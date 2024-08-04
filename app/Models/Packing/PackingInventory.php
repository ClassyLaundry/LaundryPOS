<?php

namespace App\Models\Packing;

use App\Models\Inventory\Inventory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PackingInventory extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function inventory()
    {
        return $this->belongsTo(Inventory::class);
    }

    public function packing()
    {
        return $this->belongsTo(Packing::class);
    }
}
