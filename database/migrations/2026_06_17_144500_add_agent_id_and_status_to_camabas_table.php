<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('camabas', function (Blueprint $table) {
            if (!Schema::hasColumn('camabas', 'agent_id')) {
                $table->foreignId('agent_id')
                    ->nullable()
                    ->after('id')
                    ->constrained('users')
                    ->nullOnDelete();
            }

            if (!Schema::hasColumn('camabas', 'status')) {
                $table->enum('status', [
                    'Prospek',
                    'Dihubungi',
                    'Sudah Daftar',
                    'Registrasi',
                    'Registrasi Ulang',
                    'Batal',
                ])->default('Prospek')->after('periode');
            }
        });
    }

    public function down(): void
    {
        Schema::table('camabas', function (Blueprint $table) {
            if (Schema::hasColumn('camabas', 'agent_id')) {
                $table->dropConstrainedForeignId('agent_id');
            }

            if (Schema::hasColumn('camabas', 'status')) {
                $table->dropColumn('status');
            }
        });
    }
};
