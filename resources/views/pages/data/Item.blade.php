@extends('layouts.users')

@section('content')
<div class="container">
    <header class="d-flex align-items-center my-3" style="color: var(--bs-gray);"><a>Master Data</a>
        <i class="fas fa-angle-right mx-2"></i>
        <a>Data Item</a>
    </header>
    <section id="data-item">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Data Item</h4>
                <hr>
                <div class="d-flex justify-content-between">
                    <div class="dropdown" id="dropdown-filter">
                        <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButtonFilter" data-bs-toggle="dropdown" aria-expanded="false">
                            Filter
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButtonFilter" style="min-width: 6rem;">
                            <li><h6 class="dropdown-header">Paginate</h6></li>
                            <li><a class="dropdown-item active" data-paginate='5'>5 items</a></li>
                            <li><a class="dropdown-item" data-paginate='10'>10 items</a></li>
                            <li><a class="dropdown-item" data-paginate='25'>25 items</a></li>
                            <li><a class="dropdown-item" data-paginate='50'>50 items</a></li>
                        </ul>
                    </div>
                    <div class="d-flex align-items-center">
                        Search :
                        <input class="form-control mx-1" id="input-search" type="search" name="search" style="max-width: 200px;">
                    </div>
                </div>
                <div id="table-item"></div>
                @if(in_array("Membuat Jenis Item", Session::get('permissions')) || Session::get('role') == 'administrator')
                <button class="btn btn-primary btn-tambah mt-2" type="button">
                    <i class="fas fa-plus-circle"></i>
                    &nbsp;Tambah
                </button>
                @endif
                <ul class="list-unstyled form-control" id="list-action">
                    @if(in_array("Mengubah Data Jenis Item", Session::get('permissions')) || Session::get('role') == 'administrator')
                    <li id="action-update">Rubah data</li>
                    @endif
                    @if(in_array("Menghapus Jenis Item", Session::get('permissions')) || Session::get('role') == 'administrator')
                    <li id="action-delete">Hapus data</li>
                    @endif
                </ul>
            </div>
        </div>
        <div class="modal fade" role="dialog" tabindex="-1" id="modal-update">
            <div class="modal-dialog modal-lg modal-dialog-centered modal-fullscreen-lg-down" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Rubah Data</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form id="modal-form" action="/data/jenis-item" method="POST">
                        @csrf
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-12">
                                    <h5>Kategori</h5>
                                    <select class="form-select" id="input-kategori" name="kategori_id" required>
                                        <option value='' disabled selected hidden>-</option>
                                        @foreach ($kategoris as $kategori)
                                            <option value={{ $kategori->id }}>{{ $kategori->nama }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-12">
                                    <h5>Nama Item</h5>
                                    <input class="form-control" type="text" id="input-nama-item" name="nama" required>
                                </div>
                                <div class="col-12">
                                    <h5>Unit</h5>
                                    <select class="form-select" id="input-unit" name="unit">
                                        <option value="PCS">Piece</option>
                                        <option value="KG">Kilogram</option>
                                        <option value="MTR">Meter</option>
                                    </select>
                                </div>
                                <div class="col-12 col-sm-6">
                                    <h5>Bobot Bucket</h5>
                                    <div class="form-control d-flex">
                                        <input class="w-100 me-2" type="number" id="input-bobot-bucket" name="bobot_bucket" step="0.1" required>
                                        <p>Kg</p>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-6">
                                    <h5>Harga Kilo</h5>
                                    <div class="form-control d-flex">
                                        <p>Rp</p>
                                        <input class="w-100 ms-2 input-thousand-separator" type="text" id="input-harga-kilo" name="harga_kilo" required>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-6">
                                    <h5>Harga Bucket</h5>
                                    <div class="form-control d-flex">
                                        <p>Rp</p>
                                        <input class="w-100 ms-2 input-thousand-separator" type="text" id="input-harga-bucket" name="harga_bucket" required>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-6">
                                    <h5>Harga Premium</h5>
                                    <div class="form-control d-flex">
                                        <p>Rp</p>
                                        <input class="w-100 ms-2 input-thousand-separator" type="text" id="input-harga-premium" name="harga_premium" required>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-6">
                                    <h5>Beban Produksi</h5>
                                    <div class="form-control d-flex">
                                        <input class="w-100 ms-2" type="number" value="0.0" step="0.1" min="0" id="input-beban-produksi" name="beban_produksi" required>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-6">
                                    <h5>Diskon Jenis Item</h5>
                                    <div class="form-control d-flex">
                                        <p>Rp</p>
                                        <input class="w-100 ms-2 input-thousand-separator" type="text" id="input-diskon-item" min=0 name="diskon_jenis_item" required>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-6">
                                    <h5>Status Kilo</h5>
                                    <div class="form-control d-flex align-items-center justify-content-around">
                                        <div class="form-check">
                                            <input type="radio" class="form-check-input" id="formCheck-kilo-aktif" name="status_kilo" value=1 />
                                            <label class="form-check-label" for="formCheck-kilo-aktif">Aktif</label>
                                        </div>
                                        <div class="form-check">
                                            <input type="radio" class="form-check-input" id="formCheck-kilo-tidakAktif" name="status_kilo" value=0 />
                                            <label class="form-check-label" for="formCheck-kilo-tidakAktif">Tidak aktif</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-6">
                                    <h5>Status Bucket</h5>
                                    <div class="form-control d-flex align-items-center justify-content-around">
                                        <div class="form-check">
                                            <input type="radio" class="form-check-input" id="formCheck-bucket-aktif" name="status_bucket" value=1 />
                                            <label class="form-check-label" for="formCheck-bucket-aktif">Aktif</label>
                                        </div>
                                        <div class="form-check">
                                            <input type="radio" class="form-check-input" id="formCheck-bucket-tidakAktif" name="status_bucket" value=0 />
                                            <label class="form-check-label" for="formCheck-bucket-tidakAktif">Tidak aktif</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-6">
                                    <h5>Status Premium</h5>
                                    <div class="form-control d-flex align-items-center justify-content-around">
                                        <div class="form-check">
                                            <input type="radio" class="form-check-input" id="formCheck-premium-aktif" name="status_premium" value=1 />
                                            <label class="form-check-label" for="formCheck-premium-aktif">Aktif</label>
                                        </div>
                                        <div class="form-check">
                                            <input type="radio" class="form-check-input" id="formCheck-premium-tidakAktif" name="status_premium" value=0 />
                                            <label class="form-check-label" for="formCheck-premium-tidakAktif">Tidak aktif</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-6">
                                    <h5>Status Item</h5>
                                    <div class="form-control d-flex align-items-center justify-content-around">
                                        <div class="form-check">
                                            <input type="radio" class="form-check-input" id="formCheck-item-aktif" name="status_item" value=1 />
                                            <label class="form-check-label" for="formCheck-item-aktif">Aktif</label>
                                        </div>
                                        <div class="form-check">
                                            <input type="radio" class="form-check-input" id="formCheck-item-tidakAktif" name="status_item" value=0 />
                                            <label class="form-check-label" for="formCheck-item-tidakAktif">Tidak aktif</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button id="btn-simpan" class="btn btn-primary" type="submit">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
</div>

<script src="{{ asset('js/data/item.js') }}"></script>
@endsection
