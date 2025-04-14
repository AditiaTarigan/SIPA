<?php

namespace App\Http\Controllers;

use App\Models\mahasiswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class MahasiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $katakunci = $request->katakunci;
        $jumlahbaris = 4;
        if(strlen($katakunci)){
           $data = mahasiswa::where('nim','like',"%$katakunci%")
                    ->orWhere('prodi','like',"%$katakunci%")
                    ->orWhere('angkatan','like',"%$katakunci%")
                    ->paginate($jumlahbaris);
        }else{
            $data = mahasiswa::orderBy('nim','desc')->paginate($jumlahbaris);
        }
        return view('mahasiswa.index')->with('data', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('mahasiswa.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Session::flash('nim',$request->nim);
        Session::flash('prodi',$request->prodi);
        Session::flash('angkatan',$request->angkatan);

        $request->validate([
            'nim'=>'required|numeric|unique:mahasiswa,nim',
            'prodi' => 'required',
            'angkatan' => 'required|numeric',
        ],[
            'nim.required'=>'NIM wajib diisi',
            'nim.numeric'=>'NIM wajib dalam angka',
            'nim.unique'=>'NIM yang diisikan sudah ada dalam database',
            'prodi.required'=>'Prodi wajib diisi',
            'angkatan.required'=>'Angkatan wajib diisi',
            'angkatan.numeric'=>'Angkatan wajib dalam angka',
        ]);
        $data = [
            'nim'=>$request->nim,
            'prodi'=>$request->prodi,
            'angkatan'=>$request->angkatan,
        ];
        mahasiswa::create($data);
        return redirect()->to('mahasiswa')->with('success', 'Berhasil menambahkan data');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data = mahasiswa::where('nim',$id)->first();
        return view('mahasiswa.edit')->with('data', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'prodi' => 'required',
            'angkatan' => 'required|numeric',
        ],[
            'prodi.required'=>'Prodi wajib diisi',
            'angkatan.required'=>'Angkatan wajib diisi',
            'angkatan.numeric'=>'Angkatan wajib dalam angka',
        ]);
        $data = [
            'prodi'=>$request->prodi,
            'angkatan'=>$request->angkatan,
        ];
        mahasiswa::where('nim', $id)->update($data);
        return redirect()->to('mahasiswa')->with('success', 'Berhasil melakukan update data');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        mahasiswa::where('nim', $id)->delete();
        return redirect()->to('mahasiswa')->with('success', 'Berhasil melakukan hapus data');
    }
}
