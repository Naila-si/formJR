<?php

namespace App\Models\Admin1;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Iwkl extends Model
{
    use HasFactory;

    // Nama tabel di database
    protected $table = 'iwkls'; // pastikan sesuai nama tabel

    // Kolom yang bisa diisi massal
    protected $fillable = [
        'loket',
        'kelas',
        'nama_perusahaan',
        'nama_kapal',
        'nama_pemilik_pengelola',
        'alamat',
        'no_kontak',
        'tanggal_lahir',
        'kapasitas_penumpang',
        'tanggal_pks',
        'tanggal_berakhir_pks',
        'tanggal_addendum',
        'status_pks',
        'status_pembayaran',
        'status_kapal',
        'potensi_per_bulan_rp',
        'pas_besar_kecil',
        'sertifikat_keselamatan',
        'izin_trayek',
        'tgl_jatuh_tempo_sertifikat',
        'rute',
        'sistem_pengutipan_iwkl',
        'trayek',
        'perhitungan_tarif',
        'tarif_borongan',
        'keterangan',
        'januari',
        'februari',
        'maret',
        'april',
        'mei',
        'juni',
        'juli',
        'agust',
        'sept',
        'okt',
        'nov',
        'des',
        'total',
        'persen_akt',
    ];
}
