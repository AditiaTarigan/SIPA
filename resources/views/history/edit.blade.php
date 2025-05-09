<link href="{{ asset('css/reqbim.css') }}" rel="stylesheet">

@extends('layouts.utama') {{-- Layout utama --}}

@section('title', 'Edit Data Bimbingan')

@section('content')
<div class="container">
    <h2 style="color: black">Edit Data Bimbingan</h2>

    <div class="card">
    <div class="card-body">
<!-- START FORM -->
<form action="{{ url('history/' . $data->id) }}" method="post">
    @csrf
    @method('PUT')

        <div class="mb-3 row">
            <label for="tanggal" class="col-sm-2 col-form-label">Tanggal Bimbingan</label>
            <div class="col-sm-10">
                <input type="date" class="form-control" name="tanggal" id="tanggal"
                       value="{{ $data->tanggal }}" required>
            </div>
        </div>

        <div class="mb-3 row">
            <label for="topik" class="col-sm-2 col-form-label">Topik Bimbingan</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" name="topik" id="topik"
                       value="{{ $data->topik }}" required>
            </div>
        </div>

        <div class="mb-3 row">
            <label for="hasil" class="col-sm-2 col-form-label">Hasil Bimbingan</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" name="hasil" id="hasil"
                       value="{{ $data->hasil }}" required>
            </div>
        </div>

        <div class="mb-3 row">
            <label for="tanggal2" class="col-sm-2 col-form-label">Rencana Bimbingan</label>
            <div class="col-sm-10">
                <input type="date" class="form-control" name="tanggal2" id="tanggal2"
                       value="{{ $data->tanggal2 }}" required>
            </div>
        </div>

        <div class="mb-3 row">
            <label for="jumlah" class="col-sm-2 col-form-label">Jumlah Mahasiswa</label>
            <div class="col-sm-10">
                <input type="number" class="form-control" name="jumlah" id="jumlah"
                       value="{{ $data->jumlah }}" required>
            </div>
        </div>

            <div class="text-end">
                <button type="submit" class="btn btn-primary" name="submit">Simpan Perubahan</button>

        <a href="{{ url('history') }}" class="btn btn-secondary">Batal</a>
            </div>
        </div>
    </div>
</form>
<!-- AKHIR FORM -->
@endsection
