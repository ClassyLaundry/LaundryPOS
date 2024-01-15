<div class="mt-4" id="table-laporan-omset">
    <div class="table-responsive my-2 tbody-wrap">
        <table class="table mb-0" id="table-laporan" data-total="{{ number_format($total_omset, 0, ',', '.') }}">
            <thead>
                <tr>
                    <th>Tanggal</th>
                    <th>Kode Transaksi</th>
                    <th>Kode Pelanggan</th>
                    <th>Nama Pelanggan</th>
                    <th>Besar Omset</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $tanggal = '';
                    $index = 0;
                    $index2 = -1;
                @endphp
                @foreach ($pembayarans as $pembayaran)
                    @php
                        if ($tanggal != date('d-M-Y', strtotime($pembayaran->created_at))) {
                            $tanggal = date('d-M-Y', strtotime($pembayaran->created_at));
                            $index = 0;
                            $index2++;
                        } else {
                            $index++;
                        }
                    @endphp
                    @if ($index == 0)
                        <tr>
                            <td
                                rowspan="{{ $rowHeight[$index2]->count == 1 ? $rowHeight[$index2]->count : $rowHeight[$index2]->count + 1 }}">
                                {{ date('d-M-Y', strtotime($pembayaran->created_at)) }}</td>
                        @else
                        <tr>
                    @endif
                    <td>{{ $pembayaran->transaksi->kode }}</td>
                    <td>{{ 'PL' . str_pad($pembayaran->transaksi->pelanggan->id, 6, '0', STR_PAD_LEFT) }}</td>
                    <td>{{ $pembayaran->transaksi->pelanggan->nama }}</td>
                    <td>
                        <div class="d-flex justify-content-between">
                            <span>Rp</span><span>{{ number_format($pembayaran->nominal, 0, ',', '.') }}</span>
                        </div>
                    </td>
                    </tr>
                    @if ($rowHeight[$index2]->count == $index + 1 && $index != 0)
                        <tr class="table-success">
                            <td colspan="3" class="text-center">
                                {{ 'Total omset per ' . date('d-M-Y', strtotime($rowHeight[$index2]->tanggal)) }}</td>
                            <td>
                                <div class="d-flex justify-content-between">
                                    <span>Rp</span>
                                    <span>{{ number_format($sumOfEachDate[date('d-M-Y', strtotime($rowHeight[$index2]->tanggal))], 0, ',', '.') }}</span>
                                </div>
                            </td>
                        </tr>
                    @endif
                @endforeach
            </tbody>
        </table>
    </div>
</div>
