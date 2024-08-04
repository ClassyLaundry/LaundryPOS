<?php

namespace App\Http\Controllers;

use App\Models\LogTransaksi;
use Illuminate\Http\Request;

class LogTransaksiController extends Controller
{
    public function index()
    {
        $logs = LogTransaksi::latest()->get();
        return [
            'status' => 200,
            'logs' => $logs
        ];
    }

    public function getByTransaksiId($transaksi_id)
    {
        $logs = LogTransaksi::where('transaksi_id', $transaksi_id)->latest()->get();
        return [
            'status' => 200,
            'logs' => $logs,
        ];
    }
}
