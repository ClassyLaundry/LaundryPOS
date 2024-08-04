<?php

namespace Database\Seeders;

use App\Models\Saldo;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LaporanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $twoMonthsAgo = Carbon::now()->subMonths(2);
        Saldo::create([
            'pelanggan_id' => '1',
            'nominal' => '10000',
            'jenis_input' => 'deposit',
            'saldo_akhir' => '10000',
        ]);
        Saldo::create([
            'pelanggan_id' => '1',
            'nominal' => '10000',
            'jenis_input' => 'deposit',
            'saldo_akhir' => '10000',
            'created_at' => $twoMonthsAgo
        ]);
    }
}
