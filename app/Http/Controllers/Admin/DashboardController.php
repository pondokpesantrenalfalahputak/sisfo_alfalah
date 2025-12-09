<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Santri;       // Model Santri
use App\Models\Pengumuman;   // Model Pengumuman
use App\Models\Tagihan;      // Model Tagihan
use App\Models\Guru;         // Model Guru
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Mendapatkan tahun dan bulan saat ini
        $currentYear = Carbon::now()->year;
        $currentMonth = Carbon::now()->month;

        // --- 1. Data Metric Cards ---

        $totalSantri = Santri::count();
        $totalGuru = Guru::count(); 
        $totalPengumuman = Pengumuman::count(); 

        // Menghitung total tunggakan (Tagihan dengan status 'belum_lunas')
        // MENGGUNAKAN 'jumlah_tagihan' (sesuai perbaikan)
        $totalTagihanBelumLunas = Tagihan::where('status', 'belum_lunas')
                                          ->sum('jumlah_tagihan'); 

        // --- 2. Data Status Keuangan (Dashboard Summary) ---
        
        // A. Persentase Lunas (Dihitung Berdasarkan Semua Tagihan Tahun Ini)
        $totalTagihanTahunIni = Tagihan::whereYear('tanggal_tagihan', $currentYear)->count();
        $totalLunasTahunIni = Tagihan::whereYear('tanggal_tagihan', $currentYear)
                                       ->where('status', 'lunas')
                                       ->count();

        $persentaseLunas = ($totalTagihanTahunIni > 0) 
                           ? round(($totalLunasTahunIni / $totalTagihanTahunIni) * 100) 
                           : 0;

        // B. Tagihan Bulan Ini (Total tagihan yang harus dibayar di bulan ini, terlepas dari status)
        $tagihanBulanIni = Tagihan::whereMonth('tanggal_tagihan', $currentMonth)
                                   ->whereYear('tanggal_tagihan', $currentYear)
                                   ->count();

        // C. Santri Terlambat Bayar (Santri yang memiliki tagihan 'belum_lunas' di bulan ini)
        $santriTerlambatBayar = Tagihan::whereMonth('tanggal_tagihan', $currentMonth)
                                        ->whereYear('tanggal_tagihan', $currentYear)
                                        ->where('status', 'belum_lunas')
                                        // Menggunakan distinct() untuk menghitung jumlah santri unik
                                        ->distinct('santri_id') 
                                        ->count('santri_id');


        // --- 3. Data Chart Pendaftaran Santri (Tahun Ini) ---

        // Ambil data pendaftaran per bulan dari database
        $registrations = Santri::select(
                DB::raw('MONTH(created_at) as month'),
                DB::raw('COUNT(*) as count')
            )
            ->whereYear('created_at', $currentYear)
            ->groupBy('month')
            ->orderBy('month')
            ->get()
            ->keyBy('month');
            
        // Siapkan label bulan dalam format M (Jan, Feb, dst.)
        $monthNames = [];
        for ($i = 1; $i <= 12; $i++) {
            // translatedFormat('M') memerlukan locale Carbon/Laravel yang diatur
            $monthNames[] = Carbon::create(null, $i, 1)->translatedFormat('M'); 
        }

        // Isi array data chart
        $data = array_fill(0, 12, 0); 
        foreach ($registrations as $reg) {
            $index = $reg->month - 1; 
            $data[$index] = $reg->count;
        }

        $chartData = [
            'labels' => $monthNames,
            'data' => $data,
        ];

        // --- 4. Data Tabel Pengumuman Terbaru ---
        $pengumumans = Pengumuman::latest('tanggal_publikasi')->take(5)->get();

        // --- 5. Meneruskan Variabel ke View ---
        return view('admin.dashboard', compact(
            'totalSantri',
            'totalGuru',
            'totalPengumuman',
            'totalTagihanBelumLunas',
            'persentaseLunas',
            'tagihanBulanIni',
            'santriTerlambatBayar',
            'chartData', 
            'pengumumans'
        ));
    }
}