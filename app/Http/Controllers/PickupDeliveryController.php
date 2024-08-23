<?php

namespace App\Http\Controllers;

use App\Http\Requests\InsertPickupDeliveryRequest;
use App\Models\LogTransaksi;
use App\Models\Transaksi\Penerima;
use App\Models\Transaksi\PickupDelivery;
use App\Models\Transaksi\Transaksi;
use App\Models\Transaksi\TransaksiPickupDelivery;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PickupDeliveryController extends Controller
{
    public function saveTab(Request $request)
    {
        $request->session()->put('last_tab', $request->tab);
        return response()->json(['status' => 'success', 'tab' => $request->tab]);
    }

    public function insert(InsertPickupDeliveryRequest $request)
    {
        $user = User::find(auth()->id());
        $permissions = $user->getPermissionsViaRoles();
        $permissionExist = collect($permissions)->first(function ($item) {
            return $item->name === 'Membuat Pickup Delivery';
        });
        if ($permissionExist) {
            $action = $request->action;
            $request->session()->put('last_tab', ucwords($action));
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
                if (empty($penerima)) {
                    $transaksi = Transaksi::find($request->transaksi_id);
                    $count = PickupDelivery::where('action', $action)->count() + 1;
                    $paded = str_pad($count, 6, '0', STR_PAD_LEFT);
                    $kode = 'DV-' . $paded;
                    $transaksi->need_delivery = 1;
                    $transaksi->save();

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
        } else {
            abort(403, 'USER DOES NOT HAVE THE RIGHT PERMISSION');
        }
    }

    public function show($id)
    {
        $user = User::find(auth()->id());
        $permissions = $user->getPermissionsViaRoles();
        $permissionExist = collect($permissions)->first(function ($item) {
            return $item->name === 'Melihat Detail Pickup Delivery';
        });
        if ($permissionExist) {
            $pickup_delivery = PickupDelivery::with('transaksi')->find($id);
            return [
                'status' => 200,
                $pickup_delivery,
            ];
        } else {
            abort(403, 'USER DOES NOT HAVE THE RIGHT PERMISSION');
        }
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
        $user = User::find(auth()->id());
        $permissions = $user->getPermissionsViaRoles();
        $permissionExist = collect($permissions)->first(function ($item) {
            return $item->name === 'Mengubah Data Pickup Delivery';
        });
        if ($permissionExist) {
            $merged = $request->merge(['modified_by' => Auth::id()])->toArray();
            PickupDelivery::find($id)->update($merged);

            //return redirect()->intended(route(''));
        } else {
            abort(403, 'USER DOES NOT HAVE THE RIGHT PERMISSION');
        }
    }

    public function changeDoneStatus(PickupDelivery $pickup_delivery)
    {
        $user = User::find(auth()->id());
        $permissions = $user->getPermissionsViaRoles();
        $permissionExist = collect($permissions)->first(function ($item) {
            return $item->name === 'Mengganti Status Selesai Pickup Delivery';
        });
        if ($permissionExist) {
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
        } else {
            abort(403, 'USER DOES NOT HAVE THE RIGHT PERMISSION');
        }
    }

    public function delete($id)
    {
        $user = User::find(auth()->id());
        $permissions = $user->getPermissionsViaRoles();
        $permissionExist = collect($permissions)->first(function ($item) {
            return $item->name === 'Menghapus Pickup Delivery';
        });
        if ($permissionExist) {
            PickupDelivery::destroy($id);

            //return redirect()->intended(route(''));
        } else {
            abort(403, 'USER DOES NOT HAVE THE RIGHT PERMISSION');
        }
    }

    public function hapusPickupDelivery($transaksi_id)
    {
        $user = User::find(auth()->id());
        $permissions = $user->getPermissionsViaRoles();
        $permissionExist = collect($permissions)->first(function ($item) {
            return $item->name === 'Menghapus Pickup Delivery';
        });
        if ($permissionExist) {
            $transaksi = Transaksi::find($transaksi_id);
            $transaksi->need_delivery = false;
            $transaksi->save();
            PickupDelivery::where('transaksi_id', $transaksi_id)->delete();
            return response()->json([
                "message" => "Success Delete Pickup Delivery"
            ], 200);
            //return redirect()->intended(route(''));
        } else {
            abort(403, 'USER DOES NOT HAVE THE RIGHT PERMISSION');
        }
    }

    public function pickup(Request $request)
    {
        $year = substr($request->date, 0, 4);
        $month = substr($request->date, 5, 2);

        return view('components.tablePickup', [
            'pickups' => PickupDelivery::with('pelanggan', 'driver')->where('action', 'pickup')
                ->when($request->filled('key'), function ($query) use ($request) {
                    $query->when($request->filled('search'), function ($query) use ($request) {
                        if ($request->search === 'pelanggan') {
                            $query->WhereHas('pelanggan', function ($query) use ($request) {
                                $query->where('nama', 'like', '%' . $request->key . '%');
                            });
                        } elseif ($request->search === 'alamat') {
                            $query->Where('alamat', 'like', '%' . $request->key . '%');
                        } elseif ($request->search === 'driver') {
                            $query->WhereHas('driver', function ($query) use ($request) {
                                $query->where('username', 'like', '%' . $request->key . '%');
                            });
                        } elseif ($request->search === 'status') {
                            $query->Where('is_done', ($request->key === 'done' || $request->key === 'selesai') ? 1 : 0);
                        }
                    });
                })
                ->whereYear('created_at', $year)
                ->whereMonth('created_at', $month)
                ->latest()
                ->paginate($request->paginate),
        ]);
    }

    public function delivery(Request $request)
    {
        $year = substr($request->date, 0, 4);
        $month = substr($request->date, 5, 2);

        return view('components.tableDelivery', [
            'deliveries' => PickupDelivery::with('pelanggan', 'driver')->where('action', 'delivery')
                ->when($request->filled('key'), function ($query) use ($request) {
                    $query->when($request->filled('search'), function ($query) use ($request) {
                        if ($request->search === 'pelanggan') {
                            $query->WhereHas('pelanggan', function ($query) use ($request) {
                                $query->where('nama', 'like', '%' . $request->key . '%');
                            });
                        } elseif ($request->search === 'alamat') {
                            $query->Where('alamat', 'like', '%' . $request->key . '%');
                        } elseif ($request->search === 'driver') {
                            $query->WhereHas('driver', function ($query) use ($request) {
                                $query->where('username', 'like', '%' . $request->key . '%');
                            });
                        } elseif ($request->search === 'status') {
                            $query->Where('is_done', ($request->key === 'done' || $request->key === 'selesai') ? 1 : 0);
                        }
                    });
                })
                ->whereYear('created_at', $year)
                ->whereMonth('created_at', $month)
                ->latest()
                ->paginate($request->paginate),
        ]);
    }

    public function ambil_di_outlet(Request $request)
    {
        // $diOutlet = Penerima::with('transaksi')->where('ambil_di_outlet', 1)->paginate(10);
        // return view('components.tableDiOutlet', [
        //     'diOutlets' => $diOutlet
        // ]);

        $year = substr($request->date, 0, 4);
        $month = substr($request->date, 5, 2);

        return view('components.tableDiOutlet', [
            'diOutlets' => Penerima::with('transaksi')->where('ambil_di_outlet', 1)
                ->when($request->filled('key'), function ($query) use ($request) {
                    $query->when($request->filled('search'), function ($query) use ($request) {
                        if ($request->search === 'pelanggan') {
                            $query->WhereHas('transaksi', function ($query) use ($request) {
                                $query->WhereHas('pelanggan', function ($query) use ($request) {
                                    $query->where('nama', 'like', '%' . $request->key . '%');
                                });
                            });
                        } elseif ($request->search === 'penerima') {
                            $query->Where('penerima', 'like', '%' . $request->key . '%');
                        } elseif ($request->search === 'outlet') {
                            $query->WhereHas('outlet', function ($query) use ($request) {
                                $query->where('nama', 'like', '%' . $request->key . '%');
                            });
                        }
                    });
                })
                ->whereYear('created_at', $year)
                ->whereMonth('created_at', $month)
                ->latest()
                ->paginate($request->paginate),
        ]);
    }

    public function driver_today()
    {
        $today = Carbon::today();
        $pickups = PickupDelivery::where('is_done', false)
            ->where('driver_id', auth()->id())
            ->whereDate('created_at', $today)->get();
        $done_pickups = PickupDelivery::where('is_done', true)
            ->where('driver_id', auth()->id())
            ->whereDate('created_at', $today)->get();
        return response()->json([
            'unfinished' => $pickups,
            'finished' => $done_pickups
        ], 200);
    }

    public function admin_today()
    {
        $today = Carbon::today();
        $pickups = PickupDelivery::where('is_done', false)
            ->whereDate('created_at', $today)->get();
        $done_pickups = PickupDelivery::where('is_done', true)
            ->whereDate('created_at', $today)->get();
        return response()->json([
            'unfinished' => $pickups,
            'finished' => $done_pickups
        ], 200);
    }

    public function admin_weekly()
    {
        $startOfWeek = Carbon::now()->startOfWeek();
        $endOfWeek = Carbon::now()->endOfWeek();
        $pickups = PickupDelivery::where('is_done', false)
            ->whereBetween('created_at', [$startOfWeek, $endOfWeek])->get();
        $done_pickups = PickupDelivery::where('is_done', true)
            ->whereBetween('created_at', [$startOfWeek, $endOfWeek])->get();
        return response()->json([
            'unfinished' => $pickups,
            'finished' => $done_pickups
        ], 200);
    }

    public function admin_monthly()
    {
        $startOfMonth = Carbon::now()->startOfMonth();
        $endOfMonth = Carbon::now()->endOfMonth();
        $pickups = PickupDelivery::where('is_done', false)
            ->whereBetween('created_at', [$startOfMonth, $endOfMonth])->get();
        $done_pickups = PickupDelivery::where('is_done', true)
            ->whereBetween('created_at', [$startOfMonth, $endOfMonth])->get();
        return response()->json([
            'unfinished' => $pickups,
            'finished' => $done_pickups
        ], 200);
    }

    public function transaksiDelivery(Request $request)
    {
        $transaksi = Transaksi::detail()
            ->where('status', 'confirmed')
            ->whereIn('id', function ($subquery) { // check kalau sudah di packing
                $subquery->select('transaksi_id')
                    ->from('packings');
            })
            ->whereNotIn('id', function ($subquery) { // check kalau sudah ada delivery
                $subquery->select('transaksi_id')
                    ->from('pickup_deliveries')
                    ->where('action', 'delivery')
                    ->whereNotNull('transaksi_id');
            })
            ->whereNotIn('transaksi_id', function ($subquery) { // check kalau sudah adi ambil di outlet
                $subquery->select('transaksi_id')
                    ->from('penerimas')
                    ->where('ambil_di_outlet', true);
            })
            ->where(function ($query) use ($request) { // search nama pelanggan
                $query->where('id', 'like', '%' . $request->key . '%')
                    ->orWhereHas('pelanggan', function ($q) use ($request) {
                        $q->where('nama', 'like', '%' . $request->key . '%');
                    });
            })
            ->latest()->paginate(10);

        return view('components.tableTransDelivery', [
            'status' => 200,
            'transaksis' => $transaksi
        ]);
    }
}
