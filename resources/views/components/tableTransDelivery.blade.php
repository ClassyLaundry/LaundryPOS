<div class="table-responsive">
    <table class="table table-striped table-hover" id="table-list-trans">
        <thead class="text-center">
            <tr>
                <th>Kode</th>
                <th>Tipe</th>
                <th>Outlet</th>
                <th>Tanggal Transaksi</th>
                <th>Nama Pelanggan</th>
                <th colspan="2">Harga Total</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody style="cursor: pointer">
            @foreach ($transaksis as $trans)
            <tr data-bs-toggle="tooltip" data-bss-tooltip="" title="Double klik untuk memilih" id={{ $trans->id }}>
                <td>{{ $trans->kode }}</td>
                <td>{{ $trans->tipe_transaksi }}</td>
                <td>{{ $trans->outlet->nama }}</td>
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
