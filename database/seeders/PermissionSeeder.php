<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        //Basic
        Permission::create(['name' => 'Merubah Hak Akses']);

        //Karyawan
        Permission::create(['name' => 'Membuka Menu Karyawan']);
        Permission::create(['name' => 'Melihat Detail Karyawan']);
        Permission::create(['name' => 'Menambahkan Karyawan']);
        Permission::create(['name' => 'Mengubah Data Karyawan']);
        Permission::create(['name' => 'Mengubah Data Password Karyawan']);

        //Outlet
        Permission::create(['name' => 'Membuka Menu Outlet']);
        Permission::create(['name' => 'Melihat Detail Outlet']);
        Permission::create(['name' => 'Membuat Outlet']);
        Permission::create(['name' => 'Mengubah Data Outlet']);
        Permission::create(['name' => 'Menghapus Outlet']);
        Permission::create(['name' => 'Menambah Saldo Outlet']);

        //PaketCuci
        Permission::create(['name' => 'Membuka Menu Paket Cuci']);
        Permission::create(['name' => 'Melihat Detail Paket Cuci']);
        Permission::create(['name' => 'Membuat Paket Cuci']);
        Permission::create(['name' => 'Mengubah Data Paket Cuci']);
        Permission::create(['name' => 'Menghapus Paket Cuci']);

        //PaketDeposit
        Permission::create(['name' => 'Membuka Menu Paket Deposit']);
        Permission::create(['name' => 'Melihat Detail Paket Deposit']);
        Permission::create(['name' => 'Membuat Paket Deposit']);
        Permission::create(['name' => 'Mengubah Data Paket Deposit']);
        Permission::create(['name' => 'Menghapus Paket Deposit']);

        //JenisItem
        Permission::create(['name' => 'Membuka Menu Jenis Item']);
        Permission::create(['name' => 'Melihat Detail Jenis Item']);
        Permission::create(['name' => 'Membuat Jenis Item']);
        Permission::create(['name' => 'Mengubah Data Jenis Item']);
        Permission::create(['name' => 'Menghapus Jenis Item']);

        //Kategori
        Permission::create(['name' => 'Membuka Menu Kategori']);
        Permission::create(['name' => 'Melihat Detail Kategori']);
        Permission::create(['name' => 'Membuat Kategori']);
        Permission::create(['name' => 'Mengubah Data Kategori']);
        Permission::create(['name' => 'Menghapus Kategori']);

        //Pengeluaran
        Permission::create(['name' => 'Membuka Menu Pengeluaran']);
        Permission::create(['name' => 'Melihat Detail Pengeluaran']);
        Permission::create(['name' => 'Membuat Pengeluaran']);
        Permission::create(['name' => 'Mengubah Data Pengeluaran']);
        Permission::create(['name' => 'Menghapus Pengeluaran']);

        //Parfum
        Permission::create(['name' => 'Membuka Menu Parfum']);
        Permission::create(['name' => 'Melihat Detail Parfum']);
        Permission::create(['name' => 'Membuat Parfum']);
        Permission::create(['name' => 'Mengubah Data Parfum']);
        Permission::create(['name' => 'Menghapus Parfum']);

        //Pelanggan
        Permission::create(['name' => 'Membuka Menu Pelanggan']);
        Permission::create(['name' => 'Melihat Detail Pelanggan']);
        Permission::create(['name' => 'Membuat Pelanggan']);
        Permission::create(['name' => 'Mengubah Data Pelanggan']);
        Permission::create(['name' => 'Menghapus Pelanggan']);

        //Pickup & Delivery
        Permission::create(['name' => 'Membuka Menu Pickup Delivery']);
        Permission::create(['name' => 'Melihat Detail Pickup Delivery']);
        Permission::create(['name' => 'Membuat Pickup Delivery']);
        Permission::create(['name' => 'Mengubah Data Pickup Delivery']);
        Permission::create(['name' => 'Menghapus Pickup Delivery']);
        Permission::create(['name' => 'Mengganti Status Selesai Pickup Delivery']);

        //Item Transaksi
        Permission::create(['name' => 'Melihat Detail Item Transaksi']);
        Permission::create(['name' => 'Membuat Item Transaksi']);
        Permission::create(['name' => 'Mengubah Data Item Transaksi']);
        Permission::create(['name' => 'Menghapus Item Transaksi']);

        //Item Note
        Permission::create(['name' => 'Melihat Detail Daftar Catatan Item']);
        Permission::create(['name' => 'Melihat Detail Catatan Item']);
        Permission::create(['name' => 'Membuat Catatan Item']);

        //Transaksi
        Permission::create(['name' => 'Membuka Menu Transaksi']);
        Permission::create(['name' => 'Membuat Transaksi']);
        Permission::create(['name' => 'Melihat Detail Transaksi']);
        Permission::create(['name' => 'Menambahkan Item Ke Transaksi']);
        Permission::create(['name' => 'Mengubah Data Transaksi']);
        Permission::create(['name' => 'Menambahkan Penerima Ke Transaksi']);
        Permission::create(['name' => 'Membatalkan Transaksi']);
        Permission::create(['name' => 'Restore Transaksi']);

        //Cancelled
        Permission::create(['name' => 'Membuka Menu Canceled']);
        Permission::create(['name' => 'Merestore Transaksi']);

        //HubCuci
        Permission::create(['name' => 'Membuka Menu Hub Cuci']);
        Permission::create(['name' => 'Mengambil Tugas Cuci']);
        Permission::create(['name' => 'Mengurangi Tugas Cuci']);
        //HubSetrika
        Permission::create(['name' => 'Membuka Menu Hub Setrika']);
        Permission::create(['name' => 'Mengambil Tugas Setrika']);
        Permission::create(['name' => 'Mengurangi Tugas Setrika']);

        //History Pelanggan
        Permission::create(['name' => 'Membuka Halaman Detail Pelanggan']);
        Permission::create(['name' => 'Melihat Detail History Transaksi Pelanggan']);
        Permission::create(['name' => 'Melihat Detail History Saldo Pelanggan']);

        //Saldo
        Permission::create(['name' => 'Membuka Menu Saldo']);
        Permission::create(['name' => 'Topup Saldo Pelanggan']);

        //Pembayaran
        Permission::create(['name' => 'Membuka Menu Pembayaran']);
        Permission::create(['name' => 'Melihat Detail Pembayaran']);
        Permission::create(['name' => 'Membuat Pembayaran']);
        Permission::create(['name' => 'Mengubah Data Pembayaran']);
        Permission::create(['name' => 'Menghapus Pembayaran']);

        //Inventory
        Permission::create(['name' => 'Membuka Menu Inventory']);
        Permission::create(['name' => 'Menambah Inventory']);
        Permission::create(['name' => 'Mengubah Data Inventory']);
        Permission::create(['name' => 'Menghapus Inventory']);
        Permission::create(['name' => 'Mengubah Data Stok Inventory']);

        //Rewash
        Permission::create(['name' => 'Membuka Menu Rewash']);
        Permission::create(['name' => 'Menambah Rewash']);
        Permission::create(['name' => 'Menghapus Rewash']);

        //Proses Rewash
        Permission::create(['name' => 'Membuka Menu Proses Rewash']);
        Permission::create(['name' => 'Menambah Data Proses Rewash']);
        Permission::create(['name' => 'Menyatakan Selesai Proses Rewash']);
        Permission::create(['name' => 'Menghapus Data Proses Rewash']);

        //Packing
        Permission::create(['name' => 'Membuka Menu Packing']);
        Permission::create(['name' => 'Menginputkan Data Packing']);

        //Diskon
        Permission::create(['name' => 'Membuka Menu Diskon']);
        Permission::create(['name' => 'Menambah Data Diskon']);
        Permission::create(['name' => 'Mengubah Data Diskon']);
        Permission::create(['name' => 'Menghapus Data Diskon']);

        //Catatan Pelanggan
        Permission::create(['name' => 'Menambah Catatan Pelanggan']);
        Permission::create(['name' => 'Melihat Catatan Pelanggan']);
        Permission::create(['name' => 'Mengupdate Catatan Pelanggan']);
    }
}
