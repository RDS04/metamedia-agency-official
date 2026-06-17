<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::table('komisis')
            ->where('kategori', 'dosen_karyawan')
            ->update([
                'bonus_per_mahasiswa' => 0,
                'catatan' => 'Membawa 1 mahasiswa mendapat Bonus Mahasiswa Pertama. Mahasiswa ke-2 dan seterusnya mendapat Bonus Mahasiswa Lanjutan. Total bonus laporan dijumlahkan dari Bonus Mahasiswa Pertama + Bonus Mahasiswa Lanjutan.',
                'updated_at' => now(),
            ]);

        DB::table('komisis')
            ->where('kategori', 'mao')
            ->update([
                'catatan' => 'Membawa kurang dari 4 mahasiswa hingga registrasi ulang mendapat Bonus Per Mahasiswa. Membawa minimal 4 mahasiswa mendapat Bonus Per Mahasiswa + potongan UKT.',
                'updated_at' => now(),
            ]);

        DB::table('komisis')
            ->where('kategori', 'mitra')
            ->update([
                'target_bonus_ukt' => 4,
                'bonus_pertama' => 0,
                'bonus_lanjutan' => 0,
                'bonus_per_mahasiswa' => DB::raw('CASE WHEN bonus_per_mahasiswa > 0 THEN bonus_per_mahasiswa ELSE 250000 END'),
                'potongan_ukt_persen' => DB::raw('CASE WHEN potongan_ukt_persen IS NOT NULL THEN potongan_ukt_persen ELSE 10 END'),
                'nominal_fleksibel' => false,
                'catatan' => 'Kurang dari 4 mahasiswa mendapat Bonus Per Mahasiswa. Minimal 4 mahasiswa mendapat Bonus Per Mahasiswa + Potongan UKT.',
                'updated_at' => now(),
            ]);
    }

    public function down(): void
    {
        DB::table('komisis')
            ->where('kategori', 'mitra')
            ->update([
                'target_bonus_ukt' => null,
                'bonus_per_mahasiswa' => 0,
                'potongan_ukt_persen' => null,
                'nominal_fleksibel' => true,
                'catatan' => 'Bonus langsung ditransfer ke rekening masing-masing setelah masuk tahun ajaran baru. Nominal bonus mengikuti kesepakatan MOU.',
                'updated_at' => now(),
            ]);
    }
};
