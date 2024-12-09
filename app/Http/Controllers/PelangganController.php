<?php

namespace App\Http\Controllers;

use App\Http\Requests\InsertPelangganRequest;
use App\Models\Data\CatatanPelanggan;
use App\Models\Data\Pelanggan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PelangganController extends Controller
{
    public function insert(Request $request)
    {
        $user = User::find(auth()->id());
        $permissions = $user->getPermissionsViaRoles();
        $permissionExist = collect($permissions)->first(function ($item) {
            return $item->name === 'Membuat Pelanggan';
        });
        if ($permissionExist) {
            $data = $request->all();
            $data['modified_by'] = auth()->check() ? auth()->id() : null;

            Pelanggan::create($data);

            return redirect()->intended(route('menu-pelanggan'));
        } else {
            abort(403, 'USER DOES NOT HAVE THE RIGHT PERMISSION');
        }
    }

    public function show($id)
    {
        $user = User::find(auth()->id());
        $permissions = $user->getPermissionsViaRoles();
        $permissionExist = collect($permissions)->first(function ($item) {
            return $item->name === 'Membuka Halaman Detail Pelanggan';
        });
        if ($permissionExist) {
            $pelanggan = Pelanggan::find($id);
            return [
                'status' => 200,
                $pelanggan,
            ];
        } else {
            abort(403, 'USER DOES NOT HAVE THE RIGHT PERMISSION');
        }
    }

    public function update(Request $request, $id)
    {
        $user = User::find(auth()->id());
        $permissions = $user->getPermissionsViaRoles();
        $permissionExist = collect($permissions)->first(function ($item) {
            return $item->name === 'Mengubah Data Pelanggan';
        });
        if ($permissionExist) {
            $merged = $request->merge(['modified_by' => Auth::id()])->toArray();
            Pelanggan::find($id)->update($merged);

            return redirect()->back();
        } else {
            abort(403, 'USER DOES NOT HAVE THE RIGHT PERMISSION');
        }
    }

    public function delete($id)
    {
        $user = User::find(auth()->id());
        $permissions = $user->getPermissionsViaRoles();
        $permissionExist = collect($permissions)->first(function ($item) {
            return $item->name === 'Menghapus Pelanggan';
        });
        if ($permissionExist) {
            Pelanggan::destroy($id);
            return redirect()->intended(route('menu-pelanggan'));
        } else {
            abort(403, 'USER DOES NOT HAVE THE RIGHT PERMISSION');
        }
    }

    public function detailPelanggan($id_pelanggan)
    {
        $user = User::find(auth()->id());
        $permissions = $user->getPermissionsViaRoles();
        $permissionExist = collect($permissions)->first(function ($item) {
            return $item->name === 'Membuka Halaman Detail Pelanggan';
        });
        if ($permissionExist) {
            return view(
                'pages.data.DetailPelanggan',
                [
                    'pelanggan' => Pelanggan::where('id', $id_pelanggan)->first(),
                ]
            );
        } else {
            abort(403, 'USER DOES NOT HAVE THE RIGHT PERMISSION');
        }
    }

    public function search(Request $request)
    {
        $conditions = [];
        if ($request->filter === 'nama') {
            $conditions[] = function ($q) use ($request) {
                return $q->where('nama', 'like', '%' . $request->key . '%');
            };
        } else if ($request->filter === 'telephone') {
            $conditions[] = function ($q) use ($request) {
                return $q->where('telephone', 'like', '%' . $request->key . '%');
            };
        } else if ($request->filter === 'alamat') {
            $conditions[] = function ($q) use ($request) {
                return $q->where('alamat', 'like', '%' . $request->key . '%');
            };
        } else if ($request->filter === 'email') {
            $conditions[] = function ($q) use ($request) {
                return $q->where('email', 'like', '%' . $request->key . '%');
            };
        }

        $pelanggan = Pelanggan::when($request->filled('key'), function ($q) use ($conditions) {
            return tap($q, function ($q) use ($conditions) {
                foreach ($conditions as $condition) {
                    $q->when(true, $condition);
                }
            });
        })->orderBy('created_at', 'asc')->paginate($request->paginate);

        return view('components.tablePelanggan', [
            'pelanggans' => $pelanggan,
        ]);
    }

    public function search2(Request $request)
    {
        $pelanggan = Pelanggan::when($request->filled('key'), function ($query) use ($request) {
            $query->where('nama', 'like', '%' . $request->key . '%')
                ->orWhere('alamat', 'like', '%' . $request->key . '%')
                ->orWhere('telephone', 'like', '%' . $request->key . '%');
        })->orderBy('created_at', 'asc')->paginate($request->paginate);

        return view('components.tablePelanggan', [
            'pelanggans' => $pelanggan,
        ]);
    }
}
