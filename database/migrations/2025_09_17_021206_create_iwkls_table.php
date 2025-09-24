<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('iwkls', function (Blueprint $table) {
            $table->id();
            $table->string('loket')->nullable();
            $table->string('kelas')->nullable();
            $table->string('nama_perusahaan')->nullable();
            $table->string('nama_kapal')->nullable();
            $table->string('nama_pemilik_pengelola')->nullable();
            $table->text('alamat')->nullable();
            $table->string('no_kontak')->nullable();
            $table->date('tanggal_lahir')->nullable();
            $table->integer('kapasitas_penumpang')->nullable();
            $table->date('tanggal_pks')->nullable();
            $table->date('tanggal_berakhir_pks')->nullable();
            $table->date('tanggal_addendum')->nullable();
            $table->string('status_pks')->nullable();
            $table->string('status_pembayaran')->nullable();
            $table->string('status_kapal')->nullable();
            $table->decimal('potensi_per_bulan_rp', 15, 2)->nullable();
            $table->string('pas_besar_kecil')->nullable();
            $table->string('sertifikat_keselamatan')->nullable();
            $table->string('izin_trayek')->nullable();
            $table->date('tgl_jatuh_tempo_sertifikat')->nullable();
            $table->string('rute')->nullable();
            $table->string('sistem_pengutipan_iwkl')->nullable();
            $table->string('trayek')->nullable();
            $table->string('perhitungan_tarif')->nullable();
            $table->decimal('tarif_borongan', 15, 2)->nullable();
            $table->text('keterangan')->nullable();
            $table->decimal('januari', 15, 2)->nullable();
            $table->decimal('februari', 15, 2)->nullable();
            $table->decimal('maret', 15, 2)->nullable();
            $table->decimal('april', 15, 2)->nullable();
            $table->decimal('mei', 15, 2)->nullable();
            $table->decimal('juni', 15, 2)->nullable();
            $table->decimal('juli', 15, 2)->nullable();
            $table->decimal('agust', 15, 2)->nullable();
            $table->decimal('sept', 15, 2)->nullable();
            $table->decimal('okt', 15, 2)->nullable();
            $table->decimal('nov', 15, 2)->nullable();
            $table->decimal('des', 15, 2)->nullable();
            $table->decimal('total', 15, 2)->nullable();
            $table->decimal('persen_akt', 5, 2)->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('iwkls');
    }
};
