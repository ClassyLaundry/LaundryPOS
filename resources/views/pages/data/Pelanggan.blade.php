@extends('layouts.users')

@section('content')
<div class="container">
    <header class="d-flex align-items-center my-3" style="color: var(--bs-gray);">
        <a>Master Data</a>
        <i class="fas fa-angle-right mx-2"></i>
        <a>Data Pelanggan</a>
    </header>
    <section id="data-pelanggan">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Data Pelanggan</h4>
                <hr>
                <div class="d-flex justify-content-between">
                    <div class="dropdown" id="dropdown-filter">
                        <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButtonFilter" data-bs-toggle="dropdown" aria-expanded="false">
                            Filter
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButtonFilter" style="min-width: 6rem;">
                            <li><h6 class="dropdown-header">Search by</h6></li>
                            <li><a class="dropdown-item active filter-search" data-search='nama'>Nama</a></li>
                            <li><a class="dropdown-item filter-search" data-search='telephone'>Telephone</a></li>
                            <li><a class="dropdown-item filter-search" data-search='alamat'>Alamat</a></li>
                            <li><a class="dropdown-item filter-search" data-search='email'>E-mail</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><h6 class="dropdown-header">Paginate</h6></li>
                            <li><a class="dropdown-item active filter-paginate" data-paginate='5'>5 items</a></li>
                            <li><a class="dropdown-item filter-paginate" data-paginate='10'>10 items</a></li>
                            <li><a class="dropdown-item filter-paginate" data-paginate='25'>25 items</a></li>
                            <li><a class="dropdown-item filter-paginate" data-paginate='50'>50 items</a></li>
                        </ul>
                    </div>
                    <div class="d-flex align-items-center">
                        Search :
                        <input class="form-control mx-1" id="input-search" type="search" name="search" style="max-width: 200px;">
                    </div>
                </div>
                <div id="table-pelanggan"></div>
                @if(in_array("Membuat Pelanggan", Session::get('permissions')) || Session::get('role') == 'administrator')
                <button class="btn btn-primary btn-tambah mt-2" type="button">
                    <i class="fas fa-plus-circle"></i>
                    &nbsp;Tambah
                </button>
                @endif
                <ul class="list-unstyled form-control" id="list-action">
                    @if(in_array("Membuka Halaman Detail Pelanggan", Session::get('permissions')) || Session::get('role') == 'administrator')
                    <li id="action-detail">Detail pelanggan</li>
                    @endif
                    @if(in_array("Menghapus Pelanggan", Session::get('permissions')) || Session::get('role') == 'administrator')
                    <li id="action-delete">Hapus data</li>
                    @endif
                </ul>
            </div>
        </div>

        <div class="modal fade" role="dialog" tabindex="-1" id="modal-update">
            <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Data Pelanggan</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form id="modal-form" action="/data/pelanggan" method="POST">
                        @csrf
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-12">
                                    <h5>Nama Lengkap*</h5>
                                    <input class="form-control" type="text" id="input-nama-pelanggan" name="nama" required>
                                </div>
                                <div class="col-12">
                                    <h5>Alamat*</h5>
                                    <input class="form-control" type="text" id="input-alamat" name="alamat" required>
                                </div>
                                <div class="col-12 col-lg-4">
                                    <h5>Tanggal Lahir</h5>
                                    <input class="form-control" id="input-tanggal-lahir" type="date" name="tanggal_lahir">
                                </div>
                                <div class="col-12 col-lg-4">
                                    <h5>Jenis Kelamin*</h5>
                                    <div class="form-control d-flex align-items-center justify-content-around">
                                        <div class="form-check">
                                            <input type="radio" class="form-check-input" id="formCheck-pria" name="gender" value="pria" required/>
                                            <label class="form-check-label" for="formCheck-pria">Pria</label>
                                        </div>
                                        <div class="form-check">
                                            <input type="radio" class="form-check-input" id="formCheck-wanita" name="gender" value="wanita" />
                                            <label class="form-check-label" for="formCheck-wanita">Wanita</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-lg-4">
                                    <h5>Tipe Member</h5>
                                    <div class="form-control d-flex align-items-center justify-content-around">
                                        <div class="form-check">
                                            <input type="radio" class="form-check-input" id="formCheck-member" name="member" value=1 />
                                            <label class="form-check-label" for="formCheck-member">Member</label>
                                        </div>
                                        <div class="form-check">
                                            <input type="radio" class="form-check-input" id="formCheck-non-member" name="member" value=0 />
                                            <label class="form-check-label" for="formCheck-non-member">Bukan member</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-6">
                                    <h5>Jenis Identitas</h5>
                                    <select class="form-select" id="input-jenis-identitas" name="jenis_id" >
                                        <option value='' disabled selected hidden>-</option>
                                        <option value="ktp">KTP</option>
                                        <option value="sim">SIM</option>
                                    </select>
                                </div>
                                <div class="col-12 col-sm-6">
                                    <h5>Nomor Identitas</h5>
                                    <input class="form-control" type="text" id="input-nomor-identitas" name="no_id" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');">
                                </div>
                                <div class="col-12 col-lg-6">
                                    <h5>Telephone*</h5>
                                    <input class="form-control" type="text" id="input-telepon" name="telephone" required oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');">
                                </div>
                                <div class="col-12 col-lg-6">
                                    <h5>E-mail</h5>
                                    <input class="form-control" type="text" id="input-email" name="email" >
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

<script src="{{ asset('js/data/pelanggan.js') }}"></script>
@endsection
