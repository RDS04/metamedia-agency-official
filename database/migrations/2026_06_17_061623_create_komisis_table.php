<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('komisis', function (Blueprint $table) {
            $table->id();
            $table->enum('kategori', ['mao', 'dosen_karyawan', 'mitra']);
            $table->string('nama_skema');
            $table->string('sistem_kuliah')->nullable();
            $table->unsignedInteger('target_bonus_ukt')->nullable();
            $table->unsignedBigInteger('bonus_pertama')->default(0);
            $table->unsignedBigInteger('bonus_lanjutan')->default(0);
            $table->unsignedBigInteger('bonus_per_mahasiswa')->default(0);
            $table->unsignedBigInteger('ukt_per_semester')->nullable();
            $table->decimal('potongan_ukt_persen', 5, 2)->nullable();
            $table->boolean('nominal_fleksibel')->default(false);
            $table->boolean('is_active')->default(true);
            $table->text('catatan')->nullable();
            $table->timestamps();
        });

        DB::table('komisis')->insert([
            [
                'kategori' => 'mao',
                'nama_skema' => 'Bonus Agent Mahasiswa/Orang Tua/Alumni',
                'sistem_kuliah' => 'Reguler',
                'target_bonus_ukt' => 4,
                'bonus_pertama' => 0,
                'bonus_lanjutan' => 0,
                'bonus_per_mahasiswa' => 250000,
                'ukt_per_semester' => null,
                'potongan_ukt_persen' => 10,
                'nominal_fleksibel' => false,
                'is_active' => true,
                'catatan' => 'Kurang dari 4 mahasiswa mendapat Rp250.000 per mahasiswa. Jika 4 mahasiswa registrasi ulang, mendapat potongan UKT 10% sampai tamat untuk 1 keluarga agent.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kategori' => 'mao',
                'nama_skema' => 'Bonus Executive Class',
                'sistem_kuliah' => 'Executive Class',
                'target_bonus_ukt' => 4,
                'bonus_pertama' => 0,
                'bonus_lanjutan' => 0,
                'bonus_per_mahasiswa' => 350000,
                'ukt_per_semester' => 13800000,
                'potongan_ukt_persen' => 15,
                'nominal_fleksibel' => false,
                'is_active' => true,
                'catatan' => 'UKT Executive Class Rp13.800.000 per semester. Kurang dari 4 mahasiswa mendapat Rp350.000 per mahasiswa. Jika 4 mahasiswa registrasi ulang, mendapat potongan UKT 15%.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kategori' => 'dosen_karyawan',
                'nama_skema' => 'Bonus Dosen dan Karyawan',
                'sistem_kuliah' => 'Reguler',
                'target_bonus_ukt' => 4,
                'bonus_pertama' => 125000,
                'bonus_lanjutan' => 250000,
                'bonus_per_mahasiswa' => 0,
                'ukt_per_semester' => null,
                'potongan_ukt_persen' => 10,
                'nominal_fleksibel' => false,
                'is_active' => true,
                'catatan' => 'Mahasiswa pertama Rp125.000. Mahasiswa ke-2 dan seterusnya tambahan Rp250.000 per mahasiswa. Jika 4 mahasiswa registrasi ulang, mendapat potongan UKT 10%.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kategori' => 'mitra',
                'nama_skema' => 'Bonus Mitra / Instansi MOU',
                'sistem_kuliah' => 'MOU',
                'target_bonus_ukt' => null,
                'bonus_pertama' => 0,
                'bonus_lanjutan' => 0,
                'bonus_per_mahasiswa' => 0,
                'ukt_per_semester' => null,
                'potongan_ukt_persen' => null,
                'nominal_fleksibel' => true,
                'is_active' => true,
                'catatan' => 'Bonus langsung ditransfer ke rekening masing-masing setelah masuk tahun ajaran baru. Nominal bonus mengikuti kesepakatan MOU.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('komisis');
    }
};
