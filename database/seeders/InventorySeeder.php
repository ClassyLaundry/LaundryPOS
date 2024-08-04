<?php

namespace Database\Seeders;

use App\Models\Inventory\Inventory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class InventorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Inventory::create(
            [
                "nama" => "PLASTIK HANGER",
                "kategori" => "packing"
            ],
            [
                "nama" => "PLASTIK BEDCOVER",
                "kategori" => "packing"
            ],
            [
                "nama" => "PLASTIK SEPATU",
                "kategori" => "packing"
            ],
            [
                "nama" => "PLASTIK KARPET",
                "kategori" => "packing"
            ],
            [
                "nama" => "PLASTIK OPP(LIPAT)",
                "kategori" => "packing"
            ],
            [
                "nama" => "PLASTIK",
                "kategori" => "packing"
            ],
            [
                "nama" => "HANGER",
                "kategori" => "packing"
            ]
        );
    }
}
