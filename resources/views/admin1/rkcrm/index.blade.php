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
        {{-- <button type="button" id="btnImportRKCRM" class="btn btn-secondary">Import Data</button> --}}
        <a href="{{ route('admin1.rkcrm.export.excel') }}" class="btn btn-success">Export Excel</a>
        <a href="{{ route('admin1.rkcrm.export.pdf') }}" class="btn btn-danger">Export PDF</a>
        <a href="{{ route('admin1.rkcrm.create') }}" class="btn btn-primary">Tambah Data</a>
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
                    <th>Rp OS Awal</th>
                    <th>Rp OS s.d. 11 Sept 25</th>
                    <th>%OS</th>

                    <th>Target CRM (PO)</th>
                    <th>Realisasi</th>
                    <th>GAP</th>
                    <th>s.d. 11 Sept 25</th>

                    <th>Target Rupiah (Minimal)</th>
                    <th>Realisasi OS Bayar s.d. 11 Sept 25</th>
                    <th>Jml Kend</th>
                    <th>Nominal (Rp)</th>

                    <th>Jml Kend</th>
                    <th>Nominal (Rp)</th>
                </tr>
            </thead>
            <tbody>
                @foreach($kantor_wilayah as $wilayah => $loketList)
                    @foreach($loketList as $loket)
                        @foreach($lokets[$loket] ?? [] as $index => $data)
                            <tr>
                                <td>{{ $loop->parent->index + $index + 1 }}</td>
                                <td>{{ $data->nama_pegawai }}</td>
                                <td>{{ $data->loket_samsat }}</td>
                                <td>{{ number_format($data->os_awal ?? 0, 0, ',', '.') }}</td>
                                <td>{{ number_format($data->os_sampai_11_sept ?? 0, 0, ',', '.') }}</td>
                                <td>
                                    <span class="{{ ($data->persen_os ?? 0) >= 80 ? 'text-green-600' : 'text-red-600' }}">
                                        {{ $data->persen_os ?? 0 }}%
                                    </span>
                                </td>
                                <td>{{ $data->target_crm ?? '-' }}</td>
                                <td>{{ $data->realisasi_po ?? '-' }}</td>
                                <td>{{ $data->gap_po ?? '-' }}</td>
                                <td>{{ $data->po_sampai_11_sept ?? '-' }}</td>
                                <td>{{ number_format($data->target_rupiah ?? 0, 0, ',', '.') }}</td>
                                <td>{{ number_format($data->realisasi_os_bayar ?? 0, 0, ',', '.') }}</td>
                                <td>{{ $data->jml_kend_os_bayar ?? 0 }}</td>
                                <td>{{ number_format($data->nominal_os_bayar ?? 0, 0, ',', '.') }}</td>
                                <td>
                                    <span class="{{ ($data->persen_os_bayar ?? 0) >= 80 ? 'text-green-600' : 'text-red-600' }}">
                                        {{ $data->persen_os_bayar ?? 0 }}%
                                    </span>
                                </td>
                                <td>{{ $data->jml_kend_pemeliharaan ?? 0 }}</td>
                                <td>{{ number_format($data->nominal_pemeliharaan ?? 0, 0, ',', '.') }}</td>
                                <td>
                                    <a href="{{ route('admin1.rkcrm.edit', $data->id) }}" class="btn btn-sm btn-warning">Edit</a>
                                </td>
                            </tr>
                        @endforeach

                        {{-- Subtotal per loket --}}
                        @if(isset($subtotals[$loket]))
                        <tr class="subtotal-row">
                            <td colspan="3">Subtotal {{ $loket }}</td>
                            <td>{{ number_format($subtotals[$loket]['os_awal'], 0, ',', '.') }}</td>
                            <td>{{ number_format($subtotals[$loket]['os_sampai'], 0, ',', '.') }}</td>
                            <td>{{ $subtotals[$loket]['persen_os'] ?? 0 }}%</td>
                            <td>{{ $subtotals[$loket]['target_crm'] }}</td>
                            <td>{{ $subtotals[$loket]['realisasi_po'] }}</td>
                            <td>{{ $subtotals[$loket]['gap_po'] }}</td>
                            <td>{{ $subtotals[$loket]['po_sampai_11_sept'] }}</td>
                            <td>{{ number_format($subtotals[$loket]['target_rupiah'], 0, ',', '.') }}</td>
                            <td>{{ number_format($subtotals[$loket]['realisasi_os_bayar'], 0, ',', '.') }}</td>
                            <td>{{ $subtotals[$loket]['jml_kend_os_bayar'] }}</td>
                            <td>{{ number_format($subtotals[$loket]['nominal_os_bayar'], 0, ',', '.') }}</td>
                            <td>{{ $subtotals[$loket]['persen_os_bayar'] ?? 0 }}%</td>
                            <td>{{ $subtotals[$loket]['jml_kend_pemeliharaan'] }}</td>
                            <td>{{ number_format($subtotals[$loket]['nominal_pemeliharaan'], 0, ',', '.') }}</td>
                            <td></td>
                        </tr>
                        @endif
                    @endforeach

                    {{-- Subtotal per kantor wilayah --}}
                    <tr class="subtotal-wilayah">
                        <td colspan="3">Subtotal {{ $wilayah }}</td>
                        <td>{{ number_format($subtotalsWilayah[$wilayah]['os_awal'] ?? 0, 0, ',', '.') }}</td>
                        <td>{{ number_format($subtotalsWilayah[$wilayah]['os_sampai'] ?? 0, 0, ',', '.') }}</td>
                        <td>{{ $subtotalsWilayah[$wilayah]['persen_os'] ?? 0 }}%</td>
                        <td>{{ $subtotalsWilayah[$wilayah]['target_crm'] ?? 0 }}</td>
                        <td>{{ $subtotalsWilayah[$wilayah]['realisasi_po'] ?? 0 }}</td>
                        <td>{{ $subtotalsWilayah[$wilayah]['gap_po'] ?? 0 }}</td>
                        <td>{{ $subtotalsWilayah[$wilayah]['po_sampai_11_sept'] ?? 0 }}</td>
                        <td>{{ number_format($subtotalsWilayah[$wilayah]['target_rupiah'] ?? 0, 0, ',', '.') }}</td>
                        <td>{{ number_format($subtotalsWilayah[$wilayah]['realisasi_os_bayar'] ?? 0, 0, ',', '.') }}</td>
                        <td>{{ $subtotalsWilayah[$wilayah]['jml_kend_os_bayar'] ?? 0 }}</td>
                        <td>{{ number_format($subtotalsWilayah[$wilayah]['nominal_os_bayar'] ?? 0, 0, ',', '.') }}</td>
                        <td>{{ $subtotalsWilayah[$wilayah]['persen_os_bayar'] ?? 0 }}%</td>
                        <td>{{ $subtotalsWilayah[$wilayah]['jml_kend_pemeliharaan'] ?? 0 }}</td>
                        <td>{{ number_format($subtotalsWilayah[$wilayah]['nominal_pemeliharaan'] ?? 0, 0, ',', '.') }}</td>
                        <td></td>
                    </tr>
                @endforeach

                {{-- Total akhir --}}
                <tr class="total-row">
                    <td colspan="3">Total</td>
                    <td>{{ number_format($total['os_awal'] ?? 0, 0, ',', '.') }}</td>
                    <td>{{ number_format($total['os_sampai'] ?? 0, 0, ',', '.') }}</td>
                    <td>{{ $total['persen_os'] ?? 0 }}%</td>
                    <td>{{ $total['target_crm'] ?? 0 }}</td>
                    <td>{{ $total['realisasi_po'] ?? 0 }}</td>
                    <td>{{ $total['gap_po'] ?? 0 }}</td>
                    <td>{{ $total['po_sampai_11_sept'] ?? 0 }}</td>
                    <td>{{ number_format($total['target_rupiah'] ?? 0, 0, ',', '.') }}</td>
                    <td>{{ number_format($total['realisasi_os_bayar'] ?? 0, 0, ',', '.') }}</td>
                    <td>{{ $total['jml_kend_os_bayar'] ?? 0 }}</td>
                    <td>{{ number_format($total['nominal_os_bayar'] ?? 0, 0, ',', '.') }}</td>
                    <td>{{ $total['persen_os_bayar'] ?? 0 }}%</td>
                    <td>{{ $total['jml_kend_pemeliharaan'] ?? 0 }}</td>
                    <td>{{ number_format($total['nominal_pemeliharaan'] ?? 0, 0, ',', '.') }}</td>
                    <td></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
