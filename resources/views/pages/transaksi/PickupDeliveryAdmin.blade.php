@extends('layouts.users')

@section('content')
<div class="container">
    <header class="my-3" style="color: var(--bs-gray);">
        <a>Transaksi</a>
        <i class="fas fa-angle-right mx-2"></i>
        <a>Pickup &amp; Delivery</a>
    </header>

    <ul role="tablist" class="nav nav-tabs position-relative border-bottom-0" id="tab-pickup_delivery">
        <li role="presentation" class="nav-item"><a role="tab" data-bs-toggle="tab" class="nav-link @if(session('last_tab') == 'Pickup') active @endif" href="#tab-1">Pickup</a></li>
        <li role="presentation" class="nav-item"><a role="tab" data-bs-toggle="tab" class="nav-link @if(session('last_tab') == 'Delivery') active @endif" href="#tab-2">Delivery</a></li>
        <li role="presentation" class="nav-item"><a role="tab" data-bs-toggle="tab" class="nav-link @if(session('last_tab') == 'Outlet') active @endif" href="#tab-3">Outlet</a></li>
        <li role="presentation" class="nav-item"><a role="tab" data-bs-toggle="tab" class="nav-link @if(session('last_tab') == 'Task Hub') active @endif" href="#tab-4">Task Hub</a></li>
    </ul>
    {{-- @dd(session('last_tab')) --}}
    <div class="tab-content">
        <div role="tabpanel" class="tab-pane @if(session('last_tab') == 'Pickup') active @endif" id="tab-1">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <h4 class="lh-base">Pickup</h4>
                        @if(in_array("Membuat Pickup Delivery", Session::get('permissions')) || Session::get('role') == 'administrator')
                            <button id="create-pickup" class="btn btn-primary">Pickup Baru</button>
                        @endif
                    </div>
                    <hr />
                    <section id="section-pickup">
                        <div class="row">
                            <div class="col-lg-4 col-4 order-lg-1 order-1 mb-2">
                                <div class="dropdown" id="dropdown-filter">
                                    <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButtonFilter" data-bs-toggle="dropdown" aria-expanded="false">
                                        Filter
                                    </button>
                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButtonFilter" style="min-width: 6rem;">
                                        <li><h6 class="dropdown-header">Search By</h6></li>
                                        <li><a class="dropdown-item active filter-search" data-search='pelanggan'>Pelanggan</a></li>
                                        <li><a class="dropdown-item filter-search" data-search='driver'>Driver</a></li>
                                        <li><a class="dropdown-item filter-search" data-search='alamat'>Alamat</a></li>
                                        <li><a class="dropdown-item filter-search" data-search='status'>Status</a></li>
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
                                    <input type="search" id="input-search-pickup" class="w-100" style="outline: none; border: none;">
                                </div>
                            </div>
                            <div class="col-lg-4 col-8 order-lg-3 order-2 mb-2 text-end">
                                <div class="d-inline-flex align-items-center">
                                    <h6 class="me-2">Tanggal</h6>
                                    <input type="month" name="month" class="form-control input-month" id="input-pickup-month">
                                </div>
                            </div>
                        </div>
                        <div id="table-pickup" class="table-container" data-table="pickup"></div>
                    </section>
                </div>
                <ul class="list-unstyled form-control" id="list-action">
                    @if(in_array("Mengubah Data Pickup Delivery", Session::get('permissions')) || Session::get('role') == 'administrator')
                        <li id="action-update">Update</li>
                    @endif
                    <li id="action-delete">Cancel</li>
                </ul>
            </div>
        </div>

        <div role="tabpanel" class="tab-pane @if(session('last_tab') == 'Delivery') active @endif" id="tab-2">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <h4 class="lh-base">Delivery</h4>
                        @if(in_array("Membuat Pickup Delivery", Session::get('permissions')) || Session::get('role') == 'administrator')
                        <button id="create-delivery" class="btn btn-primary">Delivery Baru</button>
                        @endif
                    </div>
                    <hr />
                    <section id="section-delivery">
                        <div class="row">
                            <div class="col-lg-4 col-4 order-lg-1 order-1 mb-2">
                                <div class="dropdown" id="dropdown-filter">
                                    <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButtonFilter" data-bs-toggle="dropdown" aria-expanded="false">
                                        Filter
                                    </button>
                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButtonFilter" style="min-width: 6rem;">
                                        <li><h6 class="dropdown-header">Search By</h6></li>
                                        <li><a class="dropdown-item active filter-search" data-search='pelanggan'>Pelanggan</a></li>
                                        <li><a class="dropdown-item filter-search" data-search='driver'>Driver</a></li>
                                        <li><a class="dropdown-item filter-search" data-search='alamat'>Alamat</a></li>
                                        <li><a class="dropdown-item filter-search" data-search='status'>Status</a></li>
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
                                    <input type="search" id="input-search-delivery" class="w-100" style="outline: none; border: none;">
                                </div>
                            </div>
                            <div class="col-lg-4 col-8 order-lg-3 order-2 mb-2 text-end">
                                <div class="d-inline-flex align-items-center">
                                    <h6 class="me-2">Tanggal</h6>
                                    <input type="month" name="month" class="form-control input-month" id="input-delivery-month">
                                </div>
                            </div>
                        </div>
                        <div id="table-delivery" class="table-container" data-table="delivery"></div>
                    </section>
                </div>
            </div>
        </div>

        <div role="tabpanel" class="tab-pane @if(session('last_tab') == 'Outlet') active @endif" id="tab-3">
            <div class="card">
                <div class="card-body">
                    <h4 class="lh-base">Ambil di outlet</h4>
                    <hr />
                    <section id="section-ambil-outlet">
                        <div class="row">
                            <div class="col-lg-4 col-4 order-lg-1 order-1 mb-2">
                                <div class="dropdown" id="dropdown-filter">
                                    <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButtonFilter" data-bs-toggle="dropdown" aria-expanded="false">
                                        Filter
                                    </button>
                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButtonFilter" style="min-width: 6rem;">
                                        <li><h6 class="dropdown-header">Search By</h6></li>
                                        <li><a class="dropdown-item active filter-search" data-search='pelanggan'>Pelanggan</a></li>
                                        <li><a class="dropdown-item filter-search" data-search='penerima'>Penerima</a></li>
                                        <li><a class="dropdown-item filter-search" data-search='outlet'>Outlet</a></li>
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
                                    <input type="search" id="input-search-outlet" class="w-100" style="outline: none; border: none;">
                                </div>
                            </div>
                            <div class="col-lg-4 col-8 order-lg-3 order-2 mb-2 text-end">
                                <div class="d-inline-flex align-items-center">
                                    <h6 class="me-2">Tanggal</h6>
                                    <input type="month" name="month" class="form-control input-month" id="input-outlet-month">
                                </div>
                            </div>
                        </div>
                        <div id="table-di-outlet" class="table-container"></div>
                    </section>
                </div>
            </div>
        </div>

        <div role="tabpanel" class="tab-pane @if(session('last_tab') == 'Task Hub') active @endif" id="tab-4">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        @foreach ($drivers as $driver)
                        <div class="col-6 mb-4">
                            <div class="border rounded p-3">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h4>Hub {{ $driver->name }}</h4>
                                    <button class="btn btn-sm btn-toggle" style="box-shadow: none;"><i class="fa-solid fa-down-left-and-up-right-to-center"></i></button>
                                </div>
                                <div class="hub-container">
                                    <hr />
                                    <div class="hub-list">
                                        @foreach ($pickups as $pickup)
                                            @if($driver->id == $pickup->driver_id)
                                                <div class="p-3 border rounded d-flex justify-content-between align-items-center mt-3"
                                                    @if ($pickup->is_done)
                                                        style="border-bottom: 3px solid rgb(75, 192, 192)!important; background-image: linear-gradient(to bottom right, white, rgb(75, 192, 192, .5));"
                                                    @else
                                                        style="border-bottom: 3px solid rgb(75, 192, 192)!important;"
                                                    @endif
                                                >
                                                    <div id="{{ $pickup->id }}" class="d-flex flex-column">
                                                        <h4>
                                                            <span>{{ $pickup->pelanggan->nama }}</span>
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="1rem" height="1rem" viewBox="0 0 16 16" fill="currentColor" class="bi bi-dot">
                                                                <path fill-rule="evenodd" d="M8 9.5a1.5 1.5 0 1 0 0-3 1.5 1.5 0 0 0 0 3z"></path>
                                                            </svg>
                                                            <span class="text-muted">{{ $pickup->alamat }}</span>
                                                        </h4>
                                                        <h6>{{ $pickup->kode }}</h6>
                                                    </div>
                                                    <div class="position-relative">
                                                        <h4 class="fw-bold" style="font-style: italic;">Pickup</h4>
                                                        @if ($pickup->is_done)
                                                            <i class="fa-solid fa-flag-checkered position-absolute top-50 start-0 translate-middle fa-4x" style="font-style: italic; opacity: 0.25;"></i>
                                                        @else
                                                            <i class="fa-solid fa-spinner position-absolute top-50 start-0 translate-middle fa-4x" style="font-style: italic; opacity: 0.25;"></i>
                                                        @endif
                                                    </div>
                                                </div>
                                            @endif
                                        @endforeach

                                        @foreach ($deliveries as $delivery)
                                            @if($driver->id == $delivery->driver_id)
                                                <div class="p-3 border rounded d-flex justify-content-between align-items-center mt-3"
                                                    @if ($delivery->is_done)
                                                        style="border-bottom: 3px solid rgb(153, 102, 255)!important; background-image: linear-gradient(to bottom right, white, rgb(153, 102, 255, .5));"
                                                    @else
                                                        style="border-bottom: 3px solid rgb(153, 102, 255)!important;"
                                                    @endif
                                                >
                                                    <div id="{{ $delivery->id }}" class="d-flex flex-column">
                                                        <h4>
                                                            <span>{{ $delivery->pelanggan->nama }}</span>
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="1rem" height="1rem" viewBox="0 0 16 16" fill="currentColor" class="bi bi-dot">
                                                                <path fill-rule="evenodd" d="M8 9.5a1.5 1.5 0 1 0 0-3 1.5 1.5 0 0 0 0 3z"></path>
                                                            </svg>
                                                            <span class="text-muted">{{ $delivery->alamat }}</span>
                                                        </h4>
                                                        <h6>{{ $delivery->kode }}</h6>
                                                    </div>
                                                    <div class="position-relative">
                                                        {{-- background-image: linear-gradient(to bottom right, red, yellow); --}}
                                                        <h4 class="fw-bold" style="font-style: italic;">Delivery</h4>
                                                        @if ($delivery->is_done)
                                                            <i class="fa-solid fa-flag-checkered position-absolute top-50 start-0 translate-middle fa-4x" style="font-style: italic; opacity: 0.25;"></i>
                                                        @else
                                                            <i class="fa-solid fa-spinner position-absolute top-50 start-0 translate-middle fa-4x" style="font-style: italic; opacity: 0.25;"></i>
                                                        @endif
                                                    </div>
                                                </div>
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div role="dialog" tabindex="-1" class="modal fade" id="modal-create-pickup">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Create Pickup</h4><button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="/transaksi/pickup-delivery" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-6 mb-2">
                            <h5>Pilih Pelanggan</h5>
                            <input id="input-pickup-pelanggan" list="data-pelanggan" class="form-control" type="text" autocomplete="off" required>
                            <input id="input-pickup-pelanggan-id" type="hidden" name="pelanggan_id" value="">
                        </div>
                        <div class="col-6 mb-2">
                            <h5>Pilih Driver</h5>
                            <select class="form-control" name="driver_id" required >
                                <option value="" selected hidden>-</option>
                                @foreach ($drivers as $driver)
                                    <option value="{{ $driver->id }}">{{ $driver->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-12 mb-2">
                            <h5>Alamat</h5>
                            <input id="input-pickup-alamat" type="text" class="form-control" name="alamat" required />
                        </div>
                        <div class="col-12 mb-2">
                            <h5>Pesan Pelanggan</h5>
                            <textarea class="form-control" name="request"></textarea>
                        </div>
                    </div>
                </div>
                <input type="hidden" name="action" value="pickup">
                <div class="modal-footer">
                    <button class="btn btn-primary" type="submit">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" role="dialog" tabindex="-1" id="modal-data-pelanggan">
    <div class="modal-dialog modal-xl modal-dialog-centered modal-fullscreen-sm-down" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Pelanggan</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <input class="form-control mb-3" type="search" id="input-nama-pelanggan" placeholder="Cari nama pelanggan">
                <div id="table-pelanggan"></div>
            </div>
        </div>
    </div>
</div>

<div role="dialog" tabindex="-1" class="modal fade" id="modal-create-delivery">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Create Delivery</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="/transaksi/pickup-delivery" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-6 mb-2" id="col-transaksi">
                            <h5>Pilih Transaksi</h5>
                            <input type="text" id="input-delivery-kode" class="form-control">
                        </div>
                        <div class="col-6 mb-2">
                            <h5>Pilih Driver</h5>
                            <select class="form-control" name="driver_id" required >
                                <option value="" selected hidden>-</option>
                                @foreach ($drivers as $driver)
                                    <option value="{{ $driver->id }}">{{ $driver->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-12 mb-2">
                            <h5>Nama Pelanggan</h5>
                            <input id="input-delivery-nama" type="text" class="form-control" required />
                        </div>
                        <div class="col-12 mb-2">
                            <h5>Alamat</h5>
                            <input id="input-delivery-alamat" type="text" class="form-control" name="alamat" required />
                        </div>
                        <div class="col-12 mb-2">
                            <h5>Pesan Pelanggan</h5>
                            <textarea class="form-control" name="request"></textarea>
                        </div>
                    </div>
                </div>
                <input type="hidden" name="action" value="delivery">
                <input type="hidden" name="transaksi_id" id="input-delivery-transaksi-id">
                <div class="modal-footer">
                    <button class="btn btn-primary" type="submit">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" role="dialog" tabindex="-1" id="modal-opsi-trans">
    <div class="modal-dialog modal-xl modal-dialog-centered modal-fullscreen-sm-down" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Opsi Transaksi</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" style="min-height: 450px;">
                <input class="form-control" type="search" id="input-key-trans" placeholder="Kata kunci">
                @if(in_array("Melihat Detail Transaksi", Session::get('permissions')) || Session::get('role') == 'administrator')
                    <div id="container-list-trans"></div>
                @endif
            </div>
        </div>
    </div>
</div>

<script src="{{ asset('js/transaksi/pickupDeliveryAdmin.js') }}"></script>
@endsection
