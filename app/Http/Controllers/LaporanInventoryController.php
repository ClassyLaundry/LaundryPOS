<?php

namespace App\Http\Controllers;

use App\Http\Traits\LaporanInventoryTrait;
use App\Models\Inventory\Inventory;
use App\Models\Inventory\LaporanInventory;
use App\Models\User;
use Illuminate\Http\Request;

class LaporanInventoryController extends Controller
{
    use LaporanInventoryTrait;

    public function insert(Request $request)
    {
        $user = User::find(auth()->id());
        $permissions = $user->getPermissionsViaRoles();
        $permissionExist = collect($permissions)->first(function ($item) {
            return $item->name === 'Mengubah Data Stok Inventory';
        });
        if ($permissionExist) {
            $request->validate([
                'inventory_id' => 'required|exists:inventories,id',
                'jumlah' => 'required|integer',
            ]);

            LaporanInventoryTrait::stockist($request->inventory_id, $request->jumlah);
            return [
                'status' => '200',
                'message' => 'success'
            ];
        } else {
            abort(403, 'USER DOES NOT HAVE THE RIGHT PERMISSION');
        }
    }
}