@endsection

@push('styles')
<link rel="stylesheet" href="{{ asset('css/admin1/rkcrm.css') }}">
<style>
    .rkcrm-table th { background-color: #1f2937; color: #fff; position: sticky; top: 0; }
    .rkcrm-table tbody tr:nth-child(even) { background-color: #f3f4f6; }
    .subtotal-row { background-color: #e5e7eb; font-weight: 600; }
    .total-row { background-color: #d1d5db; font-weight: 700; font-size: 1rem; }
    .text-green-600 { color: #16a34a; }
    .text-red-600 { color: #dc2626; }
    .subtotal-loket {
        background-color: #e5e7eb; /* abu-abu muda, sudah ada */
        font-weight: 600;
    }

    .subtotal-wilayah {
        background-color: #c7d2fe; /* biru lembut */
        font-weight: 700;
    }
</style>
@endpush
@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const btnImport = document.getElementById('btnImportRKCRM');
    const fileInput = document.getElementById('fileInputRKCRM');

    // Klik tombol akan membuka file picker
    btnImport.addEventListener('click', () => {
        fileInput.click();
    });

    // Preview & otomatis submit
    fileInput.addEventListener('change', (event) => {
        const file = event.target.files[0];
        if (!file) return;

        // Tampilkan nama file menggunakan SweetAlert
        Swal.fire({
            title: 'Import Data RK CRM',
            html: `<p>File yang dipilih: <strong>${file.name}</strong></p>`,
            icon: 'info',
            showCancelButton: true,
            confirmButtonText: 'Import',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                // Submit form
                fileInput.closest('form').submit();
            } else {
                // Reset input jika batal
                fileInput.value = '';
            }
        });
    });
});
</script>
@endpush

