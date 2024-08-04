<?php

namespace App\Http\Controllers;

use App\Http\Requests\InsertItemNoteRequest;
use App\Http\Traits\UploadTrait;
use App\Models\Transaksi\ItemNote;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ItemNoteController extends Controller
{
    use UploadTrait;

    //Menampilkan List Semua Note 1 Item Transaksi
    public function list($item_transaksi_id)
    {
        $user = User::find(auth()->id());
        $permissions = $user->getPermissionsViaRoles();
        $permissionExist = collect($permissions)->first(function ($item) {
            return $item->name === 'Melihat Detail Daftar Catatan Item';
        });
        if ($permissionExist) {
            $item_notes = ItemNote::with('modifier')->where('item_transaksi_id', $item_transaksi_id)->latest()->get();
            return view('components.tableCatatanItem', [
                'notes' => $item_notes
            ]);
        } else {
            abort(403, 'USER DOES NOT HAVE THE RIGHT PERMISSION');
        }
    }

    //Menampilkan detail 1 Note Item Transaksi
    public function show($id)
    {
        $user = User::find(auth()->id());
        $permissions = $user->getPermissionsViaRoles();
        $permissionExist = collect($permissions)->first(function ($item) {
            return $item->name === 'Melihat Detail Catatan Item';
        });
        if ($permissionExist) {
            $item_notes = ItemNote::find($id);
            $exploded = explode(';', $item_notes->image_path);
            $item_notes->image = $exploded;
            return [
                'status' => 200,
                $item_notes
            ];
        } else {
            abort(403, 'USER DOES NOT HAVE THE RIGHT PERMISSION');
        }
    }

    //Menyimpan Note ke DB
    public function insert(InsertItemNoteRequest $request)
    {
        $user = User::find(auth()->id());
        $permissions = $user->getPermissionsViaRoles();
        $permissionExist = collect($permissions)->first(function ($item) {
            return $item->name === 'Membuat Catatan Item';
        });
        if ($permissionExist) {
            $path = null;
            if (is_array($request->file('image'))) {
                $path = $this->multiPicture($request, 'item_notes');
            } else {
                $path = $this->upload($request, 'item_notes');
            }
            if ($path == null) {
                abort(500, 'INTERNAL SERVER ERROR');
            }
            $merged = $request->merge([
                'modified_by' => Auth::id(),
                'image_path' => $path,
            ])->toArray();
            $item_notes = ItemNote::create($merged);
            return [
                'status' => 200,
                $item_notes
            ];
        } else {
            abort(403, 'USER DOES NOT HAVE THE RIGHT PERMISSION');
        }
    }

    public function delete($id)
    {
        ItemNote::destroy($id);

        return [
            'status' => 200
        ];
    }
}
