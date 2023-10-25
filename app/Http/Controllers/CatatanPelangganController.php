<?php

namespace App\Http\Controllers;

use App\Models\Data\CatatanPelanggan;
use App\Models\User;
use Illuminate\Http\Request;

class CatatanPelangganController extends Controller
{
    public function insert(Request $request)
    {
        $user = User::find(auth()->id());
        $permissions = $user->getPermissionsViaRoles();
        $permissionExist = collect($permissions)->first(function ($item) {
            return $item->name === 'Menambah Catatan Pelanggan';
        });
        if ($permissionExist) {
            CatatanPelanggan::create([
                'pelanggan_id' => $request->catatan_pelanggan,
                'catatan_cuci' => $request->catatan_cuci,
                'catatan_khusus' => $request->catatan_khusus
            ]);
            return response()->json([
                "message" => "Success"
            ], 201);
        } else {
            abort(403, 'USER DOES NOT HAVE THE RIGHT PERMISSION');
        }
    }

    public function getByPelangganID($pelanggan_id)
    {
        $user = User::find(auth()->id());
        $permissions = $user->getPermissionsViaRoles();
        $permissionExist = collect($permissions)->first(function ($item) {
            return $item->name === 'Melihat Catatan Pelanggan';
        });
        if ($permissionExist) {
            $catatan_pelanggan = CatatanPelanggan::where('pelanggan_id', $pelanggan_id)->first();
            return response()->json([
                "message" => "Catatan Pelanggan sukses diinput.",
                "catatan_pelanggan" => $catatan_pelanggan
            ], 200);
        } else {
            abort(403, 'USER DOES NOT HAVE THE RIGHT PERMISSION');
        }
    }

    public function updateCatatanPelanggan(Request $request)
    {
        $user = User::find(auth()->id());
        $permissions = $user->getPermissionsViaRoles();
        $permissionExist = collect($permissions)->first(function ($item) {
            return $item->name === 'Mengupdate Catatan Pelanggan';
        });
        if ($permissionExist) {
            $catatan_pelanggan = CatatanPelanggan::where('pelanggan_id', $request->pelanggan_id)->first();
            $catatan_pelanggan->catatan_cuci = $request->catatan_cuci;
            $catatan_pelanggan->catatan_khusus = $request->catatan_khusus;
            $catatan_pelanggan->save();
            return response()->json([
                "message" => "Catatan Pelanggan sukses diupdate."
            ], 200);
        } else {
            abort(403, 'USER DOES NOT HAVE THE RIGHT PERMISSION');
        }
    }
}
