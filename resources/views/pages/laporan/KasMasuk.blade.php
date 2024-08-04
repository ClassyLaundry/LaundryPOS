@extends('layouts.users')

@section('content')

<div class="container">
    <header class="d-flex align-items-center my-3" style="color: var(--bs-gray);">
        <a>Laporan</a>
        <i class="fas fa-angle-right mx-2"></i>
        <a>Kas Masuk</a>
    </header>
    <section id="laporan-kas">
        <div class="card">
            <div class="card-body">
                <div class="card-title d-flex justify-content-between align-items-center">
                    <h4>Laporan Kas Masuk</h4>
                    <h5 class="d-flex justify-content-between" style="width: 300px;"><span>Total Kas Masuk:</span><span id="total-kas_masuk"></span></h5>
                </div>
                <hr>

                <div class="row">
                    <div class="col-xl-3 col-md-6 col-12 mb-3">
                        <div class="d-inline-flex align-items-center">
                            <p class="text-nowrap me-2">Tanggal Awal:</p>
                            <input type="date" class="form-control" name="start" id="input-tanggal-awal">
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-6 col-12 mb-3">
                        <div class="d-inline-flex align-items-center">
                            <p class="text-nowrap me-2">Tanggal Akhir:</p>
                            <input type="date" class="form-control" name="end" id="input-tanggal-akhir">
                        </div>
                    </div>
                    <div class="col-xl-5 col-md-10 col-12 mb-3">
                        <div class="d-inline-flex align-items-center">
                            <p class="text-nowrap me-2">Tipe Bayar:</p>
                            <div class="btn-group" role="group">
                                <input type="checkbox" class="btn-check" id="btn-cash" autocomplete="off">
                                <label class="btn btn-outline-primary" for="btn-cash">Cash</label>

                                <input type="checkbox" class="btn-check" id="btn-qris" autocomplete="off">
                                <label class="btn btn-outline-primary" for="btn-qris">Qris</label>

                                <input type="checkbox" class="btn-check" id="btn-debit" autocomplete="off">
                                <label class="btn btn-outline-primary" for="btn-debit">Debit</label>

                                <input type="checkbox" class="btn-check" id="btn-transfer" autocomplete="off">
                                <label class="btn btn-outline-primary" for="btn-transfer">Transfer</label>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-1 col-md-2 col-12 text-end mb-3">
                        <button type="button" class="btn btn-primary" id="btn-apply-filter">Apply</button>
                    </div>
                </div>
                <hr class="mt-0">

                <div id="table-container"></div>

                <ul class="list-unstyled form-control" id="list-action">
                    <li id="action-detail">Detail Laporan</li>
                </ul>
            </div>
        </div>
    </section>
</div>

<script src="{{ asset('js/laporan/kasMasuk.js') }}"></script>
@endsection
