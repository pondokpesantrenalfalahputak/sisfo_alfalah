<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ProfileController;

// =========================================================================
// 1. IMPOR CONTROLLERS
// =========================================================================

// Import Admin Controllers
use App\Http\Controllers\Admin\DashboardController as AdminDashboard;
use App\Http\Controllers\Admin\SantriController as AdminSantri;
use App\Http\Controllers\Admin\GuruController as AdminGuru;
use App\Http\Controllers\Admin\KelasSantriController as AdminKelas;
use App\Http\Controllers\Admin\UserController as AdminUser;
use App\Http\Controllers\Admin\TagihanController as AdminTagihan;
use App\Http\Controllers\Admin\PengumumanController as AdminPengumuman;
use App\Http\Controllers\Admin\RekeningController as AdminRekening;
use App\Http\Controllers\Admin\AbsensiRekapitulasiController as AdminAbsensiRekap;
use App\Http\Controllers\Admin\AbsensiHarianController as AdminAbsensiHarian; 
use App\Http\Controllers\Admin\AbsensiHarianBaruController; 


// Import Wali Santri Controllers
use App\Http\Controllers\WaliSantri\DashboardController as WaliDashboard;
use App\Http\Controllers\WaliSantri\TagihanController as WaliTagihan;
use App\Http\Controllers\WaliSantri\SantriController as WaliSantri;
use App\Http\Controllers\WaliSantri\PengumumanController as WaliPengumuman;
use App\Http\Controllers\WaliSantri\AbsensiController as WaliAbsensi; 

// 🚀 BARU: Import Controller Notifikasi
use App\Http\Controllers\WaliSantri\WaliNotifikasiController; 


// =========================================================================
// 2. RUTE PUBLIK & REDIRECT DASHBOARD (Setelah Login)
// =========================================================================

/**
 * Rute Root: Redirect ke dashboard yang sesuai jika sudah login.
 */
Route::get('/', function () {
    if (Auth::check()) {
        if (Auth::user()->isAdmin()) {
            return redirect()->route('admin.dashboard');
        }
        return redirect()->route('wali.dashboard');
    }
    return view('welcome'); // Tampilkan halaman default Laravel atau landing page
});

/**
 * Dashboard Redirector: URL /dashboard akan mengarahkan ke role yang benar.
 */
Route::get('/dashboard', function () {
    if (Auth::check()) {
        if (Auth::user()->isAdmin()) {
            return redirect()->route('admin.dashboard');
        }
        return redirect()->route('wali.dashboard');
    }
})->middleware(['auth', 'verified'])->name('dashboard');

// =========================================================================
// 3. RUTE OTENTIKASI (Wajib ada)
// =========================================================================

// Memuat semua rute otentikasi (login, register, reset password, dll.) dari auth.php
require __DIR__.'/auth.php';


// =========================================================================
// 4. RUTE KHUSUS SETELAH LOGIN (auth)
// =========================================================================
Route::middleware('auth')->group(function () {
    // Blok ini kini kosong karena rute profil telah dipindahkan ke group 'admin' dan 'wali'
});


