@extends('layouts.users')

@section('content')
<div class="container">
    <header class="d-flex align-items-center my-3" style="color: var(--bs-gray);">
        <a>Master Data</a>
        <i class="fas fa-angle-right mx-2"></i>
        <a>Data Diskon</a>
    </header>
    <section id="data-diskon">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Data Diskon</h4>
                <hr>
                <div class="table-responsive mb-2">
                    <table class="table table-striped" id="table-diskon">
                        <thead>
                            <tr>
                                <th>Kode</th>
                                <th>Deskripsi</th>
                                <th>Besar Diskon</th>
                                <th>Diskon Maksimal</th>
                                <th>Bertumpuk</th>
                                <th class="text-wrap" style="max-width: 175px;">Maksimal Penggunaan per Pelanggan</th>
                                <th>Pelanggan Referral</th>
                                <th>Expired Date</th>
                                <th>Status</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($diskons as $diskon)
                            <tr>
                                <td>{{ $diskon->code }}</td>
                                <td>{{ $diskon->description }}</td>
                                @if (str_contains($diskon->jenis_diskon, "percentage"))
                                <td>
                                    <div class="d-flex justify-content-center">
                                        <span class="thousand-separator">{{ $diskon->nominal }}</span>
                                        <span>%</span>
                                    </div>
                                </td>
                                @elseif (str_contains($diskon->jenis_diskon, "exact"))
                                <td>
                                    <div class="d-flex justify-content-between">
                                        <span>Rp</span>
                                        <span class="thousand-separator">{{ $diskon->nominal }}</span>
                                    </div>
                                </td>
                                @endif
                                <td>
                                    <div class="d-flex justify-content-between">
                                        <span>Rp</span>
                                        <span class="thousand-separator">{{ $diskon->maximal_diskon }}</span>
                                    </div>
                                </td>
                                @if ($diskon->is_stackable)
                                    <td class="text-center" data-stackable="1">Ya</td>
                                @else
                                    <td class="text-center" data-stackable="0">Tidak</td>
                                @endif
                                <td class="text-center">{{ $diskon->max_usage_per_customer }}</td>
                                <td class="text-center">@isset($diskon->pelanggan) {{ $diskon->pelanggan->nama }} @else - @endisset</td>
                                <td class="text-center">{{ $diskon->expired }}</td>
                                @if ($diskon->deleted_at != null)
                                    <td class="text-center">Deleted</td>
                                    <td></td>
                                @else
                                    @if (date('Y-m-d') > $diskon->expired)
                                        <td class="text-center">Expired</td>
                                    @else
                                        <td class="text-center">Active</td>
                                    @endif
                                    <td class="cell-action">
                                        <button id="btn-{{ $diskon->id }}" class="btn btn-primary btn-sm btn-show-action" type="button">
                                            <i class="fas fa-bars"></i>
                                        </button>
                                    </td>
                                @endif
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                {{ $diskons->links() }}
                @if(in_array("Menambah Data Diskon", Session::get('permissions')) || Session::get('role') == 'administrator')
                <button class="btn btn-primary btn-tambah mt-2" type="button">
                    <i class="fas fa-plus-circle"></i>
                    &nbsp;Tambah
                </button>
                @endif
                <ul class="list-unstyled form-control" id="list-action">
                    @if(in_array("Mengubah Data Diskon", Session::get('permissions')) || Session::get('role') == 'administrator')
                    <li id="action-update">Rubah data</li>
                    @endif
                    @if(in_array("Menghapus Data Diskon", Session::get('permissions')) || Session::get('role') == 'administrator')
                    <li id="action-delete">Hapus data</li>
                    @endif
                </ul>
            </div>
        </div>

        <div class="modal fade" role="dialog" tabindex="-1" id="modal-diskon">
            <div class="modal-dialog modal-lg modal-dialog-centered modal-fullscreen-lg-down" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Diskon Baru</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form id="modal-form" action="/data/diskon" method="POST">
                        @csrf
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-12">
                                    <h5>Kode Diskon</h5>
                                    <input class="form-control" type="text" id="input-kode" name="code" required>
                                </div>
                                <div class="col-12">
                                    <h5>Deskripsi</h5>
                                    <textarea class="form-control" id="input-deskripsi" name="description"></textarea>
                                </div>
                                <div class="col-12">
                                    <h5>Tanggal Expired</h5>
                                    <input class="form-control" type="date" id="input-expired" name="expired_date" required>
                                </div>
                                <div class="col-12">
                                    <div class="d-flex align-items-center">
                                        <h5>Tipe Diskon</h5>
                                        <div class="ms-3">
                                            <input type="radio" class="btn-check" id="tipe-percentage" autocomplete="off" name="jenis_diskon" value="percentage" required>
                                            <label class="btn btn-outline-primary" for="tipe-percentage">Persentasi</label>
                                            <input type="radio" class="btn-check" id="tipe-exact" autocomplete="off" name="jenis_diskon" value="exact">
                                            <label class="btn btn-outline-primary" for="tipe-exact">Nominal</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 exact" style="display: none;">
                                    <h5>Besar Diskon</h5>
                                    <div class="form-control d-flex">
                                        <p>Rp</p>
                                        <input class="w-100 ms-2 input-thousand-separator" type="text" id="input-nominal-1" name="nominal" min=0 required>
                                    </div>
                                </div>
                                <div class="col-6 mb-3 percentage" style="display: none;">
                                    <h5>Besar Diskon</h5>
                                    <div class="form-control d-flex">
                                        <input class="w-100 me-2 input-thousand-separator" type="text" id="input-nominal-2" name="nominal" min=0 max=100 required>
                                        <p>%</p>
                                    </div>
                                </div>
                                <div class="col-6 mb-3 percentage" style="display: none;">
                                    <h5>Maksimal Diskon</h5>
                                    <div class="form-control d-flex">
                                        <p>Rp</p>
                                        <input class="w-100 ms-2 input-thousand-separator" type="text" id="input-max-nominal" name="maximal_diskon" required>
                                    </div>
                                </div>
                                <div class="col-4 mb-3">
                                    <div class="d-flex align-items-center h-100">
                                        <div class="form-check mt-3">
                                            <input class="form-check-input me-2" type="checkbox" id="formCheck-is_stackable">
                                            <h5 class="form-check-label" for="formCheck-is_stackable">Bisa Bertumpuk?</h5>
                                            <input type="hidden" name="is_stackable" value="0">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-8 mb-3">
                                    <h6>Maksimal penggunaan diskon per pelanggan</h6>
                                    <input class="w-100 form-control" type="number" id="input-max-penggunaan" name="max_usage_per_customer" min=1 value="1" required>
                                </div>
                                <div class="col-4 mb-3">
                                    <div class="d-flex h-100 align-items-center">
                                        <div class="form-check">
                                            <input class="form-check-input me-2" type="checkbox" id="formCheck-referral" name="referral">
                                            <h5 class="form-check-label" for="formCheck-referral">Ada Referral?</h5>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-8 mb-3">
                                    <div class="d-flex disabled">
                                        <input class="form-control me-2 disabled" type="text" id="input-pelanggan_referral" name="pelanggan_referral" placeholder="Nama pelanggan" disabled>
                                        <button class="btn btn-outline-primary" id="pilih-pelanggan" type="button"><i class="fas fa-search"></i></button>
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

        <div class="modal fade" role="dialog" tabindex="-1" id="modal-data-pelanggan">
            <div class="modal-dialog modal-xl modal-dialog-centered modal-fullscreen-sm-down" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Pelanggan</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="d-flex mb-3">
                            <div class="intro-1 d-flex flex-fill">
                                <input class="form-control" type="search" id="input-nama-pelanggan" placeholder="Cari nama pelanggan">
                                <button class="btn btn-primary ms-3" id="search-pelanggan" type="button">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </div>
                        <div id="table-pelanggan"></div>
                    </div>
                </div>
            </div>
        </div>

    </section>
</div>

<script src="{{ asset('js/data/diskon.js') }}"></script>
@endsection
