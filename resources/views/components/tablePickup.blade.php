<div class="table-responsive">
    <table class="table">
        <thead>
            <tr>
                <th>Kode</th>
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
            @foreach ($pickups as $pickup)
                <tr>
                    <td class="text-center">{{ $pickup->kode }}</td>
                    <td>{{ $pickup->pelanggan->nama }}</td>
                    <td class="text-center">{{ date('d-M-Y H:i', strtotime($pickup->created_at)) }}</td>
                    <td>{{ $pickup->alamat }}</td>
                    <td class="text-center">{{ $pickup->nama_driver }}</td>
                    <td class="text-center">{{ ($pickup->is_done) ? 'Selesai' : 'Proses' }}</td>
                    @if(in_array("Menghapus Pickup Delivery", Session::get('permissions')) || Session::get('role') == 'administrator')
                    <td class='text-end p-1'>
                        @if ($pickup->is_done == 0)
                        <button id='btn-{{ $pickup->id }}' class='btn btn-primary btn-sm btn-show-action' type='button'>
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
{{ $pickups->links() }}
