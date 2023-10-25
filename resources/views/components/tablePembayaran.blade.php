<div class="table-responsive">
    <table class="table table-striped" id="table-pembayaran">
        <thead>
            <tr>
                <th>Kode</th>
                <th>Tipe</th>
                <th>Pelanggan</th>
                <th>Tanggal</th>
                <th colspan="2">Total</th>
                <th>Lunas</th>
                <th colspan="2">Terbayar</th>
                <th>Status</th>
                <th style="width: 50px;"></th>
            </tr>
        </thead>
        <tbody>
        @foreach ($transaksis as $transaksi)
            <tr>
                <td class="text-center">{{ $transaksi->kode }}</td>
                <td class="text-center">{{ $transaksi->tipe_transaksi }}</td>
                <td class="text-center">{{ $transaksi->pelanggan->nama }}</td>
                <td class="text-center">{{ date('d/m/Y', strtotime($transaksi->created_at)) }}</td>
                <td style="width: 35px;">Rp</td>
                <td class="thousand-separator text-end">{{ number_format($transaksi->grand_total, 0, ',', '.') }}</td>
                @if ($transaksi->lunas)
                    <td class="text-center">Lunas</td>
                @else
                    <td class="text-center">Belum lunas</td>
                @endif
                <td style="width: 35px;">Rp</td>
                <td class="thousand-separator text-end">{{ number_format($transaksi->total_terbayar, 0, ',', '.') }}</td>
                <td class="text-center">{{ $transaksi->status }}</td>
                <td class="cell-action">
                    <button id="btn-{{ $transaksi->id }}" class="btn btn-primary btn-sm btn-show-action" type="button">
                        <i class="fas fa-bars"></i>
                    </button>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
{{ $transaksis->links() }}

