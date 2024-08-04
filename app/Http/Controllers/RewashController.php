<?php

namespace App\Http\Controllers;

use App\Http\Requests\InsertJenisRewashRequest;
use App\Models\Data\JenisRewash;
use App\Models\LogTransaksi;
use App\Models\Notification;
use App\Models\Packing\Packing;
use App\Models\Transaksi\ItemTransaksi;
use App\Models\Transaksi\Rewash;
use App\Models\Transaksi\Transaksi;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RewashController extends Controller
{

    public function test()
    {
        return Rewash::with('itemTransaksi')->get();
    }

    public function insert(Request $request)
    {
        $user = User::find(auth()->id());
        $permissions = $user->getPermissionsViaRoles();
        $permissionExist = collect($permissions)->first(function ($item) {
            return $item->name === 'Menambah Data Proses Rewash';
        });
        if ($permissionExist) {
            $item_transaksi = ItemTransaksi::find($request->item_transaksi_id);
            $transaksi = Transaksi::find($item_transaksi->transaksi_id);
            $proses_asal = '';
            $submitter = -1;
            $packing = Packing::where('transaksi_id', $transaksi->id)->first();
            if ($packing) {
                $proses_asal = 'QC';
                $submitter = $packing->modified_by;
            } else {
                if ($transaksi->penyetrika) {
                    $proses_asal = "setrika";
                    $submitter = $transaksi->penyetrika;
                } else if ($transaksi->pencuci) {
                    $proses_asal = "cuci";
                    $submitter = $transaksi->pencuci;
                }
            }
            Rewash::create([
                'item_transaksi_id' => $request->item_transaksi_id,
                'jenis_rewash_id' => $request->jenis_rewash_id,
                'modified_by' => Auth::id(),
                'pencuci' => $transaksi->pencuci,
                'keterangan' => $request->keterangan,
                'proses_asal' => $proses_asal,
                'submitter' => $submitter,
            ]);
            Notification::create([
                'type' => 'Rewash',
                'message' => 'Ada Item yang perlu di rewash! \n' . $request->keterangan,
                'to_user' => $transaksi->pencuci

            ]);
            LogTransaksi::create([
                'transaksi_id' => $transaksi->id,
                'penanggung_jawab' => $submitter,
                'process' => strtoupper('add item ' . $item_transaksi->nama . ' to rewash')
            ]);
            return redirect()->back(); //->intended(route('menu-rewash'));
        } else {
            abort(403, 'USER DOES NOT HAVE THE RIGHT PERMISSION');
        }
    }

    public function updateStatus(Request $request, $id)
    {
        $user = User::find(auth()->id());
        $permissions = $user->getPermissionsViaRoles();
        $permissionExist = collect($permissions)->first(function ($item) {
            return $item->name === 'Menyatakan Selesai Proses Rewash';
        });
        if ($permissionExist) {
            $rewash = Rewash::find($id);
            $item_transaksi = ItemTransaksi::find($rewash->item_transaksi_id);
            $rewash->update([
                'status' => 1
            ]);

            LogTransaksi::create([
                'transaksi_id' => $item_transaksi->transaksi_id,
                'penanggung_jawab' => Auth::id(),
                'process' => strtoupper('update status rewash to ' . 'done')
            ]);
            return redirect()->intended(route('menu-rewash'));
        } else {
            abort(403, 'USER DOES NOT HAVE THE RIGHT PERMISSION');
        }
    }

    public function delete(Rewash $rewash)
    {
        $user = User::find(auth()->id());
        $permissions = $user->getPermissionsViaRoles();
        $permissionExist = collect($permissions)->first(function ($item) {
            return $item->name === 'Menghapus Data Proses Rewash';
        });
        if ($permissionExist) {
            $item_transaksi = ItemTransaksi::find($rewash->item_transaksi_id);
            $rewash->delete();
            LogTransaksi::create([
                'transaksi_id' => $item_transaksi->transaksi_id,
                'penanggung_jawab' => Auth::id(),
                'process' => strtoupper('delete rewash of item ' . $item_transaksi->nama)
            ]);
            return redirect()->intended(route('menu-rewash'));
        } else {
            abort(403, 'USER DOES NOT HAVE THE RIGHT PERMISSION');
        }
    }

    public function insertData(InsertJenisRewashRequest $request)
    {
        $user = User::find(auth()->id());
        $permissions = $user->getPermissionsViaRoles();
        $permissionExist = collect($permissions)->first(function ($item) {
            return $item->name === 'Menambah Rewash';
        });
        if ($permissionExist) {
            $merged = $request->merge(['modified_by' => Auth::id()])->toArray();
            JenisRewash::create($merged);

            return redirect()->intended(route('data-rewash'));
        } else {
            abort(403, 'USER DOES NOT HAVE THE RIGHT PERMISSION');
        }
    }

    public function update(InsertJenisRewashRequest $request, $id)
    {
        $merged = $request->merge(['modified_by' => Auth::id()])->toArray();
        JenisRewash::find($id)->update($merged);

        return redirect()->back();
    }

    public function deleteData($id)
    {
        $user = User::find(auth()->id());
        $permissions = $user->getPermissionsViaRoles();
        $permissionExist = collect($permissions)->first(function ($item) {
            return $item->name === 'Menghapus Rewash';
        });
        if ($permissionExist) {
            JenisRewash::destroy($id);

            return redirect()->intended(route('data-rewash'));
        } else {
            abort(403, 'USER DOES NOT HAVE THE RIGHT PERMISSION');
        }
    }
}
