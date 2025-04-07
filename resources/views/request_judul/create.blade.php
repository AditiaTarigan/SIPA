{{-- resources/views/request_judul/create.blade.php --}}

@extends('layouts.app')

 @section('content')
<div class="container">
    <h2>Ajukan Judul Skripsi Baru</h2>

    {{-- Tampilkan error validasi jika ada --}}
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('request-judul.store') }}" method="POST">
        @csrf {{-- Token CSRF Wajib untuk form POST --}}

        <div class="mb-3">
            <label for="judul" class="form-label">Judul yang Diajukan</label>
            <input type="text" class="form-control @error('judul') is-invalid @enderror" id="judul" name="judul" value="{{ old('judul') }}" required>
            @error('judul')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="deskripsi" class="form-label">Deskripsi Singkat (Opsional)</label>
            <textarea class="form-control @error('deskripsi') is-invalid @enderror" id="deskripsi" name="deskripsi" rows="3">{{ old('deskripsi') }}</textarea>
             @error('deskripsi')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="dosen_id" class="form-label">Pilih Dosen Pembimbing</label>
            <select class="form-select @error('dosen_id') is-invalid @enderror" id="dosen_id" name="dosen_id" required>
                <option value="" disabled {{ old('dosen_id') ? '' : 'selected' }}>-- Pilih Dosen --</option>
                @foreach ($dosens as $dosen)
                    <option value="{{ $dosen->id }}" {{ old('dosen_id') == $dosen->id ? 'selected' : '' }}>
                        {{ $dosen->name }} {{-- Asumsi nama dosen ada di kolom 'name' --}}
                    </option>
                @endforeach
            </select>
             @error('dosen_id')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary">Ajukan</button>
        <a href="{{ route('request-judul.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
{{-- @endsection --}}
