<?php

namespace App\Http\Controllers;

use App\Http\Requests\InsertPenerimaRequest;
use App\Http\Traits\UploadTrait;
use App\Models\Transaksi\Penerima;
use App\Models\Transaksi\PickupDelivery;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PenerimaController extends Controller
{
    use UploadTrait;

    public function insert(InsertPenerimaRequest $request)
    {
        $user = User::find(auth()->id());
        $permissions = $user->getPermissionsViaRoles();
        $permissionExist = collect($permissions)->first(function ($item) {
            return $item->name === 'Menambahkan Penerima Ke Transaksi';
        });
        if ($permissionExist) {
            $transaksi_id = $request->only('transaksi_id');
            $penerima = Penerima::where('transaksi_id', $transaksi_id)->first();
            if (empty($penerima)) {
                $delivery = PickupDelivery::where('transaksi_id', $transaksi_id)->where('action', 'delivery')->first();

                //Melakukan Pengecheckan apakah sudah dikirim tetapi request berisi ambil di outlet
                if (!empty($delivery) && $request->ambil_di_outlet == 1) {
                    return [
                        'status' => 400,
                        'message' => 'Sudah di kirim.'
                    ];
                }
                $path = $this->upload($request, 'penerima');
                $merged = $request->merge([
                    'modified_by' => Auth::id(),
                    'foto_penerima' => $path,
                ])->toArray();
                $penerima = Penerima::create($merged);
                return [
                    'status' => 200,
                    $penerima
                ];
            }
            return [
                'status' => 400,
                $penerima
            ];
        } else {
            abort(403, 'USER DOES NOT HAVE THE RIGHT PERMISSION');
        }
    }
}
