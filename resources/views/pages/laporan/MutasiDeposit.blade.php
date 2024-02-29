@extends('layouts.users')

@section('content')
@include('includes.library.datatables')
<div class="container">
    <header class="d-flex align-items-center my-3" style="color: var(--bs-gray);">
        <a>Laporan</a>
        <i class="fas fa-angle-right mx-2"></i>
        <a>Mutasi Deposit</a>
    </header>
    <section id="data-laporan">
        <div class="card">
            <div class="card-body">
                <h4>Laporan Mutasi Deposit</h4>
                <hr>

                <div class="mt-4" id="table-laporan-mutasi_deposit">
                    <div class="table-responsive my-2 tbody-wrap">
                        <table class="table table-striped mb-0" id="table-laporan">
                            <thead>
                                <tr>
                                    <th>Nama Pelanggan</th>
                                    <th>Bergabung Sejak</th>
                                    <th>Transaksi Trakhir</th>
                                    <th>Saldo Pelanggan</th>
                                    <th class="column-action" style="width: 38.25px;"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($pelanggans as $pelanggan)
                                <tr>
                                    <td>{{ strtolower($pelanggan->nama) }}</td>
                                    <td class="text-center">{{ $pelanggan->created_at }}</td>
                                    <td class="text-center">@isset($pelanggan->transaksi_terakhir) {{ $pelanggan->transaksi_terakhir->created_at }} @else - @endisset</td>
                                    <td><div class="d-flex justify-content-between"><span>Rp</span><span>{{ number_format($pelanggan->saldo_akhir, 0, ',', '.') }}</span></div></td>
                                    <td class="cell-action">
                                        <div class="d-flex h-100 align-items-center justify-content-end">
                                            <button id="btn-{{ $pelanggan->id }}" class="btn btn-primary btn-sm btn-show-action" type="button">
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

<script src="{{ asset('js/laporan/mutasiDeposit.js') }}"></script>
@endsection
