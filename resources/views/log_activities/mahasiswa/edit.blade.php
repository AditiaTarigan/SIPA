@extends('layouts.utama') {{-- Hapus salah satu extends --}}

@section('title', 'Edit Data Mahasiswa')

@section('content')
<!-- START FORM -->
<form action="{{ url('mahasiswa/' . $data->nim) }}" method="post">
    @csrf
    @method('PUT')
    <div class="my-3 p-3 bg-body rounded shadow-sm">
        <a href="{{ url('mahasiswa') }}" class="btn btn-secondary">&laquo; Kembali</a>

        <!-- NIM (non-editable) -->
        <div class="mb-3 row">
            <label for="nim" class="col-sm-2 col-form-label">NIM</label>
            <div class="col-sm-10 pt-2">
                <strong>{{ $data->nim }}</strong>
            </div>
        </div>

        <!-- Prodi -->
        <div class="mb-3 row">
            <label for="prodi" class="col-sm-2 col-form-label">Prodi</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" name="prodi" id="prodi"
                       value="{{ $data->prodi }}" required>
            </div>
        </div>

        <!-- Angkatan -->
        <div class="mb-3 row">
            <label for="angkatan" class="col-sm-2 col-form-label">Angkatan</label>
            <div class="col-sm-10">
                <input type="number" class="form-control" name="angkatan" id="angkatan"
                       value="{{ $data->angkatan }}" required>
            </div>
        </div>

        <!-- Tombol Simpan -->
        <div class="mb-3 row">
            <div class="offset-sm-2 col-sm-10">
                <button type="submit" class="btn btn-primary" name="submit">SIMPAN</button>
            </div>
        </div>
    </div>
</form>
<!-- AKHIR FORM -->
@endsection
