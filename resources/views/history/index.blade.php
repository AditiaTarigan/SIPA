{{-- Pastikan reqbim.css dimuat, idealnya di layouts.utama --}}
<link href="{{ asset('css/reqbim.css') }}" rel="stylesheet">

@extends('layouts.utama') {{-- Layout tidak diubah --}}

{{-- Judul Halaman tidak diubah --}}
@section('title', 'Data Mahasiswa / Riwayat Bimbingan')

@section('content')
{{-- Container tidak diubah --}}
<div class="container py-4">

    {{-- 1. Outer Card Wrapper --}}
    {{-- Menggunakan class 'card'. Shadow/margin tergantung CSS/layout --}}
    <div class="card">

        {{-- 2. Header Section (Inside card) --}}
        {{-- Padding & border untuk memisahkan. Menggunakan flexbox. --}}
        <div class="px-4 py-3 border-bottom bg-white">
            <div class="d-flex justify-content-between align-items-center">
                {{-- Judul Halaman Utama - H1/H3 dari kode asli --}}
                <h1 class="h3 mb-0 text-gray-800">Riwayat Bimbingan</h1>
                {{-- Tombol Tambah Data - href dan class asli --}}
                <a href="{{ url('history/create') }}" class="btn btn-primary">+ Tambah Data</a>
            </div>
        </div>

        {{-- 3. Content Area (Inside card, below header) --}}
        {{-- Padding & background abu-abu terang --}}
        <div class="p-4 bg-light">

            {{-- 4. Form Pencarian (Dipindah ke sini dari card-header asli) --}}
            <div class="mb-3"> {{-- Menambah margin bawah untuk jarak --}}
                <form class="d-flex w-100" action="{{ url('history') }}" method="get">
                    <input class="form-control me-2 flex-grow-1"
                           type="search"
                           name="katakunci"
                           value="{{ Request::get('katakunci') }}"
                           placeholder="Cari berdasarkan topik, hasil, dll..."
                           aria-label="Search">
                    <button class="btn btn-secondary" type="submit">Cari</button>
                </form>
            </div>

            {{-- 5. Sub-title untuk tabel --}}
            <p class="mb-3 text-muted">Daftar Riwayat Bimbingan</p>

            {{-- 6. Tabel --}}
            <div class="table-responsive">
                {{-- Menghapus 'table-bordered', mempertahankan sisanya --}}
                <table class="table table-striped table-hover mb-0"
                       id="dataTableHistory" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            {{-- Header asli tidak diubah --}}
                            <th>No</th>
                            <th>Tanggal Bimbingan</th>
                            <th>Topik Bimbingan</th>
                            <th>Hasil Bimbingan</th>
                            <th>Rencana Berikutnya</th>
                            <th>Jumlah Mahasiswa</th>
                            <th>Tanda Tangan Dosen</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        {{-- Loop forelse tidak diubah --}}
                        @forelse ($data as $item)
                            <tr>
                                {{-- Penomoran tidak diubah --}}
                                <td>{{ $data->firstItem() + $loop->index }}</td>
                                {{-- Data kolom tidak diubah --}}
                                <td>{{ $item->tanggal ? \Carbon\Carbon::parse($item->tanggal)->format('d-m-Y') : '-' }}</td>
                                <td>{{ $item->topik ?? '-' }}</td>
                                <td>{{ Str::limit($item->hasil, 70) ?? '-' }}</td>
                                <td>{{ $item->tanggal2 ? \Carbon\Carbon::parse($item->tanggal2)->format('d-m-Y') : '-' }}</td>
                                <td>{{ $item->jumlah ?? '-' }}</td>
                                <td> - </td>
                                {{-- Kolom Aksi: Menambah style nowrap, mempertahankan class & tombol asli --}}
                                <td class="text-center align-middle" style="white-space: nowrap;">
                                    {{-- Tombol Edit tidak diubah (url, class, ikon) --}}
                                    <a href="{{ url('history/'.$item->id.'/edit') }}" class="btn btn-warning btn-sm mb-1" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    {{-- Tombol Hapus tidak diubah (form, url, class, ikon) --}}
                                    <form onsubmit="return confirm('Yakin akan menghapus data ini?')"
                                          class="d-inline"
                                          action="{{ url('history/'.$item->id) }}"
                                          method="post">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm mb-1" title="Hapus">
                                             <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                        {{-- Empty state tidak diubah --}}
                            <tr>
                                <td colspan="8" class="text-center">Tidak ada data riwayat bimbingan ditemukan.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div> {{-- End .table-responsive --}}

            {{-- 7. Pagination --}}
            @if ($data->hasPages())
            {{-- Wrapper pagination tidak diubah --}}
            <div class="mt-4 d-flex justify-content-center">
                {{ $data->withQueryString()->links() }}
            </div>
            @endif

        </div> {{-- End .p-4 .bg-light --}}
    </div> {{-- End .card --}}

</div> {{-- Akhir .container --}}
@endsection

{{-- @push sections tidak diubah --}}
@push('styles')
    {{-- <link href="{{ asset('vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet"> --}}
    <style>
        /* CSS Kustom jika diperlukan */
        .btn-sm i {
             margin-right: 3px; /* Sedikit spasi antara ikon dan teks tombol */
        }
        .card-header form .form-control {
             /* Sesuaikan tampilan input search jika perlu */
        }
    </style>
@endpush

@push('scripts')
    {{-- <script src="{{ asset('vendor/datatables/jquery.dataTables.min.js') }}"></script> --}}
    {{-- <script src="{{ asset('vendor/datatables/dataTables.bootstrap4.min.js') }}"></script> --}}
    {{-- <script> --}}
    {{-- $(document).ready(function() { --}}
    {{--     // $('#dataTableHistory').DataTable(); // JANGAN gunakan DataTables JS jika ingin pagination & search bawaan Laravel berfungsi normal --}}
    {{-- }); --}}
    {{-- </script> --}}
@endpush
