<?php

namespace App\Http\Controllers;

use App\Models\RequestJudul;
use App\Models\User; // Import User model
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // Untuk mendapatkan user yang login
use Illuminate\Support\Facades\Gate; // Opsional: Untuk authorization

class RequestJudulController extends Controller
{
    /**
     * Menampilkan daftar request judul.
     * Mahasiswa hanya melihat requestnya sendiri.
     * Dosen melihat request yang ditujukan padanya.
     * Admin melihat semua request.
     */
    public function index()
    {
        $user = Auth::user();
        $query = RequestJudul::with(['mahasiswa', 'dosen'])->latest(); // Eager load relasi

        if ($user->role == 'mahasiswa') {
            $query->where('mahasiswa_id', $user->id);
        } elseif ($user->role == 'dosen') {
            $query->where('dosen_id', $user->id);
        }
        // Admin bisa melihat semua (tidak perlu filter tambahan)
        // Tambahkan validasi jika role tidak ada atau tidak sesuai

        $requests = $query->paginate(10); // Tampilkan 10 data per halaman

        return view('request_judul.index', compact('requests'));
    }

    /**
     * Menampilkan form untuk membuat request judul baru.
     * Hanya mahasiswa yang bisa mengakses ini.
     */
    public function create()
    {
        // Pastikan hanya mahasiswa yang bisa create
        $this->authorize('create', RequestJudul::class); // Cek method create di policy


        // Ambil daftar dosen untuk pilihan
        $dosens = User::where('role', 'dosen')->orderBy('name')->get();

        return view('request_judul.create', compact('dosens'));
    }

    /**
     * Menyimpan request judul baru ke database.
     */
    public function store(Request $request)
    {
         // Pastikan hanya mahasiswa yang bisa store
         $this->authorize('create', RequestJudul::class); // User harus bisa create


        // Validasi input
        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'dosen_id' => 'required|integer|exists:users,id,role,dosen', // Pastikan dosen_id ada di tabel users dan rolenya dosen
        ]);

        // Tambahkan mahasiswa_id dari user yang sedang login
        $validated['mahasiswa_id'] = Auth::id();

        // Buat record baru
        RequestJudul::create($validated);

        return redirect()->route('request-judul.index')
                         ->with('success', 'Request judul berhasil diajukan.'); // Pesan sukses
    }

    /**
     * Menampilkan detail spesifik request judul.
     * Implementasi authorization disarankan (misal: Policy)
     */
    public function show(RequestJudul $requestJudul)
    {

        $this->authorize('view', $requestJudul); //

        // Eager load relasi jika belum di-load (tergantung route model binding)
        $requestJudul->load(['mahasiswa', 'dosen']);

        // --- Authorization Check (Contoh Sederhana) ---
        $user = Auth::user();
        if ($user->role == 'mahasiswa' && $user->id != $requestJudul->mahasiswa_id) {
            abort(403); // Mahasiswa hanya boleh lihat requestnya sendiri
        }
        if ($user->role == 'dosen' && $user->id != $requestJudul->dosen_id) {
             abort(403); // Dosen hanya boleh lihat request yang ditujukan padanya
        }
        // Admin bisa lihat semua
        // --- End Authorization Check ---

        // !! Rekomendasi: Gunakan Laravel Policy untuk authorization yang lebih rapi !!
        // Gate::authorize('view', $requestJudul); // Jika menggunakan Policy

        return view('request_judul.show', compact('requestJudul'));
    }

    /**
     * Menampilkan form untuk mengedit request judul.
     * Biasanya hanya mahasiswa yang membuatnya yang bisa edit.
     */
    public function edit(RequestJudul $requestJudul)
    {
        $this->authorize('update', $requestJudul); // Memanggil method 'update' di RequestJudulPolicy

        // --- Authorization Check ---
        $user = Auth::user();
        // Hanya mahasiswa pembuat request yang boleh edit
        if ($user->role !== 'mahasiswa' || $user->id !== $requestJudul->mahasiswa_id) {
            abort(403, 'Anda tidak memiliki izin untuk mengedit request ini.');
        }
        // !! Rekomendasi: Gunakan Laravel Policy !!
        // Gate::authorize('update', $requestJudul);

        // Ambil daftar dosen untuk pilihan
        $dosens = User::where('role', 'dosen')->orderBy('name')->get();

        return view('request_judul.edit', compact('requestJudul', 'dosens'));
    }

    /**
     * Memperbarui request judul di database.
     */
    public function update(Request $request, RequestJudul $requestJudul)
    {
         // --- Authorization Check ---
         $this->authorize('update', $requestJudul); // Cek method update di policy

         // !! Rekomendasi: Gunakan Laravel Policy !!
         // Gate::authorize('update', $requestJudul);

         // Validasi input
         $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'dosen_id' => 'required|integer|exists:users,id,role,dosen',
         ]);

         // Update record
         $requestJudul->update($validated);

         return redirect()->route('request-judul.index')
                          ->with('success', 'Request judul berhasil diperbarui.');
    }

    /**
     * Menghapus request judul dari database.
     * Biasanya hanya mahasiswa pembuat atau admin yang bisa hapus.
     */
    public function destroy(RequestJudul $requestJudul)
    {

        $this->authorize('delete', $requestJudul); // Memanggil method 'delete' di RequestJudulPolicy

        // --- Authorization Check ---
        $user = Auth::user();
        // Hanya mahasiswa pembuat atau admin yang boleh hapus
        if (!($user->role === 'admin' || ($user->role === 'mahasiswa' && $user->id === $requestJudul->mahasiswa_id))) {
             abort(403, 'Anda tidak memiliki izin untuk menghapus request ini.');
        }
        // !! Rekomendasi: Gunakan Laravel Policy !!
        // Gate::authorize('delete', $requestJudul);

        // Hapus record
        $requestJudul->delete();

        return redirect()->route('request-judul.index')
                         ->with('success', 'Request judul berhasil dihapus.');
    }

    // --- Opsional: Metode untuk Approve/Reject oleh Dosen ---
    // public function approve(RequestJudul $requestJudul)
    // {
    //     Gate::authorize('approve', $requestJudul); // Perlu Policy/Gate
    //     // Logika untuk mengubah status request menjadi 'approved'
    //     // $requestJudul->update(['status' => 'approved']); // Perlu tambah kolom status di DB
    //     // Redirect atau return response
    // }

    // public function reject(RequestJudul $requestJudul)
    // {
    //     Gate::authorize('reject', $requestJudul); // Perlu Policy/Gate
    //     // Logika untuk mengubah status request menjadi 'rejected'
    //     // $requestJudul->update(['status' => 'rejected']); // Perlu tambah kolom status di DB
    //     // Redirect atau return response
    // }
}
