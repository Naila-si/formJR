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
        Schema::create('iwkbus', function (Blueprint $table) {
            $table->id();
            $table->string('wilayah');
            $table->string('no_polisi');
            $table->decimal('tarif', 15, 2)->nullable();
            $table->string('undefined')->nullable();
            $table->decimal('nominal_iwkbu', 15, 2)->nullable();
            $table->string('trayek')->nullable();
            $table->string('jenis')->nullable();
            $table->year('tahun_pembuatan')->nullable();
            $table->string('pic')->nullable();
            $table->string('badan_hukum')->nullable();
            $table->string('nama_perusahaan')->nullable();
            $table->text('alamat_lengkap')->nullable();
            $table->string('kel', 100)->nullable();
            $table->string('kec', 100)->nullable();
            $table->string('kota_kab', 100)->nullable();
            $table->date('tanggal_transaksi')->nullable();
            $table->string('loket_pembayaran')->nullable();
            $table->date('masa_berlaku_iwkbu')->nullable();
            $table->date('masa_laku_swdkllj')->nullable();
            $table->string('status_pembayaran')->nullable();
            $table->string('status_kendaraan')->nullable();
            $table->decimal('nilai_outstanding', 15, 2)->nullable();
            $table->string('hasil_konfirmasi')->nullable();
            $table->string('no_hp', 20)->nullable();
            $table->string('nama_pemilik')->nullable();
            $table->string('nik', 50)->nullable();
            $table->enum('dok_perizinan', ['Ada','Tidak'])->default('Tidak');
            $table->date('tgl_bayar_os_iwkbu')->nullable();
            $table->decimal('nilai_bayar_os_iwkbu', 15, 2)->nullable();
            $table->date('tgl_pemeliharaan')->nullable();
            $table->decimal('nilai_pemeliharaan_os_iwkbu', 15, 2)->nullable();
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('iwkbus');
    }
};
