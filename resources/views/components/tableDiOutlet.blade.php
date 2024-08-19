<div class="table-responsive">
    <table class="table">
        <thead>
            <tr>
                <th>Kode Transaksi</th>
                <th>Pelanggan</th>
                <th>Penerima</th>
                <th>Outlet</th>
                <th>Tanggal Ambil</th>
            </tr>
        </thead>
        <tbody class="text-center">
            @foreach ($diOutlets as $ambil_di_outlet)
                <tr>
                    <td>{{ $ambil_di_outlet->transaksi->kode }}</td>
                    <td>{{ $ambil_di_outlet->transaksi->pelanggan->nama }}</td>
                    <td>{{ $ambil_di_outlet->penerima }}</td>
                    <td>{{ $ambil_di_outlet->outlet->nama }}</td>
                    <td>{{ date('d-M-Y H:i', strtotime($ambil_di_outlet->created_at)) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
{{ $diOutlets->links() }}
