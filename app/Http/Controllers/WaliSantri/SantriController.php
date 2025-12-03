<?php

namespace App\Http\Controllers\WaliSantri;

use App\Http\Controllers\Controller;
use App\Models\Santri; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // Tambahkan ini jika menggunakan Auth::id()

class SantriController extends Controller
{
    /**
     * Menampilkan daftar santri yang diasuh oleh Wali Santri yang sedang login.
     * Menerapkan otorisasi implicit melalui filter query.
     */
    public function index()
    {
        // Mendapatkan ID user yang sedang login (ID Wali Santri)
        $waliSantriId = auth()->id();

        // Mengambil santri yang wali_santri_id-nya sesuai dengan ID user yang login
        // Eager loading relasi 'kelas'
        $santris = Santri::where('wali_santri_id', $waliSantriId)
                         ->with('kelas') 
                         ->get();

        // Menggunakan view 'wali.santri.index' dan mengirim data $santris
        return view('wali.santri.index', compact('santris'));
    }

    /**
     * Menampilkan detail satu santri.
     */
    public function show(Santri $santri)
    {
        // Otorisasi: Pastikan santri ini milik wali yang sedang login
        // Menggunakan auth()->id() atau Auth::id() (keduanya valid jika Auth diimpor)
        if ($santri->wali_santri_id !== auth()->id()) {
            abort(403, 'Akses Ditolak. Data santri ini bukan asuhan Anda.');
        }

        /**
         * Eager load relasi yang dibutuhkan di detail view.
         * PENTING: Mengganti 'user' menjadi 'waliSantri' untuk menghindari RelationNotFoundException.
         */
        $santri->load('kelas', 'waliSantri'); 

        return view('wali.santri.show', compact('santri'));
    }
}