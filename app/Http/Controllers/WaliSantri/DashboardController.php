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
            if ($tagihan->isLunas()) {
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
        // ✅ PERBAIKAN LOGIKA ABSENSI HARIAN (Menggunakan Grouping)
        // =========================================================
        $santris->each(function ($santri) use ($hariIni) {
            // Ambil SEMUA data absensi untuk hari ini
            $absensis = AbsensiHarian::where('santri_id', $santri->id)
                              ->whereDate('tanggal_absensi', $hariIni) 
                              ->get();
                              
            // Kelompokkan absensi berdasarkan jenis_kegiatan (keyBy)
            // Ini akan menghasilkan koleksi yang bisa diakses seperti: $absensiHariIni['Shubuh']
            $absensiGrouped = $absensis->keyBy('jenis_kegiatan');

            // Lampirkan hasil grouping ke objek santri
            $santri->absensiHariIni = $absensiGrouped;
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