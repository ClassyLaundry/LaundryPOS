<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class ProduksiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'username' => 'devan',
            'password' => Hash::make('devan'),
            'name' => 'devan',
            'phone' => '08123456789',
            'address' => 'surabaya',
            'email' => 'devan@mail.com',
            'outlet_id' => 1,
        ])->assignRole('produksi_cuci');

        User::create([
            'username' => 'leo',
            'password' => Hash::make('leo'),
            'name' => 'leo',
            'phone' => '08879564123',
            'address' => 'surabaya',
            'email' => 'leo@mail.com',
            'outlet_id' => 1,
        ])->assignRole('produksi_setrika');
    }
}
