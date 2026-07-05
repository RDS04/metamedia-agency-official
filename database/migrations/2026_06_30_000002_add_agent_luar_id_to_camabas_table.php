<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('camabas', function (Blueprint $table) {
            $table->foreignId('agent_luar_id')
                ->nullable()
                ->after('agent_id')
                ->constrained('agent_luars')
                ->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('camabas', function (Blueprint $table) {
            $table->dropForeign(['agent_luar_id']);
            $table->dropColumn('agent_luar_id');
        });
    }
};
