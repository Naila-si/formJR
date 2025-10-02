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
        Schema::create('day_metrics', function (Blueprint $table) {
            $table->id();

            // WAJIB: kolom 'date' yang dipakai seeder & controller
            $table->date('date')->unique();

            // tiga segmen persen (0-100)
            $table->unsignedTinyInteger('scheduled_ok')->default(40);       // biru
            $table->unsignedTinyInteger('done_on_schedule')->default(30);   // merah
            $table->unsignedTinyInteger('not_on_target')->default(30);      // kuning

            $table->json('notes')->nullable(); // keterangan bebas per tanggal
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('day_metrics');
    }
};
