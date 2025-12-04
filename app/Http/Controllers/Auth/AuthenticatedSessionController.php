<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest; // Pastikan menggunakan LoginRequest yang sudah dimodifikasi
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    // Menggunakan LoginRequest untuk otentikasi
    public function store(LoginRequest $request): RedirectResponse 
    {
        // Panggil metode authenticate() dari LoginRequest
        // Ini akan menjalankan semua logika validasi dan login (Email/NISN)
        $request->authenticate(); 

        // Regenerasi sesi jika autentikasi berhasil
        $request->session()->regenerate();
            
        // Redirect sesuai role
        if (Auth::user()->isAdmin()) {
            // Ganti dengan nama route yang benar untuk admin
            return redirect()->intended(route('admin.dashboard')); 
        }
        
        // Redirect Wali Santri
        // Ganti dengan nama route yang benar untuk wali
        return redirect()->intended(route('wali.dashboard'));
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}