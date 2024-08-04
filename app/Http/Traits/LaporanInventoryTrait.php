<?php

namespace App\Http\Traits;

use App\Models\Inventory\Inventory;
use App\Models\Inventory\LaporanInventory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image;

trait LaporanInventoryTrait
{
    public static function stockist($inventory_id, $jumlah)
    {
        $inventory = Inventory::find($inventory_id);
        if ($inventory->stok - $jumlah > 0) {
            return [
                'status' => '400',
                'message' => 'stok kurang'
            ];
        }

        $inventory->stok = $inventory->stok + $jumlah;
        $inventory->save();

        LaporanInventory::create([
            'inventory_id' => $inventory_id,
            'jumlah' => $jumlah,
            'modified_by' => Auth::id(),
        ]);
    }
}
