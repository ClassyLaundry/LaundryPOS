<?php

namespace App\Models\Packing;

use App\Models\Transaksi\PickupDelivery;
use App\Models\Transaksi\Transaksi;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Packing extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    protected $appends = [
        'nama_qc',
    ];

    public function getNamaQcAttribute()
    {
        $qc = User::find($this->modified_by);
        return $qc->username;
    }
    public function transaksi()
    {
        return $this->belongsTo(Transaksi::class);
    }

    public function packing_inventories()
    {
        return $this->hasMany(PackingInventory::class);
    }

    public function modified_by()
    {
        return $this->belongsTo(User::class);
    }

    public function pickup_delivery()
    {
        return $this->belongsTo(PickupDelivery::class);
    }
}
