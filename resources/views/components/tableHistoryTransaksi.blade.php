<div class="table-responsive mb-2">
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Kode Transaksi</th>
                <th>Outlet</th>
                <th colspan="2">Total</th>
                <th>Status</th>
                <th colspan="2">Terbayar</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($transaksis as $transaksi)
            <tr>
                <td class="text-center">{{ $transaksi->kode }}</td>
                <td class="text-center">{{ $transaksi->outlet->nama }}</td>
                <td>Rp</td>
                <td class="text-end thousand-separator">{{ number_format($transaksi->grand_total, 0, ',', '.') }}</td>
                @if ($transaksi->lunas)
                    <td class="text-center">Lunas</td>
                @else
                    <td class="text-center">Belum lunas</td>
                @endif
                <td>Rp</td>
                <td class="text-end thousand-separator">{{ number_format($transaksi->total_terbayar, 0, ',', '.') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
{{ $transaksis->links() }}
