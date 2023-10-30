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
                    })->where('outlet_id', Auth::user()->outlet_id)->orderBy("nama", "asc")->paginate(5)
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
            return view(
                'pages.proses.Rewash',
                [
                    'rewashes' => Rewash::with('itemTransaksi')->get(),
                    'jenisRewashes' => JenisRewash::get(),
                    'transaksis' => Transaksi::latest()->get(),
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
                    'outlets' => Outlet::get(),
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

        if ($request->has('search')) {
            $query->where('name', 'like', '%' . $request->get('search') . '%');
        }

        if ($request->has('role')) {
            $roleId = $request->get('role');
            $role = Role::find($roleId);
            $query->whereHas('roles', function ($q) use ($role) {
                $q->where('id', $role->id);
            });
        }

        $karyawans = $query->orderBy('id', 'asc')->paginate(5);
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
                return view(
                    'pages.transaksi.PickupDeliveryDelivery',
                    [
                        'on_going_pickups' => PickupDelivery::with('transaksi')->where('action', 'pickup')->where('driver_id', $user->id)->where('is_done', 0)->get(),
                        'is_done_pickups' => PickupDelivery::with('transaksi')->where('action', 'pickup')->where('driver_id', $user->id)->where('is_done', 1)->get(),
                        'on_going_deliveries' => PickupDelivery::with('transaksi')->where('action', 'delivery')->where('driver_id', $user->id)->where('is_done', 0)->get(),
                        'is_done_deliveries' => PickupDelivery::with('transaksi')->where('action', 'delivery')->where('driver_id', $user->id)->where('is_done', 1)->get(),
                        'driver' => $user,
                        // 'transaksis' => Transaksi::join('pickup_deliveries', 'transaksis.id', '=', 'pickup_deliveries.transaksi_id')->where('pickup_deliveries.driver_id', $user->id)->select('transaksis.*')->get(),
                    ]
                );
            } else {
                return view(
                    'pages.transaksi.PickupDeliveryAdmin',
                    [
                        'pickups' => PickupDelivery::where('action', 'pickup')->get(),
                        'deliveries' => PickupDelivery::where('action', 'delivery')->get(),
                        'transaksis' => Transaksi::detail()->get(),
                        'drivers' => User::role('delivery')->get(),
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
            $data['last_transaksi'] = Transaksi::where('tipe_transaksi', 'not like', 'premium')->orwhere('kode', null)->latest()->paginate(15);
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
            $data['last_transaksi'] = Transaksi::where('tipe_transaksi', 'not like', 'bucket')->orwhere('kode', null)->latest()->take(5)->get();
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

    public function hubCuci()
    {
        $user = User::find(auth()->id());
        $permissions = $user->getPermissionsViaRoles();
        $permissionExist = collect($permissions)->first(function ($item) {
            return $item->name === 'Membuka Menu Hub Cuci';
        });
        if ($permissionExist) {
            $role = User::getRole(Auth::id());
            $data['transaksis'] = Transaksi::with('tukang_cuci')->detail()->latest()->get();
            $data['rewashes'] = Rewash::with('itemTransaksi')->where('pencuci', Auth::id())->get();
            if ($role != 'produksi_cuci') {
                $data['pencucis'] = User::role('produksi_cuci')->with('cucian')->get();
            }
            return view('pages.proses.Cuci', $data);
        } else {
            abort(403, 'USER DOES NOT HAVE THE RIGHT PERMISSION');
        }
    }

    public function hubSetrika()
    {
        $user = User::find(auth()->id());
        $permissions = $user->getPermissionsViaRoles();
        $permissionExist = collect($permissions)->first(function ($item) {
            return $item->name === 'Membuka Menu Hub Setrika';
        });
        if ($permissionExist) {
            $data['transaksis'] = Transaksi::with('tukang_setrika')->detail()->latest()->get();
            $data['jenis_rewashes'] = JenisRewash::get();
            $data['rewash'] = Rewash::get();
            $data['penyetrikas'] = User::role('produksi_setrika')->with('setrikaan')->get();
            return view('pages.proses.Setrika', $data);
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
                    'last_transaksi' => Transaksi::with('packing')->latest()->paginate(15),
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
                    'diskons' => Diskon::withTrashed()->orderBy("code", "asc")->paginate(5)
                ]
            );
        } else {
            abort(403, 'USER DOES NOT HAVE THE RIGHT PERMISSION');
        }
    }

    public function cancel(Request $request)
    {
        return view(
            'pages.transaksi.Cancelled',
            [
                'last_transaksi' => Transaksi::when($request->has("search"), function ($q) use ($request) {
                    return $q->Where("kode", "like", "%" . $request->get("search") . "%");
                })->orderBy("id", "desc")->onlyTrashed()->paginate(10),
            ]
        );
    }
}
