<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin = Role::create(['name' => 'administrator']);
        $admin->givePermissionTo(Permission::all());

        $supervisor = Role::create(['name' => 'supervisor']);
        $supervisor->givePermissionTo(Permission::all());

        Role::create(['name' => 'operator']);

        $packing = Role::create(['name' => 'packing']);
        $packing->syncPermissions([
            'Melihat Detail Item Transaksi',
            'Melihat Detail Daftar Catatan Item',
            'Melihat Detail Catatan Item',
            'Membuat Catatan Item',

            'Membuka Menu Packing',
            'Menginputkan Data Packing',

            'Membuka Menu Proses Rewash',
            'Menambah Data Proses Rewash',

            'Membuat Pickup Delivery',
        ]);

        $produksi_cuci = Role::create(['name' => 'produksi_cuci']);
        $produksi_cuci->syncPermissions([
            'Melihat Detail Item Transaksi',
            'Melihat Detail Daftar Catatan Item',
            'Melihat Detail Catatan Item',
            'Membuat Catatan Item',

            'Membuka Menu Hub Cuci',
            'Mengambil Tugas Cuci',
            'Mengurangi Tugas Cuci',

            'Membuka Menu Proses Rewash',
            'Menyatakan Selesai Proses Rewash',
        ]);

        $produksi_setrika = Role::create(['name' => 'produksi_setrika']);
        $produksi_setrika->syncPermissions([
            'Melihat Detail Item Transaksi',
            'Melihat Detail Daftar Catatan Item',
            'Melihat Detail Catatan Item',
            'Membuat Catatan Item',

            'Membuka Menu Hub Setrika',
            'Mengambil Tugas Setrika',
            'Mengurangi Tugas Setrika',

            'Membuka Menu Proses Rewash',
            'Menambah Data Proses Rewash',
        ]);

        $delivery = Role::create(['name' => 'delivery']);
        $delivery->syncPermissions([
            'Membuka Menu Pickup Delivery',
            'Melihat Detail Pickup Delivery',
            'Membuat Pickup Delivery',
            'Mengubah Data Pickup Delivery',
            'Mengganti Status Selesai Pickup Delivery',

            'Membuka Menu Transaksi',
            'Melihat Detail Transaksi',
            'Menambahkan Item Ke Transaksi',
            'Mengubah Data Transaksi',

            'Melihat Detail Item Transaksi',
            'Membuat Item Transaksi',
            'Mengubah Data Item Transaksi',
            'Menghapus Item Transaksi',

            'Melihat Detail Jenis Item',
            'Melihat Detail Daftar Catatan Item',
            'Melihat Detail Catatan Item',
            'Membuat Catatan Item',
            'Menambahkan Penerima Ke Transaksi'
        ]);
    }
}
