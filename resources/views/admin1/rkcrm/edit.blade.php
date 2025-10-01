@extends('admin1.dashboard')

@section('title', 'Edit RK CRM')

@section('content')
<!-- Tambahkan class khusus buat styling -->
<div class="edit-form-container">
    <h2>Edit Data RK CRM</h2>

    <form action="{{ url('admin1/rkcrm/'.$rkcrm->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label>Nama Pegawai</label>
            <input type="text" name="nama_pegawai" value="{{ old('nama_pegawai', $rkcrm->nama_pegawai) }}" required>
        </div>

        <div class="form-group">
            <label>Loket Samsat</label>
            <select name="loket_samsat" required>
                <option value="">-- Pilih Loket --</option>
                @foreach($lokets_list as $loket)
                    <option value="{{ $loket }}" {{ old('loket_samsat', $rkcrm->loket_samsat) == $loket ? 'selected' : '' }}>
                        {{ $loket }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label>OS Awal</label>
            <input type="number" name="os_awal" value="{{ old('os_awal', $rkcrm->os_awal) }}" required>
        </div>

        <div class="form-group">
            <label>OS s.d 11 Sept</label>
            <input type="number" name="os_sampai_11_sept" value="{{ old('os_sampai_11_sept', $rkcrm->os_sampai_11_sept) }}" required>
        </div>

        <div class="form-group">
            <label>Persen OS</label>
            <input type="number" step="0.01" name="persen_os" value="{{ old('persen_os', $rkcrm->persen_os) }}" required>
        </div>

        <div class="form-group">
            <label>Target CRM (PO)</label>
            <input type="number" name="target_crm" value="{{ old('target_crm', $rkcrm->target_crm) }}" required>
        </div>

        <div class="form-group">
            <label>Realisasi PO</label>
            <input type="number" name="realisasi_po" value="{{ old('realisasi_po', $rkcrm->realisasi_po) }}" required>
        </div>

        <div class="form-group">
            <label>GAP PO</label>
            <input type="number" name="gap_po" value="{{ old('gap_po', $rkcrm->gap_po) }}" required>
        </div>

        <div class="form-group">
            <label>Target Rupiah</label>
            <input type="number" name="target_rupiah" value="{{ old('target_rupiah', $rkcrm->target_rupiah) }}" required>
        </div>

        <div class="form-group">
            <label>Realisasi OS Bayar</label>
            <input type="number" name="realisasi_os_bayar" value="{{ old('realisasi_os_bayar', $rkcrm->realisasi_os_bayar) }}" required>
        </div>

        <div class="form-group">
            <label>Persen OS Bayar</label>
            <input type="number" step="0.01" name="persen_os_bayar" value="{{ old('persen_os_bayar', $rkcrm->persen_os_bayar) }}" required>
        </div>

        <div class="form-group">
            <label>Jumlah Kend Pemeliharaan</label>
            <input type="number" name="jml_kend_pemeliharaan" value="{{ old('jml_kend_pemeliharaan', $rkcrm->jml_kend_pemeliharaan) }}" required>
        </div>

        <div class="form-group">
            <label>Nominal Pemeliharaan</label>
            <input type="number" name="nominal_pemeliharaan" value="{{ old('nominal_pemeliharaan', $rkcrm->nominal_pemeliharaan) }}" required>
        </div>

        <div class="form-group">
            <button type="submit" class="submit-btn">Update Data</button>
        </div>
    </form>
</div>

<!-- CSS khusus untuk edit form -->
<style>
.edit-form-container {
    max-width: 800px;
    margin: 50px auto;
    padding: 30px 40px;
    background-color: #ffffff;
    border-radius: 20px;
    box-shadow: 0 8px 25px rgba(0,0,0,0.1);
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
}

.edit-form-container h2 {
    text-align: center;
    font-size: 2rem;
    font-weight: 700;
    color: #1a202c;
    margin-bottom: 30px;
}

.form-group {
    margin-bottom: 20px;
}

.form-group label {
    display: block;
    font-weight: 600;
    margin-bottom: 8px;
    color: #2d3748;
}

.form-group input,
.form-group select {
    width: 100%;
    padding: 12px 15px;
    border: 1px solid #cbd5e0;
    border-radius: 12px;
    font-size: 1rem;
    transition: all 0.3s ease;
}

.form-group input:focus,
.form-group select:focus {
    border-color: #5a67d8;
    box-shadow: 0 0 0 3px rgba(90,103,216,0.3);
    outline: none;
}

.submit-btn {
    display: inline-block;
    background: #5a67d8;
    color: #fff;
    font-weight: 600;
    padding: 12px 25px;
    border-radius: 12px;
    border: none;
    cursor: pointer;
    transition: all 0.3s ease;
    width: 100%;
    font-size: 1.1rem;
}

.submit-btn:hover {
    background: #434190;
    box-shadow: 0 5px 15px rgba(0,0,0,0.2);
}

@media (max-width: 768px) {
    .edit-form-container {
        padding: 20px;
        margin: 20px;
    }
}
</style>
@endsection
