<?php

namespace App\Imports;

use App\Models\Mahasiswa;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Exception;
use Illuminate\Validation\Rule;

class MahasiswaImport implements ToModel, WithHeadingRow, WithValidation
{
    /**
     * @param array $row
     *
     * @return Mahasiswa|null
     */
    public function model(array $row)
    {
        // Cek apakah row kosong atau berisi hanya null values
        if (empty(array_filter($row))) {
            return null;
        }

        return new Mahasiswa([
            'nik' => $row['nik'] ?? null,
            'no_pendaftaran' => $row['no_pendaftaran'] ?? null,
            'nama_lengkap' => $row['nama_lengkap'] ?? null,
            'tanggal_lahir' => isset($row['tanggal_lahir']) ? $this->parseDate($row['tanggal_lahir']) : null,
            'jenis_kelamin' => $row['jenis_kelamin'] ?? null,
            'program_studi' => $row['program_studi'] ?? null,
            'sistem_kuliah' => $row['sistem_kuliah'] ?? null,
            'periode' => $row['periode'] ?? null,
        ]);
    }

    /**
     * Validasi untuk setiap row
     */
    public function rules(): array
    {
        $programStudi = implode(',', Mahasiswa::PROGRAM_STUDI);
        
        return [
            '*.nik' => 'required|string',
            '*.no_pendaftaran' => 'nullable|string',
            '*.nama_lengkap' => 'required|string',
            '*.program_studi' => 'required|string|in:' . $programStudi,
            '*.sistem_kuliah' => 'required|string|in:Reguler,Mandiri,Mandiri_transfer,RPL',
        ];
    }

    /**
     * Parse date dari berbagai format Excel
     */
    private function parseDate($date)
    {
        if (empty($date)) {
            return null;
        }

        // Jika sudah format date, langsung kembalikan
        if ($date instanceof \DateTime) {
            return $date;
        }

        // Coba parse sebagai string
        try {
            return \Carbon\Carbon::createFromFormat('Y-m-d', $date)->toDateString();
        } catch (Exception $e) {
            try {
                return \Carbon\Carbon::parse($date)->toDateString();
            } catch (Exception $e) {
                return null;
            }
        }
    }
}
