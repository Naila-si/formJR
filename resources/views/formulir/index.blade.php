@extends('layouts.app')

@section('title', 'Formulir CRM')

@section('content')
<!-- AUDIO: suara notifikasi step -->
<audio id="stepSound" src="{{ asset('audio/notify.mp3') }}" preload="auto"></audio>

<!-- Tombol Kembali melayang -->
<a href="{{ url('/') }}">
  <button type="button" class="back-btn" aria-label="Kembali">←</button>
</a>

<div class="form-wrapper">
  <div class="form-card">
    <!-- Header form -->
    <div class="form-header">
      <div class="title-wrap">
        <h1>Formulir CRM</h1>
        <p>Isi data kunjungan, armada/kendaraan, lalu upload bukti &amp; penilaian. Ikuti langkah-langkah di bawah ini.</p>
      </div>
    </div>

    <!-- Progress -->
    <div class="progressbar">
      <div class="progress" id="progress"></div>
      <div class="progress-step active" data-title="Data Kunjungan">1</div>
      <div class="progress-step" data-title="Armada">2</div>
      <div class="progress-step" data-title="Upload &amp; Penilaian">3</div>
    </div>

    <form action="{{ route('formulir.store') }}" method="POST" enctype="multipart/form-data" id="crmForm">
      @csrf

      <!-- STEP 1 -->
      <div class="form-step active" data-step="1">
        <div class="section-card">
          <h2 class="section-title"><span class="section-dot"></span> Data Kunjungan</h2>

          <div class="grid-1">
            <div class="form-group">
              <label>Tanggal &amp; Waktu Kunjungan</label>
              <input type="datetime-local" name="tanggal_waktu" required>
            </div>

            <div class="form-group">
              <label>Loket</label>
              <input list="loket-list" name="loket" id="loket" placeholder="Ketik nama loket..." required>
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
              <label>Nama Petugas</label>
              <div class="row-col">
                <input type="text" name="nama_depan" placeholder="Nama Depan" required>
                <input type="text" name="nama_belakang" placeholder="Nama Belakang" required>
              </div>
            </div>

            <div class="form-group">
              <label>Telah melakukan kunjungan ke Pemilik/Operator atas nama PT/CV?</label>
              <input type="text" name="nama_pt" placeholder="Contoh: PT Maju Jaya" required>
            </div>

            <div class="form-group">
              <label>Jenis Angkutan</label>
              <select name="jenis_angkutan" required>
                <option value="Kendaraan Bermotor Umum">Kendaraan Bermotor Umum</option>
                <option value="Kapal Penumpang Umum">Kapal Penumpang Umum</option>
              </select>
            </div>

            <div class="form-group">
              <label>Nama Pemilik / Pengelola</label>
              <input type="text" name="nama_pengelola" required>
            </div>

            <div class="form-group">
              <label>Alamat yang Dikunjungi</label>
              <textarea name="alamat" placeholder="Alamat lengkap..." required></textarea>
            </div>

            <div class="form-group">
              <label>No. Telepon / HP Pemilik / Pengelola</label>
              <input type="text" name="telepon" placeholder="08xxxxxxxxxx" required>
            </div>
          </div>

          <div class="card-actions">
            <button type="button" class="btn next-btn">Lanjut ke Armada</button>
          </div>
        </div>
      </div>

      <!-- STEP 2 -->
      <div class="form-step" data-step="2">
        <div class="section-card">
          <h2 class="section-title"><span class="section-dot"></span> A. Konfirmasi Armada &amp; Kendaraan</h2>

          <div id="kendaraan-list" class="stack gap-16">
            <div class="kendaraan-item">
              <div class="item-head">
                <strong>Data Kendaraan</strong>
                <button type="button" class="remove-kendaraan btn-danger">Hapus</button>
              </div>

              <div class="grid-1">
                <div class="form-group">
                  <label>Nopol / Nama Kapal</label>
                  <input type="text" name="kendaraan[nopol][]" class="nopol-input" list="nopolList" placeholder="BM 1234 CD" required>
                  <datalist id="nopolList">
                    @foreach($nopolList as $nopol)
                      <option value="{{ $nopol}}">
                    @endforeach
                  </datalist>
                </div>

                <div class="form-group">
                  <label>Status Kendaraan</label>
                  <select name="kendaraan[status][]" class="status-select" required>
                    <option value="">-- Pilih Status --</option>
                    <option value="beroperasi_bayar">Beroperasi + Bayar</option>
                    <option value="beroperasi">Beroperasi</option>
                    <option value="dijual">Dijual</option>
                    <option value="ubah_sifat">Ubah Sifat</option>
                    <option value="ubah_bentuk">Ubah Bentuk</option>
                    <option value="rusak_sementara">Rusak Sementara</option>
                    <option value="rusak_selamanya">Rusak Selamanya</option>
                    <option value="tidak_ditemukan">Tidak Ditemukan</option>
                    <option value="cadangan">Cadangan</option>
                  </select>
                </div>

                <div class="form-group">
                  <label class="muted">Informasi OS</label>
                  <small class="osInfo muted">Nominal OS akan tampil di sini…</small>
                </div>
              </div>

              <div class="form-group conditional hidden" data-status="beroperasi_bayar">
                <label>Jumlah Pembayaran</label>
                <small>Pembayaran boleh lebih dari nilai nominal OS</small>
                <input type="number" name="kendaraan[jumlah_bayar][]" placeholder="Masukkan jumlah pembayaran">
              </div>

              <div class="grid-1">
                <div class="form-group upload-conditional hidden" data-status="dijual">
                  <label>Dokumen Penjualan (max 2 file)</label>
                  <input type="file" name="kendaraan[surat_dijual][][]" multiple>
                </div>
                <div class="form-group upload-conditional hidden" data-status="ubah_sifat">
                  <label>Dokumen Ubah Sifat (max 2 file)</label>
                  <input type="file" name="kendaraan[surat_ubah_sifat][][]" multiple>
                </div>
                <div class="form-group upload-conditional hidden" data-status="ubah_bentuk">
                  <label>Dokumen Ubah Bentuk (max 2 file)</label>
                  <input type="file" name="kendaraan[surat_ubah_bentuk][][]" multiple>
                </div>
                <div class="form-group upload-conditional hidden" data-status="rusak_sementara">
                  <label>Bukti Rusak Sementara (max 2 file)</label>
                  <input type="file" name="kendaraan[surat_rusak_sementara][][]" multiple>
                </div>
                <div class="form-group upload-conditional hidden" data-status="rusak_selamanya">
                  <label>Bukti Rusak Selamanya (max 2 file)</label>
                  <input type="file" name="kendaraan[surat_rusak_selamanya][][]" multiple>
                </div>
              </div>

              <hr class="divider">
            </div>
          </div>

          <button type="button" id="add-kendaraan" class="btn-secondary w-fit">+ Tambah Kendaraan</button>
        </div>

        <div class="section-card">
          <h2 class="section-title"><span class="section-dot"></span> B. Hasil Kunjungan</h2>

          <div class="grid-1">
            <div class="form-group">
              <label>Penjelasan Hasil Kunjungan</label>
              <textarea name="hasil_kunjungan" placeholder="Tuliskan Nopol / Nama Kapal dan penjelasan berdasarkan hasil kunjungan..." required></textarea>
            </div>

            <div class="form-group">
              <label>Janji Bayar Tunggakan</label>
              <input type="datetime-local" name="janji_bayar">
            </div>
          </div>

          <div class="card-actions">
            <button type="button" class="btn ghost prev-btn">Kembali</button>
            <button type="button" class="btn next-btn">Lanjut ke Upload</button>
          </div>
        </div>
      </div>

      <!-- STEP 3 -->
      <div class="form-step" data-step="3">
        <div class="section-card">
          <h2 class="section-title"><span class="section-dot"></span> Upload &amp; Penilaian</h2>

          <div class="grid-1">
            <div class="form-group">
              <label>Upload Foto Kunjungan</label>
              <input type="file" name="foto_kunjungan[]" multiple>
            </div>

            <div class="form-group">
              <label>Upload Surat Pernyataan &amp; Evidence (max 5 file)</label>
              <input id="evidenceInput" type="file" name="evidence[]" multiple>
            </div>

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

            <div class="form-group">
              <label>Tanda Tangan Petugas</label>
              <div class="signature-card">
                <canvas id="ttd_petugas" class="signature"></canvas>
                <div class="sig-actions">
                  <button type="button" class="btn ghost" onclick="clearSignature('ttd_petugas')">Hapus</button>
                </div>
              </div>
              <input type="hidden" name="ttd_petugas_data" id="ttd_petugas_data">
            </div>

            <div class="form-group">
              <label>Tanda Tangan Pemilik</label>
              <div class="signature-card">
                <canvas id="ttd_pemilik" class="signature"></canvas>
                <div class="sig-actions">
                  <button type="button" class="btn ghost" onclick="clearSignature('ttd_pemilik')">Hapus</button>
                </div>
              </div>
              <input type="hidden" name="ttd_pemilik_data" id="ttd_pemilik_data">
            </div>
          </div>

          <div class="card-actions">
            <button type="button" class="btn ghost prev-btn">Kembali</button>
            <button type="submit" class="btn-submit">Submit</button>
          </div>
        </div>
      </div>
    </form>
  </div>
