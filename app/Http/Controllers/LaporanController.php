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
    public function laporanPiutangPelanggan(Request $request)
    {
        $totalPiutang = Transaksi::where('lunas', false)->sum(DB::raw('grand_total - total_terbayar'));
        $pelanggans = Pelanggan::orderBy('nama', 'asc')->get();

        return view('pages.laporan.PiutangPelanggan', [
            'total_piutang' => $totalPiutang,
            'pelanggans' => $pelanggans,
        ]);
    }

    public function laporanPiutangPelangganDetail($id)
    {
        $transaksis = Transaksi::detail()->where('lunas', false)->where('pelanggan_id', $id)->latest()->get();
        $totalPiutang = Transaksi::where('lunas', false)->where('pelanggan_id', $id)->sum(DB::raw('grand_total - total_terbayar'));

        return view('pages.laporan.DetailPiutangPelanggan', [
            'transaksis' => $transaksis,
            'total_piutang' => $totalPiutang,
        ]);
    }

    public function laporanMutasiDeposit()
    {
        return view('pages.laporan.MutasiDeposit', [
            'pelanggans' => Pelanggan::orderBy('nama', 'asc')->get(),
        ]);
    }

    public function laporanMutasiDepositDetail(Request $request, $id)
    {
        $pelanggan = Pelanggan::find($id);

        return view('pages.laporan.DetailMutasiDeposit', [
            'pelanggan' => $pelanggan,
        ]);
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

    public function omsetBulanan(Request $request)
    {
        // $pembayaranThisMonth = Pembayaran::with('transaksi')->whereMonth('created_at', $request->bulan)
        //     ->whereYear('created_at', $request->tahun)
        //     ->get();
        $pembayaranThisMonth = Pembayaran::with('transaksi')->get();
        $sumPembayaran = $pembayaranThisMonth->sum('nominal');
        return view('pages.laporan.Omset', [
            'total_pembayaran' => $sumPembayaran,
            'pembayaran_this_month' => $pembayaranThisMonth
        ]);
    }

    public function laporanOmset()
    {
        $pembayaranThisMonth = Pembayaran::with('transaksi')->get();
        $sumPembayaran = $pembayaranThisMonth->sum('nominal');
        return view('pages.laporan.Omset', [
            'total_pembayaran' => $sumPembayaran,
            'pembayaran_this_month' => $pembayaranThisMonth
        ]);
    }
}
