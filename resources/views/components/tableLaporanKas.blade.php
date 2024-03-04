<div id="table-laporan-piutang">
    <div class="table-responsive my-2 tbody-wrap">
        {{-- <table class="table mb-0" id="table-laporan" data-total="{{ number_format($total_kas, 0, ',', '.') }}"> --}}
        <table class="table mb-0" id="table-laporan">
            <thead>
                <tr class="text-start">
                    <th>Tipe Bayar</th>
                    <th>Kode Pembayaran</th>
                    <th>Tanggal Transaksi</th>
                    <th>Pelanggan</th>
                    <th>Nominal</th>
                    <th>Keterangan</th>
                    <th>Operator</th>
                </tr>
            </thead>
            <tbody>
                {{-- @php
                    $metode = '';
                    $index = 0;
                @endphp --}}
                @foreach ($kas as $data)
                {{-- @php
                    if ($metode != $data->metode_pembayaran) {
                        $metode = $data->metode_pembayaran;
                        $index = 0;
                    } else {
                        $index++;
                    }
                @endphp --}}
                    {{-- @if ($index == 0)
                        <tr><td rowspan="{{ $rowHeight[$data->metode_pembayaran] == 1 ? $rowHeight[$data->metode_pembayaran] : $rowHeight[$data->metode_pembayaran] + 1 }}" class="table-primary">{{ Str::upper($data->metode_pembayaran) }}</td>
                    @else --}}
                        <tr>
                    {{-- @endif --}}
                        <td>{{ $data->tipe }}</td>
                        <td>{{ $data->kode }}</td>
                        <td>{{ date('d-M-Y', strtotime($data->tanggal)) }}</td>
                        <td>{{ Str::upper($data->pelanggan) }}</td>
                        <td>
                            <div class="d-flex justify-content-between">
                                <span>Rp</span>
                                <span>{{ number_format($data->nominal, 0, ',', '.') }}</span>
                            </div>
                        </td>
                        <td>{{ $data->keterangan }}</td>
                    </tr>
                    {{-- @if ($rowHeight[$data->metode_pembayaran] == $index + 1 && $index != 0)
                        <tr class="table-primary">
                            <td colspan="3" class="text-center">{{ "TOTAL KAS MASUK VIA " . Str::upper($data->metode_pembayaran) }}</td>
                            <td>
                                <div class="d-flex justify-content-between">
                                    <span>Rp</span>
                                    <span>{{ number_format($sumOfEachPaymentMethod[$data->metode_pembayaran], 0, ',', '.') }}</span>
                                </div>
                            </td>
                            <td></td>
                        </tr>
                    @endif --}}
                @endforeach
            </tbody>
        </table>
    </div>
</div>
