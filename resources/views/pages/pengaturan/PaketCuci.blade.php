@extends('layouts.users')

@section('content')
<div class="container">
    <header class="d-flex align-items-center my-3" style="color: var(--bs-gray);"><a>Pengaturan</a><i class="fas fa-angle-right mx-2"></i><a>Pengaturan Paket</a></header>
    <section id="pengaturan-paket-cuci" class="mb-5">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Pengaturan Paket Cuci</h4>
                <hr />
                <div class="table-responsive">
                    <table class="table" id="table-paket-cuci">
                        <thead>
                            <tr>
                                <th>Nama Paket</th>
                                <th>Deskripsi</th>
                                <th>Bobot</th>
                                <th colspan="2">Harga / bobot</th>
                                <th colspan="2">Harga</th>
                                <th>Status</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $paket)
                            <tr>
                                <td>{{ $paket->nama_paket }}</td>
                                <td>{{ $paket->deskripsi }}</td>
                                <td class="text-center">{{ $paket->jumlah_bobot }}</td>
                                <td>Rp</td>
                                <td class="thousand-separator text-end">{{ $paket->harga_per_bobot }}</td>
                                <td>Rp</td>
                                <td class="thousand-separator text-end">{{ $paket->harga_paket }}</td>
                                @if ($paket->status)
                                    <td class="text-center">Aktif</td>
                                @else
                                    <td class="text-center">Tidak aktif</td>
                                @endif
                                <td class="cell-action">
                                    <button id="btn-{{ $paket->id }}" class="btn btn-primary btn-sm btn-show-action" type="button"><i class="fas fa-bars"></i></button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                {{ $data->links() }}
                @if(in_array("Membuat Paket Cuci", Session::get('permissions')) || Session::get('role') == 'administrator')
                <button class="btn btn-primary btn-add" type="button">
                    <i class="fas fa-plus-circle"></i>&nbsp;Tambah
                </button>
                @endif
            </div>
            <ul class="list-unstyled form-control" id="list-action">
                @if(in_array("Mengubah Data Paket Cuci", Session::get('permissions')) || Session::get('role') == 'administrator')
                <li id="action-update">Rubah data</li>
                @endif
                @if(in_array("Menghapus Paket Cuci", Session::get('permissions')) || Session::get('role') == 'administrator')
                <li id="action-delete">Hapus data</li>
                @endif
            </ul>
        </div>
        <div role="dialog" tabindex="-1" class="modal fade" id="modal-paket-cuci">
            <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Data Paket Cuci</h4><button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form id="form-paket-cuci" method="POST" action>
                        @csrf
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-12">
                                    <h5>Nama Paket</h5>
                                    <input type="text" class="form-control" id="input-nama-paket" name="nama_paket" required />
                                </div>
                                <div class="col-12 col-lg-4">
                                    <h5>Bobot</h5>
                                    <input type="number" class="form-control" id="input-bobot-paket" min="1" name="jumlah_bobot" required />
                                </div>
                                <div class="col-12 col-lg-4">
                                    <h5>Harga Per Bobot</h5>
                                    <div class="form-control d-flex">
                                        <p>Rp</p>
                                        <input class="w-100 ms-2 input-thousand-separator" type="text" id="input-harga_per_bobot" name="harga_per_bobot" required>
                                    </div>
                                </div>
                                <div class="col-12 col-lg-4">
                                    <h5>Harga Paket</h5>
                                    <div class="form-control d-flex">
                                        <p>Rp</p>
                                        <input class="w-100 ms-2 input-thousand-separator" type="text" id="input-harga-paket" name="harga_paket" required>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <h5>Deskripsi Paket</h5>
                                    <textarea class="form-control" id="input-deskripsi" name="deskripsi"></textarea>
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
    </section>
</div>

<script src="{{ asset('js/pengaturan/paketCuci.js') }}"></script>
@endsection
