<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('agent_luars', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('phone');
            $table->string('password');
            // Referral dari Agent Internal
            $table->string('kode_referral_dipakai')->nullable(); // kode referral yg dipakai saat daftar
            $table->foreignId('agent_internal_id')->nullable()->constrained('users')->nullOnDelete(); // Agent Internal yg merekrut
            // Kode referral milik Agent Luar sendiri (untuk ditampilkan, tidak untuk rekrut lagi)
            $table->string('kode_referral')->unique()->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamp('email_verified_at')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('agent_luars');
    }
};
