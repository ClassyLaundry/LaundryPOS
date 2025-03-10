<?php

namespace App\Http\Controllers;

use App\Models\Data\JenisItem;
use App\Models\Data\JenisRewash;
use App\Models\Data\Kategori;
use App\Models\Data\Parfum;
use App\Models\Data\Pelanggan;
use App\Models\Data\Pengeluaran;
use App\Models\Diskon;
use App\Models\Inventory\Inventory;
use App\Models\LogTransaksi;
use App\Models\Outlet;

use App\Models\Paket\PaketCuci;
use App\Models\Paket\PaketDeposit;
use App\Models\Permission\Role;
use App\Models\Transaksi\Penerima;
use App\Models\Transaksi\PickupDelivery;
use App\Models\Transaksi\Rewash;
use App\Models\Transaksi\Transaksi;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Intervention\Image\Gd\Driver;

class PageController extends Controller
{
    /**
     * Route To login page
     *
     * @return View login
     */
    public function login()
    {
        return view(
            'pages.session.login',
            [
                'outlets' => Outlet::where("status", 1)->orderBy("nama", "asc")->get(),
            ]
        );
    }

    /**
     * Reset Password Page
     *
     * @return View reset password
     */
    public function resetPassword()
    {
        return view('pages.session.ubahPassword');
    }

    public function dashboard()
    {
        return view('pages.session.home');
    }

    public function jenisItem(Request $request)
    {
        $user = User::find(auth()->id());
        $permissions = $user->getPermissionsViaRoles();
        $permissionExist = collect($permissions)->first(function ($item) {
            return $item->name === 'Membuka Menu Jenis Item';
        });
        if ($permissionExist) {
            return view(
                'pages.data.Item',
                [
                    'kategoris' => Kategori::all()
                ]
            );
        } else {
            abort(403, 'USER DOES NOT HAVE THE RIGHT PERMISSION');
        }
    }

    public function kategori(Request $request)
    {
        $user = User::find(auth()->id());
        $permissions = $user->getPermissionsViaRoles();
        $permissionExist = collect($permissions)->first(function ($item) {
            return $item->name === 'Membuka Menu Kategori';
        });
        if ($permissionExist) {
            return view(
                'pages.data.Kategori',
                [
                    'data' => Kategori::when($request->has("search"), function ($q) use ($request) {
                        return $q->where("nama", "like", "%" . $request->get("search") . "%")
                            ->orWhere("deskripsi", "like", "%" . $request->get("search") . "%");
                    })->orderBy("nama", "asc")->paginate(5)
                ]
            );
        } else {
            abort(403, 'USER DOES NOT HAVE THE RIGHT PERMISSION');
        }
    }

    public function parfum(Request $request)
    {
        $user = User::find(auth()->id());
        $permissions = $user->getPermissionsViaRoles();
        $permissionExist = collect($permissions)->first(function ($item) {
            return $item->name === 'Membuka Menu Parfum';
        });
        if ($permissionExist) {
            return view(
                'pages.data.Parfum',
                [
                    'data1' => Parfum::when($request->has("search"), function ($q) use ($request) {
                        return $q->where("nama", "like", "%" . $request->get("search") . "%")
                            ->orWhere("deskripsi", "like", "%" . $request->get("search") . "%");
                    })->orderBy("nama", "asc")->paginate(5),
                    'data2' => Parfum::select('jenis')->orderBy("jenis", "asc")->distinct()->get()
                ]
            );
        } else {
            abort(403, 'USER DOES NOT HAVE THE RIGHT PERMISSION');
        }
    }

    public function pelanggan()
    {
        $user = User::find(auth()->id());
        $permissions = $user->getPermissionsViaRoles();
        $permissionExist = collect($permissions)->first(function ($item) {
            return $item->name === 'Membuka Menu Pelanggan';
        });
        if ($permissionExist) {
            return view('pages.data.Pelanggan');
        } else {
            abort(403, 'USER DOES NOT HAVE THE RIGHT PERMISSION');
        }
    }

