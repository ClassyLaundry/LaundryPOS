<!DOCTYPE html>
<html>

<head>
    <title>Transaction Receipt</title>
    <style>
        /* Add any styles you want to use for the PDF here */
        body {
            font-family: sans-serif;
            font-size: 12pt;
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
            margin: 0px;
        }

        p {
            margin: 0px;
        }

        .text-center {
            text-align: center;
        }

        .text-end {
            text-align: right;
        }
    </style>
</head>

<body style="width: 480px; height: 100%; padding: 0px;">
    <div id="data-header">
        <h4 style="margin-top: 0px;">{{ $data->header['nama_usaha'] }}</h4>
        <h4 style="white-space: nowrap; text-overflow: clip; overflow: hidden;">{{ $data->transaksi->outlet->alamat }}</h4>
        <h4>{{ $data->transaksi->outlet->telp_1 }}</h4>
    </div>
    <p class="hr-text">
        =========================================================================================================================
    </p>
    <p style="margin: 4px auto;">{{ Str::upper($data->transaksi->tipe_transaksi) }}</p>
    <p class="hr-text" style="margin-bottom: 4px;">
        =========================================================================================================================
    </p>
    <div id="detail-transaksi">
        @foreach ($data->transaksi->item_transaksi as $item)
        <div style="margin-bottom: 4px;">
            <p style="white-space: nowrap; text-overflow: clip; overflow: hidden;">{{ $item->nama }}</p>
            <p>{{ $item->qty }} {{ $item->satuan_unit }}</p>
        </div>
        @endforeach
    </div>
    <p class="hr-text">
        =========================================================================================================================
    </p>
    <div style="margin: 4px auto;">
        <p>Jumlah Item: {{ $data->total_item }}</p>
    </div>
    <p class="hr-text">
        =========================================================================================================================
    </p>
    <div style="margin-top: 4px;">
        @isset($data->pickup) <p>Delivery: {{ $data->pickup->driver->name }}</p>@endisset
        <p>Pelanggan: {{ $data->pelanggan->nama }}</p>
        @isset($data->pickup) <p style="word-wrap: break-word; text-overflow: ellipsis; overflow: hidden; max-height: 28px;">Alamat: {{ substr($data->pickup->alamat, 0, 60) }}</p>@endisset
        @isset($data->pickup) <p style="word-wrap: break-word; text-overflow: ellipsis; overflow: hidden; max-height: 41px;">Catatan: {{ substr($data->pickup->request, 0, 90) }}</p>@endisset
    </div>
</body>

</html>
