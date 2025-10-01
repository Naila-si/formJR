<?php

namespace App\Imports;

use App\Models\Admin1\Iwkl;
use Maatwebsite\Excel\Concerns\ToModel;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Imports\HeadingRowFormatter;
use PhpOffice\PhpSpreadsheet\Cell\Cell; // tambahan

HeadingRowFormatter::default('slug');

class IwklImport implements ToModel, WithHeadingRow
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
            'tanggal_lahir' => isset($row['tanggal_lahir']) && is_numeric($row['tanggal_lahir']) ? Date::excelToDateTimeObject($row['tanggal_lahir'])->format('Y-m-d') : null,
            'kapasitas_penumpang' => $row['kapasitas_penumpang'] ?? null,
            'tanggal_pks' => isset($row['tanggal_pks']) && is_numeric($row['tanggal_pks']) ? Date::excelToDateTimeObject($row['tanggal_pks'])->format('Y-m-d') : null,
            'tanggal_berakhir_pks' => isset($row['tanggal_berakhir_pks']) && is_numeric($row['tanggal_berakhir_pks']) ? Date::excelToDateTimeObject($row['tanggal_berakhir_pks'])->format('Y-m-d') : null,
            'tanggal_addendum' => isset($row['tanggal_addendum']) && is_numeric($row['tanggal_addendum']) ? Date::excelToDateTimeObject($row['tanggal_addendum'])->format('Y-m-d') : null,
            'status_pks' => $row['status_pks'] ?? null,
            'status_pembayaran' => $row['status_pembayaran'] ?? null,
            'status_kapal' => $row['status_kapal'] ?? null,
            // gunakan floatval + getCalculatedValue untuk kolom numerik
            'potensi_per_bulan_rp' => isset($row['potensi_per_bulan_rp'])
                ? floatval($row['potensi_per_bulan_rp'])
                : null,
            'pas_besar_kecil' => $row['pas_besar_kecil'] ?? null,
            'sertifikat_keselamatan' => $row['sertifikat_keselamatan'] ?? null,
            'izin_trayek' => $row['izin_trayek'] ?? null,
            'tgl_jatuh_tempo_sertifikat' => isset($row['tgl_jatuh_tempo_sertifikat']) && is_numeric($row['tgl_jatuh_tempo_sertifikat']) ? Date::excelToDateTimeObject($row['tgl_jatuh_tempo_sertfikat'])->format('Y-m-d') : null,
            'rute' => $row['rute'] ?? null,
            'sistem_pengutipan_iwkl' => $row['sistem_pengutipan_iwkl'] ?? null,
            'trayek' => $row['trayek'] ?? null,
            'perhitungan_tarif' => $row['perhitungan_tarif'] ?? null,
            'tarif_borongan' => isset($row['tarif_borongan'])
                ? floatval($row['tarif_borongan'])
                : null,
            'keterangan' => $row['keterangan'] ?? null,
            'januari' => isset($row['januari']) ? floatval($row['januari']) : null,
            'februari' => isset($row['februari']) ? floatval($row['februari']) : null,
            'maret' => isset($row['maret']) ? floatval($row['maret']) : null,
            'april' => isset($row['april']) ? floatval($row['april']) : null,
            'mei' => isset($row['mei']) ? floatval($row['mei']) : null,
            'juni' => isset($row['juni']) ? floatval($row['juni']) : null,
            'juli' => isset($row['juli']) ? floatval($row['juli']) : null,
            'agust' => isset($row['agust']) ? floatval($row['agust']) : null,
            'sept' => isset($row['sept']) ? floatval($row['sept']) : null,
            'okt' => isset($row['okt']) ? floatval($row['okt']) : null,
            'nov' => isset($row['nov']) ? floatval($row['nov']) : null,
            'des' => isset($row['des']) ? floatval($row['des']) : null,
            'total' => isset($row['total']) ? floatval($row['total']) : null,
            'persen_akt' => isset($row['persen_akt']) ? floatval($row['persen_akt']) : null,
        ]);
    }
}
