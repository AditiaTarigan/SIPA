{{-- resources/views/request_bimbingan/index.blade.php --}}
@extends('layouts.utama') {{-- Sesuaikan dengan nama layout utama Anda --}}

@section('content')
<div class="container py-4"> {{-- py-4 untuk padding atas-bawah --}}

    {{-- Baris untuk Judul Halaman dan Tombol --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">Request Bimbingan</h1> {{-- Judul utama halaman --}}

        {{-- Tampilkan tombol hanya jika pengguna adalah mahasiswa (contoh) --}}
        {{-- Sesuaikan kondisi ini jika perlu (misal, cek role dari Auth::user()->role) --}}
        @if(Auth::check() && Auth::user()->role == 'mahasiswa')
            {{-- Pastikan Anda memiliki route bernama 'request-bimbingan.create' --}}
            <a href="{{ route('request-bimbingan.create') }}" class="btn btn-primary">
                Buat Request Baru
            </a>
        @endif
    </div>

    {{-- Card untuk membungkus tabel --}}
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Daftar Request</h6> {{-- Judul di dalam card --}}
        </div>
        <div class="card-body">
            <div class="table-responsive"> {{-- Membuat tabel responsif --}}
                <table class="table table-bordered table-striped" id="dataTableBimbingan" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Tanggal</th>
                            <th>Jam</th>
                            <th>Bimbingan Ke</th>
                            <th>Lokasi</th>
                            <th>Tujuan Singkat</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        {{-- Menggunakan variabel $requests (sesuai permintaan) --}}
                        @forelse ($requests as $index => $request)
                            <tr>
                                {{-- Gunakan $loop->iteration jika tidak pakai pagination, atau sesuaikan jika pakai --}}
                                {{-- Jika pakai pagination: <td>{{ $requests->firstItem() + $index }}</td> --}}
                                <td>{{ $loop->iteration }}</td>

                                {{-- Asumsi nama kolom di database/model: tanggal, jam, bimbingan_ke, lokasi, tujuan_singkat --}}
                                {{-- Gunakan Carbon untuk formatting jika kolomnya tipe date/time --}}
                                <td>{{ $request->tanggal ? \Carbon\Carbon::parse($request->tanggal)->format('d-m-Y') : '-' }}</td>
                                <td>{{ $request->jam ? \Carbon\Carbon::parse($request->jam)->format('H:i') : '-' }}</td>
                                <td>{{ $request->bimbingan_ke ?? '-' }}</td>
                                <td>{{ $request->lokasi ?? '-' }}</td>
                                <td>{{ Str::limit($request->tujuan_singkat, 50) ?? '-' }}</td> {{-- Batasi panjang teks jika perlu --}}
                                <td>
                                    {{-- Tombol Aksi (Contoh: Detail) --}}
                                    {{-- Pastikan Anda memiliki route bernama 'request-bimbingan.show' --}}
                                    <a href="{{ route('request-bimbingan.show', $request->id) }}" class="btn btn-info btn-sm" title="Detail">
                                        <i class="fas fa-eye"></i> {{-- Ganti dengan ikon atau teks 'Detail' --}}
                                    </a>

                                    {{-- Tambahkan tombol aksi lain sesuai kebutuhan (Edit, Hapus, Approve, Reject) --}}
                                    {{-- Contoh Tombol Edit (jika diizinkan) --}}
                                    {{-- @can('update', $request) --}}
                                    {{-- <a href="{{ route('request-bimbingan.edit', $request->id) }}" class="btn btn-warning btn-sm" title="Edit"> --}}
                                    {{--     <i class="fas fa-edit"></i> --}}
                                    {{-- </a> --}}
                                    {{-- @endcan --}}

                                    {{-- Contoh Tombol Hapus (jika diizinkan) --}}
                                    {{-- @can('delete', $request) --}}
                                    {{-- <form action="{{ route('request-bimbingan.destroy', $request->id) }}" method="POST" style="display: inline;"> --}}
                                    {{--     @csrf --}}
                                    {{--     @method('DELETE') --}}
                                    {{--     <button type="submit" class="btn btn-danger btn-sm" title="Hapus" onclick="return confirm('Yakin ingin menghapus request ini?')"> --}}
                                    {{--         <i class="fas fa-trash"></i> --}}
                                    {{--     </button> --}}
                                    {{-- </form> --}}
                                    {{-- @endcan --}}
                                </td>
                            </tr>
                        @empty
                            {{-- Tampilan jika variabel $requests kosong --}}
                            <tr>
                                <td colspan="7" class="text-center">Belum ada request bimbingan.</td> {{-- Pastikan colspan sesuai jumlah kolom --}}
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Tampilkan link pagination jika menggunakan pagination pada $requests --}}
             <div class="mt-3 d-flex justify-content-center">
                {{-- Uncomment baris di bawah jika Anda mengirimkan data pagination dari controller --}}
                {{-- {{ $requests->links() }} --}}
             </div>

        </div> {{-- Akhir card-body --}}
    </div> {{-- Akhir card --}}

</div> {{-- Akhir container --}}
@endsection

{{-- Opsional: Push CSS/JS jika diperlukan (misal untuk DataTables) --}}
@push('styles')
    {{-- <link href="{{ asset('vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet"> --}}
    <style>
        /* CSS Kustom jika diperlukan */
    </style>
@endpush

@push('scripts')
    {{-- <script src="{{ asset('vendor/datatables/jquery.dataTables.min.js') }}"></script> --}}
    {{-- <script src="{{ asset('vendor/datatables/dataTables.bootstrap4.min.js') }}"></script> --}}
    {{-- <script> --}}
    {{-- $(document).ready(function() { --}}
    {{--     $('#dataTableBimbingan').DataTable(); // Inisialisasi DataTables jika digunakan --}}
    {{-- }); --}}
    {{-- </script> --}}
@endpush
