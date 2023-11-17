<?php

namespace App\Http\Controllers;

use App\Models\MutasiPettyCash;
use App\Models\Outlet;
use Illuminate\Http\Request;

class MutasiPettyCashController extends Controller
{
    /**
     * Request:
     * outlet_id
     * jenis (deposit - withdrawal)
     * value
     * catatan
     */
    public function insert(Request $request)
    {
        $outlet = Outlet::find($request->outlet_id);
        if ($request->jenis == "withdrawal") {
            $updated_saldo = $outlet->saldo - $request->value;
            if ($updated_saldo < 0) {
                return response()->json([
                    "message" => "Saldo tidak mencukupi"
                ], 400);
            } else {
                MutasiPettyCash::create([
                    'outlet_id' => $request->outlet_id,
                    'jenis' => $request->jenis,
                    'value' => $request->value,
                    'saldo_sebelum' => $outlet->sald,
                    'saldo_sesudah' => $updated_saldo,
                    'catatan' => $request->catatan,
                ]);
                $outlet->saldo = $updated_saldo;
                $outlet->save();
                return response()->json([
                    'message' => "Success Withdrawal"
                ], 200);
            }
        } else {
            $updated_saldo = $outlet->saldo + $request->value;
            MutasiPettyCash::create([
                'outlet_id' => $request->outlet_id,
                'jenis' => $request->jenis,
                'value' => $request->value,
                'saldo_sebelum' => $outlet->sald,
                'saldo_sesudah' => $updated_saldo,
                'catatan' => $request->catatan,
            ]);
            $outlet->saldo = $updated_saldo;
            $outlet->save();
            return response()->json([
                'message' => "Success Deposit"
            ], 200);
        };
    }
}
