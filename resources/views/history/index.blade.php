@extends('layouts.utama') {{-- Sesuaikan dengan layout utama Anda --}}

{{-- Judul Halaman (bisa ditaruh di layout utama atau di sini) --}}
@section('title', 'Data Mahasiswa / Riwayat Bimbingan')

@section('content')
<div class="container py-4"> {{-- Container utama dengan padding --}}

    {{-- Baris Judul dan Tombol Tambah --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">Riwayat Bimbingan</h1> {{-- Judul Halaman Utama --}}
        <a href="{{ url('history/create') }}" class="btn btn-primary">+ Tambah Data</a> {{-- Tombol Tambah Data --}}
    </div>

    {{-- Card Utama untuk Konten --}}
    <div class="card shadow mb-4">

        {{-- Card Header: Tempatkan Form Pencarian di sini --}}
        <div class="card-header py-3">
            <form class="d-flex w-100" action="{{ url('history') }}" method="get">
                <input class="form-control me-2 flex-grow-1" {{-- me-2 untuk sedikit spasi --}}
                       type="search"
                       name="katakunci"
                       value="{{ Request::get('katakunci') }}" {{-- Pertahankan value --}}
                       placeholder="Cari berdasarkan topik, hasil, dll..."
                       aria-label="Search">
                <button class="btn btn-secondary" type="submit">Cari</button>
            </form>
        </div>

        {{-- Card Body: Tempatkan Tabel di sini --}}
        <div class="card-body">
            <div class="table-responsive"> {{-- Bungkus tabel agar responsif --}}
                <table class="table table-bordered table-striped" {{-- Tambahkan border --}}
                       id="dataTableHistory" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            {{-- Sesuaikan lebar kolom jika perlu, atau biarkan otomatis --}}
                            <th>No</th>
                            <th>Tanggal Bimbingan</th>
                            <th>Topik Bimbingan</th>
                            <th>Hasil Bimbingan</th>
                            <th>Rencana Berikutnya</th> {{-- Mengganti 'Tanggal Bimbingan' ke-2 --}}
                            <th>Jumlah Mahasiswa</th>
                            <th>Tanda Tangan Dosen</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        {{-- Gunakan @forelse untuk handle jika data kosong --}}
                        {{-- Pertahankan variabel $data dan $item --}}
                        @forelse ($data as $item)
                            <tr>
                                {{-- Nomor urut berdasarkan pagination --}}
                                <td>{{ $data->firstItem() + $loop->index }}</td>
                                <td>{{ $item->tanggal ? \Carbon\Carbon::parse($item->tanggal)->format('d-m-Y') : '-' }}</td> {{-- Format tanggal --}}
                                <td>{{ $item->topik ?? '-' }}</td>
                                <td>{{ Str::limit($item->hasil, 70) ?? '-' }}</td> {{-- Batasi panjang teks jika perlu --}}
                                <td>{{ $item->tanggal2 ? \Carbon\Carbon::parse($item->tanggal2)->format('d-m-Y') : '-' }}</td> {{-- Format tanggal rencana --}}
                                <td>{{ $item->jumlah ?? '-' }}</td>
                                <td>{{-- Kolom TTD Dosen (Isi sesuai kebutuhan, misal gambar/status) --}} - </td>
                                <td>


                                    {{-- Tombol Edit --}}
                                    <a href="{{ url('history/'.$item->id.'/edit') }}" class="btn btn-warning btn-sm" title="Edit">
                                        <i class="fas fa-edit"></i> {{-- Opsional: Ikon --}}
                                    </a>

                                    {{-- Tombol Delete (dalam form) --}}
                                    <form onsubmit="return confirm('Yakin akan menghapus data ini?')"
                                          class="d-inline" {{-- Agar tombol sebelahan --}}
                                          action="{{ url('history/'.$item->id) }}"
                                          method="post">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" title="Hapus">
                                             <i class="fas fa-trash"></i> {{-- Opsional: Ikon --}}
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            {{-- Tampilan jika $data kosong --}}
                            <tr>
                                <td colspan="8" class="text-center">Tidak ada data riwayat bimbingan ditemukan.</td> {{-- Colspan sesuai jumlah kolom --}}
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Tempatkan Pagination di bawah tabel dalam card-body --}}
            <div class="mt-3 d-flex justify-content-center">
                {{-- Pertahankan withQueryString agar filter pencarian ikut saat pindah halaman --}}
                {{ $data->withQueryString()->links() }}
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
    {{-- </script> --}}
@endpush
