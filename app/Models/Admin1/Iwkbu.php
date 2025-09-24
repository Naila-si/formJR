<?php

namespace App\Models\Admin1;

use Illuminate\Database\Eloquent\Model;
use App\Models\Models\Admin1\IwkbuPhone;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Iwkbu extends Model
{
    use HasFactory;

    protected $table = 'iwkbus'; // pastikan nama tabel sesuai DB

    protected $fillable = [
        'wilayah',
        'no_polisi',
        'tarif',
        'undefined',
        'nominal_iwkbu',
        'trayek',
        'jenis',
        'tahun_pembuatan',
        'pic',
        'badan_hukum',
        'nama_perusahaan',
        'alamat_lengkap',
        'kel',
        'kec',
        'kota_kab',
        'tanggal_transaksi',
        'loket_pembayaran',
        'masa_berlaku_iwkbu',
        'masa_laku_swdkllj',
        'status_pembayaran',
        'status_kendaraan',
        'nilai_outstanding',
        'hasil_konfirmasi',
        'no_hp',
        'nama_pemilik',
        'nik',
        'dok_perizinan',
        'keterangan',
    ];

    // jika ada kolom dengan opsi tertentu bisa dibuat helper
    public static $options = [
        'wilayah' => ['PEKANBARU', 'ROHIL', 'DUMAI', 'INHIL', 'ROHUL', 'KUANSING', 'INHU', 'PELALAWAN', 'SIAK', 'KAMPAR', 'BENGKALIS', 'ACEH', '-' ],
        'undefined' => ['DU', 'EU', '-'],
        'trayek' => ['AJAP', 'AKDP', 'Angkutan Karyawan', 'AJDP', 'Taksi', 'AKAP', 'Pariwisata', 'Angdes', 'Angkutan Sekolah', '-'],
        'badan_hukum' => ['BH', 'PR', 'CV', '-'],
        'jenis'       => ['MINIBUS', 'MICROBUS', 'BUS', 'SEDAN', 'LIGHT TRUCK', 'JEEP', 'TAKSI', '-'],
        'status_pembayaran' => ['OUTSTANDING', 'DISPENSASI', 'LUNAS', '-'],
        'status_kendaraan'  => ['ARMADA PINDAH PO', 'BEROPERASI', 'CADANGAN', 'GANTI NOPOL', 'GANTI NOPOL BARU', 'MUTASI RUSAK SELAMANYA', 'OPERASI', 'PINDAH PO', 'PINDAH PO / MUTASI KELUAR', 'RUSAK SELAMANYA', 'RUSAK SEMENTARA', 'UBAH SIFAT', 'UBAH SIFAT / BENTUK', '-'],
        'hasil_konfirmasi'  => ['BEROPERASI BLM LUNAS', 'BEROPERASI LUNAS', 'DIJUAL', 'GANTI NOPOL', 'RUSAK SELAMANYA', 'RUSAK SEMENTARA', 'TIDAK BEROPERASI / CADANGAN', 'TIDAK DITEMUKAN', 'UBAH BENTUK', 'UBAH SIFAT', '-'],
        'dok_perizinan' => ['ADA','TIDAK ADA'],
    ];

    protected static function booted()
    {
        static::saving(function ($iwkbu) {
            foreach (self::$options as $column => $allowed) {
                if (isset($iwkbu->$column) && !in_array($iwkbu->$column, $allowed)) {
                    // kalau nilai nggak valid, bisa pakai default atau lempar error
                    throw new \Exception("Nilai kolom $column tidak valid: {$iwkbu->$column}");
                }
            }
        });
    }

    public function phones()
    {
        return $this->hasMany(IwkbuPhone::class, 'iwkbu_id');
    }

}
