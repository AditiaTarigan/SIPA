<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

// --- Controller Imports ---
use App\Http\Controllers\SesiController;
use App\Http\Controllers\MahasiswaController;
use App\Http\Controllers\DosenController;
use App\Http\Controllers\RequestJudulController;
use App\Http\Controllers\RequestBimbinganController;
use App\Http\Controllers\HistoryController;
use App\Http\Controllers\DokumenController;
use App\Http\Controllers\LogActivityController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// --- Guest Routes ---
// Hanya bisa diakses jika BELUM login
Route::middleware(['guest'])->group(function() {
    Route::get('/', [SesiController::class, 'index'])->name('login');
    Route::post('/', [SesiController::class, 'login']);
});

// --- Authenticated Routes  ---
// Semua route di dalam grup ini WAJIB login
Route::middleware(['auth'])->group(function () {

    // 1. Admin Dashboard Route
    Route::get('/admin/dashboard', function() {
        // Ganti ini dengan Controller dan View Admin yang sebenarnya
        return view('Admin.Dashboard');
    })->name('Admin.Dashboard');

    // 2. Dosen Dashboard Route
    Route::get('/dosen/dashboard', [DosenController::class,'dashboard'])->name('Dosen.Dashboard');

    // 3. Mahasiswa Dashboard Route
    Route::get('/mahasiswa/dashboard', function() {
        return view('Mhs.Dashboard');
    })->name('Mhs.Dashboard');


    // --- Home route - Redirects based on role ---
    Route::get('/home', function () {
        $user = Auth::user();
        if ($user->role == 'admin') {
            return redirect()->route('Admin.Dashboard');
        } elseif ($user->role == 'dosen') {
            return redirect()->route('Dosen.Dashboard');
        } elseif ($user->role == 'mahasiswa') {
            return redirect()->route('Mhs.Dashboard');
        } else {
            Auth::logout();
            return redirect()->route('login')->withErrors('Pengguna tidak valid.');
        }
    })->name('home');


    Route::get('/dosen', [DosenController::class,'index'])->name('dosen.index');


    Route::resource('mahasiswa', MahasiswaController::class);
    Route::resource('history', HistoryController::class);
    Route::resource('dokumen', DokumenController::class);

    // Request Judul
    Route::resource('request-judul', RequestJudulController::class);

    // Request Bimbingan
    Route::resource('request-bimbingan', RequestBimbinganController::class);

    Route::resource('history', HistoryController::class);

    // Log Activities
    Route::resource('log_activities', LogActivityController::class);

    // --- Logout Route ---
    Route::post('/logout', [SesiController::class,'logout'])->name('logout');

});

