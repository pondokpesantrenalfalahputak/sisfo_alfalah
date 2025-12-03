<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
// Pastikan model Pengumuman diimport jika belum
use App\Models\Pengumuman; 

class DashboardController extends Controller
{
    public function index()
    {
        $totalSantri = \App\Models\Santri::count();
        $totalGuru = \App\Models\Guru::count();

        // Menghitung total jumlah tagihan yang belum lunas
        $totalTagihanBelumLunas = \App\Models\Tagihan::where('status', 'Belum Lunas')->sum('jumlah_tagihan');

        // Menghitung jumlah pengumuman aktif (atau semua pengumuman jika tidak ada status aktif)
        $totalPengumuman = \App\Models\Pengumuman::count();

        // >>> BARIS BARU DITAMBAHKAN DI SINI <<<
        // Mengambil 3 pengumuman terbaru untuk ditampilkan di dashboard
        $pengumumans = Pengumuman::latest('tanggal_publikasi')->take(3)->get();
        // >>> BARIS BARU BERAKHIR DI SINI <<<

        // Meneruskan semua variabel ke view menggunakan compact()
        return view('admin.dashboard', compact(
            'totalSantri',
            'totalGuru',
            'totalTagihanBelumLunas',
            'totalPengumuman',
            'pengumumans' // <-- VARIABEL INI HARUS DIKIRIMKAN KE VIEW
        ));
    }
}