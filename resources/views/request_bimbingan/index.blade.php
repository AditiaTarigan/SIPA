{{-- File: resources/views/request_bimbingan/index.blade.php --}}
<link href="{{ asset('css/reqbim.css') }}" rel="stylesheet">

@extends('layouts.app') {{-- Use YOUR layout file --}}
@extends('layouts.utama') {{-- Use YOUR layout file --}}

@section('title', 'Daftar Request Bimbingan') {{-- Change title if desired --}}

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 colour="dark">Request Bimbingan</h1>
        {{-- Make sure the user role check is appropriate for who can create --}}
        @if(Auth::user()->role == 'mahasiswa')
             <a href="{{ route('request-bimbingan.create') }}" class="btn btn-primary">Buat Request Baru</a>
        @endif
    </div>

    <div class="card">
        <div class="card-header">Daftar Request</div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>No</th>
                            @if(Auth::user()->role != 'mahasiswa') {{-- Show student details if not a student view --}}
                                <th>NIM</th>
                                <th>Nama Mahasiswa</th>
                            @endif
                            <th>Tanggal</th>
                            <th>Jam</th>
                            <th>Bimbingan Ke</th>
                            <th>Lokasi</th>
                            <th>Tujuan Singkat</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($requestBimbingans as $index => $request)
                            <tr>
                                <td>{{ $requestBimbingans->firstItem() + $index }}</td> {{-- Pagination numbering --}}
                                 @if(Auth::user()->role != 'mahasiswa')
                                    <td>{{ $request->nim }}</td>
                                    <td>{{ $request->nama }}</td> {{-- Or $request->mahasiswa->name --}}
                                @endif
                                <td>{{ optional($request->tanggal_bimbingan)->format('d M Y') }}</td>
                                <td>{{ $request->jam_bimbingan ? \Carbon\Carbon::parse($request->jam_bimbingan)->format('H:i') : '-'}}</td>
                                <td>{{ $request->bimbingan_ke }}</td>
                                <td>{{ $request->lokasi }}</td>
                                <td>{{ Str::limit($request->tujuan_bimbingan, 50) }}</td>
                                <td>
                                    <a href="{{ route('request-bimbingan.show', $request->id) }}" class="btn btn-info btn-sm" title="Lihat Detail">
                                        <i class="fa fa-eye"></i> {{-- Example using Font Awesome --}}
                                    </a>
                                     {{-- Add authorization checks (e.g., using @can or policy) --}}
                                    @if(Auth::id() == $request->mahasiswa_id || Auth::user()->role == 'admin') {{-- Allow student owner or admin --}}
                                        <a href="{{ route('request-bimbingan.edit', $request->id) }}" class="btn btn-warning btn-sm" title="Edit">
                                             <i class="fa fa-edit"></i>
                                        </a>
                                        <form action="{{ route('request-bimbingan.destroy', $request->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus request ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm" title="Hapus">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        </form>
                                    @endif
                                     {{-- Add actions for Dosen (approve/reject) later --}}

                                </td>
                            </tr>
                        @empty
                            <tr>
                                {{-- Adjust colspan based on whether student columns are shown --}}
                                <td colspan="{{ Auth::user()->role != 'mahasiswa' ? '10' : '8' }}" class="text-center">Belum ada request bimbingan.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
         <div class="card-footer">
             {{-- Pagination Links --}}
            @if ($requestBimbingans->hasPages())
                {{ $requestBimbingans->links() }}
            @endif
        </div>
    </div>


@endsection
