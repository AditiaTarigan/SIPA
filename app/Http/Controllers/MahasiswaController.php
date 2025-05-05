<?php

namespace App\Http\Controllers;

use App\Models\Mahasiswa; // Pastikan namespace Model benar
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session; // Session masih bisa digunakan untuk flash messages (sukses/gagal)
use Illuminate\Validation\Rule; // Diperlukan untuk validasi unique saat update

class MahasiswaController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\View
     */
    public function index(Request $request)
    {
        $katakunci = $request->katakunci;
        $jumlahbaris = 5; // Sesuaikan jumlah item per halaman jika perlu

        // Query dasar
        $query = Mahasiswa::query(); // Mulai dengan query builder

        if (strlen($katakunci)) {
            // Tambahkan kondisi pencarian untuk semua field yang relevan
            $query->where(function($q) use ($katakunci) {
                $q->where('nim', 'like', "%$katakunci%")
                  ->orWhere('nama', 'like', "%$katakunci%") // Tambahkan pencarian nama
                  ->orWhere('prodi', 'like', "%$katakunci%")
                  ->orWhere('nomor_kelompok', 'like', "%$katakunci%") // Tambahkan pencarian nomor kelompok
                  ->orWhere('dosen_pembimbing', 'like', "%$katakunci%") // Tambahkan pencarian dosen
                  ->orWhere('angkatan', 'like', "%$katakunci%");
            });
        }

        // Ambil data dengan paginasi dan urutkan (misalnya berdasarkan nama)
        $data = $query->orderBy('angkatan', 'asc')      // Urutan utama: Angkatan ASC
                     ->orderBy('nomor_kelompok', 'asc') // Urutan sekunder: No Kelompok ASC
                     ->paginate($jumlahbaris);         // Ambil data dengan paginasi SETELAH diurutkan

        return view('mahasiswa.index', compact('data')); // Gunakan compact lebih ringkas
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function create()
    {
        return view('mahasiswa.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        // Hapus Session::flash manual, biarkan validasi Laravel menangani old input
        // Session::flash('nim',$request->nim);
        // Session::flash('nama',$request->nama);
        // ... dst ...

        // Validasi data input, termasuk field baru
        $validatedData = $request->validate([
            'nim' => 'required|numeric|unique:mahasiswa,nim', // Pastikan nama tabel benar ('mahasiswa' atau 'mahasiswas')
            'nama' => 'required|string|max:255',
            'prodi' => 'required|string|max:100', // Sesuaikan max length jika perlu
            'nomor_kelompok' => 'required|string|max:50', // Sesuaikan tipe dan max length
            'dosen_pembimbing' => 'required|string|max:255',
            'angkatan' => 'required|numeric|digits:4', // Misal: Angkatan harus 4 digit
        ], [
            // Pesan error kustom
            'nim.required' => 'NIM wajib diisi',
            'nim.numeric' => 'NIM wajib berupa angka',
            'nim.unique' => 'NIM sudah terdaftar',
            'nama.required' => 'Nama wajib diisi',
            'nama.string' => 'Nama harus berupa teks',
            'nama.max' => 'Nama maksimal 255 karakter',
            'prodi.required' => 'Prodi wajib diisi',
            'nomor_kelompok.required' => 'Nomor Kelompok wajib diisi',
            'dosen_pembimbing.required' => 'Dosen Pembimbing wajib diisi',
            'angkatan.required' => 'Angkatan wajib diisi',
            'angkatan.numeric' => 'Angkatan wajib berupa angka',
            'angkatan.digits' => 'Angkatan harus 4 digit angka',
        ]);

        // Buat data baru menggunakan mass assignment
        // Pastikan field ada di $fillable model Mahasiswa
        try {
            Mahasiswa::create($validatedData);
            return redirect()->route('mahasiswa.index') // Gunakan route name jika ada
                         ->with('success', 'Data mahasiswa berhasil ditambahkan.');
        } catch (\Exception $e) {
             // Tangani potensi error database
             // Log error: Log::error('Error creating mahasiswa: '.$e->getMessage());
             return redirect()->back()
                          ->withInput() // Kembalikan input sebelumnya
                          ->with('error', 'Gagal menambahkan data. Silakan coba lagi.');
        }
    }

    /**
     * Display the specified resource.
     * (Method ini opsional jika Anda tidak memiliki halaman detail spesifik)
     *
     * @param string $id (NIM)
     * @return \Illuminate\Contracts\View\View
     */
    public function show(string $id)
    {
        // Cari berdasarkan NIM sebagai primary key
        $mahasiswa = Mahasiswa::where('nim', $id)->firstOrFail(); // firstOrFail akan menghasilkan 404 jika tidak ditemukan
        return view('mahasiswa.show', compact('mahasiswa')); // Anda perlu membuat view show.blade.php
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param string $id (NIM)
     * @return \Illuminate\Contracts\View\View
     */
    public function edit(string $id)
    {
        // Cari data berdasarkan NIM
        $data = Mahasiswa::where('nim', $id)->firstOrFail(); // Gunakan firstOrFail untuk penanganan error
        return view('mahasiswa.edit', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param string $id (NIM)
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, string $id)
    {
        // Validasi data input untuk update
        // NIM biasanya tidak diubah, jadi tidak perlu divalidasi unique lagi di sini
        $validatedData = $request->validate([
            // Jangan validasi 'nim' jika tidak boleh diubah
            'nama' => 'required|string|max:255',
            'prodi' => 'required|string|max:100',
            'nomor_kelompok' => 'required|string|max:50',
            'dosen_pembimbing' => 'required|string|max:255',
            'angkatan' => 'required|numeric|digits:4',
        ], [
            // Pesan error kustom (sama seperti store, kecuali untuk nim)
            'nama.required' => 'Nama wajib diisi',
            'prodi.required' => 'Prodi wajib diisi',
            'nomor_kelompok.required' => 'Nomor Kelompok wajib diisi',
            'dosen_pembimbing.required' => 'Dosen Pembimbing wajib diisi',
            'angkatan.required' => 'Angkatan wajib diisi',
            'angkatan.numeric' => 'Angkatan wajib berupa angka',
            'angkatan.digits' => 'Angkatan harus 4 digit angka',
        ]);

        // Cari record yang akan diupdate
        $mahasiswa = Mahasiswa::where('nim', $id)->firstOrFail();

        // Lakukan update menggunakan data yang sudah divalidasi
        // Pastikan field ada di $fillable model Mahasiswa
        try {
            $mahasiswa->update($validatedData);
            return redirect()->route('mahasiswa.index') // Gunakan route name jika ada
                         ->with('success', 'Data mahasiswa berhasil diperbarui.');
        } catch (\Exception $e) {
            // Tangani potensi error database
            // Log::error('Error updating mahasiswa: '.$e->getMessage());
            return redirect()->back()
                         ->withInput() // Kembalikan input sebelumnya
                         ->with('error', 'Gagal memperbarui data. Silakan coba lagi.');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param string $id (NIM)
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(string $id)
    {
        try {
            $deleted = Mahasiswa::where('nim', $id)->delete();

            if ($deleted) {
                return redirect()->route('mahasiswa.index') // Gunakan route name
                             ->with('success', 'Data mahasiswa berhasil dihapus.');
            } else {
                // Kasus jika data tidak ditemukan (meskipun link ada)
                return redirect()->route('mahasiswa.index')
                             ->with('error', 'Data mahasiswa tidak ditemukan.');
            }
        } catch (\Exception $e) {
             // Tangani potensi error database (misal karena foreign key constraint)
             // Log::error('Error deleting mahasiswa: '.$e->getMessage());
             return redirect()->route('mahasiswa.index')
                          ->with('error', 'Gagal menghapus data. Mungkin data ini terkait dengan data lain.');
        }
    }
}
