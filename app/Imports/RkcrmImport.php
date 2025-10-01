<?php

namespace App\Imports;

use App\Models\Rkcrm;
use Maatwebsite\Excel\Concerns\ToModel;

class RkcrmImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        dd($row);
        
        return new Rkcrm([
            'nama_pegawai' => $row['nama_pegawai'],
            'loket_samsat' => $row['loket_samsat'],
            'os_awal' => $row['os_awal'] ?? 0,
            'os_sampai_11_sept' => $row['os_sampai'] ?? 0,
            'persen_os' => $row['persen_os'] ?? 0,
            'target_crm' => $row['target_crm'] ?? 0,
            'realisasi_po' => $row['realisasi_po'] ?? 0,
            'gap_po' => $row['gap_po'] ?? 0,
            'po_sampai_11_sept' => $row['s_d_11_sept_25'] ?? 0,
            'target_rupiah' => $row['target_rupiah'] ?? 0,
            'realisasi_os_bayar' => $row['realisasi_os_bayar'] ?? 0,
            'jml_kend_os_bayar' => $row['jml_kend'] ?? 0,
            'nominal_os_bayar' => $row['nominal_rp'] ?? 0,
            'persen_os_bayar' => $row['persen_os_bayar'] ?? 0,
            'jml_kend_pemeliharaan' => $row['jml_ked_pemeliharaan'] ?? 0,
            'nominal_pemeliharaan' => $row['nominal_pemeliharaan'] ?? 0,
        ]);
    }
}