</div>

<style>
  :root{
    --bg:#eef6ff; --panel:#ffffff; --soft:#f8fafc;
    --ink:#0f172a; --muted:#475569;
    --brand:#2563eb; --brand-2:#3b82f6; --accent:#10b981;
    --danger:#ef4444;
    --shadow:0 12px 28px rgba(37,99,235,.12);
    --radius:16px; --radius-lg:18px;
    --gap:18px;
  }

  /* ====== LAYOUT FULL LAYAR ====== */
  body{background:linear-gradient(180deg,var(--bg),#fff);font-family:'Inter','Segoe UI',sans-serif;margin:0}
  .form-wrapper{
    display:flex;justify-content:center;align-items:flex-start;
    padding:28px clamp(8px,2vw,22px);
  }
  .form-card{
    background:var(--panel);border:1px solid #e2e8f0;border-radius:var(--radius-lg);
    box-shadow:var(--shadow);
    padding: clamp(22px,2.2vw,32px);
    /* Full layar tapi tetap ada gutter kiri/kanan */
    width: min(1400px, 96vw);
  }

  /* HEADER */
  .form-header{display:flex;gap:12px;align-items:flex-start;justify-content:space-between;margin-bottom:6px}
  .form-header h1{margin:0 0 6px 0;font-size:clamp(22px,3.2vw,32px);color:var(--brand)}
  .form-header p{margin:0;color:var(--muted);font-size:clamp(13px,1.3vw,15px);line-height:1.55}
  .badge{background:linear-gradient(90deg,var(--brand),var(--brand-2));color:#fff;border-radius:999px;padding:8px 12px;font-weight:700;box-shadow:var(--shadow);font-size:12px;white-space:nowrap}

  /* PROGRESS */
  .progressbar{display:flex;justify-content: space-around;;align-items:center;margin:22px 0 24px;position:relative}
  .progressbar::before{content:"";position:absolute;top:50%;left:0;height:5px;width:100%;background:#dbeafe;transform:translateY(-50%);z-index:0;border-radius:999px}
  .progress{height:5px;background:linear-gradient(90deg,var(--brand),var(--brand-2));width:0%;position:absolute;top:50%;left:0;transform:translateY(-50%);transition:.35s;border-radius:999px;z-index:1}
  .progress-step{position:relative;z-index:2;width:40px;height:40px;border-radius:50%;display:grid;place-items:center;background:#e5edff;color:#1e293b;font-weight:800;box-shadow:0 2px 8px rgba(15,23,42,.12)}
  .progress-step.active{background:var(--brand);color:#fff}
  .progress-step::after{content:attr(data-title);position:absolute;top:46px;left:50%;transform:translateX(-50%);white-space:nowrap;font-size:12px;color:#64748b;width: max-content;}

  /* SECTION CARD */
  .section-card{background:var(--panel);border:1px solid #e6eef9;border-radius:20px;padding:18px clamp(14px,2vw,22px);margin: 32px 0 18px;box-shadow:0 8px 18px rgba(15,23,42,.04)}
  .section-title{display:flex;align-items:center;gap:10px;margin:0 0 14px;font-size:18px}
  .section-dot{width:10px;height:10px;border-radius:50%;background:var(--brand)}
  .card-actions{display:flex;justify-content:flex-end;gap:10px;margin-top:8px}

  /* GRID SEDERHANA (1 kolom) */
  .grid-1{display:grid;grid-template-columns:1fr;gap:var(--gap)}
  .row-col{display:flex;flex-direction:column;gap:10px}
  .stack{display:flex;flex-direction:column}
  .gap-16{gap:16px}
  .w-fit{width:fit-content}
  .divider{border:0;border-top:1px solid #e2e8f0;margin:12px 0 0}

  /* FORM CONTROL */
  .form-group{display:flex;flex-direction:column;gap:6px}
  .form-group label{font-weight:700;color:#0f172a}
  .form-group input,.form-group select,.form-group textarea{
    width:100%;padding:12px 12px;border-radius:12px;border:1px solid #e2e8f0;background:var(--soft);font-size:15px;outline:none;transition:border-color .15s, box-shadow .15s
  }
  .form-group input:focus,.form-group select:focus,.form-group textarea:focus{
    border-color:#93c5fd; box-shadow:0 0 0 3px rgba(147,197,253,.35);
    background:#fff;
  }
  .form-group textarea{min-height:120px}
  .muted{color:#64748b}

  /* KENDARAAN CARD */
  .kendaraan-item{margin:0;padding:16px;border:1px solid #e6eef9;border-radius:16px;background:#fff;box-shadow:0 6px 14px rgba(15,23,42,.04)}
  .item-head{display:flex;justify-content:space-between;align-items:center;margin-bottom:8px}

  /* SIGNATURE (BESAR & RESPONSIF) */
  .signature-card{padding:12px;border:1px dashed #cbd5e1;border-radius:14px;background:#fff}
  .signature{display:block;width:100%;height:auto;max-width:100%}
  .sig-actions{margin-top:8px}

  /* BUTTONS */
  .btn{padding:10px 16px;border-radius:12px;border:0;background:linear-gradient(90deg,var(--brand),var(--brand-2));color:#fff;font-weight:800;box-shadow:var(--shadow);cursor:pointer;transition:.2s}
  .btn:hover{transform:translateY(-1px)}
  .btn.ghost{background:#eef2ff;color:#1e293b;border:1px solid #c7d2fe}
  .btn-secondary{margin:10px 0;padding:9px 14px;background:#eaf2ff;color:#1e3a8a;border:1px solid #93c5fd;border-radius:10px;font-weight:700;cursor:pointer}
  .btn-danger{background:#fee2e2;color:#991b1b;border:1px solid #fecaca;border-radius:10px;padding:6px 10px;cursor:pointer}
  .btn-submit{background:linear-gradient(135deg,#16a34a,#0ea5e9);padding:12px 22px;border-radius:14px;color:#fff;border:0;font-weight:800;box-shadow:0 10px 24px rgba(16,163,74,.2)}

  /* STEP VISIBILITY */
  .form-step{display:none;animation:fadeIn .25s ease}
  .form-step.active{display:block}
  .hidden{display:none}

  /* BACK BUTTON */
  .back-btn{
    position:fixed;top:18px;left:18px;z-index:60;
    background:linear-gradient(90deg,var(--brand),var(--brand-2));color:#fff;border:0;
    width:44px;height:44px;border-radius:50%;font-size:18px;font-weight:800;cursor:pointer;
    display:flex;align-items:center;justify-content:center;box-shadow:var(--shadow);transition:.2s
  }
  .back-btn:hover{transform:translateY(-2px)}

  /* RATING */
  .rating{display:flex;flex-direction:row-reverse;gap:6px;justify-content:flex-start}
  .rating input{display:none}
  .rating label{font-size:28px;color:#cbd5e1;cursor:pointer;transition:.2s;padding:0 2px}
  .rating input:checked ~ label,.rating label:hover,.rating label:hover ~ label{color:#f59e0b;transform:scale(1.06)}

  /* ANIMATION */
  @keyframes fadeIn{from{opacity:0;transform:translateY(4px)}to{opacity:1;transform:translateY(0)}}
</style>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
  // =========================
  // STEP CONTROL + SOUND
  // =========================
  const stepSound = document.getElementById('stepSound');
  function playStepSound(){ const p = stepSound?.play(); if(p && typeof p.catch === 'function'){ p.catch(()=>{}); } }

  const steps = document.querySelectorAll(".form-step");
  const progress = document.getElementById("progress");
  const progressSteps = document.querySelectorAll(".progress-step");
  let currentStep = 0;

  function setStep(i){
    if(i < 0 || i >= steps.length) return;
    steps[currentStep].classList.remove("active");
    currentStep = i;
    steps[currentStep].classList.add("active");
    updateProgressbar();
    playStepSound();
    document.querySelector('.form-card')?.scrollIntoView({behavior:'smooth', block:'start'});
  }

  function updateProgressbar() {
    progressSteps.forEach((step, idx) => {
      if (idx <= currentStep) step.classList.add("active");
      else step.classList.remove("active");
    });
    const actives = document.querySelectorAll(".progress-step.active");
    progress.style.width = ((actives.length - 1) / (progressSteps.length - 1)) * 100 + "%";
  }

  document.querySelectorAll(".next-btn").forEach(btn => {
    btn.addEventListener("click", () => setStep(currentStep + 1));
  });
  document.querySelectorAll(".prev-btn").forEach(btn => {
    btn.addEventListener("click", () => setStep(currentStep - 1));
  });

  // =========================
  // KENDARAAN: tambah/hapus + OS + kondisi upload
  // =========================
  const listKendaraan = document.getElementById('kendaraan-list');
  document.getElementById('add-kendaraan').addEventListener('click', () => {
    const item = listKendaraan.querySelector('.kendaraan-item').cloneNode(true);
    item.querySelectorAll('input, textarea').forEach(el => el.value = "");
    item.querySelectorAll('select').forEach(el => el.selectedIndex = 0);
    item.querySelectorAll('.osInfo').forEach(el => { el.textContent = 'Nominal OS akan tampil di sini…'; el.style.color = '#64748b'; });
    item.querySelectorAll('.conditional, .upload-conditional').forEach(el => el.classList.add('hidden'));
    listKendaraan.appendChild(item);
  });

  document.addEventListener('click', (e) => {
    if (e.target.classList.contains('remove-kendaraan')) {
      const item = e.target.closest('.kendaraan-item');
      if (document.querySelectorAll('.kendaraan-item').length > 1) {
        item.remove();
      } else {
        Swal.fire({icon:'warning',title:'Tidak bisa dihapus',text:'Minimal harus ada 1 kendaraan.',confirmButtonColor:'#2563eb'});
      }
    }
  });

  // Delegasi: perubahan nopol → fetch OS
  document.addEventListener('change', (e) => {
    if (e.target.classList.contains('nopol-input')) {
      const nopol = e.target.value;
      if (!nopol) return;
      const item = e.target.closest('.kendaraan-item');
      const osInfo = item.querySelector('.osInfo');

      fetch(`/get-os/${encodeURIComponent(nopol)}`)
        .then(res => { if(!res.ok) throw new Error('Data tidak ditemukan'); return res.json(); })
        .then(data => {
          const nominal = Number(data.nilai_outstanding);
          if (!isNaN(nominal)) {
            osInfo.style.color = "#16a34a";
            osInfo.textContent = "Nominal OS: " + formatRupiah(nominal);
          } else {
            osInfo.style.color = "#ef4444";
            osInfo.textContent = "Data OS tidak valid";
          }
        })
        .catch(err => {
          osInfo.style.color = "#ef4444";
          osInfo.textContent = err.message || "Gagal memuat data OS";
        });
    }
  });

  // Delegasi: status-select → tampilkan field kondisional
  document.addEventListener('change', (e) => {
    if (e.target.classList.contains('status-select')) {
      const selected = e.target.value;
      const item = e.target.closest('.kendaraan-item');

      item.querySelectorAll('.conditional').forEach(div => {
        const match = div.getAttribute('data-status') === selected;
        div.classList.toggle('hidden', !match);
      });

      item.querySelectorAll('.upload-conditional').forEach(div => {
        const match = div.getAttribute('data-status') === selected;
        div.classList.toggle('hidden', !match);
      });
    }
  });

  // Limit evidence max 5 file
  const ev = document.getElementById('evidenceInput');
  if (ev) {
    ev.addEventListener('change', function(){
      if(this.files.length > 5){
        Swal.fire({icon:'info', title:'Maksimal 5 file', confirmButtonColor:'#2563eb'});
        this.value = "";
      }
    });
  }

  function formatRupiah(angka) {
    try {
      return new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(angka);
    } catch { return angka; }
  }

  // =========================
  // SIGNATURE PAD (RESPONSIF + RETINA)
  // =========================
  function setupSignature(canvasId, inputId){
    const canvas = document.getElementById(canvasId);
    const hidden = document.getElementById(inputId);
    const ctx = canvas.getContext('2d');

    let drawing = false;
    let ratio = Math.max(window.devicePixelRatio || 1, 1);

    function resize(){
      const ratio = Math.max(window.devicePixelRatio || 1, 1);
      const container = canvas.parentElement; // .signature-card
      const targetWidth = container.clientWidth - 20; // padding
      const targetHeight = Math.max(260, Math.min(320, Math.round(targetWidth * 0.35))); // 35% dari lebar

      canvas.style.width = targetWidth + 'px';
      canvas.style.height = targetHeight + 'px';
      canvas.width = Math.floor(targetWidth * ratio);
      canvas.height = Math.floor(targetHeight * ratio);

      ctx.scale(ratio, ratio);
      ctx.lineWidth = 2;
      ctx.lineCap = 'round';
      ctx.strokeStyle = '#111827';
    }

    function pos(e){
        const rect = canvas.getBoundingClientRect();
        let x, y;
        if(e.touches && e.touches[0]){
        x = e.touches[0].clientX - rect.left;
        y = e.touches[0].clientY - rect.top;
        } else {
        x = e.clientX - rect.left;
        y = e.clientY - rect.top;
        }
        // Sesuaikan dengan ratio
        return { x: x * ratio / (canvas.width / canvas.clientWidth), y: y * ratio / (canvas.height / canvas.clientHeight) };
    }

    function start(e){ drawing = true; ctx.beginPath(); const p = pos(e); ctx.moveTo(p.x, p.y); e.preventDefault(); }
    function move(e){ if(!drawing) return; const p = pos(e); ctx.lineTo(p.x, p.y); ctx.stroke(); e.preventDefault(); }
    function end(){ if(!drawing) return; drawing = false; hidden.value = canvas.toDataURL('image/png'); }

    resize();
    window.addEventListener('resize', () => { const data = ctx.getImageData(0,0,canvas.width,canvas.height); resize(); ctx.putImageData(data,0,0); });

    canvas.addEventListener('mousedown', start);
    canvas.addEventListener('mousemove', move);
    canvas.addEventListener('mouseup', end);
    canvas.addEventListener('mouseleave', end);

    canvas.addEventListener('touchstart', start, {passive:false});
    canvas.addEventListener('touchmove', move, {passive:false});
    canvas.addEventListener('touchend', end);
  }

  function clearSignature(canvasId){
    const canvas = document.getElementById(canvasId);
    const ctx = canvas.getContext("2d");
    ctx.clearRect(0,0,canvas.width,canvas.height);
  }
  window.clearSignature = clearSignature;

  // init
  setupSignature("ttd_petugas", "ttd_petugas_data");
  setupSignature("ttd_pemilik", "ttd_pemilik_data");

  // =========================
  // SUBMIT + GEOLOCATION
  // =========================
  const form = document.getElementById('crmForm');
  form.addEventListener('submit', function(e){
    if (!navigator.geolocation) return; // lanjut submit biasa
    e.preventDefault();
    navigator.geolocation.getCurrentPosition(
      (pos) => {
        const lat = document.createElement('input'); lat.type='hidden'; lat.name='latitude'; lat.value=pos.coords.latitude;
        const lng = document.createElement('input'); lng.type='hidden'; lng.name='longitude'; lng.value=pos.coords.longitude;
        form.appendChild(lat); form.appendChild(lng);
        form.submit();
      },
      () => {
        Swal.fire({icon:'warning', title:'Izin lokasi diperlukan', text:'Aktifkan lokasi untuk submit form.'});
      }
    );
  });

  // Init progress
  updateProgressbar();
</script>
@endsection
