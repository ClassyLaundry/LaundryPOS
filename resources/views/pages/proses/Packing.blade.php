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
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" role="dialog" tabindex="-1" id="modal-packing-bucket">
            <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Kemas</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form id="form-packing-bucket">
                        <div class="modal-body">
                            <div id="table-container-bucket"></div>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-primary" id="simpan-packing" type="submit">Simpan & Antar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="modal fade" role="dialog" tabindex="-1" id="modal-packing-premium">
            <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Kemas</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form id="form-packing-premium">
                        <div class="modal-body">
                            <div id="table-container-premium"></div>
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
