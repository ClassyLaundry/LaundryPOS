<?php

namespace Database\Seeders;

use App\Models\Data\Pelanggan;
use App\Models\Transaksi\PickupDelivery;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PickupDeliverySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $pelanggan = Pelanggan::find(2);
        PickupDelivery::create([
            'transaksi_id' => 1,
            'kode' => 'PU-000001',
            'pelanggan_id' => 2,
            'driver_id' => 6,
            'action' => 'pickup',
            'alamat' => $pelanggan->alamat,
            'request' => '',
            'modified_by' => 4,
        ]);
    }
}
