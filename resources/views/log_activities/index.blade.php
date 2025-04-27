{{-- Pastikan file CSS ini ada dan sesuai --}}
<link href="{{ asset('css/log_activities.css') }}" rel="stylesheet">

@extends('layouts.utama') {{-- Sesuaikan dengan nama layout utama Anda --}}

@section('content')
<div class="container py-4"> {{-- py-4 untuk padding atas-bawah --}}

    {{-- Baris untuk Judul Halaman dan Tombol Tambah --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        {{-- Judul utama halaman --}}
        <h1 class="h3 mb-0 text-gray-800">Riwayat Submit Log Activities</h1>

        {{-- Tombol Tambah Data --}}
        {{-- Anda bisa menambahkan kondisi @if jika tombol ini tidak selalu tampil --}}
        <a href="{{ route('log_activities.create') }}" class="btn btn-primary">
             + Tambah Data
        </a>
        {{-- Alternatif jika punya named route: --}}
        {{-- <a href="{{ route('log_activities.create') }}" class="btn btn-primary">+ Tambah Data</a> --}}
    </div>

    {{-- Card untuk membungkus tabel --}}
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            {{-- Judul di dalam card --}}
            <h6 class="m-0 font-weight-bold text-primary">Daftar Log Activities</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive"> {{-- Membuat tabel responsif --}}
                {{-- Hapus <form> yang membungkus tabel jika tidak diperlukan --}}
                <table class="table table-bordered table-striped" id="dataTableLogActivities" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Nama</th>
                            <th>Prodi</th>
                            <th>Nomor Kelompok</th>
                            <th>File Log</th>
                            <th>Tanggal Submit</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        {{-- Menggunakan @forelse untuk menangani jika $logActivities kosong --}}
                        @forelse ($logActivities as $logActivity)
                        <tr>
                            {{-- Pastikan objek $logActivity memiliki properti ini --}}
                            <td>{{ $logActivity->nama ?? '-' }}</td>
                            <td>{{ $logActivity->prodi ?? '-' }}</td>
                            <td>{{ $logActivity->no_kelompok ?? '-' }}</td>
                            <td>
                                <a href="{{ asset('storage/logs/' . $logActivity->file_log) }}" target="_blank">
                                    {{ $logActivity->file_log ?? '-' }}
                                </a>
                            </td>
                            <td>{{ $logActivity->submitted_at ? $logActivity->submitted_at->format('d-m-Y H:i:s') : '-' }}</td>
                            <td>
                                {{-- Pastikan route 'log_activities.edit' dan 'log_activities.show' ada --}}
                                {{-- Tambahkan title untuk tooltip dan ikon jika diinginkan --}}
                                <a href="{{ route('log_activities.edit', $logActivity->id) }}" class="btn btn-sm btn-warning" title="Edit">
                                    <i class="fas fa-edit"></i> Edit {{-- Hapus ikon jika tidak pakai FontAwesome --}}
                                </a>
                                <a href="{{ route('log_activities.show', $logActivity->id) }}" class="btn btn-sm btn-info" title="Lihat">
                                    <i class="fas fa-eye"></i> Lihat {{-- Hapus ikon jika tidak pakai FontAwesome --}}
                                </a>
                                {{-- Tambahkan tombol lain jika perlu (misal: Hapus) --}}
                                <form action="{{ route('log_activities.destroy', $logActivity->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Yakin ingin menghapus data ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" title="Hapus">
                                        <i class="fas fa-trash"></i> Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        {{-- Tampilan jika $logActivities kosong --}}
                        <tr>
                            {{-- Colspan harus sesuai jumlah kolom (ada 6 kolom) --}}
                            <td colspan="6" class="text-center">Belum ada data log activities yang disubmit.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

             {{-- Tampilkan link pagination jika menggunakan pagination pada $logActivities --}}
             <div class="mt-3 d-flex justify-content-center">
                {{-- Uncomment baris di bawah jika Anda mengirimkan data pagination dari controller ($logActivities = Model::paginate()) --}}
                {{ $logActivities->links() }}
             </div>

        </div> {{-- Akhir card-body --}}
    </div> {{-- Akhir card --}}

</div> {{-- Akhir container --}}
@endsection

{{-- Opsional: Push CSS/JS jika diperlukan --}}
@push('styles')
    {{-- <link href="{{ asset('vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet"> --}}
    <style>
        /* CSS Kustom jika diperlukan */
        .btn-sm i { /* Contoh styling ikon di tombol kecil */
            margin-right: 3px;
        }
    </style>
@endpush

@push('scripts')
    {{-- <script src="{{ asset('vendor/datatables/jquery.dataTables.min.js') }}"></script> --}}
    {{-- <script src="{{ asset('vendor/datatables/dataTables.bootstrap4.min.js') }}"></script> --}}
    {{-- <script> --}}
    {{-- $(document).ready(function() { --}}
    {{--     $('#dataTableLogActivities').DataTable(); // Inisialisasi DataTables jika digunakan --}}
    {{-- }); --}}
    {{-- </script> --}}
@endpush
