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

        h3 {
            margin-bottom: 0px!important;
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
            margin: 0px!important;
        }

        .text-center {
            text-align: center;
        }

        .text-end {
            text-align: right;
        }
    </style>
    <link rel="stylesheet" href="{{asset('bootstrap/css/bootstrap.min.css')}}">
</head>

<body class="h-100 p-3" style="width: 480px; margin-top: 100px;">
    <div id="data-header">
        <h3 class="mt-0">{{ $data->header['nama_usaha'] }}</h3>
        <h3 style="white-space: nowrap; text-overflow: clip; overflow: hidden;">{{ $data->transaksi->outlet->alamat }}</h3>
        <h3>{{ $data->transaksi->outlet->telp_1 }}</h3>
    </div>
    <p class="hr-text lh-1">
        =========================================================================================================================
    </p>
    <p>Tipe: {{ Str::ucfirst($data->transaksi->tipe_transaksi) }}</p>
    <div class="d-flex">
        <p class="w-50">Tanggal Masuk: {{ date('d-M-Y', strtotime($data->transaksi->created_at)) }}</p>
        <p class="w-50">Tanggal Selesai: {{ date('d-M-Y', strtotime($data->transaksi->done_date)) }}</p>
    </div>
    <p class="hr-text lh-1" style="margin-bottom: 4px;">
        =========================================================================================================================
    </p>
    <p class="m-0">Item</p>
    <p class="hr-text lh-1 m-0">
        -------------------------------------------------------------------------------------------------------------------------
    </p>
    <div id="detail-transaksi">
        @foreach ($data->transaksi->item_transaksi as $item)
        <div class="mb-1 d-flex justify-content-between">
            <p style="white-space: nowrap; text-overflow: clip; overflow: hidden;">{{ Str::ucfirst(Str::lower($item->nama)) }}</p>
            <p>{{ $item->qty }} {{ Str::lower($item->satuan_unit) }}</p>
        </div>
        @endforeach
    </div>
    <p class="hr-text lh-1">
        =========================================================================================================================
    </p>
    <div>
        <p>Jumlah Item: {{ $data->total_qty }}</p>
    </div>
    <p class="hr-text lh-1">
        =========================================================================================================================
    </p>
    <div>
        <p>Pelanggan: {{ $data->pelanggan->nama }}</p>

        @isset($data->pickup)
            <p>Delivery: {{ $data->pickup->driver->name }}</p>
            <p style="word-wrap: break-word; text-overflow: ellipsis; overflow: hidden; max-height: 28px;">Alamat Pickup: {{ Str::limit($data->pickup->alamat, 60) }}</p>
        @endisset

        <p style="word-wrap: break-word; text-overflow: ellipsis; overflow: hidden; max-height: 41px;">
            Catatan:
            @isset($data->transaksi->catatan_transaksi)
                <span>{{ Str::limit($data->transaksi->catatan_transaksi, 90) }}</span>
            @endisset
        </p>
    </div>
</body>

</html>
