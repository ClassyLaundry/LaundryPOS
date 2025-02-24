<div id="table-laporan-piutang">
    <div class="table-responsive my-2 tbody-wrap">
        <table class="table mb-0" id="table-laporan" data-total="{{ number_format($totalKas, 0, ',', '.') }}">
            <thead>
                <tr class="text-start">
                    <th>Tipe Bayar</th>
                    <th>Kode Pembayaran</th>
                    <th>Nomor Order</th>
                    <th>Tanggal Transaksi</th>
                    <th>Pelanggan</th>
                    <th>Nominal</th>
                    <th>Keterangan</th>
                    <th>Operator</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $tipe = '';
                    $index = 0;
                @endphp
                @foreach ($kas as $data)
                @php
                    if ($tipe != $data["tipe"]) {
                        $tipe = $data["tipe"];
                        $index = 0;
                    } else {
                        $index++;
                    }
                @endphp
                    @if ($index == 0)
                        <tr><td rowspan="{{ $rowHeight[$tipe] == 1 ? $rowHeight[$tipe] : $rowHeight[$data["tipe"]] + 1 }}" class="table-primary">{{ Str::upper($data["tipe"]) }}</td>
                    @else
                        <tr>
                    @endif
                        <td>{{ $data->kode }}</td>
                        <td>{{ $data->nomor_order }}</td>
                        <td>{{ date('d-M-Y', strtotime($data->tanggal)) }}</td>
                        <td>{{ Str::upper($data->pelanggan) }}</td>
                        <td>
                            <div class="d-flex justify-content-between">
                                <span>Rp</span>
                                <span>{{ number_format($data->nominal, 0, ',', '.') }}</span>
                            </div>
                        </td>
                        <td>{{ $data->keterangan }}</td>
                        <td>{{ $data->operator }}</td>
                    </tr>
                    @if ($rowHeight[$data["tipe"]] == $index + 1 && $index != 0)
                        <tr class="table-primary">
                            <td colspan="4" class="text-center">{{ "TOTAL KAS MASUK VIA " . Str::upper($data["tipe"]) }}</td>
                            <td>
                                <div class="d-flex justify-content-between">
                                    <span>Rp</span>
                                    <span>{{ number_format($sumOfEachPaymentMethod[$data["tipe"]], 0, ',', '.') }}</span>
                                </div>
                            </td>
                            <td colspan="2"></td>
                        </tr>
                    @endif
                @endforeach
            </tbody>
        </table>
    </div>
</div>
