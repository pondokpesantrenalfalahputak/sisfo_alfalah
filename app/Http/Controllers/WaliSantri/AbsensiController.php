<?php

namespace App\Http\Controllers\WaliSantri;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Santri;
use Carbon\Carbon;

// Asumsi model AbsensiHarian untuk data harian
use App\Models\AbsensiHarian; 

class AbsensiController extends Controller
{
    /**
     * Menampilkan daftar rekapitulasi absensi bulanan untuk santri yang diwalikan.
     */
    public function index(Request $request)
    {
        $waliId = Auth::id();
        
        // Dapatkan parameter filter dari request
        $bulanFilter = $request->get('bulan');
        $tahunFilter = $request->get('tahun');
        
        // Tentukan apakah filter sedang diterapkan
        $isFiltered = $bulanFilter !== null || $tahunFilter !== null;
        
        // 1. Ambil Santri yang diwalikan oleh user yang sedang login ($waliId).
        $santriList = Santri::where('wali_santri_id', $waliId) 
            ->with([
                // Memuat relasi rekapitulasi absensi bulanan (Alpha)
                'absensiRekapitulasi' => function ($query) use ($bulanFilter, $tahunFilter) {
                    
                    if ($bulanFilter) {
                        $query->where('bulan', $bulanFilter);
                    }
                    if ($tahunFilter) {
                        $query->where('tahun', $tahunFilter);
                    }

                    $query->orderBy('tahun', 'desc')
                          ->orderBy('bulan', 'desc');
                },
                'kelas' 
            ])
            ->orderBy('nama_lengkap', 'asc')
            ->get();
        
        return view('wali.absensi.index', compact('santriList'));
    }

    /**
     * Menampilkan detail absensi harian untuk santri tertentu.
     */
    public function show(Santri $santri, Request $request)
    {
        // 1. Otorisasi
        if ($santri->wali_santri_id !== Auth::id()) {
            abort(403, 'Anda tidak memiliki akses untuk melihat data absensi santri ini.');
        }

        // 2. Filter Tanggal
        $dateFilter = $request->get('tanggal', Carbon::now()->toDateString());
        
        // 3. Ambil Data Absensi Harian untuk santri dan tanggal tersebut
        $absensiHarian = AbsensiHarian::where('santri_id', $santri->id)
            // ✅ KOREKSI: Menggunakan kolom 'tanggal_absensi'
            ->whereDate('tanggal_absensi', $dateFilter)
            ->orderBy('jenis_kegiatan', 'asc') // Mengasumsikan Anda ingin mengurutkan berdasarkan jenis_kegiatan
            ->get();

        // 4. Ambil 30 tanggal terakhir yang memiliki catatan absensi (untuk navigasi)
        $availableDates = AbsensiHarian::where('santri_id', $santri->id)
            // ✅ KOREKSI: Menggunakan kolom 'tanggal_absensi'
            ->selectRaw('DATE(tanggal_absensi) as date')
            ->distinct()
            ->orderBy('date', 'desc')
            ->limit(30)
            ->pluck('date');

        return view('wali.absensi.show', compact('santri', 'absensiHarian', 'dateFilter', 'availableDates'));
    }
}