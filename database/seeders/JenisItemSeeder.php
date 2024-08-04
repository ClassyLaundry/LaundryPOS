<?php

namespace Database\Seeders;

use App\Models\Data\JenisItem;
use App\Models\Data\Kategori;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class JenisItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        JenisItem::create([
            'nama' => 'CELANA JEANS PANJANG',
            'kategori_id' => 10,
            'unit' => 'PCS',
            'bobot_bucket' => 2.0,
            'harga_premium' => 0,
            'harga_bucket' => 0,
            'harga_kilo' => 0,
            'status_premium' => false,
            'status_bucket' => true,
            'status_kilo' => false,
            'beban_produksi' => 0.0,
            'status_item' => true,
        ]);

        JenisItem::create([
            'nama' => 'CELANA JEANS PENDEK',
            'kategori_id' => 10,
            'unit' => 'PCS',
            'bobot_bucket' => '2.0',
            'harga_premium' => 0,
            'harga_bucket' => 0,
            'harga_kilo' => 0,
            'status_premium' => false,
            'status_bucket' => true,
            'status_kilo' => false,
            'beban_produksi' => 0.0,
            'status_item' => true,
        ]);

        JenisItem::create([
            'nama' => 'DASTER',
            'kategori_id' => 10,
            'unit' => 'PCS',
            'bobot_bucket' => '2.0',
            'harga_premium' => 0,
            'harga_bucket' => 0,
            'harga_kilo' => 0,
            'status_premium' => false,
            'status_bucket' => true,
            'status_kilo' => false,
            'beban_produksi' => 0.0,
            'status_item' => true,
        ]);

        JenisItem::create([
            'nama' => 'HANDUK BESAR',
            'kategori_id' => 10,
            'unit' => 'PCS',
            'bobot_bucket' => '2.0',
            'harga_premium' => 0,
            'harga_bucket' => 0,
            'harga_kilo' => 0,
            'status_premium' => false,
            'status_bucket' => true,
            'status_kilo' => false,
            'beban_produksi' => 0.0,
            'status_item' => true,
        ]);

        JenisItem::create([
            'nama' => 'HANDUK KECIL',
            'kategori_id' => 10,
            'unit' => 'PCS',
            'bobot_bucket' => '1.0',
            'harga_premium' => 0,
            'harga_bucket' => 0,
            'harga_kilo' => 0,
            'status_premium' => false,
            'status_bucket' => true,
            'status_kilo' => false,
            'beban_produksi' => 0.0,
            'status_item' => true,
        ]);

        JenisItem::create([
            'nama' => 'HEADBAND',
            'kategori_id' => 10,
            'unit' => 'PCS',
            'bobot_bucket' => 0.0,
            'harga_premium' => 0,
            'harga_bucket' => 0,
            'harga_kilo' => 0,
            'status_premium' => false,
            'status_bucket' => true,
            'status_kilo' => false,
            'beban_produksi' => 0.0,
            'status_item' => true,
        ]);

        JenisItem::create([
            'nama' => 'JUBAH TOGA VITA SCHOOL',
            'kategori_id' => 10,
            'unit' => 'PCS',
            'bobot_bucket' => '2.0',
            'harga_premium' => 0,
            'harga_bucket' => 0,
            'harga_kilo' => 0,
            'status_premium' => false,
            'status_bucket' => true,
            'status_kilo' => false,
            'beban_produksi' => 0.0,
            'status_item' => true,
        ]);

        JenisItem::create([
            'nama' => 'KAOS DALAM',
            'kategori_id' => 10,
            'unit' => 'PCS',
            'bobot_bucket' => '0.5',
            'harga_premium' => 0,
            'harga_bucket' => 0,
            'harga_kilo' => 0,
            'status_premium' => false,
            'status_bucket' => true,
            'status_kilo' => false,
            'beban_produksi' => '0.5',
            'status_item' => true,
        ]);

        JenisItem::create([
            'nama' => 'KEMBEN',
            'kategori_id' => 10,
            'unit' => 'PCS',
            'bobot_bucket' => 0.0,
            'harga_premium' => 0,
            'harga_bucket' => 0,
            'harga_kilo' => 0,
            'status_premium' => false,
            'status_bucket' => true,
            'status_kilo' => false,
            'beban_produksi' => 0.0,
            'status_item' => true,
        ]);

        JenisItem::create([
            'nama' => 'SAPU TANGAN',
            'kategori_id' => 10,
            'unit' => 'PCS',
            'bobot_bucket' => 0.0,
            'harga_premium' => 0,
            'harga_bucket' => 0,
            'harga_kilo' => 0,
            'status_premium' => false,
            'status_bucket' => true,
            'status_kilo' => false,
            'beban_produksi' => 0.0,
            'status_item' => true,
        ]);

        JenisItem::create([
            'nama' => 'SARUNG BALI',
            'kategori_id' => 10,
            'unit' => 'PCS',
            'bobot_bucket' => '1.0',
            'harga_premium' => 0,
            'harga_bucket' => 0,
            'harga_kilo' => 0,
            'status_premium' => false,
            'status_bucket' => true,
            'status_kilo' => false,
            'beban_produksi' => 0.0,
            'status_item' => true,
        ]);

        JenisItem::create([
            'nama' => 'VITASCH JUBAH',
            'kategori_id' => 10,
            'unit' => 'PCS',
            'bobot_bucket' => '2.0',
            'harga_premium' => 0,
            'harga_bucket' => 0,
            'harga_kilo' => 0,
            'status_premium' => false,
            'status_bucket' => true,
            'status_kilo' => false,
            'beban_produksi' => 0.0,
            'status_item' => true,
        ]);

        JenisItem::create([
            'nama' => 'VITASCH SLEBER',
            'kategori_id' => 10,
            'unit' => 'PCS',
            'bobot_bucket' => '1.0',
            'harga_premium' => 0,
            'harga_bucket' => 0,
            'harga_kilo' => 0,
            'status_premium' => false,
            'status_bucket' => true,
            'status_kilo' => false,
            'beban_produksi' => 0.0,
            'status_item' => true,
        ]);

        JenisItem::create([
            'nama' => '3 BEDCOVER ALLSIZE',
            'kategori_id' => 9,
            'unit' => 'PCS',
            'bobot_bucket' => 0.0,
            'harga_premium' => 190000,
            'harga_bucket' => 0,
            'harga_kilo' => 0,
            'status_premium' => true,
            'status_bucket' => false,
            'status_kilo' => false,
            'beban_produksi' => '20.0',
            'status_item' => true,
        ]);

        JenisItem::create([
            'nama' => 'AUDELIA BEDSET BESAR(1BCd,1SPRd,2SBTL,2SGLG)',
            'kategori_id' => 11,
            'unit' => 'PCS',
            'bobot_bucket' => 0.0,
            'harga_premium' => 42000,
            'harga_bucket' => 0,
            'harga_kilo' => 0,
            'status_premium' => true,
            'status_bucket' => false,
            'status_kilo' => false,
            'beban_produksi' => 0.0,
            'status_item' => true,
        ]);

        JenisItem::create([
            'nama' => 'AUDELIA BEDSET KECIL(1BCs,1SPRs,1SBTL,1SGLG)',
            'kategori_id' => 11,
            'unit' => 'PCS',
            'bobot_bucket' => 0.0,
            'harga_premium' => 31000,
            'harga_bucket' => 0,
            'harga_kilo' => 0,
            'status_premium' => true,
            'status_bucket' => false,
            'status_kilo' => false,
            'beban_produksi' => 0.0,
            'status_item' => true,
        ]);

        JenisItem::create([
            'nama' => 'AUDELIA FULL SET(1BCd,1BCs,3SBTL,3SGLG)',
            'kategori_id' => 11,
            'unit' => 'PCS',
            'bobot_bucket' => 0.0,
            'harga_premium' => 58000,
            'harga_bucket' => 0,
            'harga_kilo' => 0,
            'status_premium' => true,
            'status_bucket' => false,
            'status_kilo' => false,
            'beban_produksi' => 0.0,
            'status_item' => true,
        ]);

        JenisItem::create([
            'nama' => 'AUDELIA SEPREI BESAR(3 SPRd,6SBTL,6SGLG)',
            'kategori_id' => 11,
            'unit' => 'PCS',
            'bobot_bucket' => 0.0,
            'harga_premium' => 33000,
            'harga_bucket' => 0,
            'harga_kilo' => 0,
            'status_premium' => true,
            'status_bucket' => false,
            'status_kilo' => false,
            'beban_produksi' => 0.0,
            'status_item' => true,
        ]);

        JenisItem::create([
            'nama' => 'AUDELIA SEPREI KECIL(3 SPRs,3SBTL,3SGLG)',
            'kategori_id' => 11,
            'unit' => 'PCS',
            'bobot_bucket' => 0.0,
            'harga_premium' => 28000,
            'harga_bucket' => 0,
            'harga_kilo' => 0,
            'status_premium' => true,
            'status_bucket' => false,
            'status_kilo' => false,
            'beban_produksi' => 0.0,
            'status_item' => true,
        ]);

        JenisItem::create([
            'nama' => 'BABY CAR CHAIR',
            'kategori_id' => 15,
            'unit' => 'PCS',
            'bobot_bucket' => 0.0,
            'harga_premium' => 98000,
            'harga_bucket' => 0,
            'harga_kilo' => 0,
            'status_premium' => true,
            'status_bucket' => false,
            'status_kilo' => false,
            'beban_produksi' => '20.0',
            'status_item' => true,
        ]);

        JenisItem::create([
            'nama' => 'BABY STROLLER',
            'kategori_id' => 15,
            'unit' => 'PCS',
            'bobot_bucket' => 0.0,
            'harga_premium' => 98000,
            'harga_bucket' => 0,
            'harga_kilo' => 0,
            'status_premium' => true,
            'status_bucket' => false,
            'status_kilo' => false,
            'beban_produksi' => '10.0',
            'status_item' => true,
        ]);

        JenisItem::create([
            'nama' => 'BAJU GAMIS',
            'kategori_id' => 6,
            'unit' => 'PCS',
            'bobot_bucket' => 0.0,
            'harga_premium' => 30000,
            'harga_bucket' => 0,
            'harga_kilo' => 0,
            'status_premium' => true,
            'status_bucket' => false,
            'status_kilo' => false,
            'beban_produksi' => '5.0',
            'status_item' => true,
        ]);

        JenisItem::create([
            'nama' => 'BAJU KARATE',
            'kategori_id' => 4,
            'unit' => 'PCS',
            'bobot_bucket' => 0.0,
            'harga_premium' => 40000,
            'harga_bucket' => 0,
            'harga_kilo' => 0,
            'status_premium' => true,
            'status_bucket' => false,
            'status_kilo' => false,
            'beban_produksi' => '1.0',
            'status_item' => true,
        ]);

        JenisItem::create([
            'nama' => 'BAJU KOKO',
            'kategori_id' => 6,
            'unit' => 'PCS',
            'bobot_bucket' => 0.0,
            'harga_premium' => 20000,
            'harga_bucket' => 0,
            'harga_kilo' => 0,
            'status_premium' => true,
            'status_bucket' => false,
            'status_kilo' => false,
            'beban_produksi' => '5.0',
            'status_item' => true,
        ]);

        JenisItem::create([
            'nama' => 'BAJU PENGANTIN JAWA',
            'kategori_id' => 14,
            'unit' => 'PCS',
            'bobot_bucket' => 0.0,
            'harga_premium' => 180000,
            'harga_bucket' => 0,
            'harga_kilo' => 0,
            'status_premium' => true,
            'status_bucket' => false,
            'status_kilo' => false,
            'beban_produksi' => '10.0',
            'status_item' => true,
        ]);

        JenisItem::create([
            'nama' => 'BAJU RENANG',
            'kategori_id' => 4,
            'unit' => 'PCS',
            'bobot_bucket' => 0.0,
            'harga_premium' => 28000,
            'harga_bucket' => 0,
            'harga_kilo' => 0,
            'status_premium' => true,
            'status_bucket' => false,
            'status_kilo' => false,
            'beban_produksi' => '5.0',
            'status_item' => true,
        ]);

        JenisItem::create([
            'nama' => 'BANDANA',
            'kategori_id' => 1,
            'unit' => 'PCS',
            'bobot_bucket' => 0.0,
            'harga_premium' => 17000,
            'harga_bucket' => 0,
            'harga_kilo' => 0,
            'status_premium' => true,
            'status_bucket' => false,
            'status_kilo' => false,
            'beban_produksi' => '1.0',
            'status_item' => true,
        ]);

        JenisItem::create([
            'nama' => 'BANTAL',
            'kategori_id' => 9,
            'unit' => 'PCS',
            'bobot_bucket' => 0.0,
            'harga_premium' => 45000,
            'harga_bucket' => 0,
            'harga_kilo' => 0,
            'status_premium' => true,
            'status_bucket' => false,
            'status_kilo' => false,
            'beban_produksi' => '10.0',
            'status_item' => true,
        ]);

        JenisItem::create([
            'nama' => 'BANTAL BONEKA',
            'kategori_id' => 3,
            'unit' => 'PCS',
            'bobot_bucket' => 0.0,
            'harga_premium' => 50000,
            'harga_bucket' => 0,
            'harga_kilo' => 0,
            'status_premium' => true,
            'status_bucket' => false,
            'status_kilo' => false,
            'beban_produksi' => '5.0',
            'status_item' => true,
        ]);

        JenisItem::create([
            'nama' => 'BANTAL BULU ANGSA',
            'kategori_id' => 9,
            'unit' => 'PCS',
            'bobot_bucket' => 0.0,
            'harga_premium' => 58000,
            'harga_bucket' => 0,
            'harga_kilo' => 0,
            'status_premium' => true,
            'status_bucket' => false,
            'status_kilo' => false,
            'beban_produksi' => '10.0',
            'status_item' => true,
        ]);

        JenisItem::create([
            'nama' => 'BANTAL SOFA JUMBO (>60CM)',
            'kategori_id' => 3,
            'unit' => 'PCS',
            'bobot_bucket' => 0.0,
            'harga_premium' => 110000,
            'harga_bucket' => 0,
            'harga_kilo' => 0,
            'status_premium' => true,
            'status_bucket' => false,
            'status_kilo' => false,
            'beban_produksi' => '10.0',
            'status_item' => true,
        ]);

        JenisItem::create([
            'nama' => 'BANTAL SOFA L(30CM-60CM)',
            'kategori_id' => 3,
            'unit' => 'PCS',
            'bobot_bucket' => 0.0,
            'harga_premium' => 53000,
            'harga_bucket' => 0,
            'harga_kilo' => 0,
            'status_premium' => true,
            'status_bucket' => false,
            'status_kilo' => false,
            'beban_produksi' => '10.0',
            'status_item' => true,
        ]);

        JenisItem::create([
            'nama' => 'BANTAL SOFA S (<30CM)',
            'kategori_id' => 3,
            'unit' => 'PCS',
            'bobot_bucket' => 0.0,
            'harga_premium' => 40000,
            'harga_bucket' => 0,
            'harga_kilo' => 0,
            'status_premium' => true,
            'status_bucket' => false,
            'status_kilo' => false,
            'beban_produksi' => '10.0',
            'status_item' => true,
        ]);

        JenisItem::create([
            'nama' => 'BANTAL SOFA TIPIS',
            'kategori_id' => 3,
            'unit' => 'PCS',
            'bobot_bucket' => 0.0,
            'harga_premium' => 35000,
            'harga_bucket' => 0,
            'harga_kilo' => 0,
            'status_premium' => true,
            'status_bucket' => false,
            'status_kilo' => false,
            'beban_produksi' => '5.0',
            'status_item' => true,
        ]);

        JenisItem::create([
            'nama' => 'BANTAL/GULING BAYI',
            'kategori_id' => 15,
            'unit' => 'PCS',
            'bobot_bucket' => 0.0,
            'harga_premium' => 25000,
            'harga_bucket' => 0,
            'harga_kilo' => 0,
            'status_premium' => true,
            'status_bucket' => false,
            'status_kilo' => false,
            'beban_produksi' => 0.0,
            'status_item' => true,
        ]);

        JenisItem::create([
            'nama' => 'BED COVER DOUBLE',
            'kategori_id' => 9,
            'unit' => 'PCS',
            'bobot_bucket' => 0.0,
            'harga_premium' => 68000,
            'harga_bucket' => 0,
            'harga_kilo' => 0,
            'status_premium' => true,
            'status_bucket' => false,
            'status_kilo' => false,
            'beban_produksi' => '15.0',
            'status_item' => true,
        ]);

        JenisItem::create([
            'nama' => 'BED COVER JUMBO ( > 2,2M )',
            'kategori_id' => 9,
            'unit' => 'PCS',
            'bobot_bucket' => 0.0,
            'harga_premium' => 95000,
            'harga_bucket' => 0,
            'harga_kilo' => 0,
            'status_premium' => true,
            'status_bucket' => false,
            'status_kilo' => false,
            'beban_produksi' => '20.0',
            'status_item' => true,
        ]);

        JenisItem::create([
            'nama' => 'BED COVER SINGLE',
            'kategori_id' => 9,
            'unit' => 'PCS',
            'bobot_bucket' => 0.0,
            'harga_premium' => 45000,
            'harga_bucket' => 0,
            'harga_kilo' => 0,
            'status_premium' => true,
            'status_bucket' => false,
            'status_kilo' => false,
            'beban_produksi' => '10.0',
            'status_item' => true,
        ]);

        JenisItem::create([
            'nama' => 'BEDCOVER 2 LAYER',
            'kategori_id' => 9,
            'unit' => 'PCS',
            'bobot_bucket' => 0.0,
            'harga_premium' => 125000,
            'harga_bucket' => 0,
            'harga_kilo' => 0,
            'status_premium' => true,
            'status_bucket' => false,
            'status_kilo' => false,
            'beban_produksi' => '22.0',
            'status_item' => true,
        ]);

        JenisItem::create([
            'nama' => 'BEDCOVER BAYI',
            'kategori_id' => 15,
            'unit' => 'PCS',
            'bobot_bucket' => 0.0,
            'harga_premium' => 38000,
            'harga_bucket' => 0,
            'harga_kilo' => 0,
            'status_premium' => true,
            'status_bucket' => false,
            'status_kilo' => false,
            'beban_produksi' => '5.0',
            'status_item' => true,
        ]);

        JenisItem::create([
            'nama' => 'BEDCOVER SUTRA',
            'kategori_id' => 9,
            'unit' => 'PCS',
            'bobot_bucket' => 0.0,
            'harga_premium' => 115000,
            'harga_bucket' => 0,
            'harga_kilo' => 0,
            'status_premium' => true,
            'status_bucket' => false,
            'status_kilo' => false,
            'beban_produksi' => '5.0',
            'status_item' => true,
        ]);

        JenisItem::create([
            'nama' => 'BEDSHEET BESAR (1BC,1SP,2BTL,2GLG)',
            'kategori_id' => 9,
            'unit' => 'PCS',
            'bobot_bucket' => 0.0,
            'harga_premium' => 115000,
            'harga_bucket' => 0,
            'harga_kilo' => 0,
            'status_premium' => true,
            'status_bucket' => false,
            'status_kilo' => false,
            'beban_produksi' => 0.0,
            'status_item' => false,
        ]);

        JenisItem::create([
            'nama' => 'BLAZER / JAS',
            'kategori_id' => 4,
            'unit' => 'PCS',
            'bobot_bucket' => 0.0,
            'harga_premium' => 43000,
            'harga_bucket' => 0,
            'harga_kilo' => 0,
            'status_premium' => true,
            'status_bucket' => false,
            'status_kilo' => false,
            'beban_produksi' => '5.0',
            'status_item' => true,
        ]);

        JenisItem::create([
            'nama' => 'BLOUSE (SELUTUT)',
            'kategori_id' => 4,
            'unit' => 'PCS',
            'bobot_bucket' => 0.0,
            'harga_premium' => 33000,
            'harga_bucket' => 0,
            'harga_kilo' => 0,
            'status_premium' => true,
            'status_bucket' => false,
            'status_kilo' => false,
            'beban_produksi' => '5.0',
            'status_item' => true,
        ]);

        JenisItem::create([
            'nama' => 'BLOUSE ANAK',
            'kategori_id' => 4,
            'unit' => 'PCS',
            'bobot_bucket' => 0.0,
            'harga_premium' => 16000,
            'harga_bucket' => 0,
            'harga_kilo' => 0,
            'status_premium' => true,
            'status_bucket' => false,
            'status_kilo' => false,
            'beban_produksi' => '3.0',
            'status_item' => true,
        ]);

        JenisItem::create([
            'nama' => 'BLOUSE BATIK',
            'kategori_id' => 4,
            'unit' => 'PCS',
            'bobot_bucket' => 0.0,
            'harga_premium' => 39000,
            'harga_bucket' => 0,
            'harga_kilo' => 0,
            'status_premium' => true,
            'status_bucket' => false,
            'status_kilo' => false,
            'beban_produksi' => '5.0',
            'status_item' => true,
        ]);

        JenisItem::create([
            'nama' => 'BLOUSE PESTA',
            'kategori_id' => 14,
            'unit' => 'PCS',
            'bobot_bucket' => 0.0,
            'harga_premium' => 55000,
            'harga_bucket' => 0,
            'harga_kilo' => 0,
            'status_premium' => true,
            'status_bucket' => false,
            'status_kilo' => false,
            'beban_produksi' => '10.0',
            'status_item' => true,
        ]);

        JenisItem::create([
            'nama' => 'BLOUSE PESTA ANAK',
            'kategori_id' => 14,
            'unit' => 'PCS',
            'bobot_bucket' => 0.0,
            'harga_premium' => 38000,
            'harga_bucket' => 0,
            'harga_kilo' => 0,
            'status_premium' => true,
            'status_bucket' => false,
            'status_kilo' => false,
            'beban_produksi' => '5.0',
            'status_item' => true,
        ]);

        JenisItem::create([
            'nama' => 'BONEKA BESAR (40-60CM)',
            'kategori_id' => 3,
            'unit' => 'PCS',
            'bobot_bucket' => 0.0,
            'harga_premium' => 50000,
            'harga_bucket' => 0,
            'harga_kilo' => 0,
            'status_premium' => true,
            'status_bucket' => false,
            'status_kilo' => false,
            'beban_produksi' => '10.0',
            'status_item' => true,
        ]);

        JenisItem::create([
            'nama' => 'BONEKA JUMBO (60CM <)',
            'kategori_id' => 3,
            'unit' => 'PCS',
            'bobot_bucket' => 0.0,
            'harga_premium' => 95000,
            'harga_bucket' => 0,
            'harga_kilo' => 0,
            'status_premium' => true,
            'status_bucket' => false,
            'status_kilo' => false,
            'beban_produksi' => '15.0',
            'status_item' => true,
        ]);

        JenisItem::create([
            'nama' => 'BONEKA KECIL (<20CM)',
            'kategori_id' => 3,
            'unit' => 'PCS',
            'bobot_bucket' => 0.0,
            'harga_premium' => 15000,
            'harga_bucket' => 0,
            'harga_kilo' => 0,
            'status_premium' => true,
            'status_bucket' => false,
            'status_kilo' => false,
            'beban_produksi' => '5.0',
            'status_item' => true,
        ]);

        JenisItem::create([
            'nama' => 'BONEKA SEDANG (20-40CM)',
            'kategori_id' => 3,
            'unit' => 'PCS',
            'bobot_bucket' => 0.0,
            'harga_premium' => 28000,
            'harga_bucket' => 0,
            'harga_kilo' => 0,
            'status_premium' => true,
            'status_bucket' => false,
            'status_kilo' => false,
            'beban_produksi' => '10.0',
            'status_item' => true,
        ]);

        JenisItem::create([
            'nama' => 'BORC BAJU',
            'kategori_id' => 11,
            'unit' => 'PCS',
            'bobot_bucket' => 0.0,
            'harga_premium' => 5000,
            'harga_bucket' => 0,
            'harga_kilo' => 0,
            'status_premium' => true,
            'status_bucket' => false,
            'status_kilo' => false,
            'beban_produksi' => 0.0,
            'status_item' => false,
        ]);

        JenisItem::create([
            'nama' => 'BORC CELANA',
            'kategori_id' => 11,
            'unit' => 'PCS',
            'bobot_bucket' => 0.0,
            'harga_premium' => 5000,
            'harga_bucket' => 0,
            'harga_kilo' => 0,
            'status_premium' => true,
            'status_bucket' => false,
            'status_kilo' => false,
            'beban_produksi' => 0.0,
            'status_item' => false,
        ]);

        JenisItem::create([
            'nama' => 'BORC DEKER KAIN',
            'kategori_id' => 11,
            'unit' => 'PCS',
            'bobot_bucket' => 0.0,
            'harga_premium' => 3000,
            'harga_bucket' => 0,
            'harga_kilo' => 0,
            'status_premium' => true,
            'status_bucket' => false,
            'status_kilo' => false,
            'beban_produksi' => 0.0,
            'status_item' => false,
        ]);

        JenisItem::create([
            'nama' => 'BORC HANDUK KECIL',
            'kategori_id' => 11,
            'unit' => 'PCS',
            'bobot_bucket' => 0.0,
            'harga_premium' => 3000,
            'harga_bucket' => 0,
            'harga_kilo' => 0,
            'status_premium' => true,
            'status_bucket' => false,
            'status_kilo' => false,
            'beban_produksi' => 0.0,
            'status_item' => false,
        ]);

        JenisItem::create([
            'nama' => 'BORC JAS',
            'kategori_id' => 11,
            'unit' => 'PCS',
            'bobot_bucket' => 0.0,
            'harga_premium' => 10000,
            'harga_bucket' => 0,
            'harga_kilo' => 0,
            'status_premium' => true,
            'status_bucket' => false,
            'status_kilo' => false,
            'beban_produksi' => 0.0,
            'status_item' => false,
        ]);

        JenisItem::create([
            'nama' => 'BORC PAKET LENGKAP',
            'kategori_id' => 11,
            'unit' => 'PCS',
            'bobot_bucket' => 0.0,
            'harga_premium' => 177000,
            'harga_bucket' => 0,
            'harga_kilo' => 0,
            'status_premium' => true,
            'status_bucket' => false,
            'status_kilo' => false,
            'beban_produksi' => 0.0,
            'status_item' => false,
        ]);

        JenisItem::create([
            'nama' => 'BORC SEPREI BESAR',
            'kategori_id' => 11,
            'unit' => 'PCS',
            'bobot_bucket' => 0.0,
            'harga_premium' => 15000,
            'harga_bucket' => 0,
            'harga_kilo' => 0,
            'status_premium' => true,
            'status_bucket' => false,
            'status_kilo' => false,
            'beban_produksi' => 0.0,
            'status_item' => false,
        ]);

        JenisItem::create([
            'nama' => 'BORC SEPREI KECIL',
            'kategori_id' => 11,
            'unit' => 'PCS',
            'bobot_bucket' => 0.0,
            'harga_premium' => 10000,
            'harga_bucket' => 0,
            'harga_kilo' => 0,
            'status_premium' => true,
            'status_bucket' => false,
            'status_kilo' => false,
            'beban_produksi' => 0.0,
            'status_item' => false,
        ]);

        JenisItem::create([
            'nama' => 'BORC TAPLAK BESAR',
            'kategori_id' => 11,
            'unit' => 'PCS',
            'bobot_bucket' => 0.0,
            'harga_premium' => 10000,
            'harga_bucket' => 0,
            'harga_kilo' => 0,
            'status_premium' => true,
            'status_bucket' => false,
            'status_kilo' => false,
            'beban_produksi' => 0.0,
            'status_item' => false,
        ]);

        JenisItem::create([
            'nama' => 'BORC TAPLAK KECIL',
            'kategori_id' => 11,
            'unit' => 'PCS',
            'bobot_bucket' => 0.0,
            'harga_premium' => 8000,
            'harga_bucket' => 0,
            'harga_kilo' => 0,
            'status_premium' => true,
            'status_bucket' => false,
            'status_kilo' => false,
            'beban_produksi' => 0.0,
            'status_item' => false,
        ]);

        JenisItem::create([
            'nama' => 'BRA / CD',
            'kategori_id' => 4,
            'unit' => 'PCS',
            'bobot_bucket' => 0.0,
            'harga_premium' => 15000,
            'harga_bucket' => 0,
            'harga_kilo' => 0,
            'status_premium' => true,
            'status_bucket' => false,
            'status_kilo' => false,
            'beban_produksi' => '1.0',
            'status_item' => true,
        ]);

        JenisItem::create([
            'nama' => 'BRA ANAK',
            'kategori_id' => 4,
            'unit' => 'PCS',
            'bobot_bucket' => 0.0,
            'harga_premium' => 11000,
            'harga_bucket' => 0,
            'harga_kilo' => 0,
            'status_premium' => true,
            'status_bucket' => false,
            'status_kilo' => false,
            'beban_produksi' => '3.0',
            'status_item' => true,
        ]);

        JenisItem::create([
            'nama' => 'BUMPER BAYI (1BJ)',
            'kategori_id' => 15,
            'unit' => 'PCS',
            'bobot_bucket' => 0.0,
            'harga_premium' => 28000,
            'harga_bucket' => 0,
            'harga_kilo' => 0,
            'status_premium' => true,
            'status_bucket' => false,
            'status_kilo' => false,
            'beban_produksi' => '5.0',
            'status_item' => true,
        ]);

        JenisItem::create([
            'nama' => 'BUMPER BAYI (2 PCS)',
            'kategori_id' => 15,
            'unit' => 'PCS',
            'bobot_bucket' => 0.0,
            'harga_premium' => 35000,
            'harga_bucket' => 0,
            'harga_kilo' => 0,
            'status_premium' => true,
            'status_bucket' => false,
            'status_kilo' => false,
            'beban_produksi' => '7.0',
            'status_item' => true,
        ]);

        JenisItem::create([
            'nama' => 'BUMPER BAYI (4 PCS)',
            'kategori_id' => 15,
            'unit' => 'PCS',
            'bobot_bucket' => 0.0,
            'harga_premium' => 55000,
            'harga_bucket' => 0,
            'harga_kilo' => 0,
            'status_premium' => true,
            'status_bucket' => false,
            'status_kilo' => false,
            'beban_produksi' => '10.0',
            'status_item' => true,
        ]);

        JenisItem::create([
            'nama' => 'CARDIGAN',
            'kategori_id' => 4,
            'unit' => 'PCS',
            'bobot_bucket' => 0.0,
            'harga_premium' => 32000,
            'harga_bucket' => 0,
            'harga_kilo' => 0,
            'status_premium' => true,
            'status_bucket' => false,
            'status_kilo' => false,
            'beban_produksi' => 0.0,
            'status_item' => true,
        ]);

        JenisItem::create([
            'nama' => 'CELANA BALAP',
            'kategori_id' => 8,
            'unit' => 'PCS',
            'bobot_bucket' => 0.0,
            'harga_premium' => 125000,
            'harga_bucket' => 0,
            'harga_kilo' => 0,
            'status_premium' => true,
            'status_bucket' => false,
            'status_kilo' => false,
            'beban_produksi' => 0.0,
            'status_item' => true,
        ]);

        JenisItem::create([
            'nama' => 'CELANA DALAM ANAK',
            'kategori_id' => 8,
            'unit' => 'PCS',
            'bobot_bucket' => 0.0,
            'harga_premium' => 13000,
            'harga_bucket' => 0,
            'harga_kilo' => 0,
            'status_premium' => true,
            'status_bucket' => false,
            'status_kilo' => false,
            'beban_produksi' => '2.0',
            'status_item' => true,
        ]);

        JenisItem::create([
            'nama' => 'CELANA KARATE',
            'kategori_id' => 8,
            'unit' => 'PCS',
            'bobot_bucket' => 0.0,
            'harga_premium' => 35000,
            'harga_bucket' => 0,
            'harga_kilo' => 0,
            'status_premium' => true,
            'status_bucket' => false,
            'status_kilo' => false,
            'beban_produksi' => 0.0,
            'status_item' => true,
        ]);

        JenisItem::create([
            'nama' => 'CELANA KULIT',
            'kategori_id' => 5,
            'unit' => 'PCS',
            'bobot_bucket' => 0.0,
            'harga_premium' => 99000,
            'harga_bucket' => 0,
            'harga_kilo' => 0,
            'status_premium' => true,
            'status_bucket' => false,
            'status_kilo' => false,
            'beban_produksi' => 0.0,
            'status_item' => true,
        ]);

        JenisItem::create([
            'nama' => 'CELANA PANJANG',
            'kategori_id' => 8,
            'unit' => 'PCS',
            'bobot_bucket' => 0.0,
            'harga_premium' => 35000,
            'harga_bucket' => 0,
            'harga_kilo' => 0,
            'status_premium' => true,
            'status_bucket' => false,
            'status_kilo' => false,
            'beban_produksi' => '10.0',
            'status_item' => true,
        ]);

        JenisItem::create([
            'nama' => 'CELANA PANJANG ANAK',
            'kategori_id' => 8,
            'unit' => 'PCS',
            'bobot_bucket' => 0.0,
            'harga_premium' => 18000,
            'harga_bucket' => 0,
            'harga_kilo' => 0,
            'status_premium' => true,
            'status_bucket' => false,
            'status_kilo' => false,
            'beban_produksi' => '3.0',
            'status_item' => true,
        ]);

        JenisItem::create([
            'nama' => 'CELANA PENDEK',
            'kategori_id' => 8,
            'unit' => 'PCS',
            'bobot_bucket' => 0.0,
            'harga_premium' => 25000,
            'harga_bucket' => 0,
            'harga_kilo' => 0,
            'status_premium' => true,
            'status_bucket' => false,
            'status_kilo' => false,
            'beban_produksi' => '5.0',
            'status_item' => true,
        ]);

        JenisItem::create([
            'nama' => 'CELANA PENDEK ANAK',
            'kategori_id' => 8,
            'unit' => 'PCS',
            'bobot_bucket' => 0.0,
            'harga_premium' => 15000,
            'harga_bucket' => 0,
            'harga_kilo' => 0,
            'status_premium' => true,
            'status_bucket' => false,
            'status_kilo' => false,
            'beban_produksi' => '2.0',
            'status_item' => true,
        ]);

        JenisItem::create([
            'nama' => 'CELEMEK MAKAN ANAK',
            'kategori_id' => 15,
            'unit' => 'PCS',
            'bobot_bucket' => 0.0,
            'harga_premium' => 17000,
            'harga_bucket' => 0,
            'harga_kilo' => 0,
            'status_premium' => true,
            'status_bucket' => false,
            'status_kilo' => false,
            'beban_produksi' => '1.0',
            'status_item' => true,
        ]);

        JenisItem::create([
            'nama' => 'COVER BEDCOVER',
            'kategori_id' => 9,
            'unit' => 'PCS',
            'bobot_bucket' => 0.0,
            'harga_premium' => 70000,
            'harga_bucket' => 0,
            'harga_kilo' => 0,
            'status_premium' => true,
            'status_bucket' => false,
            'status_kilo' => false,
            'beban_produksi' => '5.0',
            'status_item' => true,
        ]);

        JenisItem::create([
            'nama' => 'COVER BEDCOVER SMALL',
            'kategori_id' => 9,
            'unit' => 'PCS',
            'bobot_bucket' => 0.0,
            'harga_premium' => 55000,
            'harga_bucket' => 0,
            'harga_kilo' => 0,
            'status_premium' => true,
            'status_bucket' => false,
            'status_kilo' => false,
            'beban_produksi' => '2.0',
            'status_item' => true,
        ]);

        JenisItem::create([
            'nama' => 'COVER DADA',
            'kategori_id' => 12,
            'unit' => 'PCS',
            'bobot_bucket' => 0.0,
            'harga_premium' => 40000,
            'harga_bucket' => 0,
            'harga_kilo' => 0,
            'status_premium' => true,
            'status_bucket' => false,
            'status_kilo' => false,
            'beban_produksi' => '3.0',
            'status_item' => true,
        ]);

        JenisItem::create([
            'nama' => 'COVER GITAR',
            'kategori_id' => 3,
            'unit' => 'PCS',
            'bobot_bucket' => 0.0,
            'harga_premium' => 45000,
            'harga_bucket' => 0,
            'harga_kilo' => 0,
            'status_premium' => true,
            'status_bucket' => false,
            'status_kilo' => false,
            'beban_produksi' => '5.0',
            'status_item' => true,
        ]);

        JenisItem::create([
            'nama' => 'COVER JOK MOBIL (4PC)',
            'kategori_id' => 2,
            'unit' => 'PCS',
            'bobot_bucket' => 0.0,
            'harga_premium' => 110000,
            'harga_bucket' => 0,
            'harga_kilo' => 0,
            'status_premium' => true,
            'status_bucket' => false,
            'status_kilo' => false,
            'beban_produksi' => '7.0',
            'status_item' => true,
        ]);

        JenisItem::create([
            'nama' => 'COVER JOK MOBIL(8PC)',
            'kategori_id' => 2,
            'unit' => 'PCS',
            'bobot_bucket' => 0.0,
            'harga_premium' => 200000,
            'harga_bucket' => 0,
            'harga_kilo' => 0,
            'status_premium' => true,
            'status_bucket' => false,
            'status_kilo' => false,
            'beban_produksi' => '10.0',
            'status_item' => true,
        ]);

        JenisItem::create([
            'nama' => 'COVER KASUR BAYI',
            'kategori_id' => 15,
            'unit' => 'PCS',
            'bobot_bucket' => 0.0,
            'harga_premium' => 110000,
            'harga_bucket' => 0,
            'harga_kilo' => 0,
            'status_premium' => true,
            'status_bucket' => false,
            'status_kilo' => false,
            'beban_produksi' => '8.0',
            'status_item' => true,
        ]);

        JenisItem::create([
            'nama' => 'COVER KASUR LARGE',
            'kategori_id' => 9,
            'unit' => 'PCS',
            'bobot_bucket' => 0.0,
            'harga_premium' => 225000,
            'harga_bucket' => 0,
            'harga_kilo' => 0,
            'status_premium' => true,
            'status_bucket' => false,
            'status_kilo' => false,
            'beban_produksi' => '20.0',
            'status_item' => true,
        ]);

        JenisItem::create([
            'nama' => 'COVER KASUR SMALL',
            'kategori_id' => 9,
            'unit' => 'PCS',
            'bobot_bucket' => 0.0,
            'harga_premium' => 150000,
            'harga_bucket' => 0,
            'harga_kilo' => 0,
            'status_premium' => true,
            'status_bucket' => false,
            'status_kilo' => false,
            'beban_produksi' => '15.0',
            'status_item' => true,
        ]);

        JenisItem::create([
            'nama' => 'COVER TOPPER',
            'kategori_id' => 9,
            'unit' => 'PCS',
            'bobot_bucket' => 0.0,
            'harga_premium' => 52000,
            'harga_bucket' => 0,
            'harga_kilo' => 0,
            'status_premium' => true,
            'status_bucket' => false,
            'status_kilo' => false,
            'beban_produksi' => '2.0',
            'status_item' => true,
        ]);

        JenisItem::create([
            'nama' => 'DASI',
            'kategori_id' => 1,
            'unit' => 'PCS',
            'bobot_bucket' => 0.0,
            'harga_premium' => 18000,
            'harga_bucket' => 0,
            'harga_kilo' => 0,
            'status_premium' => true,
            'status_bucket' => false,
            'status_kilo' => false,
            'beban_produksi' => '1.0',
            'status_item' => true,
        ]);

        JenisItem::create([
            'nama' => 'DEKER /BIJI',
            'kategori_id' => 1,
            'unit' => 'PCS',
            'bobot_bucket' => 0.0,
            'harga_premium' => 8000,
            'harga_bucket' => 0,
            'harga_kilo' => 0,
            'status_premium' => true,
            'status_bucket' => false,
            'status_kilo' => false,
            'beban_produksi' => '1.0',
            'status_item' => true,
        ]);

        JenisItem::create([
            'nama' => 'DEKER KAKI',
            'kategori_id' => 1,
            'unit' => 'PCS',
            'bobot_bucket' => 0.0,
            'harga_premium' => 20000,
            'harga_bucket' => 0,
            'harga_kilo' => 0,
            'status_premium' => true,
            'status_bucket' => false,
            'status_kilo' => false,
            'beban_produksi' => '2.0',
            'status_item' => true,
        ]);

        JenisItem::create([
            'nama' => 'DOMPET PESTA',
            'kategori_id' => 18,
            'unit' => 'PCS',
            'bobot_bucket' => 0.0,
            'harga_premium' => 85000,
            'harga_bucket' => 0,
            'harga_kilo' => 0,
            'status_premium' => true,
            'status_bucket' => false,
            'status_kilo' => false,
            'beban_produksi' => '4.0',
            'status_item' => true,
        ]);

        JenisItem::create([
            'nama' => 'DOMPET WANITA',
            'kategori_id' => 18,
            'unit' => 'PCS',
            'bobot_bucket' => 0.0,
            'harga_premium' => 30000,
            'harga_bucket' => 0,
            'harga_kilo' => 0,
            'status_premium' => true,
            'status_bucket' => false,
            'status_kilo' => false,
            'beban_produksi' => '5.0',
            'status_item' => true,
        ]);

        JenisItem::create([
            'nama' => 'DUDUKAN STROLLER',
            'kategori_id' => 15,
            'unit' => 'PCS',
            'bobot_bucket' => 0.0,
            'harga_premium' => 30000,
            'harga_bucket' => 0,
            'harga_kilo' => 0,
            'status_premium' => true,
            'status_bucket' => false,
            'status_kilo' => false,
            'beban_produksi' => '7.0',
            'status_item' => true,
        ]);

        JenisItem::create([
            'nama' => 'GAUN PENGANTIN',
            'kategori_id' => 14,
            'unit' => 'PCS',
            'bobot_bucket' => 0.0,
            'harga_premium' => 290000,
            'harga_bucket' => 0,
            'harga_kilo' => 0,
            'status_premium' => true,
            'status_bucket' => false,
            'status_kilo' => false,
            'beban_produksi' => '50.0',
            'status_item' => true,
        ]);

        JenisItem::create([
            'nama' => 'GAUN PENGANTIN EKOR',
            'kategori_id' => 14,
            'unit' => 'PCS',
            'bobot_bucket' => 0.0,
            'harga_premium' => 380000,
            'harga_bucket' => 0,
            'harga_kilo' => 0,
            'status_premium' => true,
            'status_bucket' => false,
            'status_kilo' => false,
            'beban_produksi' => '60.0',
            'status_item' => true,
        ]);

        JenisItem::create([
            'nama' => 'GAUN PESTA ANAK',
            'kategori_id' => 14,
            'unit' => 'PCS',
            'bobot_bucket' => 0.0,
            'harga_premium' => 42000,
            'harga_bucket' => 0,
            'harga_kilo' => 0,
            'status_premium' => true,
            'status_bucket' => false,
            'status_kilo' => false,
            'beban_produksi' => '7.0',
            'status_item' => true,
        ]);

        JenisItem::create([
            'nama' => 'GAUN PESTA BESAR',
            'kategori_id' => 14,
            'unit' => 'PCS',
            'bobot_bucket' => 0.0,
            'harga_premium' => 110000,
            'harga_bucket' => 0,
            'harga_kilo' => 0,
            'status_premium' => true,
            'status_bucket' => false,
            'status_kilo' => false,
            'beban_produksi' => '15.0',
            'status_item' => true,
        ]);

        JenisItem::create([
            'nama' => 'GAUN PESTA PANJANG',
            'kategori_id' => 14,
            'unit' => 'PCS',
            'bobot_bucket' => 0.0,
            'harga_premium' => 75000,
            'harga_bucket' => 0,
            'harga_kilo' => 0,
            'status_premium' => true,
            'status_bucket' => false,
            'status_kilo' => false,
            'beban_produksi' => 0.0,
            'status_item' => false,
        ]);

        JenisItem::create([
            'nama' => 'GAUN PESTA STANDAR',
            'kategori_id' => 14,
            'unit' => 'PCS',
            'bobot_bucket' => 0.0,
            'harga_premium' => 80000,
            'harga_bucket' => 0,
            'harga_kilo' => 0,
            'status_premium' => true,
            'status_bucket' => false,
            'status_kilo' => false,
            'beban_produksi' => '10.0',
            'status_item' => true,
        ]);

        JenisItem::create([
            'nama' => 'GENDONGAN BAYI',
            'kategori_id' => 15,
            'unit' => 'PCS',
            'bobot_bucket' => 0.0,
            'harga_premium' => 45000,
            'harga_bucket' => 0,
            'harga_kilo' => 0,
            'status_premium' => true,
            'status_bucket' => false,
            'status_kilo' => false,
            'beban_produksi' => '5.0',
            'status_item' => true,
        ]);

        JenisItem::create([
            'nama' => 'GORDYN TEBAL(/M2)',
            'kategori_id' => 3,
            'unit' => 'MTR',
            'bobot_bucket' => 0.0,
            'harga_premium' => 18000,
            'harga_bucket' => 0,
            'harga_kilo' => 0,
            'status_premium' => true,
            'status_bucket' => false,
            'status_kilo' => false,
            'beban_produksi' => '10.0',
            'status_item' => true,
        ]);

        JenisItem::create([
            'nama' => 'GORDYN TIPIS/VITRAGE (/M2)',
            'kategori_id' => 3,
            'unit' => 'MTR',
            'bobot_bucket' => 0.0,
            'harga_premium' => 16000,
            'harga_bucket' => 0,
            'harga_kilo' => 0,
            'status_premium' => true,
            'status_bucket' => false,
            'status_kilo' => false,
            'beban_produksi' => '20.0',
            'status_item' => true,
        ]);

        JenisItem::create([
            'nama' => 'GULING',
            'kategori_id' => 9,
            'unit' => 'PCS',
            'bobot_bucket' => 0.0,
            'harga_premium' => 40000,
            'harga_bucket' => 0,
            'harga_kilo' => 0,
            'status_premium' => true,
            'status_bucket' => false,
            'status_kilo' => false,
            'beban_produksi' => '20.0',
            'status_item' => true,
        ]);

        JenisItem::create([
            'nama' => 'HANDUK',
            'kategori_id' => 3,
            'unit' => 'PCS',
            'bobot_bucket' => 0.0,
            'harga_premium' => 25000,
            'harga_bucket' => 0,
            'harga_kilo' => 0,
            'status_premium' => true,
            'status_bucket' => false,
            'status_kilo' => false,
            'beban_produksi' => '5.0',
            'status_item' => true,
        ]);

        JenisItem::create([
            'nama' => 'HANDUK BAJU',
            'kategori_id' => 3,
            'unit' => 'PCS',
            'bobot_bucket' => 0.0,
            'harga_premium' => 38000,
            'harga_bucket' => 0,
            'harga_kilo' => 0,
            'status_premium' => true,
            'status_bucket' => false,
            'status_kilo' => false,
            'beban_produksi' => '7.0',
            'status_item' => true,
        ]);

        JenisItem::create([
            'nama' => 'HELM RACING',
            'kategori_id' => 1,
            'unit' => 'PCS',
            'bobot_bucket' => 0.0,
            'harga_premium' => 48000,
            'harga_bucket' => 0,
            'harga_kilo' => 0,
            'status_premium' => true,
            'status_bucket' => false,
            'status_kilo' => false,
            'beban_produksi' => '10.0',
            'status_item' => true,
        ]);

        JenisItem::create([
            'nama' => 'HIPOXI HANDUK BESAR',
            'kategori_id' => 11,
            'unit' => 'PCS',
            'bobot_bucket' => 0.0,
            'harga_premium' => 1650,
            'harga_bucket' => 0,
            'harga_kilo' => 0,
            'status_premium' => true,
            'status_bucket' => false,
            'status_kilo' => false,
            'beban_produksi' => 0.0,
            'status_item' => true,
        ]);

        JenisItem::create([
            'nama' => 'HIPOXI HANDUK KECIL',
            'kategori_id' => 11,
            'unit' => 'PCS',
            'bobot_bucket' => 0.0,
            'harga_premium' => 1350,
            'harga_bucket' => 0,
            'harga_kilo' => 0,
            'status_premium' => true,
            'status_bucket' => false,
            'status_kilo' => false,
            'beban_produksi' => 0.0,
            'status_item' => true,
        ]);

        JenisItem::create([
            'nama' => 'HoL Gaun panjang',
            'kategori_id' => 11,
            'unit' => 'PCS',
            'bobot_bucket' => 0.0,
            'harga_premium' => 20000,
            'harga_bucket' => 0,
            'harga_kilo' => 0,
            'status_premium' => true,
            'status_bucket' => false,
            'status_kilo' => false,
            'beban_produksi' => 0.0,
            'status_item' => false,
        ]);

        JenisItem::create([
            'nama' => 'HoL GAUN PENGANTIN+SLAYER',
            'kategori_id' => 11,
            'unit' => 'PCS',
            'bobot_bucket' => '0.0',
            'harga_premium' => 220000,
            'harga_bucket' => 0,
            'harga_kilo' => 0,
            'status_premium' => true,
            'status_bucket' => false,
            'status_kilo' => false,
            'beban_produksi' => '0.0',
            'status_item' => true,
        ]);

        JenisItem::create([
            'nama' => 'HoL GAUN PESTA PANJANG',
            'kategori_id' => 11,
            'unit' => 'PCS',
            'bobot_bucket' => '0.0',
            'harga_premium' => 95000,
            'harga_bucket' => 0,
            'harga_kilo' => 0,
            'status_premium' => true,
            'status_bucket' => false,
            'status_kilo' => false,
            'beban_produksi' => '0.0',
            'status_item' => true,
        ]);

        JenisItem::create([
            'nama' => 'HoL GAUN PESTA PENDEK',
            'kategori_id' => 11,
            'unit' => 'PCS',
            'bobot_bucket' => '0.0',
            'harga_premium' => 75000,
            'harga_bucket' => 0,
            'harga_kilo' => 0,
            'status_premium' => true,
            'status_bucket' => false,
            'status_kilo' => false,
            'beban_produksi' => '0.0',
            'status_item' => true,
        ]);

        JenisItem::create([
            'nama' => 'HoL SET KEBAYA LENGKAP',
            'kategori_id' => 11,
            'unit' => 'PCS',
            'bobot_bucket' => '0.0',
            'harga_premium' => 50000,
            'harga_bucket' => 0,
            'harga_kilo' => 0,
            'status_premium' => true,
            'status_bucket' => false,
            'status_kilo' => false,
            'beban_produksi' => '0.0',
            'status_item' => true,
        ]);

        JenisItem::create([
            'nama' => 'HoL(8<) GAUN PESTA',
            'kategori_id' => 11,
            'unit' => 'PCS',
            'bobot_bucket' => '0.0',
            'harga_premium' => 45000,
            'harga_bucket' => 0,
            'harga_kilo' => 0,
            'status_premium' => true,
            'status_bucket' => false,
            'status_kilo' => false,
            'beban_produksi' => '0.0',
            'status_item' => false,
        ]);

        JenisItem::create([
            'nama' => 'JAKET  KULIT',
            'kategori_id' => 5,
            'unit' => 'PCS',
            'bobot_bucket' => '0.0',
            'harga_premium' => 135000,
            'harga_bucket' => 0,
            'harga_kilo' => 0,
            'status_premium' => true,
            'status_bucket' => false,
            'status_kilo' => false,
            'beban_produksi' => '25.0',
            'status_item' => true,
        ]);

        JenisItem::create([
            'nama' => 'JAKET ANAK',
            'kategori_id' => 4,
            'unit' => 'PCS',
            'bobot_bucket' => '0.0',
            'harga_premium' => 25000,
            'harga_bucket' => 0,
            'harga_kilo' => 0,
            'status_premium' => true,
            'status_bucket' => false,
            'status_kilo' => false,
            'beban_produksi' => '10.0',
            'status_item' => true,
        ]);

        JenisItem::create([
            'nama' => 'JAKET BULU MUSIM DINGIN',
            'kategori_id' => 4,
            'unit' => 'PCS',
            'bobot_bucket' => '0.0',
            'harga_premium' => 68000,
            'harga_bucket' => 0,
            'harga_kilo' => 0,
            'status_premium' => true,
            'status_bucket' => false,
            'status_kilo' => false,
            'beban_produksi' => '15.0',
            'status_item' => true,
        ]);

        JenisItem::create([
            'nama' => 'JAKET KAIN / JEANS',
            'kategori_id' => 4,
            'unit' => 'PCS',
            'bobot_bucket' => '0.0',
            'harga_premium' => 40000,
            'harga_bucket' => 0,
            'harga_kilo' => 0,
            'status_premium' => true,
            'status_bucket' => false,
            'status_kilo' => false,
            'beban_produksi' => '5.0',
            'status_item' => true,
        ]);

        JenisItem::create([
            'nama' => 'JAKET MUSIM DINGIN ANAK',
            'kategori_id' => 4,
            'unit' => 'PCS',
            'bobot_bucket' => '0.0',
            'harga_premium' => 37000,
            'harga_bucket' => 0,
            'harga_kilo' => 0,
            'status_premium' => true,
            'status_bucket' => false,
            'status_kilo' => false,
            'beban_produksi' => '5.0',
            'status_item' => true,
        ]);

        JenisItem::create([
            'nama' => 'JAKET MUSIM DINGIN PANJANG',
            'kategori_id' => 4,
            'unit' => 'PCS',
            'bobot_bucket' => '0.0',
            'harga_premium' => 120000,
            'harga_bucket' => 0,
            'harga_kilo' => 0,
            'status_premium' => true,
            'status_bucket' => false,
            'status_kilo' => false,
            'beban_produksi' => '1.0',
            'status_item' => true,
        ]);

        JenisItem::create([
            'nama' => 'JAKET MUSIM DINGIN PENDEK',
            'kategori_id' => 4,
            'unit' => 'PCS',
            'bobot_bucket' => '0.0',
            'harga_premium' => 65000,
            'harga_bucket' => 0,
            'harga_kilo' => 0,
            'status_premium' => true,
            'status_bucket' => false,
            'status_kilo' => false,
            'beban_produksi' => '1.0',
            'status_item' => true,
        ]);

        JenisItem::create([
            'nama' => 'JAKET PANJANG/ LONGCOAT',
            'kategori_id' => 4,
            'unit' => 'PCS',
            'bobot_bucket' => '0.0',
            'harga_premium' => 85000,
            'harga_bucket' => 0,
            'harga_kilo' => 0,
            'status_premium' => true,
            'status_bucket' => false,
            'status_kilo' => false,
            'beban_produksi' => '15.0',
            'status_item' => true,
        ]);

        JenisItem::create([
            'nama' => 'JAS ANAK',
            'kategori_id' => 4,
            'unit' => 'PCS',
            'bobot_bucket' => '0.0',
            'harga_premium' => 25000,
            'harga_bucket' => 0,
            'harga_kilo' => 0,
            'status_premium' => true,
            'status_bucket' => false,
            'status_kilo' => false,
            'beban_produksi' => '7.0',
            'status_item' => true,
        ]);

        JenisItem::create([
            'nama' => 'JAS HUJAN',
            'kategori_id' => 3,
            'unit' => 'PCS',
            'bobot_bucket' => '0.0',
            'harga_premium' => 32000,
            'harga_bucket' => 0,
            'harga_kilo' => 0,
            'status_premium' => true,
            'status_bucket' => false,
            'status_kilo' => false,
            'beban_produksi' => '7.0',
            'status_item' => true,
        ]);

        JenisItem::create([
            'nama' => 'JAS LAB',
            'kategori_id' => 4,
            'unit' => 'PCS',
            'bobot_bucket' => '0.0',
            'harga_premium' => 45000,
            'harga_bucket' => 0,
            'harga_kilo' => 0,
            'status_premium' => true,
            'status_bucket' => false,
            'status_kilo' => false,
            'beban_produksi' => '10.0',
            'status_item' => true,
        ]);

        JenisItem::create([
            'nama' => 'JAS MANDI HANDUK',
            'kategori_id' => 4,
            'unit' => 'PCS',
            'bobot_bucket' => '0.0',
            'harga_premium' => 32500,
            'harga_bucket' => 0,
            'harga_kilo' => 0,
            'status_premium' => true,
            'status_bucket' => false,
            'status_kilo' => false,
            'beban_produksi' => '8.0',
            'status_item' => true,
        ]);

        JenisItem::create([
            'nama' => 'JILBAB',
            'kategori_id' => 6,
            'unit' => 'PCS',
            'bobot_bucket' => '0.0',
            'harga_premium' => 13000,
            'harga_bucket' => 0,
            'harga_kilo' => 0,
            'status_premium' => true,
            'status_bucket' => false,
            'status_kilo' => false,
            'beban_produksi' => '0.0',
            'status_item' => false,
        ]);

        JenisItem::create([
            'nama' => 'JUBAH TOGA',
            'kategori_id' => 14,
            'unit' => 'PCS',
            'bobot_bucket' => '0.0',
            'harga_premium' => 50000,
            'harga_bucket' => 0,
            'harga_kilo' => 0,
            'status_premium' => true,
            'status_bucket' => false,
            'status_kilo' => false,
            'beban_produksi' => '5.0',
            'status_item' => true,
        ]);

        JenisItem::create([
            'nama' => 'JUMPSUIT',
            'kategori_id' => 14,
            'unit' => 'PCS',
            'bobot_bucket' => '0.0',
            'harga_premium' => 45000,
            'harga_bucket' => 0,
            'harga_kilo' => 0,
            'status_premium' => true,
            'status_bucket' => false,
            'status_kilo' => false,
            'beban_produksi' => '5.0',
            'status_item' => true,
        ]);

        JenisItem::create([
            'nama' => 'JUMPSUIT ANAK',
            'kategori_id' => 14,
            'unit' => 'PCS',
            'bobot_bucket' => '0.0',
            'harga_premium' => 38000,
            'harga_bucket' => 0,
            'harga_kilo' => 0,
            'status_premium' => true,
            'status_bucket' => false,
            'status_kilo' => false,
            'beban_produksi' => '3.0',
            'status_item' => true,
        ]);

        JenisItem::create([
            'nama' => 'KAIN JARIT',
            'kategori_id' => 8,
            'unit' => 'PCS',
            'bobot_bucket' => '0.0',
            'harga_premium' => 52000,
            'harga_bucket' => 0,
            'harga_kilo' => 0,
            'status_premium' => true,
            'status_bucket' => false,
            'status_kilo' => false,
            'beban_produksi' => '10.0',
            'status_item' => true,
        ]);

        JenisItem::create([
            'nama' => 'KAOS DALAM ANAK',
            'kategori_id' => 4,
            'unit' => 'PCS',
            'bobot_bucket' => '0.0',
            'harga_premium' => 15000,
            'harga_bucket' => 0,
            'harga_kilo' => 0,
            'status_premium' => true,
            'status_bucket' => false,
            'status_kilo' => false,
            'beban_produksi' => '2.0',
            'status_item' => true,
        ]);

        JenisItem::create([
            'nama' => 'KAOS KAKI',
            'kategori_id' => 1,
            'unit' => 'PCS',
            'bobot_bucket' => '0.5',
            'harga_premium' => 15000,
            'harga_bucket' => 0,
            'harga_kilo' => 0,
            'status_premium' => true,
            'status_bucket' => true,
            'status_kilo' => false,
            'beban_produksi' => '2.0',
            'status_item' => true,
        ]);

        JenisItem::create([
            'nama' => 'KAOS KAKI ANAK',
            'kategori_id' => 1,
            'unit' => 'PCS',
            'bobot_bucket' => '0.0',
            'harga_premium' => 13000,
            'harga_bucket' => 0,
            'harga_kilo' => 0,
            'status_premium' => true,
            'status_bucket' => false,
            'status_kilo' => false,
            'beban_produksi' => '0.5',
            'status_item' => true,
        ]);

        JenisItem::create([
            'nama' => 'KARPET HIAS',
            'kategori_id' => 3,
            'unit' => 'PCS',
            'bobot_bucket' => '0.0',
            'harga_premium' => 50000,
            'harga_bucket' => 0,
            'harga_kilo' => 0,
            'status_premium' => true,
            'status_bucket' => false,
            'status_kilo' => false,
            'beban_produksi' => '15.0',
            'status_item' => true,
        ]);

        JenisItem::create([
            'nama' => 'KARPET MOBIL / PCS',
            'kategori_id' => 2,
            'unit' => 'PCS',
            'bobot_bucket' => '0.0',
            'harga_premium' => 35000,
            'harga_bucket' => 0,
            'harga_kilo' => 0,
            'status_premium' => true,
            'status_bucket' => false,
            'status_kilo' => false,
            'beban_produksi' => '10.0',
            'status_item' => true,
        ]);

        JenisItem::create([
            'nama' => 'KARPET SPESIAL(2M>)',
            'kategori_id' => 3,
            'unit' => 'PCS',
            'bobot_bucket' => '0.0',
            'harga_premium' => 120000,
            'harga_bucket' => 0,
            'harga_kilo' => 0,
            'status_premium' => true,
            'status_bucket' => false,
            'status_kilo' => false,
            'beban_produksi' => '25.0',
            'status_item' => true,
        ]);

        JenisItem::create([
            'nama' => 'KARPET TEBAL (/ M2)',
            'kategori_id' => 3,
            'unit' => 'MTR',
            'bobot_bucket' => '0.0',
            'harga_premium' => 35000,
            'harga_bucket' => 0,
            'harga_kilo' => 0,
            'status_premium' => true,
            'status_bucket' => false,
            'status_kilo' => false,
            'beban_produksi' => '20.0',
            'status_item' => true,
        ]);

        JenisItem::create([
            'nama' => 'KARPET TIPIS (/ M2)',
            'kategori_id' => 3,
            'unit' => 'MTR',
            'bobot_bucket' => '0.0',
            'harga_premium' => 30000,
            'harga_bucket' => 0,
            'harga_kilo' => 0,
            'status_premium' => true,
            'status_bucket' => false,
            'status_kilo' => false,
            'beban_produksi' => '15.0',
            'status_item' => true,
        ]);

        JenisItem::create([
            'nama' => 'KARTU MEMBER',
            'kategori_id' => 13,
            'unit' => 'PCS',
            'bobot_bucket' => '0.0',
            'harga_premium' => 30000,
            'harga_bucket' => 0,
            'harga_kilo' => 0,
            'status_premium' => true,
            'status_bucket' => false,
            'status_kilo' => false,
            'beban_produksi' => '0.0',
            'status_item' => true,
        ]);

        JenisItem::create([
            'nama' => 'KASUR / MATRAS PANTAI',
            'kategori_id' => 3,
            'unit' => 'PCS',
            'bobot_bucket' => '0.0',
            'harga_premium' => 100000,
            'harga_bucket' => 0,
            'harga_kilo' => 0,
            'status_premium' => true,
            'status_bucket' => false,
            'status_kilo' => false,
            'beban_produksi' => '20.0',
            'status_item' => true,
        ]);

        JenisItem::create([
            'nama' => 'KASUR BOX BAYI',
            'kategori_id' => 15,
            'unit' => 'PCS',
            'bobot_bucket' => '0.0',
            'harga_premium' => 150000,
            'harga_bucket' => 0,
            'harga_kilo' => 0,
            'status_premium' => true,
            'status_bucket' => false,
            'status_kilo' => false,
            'beban_produksi' => '25.0',
            'status_item' => true,
        ]);

        JenisItem::create([
            'nama' => 'KEBAYA',
            'kategori_id' => 4,
            'unit' => 'PCS',
            'bobot_bucket' => '0.0',
            'harga_premium' => 45000,
            'harga_bucket' => 0,
            'harga_kilo' => 0,
            'status_premium' => true,
            'status_bucket' => false,
            'status_kilo' => false,
            'beban_produksi' => '7.0',
            'status_item' => true,
        ]);

        JenisItem::create([
            'nama' => 'KEBAYA PANJANG',
            'kategori_id' => 4,
            'unit' => 'PCS',
            'bobot_bucket' => '0.0',
            'harga_premium' => 50000,
            'harga_bucket' => 0,
            'harga_kilo' => 0,
            'status_premium' => true,
            'status_bucket' => false,
            'status_kilo' => false,
            'beban_produksi' => '10.0',
            'status_item' => true,
        ]);

        JenisItem::create([
            'nama' => 'KEBAYA TERUSAN',
            'kategori_id' => 4,
            'unit' => 'PCS',
            'bobot_bucket' => '0.0',
            'harga_premium' => 65000,
            'harga_bucket' => 0,
            'harga_kilo' => 0,
            'status_premium' => true,
            'status_bucket' => false,
            'status_kilo' => false,
            'beban_produksi' => '10.0',
            'status_item' => true,
        ]);

        JenisItem::create([
            'nama' => 'KEMBEN PESTA',
            'kategori_id' => 4,
            'unit' => 'PCS',
            'bobot_bucket' => '0.0',
            'harga_premium' => 35000,
            'harga_bucket' => 0,
            'harga_kilo' => 0,
            'status_premium' => true,
            'status_bucket' => false,
            'status_kilo' => false,
            'beban_produksi' => '5.0',
            'status_item' => true,
        ]);

        JenisItem::create([
            'nama' => 'KEMEJA',
            'kategori_id' => 4,
            'unit' => 'PCS',
            'bobot_bucket' => '1.0',
            'harga_premium' => 30000,
            'harga_bucket' => 0,
            'harga_kilo' => 0,
            'status_premium' => true,
            'status_bucket' => true,
            'status_kilo' => false,
            'beban_produksi' => '10.0',
            'status_item' => true,
        ]);

        JenisItem::create([
            'nama' => 'KEMEJA ANAK',
            'kategori_id' => 4,
            'unit' => 'PCS',
            'bobot_bucket' => '0.0',
            'harga_premium' => 20000,
            'harga_bucket' => 0,
            'harga_kilo' => 0,
            'status_premium' => true,
            'status_bucket' => false,
            'status_kilo' => false,
            'beban_produksi' => '3.0',
            'status_item' => true,
        ]);

        JenisItem::create([
            'nama' => 'KEMEJA BATIK',
            'kategori_id' => 4,
            'unit' => 'PCS',
            'bobot_bucket' => '0.0',
            'harga_premium' => 40000,
            'harga_bucket' => 0,
            'harga_kilo' => 0,
            'status_premium' => true,
            'status_bucket' => false,
            'status_kilo' => false,
            'beban_produksi' => '5.0',
            'status_item' => true,
        ]);

        JenisItem::create([
            'nama' => 'KEMEJA BATIK SUTRA',
            'kategori_id' => 4,
            'unit' => 'PCS',
            'bobot_bucket' => '0.0',
            'harga_premium' => 45000,
            'harga_bucket' => 0,
            'harga_kilo' => 0,
            'status_premium' => true,
            'status_bucket' => false,
            'status_kilo' => false,
            'beban_produksi' => '7.0',
            'status_item' => true,
        ]);

        JenisItem::create([
            'nama' => 'KEMEJA SAFARI',
            'kategori_id' => 4,
            'unit' => 'PCS',
            'bobot_bucket' => '0.0',
            'harga_premium' => 45000,
            'harga_bucket' => 0,
            'harga_kilo' => 0,
            'status_premium' => true,
            'status_bucket' => false,
            'status_kilo' => false,
            'beban_produksi' => '5.0',
            'status_item' => true,
        ]);

        JenisItem::create([
            'nama' => 'KERAH',
            'kategori_id' => 4,
            'unit' => 'PCS',
            'bobot_bucket' => '1.0',
            'harga_premium' => 25000,
            'harga_bucket' => 0,
            'harga_kilo' => 0,
            'status_premium' => true,
            'status_bucket' => true,
            'status_kilo' => false,
            'beban_produksi' => '5.0',
            'status_item' => true,
        ]);

        JenisItem::create([
            'nama' => 'KERUDUNG/JILBAB',
            'kategori_id' => 6,
            'unit' => 'PCS',
            'bobot_bucket' => '0.0',
            'harga_premium' => 20000,
            'harga_bucket' => 0,
            'harga_kilo' => 0,
            'status_premium' => true,
            'status_bucket' => false,
            'status_kilo' => false,
            'beban_produksi' => '3.0',
            'status_item' => true,
        ]);

        JenisItem::create([
            'nama' => 'KESET',
            'kategori_id' => 3,
            'unit' => 'PCS',
            'bobot_bucket' => '0.0',
            'harga_premium' => 30000,
            'harga_bucket' => 0,
            'harga_kilo' => 0,
            'status_premium' => true,
            'status_bucket' => false,
            'status_kilo' => false,
            'beban_produksi' => '10.0',
            'status_item' => true,
        ]);

        JenisItem::create([
            'nama' => 'KIMONO',
            'kategori_id' => 10,
            'unit' => 'PCS',
            'bobot_bucket' => '2.0',
            'harga_premium' => 0,
            'harga_bucket' => 0,
            'harga_kilo' => 0,
            'status_premium' => false,
            'status_bucket' => true,
            'status_kilo' => false,
            'beban_produksi' => '0.0',
            'status_item' => true,
        ]);

        JenisItem::create([
            'nama' => 'KURSI',
            'kategori_id' => 3,
            'unit' => 'PCS',
            'bobot_bucket' => '0.0',
            'harga_premium' => 40000,
            'harga_bucket' => 0,
            'harga_kilo' => 0,
            'status_premium' => true,
            'status_bucket' => false,
            'status_kilo' => false,
            'beban_produksi' => '3.0',
            'status_item' => true,
        ]);

        JenisItem::create([
            'nama' => 'LEA(2-3) GAUN PESTA',
            'kategori_id' => 11,
            'unit' => 'PCS',
            'bobot_bucket' => '0.0',
            'harga_premium' => 60000,
            'harga_bucket' => 0,
            'harga_kilo' => 0,
            'status_premium' => true,
            'status_bucket' => false,
            'status_kilo' => false,
            'beban_produksi' => '10.0',
            'status_item' => true,
        ]);

        JenisItem::create([
            'nama' => 'LONG DRESS',
            'kategori_id' => 14,
            'unit' => 'PCS',
            'bobot_bucket' => '0.0',
            'harga_premium' => 55000,
            'harga_bucket' => 0,
            'harga_kilo' => 0,
            'status_premium' => true,
            'status_bucket' => false,
            'status_kilo' => false,
            'beban_produksi' => '10.0',
            'status_item' => true,
        ]);

        JenisItem::create([
            'nama' => 'LUMBA HANDUK',
            'kategori_id' => 11,
            'unit' => 'PCS',
            'bobot_bucket' => '0.0',
            'harga_premium' => 3500,
            'harga_bucket' => 0,
            'harga_kilo' => 0,
            'status_premium' => true,
            'status_bucket' => false,
            'status_kilo' => false,
            'beban_produksi' => '0.0',
            'status_item' => false,
        ]);

        JenisItem::create([
            'nama' => 'LUMBA KESET',
            'kategori_id' => 11,
            'unit' => 'PCS',
            'bobot_bucket' => '0.0',
            'harga_premium' => 2500,
            'harga_bucket' => 0,
            'harga_kilo' => 0,
            'status_premium' => true,
            'status_bucket' => false,
            'status_kilo' => false,
            'beban_produksi' => '0.0',
            'status_item' => false,
        ]);

        JenisItem::create([
            'nama' => 'LUMBA SEPREI LARGE',
            'kategori_id' => 11,
            'unit' => 'PCS',
            'bobot_bucket' => '0.0',
            'harga_premium' => 12000,
            'harga_bucket' => 0,
            'harga_kilo' => 0,
            'status_premium' => true,
            'status_bucket' => false,
            'status_kilo' => false,
            'beban_produksi' => '0.0',
            'status_item' => false,
        ]);

        JenisItem::create([
            'nama' => 'LUMBA SEPREI SINGLE',
            'kategori_id' => 11,
            'unit' => 'PCS',
            'bobot_bucket' => '0.0',
            'harga_premium' => 10000,
            'harga_bucket' => 0,
            'harga_kilo' => 0,
            'status_premium' => true,
            'status_bucket' => false,
            'status_kilo' => false,
            'beban_produksi' => '0.0',
            'status_item' => false,
        ]);

        JenisItem::create([
            'nama' => 'LUMBA2 SET BESAR (1BC,1SPR,2SB,2SG,2HANDUK,1KEST)',
            'kategori_id' => 11,
            'unit' => 'PCS',
            'bobot_bucket' => '0.0',
            'harga_premium' => 49000,
            'harga_bucket' => 0,
            'harga_kilo' => 0,
            'status_premium' => true,
            'status_bucket' => false,
            'status_kilo' => false,
            'beban_produksi' => '0.0',
            'status_item' => false,
        ]);

        JenisItem::create([
            'nama' => 'LUMBA2 SET KECIL(2BC,2SPR,2SB,2HANDUK,1KESET)',
            'kategori_id' => 11,
            'unit' => 'PCS',
            'bobot_bucket' => '0.0',
            'harga_premium' => 65000,
            'harga_bucket' => 0,
            'harga_kilo' => 0,
            'status_premium' => true,
            'status_bucket' => false,
            'status_kilo' => false,
            'beban_produksi' => '10.0',
            'status_item' => true,
        ]);

        JenisItem::create([
            'nama' => 'MATRAS KASUR',
            'kategori_id' => 9,
            'unit' => 'PCS',
            'bobot_bucket' => '0.0',
            'harga_premium' => 55000,
            'harga_bucket' => 0,
            'harga_kilo' => 0,
            'status_premium' => true,
            'status_bucket' => false,
            'status_kilo' => false,
            'beban_produksi' => '10.0',
            'status_item' => true,
        ]);

        JenisItem::create([
            'nama' => 'MATRAS YOGA',
            'kategori_id' => 3,
            'unit' => 'PCS',
            'bobot_bucket' => '0.0',
            'harga_premium' => 60000,
            'harga_bucket' => 0,
            'harga_kilo' => 0,
            'status_premium' => true,
            'status_bucket' => false,
            'status_kilo' => false,
            'beban_produksi' => '10.0',
            'status_item' => true,
        ]);

        JenisItem::create([
            'nama' => 'MUKENAH ATASAN',
            'kategori_id' => 6,
            'unit' => 'PCS',
            'bobot_bucket' => '0.0',
            'harga_premium' => 35000,
            'harga_bucket' => 0,
            'harga_kilo' => 0,
            'status_premium' => true,
            'status_bucket' => false,
            'status_kilo' => false,
            'beban_produksi' => '5.0',
            'status_item' => true,
        ]);

        JenisItem::create([
            'nama' => 'MUKENAH TERUSAN',
            'kategori_id' => 6,
            'unit' => 'PCS',
            'bobot_bucket' => '0.0',
            'harga_premium' => 45000,
            'harga_bucket' => 0,
            'harga_kilo' => 0,
            'status_premium' => true,
            'status_bucket' => false,
            'status_kilo' => false,
            'beban_produksi' => '8.0',
            'status_item' => true,
        ]);

        JenisItem::create([
            'nama' => 'PAKET SSC',
            'kategori_id' => 11,
            'unit' => 'PCS',
            'bobot_bucket' => '0.0',
            'harga_premium' => 40000,
            'harga_bucket' => 0,
            'harga_kilo' => 0,
            'status_premium' => true,
            'status_bucket' => false,
            'status_kilo' => false,
            'beban_produksi' => '10.0',
            'status_item' => true,
        ]);

        JenisItem::create([
            'nama' => 'PEMBATAS KASUR',
            'kategori_id' => 9,
            'unit' => 'PCS',
            'bobot_bucket' => '0.0',
            'harga_premium' => 48000,
            'harga_bucket' => 0,
            'harga_kilo' => 0,
            'status_premium' => true,
            'status_bucket' => false,
            'status_kilo' => false,
            'beban_produksi' => '5.0',
            'status_item' => true,
        ]);

        JenisItem::create([
            'nama' => 'PENUTUP GALON/TV/KULKAS',
            'kategori_id' => 3,
            'unit' => 'PCS',
            'bobot_bucket' => '0.0',
            'harga_premium' => 30000,
            'harga_bucket' => 0,
            'harga_kilo' => 0,
            'status_premium' => true,
            'status_bucket' => false,
            'status_kilo' => false,
            'beban_produksi' => '5.0',
            'status_item' => true,
        ]);

        JenisItem::create([
            'nama' => 'PENUTUP MOBIL',
            'kategori_id' => 2,
            'unit' => 'PCS',
            'bobot_bucket' => '0.0',
            'harga_premium' => 100000,
            'harga_bucket' => 0,
            'harga_kilo' => 0,
            'status_premium' => true,
            'status_bucket' => false,
            'status_kilo' => false,
            'beban_produksi' => '20.0',
            'status_item' => true,
        ]);

        JenisItem::create([
            'nama' => 'PETIKOT',
            'kategori_id' => 14,
            'unit' => 'PCS',
            'bobot_bucket' => '0.0',
            'harga_premium' => 55000,
            'harga_bucket' => 0,
            'harga_kilo' => 0,
            'status_premium' => true,
            'status_bucket' => false,
            'status_kilo' => false,
            'beban_produksi' => '15.0',
            'status_item' => true,
        ]);

        JenisItem::create([
            'nama' => 'PLRS BATH MAT',
            'kategori_id' => 11,
            'unit' => 'PCS',
            'bobot_bucket' => '0.0',
            'harga_premium' => 3000,
            'harga_bucket' => 0,
            'harga_kilo' => 0,
            'status_premium' => true,
            'status_bucket' => false,
            'status_kilo' => false,
            'beban_produksi' => '0.0',
            'status_item' => false,
        ]);

        JenisItem::create([
            'nama' => 'PLRS CELANA PJG',
            'kategori_id' => 11,
            'unit' => 'PCS',
            'bobot_bucket' => '0.0',
            'harga_premium' => 1850,
            'harga_bucket' => 0,
            'harga_kilo' => 0,
            'status_premium' => true,
            'status_bucket' => false,
            'status_kilo' => false,
            'beban_produksi' => '0.0',
            'status_item' => false,
        ]);

        JenisItem::create([
            'nama' => 'PLRS CLN.PENDEK',
            'kategori_id' => 11,
            'unit' => 'PCS',
            'bobot_bucket' => '0.0',
            'harga_premium' => 1500,
            'harga_bucket' => 0,
            'harga_kilo' => 0,
            'status_premium' => true,
            'status_bucket' => false,
            'status_kilo' => false,
            'beban_produksi' => '0.0',
            'status_item' => false,
        ]);

        JenisItem::create([
            'nama' => 'PLRS HANDUK 30X30',
            'kategori_id' => 11,
            'unit' => 'PCS',
            'bobot_bucket' => '0.0',
            'harga_premium' => 1250,
            'harga_bucket' => 0,
            'harga_kilo' => 0,
            'status_premium' => true,
            'status_bucket' => false,
            'status_kilo' => false,
            'beban_produksi' => '0.0',
            'status_item' => false,
        ]);

        JenisItem::create([
            'nama' => 'PLRS HANDUK 30X70',
            'kategori_id' => 11,
            'unit' => 'PCS',
            'bobot_bucket' => '0.0',
            'harga_premium' => 2500,
            'harga_bucket' => 0,
            'harga_kilo' => 0,
            'status_premium' => true,
            'status_bucket' => false,
            'status_kilo' => false,
            'beban_produksi' => '0.0',
            'status_item' => false,
        ]);

        JenisItem::create([
            'nama' => 'PLRS HANDUK BESAR',
            'kategori_id' => 11,
            'unit' => 'PCS',
            'bobot_bucket' => '0.0',
            'harga_premium' => 3500,
            'harga_bucket' => 0,
            'harga_kilo' => 0,
            'status_premium' => true,
            'status_bucket' => false,
            'status_kilo' => false,
            'beban_produksi' => '0.0',
            'status_item' => false,
        ]);

        JenisItem::create([
            'nama' => 'PLRS KEMEJA',
            'kategori_id' => 11,
            'unit' => 'PCS',
            'bobot_bucket' => '0.0',
            'harga_premium' => 1500,
            'harga_bucket' => 0,
            'harga_kilo' => 0,
            'status_premium' => true,
            'status_bucket' => false,
            'status_kilo' => false,
            'beban_produksi' => '0.0',
            'status_item' => false,
        ]);

        JenisItem::create([
            'nama' => 'PLRS KIMONO',
            'kategori_id' => 11,
            'unit' => 'PCS',
            'bobot_bucket' => '0.0',
            'harga_premium' => 3000,
            'harga_bucket' => 0,
            'harga_kilo' => 0,
            'status_premium' => true,
            'status_bucket' => false,
            'status_kilo' => false,
            'beban_produksi' => '0.0',
            'status_item' => false,
        ]);

        JenisItem::create([
            'nama' => 'PLRS KIMONO HANDUK',
            'kategori_id' => 11,
            'unit' => 'PCS',
            'bobot_bucket' => '0.0',
            'harga_premium' => 5500,
            'harga_bucket' => 0,
            'harga_kilo' => 0,
            'status_premium' => true,
            'status_bucket' => false,
            'status_kilo' => false,
            'beban_produksi' => '0.0',
            'status_item' => false,
        ]);

        JenisItem::create([
            'nama' => 'PLRS SARUNG BANTAL',
            'kategori_id' => 11,
            'unit' => 'PCS',
            'bobot_bucket' => '0.0',
            'harga_premium' => 1000,
            'harga_bucket' => 0,
            'harga_kilo' => 0,
            'status_premium' => true,
            'status_bucket' => false,
            'status_kilo' => false,
            'beban_produksi' => '0.0',
            'status_item' => false,
        ]);

        JenisItem::create([
            'nama' => 'PLRS SELIMUT HANDUK',
            'kategori_id' => 11,
            'unit' => 'PCS',
            'bobot_bucket' => '0.0',
            'harga_premium' => 5250,
            'harga_bucket' => 0,
            'harga_kilo' => 0,
            'status_premium' => true,
            'status_bucket' => false,
            'status_kilo' => false,
            'beban_produksi' => '0.0',
            'status_item' => false,
        ]);

        JenisItem::create([
            'nama' => 'PLRS SEPREI KUNING BESAR',
            'kategori_id' => 11,
            'unit' => 'PCS',
            'bobot_bucket' => '0.0',
            'harga_premium' => 7500,
            'harga_bucket' => 0,
            'harga_kilo' => 0,
            'status_premium' => true,
            'status_bucket' => false,
            'status_kilo' => false,
            'beban_produksi' => '0.0',
            'status_item' => false,
        ]);

        JenisItem::create([
            'nama' => 'PLRS SEPREI PUTIH BESAR',
            'kategori_id' => 11,
            'unit' => 'PCS',
            'bobot_bucket' => '0.0',
            'harga_premium' => 7500,
            'harga_bucket' => 0,
            'harga_kilo' => 0,
            'status_premium' => true,
            'status_bucket' => false,
            'status_kilo' => false,
            'beban_produksi' => '0.0',
            'status_item' => false,
        ]);

        JenisItem::create([
            'nama' => 'PLRS SEPREI PUTIH KECIL',
            'kategori_id' => 11,
            'unit' => 'PCS',
            'bobot_bucket' => '0.0',
            'harga_premium' => 7000,
            'harga_bucket' => 0,
            'harga_kilo' => 0,
            'status_premium' => true,
            'status_bucket' => false,
            'status_kilo' => false,
            'beban_produksi' => '0.0',
            'status_item' => false,
        ]);

        JenisItem::create([
            'nama' => 'PLRS SEPREI SINGLE KUNING',
            'kategori_id' => 11,
            'unit' => 'PCS',
            'bobot_bucket' => '0.0',
            'harga_premium' => 7000,
            'harga_bucket' => 0,
            'harga_kilo' => 0,
            'status_premium' => true,
            'status_bucket' => false,
            'status_kilo' => false,
            'beban_produksi' => '0.0',
            'status_item' => false,
        ]);

        JenisItem::create([
            'nama' => 'PLRS SLAYER BATIK',
            'kategori_id' => 11,
            'unit' => 'PCS',
            'bobot_bucket' => '0.0',
            'harga_premium' => 1500,
            'harga_bucket' => 0,
            'harga_kilo' => 0,
            'status_premium' => true,
            'status_bucket' => false,
            'status_kilo' => false,
            'beban_produksi' => '0.0',
            'status_item' => false,
        ]);

        JenisItem::create([
            'nama' => 'PLRS WASLAP',
            'kategori_id' => 11,
            'unit' => 'PCS',
            'bobot_bucket' => '0.0',
            'harga_premium' => 500,
            'harga_bucket' => 0,
            'harga_kilo' => 0,
            'status_premium' => true,
            'status_bucket' => false,
            'status_kilo' => false,
            'beban_produksi' => '3.0',
            'status_item' => true,
        ]);

        JenisItem::create([
            'nama' => 'PRM ATASAN / TERUSAN',
            'kategori_id' => 16,
            'unit' => 'PCS',
            'bobot_bucket' => '0.0',
            'harga_premium' => 0,
            'harga_bucket' => 0,
            'harga_kilo' => 0,
            'status_premium' => true,
            'status_bucket' => false,
            'status_kilo' => false,
            'beban_produksi' => '5.0',
            'status_item' => true,
        ]);

        JenisItem::create([
            'nama' => 'PRM BEDCOVER',
            'kategori_id' => 16,
            'unit' => 'PCS',
            'bobot_bucket' => '0.0',
            'harga_premium' => 0,
            'harga_bucket' => 0,
            'harga_kilo' => 0,
            'status_premium' => true,
            'status_bucket' => false,
            'status_kilo' => false,
            'beban_produksi' => '15.0',
            'status_item' => false,
        ]);

        JenisItem::create([
            'nama' => 'PRM BEDCOVER+SEPREI',
            'kategori_id' => 16,
            'unit' => 'PCS',
            'bobot_bucket' => '0.0',
            'harga_premium' => 55000,
            'harga_bucket' => 0,
            'harga_kilo' => 0,
            'status_premium' => true,
            'status_bucket' => false,
            'status_kilo' => false,
            'beban_produksi' => '3.0',
            'status_item' => true,
        ]);

        JenisItem::create([
            'nama' => 'PRM PAKAIAN BAWAHAN',
            'kategori_id' => 16,
            'unit' => 'PCS',
            'bobot_bucket' => '0.0',
            'harga_premium' => 0,
            'harga_bucket' => 0,
            'harga_kilo' => 0,
            'status_premium' => true,
            'status_bucket' => false,
            'status_kilo' => false,
            'beban_produksi' => '4.0',
            'status_item' => true,
        ]);

        JenisItem::create([
            'nama' => 'PRM SEPREI',
            'kategori_id' => 16,
            'unit' => 'PCS',
            'bobot_bucket' => '0.0',
            'harga_premium' => 0,
            'harga_bucket' => 0,
            'harga_kilo' => 0,
            'status_premium' => true,
            'status_bucket' => false,
            'status_kilo' => false,
            'beban_produksi' => '5.0',
            'status_item' => false,
        ]);

        JenisItem::create([
            'nama' => 'PRMGO BEDCOVER KECIL',
            'kategori_id' => 16,
            'unit' => 'PCS',
            'bobot_bucket' => '0.0',
            'harga_premium' => 10000,
            'harga_bucket' => 0,
            'harga_kilo' => 0,
            'status_premium' => true,
            'status_bucket' => false,
            'status_kilo' => false,
            'beban_produksi' => '2.0',
            'status_item' => false,
        ]);

        JenisItem::create([
            'nama' => 'PRMGO BLOUSE',
            'kategori_id' => 16,
            'unit' => 'PCS',
            'bobot_bucket' => '0.0',
            'harga_premium' => 10000,
            'harga_bucket' => 0,
            'harga_kilo' => 0,
            'status_premium' => true,
            'status_bucket' => false,
            'status_kilo' => false,
            'beban_produksi' => '1.0',
            'status_item' => false,
        ]);

        JenisItem::create([
            'nama' => 'PRMGO BONEKA KECIL',
            'kategori_id' => 16,
            'unit' => 'PCS',
            'bobot_bucket' => '0.0',
            'harga_premium' => 10000,
            'harga_bucket' => 0,
            'harga_kilo' => 0,
            'status_premium' => true,
            'status_bucket' => false,
            'status_kilo' => false,
            'beban_produksi' => '5.0',
            'status_item' => false,
        ]);

        JenisItem::create([
            'nama' => 'PRMGO BONEKA SEDANG',
            'kategori_id' => 16,
            'unit' => 'PCS',
            'bobot_bucket' => '0.0',
            'harga_premium' => 10000,
            'harga_bucket' => 0,
            'harga_kilo' => 0,
            'status_premium' => true,
            'status_bucket' => false,
            'status_kilo' => false,
            'beban_produksi' => '1.0',
            'status_item' => false,
        ]);

        JenisItem::create([
            'nama' => 'PRMGO CARDIGAN',
            'kategori_id' => 16,
            'unit' => 'PCS',
            'bobot_bucket' => '0.0',
            'harga_premium' => 10000,
            'harga_bucket' => 0,
            'harga_kilo' => 0,
            'status_premium' => true,
            'status_bucket' => false,
            'status_kilo' => false,
            'beban_produksi' => '1.0',
            'status_item' => false,
        ]);

        JenisItem::create([
            'nama' => 'PRMGO CELANA PANJANG',
            'kategori_id' => 16,
            'unit' => 'PCS',
            'bobot_bucket' => '0.0',
            'harga_premium' => 10000,
            'harga_bucket' => 0,
            'harga_kilo' => 0,
            'status_premium' => true,
            'status_bucket' => false,
            'status_kilo' => false,
            'beban_produksi' => '1.0',
            'status_item' => false,
        ]);



        JenisItem::create([
            'nama' => 'PRMGO CELANA PENDEK',
            'kategori_id' => 16,
            'unit' => 'PCS',
            'bobot_bucket' => '0.0',
            'harga_premium' => 10000,
            'harga_bucket' => 0,
            'harga_kilo' => 0,
            'status_premium' => true,
            'status_bucket' => false,
            'status_kilo' => false,
            'beban_produksi' => '1.0',
            'status_item' => false,
        ]);



        JenisItem::create([
            'nama' => 'PRMGO HANDUK',
            'kategori_id' => 16,
            'unit' => 'PCS',
            'bobot_bucket' => '0.0',
            'harga_premium' => 10000,
            'harga_bucket' => 0,
            'harga_kilo' => 0,
            'status_premium' => true,
            'status_bucket' => false,
            'status_kilo' => false,
            'beban_produksi' => '2.0',
            'status_item' => false,
        ]);



        JenisItem::create([
            'nama' => 'PRMGO JAS',
            'kategori_id' => 16,
            'unit' => 'PCS',
            'bobot_bucket' => '0.0',
            'harga_premium' => 10000,
            'harga_bucket' => 0,
            'harga_kilo' => 0,
            'status_premium' => true,
            'status_bucket' => false,
            'status_kilo' => false,
            'beban_produksi' => '1.0',
            'status_item' => false,
        ]);



        JenisItem::create([
            'nama' => 'PRMGO KEMEJA',
            'kategori_id' => 16,
            'unit' => 'PCS',
            'bobot_bucket' => '0.0',
            'harga_premium' => 10000,
            'harga_bucket' => 0,
            'harga_kilo' => 0,
            'status_premium' => true,
            'status_bucket' => false,
            'status_kilo' => false,
            'beban_produksi' => '1.0',
            'status_item' => false,
        ]);



        JenisItem::create([
            'nama' => 'PRMGO LONG DRESS',
            'kategori_id' => 16,
            'unit' => 'PCS',
            'bobot_bucket' => '0.0',
            'harga_premium' => 10000,
            'harga_bucket' => 0,
            'harga_kilo' => 0,
            'status_premium' => true,
            'status_bucket' => false,
            'status_kilo' => false,
            'beban_produksi' => '1.0',
            'status_item' => false,
        ]);



        JenisItem::create([
            'nama' => 'PRMGO ROK PANJANG',
            'kategori_id' => 16,
            'unit' => 'PCS',
            'bobot_bucket' => '0.0',
            'harga_premium' => 10000,
            'harga_bucket' => 0,
            'harga_kilo' => 0,
            'status_premium' => true,
            'status_bucket' => false,
            'status_kilo' => false,
            'beban_produksi' => '1.0',
            'status_item' => false,
        ]);



        JenisItem::create([
            'nama' => 'PRMGO ROK PENDEK',
            'kategori_id' => 16,
            'unit' => 'PCS',
            'bobot_bucket' => '0.0',
            'harga_premium' => 10000,
            'harga_bucket' => 0,
            'harga_kilo' => 0,
            'status_premium' => true,
            'status_bucket' => false,
            'status_kilo' => false,
            'beban_produksi' => '2.0',
            'status_item' => false,
        ]);



        JenisItem::create([
            'nama' => 'PRMGO SANDAL',
            'kategori_id' => 16,
            'unit' => 'PCS',
            'bobot_bucket' => '0.0',
            'harga_premium' => 10000,
            'harga_bucket' => 0,
            'harga_kilo' => 0,
            'status_premium' => true,
            'status_bucket' => false,
            'status_kilo' => false,
            'beban_produksi' => '1.0',
            'status_item' => false,
        ]);



        JenisItem::create([
            'nama' => 'PRMGO SELIMUT',
            'kategori_id' => 16,
            'unit' => 'PCS',
            'bobot_bucket' => '0.0',
            'harga_premium' => 10000,
            'harga_bucket' => 0,
            'harga_kilo' => 0,
            'status_premium' => true,
            'status_bucket' => false,
            'status_kilo' => false,
            'beban_produksi' => '1.0',
            'status_item' => false,
        ]);



        JenisItem::create([
            'nama' => 'PRMGO SEPATU KAIN',
            'kategori_id' => 16,
            'unit' => 'PCS',
            'bobot_bucket' => '0.0',
            'harga_premium' => 10000,
            'harga_bucket' => 0,
            'harga_kilo' => 0,
            'status_premium' => true,
            'status_bucket' => false,
            'status_kilo' => false,
            'beban_produksi' => '1.0',
            'status_item' => false,
        ]);



        JenisItem::create([
            'nama' => 'PRMGO SEPREI BESAR',
            'kategori_id' => 16,
            'unit' => 'PCS',
            'bobot_bucket' => '0.0',
            'harga_premium' => 10000,
            'harga_bucket' => 0,
            'harga_kilo' => 0,
            'status_premium' => true,
            'status_bucket' => false,
            'status_kilo' => false,
            'beban_produksi' => '2.0',
            'status_item' => false,
        ]);



        JenisItem::create([
            'nama' => 'PRMGO SEPREI KECIL',
            'kategori_id' => 16,
            'unit' => 'PCS',
            'bobot_bucket' => '0.0',
            'harga_premium' => 10000,
            'harga_bucket' => 0,
            'harga_kilo' => 0,
            'status_premium' => true,
            'status_bucket' => false,
            'status_kilo' => false,
            'beban_produksi' => '1.0',
            'status_item' => false,
        ]);



        JenisItem::create([
            'nama' => 'PRMGO SWEETER',
            'kategori_id' => 16,
            'unit' => 'PCS',
            'bobot_bucket' => '0.0',
            'harga_premium' => 10000,
            'harga_bucket' => 0,
            'harga_kilo' => 0,
            'status_premium' => true,
            'status_bucket' => false,
            'status_kilo' => false,
            'beban_produksi' => '5.0',
            'status_item' => false,
        ]);



        JenisItem::create([
            'nama' => 'PRMGO TAS KAIN / RANSEL',
            'kategori_id' => 16,
            'unit' => 'PCS',
            'bobot_bucket' => '0.0',
            'harga_premium' => 10000,
            'harga_bucket' => 0,
            'harga_kilo' => 0,
            'status_premium' => true,
            'status_bucket' => false,
            'status_kilo' => false,
            'beban_produksi' => '1.0',
            'status_item' => false,
        ]);



        JenisItem::create([
            'nama' => 'PRMGO TSHIRT',
            'kategori_id' => 16,
            'unit' => 'PCS',
            'bobot_bucket' => '0.0',
            'harga_premium' => 10000,
            'harga_bucket' => 0,
            'harga_kilo' => 0,
            'status_premium' => true,
            'status_bucket' => false,
            'status_kilo' => false,
            'beban_produksi' => '0.0',
            'status_item' => false,
        ]);



        JenisItem::create([
            'nama' => 'PRMMARET (6KEMEJA,FREE 1SEPREI) HEMAT 20%',
            'kategori_id' => 16,
            'unit' => 'PCS',
            'bobot_bucket' => '0.0',
            'harga_premium' => 96000,
            'harga_bucket' => 0,
            'harga_kilo' => 0,
            'status_premium' => true,
            'status_bucket' => false,
            'status_kilo' => false,
            'beban_produksi' => '0.0',
            'status_item' => false,
        ]);



        JenisItem::create([
            'nama' => 'PRMMARET(12KEMEJA,FREE 1SEPREI LENGKAP) HEMAT 30%',
            'kategori_id' => 16,
            'unit' => 'PCS',
            'bobot_bucket' => '0.0',
            'harga_premium' => 192000,
            'harga_bucket' => 0,
            'harga_kilo' => 0,
            'status_premium' => true,
            'status_bucket' => false,
            'status_kilo' => false,
            'beban_produksi' => '0.0',
            'status_item' => false,
        ]);



        JenisItem::create([
            'nama' => 'PROFITNES HANDUK KECIL',
            'kategori_id' => 16,
            'unit' => 'PCS',
            'bobot_bucket' => '0.0',
            'harga_premium' => 1250,
            'harga_bucket' => 0,
            'harga_kilo' => 0,
            'status_premium' => true,
            'status_bucket' => false,
            'status_kilo' => false,
            'beban_produksi' => '0.0',
            'status_item' => false,
        ]);



        JenisItem::create([
            'nama' => 'PROMO 1BedCov+1Seprei+2srgBantal+2srgGuling',
            'kategori_id' => 16,
            'unit' => 'PCS',
            'bobot_bucket' => '0.0',
            'harga_premium' => 65000,
            'harga_bucket' => 0,
            'harga_kilo' => 0,
            'status_premium' => true,
            'status_bucket' => false,
            'status_kilo' => false,
            'beban_produksi' => '0.0',
            'status_item' => false,
        ]);



        JenisItem::create([
            'nama' => 'PROMO 1seprei+2srgBantal+2srgGuling',
            'kategori_id' => 16,
            'unit' => 'PCS',
            'bobot_bucket' => '0.0',
            'harga_premium' => 35000,
            'harga_bucket' => 0,
            'harga_kilo' => 0,
            'status_premium' => true,
            'status_bucket' => false,
            'status_kilo' => false,
            'beban_produksi' => '0.0',
            'status_item' => true,
        ]);



        JenisItem::create([
            'nama' => 'PROMO ALL ITEM 20.000',
            'kategori_id' => 16,
            'unit' => 'PCS',
            'bobot_bucket' => '0.0',
            'harga_premium' => 20000,
            'harga_bucket' => 0,
            'harga_kilo' => 0,
            'status_premium' => true,
            'status_bucket' => false,
            'status_kilo' => false,
            'beban_produksi' => '5.0',
            'status_item' => true,
        ]);



        JenisItem::create([
            'nama' => 'PROMO ATASAN',
            'kategori_id' => 16,
            'unit' => 'PCS',
            'bobot_bucket' => '0.0',
            'harga_premium' => 17000,
            'harga_bucket' => 0,
            'harga_kilo' => 0,
            'status_premium' => true,
            'status_bucket' => false,
            'status_kilo' => false,
            'beban_produksi' => '20.0',
            'status_item' => true,
        ]);



        JenisItem::create([
            'nama' => 'PROMO BEDSHEET',
            'kategori_id' => 16,
            'unit' => 'PCS',
            'bobot_bucket' => '0.0',
            'harga_premium' => 55000,
            'harga_bucket' => 0,
            'harga_kilo' => 0,
            'status_premium' => true,
            'status_bucket' => false,
            'status_kilo' => false,
            'beban_produksi' => '0.0',
            'status_item' => false,
        ]);



        JenisItem::create([
            'nama' => 'PROMO BLOUSE',
            'kategori_id' => 16,
            'unit' => 'PCS',
            'bobot_bucket' => '0.0',
            'harga_premium' => 0,
            'harga_bucket' => 0,
            'harga_kilo' => 0,
            'status_premium' => true,
            'status_bucket' => false,
            'status_kilo' => false,
            'beban_produksi' => '0.0',
            'status_item' => false,
        ]);



        JenisItem::create([
            'nama' => 'PROMO CELANA PANJANG',
            'kategori_id' => 16,
            'unit' => 'PCS',
            'bobot_bucket' => '0.0',
            'harga_premium' => 0,
            'harga_bucket' => 0,
            'harga_kilo' => 0,
            'status_premium' => true,
            'status_bucket' => false,
            'status_kilo' => false,
            'beban_produksi' => '0.0',
            'status_item' => false,
        ]);



        JenisItem::create([
            'nama' => 'PROMO CELANA PENDEK',
            'kategori_id' => 16,
            'unit' => 'PCS',
            'bobot_bucket' => '0.0',
            'harga_premium' => 0,
            'harga_bucket' => 0,
            'harga_kilo' => 0,
            'status_premium' => true,
            'status_bucket' => false,
            'status_kilo' => false,
            'beban_produksi' => '0.0',
            'status_item' => false,
        ]);



        JenisItem::create([
            'nama' => 'PROMO GAUN PESTA',
            'kategori_id' => 16,
            'unit' => 'PCS',
            'bobot_bucket' => '0.0',
            'harga_premium' => 0,
            'harga_bucket' => 0,
            'harga_kilo' => 0,
            'status_premium' => true,
            'status_bucket' => false,
            'status_kilo' => false,
            'beban_produksi' => '0.0',
            'status_item' => false,
        ]);



        JenisItem::create([
            'nama' => 'PROMO JAKET',
            'kategori_id' => 16,
            'unit' => 'PCS',
            'bobot_bucket' => '0.0',
            'harga_premium' => 0,
            'harga_bucket' => 0,
            'harga_kilo' => 0,
            'status_premium' => true,
            'status_bucket' => false,
            'status_kilo' => false,
            'beban_produksi' => '0.0',
            'status_item' => false,
        ]);



        JenisItem::create([
            'nama' => 'PROMO JAS',
            'kategori_id' => 16,
            'unit' => 'PCS',
            'bobot_bucket' => '0.0',
            'harga_premium' => 0,
            'harga_bucket' => 0,
            'harga_kilo' => 0,
            'status_premium' => true,
            'status_bucket' => false,
            'status_kilo' => false,
            'beban_produksi' => '0.0',
            'status_item' => false,
        ]);



        JenisItem::create([
            'nama' => 'PROMO KEMEJA',
            'kategori_id' => 16,
            'unit' => 'PCS',
            'bobot_bucket' => '0.0',
            'harga_premium' => 0,
            'harga_bucket' => 0,
            'harga_kilo' => 0,
            'status_premium' => true,
            'status_bucket' => false,
            'status_kilo' => false,
            'beban_produksi' => '0.0',
            'status_item' => false,
        ]);



        JenisItem::create([
            'nama' => 'PROMO KEMEJA BATIK',
            'kategori_id' => 16,
            'unit' => 'PCS',
            'bobot_bucket' => '0.0',
            'harga_premium' => 0,
            'harga_bucket' => 0,
            'harga_kilo' => 0,
            'status_premium' => true,
            'status_bucket' => false,
            'status_kilo' => false,
            'beban_produksi' => '0.0',
            'status_item' => false,
        ]);



        JenisItem::create([
            'nama' => 'PROMO LONG DRESS',
            'kategori_id' => 16,
            'unit' => 'PCS',
            'bobot_bucket' => '0.0',
            'harga_premium' => 0,
            'harga_bucket' => 0,
            'harga_kilo' => 0,
            'status_premium' => true,
            'status_bucket' => false,
            'status_kilo' => false,
            'beban_produksi' => '0.0',
            'status_item' => false,
        ]);



        JenisItem::create([
            'nama' => 'PROMO ROK PANJANG',
            'kategori_id' => 16,
            'unit' => 'PCS',
            'bobot_bucket' => '0.0',
            'harga_premium' => 0,
            'harga_bucket' => 0,
            'harga_kilo' => 0,
            'status_premium' => true,
            'status_bucket' => false,
            'status_kilo' => false,
            'beban_produksi' => '0.0',
            'status_item' => false,
        ]);



        JenisItem::create([
            'nama' => 'PROMO ROK PENDEK',
            'kategori_id' => 16,
            'unit' => 'PCS',
            'bobot_bucket' => '0.0',
            'harga_premium' => 0,
            'harga_bucket' => 0,
            'harga_kilo' => 0,
            'status_premium' => true,
            'status_bucket' => false,
            'status_kilo' => false,
            'beban_produksi' => '0.0',
            'status_item' => false,
        ]);



        JenisItem::create([
            'nama' => 'PROMO SEPREI',
            'kategori_id' => 16,
            'unit' => 'PCS',
            'bobot_bucket' => '0.0',
            'harga_premium' => 35000,
            'harga_bucket' => 0,
            'harga_kilo' => 0,
            'status_premium' => true,
            'status_bucket' => false,
            'status_kilo' => false,
            'beban_produksi' => '0.0',
            'status_item' => false,
        ]);



        JenisItem::create([
            'nama' => 'PROMO TSHIRT',
            'kategori_id' => 16,
            'unit' => 'PCS',
            'bobot_bucket' => '0.0',
            'harga_premium' => 0,
            'harga_bucket' => 0,
            'harga_kilo' => 0,
            'status_premium' => true,
            'status_bucket' => false,
            'status_kilo' => false,
            'beban_produksi' => '0.0',
            'status_item' => false,
        ]);



        JenisItem::create([
            'nama' => 'ROK MUKENAH',
            'kategori_id' => 6,
            'unit' => 'PCS',
            'bobot_bucket' => '0.0',
            'harga_premium' => 35000,
            'harga_bucket' => 0,
            'harga_kilo' => 0,
            'status_premium' => true,
            'status_bucket' => false,
            'status_kilo' => false,
            'beban_produksi' => '5.0',
            'status_item' => true,
        ]);



        JenisItem::create([
            'nama' => 'ROK PANJANG',
            'kategori_id' => 8,
            'unit' => 'PCS',
            'bobot_bucket' => '2.0',
            'harga_premium' => 38000,
            'harga_bucket' => 0,
            'harga_kilo' => 0,
            'status_premium' => true,
            'status_bucket' => true,
            'status_kilo' => false,
            'beban_produksi' => '5.0',
            'status_item' => true,
        ]);



        JenisItem::create([
            'nama' => 'ROK PENDEK',
            'kategori_id' => 8,
            'unit' => 'PCS',
            'bobot_bucket' => '1.0',
            'harga_premium' => 28000,
            'harga_bucket' => 0,
            'harga_kilo' => 0,
            'status_premium' => true,
            'status_bucket' => true,
            'status_kilo' => false,
            'beban_produksi' => '5.0',
            'status_item' => true,
        ]);



        JenisItem::create([
            'nama' => 'ROK PENDEK ANAK',
            'kategori_id' => 8,
            'unit' => 'PCS',
            'bobot_bucket' => '0.0',
            'harga_premium' => 22500,
            'harga_bucket' => 0,
            'harga_kilo' => 0,
            'status_premium' => true,
            'status_bucket' => false,
            'status_kilo' => false,
            'beban_produksi' => '2.0',
            'status_item' => true,
        ]);



        JenisItem::create([
            'nama' => 'ROK PENDEK KULIT / SWEDE',
            'kategori_id' => 5,
            'unit' => 'PCS',
            'bobot_bucket' => '0.0',
            'harga_premium' => 58000,
            'harga_bucket' => 0,
            'harga_kilo' => 0,
            'status_premium' => true,
            'status_bucket' => false,
            'status_kilo' => false,
            'beban_produksi' => '5.0',
            'status_item' => true,
        ]);



        JenisItem::create([
            'nama' => 'ROK PESTA / RUMBAI S',
            'kategori_id' => 8,
            'unit' => 'PCS',
            'bobot_bucket' => '0.0',
            'harga_premium' => 45000,
            'harga_bucket' => 0,
            'harga_kilo' => 0,
            'status_premium' => true,
            'status_bucket' => false,
            'status_kilo' => false,
            'beban_produksi' => '5.0',
            'status_item' => true,
        ]);



        JenisItem::create([
            'nama' => 'ROK PESTA /RUMBAI L',
            'kategori_id' => 8,
            'unit' => 'PCS',
            'bobot_bucket' => '0.0',
            'harga_premium' => 60000,
            'harga_bucket' => 0,
            'harga_kilo' => 0,
            'status_premium' => true,
            'status_bucket' => false,
            'status_kilo' => false,
            'beban_produksi' => '7.0',
            'status_item' => true,
        ]);



        JenisItem::create([
            'nama' => 'ROMPI / VEST',
            'kategori_id' => 4,
            'unit' => 'PCS',
            'bobot_bucket' => '0.0',
            'harga_premium' => 32000,
            'harga_bucket' => 0,
            'harga_kilo' => 0,
            'status_premium' => true,
            'status_bucket' => false,
            'status_kilo' => false,
            'beban_produksi' => '5.0',
            'status_item' => true,
        ]);



        JenisItem::create([
            'nama' => 'ROMPI ANAK',
            'kategori_id' => 4,
            'unit' => 'PCS',
            'bobot_bucket' => '0.0',
            'harga_premium' => 18000,
            'harga_bucket' => 0,
            'harga_kilo' => 0,
            'status_premium' => true,
            'status_bucket' => false,
            'status_kilo' => false,
            'beban_produksi' => '3.0',
            'status_item' => true,
        ]);



        JenisItem::create([
            'nama' => 'ROSSI BEDCOVER BESAR',
            'kategori_id' => 11,
            'unit' => 'PCS',
            'bobot_bucket' => '0.0',
            'harga_premium' => 15000,
            'harga_bucket' => 0,
            'harga_kilo' => 0,
            'status_premium' => true,
            'status_bucket' => false,
            'status_kilo' => false,
            'beban_produksi' => '0.0',
            'status_item' => false,
        ]);



        JenisItem::create([
            'nama' => 'ROSSI BEDSET BESAR(1BCD,1SPR,2SBTL,2SGLG)',
            'kategori_id' => 11,
            'unit' => 'PCS',
            'bobot_bucket' => '0.0',
            'harga_premium' => 40000,
            'harga_bucket' => 0,
            'harga_kilo' => 0,
            'status_premium' => true,
            'status_bucket' => false,
            'status_kilo' => false,
            'beban_produksi' => '0.0',
            'status_item' => false,
        ]);



        JenisItem::create([
            'nama' => 'ROSSI BEDSET KECIL(1BCS,1SPR,1SBTL,1SGLG)',
            'kategori_id' => 11,
            'unit' => 'PCS',
            'bobot_bucket' => '0.0',
            'harga_premium' => 34000,
            'harga_bucket' => 0,
            'harga_kilo' => 0,
            'status_premium' => true,
            'status_bucket' => false,
            'status_kilo' => false,
            'beban_produksi' => '0.0',
            'status_item' => false,
        ]);



        JenisItem::create([
            'nama' => 'ROSSI FULL SET(1BCD,1BCS,2SPR,3SBTL,3SGLG)',
            'kategori_id' => 11,
            'unit' => 'PCS',
            'bobot_bucket' => '0.0',
            'harga_premium' => 48000,
            'harga_bucket' => 0,
            'harga_kilo' => 0,
            'status_premium' => true,
            'status_bucket' => false,
            'status_kilo' => false,
            'beban_produksi' => '0.0',
            'status_item' => false,
        ]);

        JenisItem::create([
            'nama' => 'ROSSI HANDUK',
            'kategori_id' => 11,
            'unit' => 'PCS',
            'bobot_bucket' => '0.0',
            'harga_premium' => 1800,
            'harga_bucket' => 0,
            'harga_kilo' => 0,
            'status_premium' => true,
            'status_bucket' => false,
            'status_kilo' => false,
            'beban_produksi' => '0.0',
            'status_item' => false,
        ]);



        JenisItem::create([
            'nama' => 'ROSSI SEPREI BESAR (3SPRB,6SBTL,6SGLG)',
            'kategori_id' => 11,
            'unit' => 'PCS',
            'bobot_bucket' => '0.0',
            'harga_premium' => 32000,
            'harga_bucket' => 0,
            'harga_kilo' => 0,
            'status_premium' => true,
            'status_bucket' => false,
            'status_kilo' => false,
            'beban_produksi' => '0.0',
            'status_item' => false,
        ]);



        JenisItem::create([
            'nama' => 'ROSSI SEPREI KECIL (3SPRS,3SBTL,3SGLG)',
            'kategori_id' => 11,
            'unit' => 'PCS',
            'bobot_bucket' => '0.0',
            'harga_premium' => 28000,
            'harga_bucket' => 0,
            'harga_kilo' => 0,
            'status_premium' => true,
            'status_bucket' => false,
            'status_kilo' => false,
            'beban_produksi' => '0.0',
            'status_item' => false,
        ]);



        JenisItem::create([
            'nama' => 'SAJADAH',
            'kategori_id' => 6,
            'unit' => 'PCS',
            'bobot_bucket' => '0.0',
            'harga_premium' => 30000,
            'harga_bucket' => 0,
            'harga_kilo' => 0,
            'status_premium' => true,
            'status_bucket' => false,
            'status_kilo' => false,
            'beban_produksi' => '10.0',
            'status_item' => true,
        ]);



        JenisItem::create([
            'nama' => 'SANDAL KAIN / SUEDE',
            'kategori_id' => 17,
            'unit' => 'PCS',
            'bobot_bucket' => '0.0',
            'harga_premium' => 30000,
            'harga_bucket' => 0,
            'harga_kilo' => 0,
            'status_premium' => true,
            'status_bucket' => false,
            'status_kilo' => false,
            'beban_produksi' => '3.0',
            'status_item' => true,
        ]);



        JenisItem::create([
            'nama' => 'SARUNG BANTAL',
            'kategori_id' => 9,
            'unit' => 'PCS',
            'bobot_bucket' => '0.0',
            'harga_premium' => 18000,
            'harga_bucket' => 0,
            'harga_kilo' => 0,
            'status_premium' => true,
            'status_bucket' => false,
            'status_kilo' => false,
            'beban_produksi' => '3.0',
            'status_item' => true,
        ]);



        JenisItem::create([
            'nama' => 'SARUNG BANTAL SOFA',
            'kategori_id' => 3,
            'unit' => 'PCS',
            'bobot_bucket' => '0.0',
            'harga_premium' => 25000,
            'harga_bucket' => 0,
            'harga_kilo' => 0,
            'status_premium' => true,
            'status_bucket' => false,
            'status_kilo' => false,
            'beban_produksi' => '4.0',
            'status_item' => true,
        ]);



        JenisItem::create([
            'nama' => 'SARUNG GITAR',
            'kategori_id' => 3,
            'unit' => 'PCS',
            'bobot_bucket' => '0.0',
            'harga_premium' => 45000,
            'harga_bucket' => 0,
            'harga_kilo' => 0,
            'status_premium' => true,
            'status_bucket' => false,
            'status_kilo' => false,
            'beban_produksi' => '7.0',
            'status_item' => true,
        ]);



        JenisItem::create([
            'nama' => 'SARUNG GULING',
            'kategori_id' => 9,
            'unit' => 'PCS',
            'bobot_bucket' => '0.0',
            'harga_premium' => 18000,
            'harga_bucket' => 0,
            'harga_kilo' => 0,
            'status_premium' => true,
            'status_bucket' => false,
            'status_kilo' => false,
            'beban_produksi' => '3.0',
            'status_item' => true,
        ]);



        JenisItem::create([
            'nama' => 'SARUNG KAIN',
            'kategori_id' => 3,
            'unit' => 'PCS',
            'bobot_bucket' => '0.0',
            'harga_premium' => 18000,
            'harga_bucket' => 0,
            'harga_kilo' => 0,
            'status_premium' => true,
            'status_bucket' => false,
            'status_kilo' => false,
            'beban_produksi' => '4.0',
            'status_item' => true,
        ]);



        JenisItem::create([
            'nama' => 'SARUNG SOFA LONG (1M < ..)',
            'kategori_id' => 3,
            'unit' => 'PCS',
            'bobot_bucket' => '0.0',
            'harga_premium' => 95000,
            'harga_bucket' => 0,
            'harga_kilo' => 0,
            'status_premium' => true,
            'status_bucket' => false,
            'status_kilo' => false,
            'beban_produksi' => '10.0',
            'status_item' => true,
        ]);



        JenisItem::create([
            'nama' => 'SARUNG SOFA SMALL(1M > ..)',
            'kategori_id' => 3,
            'unit' => 'PCS',
            'bobot_bucket' => '0.0',
            'harga_premium' => 75000,
            'harga_bucket' => 0,
            'harga_kilo' => 0,
            'status_premium' => true,
            'status_bucket' => false,
            'status_kilo' => false,
            'beban_produksi' => '8.0',
            'status_item' => true,
        ]);



        JenisItem::create([
            'nama' => 'SARUNG SONGKET',
            'kategori_id' => 1,
            'unit' => 'PCS',
            'bobot_bucket' => '0.0',
            'harga_premium' => 35000,
            'harga_bucket' => 0,
            'harga_kilo' => 0,
            'status_premium' => true,
            'status_bucket' => false,
            'status_kilo' => false,
            'beban_produksi' => '5.0',
            'status_item' => true,
        ]);



        JenisItem::create([
            'nama' => 'SARUNG TANGAN ANAK',
            'kategori_id' => 1,
            'unit' => 'PCS',
            'bobot_bucket' => '0.0',
            'harga_premium' => 15000,
            'harga_bucket' => 0,
            'harga_kilo' => 0,
            'status_premium' => true,
            'status_bucket' => false,
            'status_kilo' => false,
            'beban_produksi' => '2.0',
            'status_item' => true,
        ]);



        JenisItem::create([
            'nama' => 'SARUNG TANGAN KAIN',
            'kategori_id' => 1,
            'unit' => 'PCS',
            'bobot_bucket' => '0.0',
            'harga_premium' => 25000,
            'harga_bucket' => 0,
            'harga_kilo' => 0,
            'status_premium' => true,
            'status_bucket' => false,
            'status_kilo' => false,
            'beban_produksi' => '3.0',
            'status_item' => true,
        ]);



        JenisItem::create([
            'nama' => 'SARUNG TANGAN KULIT',
            'kategori_id' => 5,
            'unit' => 'PCS',
            'bobot_bucket' => '0.0',
            'harga_premium' => 38000,
            'harga_bucket' => 0,
            'harga_kilo' => 0,
            'status_premium' => true,
            'status_bucket' => false,
            'status_kilo' => false,
            'beban_produksi' => '3.0',
            'status_item' => true,
        ]);



        JenisItem::create([
            'nama' => 'SARUNG TANGAN KULIT (PER PSG)',
            'kategori_id' => 5,
            'unit' => 'PCS',
            'bobot_bucket' => '0.0',
            'harga_premium' => 65000,
            'harga_bucket' => 0,
            'harga_kilo' => 0,
            'status_premium' => true,
            'status_bucket' => false,
            'status_kilo' => false,
            'beban_produksi' => '6.0',
            'status_item' => true,
        ]);



        JenisItem::create([
            'nama' => 'SARUNG TANGAN KULIT 1BIJI',
            'kategori_id' => 5,
            'unit' => 'PCS',
            'bobot_bucket' => '0.0',
            'harga_premium' => 17500,
            'harga_bucket' => 0,
            'harga_kilo' => 0,
            'status_premium' => true,
            'status_bucket' => false,
            'status_kilo' => false,
            'beban_produksi' => '3.0',
            'status_item' => true,
        ]);



        JenisItem::create([
            'nama' => 'SELAMBU BAYI',
            'kategori_id' => 15,
            'unit' => 'PCS',
            'bobot_bucket' => '0.0',
            'harga_premium' => 55000,
            'harga_bucket' => 0,
            'harga_kilo' => 0,
            'status_premium' => true,
            'status_bucket' => false,
            'status_kilo' => false,
            'beban_produksi' => '3.0',
            'status_item' => true,
        ]);



        JenisItem::create([
            'nama' => 'SELENDANG ANAK',
            'kategori_id' => 1,
            'unit' => 'PCS',
            'bobot_bucket' => '0.0',
            'harga_premium' => 25000,
            'harga_bucket' => 0,
            'harga_kilo' => 0,
            'status_premium' => true,
            'status_bucket' => false,
            'status_kilo' => false,
            'beban_produksi' => '5.0',
            'status_item' => true,
        ]);



        JenisItem::create([
            'nama' => 'SELENDANG KAIN',
            'kategori_id' => 1,
            'unit' => 'PCS',
            'bobot_bucket' => '0.0',
            'harga_premium' => 25000,
            'harga_bucket' => 0,
            'harga_kilo' => 0,
            'status_premium' => true,
            'status_bucket' => false,
            'status_kilo' => false,
            'beban_produksi' => '5.0',
            'status_item' => true,
        ]);



        JenisItem::create([
            'nama' => 'SELENDANG PESTA',
            'kategori_id' => 14,
            'unit' => 'PCS',
            'bobot_bucket' => '0.0',
            'harga_premium' => 35000,
            'harga_bucket' => 0,
            'harga_kilo' => 0,
            'status_premium' => true,
            'status_bucket' => false,
            'status_kilo' => false,
            'beban_produksi' => '5.0',
            'status_item' => true,
        ]);



        JenisItem::create([
            'nama' => 'SELENDANG SUTRA',
            'kategori_id' => 1,
            'unit' => 'PCS',
            'bobot_bucket' => '0.0',
            'harga_premium' => 58000,
            'harga_bucket' => 0,
            'harga_kilo' => 0,
            'status_premium' => true,
            'status_bucket' => false,
            'status_kilo' => false,
            'beban_produksi' => '5.0',
            'status_item' => true,
        ]);



        JenisItem::create([
            'nama' => 'SELIMUT BAYI',
            'kategori_id' => 15,
            'unit' => 'PCS',
            'bobot_bucket' => '0.0',
            'harga_premium' => 28000,
            'harga_bucket' => 0,
            'harga_kilo' => 0,
            'status_premium' => true,
            'status_bucket' => false,
            'status_kilo' => false,
            'beban_produksi' => '2.0',
            'status_item' => true,
        ]);



        JenisItem::create([
            'nama' => 'SELIMUT TEBAL',
            'kategori_id' => 9,
            'unit' => 'PCS',
            'bobot_bucket' => '0.0',
            'harga_premium' => 60000,
            'harga_bucket' => 0,
            'harga_kilo' => 0,
            'status_premium' => true,
            'status_bucket' => false,
            'status_kilo' => false,
            'beban_produksi' => '10.0',
            'status_item' => true,
        ]);

        JenisItem::create([
            'nama' => 'SELIMUT TIPIS',
            'kategori_id' => 9,
            'unit' => 'PCS',
            'bobot_bucket' => '0.0',
            'harga_premium' => 35000,
            'harga_bucket' => 0,
            'harga_kilo' => 0,
            'status_premium' => true,
            'status_bucket' => false,
            'status_kilo' => false,
            'beban_produksi' => '7.0',
            'status_item' => true,
        ]);



        JenisItem::create([
            'nama' => 'SEPATU ANAK',
            'kategori_id' => 17,
            'unit' => 'PCS',
            'bobot_bucket' => '0.0',
            'harga_premium' => 28000,
            'harga_bucket' => 0,
            'harga_kilo' => 0,
            'status_premium' => true,
            'status_bucket' => false,
            'status_kilo' => false,
            'beban_produksi' => '10.0',
            'status_item' => true,
        ]);



        JenisItem::create([
            'nama' => 'SEPATU BALAP',
            'kategori_id' => 17,
            'unit' => 'PCS',
            'bobot_bucket' => '0.0',
            'harga_premium' => 110000,
            'harga_bucket' => 0,
            'harga_kilo' => 0,
            'status_premium' => true,
            'status_bucket' => false,
            'status_kilo' => false,
            'beban_produksi' => '15.0',
            'status_item' => true,
        ]);



        JenisItem::create([
            'nama' => 'SEPATU KAIN',
            'kategori_id' => 17,
            'unit' => 'PCS',
            'bobot_bucket' => '0.0',
            'harga_premium' => 50000,
            'harga_bucket' => 0,
            'harga_kilo' => 0,
            'status_premium' => true,
            'status_bucket' => false,
            'status_kilo' => false,
            'beban_produksi' => '10.0',
            'status_item' => true,
        ]);



        JenisItem::create([
            'nama' => 'SEPATU KULIT',
            'kategori_id' => 5,
            'unit' => 'PCS',
            'bobot_bucket' => '0.0',
            'harga_premium' => 115000,
            'harga_bucket' => 0,
            'harga_kilo' => 0,
            'status_premium' => true,
            'status_bucket' => false,
            'status_kilo' => false,
            'beban_produksi' => '20.0',
            'status_item' => true,
        ]);



        JenisItem::create([
            'nama' => 'SEPATU PANTOVEL',
            'kategori_id' => 17,
            'unit' => 'PCS',
            'bobot_bucket' => '0.0',
            'harga_premium' => 65000,
            'harga_bucket' => 0,
            'harga_kilo' => 0,
            'status_premium' => true,
            'status_bucket' => false,
            'status_kilo' => false,
            'beban_produksi' => '10.0',
            'status_item' => true,
        ]);



        JenisItem::create([
            'nama' => 'SEPATU PESTA',
            'kategori_id' => 17,
            'unit' => 'PCS',
            'bobot_bucket' => '0.0',
            'harga_premium' => 65000,
            'harga_bucket' => 0,
            'harga_kilo' => 0,
            'status_premium' => true,
            'status_bucket' => false,
            'status_kilo' => false,
            'beban_produksi' => '15.0',
            'status_item' => true,
        ]);



        JenisItem::create([
            'nama' => 'SEPREI DOUBLE',
            'kategori_id' => 9,
            'unit' => 'PCS',
            'bobot_bucket' => '0.0',
            'harga_premium' => 50000,
            'harga_bucket' => 0,
            'harga_kilo' => 0,
            'status_premium' => true,
            'status_bucket' => false,
            'status_kilo' => false,
            'beban_produksi' => '10.0',
            'status_item' => true,
        ]);



        JenisItem::create([
            'nama' => 'SEPREI SINGLE',
            'kategori_id' => 9,
            'unit' => 'PCS',
            'bobot_bucket' => '0.0',
            'harga_premium' => 35000,
            'harga_bucket' => 0,
            'harga_kilo' => 0,
            'status_premium' => true,
            'status_bucket' => false,
            'status_kilo' => false,
            'beban_produksi' => '5.0',
            'status_item' => true,
        ]);



        JenisItem::create([
            'nama' => 'SET 2 SARUNG (SBANTAL/GLG)',
            'kategori_id' => 9,
            'unit' => 'PCS',
            'bobot_bucket' => '0.0',
            'harga_premium' => 7500,
            'harga_bucket' => 0,
            'harga_kilo' => 0,
            'status_premium' => true,
            'status_bucket' => false,
            'status_kilo' => false,
            'beban_produksi' => '0.0',
            'status_item' => true,
        ]);



        JenisItem::create([
            'nama' => 'SET ANAK JAS (JAS+CELANA)',
            'kategori_id' => 7,
            'unit' => 'PCS',
            'bobot_bucket' => '0.0',
            'harga_premium' => 38000,
            'harga_bucket' => 0,
            'harga_kilo' => 0,
            'status_premium' => true,
            'status_bucket' => false,
            'status_kilo' => false,
            'beban_produksi' => '0.0',
            'status_item' => true,
        ]);



        JenisItem::create([
            'nama' => 'SET BAJU ANAK (BAJU+CELANA)',
            'kategori_id' => 7,
            'unit' => 'PCS',
            'bobot_bucket' => '0.0',
            'harga_premium' => 38000,
            'harga_bucket' => 0,
            'harga_kilo' => 0,
            'status_premium' => true,
            'status_bucket' => false,
            'status_kilo' => false,
            'beban_produksi' => '10.0',
            'status_item' => true,
        ]);



        JenisItem::create([
            'nama' => 'SET BCOVER(1BCV+1SP2SB+2SG)',
            'kategori_id' => 9,
            'unit' => 'PCS',
            'bobot_bucket' => '0.0',
            'harga_premium' => 110000,
            'harga_bucket' => 0,
            'harga_kilo' => 0,
            'status_premium' => true,
            'status_bucket' => false,
            'status_kilo' => false,
            'beban_produksi' => '25.0',
            'status_item' => true,
        ]);



        JenisItem::create([
            'nama' => 'SET BEDCOVER BAYI',
            'kategori_id' => 9,
            'unit' => 'PCS',
            'bobot_bucket' => '0.0',
            'harga_premium' => 60000,
            'harga_bucket' => 0,
            'harga_kilo' => 0,
            'status_premium' => true,
            'status_bucket' => false,
            'status_kilo' => false,
            'beban_produksi' => '2.0',
            'status_item' => true,
        ]);



        JenisItem::create([
            'nama' => 'SET BRA & U.WEAR',
            'kategori_id' => 7,
            'unit' => 'PCS',
            'bobot_bucket' => '0.0',
            'harga_premium' => 28000,
            'harga_bucket' => 0,
            'harga_kilo' => 0,
            'status_premium' => true,
            'status_bucket' => false,
            'status_kilo' => false,
            'beban_produksi' => '5.0',
            'status_item' => true,
        ]);



        JenisItem::create([
            'nama' => 'SET JAS / BLAZER',
            'kategori_id' => 7,
            'unit' => 'PCS',
            'bobot_bucket' => '0.0',
            'harga_premium' => 68000,
            'harga_bucket' => 0,
            'harga_kilo' => 0,
            'status_premium' => true,
            'status_bucket' => false,
            'status_kilo' => false,
            'beban_produksi' => '15.0',
            'status_item' => true,
        ]);



        JenisItem::create([
            'nama' => 'SET JAS, KEMEJA, DASI, ROMPI (LUWES)',
            'kategori_id' => 16,
            'unit' => 'PCS',
            'bobot_bucket' => '0.0',
            'harga_premium' => 50000,
            'harga_bucket' => 0,
            'harga_kilo' => 0,
            'status_premium' => true,
            'status_bucket' => false,
            'status_kilo' => false,
            'beban_produksi' => '10.0',
            'status_item' => true,
        ]);



        JenisItem::create([
            'nama' => 'SET KASUR HEWAN',
            'kategori_id' => 3,
            'unit' => 'PCS',
            'bobot_bucket' => '0.0',
            'harga_premium' => 100000,
            'harga_bucket' => 0,
            'harga_kilo' => 0,
            'status_premium' => true,
            'status_bucket' => false,
            'status_kilo' => false,
            'beban_produksi' => '15.0',
            'status_item' => true,
        ]);



        JenisItem::create([
            'nama' => 'SET KEBAYA',
            'kategori_id' => 7,
            'unit' => 'PCS',
            'bobot_bucket' => '0.0',
            'harga_premium' => 75000,
            'harga_bucket' => 0,
            'harga_kilo' => 0,
            'status_premium' => true,
            'status_bucket' => false,
            'status_kilo' => false,
            'beban_produksi' => '15.0',
            'status_item' => true,
        ]);



        JenisItem::create([
            'nama' => 'SET PIYAMA',
            'kategori_id' => 7,
            'unit' => 'PCS',
            'bobot_bucket' => '0.0',
            'harga_premium' => 45000,
            'harga_bucket' => 0,
            'harga_kilo' => 0,
            'status_premium' => true,
            'status_bucket' => false,
            'status_kilo' => false,
            'beban_produksi' => '10.0',
            'status_item' => true,
        ]);



        JenisItem::create([
            'nama' => 'SET PIYAMA ANAK',
            'kategori_id' => 7,
            'unit' => 'PCS',
            'bobot_bucket' => '0.0',
            'harga_premium' => 36000,
            'harga_bucket' => 0,
            'harga_kilo' => 0,
            'status_premium' => true,
            'status_bucket' => false,
            'status_kilo' => false,
            'beban_produksi' => '2.0',
            'status_item' => true,
        ]);



        JenisItem::create([
            'nama' => 'SET SAFARI',
            'kategori_id' => 7,
            'unit' => 'PCS',
            'bobot_bucket' => '0.0',
            'harga_premium' => 65000,
            'harga_bucket' => 0,
            'harga_kilo' => 0,
            'status_premium' => true,
            'status_bucket' => false,
            'status_kilo' => false,
            'beban_produksi' => '15.0',
            'status_item' => true,
        ]);



        JenisItem::create([
            'nama' => 'SET SARUNG (2PCS)SB/SG',
            'kategori_id' => 9,
            'unit' => 'PCS',
            'bobot_bucket' => '0.0',
            'harga_premium' => 15000,
            'harga_bucket' => 0,
            'harga_kilo' => 0,
            'status_premium' => true,
            'status_bucket' => false,
            'status_kilo' => false,
            'beban_produksi' => '0.0',
            'status_item' => true,
        ]);



        JenisItem::create([
            'nama' => 'SET SEPREI (1SPR+2SB+2SG)',
            'kategori_id' => 9,
            'unit' => 'PCS',
            'bobot_bucket' => '0.0',
            'harga_premium' => 58000,
            'harga_bucket' => 0,
            'harga_kilo' => 0,
            'status_premium' => true,
            'status_bucket' => false,
            'status_kilo' => false,
            'beban_produksi' => '10.0',
            'status_item' => true,
        ]);



        JenisItem::create([
            'nama' => 'SET SEPREI 3PC',
            'kategori_id' => 9,
            'unit' => 'PCS',
            'bobot_bucket' => '0.0',
            'harga_premium' => 120000,
            'harga_bucket' => 0,
            'harga_kilo' => 0,
            'status_premium' => true,
            'status_bucket' => false,
            'status_kilo' => false,
            'beban_produksi' => '10.0',
            'status_item' => true,
        ]);



        JenisItem::create([
            'nama' => 'SET SPREI BAYI',
            'kategori_id' => 9,
            'unit' => 'PCS',
            'bobot_bucket' => '0.0',
            'harga_premium' => 40000,
            'harga_bucket' => 0,
            'harga_kilo' => 0,
            'status_premium' => true,
            'status_bucket' => false,
            'status_kilo' => false,
            'beban_produksi' => '2.0',
            'status_item' => true,
        ]);



        JenisItem::create([
            'nama' => 'SHOWERCAP',
            'kategori_id' => 1,
            'unit' => 'PCS',
            'bobot_bucket' => '1.0',
            'harga_premium' => 12000,
            'harga_bucket' => 0,
            'harga_kilo' => 0,
            'status_premium' => true,
            'status_bucket' => true,
            'status_kilo' => false,
            'beban_produksi' => '1.0',
            'status_item' => true,
        ]);



        JenisItem::create([
            'nama' => 'SLEEPING BAG',
            'kategori_id' => 9,
            'unit' => 'PCS',
            'bobot_bucket' => '0.0',
            'harga_premium' => 95000,
            'harga_bucket' => 0,
            'harga_kilo' => 0,
            'status_premium' => true,
            'status_bucket' => false,
            'status_kilo' => false,
            'beban_produksi' => '6.0',
            'status_item' => true,
        ]);



        JenisItem::create([
            'nama' => 'SLEEPING BAG',
            'kategori_id' => 9,
            'unit' => 'PCS',
            'bobot_bucket' => '0.0',
            'harga_premium' => 95000,
            'harga_bucket' => 0,
            'harga_kilo' => 0,
            'status_premium' => true,
            'status_bucket' => false,
            'status_kilo' => false,
            'beban_produksi' => '20.0',
            'status_item' => true,
        ]);



        JenisItem::create([
            'nama' => 'SOIREE SET',
            'kategori_id' => 11,
            'unit' => 'PCS',
            'bobot_bucket' => '0.0',
            'harga_premium' => 200000,
            'harga_bucket' => 0,
            'harga_kilo' => 0,
            'status_premium' => true,
            'status_bucket' => false,
            'status_kilo' => false,
            'beban_produksi' => '20.0',
            'status_item' => true,
        ]);



        JenisItem::create([
            'nama' => 'SSC JAS',
            'kategori_id' => 11,
            'unit' => 'PCS',
            'bobot_bucket' => '0.0',
            'harga_premium' => 20000,
            'harga_bucket' => 0,
            'harga_kilo' => 0,
            'status_premium' => true,
            'status_bucket' => false,
            'status_kilo' => false,
            'beban_produksi' => '10.0',
            'status_item' => false,
        ]);



        JenisItem::create([
            'nama' => 'SSC TABLE CLOTH',
            'kategori_id' => 11,
            'unit' => 'PCS',
            'bobot_bucket' => '0.0',
            'harga_premium' => 20000,
            'harga_bucket' => 0,
            'harga_kilo' => 0,
            'status_premium' => true,
            'status_bucket' => false,
            'status_kilo' => false,
            'beban_produksi' => '10.0',
            'status_item' => false,
        ]);



        JenisItem::create([
            'nama' => 'STOKING ANAK',
            'kategori_id' => 1,
            'unit' => 'PCS',
            'bobot_bucket' => '0.0',
            'harga_premium' => 16000,
            'harga_bucket' => 0,
            'harga_kilo' => 0,
            'status_premium' => true,
            'status_bucket' => false,
            'status_kilo' => false,
            'beban_produksi' => '3.0',
            'status_item' => true,
        ]);



        JenisItem::create([
            'nama' => 'SWEETER',
            'kategori_id' => 4,
            'unit' => 'PCS',
            'bobot_bucket' => '0.0',
            'harga_premium' => 40000,
            'harga_bucket' => 0,
            'harga_kilo' => 0,
            'status_premium' => true,
            'status_bucket' => false,
            'status_kilo' => false,
            'beban_produksi' => '10.0',
            'status_item' => true,
        ]);



        JenisItem::create([
            'nama' => 'SYAL KAIN',
            'kategori_id' => 1,
            'unit' => 'PCS',
            'bobot_bucket' => '0.0',
            'harga_premium' => 15000,
            'harga_bucket' => 0,
            'harga_kilo' => 0,
            'status_premium' => true,
            'status_bucket' => false,
            'status_kilo' => false,
            'beban_produksi' => '3.0',
            'status_item' => true,
        ]);



        JenisItem::create([
            'nama' => 'SYAL RAJUT',
            'kategori_id' => 1,
            'unit' => 'PCS',
            'bobot_bucket' => '0.0',
            'harga_premium' => 25000,
            'harga_bucket' => 0,
            'harga_kilo' => 0,
            'status_premium' => true,
            'status_bucket' => false,
            'status_kilo' => false,
            'beban_produksi' => '5.0',
            'status_item' => true,
        ]);



        JenisItem::create([
            'nama' => 'TAPLAK MEJA KECIL',
            'kategori_id' => 3,
            'unit' => 'PCS',
            'bobot_bucket' => '0.0',
            'harga_premium' => 30000,
            'harga_bucket' => 0,
            'harga_kilo' => 0,
            'status_premium' => true,
            'status_bucket' => false,
            'status_kilo' => false,
            'beban_produksi' => '0.0',
            'status_item' => true,
        ]);



        JenisItem::create([
            'nama' => 'TAPLAK MEJA/TABLECLOTH',
            'kategori_id' => 3,
            'unit' => 'PCS',
            'bobot_bucket' => '0.0',
            'harga_premium' => 55000,
            'harga_bucket' => 0,
            'harga_kilo' => 0,
            'status_premium' => true,
            'status_bucket' => false,
            'status_kilo' => false,
            'beban_produksi' => '10.0',
            'status_item' => true,
        ]);



        JenisItem::create([
            'nama' => 'TAS GAUN',
            'kategori_id' => 18,
            'unit' => 'PCS',
            'bobot_bucket' => '0.0',
            'harga_premium' => 28000,
            'harga_bucket' => 0,
            'harga_kilo' => 0,
            'status_premium' => true,
            'status_bucket' => false,
            'status_kilo' => false,
            'beban_produksi' => '3.0',
            'status_item' => true,
        ]);



        JenisItem::create([
            'nama' => 'TAS KAIN / RANSEL',
            'kategori_id' => 18,
            'unit' => 'PCS',
            'bobot_bucket' => '0.0',
            'harga_premium' => 58000,
            'harga_bucket' => 0,
            'harga_kilo' => 0,
            'status_premium' => true,
            'status_bucket' => false,
            'status_kilo' => false,
            'beban_produksi' => '10.0',
            'status_item' => true,
        ]);



        JenisItem::create([
            'nama' => 'TAS KECIL/POUCH',
            'kategori_id' => 18,
            'unit' => 'PCS',
            'bobot_bucket' => '0.0',
            'harga_premium' => 20000,
            'harga_bucket' => 0,
            'harga_kilo' => 0,
            'status_premium' => true,
            'status_bucket' => false,
            'status_kilo' => false,
            'beban_produksi' => '5.0',
            'status_item' => true,
        ]);



        JenisItem::create([
            'nama' => 'TAS KOPER BESAR',
            'kategori_id' => 18,
            'unit' => 'PCS',
            'bobot_bucket' => '0.0',
            'harga_premium' => 80000,
            'harga_bucket' => 0,
            'harga_kilo' => 0,
            'status_premium' => true,
            'status_bucket' => false,
            'status_kilo' => false,
            'beban_produksi' => '15.0',
            'status_item' => true,
        ]);



        JenisItem::create([
            'nama' => 'TAS KOPER KECIL',
            'kategori_id' => 18,
            'unit' => 'PCS',
            'bobot_bucket' => '0.0',
            'harga_premium' => 50000,
            'harga_bucket' => 0,
            'harga_kilo' => 0,
            'status_premium' => true,
            'status_bucket' => false,
            'status_kilo' => false,
            'beban_produksi' => '12.0',
            'status_item' => true,
        ]);



        JenisItem::create([
            'nama' => 'TAS KULIT',
            'kategori_id' => 5,
            'unit' => 'PCS',
            'bobot_bucket' => '0.0',
            'harga_premium' => 125000,
            'harga_bucket' => 0,
            'harga_kilo' => 0,
            'status_premium' => true,
            'status_bucket' => false,
            'status_kilo' => false,
            'beban_produksi' => '15.0',
            'status_item' => true,
        ]);



        JenisItem::create([
            'nama' => 'TAS RANSEL ANAK',
            'kategori_id' => 18,
            'unit' => 'PCS',
            'bobot_bucket' => '0.0',
            'harga_premium' => 35000,
            'harga_bucket' => 0,
            'harga_kilo' => 0,
            'status_premium' => true,
            'status_bucket' => false,
            'status_kilo' => false,
            'beban_produksi' => '0.0',
            'status_item' => true,
        ]);



        JenisItem::create([
            'nama' => 'TAS WANITA KAIN',
            'kategori_id' => 18,
            'unit' => 'PCS',
            'bobot_bucket' => '0.0',
            'harga_premium' => 60000,
            'harga_bucket' => 0,
            'harga_kilo' => 0,
            'status_premium' => true,
            'status_bucket' => false,
            'status_kilo' => false,
            'beban_produksi' => '10.0',
            'status_item' => true,
        ]);



        JenisItem::create([
            'nama' => 'TIKAR TEBAL',
            'kategori_id' => 3,
            'unit' => 'PCS',
            'bobot_bucket' => '0.0',
            'harga_premium' => 60000,
            'harga_bucket' => 0,
            'harga_kilo' => 0,
            'status_premium' => true,
            'status_bucket' => false,
            'status_kilo' => false,
            'beban_produksi' => '15.0',
            'status_item' => true,
        ]);



        JenisItem::create([
            'nama' => 'TOPI',
            'kategori_id' => 1,
            'unit' => 'PCS',
            'bobot_bucket' => '0.0',
            'harga_premium' => 25000,
            'harga_bucket' => 0,
            'harga_kilo' => 0,
            'status_premium' => true,
            'status_bucket' => false,
            'status_kilo' => false,
            'beban_produksi' => '5.0',
            'status_item' => true,
        ]);



        JenisItem::create([
            'nama' => 'TOPI GORDYN',
            'kategori_id' => 3,
            'unit' => 'PCS',
            'bobot_bucket' => '0.0',
            'harga_premium' => 30000,
            'harga_bucket' => 0,
            'harga_kilo' => 0,
            'status_premium' => true,
            'status_bucket' => false,
            'status_kilo' => false,
            'beban_produksi' => '10.0',
            'status_item' => true,
        ]);



        JenisItem::create([
            'nama' => 'TRX HANDUK',
            'kategori_id' => 11,
            'unit' => 'PCS',
            'bobot_bucket' => '0.0',
            'harga_premium' => 2000,
            'harga_bucket' => 0,
            'harga_kilo' => 0,
            'status_premium' => true,
            'status_bucket' => false,
            'status_kilo' => false,
            'beban_produksi' => '0.0',
            'status_item' => true,
        ]);



        JenisItem::create([
            'nama' => 'TSHIRT',
            'kategori_id' => 4,
            'unit' => 'PCS',
            'bobot_bucket' => '1.0',
            'harga_premium' => 28000,
            'harga_bucket' => 0,
            'harga_kilo' => 0,
            'status_premium' => true,
            'status_bucket' => true,
            'status_kilo' => false,
            'beban_produksi' => '5.0',
            'status_item' => true,
        ]);



        JenisItem::create([
            'nama' => 'TSHIRT ANAK',
            'kategori_id' => 4,
            'unit' => 'PCS',
            'bobot_bucket' => '1.0',
            'harga_premium' => 17000,
            'harga_bucket' => 0,
            'harga_kilo' => 0,
            'status_premium' => true,
            'status_bucket' => true,
            'status_kilo' => false,
            'beban_produksi' => '7.0',
            'status_item' => true,
        ]);



        JenisItem::create([
            'nama' => 'TUDUNG SAJI',
            'kategori_id' => 3,
            'unit' => 'PCS',
            'bobot_bucket' => '0.0',
            'harga_premium' => 40000,
            'harga_bucket' => 0,
            'harga_kilo' => 0,
            'status_premium' => true,
            'status_bucket' => false,
            'status_kilo' => false,
            'beban_produksi' => '7.0',
            'status_item' => true,
        ]);



        JenisItem::create([
            'nama' => 'VITA APRON',
            'kategori_id' => 11,
            'unit' => 'PCS',
            'bobot_bucket' => '0.0',
            'harga_premium' => 1,
            'harga_bucket' => 0,
            'harga_kilo' => 0,
            'status_premium' => true,
            'status_bucket' => false,
            'status_kilo' => false,
            'beban_produksi' => '0.0',
            'status_item' => true,
        ]);



        JenisItem::create([
            'nama' => 'VITASCH TOPI',
            'kategori_id' => 11,
            'unit' => 'PCS',
            'bobot_bucket' => '0.0',
            'harga_premium' => 10000,
            'harga_bucket' => 0,
            'harga_kilo' => 0,
            'status_premium' => true,
            'status_bucket' => false,
            'status_kilo' => false,
            'beban_produksi' => '0.0',
            'status_item' => true,
        ]);



        JenisItem::create([
            'nama' => 'VITRAGE KASUR BAYI',
            'kategori_id' => 15,
            'unit' => 'PCS',
            'bobot_bucket' => '0.0',
            'harga_premium' => 58000,
            'harga_bucket' => 0,
            'harga_kilo' => 0,
            'status_premium' => true,
            'status_bucket' => false,
            'status_kilo' => false,
            'beban_produksi' => '10.0',
            'status_item' => true,
        ]);



        JenisItem::create([
            'nama' => 'JASA PACKING VAKUM',
            'kategori_id' => 12,
            'unit' => 'PCS',
            'bobot_bucket' => '0.0',
            'harga_premium' => 15000,
            'harga_bucket' => 0,
            'harga_kilo' => 0,
            'status_premium' => true,
            'status_bucket' => false,
            'status_kilo' => false,
            'beban_produksi' => '7.0',
            'status_item' => true,
        ]);



        JenisItem::create([
            'nama' => 'BRA',
            'kategori_id' => 10,
            'unit' => 'PCS',
            'bobot_bucket' => '0.5',
            'harga_premium' => 0,
            'harga_bucket' => 0,
            'harga_kilo' => 0,
            'status_premium' => false,
            'status_bucket' => true,
            'status_kilo' => false,
            'beban_produksi' => '0.5',
            'status_item' => true,
        ]);



        JenisItem::create([
            'nama' => 'CELANA KAIN PANJANG',
            'kategori_id' => 10,
            'unit' => 'PCS',
            'bobot_bucket' => '1.0',
            'harga_premium' => 0,
            'harga_bucket' => 0,
            'harga_kilo' => 0,
            'status_premium' => false,
            'status_bucket' => true,
            'status_kilo' => false,
            'beban_produksi' => '0.0',
            'status_item' => true,
        ]);



        JenisItem::create([
            'nama' => 'CELANA KAIN PENDEK',
            'kategori_id' => 10,
            'unit' => 'PCS',
            'bobot_bucket' => '1.0',
            'harga_premium' => 0,
            'harga_bucket' => 0,
            'harga_kilo' => 0,
            'status_premium' => false,
            'status_bucket' => true,
            'status_kilo' => false,
            'beban_produksi' => '0.0',
            'status_item' => true,
        ]);



        JenisItem::create([
            'nama' => 'JAKET JEANS',
            'kategori_id' => 10,
            'unit' => 'PCS',
            'bobot_bucket' => '3.0',
            'harga_premium' => 0,
            'harga_bucket' => 0,
            'harga_kilo' => 0,
            'status_premium' => false,
            'status_bucket' => true,
            'status_kilo' => false,
            'beban_produksi' => '0.0',
            'status_item' => true,
        ]);



        JenisItem::create([
            'nama' => 'JAKET KAIN',
            'kategori_id' => 10,
            'unit' => 'PCS',
            'bobot_bucket' => '3.0',
            'harga_premium' => 0,
            'harga_bucket' => 0,
            'harga_kilo' => 0,
            'status_premium' => false,
            'status_bucket' => true,
            'status_kilo' => false,
            'beban_produksi' => '0.0',
            'status_item' => true,
        ]);



        JenisItem::create([
            'nama' => 'JILBAB / KERUDUNG',
            'kategori_id' => 10,
            'unit' => 'PCS',
            'bobot_bucket' => '1.0',
            'harga_premium' => 0,
            'harga_bucket' => 0,
            'harga_kilo' => 0,
            'status_premium' => false,
            'status_bucket' => true,
            'status_kilo' => false,
            'beban_produksi' => '0.0',
            'status_item' => true,
        ]);



        JenisItem::create([
            'nama' => 'KAIN SARUNG',
            'kategori_id' => 10,
            'unit' => 'PCS',
            'bobot_bucket' => '2.0',
            'harga_premium' => 0,
            'harga_bucket' => 0,
            'harga_kilo' => 0,
            'status_premium' => false,
            'status_bucket' => true,
            'status_kilo' => false,
            'beban_produksi' => '0.0',
            'status_item' => true,
        ]);



        JenisItem::create([
            'nama' => 'KESET HANDUK',
            'kategori_id' => 10,
            'unit' => 'PCS',
            'bobot_bucket' => '1.0',
            'harga_premium' => 0,
            'harga_bucket' => 0,
            'harga_kilo' => 0,
            'status_premium' => false,
            'status_bucket' => true,
            'status_kilo' => false,
            'beban_produksi' => '0.0',
            'status_item' => true,
        ]);



        JenisItem::create([
            'nama' => 'PLASTIK',
            'kategori_id' => 10,
            'unit' => 'PCS',
            'bobot_bucket' => '1.0',
            'harga_premium' => 0,
            'harga_bucket' => 0,
            'harga_kilo' => 0,
            'status_premium' => false,
            'status_bucket' => true,
            'status_kilo' => false,
            'beban_produksi' => '0.0',
            'status_item' => true,
        ]);



        JenisItem::create([
            'nama' => 'SEPREI BEDCOVER',
            'kategori_id' => 10,
            'unit' => 'PCS',
            'bobot_bucket' => '8.0',
            'harga_premium' => 0,
            'harga_bucket' => 0,
            'harga_kilo' => 0,
            'status_premium' => false,
            'status_bucket' => true,
            'status_kilo' => false,
            'beban_produksi' => '0.0',
            'status_item' => true,
        ]);



        JenisItem::create([
            'nama' => 'UNDERWEAR',
            'kategori_id' => 10,
            'unit' => 'PCS',
            'bobot_bucket' => '0.5',
            'harga_premium' => 0,
            'harga_bucket' => 0,
            'harga_kilo' => 0,
            'status_premium' => false,
            'status_bucket' => true,
            'status_kilo' => false,
            'beban_produksi' => '0.5',
            'status_item' => true,
        ]);



        JenisItem::create([
            'nama' => 'JAKET BALAP',
            'kategori_id' => 4,
            'unit' => 'PCS',
            'bobot_bucket' => '0.0',
            'harga_premium' => 110000,
            'harga_bucket' => 0,
            'harga_kilo' => 0,
            'status_premium' => true,
            'status_bucket' => false,
            'status_kilo' => false,
            'beban_produksi' => '15.0',
            'status_item' => true,
        ]);



        JenisItem::create([
            'nama' => 'JASA PASANG GORDYN',
            'kategori_id' => 4,
            'unit' => 'PCS',
            'bobot_bucket' => '0.0',
            'harga_premium' => 50000,
            'harga_bucket' => 0,
            'harga_kilo' => 0,
            'status_premium' => true,
            'status_bucket' => false,
            'status_kilo' => false,
            'beban_produksi' => '8.0',
            'status_item' => true,
        ]);



        JenisItem::create([
            'nama' => 'KAIN SARUNG',
            'kategori_id' => 8,
            'unit' => 'PCS',
            'bobot_bucket' => '0.0',
            'harga_premium' => 25000,
            'harga_bucket' => 0,
            'harga_kilo' => 0,
            'status_premium' => true,
            'status_bucket' => false,
            'status_kilo' => false,
            'beban_produksi' => '10.0',
            'status_item' => true,
        ]);



        JenisItem::create([
            'nama' => 'KAOS DALAM DEWASA',
            'kategori_id' => 4,
            'unit' => 'PCS',
            'bobot_bucket' => '0.0',
            'harga_premium' => 18000,
            'harga_bucket' => 0,
            'harga_kilo' => 0,
            'status_premium' => true,
            'status_bucket' => false,
            'status_kilo' => false,
            'beban_produksi' => '2.0',
            'status_item' => true,
        ]);



        JenisItem::create([
            'nama' => 'KARPET BULU ASLI',
            'kategori_id' => 3,
            'unit' => 'PCS',
            'bobot_bucket' => '0.0',
            'harga_premium' => 125000,
            'harga_bucket' => 0,
            'harga_kilo' => 0,
            'status_premium' => true,
            'status_bucket' => false,
            'status_kilo' => false,
            'beban_produksi' => '15.0',
            'status_item' => true,
        ]);



        JenisItem::create([
            'nama' => 'KASUR BAYI',
            'kategori_id' => 15,
            'unit' => 'PCS',
            'bobot_bucket' => '0.0',
            'harga_premium' => 50000,
            'harga_bucket' => 0,
            'harga_kilo' => 0,
            'status_premium' => true,
            'status_bucket' => false,
            'status_kilo' => false,
            'beban_produksi' => '25.0',
            'status_item' => true,
        ]);



        JenisItem::create([
            'nama' => 'KASUR SINGLE',
            'kategori_id' => 15,
            'unit' => 'PCS',
            'bobot_bucket' => '0.0',
            'harga_premium' => 180000,
            'harga_bucket' => 0,
            'harga_kilo' => 0,
            'status_premium' => true,
            'status_bucket' => false,
            'status_kilo' => false,
            'beban_produksi' => '25.0',
            'status_item' => true,
        ]);



        JenisItem::create([
            'nama' => 'KEMBEN BIASA',
            'kategori_id' => 4,
            'unit' => 'PCS',
            'bobot_bucket' => '0.0',
            'harga_premium' => 25000,
            'harga_bucket' => 0,
            'harga_kilo' => 0,
            'status_premium' => true,
            'status_bucket' => false,
            'status_kilo' => false,
            'beban_produksi' => '5.0',
            'status_item' => true,
        ]);



        JenisItem::create([
            'nama' => 'KORSET',
            'kategori_id' => 3,
            'unit' => 'PCS',
            'bobot_bucket' => '0.0',
            'harga_premium' => 25000,
            'harga_bucket' => 0,
            'harga_kilo' => 0,
            'status_premium' => true,
            'status_bucket' => false,
            'status_kilo' => false,
            'beban_produksi' => '10.0',
            'status_item' => true,
        ]);



        JenisItem::create([
            'nama' => 'KURSI RODA',
            'kategori_id' => 3,
            'unit' => 'PCS',
            'bobot_bucket' => '0.0',
            'harga_premium' => 100000,
            'harga_bucket' => 0,
            'harga_kilo' => 0,
            'status_premium' => true,
            'status_bucket' => false,
            'status_kilo' => false,
            'beban_produksi' => '3.0',
            'status_item' => true,
        ]);



        JenisItem::create([
            'nama' => 'LAP PEMBERSIH',
            'kategori_id' => 3,
            'unit' => 'PCS',
            'bobot_bucket' => '0.0',
            'harga_premium' => 18000,
            'harga_bucket' => 0,
            'harga_kilo' => 0,
            'status_premium' => true,
            'status_bucket' => false,
            'status_kilo' => false,
            'beban_produksi' => '1.0',
            'status_item' => true,
        ]);



        JenisItem::create([
            'nama' => 'MASKER',
            'kategori_id' => 3,
            'unit' => 'PCS',
            'bobot_bucket' => '0.0',
            'harga_premium' => 20000,
            'harga_bucket' => 0,
            'harga_kilo' => 0,
            'status_premium' => true,
            'status_bucket' => false,
            'status_kilo' => false,
            'beban_produksi' => '1.0',
            'status_item' => true,
        ]);



        JenisItem::create([
            'nama' => 'MASKER MANIK',
            'kategori_id' => 3,
            'unit' => 'PCS',
            'bobot_bucket' => '0.0',
            'harga_premium' => 25000,
            'harga_bucket' => 0,
            'harga_kilo' => 0,
            'status_premium' => true,
            'status_bucket' => false,
            'status_kilo' => false,
            'beban_produksi' => '1.0',
            'status_item' => true,
        ]);



        JenisItem::create([
            'nama' => 'MUKENAH ATASAN ANAK',
            'kategori_id' => 6,
            'unit' => 'PCS',
            'bobot_bucket' => '0.0',
            'harga_premium' => 27500,
            'harga_bucket' => 0,
            'harga_kilo' => 0,
            'status_premium' => true,
            'status_bucket' => false,
            'status_kilo' => false,
            'beban_produksi' => '5.0',
            'status_item' => true,
        ]);



        JenisItem::create([
            'nama' => 'PAKET BABY STROLLER',
            'kategori_id' => 15,
            'unit' => 'PCS',
            'bobot_bucket' => '0.0',
            'harga_premium' => 110000,
            'harga_bucket' => 0,
            'harga_kilo' => 0,
            'status_premium' => true,
            'status_bucket' => false,
            'status_kilo' => false,
            'beban_produksi' => '10.0',
            'status_item' => true,
        ]);



        JenisItem::create([
            'nama' => 'PACKING VACUM',
            'kategori_id' => 12,
            'unit' => 'PCS',
            'bobot_bucket' => '0.0',
            'harga_premium' => 15000,
            'harga_bucket' => 0,
            'harga_kilo' => 0,
            'status_premium' => true,
            'status_bucket' => false,
            'status_kilo' => false,
            'beban_produksi' => '0.0',
            'status_item' => true,
        ]);



        JenisItem::create([
            'nama' => 'PLAYMAT',
            'kategori_id' => 15,
            'unit' => 'PCS',
            'bobot_bucket' => '0.0',
            'harga_premium' => 50000,
            'harga_bucket' => 0,
            'harga_kilo' => 0,
            'status_premium' => true,
            'status_bucket' => false,
            'status_kilo' => false,
            'beban_produksi' => '5.0',
            'status_item' => true,
        ]);



        JenisItem::create([
            'nama' => 'RANJANG BAYI',
            'kategori_id' => 15,
            'unit' => 'PCS',
            'bobot_bucket' => '0.0',
            'harga_premium' => 118000,
            'harga_bucket' => 0,
            'harga_kilo' => 0,
            'status_premium' => true,
            'status_bucket' => false,
            'status_kilo' => false,
            'beban_produksi' => '10.0',
            'status_item' => true,
        ]);



        JenisItem::create([
            'nama' => 'ROK CAPE',
            'kategori_id' => 8,
            'unit' => 'PCS',
            'bobot_bucket' => '0.0',
            'harga_premium' => 155000,
            'harga_bucket' => 0,
            'harga_kilo' => 0,
            'status_premium' => true,
            'status_bucket' => false,
            'status_kilo' => false,
            'beban_produksi' => '10.0',
            'status_item' => true,
        ]);



        JenisItem::create([
            'nama' => 'ROK KULIT PANJANG',
            'kategori_id' => 8,
            'unit' => 'PCS',
            'bobot_bucket' => '0.0',
            'harga_premium' => 85000,
            'harga_bucket' => 0,
            'harga_kilo' => 0,
            'status_premium' => true,
            'status_bucket' => false,
            'status_kilo' => false,
            'beban_produksi' => '5.0',
            'status_item' => true,
        ]);



        JenisItem::create([
            'nama' => 'ROK MUKENAH ANAK',
            'kategori_id' => 6,
            'unit' => 'PCS',
            'bobot_bucket' => '0.0',
            'harga_premium' => 30000,
            'harga_bucket' => 0,
            'harga_kilo' => 0,
            'status_premium' => true,
            'status_bucket' => false,
            'status_kilo' => false,
            'beban_produksi' => '5.0',
            'status_item' => true,
        ]);



        JenisItem::create([
            'nama' => 'SANDAL KAIN ',
            'kategori_id' => 17,
            'unit' => 'PCS',
            'bobot_bucket' => '0.0',
            'harga_premium' => 35000,
            'harga_bucket' => 0,
            'harga_kilo' => 0,
            'status_premium' => true,
            'status_bucket' => false,
            'status_kilo' => false,
            'beban_produksi' => '10.0',
            'status_item' => true,
        ]);



        JenisItem::create([
            'nama' => 'SANDAL KULIT / SUEDE',
            'kategori_id' => 17,
            'unit' => 'PCS',
            'bobot_bucket' => '0.0',
            'harga_premium' => 55000,
            'harga_bucket' => 0,
            'harga_kilo' => 0,
            'status_premium' => true,
            'status_bucket' => false,
            'status_kilo' => false,
            'beban_produksi' => '10.0',
            'status_item' => true,
        ]);



        JenisItem::create([
            'nama' => 'SARUNG BANTAL KULIT',
            'kategori_id' => 3,
            'unit' => 'PCS',
            'bobot_bucket' => '0.0',
            'harga_premium' => 35000,
            'harga_bucket' => 0,
            'harga_kilo' => 0,
            'status_premium' => true,
            'status_bucket' => false,
            'status_kilo' => false,
            'beban_produksi' => '4.0',
            'status_item' => true,
        ]);



        JenisItem::create([
            'nama' => 'SARUNG TANGAN KULIT ANAK',
            'kategori_id' => 5,
            'unit' => 'PCS',
            'bobot_bucket' => '0.0',
            'harga_premium' => 18000,
            'harga_bucket' => 0,
            'harga_kilo' => 0,
            'status_premium' => true,
            'status_bucket' => false,
            'status_kilo' => false,
            'beban_produksi' => '10.0',
            'status_item' => true,
        ]);



        JenisItem::create([
            'nama' => 'SELENDANG PESTA PANJANG',
            'kategori_id' => 14,
            'unit' => 'PCS',
            'bobot_bucket' => '0.0',
            'harga_premium' => 38500,
            'harga_bucket' => 0,
            'harga_kilo' => 0,
            'status_premium' => true,
            'status_bucket' => false,
            'status_kilo' => false,
            'beban_produksi' => '5.0',
            'status_item' => true,
        ]);



        JenisItem::create([
            'nama' => 'SET QUILTCOVER(1CB+1SP2SB+2SG)',
            'kategori_id' => 9,
            'unit' => 'PCS',
            'bobot_bucket' => '0.0',
            'harga_premium' => 110000,
            'harga_bucket' => 0,
            'harga_kilo' => 0,
            'status_premium' => true,
            'status_bucket' => false,
            'status_kilo' => false,
            'beban_produksi' => '25.0',
            'status_item' => true,
        ]);



        JenisItem::create([
            'nama' => 'SET ROBES WEDDING',
            'kategori_id' => 14,
            'unit' => 'PCS',
            'bobot_bucket' => '0.0',
            'harga_premium' => 75000,
            'harga_bucket' => 0,
            'harga_kilo' => 0,
            'status_premium' => true,
            'status_bucket' => false,
            'status_kilo' => false,
            'beban_produksi' => '25.0',
            'status_item' => true,
        ]);



        JenisItem::create([
            'nama' => 'SET SEPREI + BC + QUILTCOVER',
            'kategori_id' => 9,
            'unit' => 'PCS',
            'bobot_bucket' => '0.0',
            'harga_premium' => 150000,
            'harga_bucket' => 0,
            'harga_kilo' => 0,
            'status_premium' => true,
            'status_bucket' => false,
            'status_kilo' => false,
            'beban_produksi' => '25.0',
            'status_item' => true,
        ]);



        JenisItem::create([
            'nama' => 'SOFA BAYI',
            'kategori_id' => 15,
            'unit' => 'PCS',
            'bobot_bucket' => '0.0',
            'harga_premium' => 50000,
            'harga_bucket' => 0,
            'harga_kilo' => 0,
            'status_premium' => true,
            'status_bucket' => false,
            'status_kilo' => false,
            'beban_produksi' => '2.0',
            'status_item' => true,
        ]);



        JenisItem::create([
            'nama' => 'TSIRT ANAK',
            'kategori_id' => 4,
            'unit' => 'PCS',
            'bobot_bucket' => '0.0',
            'harga_premium' => 18000,
            'harga_bucket' => 0,
            'harga_kilo' => 0,
            'status_premium' => true,
            'status_bucket' => false,
            'status_kilo' => false,
            'beban_produksi' => '3.0',
            'status_item' => true,
        ]);



        JenisItem::create([
            'nama' => 'SET BEDCOVER SUTRA (1BC+1SP+2SB+2SG)',
            'kategori_id' => 9,
            'unit' => 'PCS',
            'bobot_bucket' => '0.0',
            'harga_premium' => 125000,
            'harga_bucket' => 0,
            'harga_kilo' => 0,
            'status_premium' => true,
            'status_bucket' => false,
            'status_kilo' => false,
            'beban_produksi' => '10.0',
            'status_item' => true,
        ]);



        JenisItem::create([
            'nama' => 'COVER KOPER',
            'kategori_id' => 18,
            'unit' => 'PCS',
            'bobot_bucket' => '0.0',
            'harga_premium' => 35000,
            'harga_bucket' => 0,
            'harga_kilo' => 0,
            'status_premium' => true,
            'status_bucket' => false,
            'status_kilo' => false,
            'beban_produksi' => '8.0',
            'status_item' => true,
        ]);
    }
}
