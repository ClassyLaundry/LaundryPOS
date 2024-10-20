@extends('layouts.users')

@section('content')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.13.2/jquery-ui.min.js"></script>
<div class="container">
    <header class="my-3" style="color: var(--bs-gray);">
        <a>Proses</a>
        <i class="fas fa-angle-right mx-2"></i>
        <a>Cuci</a>
    </header>

    {{-- <?php
      $currentDate = new DateTime();

      function getISOWeek($date) {
        $d = new DateTime($date);
        $d->setTime(0, 0, 0, 0);
        $d->setDate($d->format('Y'), 1, 1);
        $week = floor(($d->format('U') - strtotime($d->format('Y-m-d'))) / (7 * 24 * 3600)) + 1;
        return $week;
      }

      $defaultWeek = $currentDate->format('Y-\WW');
    ?>

    <ul role="tablist" class="nav nav-tabs position-relative border-bottom-0">
        <li role="presentation" class="nav-item"><a role="tab" data-bs-toggle="tab" class="nav-link active" href="#tab-1">Data</a></li>
        <li role="presentation" class="nav-item"><a role="tab" data-bs-toggle="tab" class="nav-link" href="#tab-2">Task Hub</a></li>
    </ul>

    <div class="tab-content">

        <div role="tabpanel" class="tab-pane active" id="tab-1">
            <section id="section-data-cuci">
                <div class="card">
                    <div class="card-body">
                        <div id="fitler-tanggal" class="d-flex align-items-center position-absolute" style="top: -38px; right: -1px; height: 38px;">
                            <h6 class="me-2">Tanggal</h6>
                            <input type="week" name="week" class="form-control" id="input-week" style="display: none;">
                            <span id="selected-date-range" style="display: none">@isset($dateRange){{ $dateRange }}@endisset</span>
                            <button class="btn btn-outline-primary btn-sm ms-2" id="btn-reset" style="display: none;">
                                <i class="fa-solid fa-arrows-rotate"></i>
                            </button>
                        </div>
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
                                            @if($transaksi->status != 'done' && $transaksi->pencuci == null)
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
                                            <th>Pencuci</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($transaksis as $transaksi)
                                            @if(!$transaksi->is_done_cuci && $transaksi->pencuci != null)
                                            <tr>
                                                <td class="text-center">{{ $transaksi->kode }}</td>
                                                <td class="text-center">{{ $transaksi->created_at }}</td>
                                                @if($transaksi->express)
                                                    <td class="text-center">Express</td>
                                                @else
                                                    <td class="text-center">Normal</td>
                                                @endif
                                                <td class="text-center">{{ $transaksi->tukang_cuci->name }}</td>
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
                                            @if($transaksi->is_done_cuci && $transaksi->pencuci != null)
                                            <tr>
                                                <td class="text-center">{{ $transaksi->kode }}</td>
                                                <td class="text-center">{{ $transaksi->created_at }}</td>
                                                @if($transaksi->express)
                                                    <td class="text-center">Express</td>
                                                @else
                                                    <td class="text-center">Normal</td>
                                                @endif
                                                <td class="text-center">{{ $transaksi->tukang_cuci->name }}</td>
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
            <section id="proses-cuci">
                <div id="hub" class="row card d-flex flex-row position-relative border-0">
                    <div class="col-12 col-md-6">
                        <div class="p-3 border rounded" style="border: 1px solid rgba(0,0,0,.125);">
                            <h4>Staging</h4>
                            <hr />
                            <div class="hub-list hub-staging">
                                @foreach ($transaksis as $transaksi)
                                @if ($transaksi->status != 'done' && $transaksi->pencuci == null && !$transaksi->setrika_only && !$transaksi->is_done_cuci)
                                    <div class="p-3 border rounded item d-flex justify-content-between align-items-center my-3" style="border-bottom: 3px solid rgb(54, 162, 235)!important; background-color: white;">
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
                    @foreach ($pencucis as $pencuci)
                        <div class="col-12 col-md-6 mb-4">
                            <div class="p-3 border rounded" style="border: 1px solid rgba(0,0,0,.125);">
                                <h4>Hub {{ $pencuci->name }}</h4>
                                <hr />
                                <div class="hub-list hub-karyawan">
                                    @foreach ($transaksis as $transaksi)
                                    @if ($transaksi->status != 'done' && $transaksi->pencuci == $pencuci->id && !$transaksi->setrika_only)
                                        @if ($transaksi->is_done_cuci == 1)
                                            <div class="p-3 border rounded d-flex justify-content-between align-items-center my-3" style="border-bottom: 3px solid rgb(54, 162, 235)!important; background-image: linear-gradient(to bottom right, white, rgb(54, 162, 235, .5)); background-color: white;">
                                        @else
                                            <div class="p-3 border rounded d-flex justify-content-between align-items-center my-3" style="border-bottom: 3px solid rgb(54, 162, 235)!important; background-color: white;">
                                        @endif
                                            <div class="d-flex flex-column">
                                                <h4>{{ $transaksi->kode }}</h4>
                                                <h6 class="text-muted">{{ $transaksi->created_at }}</h6>
                                            </div>
                                            <div class="position-relative">
                                                @if ($transaksi->is_done_cuci == 1)
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
    </div> --}}

    <div class="card">
        <div class="card-body">
            <div class="card-title">
                <div class="d-flex justify-content-between align-items-center">
                    <h4 class="lh-base">Cuci</h4>
                </div>
                <hr />
                <div class="row">
                    <div class="col-lg-4 col-4 order-lg-1 order-1 mb-2">
                        <div class="dropdown" id="dropdown-filter">
                            <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButtonFilter" data-bs-toggle="dropdown" aria-expanded="false">
                                Filter
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButtonFilter" style="min-width: 6rem;">
                                <li><h6 class="dropdown-header">Search By</h6></li>
                                <li><a class="dropdown-item filter-search" data-search='kode'>Kode</a></li>
                                <li><a class="dropdown-item active filter-search" data-search='pelanggan'>Pelanggan</a></li>
                                <li><a class="dropdown-item filter-search" data-search='tipe'>Tipe</a></li>
                                <li><a class="dropdown-item filter-search" data-search='tanggal-buat'>Tanggal Transaksi</a></li>
                                <li><a class="dropdown-item filter-search" data-search='tanggal-selesai'>Tanggal Selesai</a></li>
                                <li><a class="dropdown-item filter-search" data-search='pencuci'>Pencuci</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><h6 class="dropdown-header">Paginate</h6></li>
                                <li><a class="dropdown-item active filter-paginate" data-paginate='5'>5 items</a></li>
                                <li><a class="dropdown-item filter-paginate" data-paginate='10'>10 items</a></li>
                                <li><a class="dropdown-item filter-paginate" data-paginate='25'>25 items</a></li>
                                <li><a class="dropdown-item filter-paginate" data-paginate='50'>50 items</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-4 col-12 order-lg-2 order-3 mb-2">
                        <div class="d-flex align-items-center form-control">
                            <i class="fa-solid fa-magnifying-glass me-2"></i>
                            <input type="search" id="input-search" class="w-100" style="outline: none; border: none;">
                        </div>
                    </div>
                </div>
                <div id="table-cuci-admin" class="table-container"></div>
            </div>
        </div>
    </div>
</div>

<script src="{{ asset('js/proses/cuciAdmin.js') }}"></script>
@endsection

