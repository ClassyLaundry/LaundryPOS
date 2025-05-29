<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class LaporanCuciExport implements FromArray, WithHeadings, WithTitle, WithStyles
{
    protected $data;
    protected $startDate;
    protected $endDate;

    public function __construct(array $data, $startDate = null, $endDate = null)
    {
        $this->data = $data;
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }

    public function array(): array
    {
        return $this->data;
    }

    public function headings(): array
    {
        $headers = [
            ['LAPORAN CUCI'],
        ];

        if ($this->startDate && $this->endDate) {
            $headers[] = ['Periode: ' . date('d-m-Y', strtotime($this->startDate)) . ' s/d ' . date('d-m-Y', strtotime($this->endDate))];
        } else {
            $headers[] = [''];
        }

        $headers[] = [
            'Tipe',
            'Nama Pelanggan',
            'Qty',
            'Tanggal Transaksi',
            'Nama Item',
            'Total',
            'Hutang',
            'Progres'
        ];

        return $headers;
    }

    public function title(): string
    {
        return 'Laporan Cuci';
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
        if ($this->startDate && $this->endDate) {
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
        $sheet->getStyle('A3:H3')->applyFromArray([
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
        $sheet->getStyle('A4:H' . ($lastRow))->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN
                ]
            ]
        ]);

        // Column widths
        $sheet->getColumnDimension('A')->setWidth(15);
        $sheet->getColumnDimension('B')->setWidth(30);
        $sheet->getColumnDimension('C')->setWidth(5);
        $sheet->getColumnDimension('D')->setWidth(20);
        $sheet->getColumnDimension('E')->setWidth(50);
        $sheet->getColumnDimension('F')->setWidth(10);

        // Merge cells for title and date range
        $sheet->mergeCells('A1:H1');
        $sheet->mergeCells('A2:H2');

        return [];
    }

}