    public function pengeluaran(Request $request)
    {
        $user = User::find(auth()->id());
        $permissions = $user->getPermissionsViaRoles();
        $permissionExist = collect($permissions)->first(function ($item) {
            return $item->name === 'Membuka Menu Pengeluaran';
        });
        if ($permissionExist) {
            return view(
                'pages.data.Pengeluaran',
                [
                    'data' => Pengeluaran::when($request->has("search"), function ($q) use ($request) {
                        return $q->where("nama", "like", "%" . $request->get("search") . "%")
                            ->orWhere("deskripsi", "like", "%" . $request->get("search") . "%");
                    })->where('outlet_id', Auth::user()->outlet_id)->paginate(10),
                    'saldo' => Outlet::where('id', Auth::user()->outlet_id)->first(),
                ]
            );
        } else {
            abort(403, 'USER DOES NOT HAVE THE RIGHT PERMISSION');
        }
    }

    public function dataRewash()
    {
        $user = User::find(auth()->id());
        $permissions = $user->getPermissionsViaRoles();
        $permissionExist = collect($permissions)->first(function ($item) {
            return $item->name === 'Membuka Menu Rewash';
        });
        if ($permissionExist) {
            return view(
                'pages.data.Rewash',
                [
                    'jenisRewashes' => JenisRewash::with('user')->paginate(5),
                ]
            );
        } else {
            abort(403, 'USER DOES NOT HAVE THE RIGHT PERMISSION');
        }
    }

    public function prosesRewash()
    {
        $user = User::find(auth()->id());
        $permissions = $user->getPermissionsViaRoles();
        $permissionExist = collect($permissions)->first(function ($item) {
            return $item->name === 'Membuka Menu Proses Rewash';
        });
        if ($permissionExist) {
            $outlet_id = User::getOutletId(Auth::id());
            return view(
                'pages.proses.Rewash',
                [
                    'rewashes' => Rewash::whereHas('item_transaksi.transaksi', function ($query) use ($outlet_id) {
                        $query->where('outlet_id', $outlet_id);
                    })->with('item_transaksi')->get(),
                    'jenisRewashes' => JenisRewash::get(),
                    'transaksis' => Transaksi::where('outlet_id', $outlet_id)->latest()->get(),
                    'pencucis' => User::role('produksi_cuci')->get(),
                ]
            );
        } else {
            abort(403, 'USER DOES NOT HAVE THE RIGHT PERMISSION');
        }
    }

    public function karyawan()
    {
        $user = User::find(auth()->id());
        $permissions = $user->getPermissionsViaRoles();
        $permissionExist = collect($permissions)->first(function ($item) {
            return $item->name === 'Membuka Menu Karyawan';
        });
        if ($permissionExist) {
            return view(
                'pages.pengaturan.Karyawan',
                [
                    'data' => User::paginate(5),
                    'outlets' => Outlet::where('status', 1)->get(),
                    'roles' => Role::get(),
                ]
            );
        } else {
            abort(403, 'USER DOES NOT HAVE THE RIGHT PERMISSION');
        }
    }

    public function listKaryawan(Request $request)
    {
        $query = User::query();

        if ($request->has('key')) {
            $query->where('name', 'like', '%' . $request->get('key') . '%');
        }

        if ($request->has('role')) {
            $roleId = $request->get('role');
            $role = Role::find($roleId);
            $query->whereHas('roles', function ($q) use ($role) {
                $q->where('id', $role->id);
            });
        }

        $karyawans = $query->whereNot('id', 1)->whereNot('id', 2)->orderBy('id', 'asc')->paginate(5);
        return view(
            'components.tableKaryawan',
            [
                'karyawans' => $karyawans,
            ]
        );
    }

    public function outlet(Request $request)
    {
        $user = User::find(auth()->id());
        $permissions = $user->getPermissionsViaRoles();
        $permissionExist = collect($permissions)->first(function ($item) {
            return $item->name === 'Membuka Menu Outlet';
        });
        if ($permissionExist) {
            return view(
                'pages.pengaturan.Outlet',
                [
                    'data' => Outlet::when($request->has("search"), function ($q) use ($request) {
                        return $q->where("kode", "like", "%" . $request->get("search") . "%")
                            ->orWhere("nama", "like", "%" . $request->get("search") . "%")
                            ->orWhere("alamat", "like", "%" . $request->get("search") . "%");
                    })->orderBy("nama", "asc")->paginate(5)
                ]
            );
        } else {
            abort(403, 'USER DOES NOT HAVE THE RIGHT PERMISSION');
        }
    }

