<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Santri; // <-- PENTING: Import model Santri
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB; // Opsional, tapi baik untuk transaksi

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        return view('admin.master.user.index', compact('users'));
    }

    public function create()
    {
        return view('admin.master.user.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|string|in:admin,wali_santri',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);

        return redirect()->route('admin.user.index')->with('success', 'User berhasil ditambahkan.');
    }

    public function show(User $user)
    {
        return view('admin.master.user.show', compact('user'));
    }

    public function edit(User $user)
    {
        return view('admin.master.user.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8|confirmed',
            'role' => 'required|string|in:admin,wali_santri',
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
        ]);

        if ($request->password) {
            $user->update(['password' => Hash::make($request->password)]);
        }

        return redirect()->route('admin.user.index')->with('success', 'User berhasil diperbarui.');
    }

    /**
     * Hapus pengguna, dengan penanganan khusus untuk Wali Santri.
     */
    public function destroy(User $user)
    {
        // Pastikan pengguna memiliki relasi 'santris' di model User
        // dan kolom 'wali_santri_id' di tabel 'santris' adalah nullable.

        // Jika pengguna yang dihapus adalah Wali Santri
        if ($user->role === 'wali_santri') {
            
            // 1. Putuskan relasi (SET NULL):
            // Temukan semua Santri yang terhubung dengan Wali ini dan set 'wali_santri_id' mereka menjadi NULL.
            // Asumsi model User memiliki method relasi hasMany bernama 'santris()'
            try {
                // Menggunakan relasi Santri dari model User
                $user->santris()->update(['wali_santri_id' => null]);

            } catch (\Exception $e) {
                // Handle jika ada masalah saat update (misal: wali_santri_id tidak nullable)
                return redirect()->route('admin.user.index')->with('error', 'Gagal memutus relasi Santri. Pastikan wali_santri_id di tabel santris dapat bernilai NULL.');
            }
        }
        
        // 2. Hapus pengguna (Sekarang aman)
        $user->delete();
        
        return redirect()->route('admin.user.index')->with('success', 'User berhasil dihapus.');
    }
}