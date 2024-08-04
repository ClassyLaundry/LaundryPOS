<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class LaporanSaldoExport implements FromArray,WithHeadings
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
            'Membership',
            'Nama Pelanggan',
            'Jenis Input',
            'Nominal',
            'Transaksi Terakhir',
            'Saldo Akhir',

        ];
    }
}
