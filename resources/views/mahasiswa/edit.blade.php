@extends('layouts.utama') {{-- Pastikan hanya satu extends --}}

@section('title', 'Edit Data Mahasiswa')

@section('content')
<!-- START FORM -->
<form action="{{ url('mahasiswa/' . $data->nim) }}" method="post">
    @csrf
    @method('PUT') {{-- Penting untuk update --}}
    <div class="my-3 p-3 bg-body rounded shadow-sm">
        <a href="{{ url('mahasiswa') }}" class="btn btn-secondary mb-3">« Kembali</a>

        {{-- Pesan Error (Opsional tapi direkomendasikan) --}}
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- NIM (non-editable) -->
        <div class="mb-3 row">
            <label for="nim" class="col-sm-2 col-form-label">NIM</label>
            <div class="col-sm-10 pt-2">
                <strong>{{ $data->nim }}</strong>
                {{-- NIM biasanya tidak diubah, jadi tidak perlu input --}}
            </div>
        </div>

        <!-- Nama -->
        <div class="mb-3 row">
            <label for="nama" class="col-sm-2 col-form-label">Nama</label>
            <div class="col-sm-10">
                {{-- Gunakan old() untuk mempertahankan input jika validasi gagal --}}
                <input type="text" class="form-control @error('nama') is-invalid @enderror"
                       name="nama" id="nama"
                       value="{{ old('nama', $data->nama) }}" required>
                @error('nama')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <!-- Prodi -->
        <div class="mb-3 row">
            <label for="prodi" class="col-sm-2 col-form-label">Prodi</label>
            <div class="col-sm-10">
                <input type="text" class="form-control @error('prodi') is-invalid @enderror"
                       name="prodi" id="prodi"
                       value="{{ old('prodi', $data->prodi) }}" required>
                 @error('prodi')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <!-- Nomor Kelompok -->
        <div class="mb-3 row">
            <label for="nomor_kelompok" class="col-sm-2 col-form-label">No Kelompok</label>
            <div class="col-sm-10">
                 {{-- Tipe bisa 'text' atau 'number' tergantung kebutuhan --}}
                <input type="text" class="form-control @error('nomor_kelompok') is-invalid @enderror"
                       name="nomor_kelompok" id="nomor_kelompok"
                       value="{{ old('nomor_kelompok', $data->nomor_kelompok) }}" required>
                 @error('nomor_kelompok')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <!-- Dosen Pembimbing -->
        <div class="mb-3 row">
            <label for="dosen_pembimbing" class="col-sm-2 col-form-label">Dosen Pembimbing</label>
            <div class="col-sm-10">
                <input type="text" class="form-control @error('dosen_pembimbing') is-invalid @enderror"
                       name="dosen_pembimbing" id="dosen_pembimbing"
                       value="{{ old('dosen_pembimbing', $data->dosen_pembimbing) }}" required>
                 @error('dosen_pembimbing')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <!-- Angkatan -->
        <div class="mb-3 row">
            <label for="angkatan" class="col-sm-2 col-form-label">Angkatan</label>
            <div class="col-sm-10">
                <input type="number" class="form-control @error('angkatan') is-invalid @enderror"
                       name="angkatan" id="angkatan"
                       value="{{ old('angkatan', $data->angkatan) }}" required>
                 @error('angkatan')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <!-- Tombol Simpan -->
        <div class="mb-3 row">
            <div class="offset-sm-2 col-sm-10">
                <button type="submit" class="btn btn-primary" name="submit">SIMPAN PERUBAHAN</button>
            </div>
        </div>
    </div>
</form>
<!-- AKHIR FORM -->
@endsection
