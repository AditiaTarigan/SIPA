{{-- Tambahkan link CSS jika BELUM ada di layout utama --}}
<link href="{{ asset('css/reqbim.css') }}" rel="stylesheet">

@extends('layouts.utama') {{-- Gunakan layout Anda --}}

@section('title', 'Data Mahasiswa')

@section('content')
<div class="card"> {{-- Mengganti wrapper lama dengan card --}}

    {{-- Header Card: Judul dan Tombol Tambah --}}
    <div class="d-flex justify-content-between align-items-center mb-3 px-3 pt-3 request-bimbingan-header"> {{-- Meniru header request bimbingan, tambahkan padding jika perlu --}}
        <h1 class="text-dark">Data Mahasiswa</h1> {{-- Judul halaman --}}
        {{-- Tambahkan kondisi @if jika perlu membatasi siapa yang bisa menambah data --}}
        {{-- @if(Auth::user()->role == 'admin') --}}
            <a href="{{ url('mahasiswa/create') }}" class="btn btn-primary"> + Tambah Data</a>
        {{-- @endif --}}
    </div>

    {{-- Card Bagian Dalam untuk Tabel --}}
    <div class="card mx-3 mb-3"> {{-- Card di dalam card, dengan margin --}}
        <div class="card-header">Daftar Mahasiswa Terdaftar</div>
        <div class="card-body p-0"> {{-- Hapus padding body agar tabel rapat --}}

            {{-- FORM PENCARIAN --}}
            <div class="p-3"> {{-- Beri padding untuk form pencarian --}}
                <form class="d-flex" action="{{ url('mahasiswa') }}" method="get">
                    <input class="form-control me-1" type="search" name="katakunci"
                           value="{{ Request::get('katakunci') }}"
                           placeholder="Cari NIM, Nama, Prodi, Kelompok, Dosen, Angkatan..." aria-label="Search">
                    <button class="btn btn-secondary" type="submit">Cari</button>
                </form>
            </div>

            {{-- TABEL DATA --}}
            <div class="table-responsive"> {{-- Agar tabel bisa scroll di layar kecil --}}
                <table class="table table-striped table-hover table-bordered mb-0"> {{-- Tambah class table-hover table-bordered mb-0 --}}
                    <thead class="text-center"> {{-- Center-align header --}}
                        <tr>
                            <th>No</th>
                            <th>NIM</th>
                            <th>Nama</th>
                            <th>Prodi</th>
                            <th>No Kelompok</th>
                            <th>Dosen Pembimbing</th>
                            <th>Angkatan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="text-center"> {{-- Center-align body (opsional) --}}
                        @forelse ($data as $index => $item) {{-- Gunakan forelse dan index --}}
                            <tr>
                                <td>{{ $data->firstItem() + $index }}</td> {{-- Nomor urut paginasi --}}
                                <td>{{ $item->nim }}</td>
                                <td class="text-start">{{ $item->nama }}</td> {{-- Nama biasanya rata kiri --}}
                                <td>{{ $item->prodi }}</td>
                                <td>{{ $item->nomor_kelompok ?? '-' }}</td> {{-- Tampilkan '-' jika null --}}
                                <td class="text-start">{{ $item->dosen_pembimbing ?? '-' }}</td> {{-- Dosen rata kiri, tampilkan '-' jika null --}}
                                <td>{{ $item->angkatan }}</td>
                                <td class="align-middle"> {{-- align-middle agar tombol rapi --}}
                                    <a href="{{ url('mahasiswa/'.$item->nim.'/edit') }}" class="btn btn-warning btn-sm mb-1">Edit</a> {{-- Tambah mb-1 --}}
                                    <form onsubmit="return confirm('Yakin akan menghapus data mahasiswa {{ $item->nama }} ({{ $item->nim }})?')"
                                          class="d-inline" action="{{ url('mahasiswa/'.$item->nim) }}"
                                          method="post">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" name="submit" class="btn btn-danger btn-sm mb-1">Delete</button> {{-- Tambah mb-1 --}}
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center">Data mahasiswa tidak ditemukan.</td> {{-- Sesuaikan colspan --}}
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div> {{-- Akhir table-responsive --}}
        </div> {{-- Akhir card-body --}}
    </div> {{-- Akhir card dalam --}}

</div> {{-- Akhir card luar --}}

{{-- PAGINATION (Letakkan di luar card utama) --}}
<div class="mt-3 d-flex justify-content-center"> {{-- Pusatkan pagination --}}
    {{ $data->withQueryString()->links() }}
</div>

@endsection
