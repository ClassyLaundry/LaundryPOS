@extends('layouts.users')
@section('content')
<input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
<div class="container">
    <header class="d-flex align-items-center my-3" style="color: var(--bs-gray);">
        <a>Transaksi</a>
        <i class="fas fa-angle-right mx-2"></i>
        <a>Komplain</a>
    </header>

    <section id="data-transaksi">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">List Komplain</h4>
                <hr>
                <div class="d-flex align-items-center justify-content-end mb-3">
                    <button type="button" class="btn btn-primary me-2" id="btn-add-komplain"><i class="fa-solid fa-plus"></i> Tambah</button>
                    Search: <input class="form-control ms-1" id="input-search-komplain" type="search" name="search" style="max-width: 200px;">
                </div>

                <div class="modal fade" id="modal-list-transaksi" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-xl modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5">List Transaksi</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="d-flex align-items-center justify-content-end mb-3">
                                    Search: <input class="form-control ms-1" id="input-search-trans" type="search" name="search" style="max-width: 200px;">
                                </div>
                                <div id="container-list-trans"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal fade" id="modal-add-komplain" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-lg modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5">Komplain Transaksi <span id="kode-transaksi"></span></h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form id="form-add-komplain" method="POST">
                                    @csrf
                                    <div class="row">
                                        <div class="col-6 mb-2">
                                            <h5>Kode Transaksi</h5>
                                            <input type="text" class="form-control" name="kode" id="input-kode" readonly>
                                        </div>
                                        <div class="col-6 mb-2">
                                            <h5>Pelanggan</h5>
                                            <input type="text" class="form-control" name="pelanggan" id="input-pelanggan" readonly>
                                        </div>
                                        <div class="col-12 mb-0">
                                            <h5>Komplain</h5>
                                            <textarea name="komplain" class="form-control" id="input-komplain" rows="5"></textarea>
                                        </div>
                                        <input type="hidden" name="id_transaksi" id="input-id_transaksi">
                                    </div>
                                </form>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" id="btn-back-komplain">Kembali</button>
                                <button type="submit" class="btn btn-primary" id="btn-submit-komplain" form="form-add-komplain">Tambah</button>
                              </div>
                        </div>
                    </div>
                </div>

                <div id="container-list-komplain"></div>

                <ul class="list-unstyled form-control" id="list-action">
                    @if(in_array("Merestore Transaksi", Session::get('permissions')) || Session::get('role') == 'administrator')
                    <li id="action-restore">Restore Transaksi</li>
                    @endif
                </ul>
            </div>
        </div>
    </section>
</div>

<script src="{{ asset('js/transaksi/komplain.js') }}"></script>
@endsection
