<?php

namespace App\Models\Data;

use App\Models\Transaksi\Transaksi;
use App\Models\User;
use App\Observers\UserActionObserver;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Parfum extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public static function boot()
    {
        parent::boot();
        Parfum::observe(new UserActionObserver);
    }

    public function transaksi()
    {
        return $this->belongsTo(Transaksi::class);
    }
}
