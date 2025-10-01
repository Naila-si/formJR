<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Manifest extends Model
{
    use HasFactory;

     protected $fillable = [
        'nama_kapal',
        'tanggal_keberangkatan',
        'asal_keberangkatan',
        'dewasa',
        'anak',
        'total_penumpang',
        'premi_asuransi',
        'nama_agen',
        'telepon',
        'foto_manifest',
        'ttd_petugas_data',
    ];

    protected $casts = [
        'foto_manifest' => 'array',
    ];
}
