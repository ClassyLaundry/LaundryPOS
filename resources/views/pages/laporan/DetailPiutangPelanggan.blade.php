@extends('layouts.users')

@section('content')

<div class="container">
    <header class="d-flex align-items-center my-3" style="color: var(--bs-gray);"><a>Laporan</a>
        <i class="fas fa-angle-right mx-2"></i>
        <a>Piutang</a>
        <i class="fas fa-angle-right mx-2"></i>
        <a>{{ $transaksis[0]->pelanggan->nama }}</a>
    </header>
    <section id="data-laporan">
        <div class="card">
            <div class="card-body">
                <div class="card-title d-flex justify-content-between align-items-center">
                    <h4>Piutang {{ $transaksis[0]->pelanggan->nama }}</h4>
                    <h5 class="d-flex justify-content-between" style="width: 300px;"><span>Total Piutang:</span><span>Rp {{ number_format($total_piutang, 0, ',', '.') }}</span></h5>
                </div>
                <hr>

                <div id="table-laporan-piutang">
                    <div class="table-responsive my-2 tbody-wrap">
                        <table class="table table-striped mb-0" id="table-table-laporan">
                            <thead>
                                <tr>
                                    <th>Kode</th>
                                    <th>Outlet</th>
                                    <th>Tanggal</th>
                                    <th colspan="2">Nominal</th>
                                    <th colspan="2">Piutang</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($transaksis as $transaksi)
                                <tr>
                                    <td>{{ $transaksi->kode }}</td>
                                    <td>{{ $transaksi->outlet->nama }}</td>
                                    <td class="text-center">{{ $transaksi->created_at }}</td>
                                    <td class="text-start">Rp</td>
                                    <td class="text-end">{{ number_format($transaksi->grand_total, 0, ',', '.') }}</td>
                                    <td class="text-start">Rp</td>
                                    <td class="text-end">{{ number_format($transaksi->grand_total - $transaksi->terbayar, 0, ',', '.') }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

@endsection
