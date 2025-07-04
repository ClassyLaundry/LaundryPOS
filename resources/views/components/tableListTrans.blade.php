<div class="table-responsive">
    <table class="table table-striped table-hover" id="table-list-trans">
        <thead class="text-center">
            <tr>
                <th>Kode</th>
                <th class="d-none d-lg-table-cell">Tanggal Transaksi</th>
                <th>Nama Pelanggan</th>
                <th colspan="2">Harga Total</th>
                <th>Lunas</th>
                <th>Delivery</th>
            </tr>
        </thead>
        <tbody style="cursor: pointer">
            @foreach ($transaksis as $trans)
            <tr data-bs-toggle="tooltip" data-bss-tooltip="" title="Double klik untuk memilih" id={{ $trans->id }}>
                <td>{{ $trans->kode }}</td>
                <td class="d-none d-lg-table-cell text-center">{{ $trans->created_at }}</td>
                <td>{{ $trans->pelanggan->nama }}</td>
                <td>Rp</td>
                <td class="text-end thousand-separator">{{ $trans->grand_total }}</td>
                <td class="text-center" style="white-space: nowrap">
                @if($trans->lunas)
                    Lunas
                @else
                    Belum Lunas
                @endif
                </td>
                <td class="text-center">
                @if($trans->need_delivery)
                    Ya
                @else
                    Tidak
                @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    {{ $transaksis->links() }}
</div>
