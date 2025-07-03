<?php

namespace App\Http\Controllers;

use App\Exports\LaporanCuciExport;
use App\Exports\LaporanOmsetExport;
use App\Exports\LaporanPelangganExport;
use App\Exports\LaporanSaldoExport;
use App\Models\Data\Pelanggan;
use App\Models\Outlet;
use App\Models\Pembayaran;
use App\Models\Saldo;
use App\Models\Transaksi\Transaksi;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Data\Pengeluaran;
use App\Exports\LaporanPengeluaranExport;
use App\Exports\LaporanDepositExport;
use App\Exports\LaporanPiutangPelangganExport;
use App\Exports\LaporanKasMasukExport;

class LaporanController extends Controller
{

    public function tableCustomer(Request $request)
    {
        $pages = $request->page;
        $jenis = explode(';', $request->input('jenis'));
        $jenis = array_filter($jenis);
        $outlet_id = User::getOutletId(Auth::id());
        if ($request->page == 'data-pelanggan' || $request->page == 'data-cuci') {
            $start = $request->input('start') . ' 00:00:00';
            $end = $request->input('end') . ' 23:59:59';
            if ($request->page == 'data-pelanggan') {
                $query = Transaksi::select(
                    'pelanggan_id',
                    DB::raw('COUNT(*) as total_washes'),
                    DB::raw('MAX(created_at) as terakhir_transaksi'),
                    DB::raw('SUM(grand_total) as total_harga'),
                    DB::raw('SUM(grand_total - total_terbayar) as hutang'),
                    DB::raw('SUM(grand_total) - SUM(grand_total - total_terbayar) as harga_asli')
                )
                    ->where('outlet_id', $outlet_id)
                    ->whereBetween('created_at', [$start, $end])
                    ->whereHas('item_transaksi', function ($query) {
                        $query->whereNotNull('jenis_item_id');
                    })
                    ->where('is_done_cuci', 1)
                    ->groupBy('pelanggan_id')
                    ->detail();

                if (in_array('terbanyak', $jenis)) {
                    $query->orderBy('total_washes', 'desc');
                }

                if (in_array('termahal', $jenis)) {
                    $query->orderBy('harga_asli', 'desc');
                }
                $data = $query->get();
                // dd($data);
                $customers = $data->map(function ($customerData) use ($start, $end) {
                    $pelanggan = Pelanggan::find($customerData->pelanggan_id);
                    $transaksi = $customerData->terakhir_transaksi;
                    $totalcuci = $customerData->total_washes;
                    // dd($customerData);
                    $totalHarga = $customerData->total_harga;
                    $hutang = $customerData->hutang;
                    $membership = $pelanggan->member;
                    $itemcuci_terbanyak = Transaksi::where('pelanggan_id', $customerData->pelanggan_id)
                        ->whereBetween('created_at', [$start, $end])
                        ->whereHas('item_transaksi', function ($query) {
                            $query->whereNotNull('jenis_item_id');
                        })
                        ->with(['item_transaksi' => function ($query) {
                            $query->select('transaksi_id', 'jenis_item_id',);
                        }])
                        ->get()
                        ->flatMap(function ($transaksi) {
                            return $transaksi->item_transaksi;
                        })
                        ->groupBy('jenis_item_id')
                        ->sortByDesc(function ($items) {
                            return $items->count();
                        })
                        ->map(function ($items) {
                            return $items->first()->nama;
                        })
                        ->first();
                    return [
                        'nama' => $pelanggan->nama,
                        'transaksi_terakhir' => $transaksi,
                        'total_cuci' => $totalcuci,
                        'item_cuci' => $itemcuci_terbanyak ? $itemcuci_terbanyak : 'N/A',
                        'total_harga' => $totalHarga - $hutang,
                        'hutang' => $hutang,
                        'member' => $membership
                    ];
                });

                $totalKas = $customers->max('total_harga');
                $highest = $customers->first();

                if (in_array('terbanyak', $jenis)) {
                    $highest = $customers->sortByDesc('total_washes')->first();
                }

                if (in_array('termahal', $jenis)) {
                    $highest = $customers->sortByDesc('total_harga')->first();
                }

                if (in_array('item', $jenis)) {
                    $highest = $customers->sortByDesc('item_cuci')->first();
                }

                return view('components.tableCustomer', [
                    'data' => $customers,
                    'totalKas' => $totalKas,
                    'highest' => $highest,
                    'jenis' => $jenis,
                    'page' => $pages
                ]);
            }

            if ($request->page == 'data-cuci') {
                $query = Transaksi::select(
                    'pelanggan_id',
                    DB::raw('MAX(created_at) as terakhir_transaksi'),
                    DB::raw('SUM(grand_total) as total_harga'),
                    DB::raw('SUM(grand_total - total_terbayar) as hutang')
                )
                    ->where('outlet_id', $outlet_id)
                    ->whereBetween('created_at', [$start, $end])
                    ->whereHas('item_transaksi', function ($query) {
                        $query->whereNotNull('jenis_item_id');
                    })
                    ->where('is_done_cuci', 1)
                    ->groupBy('pelanggan_id')
                    ->detail();

                $data = $query->get();

                $customer = $data->flatMap(function ($customerData) use ($start, $end) {
                    $transactions = Transaksi::where('pelanggan_id', $customerData->pelanggan_id)
                        ->whereBetween('created_at', [$start, $end])
                        ->with(['item_transaksi' => function ($query) {
                            $query->select('transaksi_id', 'qty', 'jenis_item_id');
                        }])
                        ->get();

                    $items = $transactions->flatMap(function ($transaction) {
                        $status = $transaction->grand_total == $transaction->total_terbayar ? 'Lunas' : 'Hutang';

                        return $transaction->item_transaksi->map(function ($item) use ($transaction, $status) {
                            return [
                                'nama' => $item->nama,
                                'quantity' => $item->qty,
                                'transaksi_id' => $transaction->id,
                                'transaksi_date' => $transaction->created_at,
                                'pelanggan' => $transaction->pelanggan->nama,
                                'membership' => $transaction->pelanggan->member,
                                'total_harga' => $transaction->grand_total,
                                'tipe_transaksi' => $transaction->tipe_transaksi,
                                'status' => $status,
                                'progres' => $transaction->is_done_cuci ? 'Selesai' : 'Proses'
                            ];
                        });
                    });
                    return $items;
                });

                $totalKas = $customer->max('total_harga');
                $highest = $customer->first();
                if (in_array('item', $jenis)) {
                    $highest = $customer->groupBy('nama')->map(function ($group, $key) {
                        return [
                            'nama' => $key,
                            'quantity' => $group->sum('quantity')
                        ];
                    })->sortByDesc('quantity')->first();
                }
                return view('components.tableCustomer', [
                    'data' => $customer,
                    'totalKas' => $totalKas,
                    'highest' => $highest,
                    'jenis' => $jenis,
                    'page' => $pages
                ]);
            }
        }
        if ($request->page == 'data-omset' || $request->page == 'data-saldo') {
            $bulan = $request->input('bulan');
            if ($request->page == 'data-omset') {
                $transaksi_berhasil = Pembayaran::whereYear('created_at', '=', date('Y', strtotime($bulan)))
                    ->whereMonth('created_at', '=', date('m', strtotime($bulan)))
                    ->whereHas('transaksi', function ($query) use ($outlet_id) {
                        $query->where('outlet_id', $outlet_id);
                    })
                    ->where('outlet_id', Auth::user()->outlet_id)
                    ->with(['transaksi.pelanggan'])
                    ->orderBy('created_at')
                    ->get();

                $rowHeight = $transaksi_berhasil->groupBy(function ($item) {
                    return $item->created_at->format('d-m-Y');
                })->map(function ($group) {
                    return $group->count();
                });

                $omsetPerMonth = $transaksi_berhasil->groupBy(function ($item) {
                    return $item->created_at->format('d-Y-m');
                })->map(function ($group) {
                    return $group->sum('nominal');
                });
                if (in_array('omsetTerbesar', $jenis)) {
                    $omsetPerMonth = $omsetPerMonth->sortDesc();
                } elseif (in_array('omsetTerkecil', $jenis)) {
                    $omsetPerMonth = $omsetPerMonth->sort();
                }

                return view('components.tableCustomer', [
                    'omsetPerMonth' => $omsetPerMonth,
                    'completedTransactions' => $transaksi_berhasil,
                    'rowHeight' => $rowHeight,
                    'startDate' => $bulan,
                    'jenis' => $jenis,
                    'page' => $pages
                ]);
            }
            if ($request->page == 'data-saldo') {
                $saldo = Saldo::whereYear('created_at', '=', date('Y', strtotime($bulan)))
                    ->whereMonth('created_at', '=', date('m', strtotime($bulan)))
                    ->where('outlet_id', $outlet_id)
                    ->with(['pelanggan'])
                    ->orderBy('created_at')
                    ->get();
                $rowHeight = $saldo->groupBy(function ($item) {
                    return $item->created_at->format('d-m-Y');
                })->map(function ($group) {
                    return $group->count();
                });
                $saldoPer = $saldo->groupBy(function ($item) {
                    return $item->created_at->format('Y-m');
                })->map(function ($group) {
                    return $group->where('nominal');
                });
                if (in_array('saldoTerbesar', $jenis)) {
                    $saldoPerMonth = $saldoPer->sortDesc();
                    $saldo = $saldo->sortByDesc('saldo_akhir');
                } elseif (in_array('saldoTerkecil', $jenis)) {
                    $saldoPerMonth = $saldoPer->sort();
                }
                $highest = $saldo->sortByDesc('saldo_akhir')->first();
                $smallest = $saldo->sortByDesc('saldo_akhir')->first();
                return view('components.tableCustomer', [
                    'saldoPerMonth' => $saldoPerMonth,
                    'completedBalances' => $saldo,
                    'rowHeight' => $rowHeight,
                    'bulan' => $bulan,
                    'jenis' => $jenis,
                    'page' => $pages,
                    'highest' => $highest,
                    'smallest' => $smallest
                ]);
            }
        }
    }

