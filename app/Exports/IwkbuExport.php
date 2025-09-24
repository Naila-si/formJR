<?php

namespace App\Exports;

use App\Models\Admin1\Iwkbu;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class IwkbuExport implements FromCollection, WithHeadings, WithStyles
{
    public function collection()
    {
        return Iwkbu::all();
    }

     public function headings(): array
    {
        return [
            'Wilayah',
            'No Polisi',
            'Tarif',
            'Undefined',
            'Nominal IWKBU',
            'Trayek',
            'Jenis',
            'Tahun Pembuatan',
            'PIC',
            'Badan Hukum / Perorangan',
            'Nama Perusahaan',
            'Alamat Lengkap',
            'Kel',
            'Kec',
            'Kota/Kab',
            'Tanggal Transaksi',
            'Loket Pembayaran',
            'Masa Berlaku IWKBU',
            'Masa Laku SWDKLLJ',
            'Status Pembayaran',
            'Status Kendaraan',
            'Nilai Outstanding',
            'Hasil Konfirmasi',
            'No HP',
            'Nama Pemilik',
            'NIK',
            'Dok Perizinan',
            'Tgl Bayar OS',
            'Nilai Bayar OS',
            'Tgl Pemeliharaan',
            'Nilai Pemeliharaan OS',
            'Keterangan',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        // kasih border ke semua sel yang ada datanya
        $sheet->getStyle($sheet->calculateWorksheetDimension())
            ->getBorders()
            ->getAllBorders()
            ->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

        // bikin heading lebih tebal
        $sheet->getStyle('1')->getFont()->setBold(true);

        return [];
    }
}
