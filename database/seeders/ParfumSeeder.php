<?php

namespace Database\Seeders;

use App\Models\Data\Parfum;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ParfumSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Parfum::create([
            'nama' => 'Lily Sweet',
            'deskripsi' => 'Aroma Lily Manis',
            'jenis' => 'Medium',
            'modified_by' => 1
        ]);

        Parfum::create([
            'nama' => 'Apel Fresh',
            'deskripsi' => 'Aroma Apel Segar',
            'jenis' => 'Soft',
            'modified_by' => 1
        ]);

        Parfum::create([
            'nama' => 'Polo Sport',
            'deskripsi' => 'Aroma Segar',
            'jenis' => 'Soft',
            'modified_by' => 1
        ]);

        Parfum::create([
            'nama' => 'Apel Sweet',
            'deskripsi' => 'Aroma Apel Manis',
            'jenis' => 'Soft',
            'modified_by' => 1
        ]);

        Parfum::create([
            'nama' => 'No Parfum',
            'deskripsi' => 'Tidak Menggunakan Parfum (Netral)',
            'jenis' => 'Netral',
            'modified_by' => 1
        ]);

        Parfum::create([
            'nama' => 'Molto Pink',
            'deskripsi' => 'Aroma Molto Pink',
            'jenis' => 'Hard',
            'modified_by' => 1
        ]);
    }
}
