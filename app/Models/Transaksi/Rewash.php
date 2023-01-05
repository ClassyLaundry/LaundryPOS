<?php

namespace App\Models\Transaksi;

use App\Models\Data\JenisRewash;
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

    public function itemTransaksi()
    {
        return $this->belongsTo(ItemTransaksi::class);
    }
}
