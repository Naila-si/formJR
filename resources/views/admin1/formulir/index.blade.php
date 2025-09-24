@extends('admin1.dashboard')

@section('title', 'Data Formulir CRM')

@section('content')
<div class="container mt-5">
    <h2 class="mb-4 text-xl font-bold">Data Formulir CRM</h2>

    <div class="table-responsive">
        <table class="table table-bordered">
            <thead class="table-dark">
                <tr>
                    <th>No</th>
                    <th>Tanggal & Waktu</th>
                    <th>Nama Petugas</th>
                    <th>Loket</th>
                    <th>Hasil Kunjungan ke Operator PT/CV</th>
                    <th>Jenis Angkutan</th>
                    <th>Nama Pemilik/Pengelola</th>
                    <th>Alamat</th>
                    <th>Telepon</th>
                    <th>Konfirmasi Kendaraan</th>
                    <th>Hasil Kunjungan</th>
                    <th>Janji Bayar</th>
                    <th>Respon Pemilik</th>
                    <th>Keramaian Penumpang</th>
                    <th>Ketaatan Izin</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($formulirs as $index => $data)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $data->tanggal_waktu }}</td>
                    <td>{{ $data->nama_depan }} {{ $data->nama_belakang }}</td>
                    <td>{{ $data->loket }}</td>
                    <td>{{ $data->nama_pt }}</td>
                    <td>{{ $data->jenis_angkutan }}</td>
                    <td>{{ $data->nama_pengelola }}</td>
                    <td>{{ $data->alamat }}</td>
                    <td>{{ $data->telepon }}</td>

                    <td>
                        @foreach($data->kendaraan as $kendaraan)
                            <div style="margin-bottom:10px; padding:5px; border:1px solid #ccc; border-radius:6px;">
                                <strong>{{ $kendaraan['nopol'] ?? '' }}</strong><br>
                                Status: {{ $kendaraan['status'] ?? '-' }}<br>

                                @if(($kendaraan['status'] ?? '') === 'Beroperasi + Bayar')
                                    Jumlah Pembayaran: {{ $kendaraan['jumlah_pembayaran'] ?? '-' }}
                                @else
                                    File:
                                    @if(!empty($kendaraan['file']))
                                        @foreach($kendaraan['file'] as $file)
                                            <a href="{{ asset('storage/'.$file) }}" target="_blank">Lihat</a>@if(!$loop->last), @endif
                                        @endforeach
                                    @else
                                        -
                                    @endif
                                @endif
                            </div>
                        @endforeach
                    </td>

                    <td>{{ $data->hasil_kunjungan }}</td>
                    <td>{{ $data->janji_bayar }}</td>
                    <td>{{ $data->profiling['respon'] ?? '' }}</td>
                    <td>{{ $data->profiling['penumpang'] ?? '' }}</td>
                    <td>{{ $data->profiling['izin'] ?? '' }}</td>
                    <td>
                        <a href="{{ route('formulir.edit', $data->id) }}" class="btn btn-warning btn-sm">Edit</a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="20" class="text-center">Belum ada data</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection

@push('styles')
<style>
.container {
    background: #fff;
    padding: 20px;
    border-radius: 12px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.05);
}

h2 { color: #374151; font-size: 1.5rem; }

.btn {
    display: inline-block;
    font-size: 0.875rem;
    font-weight: 600;
    padding: 8px 14px;
    border-radius: 8px;
    text-decoration: none;
    transition: all 0.2s ease-in-out;
}

.btn:hover { transform: translateY(-2px); }
.btn-warning { background: #facc15; color: #000; }

.table-responsive { overflow-x: auto; margin-top: 15px; }
.table { width: 100%; border-collapse: collapse; font-size: 0.85rem; white-space: nowrap; }
.table th, .table td { padding: 10px 12px; border: 1px solid #e5e7eb; text-align: left; vertical-align: middle; }
.table th { background: #1f2937; color: #fff; position: sticky; top: 0; z-index: 1; }
.table tbody tr:nth-child(even) { background: #f9fafb; }
.table tbody tr:hover { background: #f1f5f9; }
.text-center { text-align: center; color: #6b7280; font-style: italic; }
</style>
@endpush
