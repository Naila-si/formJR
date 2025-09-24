@extends('admin1.dashboard')

@section('title', 'Data IWKL')

@section('content')
<div class="container mt-5">
    <h2 class="mb-4 text-xl font-bold">Data IWKL</h2>

    <!-- Tombol Import & Export -->
    <div class="mb-3 flex gap-2">
        <form action="{{ route('admin1.iwkl.import') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="file" name="file" id="fileInputIWKL" hidden>
        </form>
        <button type="button" id="btnImportIWKL" class="btn btn-secondary">Import Data</button>
        <a href="{{ route('admin1.iwkl.export.excel') }}" class="btn btn-success">Export Excel</a>
        <a href="{{ route('admin1.iwkl.export.pdf') }}" class="btn btn-danger">Export PDF</a>
    </div>

    <!-- Tabel Data dengan scroll horizontal -->
    <div class="table-responsive">
        <table class="table table-bordered" id="iwklTable">
            <thead class="table-dark">
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
                    <th>Tanggal Jatuh Tempo Sertifikat Keselamatan Kapal</th>
                    <th>Rute</th>
                    <th>Sistem Pengutipan IWKL</th>
                    <th>Trayek</th>
                    <th>Perhitungan Tarif</th>
                    <th>Tarif Borongan Disepakati</th>
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
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($iwkls as $index => $data)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $data->loket }}</td>
                    <td>{{ $data->kelas }}</td>
                    <td>{{ $data->nama_perusahaan }}</td>
                    <td>{{ $data->nama_kapal }}</td>
                    <td>{{ $data->nama_pemilik }}</td>
                    <td>{{ $data->alamat }}</td>
                    <td>{{ $data->no_kontak }}</td>
                    <td>{{ $data->tanggal_lahir }}</td>
                    <td>{{ $data->kapasitas_penumpang }}</td>
                    <td>{{ $data->tanggal_pks }}</td>
                    <td>{{ $data->tanggal_berakhir_pks }}</td>
                    <td>{{ $data->tanggal_addendum }}</td>
                    <td>{{ $data->status_pks }}</td>
                    <td>{{ $data->status_pembayaran }}</td>
                    <td>{{ $data->status_kapal }}</td>
                    <td>{{ $data->potensi_per_bulan }}</td>
                    <td>{{ $data->pas_besar_kecil }}</td>
                    <td>{{ $data->sertifikat_keselamatan }}</td>
                    <td>{{ $data->izin_trayek }}</td>
                    <td>{{ $data->tgl_jatuh_tempo_sertifikat }}</td>
                    <td>{{ $data->rute }}</td>
                    <td>{{ $data->sistem_pengutipan }}</td>
                    <td>{{ $data->trayek }}</td>
                    <td>{{ $data->perhitungan_tarif }}</td>
                    <td>{{ $data->tarif_borongan }}</td>
                    <td>{{ $data->keterangan }}</td>
                    <td>{{ $data->januari }}</td>
                    <td>{{ $data->februari }}</td>
                    <td>{{ $data->maret }}</td>
                    <td>{{ $data->april }}</td>
                    <td>{{ $data->mei }}</td>
                    <td>{{ $data->juni }}</td>
                    <td>{{ $data->juli }}</td>
                    <td>{{ $data->agust }}</td>
                    <td>{{ $data->sept }}</td>
                    <td>{{ $data->okt }}</td>
                    <td>{{ $data->nov }}</td>
                    <td>{{ $data->des }}</td>
                    <td>{{ $data->total }}</td>
                    <td>{{ $data->persen_akt }}</td>
                    <td>
                        <a href="{{ route('admin1.iwkl.edit', $data->id) }}" class="btn btn-sm btn-warning">Edit</a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="42" class="text-center">Belum ada data</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection

@push('styles')
<link rel="stylesheet" href="{{ asset('css/admin1/iwkl.css') }}">
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="{{ asset('js/admin1/iwkl.js') }}"></script>
@endpush
