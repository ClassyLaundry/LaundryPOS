<?php

namespace App\Http\Controllers;

use App\Http\Requests\InsertTransaksiRequest;
use App\Http\Requests\UpdateTransaksiRequest;
use App\Http\Requests\UserLoginRequest;
use App\Models\Data\JenisItem;
use App\Models\Data\Pelanggan;
use App\Models\LogTransaksi;
use App\Models\Outlet;
use App\Models\Packing\Packing;
use App\Models\Packing\PackingInventory;
use App\Models\Paket\PaketCuci;
use App\Models\SettingUmum;
use App\Models\Transaksi\Rewash;
use App\Models\Transaksi\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class TransaksiController extends Controller
{

    public function show($id, Request $request)
    {
        $user = User::find(auth()->id());
        $permissions = $user->getPermissionsViaRoles();
        $permissionExist = collect($permissions)->first(function ($item) {
            return $item->name === 'Melihat Detail Transaksi';
        });
        if ($permissionExist) {
            if (isset($request->outlet) && $request->outlet == "0") {
                return Transaksi::detail()->find($id);
            } else {
                $outlet_id = User::getOutletId(Auth::id());
                return Transaksi::detail()->where('outlet_id', $outlet_id)->find($id);
            }
        } else {
            abort(403, 'USER DOES NOT HAVE THE RIGHT PERMISSION');
        }
    }

    public function getTransaksiByKode($kode)
    {
        $user = User::find(auth()->id());
        $permissions = $user->getPermissionsViaRoles();
        $permissionExist = collect($permissions)->first(function ($item) {
            return $item->name === 'Melihat Detail Transaksi';
        });
        if ($permissionExist) {
            return Transaksi::detail()->where('kode', $kode)->first();
        } else {
            abort(403, 'USER DOES NOT HAVE THE RIGHT PERMISSION');
        }
    }

    public function tableBucket($id)
    {
        $outlet_id = User::getOutletId(Auth::id());
        $transaksi = Transaksi::detail()->where('outlet_id', $outlet_id)->find($id);
        $total_qty = 0;
        foreach ($transaksi->item_transaksi as $item) {
            $total_qty += $item->qty;
        }
        return view('components.tableItemTransBucket', [
            'trans' => $transaksi,
            'total_qty' => $total_qty,
            'multiplier_express' => SettingUmum::where('nama', 'multiplier express')->first(),
            'multiplier_setrika' => SettingUmum::where('nama', 'multiplier setrika only')->first(),
        ]);
    }

    public function tablePremium($id)
    {
        $outlet_id = User::getOutletId(Auth::id());
        $transaksi = Transaksi::detail()->where('outlet_id', $outlet_id)->find($id);
        $total_qty = 0;
        foreach ($transaksi->item_transaksi as $item) {
            $total_qty += $item->qty;
        }
        return view('components.tableItemTransPremium', [
            'trans' => $transaksi,
            'total_qty' => $total_qty,
            'multiplier_express' => SettingUmum::where('nama', 'multiplier express')->first(),
            'multiplier_setrika' => SettingUmum::where('nama', 'multiplier setrika only')->first(),
        ]);
    }

    public function shortTable($id)
    {
        return view('components.tableItemTransShort', [
            'trans' => Transaksi::detail()->find($id),
        ]);
    }

    public function shortTableProcess($id)
    {
        $rewashes = Rewash::with('item_transaksi')->get();
        $filteredRewash = [];
        foreach ($rewashes as $rewash) {
            if ($rewash->item_transaksi->transaksi_id == $id) {
                array_push($filteredRewash, $rewash);
            }
        }
        return view('components.tableItemTransShort', [
            'trans' => Transaksi::detail()->find($id),
            'rewashes' => $filteredRewash,
        ]);
    }

    public function shortTableDelivery($id)
    {

        $packings = Packing::where('transaksi_id', $id)->get();

        $inventoryData = collect();

        foreach ($packings as $packing) {
            foreach ($packing->packing_inventories as $packingInventory) {
                $inventoryData->push([
                    'name' => $packingInventory->inventory->nama,
                    'qty' => $packingInventory->qty
                ]);
            }
        }

        return view('components.tableItemTransShort', [
            'trans' => Transaksi::detail()->find($id),
            'inventories' => $inventoryData,
        ]);
    }

    public function historyPelanggan($id_pelanggan)
    {
        $user = User::find(auth()->id());
        $permissions = $user->getPermissionsViaRoles();
        $permissionExist = collect($permissions)->first(function ($item) {
            return $item->name === 'Melihat Detail History Transaksi Pelanggan';
        });
        if ($permissionExist) {
            return view('components.tableHistoryTransaksi', [
                'status' => 200,
                'transaksis' => Transaksi::detail()->where('pelanggan_id', $id_pelanggan)->latest()->paginate(5),
            ]);
        } else {
            abort(403, 'USER DOES NOT HAVE THE RIGHT PERMISSION');
        }
    }

    //Mencari Transaksi dengan KEY id, Kode Transaksi, atau Nama Pelanggan
    public function search(Request $request)
    {
        $outlet_id = User::getOutletId(Auth::id());
        $role = User::getRole(Auth::id());
        if ($role == "delivery") {
            $transaksi = Transaksi::detail()
                ->whereHas('pickup_delivery', function ($query) {
                    $query->where('action', 'pickup')
                        ->where('driver_id', Auth::id());
                })
                ->where('outlet_id', $outlet_id)
                ->where(function ($query) use ($request) {
                    $query->where('tipe_transaksi', $request->tipe)
                        ->orWhere('tipe_transaksi', null);
                })
                ->where(function ($query) use ($request) {
                    $query->where('id', 'like', '%' . $request->key . '%')
                        ->orWhereHas('pelanggan', function ($q) use ($request) {
                            $q->where('nama', 'like', '%' . $request->key . '%');
                        });
                })
                ->latest()->paginate(10);
        } else {
            $transaksi = Transaksi::detail()
                ->where('outlet_id', $outlet_id)
                ->where(function ($query) use ($request) {
                    $query->where('tipe_transaksi', $request->tipe)
                        ->orWhere('tipe_transaksi', null);
                })
                ->where(function ($query) use ($request) {
                    $query->where('id', 'like', '%' . $request->key . '%')
                        ->orWhereHas('pelanggan', function ($q) use ($request) {
                            $q->where('nama', 'like', '%' . $request->key . '%');
                        });
                })
                ->latest()->paginate(10);
        }
        return view('components.tableListTrans', [
            'status' => 200,
            'transaksis' => $transaksi
        ]);
    }

    //Mendapatkan harga Paket Bucket
    public function bucketPrice($total_bobot)
    {
        $paket_bucket = PaketCuci::where('nama_paket', 'BUCKET')->first();
        $total_harga = $total_bobot * $paket_bucket->harga_paket;

        return round($total_harga, 2);
    }

    //Menghitung nilai Transaksi
    public function checkHarga(Request $request)
    {
        $paket_bucket = PaketCuci::where('nama_paket', 'BUCKET')->first();
        $subtotal = $request->total_bobot * $paket_bucket->harga_paket;
        $diskon = 0;
        $diskon_member = $request->member == 0 ? 0 : 10;
        $grand_total = $subtotal * ((100 - ($diskon + $diskon_member)) / 100);

        return [
            'status' => 200,
            'subtotal' => $subtotal,
            'diskon' => $diskon,
            'grand_total' => $grand_total,
        ];
    }

    public function insert(InsertTransaksiRequest $request)
    {
        $user = User::find(auth()->id());
        $permissions = $user->getPermissionsViaRoles();
        $permissionExist = collect($permissions)->first(function ($item) {
            return $item->name === 'Membuat Transaksi';
        });
        if ($permissionExist) {
            $pelanggan = Pelanggan::find($request->pelanggan_id);
            $merged = $request->merge([
                'outlet_id' => Auth::user()->outlet->id,
                'status_diskon_member' => $pelanggan->member,
                'modified_by' => Auth::id(),
                'status' => "draft"
            ])->toArray();
            $transaksi = Transaksi::create($merged);
            $transaksi = Transaksi::detail()->find($transaksi->id);
            LogTransaksi::create([
                'transaksi_id' => $transaksi->id,
                'penanggung_jawab' => Auth::id(),
                'process' => strtoupper('create transaksi'),
            ]);
            return [
                'status' => 200,
                $transaksi,
            ];
        } else {
            abort(403, 'USER DOES NOT HAVE THE RIGHT PERMISSION');
        }
    }

    public function authenticationDiskon(UserLoginRequest $request)
    {
        $user = User::where('username', $request['username'])->first();

        if ($user) {
            if (Hash::check($request['password'], $user->password)) {
                $role = $user->getRole($user->id);
                if ($role == 'supervisor' || $role == 'administrator') {
                    return [
                        'status' => 200,
                    ];
                }
            }
        }

        return [
            'password' => 'Tidak Memiliki Akses'
        ];
    }


    public function update(UpdateTransaksiRequest $request, $id)
    {
        $user = User::find(auth()->id());
        $permissions = $user->getPermissionsViaRoles();
        $permissionExist = collect($permissions)->first(function ($item) {
            return $item->name === 'Mengubah Data Transaksi';
        });
        if ($permissionExist) {
            $express = false;
            if ($request->express == "1") {
                $express = true;
            }

            $setrika_only = false;
            if ($request->setrika_only == "1") {
                $setrika_only = true;
            }

            $need_delivery = false;
            if ($request->need_delivery == "1") {
                $need_delivery = true;
            }

            $status = 'draft';
            if (
                User::getRole(Auth::id()) == "administrator"
                || User::getRole(Auth::id()) == "supervisor"
                || User::getRole(Auth::id()) == "operator"
            ) {
                $status = "confirmed";
            }

            $express = isset($request->express) ? $request->express : false;
            $done_date = $request->done_date;
            if ($done_date === null) {
                if ($express) {
                    $done_date = Carbon::now()->addDays(1);
                } else {
                    $done_date = Carbon::now()->addDays(3);
                }
            }

            $merged = $request->merge([
                'modified_by' => Auth::id(),
                'status' => $status,
                'express' => $express,
                'setrika_only' => $setrika_only,
                'need_delivery' => $need_delivery,
                'done_date' => $done_date,
            ])->toArray();
            $transaksi = Transaksi::find($id);
            $transaksi->update($merged);

            $kode = '';
            $outlet = Outlet::find($transaksi->outlet_id);
            $today = Carbon::today();
            $formattedDate = $today->format('ymd');
            $kode = $outlet->kode . $formattedDate;

            if ($transaksi->status != "draft") {
                if (empty($transaksi->kode)) {
                    $count = Transaksi::where('status', '!=', 'draft')->where('kode', 'like', $kode . '%')->count() + 1;
                    $paded = str_pad($count, 5, '0', STR_PAD_LEFT);

                    $transaksi->kode = $kode . $paded;
                    $transaksi->save();
                }

                if (empty($transaksi->memo_code)) {
                    $transaksi->memo_code = Transaksi::getMemoCode($transaksi->id);
                }

                if (empty($transaksi->kitir_code)) {
                    $transaksi->kitir_code = Transaksi::getKitirCode($transaksi->id);
                }
            }
            if (!isset($transaksi->operator)) {
                $transaksi->operator = Auth::id();
            }
            $transaksi->save();

            LogTransaksi::create([
                'transaksi_id' => $transaksi->id,
                'penanggung_jawab' => Auth::id(),
                'process' => strtoupper('update transaksi'),
            ]);

            return [
                'code' => '200',
                'message' => 'Pembaharuan data berhasil disimpan'
            ];
        } else {
            abort(403, 'USER DOES NOT HAVE THE RIGHT PERMISSION');
        }
    }

    public function setExpress(Request $request, $id)
    {
        $user = User::find(auth()->id());
        $permissions = $user->getPermissionsViaRoles();
        $permissionExist = collect($permissions)->first(function ($item) {
            return $item->name === 'Mengubah Data Transaksi';
        });
        if ($permissionExist) {
            $transaksi = Transaksi::find($id);
            $transaksi->express = $request->express;
            $transaksi->save();
            $transaksi->recalculate();
            LogTransaksi::create([
                'transaksi_id' => $id,
                'penanggung_jawab' => Auth::id(),
                'process' => strtoupper('update transaksi, tipe express'),
            ]);
        } else {
            abort(403, 'USER DOES NOT HAVE THE RIGHT PERMISSION');
        }
    }

    public function setSetrikaOnly(Request $request, $id)
    {
        $user = User::find(auth()->id());
        $permissions = $user->getPermissionsViaRoles();
        $permissionExist = collect($permissions)->first(function ($item) {
            return $item->name === 'Mengubah Data Transaksi';
        });
        if ($permissionExist) {
            $transaksi = Transaksi::find($id);
            $transaksi->setrika_only = $request->setrika_only;
            $transaksi->save();
            $transaksi->recalculate();
            LogTransaksi::create([
                'transaksi_id' => $id,
                'penanggung_jawab' => Auth::id(),
                'process' => strtoupper('update transaksi, tipe setrika only'),
            ]);
        } else {
            abort(403, 'USER DOES NOT HAVE THE RIGHT PERMISSION');
        }
    }

    //Mengubah Data Status item menjadi "Cuci"
    public function changeStatusCuci(Transaksi $transaksi)
    {
        $user = User::find(auth()->id());
        $permissions = $user->getPermissionsViaRoles();
        $permissionExist = collect($permissions)->first(function ($item) {
            return $item->name === 'Mengambil Tugas Cuci';
        });
        if ($permissionExist) {
            if (empty($transaksi->pencuci)) {
                $transaksi->pencuci = Auth::id();
                $transaksi->save();
                LogTransaksi::create([
                    'transaksi_id' => $transaksi->id,
                    'penanggung_jawab' => Auth::id(),
                    'process' => strtoupper('take job cuci')
                ]);
            }
        } else {
            abort(403, 'USER DOES NOT HAVE THE RIGHT PERMISSION');
        }
    }

    public function adminCuci(Request $request)
    {
        return view('components.tableProsesAdmin', [
            'transaksis' => Transaksi::with('pelanggan', 'tukang_cuci')
                ->when($request->filled('key'), function ($query) use ($request) {
                    $query->when($request->filled('search'), function ($query) use ($request) {
                        if ($request->search === 'kode') {
                            $query->Where('kode', 'like', '%' . $request->key . '%');
                        } elseif ($request->search === 'pelanggan') {
                            $query->WhereHas('pelanggan', function ($query) use ($request) {
                                $query->where('nama', 'like', '%' . $request->key . '%');
                            });
                        } elseif ($request->search === 'tipe') {
                            if ($request->key == 'express') {
                                $query->where('express', 1);
                            } else if ($request->key == 'on time' || $request->key == 'ontime') {
                                $query->where('on_time', 1);
                            } else if ($request->key == 'normal') {
                                $query->where('express', 0)->where('on_time', 0);
                            }
                        } elseif ($request->search === 'tanggal-buat') {
                            $query->Where('created_at', 'like', '%' . $request->key . '%');
                        } elseif ($request->search === 'tanggal-selesai') {
                            $query->where('done_date', 'like', '%' . $request->key . '%');
                        } elseif ($request->search === 'pencuci') {
                            $query->WhereHas('tukang_cuci', function ($query) use ($request) {
                                $query->where('username', 'like', '%' . $request->key . '%');
                            });
                        }
                    });
                })
                ->where('status', 'confirmed')
                ->where('outlet_id', Auth::user()->outlet_id)
                ->latest()
                ->paginate($request->paginate),
            'tipe' => 'cuci'
        ]);
    }

    public function workerCuci(Request $request)
    {
        $listTrans = [];
        if ($request->type == "0") {
            $listTrans = Transaksi::with('pelanggan')
                ->when($request->filled('key'), function ($query) use ($request) {
                    $query->where(function ($query) use ($request) {
                        $query->whereHas('pelanggan', function ($query) use ($request) {
                            $query->where('nama', 'like', '%' . $request->key . '%');
                        })
                        ->orWhere('kode', 'like', '%' . $request->key . '%');
                    });
                })
                ->whereNull('pencuci')
                ->where('status', 'confirmed')
                ->latest()
                ->get();
        } else if ($request->type == "1") {
            $listTrans = Transaksi::with('pelanggan')
                ->where('pencuci', Auth::id())
                ->where('is_done_cuci', 0)
                ->where('status', 'confirmed')
                ->latest()
                ->get();
        } else if ($request->type == "2") {
            $listTrans = Transaksi::with('pelanggan')
                ->when($request->filled('key'), function ($query) use ($request) {
                    $query->where(function ($query) use ($request) {
                        $query->whereHas('pelanggan', function ($query) use ($request) {
                            $query->where('nama', 'like', '%' . $request->key . '%');
                        })
                        ->orWhere('kode', 'like', '%' . $request->key . '%');
                    });
                })
                ->where('pencuci', Auth::id())
                ->where('is_done_cuci', 1)
                ->where('status', 'confirmed')
                ->latest()
                ->get();
        }

        return view('components.listCardTransaksi', [
            'transaksis' => $listTrans
        ]);
    }

    public function adminSetrika(Request $request)
    {
        return view('components.tableProsesAdmin', [
            'transaksis' => Transaksi::with('pelanggan', 'tukang_setrika')
                ->when($request->filled('key'), function ($query) use ($request) {
                    $query->when($request->filled('search'), function ($query) use ($request) {
                        if ($request->search === 'kode') {
                            $query->Where('kode', 'like', '%' . $request->key . '%');
                        } elseif ($request->search === 'pelanggan') {
                            $query->WhereHas('pelanggan', function ($query) use ($request) {
                                $query->where('nama', 'like', '%' . $request->key . '%');
                            });
                        } elseif ($request->search === 'tipe') {
                            if ($request->key == 'express') {
                                $query->where('express', 1);
                            } else if ($request->key == 'on time' || $request->key == 'ontime') {
                                $query->where('on_time', 1);
                            } else if ($request->key == 'normal') {
                                $query->where('express', 0)->where('on_time', 0);
                            }
                        } elseif ($request->search === 'tanggal-buat') {
                            $query->Where('created_at', 'like', '%' . $request->key . '%');
                        } elseif ($request->search === 'tanggal-selesai') {
                            $query->where('done_date', 'like', '%' . $request->key . '%');
                        } elseif ($request->search === 'penyetrika') {
                            $query->WhereHas('tukang_setrika', function ($query) use ($request) {
                                $query->where('username', 'like', '%' . $request->key . '%');
                            });
                        }
                    });
                })
                ->where(function ($query) {
                    $query->where('setrika_only', 1)
                        ->orWhere('is_done_cuci', 1);
                })
                ->where('status', 'confirmed')
                ->where('outlet_id', Auth::user()->outlet_id)
                ->latest()
                ->paginate($request->paginate),
            'tipe' => 'setrika'
        ]);
    }

    public function workerSetrika(Request $request)
    {
        $listTrans = [];
        if ($request->type == "0") {
            $listTrans = Transaksi::with('pelanggan')
                ->when($request->filled('key'), function ($query) use ($request) {
                    $query->where(function ($query) use ($request) {
                        $query->whereHas('pelanggan', function ($query) use ($request) {
                            $query->where('nama', 'like', '%' . $request->key . '%');
                        })
                        ->orWhere('kode', 'like', '%' . $request->key . '%');
                    });
                })
                ->whereNull('penyetrika');
        } else if ($request->type == "1") {
            $listTrans = Transaksi::with('pelanggan')
                ->where('penyetrika', Auth::id())
                ->where('is_done_setrika', 0);
        } else if ($request->type == "2") {
            $listTrans = Transaksi::with('pelanggan')
                ->when($request->filled('key'), function ($query) use ($request) {
                    $query->where(function ($query) use ($request) {
                        $query->whereHas('pelanggan', function ($query) use ($request) {
                            $query->where('nama', 'like', '%' . $request->key . '%');
                        })
                        ->orWhere('kode', 'like', '%' . $request->key . '%');
                    });
                })
                ->where('penyetrika', Auth::id())
                ->where('is_done_setrika', 1);
        }
        $listTrans = $listTrans->where(function ($query) {
                            $query->where('setrika_only', 1)
                                ->orWhere('is_done_cuci', 1);
                        })
                        ->where('status', 'confirmed')
                        ->latest()
                        ->get();

        return view('components.listCardTransaksi', [
            'transaksis' => $listTrans
        ]);
    }

    public function clearStatusCuci(Transaksi $transaksi)
    {
        $user = User::find(auth()->id());
        $permissions = $user->getPermissionsViaRoles();
        $permissionExist = collect($permissions)->first(function ($item) {
            return $item->name === 'Mengurangi Tugas Cuci';
        });
        if ($permissionExist) {
            if (!empty($transaksi->pencuci) && $transaksi->pencuci == Auth::id() && $transaksi->is_done_cuci != 1) {
                $transaksi->pencuci = NULL;
                $transaksi->save();
                LogTransaksi::create([
                    'transaksi_id' => $transaksi->id,
                    'penanggung_jawab' => Auth::id(),
                    'process' => strtoupper('remove job cuci')
                ]);
            } else {
                return [
                    "message" => "aksi tidak valid. proses cuci sudah selesai."
                ];
            }
        } else {
            abort(403, 'USER DOES NOT HAVE THE RIGHT PERMISSION');
        }
    }

    public function doneCuci(Transaksi $transaksi)
    {
        if (!empty($transaksi->pencuci) && $transaksi->pencuci == Auth::id()) {
            $transaksi->is_done_cuci = 1;
            $transaksi->save();
            LogTransaksi::create([
                'transaksi_id' => $transaksi->id,
                'penanggung_jawab' => Auth::id(),
                'process' => strtoupper('done job cuci')
            ]);
        }
    }

    //Mengubah Data Status itetm menjadi "Setrika"
    public function changeStatusSetrika(Transaksi $transaksi)
    {
        $user = User::find(auth()->id());
        $permissions = $user->getPermissionsViaRoles();
        $permissionExist = collect($permissions)->first(function ($item) {
            return $item->name === 'Mengambil Tugas Setrika';
        });
        if ($permissionExist) {
            if (empty($transaksi->penyetrika)) {
                $transaksi->penyetrika = Auth::id();
                $transaksi->save();
                LogTransaksi::create([
                    'transaksi_id' => $transaksi->id,
                    'penanggung_jawab' => Auth::id(),
                    'process' => strtoupper('take job setrika')
                ]);
            }
        } else {
            abort(403, 'USER DOES NOT HAVE THE RIGHT PERMISSION');
        }
    }

    public function clearStatusSetrika(Transaksi $transaksi)
    {
        $user = User::find(auth()->id());
        $permissions = $user->getPermissionsViaRoles();
        $permissionExist = collect($permissions)->first(function ($item) {
            return $item->name === 'Mengurangi Tugas Setrika';
        });
        if ($permissionExist) {
            if (!empty($transaksi->penyetrika) && $transaksi->penyetrika == Auth::id() && $transaksi->is_done_setrika != 1) {
                $transaksi->penyetrika = NULL;
                $transaksi->save();
                LogTransaksi::create([
                    'transaksi_id' => $transaksi->id,
                    'penanggung_jawab' => Auth::id(),
                    'process' => strtoupper('remove job setrika')
                ]);
            } else {
                return [
                    "message" => "aksi tidak valid. proses setrika sudah selesai."
                ];
            }
        } else {
            abort(403, 'USER DOES NOT HAVE THE RIGHT PERMISSION');
        }
    }

    public function doneSetrika(Transaksi $transaksi)
    {
        if (!empty($transaksi->penyetrika) && $transaksi->penyetrika == Auth::id()) {
            $transaksi->is_done_setrika = 1;
            $transaksi->save();
            LogTransaksi::create([
                'transaksi_id' => $transaksi->id,
                'penanggung_jawab' => Auth::id(),
                'process' => strtoupper('done job setrika')
            ]);
        }
    }

    public function cancelTransaksi(Transaksi $transaksi)
    {
        $user = User::find(auth()->id());
        $permissions = $user->getPermissionsViaRoles();
        $permissionExist = collect($permissions)->first(function ($item) {
            return $item->name === 'Membatalkan Transaksi';
        });
        if ($permissionExist) {
            $transaksi->update([
                'status' => "cancelled"
            ]);
            $transaksi->delete();
            LogTransaksi::create([
                'transaksi_id' => $transaksi->id,
                'penanggung_jawab' => Auth::id(),
                'process' => strtoupper('cancel transaksi')
            ]);
            return [];
        } else {
            abort(403, 'USER DOES NOT HAVE THE RIGHT PERMISSION');
        }
    }

    public function restoreTransaksi($id)
    {
        $user = User::find(auth()->id());
        $permissions = $user->getPermissionsViaRoles();
        $permissionExist = collect($permissions)->first(function ($item) {
            return $item->name === 'Restore Transaksi';
        });
        if ($permissionExist) {
            $transaksi = Transaksi::withTrashed()->where('id', $id)->first();
            $transaksi->status = "draft";
            $transaksi->save();
            Transaksi::withTrashed()->where('id', $id)->restore();
            LogTransaksi::create([
                'transaksi_id' => $transaksi->id,
                'penanggung_jawab' => Auth::id(),
                'process' => strtoupper('restore transaksi from cancel')
            ]);
            return [];
        } else {
            abort(403, 'USER DOES NOT HAVE THE RIGHT PERMISSION');
        }
    }

    public function logTransaksi($id)
    {
        return [
            "logs" => LogTransaksi::with('karyawan')->where('transaksi_id', $id)->get(),
        ];
    }

    public function tableCancelled(Request $request)
    {
        $transaksi = Transaksi::detail()
            ->where(function ($query) use ($request) {
                $query->where('id', 'like', '%' . $request->key . '%')
                    ->orWhereHas('pelanggan', function ($q) use ($request) {
                        $q->where('nama', 'like', '%' . $request->key . '%');
                    });
            })
            ->latest()->onlyTrashed()->paginate(15);

        return view('components.tableCancelled', [
            'transaksis' => $transaksi,
        ]);
    }

    public function searchItem(Request $request)
    {
        $tipe = 'status_' . $request->tipe;
        return view('components.tableSearchItemTransaksi', [
            'jenis_items' => JenisItem::where($tipe, 1)
                ->where(function ($query) use ($request) {
                    $query->where('nama', 'like', "%{$request->key}%")
                        ->orWhereHas('kategori', function ($q) use ($request) {
                            $q->where('nama', 'like', "%{$request->key}%");
                        });
                })
                ->take(10)->get(),
            'tipe_transaksi' => $request->tipe,
        ]);
    }
}
