@extends('layouts.users')

@section('content')
<div class="container">
    <header class="d-flex align-items-center my-3" style="color: var(--bs-gray);"><a>Master Data</a>
        <i class="fas fa-angle-right mx-2"></i>
        <a>Data Pengeluaran</a>
    </header>
    <section id="data-pengeluaran">
        <div class="card">
            <div class="card-body">
                <div class="d-flex jsutify-content-between align-items-center">
                    <h4 class="card-title">Data Pengeluaran</h4>
                    <h5 class="d-flex justify-content-between" style="width: 300px;"><span>Saldo Outlet:</span><span>Rp {{ number_format($saldo->saldo, 0, ',', '.') }}</span></h5>
                </div>
                <hr>
                <div class="d-flex justify-content-end">
                    <form method="GET" action="/data/pengeluaran" class="d-flex align-items-center">
                        Search :
                        <input class="form-control mx-1" type="search" name="search" style="max-width: 200px;">
                    </form>
                </div>
                <div class="table-responsive mb-2">
                    <table class="table table-striped" id="table-pengeluaran">
                        <thead>
                            <tr>
                                <th>Nama Pengeluaran</th>
                                <th>Deskripsi</th>
                                <th>Tanggal</th>
                                <th colspan="2">Nominal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $pengeluaran)
                            <tr>
                                <td>{{ $pengeluaran->nama }}</td>
                                <td>{{ $pengeluaran->deskripsi }}</td>
                                <td class="text-center">{{ $pengeluaran->created_at }}</td>
                                <td>Rp</td>
                                <td class="text-end thousand-separator">{{ $pengeluaran->nominal }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                {{ $data->links() }}
                @if(in_array("Membuat Pengeluaran", Session::get('permissions')) || Session::get('role') == 'administrator')
                <button class="btn btn-primary btn-tambah mt-2" type="button">
                    <i class="fas fa-plus-circle"></i>
                    &nbsp;Tambah
                </button>
                @endif
                {{-- <ul class="list-unstyled form-control" id="list-action">
                    @if(in_array("Mengubah Data Pengeluaran", Session::get('permissions')) || Session::get('role') == 'administrator')
                    <li id="action-update">Rubah data</li>
                    @endif
                </ul> --}}
            </div>
        </div>
        <div class="modal fade" role="dialog" tabindex="-1" id="modal-update">
            <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Rubah Data</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form id="modal-form">
                        @csrf
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-12">
                                    <h5>Nama Pengeluaran</h5>
                                    <input class="form-control" type="text" id="input-nama-pengeluaran" name="nama" required>
                                </div>
                                <div class="col-12">
                                    <h5>Deskripsi</h5>
                                    <textarea class="form-control" id="input-deskripsi" style="resize: none;" name="deskripsi"></textarea>
                                </div>
                                <div class="col-12">
                                    <h5>Nominal</h5>
                                    <div class="form-control d-flex">
                                        <p>Rp</p>
                                        <input class="w-100 ms-2 input-thousand-separator" type="text" id="input-nominal" min=1000 name="nominal" required>
                                    </div>
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

<script src="{{ asset('js/data/pengeluaran.js') }}"></script>
@endsection
