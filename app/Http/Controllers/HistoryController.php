<?php

namespace App\Http\Controllers;

use App\Models\HistoryBimbingan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class HistoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = history::orderBy('tanggal','desc')->get();
        return view('history.index')->with('data',$data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('history.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Session::flash('tanggal',$request->tanggal);
        Session::flash('topik',$request->topik);
        Session::flash('hasil',$request->hasil);
        Session::flash('tanggal2',$request->tanggal2);
        Session::flash('jumlah',$request->jumlah);
        $request->validate([
            'tanggal' => 'required',
            'topik' => 'required',
            'hasil' => 'required',
            'tanggal2' => 'required',
            'jumlah' => 'required|numeric',
        ],[
            'tanggal.required'=>'Tanggal wajib diisi',
            'topik.required'=>'Topik wajib diisi',
            'hasil.required'=>'Hasil wajib diisi',
            'tanggal2.required'=>'Rencana Bimbingan wajib diisi',
            'jumlah.required'=>'Jumlah Mahasiswa wajib diisi',
        ]);
        $data = [
            'tanggal' => $request->tanggal,
            'topik' => $request->topik,
            'hasil' => $request->hasil,
            'tanggal2' => $request->tanggal2,
            'jumlah' => $request->jumlah,
        ];
        HistoryBimbingan::create($data);
        return redirect()->to('history')->with('success','Berhasil menambahkan data');
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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
