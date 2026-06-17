<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::table('komisis')
            ->where('kategori', 'mitra')
            ->update([
                'target_bonus_ukt' => 10,
                'bonus_pertama' => 10000000,
                'bonus_lanjutan' => 0,
                'bonus_per_mahasiswa' => DB::raw('CASE WHEN bonus_per_mahasiswa > 0 THEN bonus_per_mahasiswa ELSE 250000 END'),
                'potongan_ukt_persen' => null,
                'catatan' => 'Kurang dari 10 mahasiswa registrasi ulang mendapat Bonus Per Mahasiswa. Tepat 10 mahasiswa mendapat Rp10.000.000. Lebih dari 10 mahasiswa mendapat Rp10.000.000 + Bonus Per Mahasiswa untuk mahasiswa tambahan.',
                'updated_at' => now(),
            ]);
    }

    public function down(): void
    {
        DB::table('komisis')
            ->where('kategori', 'mitra')
            ->update([
                'target_bonus_ukt' => 4,
                'bonus_pertama' => 0,
                'bonus_lanjutan' => 0,
                'potongan_ukt_persen' => 10,
                'catatan' => 'Kurang dari 4 mahasiswa mendapat Bonus Per Mahasiswa. Minimal 4 mahasiswa mendapat Bonus Per Mahasiswa + Potongan UKT.',
                'updated_at' => now(),
            ]);
    }
};
