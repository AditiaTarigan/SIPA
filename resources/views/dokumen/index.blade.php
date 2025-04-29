{{-- resources/views/dokumen/index.blade.php --}}

{{-- Pastikan file CSS ini ada dan sesuai. Sesuaikan jika Anda punya CSS spesifik seperti reqjudul.css --}}
<link href="{{ asset('css/reqbim.css') }}" rel="stylesheet">

@extends('layouts.utama') {{-- Sesuaikan dengan nama layout utama Anda --}}

@section('title', 'Riwayat Submit Dokumen') {{-- Menambahkan section title --}}

@section('content')
<div class="container py-4"> {{-- py-4 untuk padding atas-bawah --}}

    {{-- Header halaman dengan judul dan tombol --}}
    {{-- Menggunakan d-flex justify-content-between align-items-center mb-4 seperti referensi --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">Riwayat Submit Dokumen</h1> {{-- Judul --}}

        {{-- Tombol Tambah Data --}}
        {{-- href menggunakan url() seperti di kode awal Anda, tapi route() lebih disarankan --}}
        <a href="{{ url('dokumen/create') }}" class="btn btn-primary">
             + Tambah Data
        </a>
        {{-- Contoh alternatif menggunakan named route: --}}
        {{-- <a href="{{ route('dokumen.create') }}" class="btn btn-primary">+ Tambah Data</a> --}}
    </div>

    {{-- Card untuk membungkus tabel --}}
    <div class="card shadow mb-4">
        {{-- Header card --}}
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Daftar Dokumen Tersubmit</h6>
        </div>
        {{-- Body card - menambahkan p-0 untuk mepet ke pinggir seperti referensi --}}
        <div class="card-body p-0">
            <div class="table-responsive"> {{-- Membuat tabel responsif --}}
                {{-- Menambahkan table-hover seperti referensi --}}
                <table class="table table-bordered table-striped table-hover mb-0" id="dataTableDokumen" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th class="text-center">No.</th> {{-- Menggunakan "No." dan text-center --}}
                            <th class="text-center">Nama</th>
                            <th class="text-center">Prodi</th>
                            <th class="text-center">Nomor Kelompok</th>
                            <th class="text-center">Nama Dokumen</th>
                            <th class="text-center">Aksi</th> {{-- text-center di header --}}
                        </tr>
                    </thead>
                    <tbody>
                        {{-- Menggunakan @forelse untuk menangani jika $dokumens kosong --}}
                        @forelse ($dokumens as $index => $dokumen) {{-- Menggunakan $index untuk pagination numbering --}}
                        <tr>
                            {{-- Menampilkan nomor urut. Gunakan firstItem() + index jika menggunakan pagination. Jika tidak, pakai loop->iteration --}}
                            {{-- Asumsi saat ini menggunakan Dokumen::all() -> pakai loop->iteration --}}
                            <td>{{ $loop->iteration }}</td>

                            <td>{{ $dokumen->nama ?? '-' }}</td>
                            <td>{{ $dokumen->prodi ?? '-' }}</td>
                            <td>{{ $dokumen->nomor_kelompok ?? '-' }}</td>
                             {{-- Menampilkan hanya nama file dari path --}}
                            <td>{{ basename($dokumen->dokumen) ?? '-' }}</td>
                            {{-- Kolom Aksi - menambahkan text-center dan align-middle --}}
                            <td class="text-center align-middle">
                                {{-- Tombol Edit --}}
                                <a href="{{ route('dokumen.edit', $dokumen->id) }}" class="btn btn-sm btn-warning mb-1" title="Edit"> {{-- Menambahkan mb-1 --}}
                                    <i class="fas fa-edit"></i> Edit {{-- Hapus ikon jika tidak pakai FontAwesome --}}
                                </a>
                                {{-- Tombol Lihat Detail --}}
                                <a href="{{ route('dokumen.show', $dokumen->id) }}" class="btn btn-sm btn-info mb-1" title="Lihat"> {{-- Menambahkan mb-1 --}}
                                    <i class="fas fa-eye"></i> Lihat {{-- Hapus ikon jika tidak pakai FontAwesome --}}
                                </a>
                                {{-- Tombol Hapus --}}
                                {{-- Form action d-inline, menambahkan mb-1 pada button --}}
                                <form action="{{ route('dokumen.destroy', $dokumen->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Yakin ingin menghapus data ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger mb-1" title="Hapus"> {{-- Menambahkan mb-1 --}}
                                        <i class="fas fa-trash"></i> Hapus
                                    </button>
                                </form>
                                {{-- Opsional: Tambahkan kondisi @if atau @can untuk otorisasi di sini --}}
                                {{-- Contoh: @can('update', $dokumen) ... @endcan --}}
                                {{-- Contoh: @if(Auth::id() == $dokumen->user_id) ... @endif --}}
                            </td>
                        </tr>
                        @empty
                        {{-- Tampilan jika $dokumens kosong --}}
                        <tr>
                            {{-- Colspan harus sesuai jumlah kolom (ada 6 kolom: No., Nama, Prodi, NK, Nama Dokumen, Aksi) --}}
                            {{-- Menggunakan colspan="6" seperti sebelumnya --}}
                            <td colspan="6" class="text-center">Belum ada data dokumen yang disubmit.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

             {{-- Tampilkan link pagination jika menggunakan pagination pada $dokumens --}}
             {{-- Div mb-0 agar tidak ada margin bawah jika ini elemen terakhir di card-body --}}
             <div class="mt-3 d-flex justify-content-center mb-0">
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
         /* Tambahan CSS jika Anda ingin header card tanpa border bawah */
        /* .card-header {
            border-bottom: none;
        } */
    </style>
@endpush

@push('scripts')
    {{-- <script src="{{ asset('vendor/datatables/jquery.dataTables.min.js') }}"></script> --}}
    {{-- <script src="{{ asset('vendor/datatables/dataTables.bootstrap4.min.js') }}"></script> --}}
    {{-- <script> --}}
    {{-- $(document).ready(function() { --}}
    {{--     // Pastikan DataTableJS diinisialisasi setelah file JS-nya dimuat --}}
    {{--     $('#dataTableDokumen').DataTable({ --}}
    {{--         // Opsi DataTables jika perlu --}}
    {{--     }); --}}
    {{-- }); --}}
    {{-- </script> --}}
@endpush
