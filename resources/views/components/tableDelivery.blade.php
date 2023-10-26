<div class="table-responsive">
    <table class="table">
        <thead>
            <tr>
                <th style="width: 15%;">Kode Delivery</th>
                <th style="width: 15%;">Kode Transaksi</th>
                <th style="width: 20%;">Pelanggan</th>
                <th style="width: 10%;">Driver</th>
                <th>Alamat</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($deliveries as $delivery)
                <tr>
                    <td class="text-center">{{ $delivery->kode }}</td>
                    <td class="text-center">{{ $delivery->transaksi->kode }}</td>
                    <td class="text-center">{{ $delivery->pelanggan->nama }}</td>
                    <td class="text-center">{{ $delivery->nama_driver }}</td>
                    <td>{{ $delivery->alamat }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
{{ $deliveries->links() }}