    public function customer()
    {
        return view('pages.laporan.Customer');
    }

    public function exportExcel(Request $request)
    {
        $pages = $request->page;
        $jenis = explode(';', $request->input('jenis'));
        $jenis = array_filter($jenis);
        $outlet_id = User::getOutletId(Auth::id());
        if ($pages == 'data-cuci' || $pages == 'data-pelanggan') {

            $start = $request->input('start') . ' 00:00:00';
            $end = $request->input('end') . ' 23:59:59';
            if ($pages == 'data-pelanggan') {
                $query = Transaksi::select(
                    'pelanggan_id',
                    DB::raw('COUNT(*) as total_washes'),
                    DB::raw('MAX(created_at) as terakhir_transaksi'),
                    DB::raw('SUM(grand_total) as total_harga'),
                    DB::raw('SUM(grand_total - total_terbayar) as hutang'),
                    DB::raw('SUM(grand_total) - SUM(grand_total - total_terbayar) as harga_asli')
                )
                    ->where('outlet_id', $outlet_id)
                    ->whereBetween('created_at', [$start, $end])
                    ->whereHas('item_transaksi', function ($query) {
                        $query->whereNotNull('jenis_item_id');
                    })
                    ->where('is_done_cuci', 1)
                    ->groupBy('pelanggan_id')
                    ->detail();

                if (in_array('terbanyak', $jenis)) {
                    $query->orderBy('total_washes', 'desc');
                }

                if (in_array('termahal', $jenis)) {
                    $query->orderBy('harga_asli', 'desc');
                }

                $data = $query->get();

                $customers = $data->map(function ($customerData) use ($start, $end) {
                    $pelanggan = Pelanggan::find($customerData->pelanggan_id);
                    $transaksi = $customerData->terakhir_transaksi;
                    $totalcuci = $customerData->total_washes;
                    $totalHarga = $customerData->total_harga;
                    $hutang = $customerData->hutang;
                    $membership = $pelanggan->member;
                    $itemcuci_terbanyak = Transaksi::where('pelanggan_id', $customerData->pelanggan_id)
                        ->whereBetween('created_at', [$start, $end])
                        ->whereHas('item_transaksi', function ($query) {
                            $query->whereNotNull('jenis_item_id');
                        })
                        ->with(['item_transaksi' => function ($query) {
                            $query->select('transaksi_id', 'jenis_item_id');
                        }])
                        ->get()
                        ->flatMap(function ($transaksi) {
                            return $transaksi->item_transaksi;
                        })
                        ->groupBy('jenis_item_id')
                        ->sortByDesc(function ($items) {
                            return $items->count();
                        })
                        ->map(function ($items) {
                            return $items->first()->nama;
                        })
                        ->first();
                    return [
                        'member' => $membership ? 'Membership' : 'Bukan Member',
                        'nama' => $pelanggan->nama,
                        'transaksi_terakhir' => $transaksi,
                        'total_cuci' => $totalcuci,
                        // 'item_cuci' => $itemcuci_terbanyak ? $itemcuci_terbanyak : 'N/A',
                        'total_harga' => $totalHarga - $hutang,
                        'hutang' => $hutang == 0 ? 'Lunas' : number_format($hutang, 0, ',', '.'),
                    ];
                });

                $filename = 'laporan_pelanggan_' . date('Y-m-d_H-i-s') . '.xlsx';

                return Excel::download(new LaporanPelangganExport($customers->toArray(), $start, $end), $filename);
            }

            if ($pages == 'data-cuci') {
                $query = Transaksi::select(
                    'pelanggan_id',
                    DB::raw('MAX(created_at) as terakhir_transaksi'),
                    DB::raw('SUM(grand_total) as total_harga'),
                    DB::raw('SUM(grand_total - total_terbayar) as hutang')
                )
                    ->where('outlet_id', $outlet_id)
                    ->whereBetween('created_at', [$start, $end])
                    ->whereHas('item_transaksi', function ($query) {
                        $query->whereNotNull('jenis_item_id');
                    })
                    ->where('is_done_cuci', 1)
                    ->groupBy('pelanggan_id')
                    ->detail();

                $data = $query->get();

                $customer = $data->flatMap(function ($customerData) use ($start, $end) {
                    $transactions = Transaksi::where('pelanggan_id', $customerData->pelanggan_id)
                        ->whereBetween('created_at', [$start, $end])
                        ->with(['item_transaksi' => function ($query) {
                            $query->select('transaksi_id', 'qty', 'jenis_item_id');
                        }])
                        ->get();

                    $items = $transactions->flatMap(function ($transaction) {
                        $status = $transaction->grand_total == $transaction->total_terbayar ? 'Lunas' : 'Hutang';

                        return $transaction->item_transaksi->map(function ($item) use ($transaction, $status) {
                            return [
                                'tipe_transaksi' => $transaction->tipe_transaksi,
                                'pelanggan' => $transaction->pelanggan->nama,
                                'quantity' => $item->qty,
                                'transaksi_date' => $transaction->created_at,
                                'nama' => $item->nama,
                                'total_harga' => $transaction->grand_total,
                                'status' => $status,
                                'progres' => $transaction->is_done_cuci ? 'Selesai' : 'Proses'
                            ];
                        });
                    });
                    return $items;
                });

                $filename = 'laporan_cuci_' . date('Y-m-d_H-i-s') . '.xlsx';

                return Excel::download(new LaporanCuciExport($customer->toArray(), $start, $end), $filename);
            }
        }

        if ($pages == 'data-omset') {
            $bulan = $request->input('bulan');
            $transaksi_berhasil = Pembayaran::whereYear('created_at', '=', date('Y', strtotime($bulan)))
                ->with('kasir')
                ->whereMonth('created_at', '=', date('m', strtotime($bulan)))
                ->where('outlet_id', $outlet_id)
                ->with(['transaksi.pelanggan'])
                ->orderBy('created_at')
                ->get();

            // Group pembayaran by date to calculate daily totals
            $groupedPembayaran = $transaksi_berhasil->groupBy(function ($item) {
                return $item->created_at->format('d-m-Y');
            });

            $data = [];

            foreach ($groupedPembayaran as $date => $dayPembayaran) {
                $dailyTotal = 0;

                // Add individual payments for this day
                foreach ($dayPembayaran as $pembayaran) {
                    $data[] = [
                        'Tanggal' => $pembayaran->created_at->format('d-m-Y'),
                        'Kode Transaksi' => $pembayaran->transaksi->kode ?? 'N/A',
                        'Kode Pelanggan' => 'PL' . str_pad($pembayaran->transaksi?->pelanggan?->id, 6, '0', STR_PAD_LEFT),
                        'Nama Pelanggan' => $pembayaran->transaksi?->pelanggan?->nama ?? 'N/A',
                        'Status Transaksi' => $pembayaran->transaksi?->lunas ? 'Lunas' : 'Belum lunas',
                        'Besar Omset' => $pembayaran->nominal,
                        'Operator' => $pembayaran?->kasir?->name,
                        'is_daily_total' => false,
                    ];
                    $dailyTotal += $pembayaran->nominal;
                }

                // Add daily total row
                $data[] = [
                    'Tanggal' => '',
                    'Kode Transaksi' => '',
                    'Kode Pelanggan' => '',
                    'Nama Pelanggan' => 'Total omset per ' . date('d-M-Y', strtotime($date)),
                    'Status Transaksi' => '',
                    'Besar Omset' => $dailyTotal,
                    'Operator' => '',
                    'is_daily_total' => true,
                ];
            }

            $filename = 'laporan_omset_' . date('Y-m-d_H-i-s') . '.xlsx';

            return Excel::download(new LaporanOmsetExport($data), $filename);
        }

        if ($pages == 'data-saldo') {
            $bulan = $request->input('bulan');
            $saldo = Saldo::whereYear('created_at', '=', date('Y', strtotime($bulan)))
                ->whereMonth('created_at', '=', date('m', strtotime($bulan)))
                ->where('outlet_id', $outlet_id)
                ->with(['pelanggan'])
                ->orderBy('created_at')
                ->get();

            $saldoPerMonth = $saldo->groupBy(function ($item) {
                return $item->created_at->format('Y-m');
            })->map(function ($group) {
                return $group->sum('nominal');
            });

            if (in_array('saldoTerbesar', $jenis)) {
                $saldoPerMonth = $saldoPerMonth->sortDesc();
            } elseif (in_array('saldoTerkecil', $jenis)) {
                $saldoPerMonth = $saldoPerMonth->sort();
            }
            $data = $saldo->map(function ($saldos) {
                return [
                    'Membership' => $saldos->pelanggan->member ? 'Member' : 'Bukan Member',
                    'Nama Pelanggan' => $saldos->pelanggan->nama,
                    'Jenis Input' => $saldos->jenis_input,
                    // 'Nominal' => number_format($saldos->nominal, 0, ',', '.'),
                    'Nominal' => $saldos->nominal,
                    'Transaksi Terakhir' =>  date('d-M-Y', strtotime($saldos->created_at)),
                    // 'Saldo Akhir' =>  number_format($saldos->saldo_akhir, 0, ',', '.')
                    'Saldo Akhir' =>  $saldos->saldo_akhir
                ];
            })->toArray();

            $filename = 'laporan_saldo_' . date('Y-m-d_H-i-s') . '.xlsx';

            return Excel::download(new LaporanSaldoExport($data, $bulan), $filename);
        }

        return response()->json(['error' => 'Invalid page type'], 400);
    }

