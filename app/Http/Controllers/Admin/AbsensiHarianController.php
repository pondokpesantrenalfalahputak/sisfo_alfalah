<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AbsensiHarianController extends Controller
{
    /**
     * Data Kegiatan yang Mungkin Ada
     * (Digunakan di selectActivity)
     */
    public static $allActivities = [
        'Sholat' => [
            'Subuh' => 'fas fa-sun', 
            'Duha' => 'fas fa-cloud-sun', 
            'Dzuhur' => 'fas fa-cloud-sun-rain', 
            'Ashar' => 'fas fa-cloud-moon', 
            'Maghrib' => 'fas fa-moon', 
            'Isya' => 'fas fa-star'
        ],
        'Mengaji & Formal' => [
            'Qiroati' => 'fas fa-book-reader', 
            'Ngaji Pagi' => 'fas fa-book-open', 
            'Sekolah Formal' => 'fas fa-school'
        ],
        'Lainnya' => [
            'Roan Kebersihan' => 'fas fa-broom', 
            'Lain-lain' => 'fas fa-info-circle'
        ]
    ];

    /**
     * Mock Data: Daftar semua kelas yang tersedia.
     */
    private function getMockKelasData() {
        // GANTI dengan pengambilan data dari tabel 'kelas_santri' Anda yang sesungguhnya
        return [
            7 => 'Kelas 7 MTs', 8 => 'Kelas 8 MTs', 9 => 'Kelas 9 MTs',
            10 => 'Kelas 10 MA', 11 => 'Kelas 11 MA', 12 => 'Kelas 12 MA',
            13 => 'Mutakhorijin (Kelas 13)'
        ];
    }
    
    /**
     * Langkah 1: Menampilkan daftar semua kelas untuk dipilih.
     */
    public function index()
    {
        $kelasList = $this->getMockKelasData();
        $date = Carbon::now()->translatedFormat('d F Y');

        // Menggunakan view path yang diminta: admin.absensi.harian.index
        return view('admin.absensi.harian.index', compact('kelasList', 'date')); 
    }

    /**
     * Langkah 2: Menampilkan daftar kegiatan setelah kelas dipilih.
     * @param  int  $kelas_id
     */
    public function selectActivity($kelas_id)
    {
        $kelasList = $this->getMockKelasData();
        
        if (!isset($kelasList[$kelas_id])) {
            return redirect()->route('admin.absensi_baru.index')->with('error', 'Kelas tidak ditemukan.');
        }

        $kelas_nama = $kelasList[$kelas_id];
        $activities = self::$allActivities;
        $date = Carbon::now()->translatedFormat('d F Y');

        // Menggunakan view path yang diminta: admin.absensi.harian.select_activity
        return view('admin.absensi.harian.select_activity', compact('kelas_id', 'kelas_nama', 'activities', 'date'));
    }

    /**
     * Langkah 3: Menampilkan formulir input absensi.
     * @param  \Illuminate\Http\Request  $request
     */
    public function create(Request $request)
    {
        $kelas_id = $request->input('kelas');
        $kegiatan_spesifik = $request->input('kegiatan_spesifik');

        if (!$kelas_id || !$kegiatan_spesifik) {
             return redirect()->route('admin.absensi_baru.index')->with('error', 'Parameter tidak lengkap.');
        }

        // --- MOCK DATA SANTRI (GANTI DENGAN QUERY SESUNGGUHNYA) ---
        $santri = $this->getMockSantriByKelas($kelas_id);
        
        $kelas_nama = $this->getMockKelasData()[$kelas_id] ?? 'Kelas Tidak Dikenal';
        $date = Carbon::now()->translatedFormat('d F Y');

        // Menggunakan view path yang diminta: admin.absensi.harian.create
        return view('admin.absensi.harian.create', compact('kelas_id', 'kelas_nama', 'kegiatan_spesifik', 'santri', 'date'));
    }

    /**
     * Mock function untuk mengambil data santri.
     */
    private function getMockSantriByKelas($kelasId) {
        $santri = [];
        for ($i = 1; $i <= 5; $i++) {
            $santri[] = (object)[
                'id' => $kelasId * 100 + $i,
                'nama' => "Santri " . $kelasId . " - " . $i,
                'nisn' => "NISN" . $kelasId . $i
            ];
        }
        return collect($santri); 
    }

    /**
     * Proses penyimpanan data absensi.
     */
    public function store(Request $request)
    {
        // Logika penyimpanan data absensi Anda
        
        $kelas_nama = $this->getMockKelasData()[$request->kelas_id] ?? 'Kelas';
        $kegiatan = $request->kegiatan_spesifik;
        
        return redirect()->route('admin.absensi_baru.index')
            ->with('success', "Absensi untuk {$kelas_nama} kegiatan '{$kegiatan}' berhasil disimpan!");
    }
}