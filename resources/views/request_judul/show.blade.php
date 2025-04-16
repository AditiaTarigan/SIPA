@extends('layouts.utama')

@section('title', 'Detail Request Judul')

@section('content')
<div class="container" padding="10px">
    <h1>Detail Request Judul</h1>

    <div class="card">
        <div class="card-header">
            Request oleh: {{ $requestJudul->mahasiswa->name ?? 'N/A' }}
        </div>
        <div class="card-body">
            <dl class="row">
                <dt class="col-sm-3">Judul Diajukan</dt>
                <dd class="col-sm-9">{{ $requestJudul->judul }}</dd>

                <dt class="col-sm-3">Dosen Pembimbing Dituju</dt>
                <dd class="col-sm-9">{{ $requestJudul->dosen->name ?? 'N/A' }}</dd>

                <dt class="col-sm-3">Deskripsi</dt>
                <dd class="col-sm-9">{{ $requestJudul->deskripsi ?: '-' }}</dd>

                <dt class="col-sm-3">Tanggal Diajukan</dt>
                <dd class="col-sm-9">{{ $requestJudul->created_at->format('d M Y H:i:s') }}</dd>

                <dt class="col-sm-3">Status</dt>
                <dd class="col-sm-9">
                    {{-- Tampilkan status jika ada --}}
                    <span class="badge bg-warning text-dark">Pending</span>
                </dd>
            </dl>
        </div>
        <div class="card-footer text-end">
             {{-- Tombol Aksi untuk Dosen --}}
             {{-- @if(Auth::user()->role == 'dosen' && Auth::id() == $requestJudul->dosen_id)
                <button class="btn btn-success">Approve</button>
                <button class="btn btn-danger">Reject</button>
             @endif --}}

             {{-- Tombol Edit untuk Mahasiswa pembuat --}}
             @if(Auth::user()->role == 'mahasiswa' && Auth::id() == $requestJudul->mahasiswa_id)
                 <a href="{{ route('request-judul.edit', $requestJudul->id) }}" class="btn btn-warning">Edit Request</a>
             @endif

            <a href="{{ route('request-judul.index') }}" class="btn btn-secondary">Kembali ke Daftar</a>
        </div>
    </div>
</div>
@endsection
