@extends('layouts.users')

@section('content')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.13.2/jquery-ui.min.js"></script>
<div class="container">
    <header class="my-3" style="color: var(--bs-gray);">
        <a>Proses</a>
        <i class="fas fa-angle-right mx-2"></i>
        <a>Cuci</a>
    </header>
    <section id="proses-cuci">
        <div id="hub" class="row card d-flex flex-row position-relative border-0">

            <div class="col-12 col-xl-4 col-lg-6 mb-4">
                <div class="p-3 border rounded" style="border: 1px solid rgba(0,0,0,.125);">
                    <h4>Hub Staging Cuci</h4>
                    <hr />
                    <div class="hub-list hub-staging">
                        @foreach ($transaksi_staging as $staging)
                            <div class="border rounded mt-3 item" style="border-bottom: 3px solid rgb(54, 162, 235)!important; background-color: white;">
                                <div class="p-3 border-bottom rounded d-flex justify-content-between align-items-center">
                                    <div class="d-flex flex-column">
                                        <h4>{{ $staging->kode }}</h4>
                                        <h6>
                                            <span class="text-muted">{{ date('d-m-Y', strtotime($staging->created_at)) }}</span>
                                            <svg xmlns="http://www.w3.org/2000/svg" width="1rem" height="1rem" viewBox="0 0 16 16" fill="currentColor" class="bi bi-dot">
                                                <path fill-rule="evenodd" d="M8 9.5a1.5 1.5 0 1 0 0-3 1.5 1.5 0 0 0 0 3z"></path>
                                            </svg>
                                            <span class="fw-bold">{{ date('d-m-Y', strtotime($staging->done_date)) }}</span>
                                        </h6>
                                    </div>
                                    <div class="position-relative">
                                        <h4 class="fw-bold me-4" style="font-style: italic;">Process</h4>
                                        <i class="fa-solid fa-spinner position-absolute top-50 start-0 translate-middle fa-4x" style="font-style: italic; opacity: 0.25;"></i>
                                        <button class="btn btn-sm btn-show-action position-absolute end-0" type="button" style="top: -12px;" id="trans-{{ $staging->id }}" style="box-shadow: none;">
                                            <i class="fa-solid fa-ellipsis-vertical"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="px-3 py-1 pesan-pelanggan font-monospace" style="display: none;">
                                    @isset($staging->pelanggan->catatan_pelanggan->catatan_khusus)
                                    <h5 class="fw-bold">{{ $staging->pelanggan->catatan_pelanggan->catatan_khusus }}</h5>
                                    @endisset
                                    <h5>{{ $staging->catatan }}</h5>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="col-12 col-xl-4 col-lg-6 mb-4">
                <div class="p-3 border rounded" style="border: 1px solid rgba(0,0,0,.125);">
                    <h4>Hub Pencuci</h4>
                    <hr />
                    <div class="hub-list hub-karyawan">
                        @foreach ($transaksi_pencuci as $hub_pencuci)
                            <div class="border rounded mt-3 item" style="border-bottom: 3px solid rgb(54, 162, 235)!important; background-color: white;">
                                <div class="p-3 border-bottom rounded d-flex justify-content-between align-items-center">
                                    <div class="d-flex flex-column">
                                        <h4>{{ $hub_pencuci->kode }}</h4>
                                        <h6>
                                            <span class="text-muted">{{ date('d-m-Y', strtotime($hub_pencuci->created_at)) }}</span>
                                            <svg xmlns="http://www.w3.org/2000/svg" width="1rem" height="1rem" viewBox="0 0 16 16" fill="currentColor" class="bi bi-dot">
                                                <path fill-rule="evenodd" d="M8 9.5a1.5 1.5 0 1 0 0-3 1.5 1.5 0 0 0 0 3z"></path>
                                            </svg>
                                            <span class="fw-bold">{{ date('d-m-Y', strtotime($hub_pencuci->done_date)) }}</span>
                                        </h6>
                                    </div>
                                    <div class="position-relative">
                                        <h4 class="fw-bold me-4" style="font-style: italic;">Process</h4>
                                        <i class="fa-solid fa-spinner position-absolute top-50 start-0 translate-middle fa-4x" style="font-style: italic; opacity: 0.25;"></i>
                                        <button class="btn btn-sm btn-show-action position-absolute end-0" type="button" style="top: -12px;" id="trans-{{ $hub_pencuci->id }}" style="box-shadow: none;">
                                            <i class="fa-solid fa-ellipsis-vertical"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="px-3 py-1 pesan-pelanggan font-monospace" style="display: none;">
                                    @isset($hub_pencuci->pelanggan->catatan_pelanggan->catatan_khusus)
                                    <h5 class="fw-bold">{{ $hub_pencuci->pelanggan->catatan_pelanggan->catatan_khusus }}</h5>
                                    @endisset
                                    <h5>{{ $hub_pencuci->catatan }}</h5>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="col-12 col-xl-4 col-lg-6 mb-4">
                <div class="p-3 border rounded" style="border: 1px solid rgba(0,0,0,.125);">
                    <h4>Hub Selesai</h4>
                    <hr />
                    <div class="hub-list">
                        @foreach ($transaksi_done_cuci as $done_cuci)
                            <div class="border rounded mt-3" style="border-bottom: 3px solid rgb(54, 162, 235)!important; background-image: linear-gradient(to bottom right, white, rgb(54, 162, 235, .5)); background-color: white;">
                                <div class="p-3 border-bottom rounded d-flex justify-content-between align-items-center">
                                    <div class="d-flex flex-column">
                                        <h4>{{ $done_cuci->kode }}</h4>
                                        <h6>
                                            <span class="text-muted">{{ date('d-m-Y', strtotime($done_cuci->created_at)) }}</span>
                                            <svg xmlns="http://www.w3.org/2000/svg" width="1rem" height="1rem" viewBox="0 0 16 16" fill="currentColor" class="bi bi-dot">
                                                <path fill-rule="evenodd" d="M8 9.5a1.5 1.5 0 1 0 0-3 1.5 1.5 0 0 0 0 3z"></path>
                                            </svg>
                                            <span class="fw-bold">{{ date('d-m-Y', strtotime($done_cuci->done_date)) }}</span>
                                        </h6>
                                    </div>
                                    <div class="position-relative">
                                        <h4 class="fw-bold me-4" style="font-style: italic;">Done</h4>
                                        <i class="fa-solid fa-flag-checkered position-absolute top-50 start-0 translate-middle fa-4x" style="font-style: italic; opacity: 0.25;"></i>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <ul class="list-unstyled form-control" id="list-action">
                <li id="action-add">Tambahkan</li>
                <li id="action-remove">Kembalikan</li>
                <li id="action-detail">Detail</li>
                <li id="action-pesan">Toggle Pesan</li>
                <li id="action-done">Selesai</li>
            </ul>
        </div>

        <div class="modal fade" role="dialog" tabindex="-1" id="modal-detail">
            <div class="modal-dialog modal-lg modal-dialog-centered modal-fullscreen-lg-down" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Detail Transaksi</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p>Parfum: <span id="nama-parfum" class="fw-bold"></span></p>
                        <div id="table-short-trans"></div>
                        <ul class="list-unstyled form-control list-action" id="list-action-2">
                            <li id="action-notes">Catatan</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <div role="dialog" tabindex="-1" class="modal fade" id="modal-list-catatan-item">
            <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Catatan Item</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body position-relative">
                        <div id="table-catatan-item"></div>
                        <ul class="list-unstyled form-control list-action" id="list-action-3">
                            <li id="action-detail-note">Detail Catatan</li>
                            <li id="action-delete-note">Hapus Catatan</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <div role="dialog" tabindex="-1" class="modal fade" id="modal-catatan-item">
            <div class="modal-dialog modal-lg modal-dialog-centered modal-fullscreen-sm-down" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Catatan Item <span id="catatan-item-name">nama item</span></h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form id="form-catatan">
                        <div class="modal-body">
                            <div class="row">
                                <div class="col col-lg-4">
                                    <div class="mb-2">
                                        <h5>Noted by</h5>
                                        <input type="text" class="form-control" id="penulis-catatan-item" />
                                    </div>
                                    <div class="h-100">
                                        <h5>Notes</h5>
                                        <textarea class="form-control" id="catatan-item" required style="max-height: 531px;"></textarea>
                                    </div>
                                </div>
                                <div class="col col-lg-8">
                                    <div class="position-relative border rounded mb-2">
                                        <div id="container-image-item" class="carousel carousel-dark slide" data-bs-interval="false">
                                            <div class="carousel-inner">
                                                <div class="carousel-item active">
                                                    <img class="d-block w-100" style="object-fit: scale-down; max-height: 450px; height: 450px;">
                                                </div>
                                            </div>
                                            <button class="carousel-control-prev" type="button" data-bs-target="#container-image-item" data-bs-slide="prev">
                                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                                <span class="visually-hidden">Previous</span>
                                            </button>
                                            <button class="carousel-control-next" type="button" data-bs-target="#container-image-item" data-bs-slide="next">
                                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                                <span class="visually-hidden">Next</span>
                                            </button>
                                          </div>
                                    </div>
                                    <div class="text-end">
                                        <input type="file" class="form-control" id="input-foto-item" accept="image/*" name="files[]" multiple required />
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-primary" type="button" id="simpan-catatan-item">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </section>
</div>

<script src="{{ asset('js/proses/cuci.js') }}"></script>
@endsection

