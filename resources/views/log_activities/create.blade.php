<link href="{{ asset('css/log_activities.css') }}" rel="stylesheet"> {{-- Sesuaikan dengan CSS Log Activities --}}
@extends('layouts.utama')

@section('content')
<div class="container">
    <h2 style="color: black">Form Submit Log Aktivities</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('log_activities.store') }}" method="POST" enctype="multipart/form-data">
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
                <option value="Teknologi Rekayasa Perangkat Lunak">Teknologi Rekayasa Perangkat Lunak</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="no_kelompok" class="form-label">Nomor Kelompok</label>
            <input type="text" class="form-control" id="no_kelompok" name="no_kelompok">
        </div>

        <div class="mb-3">
            <label for="file_log" class="form-label">Upload File Log</label>
            <input type="file" class="form-control" id="file_log" name="file_log" required>
        </div>

        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</div>
@endsection
