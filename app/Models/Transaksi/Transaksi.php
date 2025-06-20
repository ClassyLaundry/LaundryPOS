<?php

namespace App\Models\Transaksi;

use App\Models\Data\Pelanggan;
use App\Models\Outlet;
use App\Models\Data\Parfum;
use App\Models\Diskon;
use App\Models\DiskonTransaksi;
use App\Models\Packing\Packing;
use App\Models\Paket\PaketCuci;
use App\Models\Pembayaran;
use App\Models\SettingUmum;
use App\Models\User;
use App\Observers\UserActionObserver;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use App\Models\Saldo;

class Transaksi extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = ['id'];

    //Function untuk menerapkan Observer ke Model ini
    public static function boot()
    {
        parent::boot();
        User::observe(new UserActionObserver);
    }

    public static function getKitirCode($id): string
    {
        $code = "";

        $transaksi = Transaksi::find($id);
        $outlet = Outlet::find($transaksi->outlet_id);
        $kode_outlet = $outlet->kode;

        $code = ($transaksi->tipe_transaksi == "bucket" ? "B / " : "P / ") . $kode_outlet . substr($transaksi->kode, 4, 4) . str_pad(substr($transaksi->kode, -2), 2, '0', STR_PAD_LEFT);
        return $code;
    }

    public static function getMemoCode($id): string
    {
        $code = "";

        $transaksi = Transaksi::find($id);
        $outlet = Outlet::find($transaksi->outlet_id);
        $kode_outlet = $outlet->kode;

        $index = str_pad(intval(substr($transaksi->kode, strlen($kode_outlet) + 6)), 2, '0', STR_PAD_LEFT);
        $code = substr($transaksi->kode, 0, strlen($kode_outlet) + 6) . $index;
        return $code;
    }

    function calcSetting($subtotal, $express = false, $setrika_only = false)
    {
        $expressMultiplier = SettingUmum::where('nama', 'multiplier express')->first();
        $expressMultiplier = (float)$expressMultiplier->value;
        $setrikaMultiplier = SettingUmum::where('nama', 'multiplier setrika only')->first();
        $setrikaMultiplier = (float)$setrikaMultiplier->value;
        $result = $subtotal;
        if ($express && $setrika_only) {
            $result = $subtotal * ($setrikaMultiplier + $expressMultiplier);
        } else if ($express) {
            $result = $subtotal * $expressMultiplier;
        } else if ($setrika_only) {
            $result = $subtotal * $setrikaMultiplier;
        }
        return ceil($result);
    }

    //Function untuk menghitung nilai transaksi
    public function recalculate()
    {
        //find relation
        $pelanggan = Pelanggan::find($this->pelanggan_id);
        $diskon_transaksi = DiskonTransaksi::where('transaksi_id', $this->id)->get();

        //declare variable
        $subtotal = 0;
        $total_diskon_promo = 0;
        $diskon_member = 0;
        $grand_total = 0;

        //find bucket dan premium
        if ($this->tipe_transaksi == "bucket") {
            $sum_bobot = ItemTransaksi::where('transaksi_id', $this->id)->sum('total_bobot');
            $item_count = ItemTransaksi::where('transaksi_id', $this->id)->count();

            //kalkulasi bobot bucket
            $paket_bucket = PaketCuci::where('nama_paket', 'BUCKET')->first();
            $jumlah_bucket = ceil($sum_bobot / $paket_bucket->jumlah_bobot);
            $total_harga_bucket = $paket_bucket->harga_paket;
            if ($sum_bobot == 0) {
                $total_harga_bucket = 0;
            } else if ($sum_bobot > 15) {
                $total_harga_bucket += ($sum_bobot - 15) * $paket_bucket->harga_per_bobot;
            }
            //simpan bucket dan bobot
            $this->total_bobot = $sum_bobot;
            $this->jumlah_bucket = $jumlah_bucket;
            $subtotal = $total_harga_bucket;
        } else {
            $sum_harga_premium = ItemTransaksi::where('transaksi_id', $this->id)->sum('total_premium');
            $subtotal = $sum_harga_premium;
        }

        //hitung subtotal
        $optionalSubtotal = $this->calcSetting($subtotal, $this->express, $this->setrika_only);
        $this->subtotal = $optionalSubtotal;
        $subtotal = $optionalSubtotal;

        //hitung diskon
        //promo kode bertumpuk
        foreach ($diskon_transaksi as $related) {
            $promo = Diskon::find($related->diskon_id);
            if ($promo->jenis_diskon == "percentage" || $promo->jenis_diskon == "refferal_percentage") {
                $temp = $subtotal * $promo->nominal;
                $temp = floor($temp / 100);
                if ($temp > $promo->maximal_diskon && $promo->maximal_diskon != 0) {
                    $temp = $promo->maximal_diskon;
                }
                $total_diskon_promo += $temp;
                $related->nominal_diskon = $temp;
                $related->save();
            } else if ($promo->jenis_diskon == "exact" || $promo->jenis_diskon == "refferal_exact") {
                $total_diskon_promo += $promo->nominal;
                $related->nominal_diskon = $promo->nominal;
                $related->save();
            } else {
                $halfCount = floor($item_count / 2);
                $items = ItemTransaksi::where('transaksi_id', $this->id)
                    ->orderBy('harga_premium', 'asc')
                    ->limit($halfCount)
                    ->get();

                $items->each(function ($item) {
                    $item->harga_premium = 0;
                    $item->save();
                });
            }
        }
        $this->total_diskon_promo = $total_diskon_promo;
        //diskon membership
        if ($this->status_diskon_member) {
            $diskon_member = floor($subtotal * 10 / 100);
        }
        $this->diskon_member = $diskon_member;
        //diskon jenis item
        $diskon_jenis_item = ItemTransaksi::where('transaksi_id', $this->id)->get()->map(function ($t) {
            return $t->diskon_jenis_item * $t->qty;
        })->sum();
        if ($this->tipe_transaksi == "bucket") {
            $diskon_jenis_item = 0;
        }
        $this->diskon_jenis_item = $diskon_jenis_item;
        //diskon pelanggan spesial
        $diskon_pelanggan_spesial = floor($subtotal * $pelanggan->diskon / 100);
        $this->diskon_pelanggan_spesial = $diskon_pelanggan_spesial;
        //calculate grand total
        $grand_total = $subtotal - ($diskon_jenis_item + $diskon_member + $total_diskon_promo + $diskon_pelanggan_spesial);
        $grand_total < 0 ? $this->grand_total = 0 : $this->grand_total = $grand_total;

        // Handle lunas status based on whether we're adding or removing items
        if ($this->lunas) {
            // If transaction was paid, check if it's still fully paid after recalculation
            if ($this->total_terbayar < $this->grand_total) {
                $this->lunas = false;
            }
        } else {
            // If transaction wasn't paid, check if it's now fully paid
            if ($this->total_terbayar >= $this->grand_total) {
                $this->lunas = true;
            }
        }

        $this->save();
        return $this;
    }

    //Function untuk melakukan Query detail Transaksi beserta table lain yang memiliki Relation
    public function scopeDetail($query)
    {
        return $query->with('item_transaksi', 'pickup_delivery', 'outlet', 'parfum', 'pelanggan', 'penerima', 'penerima', 'item_transaksi.rewash', 'item_transaksi.item_notes', 'packing');
    }

    public function item_transaksi()
    {
        return $this->hasMany(ItemTransaksi::class);
    }

    public function pickup_delivery()
    {
        return $this->hasMany(PickupDelivery::class);
    }

    public function outlet()
    {
        return $this->belongsTo(Outlet::class);
    }

    public function parfum()
    {
        return $this->belongsTo(Parfum::class);
    }

    public function pelanggan()
    {
        return $this->belongsTo(Pelanggan::class);
    }

    public function penerima()
    {
        return $this->hasOne(Penerima::class);
    }

    public function packing()
    {
        return $this->hasOne(Packing::class);
    }

    public function tukang_cuci()
    {
        return $this->belongsTo(User::class, 'pencuci', 'id');
    }

    public function tukang_setrika()
    {
        return $this->belongsTo(User::class, 'penyetrika', 'id');
    }

    public function pembayaran()
    {
        return $this->hasMany(Pembayaran::class, 'transaksi_id');
    }

    public function kasir()
    {
        return $this->belongsTo(User::class, 'operator', 'id');
    }

    public function refundItem($itemAmount, $user)
    {
        $pembayaran = Pembayaran::where('transaksi_id', $this->id)
            ->where('metode_pembayaran', 'deposit')
            ->first();

        // Jika pembayaran adalah deposit
        if ($pembayaran) {
            // Hitung jumlah refund
            $refundAmount = $this->calculateRefundAmount($itemAmount);

            // Get saldo terakhir
            $latestSaldo = Saldo::where('pelanggan_id', $this->pelanggan_id)
                ->latest('created_at')
                ->first();

            // Buat record saldo baru untuk pengembalian
            Saldo::create([
                'pelanggan_id' => $this->pelanggan_id,
                'outlet_id' => $user->outlet_id,
                'nominal' => $refundAmount,
                'jenis_input' => 'pengembalian',
                'saldo_akhir' => $latestSaldo->saldo_akhir + $refundAmount,
                'modified_by' => Auth::id()
            ]);

            // Update jumlah pembayaran
            $pembayaran->nominal -= $refundAmount;
            $pembayaran->save();

            // Update total_terbayar transaksi
            $this->total_terbayar -= $refundAmount;
            // Hanya update status lunas jika total_terbayar menjadi kurang dari grand_total
            if ($this->total_terbayar < $this->grand_total) {
                $this->lunas = false;
            }
            $this->save();

            return $refundAmount;
        }

        return 0;
    }

    private function calculateRefundAmount($itemAmount)
    {
        // Jika pelanggan adalah member
        if ($this->status_diskon_member) {
            // Hitung proporsi item dari total sebelum diskon
            $itemProportion = $itemAmount / $this->subtotal;
            // Hitung jumlah refund berdasarkan proporsi item dari total setelah diskon
            return floor($itemProportion * $this->grand_total);
        }
        // Jika pelanggan bukan member
        return $itemAmount;
    }
}
