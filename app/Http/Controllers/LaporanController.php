<?php

namespace App\Http\Controllers;

use App\Models\Data\Pelanggan;
use App\Models\Outlet;
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
    public function tablePiutang(Request $request)
    {
        $start = $request->start . ' 00:00:00';
        $end = $request->end . ' 23:59:59';

        $pelanggans = Pelanggan::when($request->filled('orderBy'), function($query) use ($request) {
                $query->orderBy($request->filled('orderBy'), $request->filled('order'));
            })->get();
        $total_piutang = Transaksi::where('lunas', false)->whereBetween('created_at', [$start, $end])->sum(DB::raw('grand_total - total_terbayar'));

        return view('components.tableLaporanPiutang', [
            'pelanggans' => $pelanggans,
            'start' => $start,
            'end' => $end,
            'total_piutang' => $total_piutang,
        ]);
    }

    public function laporanPiutangPelanggan()
    {
        return view('pages.laporan.PiutangPelanggan');
    }

    public function laporanPiutangPelangganDetail($id, Request $request)
    {
        $start = $request->start . ' 00:00:00';
        $end = $request->end . ' 23:59:59';
        $transaksis = Transaksi::detail()->where('lunas', false)->where('pelanggan_id', $id)->whereBetween('created_at', [$start, $end])->get();
        $totalPiutang = Transaksi::where('lunas', false)->where('pelanggan_id', $id)->whereBetween('created_at', [$start, $end])->sum(DB::raw('grand_total - total_terbayar'));

        return view('pages.laporan.DetailPiutangPelanggan', [
            'transaksis' => $transaksis,
            'total_piutang' => $totalPiutang,
            'start' => $request->start,
            'end' => $request->end,
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

    function sumPelanggans($data,$day) {
        $sum = 0;
        foreach ( $data as $value ) {
            if ($day == substr($value->created_at, 0, 10)) {
                $sum += $value->nominal;
            }
        }
        return $sum;
    }

    function NominalPelanggans($data, $day, $trans) {
        $sum = 0;
        foreach ($data as $value) {
            $kode = $value->transaksi->first()->kode ?? 'null';
            if ($day == substr($value->created_at, 0, 10) && $trans == $kode) {
                $sum += $value->nominal;
            }
        }
        return $sum;
    }

    public function laporanOmset(Request $request)
    {
        $result = [];
        if ($request->has('start') && $request->has('end')) {
            $start = $request->start . ' 00:00:00';
            $end = $request->end . ' 23:59:59';

            $pembayarans = Pembayaran::with('transaksi')->orderBy('created_at')->whereBetween('created_at', [$start, $end])->get();
            $pelanggans = Pelanggan::get();
            foreach ($pembayarans as $key) {
                $temp = [];
                $ctr = 0;
                if(array_search(substr($key->created_at, 0, 10), array_column($result, 'tanggal'))===false){
                    $temp1 = Pembayaran::with('transaksi')->whereBetween('created_at', [substr($key->created_at, 0, 10). ' 00:00:00', substr($key->created_at,0,10).' 23:59:59'])->get();
                    foreach ($temp1 as $key2) {
                        $kode = $key2->transaksi->first()->kode ?? 'null';
                        // dd($temp1);
                        if ( array_search(substr($key->created_at, 0, 10), array_column($temp, 'tanggal')) === false) {
                            if (array_search($pelanggans->find($key2->transaksi->first()->pelanggan_id ?? 0)->nama, array_column($temp, 'nama_pelanggan')) === false) {
                            //ini if cadangan kalau tidak bisa di server
                            // if (array_search($key2->transaksi->first()->pelanggan->nama, array_column($temp, 'nama_pelanggan')) === false) {
                                // Add the new data for a unique nama_pelanggan
                                array_push($temp, [
                                    // 'kode_transaksi' => $key2->transaksi->first()->kode,
                                    // 'kode_pelanggan' => $key2->transaksi->first()->pelanggan->id,
                                    // 'nama_pelanggan' => $key2->transaksi->first()->pelanggan->nama,
                                    // 'nominal' => $this->NominalPelanggans($temp1, substr($key2->created_at, 0, 10), $key2->transaksi->first()->kode)

                                    //ini code cadangan klo di server gk bisa
                                    'kode_transaksi' => $kode,
                                    'kode_pelanggan' => $pelanggans->find($key2->transaksi->first()->pelanggan_id)->id,
                                    'nama_pelanggan' => $pelanggans->find($key2->transaksi->first()->pelanggan_id)->nama,
                                    'nominal' => $this->NominalPelanggans($temp1, substr($key2->created_at, 0, 10), $kode),
                                ]);
                                $ctr++;
                            }
                        }
                    }
                    array_push($result,[
                        'tanggal' => substr($key->created_at, 0, 10),
                        'total' => $this->sumPelanggans($pembayarans, substr($key->created_at, 0, 10)),
                        'data' => $temp,
                        'count' => $ctr
                    ]);
                }
                $temp = [];
                $ctr = 0;
            }
            // dd($result);
            $totalOmset = $pembayarans->sum('nominal');
            return view('pages.laporan.Omset', [
                'pembayarans' => $result,
                'totalOmset' => $totalOmset,
                'startDate' => $start,
                'endDate' => $end,
            ]);
        } else {
            return view('pages.laporan.Omset');
        }
    }

    public function tableOmset(Request $request)
    {
    }

    public function apiTableOmset(Request $request)
    {
        $start = $request->start . ' 00:00:00';
        $end = $request->end . ' 23:59:59';

        $pembayarans = Pembayaran::with('transaksi')->orderBy('created_at')->whereBetween('created_at', [$start, $end])->get();
        $rowHeight = DB::table('pembayarans')
            ->select(DB::raw('COUNT(DATE(created_at)) as count'), DB::raw('DATE(created_at) as tanggal'))
            ->groupBy(DB::raw('DATE(created_at)'))
            ->whereBetween('created_at', [$start, $end])
            ->get();
        $sumOfEachDate = $pembayarans->groupBy(function ($date) {
            return Carbon::parse($date->created_at)->format('d-M-Y');
        })->map(function ($group) {
            return $group->sum('nominal');
        });
        $total_omset = $pembayarans->sum('nominal');
        return response()->json([
            'pembayarans'  => $pembayarans,
            'rowHeight' => $rowHeight,
            'sumOfEachDate' => $sumOfEachDate,
            'total_omset' => $total_omset,
        ]);
    }

    public function tableKasMasuk(Request $request)
    {
        $start = $request->start . ' 00:00:00';
        $end = $request->end . ' 23:59:59';
        $jenis = str_split($request->jenis);
        $tipe = ['tunai', 'qris', 'debit', 'transfer'];

        $paymentQuery = Pembayaran::select(
            'pembayarans.id as id',
            'pelanggans.id as id_pelanggan',
            'pelanggans.nama as nama_pelanggan',
            'pembayarans.metode_pembayaran as metode_pembayaran',
            'pembayarans.nominal as nominal',
            DB::raw("'pembayaran' as source"),
            'pembayarans.created_at as created_at'
        )
            ->join('transaksis', 'transaksis.id', '=', 'pembayarans.transaksi_id')
            ->join('pelanggans', 'pelanggans.id', '=', 'transaksis.pelanggan_id')
            ->whereBetween('pembayarans.created_at', [$start, $end]);

        foreach ($jenis as $key => $value) {
            if ($key === 0) {
                $paymentQuery->where('pembayarans.metode_pembayaran', $tipe[intval($value) - 1]);
            } else {
                $paymentQuery->orWhere('pembayarans.metode_pembayaran', $tipe[intval($value) - 1]);
            }
        }

        $saldoQuery = Saldo::select(
            'saldos.id as id',
            'pelanggans.id as id_pelanggan',
            'pelanggans.nama as nama_pelanggan',
            'saldos.via as metode_pembayaran',
            'saldos.nominal as nominal',
            DB::raw("'deposit' as source"),
            'saldos.created_at as created_at'
        )
            ->join('pelanggans', 'pelanggans.id', '=', 'saldos.pelanggan_id')
            ->whereBetween('saldos.created_at', [$start, $end])
            ->where('saldos.jenis_input', '=', 'deposit');

        foreach ($jenis as $key => $value) {
            if ($key === 0) {
                $saldoQuery->where('saldos.via', $tipe[intval($value) - 1]);
            } else {
                $saldoQuery->orWhere('saldos.via', $tipe[intval($value) - 1]);
            }
        }

        $kas = $paymentQuery->union($saldoQuery)
            ->orderByRaw("FIELD(metode_pembayaran, 'tunai', 'qris', 'debit', 'transfer')")
            ->get(['id', 'id_pelanggan', 'nama_pelanggan', 'metode_pembayaran', 'nominal', 'source', 'created_at']);
        $total_kas = $kas->sum('nominal');

        $rowHeight = $kas->groupBy('metode_pembayaran')->map->count();
        $sumOfEachPaymentMethod = $kas->groupBy('metode_pembayaran')
            ->map(function ($group) {
                return $group->sum('nominal');
            });
        return view('components.tableLaporanKas', [
            'kas' => $kas,
            'total_kas' => $total_kas,
            'rowHeight' => $rowHeight,
            'sumOfEachPaymentMethod' => $sumOfEachPaymentMethod,
            'start' => $start,
            'end' => $end,
        ]);
    }

    public function laporanKas()
    {
        return view('pages.laporan.KasMasuk');
    }
}
