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
        Schema::create('formulirs', function (Blueprint $table) {
            $table->id();

            // Step 1: Data Kunjungan
            $table->dateTime('tanggal_waktu')->nullable();
            $table->string('nama_depan')->nullable();
            $table->string('nama_belakang')->nullable();
            $table->string('loket')->nullable();
            $table->string('nama_pt')->nullable();
            $table->string('jenis_angkutan')->nullable();
            $table->string('nama_pengelola')->nullable();
            $table->text('alamat')->nullable();
            $table->string('telepon')->nullable();

            // Step 2: Armada & Kendaraan → simpan JSON karena bisa banyak
            $table->json('kendaraan')->nullable(); // nopol, status, jumlah_bayar, file

            $table->text('hasil_kunjungan')->nullable();
            $table->date('janji_bayar')->nullable();

            // Step 3: Upload & Penilaian
            $table->json('foto_kunjungan')->nullable(); // array file
            $table->json('evidence')->nullable(); // array file
            $table->json('profiling')->nullable(); // respon, penumpang, izin, dll

            // Tanda tangan
            $table->text('ttd_petugas_data')->nullable();
            $table->text('ttd_pemilik_data')->nullable();

            // Lokasi
            $table->decimal('latitude', 10, 7)->nullable();
            $table->decimal('longitude', 10, 7)->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('formulirs');
    }
};