    public function pembeliTermahal(Request $request, $id_pelanggan)
    {
        $user = User::find(auth()->id());
        $permissions = $user->getPermissionsViaRoles();
        $permissionExist = collect($permissions)->first(function ($item) {
            return $item->name === 'Melihat Detail History Pembelian Pelanggan';
        });


        if ($permissionExist) {
            $highestPurchase = Pembayaran::where('pelanggan_id', $id_pelanggan)
                ->orderBy('total', 'desc')
                ->first();

            return view('components.highestPurchase', [
                'status' => 200,
                'purchase' => $highestPurchase,
            ]);
        } else {
            abort(403, 'USER DOES NOT HAVE THE RIGHT PERMISSION');
        }
    }

    public function tablePiutang(Request $request)
    {
        $start = $request->start . ' 00:00:00';
        $end = $request->end . ' 23:59:59';
        $outlet_id = User::getOutletId(Auth::id());

        $withPelanggan = false;
        if (isset($request->name)) {
            $withPelanggan = true;
        }

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

        $total_piutang = Transaksi::with('pelanggan')
            ->where('lunas', false)
            ->whereBetween('created_at', [$start, $end])
            ->when($request->filled('name'), function ($query) use ($request) {
                $query->whereHas('pelanggan', function ($query) use ($request) {
                    $query->where('nama', 'like', '%' . $request->name . '%');
                });
            })
            ->sum(DB::raw('grand_total - total_terbayar'));

        return view('components.tableLaporanPiutang', [
            'pelanggans' => $pelanggans,
            'start' => $start,
            'end' => $end,
            'total_piutang' => $total_piutang,
            'withPelanggan' => $withPelanggan
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
            //list yang pernah ngisi deposit
            'pelanggans' => Pelanggan::whereHas('saldo', function ($query) {
                $query->whereNotNull('saldo_akhir');
            })->orderBy('nama', 'asc')->get(),
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
        $outlet = Outlet::find(Auth::user()->outlet_id);
        $selectedOutlet = -1;
        if (!empty($request->all())) {
            if ($request->has('start') && $request->has('end')) {
                $start = $request->start . ' 00:00:00';
                $end = $request->end . ' 23:59:59';

                $transaksis = Transaksi::whereBetween('created_at', [$start, $end])
                    ->with('kasir')
                    ->where('status', 'confirmed')
                    // jika outlet 0, maka ambil semua outlet, jika tidak maka ambil outlet yang dipilih
                    ->when($request->outlet != 0, function($query) {
                        $query->where('outlet_id', Auth::user()->outlet_id);
                    })
                    ->get();

                $countPerDay = Transaksi::whereBetween('created_at', [$start, $end])
                    ->where('status', 'confirmed')
                    // jika outlet 0, maka ambil semua outlet, jika tidak maka ambil outlet yang dipilih
                    ->when($request->outlet != 0, function($query) {
                        $query->where('outlet_id', Auth::user()->outlet_id);
                    })
                    ->get()
                    ->groupBy(function ($item) {
                        return $item->created_at->format('d-m-Y');
                    })
                    ->map(function ($group) {
                        return count($group);
                    });

                $selectedOutlet = $request->outlet;

                return view('pages.laporan.Omset', [
                    'transaksis' => $transaksis,
                    'rowHeight' => $countPerDay,
                    'outlet' => $outlet,
                    'selectedOutlet' => $selectedOutlet,
                    'start' => $request->start,
                    'end' => $request->end,
                ]);
            }
        }

        return view('pages.laporan.Omset', [
            'outlet' => $outlet,
            'selectedOutlet' => $selectedOutlet,
        ]);
    }

    public function exportOmset(Request $request)
    {
        $outlet = Outlet::find(Auth::user()->outlet_id);
        $selectedOutlet = -1;
        if (!empty($request->all())) {
            if ($request->has('start') && $request->has('end')) {
                $start = $request->start . ' 00:00:00';
                $end = $request->end . ' 23:59:59';

                $transaksis = Transaksi::whereBetween('created_at', [$start, $end])
                    ->with('kasir')
                    ->where('status', 'confirmed')
                    // jika outlet 0, maka ambil semua outlet, jika tidak maka ambil outlet yang dipilih
                    ->when($request->outlet != 0, function($query) {
                        $query->where('outlet_id', Auth::user()->outlet_id);
                    })
                    ->get();

                $countPerDay = Transaksi::whereBetween('created_at', [$start, $end])
                    ->where('status', 'confirmed')
                    // jika outlet 0, maka ambil semua outlet, jika tidak maka ambil outlet yang dipilih
                    ->when($request->outlet != 0, function($query) {
                        $query->where('outlet_id', Auth::user()->outlet_id);
                    })
                    ->get()
                    ->groupBy(function ($item) {
                        return $item->created_at->format('d-m-Y');
                    })
                    ->map(function ($group) {
                        return count($group);
                    });

                $selectedOutlet = $request->outlet;

                // Group transaksi by date to calculate daily totals
                $groupedTransaksi = $transaksis->groupBy(function ($item) {
                    return $item->created_at->format('d-m-Y');
                });

                $data = [];

                foreach ($groupedTransaksi as $date => $dayTransaksi) {
                    $dailyTotal = 0;

                    // Add individual transactions for this day
                    foreach ($dayTransaksi as $transaksi) {
                        $data[] = [
                            'Tanggal' => $transaksi->created_at->format('d-m-Y'),
                            'Kode Transaksi' => $transaksi->kode,
                            'Kode Pelanggan' => 'PL' . str_pad($transaksi->pelanggan?->id, 6, '0', STR_PAD_LEFT),
                            'Nama Pelanggan' => $transaksi->pelanggan?->nama,
                            'Status Transaksi' => $transaksi->lunas ? 'Lunas' : 'Belum lunas',
                            'Besar Omset' => $transaksi->grand_total,
                            'Operator' => $transaksi->kasir?->name,
                            'is_daily_total' => false,
                        ];
                        $dailyTotal += $transaksi->grand_total;
                    }

                    // Add daily total row
                    $data[] = [
                        'Tanggal' => '',
                        'Kode Transaksi' => '',
                        'Kode Pelanggan' => '',
                        'Nama Pelanggan' => 'Total omset per ' . date('d-M-Y', strtotime($date)),
                        'Status Transaksi' => '',
                        'Besar Omset' => $dailyTotal,
                        'Operator' => '',
                        'is_daily_total' => true,
                    ];
                }

                $filename = 'laporan_omset_' . date('Y-m-d_H-i-s') . '.xlsx';

                return Excel::download(new LaporanOmsetExport($data), $filename);
            }
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

            if ($pembayaran->transaksi == null) {
                dd($pembayaran);
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

    public function laporanPengeluaran(Request $request)
    {
        $user = User::find(auth()->id());
        $permissions = $user->getPermissionsViaRoles();
        $permissionExist = collect($permissions)->first(function ($item) {
            return $item->name === 'Melihat Laporan Pengeluaran';
        });
        if ($permissionExist) {
            $query = Pengeluaran::where('outlet_id', Auth::user()->outlet_id);

            // Apply date range filter if provided
            if ($request->has('start') && $request->has('end')) {
                $start = $request->start . ' 00:00:00';
                $end = $request->end . ' 23:59:59';
                $query->whereBetween('created_at', [$start, $end]);
            }

            // Apply search filter if provided
            if ($request->has('search')) {
                $search = '%' . $request->search . '%';
                $query->where(function($q) use ($search) {
                    $q->where('nama', 'like', $search)
                      ->orWhere('deskripsi', 'like', $search);
                });
            }

            return view(
                'pages.laporan.Pengeluaran',
                [
                    'data' => $query->paginate(10),
                    'saldo' => Outlet::where('id', Auth::user()->outlet_id)->first(),
                ]
            );
        } else {
            abort(403, 'USER DOES NOT HAVE THE RIGHT PERMISSION');
        }
    }

    public function exportLaporanPengeluaran(Request $request)
    {
        $user = User::find(auth()->id());
        $permissions = $user->getPermissionsViaRoles();
        $permissionExist = collect($permissions)->first(function ($item) {
            return $item->name === 'Melihat Laporan Pengeluaran';
        });
        if ($permissionExist) {
        $outlet = Outlet::find(Auth::user()->outlet_id);
        $query = Pengeluaran::where('outlet_id', Auth::user()->outlet_id);

        // Apply date range filter if provided
        if ($request->has('start') && $request->has('end')) {
            $start = $request->start . ' 00:00:00';
            $end = $request->end . ' 23:59:59';
            $query->whereBetween('created_at', [$start, $end]);
        }

        // Apply search filter if provided
        if ($request->has('search')) {
            $search = '%' . $request->search . '%';
            $query->where(function($q) use ($search) {
                $q->where('nama', 'like', $search)
                  ->orWhere('deskripsi', 'like', $search);
            });
        }

        $pengeluarans = $query->select('nama', 'deskripsi', 'nominal', 'created_at')
            ->orderBy('created_at', 'desc')
            ->get();

        $filename = 'laporan_pengeluaran_' . $outlet->nama . '_' . date('Y-m-d_H-i-s') . '.xlsx';

        return Excel::download(
            new LaporanPengeluaranExport(
                $pengeluarans->toArray(),
                $request->start ?? null,
                    $request->end ?? null
                ),
                $filename
            );
        } else {
            abort(403, 'USER DOES NOT HAVE THE RIGHT PERMISSION');
        }
    }

    public function exportMutasiDeposit(Request $request)
    {
        $pelanggans = Pelanggan::whereHas('saldo', function ($query) {
            $query->whereNotNull('saldo_akhir');
        })->orderBy('nama', 'asc')->get();

        $filename = 'laporan_mutasi_deposit_' . date('Y-m-d_H-i-s') . '.xlsx';

        return Excel::download(
            new LaporanDepositExport(
                $pelanggans
            ),
            $filename
        );
    }

    public function exportPiutangPelanggan(Request $request)
    {
        $start = $request->start . ' 00:00:00';
        $end = $request->end . ' 23:59:59';
        $outlet_id = User::getOutletId(Auth::id());

        $pelanggans = Pelanggan::with(['transaksi' => function ($query) use ($start, $end, $outlet_id) {
            $query->where('lunas', false)
                ->where('outlet_id', $outlet_id)
                ->whereBetween('created_at', [$start, $end])
                ->whereRaw('(grand_total - total_terbayar) > 0')
                ->orderBy('created_at', 'desc');
        }])
        ->when($request->filled('name'), function ($query) use ($request) {
            $query->where('nama', 'like', '%' . $request->name . '%');
        })
        ->whereHas('transaksi', function ($query) use ($start, $end, $outlet_id) {
            $query->where('lunas', false)
                ->where('outlet_id', $outlet_id)
                ->whereBetween('created_at', [$start, $end])
                ->whereRaw('(grand_total - total_terbayar) > 0');
        })
        ->orderBy('nama')
        ->get();

        // Prepare data for export
        $exportData = [];
        foreach ($pelanggans as $pelanggan) {
            $no = 1;
            $total_tagihan = 0;
            $total_kurang_bayar = 0;
            foreach ($pelanggan->transaksi as $trx) {
                $exportData[] = [
                    'kode_pelanggan' => 'PL' . str_pad($pelanggan->id, 6, '0', STR_PAD_LEFT),
                    'nama' => $pelanggan->nama,
                    'no' => $no++,
                    'kode_transaksi' => $trx->kode,
                    'tanggal_transaksi' => date('d-M-Y H:i:s', strtotime($trx->created_at)),
                    'total_tagihan' => $trx->grand_total,
                    'kurang_bayar' => $trx->grand_total - $trx->total_terbayar,
                    'is_summary' => false,
                ];
                $total_tagihan += $trx->grand_total;
                $total_kurang_bayar += ($trx->grand_total - $trx->total_terbayar);
            }
            // Add summary row
            $exportData[] = [
                'kode_pelanggan' => '',
                'nama' => '',
                'no' => '',
                'kode_transaksi' => 'Total Tagihan',
                'tanggal_transaksi' => '',
                'total_tagihan' => $total_tagihan,
                'kurang_bayar' => $total_kurang_bayar,
                'is_summary' => true,
            ];
        }

        $filename = 'laporan_piutang_pelanggan_' . date('Y-m-d_H-i-s') . '.xlsx';

        return Excel::download(new \App\Exports\LaporanPiutangPelangganExport($exportData), $filename);
    }

    /**
     * Export Kas Masuk
     *
     * note: bilabror 29 may 2025. data yang ditampilkan mengikuti dengan apa yang sudah diimplementasikan pada layar.
     */
    public function exportKasMasuk(Request $request)
    {
        $start = $request->start . ' 00:00:00';
        $end = $request->end . ' 23:59:59';
        $outlet_id = User::getOutletId(Auth::id());

        $tipe = explode(";", $request->jenis);
        array_pop($tipe);

        $data1 = [];
        $data2 = [];
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
            array_push($data1, [
                'tipe_bayar' => strtoupper($pembayaran->metode_pembayaran),
                'kode_pembayaran' => 'PM' . str_pad($pembayaran->id, 6, '0', STR_PAD_LEFT),
                'nomor_order' => $pembayaran->transaksi->kode,
                'tanggal_transaksi' => date('d-M-Y', strtotime($pembayaran->created_at)),
                'pelanggan' => strtoupper($pembayaran->transaksi->pelanggan->nama),
                'nominal' => $pembayaran->nominal,
                'keterangan' => "PEMBAYARAN VIA " . strtoupper($pembayaran->metode_pembayaran),
                'operator' => isset($pembayaran->kasir) ? strtoupper($pembayaran->kasir->name) : '',
            ]);

            $sum += $pembayaran->nominal;
        }

        foreach ($deposits as $deposit) {
            array_push($data2, [
                'tipe_bayar' => strtoupper($deposit->via),
                'kode_pembayaran' => 'DP' . str_pad($deposit->id, 6, '0', STR_PAD_LEFT),
                'nomor_order' => '-',
                'tanggal_transaksi' => date('d-M-Y', strtotime($deposit->created_at)),
                'pelanggan' => strtoupper($deposit->pelanggan->nama),
                'nominal' => $deposit->kas_masuk,
                'keterangan' => "PENGISIAN DEPOSIT VIA " . strtoupper($deposit->via),
                'operator' => isset($deposit->kasir) ? strtoupper($deposit->kasir->name) : '',
            ]);

            $sum += $deposit->kas_masuk;
        }

        $data = array_merge($data1, $data2);

        usort($data, function ($item1, $item2) {
            if ($item1['tipe_bayar'] !== $item2['tipe_bayar']) {
                return $item1['tipe_bayar'] <=> $item2['tipe_bayar'];
            }
            return strtotime($item1['tanggal_transaksi']) <=> strtotime($item2['tanggal_transaksi']);
        });

        $filename = 'laporan_kas_masuk_' . date('Y-m-d_H-i-s') . '.xlsx';

        return Excel::download(new LaporanKasMasukExport($data, $request->start ?? null, $request->end ?? null), $filename);
    }
}
