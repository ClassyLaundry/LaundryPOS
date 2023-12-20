<?php

namespace App\Models;

use App\Observers\UserActionObserver;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Transaksi\Transaksi;
use App\Models\Saldo;

class Pembayaran extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    //Array untuk Menambahkan Attribute ketika memanggil Model
    protected $appends = ['transaksi', 'saldo'];

    public static function boot()
    {
        parent::boot();
        Pembayaran::observe(new UserActionObserver);
    }

    public function getTransaksiAttribute()
    {
        if (!empty($this->transaksi_id)) {
            return $this->transaksi();
        }
    }

    public function getSaldoAttribute()
    {
        if (!empty($this->saldo_id)) {
            return $this->saldo();
        }
    }

    public function saldo()
    {
        return $this->belongsTo(Saldo::class);
    }

    public function transaksi()
    {
        return $this->belongsTo(Transaksi::class);
    }
}
