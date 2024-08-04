<?php

namespace App\Models;

use App\Models\Data\Pelanggan;
use App\Models\Outlet;
use App\Models\Paket\PaketDeposit;
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

    public function paket_deposit()
    {
        return $this->belongsTo(PaketDeposit::class);
    }

    public function kasir()
    {
        return $this->belongsTo(User::class, 'operator', 'id');
    }
}
