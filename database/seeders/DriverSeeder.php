<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DriverSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'username' => 'joko',
            'password' => Hash::make('joko'),
            'name' => 'Joko',
            'phone' => '0888888888',
            'address' => 'surabaya',
            'email' => 'joko@admin.com',
            'outlet_id' => 1,
        ])->assignRole('delivery');

        User::create([
            'username' => 'wawan',
            'password' => Hash::make('wawan'),
            'name' => 'wawan',
            'phone' => '0888888888',
            'address' => 'surabaya',
            'email' => 'wawan@admin.com',
            'outlet_id' => 1,
        ])->assignRole('delivery');
    }
}
