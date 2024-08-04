<div class="table-responsive">
    <table class="table table-striped" id="table-item">
        <thead>
            <tr>
                <th>Kategori</th>
                <th>Nama Item</th>
                <th>Unit</th>
                <th colspan="2">Bobot Bucket</th>
                <th colspan="2">Harga Kilo</th>
                <th colspan="2">Harga Bucket</th>
                <th colspan="2">Harga Premium</th>
                <th>Bobot Produksi</th>
                <th colspan="2">Diskon Item</th>
                <th>Status Kilo</th>
                <th>Status Bucket</th>
                <th>Status Premium</th>
                <th>Status</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @foreach ($items as $item)
            <tr>
                <td>{{ $item->kategori->nama }}</td>
                <td>{{ $item->nama }}</td>
                <td class="text-center">{{ $item->unit }}</td>
                <td class="text-end">{{ $item->bobot_bucket }}</td>
                <td>kg</td>
                <td>Rp</td>
                <td class="text-end thousand-separator">{{ $item->harga_kilo }}</td>
                <td>Rp</td>
                <td class="text-end thousand-separator">{{ $item->harga_bucket }}</td>
                <td>Rp</td>
                <td class="text-end thousand-separator">{{ $item->harga_premium }}</td>
                <td class="text-center">{{ $item->beban_produksi }}</td>
                <td>Rp</td>
                <td class="text-end thousand-separator">{{ $item->diskon_jenis_item }}</td>
                @if ($item->status_kilo)
                    <td class="text-center">Aktif</td>
                @else
                    <td class="text-center">Tidak aktif</td>
                @endif
                @if ($item->status_bucket)
                    <td class="text-center">Aktif</td>
                @else
                    <td class="text-center">Tidak aktif</td>
                @endif
                @if ($item->status_premium)
                    <td class="text-center">Aktif</td>
                @else
                    <td class="text-center">Tidak aktif</td>
                @endif
                @if ($item->status_item)
                    <td class="text-center">Aktif</td>
                @else
                    <td class="text-center">Tidak aktif</td>
                @endif
                <td class="cell-action">
                    <button id="btn-{{ $item->id }}" class="btn btn-primary btn-sm btn-show-action" type="button">
                        <i class="fas fa-bars"></i>
                    </button>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
{{ $items->links() }}
