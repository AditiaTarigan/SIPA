{{-- Pastikan file CSS ini ada dan sesuai --}}
<link href="{{ asset('css/reqbim.css') }}" rel="stylesheet">

@extends('layouts.utama') {{-- Sesuaikan dengan nama layout utama Anda --}}

@section('content')
<div class="container py-4"> {{-- py-4 untuk padding atas-bawah --}}

    {{-- Baris untuk Judul Halaman dan Tombol Tambah --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        {{-- Judul utama halaman --}}
        <h1 class="h3 mb-0 text-gray-800">Riwayat Submit Dokumen</h1>

        {{-- Tombol Tambah Data --}}
        {{-- Anda bisa menambahkan kondisi @if jika tombol ini tidak selalu tampil --}}
        <a href="{{ url('dokumen/create') }}" class="btn btn-primary">
             + Tambah Data
        </a>
        {{-- Alternatif jika punya named route: --}}
        {{-- <a href="{{ route('dokumen.create') }}" class="btn btn-primary">+ Tambah Data</a> --}}
    </div>

    {{-- Card untuk membungkus tabel --}}
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            {{-- Judul di dalam card --}}
            <h6 class="m-0 font-weight-bold text-primary">Daftar Dokumen Tersubmit</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive"> {{-- Membuat tabel responsif --}}
                {{-- Hapus <form> yang membungkus tabel jika tidak diperlukan --}}
                <table class="table table-bordered table-striped" id="dataTableDokumen" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Nama</th>
                            <th>Prodi</th>
                            <th>Nomor Kelompok</th>
                            <th>Nama Dokumen</th> {{-- Mungkin maksudnya Nama File atau Keterangan? --}}
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        {{-- Menggunakan @forelse untuk menangani jika $dokumens kosong --}}
                        @forelse ($dokumens as $dokumen)  {{-- Tetap menggunakan $dokumens dan $dokumen --}}
                        <tr>
                            {{-- Pastikan objek $dokumen memiliki properti ini --}}
                            <td>{{ $dokumen->nama ?? '-' }}</td>
                            <td>{{ $dokumen->prodi ?? '-' }}</td>
                            <td>{{ $dokumen->nomor_kelompok ?? '-' }}</td>
                            <td>{{ $dokumen->dokumen ?? '-' }}</td> {{-- Sesuaikan jika ini nama file atau path --}}
                            <td>
                                {{-- Pastikan route 'submit_dokumen.edit' dan 'submit_dokumen.show' ada --}}
                                {{-- Tambahkan title untuk tooltip dan ikon jika diinginkan --}}
                                <a href="{{ route('dokumen.edit', $dokumen->id) }}" class="btn btn-sm btn-warning" title="Edit">
                                    <i class="fas fa-edit"></i> Edit {{-- Hapus ikon jika tidak pakai FontAwesome --}}
                                </a>
                                <a href="{{ route('dokumen.show', $dokumen->id) }}" class="btn btn-sm btn-info" title="Lihat">
                                    <i class="fas fa-eye"></i> Lihat {{-- Hapus ikon jika tidak pakai FontAwesome --}}
                                </a>
                                {{-- Tambahkan tombol lain jika perlu (misal: Hapus) --}}
                                <form action="{{ route('dokumen.destroy', $dokumen->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Yakin ingin menghapus data ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" title="Hapus">
                                        <i class="fas fa-trash"></i> Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        {{-- Tampilan jika $dokumens kosong --}}
                        <tr>
                            {{-- Colspan harus sesuai jumlah kolom (ada 5 kolom) --}}
                            <td colspan="5" class="text-center">Belum ada data dokumen yang disubmit.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

             {{-- Tampilkan link pagination jika menggunakan pagination pada $dokumens --}}
             <div class="mt-3 d-flex justify-content-center">
                {{-- Uncomment baris di bawah jika Anda mengirimkan data pagination dari controller ($dokumens = Model::paginate()) --}}
                {{-- {{ $dokumens->links() }} --}}
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
    {{--     $('#dataTableDokumen').DataTable(); // Inisialisasi DataTables jika digunakan --}}
    {{-- }); --}}
    {{-- </script> --}}
@endpush