    public function paketCuci()
    {
        $user = User::find(auth()->id());
        $permissions = $user->getPermissionsViaRoles();
        $permissionExist = collect($permissions)->first(function ($item) {
            return $item->name === 'Membuka Menu Paket Cuci';
        });
        if ($permissionExist) {
            return view(
                'pages.pengaturan.PaketCuci',
                [
                    'data' => PaketCuci::paginate(5)
                ]
            );
        } else {
            abort(403, 'USER DOES NOT HAVE THE RIGHT PERMISSION');
        }
    }

    public function paketDeposit()
    {
        $user = User::find(auth()->id());
        $permissions = $user->getPermissionsViaRoles();
        $permissionExist = collect($permissions)->first(function ($item) {
            return $item->name === 'Membuka Menu Paket Deposit';
        });
        if ($permissionExist) {
            return view(
                'pages.pengaturan.PaketDeposit',
                [
                    'data' => PaketDeposit::where('id', '!=', 1)->paginate(5)
                ]
            );
        } else {
            abort(403, 'USER DOES NOT HAVE THE RIGHT PERMISSION');
        }
    }

    public function pickupDelivery()
    {
        $user = User::find(auth()->id());
        $permissions = $user->getPermissionsViaRoles();
        $permissionExist = collect($permissions)->first(function ($item) {
            return $item->name === 'Membuka Menu Pickup Delivery';
        });
        if ($permissionExist) {
            if (Auth::user()->role == 'delivery') {
                $onGoingDeliveries = PickupDelivery::with('transaksi')->where('action', 'delivery')->where('driver_id', $user->id)->where('is_done', 0)->get();
                $onGoingPackType = [];
                foreach($onGoingDeliveries as $delivery) {
                    $deliveryId = $delivery->id;

                    if (!isset($onGoingPackType[$deliveryId])) {
                        $onGoingPackType[$deliveryId] = [
                            'deliveryId' => $deliveryId,
                            'inventories' => ''
                        ];
                    }

                    $inventoryStrings = [];

                    foreach ($delivery->transaksi->packing->packing_inventories as $packing) {
                        $inventoryName = $packing->inventory->nama;
                        $quantity = $packing->qty;

                        if (isset($inventoryStrings[$inventoryName])) {
                            $inventoryStrings[$inventoryName] += $quantity;
                        } else {
                            $inventoryStrings[$inventoryName] = $quantity;
                        }
                    }

                    $formattedInventories = [];
                    foreach ($inventoryStrings as $inventoryName => $quantity) {
                        $formattedInventories[] = $inventoryName . ' : ' . $quantity;
                    }

                    $onGoingPackType[$deliveryId]['inventories'] = implode(', ', $formattedInventories);
                }

                return view(
                    'pages.transaksi.PickupDeliveryDriver',
                    [
                        'on_going_pickups' => PickupDelivery::with('transaksi')->where('action', 'pickup')->where('driver_id', $user->id)->where('is_done', 0)->get(),
                        'is_done_pickups' => PickupDelivery::with('transaksi')->where('action', 'pickup')->where('driver_id', $user->id)->where('is_done', 1)->whereDate('created_at', now()->toDateString())->get(),
                        'on_going_deliveries' => $onGoingDeliveries,
                        'on_going_packing' => $onGoingPackType,
                        'is_done_deliveries' => PickupDelivery::with('transaksi')->where('action', 'delivery')->where('driver_id', $user->id)->where('is_done', 1)->whereDate('created_at', now()->toDateString())->get(),
                        'driver' => $user,
                        // 'transaksis' => Transaksi::join('pickup_deliveries', 'transaksis.id', '=', 'pickup_deliveries.transaksi_id')->where('pickup_deliveries.driver_id', $user->id)->select('transaksis.*')->get(),
                    ]
                );
            } else {
                $outlet_id = User::getOutletId(Auth::id());
                if (!session()->has('last_tab') || session()->get('last_tab') === null) {
                    session()->put('last_tab', 'Pickup');
                }
                return view(
                    'pages.transaksi.PickupDeliveryAdmin',
                    [
                        'pickups' => PickupDelivery::where('action', 'pickup')->get(),
                        'deliveries' => PickupDelivery::whereHas('transaksi', function ($query) use ($outlet_id) {
                            $query->where('outlet_id', $outlet_id);
                        })->where('action', 'delivery')->get(),
                        'drivers' => User::role('delivery')->where('outlet_id', $outlet_id)->get(),
                    ]
                );
            }
        } else {
            abort(403, 'USER DOES NOT HAVE THE RIGHT PERMISSION');
        }
    }

