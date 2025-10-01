<?php

namespace App\Models;

use App\Models\FormulirVerification;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Formulir extends Model
{
    use HasFactory;

    protected $table = 'formulirs';

    protected $fillable = [
        'tanggal_waktu',
        'nama_depan',
        'nama_belakang',
        'loket',
        'jabatan',
        'nama_pt',
        'jenis_angkutan',
        'nama_pengelola',
        'alamat',
        'telepon',
        'kendaraan',        // array/json
        'hasil_kunjungan',
        'hasil_file',       // array file path
        'tunggakan',
        'janji_bayar',
        'foto_kunjungan',   // array file path
        'evidence',         // array file path
        'profiling',        // array/json
        'ttd_petugas_data',
        'ttd_pemilik_data',
        'latitude',
        'longitude',
        'notes',
        'verification_status'
    ];

    protected $casts = [
        'kendaraan' => 'array',
        'profiling' => 'array',
        'hasil_file' => 'array',
        'foto_kunjungan' => 'array',
        'evidence' => 'array',
        'tanggal_waktu' => 'datetime',
        'janji_bayar' => 'date'
    ];

    public function verifications()
    {
        return $this->hasMany(FormulirVerification::class);
    }
}
