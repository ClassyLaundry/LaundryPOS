<div class="table-responsive">
    <table class="table table-striped table-hover" id="table-list-komplain">
        <thead class="text-center">
            <tr>
                <th>Kode</th>
                <th class="d-none d-lg-table-cell">Tanggal Komplain</th>
                <th>Nama Pelanggan</th>
                <th colspan="2">Harga Total</th>
                <th>Lunas</th>
                <th></th>
            </tr>
        </thead>
        <tbody style="cursor: pointer">
            @foreach ($komplains as $komplain)
            <tr data-bs-toggle="tooltip" data-bss-tooltip="" title="Double klik untuk memilih" id={{ $komplain->transaksi?->id }}>
                <td>{{ $komplain->transaksi?->kode }}</td>
                <td class="d-none d-lg-table-cell text-center">{{ $komplain->created_at }}</td>
                <td>{{ $komplain->transaksi?->pelanggan->nama }}</td>
                <td>Rp</td>
                <td class="text-end thousand-separator">{{ number_format($komplain->transaksi?->grand_total, 0, ',', '.') }}</td>
                <td class="text-center" style="white-space: nowrap">
                @if($komplain->transaksi?->lunas)
                    Lunas
                @else
                    Belum Lunas
                @endif
                </td>
                <td class="cell-action">
                    <button id="btn-{{ $komplain->id }}"  class="btn btn-primary btn-sm btn-show-action" type="button"><i class="fas fa-bars"></i></button>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    {{ $komplains->links() }}
</div>
