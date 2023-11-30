@extends('layouts.users')

@section('content')
<div class="container">
    <header class="my-3" style="color: var(--bs-gray);">
        <a>Transaksi</a>
        <i class="fas fa-angle-right mx-2"></i>
        <a>Pickup &amp; Delivery</a>
    </header>

    <ul role="tablist" class="nav nav-tabs position-relative border-bottom-0">
        <li role="presentation" class="nav-item"><a role="tab" data-bs-toggle="tab" class="nav-link active" href="#tab-1">Data</a></li>
        <li role="presentation" class="nav-item"><a role="tab" data-bs-toggle="tab" class="nav-link" href="#tab-2">Task Hub</a></li>
    </ul>

    <div class="tab-content">

        <div role="tabpanel" class="tab-pane active" id="tab-1">
            <div class="card">
                <div class="card-body">
                    <div id="fitler-tanggal" class="d-flex align-items-center position-absolute" style="top: -38px; right: -1px; height: 38px;">
                        <h6 class="me-2">Tanggal</h6>
                        <input type="week" name="week" class="form-control" id="input-week">
                        <span id="selected-date-range"></span>
                        <button class="btn btn-outline-primary btn-sm ms-2" id="btn-reset" style="display: none;">
                            <i class="fa-solid fa-arrows-rotate"></i>
                        </button>
                    </div>
                    <section id="section-pickup" class="mb-3">
                        <h4>Pickup</h4>
                        <hr />
                        <div id="table-pickup" class="table-container" data-table="pickup"></div>
                        @if(in_array("Membuat Pickup Delivery", Session::get('permissions')) || Session::get('role') == 'administrator')
                        <div class="text-end mt-3">
                            <button id="create-pickup" class="btn btn-primary">Pickup Baru</button>
                        </div>
                        @endif
                    </section>
                    <hr style="margin: 1rem -1rem;" />
                    <section id="section-delivery" class="mb-3">
                        <h4>Delivery</h4>
                        <hr />
                        <div id="table-delivery" class="table-container" data-table="delivery"></div>
                        @if(in_array("Membuat Pickup Delivery", Session::get('permissions')) || Session::get('role') == 'administrator')
                        <div class="text-end mt-3">
                            <button id="create-delivery" class="btn btn-primary">Delivery Baru</button>
                        </div>
                        @endif
                    </section>
                    <hr style="margin: 1rem -1rem;" />
                    <section id="section-ambil-outlet" class="mb-3">
                        <h4>Ambil di outlet</h4>
                        <hr />
                        <div id="table-di-outlet" class="table-container"></div>
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

        <div role="tabpanel" class="tab-pane" id="tab-2">
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
