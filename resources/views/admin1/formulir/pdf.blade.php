<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Formulir</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; }
        h2 { text-align: center; margin-bottom: 20px; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 15px; }
        th, td { border: 1px solid #333; padding: 6px; vertical-align: top; }
        .section { margin-bottom: 20px; }
        .image-box { display: inline-block; margin: 5px; }
        .image-box img { width: 150px; height: auto; border: 1px solid #666; padding: 3px; }
    </style>
</head>
<body>
    <h2>Laporan Formulir CRM</h2>

    <!-- Identitas -->
    <div class="section">
        <h3>Identitas Petugas</h3>
        <table>
            <tr><td>Tanggal & Waktu</td><td>{{ $formulir->tanggal_waktu }}</td></tr>
            <tr><td>Nama Petugas</td><td>{{ $formulir->nama_depan }} {{ $formulir->nama_belakang }}</td></tr>
            <tr><td>Loket</td><td>{{ $formulir->loket }}</td></tr>
        </table>
    </div>

    <!-- Data Operator -->
    <div class="section">
        <h3>Data Operator</h3>
        <table>
            <tr><td>Nama PT/CV</td><td>{{ $formulir->nama_pt }}</td></tr>
            <tr><td>Jenis Angkutan</td><td>{{ $formulir->jenis_angkutan }}</td></tr>
            <tr><td>Nama Pengelola</td><td>{{ $formulir->nama_pengelola }}</td></tr>
            <tr><td>Alamat</td><td>{{ $formulir->alamat }}</td></tr>
            <tr><td>Telepon</td><td>{{ $formulir->telepon }}</td></tr>
        </table>
    </div>

    <!-- Kendaraan -->
    <div class="section">
        <h3>Kendaraan</h3>
        <table>
            <thead>
                <tr>
                    <th>Nopol</th>
                    <th>Status</th>
                    <th>Jumlah Bayar</th>
                    <th>File</th>
                </tr>
            </thead>
            <tbody>
                @foreach($formulir->kendaraan ?? [] as $kendaraan)
                <tr>
                    <td>{{ $kendaraan['nopol'] ?? '-' }}</td>
                    <td>{{ $kendaraan['status'] ?? '-' }}</td>
                    <td>{{ $kendaraan['jumlah_bayar'] ?? '-' }}</td>
                    <td>
                        @if(!empty($kendaraan['file']))
                            @foreach($kendaraan['file'] as $file)
                                <div class="image-box">
                                    <img src="{{ public_path('storage/'.$file) }}" alt="file">
                                </div>
                            @endforeach
                        @else
                            -
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Hasil Kunjungan -->
    <div class="section">
        <h3>Hasil Kunjungan</h3>
        <p>{{ $formulir->hasil_kunjungan }}</p>
        <p>Janji Bayar: {{ $formulir->janji_bayar }}</p>
    </div>

    <!-- Profiling -->
    <div class="section">
        <h3>Profiling</h3>
        <table>
            <tr><td>Respon Pemilik</td><td>{{ $formulir->profiling['respon'] ?? '-' }}</td></tr>
            <tr><td>Keramaian Penumpang</td><td>{{ $formulir->profiling['penumpang'] ?? '-' }}</td></tr>
            <tr><td>Ketaatan Izin</td><td>{{ $formulir->profiling['izin'] ?? '-' }}</td></tr>
        </table>
    </div>

    <!-- Foto Kunjungan -->
    <div class="section">
        <h3>Foto Kunjungan</h3>
        @if(!empty($formulir->foto_kunjungan))
            @foreach($formulir->foto_kunjungan as $foto)
                <div class="image-box">
                    <img src="{{ public_path('storage/'.$foto) }}" alt="Foto">
                </div>
            @endforeach
        @else
            <p>-</p>
        @endif
    </div>

    <!-- Evidence -->
    <div class="section">
        <h3>Evidence</h3>
        @if(!empty($formulir->evidence))
            @foreach($formulir->evidence as $file)
                <div class="image-box">
                    <img src="{{ public_path('storage/'.$file) }}" alt="Evidence">
                </div>
            @endforeach
        @else
            <p>-</p>
        @endif
    </div>

    <!-- Tanda Tangan -->
    <div class="section">
        <h3>Tanda Tangan</h3>
        <table>
            <tr>
                <td>Petugas</td>
                <td>
                    @if($formulir->ttd_petugas_data)
                        <img src="data:image/png;base64,{{ $formulir->ttd_petugas_data }}" alt="TTD Petugas" style="width:150px;">
                    @else
                        -
                    @endif
                </td>
            </tr>
            <tr>
                <td>Pemilik</td>
                <td>
                    @if($formulir->ttd_pemilik_data)
                        <img src="data:image/png;base64,{{ $formulir->ttd_pemilik_data }}" alt="TTD Pemilik" style="width:150px;">
                    @else
                        -
                    @endif
                </td>
            </tr>
        </table>
    </div>

    <!-- Lokasi -->
    <div class="section">
        <h3>Lokasi Kunjungan</h3>
        <table>
            <tr>
                <td>Latitude</td>
                <td>{{ $formulir->latitude ?? '-' }}</td>
            </tr>
            <tr>
                <td>Longitude</td>
                <td>{{ $formulir->longitude ?? '-' }}</td>
            </tr>
            <tr>
                <td>Link Google Maps</td>
                <td>
                    @if($formulir->latitude && $formulir->longitude)
                        <a href="https://maps.google.com?q={{ $formulir->latitude }},{{ $formulir->longitude }}" target="_blank">
                            Lihat di Google Maps
                        </a>
                    @else
                        -
                    @endif
                </td>
            </tr>
            <tr>
                <td>Alamat (otomatis)</td>
                <td>
                    {{ $formulir->alamat_otomatis ?? '-' }}
                </td>
            </tr>
        </table>
    </div>
    <h3 style="margin-top:20px;">Riwayat Verifikasi</h3>
    @if($formulir->verifications->count())
        <table width="100%" border="1" cellspacing="0" cellpadding="6">
            <thead style="background-color:#f1f1f1;">
                <tr>
                    <th>Admin</th>
                    <th>Status</th>
                    <th>Catatan</th>
                    <th>Tanggal</th>
                </tr>
            </thead>
            <tbody>
                @foreach($formulir->verifications as $verif)
                    <tr>
                        <td>{{ $verif->user->name ?? 'Unknown' }}</td>
                        <td>
                            @if($verif->status === 'approved')
                                ✅ Approved
                            @elseif($verif->status === 'rejected')
                                ❌ Rejected
                            @else
                                ⏳ Pending
                            @endif
                        </td>
                        <td>{{ $verif->notes ?? '-' }}</td>
                        <td>{{ $verif->created_at->format('d-m-Y H:i') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p><em>Belum ada verifikasi</em></p>
    @endif
</body>
</html>
