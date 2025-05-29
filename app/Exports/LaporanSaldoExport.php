<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class LaporanSaldoExport implements FromArray, WithHeadings, WithTitle, WithStyles
{
    protected $data;
    protected $bulan;

    public function __construct(array $data, $bulan)
    {
        $this->data = $data;
        $this->bulan = $bulan;
    }

    public function array(): array
    {
        return $this->data;
    }

    public function headings(): array
    {
        $headers = [
            ['LAPORAN SALDO'],
        ];

        if ($this->bulan) {
            $headers[] = ['Periode: ' . date('M Y', strtotime($this->bulan))];
        } else {
            $headers[] = [''];
        }

        $headers[] = [
            'Membership',
            'Nama Pelanggan',
            'Jenis Input',
            'Nominal',
            'Transaksi Terakhir',
            'Saldo Akhir',
        ];

        return $headers;
    }

    public function title(): string
    {
        return 'Laporan Saldo';
    }

    public function styles(Worksheet $sheet)
    {
        $lastRow = count($this->data) + 3; // 3 is the number of header rows

        // Title style
        $sheet->getStyle('A1')->applyFromArray([
            'font' => [
                'bold' => true,
                'size' => 14
            ],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER
            ]
        ]);

        // Date range style
        if ($this->bulan) {
            $sheet->getStyle('A2')->applyFromArray([
                'font' => [
                    'bold' => true
                ],
                'alignment' => [
                    'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER
                ]
            ]);
        }

        // Header style
        $sheet->getStyle('A3:F3')->applyFromArray([
            'font' => [
                'bold' => true
            ],
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => [
                    'rgb' => 'E2EFDA'
                ]
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN
                ]
            ]
        ]);

        // Data style
        $sheet->getStyle('A4:F' . ($lastRow))->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN
                ]
            ]
        ]);

        // Column widths
        $sheet->getColumnDimension('A')->setWidth(20);
        $sheet->getColumnDimension('B')->setWidth(30);
        $sheet->getColumnDimension('C')->setWidth(15);
        $sheet->getColumnDimension('D')->setWidth(10);
        $sheet->getColumnDimension('E')->setWidth(20);
        $sheet->getColumnDimension('F')->setWidth(15);

        // Merge cells for title and date range
        $sheet->mergeCells('A1:F1');
        $sheet->mergeCells('A2:F2');

        return [];
    }

}
