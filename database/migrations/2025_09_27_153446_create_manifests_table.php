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
        Schema::create('manifests', function (Blueprint $table) {
            $table->id();
            $table->string('nama_kapal');
            $table->dateTime('tanggal_keberangkatan');
            $table->string('asal_keberangkatan');
            $table->integer('dewasa')->default(0);
            $table->integer('anak')->default(0);
            $table->integer('total_penumpang')->default(0);
            $table->integer('premi_asuransi')->default(0);
            $table->string('nama_agen');
            $table->string('telepon');
            $table->json('foto_manifest')->nullable(); // multiple files
            $table->longText('ttd_petugas_data')->nullable(); // base64 tanda tangan
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('manifests');
    }
};
