@extends('layouts.utama')

@section('title', 'Edit Request Judul')

@section('content')
<div class="container" padding="10px">
    <h1>Edit Request Judul</h1>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('request-judul.update', $requestJudul->id) }}" method="POST">
                @csrf
                @method('PUT') {{-- Method spoofing untuk update --}}

                <div class="mb-3">
                    <label for="judul" class="form-label">Judul Proyek Akhir <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('judul') is-invalid @enderror" id="judul" name="judul" value="{{ old('judul', $requestJudul->judul) }}" required>
                    @error('judul')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="dosen_id" class="form-label">Pilih Calon Dosen Pembimbing <span class="text-danger">*</span></label>
                    <select class="form-select @error('dosen_id') is-invalid @enderror" id="dosen_id" name="dosen_id" required>
                        <option value="" disabled>-- Pilih Dosen --</option>
                        @foreach ($dosens as $dosen)
                            <option value="{{ $dosen->id }}" {{ old('dosen_id', $requestJudul->dosen_id) == $dosen->id ? 'selected' : '' }}>
                                {{ $dosen->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('dosen_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="deskripsi" class="form-label">Deskripsi Singkat (Opsional)</label>
                    <textarea class="form-control @error('deskripsi') is-invalid @enderror" id="deskripsi" name="deskripsi" rows="4">{{ old('deskripsi', $requestJudul->deskripsi) }}</textarea>
                    @error('deskripsi')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <a href="{{ route('request-judul.index') }}" class="btn btn-secondary">Batal</a>
                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
            </form>
        </div>
    </div>
</div>
@endsection
