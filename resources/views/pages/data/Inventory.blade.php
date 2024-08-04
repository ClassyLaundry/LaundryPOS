@extends('layouts.users')

@section('content')
<div class="container">
    <header class="d-flex align-items-center my-3" style="color: var(--bs-gray);">
        <a>Master Data</a>
        <i class="fas fa-angle-right mx-2"></i>
        <a>Data Inventory</a>
    </header>
    <section id="data-inventory">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Data Inventory</h4>
                <hr>
                <div class="d-flex justify-content-end">
                    <form method="GET" action="/data/inventory" class="d-flex align-items-center">
                        Search :
                        <input class="form-control mx-1" type="search" name="search" style="max-width: 200px;">
                    </form>
                </div>
                <div class="table-responsive mb-2">
                    <table class="table table-striped" id="table-inventory">
                        <thead>
                            <tr>
                                <th>Nama</th>
                                <th>Deskripsi</th>
                                <th>Tipe</th>
                                <th>Stok</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($inventories as $inventory)
                            <tr>
                                <td>{{ $inventory->nama }}</td>
                                <td>{{ $inventory->deskripsi }}</td>
                                <td class="text-center">{{ $inventory->kategori }}</td>
                                <td class="text-center thousand-separator">{{ $inventory->stok }}</td>
                                <td class="cell-action">
                                    <button id="btn-{{ $inventory->id }}" class="btn btn-primary btn-sm btn-show-action" type="button">
                                        <i class="fas fa-bars"></i>
                                    </button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                {{ $inventories->links() }}
                @if(in_array("Menambah Inventory", Session::get('permissions')) || Session::get('role') == 'administrator')
                <button class="btn btn-primary btn-tambah mt-2" type="button">
                    <i class="fas fa-plus-circle"></i>
                    &nbsp;Tambah
                </button>
                @endif
                <ul class="list-unstyled form-control" id="list-action">
                    @if(in_array("Mengubah Data Inventory", Session::get('permissions')) || Session::get('role') == 'administrator')
                    <li id="action-update">Rubah data</li>
                    @endif
                    @if(in_array("Menghapus Inventory", Session::get('permissions')) || Session::get('role') == 'administrator')
                    <li id="action-delete">Hapus data</li>
                    @endif
                </ul>
            </div>
        </div>
        <div class="modal fade" role="dialog" tabindex="-1" id="modal-inventory">
            <div class="modal-dialog modal-lg modal-dialog-centered modal-fullscreen-lg-down" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Rubah Data</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form id="modal-form" action="/data/inventory/insert" method="POST">
                        @csrf
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-12">
                                    <h5>Nama Item</h5>
                                    <input class="form-control" type="text" id="input-nama-inventory" name="nama" required>
                                </div>
                                <div class="col-12">
                                    <h5>Deskripsi</h5>
                                    <textarea class="form-control" id="input-deskripsi" name="deskripsi"></textarea>
                                </div>
                                <div class="col-6">
                                    <h5>Kategori</h5>
                                    <select class="form-control" id="input-kategori" name="kategori" required >
                                        <option value="" selected hidden>-</option>
                                        <option value="inventory">Inventory</option>
                                        <option value="packing">Packing</option>
                                    </select>
                                </div>
                                <div class="col-6">
                                    <h5>Stok</h5>
                                    <input class="form-control" type="number" id="input-stok" name="stok" required>
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

<script src="{{ asset('js/data/inventory.js') }}"></script>
@endsection
