<?php

namespace App\Http\Controllers;

use App\Http\Requests\InsertItemTransaksiRequest;
use App\Models\Data\JenisItem;
use App\Models\Transaksi\ItemTransaksi;
use App\Models\Transaksi\Transaksi;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ItemTransaksiController extends Controller
{
    //Menambahkan Item ke Transaksi
    public function addItemToTransaksi(Request $request)
    {
        $user = User::find(auth()->id());
        $permissions = $user->getPermissionsViaRoles();
        $permissionExist = collect($permissions)->first(function ($item) {
            return $item->name === 'Menambahkan Item Ke Transaksi';
        });
        if ($permissionExist) {
            $request['modified_by'] = Auth::id();
            $role = User::getRole(Auth::id());
            $jenis_item = JenisItem::find($request['jenis_item_id']);
            $request['bobot_bucket'] = $jenis_item->bobot_bucket;
            $request['harga_premium'] = $jenis_item->harga_premium;
            $request['diskon_jenis_item'] = $jenis_item->diskon_jenis_item;
            $request['status_proses'] = $role;
            $request['total_bobot'] = $jenis_item->bobot_bucket;
            $finder = ItemTransaksi::where('transaksi_id', $request->transaksi_id)->where('jenis_item_id', $request->jenis_item_id)->first();
            $trans = Transaksi::find($request->transaksi_id);
            if ($finder) {
                $finder->qty = $finder->qty + 1;
                $finder->diskon_jenis_item = $jenis_item->diskon_jenis_item;
                if ($trans->tipe_transaksi == 'bucket') {
                    $finder->bobot_bucket = $jenis_item->bobot_bucket;
                    $finder->total_bobot = $finder->qty * $finder->bobot_bucket;
                } else {
                    $finder->harga_premium = $jenis_item->harga_premium;
                    $finder->total_premium = $finder->qty * $finder->harga_premium;
                }
                $finder->save();
            } else {
                $item_transaksi = ItemTransaksi::create($request->toArray());
                $item_transaksi->qty = $item_transaksi->qty + 1;
                if ($trans->tipe_transaksi == 'bucket') {
                    $item_transaksi->total_bobot = $item_transaksi->qty * $item_transaksi->bobot_bucket;
                    $item_transaksi->total_premium = 0;
                } else {
                    $item_transaksi->total_bobot = 0;
                    $item_transaksi->total_premium = $item_transaksi->qty * $item_transaksi->harga_premium;
                }
                $item_transaksi->save();
            }

            $transaksi = Transaksi::detail()->find($request['transaksi_id'])->recalculate();
            $transaksi->modified_by = Auth::id();
            $transaksi->save();
            return  [
                'status' => 200,
                $transaksi,
            ];
        } else {
            abort(403, 'USER DOES NOT HAVE THE RIGHT PERMISSION');
        }
    }

    public function getItemAndStatus($transaksi_id)
    {
        $itemTransaksis = ItemTransaksi::with(['rewash' => function ($query) {
            $query->select('id', 'item_transaksi_id', 'status');
        }])->where('transaksi_id', $transaksi_id)->get();

        $itemTransaksis->each(function ($itemTransaksi) {
            $itemTransaksi->rewash_status = $itemTransaksi->rewash ? $itemTransaksi->rewash->status : false;
        });
        return [
            'status' => 200,
            $itemTransaksis
        ];
    }

    public function updateQty(Request $request, $id)
    {
        $item_transaksi = ItemTransaksi::find($id);
        $trans = Transaksi::find($item_transaksi->transaksi_id);
        $tipe_transaksi = $trans->tipe_transaksi;

        $item_transaksi->qty = $request->qty;
        if ($tipe_transaksi == "bucket") {
            $item_transaksi->total_bobot = $request->qty * $item_transaksi->bobot_bucket;
        } else if ($tipe_transaksi == "premium"){
            $item_transaksi->total_premium = $request->qty * $item_transaksi->harga_premium;
        }
        $item_transaksi->save();

        $transaksi = Transaksi::detail()->find($item_transaksi->transaksi_id)->recalculate();
        $transaksi->modified_by = Auth::id();
        $transaksi->save();
        return [
            'status' => 200,
            'qty' => $request->qty
        ];
    }

    //Menyimpan Item Transaksi ke DB
    public function insert(InsertItemTransaksiRequest $request)
    {
        $user = User::find(auth()->id());
        $permissions = $user->getPermissionsViaRoles();
        $permissionExist = collect($permissions)->first(function ($item) {
            return $item->name === 'Membuat Item Transaksi';
        });
        if ($permissionExist) {
            $merged = $request->merge(['modified_by' => Auth::id()])->toArray();
            ItemTransaksi::create($merged);

            return redirect()->intended(route(''));
        } else {
            abort(403, 'USER DOES NOT HAVE THE RIGHT PERMISSION');
        }
    }

    //Menampilkan Detail Item transaksi
    public function show($id)
    {
        $user = User::find(auth()->id());
        $permissions = $user->getPermissionsViaRoles();
        $permissionExist = collect($permissions)->first(function ($item) {
            return $item->name === 'Melihat Detail Item Transaksi';
        });
        if ($permissionExist) {
            $item_transaksi = ItemTransaksi::find($id);
            return [
                'status' => 200,
                $item_transaksi,
            ];
        } else {
            abort(403, 'USER DOES NOT HAVE THE RIGHT PERMISSION');
        }
    }

    //Mengupdate Detail Item Transaksi
    public function update(InsertItemTransaksiRequest $request, $id)
    {
        $user = User::find(auth()->id());
        $permissions = $user->getPermissionsViaRoles();
        $permissionExist = collect($permissions)->first(function ($item) {
            return $item->name === 'Mengubah Data Item Transaksi';
        });
        if ($permissionExist) {
            $merged = $request->merge(['modified_by' => Auth::id()])->toArray();
            ItemTransaksi::find($id)->update($merged);

            return redirect()->intended(route(''));
        } else {
            abort(403, 'USER DOES NOT HAVE THE RIGHT PERMISSION');
        }
    }

    //Menghapus Item Transaksi
    public function delete(ItemTransaksi $id)
    {
        $user = User::find(auth()->id());
        $permissions = $user->getPermissionsViaRoles();
        $permissionExist = collect($permissions)->first(function ($item) {
            return $item->name === 'Menghapus Item Transaksi';
        });
        if ($permissionExist) {
            $id_transaksi = $id->transaksi_id;
            $id->delete();

            $transaksi = Transaksi::find($id_transaksi)->recalculate();
            return  [
                'status' => 200,
                $transaksi,
            ];
        } else {
            abort(403, 'USER DOES NOT HAVE THE RIGHT PERMISSION');
        }
    }
}
