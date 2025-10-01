@extends('admin1.dashboard')

@section('title', 'Data Formulir CRM')

@section('content')
<div class="container mt-5">
    <h2 class="mb-4 text-xl font-bold">Data Formulir CRM</h2>

    <!-- Filter Status dengan tombol -->
    <div class="filter-buttons">
        <a href="{{ route('admin1.formulir.index') }}"
        class="all {{ request('status') == null ? 'active' : '' }}">Semua</a>

        <a href="{{ route('admin1.formulir.index', ['status' => 'pending']) }}"
        class="pending {{ request('status') == 'pending' ? 'active' : '' }}">Pending</a>

        <a href="{{ route('admin1.formulir.index', ['status' => 'approved']) }}"
        class="approved {{ request('status') == 'approved' ? 'active' : '' }}">Approved</a>

        <a href="{{ route('admin1.formulir.index', ['status' => 'rejected']) }}"
        class="rejected {{ request('status') == 'rejected' ? 'active' : '' }}">Rejected</a>
    </div>

    <div class="table-responsive">
        <table id="formulirTable" class="table table-bordered">
            <thead class="table-dark">
                <tr>
                    <th>No</th>
                    <th>Aksi</th>
                    <th>Tanggal & Waktu</th>
                    <th>Nama Petugas</th>
                    <th>Loket</th>
                    <th>Hasil Kunjungan ke Operator PT/CV</th>
                    <th>Jenis Angkutan</th>
                    <th>Nama Pemilik/Pengelola</th>
                    <th>Alamat</th>
                    <th>Telepon</th>
                    <th>Konfirmasi Kendaraan</th>
                    <th>Hasil Kunjungan</th>
                    <th>Janji Bayar</th>
                    <th>Respon Pemilik</th>
                    <th>Keramaian Penumpang</th>
                    <th>Ketaatan Izin</th>
                    <th>Foto Kunjungan</th>
                    <th>Evidence</th>
                </tr>
            </thead>
            <tbody>
                @forelse($formulirs as $index => $data)
                <tr class="
                    @if($data->verification_status === 'pending') bg-yellow-50
                    @elseif($data->verification_status === 'approved') bg-green-50
                    @elseif($data->verification_status === 'rejected') bg-red-50
                    @endif
                ">
                    <td>{{ $index + 1 }}</td>
                    <td>
                        <!-- Tombol lihat laporan -->
                        <a href="{{ route('admin1.formulir.show', $data->id) }}" class="btn btn-info btn-sm">Lihat Laporan</a>

                        <!-- Tombol hapus -->
                        <button type="button" class="btn btn-danger btn-sm btn-delete" data-id="{{ $data->id }}">
                            Hapus
                        </button>

                         <!-- Form hapus (hidden) -->
                        <form id="delete-form-{{ $data->id }}" action="{{ route('admin1.formulir.destroy', $data->id) }}" method="POST" style="display: none;">
                            @csrf
                            @method('DELETE')
                        </form>
                    </td>
                    <td>{{ $data->tanggal_waktu }}</td>
                    <td>{{ $data->nama_depan }} {{ $data->nama_belakang }}</td>
                    <td>{{ $data->loket }}</td>
                    <td>
                        {{ $data->nama_pt }}
                        @if($data->verification_status === 'pending')
                            <span class="badge badge-pending">Pending</span>
                        @elseif($data->verification_status === 'approved')
                            <span class="badge badge-approved">Approved</span>
                        @elseif($data->verification_status === 'rejected')
                            <span class="badge badge-rejected">Rejected</span>
                        @endif
                    </td>
                    <td>{{ $data->jenis_angkutan }}</td>
                    <td>{{ $data->nama_pengelola }}</td>
                    <td>{{ $data->alamat }}</td>
                    <td>{{ $data->telepon }}</td>

                    <td>
                        @if(!empty($data->kendaraan))
                            <table class="table table-sm table-bordered mb-0">
                                <thead>
                                    <tr>
                                        <th>Nopol</th>
                                        <th>Status</th>
                                        <th>Jumlah Bayar</th>
                                        <th>File</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($data->kendaraan as $kendaraan)
                                        <tr>
                                            <td>{{ $kendaraan['nopol'] ?? '-' }}</td>
                                            <td>{{ $kendaraan['status'] ?? '-' }}</td>
                                            <td>
                                                @if(($kendaraan['status'] ?? '') === 'beroperasi_bayar')
                                                    {{ $kendaraan['jumlah_bayar'] ?? '-' }}
                                                @else
                                                    -
                                                @endif
                                            </td>
                                            <td>
                                                @if(!empty($kendaraan['file']))
                                                    @foreach($kendaraan['file'] as $file)
                                                        <a href="{{ asset('storage/'.$file) }}" target="_blank">Lihat</a>@if(!$loop->last), @endif
                                                    @endforeach
                                                @else
                                                    -
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @else
                            <em>Tidak ada kendaraan</em>
                        @endif
                    </td>

                    <td>{{ $data->hasil_kunjungan }}</td>
                    <td>{{ $data->janji_bayar }}</td>
                    <td>{{ $data->profiling['respon'] ?? '' }}</td>
                    <td>{{ $data->profiling['penumpang'] ?? '' }}</td>
                    <td>{{ $data->profiling['izin'] ?? '' }}</td>
                     <!-- 🔹 Foto Kunjungan -->
                    <td>
                        @if(!empty($data->foto_kunjungan))
                            @foreach($data->foto_kunjungan as $foto)
                                <a href="{{ asset('storage/'.$foto) }}" target="_blank">Lihat</a>
                                @if(!$loop->last), @endif
                            @endforeach
                        @else
                            -
                        @endif
                    </td>

                    <!-- 🔹 Evidence -->
                    <td>
                        @if(!empty($data->evidence))
                            @foreach($data->evidence as $file)
                                <a href="{{ asset('storage/'.$file) }}" target="_blank">Lihat</a>
                                @if(!$loop->last), @endif
                            @endforeach
                        @else
                            -
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="20" class="text-center">Belum ada data</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection

