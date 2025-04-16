{{-- resources/views/request_judul/index.blade.php --}}
{{-- Extend layout utama kamu jika ada --}}
<link href="{{ asset('css/custom-styles.css') }}" rel="stylesheet">

@extends('layouts.app')

{{-- @section('content') --}}
<div class="container"> {{-- Atau div lain sesuai layout --}}
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
                <th>Status</th>
                <th>Aksi</th>
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
                    <td>
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
                    <td>
                        <a href="{{ route('request-judul.show', $request->id) }}" class="btn btn-sm btn-info">Detail</a>
                        {{-- Tombol Edit (hanya untuk pembuat & jika status masih pending?) --}}
                        @can('update', $request) {{-- Jika menggunakan Policy --}}
                        {{-- @if(Auth::id() == $request->mahasiswa_id && ($request->status == 'Pending' || is_null($request->status))) --}}
                            <a href="{{ route('request-judul.edit', $request->id) }}" class="btn btn-sm btn-warning">Edit</a>
                        {{-- @endif --}}
                        @endcan

                        {{-- Tombol Hapus (hanya untuk pembuat atau admin?) --}}
                        @can('delete', $request) {{-- Jika menggunakan Policy --}}
                        {{-- @if(Auth::id() == $request->mahasiswa_id || Auth::user()->role == 'admin') --}}
                            <form action="{{ route('request-judul.destroy', $request->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus request ini?')">Hapus</button>
                            </form>
                        {{-- @endif --}}
                        @endcan

                         {{-- Tombol Approve/Reject (hanya untuk dosen yang dituju?) --}}
                         @if(Auth::user()->role == 'dosen' && Auth::id() == $request->dosen_id && ($request->status == 'Pending' || is_null($request->status)))
                            {{-- Buat route & method controller untuk approve/reject --}}
                            {{-- <form action="{{ route('request-judul.approve', $request->id) }}" method="POST" style="display:inline;">
                                @csrf @method('PATCH') <button type="submit" class="btn btn-sm btn-success">Setujui</button>
                            </form>
                            <form action="{{ route('request-judul.reject', $request->id) }}" method="POST" style="display:inline;">
                                @csrf @method('PATCH') <button type="submit" class="btn btn-sm btn-danger">Tolak</button>
                            </form> --}}
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
{{-- @endsection --}}
