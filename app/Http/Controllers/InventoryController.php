<?php

namespace App\Http\Controllers;

use App\Models\Inventory\Inventory;
use App\Models\User;
use Illuminate\Http\Request;
use App\Exports\InventoryExport;
use Maatwebsite\Excel\Facades\Excel;

class InventoryController extends Controller
{
    public function insert(Request $request)
    {
        $user = User::find(auth()->id());
        $permissions = $user->getPermissionsViaRoles();
        $permissionExist = collect($permissions)->first(function ($item) {
            return $item->name === 'Menambah Inventory';
        });
        if ($permissionExist) {
            $request->validate([
                'nama' => 'required|string',
                'stok' => 'numeric|min:0',
                'kategori' => 'required|string',
            ]);

            Inventory::create([
                'nama' => $request->nama,
                'deskripsi' => $request->deskripsi,
                'stok' => $request->stok,
                'kategori' => $request->kategori,
            ]);

            return redirect()->intended(route('menu-inventory'));
        } else {
            abort(403, 'USER DOES NOT HAVE THE RIGHT PERMISSION');
        }
    }

    public function update(Request $request, Inventory $inventory)
    {
        $user = User::find(auth()->id());
        $permissions = $user->getPermissionsViaRoles();
        $permissionExist = collect($permissions)->first(function ($item) {
            return $item->name === 'Mengubah Data Inventory';
        });
        if ($permissionExist) {
            $request->validate([
                'nama' => 'required|string',
                'stok' => 'numeric|min:0',
                'kategori' => 'required|string',
            ]);

            $inventory->update([
                'nama' => $request->nama,
                'deskripsi' => $request->deskripsi,
                'kategori' => $request->kategori,
                'stok' => $request->stok
            ]);

            return redirect()->intended(route('menu-inventory'));
        } else {
            abort(403, 'USER DOES NOT HAVE THE RIGHT PERMISSION');
        }
    }

    public function delete(Inventory $inventory)
    {
        $user = User::find(auth()->id());
        $permissions = $user->getPermissionsViaRoles();
        $permissionExist = collect($permissions)->first(function ($item) {
            return $item->name === 'Menghapus Inventory';
        });
        if ($permissionExist) {
            $inventory->delete();

            return [
                'status' => 200,
                'message' => 'Success'
            ];
        } else {
            abort(403, 'USER DOES NOT HAVE THE RIGHT PERMISSION');
        }
    }

    public function export(Request $request)
    {
        $investories = Inventory::select('nama', 'deskripsi', 'kategori', 'stok')->orderBy("nama", "asc")->get();
        $filename = 'laporan_inventory_' . date('Y-m-d_H-i-s') . '.xlsx';

        return Excel::download(new InventoryExport($investories->toArray()), $filename);
    }
}
