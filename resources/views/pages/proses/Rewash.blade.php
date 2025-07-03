@extends('layouts.users')

@section('content')
<div class="container">
    <header class="d-flex align-items-center my-3" style="color: var(--bs-gray);"><a>Proses</a><i class="fas fa-angle-right mx-2"></i><a>Rewash</a></header>
    <ul role="tablist" class="nav nav-tabs position-relative border-bottom-0">
        <li role="presentation" class="nav-item"><a role="tab" data-bs-toggle="tab" class="nav-link active" href="#tab-1">Data</a></li>
        <li role="presentation" class="nav-item"><a role="tab" data-bs-toggle="tab" class="nav-link" href="#tab-2">Task Hub</a></li>
    </ul>
    <div class="tab-content">
        <div role="tabpanel" class="tab-pane active" id="tab-1">
            <section id="data-rewash">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Rewash</h4>
                        <hr>
                        <div class="table-responsive">
                            <table class="table" id="table-rewash">
                                <thead>
                                    <tr>
                                        <th>Kode Transaksi</th>
                                        <th>Nama Item</th>
                                        <th>Qty</th>
                                        <th>Jenis Rewash</th>
                                        <th>Keterangan</th>
                                        <th>Status</th>
                                        <th style="width: 46.25px;"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($rewashes as $rewash)
                                        <tr id='{{ $rewash->id }}'>
                                            <td class="text-center">{{ $rewash->item_transaksi->kode_transaksi }}</td>
                                            <td>{{ $rewash->item_transaksi->nama }}</td>
                                            <td class="text-center">{{ $rewash->item_transaksi_qty }}</td>
                                            <td class="text-center">{{ $rewash->jenis_rewash }}</td>
                                            <td>{{ $rewash->keterangan }}</td>
                                            @if ($rewash->status)
                                                <td class="text-center">sudah selesai</td>
                                                <td></td>
                                            @else
                                                <td class="text-center">sedang di proses</td>
                                                <td class="cell-action" style="width: 46.25px;">
                                                    <button id="btn-{{ $rewash->id }}" class="btn btn-primary btn-sm btn-show-action" type="button">
                                                        <i class="fas fa-bars"></i>
                                                    </button>
                                                </td>
                                            @endif
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <ul class="list-unstyled form-control" id="list-action">
                            @if(in_array("Menyatakan Selesai Proses Rewash", Session::get('permissions')) || Session::get('role') == 'administrator')
                            <li id="action-finish">Rewash Selesai</li>
                            @endif
                            <li id="action-receipt">Tanda Terima</li>
                            @if(in_array("Menghapus Data Proses Rewash", Session::get('permissions')) || Session::get('role') == 'administrator')
                            <li id="action-delete">Hapus data</li>
                            @endif
                        </ul>
                        @if(in_array("Menambah Data Proses Rewash", Session::get('permissions')) || Session::get('role') == 'administrator')
                        <button class="btn btn-primary btn-tambah mt-2" type="button">
                            <i class="fas fa-plus-circle"></i>
                            &nbsp;Tambah
                        </button>
                        @endif
                    </div>
                </div>

                <div class="modal fade" role="dialog" tabindex="-1" id="modal-create-rewash">
                    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title">Data Rewash</h4>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <form method="POST" action="/proses/rewash/insert">
                                @csrf
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-3 mb-3">
                                            <h5>Kode Transaksi</h5>
                                            <input type="text" name="kode_transaksi" id="input-rewash-kode" class="form-control" required>
                                        </div>
                                        <div class="col-6 mb-3">
                                            <h5>Jenis Item</h5>
                                            <select name="item_transaksi_id" id="item-trans" class="form-select" required>
                                                <option value hidden selected></option>
                                            </select>
                                        </div>
                                        <div class="col-3 mb-3">
                                            <h5>Quantity Item</h5>
                                            <input type="number" name="item_transaksi_qty" id="qty-rewash" class="form-control" max=1 min=1 step="1" data-bs-toggle="tooltip" data-bs-placement="top" title="" required>
                                        </div>
                                        <div class="col-12 mb-3">
                                            <h5>Alasan Cuci</h5>
                                            <select name="jenis_rewash_id" id="jenis-rewash" class="form-select" required>
                                                <option value hidden selected></option>
                                                @foreach ($jenisRewashes as $jenisRewash)
                                                    <option value="{{ $jenisRewash->id }}">{{ $jenisRewash->keterangan }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-12">
                                            <h5>Keterangan</h5>
                                            <textarea name="keterangan" class="form-control" id="input-deskripsi" style="resize: none;"></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button class="btn btn-primary" type="submit">Simpan</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="modal fade" role="dialog" tabindex="-1" id="modal-opsi-trans">
                    <div class="modal-dialog modal-xl modal-dialog-centered modal-fullscreen-sm-down" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title">Opsi Transaksi</h4>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body" style="min-height: 450px;">
                                <input class="form-control" type="search" id="input-key-trans">
                                @if(in_array("Melihat Detail Transaksi", Session::get('permissions')) || Session::get('role') == 'administrator')
                                    <div id="container-list-trans"></div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>

        <div role="tabpanel" class="tab-pane" id="tab-2">
            <section id="proses-rewash">
                <div id="hub" class="row card d-flex flex-row position-relative border-0">
                    @foreach ($pencucis as $pencuci)
                    <div class="col-12 col-md-6">
                        <div class="p-3 border rounded" style="border: 1px solid rgba(0,0,0,.125);">
                            <h4>Hub {{ $pencuci->name }}</h4>
                            <hr />
                            <div class="hub-list hub-rewash-karyawan">
                                @foreach ($rewashes as $rewash)
                                    @if($rewash->pencuci == $pencuci->id)
                                        <div class="p-3 border rounded item d-flex justify-content-between align-items-start mb-3">
                                            <div class="d-flex flex-column">
                                                <h4>
                                                    {{ $rewash->item_transaksi->kode_transaksi }}
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="1rem" height="1rem" viewBox="0 0 16 16" fill="currentColor" class="bi bi-dot">
                                                        <path fill-rule="evenodd" d="M8 9.5a1.5 1.5 0 1 0 0-3 1.5 1.5 0 0 0 0 3z"></path>
                                                    </svg>
                                                    {{ $rewash->item_transaksi->nama }}
                                                </h4>
                                                <h6 class="text-muted">{{ $rewash->item_transaksi->created_at }}</h6>
                                            </div>
                                            <button class="btn btn-sm btn-show-action" type="button" id="trans-{{ $rewash->item_transaksi->id }}" style="box-shadow: none;">
                                                <i class="fa-solid fa-ellipsis-vertical"></i>
                                            </button>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </section>
        </div>

    </div>
</div>

<script src="{{ asset('js/proses/rewash.js') }}"></script>
@endsection
