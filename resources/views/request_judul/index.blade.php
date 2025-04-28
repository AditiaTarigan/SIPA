<link rel="stylesheet" href="{{ asset('css/reqjudul.css') }}">

@extends('layouts.utama')

@section('title', 'Daftar Request Judul') {{-- Change title if desired --}}

@section('content')
<div class="card">
<div class="d-flex justify-content-between align-items-center mb-3 request-judul-header">
    {{-- Sesuaikan dengan layout yang Anda gunakan --}}
    <h1 colour="dark">Request Judul</h1>
    {{-- Make sure the user role check is appropriate for who can create --}}
    @if(Auth::user()->role == 'mahasiswa')
         <a href="{{ route('request-judul.create') }}" class="btn btn-primary mb-3">Ajukan Judul Baru</a>
    @endif
    </div>

    <div class="card">
        <div class="card-header">Daftar Request Judul Sebelumnya</div>
        <div class="card-body p-0">
            <div class="table-responsive">
           <table class="table table-striped table-hover table-bordered mb-0">
            <thead>
            <tr>
                <th class="text-center">No.</th>
                {{-- Tampilkan Mahasiswa jika Dosen/Admin --}}
                @if(Auth::user()->role != 'mahasiswa')
                    <th class="text-center">Nama Mahasiswa</th>
                @endif
                <th class="text-center">Judul yang Diajukan</th>
                {{-- Tampilkan Dosen jika Mahasiswa/Admin --}}
                @if(Auth::user()->role != 'dosen')
                    <th class="text-center">Dosen yang Dituju</th>
                @endif
                <th class="text-center">Tanggal Pengajuan</th>
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


</div>
@endsection
