<?php

namespace App\Http\Controllers;

use App\Models\Saldo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SaldoController extends Controller
{
    public function insert(Request $request)
    {
        $saldo_akhir = Saldo::where('pelanggan_id', $request->pelanggan_id)->latest()->first();
        if (empty($saldo_akhir)) {
            $saldo_akhir = 0;
        } else {
            $saldo_akhir = $saldo_akhir->saldo_akhir;
        }

        if ($request->jenis_input == "deposit") {
            $saldo_akhir += $request->nominal;
        } else {
            $saldo_akhir -= $request->nominal;
        }

        Saldo::create([
            'pelanggan_id' => $request->pelanggan_id,
            'paket_deposit_id' => $request->paket_deposit_id,
            'nominal' => $request->nominal,
            'jenis_input' => $request->jenis_input,
            'saldo_akhir' => $saldo_akhir,
            'modified_by' => Auth::id()
        ]);

        return null;
    }

    //Mendapatkan saldo pelanggan (kebutuhan AJAX)
    public function getSaldo($pelanggan_id)
    {
        $saldo = Saldo::where('pelanggan_id', $pelanggan_id)->latest()->first();
        if (empty($saldo)) {
            $saldo = 0;
        } else {
            $saldo = $saldo->saldo_akhir;
        }

        return [
            'status' => 200,
            'saldo' => $saldo
        ];
    }

    public function historyPelanggan($id_pelanggan)
    {
        return view('components.tableHistorySaldo',  [
            'status' => 200,
            'saldos' => Saldo::where('pelanggan_id', $id_pelanggan)->latest()->paginate(5),
        ]);
    }
}
