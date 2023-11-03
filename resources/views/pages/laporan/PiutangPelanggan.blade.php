@extends('layouts.users')

@section('content')

<div class="container">
    <header class="d-flex align-items-center my-3" style="color: var(--bs-gray);"><a>Laporan</a>
        <i class="fas fa-angle-right mx-2"></i>
        <a>Piutang</a>
    </header>
    <section id="data-laporan">
        <div class="card">
            <div class="card-body">
                <div class="card-title d-flex justify-content-between align-items-center">
                    <h4>Piutang Pelanggan</h4>
                    <h5 class="d-flex justify-content-between" style="width: 300px;"><span>Total Piutang:</span><span>Rp {{ number_format($total_piutang, 0, ',', '.') }}</span></h5>
                </div>
                <hr>

                <div id="table-laporan-piutang">
                    <div class="table-responsive my-2 tbody-wrap">
                        <table class="table table-striped mb-0" id="table-table-laporan">
                            <thead>
                                <tr>
                                    <th>Nama Pelanggan</th>
                                    <th>Jumlah Transaksi</th>
                                    <th colspan="2">Besar Piutang</th>
                                    <th>Transaksi Trakhir</th>
                                    <th class="column-action" style="width: 38.25px;"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($pelanggans as $pelanggan)
                                <tr>
                                    <td>{{ $pelanggan['nama'] }}</td>
                                    <td class="text-center">{{ $pelanggan['jumlah_transaksi'] }}</td>
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
