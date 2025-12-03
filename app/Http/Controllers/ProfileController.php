<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;
use Illuminate\Validation\Rules\Password;

class ProfileController extends Controller
{
    /**
     * Helper untuk mendapatkan rute profil berbasis peran
     */
    protected function getProfileRoute(string $suffix = 'show'): string
    {
        if (Auth::user()->isAdmin()) {
            return 'admin.profile.' . $suffix;
        }
        return 'wali.profile.' . $suffix;
    }

    /**
     * Display the user's profile.
     */
    public function show(Request $request): View
    {
        // View ini akan secara dinamis mencari 'admin.profile.show' atau 'wali.profile.show'.
        // Karena view Anda bernama 'admin.profile.show', ini bisa menjadi masalah di mode Wali.
        // Untuk amannya, pastikan Anda memiliki view yang berbeda atau view yang sama yang dapat diakses dari kedua peran.
        
        // Agar kompatibel dengan kode yang Anda kirim (yang menggunakan view 'admin.profile.show'):
        $viewName = Auth::user()->isAdmin() ? 'admin.profile.show' : 'wali.profile.show';
        
        // CATATAN: Jika Anda hanya memiliki satu view, gunakan nama view tersebut.
        // Jika Anda memiliki view berbeda untuk wali (misal: 'wali.profile.show'), ubah kode di atas.
        
        return view($viewName, [ 
            'user' => $request->user(),
        ]);
    }

    /**
     * Tampilkan formulir profil pengguna untuk diedit. (Jarang digunakan)
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Perbarui informasi profil pengguna (Metode default).
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        // ⚠️ Rute default 'profile.edit' diubah menjadi rute berbasis peran
        $redirectRoute = $this->getProfileRoute('show'); 
        return Redirect::route($redirectRoute)->with('success', 'Profil berhasil diperbarui.');
    }

    /**
     * Update the user's profile data (untuk form Perbarui Data).
     */
    public function updateData(Request $request): RedirectResponse
    {
        $validatedData = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $request->user()->id],
        ]);

        $request->user()->fill($validatedData);

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        // ✅ PERBAIKAN: Gunakan helper untuk rute berbasis peran
        $redirectRoute = $this->getProfileRoute('show');
        return Redirect::route($redirectRoute)->with('success', 'Data profil berhasil diperbarui.');
    }

    /**
     * Update the user's password.
     */
    public function updatePassword(Request $request): RedirectResponse
    {
        $request->validate([
            'current_password' => ['required', 'current_password'], 
            'password' => ['required', 'confirmed', Password::defaults()], 
        ]);

        $request->user()->update([
            'password' => Hash::make($request->password),
        ]);
        
        // ✅ PERBAIKAN: Gunakan helper untuk rute berbasis peran
        $redirectRoute = $this->getProfileRoute('show');
        return Redirect::route($redirectRoute)->with('success', 'Kata sandi berhasil diperbarui.');
    }

    /**
     * Hapus akun pengguna.
     */
    public function destroy(Request $request): RedirectResponse
    {
        // Validasi password sebelum penghapusan
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        // Logout pengguna sebelum menghapus akun
        Auth::logout();

        // Hapus pengguna dari database
        $user->delete();

        // Batalkan sesi dan buat token baru
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}