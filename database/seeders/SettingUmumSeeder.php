<?php

namespace Database\Seeders;

use App\Models\SettingUmum;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SettingUmumSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        SettingUmum::create([
            'nama' => 'multiplier express',
            'value' => '2.0',
        ]);

        SettingUmum::create([
            'nama' => 'multiplier setrika only',
            'value' => '0.7',
        ]);

        SettingUmum::create([
            'nama' => 'Print Header Nama Usaha',
            'value' => 'CLASSY SURABAYA'
        ]);

        SettingUmum::create([
            'nama' => 'Print Header Delivery Text',
            'value' => 'FREE DELIVERY 0822-3344-3678'
        ]);
    }
}
