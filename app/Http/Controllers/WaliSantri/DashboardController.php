<?php

namespace App\Http\Controllers\WaliSantri;

use App\Http\Controllers\Controller;
use App\Models\Santri;
use App\Models\Tagihan;
use App\Models\Pembayaran;
use App\Models\Pengumuman; 
use App\Models\AbsensiHarian; // Pastikan menggunakan model yang benar
use Carbon\Carbon;       
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Menampilkan dashboard utama untuk Wali Santri.
     */
    public function index()
    {
        // Mendapatkan ID Wali Santri yang sedang login
        $waliSantriId = auth()->id();
        $hariIni = Carbon::today(); 

        // 1. Data Santri
        $santris = Santri::where('wali_santri_id', $waliSantriId)
                         ->with('kelas')
                         ->get();
        
        $santriIds = $santris->pluck('id');
        $santriCount = $santris->count(); 
        
        // 2. Tagihan
        $semuaTagihan = Tagihan::whereIn('santri_id', $santriIds)->get();
        
        $tagihanBelumLunasCount = 0;
        $tagihanLunasCount = 0;
        
        foreach ($semuaTagihan as $tagihan) {
            // Asumsi model Tagihan memiliki metode isLunas()
            if (method_exists($tagihan, 'isLunas') && $tagihan->isLunas()) {
                $tagihanLunasCount++;
            } else {
                $tagihanBelumLunasCount++;
            }
        }
            
        // 3. Pembayaran Menunggu Konfirmasi
        $pembayaranMenungguCount = Pembayaran::whereHas('tagihan.santri', function ($query) use ($waliSantriId) {
            $query->where('wali_santri_id', $waliSantriId);
        })
        ->where('status_konfirmasi', 'Menunggu')
        ->count();

        // 4. Pengumuman Terbaru
        $pengumumanTerbaru = Pengumuman::where('status', 'published') 
                                 ->orderBy('tanggal_publikasi', 'desc')
                                 ->take(3)
                                 ->get();
        
        // =========================================================
        // ✅ PERBAIKAN & PENAMBAHAN LOGIKA ABSENSI HARIAN
        // =========================================================
        
        // Ambil SEMUA data absensi untuk hari ini untuk SEMUA santri terkait
        $absensiHariIni = AbsensiHarian::whereIn('santri_id', $santriIds)
                                       ->whereDate('tanggal_absensi', $hariIni)
                                       ->get();
        
        $santris->each(function ($santri) use ($absensiHariIni, $hariIni) {
            
            // --- Logika 1: Pengelompokan Absensi (Logika asli Anda) ---
            
            // Filter koleksi absensi yang sudah dimuat untuk santri ini
            $absensis = $absensiHariIni->where('santri_id', $santri->id);

            // Kelompokkan absensi berdasarkan jenis_kegiatan (keyBy)
            $absensiGrouped = $absensis->keyBy('jenis_kegiatan');

            // Lampirkan hasil grouping ke objek santri
            $santri->absensiHariIni = $absensiGrouped;
            
            // --- Logika 2: Menghitung Total Ketidakhadiran Hari Ini (Penambahan Anda) ---
            
            // Hitung total status non-Hadir (Izin, Sakit, Alfa) untuk hari ini
            $totalKetidakhadiran = $absensis->filter(function ($absensi) {
                return in_array($absensi->status, ['Izin', 'Sakit', 'Alfa']);
            })->count();

            // Lampirkan hasil hitungan ke objek santri
            $santri->totalKetidakhadiranHariIni = $totalKetidakhadiran;
        });

        // Mengirim semua data yang dibutuhkan ke view
        return view('wali.dashboard', compact(
            'santris',
            'santriCount', 
            'tagihanBelumLunasCount',
            'tagihanLunasCount',
            'pembayaranMenungguCount',
            'pengumumanTerbaru'
        ));
    }
}