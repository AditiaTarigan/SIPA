<link href="{{ asset('css/reqbim.css') }}" rel="stylesheet">
@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Riwayat Submit Dokumen</h2>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Nama</th>
                <th>Prodi</th>
                <th>Nomor Kelompok</th>
                <th>Nama Dokumen</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($dokumens as $dokumen)
            <tr>
                <td>{{ $dokumen->nama }}</td>
                <td>{{ $dokumen->prodi }}</td>
                <td>{{ $dokumen->nomor_kelompok }}</td>
                <td>{{ $dokumen->dokumen }}</td>
                <td>
                    <a href="{{ route('dokumen.edit', $dokumen->id) }}" class="btn btn-sm btn-warning">Edit</a>
                    <a href="{{ route('dokumen.show', $dokumen->id) }}" class="btn btn-sm btn-info">Lihat</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
