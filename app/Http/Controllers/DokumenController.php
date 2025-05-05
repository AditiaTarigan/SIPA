<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Dokumen;
use Illuminate\Support\Facades\Storage;
// Jika ingin menangkap error ModelNotFoundException secara spesifik, uncomment baris ini:
// use Illuminate\Database\Eloquent\ModelNotFoundException;

class DokumenController extends Controller
{
    /**
     * Menampilkan daftar semua dokumen.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Mengambil semua data dokumen
        // Jika data banyak, pertimbangkan pagination: $dokumens = Dokumen::paginate(10);
        $dokumens = Dokumen::all();

        // Mengirim data dokumen ke view index
        return view('dokumen.index', compact('dokumens'));
    }

    /**
     * Menampilkan form untuk membuat dokumen baru.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('dokumen.create');
    }

    /**
     * Menyimpan dokumen baru ke database.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        // Validasi data yang masuk
        $request->validate([
            'nama' => 'required|string|max:255',
            'prodi' => 'required|string|max:255',
            'nomor_kelompok' => 'required|string|max:50',
            'dokumen' => 'required|file|mimes:pdf,doc,docx|max:2048', // Validasi file dan ukuran
        ]);

        // Upload file dokumen ke storage public/dokumen
        $path = $request->file('dokumen')->store('dokumen', 'public');

        // Membuat entri baru di database
        Dokumen::create([
            'nama' => $request->nama,
            'prodi' => $request->prodi,
            'nomor_kelompok' => $request->nomor_kelompok,
            'dokumen' => $path, // Menyimpan path file
        ]);

        // Redirect kembali ke halaman index dengan pesan sukses
        return redirect()->route('dokumen.index')->with('success', 'Dokumen berhasil dikirim.');
    }

    /**
     * Menampilkan detail spesifik dari sebuah dokumen.
     * Menggunakan Route Model Binding: Laravel otomatis menemukan Dokumen berdasarkan ID di URL.
     * Jika tidak ditemukan, akan melempar ModelNotFoundException (menghasilkan halaman 404 secara default).
     *
     * @param  \App\Models\Dokumen  $dokumen Parameter ini otomatis diisi oleh Route Model Binding
     * @return \Illuminate\View\View|\Illuminate\Http\Response
     */
    public function show(Dokumen $dokumen)
    {
        // Data dokumen sudah tersedia di variabel $dokumen berkat Route Model Binding
        // Mengirim data dokumen ke view show
        return view('dokumen.show', compact('dokumen'));

        // Jika view 'dokumen.show.blade.php' tidak ada, ini akan melempar ViewNotFoundException
    }

    /**
     * Menampilkan form untuk mengedit dokumen yang sudah ada.
     * Menggunakan Route Model Binding.
     *
     * @param  \App\Models\Dokumen  $dokumen
     * @return \Illuminate\View\View
     */
    public function edit(Dokumen $dokumen)
    {
        // Pastikan hanya admin atau dosen yang bisa mengedit
        // $this->authorize('update', $dokumen); // Jika ada policy
        // Atau bisa menggunakan gate
        // Gate::authorize('update', $dokumen);
        // Jika tidak ada policy, bisa langsung cek role
        // if (auth()->user()->role !== 'admin' && auth()->user()->role !== 'dosen') {
        //     abort(403, 'Anda tidak memiliki izin untuk mengedit dokumen ini.');
        // }

        // Data dokumen sudah tersedia di variabel $dokumen berkat Route Model Binding
        // Mengirim data dokumen ke view edit

        return view('dokumen.edit', compact('dokumen'));
    }

    /**
     * Memperbarui dokumen yang sudah ada di database.
     * Menggunakan Route Model Binding.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Dokumen  $dokumen
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Dokumen $dokumen)
    {
        // Data dokumen sudah tersedia di variabel $dokumen berkat Route Model Binding
        // Validasi data yang masuk (dokumen bersifat nullable saat update)
        $request->validate([
            'nama' => 'required|string|max:255',
            'prodi' => 'required|string|max:255',
            'nomor_kelompok' => 'required|string|max:50',
            'dokumen' => 'nullable|file|mimes:pdf,doc,docx|max:2048', // Dokumen opsional
        ]);

        // Mengambil data yang akan diupdate
        $data = $request->only('nama', 'prodi', 'nomor_kelompok');

        // Proses upload file baru jika ada
        if ($request->hasFile('dokumen')) {
            // Hapus file lama jika ada dan valid
            if ($dokumen->dokumen && Storage::disk('public')->exists($dokumen->dokumen)) {
                Storage::disk('public')->delete($dokumen->dokumen);
            }
            // Simpan file baru dan update path di $data
            $data['dokumen'] = $request->file('dokumen')->store('dokumen', 'public');
        }

        // Update data dokumen di database
        $dokumen->update($data);

        // Redirect kembali ke halaman index dengan pesan sukses
        return redirect()->route('dokumen.index')->with('success', 'Dokumen berhasil diperbarui.');
    }

    /**
     * Menghapus dokumen dari database.
     * Menggunakan Route Model Binding.
     * Jika tidak ditemukan, akan melempar ModelNotFoundException (menghasilkan halaman 404 secara default).
     *
     * @param  \App\Models\Dokumen  $dokumen
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Dokumen $dokumen)
    {
        // Data dokumen sudah tersedia di variabel $dokumen berkat Route Model Binding

        // Hapus file terkait dari storage jika ada dan valid
        if ($dokumen->dokumen && Storage::disk('public')->exists($dokumen->dokumen)) {
            Storage::disk('public')->delete($dokumen->dokumen);
        }

        // Hapus data dokumen dari database
        $dokumen->delete();

        // Redirect kembali ke halaman index dengan pesan sukses
        return redirect()->route('dokumen.index')->with('success', 'Dokumen berhasil dihapus.');
    }
}
