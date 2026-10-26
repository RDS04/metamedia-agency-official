<?php

namespace App\Exports;

use App\Helpers\StatusHelper;
use App\Models\Agent;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithCustomValueBinder;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Cell\Cell;
use PhpOffice\PhpSpreadsheet\Cell\DataType;
use PhpOffice\PhpSpreadsheet\Cell\DefaultValueBinder;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class CamabaExport extends DefaultValueBinder implements
    FromQuery,
    WithHeadings,
    WithMapping,
    WithStyles,
    ShouldAutoSize,
    WithTitle,
    WithColumnFormatting,
    WithCustomValueBinder
{
    protected array $filters;
    protected int $rowNumber = 0;

    public function __construct(array $filters = [])
    {
        $this->filters = $filters;
    }

    /**
     * Query data calon mahasiswa berdasarkan filter yang sedang aktif
     */
    public function query()
    {
        return Agent::with(['agent', 'agentLuar'])
            ->when(!empty($this->filters['search']), function ($query) {
                $search = $this->filters['search'];
                $query->where(function ($q) use ($search) {
                    $q->where('nama_lengkap', 'like', '%' . $search . '%')
                        ->orWhere('nik', 'like', '%' . $search . '%')
                        ->orWhere('nomor_hp', 'like', '%' . $search . '%')
                        ->orWhere('program_studi', 'like', '%' . $search . '%')
                        ->orWhere('sistem_kuliah', 'like', '%' . $search . '%')
                        ->orWhereHas('agent', function ($qAgent) use ($search) {
                            $qAgent->where('name', 'like', '%' . $search . '%');
                        })
                        ->orWhereHas('agentLuar', function ($qAgentLuar) use ($search) {
                            $qAgentLuar->where('name', 'like', '%' . $search . '%');
                        });
                });
            })
            ->when(!empty($this->filters['status']), function ($query) {
                $query->where('status', $this->filters['status']);
            })
            ->when(!empty($this->filters['agent_id']), function ($query) {
                $query->where('agent_id', $this->filters['agent_id']);
            })
            ->latest();
    }

    /**
     * Judul sheet
     */
    public function title(): string
    {
        return 'Data Calon Mahasiswa';
    }

    /**
     * Header kolom di file Excel
     */
    public function headings(): array
    {
        return [
            'No',
            'Nama Lengkap',
            'NIK / NIM',
            'Jenis Kelamin',
            'No. HP / WhatsApp',
            'Program Studi',
            'Sistem Kuliah',
            'Periode PMB',
            'Nama Agent',
            'Kategori Agent',
            'Status Camaba',
            'Tanggal Didaftarkan',
        ];
    }

    /**
     * Mapping data ke tiap kolom
     */
    public function map($camaba): array
    {
        $this->rowNumber++;

        $agentName = $camaba->agent?->name ?? $camaba->agentLuar?->name ?? 'Belum terhubung';
        $agentKategori = $camaba->agent
            ? StatusHelper::formatStatus($camaba->agent->status)
            : ($camaba->agentLuar ? 'Agent Umum' : '-');

        return [
            $this->rowNumber,
            $camaba->nama_lengkap,
            (string) ($camaba->nik ?? '-'),
            $camaba->jenis_kelamin ?? '-',
            (string) ($camaba->nomor_hp ?? '-'),
            $camaba->program_studi ?? '-',
            $camaba->sistem_kuliah ?? '-',
            $camaba->periode ?? '-',
            $agentName,
            $agentKategori,
            $camaba->status ?? 'Prospek',
            $camaba->created_at ? $camaba->created_at->format('d/m/Y H:i') : '-',
        ];
    }

    /**
     * Pastikan kolom NIK dan No HP disimpan sebagai teks agar 0 di depan dan digit panjang tidak rusak
     */
    public function bindValue(Cell $cell, $value)
    {
        if (in_array($cell->getColumn(), ['C', 'E'])) {
            $cell->setValueExplicit((string) $value, DataType::TYPE_STRING);
            return true;
        }

        return parent::bindValue($cell, $value);
    }

    /**
     * Format kolom teks untuk NIK dan No HP
     */
    public function columnFormats(): array
    {
        return [
            'C' => NumberFormat::FORMAT_TEXT,
            'E' => NumberFormat::FORMAT_TEXT,
        ];
    }

    /**
     * Tampilan dan styling sheet Excel
     */
    public function styles(Worksheet $sheet)
    {
        $highestRow = $sheet->getHighestRow();
        $highestColumn = $sheet->getHighestColumn();

        // Style header (baris 1)
        $sheet->getStyle("A1:{$highestColumn}1")->applyFromArray([
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
                'vertical' => Alignment::VERTICAL_CENTER,
            ],
        ]);

        $sheet->getRowDimension(1)->setRowHeight(28);

        // Style data baris
        if ($highestRow > 1) {
            $sheet->getStyle("A2:{$highestColumn}{$highestRow}")->applyFromArray([
                'alignment' => [
                    'vertical' => Alignment::VERTICAL_CENTER,
                ],
            ]);

            // Alignment spesifik kolom
            $sheet->getStyle("A2:A{$highestRow}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle("C2:E{$highestRow}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle("H2:H{$highestRow}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle("K2:L{$highestRow}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

            // Striping baris genap & tinggi baris
            for ($row = 2; $row <= $highestRow; $row++) {
                $sheet->getRowDimension($row)->setRowHeight(20);
                if ($row % 2 == 0) {
                    $sheet->getStyle("A{$row}:{$highestColumn}{$row}")->applyFromArray([
                        'fill' => [
                            'fillType' => Fill::FILL_SOLID,
                            'startColor' => ['rgb' => 'F8FAFC'],
                        ],
                    ]);
                }
            }

            // Border seluruh tabel
            $sheet->getStyle("A1:{$highestColumn}{$highestRow}")->applyFromArray([
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => Border::BORDER_THIN,
                        'color' => ['rgb' => 'CBD5E1'],
                    ],
                ],
            ]);
        }

        return $sheet;
    }
}
