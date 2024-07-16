<?php

namespace App\Http\Controllers;

use App\Models\Data\Pelanggan;
use App\Models\Pembayaran;
use App\Models\Saldo;
use App\Models\Transaksi\Transaksi;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class LaporanController extends Controller
{
    public function tablePiutang(Request $request)
    {
        $start = $request->start . ' 00:00:00';
        $end = $request->end . ' 23:59:59';
        $outlet_id = User::getOutletId(Auth::id());

        $pelanggans = Pelanggan::with('transaksi')
            ->when($request->filled('orderBy'), function ($query) use ($request) {
                $query->orderBy($request->filled('orderBy'), $request->filled('order'));
            })
            ->when($request->filled('name'), function ($query) use ($request) {
                $query->where('nama', 'like', '%' . $request->name . '%');
            })
            ->whereHas('transaksi', function ($query) use ($start, $end, $outlet_id) {
                $query->where('lunas', false)
                    ->where('outlet_id', $outlet_id)
                    ->whereBetween('created_at', [$start, $end])
                    ->whereRaw('(grand_total - total_terbayar) > 0');
            })
            ->get();

        $total_piutang = Transaksi::where('lunas', false)
            ->where('outlet_id', $outlet_id)
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
        return view('pages.laporan.PiutangPelanggan', [
            'pelanggans' => Pelanggan::orderBy('nama', 'asc')->get()
        ]);
    }

    public function laporanPiutangPelangganDetail($id, Request $request)
    {
        $start = $request->start . ' 00:00:00';
        $end = $request->end . ' 23:59:59';
        $outlet_id = User::getOutletId(Auth::id());

        $transaksis = Transaksi::detail()
            ->where('lunas', false)
            ->where('outlet_id', $outlet_id)
            ->where('pelanggan_id', $id)
            ->whereBetween('created_at', [$start, $end])
            ->get();
        $totalPiutang = Transaksi::where('lunas', false)
            ->where('outlet_id', $outlet_id)
            ->where('pelanggan_id', $id)
            ->whereBetween('created_at', [$start, $end])
            ->sum(DB::raw('grand_total - total_terbayar'));

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

    function sumPelanggans($data, $day)
    {
        $sum = 0;
        foreach ($data as $value) {
            if ($day == substr($value->created_at, 0, 10)) {
                $sum += $value->nominal;
            }
        }
        return $sum;
    }

    function NominalPelanggans($data, $day, $trans)
    {
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
        if ($request->has('start') && $request->has('end')) {
            $start = $request->start . ' 00:00:00';
            $end = $request->end . ' 23:59:59';
            $outlet_id = User::getOutletId(Auth::id());

            $completedTransactions = Pembayaran::whereBetween('created_at', [$start, $end])
                ->whereHas('transaksi', function ($query) use ($outlet_id) {
                    // $query->where('lunas', true)
                    //     ->where('outlet_id', $outlet_id);
                    $query->where('outlet_id', $outlet_id);
                })
                ->where('outlet_id', Auth::user()->outlet_id)
                ->with('transaksi')
                ->orderBy('created_at')
                ->get();

            $countPerDay = Pembayaran::whereBetween('created_at', [$start, $end])
                ->whereHas('transaksi', function ($query) use ($outlet_id) {
                    // $query->where('lunas', true)
                    //     ->where('outlet_id', $outlet_id);
                    $query->where('outlet_id', $outlet_id);
                })
                ->where('outlet_id', Auth::user()->outlet_id)
                ->with('transaksi')
                ->orderBy('created_at')
                ->get()
                ->groupBy(function ($item) {
                    return $item->created_at->format('d-m-Y');
                })
                ->map(function ($group) {
                    return count($group);
                });

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

    public function tableKasMasuk(Request $request)
    {
        $start = $request->start . ' 00:00:00';
        $end = $request->end . ' 23:59:59';
        $outlet_id = User::getOutletId(Auth::id());

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
            ->where('outlet_id', $outlet_id)
            ->orderBy('created_at')
            ->get();

        $deposits = Saldo::with(['pelanggan', 'outlet', 'paket_deposit', 'kasir'])
            ->whereBetween('created_at', [$start, $end])
            ->where('jenis_input', 'deposit')
            ->where('outlet_id', $outlet_id)
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
                'nomor_order' => $pembayaran->transaksi->kode,
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
                'nomor_order' => '-',
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
