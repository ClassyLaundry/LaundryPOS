@extends('layouts.users')

@section('content')
<style>
    #nama-pelanggan::-webkit-calendar-picker-indicator {
        display: none!important;
    }
</style>

<div class="container">
    <section id="section-transaksi-saldo">
        <header class="my-3" style="color: var(--bs-gray);">
            <a>Transaksi</a>
            <i class="fas fa-angle-right mx-2"></i>
            <a>Saldo</a>
        </header>
        <div class="card">
            <div class="card-body">
                <h1 class="card-title">Saldo</h1>
                <hr />
                <div class="row">
                    <div class="col-lg-9" id="info-paket">
                        <div class="row" id="paket-container">
                            @foreach ($paket_deposits as $paket)
                            <div class="col-xl-3 col-lg-4 col-md-6 col-12 mb-3">
                                <div class="card" id="{{ $paket->id }}">
                                    <div class="card-body d-flex flex-column justify-content-between">
                                        <h4 class="card-title">{{ $paket->nama }}</h4>
                                        <div>
                                            <h6 class="mb-2 d-flex justify-content-between nominal-paket">Nominal: <span class="thousand-separator">{{ $paket->nominal }}</span></h6>
                                            <h6 class="mb-2 text-muted d-flex justify-content-between harga-paket">Harga: <span class="thousand-separator">{{ $paket->harga }}</span></h6>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                            <div class="col-xl-3 col-lg-4 col-md-6 col-12 mb-3">
                                <div class="card" id="1">
                                    <div class="card-body d-flex flex-column justify-content-between">
                                        <h4 class="card-title mb-1">Manual</h4>
                                        <input id="input-manual" type="number" class="form-control mb-2" min="0" value="0" />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr class="d-lg-none">
                    <div class="col-lg-3 border-lg-start border-0" id="info-pelanggan">
                        <form id="form-saldo">
                            <div class="mb-2">
                                <h5>Pelanggan</h5>
                                <div>
                                    <input id="nama-pelanggan" list="data-pelanggan" class="form-control" required>
                                    <datalist id="data-pelanggan">
                                        @foreach ($pelanggans as $pelanggan)
                                            <option data-id="{{ $pelanggan->id }}">{{ $pelanggan->id }} - {{ $pelanggan->nama }}</option>
                                        @endforeach
                                    </datalist>
                                </div>
                            </div>
                            <div class="mb-2">
                                <h5>Saldo Akhir</h5>
                                <input id="input-saldo-akhir" type="text" class="form-control disabled" required />
                            </div>
                            <input id="input-dibayarkan" type="hidden" class="form-control disabled" required />
                            @if(in_array("Topup Saldo Pelanggan", Session::get('permissions')) || Session::get('role') == 'administrator')
                            <div class="text-end">
                                <button id="submit-saldo" class="btn btn-primary" type="submit">Beli</button>
                            </div>
                            @endif
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div role="dialog" tabindex="-1" class="modal fade" id="modal-pembayaran">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Pembayaran <span class="kode-trans">kode trans</span></h4><button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="form-pembayaran">
                    @csrf
                    <div class="modal-body">
                        <div class="alert alert-danger alert-dismissible fade show" role="alert" id="alert-saldo">
                            Saldo kurang dari 100.000
                        </div>
                        <div class="alert alert-info alert-dismissible fade show" role="alert" id="alert-member">
                            Pelanggan belum menjadi member
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
                                <select class="form-select" name="metode_pembayaran" required>
                                    <option value hidden selected>-</option>
                                    <option value="tunai">Tunai</option>
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
                        </div>
                    </div>
                    <div class="modal-footer"><button id="btn-save" class="btn btn-primary" type="submit">Simpan</button></div>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="{{ asset('js/transaksi/saldo.js') }}"></script>
@endsection
