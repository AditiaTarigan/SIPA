<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SesiController extends Controller
{
    public function index()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        // Validasi input
        $request->validate([
            'username' => 'required',
            'password' => 'required'
        ], [
            'username.required' => 'Username harus diisi',
            'password.required' => 'Password harus diisi'
        ]);

        // Ambil input username dan password
        $infologin = [
            'username' => $request->input('username'),
            'password' => $request->input('password')
        ];

        // Coba melakukan login
        if (Auth::attempt($infologin)) {

        } else {
            return redirect()->back()->withErrors(['login' => 'Username atau password salah'])->withInput();
        }if (Auth::user()->role == 'admin') {
            return redirect('admin');
        } elseif (Auth::user()->role == 'mahasiswa') {
            return redirect('mahasiswa');
        }elseif (Auth::user()->role== 'dosen') {
            return redirect('dosen');
        }
    }

         public function logout()
        {
          Auth::logout();
          return redirect(''); // Pastikan ini mengarah ke halaman login
}

}
