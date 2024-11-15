@extends('layouts.users')
@include('includes.library.intro_js')
@section('content')
<input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
<div class="container">
    <header class="my-3 d-flex justify-content-between" style="color: var(--bs-gray);">
        <div class="d-flex align-items-center">
            <a>Transaksi</a>
            <i class="fas fa-angle-right mx-2"></i>
            <a>Premium</a>
        </div>
        <button class="btn btn-primary btn-sm" data-bs-toggle="tooltip" data-bss-tooltip="" id="show-option" type="button" title="Show options">
            <i class="fas fa-cog"></i>
        </button>
    </header>

    <div class="modal fade" role="dialog" tabindex="-1" id="modal-opsi-trans">
        <div class="modal-dialog modal-xl modal-dialog-centered modal-fullscreen-sm-down" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Opsi Transaksi</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="d-flex mb-3">
                        <input class="form-control" type="search" id="input-key-trans" placeholder="Kata kunci">

                        @if(in_array("Membuat Transaksi", Session::get('permissions')) || Session::get('role') == 'administrator')
                            <button class="btn btn-primary ms-3" data-bs-toggle="tooltip" data-bss-tooltip="" id="add-new-trans" type="button" title="Buat transaksi baru">
                                <i class="fas fa-plus"></i>
                            </button>
                        @endif
                    </div>
                    @if(in_array("Melihat Detail Transaksi", Session::get('permissions')) || Session::get('role') == 'administrator')
                        <div id="container-list-trans"></div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div role="dialog" id="modal-new-trans" tabindex="-1" class="modal fade">
        <div class="modal-dialog modal-xl modal-dialog-centered modal-fullscreen-sm-down" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Transaksi Baru</h4>
                    <button type="button" class="btn btn-sm btn-primary" id="new-trans-back" data-bs-dismiss="modal" aria-label="">Kembali</button>
                </div>
                <div class="modal-body">
                    <section id="section-info-pelanggan-2">
                        <header class="d-flex align-items-center">
                            <h4>Pelanggan</h4>
                        </header>
                        <div id="info-pelanggan-2" class="mt-2">
                            <div class="mb-2 position-relative">
                                <button class="btn btn-primary" id="search-pelanggan-2" type="button"><i class="fas fa-search"></i> Cari Pelanggan</button>
                                <div class="position-absolute card card-body w-100 mt-2" style="background-color: white; min-height: 342px; display: none;">
                                    <form class="mb-3">
                                        <div class="d-flex">
                                            <input type="search" class="form-control" id="input-nama-pelanggan-2" placeholder="Nama pelanggan" />
                                            <a href="/data/pelanggan" class="ms-3"><button class="btn btn-primary" data-bs-toggle="tooltip" id="new-pelanggan-2" type="button" title="Pelanggan baru"><i class="fas fa-plus"></i></button></a>
                                        </div>
                                    </form>
                                    <div id="table-list-pelanggan-2" class="overflow-auto"></div>
                                </div>
                            </div>
                            <form id="data-pelanggan-2">
                                <div class="row">
                                    <input type="hidden" id="input-id-2" />
                                    <div class="col-12 mb-2">
                                        <h5>Nama</h5>
                                        <input type="text" class="form-control disabled" id="input-nama-2" />
                                    </div>
                                    <div class="col-12 mb-2">
                                        <h5>Alamat</h5>
                                        <input type="text" class="form-control disabled" id="input-alamat-2" />
                                    </div>
                                    <div class="col-12 mb-2">
                                        <h5>Telepon</h5>
                                        <input type="text" class="form-control disabled" id="input-telepon-2" />
                                    </div>
                                    <div class="col-12 mb-2">
                                        <h5>Member</h5>
                                        <input type="text" class="form-control disabled" id="input-member-2" />
                                    </div>
                                    <div class="col-12 mb-2">
                                        <h5>Saldo Deposit</h5>
                                        <input type="date" class="form-control disabled" id="input-Saldo-2" />
                                    </div>
                                </div>
                            </form>
                        </div>
                    </section>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary" type="button" id="create-trans">Create trans</button>
                </div>
            </div>
        </div>
    </div>

    <div>
        <ul role="tablist" class="nav nav-tabs border-bottom-0">
            <li role="presentation" id="nav-trans" class="nav-item"><a role="tab" data-bs-toggle="tab" class="nav-link active" href="#tab-transaksi">Transaksi</a></li>
            <li role="presentation" id="nav-pembayaran" class="nav-item"><a role="tab" data-bs-toggle="tab" class="nav-link" href="#tab-pembayaran">Pembayaran</a></li>
            <li role="presentation" id="nav-log" class="nav-item"><a role="tab" data-bs-toggle="tab" class="nav-link" href="#tab-log">Log</a></li>
        </ul>
        <div class="tab-content">
            <div role="tabpanel" class="tab-pane active" id="tab-transaksi">
                <section id="section-transaksi-premium" class="section-detail-transaksi">
                    <div class="card">
                        <div class="card-body">
                            <header>
                                <h3>Kode Transaksi : <span id="kode-trans"></span><span id="id-trans" class="d-none"></span></h3>
                            </header>
                            <div id="table-container"></div>

                            <ul class="list-unstyled form-control" id="list-action">
                                @if(in_array("Mengubah Data Item Transaksi", Session::get('permissions')) || Session::get('role') == 'administrator')
                                    <li id="action-change-qty">Rubah qty item</li>
                                @endif
                                @if(in_array("Melihat Detail Daftar Catatan Item", Session::get('permissions')) || Session::get('role') == 'administrator')
                                    <li id="action-notes">Catatan item</li>
                                @endif
                                @if(in_array("Menghapus Item Transaksi", Session::get('permissions')) || Session::get('role') == 'administrator')
                                    <li id="action-delete">Hapus item</li>
                                @endif
                            </ul>

                            @if(in_array("Mengubah Data Transaksi", Session::get('permissions')) || Session::get('role') == 'administrator')
                                <form method="POST" id="form-transaksi" class="mb-0">
                            @else
                                <form method="POST" id="form-transaksi" class="mb-0 disabled">
                            @endif
                                @csrf
                                <div class="row">
                                    <div class="col-md-4 col-12 mt-2">
                                        <h5>Parfum</h5>
                                        <select class="form-select-sm form-control" id="input-parfum" name="parfum_id" required>
                                            <option value="" selected hidden>-</option>
                                            @foreach ($data['parfum'] as $parfum)
                                                <option value="{{ $parfum->id }}">{{ $parfum->nama }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-4 col-12 mt-2">
                                        <div class="d-flex justify-content-center align-items-end h-100">
                                            <div class="form-check me-1">
                                                <input class="form-check-input" type="checkbox" id="formCheck-express" name="express" value=0>
                                                <label class="form-check-label" for="formCheck-express">Express</label>
                                            </div>
                                            <div class="form-check me-1">
                                                <input class="form-check-input" type="checkbox" id="formCheck-ontime" name="on_time" value=0>
                                                <label class="form-check-label" for="formCheck-ontime">On Time</label>
                                            </div>
                                            <div class="form-check ms-1">
                                                <input class="form-check-input" type="checkbox" id="formCheck-setrika" name="setrika_only" value=0>
                                                <label class="form-check-label" for="formCheck-setrika">Setrika only</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-12 mt-2 d-flex align-items-end justify-content-end">
                                        <button class="btn btn-primary full-when-small" id="kode-promo" type="button">Kode Promosi</button>
                                    </div>
                                    <div class="col-md-4 col-12 mt-2 d-flex align-items-center">
                                        <div class="position-relative w-100">
                                            <button class="btn btn-primary full-when-small" id="show-catatan-trans" type="button" style="width: 200px;">Catatan Transaksi</button>
                                            <div class="position-absolute w-100 card p-2" style="z-index: 1;display: none; box-shadow: rgba(0, 0, 0, 0.15) 1.95px 1.95px 2.6px;">
                                                <textarea class="form-control" id="input-catatan-trans" name="catatan_transaksi" style="height: 300px;"></textarea>
                                                <button class="btn btn-primary" id="save-catatan-trans" type="button">Simpan Catatan</button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-12 mt-2 d-flex align-items-center justify-content-center">
                                        <div class="d-flex align-items-center">
                                            <p class="me-3" style="white-space: nowrap">Tanggal Selesai</p>
                                            @if(in_array("Mengubah Data Transaksi", Session::get('permissions')) || Session::get('role') == 'administrator')
                                                <input class="form-control" id="tanggal-selesai-proses" type="date" name="done_date">
                                            @else
                                                <input class="form-control disabled" id="tanggal-selesai-proses" type="date" name="done_date">
                                            @endif
                                        </div>
                                    </div>
                                    <input type="hidden" name="tipe_transaksi" value="premium">
                                    <div class="col-md-4 col-12 mt-2 d-flex align-items-center justify-content-end">
                                        @if(in_array("Membatalkan Transaksi", Session::get('permissions')) || Session::get('role') == 'administrator')
                                        <button id="cancel-trans" class="btn btn-danger full-when-small" type="button">Cancel</button>
                                        @endif
                                        @if(Session::get('role') == 'delivery' || Session::get('role') == 'administrator')
                                            <button id="print-tanda-terima" class="btn btn-outline-primary full-when-small ms-2" type="button">Print tanda terima</button>
                                        @endif
                                        @if(in_array("Mengubah Data Transaksi", Session::get('permissions')) || Session::get('role') == 'administrator')
                                            <button id="save-trans" class="btn btn-primary full-when-small ms-2" type="submit">Simpan</button>
                                        @endif
                                    </div>
                                </div>
                            </form>

                            <div role="dialog" tabindex="-1" class="modal fade" id="modal-kode-promo">
                                <div class="modal-dialog modal-lg modal-dialog-centered modal-fullscreen-sm-down" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h4 class="modal-title">Promo Diskon</h4>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div id="promo-biasa">
                                                <h5>Kode Diskon</h5>
                                                <div class="d-flex">
                                                    <input id="input-kode-diskon" class="form-control me-3" type="text" name="diskon_code">
                                                    <button class="btn btn-primary" type="button" id="btn-apply-promo-basic">
                                                        <i class="fa-solid fa-magnifying-glass"></i>
                                                    </button>
                                                </div>
                                                <p class="error-promo-basic"></p>
                                            </div>
                                            <div id="active-promo" style="display: none;">
                                                <hr>
                                                <h5>Diskon Aktif</h5>
                                                <div class="d-flex mt-2">
                                                    <div class="me-2" id="diskon-1">
                                                        <div class="btn-group" role="group">
                                                            <button type="button" class="btn btn-primary">
                                                                <span class="kode-diskon"></span>
                                                                &nbsp;-&nbsp;
                                                                <span class="info-diskon"></span>
                                                            </button>
                                                            <button type="button" class="btn btn-danger cancel-diskon">
                                                                <i class="fa-solid fa-xmark"></i>
                                                            </button>
                                                          </div>
                                                    </div>
                                                    <div class="me-2" id="diskon-2">
                                                        <div class="btn-group" role="group">
                                                            <button type="button" class="btn btn-primary">
                                                                <span class="kode-diskon"></span>
                                                                &nbsp;-&nbsp;
                                                                <span class="info-diskon"></span>
                                                            </button>
                                                            <button type="button" class="btn btn-danger cancel-diskon">
                                                                <i class="fa-solid fa-xmark"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                    <div class="me-2" id="diskon-member">
                                                        <div class="btn-group" role="group">
                                                            <button type="button" class="btn btn-member">
                                                                <span class="kode-diskon">Member</span>
                                                                &nbsp;-&nbsp;
                                                                <span class="info-diskon">10 %</span>
                                                            </button>
                                                            <button type="button" class="btn btn-toogle">
                                                                <i class="fa-solid fa-toggle-on" style="display: none;"></i>
                                                                <i class="fa-solid fa-toggle-off" style="display: none;"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div role="dialog" tabindex="-1" class="modal fade" id="modal-add-item">
                                <div class="modal-dialog modal-lg modal-dialog-centered modal-fullscreen-sm-down" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h4 class="modal-title">Pilih Item</h4>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="d-flex mb-3">
                                                <input class="form-control" type="search" id="input-nama-item" placeholder="Nama Item">
                                            </div>
                                            <div id="container-search-item"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div role="dialog" tabindex="-1" class="modal fade" id="modal-list-catatan-item">
                                <div class="modal-dialog modal-lg modal-dialog-centered modal-fullscreen-sm-down" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h4 class="modal-title">Catatan Item</h4><button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body position-relative">
                                            <div id="table-catatan-item"></div>
                                            <ul class="list-unstyled form-control list-action" id="list-action-2">
                                                <li id="action-detail">Detail Catatan</li>
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
                        </div>
                    </div>
                </section>
                <section id="section-info" class="mt-4">
                    <div class="card">
                        <div class="card-body pb-0">
                            <h5 class="card-title">Informasi</h5>
                            <hr class="mb-0">
                            <div class="row">
                                <div class="g-0 col col-xl-4 col-md-6 col-12 position-relative">
                                    <div class="h-100 border-end" style="padding: 1rem .75rem;">
                                        <section id="section-info-pelanggan">
                                            <header class="d-flex justify-content-between align-items-center">
                                                <h5>Pelanggan</h5>
                                                <button class="btn show-data" id="show-data-pelanggan" type="button">
                                                    <i class="fas fa-chevron-down large"></i>
                                                </button>
                                            </header>
                                            <div id="info-pelanggan" class="mt-2" style="display: none;">
                                                <div class="modal fade" role="dialog" tabindex="-1" id="modal-list-pelanggan">
                                                    <div class="modal-dialog modal-lg modal-dialog-centered modal-fullscreen-sm-down" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h4 class="modal-title">Cari Pelanggan</h4>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <form class="mb-3">
                                                                    <div class="d-flex">
                                                                        <input class="form-control" type="search" id="input-nama-pelanggan" placeholder="Nama Pelanggan">
                                                                        <button class="btn btn-primary mx-3" data-bs-toggle="tooltip" data-bss-tooltip="" id="search-nama-pelanggan" type="button" title="Cari transaksi">
                                                                            <i class="fas fa-search"></i>
                                                                        </button>
                                                                        <button class="btn btn-primary" data-bs-toggle="tooltip" data-bss-tooltip="" id="add-new-pelanggan" type="button" title="Buat transaksi baru">
                                                                            <i class="fas fa-plus"></i>
                                                                        </button>
                                                                    </div>
                                                                </form>
                                                                <div class="table-responsive">
                                                                    <table class="table table-striped table-hover" id="table-list-pelanggan">
                                                                        <thead class="text-center">
                                                                            <tr>
                                                                                <th>Nama</th>
                                                                                <th>Tanggal Lahir</th>
                                                                                <th>Alamat</th>
                                                                                <th>Membership</th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody style="cursor: pointer">
                                                                            @foreach ($data['pelanggan'] as $pelanggan)
                                                                            <tr id="row-{{ $pelanggan->id }}" data-bs-toggle="tooltip" data-bss-tooltip="" title="Double klik untuk memilih">
                                                                                <td>{{ $pelanggan->nama }}</td>
                                                                                <td class="text-center">{{ $pelanggan->tanggal_lahir }}</td>
                                                                                <td>{{ $pelanggan->alamat }}</td>
                                                                                <td class="text-center">
                                                                                @if($pelanggan->member)
                                                                                    Member
                                                                                @else
                                                                                    Bukan member
                                                                                @endif
                                                                                </td>
                                                                            </tr>
                                                                            @endforeach
                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <form id="data-pelanggan">
                                                    <div class="row">
                                                        <div class="col-12 mb-2">
                                                            <h6>Nama</h6>
                                                            <input class="form-control disabled" type="text" id="input-nama" name="username">
                                                        </div>
                                                        <div class="col-12 mb-2">
                                                            <h6>Alamat</h6>
                                                            <input class="form-control disabled" type="text" id="input-alamat">
                                                        </div>
                                                        <div class="col-12 mb-2">
                                                            <h6>Telepon</h6>
                                                            <input class="form-control disabled" type="text" id="input-telepon">
                                                        </div>
                                                        <div class="col-12 mb-2">
                                                            <h6>Status Membership</h6>
                                                            <input class="form-control disabled" type="text" id="input-member">
                                                        </div>
                                                        <div class="col-12 mb-2">
                                                            <h6>Saldo</h6>
                                                            <div class="form-control disabled d-flex justify-content-between">
                                                                <p>Rp</p>
                                                                <input class="text-end input-thousand-separator" type="text" id="input-saldo">
                                                            </div>
                                                        </div>
                                                        <div class="col-12">
                                                            <h6>Catatan Pelanggan</h6>
                                                            <textarea class="form-control disabled" style="resize: none;" id="input-catatan-pelanggan"></textarea>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </section>
                                    </div>
                                </div>
                                <div class="g-0 col col-xl-4 col-md-6 col-12 position-relative">
                                    <div class="h-100 border-end" style="padding: 1rem .75rem;">
                                        <section id="section-info-pickup-delivery" class="h-100">
                                            <header class="d-flex justify-content-between align-items-center">
                                                <h5 class="d-flex justify-content-between align-items-center">Pickup &amp; Delivery</h5>
                                                <button class="btn show-data" id="show-data-pickup-delivery" type="button">
                                                    <i class="fas fa-chevron-down large"></i>
                                                </button>
                                            </header>
                                            <div id="info-pickup-delivery" class="mt-2" style="display: none;">
                                                <div class="mb-5 disabled">
                                                    <div class="form-check" id="check-pickup" style="margin-bottom: .5rem;" class="disabled">
                                                        <input class="form-check-input" type="checkbox" id="formCheck-pickup">
                                                        <label class="form-check-label" for="formCheck-pickup">Pickup</label>
                                                    </div>
                                                    <div id="container-pickup" class="position-relative mb-2" style="display: none;">
                                                        <h6>Kode Pickup</h6>
                                                        <input type="text" name="" id="input-kode-pickup" class="form-control" readonly>
                                                        <h6>Driver</h6>
                                                        <input type="text" name="" id="input-driver-pickup" class="form-control" readonly>
                                                    </div>
                                                    <div class="form-check" id="check-delivery" style="margin-bottom: .5rem;">
                                                        <input class="form-check-input" type="checkbox" id="formCheck-delivery" />
                                                        <label class="form-check-label" for="formCheck-delivery">Delivery</label>
                                                    </div>
                                                    <div id="container-delivery" class="position-relative mb-2 d-none">
                                                        <h6>Kode Delivery</h6>
                                                        <select class="form-control" id="select-kode-delivery" disabled>
                                                            <option value="" selected hidden>-</option>
                                                            @foreach ($data['delivery'] as $delivery)
                                                                <option value="{{ $delivery->id }}">{{ $delivery->kode }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="position-absolute" style="right: 1rem; bottom: 1rem;">
                                                    <button class="btn btn-primary d-flex full-when-small" id="to-pickup-delivery">Edit<span class="d-lg-block d-none">&nbsp;Pickup & Delivery</span></button>
                                                </div>
                                            </div>
                                        </section>
                                    </div>
                                </div>
                                <div class="g-0 col col-xl-4 col-md-6 col-12 position-relative">
                                    <div class="h-100" style="padding: 1rem .75rem;">
                                        <section id="section-info-penerimaan" class="h-100">
                                            <header>
                                                <h5 class="d-flex justify-content-between align-items-center">
                                                    Penerimaan
                                                    <button class="btn show-data" id="show-data-penerimaan" type="button">
                                                        <i class="fas fa-chevron-down large"></i>
                                                    </button>
                                                </h5>
                                            </header>
                                            <div id="info-penerimaan" class="mt-2" style="display: none;">
                                                <form id="form-penerimaan" enctype="multipart/form-data">
                                                    @if(in_array("Menambahkan Penerima Ke Transaksi", Session::get('permissions')) || Session::get('role') == 'administrator')
                                                        <div class="mb-5">
                                                    @else
                                                        <div class="mb-5 disabled">
                                                    @endif
                                                        <h6 class="mt-2">Outlet Ambil</h6>
                                                        <select class="form-control" id="select-outlet-ambil" required>
                                                            <option value="0">-</option>
                                                            @foreach ($data['outlet'] as $outlet)
                                                                <option value="{{ $outlet->id }}">{{ $outlet->nama }}</option>
                                                            @endforeach
                                                        </select>
                                                        <h6 class="mt-2">Nama Penerima</h6>
                                                        <input type="text" class="form-control" id="input-nama-penerima" name="penerima" required>
                                                        <h6 class="mt-2">Foto Penerima</h6>
                                                        <input type="file" class="form-control" id="input-foto-penerima" name="image" accept="image/*" required>
                                                    </div>
                                                    <div class="position-absolute" style="right: 1rem; bottom: 1rem;">
                                                        @if(in_array("Menambahkan Penerima Ke Transaksi", Session::get('permissions')) || Session::get('role') == 'administrator')
                                                            <button class="btn btn-primary full-when-small" id="simpan-info-penerimaan" type="submit">Simpan Penerimaan</button>
                                                        @endif
                                                        <button type="button" id="btn-show-foto_penerima" class="btn btn-primary" style="display: none;" data-url="">Tampilkan Foto</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </section>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
            <div role="tabpanel" class="tab-pane" id="tab-pembayaran">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped" id="table-pembayaran">
                                <thead>
                                    <tr>
                                        <th>Nama</th>
                                        <th>Kategori</th>
                                        <th colspan="2">Harga</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="2" class="text-end">Sub Total</td>
                                        <td>Rp</td>
                                        <td class="thousand-separator text-end" id="pembayaran-subtotal"></td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" class="text-end">Diskon</td>
                                        <td>Rp</td>
                                        <td class="thousand-separator text-end" id="pembayaran-diskon"></td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" class="text-end">Grand Total</td>
                                        <td>Rp</td>
                                        <td class="thousand-separator text-end" id="pembayaran-grand-total"></td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                        <div class="d-flex justify-content-end align-items-center">
                            <button id="btn-bayar" class="btn btn-primary me-2">Bayar</button>
                            <button id="btn-print" class="btn btn-primary">Print Nota</button>
                        </div>
                        <input type="hidden" id="terbayar" value="0">
                    </div>
                </div>
                <div role="dialog" tabindex="-1" class="modal fade" id="modal-pembayaran">
                    <div class="modal-dialog modal-lg modal-dialog-centered modal-fullscreen-sm-down" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title">Pembayaran <span class="kode-trans">kode trans</span></h4><button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <form id="form-pembayaran" method="POST" action="/transaksi/pembayaran">
                                @csrf
                                <div class="modal-body">
                                    <div class="row">
                                        <input id="input-trans-id" type="hidden" name="transaksi_id" value >
                                        <div class="col-3 text-end mb-4">
                                            <h1>Total :</h1>
                                        </div>
                                        <div class="col-9 mb-4">
                                            <input type="text" class="form-control h-100 extra-large disabled input-thousand-separator" id="input-total" />
                                        </div>
                                        <div class="col-3 mb-2">
                                            <p class="d-flex align-items-center justify-content-end" style="height: 38px;">Metode Pembayaran :</p>
                                        </div>
                                        <div class="col-9 mb-2">
                                            <select class="form-select" name="metode_pembayaran" id="input-metode-pembayaran" required>
                                                <option value hidden selected>-</option>
                                                <option value="tunai">Tunai</option>
                                                <option value="qris">Qris</option>
                                                <option value="debit">Debit</option>
                                                <option value="transfer">Transfer</option>
                                            </select>
                                        </div>
                                        <div class="col-3 mb-2">
                                            <p class="d-flex align-items-center justify-content-end" style="height: 38px;" >Nominal :</p>
                                        </div>
                                        <div class="col-9 mb-2">
                                            <input type="text" class="form-control input-thousand-separator" id="input-nominal" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" name="nominal" required />
                                        </div>
                                        <div class="col-3 mb-2">
                                            <p class="d-flex align-items-center justify-content-end fw-bold" style="height: 38px;">Total Terbayar :</p>
                                        </div>
                                        <div class="col-9 mb-2">
                                            <input type="text" class="form-control disabled input-thousand-separator" id="input-terbayar" />
                                        </div>
                                        <div class="col-3 mb-2">
                                            <p class="d-flex align-items-center justify-content-end fw-bold" style="height: 38px;">Kembali :</p>
                                        </div>
                                        <div class="col-9 mb-2">
                                            <input type="text" class="form-control disabled input-thousand-separator" id="input-kembalian" />
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer"><button class="btn btn-primary" type="submit">Simpan</button></div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div role="tabpanel" class="tab-pane" id="tab-log">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped" id="table-log">
                                <thead>
                                    <tr>
                                        <th>Time</th>
                                        <th>Penanggung Jawab</th>
                                        <th>Proses</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="{{ asset('js/transaksi/premium.js') }}"></script>
@endsection
