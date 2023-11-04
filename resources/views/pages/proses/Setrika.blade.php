@extends('layouts.users')

@section('content')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.13.2/jquery-ui.min.js"></script>
<div class="container">
    <header class="my-3" style="color: var(--bs-gray);"><a>Proses</a><i class="fas fa-angle-right mx-2"></i><a>Setrika</a></header>
    {{-- if admin --}}
    @if(Session::get('role') != 'produksi_setrika')
        <ul role="tablist" class="nav nav-tabs position-relative border-bottom-0">
            <li role="presentation" class="nav-item"><a role="tab" data-bs-toggle="tab" class="nav-link active" href="#tab-1">Data</a></li>
            <li role="presentation" class="nav-item"><a role="tab" data-bs-toggle="tab" class="nav-link" href="#tab-2">Task Hub</a></li>
        </ul>
        <div class="tab-content">
            <div role="tabpanel" class="tab-pane active" id="tab-1">
                <section id="section-data-setrika">
                    <div class="card">
                        <div class="card-body">
                            <section id="section-staging" class="mb-4">
                                <h4>Staging</h4>
                                <hr />
                                <div class="table-responsive mb-2">
                                    <table class="table table-striped" id="table-staging">
                                        <thead>
                                            <tr>
                                                <th>Kode Transaksi</th>
                                                <th>Tanggal</th>
                                                <th>Jenis</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($transaksis as $transaksi)
                                                @if($transaksi->status != 'done' && $transaksi->penyetrika == null)
                                                <tr>
                                                    <td class="text-center">{{ $transaksi->kode }}</td>
                                                    <td class="text-center">{{ $transaksi->created_at }}</td>
                                                    @if($transaksi->express)
                                                        <td class="text-center">Express</td>
                                                    @else
                                                        <td class="text-center">Normal</td>
                                                    @endif
                                                </tr>
                                                @endif
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </section>
                            <hr style="margin: 1rem -1rem;" />
                            <section id="section-on-process" class="mb-4">
                                <h4>On Process</h4>
                                <hr />
                                <div class="table-responsive mb-2">
                                    <table class="table table-striped" id="table-on-process">
                                        <thead>
                                            <tr>
                                                <th>Kode Transaksi</th>
                                                <th>Tanggal</th>
                                                <th>Jenis</th>
                                                <th>Penyetrika</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($transaksis as $transaksi)
                                                @if(!$transaksi->is_done_setrika && $transaksi->penyetrika != null)
                                                <tr>
                                                    <td class="text-center">{{ $transaksi->kode }}</td>
                                                    <td class="text-center">{{ $transaksi->created_at }}</td>
                                                    @if($transaksi->express)
                                                        <td class="text-center">Express</td>
                                                    @else
                                                        <td class="text-center">Normal</td>
                                                    @endif
                                                    <td class="text-center">{{ $transaksi->tukang_setrika->name }}</td>
                                                </tr>
                                                @endif
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </section>
                            <hr style="margin: 1rem -1rem;" />
                            <section id="section-on-process" class="mb-4">
                                <h4>Done</h4>
                                <hr />
                                <div class="table-responsive mb-2">
                                    <table class="table table-striped" id="table-on-process">
                                        <thead>
                                            <tr>
                                                <th>Kode Transaksi</th>
                                                <th>Tanggal</th>
                                                <th>Jenis</th>
                                                <th>Pencuci</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($transaksis as $transaksi)
                                                @if($transaksi->is_done_setrika && $transaksi->pencuci != null)
                                                <tr>
                                                    <td class="text-center">{{ $transaksi->kode }}</td>
                                                    <td class="text-center">{{ $transaksi->created_at }}</td>
                                                    @if($transaksi->express)
                                                        <td class="text-center">Express</td>
                                                    @else
                                                        <td class="text-center">Normal</td>
                                                    @endif
                                                    <td class="text-center">{{ $transaksi->tukang_setrika->name }}</td>
                                                </tr>
                                                @endif
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </section>
                        </div>
                    </div>
                </section>
            </div>
            <div role="tabpanel" class="tab-pane" id="tab-2">
                <section id="proses-setrika">
                    <div id="hub" class="row card d-flex flex-row position-relative border-0">
                        <div class="col-12 col-md-6">
                            <div class="p-3 border rounded" style="border: 1px solid rgba(0,0,0,.125);">
                                <h4>Staging</h4>
                                <hr />
                                <div class="hub-list hub-staging">
                                    {{-- @foreach ($transaksis as $transaksi)
                                        @if($transaksi->status != 'done' && $transaksi->penyetrika == null)
                                        <div class="p-3 border rounded item d-flex justify-content-between align-items-start">
                                            <div class="d-flex flex-column">
                                                <h4>{{ $transaksi->kode }}</h4>
                                                <h6 class="text-muted">{{ $transaksi->created_at }}</h6>
                                            </div>
                                            <button class="btn btn-sm btn-show-action" type="button" id="trans-{{ $transaksi->id }}" style="box-shadow: none;">
                                                <i class="fa-solid fa-ellipsis-vertical"></i>
                                            </button>
                                        </div>
                                        @endif
                                    @endforeach --}}
                                    @foreach ($transaksis as $transaksi)
                                    @if ($transaksi->status != 'done' && $transaksi->penyetrika == null && ($transaksi->setrika_only || $transaksi->is_done_cuci))
                                        <div class="p-3 border rounded d-flex justify-content-between align-items-center my-3" style="border-bottom: 3px solid rgb(255, 99, 132)!important; background-color: white;">
                                            <div class="d-flex flex-column">
                                                <h4>{{ $transaksi->kode }}</h4>
                                                <h6 class="text-muted">{{ $transaksi->created_at }}</h6>
                                            </div>
                                            <div class="position-relative">
                                                <h4 class="fw-bold me-4" style="font-style: italic;">Process</h4>
                                                <i class="fa-solid fa-spinner position-absolute top-50 start-0 translate-middle fa-4x" style="font-style: italic; opacity: 0.25;"></i>
                                            </div>
                                        </div>
                                    @endif
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        @foreach ($penyetrikas as $penyetrika)
                            <div class="col-12 col-md-6 mb-4">
                                <div class="p-3 border rounded" style="border: 1px solid rgba(0,0,0,.125);">
                                    <h4>Hub {{ $penyetrika->name }}</h4>
                                    <hr />
                                    <div class="hub-list hub-karyawan">
                                        @foreach ($transaksis as $transaksi)
                                        @if ($transaksi->status != 'done' && $transaksi->penyetrika == $penyetrika->id && ($transaksi->setrika_only || $transaksi->is_done_cuci))
                                            @if ($transaksi->is_done_setrika == 1)
                                                <div class="p-3 border rounded d-flex justify-content-between align-items-center my-3" style="border-bottom: 3px solid rgb(255, 99, 132)!important; background-image: linear-gradient(to bottom right, white, rgb(255, 99, 132, .5)); background-color: white;">
                                            @else
                                                <div class="p-3 border rounded d-flex justify-content-between align-items-center my-3" style="border-bottom: 3px solid rgb(255, 99, 132)!important; background-color: white;">
                                            @endif
                                                <div class="d-flex flex-column">
                                                    <h4>{{ $transaksi->kode }}</h4>
                                                    <h6 class="text-muted">{{ $transaksi->created_at }}</h6>
                                                </div>
                                                <div class="position-relative">
                                                    @if ($transaksi->is_done_setrika == 1)
                                                        <h4 class="fw-bold me-4" style="font-style: italic;">Done</h4>
                                                        <i class="fa-solid fa-flag-checkered position-absolute top-50 start-0 translate-middle fa-4x" style="font-style: italic; opacity: 0.25;"></i>
                                                    @else
                                                        <h4 class="fw-bold me-4" style="font-style: italic;">Process</h4>
                                                        <i class="fa-solid fa-spinner position-absolute top-50 start-0 translate-middle fa-4x" style="font-style: italic; opacity: 0.25;"></i>
                                                    @endif
                                                </div>
                                            </div>
                                        @endif
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="modal fade" role="dialog" tabindex="-1" id="modal-detail">
                        <div class="modal-dialog modal-lg modal-dialog-centered modal-fullscreen-lg-down" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title">Detail Transaksi</h4>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="table-responsive my-2 tbody-wrap">
                                        <table class="table table-striped mb-0" id="table-trans-item">
                                            <thead>
                                                <tr>
                                                    <th>Nama Item</th>
                                                    <th>Kategori</th>
                                                    <th>Keterangan</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($transaksis as $transaksi)
                                                    @foreach ($transaksi->item_transaksi as $item_transaksi)
                                                    <tr class="trans-{{ $transaksi->id }}">
                                                        <td>{{ $item_transaksi->nama }}</td>
                                                        <td>{{ $item_transaksi->nama_kategori }}</td>
                                                        <td>keterangan</td>
                                                    </tr>
                                                    @endforeach
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>

    @else
        <section id="proses-setrika">
            <div id="hub" class="card d-flex flex-row position-relative border-0">
                <div class="w-50 py-2" style="padding-right: .75rem!important;">
                    <div class="p-3 border rounded" style="border: 1px solid rgba(0,0,0,.125);">
                        <h4>Hub Setrika</h4>
                        <hr />
                        <div class="hub-list hub-setrika">
                            @foreach ($transaksis as $transaksi)
                            @if ($transaksi->status != 'done' && $transaksi->penyetrika == null && ($transaksi->setrika_only || $transaksi->is_done_cuci))
                                <div class="border rounded mt-3 item" style="border-bottom: 3px solid rgb(255, 99, 132)!important; background-color: white;">
                                    <div class="p-3 border-bottom rounded d-flex justify-content-between align-items-center">
                                        <div class="d-flex flex-column">
                                            <h4>{{ $transaksi->kode }}</h4>
                                            <h6 class="text-muted">{{ $transaksi->created_at }}</h6>
                                        </div>
                                        <div class="position-relative">
                                            <h4 class="fw-bold me-4" style="font-style: italic;">Process</h4>
                                            <i class="fa-solid fa-spinner position-absolute top-50 start-0 translate-middle fa-4x" style="font-style: italic; opacity: 0.25;"></i>
                                            <button class="btn btn-sm btn-show-action position-absolute end-0" type="button" style="top: -12px;" id="trans-{{ $transaksi->id }}" style="box-shadow: none;">
                                                <i class="fa-solid fa-ellipsis-vertical"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="px-3 py-1 pesan-pelanggan font-monospace" style="display: none;">
                                        <h4>{{ $transaksi->catatan }}</h4>
                                    </div>
                                </div>
                            @endif
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="w-50 py-2" style="padding-left: .75rem!important;">
                    <div class="p-3 border rounded" style="border: 1px solid rgba(0,0,0,.125);">
                        <h4>Hub Penyetrika</h4>
                        <hr />
                        <div class="hub-list hub-karyawan">
                            @foreach ($transaksis as $transaksi)
                            @if ($transaksi->status != 'done' && $transaksi->penyetrika == Auth::id() && ($transaksi->setrika_only || $transaksi->is_done_cuci))
                                <div
                                    @if ($transaksi->is_done_setrika == 1)
                                    class="border rounded mt-3" style="border-bottom: 3px solid rgb(255, 99, 132)!important; background-image: linear-gradient(to bottom right, white, rgb(255, 99, 132, .5)); background-color: white;"
                                    @else
                                    class="border rounded mt-3 item" style="border-bottom: 3px solid rgb(255, 99, 132)!important; background-color: white;"
                                    @endif
                                >
                                    <div class="p-3 border-bottom rounded d-flex justify-content-between align-items-center">
                                        <div class="d-flex flex-column">
                                            <h4>{{ $transaksi->kode }}</h4>
                                            <h6 class="text-muted">{{ $transaksi->created_at }}</h6>
                                        </div>
                                        <div class="position-relative">
                                            @if ($transaksi->is_done_setrika == 1)
                                                <h4 class="fw-bold me-4" style="font-style: italic;">Done</h4>
                                                <i class="fa-solid fa-flag-checkered position-absolute top-50 start-0 translate-middle fa-4x" style="font-style: italic; opacity: 0.25;"></i>
                                            @else
                                                <h4 class="fw-bold me-4" style="font-style: italic;">Process</h4>
                                                <i class="fa-solid fa-spinner position-absolute top-50 start-0 translate-middle fa-4x" style="font-style: italic; opacity: 0.25;"></i>
                                                <button class="btn btn-sm btn-show-action position-absolute end-0" type="button" style="top: -12px;" id="trans-{{ $transaksi->id }}" style="box-shadow: none;">
                                                    <i class="fa-solid fa-ellipsis-vertical"></i>
                                                </button>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="px-3 py-1 pesan-pelanggan font-monospace" style="display: none;">
                                        <h4>{{ $transaksi->catatan }}</h4>
                                    </div>
                                </div>
                            @endif
                            @endforeach
                        </div>
                    </div>
                </div>
                <ul class="list-unstyled form-control" id="list-action">
                    <li id="action-add">Tambahkan</li>
                    <li id="action-remove">Kembalikan</li>
                    <li id="action-detail">Detail</li>
                    <li id="action-pesan">Toggle Pesan</li>
                    <li id="action-done">Selesai</li>
                </ul>
            </div>

            <div class="modal fade" role="dialog" tabindex="-1" id="modal-detail">
                <div class="modal-dialog modal-lg modal-dialog-centered modal-fullscreen-lg-down" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Detail Transaksi <span id="kode-trans"></span></h4>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body position-relative">
                            <div id="table-short-trans"></div>
                            <ul class="list-unstyled form-control list-action" id="list-action-2">
                                <li id="action-notes">Notes</li>
                                <li id="action-rewash">Rewash</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <div role="dialog" tabindex="-1" class="modal fade" id="modal-list-catatan-item">
                <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Catatan Item</h4>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body position-relative">
                            <div id="table-catatan-item"></div>
                            <ul class="list-unstyled form-control list-action" id="list-action-3">
                                <li id="action-detail-note">Detail Catatan</li>
                                <li id="action-delete-note">Hapus Catatan</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <div role="dialog" tabindex="-1" class="modal fade" id="modal-catatan-item">
                <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Catatan Item <span id="catatan-item-name">nama item</span></h4>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form id="form-catatan">
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-4">
                                        <div class="mb-2">
                                            <h5>Noted by</h5>
                                            <input type="text" class="form-control" id="penulis-catatan-item" />
                                        </div>
                                        <div class="h-100">
                                            <h5>Notes</h5>
                                            <textarea class="form-control" id="catatan-item" required style="max-height: 496px;"></textarea>
                                        </div>
                                    </div>
                                    <div class="col-8">
                                        <h5>Foto</h5>
                                        <img id="container-image-item" class="w-100 mb-2" style="object-fit: contain;max-height: 450px;height: 450px;" />
                                        <input type="file" class="form-control" id="input-foto-item" accept="image/*" onchange="document.getElementById('container-image-item').src = window.URL.createObjectURL(this.files[0])" required />
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

            <div class="modal fade" role="dialog" tabindex="-1" id="modal-rewash">
                <div class="modal-dialog modal-lg modal-dialog-centered modal-fullscreen-lg-down" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Request Rewash</h4>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form action="/proses/rewash/insert" method="POST">
                            @csrf
                            <div class="modal-body position-relative">
                                <div class="row">
                                    <div class="col-8 mb-2">
                                        <h5>Nama Item</h5>
                                        <input id="input-nama" class="form-control disabled" type="text">
                                    </div>
                                    <div class="col-4 mb-2">
                                        <h5>Keterangan</h5>
                                        <select class="form-select" name="jenis_rewash_id" id="input-jenis" required>
                                            <option value selected hidden>-</option>
                                            @foreach ($jenis_rewashes as $jenis_rewash)
                                                <option value="{{ $jenis_rewash->id }}">{{ $jenis_rewash->keterangan }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-12 mb-2">
                                        <h5>Keterangan Item</h5>
                                        <textarea id="input-keterangan" class="form-control" name="keterangan"></textarea>
                                    </div>
                                    <input id="input-hidden-id" type="hidden" name="item_transaksi_id" value="">
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary">Simpan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    @endif
</div>

<script src="{{ asset('js/proses/setrika.js') }}"></script>
@endsection

