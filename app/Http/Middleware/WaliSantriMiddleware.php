<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class WaliSantriMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle(Request $request, Closure $next): Response
    {
        // 1. Cek Autentikasi
        if (Auth::check()) {
            // 2. Cek Peran (Role)
            // Asumsi metode isWaliSantri() ada pada Model User (app/Models/User.php)
            if (Auth::user()->isWaliSantri()) {
                // Pengguna adalah Wali Santri, izinkan akses
                return $next($request);
            }
        }

        // 3. Jika pengguna tidak login atau bukan Wali Santri
        
        // Arahkan kembali ke halaman utama ('/') atau halaman login
        // Disertai flash message 'error'
        return redirect('/')->with('error', 'Akses ditolak. Anda tidak memiliki izin Wali Santri.');
    }
}