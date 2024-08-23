<div id="table-laporan-piutang">
    <div class="table-responsive my-2 tbody-wrap">
        <table class="table mb-0" id="table-laporan" data-total="{{ number_format($total_piutang, 0, ',', '.') }}">
            <thead>
                <tr class="text-start">
                    <th>Kode Pelanggan</th>
                    <th>Nama Pelanggan</th>
                    <th>No</th>
                    <th>Kode Transaksi</th>
                    <th>Tanggal Transaksi</th>
                    <th>Total Tagihan</th>
                    <th>Kurang Bayar</th>
                    <th style="width: 36.25px;"></th>
                </tr>
            </thead>
            <tbody>
            @foreach ($pelanggans as $pelanggan)
            @if ($pelanggan->jumlahTransaksiBetweenDate($start, $end) > 0)
            @php
                $totalTagihan = 0;
                $totalKurangBayar = 0;
                $index = 1;
            @endphp
            <tr>
                <td rowspan="{{ $pelanggan->jumlahTransaksiBetweenDate($start, $end) + 1 }}">{{ 'PL' . str_pad($pelanggan->id, 6, '0', STR_PAD_LEFT) }}</td>
                <td rowspan="{{ $pelanggan->jumlahTransaksiBetweenDate($start, $end) + 1 }}">{{ Str::upper($pelanggan->nama) }}</td>
                @foreach($pelanggan->transaksi as $key => $trans)
                    @php
                        $index2 = 0;
                    @endphp
                    @if ($trans->created_at >= $start && $trans->created_at <= $end)
                        @php
                            $totalTagihan += $trans->grand_total;
                            $totalKurangBayar += $trans->grand_total - $trans->total_terbayar;
                        @endphp
                        @if ($totalKurangBayar > 0)
                            @if($index2 > 0)
                                <tr>
                            @endif
                            <td>{{ $index }}</td>
                            <td>{{ $trans->kode }}</td>
                            <td>{{ date('d-M-Y H:i:s', strtotime($trans->created_at)) }}</td>
                            <td>
                                <div class="d-flex justify-content-between">
                                    <span>Rp</span>
                                    <span>{{ number_format($trans->grand_total, 0, ',', '.') }}</span>
                                </div>
                            </td>
                            <td>
                                <div class="d-flex justify-content-between">
                                    <span>Rp</span>
                                    <span>{{ number_format($trans->grand_total - $trans->total_terbayar, 0, ',', '.') }}</span>
                                </div>
                            </td>
                            @if($index == 1)
                                <td class="cell-action">
                                    <div class="d-flex h-100 align-items-center justify-content-end">
                                        <button id="btn-{{ $pelanggan->id }}" class="btn btn-primary btn-sm btn-show-action" type="button">
                                            <i class="fas fa-bars"></i>
                                        </button>
                                    </div>
                                </td>
                            @endif
                            @if($index2 == 0)
                                </tr>
                            @endif
                            @php
                                $index++;
                                $index2++;
                            @endphp
                        @endif
                    @endif
                @endforeach
                <tr class="table-info">
                    <td colspan="3">Total Tagihan</td>
                    <td>
                        <div class="d-flex justify-content-between">
                            <span>Rp</span>
                            <span>{{ number_format($totalTagihan, 0, ',', '.') }}</span>
                        </div>
                    </td>
                    <td>
                        <div class="d-flex justify-content-between">
                            <span>Rp</span>
                            <span>{{ number_format($totalKurangBayar, 0, ',', '.') }}</span>
                        </div>
                    </td>
                    <td></td>
                </tr>
            </tr>
            @endif
            @endforeach
            </tbody>
        </table>
    </div>
</div>
