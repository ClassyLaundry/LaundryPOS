<div class="table-responsive">
    <table class="table">
        <thead>
            <tr>
                <th>Delivery</th>
                <th>Transaksi</th>
                <th>Pelanggan</th>
                <th>Waktu Order</th>
                <th>Alamat</th>
                <th>Driver</th>
                <th>Status</th>
                @if(in_array("Menghapus Pickup Delivery", Session::get('permissions')) || Session::get('role') == 'administrator')
                    <th style="width: 38.25px;"></th>
                @endif
            </tr>
        </thead>
        <tbody>
            @foreach ($deliveries as $delivery)
                <tr>
                    <td class="text-center">{{ $delivery->kode }}</td>
                    <td class="text-center">{{ $delivery->transaksi->kode }}</td>
                    <td>{{ $delivery->pelanggan->nama }}</td>
                    <td class="text-center">{{ date('d-M-Y H:i', strtotime($delivery->created_at)) }}</td>
                    <td>{{ $delivery->alamat }}</td>
                    <td class="text-center">{{ $delivery->nama_driver }}</td>
                    <td class="text-center">{{ ($delivery->is_done) ? 'Selesai' : 'Proses' }}</td>
                    @if(in_array("Menghapus Pickup Delivery", Session::get('permissions')) || Session::get('role') == 'administrator')
                    <td class='text-end p-1'>
                        @if ($delivery->is_done == 0)
                        <button id='btn-{{ $delivery->id }}' class='btn btn-primary btn-sm btn-show-action' type='button'>
                            <i class='fas fa-bars' aria-hidden='true'></i>
                        </button>
                        @endif
                    </td>
                    @endif
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
{{ $deliveries->links() }}
