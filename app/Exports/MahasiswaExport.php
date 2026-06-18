<?php

namespace App\Exports;

use App\Models\Mahasiswa;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class MahasiswaExport implements FromQuery, WithHeadings, WithStyles, ShouldAutoSize
{
    /**
     * Query untuk export semua data mahasiswa
     */
    public function query()
    {
        return Mahasiswa::query();
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

        // Style data rows (alternating background)
        $highestRow = $sheet->getHighestRow();
        for ($row = 2; $row <= $highestRow; $row++) {
            if ($row % 2 == 0) {
                $sheet->getStyle("A{$row}:H{$row}")->applyFromArray([
                    'fill' => [
                        'fillType' => 'solid',
                        'startColor' => ['rgb' => 'F3F4F6'],
                    ],
                ]);
            }
        }

        return $sheet;
    }
}
