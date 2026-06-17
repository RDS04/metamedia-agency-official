<?php

namespace Database\Seeders;

use App\Models\Agent;
use App\Models\Periode;
use App\Models\User;
use Illuminate\Database\Seeder;

class MitraCamabaSeeder extends Seeder
{
    public function run(): void
    {
        $periode = Periode::where('is_active', true)->first()
            ?? Periode::firstOrCreate(
                ['nama_periode' => 'PMB 2026', 'tahun' => 2026],
                [
                    'tanggal_mulai' => '2026-01-01',
                    'tanggal_selesai' => '2026-12-31',
                    'is_active' => true,
                ]
            );

        $mitra = User::whereRaw('LOWER(name) = ?', ['agam'])->firstOrFail();

        $mitra->forceFill([
            'status' => 'mitra',
            'is_active' => true,
        ])->save();

        $camabas = [
            ['nama_lengkap' => 'Ahmad Fauzan', 'nik' => '3276011700010001', 'nomor_hp' => '081300000001', 'jenis_kelamin' => 'Laki-Laki', 'program_studi' => 'Sistem Informasi', 'sistem_kuliah' => 'Reguler', 'status' => 'Registrasi Ulang'],
            ['nama_lengkap' => 'Siti Nurhaliza', 'nik' => '3276011700010002', 'nomor_hp' => '081300000002', 'jenis_kelamin' => 'Perempuan', 'program_studi' => 'Informatika', 'sistem_kuliah' => 'Reguler', 'status' => 'Registrasi Ulang'],
            ['nama_lengkap' => 'Rizky Pratama', 'nik' => '3276011700010003', 'nomor_hp' => '081300000003', 'jenis_kelamin' => 'Laki-Laki', 'program_studi' => 'Bisnis Digital', 'sistem_kuliah' => 'Mandiri', 'status' => 'Registrasi Ulang'],
            ['nama_lengkap' => 'Dewi Lestari', 'nik' => '3276011700010004', 'nomor_hp' => '081300000004', 'jenis_kelamin' => 'Perempuan', 'program_studi' => 'Desain Komunikasi Visual', 'sistem_kuliah' => 'Mandiri', 'status' => 'Registrasi Ulang'],
            ['nama_lengkap' => 'Bagas Saputra', 'nik' => '3276011700010005', 'nomor_hp' => '081300000005', 'jenis_kelamin' => 'Laki-Laki', 'program_studi' => 'Pendidikan Teknologi Informasi', 'sistem_kuliah' => 'RPL', 'status' => 'Sudah Daftar'],
            ['nama_lengkap' => 'Nadia Putri', 'nik' => '3276011700010006', 'nomor_hp' => '081300000006', 'jenis_kelamin' => 'Perempuan', 'program_studi' => 'Manajemen Ritel', 'sistem_kuliah' => 'Reguler', 'status' => 'Sudah Daftar'],
            ['nama_lengkap' => 'Fajar Ramadhan', 'nik' => '3276011700010007', 'nomor_hp' => '081300000007', 'jenis_kelamin' => 'Laki-Laki', 'program_studi' => 'Sistem Informasi', 'sistem_kuliah' => 'Mandiri_Transfer', 'status' => 'Registrasi'],
            ['nama_lengkap' => 'Maya Salsabila', 'nik' => '3276011700010008', 'nomor_hp' => '081300000008', 'jenis_kelamin' => 'Perempuan', 'program_studi' => 'Informatika', 'sistem_kuliah' => 'Reguler', 'status' => 'Prospek'],
            ['nama_lengkap' => 'Ilham Maulana', 'nik' => '3276011700010009', 'nomor_hp' => '081300000009', 'jenis_kelamin' => 'Laki-Laki', 'program_studi' => 'Bisnis Digital', 'sistem_kuliah' => 'Mandiri', 'status' => 'Prospek'],
            ['nama_lengkap' => 'Citra Anggraini', 'nik' => '3276011700010010', 'nomor_hp' => '081300000010', 'jenis_kelamin' => 'Perempuan', 'program_studi' => 'Desain Komunikasi Visual', 'sistem_kuliah' => 'RPL', 'status' => 'Dihubungi'],
        ];

        foreach ($camabas as $camaba) {
            Agent::updateOrCreate(
                ['nik' => $camaba['nik']],
                [
                    ...$camaba,
                    'agent_id' => $mitra->id,
                    'periode' => $periode->nama_periode,
                ]
            );
        }
    }
}
