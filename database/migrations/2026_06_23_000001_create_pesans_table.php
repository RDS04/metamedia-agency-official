<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pesans', function (Blueprint $table) {
            $table->id();
            $table->string('nama_lengkap');
            $table->string('email');
            $table->unsignedTinyInteger('rating');          // 1-5 bintang
            $table->json('fitur_favorit')->nullable();      // array fitur yang dipilih
            $table->text('saran')->nullable();              // saran & masukan
            $table->string('rekomendasi')->nullable();      // Ya, pasti! / Mungkin / dst
            $table->boolean('tampil')->default(true);       // tampil di testimoni publik
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pesans');
    }
};
