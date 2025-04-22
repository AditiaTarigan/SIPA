<link href="{{ asset('css/reqbim.css') }}" rel="stylesheet">
@extends('layouts.utama')

@section('content')
<div class="container">
    <h2 style="color: black">Submit Dokumen</h2>

    <form action="{{ route('dokumen.update', $dokumen->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="nama" class="form-label">Nama</label>
            <input type="text" class="form-control" id="nama" name="nama" value="{{ $dokumen->nama }}" required>
        </div>

        <div class="mb-3">
            <label for="prodi" class="form-label">Program Studi</label>
            <input type="text" class="form-control" id="prodi" name="prodi" value="{{ $dokumen->prodi }}" required>
        </div>

        <div class="mb-3">
            <label for="nomor_kelompok" class="form-label">Nomor Kelompok</label>
            <input type="text" class="form-control" id="nomor_kelompok" name="nomor_kelompok" value="{{ $dokumen->nomor_kelompok }}" required>
        </div>

        <div class="mb-3">
            <label for="dokumen" class="form-label">Upload Dokumen Baru (Opsional)</label>
            <input type="file" class="form-control" id="dokumen" name="dokumen">
        </div>

        <button type="submit" class="btn btn-success">Simpan Perubahan</button>
    </form>
</div>
@endsection
