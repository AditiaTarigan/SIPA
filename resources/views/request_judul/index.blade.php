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
