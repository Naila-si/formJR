@extends('admin1.dashboard')

@section('title', 'Daftar Manifest')

@section('content')
<div class="container mt-5">
    <h2 class="manifest-title">Daftar Manifest</h2>

    <div class="table-responsive">
        <table class="table table-bordered" id="manifestTable">
            <thead class="table-dark">
                <tr>
                    <th>No</th>
                    <th>Aksi</th>
                    <th>Nama Kapal</th>
                    <th>Tanggal Keberangkatan</th>
                    <th>Asal Keberangkatan</th>
                    <th>Dewasa</th>
                    <th>Anak</th>
                    <th>Total Penumpang</th>
                    <th>Premi Asuransi</th>
                    <th>Nama Agen</th>
                    <th>Telepon</th>
                    <th>Bukti Manifest</th>
                    <th>Tanda Tangan</th>
                </tr>
            </thead>
            <tbody>
                @forelse($manifests as $index => $manifest)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>
                        <form action="{{ route('admin1.manifest.destroy', $manifest->id) }}" method="POST" onsubmit="return confirm('Hapus data ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                        </form>
                    </td>
                    <td>{{ $manifest->nama_kapal }}</td>
                    <td>{{ $manifest->tanggal_keberangkatan }}</td>
                    <td>{{ $manifest->asal_keberangkatan }}</td>
                    <td>{{ $manifest->dewasa }}</td>
                    <td>{{ $manifest->anak }}</td>
                    <td>{{ $manifest->total_penumpang }}</td>
                    <td>Rp {{ number_format($manifest->premi_asuransi,0,',','.') }}</td>
                    <td>{{ $manifest->nama_agen }}</td>
                    <td>{{ $manifest->telepon }}</td>
                    <td>
                        @if(is_array($manifest->foto_manifest))
                            @foreach($manifest->foto_manifest as $foto)
                                <a href="{{ asset('storage/manifest/'.$foto) }}" target="_blank">Lihat</a><br>
                            @endforeach
                        @endif
                    </td>
                    <td>
                        @if($manifest->ttd_petugas_data)
                            <img src="{{ $manifest->ttd_petugas_data }}" alt="TTD" style="width:120px;height:60px;object-fit:contain;border:1px solid #ccc;border-radius:4px;">
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="13" class="text-center">Belum ada data manifest</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection

@push('styles')
<link rel="stylesheet" href="{{ asset('css/admin1/manifest.css') }}">
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/fixedheader/3.4.0/css/fixedHeader.dataTables.min.css">
@endpush

@push('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/fixedheader/3.4.0/js/dataTables.fixedHeader.min.js"></script>
<script>
$(document).ready(function() {
    $('#manifestTable').DataTable({
        pageLength: 25,
        scrollX: true,
        fixedHeader: true,
        dom: '<"top"l>rt<"bottom"ip><"clear">'
    });
});
</script>
@endpush
