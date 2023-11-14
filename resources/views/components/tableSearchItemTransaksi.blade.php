@if ($tipe_transaksi == 'bucket')
    <div class="table-responsive">
        <table class="table table-striped table-hover" id="table-items">
            <thead>
                <tr>
                    <th>Nama Item</th>
                    <th>Kategori</th>
                    <th>Bobot</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($jenis_items as $item)
                <tr id='item-{{ $item->id }}'>
                    <td>{{ $item->nama }}</td>
                    <td class='text-center'>{{ $item->nama_kategori }}</td>
                    <td class='text-center'>{{ $item->bobot_bucket }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@elseif ($tipe_transaksi == 'premium')
    <div class="table-responsive">
        <table class="table table-striped table-hover" id="table-items">
            <thead>
                <tr>
                    <th>Nama Item</th>
                    <th>Kategori</th>
                    <th colspan="2">Harga</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($jenis_items as $item)
                <tr id='item-{{ $item->id }}'>
                    <td>{{ $item->nama }}</td>
                    <td class='text-center'>{{ $item->nama_kategori }}</td>
                    <td>Rp</td>
                    <td class='text-end thousand-separator'>{{ $item->harga_premium }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endif
