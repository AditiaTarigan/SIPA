<?php

namespace App\Http\Controllers;

use App\Models\HistoryBimbingan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class HistoryController extends Controller
{
    public function index(Request $request)
    {
        $katakunci = $request->katakunci;
        $jumlahbaris = 4;

        if ($katakunci) {
            $data = HistoryBimbingan::where('topik', 'like', "%$katakunci%")
                ->orWhere('tanggal', 'like', "%$katakunci%")
                ->orWhere('hasil', 'like', "%$katakunci%")
                ->orWhere('tanggal2', 'like', "%$katakunci%")
                ->paginate($jumlahbaris);
        } else {
            $data = HistoryBimbingan::orderBy('tanggal', 'desc')->paginate($jumlahbaris);
        }

        return view('history.index', compact('data'));
    }

    public function create()
    {
        return view('history.create');
    }

    public function store(Request $request)
    {
        Session::flash('tanggal', $request->tanggal);
        Session::flash('topik', $request->topik);
        Session::flash('hasil', $request->hasil);
        Session::flash('tanggal2', $request->tanggal2);
        Session::flash('jumlah', $request->jumlah);

        $request->validate([
            'tanggal' => 'required',
            'topik' => 'required',
            'hasil' => 'required',
            'tanggal2' => 'required',
            'jumlah' => 'required|numeric',
        ]);

        HistoryBimbingan::create($request->all());

        return redirect()->to('history')->with('success', 'Berhasil menambahkan data');
    }

    public function show(string $id)
    {
        //
    }

    public function edit(string $id)
    {
        $data = HistoryBimbingan::findOrFail($id);
        return view('history.edit', compact('data'));
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'tanggal' => 'required',
            'topik' => 'required',
            'hasil' => 'required',
            'tanggal2' => 'required',
            'jumlah' => 'required|numeric',
        ]);

        $data = HistoryBimbingan::findOrFail($id);
        $data->update($request->all());

        return redirect()->to('history')->with('success', 'Berhasil melakukan update data');
    }

    public function destroy(string $id)
    {
        $data = HistoryBimbingan::findOrFail($id);
        $data->delete();

        return redirect()->to('history')->with('success', 'Berhasil menghapus data');
    }

}
