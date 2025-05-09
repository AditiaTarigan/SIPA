{{-- Menggunakan layout utama aplikasi. Sesuaikan dengan nama layout utama Anda jika berbeda. --}}
@extends('layouts.utama')

{{-- Menetapkan judul halaman. Menggunakan nama file dokumen jika tersedia. --}}
@section('title', 'Detail Dokumen' . (isset($dokumen->dokumen) ? ': ' . basename($dokumen->dokumen) : ''))

{{-- Konten utama halaman --}}
@section('content')
<div class="container py-4">

    {{-- Judul Halaman --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">Detail Dokumen</h1>
    </div>

    {{-- Card untuk membungkus detail dokumen --}}
    <div class="card shadow mb-4">
        {{-- Header card --}}
        <div class="card-header py-3">
            {{-- Judul di dalam card. Tampilkan ID dokumen jika ada. --}}
            <h6 class="m-0 font-weight-bold text-primary">Detail Dokumen #{{ $dokumen->id ?? '' }}</h6>
        </div>
        {{-- Body card (area detail dokumen) --}}
        <div class="card-body">
            {{-- Menggunakan Description List (dl) untuk menampilkan pasangan label-nilai --}}
            <dl class="row">
                {{-- Menampilkan ID Dokumen --}}
                <dt class="col-sm-3">ID Dokumen</dt>
                <dd class="col-sm-9">{{ $dokumen->id ?? '-' }}</dd>

                {{-- Menampilkan Nama --}}
                <dt class="col-sm-3">Nama</dt>
                <dd class="col-sm-9">{{ $dokumen->nama ?? '-' }}</dd>

                {{-- Menampilkan Prodi --}}
                <dt class="col-sm-3">Prodi</dt>
                <dd class="col-sm-9">{{ $dokumen->prodi ?? '-' }}</dd>

                {{-- Menampilkan Nomor Kelompok --}}
                <dt class="col-sm-3">Nomor Kelompok</dt>
                <dd class="col-sm-9">{{ $dokumen->nomor_kelompok ?? '-' }}</dd>

                {{-- Menampilkan Link File Dokumen --}}
                <dt class="col-sm-3">File Dokumen</dt>
                <dd class="col-sm-9">
                    @if ($dokumen->dokumen) {{-- Cek apakah ada path dokumen tersimpan --}}
                        {{-- Menggunakan Storage::url() untuk mendapatkan URL publik file --}}
                        {{-- Pastikan Anda sudah menjalankan 'php artisan storage:link' agar symlink 'public/storage' terbuat --}}
                        <a href="{{ Storage::url($dokumen->dokumen) }}" target="_blank">
                            {{-- Menampilkan hanya nama file dari path lengkap --}}
                            {{ basename($dokumen->dokumen) }}
                        </a>
                    @else
                        - Belum ada file -
                    @endif
                </dd>

                 {{-- Menampilkan Tanggal Submit (created_at) --}}
                 <dt class="col-sm-3">Tanggal Submit</dt>
                 {{-- Menggunakan format tanggal dan waktu. Memberi nilai default jika created_at null. --}}
                 <dd class="col-sm-9">{{ $dokumen->created_at ? $dokumen->created_at->format('d M Y H:i:s') : '-' }}</dd>
            </dl>
        </div>
        {{-- Footer card dengan tombol aksi --}}
        <div class="card-footer">
             {{-- Tombol kembali ke halaman index riwayat dokumen --}}
             {{-- Menggunakan route dokumen.index --}}
             <a href="{{ route('dokumen.index') }}" class="btn btn-secondary">Kembali ke Riwayat</a>

             {{-- Tombol Edit --}}
             {{-- Menggunakan route dokumen.edit dan melewatkan objek $dokumen --}}
             {{-- Kode ini sudah benar. Jika error parameter {dokuman} masih muncul, itu karena DEFINISI ROUTE yang salah (bukan di sini). --}}
             <a href="{{ route('dokumen.edit', $dokumen) }}" class="btn btn-warning">Edit</a>

             {{-- Form Delete --}}
             {{-- Menggunakan route dokumen.destroy dan melewatkan ID dokumen --}}
             {{-- Menggunakan method POST dengan spoofing DELETE, dan konfirmasi JS. --}}
             {{-- Kode ini juga sudah standar dan benar. --}}
             <form action="{{ route('dokumen.destroy', $dokumen->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus dokumen ini?');">
                @csrf {{-- Token CSRF untuk keamanan --}}
                @method('DELETE') {{-- Mengoverride method POST menjadi DELETE --}}
                <button type="submit" class="btn btn-danger">Hapus</button>
            </form>
        </div>
    </div>

</div> {{-- Akhir container --}}
@endsection

{{-- Opsional: Push CSS/JS jika diperlukan --}}
{{-- Biasanya tidak perlu CSS/JS tambahan untuk halaman show sederhana ini, kecuali ada kebutuhan spesifik. --}}
{{-- @push('styles') --}}
    {{-- Tambahkan CSS khusus jika ada --}}
{{-- @endpush --}}

{{-- @push('scripts') --}}
    {{-- Tambahkan JS khusus jika ada --}}
{{-- @endpush --}}
