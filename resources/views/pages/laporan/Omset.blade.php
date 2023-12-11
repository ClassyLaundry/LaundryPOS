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
                    <h5 class="d-flex justify-content-between" style="width: 300px;"><span>Total Omset:</span><span id="total-omset"></span></h5>
                </div>
                <hr>

                <div class="row">
                    <div class="col-xl-3 col-md-6 col-12">
                        <div class="d-inline-flex align-items-center">
                            <p class="text-nowrap me-2">Tanggal Awal:</p>
                            <input type="date" class="form-control" name="tanggal_awal" id="input-tanggal-awal">
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-6 col-12">
                        <div class="d-inline-flex align-items-center">
                            <p class="text-nowrap me-2">Tanggal Akhir:</p>
                            <input type="date" class="form-control" name="tanggal_akhir" id="input-tanggal-akhir">
                        </div>
                    </div>
                    <div class="col-xl-3 col-12 text-end offset-xl-3">
                        <button type="button" class="btn btn-primary" id="btn-apply-filter">Apply</button>
                    </div>
                </div>
                <hr>

                <div id="table-container"></div>
            </div>
        </div>
    </section>
</div>

<script src="{{ asset('js/laporan/omset.js') }}"></script>
@endsection
