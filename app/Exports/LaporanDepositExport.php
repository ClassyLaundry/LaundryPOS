<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

/**
 * Class untuk export data mutasi deposit ke Excel
 */
class LaporanDepositExport implements FromArray, WithHeadings, WithTitle, WithStyles
{
    /**
     * Data mutasi deposit yang akan di-export
     * @var array
     */
    protected $data;

    /**
     * Constructor untuk inisialisasi data
     * @param $data Data mutasi deposit yang akan di-export
     */
    public function __construct($data)
    {
        $this->data = $data->map(function($item, $index) {
            return [
                'no' => $index + 1,
                'nama' => $item->nama,
                'bergabung_sejak' => date('d-m-Y H:i', strtotime($item->created_at)),
                'transaksi_terakhir' => $item->transaksi_terakhir ? date('d-m-Y H:i', strtotime($item->transaksi_terakhir->created_at)) : '-',
                'saldo_pelanggan' => $item->saldo_akhir
            ];
        })->toArray();
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
            ['LAPORAN MUTASI DEPOSIT'],
            ['']
        ];

        $headers[] = [
            'No',
            'Nama pelanggan',
            'Bergabung sejak',
            'Transaksi terakhir',
            'Saldo pelanggan'
        ];

        return $headers;
    }

    /**
     * Mendapatkan judul worksheet
     * @return string
     */
    public function title(): string
    {
        return 'Laporan Mutasi Deposit';
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
        $sheet->getColumnDimension('C')->setWidth(25);
        $sheet->getColumnDimension('D')->setWidth(25);
        $sheet->getColumnDimension('E')->setWidth(25);

        // Merge cells for title
        $sheet->mergeCells('A1:E1');

        return [];
    }
}
