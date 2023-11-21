@extends('layouts.users')

@section('content')
<div class="container">
    <header class="d-flex align-items-center my-3" style="color: var(--bs-gray);"><a>Pengaturan</a><i class="fas fa-angle-right mx-2"></i><a>Pengaturan Karyawan</a></header>
    <section id="pengaturan-karyawan" class="mb-5">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Pengaturan Data Karyawan</h4>
                <hr>

                <div class="d-flex justify-content-between align-items-center">
                    <div class="dropdown" id="dropdown-filter-role">
                        <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButtonFilter" data-bs-toggle="dropdown" aria-expanded="false">
                            Filter Role
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButtonFilter" style="min-width: 6rem; cursor:default;">
                            <li><h6 class="dropdown-header">Role</h6></li>
                            <li><a class="dropdown-item active" data-value=>Semua</a></li>
                            <li><a class="dropdown-item" data-value='2'>Supervisor</a></li>
                            <li><a class="dropdown-item" data-value='3'>Operator</a></li>
                            <li><a class="dropdown-item" data-value='4'>Packing</a></li>
                            <li><a class="dropdown-item" data-value='5'>Penyuci</a></li>
                            <li><a class="dropdown-item" data-value='6'>Penyetrika</a></li>
                            <li><a class="dropdown-item" data-value='7'>Delivery</a></li>
                        </ul>
                    </div>
                    <div class="d-flex align-items-center">
                        Search:
                        <input class="form-control ms-1" id="input-search" type="search" name="search" style="max-width: 200px;">
                    </div>
                </div>

                <div id="list-karyawan"></div>

                @if(in_array("Menambahkan Karyawan", Session::get('permissions')) || Session::get('role') == 'administrator')
                <button id="btn-add" class="btn btn-primary" type="button">
                    <i class="fas fa-plus-circle"></i>&nbsp;Tambah
                </button>
                @endif
                <ul class="list-unstyled form-control" id="list-action">
                    @if(in_array("Mengubah Data Karyawan", Session::get('permissions')) || Session::get('role') == 'administrator')
                    <li id="action-update">Rubah data</li>
                    @endif
                    @if(in_array("Mengubah Data Password Karyawan", Session::get('permissions')) || Session::get('role') == 'administrator')
                    <li id="action-change-password">Rubah password</li>
                    @endif
                </ul>
            </div>
        </div>

        <div class="modal fade" role="dialog" tabindex="-1" id="modal-data-user">
            <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Rubah Data</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form id="form-karyawan" method="POST" action>
                        @csrf
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-12 col-sm-6" id="col-username">
                                    <h5>Username</h5>
                                    <input class="form-control" type="text" id="input-username" name="username" required />
                                </div>
                                <div class="col-12 col-sm-6" id="col-password">
                                    <h5>Password</h5>
                                    <div class="form-control d-flex align-items-center">
                                        <input class="w-100 me-2" style="outline: none; border: none;" id="input-password" name="password" type="password" required />
                                        <i class="fas fa-eye-slash"></i>
                                    </div>
                                </div>
                                <div class="col-12" id="col-name">
                                    <h5>Nama Lengkap</h5>
                                    <input class="form-control" type="text" id="input-nama" name="name" required />
                                </div>
                                <div class="col-12">
                                    <h5>Alamat</h5>
                                    <input class="form-control" type="text" id="input-alamat" name="address" required />
                                </div>
                                <div class="col-12 col-sm-6">
                                    <h5>Telepon</h5>
                                    <input class="form-control" type="text" id="input-telepon" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" name="phone" required />
                                </div>
                                <div class="col-12 col-sm-6" id="col-email">
                                    <h5>E-mail</h5>
                                    <input class="form-control" type="email" id="input-email" name="email" required />
                                </div>
                                <div class="col-12 col-sm-6" id="col-outlet">
                                    <h5>Outlet</h5>
                                    <select class="form-select" id="input-outlet" name="outlet_id" required />
                                        <option value="" selected hidden>-</option>
                                        @foreach ($outlets as $outlet)
                                            <option value="{{ $outlet->id }}">{{ $outlet->nama }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-12 col-sm-6" id="col-role">
                                    <h5>Role</h5>
                                    <select class="form-select" id="input-role" name="role" required />
                                        <option value="" selected hidden>-</option>
                                        @foreach ($roles as $role)
                                            @if($role->name != "administrator")
                                            <option value="{{ $role->name }}">{{ $role->name }}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-12" id="col-status">
                                    <h5>Status</h5>
                                    <div class="form-control d-flex justify-content-around" style="height: 38px;">
                                        <div class="form-check">
                                            <input type="radio" class="form-check-input" id="radio-status-aktif" name="status" value=1 />
                                            <label class="form-check-label" for="radio-status-aktif">Aktif</label>
                                        </div>
                                        <div class="form-check">
                                            <input type="radio" class="form-check-input" id="radio-status-tidakAktif" name="status" value=0 />
                                            <label class="form-check-label" for="radio-status-tidakAktif">Tidak aktif</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer"><button class="btn btn-primary" type="submit">Simpan</button></div>
                    </form>
                </div>
            </div>
        </div>

        <div class="modal fade" role="dialog" tabindex="-1" id="modal-change-password">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Reset Password</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-12">
                                    <h5>Password Baru</h5>
                                    <div class="form-container d-flex align-items-center">
                                        <input class="form-control" type="password" id="input-password-baru" required />
                                        <i class="fas fa-eye-slash"></i>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <h5>Konfirmasi Password Baru</h5>
                                    <div class="form-container d-flex align-items-center">
                                        <input class="form-control" type="password" id="input-konfirmasi" required />
                                        <i class="fas fa-eye-slash"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="alert alert-danger d-none" role="alert">
                                <span id="error-msg"></span>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-primary" type="button" id="btn-change-password">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

    @if(in_array("Merubah Hak Akses", Session::get('permissions')) || Session::get('role') == 'administrator')
    <section id="pengaturan-hak-akses">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Pengaturan Hak Akses</h4>
                <hr>
                <div class="d-flex align-items-center mb-3">
                    <p class="me-2">Role :</p>
                    <select class="form-select" id="role-id" style="width: initial;" required>
                        <option value="" selected hidden>-</option>
                        <option value="2">Supervisor</option>
                        <option value="3">Operator</option>
                        <option value="4">Packing</option>
                        <option value="5">Pencuci</option>
                        <option value="6">Penyetrika</option>
                        <option value="7">Delivery</option>
                    </select>
                </div>
                <div class="row disabled" id="list-hak-akses">
                    <div class="col-12 col-md-6 col-xl-3">
                        <div class="card h-100" id="card-pengaturan">
                            <div class="card-body">
                                <h4>Pengaturan</h4>
                                <hr>
                                <h5 class="fw-bold">Outlet</h5>
                                <div class="ms-1 mb-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="check-pengaturan-outlet-1" value="Membuka Menu Outlet">
                                        <label class="form-check-label" for="check-pengaturan-outlet-1">Membuka menu outlet</label>
                                    </div>
                                    {{-- <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="check-pengaturan-outlet-2" value="Melihat Detail Outlet">
                                        <label class="form-check-label" for="check-pengaturan-outlet-2">Melihat detail outlet</label>
                                    </div> --}}
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="check-pengaturan-outlet-3" value="Membuat Outlet">
                                        <label class="form-check-label" for="check-pengaturan-outlet-3">Membuat outlet</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="check-pengaturan-outlet-4" value="Mengubah Data Outlet">
                                        <label class="form-check-label" for="check-pengaturan-outlet-4">Mengubah data outlet</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="check-pengaturan-outlet-5" value="Menambah Saldo Outlet">
                                        <label class="form-check-label" for="check-pengaturan-outlet-5">Menambah saldo outlet</label>
                                    </div>
                                </div>
                                <h5 class="fw-bold">Karyawan & Hak Akses</h5>
                                <div class="ms-1 mb-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="check-pengaturan-akses-1" value="Merubah Hak Akses">
                                        <label class="form-check-label" for="check-pengaturan-akses-1">Merubah hak akses</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="check-pengaturan-karyawan-1" value="Membuka Menu Karyawan">
                                        <label class="form-check-label" for="check-pengaturan-karyawan-1">Membuka menu karyawan</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="check-pengaturan-karyawan-2" value="Melihat Detail Karyawan">
                                        <label class="form-check-label" for="check-pengaturan-karyawan-2">Melihat detail karyawan</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="check-pengaturan-karyawan-3" value="Menambahkan Karyawan">
                                        <label class="form-check-label" for="check-pengaturan-karyawan-3">Menambahkan karyawan</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="check-pengaturan-karyawan-4" value="Mengubah Data Karyawan">
                                        <label class="form-check-label" for="check-pengaturan-karyawan-4">Mengubah data karyawan</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="check-pengaturan-karyawan-5" value="Mengubah Data Password Karyawan">
                                        <label class="form-check-label" for="check-pengaturan-karyawan-5">Mengubah password karyawan</label>
                                    </div>
                                </div>
                                <h5 class="fw-bold">Paket Cuci</h5>
                                <div class="ms-1 mb-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="check-pengaturan-paket-cuci-1" value="Membuka Menu Paket Cuci">
                                        <label class="form-check-label" for="check-pengaturan-paket-cuci-1">Membuka menu paket cuci</label>
                                    </div>
                                    {{-- <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="check-pengaturan-paket-cuci-2" value="Melihat Detail Paket Cuci">
                                        <label class="form-check-label" for="check-pengaturan-paket-cuci-2">Melihat detail paket cuci</label>
                                    </div> --}}
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="check-pengaturan-paket-cuci-3" value="Membuat Paket Cuci">
                                        <label class="form-check-label" for="check-pengaturan-paket-cuci-3">Membuat paket cuci</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="check-pengaturan-paket-cuci-4" value="Mengubah Data Paket Cuci">
                                        <label class="form-check-label" for="check-pengaturan-paket-cuci-4">Mengubah data paket cuci</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="check-pengaturan-paket-cuci-5" value="Menghapus Paket Cuci">
                                        <label class="form-check-label" for="check-pengaturan-paket-cuci-5">Menghapus paket cuci</label>
                                    </div>
                                </div>
                                <h5 class="fw-bold">Paket Deposit</h5>
                                <div class="ms-1 mb-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="check-pengaturan-paket-deposit-1" value="Membuka Menu Paket Deposit">
                                        <label class="form-check-label" for="check-pengaturan-paket-deposit-1">Membuka menu paket deposit</label>
                                    </div>
                                    {{-- <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="check-pengaturan-paket-deposit-2" value="Melihat Detail Paket Deposit">
                                        <label class="form-check-label" for="check-pengaturan-paket-deposit-2">Melihat detail paket deposit</label>
                                    </div> --}}
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="check-pengaturan-paket-deposit-3" value="Membuat Paket Deposit">
                                        <label class="form-check-label" for="check-pengaturan-paket-deposit-3">Membuat paket deposit</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="check-pengaturan-paket-deposit-4" value="Mengubah Data Paket Deposit">
                                        <label class="form-check-label" for="check-pengaturan-paket-deposit-4">Mengubah data paket deposit</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="check-pengaturan-paket-deposit-5" value="Menghapus Paket Deposit">
                                        <label class="form-check-label" for="check-pengaturan-paket-deposit-5">Menghapus paket deposit</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-xl-3">
                        <div class="card h-100" id="card-data">
                            <div class="card-body">
                                <h4>Data</h4>
                                <hr>
                                <h5 class="fw-bold">Kategori</h5>
                                <div class="ms-1 mb-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="check-data-kategori-1" value="Membuka Menu Kategori">
                                        <label class="form-check-label" for="check-data-kategori-1">Membuka menu kategori</label>
                                    </div>
                                    {{-- <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="check-data-kategori-2" value="Melihat Detail Kategori">
                                        <label class="form-check-label" for="check-data-kategori-2">Melihat detail kategori</label>
                                    </div> --}}
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="check-data-kategori-3" value="Membuat Kategori">
                                        <label class="form-check-label" for="check-data-kategori-3">Membuat kategori</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="check-data-kategori-4" value="Mengubah Data Kategori">
                                        <label class="form-check-label" for="check-data-kategori-4">Mengubah data kategori</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="check-data-kategori-5" value="Menghapus Kategori">
                                        <label class="form-check-label" for="check-data-kategori-5">Menghapus kategori</label>
                                    </div>
                                </div>
                                <h5 class="fw-bold">Jenis Item</h5>
                                <div class="ms-1 mb-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="check-data-item-1" value="Membuka Menu Jenis Item">
                                        <label class="form-check-label" for="check-data-item-1">Membuka menu jenis item</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="check-data-item-2" value="Melihat Detail Jenis Item">
                                        <label class="form-check-label" for="check-data-item-2">Melihat detail jenis item</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="check-data-item-3" value="Membuat Jenis Item">
                                        <label class="form-check-label" for="check-data-item-3">Membuat jenis item</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="check-data-item-4" value="Mengubah Data Jenis Item">
                                        <label class="form-check-label" for="check-data-item-4">Mengubah data jenis item</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="check-data-item-5" value="Menghapus Jenis Item">
                                        <label class="form-check-label" for="check-data-item-5">Menghapus jenis item</label>
                                    </div>
                                </div>
                                <h5 class="fw-bold">Parfum</h5>
                                <div class="ms-1 mb-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="check-data-parfum-1" value="Membuka Menu Parfum">
                                        <label class="form-check-label" for="check-data-parfum-1">Membuka menu perfum</label>
                                    </div>
                                    {{-- <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="check-data-parfum-2" value="Melihat Detail Parfum">
                                        <label class="form-check-label" for="check-data-parfum-2">Melihat detail perfum</label>
                                    </div> --}}
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="check-data-parfum-3" value="Membuat Parfum">
                                        <label class="form-check-label" for="check-data-parfum-3">Membuat perfum</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="check-data-parfum-4" value="Mengubah Data Parfum">
                                        <label class="form-check-label" for="check-data-parfum-4">Mengubah data perfum</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="check-data-parfum-5" value="Menghapus Parfum">
                                        <label class="form-check-label" for="check-data-parfum-5">Menghapus perfum</label>
                                    </div>
                                </div>
                                <h5 class="fw-bold">Pelanggan</h5>
                                <div class="ms-1 mb-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="check-data-pelanggan-1" value="Membuka Menu Pelanggan">
                                        <label class="form-check-label" for="check-data-pelanggan-1">Membuka menu pelanggan</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="check-data-pelanggan-2" value="Membuka Halaman Detail Pelanggan">
                                        <label class="form-check-label" for="check-data-pelanggan-2">Membuka halaman detail pelanggan</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="check-data-pelanggan-3" value="Membuat Pelanggan">
                                        <label class="form-check-label" for="check-data-pelanggan-3">Membuat pelanggan</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="check-data-pelanggan-4" value="Mengubah Data Pelanggan">
                                        <label class="form-check-label" for="check-data-pelanggan-4">Mengubah data pelanggan</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="check-data-pelanggan-5" value="Menghapus Pelanggan">
                                        <label class="form-check-label" for="check-data-pelanggan-5">Menghapus pelanggan</label>
                                    </div>
                                </div>
                                <h5 class="fw-bold">Inventory</h5>
                                <div class="ms-1 mb-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="check-data-inventory-1" value="Membuka Menu Inventory">
                                        <label class="form-check-label" for="check-data-inventory-1">Membuka menu inventory</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="check-data-inventory-2" value="Menambah Inventory">
                                        <label class="form-check-label" for="check-data-inventory-2">Menambah inventory</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="check-data-inventory-3" value="Mengubah Data Inventory">
                                        <label class="form-check-label" for="check-data-inventory-3">Mengubah data inventory</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="check-data-inventory-4" value="Menghapus Inventory">
                                        <label class="form-check-label" for="check-data-inventory-4">Menghapus inventory</label>
                                    </div>
                                    {{-- <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="check-data-inventory-5" value="Mengubah Data Stok Inventory">
                                        <label class="form-check-label" for="check-data-inventory-5">Mengubah stok inventory</label>
                                    </div> --}}
                                </div>
                                <h5 class="fw-bold">Pengeluaran</h5>
                                <div class="ms-1 mb-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="check-data-pengeluaran-1" value="Membuka Menu Pengeluaran">
                                        <label class="form-check-label" for="check-data-pengeluaran-1">Membuka menu pengeluaran</label>
                                    </div>
                                    {{-- <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="check-data-pengeluaran-2" value="Melihat Detail Pengeluaran">
                                        <label class="form-check-label" for="check-data-pengeluaran-2">Melihat detail pengeluaran</label>
                                    </div> --}}
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="check-data-pengeluaran-3" value="Membuat Pengeluaran">
                                        <label class="form-check-label" for="check-data-pengeluaran-3">Membuat pengeluaran</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="check-data-pengeluaran-4" value="Mengubah Data Pengeluaran">
                                        <label class="form-check-label" for="check-data-pengeluaran-4">Mengubah data pengeluaran</label>
                                    </div>
                                </div>
                                <h5 class="fw-bold">Rewash</h5>
                                <div class="ms-1 mb-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="check-data-rewash-1" value="Membuka Menu Rewash">
                                        <label class="form-check-label" for="check-data-rewash-1">Membuka menu jenis rewash</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="check-data-rewash-2" value="Menambah Rewash">
                                        <label class="form-check-label" for="check-data-rewash-2">Menambah jenis rewash</label>
                                    </div>
                                    {{-- <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="check-data-rewash-3" value="Mengganti Status Rewash">
                                        <label class="form-check-label" for="check-data-rewash-3">Mengganti status rewash</label>
                                    </div> --}}
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="check-data-rewash-4" value="Menghapus Rewash">
                                        <label class="form-check-label" for="check-data-rewash-4">Menghapus jenis rewash</label>
                                    </div>
                                </div>
                                <h5 class="fw-bold">Diskon</h5>
                                <div class="ms-1 mb-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="check-data-diskon-1" value="Membuka Menu Diskon">
                                        <label class="form-check-label" for="check-data-diskon-1">Membuka menu diskon</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="check-data-diskon-2" value="Menambah Data Diskon">
                                        <label class="form-check-label" for="check-data-diskon-2">Menambah diskon</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="check-data-diskon-3" value="Mengubah Data Diskon">
                                        <label class="form-check-label" for="check-data-diskon-3">Mengubah diskon</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="check-data-diskon-4" value="Menghapus Data Diskon">
                                        <label class="form-check-label" for="check-data-diskon-4">Menghapus diskon</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-xl-3">
                        <div class="card h-100" id="card-transaksi">
                            <div class="card-body">
                                <h4>Transaksi</h4>
                                <hr>
                                <h5 class="fw-bold">Bucket & Premium</h5>
                                <div class="ms-1 mb-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="check-transaksi-1" value="Membuka Menu Transaksi">
                                        <label class="form-check-label" for="check-transaksi-1">Membuka menu transaksi</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="check-transaksi-2" value="Membuat Transaksi">
                                        <label class="form-check-label" for="check-transaksi-2">Membuat transaksi</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="check-transaksi-3" value="Melihat Detail Transaksi">
                                        <label class="form-check-label" for="check-transaksi-3">Melihat detail transaksi</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="check-transaksi-4" value="Menambahkan Item Ke Transaksi">
                                        <label class="form-check-label" for="check-transaksi-4">Menambahkan item transaksi</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="check-transaksi-5" value="Mengubah Data Transaksi">
                                        <label class="form-check-label" for="check-transaksi-5">Mengubah data transaksi</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="check-transaksi-6" value="Menambahkan Penerima Ke Transaksi">
                                        <label class="form-check-label" for="check-transaksi-6">Menambahkan penerima</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="check-transaksi-7" value="Membatalkan Transaksi">
                                        <label class="form-check-label" for="check-transaksi-7">Membatalkan transaksi</label>
                                    </div>
                                    {{-- <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="check-transaksi-item-1" value="Melihat Detail Item Transaksi">
                                        <label class="form-check-label" for="check-transaksi-item-1">Melihat detail item transaksi</label>
                                    </div> --}}
                                    {{-- <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="check-transaksi-item-2" value="Membuat Item Transaksi">
                                        <label class="form-check-label" for="check-transaksi-item-2">Membuat item transaksi</label>
                                    </div> --}}
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="check-transaksi-item-3" value="Mengubah Data Item Transaksi">
                                        <label class="form-check-label" for="check-transaksi-item-3">Mengubah data item transaksi</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="check-transaksi-item-4" value="Menghapus Item Transaksi">
                                        <label class="form-check-label" for="check-transaksi-item-4">Menghapus item transaksi</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="check-transaksi-catatan-1" value="Melihat Detail Daftar Catatan Item">
                                        <label class="form-check-label" for="check-transaksi-catatan-1">Melihat daftar catatan item</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="check-transaksi-catatan-2" value="Melihat Detail Catatan Item">
                                        <label class="form-check-label" for="check-transaksi-catatan-2">Melihat catatan item</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="check-transaksi-catatan-3" value="Membuat Catatan Item">
                                        <label class="form-check-label" for="check-transaksi-catatan-3">Membuat catatan item</label>
                                    </div>
                                </div>
                                <h5 class="fw-bold">Pickup & Delivery</h5>
                                <div class="ms-1 mb-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="check-transaksi-pickup-delivery-1" value="Membuka Menu Pickup Delivery">
                                        <label class="form-check-label" for="check-transaksi-pickup-delivery-1">Membuka menu pickup delivery</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="check-transaksi-pickup-delivery-2" value="Melihat Detail Pickup Delivery">
                                        <label class="form-check-label" for="check-transaksi-pickup-delivery-2">Melihat detail pickup delivery</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="check-transaksi-pickup-delivery-3" value="Membuat Pickup Delivery">
                                        <label class="form-check-label" for="check-transaksi-pickup-delivery-3">Membuat pickup delivery</label>
                                    </div>
                                    {{-- <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="check-transaksi-pickup-delivery-4" value="Mengubah Data Pickup Delivery">
                                        <label class="form-check-label" for="check-transaksi-pickup-delivery-4">Mengubah data pickup delivery</label>
                                    </div> --}}
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="check-transaksi-pickup-delivery-5" value="Menghapus Pickup Delivery">
                                        <label class="form-check-label" for="check-transaksi-pickup-delivery-5">Menghapus pickup delivery</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="check-transaksi-pickup-delivery-6" value="Mengganti Status Selesai Pickup Delivery">
                                        <label class="form-check-label" for="check-transaksi-pickup-delivery-6">Mengganti status pickup delivery</label>
                                    </div>
                                </div>
                                <h5 class="fw-bold">Saldo</h5>
                                <div class="ms-1 mb-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="check-transaksi-saldo-1" value="Membuka Menu Saldo">
                                        <label class="form-check-label" for="check-transaksi-saldo-1">Membuka menu saldo</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="check-transaksi-saldo-2" value="Topup Saldo Pelanggan">
                                        <label class="form-check-label" for="check-transaksi-saldo-2">Topup saldo pelanggan</label>
                                    </div>
                                </div>
                                <h5 class="fw-bold">Pembayaran</h5>
                                <div class="ms-1 mb-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="check-transaksi-pembayaran-1" value="Membuka Menu Pembayaran">
                                        <label class="form-check-label" for="check-transaksi-pembayaran-1">Membuka menu pembayaran</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="check-transaksi-pembayaran-2" value="Melihat Detail Pembayaran">
                                        <label class="form-check-label" for="check-transaksi-pembayaran-2">Melihat detail pembayaran</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="check-transaksi-pembayaran-3" value="Membuat Pembayaran">
                                        <label class="form-check-label" for="check-transaksi-pembayaran-3">Membuat pembayaran</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="check-transaksi-pembayaran-4" value="Mengubah Data Pembayaran">
                                        <label class="form-check-label" for="check-transaksi-pembayaran-4">Mengubah data pembayaran</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="check-transaksi-pembayaran-5" value="Menghapus Pembayaran">
                                        <label class="form-check-label" for="check-transaksi-pembayaran-5">Menghapus pembayaran</label>
                                    </div>
                                </div>
                                <h5 class="fw-bold">History</h5>
                                <div class="ms-1 mb-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="check-transaksi-history-1" value="Melihat Detail History Transaksi Pelanggan">
                                        <label class="form-check-label" for="check-transaksi-history-1">Melihat history transaksi pelanggan</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="check-transaksi-history-2" value="Melihat Detail History Saldo Pelanggan">
                                        <label class="form-check-label" for="check-transaksi-history-2">Melihat history saldo pelanggan</label>
                                    </div>
                                </div>
                                <h5 class="fw-bold">Cancelled</h5>
                                <div class="ms-1 mb-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="check-transaksi-cancelled-1" value="Membuka Menu Canceled">
                                        <label class="form-check-label" for="check-transaksi-cancelled-1">Membuka menu cancelled</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="check-transaksi-cancelled-2" value="Merestore Transaksi">
                                        <label class="form-check-label" for="check-transaksi-cancelled-2">Memulihkan transaksi</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-xl-3">
                        <div class="card h-100" id="card-proses">
                            <div class="card-body">
                                <h4>Proses</h4>
                                <hr>
                                <h5 class="fw-bold">Cuci</h5>
                                <div class="ms-1 mb-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="check-proses-cuci-1" value="Membuka Menu Hub Cuci">
                                        <label class="form-check-label" for="check-proses-cuci-1">Membuka menu hub cuci</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="check-proses-cuci-2" value="Mengambil Tugas Cuci">
                                        <label class="form-check-label" for="check-proses-cuci-2">Mengambil tugas cuci</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="check-proses-cuci-3" value="Mengurangi Tugas Cuci">
                                        <label class="form-check-label" for="check-proses-cuci-3">Mengurangi tugas cuci</label>
                                    </div>
                                </div>
                                <h5 class="fw-bold">Setrika</h5>
                                <div class="ms-1 mb-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="check-proses-setrika-1" value="Membuka Menu Hub Setrika">
                                        <label class="form-check-label" for="check-proses-setrika-1">Membuka menu hub setrika</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="check-proses-setrika-2" value="Mengambil Tugas Setrika">
                                        <label class="form-check-label" for="check-proses-setrika-2">Mengambil tugas setrika</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="check-proses-setrika-3" value="Mengurangi Tugas Setrika">
                                        <label class="form-check-label" for="check-proses-setrika-3">Mengurangi tugas setrika</label>
                                    </div>
                                </div>
                                <h5 class="fw-bold">Rewash</h5>
                                <div class="ms-1 mb-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="check-proses-rewash-1" value="Membuka Menu Proses Rewash">
                                        <label class="form-check-label" for="check-proses-rewash-1">Membuka menu rewash</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="check-proses-rewash-2" value="Menambah Data Proses Rewash">
                                        <label class="form-check-label" for="check-proses-rewash-2">Menambah rewash</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="check-proses-rewash-3" value="Menyatakan Selesai Proses Rewash">
                                        <label class="form-check-label" for="check-proses-rewash-3">Menyatakan rewash selesai</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="check-proses-rewash-4" {{-- value="Menghapus Data Proses Rewash" --}}>
                                        <label class="form-check-label text-danger" for="check-proses-rewash-4">Menghapus rewash</label>
                                    </div>
                                </div>
                                <h5 class="fw-bold">Packing</h5>
                                <div class="ms-1 mb-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="check-proses-packing-1" value="Membuka Menu Packing">
                                        <label class="form-check-label" for="check-proses-packing-1">Membuka menu packing</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="check-proses-packing-2" value="Menginputkan Data Packing">
                                        <label class="form-check-label" for="check-proses-packing-2">Menginputkan data packing</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="text-end"><button class="btn btn-primary" id="save-permission" type="button"><i class="fas fa-save"></i>&nbsp;Simpan</button></div>
            </div>
        </div>
    </section>
    @endif
</div>

<script src="{{ asset('js/pengaturan/karyawan.js') }}"></script>
@endsection
