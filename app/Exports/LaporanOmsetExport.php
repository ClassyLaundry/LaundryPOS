<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithMapping;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class LaporanOmsetExport implements FromArray, WithHeadings, WithTitle, WithStyles, WithMapping
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

    public function map($row): array
    {
        if (isset($row['is_daily_total']) && $row['is_daily_total']) {
            return [
                '',
                '',
                '',
                $row['Nama Pelanggan'],
                '',
                'Rp ' . number_format($row['Besar Omset'], 0, ',', '.'),
                ''
            ];
        }

        return [
            $row['Tanggal'],
            $row['Kode Transaksi'],
            $row['Kode Pelanggan'],
            $row['Nama Pelanggan'],
            $row['Status Transaksi'],
            'Rp ' . number_format($row['Besar Omset'], 0, ',', '.'),
            $row['Operator']
        ];
    }

    public function headings(): array
    {
        $headers = [
            ['LAPORAN OMSET'], [''],
        ];

        $headers[] = [
            'Tanggal',
            'Kode Transaksi',
            'Kode Pelanggan',
            'Nama Pelanggan',
            'Status Transaksi',
            'Besar Omset',
            'Operator'
        ];

        return $headers;
    }

    public function title(): string
    {
        return 'Laporan Omset';
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

        // Header style
        $sheet->getStyle('A3:G3')->applyFromArray([
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

        // Data style and daily total style
        $currentRow = 4; // Starting from row 4 (after headers)
        foreach ($this->data as $row) {
            if (isset($row['is_daily_total']) && $row['is_daily_total']) {
                // Style for daily total rows (green background, bold)
                $sheet->getStyle('A' . $currentRow . ':G' . $currentRow)->applyFromArray([
                    'font' => [
                        'bold' => true
                    ],
                    'fill' => [
                        'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                        'startColor' => [
                            'rgb' => 'C6EFCE' // Light green similar to table-success
                        ]
                    ],
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN
                        ]
                    ]
                ]);
            } else {
                // Style for regular data rows
                $sheet->getStyle('A' . $currentRow . ':G' . $currentRow)->applyFromArray([
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN
                        ]
                    ]
                ]);
            }
            $currentRow++;
        }

        // Column widths
        $sheet->getColumnDimension('A')->setWidth(15);
        $sheet->getColumnDimension('B')->setWidth(15);
        $sheet->getColumnDimension('C')->setWidth(15);
        $sheet->getColumnDimension('D')->setWidth(25);
        $sheet->getColumnDimension('E')->setWidth(15);
        $sheet->getColumnDimension('F')->setWidth(15);
        $sheet->getColumnDimension('G')->setWidth(25);

        // Merge cells for title
        $sheet->mergeCells('A1:G1');

        return [];
    }
}