// =========================================================================
// 5. RUTE untuk ADMIN (Akses: /admin/*)
// Membutuhkan Middleware 'admin' untuk otorisasi
// =========================================================================
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    
    // Dashboard
    Route::get('/dashboard', [AdminDashboard::class, 'index'])->name('dashboard');

    // RUTE PROFIL UNTUK ADMIN (SOLUSI UNTUK admin.profile.update)
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::put('/profile/update-data', [ProfileController::class, 'updateData'])->name('profile.update');
    Route::put('/profile/update-password', [ProfileController::class, 'updatePassword'])->name('profile.password');

    // Master Data
    Route::resource('santri', AdminSantri::class);
    Route::resource('guru', AdminGuru::class);
    Route::resource('kelas', AdminKelas::class)->parameters(['kelas' => 'kela']); 
    Route::resource('user', AdminUser::class);

    // ---------------------------------------------------------------------
    // RUTE ABSENSI HARIAN (SISTEM LAMA: Kegiatan -> Kelas)
    // URL: /admin/absensi
    // ---------------------------------------------------------------------
    Route::prefix('absensi')->name('absensi.')->group(function () {
        // Tampilan daftar kelas untuk memilih absensi
        Route::get('/', [AdminAbsensiHarian::class, 'index'])->name('index'); 

        // Formulir Absensi Harian
        Route::get('/{jenis_kegiatan}/{kegiatan_spesifik}/{kelas}', [AdminAbsensiHarian::class, 'create'])
            ->name('harian.create'); 
            
        // Menyimpan data Absensi Harian
        Route::post('/', [AdminAbsensiHarian::class, 'store'])->name('harian.store'); 
    });

    // ---------------------------------------------------------------------
    // RUTE ABSENSI HARIAN (SISTEM BARU: Kelas -> Kegiatan)
    // URL: /admin/absensi-baru
    // ---------------------------------------------------------------------
    Route::prefix('absensi')->name('absensi_baru.')->group(function () {
        // [Langkah 1] Tampilkan daftar kelas
        Route::get('/', [AbsensiHarianBaruController::class, 'index'])->name('index'); 

        // ✅ [Langkah 3] Tampilkan formulir absensi (HARUS DIDEFINISIKAN PERTAMA)
        // Ini adalah rute statis.
        Route::get('/create', [AbsensiHarianBaruController::class, 'create'])->name('create'); 

        // [Langkah 2] Pilih kegiatan untuk kelas tertentu (Didefinisikan KEDUA)
        // Ini adalah rute parameter.
        Route::get('/{kelas_id}', [AbsensiHarianBaruController::class, 'selectActivity'])->name('select_activity'); 

        // [Langkah 4] Simpan absensi
        Route::post('/store', [AbsensiHarianBaruController::class, 'store'])->name('store');
    });

    // BARU: RUTE ABSENSI REKAPITULASI BULANAN (CRUD)
    Route::resource('absensi_rekap', AdminAbsensiRekap::class)->except(['show', 'create']);

    // Rute Kustom untuk Form Input Bulanan Massal
    Route::get('absensi_rekap/create_multi', [AdminAbsensiRekap::class, 'createMulti'])->name('absensi_rekap.create_multi');
    Route::post('absensi_rekap/store_multi', [AdminAbsensiRekap::class, 'storeMulti'])->name('absensi_rekap.store_multi');
    
    // Keuangan & Konfirmasi
    Route::get('tagihan/konfirmasi', [AdminTagihan::class, 'konfirmasiPembayaran'])->name('tagihan.konfirmasi.index');
    Route::post('tagihan/konfirmasi/{pembayaran}', [AdminTagihan::class, 'prosesKonfirmasi'])->name('tagihan.konfirmasi.proses');
    Route::get('pembayaran/riwayat', [AdminTagihan::class, 'riwayatPembayaran'])->name('pembayaran.riwayat');
    Route::resource('tagihan', AdminTagihan::class)->only(['index', 'create', 'store', 'show', 'edit', 'update', 'destroy']);

    // Komunikasi & Pengaturan
    Route::resource('pengumuman', AdminPengumuman::class);
    Route::resource('rekening', AdminRekening::class);
});


// =========================================================================
// 6. RUTE untuk WALI SANTRI (Akses: /wali/*)
// Membutuhkan Middleware 'auth' dan 'wali_santri'
// =========================================================================
Route::middleware(['auth', 'wali_santri'])->prefix('wali')->name('wali.')->group(function () {
    
    // Dashboard
    Route::get('/dashboard', [WaliDashboard::class, 'index'])->name('dashboard');

    // RUTE PROFIL UNTUK WALI SANTRI
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::put('/profile/update-data', [ProfileController::class, 'updateData'])->name('profile.update');
    Route::put('/profile/update-password', [ProfileController::class, 'updatePassword'])->name('profile.password');

    // Tagihan dan Pembayaran
    Route::get('/tagihan', [WaliTagihan::class, 'index'])->name('tagihan.index');
    Route::get('/tagihan/{tagihan}', [WaliTagihan::class, 'show'])->name('tagihan.show');
    Route::post('/tagihan/{tagihan}/bayar', [WaliTagihan::class, 'bayar'])->name('tagihan.bayar');

    // Data Santri
    Route::resource('santri', WaliSantri::class)->only(['index', 'show']);

    // Pengumuman
    Route::get('/pengumuman', [WaliPengumuman::class, 'index'])->name('pengumuman.index');
    Route::get('/pengumuman/{pengumuman}', [WaliPengumuman::class, 'show'])->name('pengumuman.show');

    // RUTE ABSENSI
    Route::get('/absensi', [WaliAbsensi::class, 'index'])->name('absensi.index');
    Route::get('/absensi/{santri}', [WaliAbsensi::class, 'show'])->name('absensi.show'); 
    
    // 🚀 BLOK ROUTE NOTIFIKASI KUSTOM
    // Ini adalah blok yang ditambahkan untuk mendefinisikan rute wali.notifikasi.*
    Route::controller(WaliNotifikasiController::class)->prefix('notifikasi')->name('notifikasi.')->group(function () {
        Route::get('/', 'index')->name('index'); // wali.notifikasi.index (Daftar Notifikasi)
        Route::post('/read-all', 'markAllRead')->name('mark_all_read'); // wali.notifikasi.mark_all_read
        // Menggunakan Route Model Binding untuk Model Kustom Notifikasi Anda
        Route::post('/{notifikasi}/read', 'markRead')->name('mark_read'); // wali.notifikasi.mark_read
    });

}); // Akhir dari grup route WALI SANTRI