<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

class AgentTemplateExport implements FromArray, WithHeadings, WithStyles, WithColumnWidths, WithTitle
{
    public function title(): string
    {
        return 'Data Agent';
    }

    public function headings(): array
    {
        return [
            'name',
            'email',
            'phone',
            'status',
            'password',
        ];
    }

    public function array(): array
    {
        // Contoh data dummy
        return [
            ['Budi Santoso', 'budi@email.com', '081234567890', 'mahasiswa', 'password123'],
            ['Siti Rahayu', 'siti@email.com', '082345678901', 'alumni', 'password123'],
        ];
    }

    public function styles(Worksheet $sheet): array
    {
        return [
            // Heading row
            1 => [
                'font' => [
                    'bold' => true,
                    'color' => ['rgb' => 'FFFFFF'],
                    'size' => 11,
                ],
                'fill' => [
                    'fillType' => Fill::FILL_SOLID,
                    'startColor' => ['rgb' => '018FD7'],
                ],
                'alignment' => [
                    'horizontal' => Alignment::HORIZONTAL_CENTER,
                ],
            ],
        ];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 25,
            'B' => 30,
            'C' => 18,
            'D' => 20,
            'E' => 20,
        ];
    }
}
