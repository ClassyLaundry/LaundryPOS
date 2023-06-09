<?php

namespace App\Models\Transaksi;

use App\Models\Data\CatatanPelanggan;
use App\Models\Data\Pelanggan;
use App\Models\Outlet;
use App\Models\Data\Parfum;
use App\Models\Diskon;
use App\Models\DiskonTransaksi;
use App\Models\Packing\Packing;
use App\Models\Paket\PaketCuci;
use App\Models\User;
use App\Observers\UserActionObserver;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

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

    //Function untuk menghitung nilai transaksi
    public function recalculate()
    {
        //find relation
        $pelanggan = Pelanggan::find($this->pelanggan_id);
        $diskon_transaksi = DiskonTransaksi::where('transaksi_id', $this->id)->get();

        //declare variable
        $subtotal = 0;
        $total_diskon_promo = 0;
        $diskon_member = $pelanggan->member ? 10 : 0;
        $grand_total = 0;

        //find bucket dan premium
        $sum_bobot = ItemTransaksi::where('transaksi_id', $this->id)->sum('total_bobot');
        $sum_harga_premium = ItemTransaksi::where('transaksi_id', $this->id)->sum('total_premium');
        $item_count = ItemTransaksi::where('transaksi_id', $this->id)->count();

        //kalkulasi bobot bucket
        $paket_bucket = PaketCuci::where('nama_paket', 'BUCKET')->first();
        $jumlah_bucket = ceil($sum_bobot / $paket_bucket->jumlah_bobot);
        $total_harga_bucket = $jumlah_bucket * $paket_bucket->harga_paket;
        //simpan bucket dan bobot
        $this->total_bobot = $sum_bobot;
        $this->jumlah_bucket = $jumlah_bucket;

        //hitung subtotal
        $subtotal = $sum_harga_premium + $total_harga_bucket;
        $this->subtotal = $subtotal;
        //hitung diskon
        //promo kode bertumpuk
        foreach ($diskon_transaksi as $related) {
            $promo = Diskon::find($related->diskon_id);
            if ($promo->jenis_diskon == "percentage") {
                $temp = $subtotal * $promo->nominal;
                $temp = floor($temp / 100);
                if ($temp > $promo->maximal_diskon && $promo->maximal_diskon != 0) {
                    $temp = $promo->maximal_diskon;
                }
                $total_diskon_promo += $temp;
            } else if ($promo->jenis_diskon == "exact") {
                $total_diskon_promo += $promo->nominal;
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
        $diskon_member = floor($subtotal * $diskon_member / 100);
        $this->diskon_member = $diskon_member;
        //diskon jenis item
        $diskon_jenis_item = ItemTransaksi::where('transaksi_id', $this->id)->get()->map(function ($t) {
            return $t->diskon_jenis_item * $t->qty;
        })->sum();
        if ($sum_bobot > 0) {
            $diskon_jenis_item = 0;
        }
        $this->diskon_jenis_item = $diskon_jenis_item;
        //calculate grand total
        $grand_total = $subtotal - ($diskon_jenis_item + $diskon_member + $total_diskon_promo);
        $grand_total < 0 ? $this->grand_total = 0 : $this->grand_total = $grand_total;
        $this->save();
        return $this;
    }

    //Function untuk melakukan Query detail Transaksi beserta table lain yang memiliki Relation
    public function scopeDetail($query)
    {
        return $query->with('item_transaksi', 'pickup_delivery', 'outlet', 'parfum', 'pelanggan', 'penerima', 'pelanggan.catatan_pelanggan', 'penerima', 'item_transaksi.rewash', 'packing');
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
}
