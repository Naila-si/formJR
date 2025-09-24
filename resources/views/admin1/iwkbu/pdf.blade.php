<!DOCTYPE html>
<html>
<head>
    <title>Data IWKBU</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 12px;
        }
        th, td {
            border: 1px solid #333;
            padding: 4px;
            text-align: center;
        }
    </style>
</head>
<body>
    <h2>Data IWKBU</h2>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Wilayah</th>
                <th>No Polisi</th>
                <th>Tarif</th>
                <th>Undefined</th>
                <th>Nominal IWKBU</th>
                <th>Trayek</th>
                <th>Jenis</th>
                <th>Tahun Pembuatan</th>
                <th>PIC</th>
                <th>Badan Hukum / Perorangan</th>
                <th>Nama Perusahaan</th>
                <th>Alamat Lengkap</th>
                <th>Kel</th>
                <th>Kec</th>
                <th>Kota/Kab</th>
                <th>Tanggal Transaksi</th>
                <th>Loket Pembayaran</th>
                <th>Masa Berlaku IWKBU</th>
                <th>Masa Laku SWDKLLJ Terakhir</th>
                <th>Status Pembayaran IWKBU</th>
                <th>Status Kendaraan</th>
                <th>Nilai Outstanding IWKBU (Rp)</th>
                <th>Hasil Konfirmasi</th>
                <th>No HP</th>
                <th>Nama Pemilik/Pengelola</th>
                <th>NIK / No Identitas</th>
                <th>Dok Perizinan</th>
                <th>Tgl Bayar OS IWKBU</th>
                <th>Nilai Bayar OS IWKBU</th>
                <th>Tgl Pemeliharaan</th>
                <th>Nilai Pemeliharaan OS IWKBU</th>
                <th>Keterangan</th>
            </tr>
        </thead>
        <tbody>
            @foreach($iwkbus as $i => $d)
            <tr>
                <td>{{ $i + 1 }}</td>
                <td>{{ $d->wilayah }}</td>
                <td>{{ $d->no_polisi }}</td>
                <td>{{ $d->tarif }}</td>
                <td>{{ $d->undefined }}</td>
                <td>{{ $d->nominal_iwkbu }}</td>
                <td>{{ $d->trayek }}</td>
                <td>{{ $d->jenis }}</td>
                <td>{{ $d->tahun_pembuatan }}</td>
                <td>{{ $d->pic }}</td>
                <td>{{ $d->badan_hukum }}</td>
                <td>{{ $d->nama_perusahaan }}</td>
                <td>{{ $d->alamat_lengkap }}</td>
                <td>{{ $d->kel }}</td>
                <td>{{ $d->kec }}</td>
                <td>{{ $d->kota_kab }}</td>
                <td>{{ $d->tanggal_transaksi }}</td>
                <td>{{ $d->loket_pembayaran }}</td>
                <td>{{ $d->masa_berlaku_iwkbu }}</td>
                <td>{{ $d->masa_laku_swdkllj }}</td>
                <td>{{ $d->status_pembayaran }}</td>
                <td>{{ $d->status_kendaraan }}</td>
                <td>{{ $d->nilai_outstanding }}</td>
                <td>{{ $d->hasil_konfirmasi }}</td>
                <td>{{ $d->no_hp }}</td>
                <td>{{ $d->nama_pemilik }}</td>
                <td>{{ $d->nik }}</td>
                <td>{{ $d->dok_perizinan }}</td>
                <td>{{ $d->tgl_bayar_os_iwkbu }}</td>
                <td>{{ $d->nilai_bayar_os_iwkbu }}</td>
                <td>{{ $d->tgl_pemeliharaan }}</td>
                <td>{{ $d->nilai_pemeliharaan_os_iwkbu }}</td>
                <td>{{ $d->keterangan }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
