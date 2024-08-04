<?php

namespace App\Http\Controllers;

use App\Http\Requests\InsertPaketCuciRequest;
use App\Models\Paket\PaketCuci;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PaketCuciController extends Controller
{
    public function insert(InsertPaketCuciRequest $request)
    {
        $user = User::find(auth()->id());
        $permissions = $user->getPermissionsViaRoles();
        $permissionExist = collect($permissions)->first(function ($item) {
            return $item->name === 'Membuat Paket Cuci';
        });
        if ($permissionExist) {
            $merged = $request->merge([
                'modified_by' => Auth::id(),
            ])->toArray();
            PaketCuci::create($merged);

            return redirect()->intended(route('menu-paket-cuci'));
        } else {
            abort(403, 'USER DOES NOT HAVE THE RIGHT PERMISSION');
        }
    }

    public function show($id)
    {
        $user = User::find(auth()->id());
        $permissions = $user->getPermissionsViaRoles();
        $permissionExist = collect($permissions)->first(function ($item) {
            return $item->name === 'Melihat Detail Paket Cuci';
        });
        if ($permissionExist) {
            $paket_cuci = PaketCuci::find($id);
            return [
                'status' => 200,
                $paket_cuci,
            ];
        } else {
            abort(403, 'USER DOES NOT HAVE THE RIGHT PERMISSION');
        }
    }

    public function update(InsertPaketCuciRequest $request, $id)
    {
        $user = User::find(auth()->id());
        $permissions = $user->getPermissionsViaRoles();
        $permissionExist = collect($permissions)->first(function ($item) {
            return $item->name === 'Mengubah Data Paket Cuci';
        });
        if ($permissionExist) {
            $merged = $request->merge([
                'modified_by' => Auth::id(),
            ])->toArray();
            PaketCuci::find($id)->update($merged);

            return redirect()->intended(route('menu-paket-cuci'));
        } else {
            abort(403, 'USER DOES NOT HAVE THE RIGHT PERMISSION');
        }
    }

    public function delete($id)
    {
        $user = User::find(auth()->id());
        $permissions = $user->getPermissionsViaRoles();
        $permissionExist = collect($permissions)->first(function ($item) {
            return $item->name === 'Menghapus Paket Cuci';
        });
        if ($permissionExist) {
            PaketCuci::destroy($id);

            return redirect()->intended(route('menu-paket-cuci'));
        } else {
            abort(403, 'USER DOES NOT HAVE THE RIGHT PERMISSION');
        }
    }
}
