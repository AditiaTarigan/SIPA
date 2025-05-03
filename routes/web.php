<?php

// --- Use statements ---
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
// Hapus DB jika tidak dipakai langsung di sini: use Illuminate\Support\Facades\DB;
use Carbon\Carbon; // Pastikan namespace Carbon benar
use Carbon\CarbonPeriod;
use Illuminate\Http\Request; // Perlu untuk inject $request

// --- Controller Imports ---
use App\Http\Controllers\SesiController;
use App\Http\Controllers\MahasiswaController;
use App\Http\Controllers\DosenController;
use App\Http\Controllers\RequestJudulController;
use App\Http\Controllers\RequestBimbinganController;
use App\Http\Controllers\HistoryController;
use App\Http\Controllers\DokumenController;
use App\Http\Controllers\LogActivityController;
// Hapus CalendarController jika tidak dipakai lagi: use App\Http\Controllers\CalendarController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// --- Guest Routes ---
Route::middleware(['guest'])->group(function() {
    Route::get('/', [SesiController::class, 'index'])->name('login');
    Route::post('/', [SesiController::class, 'login']);
});

// --- Authenticated Routes  ---
Route::middleware(['auth'])->group(function () {

    // 1. Admin Dashboard Route
    Route::get('/admin/dashboard', function() {
        // Jika perlu kalender di admin, logikanya taruh di sini
        return view('Admin.Dashboard');
    })->name('Admin.Dashboard');

    // 2. Dosen Dashboard Route
    // Jika perlu kalender di dosen, logikanya taruh di DosenController::dashboard
    Route::get('/dosen/dashboard', function(Request $request) {
        // Jika perlu kalender di dosen, logikanya taruh di sini

        // --- LOGIKA KALENDER ---
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

        // Gabungkan semua data yang diperlukan oleh view Mhs.Dashboard
        $viewData = [
            // Mungkin ada data lain yang perlu dikirim ke view mahasiswa?
            // 'mahasiswa' => Auth::user(), // Contoh

            // Data Kalender (WAJIB ADA)
            'cal_currentMonthDate' => $currentMonthDate,
            'cal_calendarPeriod'   => $calendarPeriod,
            'cal_daysOfWeek'       => $daysOfWeek,
            'cal_prevMonthParams'  => ['cal_month' => $prevMonthDate->month, 'cal_year' => $prevMonthDate->year],
            'cal_nextMonthParams'  => ['cal_month' => $nextMonthDate->month, 'cal_year' => $nextMonthDate->year],
        ];
        // Kirim data ke view Dosen Dashboard
        return view('Dosen.Dashboard', $viewData);
    })->name('Dosen.Dashboard');

    // 3. Mahasiswa Dashboard Route <<-- TEMPATKAN LOGIKA KALENDER DI SINI
    Route::get('/mahasiswa/dashboard', function(Request $request) { // Inject Request di sini

        // --- LOGIKA KALENDER ---
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

        // Gabungkan semua data yang diperlukan oleh view Mhs.Dashboard
        $viewData = [
            // Mungkin ada data lain yang perlu dikirim ke view mahasiswa?
            // 'mahasiswa' => Auth::user(), // Contoh

            // Data Kalender (WAJIB ADA)
            'cal_currentMonthDate' => $currentMonthDate,
            'cal_calendarPeriod'   => $calendarPeriod,
            'cal_daysOfWeek'       => $daysOfWeek,
            'cal_prevMonthParams'  => ['cal_month' => $prevMonthDate->month, 'cal_year' => $prevMonthDate->year],
            'cal_nextMonthParams'  => ['cal_month' => $nextMonthDate->month, 'cal_year' => $nextMonthDate->year],
        ];

        // Kirim data ke view Mahasiswa Dashboard
        return view('Mhs.Dashboard', $viewData); // <<-- Kirim $viewData ke view yang benar

    })->name('Mhs.Dashboard'); // <<-- Nama route yang benar


    // --- Home route - HANYA REDIRECT ---
    Route::get('/home', function () { // Tidak perlu $request di sini
        $user = Auth::user();
        if ($user->role == 'admin') {
            return redirect()->route('Admin.Dashboard');
        } elseif ($user->role == 'dosen') {
            return redirect()->route('Dosen.Dashboard');
        } elseif ($user->role == 'mahasiswa') {
            // Redirect ke route /mahasiswa/dashboard yang sudah ada logika kalendernya
            return redirect()->route('Mhs.Dashboard');
        } else {
            Auth::logout();
            return redirect()->route('login')->withErrors('Pengguna tidak valid.');
        }
        // HAPUS SEMUA LOGIKA KALENDER DAN RETURN VIEW DARI SINI
    })->name('home');


    // --- Route Lainnya ---
    Route::get('/dosen', [DosenController::class,'index'])->name('dosen.index');
    Route::resource('mahasiswa', MahasiswaController::class);
    Route::resource('history', HistoryController::class); // Anda punya dua resource history, mungkin salah satu bisa dihapus?
    Route::resource('dokumen', DokumenController::class);
    Route::resource('request-judul', RequestJudulController::class);
    Route::resource('request-bimbingan', RequestBimbinganController::class);
    // Route::resource('history', HistoryController::class); // Duplikat
    Route::resource('log_activities', LogActivityController::class);

    // --- Logout Route ---
    Route::post('/logout', [SesiController::class,'logout'])->name('logout');

    // --- Calendar Route (Hapus jika tidak dipakai lagi) ---
    // Route::get('/kalender', [CalendarController::class, 'show'])->name('calendar.show');

});
