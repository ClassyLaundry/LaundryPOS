<?php

namespace App\Models;

use App\Models\Data\Pelanggan;
use App\Models\Transaksi\Transaksi;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DiskonHistory extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function transaksi()
    {
        return $this->belongsTo(Transaksi::class, 'id_transaksi', 'id');
    }

    public function pelanggan()
    {
        return $this->belongsTo(Pelanggan::class, 'id_pelanggan', 'id');
    }

    public function diskon()
    {
        return $this->belongsTo(Diskon::class, 'id_diskon', 'id');
    }

    public static function canApplyDiscount($id_transaksi, $id_diskon, $id_pelanggan)
    {
        $diskon = Diskon::find($id_diskon);

        if (!$diskon) {
            return false; // Diskon tidak ditemukan
        }

        // Check kalo diskon bisa bertumpuk dengan diskon apapun
        if (!$diskon->is_stackable) {
            $penggunaanDiskon = DiskonHistory::where('id_transaksi', $id_transaksi)->exists();
            if ($penggunaanDiskon) {
                return false; // Cannot add non-stackable discount if there are existing discounts
            }
        }

        // Check berapa kali penggunaan diskon
        $countPenggunaan = DiskonHistory::where('id_pelanggan', $id_pelanggan)
            ->where('id_diskon', $id_diskon)
            ->count();

        if ($countPenggunaan >= $diskon->max_usage_per_customer) {
            return false; // Penggunaan melebihi limit
        }

        return true;
    }
}
