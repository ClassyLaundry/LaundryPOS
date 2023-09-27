<?php

namespace Database\Seeders;

use App\Models\Data\Pelanggan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PelangganSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Pelanggan::create([
            'nama' => 'Abdul',
            'tanggal_lahir' => '1995-5-27',
            'alamat' => 'Jl. Indah 1',
            'member' => 0,
            'no_id' => '123456789',
            'jenis_id' => 'sim',
            'telephone' => '08123456789',
            'email' => 'abdul123@mail.com',
            'gender' => 'pria',
            'diskon' => 0,
            'modified_by' => 1
        ]);

        Pelanggan::create([
            'nama' => 'Kevin',
            'tanggal_lahir' => '1981-12-3',
            'alamat' => 'Jl. Indah 2',
            'member' => 1,
            'no_id' => '123456789',
            'jenis_id' => 'ktp',
            'telephone' => '08123456789',
            'email' => 'kevin123@mail.com',
            'gender' => 'pria',
            'diskon' => 0,
            'modified_by' => 1
        ]);

        Pelanggan::create([
            'nama' => 'Javar',
            'tanggal_lahir' => '1989-6-15',
            'alamat' => 'Jl. Indah 3',
            'member' => 0,
            'no_id' => '123456789',
            'jenis_id' => 'ktp',
            'telephone' => '08123456789',
            'email' => 'javar123@mail.com',
            'gender' => 'pria',
            'diskon' => 0,
            'modified_by' => 1
        ]);

        Pelanggan::create([
            'nama' => 'Clyde',
            'tanggal_lahir' => '1993-2-20',
            'alamat' => 'Jl. Indah 4',
            'member' => 1,
            'no_id' => '123456789',
            'jenis_id' => 'sim',
            'telephone' => '08123456789',
            'email' => 'clyde123@mail.com',
            'gender' => 'pria',
            'diskon' => 0,
            'modified_by' => 1
        ]);
    }
}
