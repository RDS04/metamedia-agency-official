<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class MahasiswaTemplateExport implements FromArray, WithHeadings, WithStyles
{
    /**
     * Return array of template data
     */
    public function array(): array
    {
        return [
            // Row 1 - Header
            // Akan di-handle oleh WithHeadings interface
            
            // Row 2 - Contoh data
            [
                '3275099999999999',
                'PMB2026001',
                'John Doe',
                '1990-01-01',
                'Laki-Laki',
                'Sistem Informasi',
                'Reguler',
                'PMB 2026 Gelombang 1',
            ],
        ];
    }

    /**
     * Define heading row
     */
    public function headings(): array
    {
        return [
            'NIK',
            'No Pendaftaran',
            'Nama Lengkap',
            'Tanggal Lahir',
            'Jenis Kelamin',
            'Program Studi',
            'Sistem Kuliah',
            'Periode',
        ];
    }

    /**
     * Apply styling
     */
    public function styles(Worksheet $sheet)
    {
        // Style header row
        $sheet->getStyle('A1:H1')->applyFromArray([
            'font' => [
                'bold' => true,
                'color' => ['rgb' => 'FFFFFF'],
            ],
            'fill' => [
                'fillType' => 'solid',
                'startColor' => ['rgb' => '018FD7'],
            ],
            'alignment' => [
                'horizontal' => 'center',
                'vertical' => 'center',
            ],
        ]);

        // Auto-size columns
        $sheet->getColumnDimension('A')->setWidth(18);
        $sheet->getColumnDimension('B')->setWidth(15);
        $sheet->getColumnDimension('C')->setWidth(20);
        $sheet->getColumnDimension('D')->setWidth(15);
        $sheet->getColumnDimension('E')->setWidth(15);
        $sheet->getColumnDimension('F')->setWidth(20);
        $sheet->getColumnDimension('G')->setWidth(15);
        $sheet->getColumnDimension('H')->setWidth(20);

        return $sheet;
    }
}
