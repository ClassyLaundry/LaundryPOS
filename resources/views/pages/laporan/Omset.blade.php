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
                <div class="d-flex justify-content-between">
                    <div class="d-inline-flex align-items-center">
                        <p class="text-nowrap me-2">Tanggal:</p>
                        <input type="date" class="form-control" name="tanggal" id="input-tanggal" value=@isset($date) {{ $date }} @endisset>
                    </div>
                    <button type="button" class="btn btn-primary" id="btn-apply-filter">Apply</button>
                </div>
                <hr>
                <div id="table-container">
                    @isset($pembayarans)
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
                                    @foreach ($pembayarans as $pembayaran)
                                        @php
                                            if ($date != date('d-m-Y', strtotime($pembayaran->created_at))) {
                                                $date = date('d-m-Y', strtotime($pembayaran->created_at));
                                                $dateIndex = 0;
                                                $total = 0;
                                            }
                                        @endphp
                                        @if ($dateIndex == 0)
                                            <tr>
                                                <td class="text-center" rowspan="{{ $rowHeight[date('d-m-Y', strtotime($pembayaran->created_at))] + 1 }}">{{ date('d-M-Y', strtotime($pembayaran->created_at)) }}</td>
                                        @else
                                            <tr>
                                        @endif
                                            <td class="text-center">{{ $pembayaran->transaksi->kode }}</td>
                                            <td class="text-center">{{ 'PL' . str_pad($pembayaran->transaksi->pelanggan->id, 6, '0', STR_PAD_LEFT) }}</td>
                                            <td>{{ $pembayaran->transaksi->pelanggan->nama }}</td>
                                            <td>
                                                <div class="d-flex justify-content-between">
                                                    <span>Rp</span>
                                                    <span>{{ number_format($pembayaran->nominal, 0, ',', '.') }}</span>
                                                </div>
                                            </td>
                                            <td class="text-center">{{ $pembayaran->kasir->name }}</td>
                                        </tr>
                                        @php
                                            $dateIndex++;
                                            $total += $pembayaran->nominal;
                                        @endphp
                                        @if ($dateIndex == $rowHeight[date('d-m-Y', strtotime($pembayaran->created_at))])
                                            <tr class="table-success fw-bold">
                                                <td colspan="3" class="text-center">{{ 'Total omset per ' . date('d-M-Y', strtotime($pembayaran->created_at)) }}</td>
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
