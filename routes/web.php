<?php

use App\Http\Controllers\SesiController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MahasiswaController;
use App\Http\Controllers\DosenController;
use App\Http\Controllers\RequestJudulController;
use App\Http\Controllers\RequestBimbinganController;
use App\Http\Controllers\HistoryController;
// Commented out controllers - uncomment when needed
// use App\Http\Controllers\JudulController;
// use App\Http\Controllers\BimbinganController;
// use App\Http\Controllers\LogActivityController;
// use App\Http\Controllers\CatatanController;
// use App\Http\Controllers\ChatController;
use App\Http\Controllers\DokumenController;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// --- Guest Routes (Users Not Logged In) ---
Route::middleware(['guest'])->group(function() {
    Route::get('/', [SesiController::class, 'index'])->name('login');
    Route::post('/', [SesiController::class, 'login']); // Handles login form submission
});

// --- Authenticated Routes (Users Must Be Logged In) ---
Route::middleware(['auth'])->group(function () {

    // Home route - redirects based on role
    Route::get('/home', function () {
        $user = Auth::user();
        if ($user->role == 'mahasiswa') {
            // Redirect mahasiswa, e.g., to request judul index or their specific dashboard
            return redirect()->route('request-judul.index');
        } elseif ($user->role == 'dosen') {
             // Redirect dosen to their dashboard
            return redirect()->route('dosen.dashboard');
        } else {
            // Default redirect for other roles (e.g., admin)
            // Replace 'admin.dashboard' with your actual default/admin dashboard route name
            return redirect()->route('admin.dashboard'); // Example: You need to define this route
        }
    })->name('home'); // Give the home route a name

    // --- Mahasiswa Specific Routes (Example) ---
    // Consider adding role middleware here if needed: ->middleware('role:mahasiswa')
    Route::resource('mahasiswa', MahasiswaController::class);

    Route::resource('history', HistoryController::class);

    Route::resource('dokumen', DokumenController::class);

    // --- Dosen Specific Routes (Example) ---
    // Consider adding role middleware here if needed: ->middleware('role:dosen')
    Route::get('/dosen', [DosenController::class,'index'])->name('dosen.index');
    Route::get('/dosen/dashboard', [DosenController::class,'dashboard'])->name('dosen.dashboard');

    // --- CRUD Routes for Request Judul ---
    // Accessible by authenticated users (add role middleware if only specific roles can access)
    Route::resource('request-judul', RequestJudulController::class);

    // --- CRUD Routes for Request Bimbingan ---
    // Accessible by authenticated users (add role middleware if only specific roles can access)
    // This single line defines all necessary routes:
    // - request-bimbingan.index (GET)
    // - request-bimbingan.create (GET)
    // - request-bimbingan.store (POST)
    // - request-bimbingan.show (GET)
    // - request-bimbingan.edit (GET)
    // - request-bimbingan.update (PUT/PATCH)
    // - request-bimbingan.destroy (DELETE)
    Route::resource('request-bimbingan', RequestBimbinganController::class);

    // --- Other Potential Resource Routes (Uncomment when ready) ---
    // Route::resource('judul', JudulController::class)->middleware('role:admin,dosen'); // Example with role restriction
    // Route::resource('bimbingan', BimbinganController::class);
    // Route::resource('catatan', CatatanController::class);
    // Route::resource('log-activity', LogActivityController::class)->only(['index', 'show']); // Example: only index/show
    // Route::resource('dokumen', DokumenController::class);
    // Route::resource('chat', ChatController::class);

    // --- Logout Route ---
    // Place it here for logical grouping of authenticated actions
    Route::post('/logout', [SesiController::class,'logout'])->name('logout');

    // --- Example Admin Dashboard Route (define controller/view) ---
    Route::get('/admin/dashboard', function() {
        return view('dashboard.admin'); // Replace with actual view/controller
    })->name('dashboard.admin')->middleware('role:admin'); // Example: Restrict to admin role

}); // End of Auth Middleware Group


// --- Optional Test Routes (Remove or comment out in production) ---
Route::get('/test-db', function () {
    try {
        DB::connection()->getPdo();
        return 'Connected to: ' . DB::connection()->getDatabaseName();
    } catch (\Exception $e) {
        return 'Could not connect. ' . $e->getMessage();
    }
});


// If you are using Laravel's built-in Auth scaffolding (like Breeze or Jetstream),
// their routes might be included separately, often via:
// require __DIR__.'/auth.php';
// Make sure that file exists if you uncomment such a line.
