<!DOCTYPE html>
<html>

<head>
    <title>Delivery Note</title>
    <style>
        /* Add any styles you want to use for the PDF here */
        body {
            font-family: Arial, sans-serif;
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
            ============================================================================================================================
        </p>
        <div style="position: relative; height: 150px;">
            <h1 style="position: absolute; left: 0px; top: -15px;">MEMO PRODUKSI</h1>
            <h1 style="position: absolute; left: 400px; top: -15px;">{{ $data->transaksi->memo_code }}</h1>

            <p style="position: absolute; left: 0px; top: 30px;">NO. ORDER</p>
            <p style="position: absolute; left: 100px; top: 30px;">: {{ $data->transaksi->kode }} / {{ $data->transaksi->jenis_transaksi }}</p>

            <p style="position: absolute; left: 400px; top: 30px;">PENCETAKAN</p>
            <p style="position: absolute; left: 500px; top: 30px;">: {{ date('d-M-Y h:i:s') }}</p>

            <p style="position: absolute; left: 0px; top: 60px;">PELANGGAN</p>
            <p style="position: absolute; left: 100px; top: 60px;">: {{ $data->transaksi->pelanggan->no_id }} / {{ $data->transaksi->pelanggan->nama }}</p>

            <p style="position: absolute; left: 400px; top: 60px;">TGL CUCI</p>
            <p style="position: absolute; left: 500px; top: 60px;">: {{ date('d-M-Y h:i:s', strtotime($data->transaksi->created_at)) }} s.d {{ date('d-M-Y', strtotime($data->transaksi->updated_at)) }}</p>

            <p style="position: absolute; left: 0px; top: 90px;">ALAMAT/TELP</p>
            <p style="position: absolute; left: 100px; top: 90px;">: {{ $data->transaksi->pelanggan->alamat }} / {{ $data->transaksi->pelanggan->telephone }}</p>

            <p style="position: absolute; left: 0px; top: 120px;">EXPRESS</p>
            <p style="position: absolute; left: 100px; top: 120px;">: {{ $data->transaksi->express ? 'YA' : 'TIDAK' }}</p>

            <p style="position: absolute; left: 300px; top: 120px;">SETRIKA SAJA</p>
            <p style="position: absolute; left: 400px; top: 120px;">: {{ $data->transaksi->setrika_only ? 'YA' : 'TIDAK' }}</p>

            <p style="position: absolute; left: 600px; top: 120px;">DELIVERY</p>
            <p style="position: absolute; left: 700px; top: 120px;">: {{ $data->status_delivery }}</p>
        </div>
        <p class="hr-text" style="margin-bottom: 0px;">
            ============================================================================================================================
        </p>
    </div>
    <div id="detail-transaksi">
        @if (str_contains($data->transaksi->kode, 'BU-'))
        <table style="font-size: 10pt">
            <thead style="border-bottom: 1px solid black;">
                <tr>
                    <th class="text-center">NAMA ITEM</th>
                    <th class="text-center">QTY</th>
                    <th class="text-center">UNIT</th>
                    <th class="text-center">BOBOT</th>
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
                    <th class="text-center">NAMA ITEM</th>
                    <th class="text-center">QTY</th>
                    <th class="text-center">UNIT</th>
                    <th class="text-center">KETERANGAN</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data->transaksi->item_transaksi as $item)
                    <tr>
                        <td class="text-start">{{ $item->nama }}</td>
                        <td class="text-center">{{ $item->qty }}</td>
                        <td class="text-center">{{ $item->satuan_unit }}</td>
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
            ============================================================================================================================
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
            ============================================================================================================================
        </p>
        <div style="position: relative; height: 90px;">
            <p style="position: absolute; left: 0px; top: 25px;">Tim Produksi</p>

            <p class="text-center" style="position: absolute; left: 100px; top: 40px; width: 200px;">{{ $data->transaksi->pencuci }}</p>
            <p class="text-center" style="position: absolute; left: 100px; top: 45px; width: 200px;">_______________</p>
            <p class="text-center" style="position: absolute; left: 100px; top: 60px; width: 200px;">cuci</p>


            <p class="text-center" style="position: absolute; left: 300px; top: 40px; width: 200px;">{{ $data->transaksi->penyetrika }}</p>
            <p class="text-center" style="position: absolute; left: 300px; top: 45px; width: 200px;">_______________</p>
            <p class="text-center" style="position: absolute; left: 300px; top: 60px; width: 200px;">setrika</p>

            <p class="text-center" style="position: absolute; left: 500px; top: 40px; width: 200px;"></p>
            <p class="text-center" style="position: absolute; left: 500px; top: 45px; width: 200px;">_______________</p>
            <p class="text-center" style="position: absolute; left: 500px; top: 60px; width: 200px;">packing</p>

            <p class="text-center" style="position: absolute; left: 700px; top: 40px; width: 200px;"></p>
            <p class="text-center" style="position: absolute; left: 700px; top: 45px; width: 200px;">_______________</p>
            <p class="text-center" style="position: absolute; left: 700px; top: 60px; width: 200px;">delivery</p>
        </div>
        <p class="hr-text" style="margin-top: 0px;">
            ============================================================================================================================
        </p>
    </div>
</body>

</html>
