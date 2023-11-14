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
    </style>
</head>
<body style="width: 750px; height: 500px;">
    <div id="data-header">
        <p style="font-weight: 600;">
            {{ $data->header['nama_usaha'] }} <br>
            {{ $data->transaksi->outlet->alamat }} <br>
            {{ $data->header['delivery_text'] }}
        </p>
    </div>
    {{-- <hr> --}}
    <div id=data-transaksi>
        {{-- <div style="position: relative; height: 75px;">
            <p class="w-75 d-flex">
                <span class=""></span>
                <span></span>
            </p>
            <p style="position: absolute; left: 0px; top: -5%; font-weight: 600; font-size: 1rem;">MEMO PRODUKSI</p>
            <p style="position: absolute; left: 400px; top: -5px; font-weight: 600; font-size: 1rem;">{{ $data->transaksi->memo_code }}</p>

            <p style="position: absolute; left: 0px; top: 15px;">NO. ORDER</p>
            <p style="position: absolute; left: 100px; top: 15px;">: {{ $data->transaksi->kode }} / {{ strtoupper($data->transaksi->tipe_transaksi) }}</p>

            <p style="position: absolute; left: 400px; top: 15px;">PENCETAKAN</p>
            <p style="position: absolute; left: 500px; top: 15px;">: {{ date('d-M-Y h:i:s') }}</p>

            <p style="position: absolute; left: 0px; top: 30px;">PELANGGAN</p>
            <p style="position: absolute; left: 100px; top: 30px;">: {{ $data->transaksi->pelanggan->no_id }} / {{ $data->transaksi->pelanggan->nama }}</p>

            <p style="position: absolute; left: 400px; top: 30px;">TGL CUCI</p>
            <p style="position: absolute; left: 500px; top: 30px;">: {{ date('d-M-Y', strtotime($data->transaksi->created_at)) }} s.d {{ date('d-M-Y', strtotime($data->transaksi->done_date)) }}</p>

            <p style="position: absolute; left: 0px; top: 45px;">ALAMAT/TELP</p>
            <p style="position: absolute; left: 100px; top: 45px;">: {{ $data->transaksi->pelanggan->alamat }} / {{ $data->transaksi->pelanggan->telephone }}</p>

            <p style="position: absolute; left: 0px; top: 60px;">EXPRESS</p>
            <p style="position: absolute; left: 100px; top: 60px;">: {{ $data->transaksi->express ? 'YA' : 'TIDAK' }}</p>

            <p style="position: absolute; left: 275px; top: 60px;">SETRIKA SAJA</p>
            <p style="position: absolute; left: 375px; top: 60px;">: {{ $data->transaksi->setrika_only ? 'YA' : 'TIDAK' }}</p>

            <p style="position: absolute; left: 550px; top: 60px;">DELIVERY</p>
            <p style="position: absolute; left: 650px; top: 60px;">: {{ $data->transaksi->need_delivery ? 'YA' : 'TIDAK' }}</p>
        </div> --}}
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
        <hr>
        <div style="position: relative; height: 90px;">
            <p style="position: absolute; left: 0px; top: 25px;">Tim Produksi</p>

            <p class="text-center" style="position: absolute; left: 75px; top: 25px; width: 200px;">@isset($data->transaksi->tukang_cuci) {{ $data->transaksi->tukang_cuci->name }} @endisset</p>
            <p class="text-center" style="position: absolute; left: 75px; top: 45px; width: 200px;">_______________</p>
            <p class="text-center" style="position: absolute; left: 75px; top: 60px; width: 200px;">cuci</p>


            <p class="text-center" style="position: absolute; left: 225px; top: 25px; width: 200px;">@isset($data->transaksi->tukang_setrika) {{ $data->transaksi->tukang_setrika->name }} @endisset</p>
            <p class="text-center" style="position: absolute; left: 225px; top: 45px; width: 200px;">_______________</p>
            <p class="text-center" style="position: absolute; left: 225px; top: 60px; width: 200px;">setrika</p>

            <p class="text-center" style="position: absolute; left: 375px; top: 25px; width: 200px;">@isset($data->packing) {{ $data->packing->name }} @endisset</p>
            <p class="text-center" style="position: absolute; left: 375px; top: 45px; width: 200px;">_______________</p>
            <p class="text-center" style="position: absolute; left: 375px; top: 60px; width: 200px;">packing</p>

            <p class="text-center" style="position: absolute; left: 525px; top: 25px; width: 200px;">@isset($data->transaksi->pickup_delivery[count($data->transaksi->pickup_delivery) - 1]) {{ $data->transaksi->pickup_delivery[count($data->transaksi->pickup_delivery) - 1]->nama_driver }} @endisset</p>
            <p class="text-center" style="position: absolute; left: 525px; top: 45px; width: 200px;">_______________</p>
            <p class="text-center" style="position: absolute; left: 525px; top: 60px; width: 200px;">delivery</p>
        </div>
    </div>
    <hr>
</body>

</html>
