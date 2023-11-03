@extends('layouts.users')

@section('content')

<div class="container">
    <header class="d-flex align-items-center my-3" style="color: var(--bs-gray);"><a>Laporan</a>
        <i class="fas fa-angle-right mx-2"></i>
        <a>Omset</a>
    </header>
    <section id="data-laporan">
        <div class="card">
            <div class="card-body">
                <h4>Laporan Omset</h4>
                <hr>

                <div class="d-flex justify-content-between align-items-center">
                    <div class="d-flex">
                        <input class="form-control" type="month" name="month" id="input-month" style="max-width: 200px; border-top-right-radius: 0; border-bottom-right-radius: 0;">
                        <button class="btn btn-primary" data-bs-toggle="tooltip" data-bss-tooltip="" id="btn-search" type="button" title="Cari transaksi" style="border-top-left-radius: 0; border-bottom-left-radius: 0;">
                            <i class="fas fa-search" aria-hidden="true"></i>
                        </button>
                    </div>
                    <h5 class="d-flex justify-content-between" style="width: 300px;"><span>Total Omset:</span><span>Rp {{ number_format($total_pembayaran, 0, ',', '.') }}</span></h5>
                </div>

                <div class="mt-4" id="table-laporan-piutang">
                    <div class="table-responsive my-2 tbody-wrap">
                        <table class="table table-striped mb-0" id="table-table-laporan">
                            <thead>
                                <tr>
                                    <th>Pelanggan</th>
                                    <th>Kode Transaksi</th>
                                    <th colspan="2">Besar Piutang</th>
                                    <th>Transaksi Trakhir</th>
                                    <th class="column-action" style="width: 38.25px;"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($pembayaran_this_month as $pembayaran)
                                <tr>
                                    <td>{{ strtolower($pembayaran->transaksi->pelanggan->nama) }}</td>
                                    <td class="text-center">{{ $pembayaran->transaksi->kode }}</td>
                                    <td class="text-start">Rp</td>
                                    <td class="text-end">{{ number_format($pelanggan['piutang'], 0, ',', '.') }}</td>
                                    <td class="text-center">{{ $pelanggan['last_transaction'] }}</td>
                                    <td class="cell-action">
                                        <div class="d-flex h-100 align-items-center justify-content-end">
                                            <button id="btn-{{ $pelanggan['id'] }}" class="btn btn-primary btn-sm btn-show-action" type="button">
                                                <i class="fas fa-bars"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <ul class="list-unstyled form-control" id="list-action">
                    <li id="action-detail">Detail Laporan</li>
                </ul>
            </div>
        </div>
    </section>
</div>

<script src="{{ asset('js/laporan/piutang.js') }}"></script>
@endsection
