<?php

namespace App\Imports;

use App\Models\Admin1\Iwkbu;
use App\Models\Admin1\IwkbuPhone;
use Illuminate\Support\Collection;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithCalculatedFormulas;

class IwkbuImport implements ToCollection, WithHeadingRow, WithCalculatedFormulas
{
    private function parseNumber($value)
    {
        if ($value === null || $value === '' || $value === '-') {
            return null;
        }

        // hapus spasi
        $value = str_replace(' ', '', $value);

        // hapus titik (sebagai pemisah ribuan)
        $value = str_replace('.', '', $value);

        // ganti koma (,) jadi titik (.) untuk desimal
        $value = str_replace(',', '.', $value);

        return is_numeric($value) ? (float) $value : null;
    }

    private function transformDate($value)
    {
        try {
            if (is_numeric($value)) {
                return Date::excelToDateTimeObject($value)->format('Y-m-d');
            } elseif (!empty($value) && $value !== '-') {
                return date('Y-m-d', strtotime($value));
            }
            return null;
        } catch (\Exception $e) {
            return null;
        }
    }

    public function collection(Collection $rows)
    {
        $badanHukum = strtoupper(trim($row['badan_hukum'] ?? ''));

        // mapping angka ke teks
        $mapBadanHukum = [
            '1' => 'PT',
            '2' => 'CV',
            '3' => 'KOPERASI',
            '4' => 'YAYASAN',
            '5' => 'PERORANGAN',
            '6' => 'BUMN',
            '7' => 'BUMD',
        ];

        if (isset($mapBadanHukum[$badanHukum])) {
            $badanHukum = $mapBadanHukum[$badanHukum];
        }

        // kasih default kalau kosong
        if ($badanHukum === null || $badanHukum === '' || $badanHukum === '-') {
            $badanHukum = '-';
        }

        foreach ($rows as $row) {
            // normalisasi data kosong
            foreach ($row as $key => $value) {
                if ($value === null || trim($value) === '') {
                    $row[$key] = '-';
                }
            }

            $dok = strtoupper(trim($row['dok_perizinan'] ?? ''));
            $dok = in_array($dok, ['ADA', 'TIDAK ADA']) ? $dok : 'TIDAK ADA';

            // simpan data utama Iwkbu
            $iwkbu = Iwkbu::create([
                'wilayah'           => strtoupper(trim($row['wilayah'] ?? '-')),
                'no_polisi'         => $row['no_polisi'],
                'tarif'             => $this->parseNumber($row['tarif']),
                'undefined'         => $row['undefined'],
                'nominal_iwkbu'     => $this->parseNumber($row['nominal_iwkbu']),
                'trayek'            => $row['trayek'],
                'jenis' => strtoupper(trim($row['jenis'])),
                'tahun_pembuatan' => is_numeric($row['tahun_pembuatan']) ? (int)$row['tahun_pembuatan'] : null,
                'pic'               => $row['pic'],
                'badan_hukum'       => $badanHukum,
                'nama_perusahaan'   => $row['nama_perusahaan'],
                'alamat_lengkap'    => $row['alamat_lengkap'],
                'kel'               => $row['kel'],
                'kec'               => $row['kec'],
                'kota_kab'          => $row['kota_kab'],
                'tanggal_transaksi' => $this->transformDate($row['tgl_transaksi']),
                'loket_pembayaran'  => $row['loket_pembayaran'],
                'masa_berlaku_iwkbu'=> $this->transformDate($row['masa_berlaku_iwkbu']),
                'masa_laku_swdkllj' => $this->transformDate($row['masa_laku_swdkllj']),
                'status_kendaraan' => strtoupper(trim($row['status_kendaraan'])),
                'status_pembayaran' => strtoupper(trim($row['status_pembayaran'])),
                'nilai_outstanding' => $this->parseNumber($row['nilai_outstanding']),
                'hasil_konfirmasi'  => $row['hasil_konfirmasi'],
                'nama_pemilik'      => $row['nama_pemilik'],
                'nik'               => $row['nik'],
                'dok_perizinan'     => $dok,
                'tgl_bayar_os_iwkbu'    => $this->transformDate($row['tgl_bayar_os_iwkbu']),
                'nilai_bayar_os_iwkbu'  => $this->parseNumber($row['nilai_bayar_os_iwkbu_rp']),
                'tgl_pemeliharaan'      => $this->transformDate($row['tgl_pemeliharaan']),
                'nilai_pemeliharaan_os_iwkbu' => $this->parseNumber($row['nilai_pemeliharaan_os_iwkbu']),
                'keterangan'        => $row['keterangan'],
            ]);

            // simpan nomor hp (bisa banyak)
            $no_hp_raw = $row['no_hp'] ?? '';
            $nomors = preg_split('/[\/,;]+/', $no_hp_raw);

            foreach ($nomors as $nomor) {
                $nomor = trim($nomor);
                if ($nomor !== '') {
                    $iwkbu->phones()->create(['no_hp' => $nomor]);
                }
            }
        }
    }

    public function headingRow(): int
    {
        return 1;
    }
}
