@extends('layouts.app')

@section('title', 'Formulir CRM')

@section('content')
<!-- Floating Back Button -->
<a href="{{ url('/') }}">
    <button type="button" class="back-btn">←</button>
</a>
<div class="form-wrapper">
  <div class="form-card">
    <div class="progressbar">
      <div class="progress" id="progress"></div>
      <div class="progress-step active" data-title="Data Kunjungan"></div>
      <div class="progress-step" data-title="Armada"></div>
      <div class="progress-step" data-title="Upload"></div>
    </div>

    <form action="{{ route('formulir.store') }}" method="POST" enctype="multipart/form-data">
      @csrf

      <!-- Step 1 -->
      <div class="form-step active">
        <h2 class="title">Data Kunjungan</h2>

        <div class="form-group">
          <label>Tanggal & Waktu Kunjungan</label>
          <input type="datetime-local" name="tanggal_waktu">
        </div>

        <div class="form-group">
          <label>Nama Petugas</label>
          <div class="row">
            <input type="text" name="nama_depan" placeholder="Nama Depan">
            <input type="text" name="nama_belakang" placeholder="Nama Belakang">
          </div>
        </div>

        <div class="form-group">
            <label for="loket">Loket</label>
            <input list="loket-list" name="loket" id="loket" placeholder="Ketik nama loket...">
            <datalist id="loket-list">
                <option value="Loket Kantor Wilayah">
                <option value="Pekanbaru Kota">
                <option value="Pekanbaru Selatan">
                <option value="Pekanbaru Utara">
                <option value="Panam">
                <option value="Kubang">
                <option value="Bangkinang">
                <option value="Lipat Kain">
                <option value="Tapung">
                <option value="Siak">
                <option value="Perawang">
                <option value="Kandis">
                <option value="Pelalawan">
                <option value="Sorek">
                <option value="Pasir Pengaraian">
                <option value="Ujung Batu">
                <option value="Dalu-Dalu">
                <option value="Koto Tengah">
                <option value="Taluk Kuantan">
                <option value="Singingi Hilir">
                <option value="Rengat">
                <option value="Air Molek">
                <option value="Tembilahan">
                <option value="Kota Baru">
                <option value="Sungai Guntung">
                <option value="Loket Kantor Cabang Dumai">
                <option value="Dumai">
                <option value="Duri">
                <option value="Bengkalis">
                <option value="Selat Panjang">
                <option value="Bagan Siapiapi">
                <option value="Bagan Batu">
                <option value="Ujung Tanjung">
            </datalist>
            </div>

        <div class="form-group">
          <label for="jabatan">Jabatan</label>
          <input list="jabatan-list" name="jabatan" id="jabatan" placeholder="ketik nama jabatan...">
            <datalist id="jabatan-list">
                <option value="Kepala Kantor Wilayah Riau">
                <option value="Kepala Bagian Operasional">
                <option value="Kepala Cabang Dumai">
                <option value="Kepala Bagian Administrasi">
                <option value="Kepala Sub Bagian">
                <option value="PJ Samsat">
                <option value="Staff Administrasi Tk.I">
                <option value="Staff Administrasi Tk.II">
                <option value="Pelaksana Administrasi Tk.I">
                <option value="Pelaksana Administrasi Tk.II">
                <option value="LBJR">
            </datalist>
        </div>

        <div class="form-group">
          <label>Telah melakukan kunjungan ke Pemilik/Operator atas nama PT/CV?</label>
          <input type="text" name="nama_pt">
        </div>

        <div class="form-group">
          <label>Jenis Angkutan</label>
          <select name="jenis_angkutan">
            <option>Kendaraan Bermotor Umum</option>
            <option>Kapal Penumpang Umum</option>
          </select>
        </div>

        <div class="form-group">
          <label>Nama Pemilik / Pengelola</label>
          <input type="text" name="nama_pengelola">
        </div>

        <div class="form-group">
          <label>Alamat yang Dikunjungi</label>
          <textarea name="alamat"></textarea>
        </div>

        <div class="form-group">
          <label>No. Telepon / HP Pemilik / Pengelola</label>
          <input type="text" name="telepon">
        </div>

        <div class="btns-group">
          <button type="button" class="btn next-btn">Next</button>
        </div>
      </div>

    <!-- Step 2 -->
    <div class="form-step">
    <h2 class="title">A. Konfirmasi Armada & Kendaraan</h2>

    <div id="kendaraan-list">
        <div class="kendaraan-item">
         <!-- Tombol hapus -->
        <button type="button" class="remove-kendaraan btn-danger">❌ Hapus Kendaraan</button>
        <!-- Nomor Kendaraan / Plat -->
        <div class="form-group">
            <label>Nopol / Nama Kapal</label>
            <input type="text" name="kendaraan[nopol][]" placeholder="BM 1234 CD / Kapal ABC">
        </div>

        <!-- Upload Surat Operasi -->
        <div class="form-group">
            <label>Upload Surat Operasi</label>
            <small>Upload maksimal 2 file (contoh: STNK, KIR)</small>
            <input type="file" name="kendaraan[surat_operasi][][]" multiple>
        </div>

        <!-- Status Armada -->
        <div class="form-group">
            <label>Status Kendaraan</label>
            <select name="kendaraan[status][]" class="status-select">
            <option value="">-- Pilih Status --</option>
            <option value="beroperasi">Beroperasi</option>
            <option value="tidak_beroperasi">Tidak Beroperasi</option>
            <option value="dijual">Dijual</option>
            <option value="ubah_sifat">Ubah Sifat</option>
            <option value="ubah_bentuk">Ubah Bentuk</option>
            <option value="rusak_sementara">Rusak Sementara</option>
            <option value="rusak_selamanya">Rusak Selamanya</option>
            <option value="tidak_ditemukan">Tidak Ditemukan</option>
            </select>
        </div>

        <!-- Upload tambahan muncul sesuai status -->
        <div class="form-group upload-conditional hidden" data-status="dijual">
            <small>Upload maksimal 2 file (contoh: Surat Jual Beli)</small>
            <input type="file" name="kendaraan[surat_dijual][][]" multiple>
        </div>

        <div class="form-group upload-conditional hidden" data-status="ubah_sifat">
            <small>Upload maksimal 2 file (contoh: Surat Perubahan Fungsi)</small>
            <input type="file" name="kendaraan[surat_ubah_sifat][][]" multiple>
        </div>

        <div class="form-group upload-conditional hidden" data-status="ubah_bentuk">
            <small>Upload maksimal 2 file (contoh: Surat Modifikasi Kendaraan)</small>
            <input type="file" name="kendaraan[surat_ubah_bentuk][][]" multiple>
        </div>

        <div class="form-group upload-conditional hidden" data-status="rusak_sementara">
            <small>Upload maksimal 2 file (contoh: Surat Keterangan Bengkel)</small>
            <input type="file" name="kendaraan[surat_rusak_sementara][][]" multiple>
        </div>

        <div class="form-group upload-conditional hidden" data-status="rusak_selamanya">
            <small>Upload maksimal 2 file (contoh: Surat Keterangan Barang Rongsok)</small>
            <input type="file" name="kendaraan[surat_rusak_selamanya][][]" multiple>
        </div>

        <!-- Rekomendasi -->
        <div class="form-group">
            <label>Rekomendasi Tindak Lanjut</label>
            <textarea name="kendaraan[rekomendasi][]" placeholder="Tulis rekomendasi..."></textarea>
        </div>

        <hr>
        </div>
    </div>

  <!-- Tombol tambah kendaraan -->
  <button type="button" id="add-kendaraan" class="btn-secondary">+ Tambah Kendaraan</button>

  <hr>

    <!-- 12. Hasil Kunjungan -->
    <h2 class="title">B. Hasil Kunjungan</h2>
    <div class="form-group">
        <label>Penjelasan Hasil Kunjungan</label>
        <textarea name="hasil_kunjungan" placeholder="Tuliskan Nopol / Nama Kapal dan penjelasan berdasarkan hasil kunjungan..."></textarea>
        <small>Tambahkan gambar atau file dokumen jika diperlukan</small>
        <input type="file" name="hasil_file[]" multiple>
    </div>

    <!-- 13. Jumlah Tunggakan -->
    <div class="form-group">
        <label>Jumlah Tunggakan (Rp)</label>
        <input type="number" name="tunggakan" placeholder="Contoh: 5000000">
    </div>

    <!-- 14. Janji Bayar -->
    <div class="form-group">
        <label>Janji Bayar Tunggakan</label>
        <input type="date" name="janji_bayar">
    </div>

    <!-- Navigation -->
    <div class="btns-group">
        <button type="button" class="btn prev-btn">Previous</button>
        <button type="button" class="btn next-btn">Next</button>
    </div>
    </div>

      <!-- Step 3 -->
      <div class="form-step">
        <h2 class="title">Upload & Penilaian</h2>

        <div class="form-group">
          <label>Upload Foto Kunjungan</label>
          <input type="file" name="foto_kunjungan[]" multiple>
        </div>

        <div class="form-group">
          <label>Upload Surat Pernyataan & Evidence</label>
          <input type="file" name="evidence[]" multiple>
        </div>

        <!-- Respon Pemilik -->
        <div class="form-group">
            <label>Respon Pemilik / Pengelola</label>
            <div class="rating">
            <input type="radio" name="profiling[respon]" value="5" id="respon-5"><label for="respon-5">★</label>
            <input type="radio" name="profiling[respon]" value="4" id="respon-4"><label for="respon-4">★</label>
            <input type="radio" name="profiling[respon]" value="3" id="respon-3"><label for="respon-3">★</label>
            <input type="radio" name="profiling[respon]" value="2" id="respon-2"><label for="respon-2">★</label>
            <input type="radio" name="profiling[respon]" value="1" id="respon-1"><label for="respon-1">★</label>
            </div>
        </div>

        <!-- Kesadaran Penyetoran Iuran Wajib -->
        <div class="form-group">
            <label>Kesadaran Penyetoran Iuran Wajib</label>
            <div class="rating">
            <input type="radio" name="profiling[iuran]" value="5" id="iuran-5"><label for="iuran-5">★</label>
            <input type="radio" name="profiling[iuran]" value="4" id="iuran-4"><label for="iuran-4">★</label>
            <input type="radio" name="profiling[iuran]" value="3" id="iuran-3"><label for="iuran-3">★</label>
            <input type="radio" name="profiling[iuran]" value="2" id="iuran-2"><label for="iuran-2">★</label>
            <input type="radio" name="profiling[iuran]" value="1" id="iuran-1"><label for="iuran-1">★</label>
            </div>
        </div>

        <!-- Keramaian Penumpang -->
        <div class="form-group">
            <label>Keramaian Penumpang</label>
            <div class="rating">
            <input type="radio" name="profiling[penumpang]" value="5" id="penumpang-5"><label for="penumpang-5">★</label>
            <input type="radio" name="profiling[penumpang]" value="4" id="penumpang-4"><label for="penumpang-4">★</label>
            <input type="radio" name="profiling[penumpang]" value="3" id="penumpang-3"><label for="penumpang-3">★</label>
            <input type="radio" name="profiling[penumpang]" value="2" id="penumpang-2"><label for="penumpang-2">★</label>
            <input type="radio" name="profiling[penumpang]" value="1" id="penumpang-1"><label for="penumpang-1">★</label>
            </div>
        </div>

        <!-- Ketaatan Pengurusan Izin Angkutan -->
        <div class="form-group">
            <label>Ketaatan Pengurusan Izin Angkutan</label>
            <div class="rating">
            <input type="radio" name="profiling[izin]" value="5" id="izin-5"><label for="izin-5">★</label>
            <input type="radio" name="profiling[izin]" value="4" id="izin-4"><label for="izin-4">★</label>
            <input type="radio" name="profiling[izin]" value="3" id="izin-3"><label for="izin-3">★</label>
            <input type="radio" name="profiling[izin]" value="2" id="izin-2"><label for="izin-2">★</label>
            <input type="radio" name="profiling[izin]" value="1" id="izin-1"><label for="izin-1">★</label>
            </div>
        </div>

        <!-- Ketaatan Uji KIR -->
        <div class="form-group">
            <label>Ketaatan Uji KIR / Sertifikat Keselamatan Kapal</label>
            <div class="rating">
            <input type="radio" name="profiling[kir]" value="5" id="kir-5"><label for="kir-5">★</label>
            <input type="radio" name="profiling[kir]" value="4" id="kir-4"><label for="kir-4">★</label>
            <input type="radio" name="profiling[kir]" value="3" id="kir-3"><label for="kir-3">★</label>
            <input type="radio" name="profiling[kir]" value="2" id="kir-2"><label for="kir-2">★</label>
            <input type="radio" name="profiling[kir]" value="1" id="kir-1"><label for="kir-1">★</label>
            </div>
        </div>

        <div class="form-group">
            <label>Tanda Tangan Petugas</label>
            <canvas id="ttd_petugas" width="500" height="200"
                style="border:1px solid #ccc; border-radius:8px; cursor: url('https://cdn.iconscout.com/icon/free/png-256/pen-1767892-1502435.png') 0 20, auto;">
            </canvas>
            <div>
                <button type="button" onclick="clearSignature('ttd_petugas')">Hapus</button>
            </div>
            <input type="hidden" name="ttd_petugas_data" id="ttd_petugas_data">
        </div>

        <div class="form-group">
            <label>Tanda Tangan Pemilik</label>
            <canvas id="ttd_pemilik" width="500" height="200"
                style="border:1px solid #ccc; border-radius:8px; cursor: url('https://cdn.iconscout.com/icon/free/png-256/pen-1767892-1502435.png') 0 20, auto;">
            </canvas>
            <div>
                <button type="button" onclick="clearSignature('ttd_pemilik')">Hapus</button>
            </div>
            <input type="hidden" name="ttd_pemilik_data" id="ttd_pemilik_data">
        </div>

        <div class="btns-group">
          <button type="button" class="btn prev-btn">Previous</button>
          <button type="submit" class="btn-submit">Submit</button>
        </div>
      </div>
    </form>
  </div>
