@extends('admin1.dashboard')

@section('title', 'Detail IWKBU')

@section('content')
<div class="container mt-5">
    <h2 class="mb-4">Detail Data IWKBU</h2>
    <table class="table table-bordered">
        <tr>
            <th>No Polisi</th>
            <td>{{ $iwkbu->no_polisi }}</td>
        </tr>
        <tr>
            <th>Wilayah</th>
            <td>{{ $iwkbu->wilayah }}</td>
        </tr>
        <tr>
            <th>Trayek</th>
            <td>{{ $iwkbu->trayek }}</td>
        </tr>
        <tr>
            <th>Jenis</th>
            <td>{{ $iwkbu->jenis }}</td>
        </tr>
        <tr>
            <th>Tahun Pembuatan</th>
            <td>{{ $iwkbu->tahun_pembuatan }}</td>
        </tr>
    </table>

    <a href="{{ route('admin1.iwkbu.index') }}" class="btn btn-secondary">Kembali</a>
</div>

@push('styles')
<link rel="stylesheet" href="{{ asset('css/admin1/iwkbu-detail.css') }}">
@endpush

@endsection
