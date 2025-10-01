@extends('admin1.dashboard')

@section('title', 'Data IWKBU')

@section('content')
<div class="container mt-5">
    <h2 class="mb-4 text-xl font-bold">Data IWKBU</h2>
    <!-- Tombol Import & Export -->
    <div class="mb-3 flex gap-2">
        <form action="{{ route('admin1.iwkbu.import') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="file" name="file" id="fileInput" hidden>
        </form>
        <button type="button" id="btnImport" class="btn btn-secondary">Import Data</button>
        <a href="{{ route('admin1.iwkbu.export.excel') }}" class="btn btn-success">Export Excel</a>
        <a href="{{ route('admin1.iwkbu.export.pdf') }}" class="btn btn-danger">Export PDF</a>
    </div>

    <!-- Tabel Data dengan scroll horizontal -->
    <div class="table-responsive">
        <table class="table table-bordered" id="iwkbuTable">
            <thead class="table-dark">
                <tr>
                    <th>Aksi</th>
                    <th>No</th>
                    <th>Wilayah
                        <select id="filter-wilayah" class="form-select form-select-sm">
                            <option value="">All</option>
                            @foreach(\App\Models\Admin1\Iwkbu::$options['wilayah'] as $wilayah)
                            <option value="{{ $wilayah }}">{{ $wilayah }}</option>
                            @endforeach
                        </select>
                    </th>
                    <th>No Polisi</th>
                    <th>Tarif</th>
                    <th>Golongan
                        <select id="filter-golongan" class="form-select form-select-sm">
                            <option value="">All</option>
                            @foreach(\App\Models\Admin1\Iwkbu::$options['undefined'] as $gol)
                            <option value="{{ $gol }}">{{ $gol }}</option>
                            @endforeach
                        </select>
                    </th>
                    <th>Nominal IWKBU</th>
                    <th>Trayek</th>
                    <th>Jenis</th>
                    <th>Tahun Pembuatan</th>
                    <th>PIC
                        <input type="text" id="filter-pic" class="form-control form-control-sm" placeholder="Cari PIC">
                    </th>
                    <th>Badan Hukum / Perorangan</th>
                    <th>Nama Perusahaan
                        <input type="text" id="filter-perusahaan" class="form-control form-control-sm" placeholder="Cari Perusahaan">
                    </th>
                    <th>Alamat Lengkap</th>
                    <th>Kel</th>
                    <th>Kec</th>
                    <th>Kota/Kab</th>
                    <th>Tanggal Transaksi
                        <input type="date" id="filter-tanggal" class="form-control form-control-sm">
                    </th>
                    <th>Loket Pembayaran
                        <input type="text" id="filter-loket" class="form-control form-control-sm" placeholder="Cari Loket">
                    </th>
                    <th>Masa Berlaku IWKBU
                        <input type="text" id="filter-masa" class="form-control form-control-sm" placeholder="Cari Masa">
                    </th>
                    <th>Masa Laku SWDKLLJ Terakhir
                        <input type="text" id="filter-swdkllj" class="form-control form-control-sm" placeholder="Cari SWDKLLJ">
                    </th>
                    <th>Status Pembayaran IWKBU
                        <select id="filter-status-pembayaran" class="form-select form-select-sm">
                            <option value="">All</option>
                            @foreach(\App\Models\Admin1\Iwkbu::$options['status_pembayaran'] as $status)
                            <option value="{{ $status }}">{{ $status }}</option>
                            @endforeach
                        </select>
                    </th>
                    <th>Status Kendaraan
                        <select id="filter-status-kendaraan" class="form-select form-select-sm">
                            <option value="">All</option>
                            @foreach(\App\Models\Admin1\Iwkbu::$options['status_kendaraan'] as $status)
                            <option value="{{ $status }}">{{ $status }}</option>
                            @endforeach
                        </select>
                    </th>
                    <th>Nilai Outstanding IWKBU (Rp)
                        <input type="number" id="filter-nilai" class="form-control form-control-sm" placeholder="Min. Nilai">
                    </th>
                    <th>Hasil Konfirmasi</th>
                    <th>No HP</th>
                    <th>Nama Pemilik/Pengelola</th>
                    <th>NIK / No Identitas</th>
                    <th>Dok Perizinan</th>
                    <th>Tgl Bayar OS IWKBU</th>
                    <th>Nilai Bayar OS IWKBU</th>
                    <th>Tgl Pemeliharaan</th>
                    <th>Nilai Pemeliharaan OS IWKBU</th>
                    <th>Keterangan</th>
                </tr>
            </thead>
            <tbody>
                @forelse($iwkbus as $index => $data)
                <tr>
                    <td>
                        <a href="{{ route('admin1.iwkbu.edit', $data->id) }}" class="btn btn-sm btn-warning">Edit</a>
                    </td>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $data->wilayah }}</td>
                    <td>
                        <a href="{{ route('admin1.iwkbu.show', $data->id) }}">
                            {{ $data->no_polisi }}
                        </a>
                    </td>
                    <td>{{ $data->tarif }}</td>
                    <td>{{ $data->undefined }}</td>
                    <td>{{ $data->nominal_iwkbu }}</td>
                    <td>{{ $data->trayek }}</td>
                    <td>{{ $data->jenis }}</td>
                    <td>{{ $data->tahun_pembuatan }}</td>
                    <td>{{ $data->pic }}</td>
                    <td>{{ $data->badan_hukum }}</td>
                    <td>{{ $data->nama_perusahaan }}</td>
                    <td>{{ $data->alamat_lengkap }}</td>
                    <td>{{ $data->kel }}</td>
                    <td>{{ $data->kec }}</td>
                    <td>{{ $data->kota_kab }}</td>
                    <td>{{ $data->tanggal_transaksi }}</td>
                    <td>{{ $data->loket_pembayaran }}</td>
                    <td>{{ $data->masa_berlaku_iwkbu }}</td>
                    <td>{{ $data->masa_laku_swdkllj }}</td>
                    <td>{{ $data->status_pembayaran }}</td>
                    <td>{{ $data->status_kendaraan }}</td>
                    <td>{{ $data->nilai_outstanding }}</td>
                    <td>{{ $data->hasil_konfirmasi }}</td>
                    <td>{{ $data->no_hp }}</td>
                    <td>{{ $data->nama_pemilik }}</td>
                    <td>{{ $data->nik }}</td>
                    <td>{{ $data->dok_perizinan }}</td>
                    <td>{{ $data->tgl_bayar_os_iwkbu }}</td>
                    <td>{{ $data->nilai_bayar_os_iwkbu }}</td>
                    <td>{{ $data->tgl_pemeliharaan }}</td>
                    <td>{{ $data->nilai_pemeliharaan_os_iwkbu }}</td>
                    <td>{{ $data->keterangan }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="35" class="text-center">Belum ada data</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection

@push('styles')
<link rel="stylesheet" href="{{ asset('css/admin1/iwkbu.css') }}">
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/fixedheader/3.4.0/css/fixedHeader.dataTables.min.css">
@endpush

@push('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/fixedheader/3.4.0/js/dataTables.fixedHeader.min.js"></script>
<script src="{{ asset('js/admin1/iwkbu.js') }}"></script>

<script>
$(document).ready(function() {
    var table = $('#iwkbuTable').DataTable({
        pageLength: 50,
        lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "Semua"]],
        scrollX: true,
        scrollY: "500px",
        scrollCollapse: true,
        fixedHeader: true,
        dom: '<"top"l>rt<"bottom"ip><"clear">' 
    });

    // Wilayah
    $('#filter-wilayah').on('change', function() {
        table.column(2).search(this.value).draw();
    });
    // Golongan
    $('#filter-golongan').on('change', function() {
        table.column(5).search(this.value).draw();
    });
    // PIC
    $('#filter-pic').on('keyup change', function() {
        table.column(10).search(this.value).draw();
    });
    // Perusahaan
    $('#filter-perusahaan').on('keyup change', function() {
        table.column(12).search(this.value).draw();
    });
    // Tanggal transaksi (harus sama formatnya, misal "2025-09-18")
    $('#filter-tanggal').on('change', function() {
        table.column(17).search(this.value).draw();
    });
    // Loket
    $('#filter-loket').on('keyup change', function() {
        table.column(18).search(this.value).draw();
    });
    // Masa berlaku IWKBU
    $('#filter-masa').on('keyup change', function() {
        table.column(19).search(this.value).draw();
    });
    // Masa laku SWDKLLJ
    $('#filter-swdkllj').on('keyup change', function() {
        table.column(20).search(this.value).draw();
    });
    // Status pembayaran
    $('#filter-status-pembayaran').on('change', function() {
        table.column(21).search(this.value).draw();
    });
    // Status kendaraan
    $('#filter-status-kendaraan').on('change', function() {
        table.column(22).search(this.value).draw();
    });
    // Nilai Outstanding (cari angka persis)
    $('#filter-nilai').on('keyup change', function() {
        table.column(23).search(this.value).draw();
    });
});

</script>
@endpush
