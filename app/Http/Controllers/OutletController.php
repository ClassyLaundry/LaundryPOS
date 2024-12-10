<?php

namespace App\Http\Controllers;

use App\Http\Requests\InsertOutletRequest;
use App\Models\Outlet;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OutletController extends Controller
{
    public function insert(InsertOutletRequest $request)
    {
        $user = User::find(auth()->id());
        $permissions = $user->getPermissionsViaRoles();
        $permissionExist = collect($permissions)->first(function ($item) {
            return $item->name === 'Membuat Outlet';
        });
        if ($permissionExist) {
            $merged = $request->merge(['modified_by' => Auth::id()])->toArray();
            Outlet::create($merged);

            return redirect()->intended(route('menu-outlet'));
        } else {
            abort(403, 'USER DOES NOT HAVE THE RIGHT PERMISSION');
        }
    }

    public function show($id)
    {
        $user = User::find(auth()->id());
        $permissions = $user->getPermissionsViaRoles();
        $permissionExist = collect($permissions)->first(function ($item) {
            return $item->name === 'Melihat Detail Outlet';
        });
        if ($permissionExist) {
            $outlet = Outlet::find($id);
            return [
                'status' => 200,
                $outlet,
            ];
        } else {
            abort(403, 'USER DOES NOT HAVE THE RIGHT PERMISSION');
        }
    }

    public function update(InsertOutletRequest $request, $id)
    {
        $user = User::find(auth()->id());
        $permissions = $user->getPermissionsViaRoles();
        $permissionExist = collect($permissions)->first(function ($item) {
            return $item->name === 'Mengubah Data Outlet';
        });
        if ($permissionExist) {
            $merged = $request->merge(['modified_by' => Auth::id()])->toArray();
            Outlet::find($id)->update($merged);

            return redirect()->intended(route('menu-outlet'));
        } else {
            abort(403, 'USER DOES NOT HAVE THE RIGHT PERMISSION');
        }
    }

    public function delete($id)
    {
        $user = User::find(auth()->id());
        $permissions = $user->getPermissionsViaRoles();
        $permissionExist = collect($permissions)->first(function ($item) {
            return $item->name === 'Menghapus Outlet';
        });
        if ($permissionExist) {
            Outlet::destroy($id);

            return redirect()->intended(route('menu-outlet'));
        } else {
            abort(403, 'USER DOES NOT HAVE THE RIGHT PERMISSION');
        }
    }

    public function updateSaldo(Request $request, Outlet $outlet)
    {
        $user = User::find(auth()->id());
        $permissions = $user->getPermissionsViaRoles();
        $permissionExist = collect($permissions)->first(function ($item) {
            return $item->name === 'Menambah Saldo Outlet';
        });
        if ($permissionExist) {
            $outlet->update([
                'saldo' => $outlet->saldo + $request->nominal
            ]);
            return redirect()->intended(route('menu-outlet'));
        } else {
            abort(403, 'USER DOES NOT HAVE THE RIGHT PERMISSION');
        }
    }

    public function component()
    {
        return view('components.selectOutlet', [
            'outlets' => Outlet::where('status', 1)->get(),
        ]);
    }
}
