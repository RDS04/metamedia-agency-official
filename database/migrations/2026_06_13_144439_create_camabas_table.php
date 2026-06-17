<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('camabas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('agent_id')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();
            $table->string('nama_lengkap');
            $table->string('nik', 20)->unique();
            $table->string('nomor_hp', 20);
            $table->enum('jenis_kelamin', [
                'Laki-Laki',
                'Perempuan'
            ]);
            $table->enum('program_studi', [
                "Sistem Informasi",
                "Informatika",
                "Bisnis Digital",
                "Desain Komunikasi Visual",
                "Pendidikan Teknologi Informasi",
                "Manajemen Ritel",
            ]);
            $table->enum('sistem_kuliah', [
                'Reguler',
                'Mandiri',
                'Mandiri_Transfer',
                'RPL',
            ]);
            $table->string('periode');
            $table->enum('status', [
                'Prospek',
                'Dihubungi',
                'Sudah Daftar',
                'Registrasi',
                'Registrasi Ulang',
                'Batal',
            ])->default('Prospek');
            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('camabas');
    }
};
