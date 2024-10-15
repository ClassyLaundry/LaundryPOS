@if(count($transaksis) > 0)
    @foreach ($transaksis as $transaksi)
        <div class="card mb-3 border-2 @if ($transaksi->express) {{ 'border-danger' }} @elseif ($transaksi->on_time) {{ 'border-warning' }} @endif">
            <div class="card-body py-1 px-2 position-relative">
                <h4>{{ $transaksi->kode }}</h4>
                <h6>{{ $transaksi->pelanggan->nama }}</h6>
                <h6>{{ date('d-m-Y', strtotime($transaksi->done_date)) }}</h6>
                <div class="position-absolute top-50 end-0 translate-middle">
                    <h5 class="fst-italic fw-bold">@if ($transaksi->express) {{ 'Express' }} @elseif ($transaksi->on_time) {{ 'On Time' }} @else {{ 'Normal' }} @endif</h5>
                </div>
                <div class="position-absolute top-0 end-0">
                    <button class="btn btn-sm btn-show-action" type="button" id="trans-{{$transaksi->id}}">
                        <i class="fa-solid fa-ellipsis-vertical" aria-hidden="true"></i>
                    </button>
                </div>
            </div>
        </div>
    @endforeach
@else
    <div class="card mb-3 border-2 border-info">
        <div class="card-body">
            <h6 class="fw-bold">Tidak ada transaksi</h6>
        </div>
    </div>
@endif
