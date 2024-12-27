<?php

namespace App\Http\Controllers;

use App\Models\Transaksi\KomplainTransaksi;
use App\Models\Transaksi\Transaksi;
use Illuminate\Http\Request;

class KomplainController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    public function get(Request $request)
    {
        $komplains = KomplainTransaksi::with('transaksi')
            ->when($request->key, function ($query) use ($request) {
                $query->whereHas('transaksi', function ($query) use ($request) {
                    $query->where('kode', 'like', "%{$request->key}%")
                        ->orWhereHas('pelanggan', function ($query) use ($request) {
                            $query->where('nama', 'like', "%{$request->key}%");
                        });
                });
            })
            ->latest()
            ->paginate(10);

        return view('components.tableKomplain', [
            'komplains' => $komplains,
        ]);
    }

    public function searchTransaksi(Request $request)
    {
        $transaksi = Transaksi::where("status", "confirmed")->latest()->paginate(10);

        return view('components.tableTransDelivery', [
            'transaksis' => $transaksi,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        KomplainTransaksi::create([
            'id_transaksi' => $request->id_transaksi,
            'komplain' => $request->komplain,
            'created_by' => auth()->id(),
            'created_at' => now(),
        ]);

        return redirect()->intended(route('komplain'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
