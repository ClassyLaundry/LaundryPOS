@extends('layouts.users')

@section('content')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.13.2/jquery-ui.min.js"></script>
<div class="container">
    <header class="my-3" style="color: var(--bs-gray);">
        <a>Proses</a>
        <i class="fas fa-angle-right mx-2"></i>
        <a>Setrika</a>
    </header>

    <ul role="tablist" class="nav nav-tabs border-bottom-0">
        <li role="presentation" class="nav-item"><a role="tab" data-bs-toggle="tab" class="nav-link" href="#tab-1">Staging</a></li>
        <li role="presentation" class="nav-item"><a role="tab" data-bs-toggle="tab" class="nav-link" href="#tab-2">Penyetrika</a></li>
        <li role="presentation" class="nav-item"><a role="tab" data-bs-toggle="tab" class="nav-link" href="#tab-3">Selesai</a></li>
    </ul>

    <div class="tab-content">
        <div class="card beacon">
            <div class="card-body pb-0">
                <div class="staging done">
                    <div class="d-flex align-items-center form-control">
                        <i class="fa-solid fa-magnifying-glass me-2"></i>
                        <input type="search" id="input-search" class="w-100" style="outline: none; border: none;">
                    </div>
                    <hr>
                </div>
                <div role="tabpanel" class="tab-pane" id="tab-1">
                    <div class="list-container" id="hub-staging"></div>
                </div>
                <div role="tabpanel" class="tab-pane" id="tab-2">
                    <div class="list-container" id="hub-penyetrika"></div>
                </div>
                <div role="tabpanel" class="tab-pane" id="tab-3">
                    <div class="list-container" id="hub-done"></div>
                </div>
                <ul class="list-unstyled form-control" id="list-action">
                    <li id="action-detail" class="staging ongoing done">Detail Transaksi</li>
                    <li id="action-takein" class="staging">Ambil</li>
                    <li id="action-cancel" class="ongoing">Kembalikan</li>
                    <li id="action-finish" class="ongoing">Nyatakan Selesai</li>
                </ul>
            </div>
        </div>
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
                    <div class="mt-2">
                        <h5 class="fw-bold">Catatan Pelanggan</h5>
                        <textarea id="text-catatan-pelanggan" class="form-control" readonly></textarea>
                    </div>
                    <div class="mt-2">
                        <h5 class="fw-bold">Catatan Transaksi</h5>
                        <textarea id="text-catatan-transaksi" class="form-control" readonly></textarea>
                    </div>
                    <ul class="list-unstyled form-control list-action" id="list-action-2">
                        <li id="action-notes">Catatan</li>
                        <li id="action-rewash">Rewash</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div role="dialog" tabindex="-1" class="modal fade" id="modal-list-catatan-item">
        <div class="modal-dialog modal-lg modal-dialog-centered modal-fullscreen-sm-down" role="document">
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
                            <div class="col-12 col-lg-4">
                                <div class="mb-2">
                                    <h5>Noted by</h5>
                                    <input type="text" class="form-control" id="penulis-catatan-item" />
                                </div>
                                <div class="h-100">
                                    <h5>Notes</h5>
                                    <textarea class="form-control" id="catatan-item" required style="max-height: 531px;"></textarea>
                                </div>
                            </div>
                            <div class="col-12 col-lg-8">
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
</div>

<script src="{{ asset('js/proses/setrikaProses.js') }}"></script>
@endsection

