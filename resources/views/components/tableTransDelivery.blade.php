<div class="table-responsive">
    <table class="table table-striped table-hover" id="table-list-trans">
        <thead class="text-center">
            <tr>
                <th>Kode</th>
                <th>Tipe</th>
                <th>Tanggal Transaksi</th>
                <th>Nama Pelanggan</th>
                <th colspan="2">Harga Total</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody style="cursor: pointer">
            @foreach ($transaksis as $trans)
            <tr id={{ $trans->id }}>
                <td>
                    {{ $trans->kode }}
                    @if($trans->status === 'rewash')
                        <span class="badge bg-danger">Rewash</span>
                    @endif
                </td>
                <td class="text-center">{{ $trans->tipe_transaksi }}</td>
                <td class="text-center">{{ date('d-M-Y H:i', strtotime($trans->created_at)) }}</td>
                <td>{{ $trans->pelanggan->nama }}</td>
                <td>Rp</td>
                <td class="text-end">{{ number_format($trans->grand_total, 0, ',', '.') }}</td>
                <td class="text-center" style="white-space: nowrap">
                @if($trans->lunas)
                    Lunas
                @else
                    Belum Lunas
                @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    {{ $transaksis->links() }}
</div>
