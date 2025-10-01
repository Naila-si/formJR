@extends('admin1.dashboard')

@section('title', 'Tambah Data RK CRM')

@section('content')
<div class="form-wrapper">
    <div class="container mx-auto p-6">
        <h2 class="mb-8 text-3xl font-bold text-gray-800 text-center">Tambah Data RK CRM</h2>

        @if(session('success'))
            <div class="mb-4 p-4 bg-green-50 border border-green-400 text-green-800 rounded shadow-md">
                {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div class="mb-4 p-4 bg-red-50 border border-red-400 text-red-800 rounded shadow-md">
                <ul class="list-disc pl-5">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin1.rkcrm.store') }}" method="POST" class="space-y-8">
            @csrf

            {{-- ===== NAMA PEGAWAI & LOKET SAMSAT ===== --}}
            <div class="p-6 rounded-xl shadow-lg bg-gray-100">
                <h3 class="text-2xl font-semibold mb-6">Informasi Pegawai</h3>
                <div class="grid md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-gray-700 font-medium mb-2">Nama Pegawai</label>
                        <input type="text" name="nama_pegawai" value="{{ old('nama_pegawai') }}" required
                               class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition duration-300 shadow-sm hover:shadow-md">
                    </div>
                    <div>
                        <label class="block text-gray-700 font-medium mb-2">Loket Samsat</label>
                        <select name="loket_samsat" required
                                class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition duration-300 shadow-sm hover:shadow-md">
                            <option value="">-- Pilih Loket --</option>
                            @foreach($lokets_list as $loket)
                                <option value="{{ $loket }}" {{ old('loket_samsat') == $loket ? 'selected' : '' }}>
                                    {{ $loket }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            {{-- ===== CATEGORY FIELDS ===== --}}
            @php
            $categories = [
                'OS' => ['os_awal','os_sampai_11_sept','persen_os'],
                'PO' => ['target_crm','realisasi_po','gap_po','po_sampai_11_sept'],
                'Rupiah' => ['target_rupiah','realisasi_os_bayar','jml_kend_os_bayar','nominal_os_bayar','persen_os_bayar','jml_kend_pemeliharaan','nominal_pemeliharaan'],
            ];

            $categoryColors = [
                'OS'=>'bg-gradient-to-r from-blue-50 to-blue-100',
                'PO'=>'bg-gradient-to-r from-yellow-50 to-yellow-100',
                'Rupiah'=>'bg-gradient-to-r from-green-50 to-green-100',
            ];

            $fields = [
                'os_awal'=>['label'=>'OS Awal','type'=>'number','tooltip'=>'Saldo OS awal bulan','required'=>true],
                'os_sampai_11_sept'=>['label'=>'OS s.d. 11 Sept','type'=>'number','tooltip'=>'Saldo OS sampai 11 Sept','required'=>true],
                'persen_os'=>['label'=>'% OS','type'=>'number','step'=>'0.01','tooltip'=>'Persentase OS','required'=>true],
                'target_crm'=>['label'=>'Target CRM (PO)','type'=>'number','tooltip'=>'Target PO pegawai','required'=>true],
                'realisasi_po'=>['label'=>'Realisasi PO','type'=>'number','tooltip'=>'PO yang direalisasikan','required'=>true],
                'gap_po'=>['label'=>'GAP PO','type'=>'number','tooltip'=>'Selisih target & realisasi','required'=>true],
                'po_sampai_11_sept'=>['label'=>'PO s.d. 11 Sept','type'=>'number','tooltip'=>'Jumlah PO sampai 11 Sept','required'=>false],
                'target_rupiah'=>['label'=>'Target Rupiah','type'=>'number','tooltip'=>'Target minimal rupiah','required'=>true],
                'realisasi_os_bayar'=>['label'=>'Realisasi OS Bayar','type'=>'number','tooltip'=>'Jumlah rupiah OS dibayar','required'=>true],
                'jml_kend_os_bayar'=>['label'=>'Jumlah Kendaraan OS Bayar','type'=>'number','tooltip'=>'Jumlah kendaraan membayar OS','required'=>true],
                'nominal_os_bayar'=>['label'=>'Nominal OS Bayar','type'=>'number','tooltip'=>'Nominal OS bayar','required'=>true],
                'persen_os_bayar'=>['label'=>'% OS Bayar','type'=>'number','step'=>'0.01','tooltip'=>'Persentase OS bayar','required'=>true],
                'jml_kend_pemeliharaan'=>['label'=>'Jumlah Kendaraan Pemeliharaan','type'=>'number','tooltip'=>'Jumlah kendaraan pemeliharaan','required'=>true],
                'nominal_pemeliharaan'=>['label'=>'Nominal Pemeliharaan','type'=>'number','tooltip'=>'Nominal pemeliharaan','required'=>true],
            ];
            @endphp

            @foreach($categories as $categoryName => $categoryFields)
            <div class="p-6 rounded-xl shadow-lg {{ $categoryColors[$categoryName] }}">
                <h3 class="text-2xl font-semibold mb-6">{{ $categoryName }}</h3>
                <div class="grid md:grid-cols-2 gap-6">
                    @foreach($categoryFields as $fieldKey)
                    <div>
                        <label class="block text-gray-700 font-medium mb-2 flex items-center justify-between">
                            {{ $fields[$fieldKey]['label'] }}
                            <span class="tooltip text-gray-400 cursor-pointer" title="{{ $fields[$fieldKey]['tooltip'] }}">&#9432;</span>
                        </label>
                        <input
                            type="{{ $fields[$fieldKey]['type'] }}"
                            name="{{ $fieldKey }}"
                            @if(isset($fields[$fieldKey]['step'])) step="{{ $fields[$fieldKey]['step'] }}" @endif
                            value="{{ old($fieldKey) }}"
                            @if($fields[$fieldKey]['required']) required @endif
                            class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition duration-300 shadow-sm hover:shadow-md"
                        >
                    </div>
                    @endforeach
                </div>
            </div>
            @endforeach

            <div class="flex gap-4 justify-center mt-8">
                <button type="submit" class="px-8 py-3 bg-gradient-to-r from-indigo-600 to-indigo-700 text-white rounded-xl hover:from-indigo-700 hover:to-indigo-800 shadow-lg transition duration-300 transform hover:-translate-y-1">Simpan</button>
                <a href="{{ route('admin1.rkcrm.index') }}" class="px-8 py-3 bg-gray-400 text-white rounded-xl hover:bg-gray-500 shadow-lg transition duration-300 transform hover:-translate-y-1">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection

@push('styles')
<style>
/* ===== CONTAINER ===== */
.form-wrapper .container {
    background: #ffffff; /* putih bersih */
    border-radius: 1rem;
    padding: 3rem 2rem;
    max-width: 900px;
    box-shadow: 0 6px 20px rgba(0,0,0,0.05);
}

/* ===== TITLES ===== */
.form-wrapper h2 {
    color: #1e3a8a;
    font-weight: 700;
    text-align: center;
    margin-bottom: 2.5rem;
    font-size: 2.5rem;
}

.form-wrapper h3 {
    font-weight: 600;
    font-size: 1.5rem;
    margin-bottom: 1.5rem;
    color: #1e3a8a;
}

/* ===== INPUTS ===== */

.form-wrapper input,
.form-wrapper select,
.form-wrapper textarea {
    border-radius: 0.5rem;
    border: 1px solid #cbd5e1;
    padding: 0.75rem 1rem;
    width: 100%;
    transition: all 0.2s ease;
    background: #ffffff;
    margin-top: 0.3rem;
}

.form-wrapper input:focus,
.form-wrapper select:focus,
.form-wrapper textarea:focus {
    outline: none;
    border-color: #1e40af;
    box-shadow: 0 0 6px rgba(30,64,175,0.2);
}

/* ===== CARD (CATEGORY) ===== */
.form-wrapper .p-6.rounded-xl {
    background: #f0f5ff; /* biru lembut */
    padding: 2rem;
    margin-bottom: 2rem;
    border-radius: 0.75rem;
    box-shadow: 0 4px 15px rgba(0,0,0,0.05);
    transition: transform 0.2s ease, box-shadow 0.2s ease;
}

.form-wrapper .p-6.rounded-xl:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(0,0,0,0.08);
}

/* ===== GRID FIELDS ===== */
div.grid {
    gap: 1.5rem;
}
div.grid > div {
    display: flex;
    flex-direction: column;
}

/* ===== LABEL ===== */
.form-wrapper label {
    font-weight: 500;
    margin-bottom: 0.3rem;
    color: #1e293b;
}

/* ===== TOOLTIP ===== */
.form-wrapper .tooltip {
    position: relative;
    cursor: help;
    margin-left: 0.3rem;
    color: #6b7280;
    font-size: 0.9rem;
}

.form-wrapper .tooltip:hover::after {
    content: attr(title);
    position: absolute;
    background: rgba(55,65,81,0.9);
    color: white;
    padding: 0.4rem 0.6rem;
    border-radius: 0.3rem;
    font-size: 0.8rem;
    white-space: nowrap;
    top: 120%;
    left: 50%;
    transform: translateX(-50%);
    opacity: 0;
    transition: opacity 0.2s ease;
    pointer-events: none;
}
.form-wrapper .tooltip:hover::after {
    opacity: 1;
}

/* ===== BUTTONS ===== */
.form-wrapper button {
    background-color: #1e40af;
    color: #ffffff;
    font-weight: 600;
    border-radius: 0.5rem;
    padding: 0.75rem 1.5rem;
    transition: all 0.2s ease;
}
.form-wrapper button:hover {
    background-color: #1e3a8a;
    transform: translateY(-1px);
    box-shadow: 0 6px 15px rgba(0,0,0,0.1);
}

.form-wrapper a {
    background-color: #6b7280;
    color: #ffffff;
    text-align: center;
    border-radius: 0.5rem;
    padding: 0.75rem 1.5rem;
    transition: all 0.2s ease;
}
.form-wrapper a:hover {
    background-color: #4b5563;
    transform: translateY(-1px);
    box-shadow: 0 6px 15px rgba(0,0,0,0.1);
}

.form-wrapper div.grid {
    gap: 1.5rem;
}

.form-wrapper div.grid > div {
    display: flex;
    flex-direction: column;
}

/* ===== RESPONSIVE ===== */
@media (max-width: 768px) {
    .form-wrapper div.grid {
        grid-template-columns: 1fr;
    }
}

</style>
@endpush
