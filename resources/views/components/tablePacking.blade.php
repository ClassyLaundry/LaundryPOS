<div class="table-responsive mb-2">
    <table class="table table-striped" id="table-list-trans">
        <thead class="text-center">
            <tr>
                <th>Kode</th>
                <th>Tipe</th>
                <th class="d-none d-lg-table-cell">Tanggal Transaksi</th>
                <th>Nama Pelanggan</th>
                @if(Session::get('role') == 'administrator')
                    <th colspan="2">Harga Total</th>
                    <th>Lunas</th>
                @endif
                <th style="width: 46.25px;"></th>
            </tr>
        </thead>
        <tbody>
            @foreach ($transaksis as $trans)
                @if ($trans->packing == null)
                <tr id="{{ $trans->id }}">
                    <td class="text-center">{{ $trans->kode }}</td>
                    <td class="text-center">{{ ucwords($trans->tipe_transaksi) }}</td>
                    <td class="d-none d-lg-table-cell text-center">{{ $trans->created_at }}</td>
                    <td>{{ $trans->pelanggan->nama }}</td>
                    @if(Session::get('role') == 'administrator')
                        <td>Rp</td>
                        <td class="text-end thousand-separator">{{ $trans->grand_total }}</td>
                        <td class="text-center" style="white-space: nowrap">
                        @if($trans->lunas)
                            Lunas
                        @else
                            Belum Lunas
                        @endif
                    @endif
                    </td>
                    <td class="cell-action">
                        <button id="btn-{{ $trans->id }}" class="btn btn-primary btn-sm btn-show-action" type="button"><i class="fas fa-bars"></i></button>
                    </td>
                </tr>
                @endif
            @endforeach
        </tbody>
    </table>
</div>
{{ $transaksis->links() }}
