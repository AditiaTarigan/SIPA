<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  ...$roles
     * @return mixed
     */
    public function handle(Request $request, Closure $next, ...$roles)
    {
        // Pastikan user sudah login
        if (!Auth::check()) {
            return redirect('/login'); // Atau sesuaikan dengan route login kamu
        }

        // Cek apakah role user cocok dengan salah satu role yang dikirimkan
        if (!in_array(Auth::user()->role, $roles)) {
            abort(403, 'Unauthorized'); // Menghentikan akses jika role tidak sesuai
        }

        return $next($request); // Lanjutkan request jika role cocok
    }
}
