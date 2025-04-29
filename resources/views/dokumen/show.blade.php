    @extends('layouts.utama') {{-- Sesuaikan dengan nama layout utama Anda --}}

@section('title', 'Detail Dokumen') {{-- Opsional: Menentukan judul halaman --}}

@section('content')
<div class="container py-4">

    {{-- Judul Halaman --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">Detail Dokumen</h1>
    </div>

    {{-- Card untuk membungkus detail --}}
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            {{-- Judul di dalam card --}}
            <h6 class="m-0 font-weight-bold text-primary">Detail Dokumen #{{ $dokumen->id ?? '' }}</h6> {{-- Tampilkan ID dokumen --}}
        </div>
        <div class="card-body">
            {{-- Menggunakan Description List untuk detail --}}
            <dl class="row">
                <dt class="col-sm-3">ID Dokumen</dt>
                <dd class="col-sm-9">{{ $dokumen->id ?? '-' }}</dd>

                <dt class="col-sm-3">Nama</dt>
                <dd class="col-sm-9">{{ $dokumen->nama ?? '-' }}</dd>

                <dt class="col-sm-3">Prodi</dt>
                <dd class="col-sm-9">{{ $dokumen->prodi ?? '-' }}</dd>

                <dt class="col-sm-3">Nomor Kelompok</dt>
                <dd class="col-sm-9">{{ $dokumen->nomor_kelompok ?? '-' }}</dd>

                <dt class="col-sm-3">File Dokumen</dt>
                <dd class="col-sm-9">
                    @if ($dokumen->dokumen) {{-- Cek apakah ada path dokumen tersimpan --}}
                        {{-- Menggunakan Storage::url() untuk mendapatkan URL publik file --}}
                        {{-- Pastikan Anda sudah menjalankan 'php artisan storage:link' agar symlink 'public/storage' terbuat --}}
                        <a href="{{ Storage::url($dokumen->dokumen) }}" target="_blank">
                            {{-- Tampilkan nama file saja jika memungkinkan, atau path lengkap --}}
                            {{ basename($dokumen->dokumen) }} {{-- Menampilkan hanya nama file dari path --}}
                        </a>
                    @else
                        - Belum ada file -
                    @endif
                </dd>

                 <dt class="col-sm-3">Tanggal Submit</dt>
                 {{-- Asumsi Model memiliki timestamps (created_at) --}}
                 <dd class="col-sm-9">{{ $dokumen->created_at ? $dokumen->created_at->format('d M Y H:i:s') : '-' }}</dd>
            </dl>
        </div>
        <div class="card-footer">
             {{-- Tombol kembali ke halaman index --}}
             <a href="{{ route('dokumen.index') }}" class="btn btn-secondary">Kembali ke Riwayat</a>

             {{-- Tombol Edit --}}
             {{-- Pastikan route 'dokumen.edit' ada di web.php --}}
             <a href="{{ route('dokumen.edit', $dokumen->id) }}" class="btn btn-warning">Edit</a>

             {{-- Form Delete --}}
             {{-- Pastikan route 'dokumen.destroy' ada di web.php --}}
             <form action="{{ route('dokumen.destroy', $dokumen->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus dokumen ini?');">
                @csrf
                @method('DELETE') {{-- Method Spoofing untuk DELETE --}}
                <button type="submit" class="btn btn-danger">Hapus</button>
            </form>
        </div>
    </div>

</div> {{-- Akhir container --}}
@endsection

{{-- Opsional: Push CSS/JS jika diperlukan --}}
{{-- Biasanya tidak perlu CSS/JS tambahan untuk halaman show sederhana ini --}}
{{-- @push('styles') --}}
    {{-- Tambahkan CSS khusus jika ada --}}
{{-- @endpush --}}

{{-- @push('scripts') --}}
    {{-- Tambahkan JS khusus jika ada --}}
{{-- @endpush --}}
