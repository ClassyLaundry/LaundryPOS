<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\WithTitle;

class LaporanPiutangPelangganExport implements FromArray, WithHeadings, WithMapping, WithStyles, WithEvents, WithTitle
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
        $headers = [
            ['LAPORAN PIUTANG PELANGGAN'],
            ['']
        ];

        $headers[] = ['Kode Pelanggan', 'Nama Pelanggan', 'No', 'Kode Transaksi', 'Tanggal Transaksi', 'Total Tagihan', 'Kurang Bayar'];

        return $headers;
    }

    /**
     * Mendapatkan judul worksheet
     * @return string
     */
    public function title(): string
    {
        return 'Laporan Piutang Pelanggan';
    }

    public function map($row): array
    {
        return [
            $row['kode_pelanggan'],
            $row['nama'],
            $row['no'],
            $row['kode_transaksi'],
            $row['tanggal_transaksi'],
            'Rp ' . number_format($row['total_tagihan'], 0, ',', '.'),
            'Rp ' . number_format($row['kurang_bayar'], 0, ',', '.'),
        ];
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

        // Mengatur style untuk header
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

        // Data style
        $sheet->getStyle('A4:G' . ($lastRow))->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN
                ]
            ]
        ]);

        // Mengatur alignment untuk kolom nomor
        $sheet->getStyle('C:C')->getAlignment()->setHorizontal('center');
        // Mengatur lebar kolom
        $sheet->getColumnDimension('A')->setWidth(15);
        $sheet->getColumnDimension('B')->setWidth(30);
        $sheet->getColumnDimension('C')->setWidth(5);
        $sheet->getColumnDimension('D')->setWidth(25);
        $sheet->getColumnDimension('E')->setWidth(25);
        $sheet->getColumnDimension('F')->setWidth(25);
        $sheet->getColumnDimension('G')->setWidth(25);

        // Merge cells for title
        $sheet->mergeCells('A1:G1');

        return [];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                $rowNum = 4; // Data starts after 3 header rows
                foreach ($this->data as $row) {
                    if (!empty($row['is_summary']) && $row['is_summary']) {
                        $event->sheet->getStyle("A{$rowNum}:G{$rowNum}")->applyFromArray([
                            'font' => [
                                'bold' => true,
                            ],
                        ]);
                    }
                    $rowNum++;
                }
            }
        ];
    }
}