    /*
    public function transaksi()
    {
        $data['transaksi_id'] = Transaksi::count() == 0 ? 1 : Transaksi::latest()->first()->id + 1;
        $data['last_transaksi'] = Transaksi::latest()->take(5)->get();
        $data['pelanggan'] = Pelanggan::latest()->take(5)->get();
        $data['pickup'] = PickupDelivery::where('action', 'pickup')->get();
        $data['delivery'] = PickupDelivery::where('action', 'delivery')->get();
        $data['parfum'] = Parfum::get();
        $data['outlet'] = Outlet::get();

        return view(
            'pages.transaksi.Transaksi',
            [
                'data' => $data
            ]
        );
    }
    */

    public function bucket()
    {
        $user = User::find(auth()->id());
        $permissions = $user->getPermissionsViaRoles();
        $permissionExist = collect($permissions)->first(function ($item) {
            return $item->name === 'Membuka Menu Transaksi';
        });
        if ($permissionExist) {
            $data['transaksi_id'] = Transaksi::count() == 0 ? 1 : Transaksi::latest()->first()->id + 1;
            // $data['last_transaksi'] = Transaksi::where('tipe_transaksi', 'not like', 'premium')->orwhere('kode', null)->latest()->paginate(15);
            $data['pelanggan'] = Pelanggan::latest()->take(5)->get();
            $data['pickup'] = PickupDelivery::where('action', 'pickup')->get();
            $data['delivery'] = PickupDelivery::where('action', 'delivery')->get();
            $data['parfum'] = Parfum::get();
            $data['outlet'] = Outlet::get();

            return view(
                'pages.transaksi.Bucket',
                [
                    'data' => $data
                ]
            );
        } else {
            abort(403, 'USER DOES NOT HAVE THE RIGHT PERMISSION');
        }
    }

    public function premium()
    {
        $user = User::find(auth()->id());
        $permissions = $user->getPermissionsViaRoles();
        $permissionExist = collect($permissions)->first(function ($item) {
            return $item->name === 'Membuka Menu Transaksi';
        });
        if ($permissionExist) {
            $data['transaksi_id'] = Transaksi::count() == 0 ? 1 : Transaksi::latest()->first()->id + 1;
            // $data['last_transaksi'] = Transaksi::where('tipe_transaksi', 'not like', 'bucket')->orwhere('kode', null)->latest()->take(5)->get();
            $data['pelanggan'] = Pelanggan::latest()->take(5)->get();
            $data['pickup'] = PickupDelivery::where('action', 'pickup')->get();
            $data['delivery'] = PickupDelivery::where('action', 'delivery')->get();
            $data['parfum'] = Parfum::get();
            $data['outlet'] = Outlet::get();

            return view(
                'pages.transaksi.Premium',
                [
                    'data' => $data
                ]
            );
        } else {
            abort(403, 'USER DOES NOT HAVE THE RIGHT PERMISSION');
        }
    }

