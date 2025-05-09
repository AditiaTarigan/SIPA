<link href="{{ asset('css/reqbim.css') }}" rel="stylesheet">

@extends('layouts.utama')

@section('title', 'Edit Request Bimbingan')

@section('content')
<div class="container">
    <h1>Edit Request Bimbingan</h1>

    <div class="card">
        <div class="card-body">
    {{-- Display Validation Errors --}}
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    </div>
</div>
    @endif

    <form action="{{ route('request-bimbingan.update', $requestBimbingan->id) }}" method="POST">
        @csrf {{-- CSRF Protection --}}
        @method('PUT') {{-- Method Spoofing for UPDATE --}}

        {{-- Display student info read-only --}}
        <fieldset disabled class="mb-3">
             <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">NIM</label>
                    <input type="text" class="form-control" value="{{ $requestBimbingan->nim }}">
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Nama Mahasiswa</label>
                    <input type="text" class="form-control" value="{{ $requestBimbingan->nama }}">
                </div>
            </div>
        </fieldset>

        <div class="row">
             <div class="col-md-6 mb-3">
                <label for="tanggal_bimbingan" class="form-label">Tanggal Bimbingan <span class="text-danger">*</span></label>
                <input type="date" class="form-control @error('tanggal_bimbingan') is-invalid @enderror" id="tanggal_bimbingan" name="tanggal_bimbingan" value="{{ old('tanggal_bimbingan', $requestBimbingan->tanggal_bimbingan->format('Y-m-d')) }}" required>
                @error('tanggal_bimbingan')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
             <div class="col-md-6 mb-3">
                <label for="jam_bimbingan" class="form-label">Jam Bimbingan <span class="text-danger">*</span></label>
                {{-- Format time correctly for the input type="time" --}}
                <input type="time" class="form-control @error('jam_bimbingan') is-invalid @enderror" id="jam_bimbingan" name="jam_bimbingan" value="{{ old('jam_bimbingan', \Carbon\Carbon::parse($requestBimbingan->jam_bimbingan)->format('H:i')) }}" required>
                 @error('jam_bimbingan')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

         <div class="row">
             <div class="col-md-6 mb-3">
                <label for="bimbingan_ke" class="form-label">Bimbingan Ke- <span class="text-danger">*</span></label>
                <input type="number" class="form-control @error('bimbingan_ke') is-invalid @enderror" id="bimbingan_ke" name="bimbingan_ke" value="{{ old('bimbingan_ke', $requestBimbingan->bimbingan_ke) }}" min="1" required>
                 @error('bimbingan_ke')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="col-md-6 mb-3">
                <label for="no_kelompok" class="form-label">Nomor Kelompok (Optional)</label>
                <input type="text" class="form-control @error('no_kelompok') is-invalid @enderror" id="no_kelompok" name="no_kelompok" value="{{ old('no_kelompok', $requestBimbingan->no_kelompok) }}">
                 @error('no_kelompok')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="mb-3">
            <label for="lokasi" class="form-label">Lokasi <span class="text-danger">*</span></label>
            <input type="text" class="form-control @error('lokasi') is-invalid @enderror" id="lokasi" name="lokasi" value="{{ old('lokasi', $requestBimbingan->lokasi) }}" required>
             @error('lokasi')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="tujuan_bimbingan" class="form-label">Tujuan Bimbingan <span class="text-danger">*</span></label>
            <textarea class="form-control @error('tujuan_bimbingan') is-invalid @enderror" id="tujuan_bimbingan" name="tujuan_bimbingan" rows="4" required>{{ old('tujuan_bimbingan', $requestBimbingan->tujuan_bimbingan) }}</textarea>
             @error('tujuan_bimbingan')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="text-end">
        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
        <a href="{{ route('request-bimbingan.index') }}" class="btn btn-secondary">Batal</a>
    </div>
    </form>

@endsection
