<?php

namespace App\Http\Controllers;

use App\Models\Data\Pelanggan;
use App\Models\Outlet;
use App\Models\Pembayaran;
use App\Models\Saldo;
use App\Models\Transaksi\Transaksi;
use App\Models\UserAction;
use Carbon\Carbon;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LaporanController extends Controller
{
    public function tablePiutang(Request $request)
    {
        $start = $request->start . ' 00:00:00';
        $end = $request->end . ' 23:59:59';

        $pelanggans = Pelanggan::with('transaksi')
            ->when($request->filled('orderBy'), function($query) use ($request) {
                $query->orderBy($request->filled('orderBy'), $request->filled('order'));
            })
            ->when($request->filled('name'), function($query) use ($request) {
                $query->where('nama', 'like', '%' . $request->name . '%');
            })
            ->whereHas('transaksi', function($query) use ($start, $end) {
                $query->where('lunas', false)
                    ->whereBetween('created_at', [$start, $end])
                    ->whereRaw('(grand_total - total_terbayar) > 0');
            })
            ->get();

        // TODO: add datalist (key: pelanggan->name, value: pelanggan->id)
        $total_piutang = Transaksi::where('lunas', false)
            ->whereBetween('created_at', [$start, $end])
            ->sum(DB::raw('grand_total - total_terbayar'));

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
        // $result = [];
        if ($request->has('start') && $request->has('end')) {
            $start = $request->start . ' 00:00:00';
            $end = $request->end . ' 23:59:59';

            $completedTransactions = Pembayaran::whereBetween('created_at', [$start, $end])
                ->whereHas('transaksi', function($query) {
                    $query->where('lunas', true);
                })
                ->with('transaksi')
                ->orderBy('created_at')
                ->get();

            $countPerDay = Pembayaran::whereBetween('created_at', [$start, $end])
                ->whereHas('transaksi', function ($query) {
                    $query->where('lunas', true);
                })
                ->with('transaksi')
                ->orderBy('created_at')
                ->get()
                ->groupBy(function ($item) {
                    return $item->created_at->format('d-m-Y');
                })
                ->map(function ($group) {
                    return count($group);
                });

            // return $completedTransactions;

            // $pembayarans = Pembayaran::with('transaksi')->orderBy('created_at')->whereBetween('created_at', [$start, $end])->get();
            // $pelanggans = Pelanggan::get();
            // foreach ($pembayarans as $key) {
            //     $temp = [];
            //     $ctr = 0;
            //     if(array_search(substr($key->created_at, 0, 10), array_column($result, 'tanggal'))===false){
            //         $temp1 = Pembayaran::with('transaksi')->whereBetween('created_at', [substr($key->created_at, 0, 10). ' 00:00:00', substr($key->created_at,0,10).' 23:59:59'])->get();
            //         foreach ($temp1 as $key2) {
            //             $kode = $key2->transaksi->first()->kode ?? 'null';
            //             // dd($temp1);
            //             if ( array_search(substr($key->created_at, 0, 10), array_column($temp, 'tanggal')) === false) {
            //                 if (array_search($pelanggans->find($key2->transaksi->first()->pelanggan_id ?? 0)->nama ?? 'null', array_column($temp, 'nama_pelanggan')) === false) {
            //                 //ini if cadangan kalau tidak bisa di server
            //                 // if (array_search($key2->transaksi->first()->pelanggan->nama, array_column($temp, 'nama_pelanggan')) === false) {
            //                     // Add the new data for a unique nama_pelanggan
            //                     array_push($temp, [
            //                         // 'kode_transaksi' => $key2->transaksi->first()->kode,
            //                         // 'kode_pelanggan' => $key2->transaksi->first()->pelanggan->id,
            //                         // 'nama_pelanggan' => $key2->transaksi->first()->pelanggan->nama,
            //                         // 'nominal' => $this->NominalPelanggans($temp1, substr($key2->created_at, 0, 10), $key2->transaksi->first()->kode)

            //                         //ini code cadangan klo di server gk bisa
            //                         'kode_transaksi' => $kode,
            //                         'kode_pelanggan' => $pelanggans->find($key2->transaksi->first()->pelanggan_id ?? 0)->id ?? 0,
            //                         'nama_pelanggan' => $pelanggans->find($key2->transaksi->first()->pelanggan_id ?? 0)->nama ?? 'null',
            //                         'nominal' => $this->NominalPelanggans($temp1, substr($key2->created_at, 0, 10), $kode),
            //                     ]);
            //                     $ctr++;
            //                 }
            //             }
            //         }
            //         array_push($result,[
            //             'tanggal' => substr($key->created_at, 0, 10),
            //             'total' => $this->sumPelanggans($pembayarans, substr($key->created_at, 0, 10)),
            //             'data' => $temp,
            //             'count' => $ctr
            //         ]);
            //     }
            //     $temp = [];
            //     $ctr = 0;
            // }
            // dd($result);
            // $totalOmset = $completedTransactions->sum('nominal');
            // dd([$completedTransactions], [$totalOmset]);
            return view('pages.laporan.Omset', [
                'pembayarans' => $completedTransactions,
                'rowHeight' => $countPerDay,
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
        // $start = $request->start . ' 00:00:00';
        // $end = $request->end . ' 23:59:59';

        // $pembayarans = Pembayaran::with('transaksi')->orderBy('created_at')->whereBetween('created_at', [$start, $end])->get();
        // $rowHeight = DB::table('pembayarans')
        //     ->select(DB::raw('COUNT(DATE(created_at)) as count'), DB::raw('DATE(created_at) as tanggal'))
        //     ->groupBy(DB::raw('DATE(created_at)'))
        //     ->whereBetween('created_at', [$start, $end])
        //     ->get();
        // $sumOfEachDate = $pembayarans->groupBy(function ($date) {
        //     return Carbon::parse($date->created_at)->format('d-M-Y');
        // })->map(function ($group) {
        //     return $group->sum('nominal');
        // });
        // $total_omset = $pembayarans->sum('nominal');
        // return response()->json([
        //     'pembayarans'  => $pembayarans,
        //     'rowHeight' => $rowHeight,
        //     'sumOfEachDate' => $sumOfEachDate,
        //     'total_omset' => $total_omset,
        // ]);
    }

    public function tableKasMasuk(Request $request)
    {
        $start = $request->start . ' 00:00:00';
        $end = $request->end . ' 23:59:59';

        $tipe = explode(";", $request->jenis);
        array_pop($tipe);

        $data1 = [];
        $data2 = [];

        $rowHeight = [];
        $sumOfEachPaymentMethod = [];
        $sum = 0;

        $pembayarans = Pembayaran::with(['transaksi', 'transaksi.pelanggan', 'kasir'])
            ->whereBetween('created_at', [$start, $end])
            ->whereIn('metode_pembayaran', $tipe)
            ->orderBy('created_at')
            ->get();

        $deposits = Saldo::with(['pelanggan', 'outlet', 'paket_deposit', 'kasir'])
            ->whereBetween('created_at', [$start, $end])
            ->where('jenis_input', 'deposit')
            ->orderBy('created_at')
            ->get();

        foreach ($pembayarans as $pembayaran) {
            if (isset($rowHeight[$pembayaran->metode_pembayaran])) {
                $rowHeight[$pembayaran->metode_pembayaran]++;
            } else {
                $rowHeight[$pembayaran->metode_pembayaran] = 1;
            }

            if (isset($sumOfEachPaymentMethod[$pembayaran->metode_pembayaran])) {
                $sumOfEachPaymentMethod[$pembayaran->metode_pembayaran] += $pembayaran->nominal;
            } else {
                $sumOfEachPaymentMethod[$pembayaran->metode_pembayaran] = $pembayaran->nominal;
            }

            array_push($data1, (object)[
                'kode' => 'PM' . str_pad($pembayaran->id, 6, '0', STR_PAD_LEFT),
                'tanggal' => $pembayaran->created_at,
                'pelanggan' => $pembayaran->transaksi->pelanggan->nama,
                'nominal' => $pembayaran->nominal,
                'tipe' => $pembayaran->metode_pembayaran,
                'keterangan' => "PEMBAYARAN VIA " . strtoupper($pembayaran->metode_pembayaran),
                'operator' => isset($pembayaran->kasir) ? strtoupper($pembayaran->kasir->name) : '',
            ]);

            $sum += $pembayaran->nominal;
        }
        foreach ($deposits as $deposit) {
            if (isset($rowHeight[$deposit->via])) {
                $rowHeight[$deposit->via]++;
            } else {
                $rowHeight[$deposit->via] = 1;
            }

            if (isset($sumOfEachPaymentMethod[$deposit->via])) {
                $sumOfEachPaymentMethod[$deposit->via] += $deposit->kas_masuk;
            } else {
                $sumOfEachPaymentMethod[$deposit->via] = $deposit->kas_masuk;
            }

            array_push($data2, (object)[
                'kode' => 'DP' . str_pad($deposit->id, 6, '0', STR_PAD_LEFT),
                'tanggal' => $deposit->created_at,
                'pelanggan' => $deposit->pelanggan->nama,
                'nominal' => $deposit->kas_masuk,
                'tipe' => $deposit->via,
                'keterangan' => "PENGISIAN DEPOSIT VIA " . strtoupper($deposit->via),
                'operator' =>  isset($deposit->kasir) ? strtoupper($deposit->kasir->name) : '',
            ]);

            $sum += $deposit->kas_masuk;
        }
        $data = array_merge($data1, $data2);

        usort($data, function ($item1, $item2) {
            if ($item1->tipe !== $item2->tipe) {
                return $item1->tipe <=> $item2->tipe;
            }
            return $item1->tanggal <=> $item2->tanggal;
        });

        // return response()->json($data);

        // $paymentQuery = Pembayaran::select(
        //     'pembayarans.id as id',
        //     'pelanggans.id as id_pelanggan',
        //     'pelanggans.nama as nama_pelanggan',
        //     'pembayarans.metode_pembayaran as metode_pembayaran',
        //     'pembayarans.nominal as nominal',
        //     DB::raw("'pembayaran' as source"),
        //     'pembayarans.created_at as created_at'
        // )
        //     ->join('transaksis', 'transaksis.id', '=', 'pembayarans.transaksi_id')
        //     ->join('pelanggans', 'pelanggans.id', '=', 'transaksis.pelanggan_id')
        //     ->whereBetween('pembayarans.created_at', [$start, $end])
        //     ->whereIn('pembayarans.metode_pembayaran', $tipe);

        // $saldoQuery = Saldo::select(
        //     'saldos.id as id',
        //     'pelanggans.id as id_pelanggan',
        //     'pelanggans.nama as nama_pelanggan',
        //     'saldos.via as metode_pembayaran',
        //     'saldos.nominal as nominal',
        //     DB::raw("'deposit' as source"),
        //     'saldos.created_at as created_at'
        // )
        //     ->join('pelanggans', 'pelanggans.id', '=', 'saldos.pelanggan_id')
        //     ->whereBetween('saldos.created_at', [$start, $end])
        //     ->where('saldos.jenis_input', '=', 'deposit');

        // foreach ($jenis as $key => $value) {
        //     if ($key === 0) {
        //         $saldoQuery->where('saldos.via', $tipe[intval($value) - 1]);
        //     } else {
        //         $saldoQuery->orWhere('saldos.via', $tipe[intval($value) - 1]);
        //     }
        // }

        // $kas = $paymentQuery->union($saldoQuery)
        //     ->orderByRaw("FIELD(metode_pembayaran, 'tunai', 'qris', 'debit', 'transfer')")
        //     ->get(['id', 'id_pelanggan', 'nama_pelanggan', 'metode_pembayaran', 'nominal', 'source', 'created_at']);
        // $total_kas = $kas->sum('nominal');

        // $rowHeight = $kas->groupBy('metode_pembayaran')->map->count();
        // $sumOfEachPaymentMethod = $kas->groupBy('metode_pembayaran')
        //     ->map(function ($group) {
        //         return $group->sum('nominal');
        //     });
        // dd($sumOfEachPaymentMethod);
        return view('components.tableLaporanKas', [
            'kas' => $data,
            'totalKas' => $sum,
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
