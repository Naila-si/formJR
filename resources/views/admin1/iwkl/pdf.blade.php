<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Data IWKL</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 10px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }
        th, td {
            border: 1px solid #444;
            padding: 5px;
            text-align: left;
        }
        th {
            background: #ddd;
        }
        h2 {
            text-align: center;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <h2>Data IWKL</h2>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Loket</th>
                <th>Kelas</th>
                <th>Nama Perusahaan</th>
                <th>Nama Kapal</th>
                <th>Nama Pemilik / Pengelola</th>
                <th>Alamat</th>
                <th>No. Kontak</th>
                <th>Tanggal Lahir</th>
                <th>Kapasitas Penumpang</th>
                <th>Tanggal PKS</th>
                <th>Tanggal Berakhir PKS</th>
                <th>Tanggal Addendum</th>
                <th>Status PKS</th>
                <th>Status Pembayaran</th>
                <th>Status Kapal</th>
                <th>Potensi Per Bulan (Rp)</th>
                <th>Pas Besar / Kecil</th>
                <th>Sertifikat Keselamatan</th>
                <th>Izin Trayek</th>
                <th>Tanggal Jatuh Tempo Sertifikat</th>
                <th>Rute</th>
                <th>Sistem Pengutipan IWKL</th>
                <th>Trayek</th>
                <th>Perhitungan Tarif</th>
                <th>Tarif Borongan</th>
                <th>Keterangan</th>
                <th>Januari</th>
                <th>Februari</th>
                <th>Maret</th>
                <th>April</th>
                <th>Mei</th>
                <th>Juni</th>
                <th>Juli</th>
                <th>Agust</th>
                <th>Sept</th>
                <th>Okt</th>
                <th>Nov</th>
                <th>Des</th>
                <th>Total</th>
                <th>% Akt 24 - 23</th>
            </tr>
        </thead>
        <tbody>
            @foreach($iwkls as $index => $iwkl)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $iwkl->loket }}</td>
                <td>{{ $iwkl->kelas }}</td>
                <td>{{ $iwkl->nama_perusahaan }}</td>
                <td>{{ $iwkl->nama_kapal }}</td>
                <td>{{ $iwkl->nama_pemilik_pengelola }}</td>
                <td>{{ $iwkl->alamat }}</td>
                <td>{{ $iwkl->no_kontak }}</td>
                <td>{{ $iwkl->tanggal_lahir }}</td>
                <td>{{ $iwkl->kapasitas_penumpang }}</td>
                <td>{{ $iwkl->tanggal_pks }}</td>
                <td>{{ $iwkl->tanggal_berakhir_pks }}</td>
                <td>{{ $iwkl->tanggal_addendum }}</td>
                <td>{{ $iwkl->status_pks }}</td>
                <td>{{ $iwkl->status_pembayaran }}</td>
                <td>{{ $iwkl->status_kapal }}</td>
                <td>{{ $iwkl->potensi_per_bulan_rp }}</td>
                <td>{{ $iwkl->pas_besar_kecil }}</td>
                <td>{{ $iwkl->sertifikat_keselamatan }}</td>
                <td>{{ $iwkl->izin_trayek }}</td>
                <td>{{ $iwkl->tgl_jatuh_tempo_sertifikat }}</td>
                <td>{{ $iwkl->rute }}</td>
                <td>{{ $iwkl->sistem_pengutipan_iwkl }}</td>
                <td>{{ $iwkl->trayek }}</td>
                <td>{{ $iwkl->perhitungan_tarif }}</td>
                <td>{{ $iwkl->tarif_borongan }}</td>
                <td>{{ $iwkl->keterangan }}</td>
                <td>{{ $iwkl->januari }}</td>
                <td>{{ $iwkl->februari }}</td>
                <td>{{ $iwkl->maret }}</td>
                <td>{{ $iwkl->april }}</td>
                <td>{{ $iwkl->mei }}</td>
                <td>{{ $iwkl->juni }}</td>
                <td>{{ $iwkl->juli }}</td>
                <td>{{ $iwkl->agust }}</td>
                <td>{{ $iwkl->sept }}</td>
                <td>{{ $iwkl->okt }}</td>
                <td>{{ $iwkl->nov }}</td>
                <td>{{ $iwkl->des }}</td>
                <td>{{ $iwkl->total }}</td>
                <td>{{ $iwkl->persen_akt }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
