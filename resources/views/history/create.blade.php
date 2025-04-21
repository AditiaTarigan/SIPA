@extends('layouts.utama') {{-- Pilih salah satu layout, misalnya layouts.utama --}}

@section('title', 'Tambah Data Mahasiswa')

@section('content')
<!-- START FORM -->
<form action='{{ url('history') }}' method='post'>
    @csrf
    <div class="my-3 p-3 bg-body rounded shadow-sm">
        <a href='{{ url('history') }}' class="btn btn-secondary">&laquo; Kembali</a>

        <div class="mb-3 row">
            <label for="tanggal" class="col-sm-2 col-form-label">Tanggal Bimbingan</label>
            <div class="col-sm-10">
                <input type="date" class="form-control" name='tanggal' value="" id="tanggal">
            </div>
        </div>

        <div class="mb-3 row">
            <label for="topik" class="col-sm-2 col-form-label">Topik Bimbingan</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" name='topik' value="" id="topik">
            </div>
        </div>

        <div class="mb-3 row">
            <label for="hasil" class="col-sm-2 col-form-label">Hasil Bimbingan</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" name='hasil' value="" id="hasil">
            </div>
        </div>

        <div class="mb-3 row">
            <label for="tanggal2" class="col-sm-2 col-form-label">Rencana Bimbingan</label>
            <div class="col-sm-10">
                <input type="date" class="form-control" name='tanggal2' value="" id="tanggal2">
            </div>
        </div>

        <div class="mb-3 row">
            <label for="jumlah" class="col-sm-2 col-form-label">Jumlah</label>
            <div class="col-sm-10">
                <input type="number" class="form-control" name='jumlah' value="" id="jumlah">
            </div>
        </div>

        <div class="mb-3 row">
            <div class="offset-sm-2 col-sm-10">
                <button type="submit" class="btn btn-primary" name="submit">SIMPAN</button>
            </div>
        </div>
    </div>
</form>
<!-- AKHIR FORM -->
@endsection
