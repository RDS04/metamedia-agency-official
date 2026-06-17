<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Komisi extends Model
{
    private const MITRA_TARGET_MAHASISWA = 10;
    private const MITRA_BONUS_TARGET = 10000000;

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
                'bonus_pertama_total' => 0,
                'bonus_lanjutan_total' => 0,
                'bonus_per_mahasiswa_total' => 0,
                'jumlah_bonus_pertama' => 0,
                'jumlah_bonus_lanjutan' => 0,
                'jumlah_bonus_per_mahasiswa' => 0,
            ];
        }

        $bonusPertamaTotal = 0;
        $bonusLanjutanTotal = 0;
        $bonusPerMahasiswaTotal = 0;
        $jumlahBonusPertama = 0;
        $jumlahBonusLanjutan = 0;
        $jumlahBonusPerMahasiswa = 0;

        if ($this->kategori === 'mitra') {
            $targetMitra = (int) ($this->target_bonus_ukt ?: self::MITRA_TARGET_MAHASISWA);
            $bonusTargetMitra = (int) ($this->bonus_pertama ?: self::MITRA_BONUS_TARGET);

            if ($jumlahMahasiswa >= $targetMitra) {
                $jumlahBonusPertama = 1;
                $jumlahBonusPerMahasiswa = max(0, $jumlahMahasiswa - $targetMitra);
                $bonusPertamaTotal = $bonusTargetMitra;
                $bonusPerMahasiswaTotal = $jumlahBonusPerMahasiswa * $this->bonus_per_mahasiswa;
                $totalBonus = $bonusPertamaTotal + $bonusPerMahasiswaTotal;
            } else {
                $jumlahBonusPerMahasiswa = $jumlahMahasiswa;
                $bonusPerMahasiswaTotal = $jumlahBonusPerMahasiswa * $this->bonus_per_mahasiswa;
                $totalBonus = $bonusPerMahasiswaTotal;
            }
        } elseif ($this->kategori === 'dosen_karyawan') {
            $jumlahBonusPertama = $jumlahMahasiswa > 0 ? 1 : 0;
            $jumlahBonusLanjutan = max(0, $jumlahMahasiswa - 1);
            $bonusPertamaTotal = $jumlahBonusPertama * $this->bonus_pertama;
            $bonusLanjutanTotal = $jumlahBonusLanjutan * $this->bonus_lanjutan;
            $totalBonus = $bonusPertamaTotal + $bonusLanjutanTotal;
        } elseif ($this->bonus_per_mahasiswa > 0) {
            $jumlahBonusPerMahasiswa = $jumlahMahasiswa;
            $bonusPerMahasiswaTotal = $jumlahBonusPerMahasiswa * $this->bonus_per_mahasiswa;
            $totalBonus = $bonusPerMahasiswaTotal;
        } else {
            $jumlahBonusPertama = $jumlahMahasiswa > 0 ? 1 : 0;
            $jumlahBonusLanjutan = max(0, $jumlahMahasiswa - 1);
            $bonusPertamaTotal = $jumlahBonusPertama * $this->bonus_pertama;
            $bonusLanjutanTotal = $jumlahBonusLanjutan * $this->bonus_lanjutan;
            $totalBonus = $jumlahMahasiswa > 0
                ? $bonusPertamaTotal + $bonusLanjutanTotal
                : 0;
        }

        $bonusUkt = $this->memenuhiTargetBonusUkt($jumlahMahasiswa);

        return [
            'total_bonus' => $totalBonus,
            'bonus_ukt' => $bonusUkt,
            'bonus_pertama_total' => $bonusPertamaTotal,
            'bonus_lanjutan_total' => $bonusLanjutanTotal,
            'bonus_per_mahasiswa_total' => $bonusPerMahasiswaTotal,
            'jumlah_bonus_pertama' => $jumlahBonusPertama,
            'jumlah_bonus_lanjutan' => $jumlahBonusLanjutan,
            'jumlah_bonus_per_mahasiswa' => $jumlahBonusPerMahasiswa,
        ];
    }

    public function bonusUntukUrutan(int $urutan): ?int
    {
        if ($this->nominal_fleksibel || $urutan < 1) {
            return null;
        }

        if ($this->kategori === 'dosen_karyawan') {
            return $urutan === 1
                ? (int) $this->bonus_pertama
                : (int) $this->bonus_lanjutan;
        }

        if ($this->bonus_per_mahasiswa > 0) {
            return (int) $this->bonus_per_mahasiswa;
        }

        return $urutan === 1
            ? (int) $this->bonus_pertama
            : (int) $this->bonus_lanjutan;
    }

    public function memenuhiTargetBonusUkt(int $jumlahMahasiswa): bool
    {
        $targetBonusUkt = $this->target_bonus_ukt;

        return $targetBonusUkt !== null
            && $this->potongan_ukt_persen !== null
            && max(0, $jumlahMahasiswa) >= $targetBonusUkt;
    }
}
