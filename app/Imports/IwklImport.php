<?php

namespace App\Imports;

use App\Models\Admin1\Iwkl;
use Maatwebsite\Excel\Concerns\ToModel;

class IwklImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Iwkl([
            'loket' => $row['loket'] ?? null,
            'kelas' => $row['kelas'] ?? null,
            'nama_perusahaan' => $row['nama_perusahaan'] ?? null,
            'nama_kapal' => $row['nama_kapal'] ?? null,
            'nama_pemilik_pengelola' => $row['nama_pemilik_pengelola'] ?? null,
            'alamat' => $row['alamat'] ?? null,
            'no_kontak' => $row['no_kontak'] ?? null,
            'tanggal_lahir' => $row['tanggal_lahir'] ?? null,
            'kapasitas_penumpang' => $row['kapasitas_penumpang'] ?? null,
            'tanggal_pks' => $row['tanggal_pks'] ?? null,
            'tanggal_berakhir_pks' => $row['tanggal_berakhir_pks'] ?? null,
            'tanggal_addendum' => $row['tanggal_addendum'] ?? null,
            'status_pks' => $row['status_pks'] ?? null,
            'status_pembayaran' => $row['status_pembayaran'] ?? null,
            'status_kapal' => $row['status_kapal'] ?? null,
            'potensi_per_bulan_rp' => $row['potensi_per_bulan_rp'] ?? null,
            'pas_besar_kecil' => $row['pas_besar_kecil'] ?? null,
            'sertifikat_keselamatan' => $row['sertifikat_keselamatan'] ?? null,
            'izin_trayek' => $row['izin_trayek'] ?? null,
            'tgl_jatuh_tempo_sertifikat' => $row['tgl_jatuh_tempo_sertifikat'] ?? null,
            'rute' => $row['rute'] ?? null,
            'sistem_pengutipan_iwkl' => $row['sistem_pengutipan_iwkl'] ?? null,
            'trayek' => $row['trayek'] ?? null,
            'perhitungan_tarif' => $row['perhitungan_tarif'] ?? null,
            'tarif_borongan' => $row['tarif_borongan'] ?? null,
            'keterangan' => $row['keterangan'] ?? null,
            'januari' => $row['januari'] ?? null,
            'februari' => $row['februari'] ?? null,
            'maret' => $row['maret'] ?? null,
            'april' => $row['april'] ?? null,
            'mei' => $row['mei'] ?? null,
            'juni' => $row['juni'] ?? null,
            'juli' => $row['juli'] ?? null,
            'agust' => $row['agust'] ?? null,
            'sept' => $row['sept'] ?? null,
            'okt' => $row['okt'] ?? null,
            'nov' => $row['nov'] ?? null,
            'des' => $row['des'] ?? null,
            'total' => $row['total'] ?? null,
            'persen_akt' => $row['persen_akt'] ?? null,
        ]);
    }
}
