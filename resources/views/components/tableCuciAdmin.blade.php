@php
    use Carbon\Carbon;
@endphp
<div class="table-responsive">
    <table class="table" id="table-list-catatan">
        <thead class="text-center">
            <tr>
                <th>Kode</th>
                <th>Pelanggan</th>
                <th>Tipe</th>
                <th>Tanggal Transaksi</th>
                <th>Tanggal Selesai</th>
                <th>Status</th>
                <th>Pencuci</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($transaksis as $transaksi)
            <tr id={{ $transaksi->id }}>
                <td class='text-center'>{{ $transaksi->kode }}</td>
                <td class='text-center'>{{ $transaksi->pelanggan->nama }}</td>
                <td class='text-center'>
                    @if ($transaksi->express && $transaksi->on_time)
                        Express & On time
                    @elseif ($transaksi->express)
                        Express
                    @elseif ($transaksi->on_time)
                        On time
                    @else
                        Normal
                    @endif
                </td>
                <td class='text-center'>{{ date('d-m-Y', strtotime($transaksi->created_at)) }}</td>
                @php
                    $doneDate = Carbon::parse($transaksi->done_date);
                    $isUrgent = Carbon::today()->diffInDays($doneDate, false) <= 3;
                @endphp
                <td class='text-center {{ $isUrgent && !$transaksi->is_done_cuci ? 'text-danger fw-bold' : '' }}'>{{ date('d-m-Y', strtotime($transaksi->done_date)) }}</td>
                <td class='text-center'>
                    @if ($transaksi->tukang_cuci == null)
                        Staging
                    @else
                        @if ($transaksi->is_done_cuci)
                            Done
                        @else
                            On Process
                        @endif
                    @endif
                </td>
                <td class='text-center'> @isset($transaksi->tukang_cuci) {{ $transaksi->tukang_cuci->name }} @else - @endisset </td>
            @endforeach
        </tbody>
    </table>
</div>

{{ $transaksis->links() }}
