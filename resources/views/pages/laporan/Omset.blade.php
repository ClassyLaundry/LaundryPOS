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
                <div class="card-title d-flex justify-content-between align-items-center">
                    <h4>Laporan Omset</h4>
                    <h5 class="d-flex justify-content-between" style="width: 300px;">
                        <span>Total Omset:</span>
                        <span id="total-omset">
                        @isset($total_omset)
                            {{ 'Rp ' . number_format($totalOmset, 0, ',', '.') }}
                        @endisset
                        </span>
                    </h5>
                </div>
                <hr>

                <div class="row">
                    <div class="col-xl-3 col-md-6 col-12">
                        <div class="d-inline-flex align-items-center">
                            <p class="text-nowrap me-2">Tanggal Awal:</p>
                            <input type="date" class="form-control" name="tanggal_awal" id="input-tanggal-awal" value=@isset($startDate) {{ $startDate }} @endisset>
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-6 col-12">
                        <div class="d-inline-flex align-items-center">
                            <p class="text-nowrap me-2">Tanggal Akhir:</p>
                            <input type="date" class="form-control" name="tanggal_akhir" id="input-tanggal-akhir" value=@isset($endDate) {{ $endDate }} @endisset>
                        </div>
                    </div>
                    <div class="col-xl-3 col-12 text-end offset-xl-3">
                        <button type="button" class="btn btn-primary" id="btn-apply-filter">Apply</button>
                    </div>
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
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $tanggal = '';
                                        $index = 0;
                                        $index2 = -1;
                                    @endphp
                                    @foreach ($pembayarans as $pembayaran)
                                        @dump($pembayaran->transaksi->first()['kode'])

                                        {{-- @php
                                            $transaksi = $pembayaran->transaksi->get()[0];
                                        @endphp
                                        @dump($transaksi->kode) --}}
                                        {{-- @php
                                            if ($tanggal != date('d-M-Y', strtotime($pembayaran->created_at))) {
                                                $tanggal = date('d-M-Y', strtotime($pembayaran->created_at));
                                                $index = 0;
                                                $index2++;
                                            } else {
                                                $index++;
                                            }
                                        @endphp
                                        @if ($index == 0)
                                            <tr>
                                                <td rowspan="{{ $rowHeight[$index2]->count == 1 ? $rowHeight[$index2]->count : $rowHeight[$index2]->count + 1 }}">
                                                    {{ date('d-M-Y', strtotime($pembayaran->created_at)) }}
                                                </td>
                                            @else
                                            <tr>
                                        @endif
                                        <td>{{ $pembayaran->transaksi->get()[0]->kode }}</td>
                                        <td>{{ 'PL' . str_pad($pembayaran->transaksi->get()[0]->pelanggan->id, 6, '0', STR_PAD_LEFT) }}</td>
                                        <td>{{ $pembayaran->transaksi->get()[0]->pelanggan->nama }}</td>
                                        <td>
                                            <div class="d-flex justify-content-between">
                                                <span>Rp</span><span>{{ number_format($pembayaran->nominal, 0, ',', '.') }}</span>
                                            </div>
                                        </td>
                                        </tr>
                                        @if ($rowHeight[$index2]->count == $index + 1 && $index != 0)
                                            <tr class="table-success">
                                                <td colspan="3" class="text-center">
                                                    {{ 'Total omset per ' . date('d-M-Y', strtotime($rowHeight[$index2]->tanggal)) }}</td>
                                                <td>
                                                    <div class="d-flex justify-content-between">
                                                        <span>Rp</span>
                                                        <span>{{ number_format($sumOfEachDate[date('d-M-Y', strtotime($rowHeight[$index2]->tanggal))], 0, ',', '.') }}</span>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endif --}}
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
