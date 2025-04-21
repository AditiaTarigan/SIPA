<link href="{{ asset('css/reqbim.css') }}" rel="stylesheet">

@extends('layouts.utama')

@section('title', 'Request Bimbingan Details')

@section('content')
    <h1>Request Bimbingan Details</h1>

    <div class="card">
        <div class="card-header">
            Request #{{ $requestBimbingan->id }}
        </div>
        <div class="card-body">
            <dl class="row">
                <dt class="col-sm-3">NIM</dt>
                <dd class="col-sm-9">{{ $requestBimbingan->nim }}</dd>

                <dt class="col-sm-3">Nama Mahasiswa</dt>
                <dd class="col-sm-9">{{ $requestBimbingan->nama }}</dd>

                <dt class="col-sm-3">Program Studi</dt>
                <dd class="col-sm-9">{{ $requestBimbingan->prodi }}</dd>

                 <dt class="col-sm-3">Tahun Angkatan</dt>
                <dd class="col-sm-9">{{ $requestBimbingan->tahun_angkatan }}</dd>

                <dt class="col-sm-3">No Kelompok</dt>
                <dd class="col-sm-9">{{ $requestBimbingan->no_kelompok ?? '-' }}</dd>

                <dt class="col-sm-3">Tanggal Bimbingan</dt>
                <dd class="col-sm-9">{{ $requestBimbingan->tanggal_bimbingan->format('d F Y') }}</dd>

                <dt class="col-sm-3">Jam Bimbingan</dt>
                <dd class="col-sm-9">{{ \Carbon\Carbon::parse($requestBimbingan->jam_bimbingan)->format('H:i') }}</dd>

                <dt class="col-sm-3">Bimbingan Ke</dt>
                <dd class="col-sm-9">{{ $requestBimbingan->bimbingan_ke }}</dd>

                <dt class="col-sm-3">Lokasi</dt>
                <dd class="col-sm-9">{{ $requestBimbingan->lokasi }}</dd>

                 <dt class="col-sm-3">Tujuan Bimbingan</dt>
                <dd class="col-sm-9">{{ nl2br(e($requestBimbingan->tujuan_bimbingan)) }}</dd>

                 <dt class="col-sm-3">Requested At</dt>
                 <dd class="col-sm-9">{{ $requestBimbingan->created_at->format('d M Y H:i:s') }}</dd>

                 <dt class="col-sm-3">Status (Placeholder)</dt>
                 <dd class="col-sm-9"><span class="badge bg-warning">Pending</span></dd> {{-- Add actual status logic later --}}
            </dl>
        </div>
        <div class="card-footer">
             <a href="{{ route('request-bimbingan.index') }}" class="btn btn-secondary">Back to List</a>
             {{-- Add authorization check --}}
             @if(Auth::id() == $requestBimbingan->mahasiswa_id)
                 <a href="{{ route('request-bimbingan.edit', $requestBimbingan->id) }}" class="btn btn-warning">Edit</a>
                 <form action="{{ route('request-bimbingan.destroy', $requestBimbingan->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this request?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
             @endif
        </div>
    </div>

@endsection
