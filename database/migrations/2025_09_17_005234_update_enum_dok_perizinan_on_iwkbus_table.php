<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::statement("ALTER TABLE iwkbus MODIFY dok_perizinan ENUM('ADA','TIDAK ADA') DEFAULT 'TIDAK ADA'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("ALTER TABLE iwkbus MODIFY dok_perizinan ENUM('Ada','Tidak') DEFAULT 'Tidak'");
    }
};
