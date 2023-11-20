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

use function PHPSTORM_META\type;

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

    public function laporanOmsetTahunan(Request $request)
    {
        $dataLaporan = DB::table('saldos')
            ->join('pembayarans', function ($join) {
                $join->on(DB::raw('YEAR(saldos.created_at)'), '=', DB::raw('YEAR(pembayarans.created_at)'));
            })
            ->select(
                DB::raw('YEAR(saldos.created_at) as tahun'),
                DB::raw('(SELECT SUM(nominal) FROM saldos WHERE jenis_input = "deposit") as deposit'),
                DB::raw('(SELECT SUM(nominal) FROM pembayarans WHERE metode_pembayaran != "deposit") as pembayaran'),
                DB::raw('(SELECT SUM(nominal) FROM pembayarans WHERE metode_pembayaran = "tunai") as tunai'),
                DB::raw('(SELECT SUM(nominal) FROM pembayarans WHERE metode_pembayaran = "qris") as qris'),
                DB::raw('(SELECT SUM(nominal) FROM pembayarans WHERE metode_pembayaran = "debit") as debit'),
                DB::raw('(SELECT SUM(nominal) FROM pembayarans WHERE metode_pembayaran = "transfer") as transfer'),
            )
            ->groupBy('tahun')
            ->get();

        return view('pages.laporan.Omset', [
            'laporan' => $dataLaporan,
        ]);
    }

    public function laporanOmsetBulanan(Request $request)
    {
        $dataLaporan = [];
        for ($i=1; $i <= 12; $i++) {
            $temp = DB::table('saldos')
            ->join('pembayarans', function ($join) {
                $join->on(DB::raw('MONTH(saldos.created_at)'), '=', DB::raw('MONTH(pembayarans.created_at)'));
            })
            ->whereYear('saldos.created_at', '=', $request->year)
            ->whereMonth('saldos.created_at', '=', $i)
            ->select(
                DB::raw('DATE_FORMAT(saldos.created_at, "%M") bulan'),
                DB::raw('(SELECT SUM(nominal) FROM saldos WHERE jenis_input = "deposit") as deposit'),
                DB::raw('(SELECT SUM(nominal) FROM pembayarans WHERE metode_pembayaran != "deposit") as pembayaran'),
                DB::raw('(SELECT SUM(nominal) FROM pembayarans WHERE metode_pembayaran = "tunai") as tunai'),
                DB::raw('(SELECT SUM(nominal) FROM pembayarans WHERE metode_pembayaran = "qris") as qris'),
                DB::raw('(SELECT SUM(nominal) FROM pembayarans WHERE metode_pembayaran = "debit") as debit'),
                DB::raw('(SELECT SUM(nominal) FROM pembayarans WHERE metode_pembayaran = "transfer") as transfer'),
            )
            ->groupBy('bulan')
            ->get();
            array_push($dataLaporan, $temp);
        }

        return view('pages.laporan.OmsetBulanan', [
            'laporan' => $dataLaporan,
            'tahun' => $request->year,
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
}
