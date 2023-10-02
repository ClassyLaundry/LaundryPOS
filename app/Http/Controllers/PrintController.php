<?php

namespace App\Http\Controllers;

use App\Models\SettingUmum;
use App\Models\Transaksi\PickupDelivery;
use App\Models\Transaksi\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Barryvdh\DomPDF\Facade\Pdf;

class PrintController extends Controller
{

    public function preview($transaksi_id)
    {
        $transaksi = Transaksi::detail()->find($transaksi_id);

        $paper_size = [0, 0, 75, 151];
        $pdf = Pdf::loadView('pages.print.kitir', [
            'data' => $transaksi
        ])->setPaper($paper_size, 'landscape');
        // return $pdf->stream('invoice.pdf');

        return view('pages.print.Kitir', [
            'data' => $transaksi,
            'height' => $paper_size[2],
            'width' => $paper_size[3],
        ]);
    }

    public function dotMatrix($transaksi_id)
    {
    }

    public function nota($transaksi_id)
    {
        $transaksi = Transaksi::detail()->with('item_transaksi.item_notes')->find($transaksi_id);
        $header = [
            'nama_usaha' => SettingUmum::where('nama', 'Print Header Nama Usaha')->first()->value,
            'delivery_text' => SettingUmum::where('nama', 'Print Header Delivery Text')->first()->value
        ];
        $total_qty = 0;
        $total_bobot = 0;
        foreach ($transaksi->item_transaksi as $item) {
            $total_qty += $item->qty;
            $total_bobot += $item->total_bobot;
        }
        $status_delivery = PickupDelivery::where("transaksi_id", $transaksi_id)->where('action', 'delivery')->get()->count() != 0 ? 'YA' : 'TIDAK';

        $data = collect();
        $data->header = $header;
        $data->transaksi = $transaksi;
        $data->total_qty = $total_qty;
        $data->total_bobot = $total_bobot;
        $data->status_delivery = $status_delivery;

        // return view('pages.print.Nota', ['data' => $data]);

        //8.5x 11 inch = 612x792 point
        // $paper_size = [0, 0, 792, 612];
        $pdf = Pdf::loadView('pages.print.Nota', [
            'data' => $data
        ])->setPaper('A4', 'portrait');
        return $pdf->stream('invoice.pdf');
        // //stream kalau preview, download kalau lsg download
    }

    public function memoProduksi($transaksi_id)
    {
        $transaksi = Transaksi::detail()->find($transaksi_id);
        // return $transaksi;
        $header = [
            'nama_usaha' => SettingUmum::where('nama', 'Print Header Nama Usaha')->first()->value,
            'delivery_text' => SettingUmum::where('nama', 'Print Header Delivery Text')->first()->value
        ];
        $total_qty = 0;
        $total_bobot = 0;
        foreach ($transaksi->item_transaksi as $item) {
            $total_qty += $item->qty;
            $total_bobot += $item->total_bobot;
        }
        $status_delivery = PickupDelivery::where("transaksi_id", $transaksi_id)->where('action', 'delivery')->get()->count() != 0 ? 'YA' : 'TIDAK';

        $data = collect();
        $data->header = $header;
        $data->transaksi = $transaksi;
        $data->total_qty = $total_qty;
        $data->total_bobot = $total_bobot;
        $data->status_delivery = $status_delivery;

        //8.5x 11 inch = 612x792 point
        // $paper_size = [0, 0, 792, 612];
        $pdf = Pdf::loadView('pages.print.MemoProduksi', [
            'data' => $data
        ])->setPaper('A4', 'portrait');
        return $pdf->stream('invoice.pdf');
        //stream kalau preview, download kalau lsg download
    }

    public function kitir($transaksi_id)
    {
        $transaksi = Transaksi::detail()->find($transaksi_id);

        $paper_size = [0, 0, 225, 75];
        $pdf = Pdf::loadView('pages.print.Kitir', [
            'data' => $transaksi
        ])->setPaper($paper_size, 'portrait');
        return $pdf->stream('invoice.pdf');
    }
}
