{{-- File: resources/views/mahasiswa/show.blade.php --}}

{{-- Jika Anda punya CSS khusus untuk styling dt bold, pastikan di-include --}}
{{-- Contoh: <link href="{{ asset('css/detail-view.css') }}" rel="stylesheet"> --}}
{{-- Atau pastikan layouts.utama sudah menghandle styling dt --}}

@extends('layouts.utama') {{-- Menggunakan layout yang sama --}}

@section('title', 'Detail Data Mahasiswa') {{-- Judul Halaman Browser --}}

@section('content')
    <h1>Detail Data Mahasiswa</h1> {{-- Judul Utama Konten --}}

    <div class="card shadow-sm"> {{-- Menggunakan card seperti contoh sebelumnya --}}
        <div class="card-header">
            {{-- Bisa menampilkan NIM atau Nama sebagai header --}}
            Data Mahasiswa: {{ $mahasiswa->nama ?? $mahasiswa->nim }}
        </div>
        <div class="card-body">
            {{-- Menggunakan Description List (dl) untuk layout label-value --}}
            <dl class="row">
                {{-- Pastikan CSS Anda (misal di layouts.utama atau CSS terpisah) --}}
                {{-- memiliki rule: dl.row dt { font-weight: bold; } --}}

                <dt class="col-sm-3">NIM</dt>
                <dd class="col-sm-9">{{ $mahasiswa->nim }}</dd>

                {{-- Diasumsikan ada field 'nama' di model Mahasiswa Anda --}}
                <dt class="col-sm-3">Nama Mahasiswa</dt>
                <dd class="col-sm-9">{{ $mahasiswa->nama ?? '-' }}</dd>

                 <dt class="col-sm-3">Program Studi</dt>
                 <dd class="col-sm-9">{{ $mahasiswa->prodi }}</dd>

                 <dt class="col-sm-3">Tahun Angkatan</dt>
                <dd class="col-sm-9">{{ $mahasiswa->angkatan }}</dd>

                {{-- Diasumsikan ada field 'no_kelompok' di model Mahasiswa Anda --}}
                {{-- Menggunakan ?? '-' untuk handle jika data null/kosong --}}
                <dt class="col-sm-3">No Kelompok</dt>
                <dd class="col-sm-9">{{ $mahasiswa->no_kelompok ?? '-' }}</dd>

                {{-- Tambahkan field lain jika ada dan relevan untuk ditampilkan --}}
                {{-- Contoh:
                <dt class="col-sm-3">Email</dt>
                <dd class="col-sm-9">{{ $mahasiswa->email ?? '-' }}</dd>

                <dt class="col-sm-3">Tanggal Terdaftar</dt>
                <dd class="col-sm-9">{{ $mahasiswa->created_at ? $mahasiswa->created_at->format('d F Y H:i') : '-' }}</dd>
                --}}

            </dl>
        </div>
        <div class="card-footer text-end"> {{-- Meratakan tombol ke kanan --}}
             {{-- Gunakan route helper jika memungkinkan --}}
             <a href="{{ route('mahasiswa.index') }}" class="btn btn-secondary">Kembali ke Daftar</a>

             {{-- Tombol Edit dan Delete (Sebaiknya gunakan Authorization/Policies) --}}
             {{-- Contoh dengan @can (jika menggunakan Laravel Policies/Gates) --}}
             @can('update', $mahasiswa)
                 <a href="{{ route('mahasiswa.edit', $mahasiswa->id) }}" class="btn btn-warning">Edit</a>
             @endcan

             @can('delete', $mahasiswa)
                 <form action="{{ route('mahasiswa.destroy', $mahasiswa->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data mahasiswa ini?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Hapus</button>
                </form>
             @endcan

             {{-- Jika belum pakai Policies/Gates, bisa pakai cek sederhana (kurang ideal) --}}
             {{-- Contoh:
             @if(Auth::user()->isAdmin()) // Atau role lain yang sesuai
                 <a href="{{ route('mahasiswa.edit', $mahasiswa->id) }}" class="btn btn-warning">Edit</a>
                 <form action="{{ route('mahasiswa.destroy', $mahasiswa->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data mahasiswa ini?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Hapus</button>
                </form>
             @endif
             --}}
        </div>
    </div>

@endsection

{{-- Jangan lupa pastikan CSS untuk membuat <dt> bold sudah ada --}}
{{-- Contoh CSS jika belum ada: --}}
{{--
@push('styles')
<style>
    dl.row dt {
        font-weight: bold;
    }
</style>
@endpush
--}}
