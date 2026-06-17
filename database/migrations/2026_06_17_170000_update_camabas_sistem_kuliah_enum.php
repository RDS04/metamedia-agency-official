<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement("ALTER TABLE camabas MODIFY sistem_kuliah ENUM('Reguler', 'Mandiri', 'Mandiri_Tranfer', 'Mandiri_Transfer', 'RPL') NOT NULL");

        DB::table('camabas')
            ->where('sistem_kuliah', 'Mandiri_Tranfer')
            ->update(['sistem_kuliah' => 'Mandiri_Transfer']);

        DB::statement("ALTER TABLE camabas MODIFY sistem_kuliah ENUM('Reguler', 'Mandiri', 'Mandiri_Transfer', 'RPL') NOT NULL");
    }

    public function down(): void
    {
        DB::statement("ALTER TABLE camabas MODIFY sistem_kuliah ENUM('Reguler', 'Mandiri', 'Mandiri_Tranfer', 'Mandiri_Transfer', 'RPL') NOT NULL");

        DB::table('camabas')
            ->where('sistem_kuliah', 'Mandiri_Transfer')
            ->update(['sistem_kuliah' => 'Mandiri_Tranfer']);

        DB::statement("ALTER TABLE camabas MODIFY sistem_kuliah ENUM('Reguler', 'Mandiri', 'Mandiri_Tranfer', 'RPL') NOT NULL");
    }
};
