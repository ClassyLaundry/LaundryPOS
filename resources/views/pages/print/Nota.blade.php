<!DOCTYPE html>
<html>

<head>
    <title>Transaction Receipt</title>
    <style>
        /* Add any styles you want to use for the PDF here */
        body {
            font-family: sans-serif;
            font-size: 10pt
        }

        table {
            width: 100%;
        }

        th,
        td {
            padding: 8px;
            text-align: left;
        }
        h4 {
            margin: 4px 0px;
        }

        .hr-text {
            color: #333;
            text-align: center;
            width: 100%;
            overflow: hidden;
            white-space: nowrap;
            text-overflow: "";
            margin: 8px 0px;
        }

        td {
            border: none!important;
        }

        .text-center {
            text-align: center;
        }

        .text-end {
            text-align: right;
        }
    </style>
</head>
<body style="width: 100%; height: 100%;">
    <div id="data-header">
        <h4> {{ $data->header['nama_usaha'] }}</h4>
        <h4> {{ $data->transaksi->outlet->alamat }}</h4>
        <h4> {{ $data->header['delivery_text'] }}</h4>
    </div>
    <div id=data-transaksi>
        <p class="hr-text" style="margin-bottom: 0px;">
            =========================================================================================================================
        </p>
        <div style="position: relative; height: 150px;">
            <p style="position: absolute; left: 0px; top: 0px;">NO. ORDER</p>
            <p style="position: absolute; left: 100px; top: 0px;">: {{ $data->transaksi->kode }} / {{ strtoupper($data->transaksi->tipe_transaksi) }}</p>

            <p style="position: absolute; left: 350px; top: 0px;">PENCETAKAN</p>
            <p style="position: absolute; left: 450px; top: 0px;">: {{ date('d-M-Y h:i:s') }}</p>

            <p style="position: absolute; left: 0px; top: 30px;">PELANGGAN</p>
            <p style="position: absolute; left: 100px; top: 30px;">: {{ $data->transaksi->pelanggan->no_id }} / {{ $data->transaksi->pelanggan->nama }}</p>

            <p style="position: absolute; left: 350px; top: 30px;">TGL CUCI</p>
            <p style="position: absolute; left: 450px; top: 30px;">: {{ date('d-M-Y', strtotime($data->transaksi->created_at)) }} s.d {{ date('d-M-Y', strtotime($data->transaksi->done_date)) }}</p>

            <p style="position: absolute; left: 0px; top: 60px;">ALAMAT/TELP</p>
            <p style="position: absolute; left: 100px; top: 60px;">: {{ $data->transaksi->pelanggan->alamat }} / {{ $data->transaksi->pelanggan->telephone }}</p>

            <p style="position: absolute; left: 0px; top: 90px;">SISA DEPOSIT</p>
            <p style="position: absolute; left: 100px; top: 90px;">: {{ $data->transaksi->pelanggan->saldo_akhir }}</p>

            <p style="position: absolute; left: 0px; top: 120px;">EXPRESS</p>
            <p style="position: absolute; left: 100px; top: 120px;">: {{ $data->transaksi->express ? 'YA' : 'TIDAK' }}</p>

            <p style="position: absolute; left: 250px; top: 120px;">SETRIKA SAJA</p>
            <p style="position: absolute; left: 350px; top: 120px;">: {{ $data->transaksi->setrika_only ? 'YA' : 'TIDAK' }}</p>

            <p style="position: absolute; left: 500px; top: 120px;">DELIVERY</p>
            <p style="position: absolute; left: 600px; top: 120px;">: {{ $data->status_delivery }}</p>
        </div>
        <p class="hr-text" style="margin-bottom: 0px;">
            =========================================================================================================================
        </p>
    </div>
    <div id="detail-transaksi">
        @if (str_contains($data->transaksi->kode, 'BU-'))
        <table style="font-size: 10pt">
            <thead style="border-bottom: 1px solid black;">
                <tr>
                    <th class="text-center" style="">NAMA ITEM</th>
                    <th class="text-center">QTY</th>
                    <th class="text-center">UNIT</th>
                    <th class="text-center">BOBOT</th>
                    <th class="text-center">TOTAL</th>
                    <th class="text-center">KETERANGAN</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data->transaksi->item_transaksi as $item)
                    <tr>
                        <td class="text-start">{{ $item->nama }}</td>
                        <td class="text-center">{{ $item->qty }}</td>
                        <td class="text-center">{{ $item->satuan_unit }}</td>
                        <td class="text-center">{{ $item->bobot_bucket }}</td>
                        <td class="text-center">{{ $item->total_bobot }}</td>
                        <td class="text-start">
                            @foreach ($item->item_notes as $item_note)
                                @if ($loop->index == 0)
                                    {{ $item_note->catatan }}
                                @else
                                    {{ ', ' . $item_note->catatan }}
                                @endif
                            @endforeach
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        @elseif (str_contains($data->transaksi->kode, 'PR-'))
        <table style="font-size: 10pt">
            <thead style="border-bottom: 1px solid black;">
                <tr>
                    <th class="text-center" style="width: 25%;">NAMA ITEM</th>
                    <th class="text-center" style="width: 5%;">QTY</th>
                    <th class="text-center" style="width: 7.5%;">UNIT</th>
                    <th class="text-center" style="width: 10%;">DISKON</th>
                    <th class="text-center" style="width: 10%;">TOTAL</th>
                    <th class="text-center">KETERANGAN</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data->transaksi->item_transaksi as $item)
                    <tr>
                        <td class="text-start">{{$item->nama}}</td>
                        <td class="text-center">{{$item->qty}}</td>
                        <td class="text-center">{{$item->satuan_unit}}</td>
                        <td class="text-center">{{$item->diskon_jenis_item}}</td>
                        <td class="text-center">{{$item->total_premium}}</td>
                        <td class="text-start">
                            @foreach ($item->item_notes as $item_note)
                                @if ($loop->index == 0)
                                    {{ $item_note->catatan }}
                                @else
                                    {{ ', ' . $item_note->catatan }}
                                @endif
                            @endforeach
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        @endif
        <p class="hr-text" style="margin: 0px;">
            =========================================================================================================================
        </p>
        <div style="position: relative; height: 60px;">
            <p style="position: absolute; left: 0px; top: 0px;">Jml Pcs</p>
            <p style="position: absolute; left: 100px; top: 0px;">: {{ $data->total_qty }}</p>

            <p style="position: absolute; left: 200px; top: 0px;">Jml Bobot</p>
            <p style="position: absolute; left: 300px; top: 0px;">: {{ $data->total_bobot }}</p>

            <p style="position: absolute; left: 400px; top: 0px;">Jml M2</p>
            <p style="position: absolute; left: 500px; top: 0px;">: 0</p>

            <p style="position: absolute; left: 0px; top: 30px;">CATATAN</p>
            <p style="position: absolute; left: 100px; top: 30px;">: {{ $data->transaksi->catatan }}</p>
        </div>
        <p class="hr-text" style="margin-bottom: 0px;">
            =========================================================================================================================
        </p>
        <div style="position: relative; height: 90px;">
            <p style="position: absolute; left: 0px; top: 0px;">Subtotal</p>
            <p style="position: absolute; left: 100px; top: 0px;">:</p>
            <p style="position: absolute; left: 100px; top: 0px; width: 75px;" class="text-end">{{ number_format($data->transaksi->subtotal, 0, ',', '.') }}</p>

            <p style="position: absolute; left: 300px; top: 0px;">Grand Total</p>
            <p style="position: absolute; left: 400px; top: 0px;">:</p>
            <p style="position: absolute; left: 400px; top: 0px; width: 75px;" class="text-end">{{ number_format($data->transaksi->grand_total, 0, ',', '.') }}</p>

            <p style="position: absolute; left: 0px; top: 30px;">Diskon</p>
            <p style="position: absolute; left: 100px; top: 30px;">:</p>
            <p style="position: absolute; left: 100px; top: 30px; width: 75px;" class="text-end">{{ number_format($data->transaksi->diskon_jenis_item + $data->transaksi->total_diskon_promo + $data->transaksi->diskon_member, 0, ',', '.') }}</p>

            <p style="position: absolute; left: 300px; top: 30px;">Telah Bayar</p>
            <p style="position: absolute; left: 400px; top: 30px;">:</p>
            <p style="position: absolute; left: 400px; top: 30px; width: 75px;" class="text-end">{{ isset($data->transaksi->terbayar) ? number_format($data->transaksi->terbayar, 0, ',', '.') : '0' }}</p>

            <p style="position: absolute; left: 0px; top: 60px;">Delivery</p>
            <p style="position: absolute; left: 100px; top: 60px;">:</p>
            <p style="position: absolute; left: 100px; top: 60px; width: 75px;" class="text-end">0</p>

            <p style="position: absolute; left: 300px; top: 60px;">Sisa</p>
            <p style="position: absolute; left: 400px; top: 60px;">:</p>
            <p style="position: absolute; left: 400px; top: 60px; width: 75px;" class="text-end">{{ number_format($data->transaksi->grand_total - $data->transaksi->terbayar, 0, ',', '.') }}</p>
            @if (!$data->transaksi->lunas)
            <p style="position: absolute; left: 500px; top: 60px;">BELUM LUNAS</p>
            @endif
        </div>
        <p class="hr-text">
            =========================================================================================================================
        </p>
        <div style="position: relative; height: 30px;">
            <div style="position: absolute; left: 0px; top: 0px;">KASIR</div>
            <div style="position: absolute; left: 100px; top: 0px;">: {{ Auth::user()->name }}</div>
            <div style="position: absolute; left: 300px; top: 0px;">Tagihan belum terbayar</div>
            <div style="position: absolute; left: 500px; top: 0px;">: {{ number_format($data->transaksi->pelanggan->tagihan, 0, ',', '.') }}</div>
        </div>
        <p class="hr-text" style="margin-top: 0px;">
            =========================================================================================================================
        </p>
    </div>
</body>

</html>
