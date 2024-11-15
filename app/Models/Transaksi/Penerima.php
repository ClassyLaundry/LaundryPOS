<?php

namespace App\Models\Transaksi;

use App\Models\Outlet;
use App\Observers\UserActionObserver;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penerima extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    protected $appends = [
        'nama_outlet'
    ];


    public static function boot()
    {
        parent::boot();
        Penerima::observe(new UserActionObserver);
    }

    public function getNamaOutletAttribute()
    {
        return $this->outlet ? $this->outlet->nama : null;
    }

    public function outlet()
    {
        return $this->belongsTo(Outlet::class);
    }

    public function transaksi()
    {
        return $this->belongsTo(Transaksi::class);
    }
}
