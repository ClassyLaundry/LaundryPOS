@extends('layouts.users')

@section('content')

<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.13.2/jquery-ui.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/datalist-css/dist/datalist-css.min.js"></script>


<div class="container">
    <header class="my-3" style="color: var(--bs-gray);">
        <a>Transaksi</a>
        <i class="fas fa-angle-right mx-2"></i>
        <a>Pickup &amp; Delivery</a>
        <i class="fas fa-angle-right mx-2"></i>
        <a>Hub {{ $driver->name }}</a>
    </header>
    <div class="row">
        <div class="col-12 col-lg-6">
            <div class="card p-3">
                <div class="d-flex justify-content-between align-items-center">
                    <h4>Hub yang dikerjakan</h4>
                    <button class="btn btn-sm btn-toggle" style="box-shadow: none;"><i class="fa-solid fa-down-left-and-up-right-to-center"></i></button>
                </div>
                <div class="hub-container">
                    <hr />
                    <div class="hub-list hub-karyawan">
                        @foreach ($on_going_pickups as $pickup)
                            <div class="border rounded mt-3 card-pickup" id="pickup-{{ $pickup->id }}" style="border-bottom: 3px solid rgb(75, 192, 192)!important; background-color: white;">
                                <div class="p-3 border-bottom rounded d-flex justify-content-between align-items-center">
                                    <div id="{{ $pickup->id }}" class="d-flex flex-column">
                                        <h4>
                                            <input class="pelanggan-id" type="hidden" value="{{ $pickup->pelanggan->id }}">
                                            <span class="pelanggan-nama">{{ strtolower($pickup->pelanggan->nama) }}</span>
                                            <svg xmlns="http://www.w3.org/2000/svg" width="1rem" height="1rem" viewBox="0 0 16 16" fill="currentColor" class="bi bi-dot">
                                                <path fill-rule="evenodd" d="M8 9.5a1.5 1.5 0 1 0 0-3 1.5 1.5 0 0 0 0 3z"></path>
                                            </svg>
                                            <span class="text-muted">{{ $pickup->alamat }}</span>
                                        </h4>
                                        <h6>{{ $pickup->kode }}</h6>
                                    </div>
                                    <div class="d-flex h-100">
                                        <div class="position-relative h-100">
                                            <h4 class="fw-bold" style="font-style: italic; margin-right: 2.5rem;">Pickup</h4>
                                            <i class="fa-solid fa-spinner position-absolute top-50 start-0 translate-middle fa-4x" style="font-style: italic; opacity: 0.25;"></i>
                                            <button class="btn btn-sm btn-show-action position-absolute end-0" type="button" style="top: -12px;" id="trans-{{ $pickup->id }}" style="box-shadow: none;">
                                                <i class="fa-solid fa-ellipsis-vertical"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div class="px-3 py-1 pesan-pelanggan font-monospace" style="display: none;">
                                    <h4>{{ $pickup->request }}</h4>
                                </div>
                            </div>
                        @endforeach

                        @foreach ($on_going_deliveries as $delivery)
                            <div class="border rounded mt-3 card-delivery" id="delivery-{{ $delivery->id }}" data-transaksi="{{ $delivery->transaksi_id }}" style="border-bottom: 3px solid rgb(153, 102, 255)!important; background-color: white;">
                                <div class="p-3 border-bottom rounded d-flex justify-content-between align-items-center">
                                    <div id="{{ $delivery->id }}" class="d-flex flex-column">
                                        <h4>
                                            <input class="pelanggan-id" type="hidden" value="{{ $delivery->pelanggan->id }}">
                                            <span class="pelanggan-nama">{{ strtolower($delivery->pelanggan->nama) }}</span>
                                            <svg xmlns="http://www.w3.org/2000/svg" width="1rem" height="1rem" viewBox="0 0 16 16" fill="currentColor" class="bi bi-dot">
                                                <path fill-rule="evenodd" d="M8 9.5a1.5 1.5 0 1 0 0-3 1.5 1.5 0 0 0 0 3z"></path>
                                            </svg>
                                            <span class="text-muted">{{ $delivery->alamat }}</span>
                                        </h4>
                                        <h6>
                                            {{ $delivery->kode }}
                                            <svg xmlns="http://www.w3.org/2000/svg" width=".5rem" height=".5rem" viewBox="0 0 16 16" fill="currentColor" class="bi bi-dot">
                                                <path fill-rule="evenodd" d="M8 9.5a1.5 1.5 0 1 0 0-3 1.5 1.5 0 0 0 0 3z"></path>
                                            </svg>
                                            <span class="text-muted">{{ $delivery->transaksi->kode }}</span>
                                        </h6>
                                    </div>
                                    <div class="position-relative">
                                        <h4 class="fw-bold me-4" style="font-style: italic;">Delivery</h4>
                                        <i class="fa-solid fa-spinner position-absolute top-50 start-0 translate-middle fa-4x" style="font-style: italic; opacity: 0.25;"></i>
                                        <button class="btn btn-sm btn-show-action position-absolute end-0" type="button" style="top: -12px;" id="trans-{{ $delivery->id }}" style="box-shadow: none;">
                                            <i class="fa-solid fa-ellipsis-vertical"></i>
                                        </button>
                                    </div>
                                </div>
                                @if (isset($delivery->transaksi->packing->packing_inventories))
                                <div class="px-3 py-1 border-bottom rounded packing font-monospace">
                                    @php
                                        $packType = [];
                                        for ($i = 0; $i < count($delivery->transaksi->packing->packing_inventories); $i++) {
                                            $packing = $delivery->transaksi->packing->packing_inventories[$i];
                                            $new = true;
                                            foreach ($packType as $temp) {
                                                if ($temp['nama'] == $packing->inventory->nama) {
                                                    $new = false;
                                                }
                                            }
                                            if ($new) {
                                                $packType[$packing->inventory->nama] = 1;
                                            } else {
                                                $packType[$packing->inventory->nama] += $packing->qty;
                                            }
                                        }
                                    @endphp
                                    <h4>
                                        @foreach ($packType as $key => $value)
                                            {{ strtolower($key) . ': ' . $value }}
                                        @endforeach
                                    </h4>
                                </div>
                                @endif
                                <div class="px-3 py-1 pesan-pelanggan border-bottom rounded font-monospace" style="display: none;">
                                    <h4>{{ $delivery->request }}</h4>
                                </div>
                                @if (!$delivery->transaksi->lunas)
                                <div class="px-3 py-1 besar-tagihan font-monospace">
                                    <h4>Tagihan: Rp {{ number_format($delivery->transaksi->grand_total - $delivery->transaksi->total_terbayar, 0, ',', '.') }}</h4>
                                </div>
                                @endif
                            </div>
                        @endforeach
                    </div>

                    <ul class="list-unstyled form-control" id="list-action">
                        @if(in_array("Melihat Detail Transaksi", Session::get('permissions')) || Session::get('role') == 'administrator')
                            <li id="action-detail">Detail Transaksi</li>
                        @endif
                        <li id="action-print-memo">Print Memo</li>
                        <li id="action-pesan">Toggle Pesan</li>
                        @if(in_array("Membuka Halaman Detail Pelanggan", Session::get('permissions')) || Session::get('role') == 'administrator')
                            <li id="action-pelanggan">Detail Pelanggan</li>
                        @endif
                        @if(in_array("Mengganti Status Selesai Pickup Delivery", Session::get('permissions')))
                            <li id="action-change-status">Selesai</li>
                        @endif
                    </ul>
                </div>
            </div>
        </div>

        <div class="col-12 col-lg-6">
            <div class="card p-3">
                <div class="d-flex justify-content-between align-items-center">
                    <h4>Hub sudah selesai</h4>
                    <button class="btn btn-sm btn-toggle" style="box-shadow: none;"><i class="fa-solid fa-down-left-and-up-right-to-center"></i></button>
                </div>
                <div class="hub-container">
                    <hr />
                    <div class="hub-list">
                        @foreach ($is_done_pickups as $pickup)
                            <div class="border rounded mt-3 card-pickup" id="pickup-{{ $pickup->id }}" style="border-bottom: 3px solid rgb(75, 192, 192)!important; background-image: linear-gradient(to bottom right, white, rgb(75, 192, 192, .5)); background-color: white;">
                                <div class="p-3 border-bottom rounded d-flex justify-content-between align-items-center">
                                    <div id="{{ $pickup->id }}" class="d-flex flex-column">
                                        <h4>
                                            <input class="pelanggan-id" type="hidden" value="{{ $pickup->pelanggan->id }}">
                                            <span class="pelanggan-nama">{{ strtolower($pickup->pelanggan->nama) }}</span>
                                            <svg xmlns="http://www.w3.org/2000/svg" width="1rem" height="1rem" viewBox="0 0 16 16" fill="currentColor" class="bi bi-dot">
                                                <path fill-rule="evenodd" d="M8 9.5a1.5 1.5 0 1 0 0-3 1.5 1.5 0 0 0 0 3z"></path>
                                            </svg>
                                            <span class="text-muted">{{ $pickup->alamat }}</span>
                                        </h4>
                                        <h6>{{ $pickup->kode }}</h6>
                                    </div>
                                    <div class="d-flex h-100">
                                        <div class="position-relative h-100">
                                            <h4 class="fw-bold" style="font-style: italic; margin-right: 2.5rem;">Pickup</h4>
                                            <i class="fa-solid fa-flag-checkered position-absolute top-50 start-0 translate-middle fa-4x" style="font-style: italic; opacity: 0.25;"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="px-3 py-1 pesan-pelanggan font-monospace" style="display: none;">
                                    <h4>{{ $pickup->request }}</h4>
                                </div>
                            </div>
                        @endforeach

                        @foreach ($is_done_deliveries as $delivery)
                            <div class="border rounded mt-3 card-delivery" id="delivery-{{ $delivery->id }}" data-transaksi="{{ $delivery->transaksi_id }}" style="border-bottom: 3px solid rgb(153, 102, 255)!important; background-image: linear-gradient(to bottom right, white, rgb(153, 102, 255, .5)); background-color: white;">
                                <div class="p-3 border-bottom rounded d-flex justify-content-between align-items-center">
                                    <div id="{{ $delivery->id }}" class="d-flex flex-column">
                                        <h4>
                                            <input class="pelanggan-id" type="hidden" value="{{ $delivery->pelanggan->id }}">
                                            <span class="pelanggan-nama">{{ $delivery->pelanggan->nama }}</span>
                                            <svg xmlns="http://www.w3.org/2000/svg" width="1rem" height="1rem" viewBox="0 0 16 16" fill="currentColor" class="bi bi-dot">
                                                <path fill-rule="evenodd" d="M8 9.5a1.5 1.5 0 1 0 0-3 1.5 1.5 0 0 0 0 3z"></path>
                                            </svg>
                                            <span class="text-muted">{{ $delivery->alamat }}</span>
                                        </h4>
                                        <h6>
                                            {{ $delivery->kode }}
                                            <svg xmlns="http://www.w3.org/2000/svg" width=".5rem" height=".5rem" viewBox="0 0 16 16" fill="currentColor" class="bi bi-dot">
                                                <path fill-rule="evenodd" d="M8 9.5a1.5 1.5 0 1 0 0-3 1.5 1.5 0 0 0 0 3z"></path>
                                            </svg>
                                            <span class="text-muted">{{ $delivery->transaksi->kode }}</span>
                                        </h6>
                                    </div>
                                    <div class="position-relative">
                                        <h4 class="fw-bold me-4" style="font-style: italic;">Delivery</h4>
                                        <i class="fa-solid fa-flag-checkered position-absolute top-50 start-0 translate-middle fa-4x" style="font-style: italic; opacity: 0.25;"></i>
                                    </div>
                                </div>
                                <div class="px-3 py-1 pesan-pelanggan font-monospace" style="display: none;">
                                    <h4>{{ $delivery->request }}</h4>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div role="dialog" tabindex="-1" class="modal fade" id="modal-transaksi">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Detail Transaksi <span id="kode-transaksi"></span></h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="table-short-trans"></div>
            </div>
            <div class="modal-footer d-flex justify-content-between align-items-center">
                <div>
                    Status Pembayaran: <span id="status-transaksi"></span>
                </div>
                <div class="invisible">
                    Total tagihan: <span id="tagihan-transaksi" class="thousand-separator"></span>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="{{ asset('js/transaksi/pickupDeliveryDriver.js') }}"></script>
@endsection
