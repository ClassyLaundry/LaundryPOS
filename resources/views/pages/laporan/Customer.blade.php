@extends('layouts.users')

@section('content')
    <div class="container">
        <header class="d-flex align-items-center my-3" style="color: var(--bs-gray);">
            <a>Laporan</a>
            <i class="fas fa-angle-right mx-2"></i>
            <a>Laporan Keseluruhan</a>
        </header>
        <section id="laporan-kas">
            <div class="card">
                <div class="card-body">
                    <div class="card-title d-flex justify-content-between align-items-center">
                        <h4 id="judul-laporan">Laporan Keseluruhan</h4>

                        {{-- <h5 class="d-flex justify-content-between" style="width: 300px;"><span>Total:</span><span
                                id="total-kas_masuk"></span></h5> --}}
                    </div>
                    <hr>


                    <div class="row">
                        <div class="dropdown" id="dropdown-filter">
                            <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButtonFilter"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                Pilih Table
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButtonFilter" style="min-width: 6rem;">
                                <li>
                                    <h6 class="dropdown-header">Search by</h6>
                                </li>
                                <li><a class="dropdown-item filter-search" data-search='data-pelanggan'>Data-Pelanggan</a>
                                <li><a class="dropdown-item filter-search" data-search="data-cuci">Data-Cuci</a></li>
                                <li><a class="dropdown-item filter-search" data-search='data-omset'>Data-Omset</a></li>
                                </li>
                                <li><a class="dropdown-item filter-search" data-search='data-saldo'>Data-Saldo</a></li>
                            </ul>
                        </div>
                        {{--
                        <div class="col-xl-1 col-md-2 col-12 text-end mb-3">
                            <button type="button" class="btn btn-primary" id="btn-apply-filter">Apply</button>
                        </div> --}}
                    </div>
                    <hr class="mt-0">
                    <div class="row">
                        <div class="col-xl-3 col-md-6 col-12 mb-3 tanggal">
                            <div class="d-inline-flex align-items-center">
                                <p class="text-nowrap me-2">Tanggal Awal:</p>
                                <input type="date" class="form-control" name="start" id="input-tanggal-awal">
                            </div>
                        </div>
                        <div class="col-xl-3 col-md-6 col-12 mb-3 tanggal">
                            <div class="d-inline-flex align-items-center">
                                <p class="text-nowrap me-2">Tanggal Akhir:</p>
                                <input type="date" class="form-control" name="end" id="input-tanggal-akhir">
                            </div>
                        </div>
                        <div class="col-xl-3 col-md-6 col-12 mb-3" id="bulan">
                            <div class="d-inline-flex align-items-center">
                                <p class="text-nowrap me-2">Bulan:</p>
                                <input type="month" class="form-control" name="start" id="bulanomset">
                            </div>
                        </div>

                        <div class="col-xl-3 col-md-10 col-12 mb-3" id='button-customer'>
                            <div class="d-inline-flex align-items-center">
                                <p class="text-nowrap me-2">Sort Tipe:</p>
                                <div class="btn-group" role="group">
                                    <input type="radio" class="btn-check" name="filterOption" id="btn-terbanyak"
                                        value="terbanyak" autocomplete="off">
                                    <label class="btn btn-outline-primary" for="btn-terbanyak">Terbanyak</label>

                                    <input type="radio" class="btn-check" name="filterOption" id="btn-termahal"
                                        value="termahal" autocomplete="off">
                                    <label class="btn btn-outline-primary" for="btn-termahal">Termahal</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-md-10 col-12 mb-3" id='button-cuci'>
                            <div class="d-inline-flex align-items-center">
                                <p class="text-nowrap me-2">Tipe :</p>
                                <div class="btn-group" role="group">
                                    <input type="radio" class="btn-check" id="btn-item" name="filterOption"
                                        value="item" autocomplete="off">
                                    <label class="btn btn-outline-primary" for="btn-item">Item Cuci Terbanyak</label>

                                    {{-- <input type="radio" class="btn-check" name="filterOption" value="paket"
                                        id="btn-paket" autocomplete="off">
                                    <label class="btn btn-outline-primary" for="btn-paket">Paket Terbanyak</label> --}}
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-6 col-md-10 col-12 mb-3" id='button-omset'>
                            <div class="d-inline-flex align-items-center">
                                <p class="text-nowrap me-2">Tipe :</p>
                                <div class="btn-group" role="group">
                                    <input type="checkbox" class="btn-check" id="btn-omsetTerbesar" autocomplete="off">
                                    <label class="btn btn-outline-primary" for="btn-omsetTerbesar">Omset terbanyak</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-6 col-md-10 col-12 mb-3" id='button-saldo'>
                            <div class="d-inline-flex align-items-center">
                                <p class="text-nowrap me-2">Tipe :</p>
                                <div class="btn-group" role="group">
                                    <input type="checkbox" class="btn-check" id="btn-saldoTerbesar" autocomplete="off">
                                    <label class="btn btn-outline-primary" for="btn-saldoTerbesar">Saldo terbanyak</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-md-2 col-12 text-end mb-3">
                            <button id="btn-export-excel" class="btn btn-primary w-5">Export Excel</button>
                            <button type="button" class="btn btn-primary" id="btn-apply-filter">Apply</button>
                        </div>
                    </div>
                    <div id="table-container"></div>

                    <ul class="list-unstyled form-control" id="list-action">
                    </ul>
                </div>
            </div>
        </section>
    </div>

    <style>
        .dropdown-item.active,
        .dropdown-item:active {
            color: #fff !important;
            text-decoration: none;
            background-color: #0d6efd;
        }
    </style>
    <script src="{{ asset('js/laporan/customer.js') }}"></script>
@endsection
