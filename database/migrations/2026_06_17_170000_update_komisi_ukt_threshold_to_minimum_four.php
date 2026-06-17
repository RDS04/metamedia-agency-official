<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::table('komisis')
            ->where('kategori', 'mao')
            ->update([
                'catatan' => 'Membawa kurang dari 4 mahasiswa hingga registrasi ulang mendapat Bonus Per Mahasiswa. Membawa minimal 4 mahasiswa mendapat Bonus Per Mahasiswa + potongan UKT.',
                'updated_at' => now(),
            ]);

        DB::table('komisis')
            ->where('kategori', 'mitra')
            ->update([
                'catatan' => 'Kurang dari 4 mahasiswa mendapat Bonus Per Mahasiswa. Minimal 4 mahasiswa mendapat Bonus Per Mahasiswa + Potongan UKT.',
                'updated_at' => now(),
            ]);
    }

    public function down(): void
    {
        DB::table('komisis')
            ->where('kategori', 'mao')
            ->update([
                'catatan' => 'Membawa kurang dari 4 mahasiswa hingga registrasi ulang mendapat Bonus Per Mahasiswa. Membawa lebih dari 4 mahasiswa hingga registrasi ulang mendapat Bonus Per Mahasiswa + potongan UKT.',
                'updated_at' => now(),
            ]);

        DB::table('komisis')
            ->where('kategori', 'mitra')
            ->update([
                'catatan' => 'Kurang dari 4 mahasiswa mendapat Bonus Per Mahasiswa. Lebih dari 4 mahasiswa mendapat Bonus Per Mahasiswa + Potongan UKT.',
                'updated_at' => now(),
            ]);
    }
};
