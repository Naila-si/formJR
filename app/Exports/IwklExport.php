<?php

namespace App\Exports;

use App\Models\Admin1\Iwkl;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

class IwklExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return Iwkl::all();
    }

    public function headings(): array
    {
        return [
            'ID',
            'Loket',
            'Kelas',
            'Nama Perusahaan',
            'Nama Kapal',
            'Nama Pemilik / Pengelola',
            'Alamat',
            'No. Kontak',
            'Tanggal Lahir',
            'Kapasitas Penumpang',
            'Tanggal PKS',
            'Tanggal Berakhir PKS',
            'Tanggal Addendum',
            'Status PKS',
            'Status Pembayaran',
            'Status Kapal',
            'Potensi Per Bulan (Rp)',
            'Pas Besar / Kecil',
            'Sertifikat Keselamatan',
            'Izin Trayek',
            'Tanggal Jatuh Tempo Sertifikat',
            'Rute',
            'Sistem Pengutipan IWKL',
            'Trayek',
            'Perhitungan Tarif',
            'Tarif Borongan',
            'Keterangan',
            'Januari',
            'Februari',
            'Maret',
            'April',
            'Mei',
            'Juni',
            'Juli',
            'Agust',
            'Sept',
            'Okt',
            'Nov',
            'Des',
            'Total',
            '% Akt 24 - 23',
        ];
    }
}
