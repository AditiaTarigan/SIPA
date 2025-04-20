<link href="{{ asset('css/reqbim.css') }}" rel="stylesheet">

@extends('layouts.app')
@extends('layouts.utama')

@section('title', 'Create Request Bimbingan')

@section('content')
    <h1>Create New Request Bimbingan</h1>

    {{-- Display Validation Errors --}}
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('request-bimbingan.store') }}" method="POST">
        @csrf {{-- CSRF Protection --}}

        {{-- Student info will be automatically added from logged-in user in the controller --}}
        {{-- You could display it here read-only if desired --}}
        {{-- <p>Requesting as: {{ Auth::user()->name }} ({{ Auth::user()->nim }})</p> --}}

        <div class="row">
             <div class="col-md-6 mb-3">
                <label for="tanggal_bimbingan" class="form-label">Tanggal Bimbingan <span class="text-danger">*</span></label>
                <input type="date" class="form-control @error('tanggal_bimbingan') is-invalid @enderror" id="tanggal_bimbingan" name="tanggal_bimbingan" value="{{ old('tanggal_bimbingan') }}" required>
                @error('tanggal_bimbingan')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
             <div class="col-md-6 mb-3">
                <label for="jam_bimbingan" class="form-label">Jam Bimbingan <span class="text-danger">*</span></label>
                <input type="time" class="form-control @error('jam_bimbingan') is-invalid @enderror" id="jam_bimbingan" name="jam_bimbingan" value="{{ old('jam_bimbingan') }}" required>
                 @error('jam_bimbingan')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

         <div class="row">
             <div class="col-md-6 mb-3">
                <label for="bimbingan_ke" class="form-label">Bimbingan Ke- <span class="text-danger">*</span></label>
                <input type="number" class="form-control @error('bimbingan_ke') is-invalid @enderror" id="bimbingan_ke" name="bimbingan_ke" value="{{ old('bimbingan_ke') }}" min="1" required>
                 @error('bimbingan_ke')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="col-md-6 mb-3">
                <label for="no_kelompok" class="form-label">Nomor Kelompok (Optional)</label>
                <input type="text" class="form-control @error('no_kelompok') is-invalid @enderror" id="no_kelompok" name="no_kelompok" value="{{ old('no_kelompok') }}">
                 @error('no_kelompok')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="mb-3">
            <label for="lokasi" class="form-label">Lokasi <span class="text-danger">*</span></label>
            <input type="text" class="form-control @error('lokasi') is-invalid @enderror" id="lokasi" name="lokasi" value="{{ old('lokasi') }}" required>
             @error('lokasi')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="tujuan_bimbingan" class="form-label">Tujuan Bimbingan <span class="text-danger">*</span></label>
            <textarea class="form-control @error('tujuan_bimbingan') is-invalid @enderror" id="tujuan_bimbingan" name="tujuan_bimbingan" rows="4" required>{{ old('tujuan_bimbingan') }}</textarea>
             @error('tujuan_bimbingan')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary">Submit Request</button>
        <a href="{{ route('request-bimbingan.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
@endsection
