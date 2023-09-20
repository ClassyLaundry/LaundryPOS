<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        $this->call(PermissionSeeder::class);
        $this->call(RoleSeeder::class);
        $this->call(OutletSeeder::class);
        $this->call(AdminSeeder::class);
        $this->call(PaketSeeder::class);
        $this->call(ParfumSeeder::class);
        $this->call(KategoriSeeder::class);
        $this->call(JenisRewashSeeder::class);
        $this->call(SettingUmumSeeder::class);
        $this->call(JenisItemSeeder::class);

        $this->call(PelangganSeeder::class);
        $this->call(ProduksiSeeder::class);
        $this->call(DriverSeeder::class);
        $this->call(TransaksiSeeder::class);
        $this->call(PickupDeliverySeeder::class);
        $this->call(DiskonSeeder::class);
        $this->call(LaporanSeeder::class);
    }
}
