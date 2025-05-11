{{-- resources/views/log_activities/show.blade.php --}}

{{-- Menggunakan layout utama aplikasi. Sesuaikan dengan nama layout utama Anda jika berbeda. --}}
@extends('layouts.utama')

{{-- Menetapkan judul halaman. --}}
@section('title', 'Detail Log Activity')

{{-- Konten utama halaman --}}
@section('content')
<div class="container py-4"> {{-- Tambahkan container jika belum ada di layout --}}

    {{-- Judul Halaman --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">Detail Log Activity</h1>
    </div>

    {{-- Card untuk membungkus detail log activity --}}
    <div class="card shadow mb-4">
        {{-- Header card --}}
        <div class="card-header py-3">
            {{-- Judul di dalam card. Tampilkan ID log activity jika ada. --}}
            <h6 class="m-0 font-weight-bold text-primary">Detail Log Activity #{{ $logActivity->id ?? '' }}</h6>
        </div>
        {{-- Body card (area detail log activity) --}}
        <div class="card-body">
            {{-- Menggunakan Description List (dl) untuk menampilkan pasangan label-nilai --}}
            <dl class="row">
                {{-- Menampilkan ID Log Activity --}}
                <dt class="col-sm-3">ID Log</dt>
                <dd class="col-sm-9">{{ $logActivity->id ?? '-' }}</dd>

                {{-- Menampilkan ID Mahasiswa (jika perlu, asumsikan relasi LogActivity belongsTo User/Mahasiswa) --}}
                 @if ($logActivity->mahasiswa_id)
                 <dt class="col-sm-3">ID Mahasiswa</dt>
                 <dd class="col-sm-9">{{ $logActivity->mahasiswa_id }}</dd>
                 @endif
                 {{-- Atau jika ada relasi dan Anda ingin menampilkan nama mahasiswa --}}
                 {{-- @if ($logActivity->mahasiswa)
                 <dt class="col-sm-3">Mahasiswa</dt>
                 <dd class="col-sm-9">{{ $logActivity->mahasiswa->nama }}</dd>
                 @endif --}}


                {{-- Menampilkan Nama (dari form, bukan dari relasi mahasiswa) --}}
                <dt class="col-sm-3">Nama Mahasiswa (Input)</dt>
                <dd class="col-sm-9">{{ $logActivity->nama ?? '-' }}</dd>

                {{-- Menampilkan Prodi --}}
                <dt class="col-sm-3">Prodi</dt>
                <dd class="col-sm-9">{{ $logActivity->prodi ?? '-' }}</dd>

                {{-- Menampilkan Nomor Kelompok --}}
                <dt class="col-sm-3">Nomor Kelompok</dt>
                <dd class="col-sm-9">{{ $logActivity->no_kelompok ?? '-' }}</dd> {{-- Menggunakan no_kelompok sesuai model Anda --}}

                {{-- Menampilkan Link File Log --}}
                <dt class="col-sm-3">File Log</dt>
                <dd class="col-sm-9">
                    @if ($logActivity->file_log) {{-- Cek apakah ada nama file tersimpan --}}
                        {{-- Menggunakan asset() untuk URL publik file yang disimpan di storage/app/public/logs --}}
                        {{-- Pastikan Anda sudah menjalankan 'php artisan storage:link' --}}
                        <a href="{{ asset('storage/logs/' . $logActivity->file_log) }}" target="_blank">
                            {{-- Menampilkan hanya nama file --}}
                            {{ $logActivity->file_log }}
                        </a>
                    @else
                        - Belum ada file -
                    @endif
                </dd>

                 {{-- Menampilkan Tanggal Submit (created_at atau submitted_at) --}}
                 {{-- Berdasarkan controller, sepertinya Anda menyimpan timestamp submit di created_at atau field lain --}}
                 {{-- Kode controller store/update tidak secara eksplisit mengisi 'submitted_at', jadi kemungkinan itu adalah created_at --}}
                 {{-- Jika Anda memang punya kolom 'submitted_at' dan diisi saat create/update, gunakan itu. Jika tidak, gunakan created_at. --}}
                 {{-- Saya akan gunakan $logActivity->created_at karena lebih umum terisi otomatis oleh Eloquent --}}
                 <dt class="col-sm-3">Tanggal Submit</dt>
                 {{-- Menggunakan format tanggal dan waktu. Memberi nilai default jika created_at null. --}}
                 <dd class="col-sm-9">{{ $logActivity->created_at ? $logActivity->created_at->format('d M Y H:i:s') : '-' }}</dd>
            </dl>
        </div>
        {{-- Footer card dengan tombol aksi --}}
        <div class="card-footer">
             {{-- Tombol kembali ke halaman index log activities --}}
             {{-- Menggunakan route log_activities.index --}}
             <a href="{{ route('log_activities.index') }}" class="btn btn-secondary">Kembali ke Riwayat</a>

             {{-- Tombol Edit --}}
             {{-- Menggunakan route log_activities.edit dan melewatkan objek $logActivity --}}
             <a href="{{ route('log_activities.edit', $logActivity) }}" class="btn btn-warning">Edit</a>

             {{-- Form Delete --}}
             {{-- Menggunakan route log_activities.destroy dan melewatkan ID log activity --}}
             {{-- Menggunakan method POST dengan spoofing DELETE, dan konfirmasi JS. --}}
             <form action="{{ route('log_activities.destroy', $logActivity->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus log ini?');">
                @csrf {{-- Token CSRF untuk keamanan --}}
                @method('DELETE') {{-- Mengoverride method POST menjadi DELETE --}}
                <button type="submit" class="btn btn-danger">Hapus</button>
            </form>
        </div>
    </div>

</div> {{-- Akhir container --}}
@endsection

{{-- Opsional: Push CSS/JS jika diperlukan --}}
{{-- @push('styles') --}}
    {{-- Tambahkan CSS khusus jika ada --}}
{{-- @endpush --}}

{{-- @push('scripts') --}}
    {{-- Tambahkan JS khusus jika ada --}}
{{-- @endpush --}}
