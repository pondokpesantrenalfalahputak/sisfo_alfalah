<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Santri; // Pastikan Model Santri sudah diimpor
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use Illuminate\Support\Facades\DB; // Tambahkan ini untuk transaksi

class RegisteredUserController extends Controller
{
    /**
     * Tampilkan view pendaftaran (register).
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Tangani permintaan pendaftaran yang masuk.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        // 1. VALIDASI DATA WALI DAN SANTRI
        $request->validate([
            // --- Validasi Data Wali ---
            'name' => ['required', 'string', 'max:255'], // Nama Wali
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            
            // --- Validasi Data Santri (dari form) ---
            'nama_santri' => ['required', 'string', 'max:255'],
            // 🚀 PERBAIKAN: NISN diubah dari 'nullable' menjadi 'required'
            'nis' => ['required', 'string', 'max:20', 'unique:'.Santri::class.',nisn'], 
            
            'tanggal_lahir_santri' => ['required', 'date', 'before:today'],
        ]);

        // Gunakan Transaksi untuk memastikan kedua data (User dan Santri) tersimpan dengan aman
        DB::transaction(function () use ($request) {
            
            // 2. SIMPAN AKUN WALI SANTRI (Tabel users)
            $wali = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => 'wali_santri',
            ]);

            // 3. SIMPAN DATA SANTRI (Tabel santris)
            Santri::create([
                'wali_santri_id' => $wali->id,
                'nama_lengkap' => $request->nama_santri, 
                'nisn' => $request->nis, // Kini dijamin tidak NULL
                'tanggal_lahir' => $request->tanggal_lahir_santri, 
                
                // Kolom opsional yang tidak diisi di form register
                'kelas_id' => null, 
                'tempat_lahir' => null,
                'alamat' => null,
            ]);

            event(new Registered($wali)); 
            Auth::login($wali); 
        });

        // Redirect ke dashboard (route 'dashboard' harus didefinisikan)
        return redirect(route('dashboard', absolute: false));
    }
}