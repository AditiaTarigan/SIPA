@extends('layouts.utama')

@section('content')

<link href="{{ asset('css/reqjudul.css') }}" rel="stylesheet">

<div class="container" padding="10px"> {{-- Atau div lain sesuai layout --}}
<h2>Daftar Request Judul Project Akhir</h2>

    {{-- Tampilkan pesan sukses jika ada --}}
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    {{-- Tombol untuk Tambah Request (biasanya hanya untuk mahasiswa) --}}
    @if(Auth::user()->role == 'mahasiswa')
        <div class="mb-3">
            <a href="{{ route('request-judul.create') }}" class="btn btn-primary">Ajukan Judul Baru</a>
        </div>
    @endif

    <table class="table table-striped table-bordered">
        <thead>
            <tr>
                <th>No.</th>
                {{-- Tampilkan Mahasiswa jika Dosen/Admin --}}
                @if(Auth::user()->role != 'mahasiswa')
                    <th>Nama Mahasiswa</th>
                @endif
                <th>Judul yang Diajukan</th>
                {{-- Tampilkan Dosen jika Mahasiswa/Admin --}}
                @if(Auth::user()->role != 'dosen')
                    <th>Dosen yang Dituju</th>
                @endif
                <th>Tanggal Pengajuan</th>
                {{-- Anda bisa menambahkan text-center di header juga jika mau --}}
                <th class="text-center">Status</th>
                <th class="text-center">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($requests as $index => $request)
                <tr>
                    {{-- Gunakan $loop->iteration untuk nomor otomatis dari pagination --}}
                    <td>{{ $requests->firstItem() + $index }}</td>

                    {{-- Tampilkan Mahasiswa jika Dosen/Admin --}}
                    @if(Auth::user()->role != 'mahasiswa')
                        {{-- Pastikan relasi 'mahasiswa' di-load di controller --}}
                        <td>{{ $request->mahasiswa->name ?? 'N/A' }}</td>
                    @endif

                    <td>{{ $request->judul }}</td>

                    {{-- Tampilkan Dosen jika Mahasiswa/Admin --}}
                    @if(Auth::user()->role != 'dosen')
                        {{-- Pastikan relasi 'dosen' di-load di controller --}}
                        <td>{{ $request->dosen->name ?? 'N/A' }}</td>
                    @endif

                    <td>{{ $request->created_at->format('d-m-Y H:i') }}</td>

                    {{-- === MODIFIKASI DI SINI === --}}
                    <td class="text-center align-middle">
                        {{-- Logika status (sesuaikan dengan kolom status di DB kamu) --}}
                        <span class="badge
                            @if ($request->status == 'Disetujui') bg-success
                            @elseif ($request->status == 'Ditolak') bg-danger
                            @else bg-warning text-dark {{-- Default: Pending --}}
                            @endif
                            ">
                            {{ $request->status ?? 'Pending' }} {{-- Tampilkan 'Pending' jika status null --}}
                        </span>
                    </td>

                    {{-- === MODIFIKASI DI SINI === --}}
                    <td class="text-center align-middle">
                        <a href="{{ route('request-judul.show', $request->id) }}" class="btn btn-sm btn-info mb-1">Detail</a> {{-- mb-1 untuk sedikit jarak jika tombol wrap --}}

                        {{-- Tombol Edit (hanya untuk pembuat & jika status masih pending?) --}}
                        @can('update', $request)
                            <a href="{{ route('request-judul.edit', $request->id) }}" class="btn btn-sm btn-warning mb-1">Edit</a>
                        @endcan

                        {{-- Tombol Hapus (hanya untuk pembuat atau admin?) --}}
                        @can('delete', $request)
                            <form action="{{ route('request-judul.destroy', $request->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger mb-1" onclick="return confirm('Yakin ingin menghapus request ini?')">Hapus</button>
                            </form>
                        @endcan

                        {{-- Tombol Approve/Reject (hanya untuk dosen yang dituju?) --}}
                        @if(Auth::user()->role == 'dosen' && Auth::id() == $request->dosen_id && ($request->status == 'Pending' || is_null($request->status)))
                            {{-- ... (Tombol Approve/Reject jika ada) ... --}}
                            {{-- Pastikan tombol-tombol ini juga diberi class mb-1 jika perlu --}}
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    {{-- Sesuaikan colspan dengan jumlah kolom --}}
                    <td colspan="{{ (Auth::user()->role != 'mahasiswa' ? 1 : 0) + (Auth::user()->role != 'dosen' ? 1 : 0) + 5 }}" class="text-center">
                        Belum ada data request judul.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    {{-- Tampilkan link pagination --}}
    {{ $requests->links() }}

</div>
@endsection

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
