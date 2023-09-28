@extends('layouts.users')

@section('content')
<div class="container">
    <header class="d-flex align-items-center my-3" style="color: var(--bs-gray);">
        <a>Master Data</a>
        <i class="fas fa-angle-right mx-2"></i>
        <a>Data Rewash</a>
    </header>
    <section id="data-rewash">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Data Item</h4>
                <hr>
                <div class="d-flex justify-content-end">
                    <form method="GET" action="/data/rewash" class="d-flex align-items-center">
                        Search :
                        <input class="form-control mx-1" type="search" name="search" style="max-width: 200px;">
                    </form>
                </div>
                <div class="table-responsive mb-2">
                    <table class="table table-striped" id="table-rewash">
                        <thead>
                            <tr>
                                <th>Alasan Rewash</th>
                                <th>Terakhir Edit</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($jenisRewashes as $jenisRewash)
                            <tr>
                                <td>{{ $jenisRewash->keterangan }}</td>
                                <td class="text-center">{{ $jenisRewash->user->name }}</td>
                                <td class="cell-action">
                                    <button id="btn-{{ $jenisRewash->id }}" class="btn btn-primary btn-sm btn-show-action" type="button">
                                        <i class="fas fa-bars"></i>
                                    </button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                {{ $jenisRewashes->links() }}
                @if(in_array("Menambah Rewash", Session::get('permissions')) || Session::get('role') == 'administrator')
                <button class="btn btn-primary btn-tambah mt-2" type="button">
                    <i class="fas fa-plus-circle"></i>
                    &nbsp;Tambah
                </button>
                @endif
                <ul class="list-unstyled form-control" id="list-action">
                    @if(in_array("Menghapus Rewash", Session::get('permissions')) || Session::get('role') == 'administrator')
                    <li id="action-delete">Hapus data</li>
                    @endif
                </ul>
            </div>
        </div>
        <div class="modal fade" role="dialog" tabindex="-1" id="modal-rewash">
            <div class="modal-dialog modal-lg modal-dialog-centered modal-fullscreen-lg-down" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Rubah Data</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form id="modal-form" action="/data/rewash" method="POST">
                        @csrf
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-12">
                                    <h5>Keterangan</h5>
                                    <input class="form-control" type="text" id="input-keterangan" name="keterangan" required>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button id="btn-submit" class="btn btn-primary" type="submit">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
</div>

<script src="{{ asset('js/data/rewash.js') }}"></script>
@endsection
