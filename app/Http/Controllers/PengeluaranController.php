<?php

namespace App\Http\Controllers;

use App\Http\Requests\InsertPengeluaranRequest;
use App\Models\Data\Pengeluaran;
use App\Models\Outlet;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PengeluaranController extends Controller
{
    public function insert(InsertPengeluaranRequest $request)
    {
        $user = User::find(auth()->id());
        $permissions = $user->getPermissionsViaRoles();
        $permissionExist = collect($permissions)->first(function ($item) {
            return $item->name === 'Membuat Pengeluaran';
        });
        if ($permissionExist) {
            $outlet_id = Auth::user()->outlet_id;
            $outlet = Outlet::find($outlet_id);
            if ($outlet->saldo >= $request->nominal) {

                $merged = $request->merge([
                    'modified_by' => Auth::id(),
                    'outlet_id' => Auth::user()->outlet_id
                ])->toArray();
                Pengeluaran::create($merged);
                $outlet->update([
                    'saldo' => $outlet->saldo - $request->nominal
                ]);
                return redirect()->intended(route('menu-pengeluaran'));
            } else {
                return response()->json([
                    'status' => 400,
                    'message' => 'Saldo Kurang'
                ]);
            }
        } else {
            abort(403, 'USER DOES NOT HAVE THE RIGHT PERMISSION');
        }
    }

    public function show($id)
    {
        $user = User::find(auth()->id());
        $permissions = $user->getPermissionsViaRoles();
        $permissionExist = collect($permissions)->first(function ($item) {
            return $item->name === 'Melihat Detail Pengeluaran';
        });
        if ($permissionExist) {
            $pengeluaran = Pengeluaran::find($id);
            return [
                'status' => 200,
                $pengeluaran,
            ];
        } else {
            abort(403, 'USER DOES NOT HAVE THE RIGHT PERMISSION');
        }
    }

    public function update(InsertPengeluaranRequest $request, $id)
    {
        $user = User::find(auth()->id());
        $permissions = $user->getPermissionsViaRoles();
        $permissionExist = collect($permissions)->first(function ($item) {
            return $item->name === 'Mengubah Data Pengeluaran';
        });
        if ($permissionExist) {
            $merged = $request->merge(['modified_by' => Auth::id()])->toArray();
            Pengeluaran::find($id)->update($merged);

            return redirect()->intended(route('menu-pengeluaran'));
        } else {
            abort(403, 'USER DOES NOT HAVE THE RIGHT PERMISSION');
        }
    }

    public function delete($id)
    {
        $user = User::find(auth()->id());
        $permissions = $user->getPermissionsViaRoles();
        $permissionExist = collect($permissions)->first(function ($item) {
            return $item->name === 'Menghapus Pengeluaran';
        });
        if ($permissionExist) {
            Pengeluaran::destroy($id);

            return redirect()->intended(route('menu-pengeluaran'));
        } else {
            abort(403, 'USER DOES NOT HAVE THE RIGHT PERMISSION');
        }
    }
}
