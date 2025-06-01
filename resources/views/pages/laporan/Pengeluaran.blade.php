@extends('layouts.users')

@section('content')
<div class="container">
    <header class="d-flex align-items-center my-3" style="color: var(--bs-gray);"><a>Laporan</a>
        <i class="fas fa-angle-right mx-2"></i>
        <a>Pengeluaran</a>
    </header>
    <section id="data-pengeluaran">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <h4 class="card-title">Laporan Pengeluaran</h4>
                    <button type="button" class="btn btn-primary text-white" id="btn-export">Export</button>
                </div>
                <h5 class="d-flex justify-content-between" style="width: 300px;"><span>Saldo Outlet:</span><span>Rp {{ number_format($saldo->saldo, 0, ',', '.') }}</span></h5>
                <hr>

                <div class="row">
                    <div class="col-xl-3 col-md-6 col-12 mb-3">
                        <div class="d-inline-flex align-items-center">
                            <p class="text-nowrap me-2">Tanggal Awal:</p>
                            <input type="date" class="form-control" name="start" id="input-tanggal-awal">
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-6 col-12 mb-3">
                        <div class="d-inline-flex align-items-center">
                            <p class="text-nowrap me-2">Tanggal Akhir:</p>
                            <input type="date" class="form-control" name="end" id="input-tanggal-akhir">
                        </div>
                    </div>
                    <div class="col-xl-5 col-md-10 col-12 mb-3">
                        <div class="d-inline-flex align-items-center">
                            <p class="text-nowrap me-2">Search:</p>
                            <input class="form-control" type="search" name="search" id="input-search" placeholder="nama atau deskripsi">
                        </div>
                    </div>
                    <div class="col-xl-1 col-md-2 col-12 text-end mb-3">
                        <button type="button" class="btn btn-primary" id="btn-apply-filter">Apply</button>
                    </div>
                </div>
                <hr class="mt-0">

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
                {{-- @if(in_array("Membuat Pengeluaran", Session::get('permissions')) || Session::get('role') == 'administrator')
                <button id='btn-tambah' class="btn btn-primary mt-2" type="button">
                    <i class="fas fa-plus-circle"></i>
                    &nbsp;Tambah
                </button>
                @endif --}}
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

<script src="{{ asset('js/laporan/pengeluaran.js') }}"></script>
@endsection
