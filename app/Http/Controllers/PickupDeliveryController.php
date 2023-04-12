<?php

namespace App\Http\Controllers;

use App\Http\Requests\InsertPickupDeliveryRequest;
use App\Models\LogTransaksi;
use App\Models\Transaksi\Penerima;
use App\Models\Transaksi\PickupDelivery;
use App\Models\Transaksi\Transaksi;
use App\Models\Transaksi\TransaksiPickupDelivery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PickupDeliveryController extends Controller
{
    public function insert(InsertPickupDeliveryRequest $request)
    {
        $action = $request->action;
        if ($action == "pickup") {
            $transaksi = Transaksi::create([
                'pelanggan_id' => $request->pelanggan_id,
                'outlet_id' => Auth::user()->outlet_id,
                'request' => $request->request,
                'status' => 'draft',
            ]);
            $count = PickupDelivery::where('action', $action)->count() + 1;
            $paded = str_pad($count, 6, '0', STR_PAD_LEFT);
            $kode = 'PU-' . $paded;

            $merged = $request->merge([
                'kode' => $kode,
                'transaksi_id' => $transaksi->id,
                'modified_by' => Auth::id()
            ])->toArray();

            $pickup_delivery = PickupDelivery::create($merged);
            return redirect()->intended(route('pickup-delivery'))->with('message', 'Success Created Pickup');
        } else {
            $penerima = Penerima::where('transaksi_id', $request->transaksi_id)->first();
            //Melakukan Pengecheckan apakah sudah diterima
            if (empty($penerima)) {
                $transaksi = Transaksi::find($request->transaksi_id);
                $count = PickupDelivery::where('action', $action)->count() + 1;
                $paded = str_pad($count, 6, '0', STR_PAD_LEFT);
                $kode = 'DV-' . $paded;

                $merged = $request->merge([
                    'pelanggan_id' => $transaksi->pelanggan_id,
                    'kode' => $kode,
                    'modified_by' => Auth::id()
                ])->toArray();

                $pickup_delivery = PickupDelivery::create($merged);
                return redirect()->intended(route('pickup-delivery'))->with('message', 'Success Created Delivery');
            }
            //Sudah diterima
            return redirect()->back()->with('message', 'Sudah diterima di outlet');
        }
    }

    public function show($id)
    {
        $pickup_delivery = PickupDelivery::find($id);
        return [
            'status' => 200,
            $pickup_delivery,
        ];
    }

    public function showTaskHub()
    {
        $id = Auth::id();
        $pickup_delivery = PickupDelivery::where('driver_id', $id)->get();
        return [
            'status' => 200,
            $pickup_delivery
        ];
    }

    public function update(InsertPickupDeliveryRequest $request, $id)
    {
        $merged = $request->merge(['modified_by' => Auth::id()])->toArray();
        PickupDelivery::find($id)->update($merged);

        //return redirect()->intended(route(''));
    }

    public function changeDoneStatus(PickupDelivery $pickup_delivery)
    {
        $pickup_delivery->is_done = true;
        $pickup_delivery->modified_by = Auth::id();
        $pickup_delivery->save();
        LogTransaksi::create([
            'transaksi_id' => $pickup_delivery->transaksi_id,
            'penanggung_jawab' => Auth::id(),
            'process' => strtoupper($pickup_delivery->action) . " DONE",
        ]);
        return [
            'status' => 200
        ];
    }

    public function delete($id)
    {
        PickupDelivery::destroy($id);

        //return redirect()->intended(route(''));
    }

    public function pickup()
    {
        $pickup = PickupDelivery::where('action', 'pickup')->paginate(5);
        return view('components.tablePickup', [
            'pickups' => $pickup
        ]);
    }

    public function delivery()
    {
        $delivery = PickupDelivery::where('action', 'delivery')->paginate(5);
        return view('components.tableDelivery', [
            'deliveries' => $delivery
        ]);
    }

    public function ambil_di_outlet()
    {
        $diOutlet = Penerima::where('ambil_di_outlet', 1)->paginate(5);
        return view('components.tableDiOutlet', [
            'diOutlets' => $diOutlet
        ]);
    }
}
