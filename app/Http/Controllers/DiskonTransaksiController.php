<?php

namespace App\Http\Controllers;

use App\Models\Data\Pelanggan;
use App\Models\Diskon;
use App\Models\DiskonHistory;
use App\Models\DiskonTransaksi;
use App\Models\LogTransaksi;
use App\Models\Transaksi\Transaksi;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DiskonTransaksiController extends Controller
{
    public function find($id)
    {
        $pelangganId = Transaksi::find($id)->pelanggan_id;

        return [
            'dataDiskon' => DiskonTransaksi::with('diskon')->where('transaksi_id', $id)->get(),
            'statusMember' => Pelanggan::find($pelangganId)->member,
            'statusDiskonMember' => Transaksi::find($id)->status_diskon_member
        ];
    }

    public function insert(Request $request)
    {
        $diskon = Diskon::where('code', $request->code)->first();
        if ($diskon) {
            $date = Carbon::parse($diskon->expired.' 23:59:59');
            if ($date->timestamp > Carbon::now()->timestamp) {
                $dt = DiskonTransaksi::where('transaksi_id', $request->transaksi_id)
                    ->where('diskon_id', $diskon->id)->first();
                if (!$dt) {
                    $transaksi = Transaksi::find($request->transaksi_id);
                    $canApply = DiskonHistory::canApplyDiscount($transaksi->id, $diskon->id, $transaksi->pelanggan_id);
                    if ($canApply) {
                        // Insert the discount into the discount_history table
                        DiskonTransaksi::create([
                            'transaksi_id' => $request->transaksi_id,
                            'diskon_id' => $diskon->id
                        ]);
                        $transaksi->recalculate();
                        LogTransaksi::create([
                            'transaksi_id' => $request->transaksi_id,
                            'penanggung_jawab' => Auth::id(),
                            'process' => strtoupper('add promo code '.$request->code)
                        ]);
                        DiskonHistory::create([
                            'id_transaksi' => $transaksi->id,
                            'id_diskon' => $diskon->id,
                            'id_pelanggan' => $transaksi->pelanggan_id
                        ]);
                        return [
                            'status' => 200,
                            'message' => 'Success'
                        ];
                    } else {
                        // Handle the case where the discount cannot be applied
                        return [
                            'status' => 400,
                            'message' => 'Kode diskon melebihi limit atau diskon tidak boleh bertumpuk'
                        ];
                    }

                } else {
                    return [
                        'status' => 400,
                        'message' => 'Kode diskon sudah digunakan',
                    ];
                }
            }else{
                return [
                    'status' => 400,
                    'message' => 'Kode diskon sudah expired',
                ];
            }
        } else {
            return [
                'status' => 400,
                'message' => 'Kode diskon tidak ditemukan',
            ];
        }
    }

    public function delete($id)
    {
        $diskon_transaksi = DiskonTransaksi::find($id);
        $transaksi = Transaksi::find($diskon_transaksi->transaksi_id);
        $diskon_history = DiskonHistory::where('id_transaksi', $transaksi->id)->first();
        DiskonHistory::destroy($diskon_history->id);
        DiskonTransaksi::destroy($id);
        $transaksi->recalculate();
        LogTransaksi::create([
            'transaksi_id' => $transaksi->id,
            'penanggung_jawab' => Auth::id(),
            'process'=> strtoupper('remove promo code '. $diskon_transaksi->code)
        ]);
        return [
            'status' => 200,
        ];
    }

    public function toogleMembershipDiscount($transactionId)
    {
        $transaksi = Transaksi::find($transactionId);
        $transaksi->status_diskon_member = !$transaksi->status_diskon_member;
        $transaksi->save();
        $transaksi->recalculate();
        return response()->json(['message' => 'Transaction membership discount status toggled successfully']);
    }
}
