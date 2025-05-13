<?php

// --- Use statements ---
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
// Hapus DB jika tidak dipakai langsung di sini: // use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;

// --- Controller Imports ---
use App\Http\Controllers\SesiController;
use App\Http\Controllers\MahasiswaController;
use App\Http\Controllers\DosenController;
use App\Http\Controllers\RequestJudulController;
use App\Http\Controllers\RequestBimbinganController;
use App\Http\Controllers\HistoryController;
use App\Http\Controllers\DokumenController;
use App\Http\Controllers\LogActivityController;
// Hapus CalendarController jika tidak dipakai lagi: // use App\Http\Controllers\CalendarController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Di sini Anda dapat mendaftarkan route web untuk aplikasi Anda. Route
| ini dimuat oleh RouteServiceProvider dalam sebuah grup yang
| mengandung middleware "web" group. Sekarang buat sesuatu yang hebat!
|
*/

// --- Guest Routes (Akses Tanpa Autentikasi) ---
Route::middleware(['guest'])->group(function() {
    Route::get('/', [SesiController::class, 'index'])->name('login'); // Halaman login
    Route::post('/', [SesiController::class, 'login']); // Proses login
});

// --- Authenticated Routes (Akses Setelah Login) ---
Route::middleware(['auth'])->group(function () {

    // 1. Admin Dashboard Route
    Route::get('/admin/dashboard', function() {
        // Jika perlu data spesifik admin, ambil di sini sebelum return view
        return view('Admin.Dashboard');
    })->name('Admin.Dashboard');

    // 2. Dosen Dashboard Route (dengan Logika Kalender)
    Route::get('/dosen/dashboard', function(Request $request) { // Inject Request
        // --- LOGIKA KALENDER (Dipertahankan sesuai kode Anda) ---
        $month = $request->input('cal_month', Carbon::now()->month);
        $year = $request->input('cal_year', Carbon::now()->year);
        try {
            $currentMonthDate = Carbon::createFromDate($year, $month, 1)->startOfDay();
        } catch (\Carbon\Exceptions\InvalidDateException $e) {
            $currentMonthDate = Carbon::now()->startOfMonth();
        }
        $firstDayOfMonth = $currentMonthDate->copy()->startOfMonth();
        $lastDayOfMonth = $currentMonthDate->copy()->endOfMonth();
        $startDayOfWeek = Carbon::SUNDAY; // Sesuaikan jika perlu (Carbon::MONDAY)
        $startOfGrid = $firstDayOfMonth->copy()->startOfWeek($startDayOfWeek);
        $endOfGrid = $lastDayOfMonth->copy()->endOfWeek($startDayOfWeek);
        $calendarPeriod = CarbonPeriod::create($startOfGrid, $endOfGrid);
        $prevMonthDate = $currentMonthDate->copy()->subMonthNoOverflow();
        $nextMonthDate = $currentMonthDate->copy()->addMonthNoOverflow();
         if ($startDayOfWeek === Carbon::SUNDAY) {
            $daysOfWeek = ['Min', 'Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab'];
        } else {
            $daysOfWeek = ['Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab', 'Min'];
        }
        // --- AKHIR LOGIKA KALENDER ---

        $viewData = [
            'cal_currentMonthDate' => $currentMonthDate,
            'cal_calendarPeriod'   => $calendarPeriod,
            'cal_daysOfWeek'       => $daysOfWeek,
            'cal_prevMonthParams'  => ['cal_month' => $prevMonthDate->month, 'cal_year' => $prevMonthDate->year],
            'cal_nextMonthParams'  => ['cal_month' => $nextMonthDate->month, 'cal_year' => $nextMonthDate->year],
            // Tambahkan data spesifik Dosen jika ada
        ];
        return view('Dosen.Dashboard', $viewData);
    })->name('Dosen.Dashboard');

    // 3. Mahasiswa Dashboard Route (dengan Logika Kalender)
    Route::get('/mahasiswa/dashboard', function(Request $request) { // Inject Request
         // --- LOGIKA KALENDER (Dipertahankan sesuai kode Anda) ---
        $month = $request->input('cal_month', Carbon::now()->month);
        $year = $request->input('cal_year', Carbon::now()->year);
        try {
            $currentMonthDate = Carbon::createFromDate($year, $month, 1)->startOfDay();
        } catch (\Carbon\Exceptions\InvalidDateException $e) {
            $currentMonthDate = Carbon::now()->startOfMonth();
        }
        $firstDayOfMonth = $currentMonthDate->copy()->startOfMonth();
        $lastDayOfMonth = $currentMonthDate->copy()->endOfMonth();
        $startDayOfWeek = Carbon::SUNDAY; // Sesuaikan jika perlu (Carbon::MONDAY)
        $startOfGrid = $firstDayOfMonth->copy()->startOfWeek($startDayOfWeek);
        $endOfGrid = $lastDayOfMonth->copy()->endOfWeek($startDayOfWeek);
        $calendarPeriod = CarbonPeriod::create($startOfGrid, $endOfGrid);
        $prevMonthDate = $currentMonthDate->copy()->subMonthNoOverflow();
        $nextMonthDate = $currentMonthDate->copy()->addMonthNoOverflow();
         if ($startDayOfWeek === Carbon::SUNDAY) {
            $daysOfWeek = ['Min', 'Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab'];
        } else {
            $daysOfWeek = ['Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab', 'Min'];
        }
        // --- AKHIR LOGIKA KALENDER ---

        $viewData = [
            'cal_currentMonthDate' => $currentMonthDate,
            'cal_calendarPeriod'   => $calendarPeriod,
            'cal_daysOfWeek'       => $daysOfWeek,
            'cal_prevMonthParams'  => ['cal_month' => $prevMonthDate->month, 'cal_year' => $prevMonthDate->year],
            'cal_nextMonthParams'  => ['cal_month' => $nextMonthDate->month, 'cal_year' => $nextMonthDate->year],
            // Tambahkan data spesifik Mahasiswa jika ada
        ];
        return view('Mhs.Dashboard', $viewData);
    })->name('Mhs.Dashboard');

    // --- Home route - Redirect Berdasarkan Role ---
    Route::get('/home', function () {
        $user = Auth::user();
        if ($user->role == 'admin') {
            return redirect()->route('Admin.Dashboard');
        } elseif ($user->role == 'dosen') {
            return redirect()->route('Dosen.Dashboard');
        } elseif ($user->role == 'mahasiswa') {
            return redirect()->route('Mhs.Dashboard'); // Redirect ke dashboard mahasiswa
        } else {
            Auth::logout();
            return redirect()->route('login')->withErrors('Pengguna tidak valid.');
        }
    })->name('home');


    // --- Resource & Specific Routes ---

    // Route untuk pengelolaan data Dosen (hanya index)
    Route::get('/dosen', [DosenController::class,'index'])->name('dosen.index');

    // Route Resource standar untuk CRUD Mahasiswa
    Route::resource('mahasiswa', MahasiswaController::class);

    // Route Resource standar untuk CRUD History
    // Anda punya dua resource history di kode sebelumnya. Saya biarkan salah satunya.
    Route::resource('history', HistoryController::class);

    // Route Resource standar untuk CRUD Dokumen
    // Ini mencakup routes: dokumen.index, dokumen.create, dokumen.store,
    // dokumen.show, dokumen.edit, dokumen.update, dokumen.destroy
    // Parameter yang digunakan oleh resource ini adalah {dokumen} (dengan 'e')
    Route::get('/dokumen', [DokumenController::class, 'index'])->name('dokumen.index'); // Menampilkan daftar dokumen
Route::get('/dokumen/create', [DokumenController::class, 'create'])->name('dokumen.create'); // Menampilkan form untuk membuat dokumen baru
Route::post('/dokumen', [DokumenController::class, 'store'])->name('dokumen.store'); // Menyimpan dokumen baru
Route::get('/dokumen/{dokuman}', [DokumenController::class, 'show'])->name('dokumen.show'); // Menampilkan detail dokumen spesifik
Route::get('/dokumen/{dokuman}/edit', [DokumenController::class, 'edit'])->name('dokumen.edit'); // Menampilkan form untuk mengedit dokumen
Route::put('/dokumen/{dokuman}', [DokumenController::class, 'update'])->name('dokumen.update'); // Memperbarui dokumen
Route::delete('/dokumen/{dokuman}', [DokumenController::class, 'destroy'])->name('dokumen.destroy'); // Menghapus dokumen

    // Route Resource standar untuk CRUD Request Judul
    Route::resource('request-judul', RequestJudulController::class);

    // Route Resource standar untuk CRUD Request Bimbingan
    Route::resource('request-bimbingan', RequestBimbinganController::class);

    // Route Resource standar untuk CRUD Log Activity
    Route::resource('log_activities', LogActivityController::class);

    // --- Logout Route ---
    Route::post('/logout', [SesiController::class,'logout'])->name('logout');

    // --- Calendar Route (Dikommentari sesuai kode Anda, hapus jika tidak dipakai) ---
    // Route::get('/kalender', [CalendarController::class, 'show'])->name('calendar.show');

});
