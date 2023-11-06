<?php

namespace App\Http\Controllers;

use App\Models\Data\CatatanPelanggan;
use App\Models\Data\Pelanggan;
use App\Models\Packing\Packing;
use App\Models\SettingUmum;
use App\Models\Transaksi\PickupDelivery;
use App\Models\Transaksi\Transaksi;
use App\Models\User;
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
        $pelanggan = Pelanggan::with('catatan_pelanggan')->find($transaksi->pelanggan_id);
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
        $catatan = CatatanPelanggan::where('pelanggan_id', $transaksi->pelanggan_id)->first();

        $data = collect();
        $data->header = $header;
        $data->transaksi = $transaksi;
        $data->total_qty = $total_qty;
        $data->total_bobot = $total_bobot;
        $data->status_delivery = $status_delivery;
        $data->pelanggan = $pelanggan;
        if ($catatan != null) {
            $data->catatan = $catatan->catatan_khusus;
        }

        // return view('pages.print.Nota', ['data' => $data]);

        //8.5x 11 inch = 612x792 point
        // $paper_size = [0, 0, 792, 612];
        $pdf = Pdf::loadView('pages.print.Nota', [
            'data' => $data
        ])->setPaper('A4', 'portrait');
        return $pdf->stream('invoice.pdf');
        // stream kalau preview, download kalau lsg download
    }

    public function memoProduksi($transaksi_id)
    {
        $transaksi = Transaksi::detail()->find($transaksi_id);
        $pelanggan = Pelanggan::with('catatan_pelanggan')->find($transaksi->pelanggan_id);
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
        $dataPacking = Packing::where('transaksi_id', $transaksi_id)->first();
        if ($dataPacking !== null && $dataPacking->modified_by !== null) {
            $packing = User::where('id', $dataPacking->modified_by)->first();
        } else {
            $packing = null;
        }

        $data = collect();
        $data->header = $header;
        $data->transaksi = $transaksi;
        $data->total_qty = $total_qty;
        $data->total_bobot = $total_bobot;
        $data->status_delivery = $status_delivery;
        $data->pelanggan = $pelanggan;
        $data->packing = $packing;

        //8.5x 11 inch = 612x792 point
        // $paper_size = [0, 0, 792, 612];
        $pdf = Pdf::loadView('pages.print.MemoProduksi', [
            'data' => $data
        ])->setPaper('A4', 'portrait');
        return $pdf->stream('invoice.pdf');
        //stream kalau preview, download kalau lsg download
    }

    public function kitir(Request $request, $transaksi_id)
    {
        $transaksi = Transaksi::detail()->find($transaksi_id);
        $cetak = $request->cetak;

        $paper_size = [0, 0, 120, 80 * $cetak - intval(($cetak - 1) * 27.5)];
        $pdf = Pdf::loadView('pages.print.Kitir', [
            'data' => $transaksi,
            'cetak' => $cetak,
        ])->setPaper($paper_size, 'portrait');
        return $pdf->stream('invoice.pdf');
    }

    public function tandaTerima($transaksi_id)
    {
        $transaksi = Transaksi::detail()->find($transaksi_id);

        $header = [
            'nama_usaha' => SettingUmum::where('nama', 'Print Header Nama Usaha')->first()->value,
            'delivery_text' => SettingUmum::where('nama', 'Print Header Delivery Text')->first()->value
        ];
    $total_item = 0;
        $total_jenis_item = 0;
        foreach ($transaksi->item_transaksi as $item) {
            $total_item += $item->qty;
            $total_jenis_item++;
        }
        $pelanggan = Pelanggan::find($transaksi->pelanggan_id);
        $driver = PickupDelivery::with('driver')->where('transaksi_id', $transaksi_id)->first();
        if ($driver != null) {
            $driver = $driver->driver;
        }

        $data = collect();
        $data->header = $header;
        $data->transaksi = $transaksi;
        $data->total_item = $total_item;
        $data->pelanggan = $pelanggan;
        $data->driver = $driver;

        $paper_size = [0, 0, 160, 159 + ($total_jenis_item * 22)];
        $pdf = Pdf::loadView('pages.print.TandaTerima', [
            'data' => $data,
        ])->setPaper($paper_size, 'portrait');
        return $pdf->stream('invoice.pdf');
    }
}
