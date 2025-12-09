<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Santri; 
use App\Models\KelasSantri; 
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use Illuminate\Support\Facades\DB; 

class RegisteredUserController extends Controller
{
    /**
     * Tampilkan view pendaftaran (register).
     */
    public function create(): View
    {
        // 🚀 Mengambil data kelas untuk dropdown di form
        $kelas = KelasSantri::all(); 

        return view('auth.register', compact('kelas')); // Kirim variabel $kelas ke view
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
            // --- Validasi Data Wali (User) ---
            'name' => ['required', 'string', 'max:255'], 
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            
            // --- Validasi Data Santri ---
            'nama_santri' => ['required', 'string', 'max:255'],
            'nis' => ['required', 'string', 'max:20', 'unique:'.Santri::class.',nisn'], 
            'tanggal_lahir_santri' => ['required', 'date', 'before:today'],
            'kelas_id' => ['required', 'exists:kelas_santris,id'], 
            'alamat_santri' => ['required', 'string', 'max:500'], 
        ]);

        // Gunakan Transaksi untuk memastikan kedua data tersimpan atau tidak sama sekali
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
                'nisn' => $request->nis, 
                'tanggal_lahir' => $request->tanggal_lahir_santri, 
                
                'kelas_id' => $request->kelas_id,     
                'alamat' => $request->alamat_santri,  
                
                // Kolom opsional lain:
                'tempat_lahir' => null, 
            ]);

            event(new Registered($wali)); 
            Auth::login($wali); 
        });

        // Redirect ke dashboard
        return redirect(route('dashboard', absolute: false));
    }
}