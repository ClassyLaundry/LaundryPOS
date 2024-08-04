<?php

namespace App\Http\Controllers;

use App\Http\Requests\InsertJenisItemRequest;
use App\Models\Data\JenisItem;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class JenisItemController extends Controller
{
    public function find(Request $request)
    {
        $tipe = 'status_' . $request->tipe;
        $jenis_item = JenisItem::where($tipe, 1)
            ->where(function ($query) use ($request) {
                $query->where('nama', 'like', "%{$request->key}%")
                    ->orWhereHas('kategori', function ($q) use ($request) {
                        $q->where('nama', 'like', "%{$request->key}%");
                    });
            })
            ->take(5)->get();
        return [
            'status' => 200,
            $jenis_item
        ];
    }

    public function componentFind(Request $request)
    {
        return view('components.tableJenisItem', [
            'items' => JenisItem::where(function ($query) use ($request) {
                $query->where('nama', 'like', "%{$request->key}%")
                    ->orWhereHas('kategori', function ($q) use ($request) {
                        $q->where('nama', 'like', "%{$request->key}%");
                    });
            })->orderBy("nama", "asc")->paginate($request->paginate),
        ]);
    }

    public function insert(InsertJenisItemRequest $request)
    {
        $user = User::find(auth()->id());
        $permissions = $user->getPermissionsViaRoles();
        $permissionExist = collect($permissions)->first(function ($item) {
            return $item->name === 'Membuat Jenis Item';
        });
        if ($permissionExist) {
            $merged = $request->merge(['modified_by' => Auth::id()])->toArray();
            JenisItem::create($merged);

            return redirect()->intended(route('menu-jenis-item'));
        } else {
            abort(403, 'USER DOES NOT HAVE THE RIGHT PERMISSION');
        }
    }

    public function show($id)
    {
        $user = User::find(auth()->id());
        $permissions = $user->getPermissionsViaRoles();
        $permissionExist = collect($permissions)->first(function ($item) {
            return $item->name === 'Melihat Detail Jenis Item';
        });
        if ($permissionExist) {
            $jenis_item = JenisItem::find($id);
            return [
                'status' => 200,
                $jenis_item,
            ];
        } else {
            abort(403, 'USER DOES NOT HAVE THE RIGHT PERMISSION');
        }
    }

    public function update(InsertJenisItemRequest $request, $id)
    {
        $user = User::find(auth()->id());
        $permissions = $user->getPermissionsViaRoles();
        $permissionExist = collect($permissions)->first(function ($item) {
            return $item->name === 'Mengubah Data Jenis Item';
        });
        if ($permissionExist) {
            $merged = $request->merge(['modified_by' => Auth::id()])->toArray();
            JenisItem::find($id)->update($merged);

            return redirect()->intended(route('menu-jenis-item'));
        } else {
            abort(403, 'USER DOES NOT HAVE THE RIGHT PERMISSION');
        }
    }

    public function delete($id)
    {
        $user = User::find(auth()->id());
        $permissions = $user->getPermissionsViaRoles();
        $permissionExist = collect($permissions)->first(function ($item) {
            return $item->name === 'Menghapus Jenis Item';
        });
        if ($permissionExist) {
            JenisItem::destroy($id);

            return redirect()->intended(route('menu-jenis-item'));
        } else {
            abort(403, 'USER DOES NOT HAVE THE RIGHT PERMISSION');
        }
    }
}
