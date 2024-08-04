@if ($page === 'data-pelanggan')
    <div id="table-laporan-customer">
        <div class="table-responsive my-2 tbody-wrap">
            <table class="table mb-0" id="table-laporan" data-total="{{ number_format($totalKas, 0, ',', '.') }}">
                <thead>
                    <tr class="text-start">
                        <th>Membership</th>
                        <th>Nama Pelanggan</th>
                        <th>Transaksi Terakhir</th>
                        <th>Total Cuci</th>
                        <th>Total Harga</th>
                        <th>Hutang</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $user)
                        <tr>
                            <td class="text-center">{{ $user['member'] == 0 ? 'Bukan member' : 'Membership' }}</td>
                            <td class="text-center">{{ $user['nama'] }}</td>
                            <td class="text-center">{{ $user['transaksi_terakhir'] }}</td>
                            <td class="text-center">{{ $user['total_cuci'] }}</td>
                            <td class="text-center">Rp: {{ number_format($user['total_harga'], 0, ',', '.') }}</td>
                            <td class="text-center">
                                @if ($user['hutang'] == 0)
                                    Lunas
                                @else
                                    Rp: -{{ number_format($user['hutang'], 0, ',', '.') }}
                                @endif
                            </td>
                            <td class="cell-action">
                                <button id="btn-{{ 1 }}" class="btn btn-primary btn-sm btn-show-action"
                                    type="button"><i class="fas fa-bars"></i></button>
                            </td>
                        </tr>
                    @endforeach
                    @if ($highest)
                        <tr class="table-primary">
                            <td colspan="4" class="text-center" id="keterangan">
                                @if (in_array('terbanyak', $jenis))
                                    {{ 'Customer ' . (in_array('terbanyak', $jenis) ? 'Cuci Terbanyak' : '') . ' ' . Str::upper($highest['nama']) }}
                                @elseif (in_array('termahal', $jenis))
                                    {{ 'Customer ' . (in_array('termahal', $jenis) ? 'Cuci Termahal' : '') . ' ' . Str::upper($highest['nama']) }}
                                @elseif (in_array('item', $jenis))
                                    {{ 'Customer ' . (in_array('item', $jenis) ? 'Item cuci terbanyak' : '') . ' ' . Str::upper($highest['item_cuci']) }}
                                @endif

                            </td>
                            <td>
                                <div class="d-flex justify-content-between">
                                    <span class="before-harga">
                                        {{ in_array('terbanyak', $jenis) ? 'Item :' : 'Rp :' }}
                                    </span>
                                    <span
                                        id="harga">{{ in_array('terbanyak', $jenis) ? $highest['total_cuci'] : number_format($highest['total_harga'], 0, ',', '.') }}</span>
                                </div>
                            </td>
                            <td colspan="2"></td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
@elseif ($page === 'data-cuci')
    <div id="table-laporan-cuci">
        <div class="table-responsive my-2 tbody-wrap">
            <table class="table mb-0" id="table-laporan" data-total="{{ number_format($totalKas, 0, ',', '.') }}">
                <thead>
                    <tr class="text-start">
                        <th>Tipe</th>
                        <th>Nama Pelanggan</th>
                        <th>Qty</th>
                        <th>Tanggal Transaksi</th>
                        <th>Nama Item</th>
                        <th>Total</th>
                        <th>Hutang</th>
                        <th>Progres</th>
                    </tr>
                </thead>
                <tbody>

                    @foreach ($data as $item)
                        <tr>
                            <td>{{ Str::upper($item['tipe_transaksi']) }}</td>
                            <td>{{ $item['pelanggan'] }}</td>
                            <td>{{ $item['quantity'] }}</td>
                            <td>{{ $item['transaksi_date'] }}</td>
                            <td>{{ $item['nama'] }}</td>
                            <td>Rp: {{ number_format($item['total_harga'], 0, ',', '.') }}</td>
                            <td>{{ $item['status'] }}</td>
                            <td>{{ $item['progres'] }}</td>
                        </tr>
                    @endforeach
                    @if ($highest)
                    <tr class="table-primary">
                        <td colspan="6" class="text-center" id="keterangan">
                            @if (in_array('item', $jenis))
                                {{  (in_array('item', $jenis) ? 'item Cuci Terbanyak' : '') . ' ' . Str::upper($highest['nama']) }}
                            @endif

                        </td>
                        <td>
                            <div class="d-flex justify-content-between">
                                <span class="before-harga">
                                    {{ in_array('item', $jenis) ? 'Item :' : 'Rp :' }}
                                </span>
                                <span
                                    id="harga">{{ in_array('item', $jenis) ? $highest['quantity'] : number_format($highest['quantity'], 0, ',', '.') }}</span>
                            </div>
                        </td>
                        <td colspan="2"></td>
                    </tr>
                @endif
                </tbody>
            </table>
        </div>
    </div>
