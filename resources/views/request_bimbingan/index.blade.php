    <link href="{{ asset('css/reqbim.css') }}" rel="stylesheet">

    @extends('layouts.utama') {{-- Use YOUR layout file --}}


    @section('title', 'Daftar Request Bimbingan') {{-- Change title if desired --}}



    @section('content')
    <div class="card">
        <div class="d-flex justify-content-between align-items-center mb-3 request-bimbingan-header">
            {{-- Sesuaikan dengan layout yang Anda gunakan --}}
            {{-- <h1 class="text-dark">Request Bimbingan</h1> --}}
            {{-- Sesuaikan dengan layout yang Anda gunakan --}}
            <h1 colour="dark">Request Bimbingan</h1>
            {{-- Make sure the user role check is appropriate for who can create --}}
            @if(Auth::user()->role == 'mahasiswa')
                <a href="{{ route('request-bimbingan.create') }}" class="btn btn-primary mb-3">Ajukan Bimbingan Baru</a>
            @endif
        </div>

        <div class="card">
            <div class="card-header">Daftar Request Bimbingan Sebelumnya</div>
            <div class="card-body p-0">
                <div class="table-responsive">
            <table class="table table-striped table-hover table-bordered mb-0">
                <thead>
                            <tr>
                                <th class="text-center">No</th>
                                @if(Auth::user()->role != 'mahasiswa') {{-- Show student details if not a student view --}}
                                    <th class="text-center">NIM</th>
                                    <th class="text-center">Nama Mahasiswa</th>
                                @endif
                                <th class="text-center">Tanggal</th>
                                <th class="text-center">Jam</th>
                                <th class="text-center">Bimbingan Ke</th>
                                <th class="text-center">Lokasi</th>
                                <th class="text-center">Tujuan Singkat</th>
                                <th class="text-center">Status</th>
                                <th class="text-center">Aksi</th>
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

                                    <td class="text-center align-middle">
                                        <a href="{{ route('request-bimbingan.show', $request->id) }}" class="btn btn-sm btn-info mb-1">Detail</a> {{-- mb-1 untuk sedikit jarak jika tombol wrap --}}


                                        {{-- Add authorization checks (e.g., using @can or policy) --}}
                                        @if(Auth::id() == $request->mahasiswa_id || Auth::user()->role == 'admin') {{-- Allow student owner or admin --}}
                                        <a href="{{ route('request-bimbingan.edit', $request->id) }}" class="btn btn-sm btn-warning mb-1">Edit</a>

                                            <form action="{{ route('request-bimbingan.destroy', $request->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus request ini?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger mb-1" onclick="return confirm('Yakin ingin menghapus request ini?')">Hapus</button>
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
        </div>
    </div>

    @endsection
