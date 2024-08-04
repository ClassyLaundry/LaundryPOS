<?php

namespace Database\Seeders;

use App\Models\Paket\PaketCuci;
use App\Models\Paket\PaketDeposit;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PaketSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        PaketCuci::create([
            'nama_paket' => 'CUCI SETRIKA 5 KG',
            'deskripsi' => 'PAKET INI MELAYANI CUCI SETRIKA 5 KG',
            'harga_paket' => 30000,
            'harga_per_bobot' => 6000,
            'jumlah_bobot' => 5,
            'modified_by' => 1
        ]);

        PaketCuci::create([
            'nama_paket' => 'CUCI SETRIKA 10 KG',
            'deskripsi' => 'PAKET INI MELAYANI CUCI SETRIKA 10 KG',
            'harga_paket' => 50000,
            'harga_per_bobot' => 5000,
            'jumlah_bobot' => 10,
            'modified_by' => 1
        ]);

        PaketCuci::create([
            'nama_paket' => 'CUCI SETRIKA 15 KG',
            'deskripsi' => 'PAKET INI MELAYANI CUCI SETRIKA 15 KG',
            'harga_paket' => 90000,
            'harga_per_bobot' => 6000,
            'jumlah_bobot' => 15,
            'modified_by' => 1
        ]);

        PaketCuci::create([
            'nama_paket' => 'SETRIKA 5 KG',
            'deskripsi' => 'PAKET INI MELAYANI SETRIKA 5 KG',
            'harga_paket' => 25000,
            'harga_per_bobot' => 5000,
            'jumlah_bobot' => 5,
            'modified_by' => 1
        ]);

        PaketCuci::create([
            'nama_paket' => 'BUCKET',
            'deskripsi' => 'Paket ini adalah jenis bucket yang memuat bobot 15 satuan bucket',
            'harga_paket' => 45000,
            'harga_per_bobot' => 2500,
            'jumlah_bobot' => 15,
            'modified_by' => 1
        ]);

        PaketDeposit::create([
            'id' => 0,
            'nama' => 'Manual',
            'deskripsi' => 'Pengisian saldo secara manual',
            'nominal' => 0,
            'harga' => 0,
            'modified_by' => 2
        ]);

        PaketDeposit::create([
            'nama' => 'DEPOSIT 500K',
            'deskripsi' => 'DEPOSIT 500K FREE DEPOSIT 50K',
            'nominal' => 550000,
            'harga' => 500000,
            'modified_by' => 1
        ]);

        PaketDeposit::create([
            'nama' => 'DEPOSIT 100K',
            'deskripsi' => 'PENGISIAN DEPOSIT 100K',
            'nominal' => 100000,
            'harga' => 95000,
            'modified_by' => 1
        ]);
    }
}
