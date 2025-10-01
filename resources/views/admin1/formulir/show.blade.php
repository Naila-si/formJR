@extends('admin1.dashboard')

@section('title', 'Detail Formulir CRM')

@section('content')
<div id="printArea">

    <!-- Identitas Petugas -->
    <div class="card mb-6">
        <h3 class="section-title">Identitas Petugas</h3>
        <table class="detail-table">
            <tr><td>Tanggal & Waktu</td><td>{{ \Carbon\Carbon::parse($formulir->tanggal_waktu)->translatedFormat('d F Y, H:i') }} WIB</td></tr>
            <tr><td>Nama Petugas</td><td>{{ $formulir->nama_depan }} {{ $formulir->nama_belakang }}</td></tr>
            <tr><td>Loket</td><td>{{ $formulir->loket }}</td></tr>
        </table>
    </div>

    <!-- Data Operator -->
    <div class="card mb-6">
        <h3 class="section-title">Data Operator</h3>
        <table class="detail-table">
            <tr><td>Nama PT/CV</td><td>{{ $formulir->nama_pt }}</td></tr>
            <tr><td>Jenis Angkutan</td><td>{{ $formulir->jenis_angkutan }}</td></tr>
            <tr><td>Nama Pemilik/Pengelola</td><td>{{ $formulir->nama_pengelola }}</td></tr>
            <tr><td>Alamat</td><td>{{ $formulir->alamat }}</td></tr>
            <tr><td>Telepon</td><td>{{ $formulir->telepon }}</td></tr>
        </table>
    </div>

    <!-- Konfirmasi Kendaraan -->
    <div class="card mb-6">
        <h3 class="section-title">Konfirmasi Kendaraan</h3>
        @if(!empty($formulir->kendaraan))
            <table class="table table-sm table-bordered">
                <thead>
                    <tr>
                        <th>Nopol</th>
                        <th>Status</th>
                        <th>Jumlah Bayar</th>
                        <th>File</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($formulir->kendaraan as $kendaraan)
                        <tr>
                            <td>{{ $kendaraan['nopol'] ?? '-' }}</td>
                            <td>{{ $kendaraan['status'] ?? '-' }}</td>
                            <td>
                                @if(($kendaraan['status'] ?? '') === 'beroperasi_bayar')
                                    {{ $kendaraan['jumlah_bayar'] ?? '-' }}
                                @else
                                    -
                                @endif
                            </td>
                            <td>
                                @if(!empty($kendaraan['file']))
                                    @foreach($kendaraan['file'] as $file)
                                        <a href="{{ asset('storage/'.$file) }}" target="_blank">Lihat</a>
                                        @if(!$loop->last), @endif
                                    @endforeach
                                @else
                                    -
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <em>Tidak ada kendaraan</em>
        @endif
    </div>

    <!-- Hasil Kunjungan -->
    <div class="card mb-6">
        <h3 class="section-title">Hasil Kunjungan</h3>
        <table class="detail-table">
            <tr><td>Hasil Kunjungan</td><td>{{ $formulir->hasil_kunjungan }}</td></tr>
            <tr><td>Janji Bayar</td><td>{{ $formulir->janji_bayar }}</td></tr>
        </table>
    </div>

    <!-- Profiling -->
    <div class="card mb-6">
        <h3 class="section-title">Profiling PO / Operator</h3>
        <table class="detail-table">
            <tr><td>Respon Pemilik</td><td>{{ $formulir->profiling['respon'] ?? '-' }}</td></tr>
            <tr><td>Keramaian Penumpang</td><td>{{ $formulir->profiling['penumpang'] ?? '-' }}</td></tr>
            <tr><td>Ketaatan Izin</td><td>{{ $formulir->profiling['izin'] ?? '-' }}</td></tr>
        </table>
    </div>

    <!-- Foto & Evidence -->
    <div class="card mb-6">
        <h3 class="section-title">Dokumentasi</h3>
        <div>
            <strong>Foto Kunjungan:</strong><br>
            @if(!empty($formulir->foto_kunjungan))
                @foreach($formulir->foto_kunjungan as $foto)
                    <a href="{{ asset('storage/'.$foto) }}" target="_blank">
                        <img src="{{ asset('storage/'.$foto) }}" alt="Foto" width="120" class="m-1 rounded shadow">
                    </a>
                @endforeach
            @else
                <em>Tidak ada foto</em>
            @endif
        </div>
        <div class="mt-3">
            <strong>Evidence:</strong><br>
            @if(!empty($formulir->evidence))
                @foreach($formulir->evidence as $file)
                    <a href="{{ asset('storage/'.$file) }}" target="_blank">📄 Lihat Evidence</a><br>
                @endforeach
            @else
                <em>Tidak ada evidence</em>
            @endif
        </div>
    </div>

    <!-- Tanda Tangan -->
    <div class="card mb-6">
        <h3 class="section-title">Tanda Tangan</h3>
        <div class="flex gap-6">
            <div>
                <strong>Petugas:</strong><br>
                @if($formulir->ttd_petugas_data)
                    <img src="{{ $formulir->ttd_petugas_data }}" alt="TTD Petugas" width="200">
                @else
                    <em>Belum ada tanda tangan</em>
                @endif
            </div>
            <div>
                <strong>Pemilik:</strong><br>
                @if($formulir->ttd_pemilik_data)
                    <img src="{{ $formulir->ttd_pemilik_data }}" alt="TTD Pemilik" width="200">
                @else
                    <em>Belum ada tanda tangan</em>
                @endif
            </div>
        </div>
    </div>

    <!-- Lokasi -->
    <div class="card mb-6">
        <h3 class="section-title">Lokasi Kunjungan</h3>
        <p>Latitude: {{ $formulir->latitude ?? '-' }}, Longitude: {{ $formulir->longitude ?? '-' }}</p>
        <p><em id="address">Loading alamat...</em></p>
    </div>
