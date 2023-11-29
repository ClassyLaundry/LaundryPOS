<?php

namespace App\Http\Controllers;

use App\Models\Data\Pelanggan;
use App\Models\Diskon;
use App\Models\DiskonTransaksi;
use App\Models\Pembayaran;
use App\Models\Saldo;
use App\Models\Transaksi\Transaksi;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PembayaranController extends Controller
{
    public function insert(Request $request)
    {
        $user = User::find(auth()->id());
        $permissions = $user->getPermissionsViaRoles();
        $permissionExist = collect($permissions)->first(function ($item) {
            return $item->name === 'Membuat Pembayaran';
        });

        if ($permissionExist) {
            $transaksi = Transaksi::find($request->transaksi_id);
            $total_terbayar = $transaksi->total_terbayar;
            $nominal = intval($request->nominal);
            Pembayaran::create([
                'nominal' => $nominal,
                'outlet_id' => $user->outlet_id,
                'transaksi_id' => $request->transaksi_id,
                'saldo_id' => $request->saldo_id,
                'metode_pembayaran' => $request->metode_pembayaran
            ]);

            if ($request->metode_pembayaran == 'deposit') {
                $pelanggan = Pelanggan::find($transaksi->pelanggan_id);
                $latestSaldo = Saldo::where('pelanggan_id', $transaksi->pelanggan_id)
                    ->latest('created_at')
                    ->first();
                if ($latestSaldo->saldo_akhir > 0) {
                    if ($latestSaldo->saldo_akhir < $nominal) {
                        $total_terbayar = $total_terbayar + $latestSaldo->saldo_akhir;
                        Saldo::create([
                            'pelanggan_id' => $transaksi->pelanggan_id,
                            'outlet_id' => $user->outlet_id,
                            'nominal' => $nominal,
                            'jenis_input' => 'pembayaran',
                            'saldo_akhir' => 0,
                            'modified_by' => Auth::id()
                        ]);
                    } else {
                        $total_terbayar = $total_terbayar + $nominal;
                        Saldo::create([
                            'pelanggan_id' => $transaksi->pelanggan_id,
                            'outlet_id' => $user->outlet_id,
                            'nominal' => $nominal,
                            'jenis_input' => 'pembayaran',
                            'saldo_akhir' => $latestSaldo->saldo_akhir - $nominal,
                            'modified_by' => Auth::id()
                        ]);
                    }
                } else {
                    abort(400, 'SALDO IS 0');
                }
            } else {
                $total_terbayar = $transaksi->total_terbayar + (int) $nominal;
            }

            //Mengubah Total Transaksi
            if ($total_terbayar >= $transaksi->grand_total) {
                $diskon_transaksi = DiskonTransaksi::where('transaksi_id', $transaksi->id)->get();
                foreach ($diskon_transaksi as $related) {
                    $promo = Diskon::find($related->diskon_id);
                    if ($promo->jenis_diskon == "refferal_exact" || $promo->jenis_diskon == "refferal_percentage") {
                        $saldo_akhir = Saldo::where('pelanggan_id', $request->pelanggan_id)->latest()->first();
                        if (empty($saldo_akhir)) {
                            $saldo_akhir = $promo->nominal_diskon;
                        } else {
                            $saldo_akhir = $saldo_akhir->saldo_akhir + $promo->nominal_diskon;
                        }
                        Saldo::create([
                            'pelanggan_id' => $promo->refferal_pelanggan,
                            'outlet_id' => $user->outlet_id,
                            'nominal' => $related->nominal_diskon,
                            'jenis_input' => "refferal",
                            'saldo_akhir' => $saldo_akhir,
                            'modified_by' => Auth::id()
                        ]);
                    }
                }
                $transaksi->total_terbayar = $transaksi->grand_total;
                $transaksi->lunas = true;
            } else {
                $transaksi->total_terbayar = $total_terbayar;
            }
            $transaksi->save();

            // return redirect()->intended(route('menu_pembayaran'));
            return  [
                'status' => 200,
                'message' => 'success',
            ];
        } else {
            abort(403, 'USER DOES NOT HAVE THE RIGHT PERMISSION');
        }
    }

    public function bayarTagihan(Request $request)
    {
        $user = User::find(auth()->id());
        $permissions = $user->getPermissionsViaRoles();
        $permissionExist = collect($permissions)->first(function ($item) {
            return $item->name === 'Membuat Pembayaran';
        });
        if ($permissionExist) {
            $transaksis = Transaksi::where('pelanggan_id', $request->pelanggan_id)
                ->where('lunas', false)
                ->oldest()
                ->get();
            $nominal = $request->nominal;
            foreach ($transaksis as $transaksi) {
                if ($nominal > 0) {
                    $tagihan_transaksi = $transaksi->grand_total - $transaksi->total_terbayar;

                    if ($nominal >= $tagihan_transaksi) {
                        $transaksi->total_terbayar = $transaksi->grand_total;
                        $transaksi->lunas = true;
                        $nominal -= $tagihan_transaksi;

                        Pembayaran::create([
                            'outlet_id' => $user->outlet_id,
                            'nominal' => $transaksi->total_terbayar,
                            'transaksi_id' => $transaksi->id,
                            'metode_pembayaran' => 'cash'
                        ]);
                    } else {
                        $transaksi->total_terbayar = $transaksi->total_terbayar + $nominal;
                        Pembayaran::create([
                            'nominal' => $nominal,
                            'transaksi_id' => $transaksi->id,
                            'metode_pembayaran' => 'cash'
                        ]);
                        $nominal = 0;
                    }
                    $transaksi->save();
                } else {
                    break;
                }
            }
            return [
                'status' => 200,
                'message' => 'success',
            ];
        } else {
            abort(403, 'USER DOES NOT HAVE THE RIGHT PERMISSION');
        }
    }

    public function tablePembayaran(Request $request)
    {
        $transaksis = Transaksi::join('pelanggans', 'transaksis.pelanggan_id', '=', 'pelanggans.id')
            ->select('transaksis.*')
            ->where(function ($query) use ($request) {
                $query->where('pelanggans.nama', 'like', "%{$request->name}%")
                    ->where('transaksis.created_at', 'like', "{$request->date}%");
            })
            ->get();
        return view('components.tablePembayaran', [
            'transaksis' => $transaksis,
        ]);
    }


    public function show(Pembayaran $pembayaran)
    {
        $user = User::find(auth()->id());
        $permissions = $user->getPermissionsViaRoles();
        $permissionExist = collect($permissions)->first(function ($item) {
            return $item->name === 'Melihat Detail Pembayaran';
        });
        if ($permissionExist) {
            return [
                'status' => 200,
                $pembayaran
            ];
        } else {
            abort(403, 'USER DOES NOT HAVE THE RIGHT PERMISSION');
        }
    }

    public function update(Request $request, Pembayaran $pembayaran)
    {
        $user = User::find(auth()->id());
        $permissions = $user->getPermissionsViaRoles();
        $permissionExist = collect($permissions)->first(function ($item) {
            return $item->name === 'Mengubah Data Pembayaran';
        });
        if ($permissionExist) {
            $request->validate([
                'nominal' => 'required|integer'
            ]);

            $pembayaran->update([
                'nominal' => $request->nominal,
                'outlet_id' => $user->outlet_id,
                'transaksi_id' => $request->transaksi_id,
                'saldo_id' => $request->saldo_id,
                'metode_pembayaran' => $request->metode_pembayaran
            ]);

            return redirect()->intended(route('menu_pembayaran'));
        } else {
            abort(403, 'USER DOES NOT HAVE THE RIGHT PERMISSION');
        }
    }

    public function delete(Pembayaran $pembayaran)
    {
        $user = User::find(auth()->id());
        $permissions = $user->getPermissionsViaRoles();
        $permissionExist = collect($permissions)->first(function ($item) {
            return $item->name === 'Menghapus Pembayaran';
        });
        if ($permissionExist) {
            $pembayaran->delete();

            return [
                'status' => 200,
                'message' => 'Sukses Terhapus'
            ];
        } else {
            abort(403, 'USER DOES NOT HAVE THE RIGHT PERMISSION');
        }
    }
}
