<?php

namespace Database\Seeders;

use App\Models\Diskon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Date;

class DiskonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Diskon::create([
            'code' => 'DC'. rand(10000,99999),
            'description' => 'Contoh',
            'jenis_diskon' => 'exact',
            'expired' => Date::createFromDate(2023,6,1,'Asia/Jakarta'),
            'nominal' => 20000
        ]);
    }
}
