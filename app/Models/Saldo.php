<?php

namespace App\Models;

use App\Models\Data\Pelanggan;
use App\Models\Outlet;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Saldo extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function pelanggan()
    {
        return $this->belongsTo(Pelanggan::class);
    }

    public function outlet()
    {
        return $this->belongsTo(Outlet::class);
    }
}
