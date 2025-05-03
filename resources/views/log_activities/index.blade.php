{{-- Pastikan reqbim.css dimuat, idealnya di layouts.utama --}}
<link href="{{ asset('css/reqbim.css') }}" rel="stylesheet">

@extends('layouts.utama')

@section('title', 'Riwayat Submit Log Activities')

@section('content')

{{-- 1. Outer Container/Card --}}
{{-- Menggunakan class 'card' saja, asumsi shadow/margin diatur oleh reqbim.css atau layout --}}
{{-- Jika reqbim.css tidak mengatur shadow/margin untuk .card, tambahkan kembali (misal: shadow-sm mb-4) --}}
<div class="card">

    {{-- 2. Header Section (Di dalam card luar) --}}
    {{-- Menggunakan padding dan border yang mungkin lebih cocok dengan target --}}
    {{-- Coba class 'request-bimbingan-header' jika didefinisikan di reqbim.css --}}
    {{-- Atau gunakan padding/border eksplisit --}}
    <div class="px-6 py-4 border-bottom bg-white request-bimbingan-header"> {{-- Coba padding lebih besar (px-6 py-4) dan class header --}}
        <div class="d-flex justify-content-between align-items-center">
            {{-- Main page title - Ukuran/Font harusnya dari H1 default atau CSS --}}
            <h1>Riwayat Submit Log Activities</h1>

            {{-- "Tambah Data" Button - Class btn-primary seharusnya sudah benar --}}
            <a href="{{ route('log_activities.create') }}" class="btn btn-primary">
                + Tambah Data
            </a>
        </div>
    </div>

    {{-- 3. Content Area (Di dalam card luar, di bawah header) --}}
    {{-- Menggunakan padding dan background yang lebih mendekati target --}}
    {{-- Coba 'bg-gray-50' (jika Tailwind) atau 'bg-light' (Bootstrap) atau class kustom --}}
    <div class="p-6 bg-light"> {{-- Coba padding lebih besar (p-6) dan bg-light --}}

        {{-- 4. Sub-title untuk tabel --}}
        {{-- Coba styling font/margin yang lebih mirip target --}}
        <h6 class="mb-4 text-secondary">Daftar Log Activities</h6> {{-- Coba mb-4 dan text-secondary/abu-abu --}}

        {{-- 5. Tabel --}}
        <div class="table-responsive">
            {{-- Class tabel dari kode Anda sudah benar (striped, hover, bordered, mb-0) --}}
            <table class="table table-striped table-hover table-bordered mb-0">
                {{-- Thead: Styling biru harus dari reqbim.css untuk .table thead tr --}}
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Prodi</th>
                        <th>No Kelompok</th>
                        <th>File Log</th>
                        <th>Tanggal Submit</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    {{-- Loop forelse dari kode Anda --}}
                    @forelse ($logActivities as $index => $logActivity)
                    <tr>
                        {{-- Data tidak diubah --}}
                        <td>{{ $logActivities->firstItem() + $index }}</td>
                        <td>{{ $logActivity->nama ?? '-' }}</td>
                        <td>{{ $logActivity->prodi ?? '-' }}</td>
                        <td>{{ $logActivity->no_kelompok ?? '-' }}</td>
                        <td>
                            @if($logActivity->file_log)
                                {{-- Link file tidak diubah --}}
                                <a href="{{ asset('storage/logs/' . $logActivity->file_log) }}" target="_blank">{{ $logActivity->file_log }}</a>
                            @else
                                -
                            @endif
                        </td>
                        {{-- Format tanggal tidak diubah --}}
                        <td>{{ $logActivity->submitted_at ? $logActivity->submitted_at->format('d M Y H:i') : '-' }}</td>
                        {{-- Kolom Aksi: Class kolom & Tombol dari kode Anda --}}
                        {{-- Warna tombol (info, warning, danger) sudah sesuai target --}}
                        <td class="text-center align-middle">
                            {{-- Tombol Detail (info - cyan/biru muda) --}}
                            <a href="{{ route('log_activities.show', $logActivity->id) }}" class="btn btn-sm btn-info mb-1" title="Lihat Detail">Detail</a>
                            {{-- Tombol Edit (warning - kuning) --}}
                            <a href="{{ route('log_activities.edit', $logActivity->id) }}" class="btn btn-sm btn-warning mb-1" title="Edit">Edit</a>
                            {{-- Tombol Hapus (danger - merah) --}}
                            <form action="{{ route('log_activities.destroy', $logActivity->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus log ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger mb-1" title="Hapus">Hapus</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    {{-- Empty state dari kode Anda --}}
                    <tr>
                        <td colspan="7" class="text-center">Belum ada data log activities yang disubmit.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div> {{-- End .table-responsive --}}

        {{-- 6. Pagination --}}
        @if ($logActivities->hasPages())
        {{-- Wrapper pagination tidak diubah --}}
        <div class="mt-4 d-flex justify-content-center">
            {{ $logActivities->links() }}
        </div>
        @endif

    </div> {{-- End .p-6 .bg-light --}}
</div> {{-- End .card --}}

@endsection

{{-- @push sections tidak diubah --}}
