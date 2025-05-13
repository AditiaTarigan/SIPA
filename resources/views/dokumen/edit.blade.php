{{-- resources/views/dokumen/edit.blade.php --}}

<link href="{{ asset('css/reqbim.css') }}" rel="stylesheet"> {{-- Sesuaikan dengan CSS Anda --}}

@extends('layouts.utama') {{-- Pastikan ini mengarah ke layout utama Anda --}}

@section('title', 'Edit Dokumen') {{-- Menambahkan judul halaman --}}

@section('content')
<div class="container py-4"> {{-- Menambahkan padding Y untuk kontainer --}}

    {{-- Judul Halaman --}}
    {{-- Menggunakan H3 dan mb-4 untuk margin bawah --}}
    <h3 class="mb-4 text-gray-800">Edit Dokumen</h3>

    {{-- Form Update Dokumen --}}
    <form action="{{ route('dokumen.update', $dokuman->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        {{-- Card untuk membungkus form --}}
        <div class="card shadow mb-4"> {{-- Menambahkan shadow dan margin bawah --}}
            <div class="card-body"> {{-- Body card --}}

                {{-- Input Nama --}}
                <div class="mb-3">
                    <label for="nama" class="form-label">Nama</label>
                    <input type="text" class="form-control @error('nama') is-invalid @enderror" id="nama" name="nama" value="{{ old('nama', $dokuman->nama) }}" required>
                     @error('nama')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Input Program Studi --}}
                <div class="mb-3">
                    <label for="prodi" class="form-label">Program Studi</label>
                    <input type="text" class="form-control @error('prodi') is-invalid @enderror" id="prodi" name="prodi" value="{{ old('prodi', $dokuman->prodi) }}" required>
                     @error('prodi')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Input Nomor Kelompok --}}
                <div class="mb-3">
                    <label for="nomor_kelompok" class="form-label">Nomor Kelompok</label>
                    {{-- Menggunakan old() untuk mempertahankan nilai jika validasi gagal --}}
                    <input type="text" class="form-control @error('nomor_kelompok') is-invalid @enderror" id="nomor_kelompok" name="nomor_kelompok" value="{{ old('nomor_kelompok', $dokuman->nomor_kelompok) }}" required>
                     @error('nomor_kelompok')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Input Upload Dokumen Baru --}}
                <div class="mb-3">
                    <label for="dokumen" class="form-label">Upload Dokumen Baru (Opsional)</label>
                    <input type="file" class="form-control @error('dokumen') is-invalid @enderror" id="dokumen" name="dokumen">
                    @error('dokumen')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    {{-- Menampilkan nama file saat ini jika ada --}}
                    @if($dokuman->dokumen)
                        <small class="form-text text-muted">File saat ini: <a href="{{ Storage::url($dokuman->dokumen) }}" target="_blank">{{ basename($dokuman->dokumen) }}</a></small>
                    @else
                         <small class="form-text text-muted">Belum ada file dokumen terunggah.</small>
                    @endif
                </div>

                {{-- Tombol Aksi (Simpan dan Batal), rata kanan --}}
                <div class="text-end mt-4"> {{-- Menambahkan margin top --}}
                    <button type="submit" class="btn btn-primary me-2">Simpan Perubahan</button> {{-- btn-primary seperti referensi, me-2 untuk margin kanan --}}
                    <a href="{{ route('dokumen.index') }}" class="btn btn-secondary">Batal</a> {{-- Tombol Batal --}}
                </div>

            </div> {{-- Akhir card-body --}}
        </div> {{-- Akhir card --}}
    </form>

</div> {{-- Akhir container --}}
@endsection
