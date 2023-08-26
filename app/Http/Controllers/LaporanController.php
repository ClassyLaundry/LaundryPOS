<?php

namespace App\Http\Controllers;

use App\Models\Data\Pelanggan;
use App\Models\Pembayaran;
use App\Models\Saldo;
use App\Models\Transaksi\Transaksi;
use App\Models\UserAction;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LaporanController extends Controller
{
    public function mutasiDeposit()
    {
        $pelanggan = Pelanggan::get();
        return $pelanggan;
    }
    public function mutasiDepositPelanggan(Request $request)
    {
        $pelanggan = Pelanggan::where('id', $request->pelanggan_id)->with(['saldo' => function ($query) use ($request) {
            if (isset($request->bulan)) {
                $query->whereMonth('created_at', $request->bulan);
            }
            if (isset($request->tahun)) {
                $query->whereYear('created_at', $request->tahun);
            }
        }])->get();
        return $pelanggan;
    }

    public function kasMasuk(Request $request)
    {
        $logs = UserAction::where('action_model', 'outlets')
            ->where('action', 'updated')
            ->where('action_id', $request->outlet_id)
            ->whereMonth('created_at', $request->bulan)
            ->whereYear('created_at', $request->tahun)
            ->latest()->get();

        $outlets = [];
        foreach ($logs as $log) {
            $outlets[] = $log->getModelInstanceFromAction($log, "App\\Models\\Outlet");
        }
        $sumDiff = 0;
        $currentSaldo = null;
        if (count($outlets) == 1) {
            $sumDiff = $outlets[0]->saldo;
        } else if (count($outlets) > 1) {
            foreach ($outlets as $outlet) {
                if ($currentSaldo == null) {
                    $currentSaldo = $outlet->saldo;
                } else {
                    $sumDiff = $currentSaldo - $outlet->saldo;
                    $currentSaldo = $outlet->saldo;
                }
            }
        }
        $topupThisMonth = Saldo::where('outlet_id', $request->outlet_id)
            ->whereMonth('created_at', $request->bulan)
            ->whereYear('created_at', $request->tahun)
            ->get();
        $sumTopUp = $topupThisMonth->sum('nominal');

        $pembayaranThisMonth = Pembayaran::where('outlet_id', $request->outlet_id)->whereMonth('created_at', $request->bulan)
            ->whereYear('created_at', $request->tahun)
            ->get();
        $sumPembayaran = $pembayaranThisMonth->sum('nominal');
        return [
            'penambahan_saldo' => $sumDiff,
            'total_top_up' => $sumTopUp,
            'total_pembayaran' => $sumPembayaran,
        ];
    }

    public function semuaPiutang()
    {
        $totalPiutang = Transaksi::where('lunas', false)->sum(DB::raw('grand_total - total_terbayar'));
        $pelanggan = Pelanggan::get();
        return response()->json([
            'total_piutang' => $totalPiutang,
            "pelanggan" => $pelanggan,
        ]);
    }

    public function piutangPelanggan(Request $request)
    {
        $pelanggan = Pelanggan::where('id', $request->pelanggan_id)
            ->with(['transaksi' => function ($query) {
                $query->where('lunas', false);
            }])->first();
        return $pelanggan;
    }

    public function omsetBulanan(Request $request)
    {
        $pembayaranThisMonth = Pembayaran::with('transaksi')->whereMonth('created_at', $request->bulan)
            ->whereYear('created_at', $request->tahun)
            ->get();
        $sumPembayaran = $pembayaranThisMonth->sum('nominal');
        return response()->json([
            'total_pembayaran' => $sumPembayaran,
            'pembayaran_this_month' => $pembayaranThisMonth
        ]);
    }
}
