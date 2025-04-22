<link href="{{ asset('css/reqbim.css') }}" rel="stylesheet">
@extends('layouts.utama')

@section('content')
<div class="container">
    <h2>Riwayat Submit Dokumen</h2>
    <form action="" method="POST" enctype="multipart/form-data">
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
                @foreach ($dokumens as $dokumen)  <!-- Menggunakan objek $dokumen dalam foreach -->
                <tr>
                    <td>{{ $dokumen->nama }}</td>
                    <td>{{ $dokumen->prodi }}</td>
                    <td>{{ $dokumen->nomor_kelompok }}</td>
                    <td>{{ $dokumen->dokumen }}</td>
                    <td>
                        <a href="{{ route('submit_dokumen.edit', $dokumen->id) }}" class="btn btn-sm btn-warning">Edit</a>
                        <a href="{{ route('submit_dokumen.show', $dokumen->id) }}" class="btn btn-sm btn-info">Lihat</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </form>
</div>
@endsection
