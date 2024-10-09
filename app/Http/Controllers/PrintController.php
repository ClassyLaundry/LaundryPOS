<?php

namespace App\Http\Controllers;

use App\Models\Data\CatatanPelanggan;
use App\Models\Data\JenisItem;
use App\Models\Data\Pelanggan;
use App\Models\Packing\Packing;
use App\Models\SettingUmum;
use App\Models\Transaksi\PickupDelivery;
use App\Models\Transaksi\Rewash;
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
        $total_length = 0;
        foreach ($transaksi->item_transaksi as $item) {
            $jenisitem = JenisItem::find($item->jenis_item_id);
            if ($jenisitem->unit == "PCS") {
                $total_qty += $item->qty;
            } else if ($jenisitem->unit == "MTR") {
                $total_length += $item->qty;
            }
            $total_bobot += $item->total_bobot;
        }
        $status_delivery = PickupDelivery::where("transaksi_id", $transaksi_id)->where('action', 'delivery')->get()->count() != 0 ? 'YA' : 'TIDAK';
        $catatan = CatatanPelanggan::where('pelanggan_id', $transaksi->pelanggan_id)->first();

        $data = collect();
        $data->header = $header;
        $data->transaksi = $transaksi;
        $data->total_qty = $total_qty;
        $data->total_bobot = $total_bobot;
        $data->total_length = $total_length;
        $data->status_delivery = $status_delivery;
        $data->pelanggan = $pelanggan;
        if ($catatan != null) {
            $data->catatan = $catatan->catatan_khusus;
        }

        return view('pages.print.Nota', [
            'data' => $data
        ]);

        //8.5x 11 inch = 612x792 point
        // $paper_size = [0, 0, 792, 612];
        // $pdf = Pdf::loadView('pages.print.Nota', [
        //     'data' => $data
        // ])->setPaper('custom_A5', 'portrait');
        // return $pdf->stream('invoice.pdf');
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

        return view('pages.print.MemoProduksi', [
            'data' => $data
        ]);

        //8.5x 11 inch = 612x792 point
        // $paper_size = [0, 0, 792, 612];
        // $pdf = Pdf::loadView('pages.print.MemoProduksi', [
        //     'data' => $data
        // ])->setPaper('A4', 'portrait');
        // return $pdf->stream('invoice.pdf');
        //stream kalau preview, download kalau lsg download
    }

    public function kitir(Request $request, $transaksi_id)
    {
        $transaksi = Transaksi::detail()->find($transaksi_id);
        $cetak = $request->cetak;

        $paper_size = [0, 0, 120, 61 * $cetak - intval(($cetak - 1))];
        $pdf = Pdf::loadView('pages.print.Kitir', [
            'data' => $transaksi,
            'cetak' => $cetak,
        ])->setPaper($paper_size, 'portrait');
        return $pdf->stream('invoice.pdf');
    }

    public function tandaTerima($transaksi_id)
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
        $pickup = PickupDelivery::with('driver')->where("transaksi_id", $transaksi_id)->where('action', 'pickup')->first();

        $data = collect();
        $data->header = $header;
        $data->transaksi = $transaksi;
        $data->total_qty = $total_qty;
        $data->total_bobot = $total_bobot;
        $data->status_delivery = $status_delivery;
        $data->pelanggan = $pelanggan;
        $data->pickup = $pickup;
        if ($catatan != null) {
            $data->catatan = $catatan->catatan_khusus;
        }

        return view('pages.print.TandaTerima', [
            'data' => $data
        ]);
    }

    public function tandaTerimaRewash($rewash_id)
    {
        $rewash = Rewash::with('jenis_rewash', 'item_transaksi.item_notes')->find($rewash_id);
        $jenis_item = JenisItem::find($rewash->item_transaksi->jenis_item_id);
        $transaksi = Transaksi::detail()->find($rewash->item_transaksi->transaksi_id);
        $pelanggan = Pelanggan::with('catatan_pelanggan')->find($transaksi->pelanggan_id);
        $header = [
            'nama_usaha' => SettingUmum::where('nama', 'Print Header Nama Usaha')->first()->value,
            'delivery_text' => SettingUmum::where('nama', 'Print Header Delivery Text')->first()->value
        ];
        $total_qty = $rewash->item_transaksi->qty;
        $total_bobot = $rewash->item_transaksi->total_bobot;
        $status_delivery = PickupDelivery::where("transaksi_id", $transaksi->id)->where('action', 'delivery')->get()->count() != 0 ? 'YA' : 'TIDAK';
        $catatan = CatatanPelanggan::where('pelanggan_id', $transaksi->pelanggan_id)->first();

        $data = collect();
        $data->header = $header;
        $data->transaksi = $transaksi;
        $data->rewash = $rewash;
        $data->item = $rewash->item_transaksi;
        $data->jenis_item = $jenis_item;
        $data->total_qty = $total_qty;
        $data->total_bobot = $total_bobot;
        $data->status_delivery = $status_delivery;
        $data->pelanggan = $pelanggan;
        if ($catatan != null) {
            $data->catatan = $catatan->catatan_khusus;
        }

        return view('pages.print.TandaTerimaRewash', [
            'data' => $data
        ]);

        // $pdf = Pdf::loadView('pages.print.TandaTerima', [
        //     'data' => $data,
        // ])->setPaper($paper_size, 'portrait');

        // return $pdf->stream('tanda_terima.pdf');
    }
}
