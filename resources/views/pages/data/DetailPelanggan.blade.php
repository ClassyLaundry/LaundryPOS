@extends('layouts.users')

@section('content')
<div class="container">
    <header class="d-flex align-items-center my-3" style="color: var(--bs-gray);"><a>Master Data</a><i class="fas fa-angle-right mx-2"></i><a>Data Pelanggan</a></header>
    <section id="data-pelanggan" class="mb-3">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Data Pelanggan</h4>
                <hr>
                <form id="modal-form" action="/data/pelanggan/{{ $pelanggan->id }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-12 mb-2">
                            <h5>Nama Lengkap*</h5>
                            <input class="form-control" type="text" id="input-nama-pelanggan" name="nama" value="{{ $pelanggan->nama }}" required disabled>
                        </div>
                        <div class="col-12 col-lg-4 mb-2">
                            <h5>Tanggal Lahir</h5>
                            <input class="form-control" id="input-tanggal-lahir" type="date" name="tanggal_lahir" value="{{ $pelanggan->tanggal_lahir }}" disabled>
                        </div>
                        <div class="col-12 col-lg-4 mb-2">
                            <h5>Jenis Kelamin</h5>
                            <div class="form-control d-flex align-items-center justify-content-around">
                                <div class="form-check">
                                    <input type="radio" class="form-check-input" id="formCheck-pria" name="gender" value='pria' @if ($pelanggan->gender == "pria") checked @endif required disabled/>
                                    <label class="form-check-label" for="formCheck-pria">Pria</label>
                                </div>
                                <div class="form-check">
                                    <input type="radio" class="form-check-input" id="formCheck-wanita" name="gender" value='wanita' @if ($pelanggan->gender == "wanita") checked @endif disabled/>
                                    <label class="form-check-label" for="formCheck-wanita">Wanita</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-lg-4 mb-2">
                            <h5>Tipe Member</h5>
                            <div class="form-control d-flex align-items-center justify-content-around">
                                <div class="form-check">
                                    <input type="radio" class="form-check-input" id="formCheck-member" name="member" value=1 @if ($pelanggan->member) checked @endif required disabled/>
                                    <label class="form-check-label" for="formCheck-member">Member</label>
                                </div>
                                <div class="form-check">
                                    <input type="radio" class="form-check-input" id="formCheck-non-member" name="member" value=0 @if (!$pelanggan->member) checked @endif disabled/>
                                    <label class="form-check-label" for="formCheck-non-member">Bukan member</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 mb-2">
                            <h5>Alamat*</h5>
                            <input class="form-control" type="text" id="input-alamat" name="alamat" value="{{ $pelanggan->alamat }}" required disabled>
                        </div>
                        <div class="col-12 col-sm-6 mb-2">
                            <h5>Jenis Identitas</h5>
                            <select class="form-select" id="input-jenis-identitas" name="jenis_id" value="{{ $pelanggan->jenis_id }}" disabled>
                                <option value='' disabled hidden>-</option>
                                <option value="ktp">KTP</option>
                                <option value="sim">SIM</option>
                            </select>
                        </div>
                        <div class="col-12 col-sm-6 mb-2">
                            <h5>Nomor Identitas</h5>
                            <input class="form-control" type="text" id="input-nomor-identitas" name="no_id" value="{{ $pelanggan->no_id }}"  oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" disabled>
                        </div>
                        <div class="col-12 col-lg-6 mb-2">
                            <h5>Telephone*</h5>
                            <input class="form-control" type="text" id="input-telepon" name="telephone" value="{{ $pelanggan->telephone }}" required oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" disabled>
                        </div>
                        <div class="col-12 col-lg-6 mb-2">
                            <h5>E-mail</h5>
                            <input class="form-control" type="text" id="input-email" name="email" value="{{ $pelanggan->email }}" disabled>
                        </div>
                        <div class="col-12 mb-2">
                            <h5>Catatan Pelanggan</h5>
                            <textarea class="form-control" id="input-catatan-khusus" name="catatan_khusus" disabled></textarea>
                        </div>
                        {{-- <div class="col-12 col-lg-4 mb-2">
                            <h5>Status</h5>
                            <div class="form-control d-flex align-items-center justify-content-around">
                                <div class="form-check">
                                    <input type="radio" class="form-check-input" id="formCheck-aktif" name="status" value=1 @if ($pelanggan->status) checked @endif required />
                                    <label class="form-check-label" for="formCheck-aktif">Aktif</label>
                                </div>
                                <div class="form-check">
                                    <input type="radio" class="form-check-input" id="formCheck-tidakAktif" name="status" value=0 @if (!$pelanggan->status) checked @endif />
                                    <label class="form-check-label" for="formCheck-tidakAktif">Tidak aktif</label>
                                </div>
                            </div>
                        </div> --}}
                    </div>
                    @if(in_array("Mengubah Data Pelanggan", Session::get('permissions')) || Session::get('role') == 'administrator')
                    <hr>
                    <div class="text-end">
                        <button class="btn btn-primary" id="btn-ubah" type="button">Ubah Data</button>
                        <button class="btn btn-primary" type="submit" style="display: none;">Simpan</button>
                    </div>
                    @endif
                </form>
            </div>
        </div>
    </section>


    @if(in_array("Membuka Menu Pembayaran", Session::get('permissions')) || Session::get('role') == 'administrator')
    <div class="card">
        <div class="card-body">
            <section id="data-tagihan" class="mb-3">
                <div class="d-flex align-items-center">
                    <h4 class="me-4">Tagihan</h4>
                    <h5>Rp<span class="thousand-separator ms-2">{{ $pelanggan->tagihan }}</span></h5>
                    <button class="btn btn-primary btn-sm ms-4" id="btn-bayar">Bayar</button>
                </div>
            </section>

            <div role="dialog" tabindex="-1" class="modal fade" id="modal-pembayaran">
                <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Pembayaran <span class="kode-trans">kode trans</span></h4><button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form id="form-pembayaran" method="POST" action="/transaksi/pembayaran-tagihan">
                            @csrf
                            <div class="modal-body">
                                {{-- <div class="alert alert-danger alert-dismissible fade show" role="alert" id="alert-saldo">
                                    Saldo kurang dari 100.000, <a href="/transaksi/saldo" class="alert-link fw-bold" style="text-decoration: underline!important; color: #6a1a21!important;">Top up?</a>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                                <div class="alert alert-info alert-dismissible fade show" role="alert" id="alert-member">
                                    Pelanggan belum menjadi member, <a href="#" class="alert-link fw-bold" style="text-decoration: underline!important; color: #04414d!important;">Daftar membership ?</a>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div> --}}
                                <div class="row">
                                    <input id="input-trans-id" type="hidden" name="transaksi_id" value >
                                    <div class="col-3 text-end mb-4">
                                        <h1>Total :</h1>
                                    </div>
                                    <div class="col-9 mb-4">
                                        <input type="text" class="form-control h-100 extra-large disabled input-thousand-separator" id="input-total" value="{{ $pelanggan->tagihan }}"/>
                                    </div>
                                    <div class="col-3 mb-2">
                                        <p class="d-flex align-items-center justify-content-end" style="height: 38px;">Metode Pembayaran :</p>
                                    </div>
                                    <div class="col-9 mb-2">
                                        <select class="form-select" name="metode_pembayaran" required>
                                            <option value hidden selected>-</option>
                                            <option value="tunai">Tunai</option>
                                            <option value="saldo">Saldo</option>
                                            <option value="kredit">Kredit</option>
                                            <option value="debit">Debit</option>
                                        </select>
                                    </div>
                                    <div class="col-3 mb-2">
                                        <p class="d-flex align-items-center justify-content-end" style="height: 38px;" >Nominal :</p>
                                    </div>
                                    <div class="col-9 mb-2">
                                        <input type="text" class="form-control input-thousand-separator" id="input-nominal" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" name="nominal" required />
                                    </div>
                                    <div class="col-3 mb-2">
                                        <p class="d-flex align-items-center justify-content-end fw-bold" style="height: 38px;">Kembali :</p>
                                    </div>
                                    <div class="col-9 mb-2">
                                        <input type="text" class="form-control disabled input-thousand-separator" id="input-kembalian" />
                                    </div>
                                    <input type="hidden" id="input-pelanggan" name="pelanggan_id" value="{{ $pelanggan->id }}"/>
                                </div>
                            </div>
                            <div class="modal-footer"><button class="btn btn-primary" type="submit">Simpan</button></div>
                        </form>
                    </div>
                </div>
            </div>

            @if(in_array("Melihat Detail History Transaksi Pelanggan", Session::get('permissions')) || Session::get('role') == 'administrator')
            <hr>
            <section id="data-transaksi" class="mb-3">
                <h4 class="card-title">Data Transaksi</h4>
                <div id="table-history-transaksi"></div>
            </section>
            @endif

            @if(in_array("Melihat Detail History Saldo Pelanggan", Session::get('permissions')) || Session::get('role') == 'administrator')
            <hr>
            <section id="data-saldo">
                <h4 class="card-title">Data Saldo</h4>
                <div id="table-history-saldo"></div>
            </section>
            @endif
        </div>
    </div>
    @endif
</div>

<script src="{{ asset('js/data/detailPelanggan.js') }}"></script>
@endsection
