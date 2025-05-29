<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use Maatwebsite\Excel\Concerns\WithTitle;

class LaporanKasMasukExport implements FromArray, WithHeadings, WithMapping, WithStyles, WithTitle
{
    protected $data;
    protected $sumOfEachPaymentMethod;
    protected $startDate;
    protected $endDate;

    public function __construct(array $data, $startDate = null, $endDate = null)
    {
        $this->data = $data;
        $this->sumOfEachPaymentMethod = [];
        $this->startDate = $startDate;
        $this->endDate = $endDate;

        // Calculate subtotals for each payment type
        foreach ($data as $row) {
            $type = $row['tipe_bayar'];
            if (!isset($this->sumOfEachPaymentMethod[$type])) {
                $this->sumOfEachPaymentMethod[$type] = 0;
            }
            $this->sumOfEachPaymentMethod[$type] += $row['nominal'];
        }
    }

    public function array(): array
    {
        $exportData = [];
        $currentType = null;
        $rowCount = 0;
        $grandTotal = 0;

        foreach ($this->data as $row) {
            // Add payment type header if it's a new type
            if ($currentType !== $row['tipe_bayar']) {
                if ($currentType !== null) {
                    // Add subtotal row for previous type
                    $exportData[] = [
                        'is_subtotal' => true,
                        'tipe_bayar' => $currentType,
                        'total' => $this->sumOfEachPaymentMethod[$currentType]
                    ];
                }
                $currentType = $row['tipe_bayar'];
                $rowCount = 0;
            }

            $exportData[] = $row;
            $rowCount++;
            $grandTotal += $row['nominal'];
        }

        // Add final subtotal
        if ($currentType !== null) {
            $exportData[] = [
                'is_subtotal' => true,
                'tipe_bayar' => $currentType,
                'total' => $this->sumOfEachPaymentMethod[$currentType]
            ];
        }

        // Add grand total
        $exportData[] = [
            'is_grand_total' => true,
            'total' => $grandTotal
        ];

        return $exportData;
    }

    public function headings(): array
    {
        $headers = [
            ['LAPORAN KAS MASUK'],
        ];

        if ($this->startDate && $this->endDate) {
            $headers[] = ['Periode: ' . date('d-m-Y', strtotime($this->startDate)) . ' s/d ' . date('d-m-Y', strtotime($this->endDate))];
        } else {
            $headers[] = [''];
        }

        $headers[] = [
            'TIPE BAYAR',
            'KODE PEMBAYARAN',
            'NOMOR ORDER',
            'TANGGAL TRANSAKSI',
            'PELANGGAN',
            'NOMINAL',
            'KETERANGAN',
            'OPERATOR'
        ];

        return $headers;
    }

    /**
     * Mendapatkan judul worksheet
     * @return string
     */
    public function title(): string
    {
        return 'Laporan Kas Masuk';
    }

    public function map($row): array
    {
        if (isset($row['is_grand_total']) && $row['is_grand_total']) {
            return [
                'TOTAL KAS MASUK',
                '',
                '',
                '',
                '',
                'Rp ' . number_format($row['total'], 0, ',', '.'),
                '',
                ''
            ];
        }

        if (isset($row['is_subtotal']) && $row['is_subtotal']) {
            return [
                'TOTAL KAS MASUK VIA ' . $row['tipe_bayar'],
                '',
                '',
                '',
                '',
                'Rp ' . number_format($row['total'], 0, ',', '.'),
                '',
                ''
            ];
        }

        return [
            $row['tipe_bayar'],
            $row['kode_pembayaran'],
            $row['nomor_order'],
            $row['tanggal_transaksi'],
            $row['pelanggan'],
            'Rp ' . number_format($row['nominal'], 0, ',', '.'),
            $row['keterangan'],
            $row['operator']
        ];
    }

    public function styles(Worksheet $sheet)
    {
        $lastRow = $sheet->getHighestRow();

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

        // Style for headers
        $sheet->getStyle('A3:H3')->applyFromArray([
            'font' => ['bold' => true],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['rgb' => 'E2EFDA']
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

        // Style for payment type headers and subtotals
        for ($row = 4; $row <= $lastRow; $row++) {
            $cellValue = $sheet->getCell('A' . $row)->getValue();

            if (strpos($cellValue, 'TOTAL KAS MASUK VIA') === 0) {
                $sheet->getStyle('A' . $row . ':H' . $row)->applyFromArray([
                    'font' => ['bold' => true],
                    'fill' => [
                        'fillType' => Fill::FILL_SOLID,
                        'startColor' => ['rgb' => 'E2EFDA']
                    ]
                ]);
            }

            // Style for grand total
            if ($cellValue === 'TOTAL KAS MASUK') {
                $sheet->getStyle('A' . $row . ':H' . $row)->applyFromArray([
                    'font' => ['bold' => true],
                    'fill' => [
                        'fillType' => Fill::FILL_SOLID,
                        'startColor' => ['rgb' => 'FFD700'] // Gold color for grand total
                    ]
                ]);
            }
        }

        // Auto-size columns
        foreach (range('A', 'H') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        // Merge cells for title and date range
        $sheet->mergeCells('A1:H1');
        $sheet->mergeCells('A2:H2');
        return [];
    }
}
