<?php

namespace App\Http\Controllers;

use App\Models\Diskon;
use App\Models\Transaksi\Transaksi;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Date;

class DiskonController extends Controller
{
    public function insert(Request $request)
    {
        $user = User::find(auth()->id());
        $permissions = $user->getPermissionsViaRoles();
        $permissionExist = collect($permissions)->first(function ($item) {
            return $item->name === 'Menambah Data Diskon';
        });
        if ($permissionExist) {
            $jenis_diskon = $request->referral != null ? 'refferal_' . $request->jenis_diskon : $request->jenis_diskon;
            Diskon::create([
                'code' => $request->code,
                'description' => $request->description,
                'jenis_diskon' => $jenis_diskon,
                'nominal' => $request->nominal,
                'maximal_diskon' => ($request->jenis_diskon == 'percentage') ? $request->maximal_diskon : 0,
                'refferal_pelanggan' => $request->referral,
                'expired' => Date::createFromFormat('Y-m-d', $request->expired_date),
            ]);
            return redirect()->intended(route('data-diskon'));
        } else {
            abort(403, 'USER DOES NOT HAVE THE RIGHT PERMISSION');
        }
    }

    public function update(Request $request, Diskon $diskon)
    {
        $user = User::find(auth()->id());
        $permissions = $user->getPermissionsViaRoles();
        $permissionExist = collect($permissions)->first(function ($item) {
            return $item->name === 'Mengubah Data Diskon';
        });
        if ($permissionExist) {
            $jenis_diskon = $request->referral != null ? 'refferal_' . $request->jenis_diskon : $request->jenis_diskon;
            $diskon->update([
                'code' => $request->code,
                'description' => $request->description,
                'jenis_diskon' => $jenis_diskon,
                'nominal' => $request->nominal,
                'maximal_diskon' => ($request->jenis_diskon == 'percentage') ? $request->maximal_diskon : 0,
                'refferal_pelanggan' => $request->referral,
                'expired' => Date::createFromFormat('Y-m-d', $request->expired_date),
            ]);
            return redirect()->intended(route('data-diskon'));
        } else {
            abort(403, 'USER DOES NOT HAVE THE RIGHT PERMISSION');
        }
    }

    // public function addCodeToTransaksi(Transaksi $transaksi, $promo)
    // {
    //     $diskon = Diskon::where('code', $promo)->first();
    //     if ($promo) {
    //         $transaksi->update([
    //             'promo_code' => $diskon->id,
    //             'diskon' => $diskon->nominal,
    //         ]);
    //         $transaksi->recalculate();
    //     } else {
    //         $transaksi->update([
    //             'promo_code' => null,
    //             'diskon' => 0
    //         ]);
    //     }
    // }

    public function delete($id)
    {
        $user = User::find(auth()->id());
        $permissions = $user->getPermissionsViaRoles();
        $permissionExist = collect($permissions)->first(function ($item) {
            return $item->name === 'Menghapus Data Diskon';
        });
        if ($permissionExist) {
            Diskon::destroy($id);

            return redirect()->intended(route('data-diskon'));
        } else {
            abort(403, 'USER DOES NOT HAVE THE RIGHT PERMISSION');
        }
    }
}
