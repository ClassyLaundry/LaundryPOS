<?php

namespace App\Models;

use App\Models\Transaksi\Transaksi;
use App\Models\User;
use App\Models\Saldo;
use App\Observers\UserActionObserver;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Outlet extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public static function boot()
    {
        parent::boot();
        Outlet::observe(new UserActionObserver);
    }

    public function transaksi()
    {
        return $this->hasMany(Transaksi::class);
    }

    public function saldo()
    {
        return $this->hasMany(Saldo::class);
    }
}
