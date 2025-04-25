<link href="{{ asset('css/dokumen.css') }}" rel="stylesheet">
@extends('layouts.utama')

@section('content')
<div class="container">
    <h2 style="color: black">Form Submit Dokumen</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('dokumen.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label for="nama" class="form-label">Nama</label>
            <input type="text" class="form-control" id="nama" name="nama" required>
        </div>

        <div class="mb-3">
            <label for="prodi" class="form-label">Program Studi</label>
            <select class="form-control" id="prodi" name="prodi" required>
                <option value="">-- Pilih Program Studi --</option>
                <option value="Teknologi Informasi">Teknologi Informasi</option>
                <option value="Teknologi Komputer">Teknologi Komputer</option>
                <option value="Teknologi Rekayasa Perangkat Lunak"> Teknologi Informasi Perangkat Lunak</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="nomor_kelompok" class="form-label">Nomor Kelompok</label>
            <input type="text" class="form-control" id="nomor_kelompok" name="nomor_kelompok" required>
        </div>
        <div class="mb-3">
            <label for="angkatan" class="form-label">Angkatan</label>
            <select class="form-control" id="angkatan" name="angkatan" required>
                <option value="">-- Pilih Angkatan --</option>
                <option value="2024">2024</option>
                <option value="2024">2023</option>
                <option value="2024">2022</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="dokumen" class="form-label">Upload Dokumen</label>
            <input type="file" class="form-control" id="dokumen" name="dokumen" required>
        </div>

        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</div>
@endsection
