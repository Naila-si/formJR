<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Rkcrm extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_pegawai', 'loket_samsat', 'os_awal', 'os_sampai_11_sept',
        'persen_os', 'target_crm', 'realisasi_po', 'gap_po',
        'target_rupiah', 'realisasi_os_bayar', 'jml_kend_os_bayar',
        'nominal_os_bayar', 'persen_os_bayar', 'jml_kend_pemeliharaan',
        'nominal_pemeliharaan'
    ];
}
