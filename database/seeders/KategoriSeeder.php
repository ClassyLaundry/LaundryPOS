<?php

namespace Database\Seeders;

use App\Models\Data\Kategori;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class KategoriSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Kategori::create([
            'nama' => 'Aksesoris Kaki dan Kepala',
            'deskripsi' => 'Segala Jenis Aksesoris Kaki dan Kepala',
            'modified_by' => 1
        ]);

        Kategori::create([
            'nama' => 'Aksesoris Mobil',
            'deskripsi' => 'Segala Jenis Aksesoris Mobil',
            'modified_by' => 1
        ]);

        Kategori::create([
            'nama' => 'Aksesoris Rumah',
            'deskripsi' => 'Segala Jenis Aksesoris Rumah',
            'modified_by' => 1
        ]);

        Kategori::create([
            'nama' => 'Atasan',
            'deskripsi' => 'Segala Jenis Atasan',
            'modified_by' => 1
        ]);

        Kategori::create([
            'nama' => 'Bahan Kulit',
            'deskripsi' => 'Segala Jenis Bahan Kulit',
            'modified_by' => 1
        ]);

        Kategori::create([
            'nama' => 'Baju Rohani',
            'deskripsi' => 'Segala Jenis Baju Rohani',
            'modified_by' => 1
        ]);

        Kategori::create([
            'nama' => 'Bahan Set',
            'deskripsi' => 'Segala Jenis Baju Set',
            'modified_by' => 1
        ]);

        Kategori::create([
            'nama' => 'Bawahan',
            'deskripsi' => 'Segala Jenis Bawahan',
            'modified_by' => 1
        ]);

        Kategori::create([
            'nama' => 'Bedsheet',
            'deskripsi' => 'Segala Jenis Bedsheet',
            'modified_by' => 1
        ]);

        Kategori::create([
            'nama' => 'Bucket',
            'deskripsi' => 'Hanya untuk Paket Bucket',
            'modified_by' => 1
        ]);

        Kategori::create([
            'nama' => 'Corporate',
            'deskripsi' => 'Hanya untuk Corporate',
            'modified_by' => 1
        ]);

        Kategori::create([
            'nama' => 'Lain Lain',
            'deskripsi' => 'Segala Jenis Lainnya',
            'modified_by' => 1
        ]);

        Kategori::create([
            'nama' => 'Membership',
            'deskripsi' => 'Hanya untuk Member',
            'modified_by' => 1
        ]);

        Kategori::create([
            'nama' => 'Pakaian Pesta',
            'deskripsi' => 'Segala Jenis Pakaian Pesta',
            'modified_by' => 1
        ]);

        Kategori::create([
            'nama' => 'Perlengkapan Bayi',
            'deskripsi' => 'Segala Jenis Perlengkapan Bayi',
            'modified_by' => 1
        ]);

        Kategori::create([
            'nama' => 'Promo',
            'deskripsi' => 'Hanya untuk Promo',
            'modified_by' => 1
        ]);

        Kategori::create([
            'nama' => 'Sepatu/Sandal',
            'deskripsi' => 'Segala Jenis Sepatu / Sandal',
            'modified_by' => 1
        ]);

        Kategori::create([
            'nama' => 'Tas',
            'deskripsi' => 'Segala Jenis Tas',
            'modified_by' => 1
        ]);
    }
}
