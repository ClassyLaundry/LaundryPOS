<!DOCTYPE html>
<html>

<head>
    @include('includes.head')
    <link href='https://fonts.googleapis.com/css?family=Roboto Mono' rel='stylesheet'>
    <title>Delivery Note</title>
    <style>
        /* Add any styles you want to use for the PDF here */
        body {
            font-family: 'Roboto Mono';
            font-size: 1.25rem;
        }

        table {
            width: 100%;
        }

        th,
        td {
            padding: 0;
            text-align: left;
        }

        hr {
            margin: .25rem 0;
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

        p {
            margin: 0;
        }

        .w-15 {
            width: 15%!important;
        }

        .w-30 {
            width: 30%!important;
        }

        .w-70 {
            width: 70%!important;
        }
    </style>
</head>
<body style="width: 1000px;">
    <div id="data-header">
        <p style="font-weight: 600;">
            {{ Str::upper($data->transaksi->outlet->nama) }}<br>
            {{ $data->transaksi->outlet->alamat }} <br>
            {{ $data->header['delivery_text'] }}
        </p>
    </div>
    <hr>
    <div id="data-transaksi">
        <div class="d-flex fs-2">
            <p>MEMO PRODUKSI</p>
            <p class="fw-bold ms-4">{{ $data->transaksi->memo_code }}</p>
        </div>

        <div class="d-flex">
            <div class="d-flex w-50">
                <p class="w-30">NO. ORDER</p>
                <p class="w-70">: {{ $data->transaksi->kode }} / {{ strtoupper($data->transaksi->tipe_transaksi) }}</p>
            </div>
            <div class="d-flex w-50">
                <p class="w-30">PENCETAKAN</p>
                <p class="w-70">: {{ date('d-M-Y h:i:s') }}</p>
            </div>
        </div>

        <div class="d-flex">
            <div class="d-flex w-50">
                <p class="w-30">PELANGGAN</p>
                <p class="w-70">: {{ $data->transaksi->pelanggan->no_id }} / {{ $data->transaksi->pelanggan->nama }}</p>
            </div>
            <div class="d-flex w-50">
                <p class="w-30">TGL CUCI</p>
                <p class="w-70">: {{ date('d-M-Y', strtotime($data->transaksi->created_at)) }} / {{ date('d-M-Y', strtotime($data->transaksi->done_date)) }}</p>
            </div>
        </div>

        <div class="d-flex w-50">
            <p class="w-30">ALAMAT/TELP</p>
            <p class="w-70">: {{ $data->transaksi->pelanggan->alamat }} / {{ $data->transaksi->pelanggan->telephone }}</p>
        </div>

        <div class="d-flex justify-content-around">
            <div class="d-flex">
                <p>EXPRESS</p>
                <p>: {{ $data->transaksi->express ? 'YA' : 'TIDAK' }}</p>
            </div>

            <div class="d-flex">
                <p>SETRIKA SAJA</p>
                <p>: {{ $data->transaksi->setrika_only ? 'YA' : 'TIDAK' }}</p>
            </div>

            <div class="d-flex">
                <p>DELIVERY</p>
                <p>: {{ $data->transaksi->need_delivery ? 'YA' : 'TIDAK' }}</p>
            </div>

        </div>
    <hr>
    <div id="detail-transaksi">
        @if ($data->transaksi->tipe_transaksi == 'bucket')
        <table>
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
        @elseif ($data->transaksi->tipe_transaksi == 'premium')
        <table>
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
        <hr>
        <div class="w-75 d-flex justify-content-between alingn-items-center">
            <p>Jml Pcs: {{ $data->total_qty }}</p>
            <p>Jml Bobot: {{ $data->total_bobot }}</p>
            <p>Jml M<sup>2</sup>: 0</p>
        </div>
        <div>
            <p>CATATAN:</p>
            <p>@isset($data->catatan) {{ $data->catatan }} || @endisset {{ $data->transaksi->catatan }}</p>
        </div>
    </div>
    <hr>
    <div id="data-tim-produksi">
        <div class="d-flex align-items-center">
            <p class="w-15">Tim Produksi</p>
            <div class="d-flex" style="width: 85%;">
                <div class="w-25 text-center px-5">
                    @isset($data->transaksi->tukang_cuci) <p class="lh-lg">{{ $data->transaksi->tukang_cuci->name }}</p> @else <p class="invisible lh-lg">cuci</p> @endisset
                    <p class="border-1 border-top">cuci</p>
                </div>
                <div class="w-25 text-center px-5">
                    @isset($data->transaksi->tukang_setrika) <p class="lh-lg">{{ $data->transaksi->tukang_setrika->name }}</p> @else <p class="invisible lh-lg">setrika</p> @endisset
                    <p class="border-1 border-top">setrika</p>
                </div>
                <div class="w-25 text-center px-5">
                    @isset($data->packing) <p class="lh-lg">{{ $data->packing->name }}</p> @else <p class="invisible lh-lg">packing</p> @endisset
                    <p class="border-1 border-top">packing</p>
                </div>
                <div class="w-25 text-center px-5">
                    @isset($data->transaksi->pickup_delivery[count($data->transaksi->pickup_delivery) - 1]) <p class="lh-lg">{{ $data->transaksi->pickup_delivery[count($data->transaksi->pickup_delivery) - 1]->nama_driver }}</p> @else <p class="invisible lh-lg">delivery</p> @endisset
                    <p class="border-1 border-top">delivery</p>
                </div>
            </div>
        </div>
    </div>
    <hr>
</body>

</html>
