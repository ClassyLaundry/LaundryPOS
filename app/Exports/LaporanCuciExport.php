<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;

class LaporanCuciExport implements FromArray, WithHeadings
{
    protected $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function array(): array
    {
        return $this->data;
    }
    public function headings(): array
    {
        return [
            'Tipe',
            'Nama Pelanggan',
            'Qty',
            'Tanggal Transaksi',
            'Nama Item',
            'Total',
            'Hutang',
            'Progres'
        ];
    }
}
