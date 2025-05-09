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
                <div class="position-relative">
                    <button type="button" class="btn btn-primary" id="btn-show-filter"><i class="fa-solid fa-filter"></i> Filter</button>
                    <div id="container-filter" class="w-50 border rounded-2 p-3 position-absolute bg-white mt-1" style="display:none;">
                        <form action="/laporan/omset" id="form-filter">
                            <div class="row mb-3">
                                <div class="d-flex align-items-center col-6">
                                    <p class="text-nowrap me-2 fw-bold">Tanggal Awal</p>
                                    <input type="date" class="form-control" name="start" id="input-tanggal-awal" value=@isset($start) {{ $start }} @endisset>
                                </div>
                                <div class="d-flex align-items-center col-6">
                                    <p class="text-nowrap me-2 fw-bold">Tanggal Akhir</p>
                                    <input type="date" class="form-control" name="end" id="input-tanggal-akhir" value=@isset($end) {{ $end }} @endisset>
                                </div>
                            </div>
                            <div class="d-flex justify-content-start">
                                <p class="text-nowrap me-2 fw-bold">Outlet</p>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="outlet" value="0" @if($selectedOutlet == 0) checked @endif>
                                    <label class="form-check-label">Semua</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="outlet" value="{{ $outlet->id }}" @if($selectedOutlet == $outlet->id) checked @endif>
                                    <label class="form-check-label">{{ substr($outlet->nama, 7) }}</label>
                                </div>
                            </div>
                            <div class="d-flex w-100 justify-content-end">
                                <button type="submit" form="form-filter" class="btn btn-primary" id="btn-apply-filter">Apply</button>
                            </div>
                        </form>
                    </div>
                </div>
                <div id="table-container">
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
                                @isset($transaksis)
                                    <tbody>
                                        @php
                                            $date = '';
                                            $dateIndex = 0;
                                            $total = 0;
                                        @endphp
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
                                                        <span>{{ number_format($transaksi->grand_total, 0, ',', '.') }}</span>
                                                    </div>
                                                </td>
                                                <td class="text-center">
                                                    @isset($transaksi->operator)
                                                        {{ $transaksi->kasir->name }}
                                                    @endisset
                                                </td>
                                            </tr>
                                            @php
                                                $dateIndex++;
                                                $total += $transaksi->grand_total;
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
                                @endisset
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<script src="{{ asset('js/laporan/omset.js') }}"></script>
@endsection
