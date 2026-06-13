<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('mahasiswas', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->enum('jenis_kelamin', ['Laki-laki', 'Perempuan']);
            $table->string('agama');
            $table->text('alamat');
            $table->string('no_hp');
            $table->string('email');
            $table->string('asal_sekolah');
            $table->integer('tahun_lulus');
            $table->enum('program_studi', ['Sistem Informasi', 'Teknik Informatika', 'Manajemen Informatika', 'Pendidikan Matematika']);
            $table->enum('kelas', ['Reguler', 'Karyawan', 'Online']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mahasiswas');
    }
};
