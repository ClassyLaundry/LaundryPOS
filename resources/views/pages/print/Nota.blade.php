<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" href="{{asset('bootstrap/css/bootstrap.min.css')}}">
    <link href='https://fonts.googleapis.com/css?family=Roboto' rel='stylesheet'>
    <title>Transaction Receipt</title>
    <style>
        body {
            font-family: 'Roboto';
            font-size: 1rem;
            font-weight: 600;
        }

        table {
            width: 100%;
        }

        hr {
            opacity: 1;
        }

        td {
            border: none!important;
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

        p {
            margin: 0!important;
        }

        hr {
            margin: .5rem 0;
        }

        @media print {
            @page {
                size: A5;
                orientation: landscape;
            }
        }
    </style>
</head>
<body class="lh-1" style="width: 900px;">
    <div id="data-header">
        <p class="fw-bold fs-5">
            {{ Str::upper($data->transaksi->outlet->nama) }}<br>
            {{ $data->transaksi->outlet->alamat }}<br>
            {{ $data->header['delivery_text'] }}
        </p>
    </div>
    <hr>
    <div id=data-transaksi>
        <div class="row">
            <div class="col-6 d-flex">
                <p class="w-30">NO. ORDER</p>
                <p class="w-70">: {{ $data->transaksi->kode }} / {{ strtoupper($data->transaksi->tipe_transaksi) }}</p>
            </div>
            <div class="col-6 d-flex">
                <p class="w-30">PENCETAKAN</p>
                <p class="w-70">: {{ date('d-M-Y h:i:s') }}</p>
            </div>
            <div class="col-6 d-flex">
                <p class="w-30">PELANGGAN</p>
                <p class="w-70">: {{ $data->transaksi->pelanggan->no_id }} / {{ Str::upper($data->transaksi->pelanggan->nama) }}</p>
            </div>
            <div class="col-6 d-flex">
                <p class="w-30">TGL CUCI</p>
                <p class="w-70">: {{ date('d-M-Y', strtotime($data->transaksi->created_at)) }} / {{ date('d-M-Y', strtotime($data->transaksi->done_date)) }}</p>
            </div>
            <div class="col-6 d-flex">
                <p class="w-30">ALAMAT/TELP</p>
                <p class="w-70">: {{ Str::upper($data->transaksi->pelanggan->alamat) }} / {{ $data->transaksi->pelanggan->telephone }}</p>
            </div>
            <div class="col-6 d-flex">
                <p class="w-30">SISA DEPOSIT</p>
                <p class="w-70">: {{ $data->transaksi->pelanggan->saldo_akhir }}</p>
            </div>
            <div class="col-4 d-flex justify-content-center">
                <p>EXPRESS</p>
                <p>: {{ $data->transaksi->express ? 'YA' : 'TIDAK' }}</p>
            </div>
            <div class="col-4 d-flex justify-content-center">
                <p>SETRIKA SAJA</p>
                <p>: {{ $data->transaksi->setrika_only ? 'YA' : 'TIDAK' }}</p>
            </div>
            <div class="col-4 d-flex justify-content-center">
                <p>DELIVERY</p>
                <p>: {{ $data->transaksi->need_delivery ? 'YA' : 'TIDAK' }}</p>
            </div>
        </div>
    </div>
    <hr>
    <div id="detail-transaksi">
        @if ($data->transaksi->tipe_transaksi == 'bucket')
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
        @elseif ($data->transaksi->tipe_transaksi == 'premium')
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
                        <td class="text-center">{{ number_format($item->total_premium, 0, ',', '.') }}</td>
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
            <p>JML PCS: {{ $data->total_qty }}</p>
            <p>JML BOBOT: {{ $data->total_bobot }}</p>
            <p>JML M<sup>2</sup>: 0</p>
        </div>
        <div class="d-flex">
            <p>CATATAN:&nbsp;</p>
            <p>@isset($data->catatan) {{ $data->catatan }} || @endisset {{ $data->transaksi->catatan }}</p>
        </div>
        <hr>
        <div class="row">
            <div class="col-4 d-flex">
                <p class="w-30">SUBTOTAL</p>
                <p class="w-70">: {{ number_format($data->transaksi->subtotal, 0, ',', '.') }}</p>
            </div>
            <div class="col-4 d-flex">
                <p class="w-30">GRAND TOTAL</p>
                <p class="w-70">: {{ number_format($data->transaksi->grand_total, 0, ',', '.') }}</p>
            </div>
            <div class="col-4"></div>
            <div class="col-4 d-flex">
                <p class="w-30">DISKON</p>
                <p class="w-70">: {{ number_format($data->transaksi->subtotal - $data->transaksi->grand_total, 0, ',', '.') }}</p>
            </div>
            <div class="col-4 d-flex">
                <p class="w-30">TELAH BAYAR</p>
                <p class="w-70">: {{ isset($data->transaksi->total_terbayar) ? number_format($data->transaksi->total_terbayar, 0, ',', '.') : '0' }}</p>
            </div>
            <div class="col-4"></div>
            <div class="col-4 d-flex">
                <p class="w-30">DELIVERY</p>
                <p class="w-70">: 0</p>
            </div>
            <div class="col-4 d-flex">
                <p class="w-30">SISA</p>
                <p class="w-70">: {{ number_format($data->transaksi->grand_total - $data->transaksi->total_terbayar, 0, ',', '.') }}</p>
            </div>
            <div class="col-4 d-flex">
                <p>@if ($data->transaksi->lunas) LUNAS @else BELUM LUNAS @endif</p>
            </div>
        </div>
    </div>
    <hr>
    <div id="data-tambahan">
        <div class="row">
            <div class="col-6 d-flex">
                <p class="w-30">KASIR</p>
                <p class="w-70">: {{ Str::upper(Auth::user()->name) }}</p>
            </div>
            <div class="col-6 d-flex">
                <p class="w-50">TAGIHAN BELUM TERBAYAR</p>
                <p class="w-50">: {{ number_format($data->transaksi->pelanggan->tagihan, 0, ',', '.') }}</p>
            </div>
        </div>
    </div>
    <hr>
</body>

</html>
