@extends('admin1.dashboard')

@section('title', 'Edit Data IWKBU')

@section('content')
<link rel="stylesheet" href="{{ asset('css/admin1/iwkbu-edit.css') }}">
<div class="container mt-5">
    <h2 class="mb-4 text-xl font-bold">Edit Data IWKBU</h2>

    <form action="{{ route('admin1.iwkbu.update', $iwkbu->id) }}" method="POST" class="iwkbu-form">
        @csrf
        @method('PUT')

        <!-- Accordion Section -->
        <div class="accordion">

            <!-- Data Kendaraan -->
            <div class="accordion-item">
                <button type="button" class="accordion-header">Data Kendaraan</button>
                <div class="accordion-body">
                    <div class="form-grid">
                        <div class="form-group">
                            <label>Wilayah</label>
                            <select name="wilayah">
                                @foreach(\App\Models\Admin1\Iwkbu::$options['wilayah'] as $option)
                                    <option value="{{ $option }}" {{ $iwkbu->wilayah == $option ? 'selected' : '' }}>{{ $option }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>No Polisi</label>
                            <input type="text" name="no_polisi" value="{{ $iwkbu->no_polisi }}">
                        </div>
                        <div class="form-group">
                            <label>Tarif</label>
                            <input type="number" name="tarif" value="{{ $iwkbu->tarif }}">
                        </div>
                        <div class="form-group">
                            <label>Golongan</label>
                            <select name="undefined">
                                @foreach(\App\Models\Admin1\Iwkbu::$options['undefined'] as $option)
                                    <option value="{{ $option }}" {{ $iwkbu->undefined == $option ? 'selected' : '' }}>{{ $option }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Nominal IWKBU</label>
                            <input type="number" name="nominal_iwkbu" value="{{ $iwkbu->nominal_iwkbu }}">
                        </div>
                        <div class="form-group">
                            <label>Trayek</label>
                            <select name="trayek">
                                @foreach(\App\Models\Admin1\Iwkbu::$options['trayek'] as $option)
                                    <option value="{{ $option }}" {{ $iwkbu->trayek == $option ? 'selected' : '' }}>{{ $option }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Jenis</label>
                            <select name="jenis">
                                @foreach(\App\Models\Admin1\Iwkbu::$options['jenis'] as $option)
                                    <option value="{{ $option }}" {{ $iwkbu->jenis == $option ? 'selected' : '' }}>{{ $option }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Tahun Pembuatan</label>
                            <input type="number" name="tahun_pembuatan" value="{{ $iwkbu->tahun_pembuatan }}">
                        </div>
                        <div class="form-group">
                            <label>PIC</label>
                            <input type="text" name="pic" value="{{ $iwkbu->pic }}">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Data Perusahaan -->
            <div class="accordion-item">
                <button type="button" class="accordion-header">Data Perusahaan</button>
                <div class="accordion-body">
                    <div class="form-grid">
                        <div class="form-group">
                            <label>Badan Hukum / Perorangan</label>
                            <select name="badan_hukum">
                                @foreach(\App\Models\Admin1\Iwkbu::$options['badan_hukum'] as $option)
                                    <option value="{{ $option }}" {{ $iwkbu->badan_hukum == $option ? 'selected' : '' }}>{{ $option }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Nama Perusahaan</label>
                            <input type="text" name="nama_perusahaan" value="{{ $iwkbu->nama_perusahaan }}">
                        </div>
                        <div class="form-group">
                            <label>Alamat Lengkap</label>
                            <input type="text" name="alamat_lengkap" value="{{ $iwkbu->alamat_lengkap }}">
                        </div>
                        <div class="form-group">
                            <label>Kel</label>
                            <input type="text" name="kel" value="{{ $iwkbu->kel }}">
                        </div>
                        <div class="form-group">
                            <label>Kec</label>
                            <input type="text" name="kec" value="{{ $iwkbu->kec }}">
                        </div>
                        <div class="form-group">
                            <label>Kota/Kab</label>
                            <input type="text" name="kota_kab" value="{{ $iwkbu->kota_kab }}">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Transaksi & Pembayaran -->
            <div class="accordion-item">
                <button type="button" class="accordion-header">Transaksi & Pembayaran</button>
                <div class="accordion-body">
                    <div class="form-grid">
                        <div class="form-group">
                            <label>Tanggal Transaksi</label>
                            <input type="date" name="tanggal_transaksi" value="{{ $iwkbu->tanggal_transaksi }}">
                        </div>
                        <div class="form-group">
                            <label>Loket Pembayaran</label>
                            <input type="text" name="loket_pembayaran" value="{{ $iwkbu->loket_pembayaran }}">
                        </div>
                        <div class="form-group">
                            <label>Masa Berlaku IWKBU</label>
                            <input type="date" name="masa_berlaku_iwkbu" value="{{ $iwkbu->masa_berlaku_iwkbu }}">
                        </div>
                        <div class="form-group">
                            <label>Masa Laku SWDKLLJ Terakhir</label>
                            <input type="date" name="masa_laku_swdkllj" value="{{ $iwkbu->masa_laku_swdkllj }}">
                        </div>
                        <div class="form-group">
                            <label>Status Pembayaran IWKBU</label>
                            <select name="status_pembayaran">
                                @foreach(\App\Models\Admin1\Iwkbu::$options['status_pembayaran'] as $option)
                                    <option value="{{ $option }}" {{ $iwkbu->status_pembayaran == $option ? 'selected' : '' }}>{{ $option }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Status Kendaraan</label>
                            <select name="status_kendaraan">
                                @foreach(\App\Models\Admin1\Iwkbu::$options['status_kendaraan'] as $option)
                                    <option value="{{ $option }}" {{ $iwkbu->status_kendaraan == $option ? 'selected' : '' }}>{{ $option }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Nilai Outstanding IWKBU (Rp)</label>
                            <input type="number" name="nilai_outstanding" value="{{ $iwkbu->nilai_outstanding }}">
                        </div>
                        <div class="form-group">
                            <label>Hasil Konfirmasi</label>
                            <select name="hasil_konfirmasi">
                                @foreach(\App\Models\Admin1\Iwkbu::$options['hasil_konfirmasi'] as $option)
                                    <option value="{{ $option }}" {{ $iwkbu->hasil_konfirmasi == $option ? 'selected' : '' }}>{{ $option }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>No HP</label>
                            <input type="text" name="no_hp" value="{{ $iwkbu->no_hp }}">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Pemilik & Dokumen -->
            <div class="accordion-item">
                <button type="button" class="accordion-header">Pemilik & Dokumen</button>
                <div class="accordion-body">
                    <div class="form-grid">
                        <div class="form-group">
                            <label>Nama Pemilik/Pengelola</label>
                            <input type="text" name="nama_pemilik" value="{{ $iwkbu->nama_pemilik }}">
                        </div>
                        <div class="form-group">
                            <label>NIK / No Identitas</label>
                            <input type="text" name="nik" value="{{ $iwkbu->nik }}">
                        </div>
                        <div class="form-group">
                            <label>Dok Perizinan</label>
                            <select name="dok_perizinan">
                                @foreach(\App\Models\Admin1\Iwkbu::$options['dok_perizinan'] as $option)
                                    <option value="{{ $option }}" {{ $iwkbu->dok_perizinan == $option ? 'selected' : '' }}>{{ $option }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <!-- OS IWKBU & Pemeliharaan -->
            <div class="accordion-item">
                <button type="button" class="accordion-header">OS IWKBU & Pemeliharaan</button>
                <div class="accordion-body">
                    <div class="form-grid">
                        <div class="form-group">
                            <label>Tgl Bayar OS IWKBU</label>
                            <input type="date" name="tgl_bayar_os" value="{{ $iwkbu->tgl_bayar_os }}">
                        </div>
                        <div class="form-group">
                            <label>Nilai Bayar OS IWKBU</label>
                            <input type="number" name="nilai_bayar_os" value="{{ $iwkbu->nilai_bayar_os }}">
                        </div>
                        <div class="form-group">
                            <label>Tgl Pemeliharaan</label>
                            <input type="date" name="tgl_pemeliharaan" value="{{ $iwkbu->tgl_pemeliharaan }}">
                        </div>
                        <div class="form-group">
                            <label>Nilai Pemeliharaan OS IWKBU</label>
                            <input type="number" name="nilai_pemeliharaan_os" value="{{ $iwkbu->nilai_pemeliharaan_os }}">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Keterangan -->
            <div class="accordion-item">
                <button type="button" class="accordion-header">Keterangan</button>
                <div class="accordion-body">
                    <div class="form-group">
                        <input type="text" name="keterangan" value="{{ $iwkbu->keterangan }}">
                    </div>
                </div>
            </div>

        </div>

        <div class="mt-4 flex gap-2">
            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
            <a href="{{ route('admin1.iwkbu.index') }}" class="btn btn-secondary">Kembali</a>
        </div>
    </form>
</div>

<script>
document.querySelectorAll('.accordion-header').forEach(header => {
    header.addEventListener('click', function() {
        const body = this.nextElementSibling;

        // Toggle class active
        this.classList.toggle('active');

        // Toggle body dengan smooth animation
        if (body.style.maxHeight) {
            body.style.maxHeight = null;
        } else {
            body.style.maxHeight = body.scrollHeight + "px";
        }
    });
});
</script>

@endsection
