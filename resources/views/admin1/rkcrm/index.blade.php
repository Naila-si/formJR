@extends('admin1.dashboard')

@section('title', 'Data RK CRM')

@section('content')
<div class="container mt-5">
    <h2 class="mb-4 text-xl font-bold">Data RK CRM</h2>

    <!-- Tombol Import & Export -->
    <div class="mb-3 flex gap-2">
        <form action="{{ route('admin1.rkcrm.import') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="file" name="file" id="fileInputRKCRM" hidden>
        </form>
        <button type="button" id="btnImportRKCRM" class="btn btn-secondary">Import Data</button>
        <a href="{{ route('admin1.rkcrm.export.excel') }}" class="btn btn-success">Export Excel</a>
        <a href="{{ route('admin1.rkcrm.export.pdf') }}" class="btn btn-danger">Export PDF</a>
    </div>

    <!-- Tabel Data dengan scroll horizontal -->
    <div class="table-responsive">
        <table class="table table-bordered" id="rkcrmTable">
            <thead class="table-dark">
                <tr>
                    <th rowspan="2">No</th>
                    <th rowspan="2">Nama Pegawai</th>
                    <th rowspan="2">Loket Samsat</th>
                    <th colspan="3">OS September 2025</th>
                    <th colspan="4">Jumlah PO</th>
                    <th colspan="4">Hasil Rupiah</th>
                    <th rowspan="2">%OS Bayar</th>
                    <th colspan="2">Pemeliharaan OS s.d. 11 Sept 25</th>
                    <th rowspan="2">Aksi</th>
                </tr>
                <tr>
                    <!-- OS September -->
                    <th>Rp OS Awal</th>
                    <th>Rp OS s.d. 11 Sept 25</th>
                    <th>%OS</th>

                    <!-- Jumlah PO -->
                    <th>Target CRM (PO)</th>
                    <th>Realisasi</th>
                    <th>GAP</th>
                    <th>s.d. 11 Sept 25</th>

                    <!-- Hasil Rupiah -->
                    <th>Target Rupiah (Minimal)</th>
                    <th>Realisasi OS Bayar s.d. 11 Sept 25</th>
                    <th>Jml Kend</th>
                    <th>Nominal (Rp)</th>

                    <!-- Pemeliharaan OS -->
                    <th>Jml Kend</th>
                    <th>Nominal (Rp)</th>
                </tr>
            </thead>
            <tbody>
                @forelse($rkcrms as $index => $data)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $data->nama_pegawai }}</td>
                    <td>{{ $data->loket_samsat }}</td>
                    <td>{{ $data->os_awal }}</td>
                    <td>{{ $data->os_sampai_11_sept }}</td>
                    <td>{{ $data->persen_os }}</td>
                    <td>{{ $data->target_crm }}</td>
                    <td>{{ $data->realisasi_po }}</td>
                    <td>{{ $data->gap_po }}</td>
                    <td>{{ $data->po_sampai_11_sept }}</td>
                    <td>{{ $data->target_rupiah }}</td>
                    <td>{{ $data->realisasi_os_bayar }}</td>
                    <td>{{ $data->jml_kend_os_bayar }}</td>
                    <td>{{ $data->nominal_os_bayar }}</td>
                    <td>{{ $data->persen_os_bayar }}</td>
                    <td>{{ $data->jml_kend_pemeliharaan }}</td>
                    <td>{{ $data->nominal_pemeliharaan }}</td>
                    <td>
                        <a href="{{ route('admin1.rkcrm.edit', $data->id) }}" class="btn btn-sm btn-warning">Edit</a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="18" class="text-center">Belum ada data</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection

@push('styles')
<link rel="stylesheet" href="{{ asset('css/admin1/rkcrm.css') }}">
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="{{ asset('js/admin1/rkcrm.js') }}"></script>
@endpush
