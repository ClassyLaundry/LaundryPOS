<?php

namespace App\Models\Data;

use App\Models\Saldo;
use App\Models\Transaksi\Transaksi;
use App\Models\User;
use App\Observers\UserActionObserver;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Pelanggan extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    protected $appends = [
        'saldo_akhir',
        'tagihan',
    ];
    protected $dates = ['created_at'];

    public static function boot()
    {
        parent::boot();
        Pelanggan::observe(new UserActionObserver);
    }

    public function getTagihanAttribute()
    {
        $transaksi = Transaksi::where('pelanggan_id', $this->id)->where('lunas', false)->get();
        $grand_total = $transaksi->map(function ($item) {
            return $item->grand_total;
        })->sum();
        $total_terbayar = $transaksi->map(function ($item) {
            return $item->total_terbayar;
        })->sum();
        $tagihan = $grand_total - $total_terbayar;
        return $tagihan;
    }

    public function getSaldoAkhirAttribute()
    {
        $saldo = Saldo::where('pelanggan_id', $this->id)->latest()->first();
        if (!$saldo) {
            return 0;
        }
        return $saldo->saldo_akhir;
    }

    public function getTransaksiTerakhirAttribute()
    {
        return $this->transaksi->last();
    }

    public function getJumlahTransaksiAttribute()
    {
        return $this->transaksi->count();
    }

    public function jumlahTransaksiPiutangBetweenDate($start, $end)
    {
        return $this->transaksi()
            ->where('lunas', 0)
            ->where('status', 'confirmed')
            ->whereNot('grand_total', 0)
            ->whereDate('created_at', '>=', $start)
            ->whereDate('created_at', '<=', $end)
            ->count();
    }

    public function getPiutangAttribute()
    {
        return $this->transaksi()->where('lunas', false)->sum(DB::raw('grand_total - total_terbayar'));
    }

    public function catatan_pelanggan()
    {
        return $this->hasOne(CatatanPelanggan::class);
    }

    public function saldo()
    {
        return $this->hasMany(Saldo::class);
    }

    public function transaksi()
    {
        return $this->hasMany(Transaksi::class);
    }
}