@elseif ($page === 'data-omset')
    <div class="mt-4" id="table-laporan-omset">
        <div class="table-responsive my-2 tbody-wrap">
            <table class="table mb-0" id="table-laporan">
                <thead>
                    <tr>
                        <th>Tanggal</th>
                        <th>Kode Transaksi</th>
                        <th>Kode Pelanggan</th>
                        <th>Nama Pelanggan</th>
                        <th>Status Transaksi</th>
                        <th>Besar Omset</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $date = '';
                        $dateIndex = 0;
                        $total = 0;
                    @endphp
                    @foreach ($completedTransactions as $pembayaran)
                        @php
                            if ($date != date('d-m-Y', strtotime($pembayaran->created_at))) {
                                $date = date('d-m-Y', strtotime($pembayaran->created_at));
                                $dateIndex = 0;
                                $total = 0;
                            }
                        @endphp
                        @if ($dateIndex == 0)
                            <tr>
                                <td class="text-center table-success"
                                    rowspan="{{ $rowHeight[date('d-m-Y', strtotime($pembayaran->created_at))] + 1 }}">
                                    {{ date('d-M-Y', strtotime($pembayaran->created_at)) }}</td>
                            @else
                            <tr>
                        @endif
                        <td class="text-center">{{ $pembayaran->transaksi->kode }}</td>
                        <td class="text-center">
                            {{ 'PL' . str_pad($pembayaran->transaksi->pelanggan->id, 6, '0', STR_PAD_LEFT) }}</td>
                        <td>{{ $pembayaran->transaksi->pelanggan->nama }}</td>
                        @if ($pembayaran->transaksi->lunas)
                            <td class="text-center">Lunas</td>
                        @else
                            <td class="text-center">Belum lunas</td>
                        @endif
                        <td>
                            <div class="d-flex justify-content-between">
                                <span>Rp</span>
                                <span>{{ number_format($pembayaran->nominal, 0, ',', '.') }}</span>
                            </div>
                        </td>
                        </tr>
                        @php
                            $dateIndex++;
                            $total += $pembayaran->nominal;
                        @endphp
                        @if ($dateIndex == $rowHeight[date('d-m-Y', strtotime($pembayaran->created_at))])
                            <tr class="table-success">
                                <td colspan="4" class="text-center">
                                    {{ 'Total omset per ' . date('d-M-Y', strtotime($pembayaran->created_at)) }}</td>
                                <td>
                                    <div class="d-flex justify-content-between">
                                        <span>Rp</span>
                                        <span>{{ number_format($total, 0, ',', '.') }}</span>
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
@elseif ($page === 'data-saldo')
    <div id="table-laporan-saldo">
        <div class="table-responsive my-2 tbody-wrap">
            <table class="table mb-0" id="table-laporan" {{-- data-total="{{ number_format($totalKas, 0, ',', '.') }}" --}}>
                <thead>
                    <tr class="text-start">
                        <th>Membership</th>
                        <th>Nama Pelanggan</th>
                        <th>Jenis Input</th>
                        <th>Nominal</th>
                        <th>Transaksi Terakhir</th>
                        <th>Saldo Akhir</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($completedBalances as $balance)
                        @php
                            $date = date('d-m-Y', strtotime($balance->created_at));
                            $rowSpan = $rowHeight[$date] + 1;
                        @endphp
                        {{-- @if ($loop->first || $previousDate !== $date)
                            <tr>
                                <td class="text-center" rowspan="{{ $rowSpan }}">
                                    {{ date('d-M-Y', strtotime($balance->created_at)) }}</td>
                            @else
                            <tr>
                        @endif --}}
                        <td>{{ $balance->pelanggan->member ? 'Member' : 'Non-member' }}</td>
                        <td>{{ $balance->pelanggan->nama }}</td>
                        <td>{{ $balance->jenis_input }}</td>
                        <td>{{ number_format($balance->nominal, 0, ',', '.') }}</td>
                        <td>{{ date('d-M-Y', strtotime($balance->created_at)) }}</td>
                        <td>{{ number_format($balance->saldo_akhir, 0, ',', '.') }}</td>
                        </tr>
                        @php
                            $previousDate = $date;
                        @endphp
                    @endforeach
                    @if ($highest)
                        <tr class="table-primary">
                            <td colspan="5" class="text-center" id="keterangan">
                                @if (in_array('saldoTerbesar', $jenis))
                                    {{ 'Saldo Terbesar Adalah ' . Str::upper($highest->pelanggan->nama) }}
                                @endif
                            </td>
                            <td>
                                <div class="d-flex justify-content-between">
                                    <span class="before-harga">
                                        @if (in_array('saldoTerbesar', $jenis))
                                            {{ 'Saldo :' }}
                                        @endif
                                    </span>
                                    <span id="harga">
                                        @if (in_array('saldoTerbesar', $jenis))
                                            {{ number_format($highest->saldo_akhir, 0, ',', '.') }}
                                        @endif
                                    </span>
                                </div>
                            </td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
@endif
