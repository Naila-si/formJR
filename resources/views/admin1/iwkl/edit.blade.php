@extends('admin1.dashboard')

@section('title', 'Edit Data IWKL')

@section('content')
<div class="container mt-5">
    <h2 class="mb-4 text-xl font-bold">Edit Data IWKL</h2>

    <form action="{{ route('admin1.iwkl.update', $iwkl->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label>Loket</label>
                <input type="text" name="loket" class="form-input" value="{{ $iwkl->loket }}">
            </div>
            <div>
                <label>Kelas</label>
                <input type="text" name="kelas" class="form-input" value="{{ $iwkl->kelas }}">
            </div>
            <div>
                <label>Nama Perusahaan</label>
                <input type="text" name="nama_perusahaan" class="form-input" value="{{ $iwkl->nama_perusahaan }}">
            </div>
            <div>
                <label>Nama Kapal</label>
                <input type="text" name="nama_kapal" class="form-input" value="{{ $iwkl->nama_kapal }}">
            </div>
            <div>
                <label>Nama Pemilik / Pengelola</label>
                <input type="text" name="nama_pemilik_pengelola" class="form-input" value="{{ $iwkl->nama_pemilik_pengelola }}">
            </div>
            <div>
                <label>Alamat</label>
                <textarea name="alamat" class="form-input">{{ $iwkl->alamat }}</textarea>
            </div>
            <div>
                <label>No. Kontak</label>
                <input type="text" name="no_kontak" class="form-input" value="{{ $iwkl->no_kontak }}">
            </div>
            <div>
                <label>Tanggal Lahir</label>
                <input type="date" name="tanggal_lahir" class="form-input" value="{{ $iwkl->tanggal_lahir }}">
            </div>
            <div>
                <label>Kapasitas Penumpang</label>
                <input type="number" name="kapasitas_penumpang" class="form-input" value="{{ $iwkl->kapasitas_penumpang }}">
            </div>
            <div>
                <label>Tanggal PKS</label>
                <input type="date" name="tanggal_pks" class="form-input" value="{{ $iwkl->tanggal_pks }}">
            </div>
            <div>
                <label>Tanggal Berakhir PKS</label>
                <input type="date" name="tanggal_berakhir_pks" class="form-input" value="{{ $iwkl->tanggal_berakhir_pks }}">
            </div>
            <div>
                <label>Status PKS</label>
                <input type="text" name="status_pks" class="form-input" value="{{ $iwkl->status_pks }}">
            </div>
            <div>
                <label>Status Pembayaran</label>
                <input type="text" name="status_pembayaran" class="form-input" value="{{ $iwkl->status_pembayaran }}">
            </div>
            <div>
                <label>Status Kapal</label>
                <input type="text" name="status_kapal" class="form-input" value="{{ $iwkl->status_kapal }}">
            </div>
            <div>
                <label>Potensi Per Bulan (Rp)</label>
                <input type="number" name="potensi_per_bulan_rp" class="form-input" value="{{ $iwkl->potensi_per_bulan_rp }}">
            </div>
            <div>
                <label>Keterangan</label>
                <textarea name="keterangan" class="form-input">{{ $iwkl->keterangan }}</textarea>
            </div>
            <!-- Tambahkan field lain sesuai kebutuhan -->
        </div>

        <div class="mt-4">
            <button type="submit" class="btn btn-success">Update Data</button>
            <a href="{{ route('admin1.iwkl.index') }}" class="btn btn-secondary">Kembali</a>
        </div>
    </form>
</div>
@endsection

@push('styles')
<link rel="stylesheet" href="{{ asset('css/admin1/iwkl.css') }}">
@endpush
