@extends('layouts.users')

@section('content')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.13.2/jquery-ui.min.js"></script>
<div class="container">
    <header class="my-3" style="color: var(--bs-gray);">
        <a>Proses</a>
        <i class="fas fa-angle-right mx-2"></i>
        <a>Setrika</a>
    </header>

    <div class="card">
        <div class="card-body">
            <div class="card-title">
                <div class="d-flex justify-content-between align-items-center">
                    <h4 class="lh-base">Setrika</h4>
                </div>
                <hr />
                <div class="row">
                    <div class="col-lg-4 col-4 order-lg-1 order-1 mb-2">
                        <div class="dropdown" id="dropdown-filter">
                            <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButtonFilter" data-bs-toggle="dropdown" aria-expanded="false">
                                Filter
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButtonFilter" style="min-width: 6rem;">
                                <li><h6 class="dropdown-header">Search By</h6></li>
                                <li><a class="dropdown-item filter-search" data-search='kode'>Kode</a></li>
                                <li><a class="dropdown-item active filter-search" data-search='pelanggan'>Pelanggan</a></li>
                                <li><a class="dropdown-item filter-search" data-search='tipe'>Tipe</a></li>
                                <li><a class="dropdown-item filter-search" data-search='tanggal-buat'>Tanggal Transaksi</a></li>
                                <li><a class="dropdown-item filter-search" data-search='tanggal-selesai'>Tanggal Selesai</a></li>
                                <li><a class="dropdown-item filter-search" data-search='penyetrika'>Penyetrika</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><h6 class="dropdown-header">Paginate</h6></li>
                                <li><a class="dropdown-item active filter-paginate" data-paginate='5'>5 items</a></li>
                                <li><a class="dropdown-item filter-paginate" data-paginate='10'>10 items</a></li>
                                <li><a class="dropdown-item filter-paginate" data-paginate='25'>25 items</a></li>
                                <li><a class="dropdown-item filter-paginate" data-paginate='50'>50 items</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-4 col-12 order-lg-2 order-3 mb-2">
                        <div class="d-flex align-items-center form-control">
                            <i class="fa-solid fa-magnifying-glass me-2"></i>
                            <input type="search" id="input-search" class="w-100" style="outline: none; border: none;">
                        </div>
                    </div>
                </div>
                <div id="table-setrika-admin" class="table-container"></div>
            </div>
        </div>
    </div>
</div>

<script src="{{ asset('js/proses/setrikaAdmin.js') }}"></script>
@endsection

