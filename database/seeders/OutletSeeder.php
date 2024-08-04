<?php

namespace Database\Seeders;

use App\Models\Outlet;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OutletSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Outlet::factory(5)->create();
        Outlet::create([
            "kode" => "DHU",
            "nama" => "CLASSY LAUNDRY & DRY CLEAN",
            "alamat" => "JL. RAYA DHARMAHUSADA 173",
            "telp_1" => "0822-3000-8487",
        ]);
    }
}
