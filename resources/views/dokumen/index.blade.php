{{-- Memuat file CSS kustom. Idealnya dimuat di layouts.utama jika digunakan di banyak halaman. --}}
<link href="{{ asset('css/reqbim.css') }}" rel="stylesheet">

{{-- Menggunakan layout utama aplikasi --}}
@extends('layouts.utama')

{{-- Menetapkan judul halaman --}}
@section('title', 'Riwayat Submit Dokumen')

{{-- Konten utama halaman --}}
@section('content')


{{-- Container Bootstrap untuk padding dan lebar responsif --}}
<div class="container py-4">


    {{-- Card utama untuk membungkus konten --}}
    <div class="card">

        {{-- 2. Header Section (Inside card) --}}


        {{-- Header card --}}

        <div class="px-4 py-3 border-bottom bg-white">
            <div class="d-flex justify-content-between align-items-center">
                <h1 class="h3 mb-0 text-gray-800">Riwayat Submit Dokumen</h1>
                {{-- Tombol untuk menambah data baru --}}
                <a href="{{ url('dokumen/create') }}" class="btn btn-primary">
                     + Tambah Data
                </a>
            </div>
        </div>


            {{-- 4. Sub-title untuk tabel --}}
            <p class="card-header">Daftar Dokumen Tersubmit</p>

                {{-- MODIFIKASI: Menghapus cellspacing dan menambah inline style --}}

        {{-- Body card (area konten tabel) --}}
        <div class="p-4 bg-light">

            {{-- Sub-judul untuk tabel --}}
            <p class="mb-3 text-muted">Daftar Dokumen Tersubmit</p>

            {{-- Tabel responsif --}}
            <div class="table-responsive">
                {{-- Tabel utama --}}
                {{-- MODIFIKASI ASLI: Anda menambahkan inline style border-spacing. --}}
                {{-- Perhatikan bahwa ini memberikan jarak antar sel. --}}
                {{-- Jika ingin tampilan standar Bootstrap, hapus style="...". --}}

                <table class="table table-striped table-hover mb-0" id="dataTableDokumen" width="100%"
                       style="border-collapse: separate; border-spacing: 1px;">
                    {{-- thead akan di-style oleh reqbim.css (kemungkinan) --}}
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
                        {{-- Loop untuk menampilkan data dokumen --}}
                        @forelse ($dokumens as $dokumen)
                        <tr>
                            <td class="text-center">{{ $loop->iteration }}</td>
                            <td>{{ $dokumen->nama ?? '-' }}</td>
                            <td>{{ $dokumen->prodi ?? '-' }}</td>
                            <td>{{ $dokumen->nomor_kelompok ?? '-' }}</td>
                            <td>
                                {{-- Menampilkan link ke dokumen jika ada --}}
                                @if($dokumen->dokumen)
                                <a href="{{ asset('storage/' . $dokumen->dokumen) }}" target="_blank">
                                    {{ basename($dokumen->dokumen) }}
                                </a>
                                @else
                                {{ basename($dokumen->dokumen) ?? '-' }} {{-- Jika dokumen null, tampilkan '-' --}}
                                @endif

                            </td>
                            {{-- Kolom Aksi --}}
                            <td class="text-center align-middle" style="white-space: nowrap;">
                                {{-- Tombol Edit: Menggunakan route dokumen.edit --}}
                                {{-- Ini memanggil metode edit di DokumenController --}}
                                <a href="{{ route('dokumen.edit', $dokumen->id) }}" class="btn btn-sm btn-warning mb-1" title="Edit">
                                    <i class="fas fa-edit"></i> Edit
                                </a>
                                {{-- Tombol Lihat: Menggunakan route dokumen.show --}}
                                {{-- Ini memanggil metode show di DokumenController --}}
                                <a href="{{ route('dokumen.show', $dokumen->id) }}" class="btn btn-sm btn-info mb-1" title="Lihat">
                                    <i class="fas fa-eye"></i> Lihat
                                </a>
                                {{-- Form Hapus: Menggunakan route dokumen.destroy --}}
                                {{-- Ini memanggil metode destroy di DokumenController --}}
                                {{-- Menggunakan POST dengan method DELETE --}}
                                {{-- Ada konfirmasi JavaScript sebelum submit --}}
                                <form action="{{ route('dokumen.destroy', $dokumen->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Yakin ingin menghapus data ini?');">
                                    @csrf {{-- Token CSRF untuk keamanan form --}}
                                    @method('DELETE') {{-- Mengoverride method POST menjadi DELETE --}}
                                    <button type="submit" class="btn btn-sm btn-danger mb-1" title="Hapus">
                                        <i class="fas fa-trash"></i> Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        {{-- Tampilkan pesan jika tidak ada data --}}
                        <tr>
                            <td colspan="7" class="text-center">Belum ada data dokumen yang disubmit.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div> {{-- End .table-responsive --}}

            {{-- Area Pagination --}}
            {{-- {{ $dokumens->links() }} --}} {{-- Baris pagination asli dikomentari --}}
            {{-- Jika Anda ingin pagination dari Laravel, hilangkan komentar di atas --}}
            {{-- Jika ingin pagination via DataTables, pastikan DataTables JS diaktifkan di @push('scripts') --}}
            <div class="mt-3 d-flex justify-content-center mb-0">
               {{-- Pagination dari Laravel akan muncul di sini jika diaktifkan --}}
            </div>

        </div> {{-- End .p-4 .bg-light --}}
    </div> {{-- End .card --}}

</div> {{-- Akhir .container --}}
@endsection

{{-- Menambahkan CSS tambahan ke section 'styles' layout --}}
@push('styles')
    {{-- Link CSS DataTables dikomentari. Jika Anda menggunakan DataTables, aktifkan ini. --}}
    {{-- <link href="{{ asset('vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet"> --}}
    <style>
        /* CSS Kustom jika diperlukan */
        .btn-sm i { /* Contoh styling ikon di tombol kecil */
            margin-right: 3px;
        }
        /* Jika Anda mempertahankan border-spacing, Anda mungkin perlu menyesuaikan padding */
        /* .table td, .table th { padding: 0.7rem; } */
    </style>
@endpush

{{-- Menambahkan JS tambahan ke section 'scripts' layout --}}
@push('scripts')
    {{-- Script DataTables atau script lain bisa ditambahkan di sini --}}
    {{-- Pastikan pustaka jQuery dan Bootstrap JS dimuat di layout utama sebelum script ini --}}
    {{-- Script DataTables JS dikomentari. Jika Anda menggunakan DataTables, aktifkan dan inisialisasi di sini. --}}
    {{-- <script src="{{ asset('vendor/datatables/jquery.dataTables.min.js') }}"></script> --}}
    {{-- <script src="{{ asset('vendor/datatables/dataTables.bootstrap4.min.js') }}"></script> --}}
    {{-- Script inisialisasi DataTables: --}}
    {{-- <script>
        $(document).ready(function() {
            $('#dataTableDokumen').DataTable(); // Inisialisasi DataTables pada tabel dengan ID 'dataTableDokumen'
        });
    </script> --}}
@endpush
