<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

/**
 * Class untuk export data pengeluaran ke Excel
 */
class LaporanPengeluaranExport implements FromArray, WithHeadings, WithTitle, WithStyles, WithColumnFormatting
{
    /**
     * Data pengeluaran yang akan di-export
     * @var array
     */
    protected $data;
    protected $startDate;
    protected $endDate;

    /**
     * Constructor untuk inisialisasi data
     * @param array $data Data pengeluaran yang akan di-export
     */
    public function __construct(array $data, $startDate = null, $endDate = null)
    {
        $this->startDate = $startDate;
        $this->endDate = $endDate;
        $this->data = array_map(function($item, $index) {
            return [
                'no' => $index + 1,
                'nama' => $item['nama'],
                'deskripsi' => $item['deskripsi'],
                'nominal' => $item['nominal'],
                'tanggal' => date('d-m-Y H:i', strtotime($item['created_at']))
            ];
        }, $data, array_keys($data));

        // Add total row
        $total = array_sum(array_column($this->data, 'nominal'));
        $this->data[] = [
            'no' => '',
            'nama' => '',
            'deskripsi' => 'TOTAL',
            'nominal' => $total,
            'tanggal' => ''
        ];
    }

    /**
     * Mendapatkan array data yang akan di-export
     * @return array
     */
    public function array(): array
    {
        return $this->data;
    }

    /**
     * Mendapatkan array header/judul kolom
     * @return array
     */
    public function headings(): array
    {
        $headers = [
            ['LAPORAN PENGELUARAN'],
            ['']
        ];

        if ($this->startDate && $this->endDate) {
            $headers[] = ['Periode: ' . date('d-m-Y', strtotime($this->startDate)) . ' s/d ' . date('d-m-Y', strtotime($this->endDate))];
            $headers[] = [''];
        }

        $headers[] = [
            'No',
            'Nama',
            'Deskripsi',
            'Nominal',
            'Tanggal'
        ];

        return $headers;
    }

    /**
     * Mendapatkan judul worksheet
     * @return string
     */
    public function title(): string
    {
        return 'Laporan Pengeluaran';
    }

    /**
     * Mengatur format kolom
     * @return array
     */
    public function columnFormats(): array
    {
        return [
            'D' => NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1,
        ];
    }

    /**
     * Mengatur style/tampilan worksheet
     * @param Worksheet $sheet
     * @return array
     */
    public function styles(Worksheet $sheet)
    {
        $lastRow = count($this->data) + 4; // 4 is the number of header rows

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
            $sheet->getStyle('A3')->applyFromArray([
                'font' => [
                    'bold' => true
                ]
            ]);
        }

        // Header style
        $sheet->getStyle('A3:E3')->applyFromArray([
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
        $sheet->getStyle('A4:E' . ($lastRow - 1))->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN
                ]
            ]
        ]);

        // Total row style
        $sheet->getStyle('A' . ($lastRow - 1) . ':E' . ($lastRow - 1))->applyFromArray([
            'font' => [
                'bold' => true
            ],
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => [
                    'rgb' => 'F2F2F2'
                ]
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN
                ]
            ]
        ]);

        // Alignment
        $sheet->getStyle('A:A')->getAlignment()->setHorizontal('center');
        $sheet->getStyle('D:D')->getAlignment()->setHorizontal('right');
        $sheet->getStyle('E:E')->getAlignment()->setHorizontal('center');

        // Column widths
        $sheet->getColumnDimension('A')->setWidth(5);
        $sheet->getColumnDimension('B')->setWidth(30);
        $sheet->getColumnDimension('C')->setWidth(40);
        $sheet->getColumnDimension('D')->setWidth(20);
        $sheet->getColumnDimension('E')->setWidth(20);

        // Merge cells for title
        $sheet->mergeCells('A1:E1');

        return [];
    }
}
