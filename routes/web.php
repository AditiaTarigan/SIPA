<?php

use App\Http\Controllers\SesiController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MahasiswaController;
use App\Http\Controllers\DosenController;
use App\Http\Controllers\JudulController;
use App\Http\Controllers\bimbingancontroller;
use App\Http\Controllers\logactivitycontroller;
use App\Http\Controllers\catatancontroller;
use App\Http\Controllers\chatcontroller;
use App\Http\Controllers\dokumencontroller;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


use Illuminate\Support\Facades\DB;

Route::get('/test-db', function () {
    try {
        DB::connection()->getPdo();
        return 'Connected to: ' . DB::connection()->getDatabaseName();
    } catch (\Exception $e) {
        return 'Could not connect. ' . $e->getMessage();
    }
});

Route::middleware(['guest'])->group(function(){
    Route::get('/', [SesiController::class, 'index'])->name('login');
    Route::post('/', [SesiController::class, 'login'])->name('login');
});

//Route::get('/', [SesiController::class, 'index']);
//Route::post('/', [SesiController::class, 'login'])->name('login');


Route::get('/home', function () {
    return redirect('/mahasiswa');
});

Route::get('/mahasiswa', [MahasiswaController::class,'index']) ;

Route::get('/logout',[SesiController::class,'logout']);

Route::get('/dosen', [DosenController::class,'index']);

