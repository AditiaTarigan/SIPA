<link href="{{ asset('css/reqbim.css') }}" rel="stylesheet"> {{-- Sesuaikan dengan CSS Log Activities --}}
@extends('layouts.utama')

@section('content')
<div class="container">
    <h2 style="color: black">Edit Log Aktivitas</h2>

    <form action="{{ route('log_activities.update', $logActivity->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="nama" class="form-label">Nama</label>
            <input type="text" class="form-control" id="nama" name="nama" value="{{ $logActivity->nama }}" required>
        </div>

        <div class="mb-3">
            <label for="prodi" class="form-label">Program Studi</label>
            <input type="text" class="form-control" id="prodi" name="prodi" value="{{ $logActivity->prodi }}" required>
        </div>

        <div class="mb-3">
            <label for="no_kelompok" class="form-label">Nomor Kelompok</label>
            <input type="text" class="form-control" id="no_kelompok" name="no_kelompok" value="{{ $logActivity->no_kelompok }}">
        </div>

        <div class="mb-3">
            <label for="file_log" class="form-label">Upload File Log Baru (Opsional)</label>
            <input type="file" class="form-control" id="file_log" name="file_log">
        </div>

        <button type="submit" class="btn btn-success">Simpan Perubahan</button>
    </form>
</div>
@endsection
