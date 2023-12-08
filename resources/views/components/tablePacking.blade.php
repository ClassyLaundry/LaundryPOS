<div class="table-responsive mb-2">
    <table class="table table-striped" id="table-list-trans">
        <thead class="text-center">
            <tr>
                <th>Kode</th>
                <th>Tipe</th>
                <th>Nama Pelanggan</th>
                <th class="d-none d-lg-table-cell">Tanggal Transaksi</th>
                <th class="d-none d-lg-table-cell">Tanggal Selesai</th>
                <th style="width: 46.25px;"></th>
            </tr>
        </thead>
        <tbody>
            @foreach ($transaksis as $trans)
                @if ($trans->packing == null)
                <tr id="{{ $trans->id }}">
                    <td class="text-center">{{ $trans->kode }}</td>
                    <td class="text-center">{{ ucwords($trans->tipe_transaksi) }}</td>
                    <td>{{ $trans->pelanggan->nama }}</td>
                    <td class="d-none d-lg-table-cell text-center">{{ date('d-M-Y', strtotime($trans->created_at)) }}</td>
                    <td class="d-none d-lg-table-cell text-center">@isset($trans->done_date){{ date('d-M-Y', strtotime($trans->done_date)) }}@endisset</td>
                    <td class="cell-action">
                        <button id="btn-{{ $trans->id }}" class="btn btn-primary btn-sm btn-show-action" type="button"><i class="fas fa-bars"></i></button>
                    </td>
                </tr>
                @endif
            @endforeach
        </tbody>
    </table>
</div>
