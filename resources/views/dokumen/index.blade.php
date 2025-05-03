{{-- Pastikan reqbim.css dimuat, idealnya di layouts.utama --}}
<link href="{{ asset('css/reqbim.css') }}" rel="stylesheet">

@extends('layouts.utama') {{-- Layout tidak diubah --}}

@section('title', 'Riwayat Submit Dokumen') {{-- Judul tidak diubah --}}

@section('content')
{{-- Container asli dipertahankan --}}
<div class="container py-4">

    {{-- 1. Outer Card Wrapper --}}
    <div class="card">

        {{-- 2. Header Section (Inside card) --}}
        <div class="px-4 py-3 border-bottom bg-white">
            <div class="d-flex justify-content-between align-items-center">
                <h1 class="h3 mb-0 text-gray-800">Riwayat Submit Dokumen</h1>
                <a href="{{ url('dokumen/create') }}" class="btn btn-primary">
                     + Tambah Data
                </a>
            </div>
        </div>

        {{-- 3. Content Area (Inside card, below header) --}}
        <div class="p-4 bg-light">

            {{-- 4. Sub-title untuk tabel --}}
            <p class="mb-3 text-muted">Daftar Dokumen Tersubmit</p>

            {{-- 5. Tabel --}}
            <div class="table-responsive">
                {{-- MODIFIKASI: Menghapus cellspacing dan menambah inline style --}}
                <table class="table table-striped table-hover mb-0" id="dataTableDokumen" width="100%"
                       style="border-collapse: separate; border-spacing: 1px;">
                    {{-- thead akan di-style oleh reqbim.css --}}
                    <thead>
                        <tr>
                            <th class="text-center">No.</th>
                            <th class="text-center">Nama</th>
                            <th class="text-center">Prodi</th>
                            <th class="text-center">Nomor Kelompok</th>
                            <th class="text-center">Nama Dokumen</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        {{-- Loop forelse tidak diubah --}}
                        @forelse ($dokumens as $dokumen)
                        <tr>
                            <td class="text-center">{{ $loop->iteration }}</td>
                            <td>{{ $dokumen->nama ?? '-' }}</td>
                            <td>{{ $dokumen->prodi ?? '-' }}</td>
                            <td>{{ $dokumen->nomor_kelompok ?? '-' }}</td>
                            <td>
                                @if($dokumen->dokumen)
                                <a href="{{ asset('storage/' . $dokumen->dokumen) }}" target="_blank">
                                    {{ basename($dokumen->dokumen) }}
                                </a>
                                @else
                                {{ basename($dokumen->dokumen) ?? '-' }}
                                @endif
                            </td>
                            {{-- Kolom Aksi: Style nowrap dipertahankan --}}
                            <td class="text-center align-middle" style="white-space: nowrap;">
                                <a href="{{ route('dokumen.edit', $dokumen->id) }}" class="btn btn-sm btn-warning mb-1" title="Edit">
                                    <i class="fas fa-edit"></i> Edit
                                </a>
                                <a href="{{ route('dokumen.show', $dokumen->id) }}" class="btn btn-sm btn-info mb-1" title="Lihat">
                                    <i class="fas fa-eye"></i> Lihat
                                </a>
                                <form action="{{ route('dokumen.destroy', $dokumen->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Yakin ingin menghapus data ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger mb-1" title="Hapus">
                                        <i class="fas fa-trash"></i> Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center">Belum ada data dokumen yang disubmit.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div> {{-- End .table-responsive --}}

            {{-- 6. Pagination --}}
            <div class="mt-3 d-flex justify-content-center mb-0">
               {{-- {{ $dokumens->links() }} --}}
            </div>

        </div> {{-- End .p-4 .bg-light --}}
    </div> {{-- End .card --}}

</div> {{-- Akhir .container --}}
@endsection

{{-- @push sections tidak diubah --}}
@push('styles')
    {{-- <link href="{{ asset('vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet"> --}}
    <style>
        /* CSS Kustom jika diperlukan */
        .btn-sm i { /* Contoh styling ikon di tombol kecil */
            margin-right: 3px;
        }
        /* Anda mungkin perlu sedikit menyesuaikan padding sel jika border-spacing ditambahkan */
        /* .table td, .table th { padding: 0.7rem; } */
    </style>
@endpush

@push('scripts')
    {{-- Script tidak diubah --}}
@endpush
