<?php

namespace App\Models\Transaksi;

use App\Models\Data\JenisRewash;
use App\Models\User;
use App\Models\Transaksi\ItemTransaksi;
use App\Models\Transaksi\Transaksi;
use App\Observers\UserActionObserver;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rewash extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    protected $appends = ['jenis_rewash'];

    public static function boot()
    {
        parent::boot();
        Rewash::observe(new UserActionObserver);
    }

    public function getJenisRewashAttribute()
    {
        $jenis_rewash = JenisRewash::find($this->jenis_rewash_id);
        return $jenis_rewash->keterangan;
    }

    public function jenis_rewash()
    {
        return $this->belongsTo(JenisRewash::class, 'jenis_rewash_id', 'id');
    }

    public function item_transaksi()
    {
        return $this->belongsTo(ItemTransaksi::class, 'item_transaksi_id', 'id');
    }

    public function tukang_cuci()
    {
        return $this->belongsTo(User::class, 'pencuci', 'id');
    }
}