@push('styles')
<!-- DataTables default -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css"/>
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.dataTables.min.css"/>

<style>
/* ===== Card Container ===== */
.container {
    background: #fff;
    padding: 20px;
    border-radius: 12px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.05);
}
h2 { color: #374151; font-size: 1.5rem; }

/* ===== Tombol ===== */
.btn {
    display: inline-block;
    font-size: 0.875rem;
    font-weight: 600;
    padding: 8px 14px;
    border-radius: 8px;
    text-decoration: none;
    transition: all 0.2s ease-in-out;
}
.btn:hover { transform: translateY(-2px); }
.btn-warning { background: #facc15; color: #000; }
.btn-info { background: #38bdf8; color: #fff; }
.btn-info:hover { background: #0ea5e9; }

/* ===== Table ===== */
.table-responsive { overflow-x: auto; margin-top: 15px; }
.table { width: 100%; border-collapse: collapse; font-size: 0.85rem; white-space: nowrap; }
.table th, .table td { padding: 10px 12px; border: 1px solid #e5e7eb; text-align: left; vertical-align: middle; }
.table th { background: #1f2937; color: #fff; position: sticky; top: 0; z-index: 1; }
.table tbody tr:nth-child(even) { background: #f9fafb; }
.table tbody tr:hover { background: #f1f5f9; }
.text-center { text-align: center; color: #6b7280; font-style: italic; }

/* ===== Status Colors ===== */
.bg-yellow-50 { background-color: #fef9c3 !important; }
.bg-green-50 { background-color: #dcfce7 !important; }
.bg-red-50   { background-color: #fee2e2 !important; }

.badge {
    display: inline-block;
    font-size: 0.75rem;
    font-weight: 600;
    padding: 3px 8px;
    border-radius: 6px;
    margin-left: 6px;
}
.badge-pending { background: #fef08a; color: #92400e; }
.badge-approved { background: #86efac; color: #166534; }
.badge-rejected { background: #fca5a5; color: #991b1b; }

/* ===== Filter Status Buttons ===== */
.filter-buttons {
    display: flex;
    gap: 0.5rem;
    flex-wrap: wrap;
    margin-bottom: 1rem;
}
.filter-buttons a {
    padding: 0.5rem 1rem;
    border-radius: 0.5rem;
    font-weight: 600;
    text-decoration: none;
    transition: all 0.2s ease-in-out;
    min-width: 90px;
    text-align: center;
}
.filter-buttons a.bg-gray-200 {
    background-color: #e5e7eb;
    color: #374151;
}
.filter-buttons a.bg-gray-200:hover {
    background-color: #d1d5db;
    transform: translateY(-2px);
}
.filter-buttons a.active { color: #fff; box-shadow: 0 2px 6px rgba(0,0,0,0.2); }
.filter-buttons a.all.active      { background: #3b82f6; }
.filter-buttons a.pending.active  { background: #facc15; }
.filter-buttons a.approved.active { background: #22c55e; }
.filter-buttons a.rejected.active { background: #ef4444; }

/* ===== DataTables Layout ===== */
#formulirTable_wrapper #formulirTable_scrollHead {
    z-index: 30 !important;
}

#formulirTable_length label {
    font-weight: 600;
    color: #333;
    display: flex;
    align-items: center;
    gap: 8px;
}

#formulirTable_length select {
    border-radius: 8px;
    padding: 4px 8px;
    border: 1px solid #ccc;
    background: #f9f9f9;
    font-size: 14px;
    cursor: pointer;
    transition: 0.3s;
}

#formulirTable_length select:hover {
    background: #eef2f7;
    border-color: #888;
}

#formulirTable_paginate {
    display: flex;
    justify-content: center; /* biar di tengah */
    gap: 6px; /* jarak antar tombol */
    margin-top: 15px;
}

/* Tombol pagination */
#formulirTable_paginate .paginate_button {
    border-radius: 6px !important;
    padding: 6px 12px !important;
    border: 1px solid #ccc !important;
    background: #f9f9f9 !important;
    margin: 0 !important; /* hapus jarak bawaan */
    transition: 0.3s;
}

#formulirTable_paginate .paginate_button:hover {
    background: #eef2f7 !important;
    border-color: #888 !important;
}

/* Tombol aktif */
#formulirTable_paginate .paginate_button.current {
    background: #007bff !important;
    color: #fff !important;
    border-color: #007bff !important;
}

#formulirTable_info,
#formulirTable_paginate {
    display: inline-flex;
    align-items: center;
    margin: 0 8px;
}

/* Container bawah */
#formulirTable_wrapper .bottom {
    display: flex;
    justify-content: flex-start; /* biar mulai dari kiri */
    align-items: center;
    gap: 15px; /* jarak antar info & pagination */
}

/* ===== Responsive tweaks ===== */
@media (max-width: 768px) {
     h2 {
        text-align: center;
    }
    
    .filter-buttons a { font-size: 0.75rem; padding: 0.4rem 0.8rem; }
    /* Info + Pagination di bawah tabel jadi stack */
    #formulirTable_wrapper .bottom {
        flex-direction: column;
        align-items: center;
        gap: 10px;
    }

    #formulirTable_info {
        text-align: center;
    }

    #formulirTable_paginate {
        justify-content: center;
        flex-wrap: wrap;
    }

    #formulirTable_paginate .paginate_button {
        padding: 5px 10px !important;
        font-size: 0.8rem !important;
    }

    /* Dropdown length biar kecil */
    #formulirTable_length label {
        flex-direction: column;
        gap: 4px;
        font-size: 0.8rem;
        align-items: flex-start;
    }

    #formulirTable_length select {
        width: 100%;
    }
}
</style>
@endpush
@push('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.querySelectorAll('.btn-delete').forEach(button => {
    button.addEventListener('click', function() {
        const id = this.dataset.id;

        Swal.fire({
            title: 'Yakin ingin hapus?',
            text: "Data ini akan dipindahkan ke sampah sementara.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#ef4444',
            cancelButtonColor: '#6b7280',
            confirmButtonText: 'Ya, hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                // Submit form (soft delete / langsung hapus tergantung controller)
                document.getElementById('delete-form-' + id).submit();

                // Tampilkan toast dengan opsi Undo
                let timerInterval;
                Swal.fire({
                    title: 'Data dihapus',
                    html: 'Menghapus dalam <b></b> detik.<br><button id="undoBtn" class="swal2-confirm swal2-styled" style="margin-top:10px;">Urungkan</button>',
                    timer: 5000,
                    timerProgressBar: true,
                    didOpen: () => {
                        const b = Swal.getHtmlContainer().querySelector('b');
                        timerInterval = setInterval(() => {
                            b.textContent = Math.ceil(Swal.getTimerLeft() / 1000);
                        }, 100);

                        document.getElementById('undoBtn').addEventListener('click', () => {
                            clearInterval(timerInterval);
                            Swal.close();

                            // Panggil route undo
                            fetch(`/admin1/formulir/${id}/undo`, {
                                method: 'POST',
                                headers: {
                                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                                }
                            }).then(() => {
                                Swal.fire('Dibatalkan!', 'Data berhasil dikembalikan.', 'success');
                            });
                        });
                    },
                    willClose: () => {
                        clearInterval(timerInterval);
                    }
                });
            }
        });
    });
});
$(document).ready(function () {
    $('#formulirTable').DataTable({
        pageLength: 50,
        lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "Semua"]],
        scrollX: true,
        scrollY: "500px",
        scrollCollapse: true,
        fixedHeader: true,
        dom: '<"top"l>rt<"bottom"ip><"clear">'
    });
});
</script>
@endpush
