@extends('layouts.app')

@section('title', 'Form Manifest Real Time')

@section('content')
<a href="{{ url('/') }}">
    <button type="button" class="back-btn">←</button>
</a>

<div class="form-wrapper">
  <div class="form-card">
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
          <canvas id="ttd_petugas" width="500" height="200"
            style="border:1px solid #ccc; border-radius:8px; cursor: crosshair;"></canvas>
          <div>
            <button type="button" onclick="clearSignature('ttd_petugas')">Hapus</button>
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
function initSignaturePad(canvasId, inputId) {
  const canvas = document.getElementById(canvasId);
  const ctx = canvas.getContext("2d");
  let drawing = false;
  ctx.lineWidth = 2;
  ctx.lineCap = "round";
  ctx.strokeStyle = "black";

  function startDraw(e) { drawing = true; ctx.beginPath(); ctx.moveTo(getX(e), getY(e)); e.preventDefault(); }
  function draw(e) { if (!drawing) return; ctx.lineTo(getX(e), getY(e)); ctx.stroke(); e.preventDefault(); }
  function stopDraw() { if (!drawing) return; drawing = false; document.getElementById(inputId).value = canvas.toDataURL(); }

  function getX(e) { return e.touches ? e.touches[0].clientX - canvas.getBoundingClientRect().left : e.offsetX; }
  function getY(e) { return e.touches ? e.touches[0].clientY - canvas.getBoundingClientRect().top : e.offsetY; }

  canvas.addEventListener("mousedown", startDraw);
  canvas.addEventListener("mousemove", draw);
  canvas.addEventListener("mouseup", stopDraw);
  canvas.addEventListener("mouseout", stopDraw);
  canvas.addEventListener("touchstart", startDraw);
  canvas.addEventListener("touchmove", draw);
  canvas.addEventListener("touchend", stopDraw);
}

function clearSignature(canvasId) {
  const canvas = document.getElementById(canvasId);
  canvas.getContext("2d").clearRect(0, 0, canvas.width, canvas.height);
}

initSignaturePad("ttd_petugas", "ttd_petugas_data");

updateProgressbar();
</script>

<style>
/* General wrapper */
.form-wrapper {
  display: flex;
  justify-content: center;
  margin: 40px 20px;
  font-family: 'Poppins', sans-serif;
}
.form-card {
  background: #f9faff;
  padding: 40px 30px;
  border-radius: 16px;
  box-shadow: 0 10px 30px rgba(0,0,0,0.1);
  width: 100%;
  max-width: 650px;
  transition: all 0.3s ease;
}

/* Back button */
.back-btn {
  background: none;
  border: none;
  font-size: 1.3rem;
  cursor: pointer;
  margin-bottom: 20px;
  color: #555;
  transition: 0.3s;
}
.back-btn:hover {
  color: #007bff;
  transform: translateX(-2px);
}

/* Progress Bar modern */
.progressbar {
  display: flex;
  justify-content: space-between;
  position: relative;
  margin-bottom: 35px;
}
.progress {
  position: absolute;
  top: 50%;
  left: 0;
  height: 5px;
  background: linear-gradient(90deg, #007bff, #00c6ff);
  transform: translateY(-50%);
  border-radius: 5px;
  transition: width 0.4s ease;
}
.progress-step {
  width: 24px;
  height: 24px;
  border-radius: 50%;
  background: #e0e0e0;
  display: flex;
  align-items: center;
  justify-content: center;
  z-index: 1;
}
.progress-step.active {
  background: #007bff;
  transform: scale(1.2);
}
.progress-step::after {
  content: attr(data-title);
  position: absolute;
  top: 35px;
  font-size: 0.8rem;
  color: #555;
  white-space: nowrap;
  text-align: center;
  transform: translateX(-50%);
}

/* Form Steps */
.form-step {
  display: none;
  flex-direction: column;
  gap: 20px;
  opacity: 0;
  transform: translateY(20px);
  transition: all 0.4s ease;
}
.form-step.active {
  display: flex;
  opacity: 1;
  transform: translateY(0);
}

/* Titles */
.title {
  font-size: 1.6rem;
  font-weight: 600;
  text-align: center;
  color: #007bff;
  margin-bottom: 25px;
}

/* Form group modern */
.form-group {
  display: flex;
  flex-direction: column;
}
.form-group label {
  margin-bottom: 6px;
  font-weight: 500;
  color: #333;
}
.form-group input,
.form-group select {
  padding: 12px 15px;
  border: 1px solid #ccc;
  border-radius: 10px;
  font-size: 1rem;
  outline: none;
  transition: all 0.3s ease;
}
.form-group input:focus,
.form-group select:focus {
  border-color: #007bff;
  box-shadow: 0 0 0 3px rgba(0,123,255,0.15);
}

/* Grid layout for smaller inputs */
.form-group.double {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 15px;
}

/* Buttons */
.btns-group {
  display: flex;
  justify-content: space-between;
  margin-top: 25px;
  gap: 10px;
}
.btn, .btn-submit {
  padding: 12px 22px;
  border-radius: 12px;
  font-weight: 600;
  cursor: pointer;
  transition: all 0.3s ease;
}
.next-btn {
  background: linear-gradient(90deg, #007bff, #00c6ff);
  color: #fff;
  box-shadow: 0 5px 15px rgba(0,123,255,0.3);
}
.prev-btn {
  background: #6c757d;
  color: #fff;
}
.btn-submit {
  background: linear-gradient(90deg, #28a745, #71e76a);
  color: #fff;
  width: 100%;
  box-shadow: 0 5px 15px rgba(40,167,69,0.3);
}
.btn:hover, .btn-submit:hover {
  opacity: 0.9;
  transform: translateY(-2px);
}

/* Canvas modern */
canvas {
  width: 100%;
  max-width: 100%;
  border: 1px dashed #007bff;
  border-radius: 12px;
  cursor: crosshair;
}

/* Input file */
input[type="file"] {
  padding: 8px;
  border-radius: 8px;
  border: 1px dashed #ccc;
  transition: 0.3s;
}
input[type="file"]:hover {
  border-color: #007bff;
  background: #f0f8ff;
}
</style>

@endsection
