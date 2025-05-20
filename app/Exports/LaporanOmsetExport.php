<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class LaporanOmsetExport implements FromArray, WithHeadings, WithTitle, WithStyles
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
            'Operator'
        ];
    }

    public function title(): string
    {
        return 'Laporan Omset';
    }

    public function styles(Worksheet $sheet)
    {
        return [
            // Style the first row as bold text
            1 => ['font' => ['bold' => true]],

            // Style the total rows with background color
            'A2:A1000' => [
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'color' => ['argb' => 'FFD9D9D9']
                ]
            ]
        ];
    }
}
