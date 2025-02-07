@extends('layouts.users')

@section('content')
@include('includes.library.datatables')
<div class="container">
    <header class="d-flex align-items-center my-3" style="color: var(--bs-gray);">
        <a>Proses</a>
        <i class="fas fa-angle-right mx-2"></i>
        <a>Packing</a>
    </header>
    <section id="data-packing">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Packing</h4>
                <hr>

                <div id="container-list-trans"></div>

                <ul class="list-unstyled form-control" id="list-action">
                    <li id="action-detail">Lihat Detail</li>
                    <li id="action-kemas">Kemas</li>
                </ul>
            </div>
        </div>

        <div class="modal fade" role="dialog" tabindex="-1" id="modal-detail">
            <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Detail Transaksi</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div id="container-bucket"></div>
                        <div id="container-premium"></div>
                        <div class="mt-2">
                            <h5 class="fw-bold">Catatan Pelanggan</h5>
                            <textarea id="text-catatan-pelanggan" class="form-control" readonly></textarea>
                        </div>
                        <div class="mt-2">
                            <h5 class="fw-bold">Catatan Transaksi</h5>
                            <textarea id="text-catatan-transaksi" class="form-control" readonly></textarea>
                        </div>
                        <ul class="list-unstyled form-control list-action" id="list-action-2">
                            <li id="action-notes">Catatan Item</li>
                            <li id="action-rewash">Rewash</li>
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


        <div class="modal fade" role="dialog" tabindex="-1" id="modal-packing" data-bs-backdrop="static" data-bs-keyboard="false">
            <div class="modal-dialog modal-lg modal-dialog-centered modal-fullscreen-sm-down" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Kemas</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form id="form-packing">
                        <div class="modal-body">
                            <div id="table-container"></div>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-primary" id="simpan-packing" type="submit">Simpan & Antar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
</div>

<script src="{{ asset('js/proses/packing.js') }}"></script>
@endsection
