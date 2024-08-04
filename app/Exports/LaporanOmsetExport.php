<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;

class LaporanOmsetExport implements FromArray, WithHeadings
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
            'Tanggal',
            'Kode Transaksi',
            'Kode Pelanggan',
            'Nama Pelanggan',
            'Status Transaksi',
            'Besar Omset',
        ];
    }
}
