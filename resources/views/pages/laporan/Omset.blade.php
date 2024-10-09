@extends('layouts.users')

@section('content')
<div class="container">
    <header class="d-flex align-items-center my-3" style="color: var(--bs-gray);">
        <a>Laporan</a>
        <i class="fas fa-angle-right mx-2"></i>
        <a>Omset</a>
    </header>
    <section id="laporan-omset">
        <div class="card">
            <div class="card-body">
                <div class="card-title">
                    <h4>Laporan Omset</h4>
                </div>
                <hr>
                <div class="row">
                    <div class="col-xl-3 col-md-6 col-12 mb-3">
                        <div class="d-flex align-items-center justify-content-between">
                            <p class="text-nowrap me-2">Tanggal Awal:</p>
                            <input type="date" class="form-control" name="start" id="input-tanggal-awal" style="max-width: 180px;"value=@isset($start) {{ $start }} @endisset>
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-6 col-12 mb-3">
                        <div class="d-flex align-items-center justify-content-between">
                            <p class="text-nowrap me-2">Tanggal Akhir:</p>
                            <input type="date" class="form-control" name="end" id="input-tanggal-akhir" style="max-width: 180px;"value=@isset($end) {{ $end }} @endisset>
                        </div>
                    </div>
                    <div class="offset-xl-4 col-xl-2 col-12 mb-3 text-end">
                        <button type="button" class="btn btn-primary" id="btn-apply-filter">Apply</button>
                    </div>
                </div>
                <hr class="m-0">
                <div id="table-container">
                    @isset($transaksis)
                    <div class="mt-4" id="table-laporan-omset">
                        <div class="table-responsive my-2 tbody-wrap">
                            <table class="table mb-0" id="table-laporan">
                                <thead>
                                    <tr>
                                        <th>Tanggal</th>
                                        <th>Kode Transaksi</th>
                                        <th>Kode Pelanggan</th>
                                        <th>Nama Pelanggan</th>
                                        <th>Besar Omset</th>
                                        <th>Operator</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    {{-- @php
                                        $tanggal = '';
                                        $index = 0;
                                    @endphp
                                    @foreach ($pembayarans as $pembayaran)
                                        @php
                                            if ($tanggal != $pembayaran['tanggal']) {
                                                $tanggal = $pembayaran['tanggal'];
                                                $index = 0;
                                            }
                                        @endphp
                                        @if ($index == 0)
                                            <tr>
                                                <td rowspan="{{ $pembayaran['count'] + 1 }}">{{ $pembayaran['tanggal'] ?? 'null' }}</td>
                                            @else
                                            <tr>
                                        @endif
                                        @foreach ($pembayaran['data'] as $transaksi)
                                            @if ($loop->index > 0)
                                                <tr>
                                            @endif
                                            <td>{{ $transaksi['kode_transaksi'] != 'null' ? $transaksi['kode_transaksi'] : '' }}</td>
                                            <td>{{ 'PL' . str_pad($transaksi['kode_pelanggan'] ?? '0', 6, '0', STR_PAD_LEFT) }}</td>
                                            <td>{{ Str::upper($transaksi['nama_pelanggan']) ?? 'null' }}</td>
                                            <td>
                                                <div class="d-flex justify-content-between">
                                                    <span>Rp</span><span>{{ number_format($transaksi['nominal'], 0, ',', '.') }}</span>
                                                </div>
                                            </td>
                                            @php
                                                $index++;
                                            @endphp
                                        @endforeach
                                        </tr>
                                        @if ($pembayaran['count'] == $index && $index != 0)
                                            <tr class="table-success">
                                                <td colspan="3" class="text-center">
                                                    {{ 'Total omset per ' . date('d-M-Y', strtotime($pembayaran['tanggal'])) }}</td>
                                                <td>
                                                    <div class="d-flex justify-content-between">
                                                        <span>Rp</span>
                                                        <span>{{ number_format($pembayaran['total'], 0, ',', '.') }}</span>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endif
                                    @endforeach --}}
                                    @php
                                        $date = '';
                                        $dateIndex = 0;
                                        $total = 0;
                                    @endphp
                                    {{-- test --}}
                                    @foreach ($transaksis as $transaksi)
                                        @php
                                            if ($date != date('d-m-Y', strtotime($transaksi->created_at))) {
                                                $date = date('d-m-Y', strtotime($transaksi->created_at));
                                                $dateIndex = 0;
                                                $total = 0;
                                            }
                                        @endphp
                                        @if ($dateIndex == 0)
                                            <tr>
                                                <td class="text-center" rowspan="{{ $rowHeight[date('d-m-Y', strtotime($transaksi->created_at))] + 1 }}">{{ date('d-M-Y', strtotime($transaksi->created_at)) }}</td>
                                        @else
                                            <tr>
                                        @endif
                                            <td class="text-center">{{ $transaksi->kode }}</td>
                                            <td class="text-center">{{ 'PL' . str_pad($transaksi->pelanggan->id, 6, '0', STR_PAD_LEFT) }}</td>
                                            <td>{{ $transaksi->pelanggan->nama }}</td>
                                            <td>
                                                <div class="d-flex justify-content-between">
                                                    <span>Rp</span>
                                                    <span>{{ number_format($transaksi->total_terbayar, 0, ',', '.') }}</span>
                                                </div>
                                            </td>
                                            <td class="text-center">
                                                @isset($transaksi->pembayaran[count($transaksi->pembayaran) - 1])
                                                    {{ $transaksi->pembayaran[count($transaksi->pembayaran) - 1]->kasir->name }}
                                                @endisset
                                            </td>
                                        </tr>
                                        @php
                                            $dateIndex++;
                                            $total += $transaksi->total_terbayar;
                                        @endphp
                                        @if ($dateIndex == $rowHeight[date('d-m-Y', strtotime($transaksi->created_at))])
                                            <tr class="table-success fw-bold">
                                                <td colspan="3" class="text-center">{{ 'Total omset per ' . date('d-M-Y', strtotime($transaksi->created_at)) }}</td>
                                                <td>
                                                    <div class="d-flex justify-content-between">
                                                        <span>Rp</span>
                                                        <span>{{ number_format($total, 0, ',', '.') }}</span>
                                                    </div>
                                                </td>
                                                <td></td>
                                            </tr>
                                        @endif
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    @endisset
                </div>
            </div>
        </div>
    </section>
</div>

<script src="{{ asset('js/laporan/omset.js') }}"></script>
@endsection
