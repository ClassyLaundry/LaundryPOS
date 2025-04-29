@extends('layouts.users')
@section('content')
<input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
<div class="container">
    <header class="d-flex align-items-center my-3" style="color: var(--bs-gray);">
        <a>Transaksi</a>
        <i class="fas fa-angle-right mx-2"></i>
        <a>Cancelled</a>
    </header>

    <section id="data-transaksi">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">List Cancelled</h4>
                <hr>
                <div class="d-flex align-items-center justify-content-end mb-3">
                    Search: <input class="form-control ms-1" id="input-nama-pelanggan" type="search" name="search" style="max-width: 200px;">
                </div>

                <div id="container-list-trans"></div>

                {{-- <ul class="list-unstyled form-control" id="list-action">
                    @if(in_array("Merestore Transaksi", Session::get('permissions')) || Session::get('role') == 'administrator')
                    <li id="action-restore">Restore Transaksi</li>
                    @endif
                </ul> --}}
            </div>
        </div>
    </section>
</div>

<script src="{{ asset('js/transaksi/cancelled.js') }}"></script>
@endsection