</div>

<style>
  body {
    background: #f4f8fb;
    font-family: 'Segoe UI', sans-serif;
  }
  .form-wrapper {
    display: flex;
    justify-content: center;
    align-items: center;
    padding: 40px 10px;
  }
  .form-card {
    background: #fff;
    border-radius: 12px;
    padding: 30px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    max-width: 800px;
    width: 100%;
  }
  .progressbar {
    display: flex;
    justify-content: space-between;
    margin-bottom: 50px;
    position: relative;
  }
  .progressbar::before {
    content: "";
    position: absolute;
    top: 50%;
    left: 0;
    height: 4px;
    width: 100%;
    background: #d0e2f7;
    transform: translateY(-50%);
    z-index: -1;
  }
  .progress {
    height: 4px;
    background: #007bff;
    width: 0%;
    position: absolute;
    top: 50%;
    left: 0;
    transform: translateY(-50%);
    transition: 0.3s;
    z-index: -1;
  }
  .progress-step {
    background: #d0e2f7;
    color: #007bff;
    width: 30px;
    height: 30px;
    border-radius: 50%;
    display: flex;
    justify-content: center;
    align-items: center;
    font-size: 14px;
    position: relative;
  }
  .progress-step.active {
    background: #007bff;
    color: #fff;
  }
  .progress-step::after {
    content: attr(data-title);
    position: absolute;
    top: 40px;
    font-size: 12px;
    color: #666;
  }
  .title {
    font-size: 20px;
    color: #007bff;
    margin-bottom: 20px;
  }
  .form-group {
    margin-bottom: 15px;
  }
  .form-group label {
    font-weight: 600;
    margin-bottom: 6px;
    display: block;
  }
  .form-group input,
  .form-group select,
  .form-group textarea {
    width: 100%;
    padding: 10px 12px;
    border-radius: 6px;
    border: 1px solid #dce3ec;
    font-size: 14px;
  }
  .form-group textarea {
    min-height: 80px;
  }
  .row {
    display: flex;
    gap: 10px;
  }
  .btns-group {
    display: flex;
    justify-content: flex-end;
    gap: 10px;
    margin-top: 20px;
  }
  .btn {
    padding: 10px 20px;
    background: #007bff;
    color: #fff;
    border: none;
    border-radius: 6px;
    cursor: pointer;
    font-size: 14px;
    transition: 0.2s;
  }
  .btn:hover {
    background: #0056b3;
  }
  .btn-secondary {
    margin: 10px 0;
    padding: 6px 14px;
    background: #e9f3ff;
    color: #007bff;
    border: 1px solid #007bff;
    border-radius: 6px;
    font-size: 13px;
    cursor: pointer;
  }
  .btn-submit {
  background: linear-gradient(135deg, #28a745, #218838);
  color: #fff;
  font-weight: bold;
  padding: 12px 28px;
  border: none;
  border-radius: 8px;
  cursor: pointer;
  font-size: 16px;
  box-shadow: 0 4px 8px rgba(0,0,0,0.15);
  transition: all 0.3s ease;
}

.btn-submit:hover {
  background: linear-gradient(135deg, #218838, #1e7e34);
  transform: translateY(-2px);
  box-shadow: 0 6px 12px rgba(0,0,0,0.2);
}

.btn-submit:active {
  transform: translateY(0);
  box-shadow: 0 2px 6px rgba(0,0,0,0.15);
}
  .form-step { display: none; }
  .form-step.active { display: block; }
  .hidden { display: none; }
  .kendaraan-item {
        margin-bottom: 20px;
        padding: 15px;
        border: 1px solid #ccc;
        border-radius: 8px;
        position: relative;
    }
    .remove-kendaraan {
        background: #e74c3c;
        color: #fff;
        border: none;
        padding: 5px 10px;
        border-radius: 6px;
        cursor: pointer;
        margin-bottom: 10px;
    }
    .rating {
        display: flex;
        flex-direction: row-reverse;
        justify-content: center; /* ⭐ biar ke tengah */
        margin-top: 8px;
    }

    .rating input {
        display: none;
    }

    .rating label {
        font-size: 35px; /* ⭐ lebih besar */
        color: #ccc; /* abu lebih terang daripada #ddd */
        cursor: pointer;
        transition: transform 0.2s, color 0.2s;
        padding: 0 3px;
    }

    .rating input:checked ~ label,
    .rating label:hover,
    .rating label:hover ~ label {
        color: #f7c200; /* ⭐ gold lebih terang */
        transform: scale(1.1); /* efek zoom sedikit saat hover */
    }

    /* Floating Back Button */
    .back-btn {
        position: fixed; /* ganti absolute jadi fixed biar nempel di layar */
        top: 20px;
        left: 20px;
        background: #1e3a8a;
        color: white;
        border: none;
        width: 42px;
        height: 42px;
        border-radius: 50%;
        font-size: 18px;
        font-weight: bold;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        transition: transform 0.2s ease, background-color 0.3s ease;
    }

    .back-btn:hover {
        background: #1d4ed8;
        transform: translateY(-2px);
    }

</style>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
  const steps = document.querySelectorAll(".form-step");
  const progress = document.getElementById("progress");
  const progressSteps = document.querySelectorAll(".progress-step");

  let currentStep = 0;

  function updateProgressbar() {
    progressSteps.forEach((step, idx) => {
      if (idx <= currentStep) {
        step.classList.add("active");
      } else {
        step.classList.remove("active");
      }
    });
    const actives = document.querySelectorAll(".progress-step.active");
    progress.style.width = ((actives.length - 1) / (progressSteps.length - 1)) * 100 + "%";
  }

  document.querySelectorAll(".next-btn").forEach(btn => {
    btn.addEventListener("click", () => {
      steps[currentStep].classList.remove("active");
      currentStep++;
      steps[currentStep].classList.add("active");
      updateProgressbar();
    });
  });

  document.querySelectorAll(".prev-btn").forEach(btn => {
    btn.addEventListener("click", () => {
      steps[currentStep].classList.remove("active");
      currentStep--;
      steps[currentStep].classList.add("active");
      updateProgressbar();
    });
  });

  // Conditional Upload
  document.querySelectorAll(".conditional").forEach(sel => {
    sel.addEventListener("change", e => {
      let uploadDiv = e.target.parentNode.querySelector(".upload-dijual");
      if (e.target.value === "ya") {
        uploadDiv.classList.remove("hidden");
      } else {
        uploadDiv.classList.add("hidden");
      }
    });
  });

   // Tambah kendaraan baru
  document.getElementById('add-kendaraan').addEventListener('click', function () {
    const list = document.getElementById('kendaraan-list');
    const item = document.querySelector('.kendaraan-item').cloneNode(true);

    // kosongkan semua input
    item.querySelectorAll('input, textarea, select').forEach(el => {
      if (el.type === 'file') el.value = "";
      else el.value = "";
    });

    list.appendChild(item);
  });

  // Hapus kendaraan
  document.addEventListener('click', function (e) {
    if (e.target.classList.contains('remove-kendaraan')) {
      const item = e.target.closest('.kendaraan-item');
      const list = document.getElementById('kendaraan-list');
      if (list.children.length > 1) {
        item.remove(); // hapus hanya kalau ada lebih dari 1 kendaraan
      } else {
        Swal.fire({
          icon: 'warning',
          title: 'Tidak bisa dihapus!',
          text: 'Minimal harus ada 1 kendaraan.',
          confirmButtonColor: '#3085d6',
          confirmButtonText: 'Mengerti 👍'
        });
      }
    }
  });

  // Kondisi upload tambahan berdasarkan status
  document.addEventListener('change', function (e) {
    if (e.target.classList.contains('status-select')) {
      const container = e.target.closest('.kendaraan-item');
      const selected = e.target.value;
      container.querySelectorAll('.upload-conditional').forEach(div => {
        div.classList.add('hidden');
        if (div.dataset.status === selected) {
          div.classList.remove('hidden');
        }
      });
    }
  });

  function initSignaturePad(canvasId, inputId) {
    const canvas = document.getElementById(canvasId);
    const ctx = canvas.getContext("2d");
    let drawing = false;

    ctx.lineWidth = 2;
    ctx.lineCap = "round";
    ctx.strokeStyle = "black";

    function startDraw(e) {
        drawing = true;
        ctx.beginPath();
        ctx.moveTo(getX(e), getY(e));
        e.preventDefault();
    }

    function draw(e) {
        if (!drawing) return;
        ctx.lineTo(getX(e), getY(e));
        ctx.stroke();
        e.preventDefault();
    }

    function stopDraw() {
        if (!drawing) return;
        drawing = false;
        document.getElementById(inputId).value = canvas.toDataURL(); // simpan hasil
    }

    function getX(e) {
        if (e.touches) return e.touches[0].clientX - canvas.getBoundingClientRect().left;
        return e.offsetX;
    }

    function getY(e) {
        if (e.touches) return e.touches[0].clientY - canvas.getBoundingClientRect().top;
        return e.offsetY;
    }

    // mouse events
    canvas.addEventListener("mousedown", startDraw);
    canvas.addEventListener("mousemove", draw);
    canvas.addEventListener("mouseup", stopDraw);
    canvas.addEventListener("mouseout", stopDraw);

    // touch events (HP/Tablet)
    canvas.addEventListener("touchstart", startDraw);
    canvas.addEventListener("touchmove", draw);
    canvas.addEventListener("touchend", stopDraw);
    }

    function clearSignature(canvasId) {
    const canvas = document.getElementById(canvasId);
    const ctx = canvas.getContext("2d");
    ctx.clearRect(0, 0, canvas.width, canvas.height);
    }

    // inisialisasi
    initSignaturePad("ttd_petugas", "ttd_petugas_data");
    initSignaturePad("ttd_pemilik", "ttd_pemilik_data");

  updateProgressbar();
</script>
@endsection
