<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Dokumen;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\ModelNotFoundException; // Penting untuk menangkap exception

class DokumenController extends Controller
{
    public function index()
    {
        $dokumens = Dokumen::all();
        return view('dokumen.index', compact('dokumens'));
    }

    public function create()
    {
        return view('dokumen.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'prodi' => 'required|string|max:255',
            'nomor_kelompok' => 'required|string|max:50',
            'dokumen' => 'required|file|mimes:pdf,doc,docx|max:2048',
        ]);

        $path = $request->file('dokumen')->store('dokumen', 'public');

        Dokumen::create([
            'nama' => $request->nama,
            'prodi' => $request->prodi,
            'nomor_kelompok' => $request->nomor_kelompok,
            'dokumen' => $path,
        ]);

        return redirect()->route('dokumen.index')->with('success', 'Dokumen berhasil dikirim.');
    }

    //Perhatikan parameter route model binding namanya $dokuman
    public function show(Dokumen $dokuman)
    {
        return view('dokumen.show', compact('dokuman'));
    }

    //Perhatikan parameter route model binding namanya $dokuman
    public function edit(Dokumen $dokuman)
    {
        return view('dokumen.edit', compact('dokuman'));
    }

    //Perhatikan parameter route model binding namanya $dokuman
    public function update(Request $request, Dokumen $dokuman)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'prodi' => 'required|string|max:255',
            'nomor_kelompok' => 'required|string|max:50',
            'dokumen' => 'nullable|file|mimes:pdf,doc,docx|max:2048',
        ]);

        $data = $request->only('nama', 'prodi', 'nomor_kelompok');

        if ($request->hasFile('dokumen')) {
            if ($dokumen->dokumen && Storage::disk('public')->exists($dokumen->dokumen)) {
                Storage::disk('public')->delete($dokumen->dokumen);
            }
            $data['dokumen'] = $request->file('dokumen')->store('dokumen', 'public');
        }

        $dokumen->update($data);

        return redirect()->route('dokumen.index')->with('success', 'Dokumen berhasil diperbarui.');
    }

    //Perhatikan parameter route model binding namanya $dokuman
    public function destroy(Dokumen $dokuman)
    {
        //PERHATIKAN: Sekarang Anda menerima instance model $dokuman, bukan hanya ID
        //Tidak perlu findOrFail lagi.

        //Hapus file terkait sebelum menghapus record
        if ($dokuman->dokumen && Storage::disk('public')->exists($dokuman->dokumen)) {
            Storage::disk('public')->delete($dokuman->dokumen);
        }

        $dokuman->delete();

        return redirect()->route('dokumen.index')->with('success', 'Dokumen berhasil dihapus.');
    }
}
