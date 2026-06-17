<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Komisi extends Model
{
    protected $fillable = [
        'kategori',
        'nama_skema',
        'sistem_kuliah',
        'target_bonus_ukt',
        'bonus_pertama',
        'bonus_lanjutan',
        'bonus_per_mahasiswa',
        'ukt_per_semester',
        'potongan_ukt_persen',
        'nominal_fleksibel',
        'is_active',
        'catatan',
    ];

    protected function casts(): array
    {
        return [
            'target_bonus_ukt' => 'integer',
            'bonus_pertama' => 'integer',
            'bonus_lanjutan' => 'integer',
            'bonus_per_mahasiswa' => 'integer',
            'ukt_per_semester' => 'integer',
            'potongan_ukt_persen' => 'decimal:2',
            'nominal_fleksibel' => 'boolean',
            'is_active' => 'boolean',
        ];
    }

    public function getKategoriLabelAttribute(): string
    {
        return match ($this->kategori) {
            'mao' => 'Mahasiswa, Orang Tua, Alumni',
            'dosen_karyawan' => 'Dosen/Karyawan',
            'mitra' => 'Mitra / Instansi',
            default => ucfirst(str_replace('_', ' ', $this->kategori)),
        };
    }

    public function hitungBonus(int $jumlahMahasiswa): array
    {
        $jumlahMahasiswa = max(0, $jumlahMahasiswa);

        if ($this->nominal_fleksibel) {
            return [
                'total_bonus' => null,
                'bonus_ukt' => false,
            ];
        }

        if ($this->bonus_per_mahasiswa > 0) {
            $totalBonus = $jumlahMahasiswa * $this->bonus_per_mahasiswa;
        } else {
            $mahasiswaLanjutan = max(0, $jumlahMahasiswa - 1);
            $totalBonus = $jumlahMahasiswa > 0
                ? $this->bonus_pertama + ($mahasiswaLanjutan * $this->bonus_lanjutan)
                : 0;
        }

        return [
            'total_bonus' => $totalBonus,
            'bonus_ukt' => $this->target_bonus_ukt !== null && $jumlahMahasiswa >= $this->target_bonus_ukt,
        ];
    }
}