    public function hubCuci(Request $request)
    {
        $user = User::find(auth()->id());
        $permissions = $user->getPermissionsViaRoles();
        $permissionExist = collect($permissions)->first(function ($item) {
            return $item->name === 'Membuka Menu Hub Cuci';
        });
        if ($permissionExist) {
            if (Auth::user()->role == 'produksi_cuci') {
                return view('pages.proses.CuciProses');
            } else {
                return view('pages.proses.CuciAdmin');
            }
        } else {
            abort(403, 'USER DOES NOT HAVE THE RIGHT PERMISSION');
        }
    }

    public function hubSetrika(Request $request)
    {
        $user = User::find(auth()->id());
        $permissions = $user->getPermissionsViaRoles();
        $permissionExist = collect($permissions)->first(function ($item) {
            return $item->name === 'Membuka Menu Hub Setrika';
        });
        if ($permissionExist) {
            if (Auth::user()->role == 'produksi_setrika') {
                return view('pages.proses.SetrikaProses');
            } else {
                return view('pages.proses.SetrikaAdmin');
            }
        } else {
            abort(403, 'USER DOES NOT HAVE THE RIGHT PERMISSION');
        }
    }

    public function packing()
    {
        $user = User::find(auth()->id());
        $permissions = $user->getPermissionsViaRoles();
        $permissionExist = collect($permissions)->first(function ($item) {
            return $item->name === 'Membuka Menu Packing';
        });
        if ($permissionExist) {
            return view(
                'pages.proses.Packing',
                [
                    'inventories' => Inventory::where('kategori', 'packing')->get(),
                ]
            );
        } else {
            abort(403, 'USER DOES NOT HAVE THE RIGHT PERMISSION');
        }
    }

    public function saldo()
    {
        $user = User::find(auth()->id());
        $permissions = $user->getPermissionsViaRoles();
        $permissionExist = collect($permissions)->first(function ($item) {
            return $item->name === 'Membuka Menu Saldo';
        });
        if ($permissionExist) {
            return view(
                'pages.transaksi.Saldo',
                [
                    'paket_deposits' => PaketDeposit::where('status', 1)->where('id', '!=', 1)->orderBy('nominal', 'desc')->get(),
                    'pelanggans' => Pelanggan::where('status', 1)->get(),
                ]
            );
        } else {
            abort(403, 'USER DOES NOT HAVE THE RIGHT PERMISSION');
        }
    }

    public function pembayaran()
    {
        $user = User::find(auth()->id());
        $permissions = $user->getPermissionsViaRoles();
        $permissionExist = collect($permissions)->first(function ($item) {
            return $item->name === 'Membuka Menu Pembayaran';
        });
        if ($permissionExist) {
            return view('pages.transaksi.Pembayaran');
        } else {
            abort(403, 'USER DOES NOT HAVE THE RIGHT PERMISSION');
        }
    }

    public function inventory(Request $request)
    {
        $user = User::find(auth()->id());
        $permissions = $user->getPermissionsViaRoles();
        $permissionExist = collect($permissions)->first(function ($item) {
            return $item->name === 'Membuka Menu Inventory';
        });
        if ($permissionExist) {
            return view(
                'pages.data.Inventory',
                [
                    'inventories' => Inventory::when($request->has("search"), function ($q) use ($request) {
                        return $q->Where("nama", "like", "%" . $request->get("search") . "%");
                    })->orderBy("nama", "asc")->paginate(5)
                ]
            );
        } else {
            abort(403, 'USER DOES NOT HAVE THE RIGHT PERMISSION');
        }
    }

    public function diskon(Request $request)
    {
        $user = User::find(auth()->id());
        $permissions = $user->getPermissionsViaRoles();
        $permissionExist = collect($permissions)->first(function ($item) {
            return $item->name === 'Membuka Menu Diskon';
        });
        if ($permissionExist) {
            return view(
                'pages.data.Diskon',
                [
                    'diskons' => Diskon::withTrashed()->orderBy("expired", "desc")->paginate(5)
                ]
            );
        } else {
            abort(403, 'USER DOES NOT HAVE THE RIGHT PERMISSION');
        }
    }

    public function cancel()
    {
        return view('pages.transaksi.Cancelled');
    }

    public function komplain()
    {
        return view('pages.transaksi.Komplain');
    }
}
