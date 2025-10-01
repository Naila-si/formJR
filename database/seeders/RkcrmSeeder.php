<?php

namespace Database\Seeders;

use App\Models\Rkcrm;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RkcrmSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Rkcrm::create([
            'nama_pegawai' => 'Dimas Andaru',
            'loket_samsat' => 'Pekanbaru Kota',
            'os_awal' => 1657000,
            'os_sampai_11_sept' => 1329000,
            'persen_os' => 80.21,
            'target_crm' => 11,
            'realisasi_po' => 9,
            'gap_po' => 2,
            'target_rupiah' => 662800,
            'realisasi_os_bayar' => 328000,
            'jml_kend_os_bayar' => 5,
            'nominal_os_bayar' => 328000,
            'persen_os_bayar' => 49.49,
            'jml_kend_pemeliharaan' => 0,
            'nominal_pemeliharaan' => 0
        ]);
    }
}
