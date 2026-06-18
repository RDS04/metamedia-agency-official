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
            $table->string('nik')->unique();
            $table->string('no_pendaftaran')->unique();
            $table->string('nama_lengkap');
            $table->date('tanggal_lahir')->nullable();
            $table->enum('jenis_kelamin', ['Laki-Laki', 'Perempuan'])->nullable();
            $table->string('program_studi');
            $table->enum('sistem_kuliah', ['Reguler', 'Mandiri','Mandiri_transfer', 'RPL',]);
            $table->string('periode')->nullable();
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