</div>

<!-- Verifikasi + Riwayat (Versi Modern) -->
<div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">

    <!-- Verifikasi Anda -->
    <div class="bg-white rounded-2xl shadow-md p-6 border border-gray-200">
        <h3 class="text-xl font-semibold mb-5 border-b pb-2">📝 Verifikasi Anda</h3>
        <form action="{{ route('admin1.formulir.verification', $formulir->id) }}" method="POST">
            @csrf

            <!-- Status -->
            <div class="mb-5">
                <label for="status" class="block mb-2 font-medium text-gray-700">Status Verifikasi</label>
                <select name="status" id="status" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-400 focus:outline-none">
                    <option value="pending">⏳ Pending</option>
                    <option value="approved">✅ Approved</option>
                    <option value="rejected">❌ Rejected</option>
                </select>
            </div>

            <!-- Catatan -->
            <div class="mb-5">
                <label for="notes" class="block mb-2 font-medium text-gray-700">Catatan</label>
                <textarea name="notes" id="notes" rows="6" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-400 focus:outline-none" placeholder="Tambahkan catatan di sini..."></textarea>
            </div>

            <!-- Tombol Simpan -->
            <button type="submit" class="w-full py-3 bg-gradient-to-r from-blue-500 to-blue-600 text-white font-semibold rounded-lg shadow-lg hover:from-blue-600 hover:to-blue-700 transition-all flex items-center justify-center gap-2">
                💾 Simpan Verifikasi
            </button>
        </form>
    </div>

    <!-- Riwayat Verifikasi -->
    <div class="bg-white rounded-2xl shadow-md p-6 border border-gray-200">
        <h3 class="text-xl font-semibold mb-5 border-b pb-2">📜 Riwayat Verifikasi</h3>
        @if($formulir->verifications->count())
            <div class="overflow-x-auto">
                <table class="min-w-full text-sm border-collapse">
                    <thead>
                        <tr class="bg-gray-50">
                            <th class="px-4 py-2 text-left font-medium">Admin</th>
                            <th class="px-4 py-2 text-left font-medium">Status</th>
                            <th class="px-4 py-2 text-left font-medium">Catatan</th>
                            <th class="px-4 py-2 text-left font-medium">Tanggal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($formulir->verifications as $verif)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-4 py-2">{{ $verif->user->name ?? 'Unknown' }}</td>
                            <td class="px-4 py-2">
                                @php
                                    $statusColors = [
                                        'approved' => 'bg-green-100 text-green-800',
                                        'rejected' => 'bg-red-100 text-red-800',
                                        'pending'  => 'bg-yellow-100 text-yellow-800'
                                    ];
                                @endphp
                                <span class="inline-block px-3 py-1 rounded-full font-semibold text-sm {{ $statusColors[$verif->status] ?? 'bg-gray-100 text-gray-700' }}">
                                    {{ ucfirst($verif->status) }}
                                </span>
                            </td>
                            <td class="px-4 py-2">{{ $verif->notes ?? '-' }}</td>
                            <td class="px-4 py-2">{{ $verif->created_at->format('d-m-Y H:i') }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <p class="text-gray-500 italic">Belum ada verifikasi</p>
        @endif
    </div>
</div>

<div class="flex space-x-3 mt-5">
    <a href="{{ route('admin1.formulir.index') }}" class="btn">← Kembali</a>
    <a href="{{ route('admin1.formulir.exportPdf', $formulir->id) }}" class="btn-secondary">📄 Export PDF</a>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener("DOMContentLoaded", function() {
    let lat = "{{ $formulir->latitude }}";
    let lng = "{{ $formulir->longitude }}";

    if(lat && lng){
        fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lng}`)
            .then(res => res.json())
            .then(data => {
                document.getElementById('address').innerText =
                    data.display_name ?? "Alamat tidak ditemukan";
            })
            .catch(() => {
                document.getElementById('address').innerText = "Gagal mengambil alamat";
            });
    } else {
        document.getElementById('address').innerText = "Koordinat tidak tersedia";
    }
});
</script>
@push('styles')
<style>
/* Reset & base */
body {
    font-family: 'Inter', sans-serif;
    color: #1f2937;
    background-color: #f9fafb;
}

/* Card */
.card {
    background-color: #ffffff;
    border-radius: 1rem; /* rounded-2xl */
    padding: 1.5rem;
    box-shadow: 0 4px 8px rgba(0,0,0,0.05);
    border: 1px solid #e5e7eb;
    margin-bottom: 1.5rem;
}

/* Section title */
.section-title {
    font-size: 1.25rem;
    font-weight: 600;
    margin-bottom: 0.75rem;
    border-bottom: 2px solid #3b82f6;
    display: inline-block;
    padding-bottom: 0.25rem;
}

/* Detail tables */
.detail-table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 0.5rem;
}

.detail-table td {
    padding: 0.5rem 0.75rem;
    vertical-align: top;
}

.detail-table tr:nth-child(odd) td {
    background-color: #f3f4f6;
}

/* Tabel kendaraan */
.table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 0.5rem;
}

.table th, .table td {
    border: 1px solid #d1d5db;
    padding: 0.5rem;
    text-align: left;
}

/* Tombol */
.btn {
    display: inline-block;
    padding: 0.5rem 1rem;
    background-color: #3b82f6;
    color: #ffffff;
    font-weight: 500;
    border-radius: 0.5rem;
    text-decoration: none;
    transition: all 0.3s;
}

.btn:hover {
    background-color: #2563eb;
}

.btn-secondary {
    display: inline-block;
    padding: 0.5rem 1rem;
    background-color: #f3f4f6;
    color: #1f2937;
    font-weight: 500;
    border-radius: 0.5rem;
    text-decoration: none;
    border: 1px solid #d1d5db;
}

.btn-secondary:hover {
    background-color: #e5e7eb;
}

/* Grid modern Verifikasi + Riwayat */
.grid {
    display: grid;
    gap: 1.5rem;
}

@media (min-width: 768px) {
    .grid-cols-2 {
        grid-template-columns: repeat(2, 1fr);
    }
}

/* Status badges */
span.rounded-full {
    padding: 0.25rem 0.75rem;
    font-size: 0.875rem;
}

/* Foto & Evidence */
img {
    border-radius: 0.5rem;
    box-shadow: 0 2px 6px rgba(0,0,0,0.1);
}

/* Tanda tangan */
.flex {
    display: flex;
}

.flex > div {
    flex: 1;
}

/* Responsive table scroll */
.overflow-x-auto {
    overflow-x: auto;
}

/* ================= Verifikasi + Riwayat ================= */

/* Card form verifikasi & riwayat */
.bg-white {
    background-color: #ffffff;
}

.rounded-2xl {
    border-radius: 1rem;
}

.shadow-md {
    box-shadow: 0 4px 8px rgba(0,0,0,0.05);
}

.border {
    border: 1px solid #e5e7eb;
}

.p-6 {
    padding: 1.5rem;
}

/* Judul card */
.text-xl {
    font-size: 1.25rem;
}

.font-semibold {
    font-weight: 600;
}

.mb-5 {
    margin-bottom: 1.25rem;
}

.border-b {
    border-bottom: 2px solid #e5e7eb;
}

.pb-2 {
    padding-bottom: 0.5rem;
}

/* Form input & textarea */
input, select, textarea {
    width: 100%;
    padding: 0.5rem 1rem;
    border: 1px solid #d1d5db;
    border-radius: 0.5rem;
    font-size: 1rem;
    outline: none;
    transition: all 0.2s;
}

input:focus, select:focus, textarea:focus {
    border-color: #3b82f6;
    box-shadow: 0 0 0 2px rgba(59,130,246,0.2);
}

/* Tombol simpan verifikasi */
button[type="submit"] {
    background: linear-gradient(to right, #3b82f6, #2563eb);
    color: #ffffff;
    font-weight: 600;
    border-radius: 0.75rem;
    padding: 0.75rem;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
    transition: all 0.3s;
    width: 100%;
}

button[type="submit"]:hover {
    background: linear-gradient(to right, #2563eb, #1e40af);
}

/* Table Riwayat */
table.min-w-full {
    width: 100%;
    border-collapse: collapse;
    font-size: 0.875rem;
}

table.min-w-full th,
table.min-w-full td {
    padding: 0.5rem 0.75rem;
    border-bottom: 1px solid #e5e7eb;
    text-align: left;
}

table.min-w-full thead tr {
    background-color: #f3f4f6;
}

.hover\:bg-gray-50:hover {
    background-color: #f9fafb;
}

.inline-block.px-3.py-1.rounded-full {
    display: inline-block;
    padding: 0.25rem 0.75rem;
    border-radius: 9999px;
    font-weight: 500;
    font-size: 0.875rem;
}

/* Status colors */
.bg-green-100 { background-color: #d1fae5; color: #065f46; }
.bg-red-100 { background-color: #fee2e2; color: #991b1b; }
.bg-yellow-100 { background-color: #fef3c7; color: #78350f; }

/* Responsive table scroll */
.overflow-x-auto {
    overflow-x: auto;
}

</style>
@endpush
