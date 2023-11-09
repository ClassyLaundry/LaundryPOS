@extends('layouts.users')

@section('content')
<div class="container">
    <header class="my-3" style="color: var(--bs-gray);">
        <a>Transaksi</a>
        <i class="fas fa-angle-right mx-2"></i>
        <a>Pembayaran</a>
    </header>
    <section id="section-pembayaran">
        <div class="card">
            <div class="card-body">
                <h4>List Transaksi</h4>
                <hr />

                <div class="d-flex justify-content-between align-items-center">
                    <div class="d-flex align-items-center">
                        Tanggal:
                        <input class="form-control mx-1" id="input-search-by-date" type="date">

                        <button class="btn btn-outline-primary d-none" id="btn-reset">
                            <i class="fa-solid fa-arrows-rotate"></i>
                        </button>
                    </div>
                    <div class="d-flex align-items-center">
                        Search:
                        <input class="form-control ms-1" id="input-search-by-name" type="search" style="max-width: 200px;">
                    </div>
                </div>

                <div id="table-container" class="mt-3"></div>

                <ul class="list-unstyled form-control" id="list-action">
                    @if(in_array("Melihat Detail Pembayaran", Session::get('permissions')) || Session::get('role') == 'administrator')
                        <li id="action-detail">Lihat detail</li>
                    @endif
                    <li id="action-print-nota">Print nota</li>
                    <li id="action-print-memo">Print memo</li>
                    <li id="action-print-kitir">Print kitir</li>
                </ul>
            </div>
        </div>
    </section>

    <div class="modal fade" role="dialog" tabindex="-1" id="modal-detail-trans">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Detail Transaksi <span class="kode-trans">kode trans</span></h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="table-responsive">
                        <table class="table table-striped" id="table-item-transaksi">
                            <thead>
                                <tr>
                                    <th>Nama</th>
                                    <th>Kategori</th>
                                    <th colspan="2">Bobot/Harga</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="2" class="text-end">Sub Total</td>
                                    <td>Rp</td>
                                    <td class="thousand-separator text-end" id="subtotal"></td>
                                </tr>
                                <tr>
                                    <td colspan="2" class="text-end">Diskon</td>
                                    <td>Rp</td>
                                    <td class="thousand-separator text-end" id="diskon"></td>
                                </tr>
                                <tr>
                                    <td colspan="2" class="text-end">Grand Total</td>
                                    <td>Rp</td>
                                    <td class="thousand-separator text-end" id="grand-total"></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button id="btn-bayar" class="btn btn-primary">Bayar</button>
                </div>
            </div>
        </div>
    </div>

    <div role="dialog" tabindex="-1" class="modal fade" id="modal-pembayaran">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Pembayaran <span class="kode-trans">kode trans</span></h4><button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="form-pembayaran" method="POST" action="/transaksi/pembayaran">
                    @csrf
                    <div class="modal-body">
                        <div class="alert alert-danger alert-dismissible fade show" role="alert" id="alert-saldo">
                            Saldo kurang dari 100.000, <a href="/transaksi/saldo" class="alert-link fw-bold" style="text-decoration: underline!important; color: #6a1a21!important;">Top up?</a>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                        <div class="alert alert-info alert-dismissible fade show" role="alert" id="alert-member">
                            Pelanggan belum menjadi member, <a href="#" class="alert-link fw-bold" style="text-decoration: underline!important; color: #04414d!important;">Daftar membership ?</a>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
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
                                    <option value="deposit">Deposit</option>
                                    <option value="tunai">Tunai</option>
                                    <option value="kredit">Kredit</option>
                                    <option value="debit">Debit</option>
                                </select>
                            </div>
                            <input type="hidden" id="input-saldo-pelanggan">
                            <div class="col-3 mb-2">
                                <p class="d-flex align-items-center justify-content-end" style="height: 38px;" >Nominal :</p>
                            </div>
                            <div class="col-9 mb-2">
                                <input type="text" name="nominal" class="form-control input-thousand-separator" id="input-nominal" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" required />
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
                    <div class="modal-footer d-flex justify-content-between">
                        <p>Saldo Pelanggan: <span id="saldo-pelanggan"></span></p>
                        <button class="btn btn-primary" type="submit">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" role="dialog" tabindex="-1" id="modal-cetak-kitir">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Cetak kitir <span id="kode-trans-kitir"></span></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="form-cetak-kitir">
                    <div class="modal-body">
                        <h5>Cetak berapa kitir ?</h5>
                        <input class="form-control" name="cetak" id="input-cetak" type="number" step="1">
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Cetak</button>
                    </div>
                </form>
            </div>
        </div>
      </div>
</div>

<script src="{{ asset('js/transaksi/pembayaran.js') }}"></script>
@endsection
