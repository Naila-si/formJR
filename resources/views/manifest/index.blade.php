@extends('layouts.app')

@section('title', 'Form Manifest Real Time')

@section('content')
<a href="{{ url('/') }}">
    <button type="button" class="back-btn">←</button>
</a>

<div class="form-wrapper">
  <div class="form-card">
    <div class="form-header">
      <div class="title-wrap">
        <h1>Formulir Manifest</h1>
        <p>Isi data kapal & keberangkatan, penumpang, lalu upload bukti pencatatan manifest &amp; tanda tangan. Ikuti langkah-langkah di bawah ini.</p>
      </div>
    </div>

    <div class="progressbar">
      <div class="progress" id="progress"></div>
      <div class="progress-step active" data-title="Data Kapal"></div>
      <div class="progress-step" data-title="Penumpang"></div>
      <div class="progress-step" data-title="Upload & Tanda Tangan"></div>
    </div>

    <form action="{{ route('manifest.store') }}" method="POST" enctype="multipart/form-data">
      @csrf

      <!-- Step 1 -->
      <div class="form-step active">
        <h2 class="title">Data Kapal & Keberangkatan</h2>

        <div class="form-group">
          <label>Nama Kapal</label>
          <select name="nama_kapal" required>
            <option value="">-- Pilih Kapal --</option>
            <option>SB Karunia Jaya</option>
            <option>SB Bintang Rizky Express 89</option>
            <option>SB Verando 12</option>
            <option>SB Karunia Jaya Mini 01</option>
            <option>SB Terubuk Express 2</option>
            <option>SB Four Brother 01</option>
            <option>SB Meranti Express 89</option>
            <option>SB Meranti Jaya</option>
          </select>
        </div>

        <div class="form-group">
          <label>Tanggal & Waktu Keberangkatan</label>
          <input type="datetime-local" name="tanggal_keberangkatan" required>
        </div>

        <div class="form-group">
          <label>Keberangkatan Asal</label>
          <select name="asal_keberangkatan" required>
            <option value="">-- Pilih Pelabuhan --</option>
            <option>Pelabuhan Mengkapan Buton Siak</option>
            <option>Pelabuhan Tanjung Harapan Selat Panjang</option>
          </select>
        </div>

        <div class="btns-group">
          <button type="button" class="btn next-btn">Next</button>
        </div>
      </div>

      <!-- Step 2 -->
      <div class="form-step">
        <h2 class="title">Data Penumpang & Premi</h2>

        <div class="form-group">
          <label>Jumlah Penumpang Dewasa</label>
          <input type="number" min="0" name="dewasa" id="dewasa" value="0" required>
        </div>

        <div class="form-group">
          <label>Jumlah Penumpang Anak</label>
          <input type="number" min="0" name="anak" id="anak" value="0" required>
        </div>

        <div class="form-group">
          <label>Total Penumpang</label>
          <input type="number" name="total_penumpang" id="total_penumpang" readonly>
        </div>

        <div class="form-group">
          <label>Jumlah Premi Asuransi Jasa Raharja</label>
          <input type="number" name="premi_asuransi" id="premi_asuransi" readonly>
        </div>

        <div class="btns-group">
          <button type="button" class="btn prev-btn">Previous</button>
          <button type="button" class="btn next-btn">Next</button>
        </div>
      </div>

      <!-- Step 3 -->
      <div class="form-step">
        <h2 class="title">Upload & Tanda Tangan</h2>

        <div class="form-group">
          <label>Upload Foto Pencatatan Manifest</label>
          <input type="file" name="foto_manifest[]" multiple>
        </div>

        <div class="form-group">
          <label>Nama Agen / Pengelola</label>
          <input type="text" name="nama_agen" required>
        </div>

        <div class="form-group">
          <label>No. Telepon</label>
          <input type="text" name="telepon" required>
        </div>

        <div class="form-group">
          <label>Tanda Tangan</label>
          <div class="signature-card">
            <canvas id="ttd_petugas" width="500" height="200" style="border:1px solid #ccc; border-radius:8px; cursor: crosshair;"></canvas>
            <div class="sig-actions">
                <button type="button" onclick="clearSignature('ttd_petugas')">Hapus</button>
            </div>
          </div>
          <input type="hidden" name="ttd_petugas_data" id="ttd_petugas_data">
        </div>

        <div class="btns-group">
          <button type="button" class="btn prev-btn">Previous</button>
          <button type="submit" class="btn-submit">Submit</button>
        </div>
      </div>
    </form>
  </div>
</div>

<script>
const steps = document.querySelectorAll(".form-step");
const progress = document.getElementById("progress");
const progressSteps = document.querySelectorAll(".progress-step");
let currentStep = 0;

function updateProgressbar() {
  progressSteps.forEach((step, idx) => {
    step.classList.toggle("active", idx <= currentStep);
  });
  const actives = document.querySelectorAll(".progress-step.active");
  progress.style.width = ((actives.length - 1) / (progressSteps.length - 1)) * 100 + "%";
}

document.querySelectorAll(".next-btn").forEach(btn => btn.addEventListener("click", () => {
  steps[currentStep].classList.remove("active");
  currentStep++;
  steps[currentStep].classList.add("active");
  updateProgressbar();
}));

document.querySelectorAll(".prev-btn").forEach(btn => btn.addEventListener("click", () => {
  steps[currentStep].classList.remove("active");
  currentStep--;
  steps[currentStep].classList.add("active");
  updateProgressbar();
}));

// Auto hitung total penumpang
function hitungTotal() {
  const dewasa = parseInt(document.getElementById('dewasa').value) || 0;
  const anak = parseInt(document.getElementById('anak').value) || 0;
  const total = dewasa + anak;
  document.getElementById('total_penumpang').value = total;

  // Hitung premi (misal 1 orang = 2000)
  const premi = total * 2000;
  document.getElementById('premi_asuransi').value = premi;
}

document.getElementById('dewasa').addEventListener('input', hitungTotal);
document.getElementById('anak').addEventListener('input', hitungTotal);

// Signature pad
 function setupSignature(canvasId, inputId){
    const canvas = document.getElementById(canvasId);
    const hidden = document.getElementById(inputId);
    const ctx = canvas.getContext('2d');

    let drawing = false;

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
      if (e.touches && e.touches[0]){
        return { x: e.touches[0].clientX - rect.left, y: e.touches[0].clientY - rect.top };
      }
      return { x: e.offsetX, y: e.offsetY };
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
  setupSignature("ttd_petugas", "ttd_petugas_data");

initSignaturePad("ttd_petugas", "ttd_petugas_data");

updateProgressbar();
</script>

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

@endsection
