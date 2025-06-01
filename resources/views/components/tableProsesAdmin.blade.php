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
                @if ($tipe == 'cuci')
                    <th>Pencuci</th>
                @elseif ($tipe == 'setrika')
                    <th>Penyetrika</th>
                @endif
            </tr>
        </thead>
        <tbody>
            @foreach ($transaksis as $transaksi)
            <tr id={{ $transaksi->id }}>
                <td class='text-center'>
                    {{ $transaksi->kode }}
                    @if($transaksi->status === 'rewash')
                        <span class="badge bg-danger">Sedang di rewash</span>
                    @endif
                </td>
                <td class='text-center'>{{ $transaksi->pelanggan->nama }}</td>
                <td class='text-center'>
                    @if ($transaksi->express)
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
                @if ($tipe == 'cuci')
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
                @elseif ($tipe == 'setrika')
                    <td class='text-center {{ $isUrgent && !$transaksi->is_done_setrika ? 'text-danger fw-bold' : '' }}'>{{ date('d-m-Y', strtotime($transaksi->done_date)) }}</td>
                    <td class='text-center'>
                        @if ($transaksi->tukang_setrika == null)
                            Staging
                        @else
                            @if ($transaksi->is_done_setrika)
                                Done
                            @else
                                On Process
                            @endif
                        @endif
                    </td>
                    <td class='text-center'> @isset($transaksi->tukang_setrika) {{ $transaksi->tukang_setrika->name }} @else - @endisset </td>
                @endif
            @endforeach
        </tbody>
    </table>
</div>

{{ $transaksis->links() }}
