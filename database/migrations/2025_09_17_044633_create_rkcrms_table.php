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
        Schema::create('rkcrms', function (Blueprint $table) {
            $table->id();
            $table->string('nama_pegawai');
            $table->string('loket_samsat');
            $table->decimal('os_awal', 15, 2)->nullable();
            $table->decimal('os_sampai_11_sept', 15, 2)->nullable();
            $table->decimal('persen_os', 5, 2)->nullable();
            $table->decimal('target_crm', 15, 2)->nullable();
            $table->decimal('realisasi_po', 15, 2)->nullable();
            $table->decimal('gap_po', 15, 2)->nullable();
            $table->decimal('po_sampai_11_sept', 15, 2)->nullable();
            $table->decimal('target_rupiah', 15, 2)->nullable();
            $table->decimal('realisasi_os_bayar', 15, 2)->nullable();
            $table->integer('jml_kend_os_bayar')->nullable();
            $table->decimal('nominal_os_bayar', 15, 2)->nullable();
            $table->decimal('persen_os_bayar', 5, 2)->nullable();
            $table->integer('jml_kend_pemeliharaan')->nullable();
            $table->decimal('nominal_pemeliharaan', 15, 2)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rkcrms');
    }
};
