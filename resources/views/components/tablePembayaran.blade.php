<div class="table-responsive">
    <table class="table table-striped" id="table-pembayaran">
        <thead>
            <tr>
                <th>Kode</th>
                <th>Tipe</th>
                <th>Pelanggan</th>
                <th>Tanggal Transaksi</th>
                <th>Tanggal Selesai</th>
                <th>Total</th>
                <th>Lunas</th>
                <th>Terbayar</th>
                <th>Status</th>
                <th style="width: 26px;"></th>
            </tr>
        </thead>
        <tbody>
        @foreach ($transaksis as $transaksi)
            <tr>
                <td class="text-center">{{ $transaksi->kode }}</td>
                <td class="text-center">{{ $transaksi->tipe_transaksi }}</td>
                <td class="text-center">{{ $transaksi->pelanggan->nama }}</td>
                <td class="text-center">{{ date('d/m/Y', strtotime($transaksi->created_at)) }}</td>
                <td class="text-center">@isset($transaksi->done_date) {{ date('d/m/Y', strtotime($transaksi->done_date)) }} @endisset</td>
                <td>
                    <div class="d-flex justify-content-between">
                        <span>Rp</span>
                        <span class="thousand-separator">{{ number_format($transaksi->grand_total, 0, ',', '.') }}</span>
                    </div>
                </td>
                @if ($transaksi->lunas)
                    <td class="text-center">Lunas</td>
                @else
                    <td class="text-center">Belum lunas</td>
                @endif
                <td>
                    <div class="d-flex justify-content-between">
                        <span>Rp</span>
                        <span class="thousand-separator">{{ number_format($transaksi->total_terbayar, 0, ',', '.') }}</span>
                    </div>
                </td>
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

