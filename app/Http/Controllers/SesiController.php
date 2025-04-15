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
        $request->validate([
            'username' => 'required',
            'password' => 'required'
        ], [
            'username.required' => 'Username harus diisi',
            'password.required' => 'Password harus diisi'
        ]);

        $infologin = [
            'username' => $request->input('username'),
            'password' => $request->input('password')
        ];

        if (Auth::attempt($infologin)) {
            // Kalau login berhasil, cek role-nya
            $user = Auth::user();
            if ($user->role == 'admin') {
                return redirect()->route('admin.dashboard');
            } elseif ($user->role == 'mahasiswa') {
                return redirect()->route('request-judul.index');
            } elseif ($user->role == 'dosen') {
                return redirect()->route('dosen.dashboard');
            } else {
                return redirect()->route('home'); // fallback
            }
        } else {
            return redirect()->back()->withErrors(['login' => 'Username atau password salah'])->withInput();
        }
    }

         public function logout()
        {
          Auth::logout();
          return redirect(''); // Pastikan ini mengarah ke halaman login
}

}
