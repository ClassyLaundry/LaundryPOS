<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

/**
 * Class untuk export data inventory ke Excel
 */
class InventoryExport implements FromArray, WithHeadings, WithTitle, WithStyles
{
    /**
     * Data inventory yang akan di-export
     * @var array
     */
    protected $data;

    /**
     * Constructor untuk inisialisasi data
     * @param array $data Data inventory yang akan di-export
     */
    public function __construct(array $data)
    {
        $this->data = array_map(function($item, $index) {
            return [
                'no' => $index + 1,
                'nama' => $item['nama'],
                'deskripsi' => $item['deskripsi'],
                'kategori' => $item['kategori'],
                'stok' => $item['stok']
            ];
        }, $data, array_keys($data));
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
            ['LAPORAN INVENTORY'],
            ['']
        ];

        $headers[] = [
            'No',
            'Nama',
            'Deskripsi',
            'Tipe',
            'Stok'
        ];

        return $headers;
    }

    /**
     * Mendapatkan judul worksheet
     * @return string
     */
    public function title(): string
    {
        return 'Laporan Inventory';
    }

    /**
     * Mengatur style/tampilan worksheet
     * @param Worksheet $sheet
     * @return array
     */
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

        // Mengatur style untuk header
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
        $sheet->getStyle('A4:E' . ($lastRow))->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN
                ]
            ]
        ]);

        // Mengatur alignment untuk kolom nomor
        $sheet->getStyle('A:A')->getAlignment()->setHorizontal('center');

        // Mengatur lebar kolom
        $sheet->getColumnDimension('A')->setWidth(5);
        $sheet->getColumnDimension('B')->setWidth(30);
        $sheet->getColumnDimension('C')->setWidth(40);
        $sheet->getColumnDimension('D')->setWidth(15);
        $sheet->getColumnDimension('E')->setWidth(10);

        // Merge cells for title
        $sheet->mergeCells('A1:E1');

        return [];
    }
}
