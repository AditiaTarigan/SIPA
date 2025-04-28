<?php

namespace App\Http\Controllers;

use App\Models\LogActivity; // Pastikan model LogActivity sudah dibuat
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // Untuk mendapatkan ID user yang login

class LogActivityController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Mendapatkan semua log aktivitas, bisa ditambahkan pagination
        $logActivities = LogActivity::latest()->paginate(10); // atau get() jika tidak ingin pagination
        return view('log_activities.index', compact('logActivities')); // Sesuaikan nama view
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Menampilkan form untuk membuat log aktivitas baru
        return view('log_activities.create'); // Sesuaikan nama view
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'nama' => 'required|string|max:100',
            'prodi' => 'required|string|max:100',
            'no_kelompok' => 'nullable|string|max:20',
            'file_log' => 'required|file|mimes:txt,pdf,doc,docx|max:2048', // Contoh validasi file
        ]);

        // Upload file log
        $fileLog = $request->file('file_log');
        $fileName = time() . '_' . $fileLog->getClientOriginalName();
        $fileLog->storeAs('logs', $fileName, 'public'); // Simpan di storage/app/public/logs

        // Membuat log aktivitas baru
        LogActivity::create([
            'mahasiswa_id' => Auth::id(), // Mendapatkan ID user yang login (pastikan user sudah login)
            'nama' => $request->nama,
            'prodi' => $request->prodi,
            'no_kelompok' => $request->no_kelompok,
            'file_log' => $fileName, // Simpan nama file saja
        ]);

        // Redirect ke halaman index dengan pesan sukses
        return redirect()->route('log_activities.index')->with('success', 'Log aktivitas berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(LogActivity $logActivity)
    {
        // Menampilkan detail log aktivitas
        return view('log_activities.show', compact('logActivity')); // Sesuaikan nama view
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(LogActivity $logActivity)
    {
        // Menampilkan form untuk mengedit log aktivitas
        return view('log_activities.edit', compact('logActivity')); // Sesuaikan nama view
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, LogActivity $logActivity)
    {
        // Validasi input
        $request->validate([
            'nama' => 'required|string|max:100',
            'prodi' => 'required|string|max:100',
            'no_kelompok' => 'nullable|string|max:20',
            'file_log' => 'nullable|file|mimes:txt,pdf,doc,docx|max:2048', // Contoh validasi file (opsional)
        ]);

        // Update data log aktivitas
        $logActivity->nama = $request->nama;
        $logActivity->prodi = $request->prodi;
        $logActivity->no_kelompok = $request->no_kelompok;

        // Jika ada file baru diupload
        if ($request->hasFile('file_log')) {
            // Hapus file lama
            Storage::delete('public/logs/' . $logActivity->file_log);

            // Upload file baru
            $fileLog = $request->file('file_log');
            $fileName = time() . '_' . $fileLog->getClientOriginalName();
            $fileLog->storeAs('logs', $fileName, 'public');
            $logActivity->file_log = $fileName;
        }

        $logActivity->save();

        // Redirect ke halaman index dengan pesan sukses
        return redirect()->route('log_activities.index')->with('success', 'Log aktivitas berhasil diupdate.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(LogActivity $logActivity)
    {
        // Hapus file log
        Storage::delete('public/logs/' . $logActivity->file_log);

        // Hapus log aktivitas
        $logActivity->delete();

        // Redirect ke halaman index dengan pesan sukses
        return redirect()->route('log_activities.index')->with('success', 'Log aktivitas berhasil dihapus.');
    }
}
