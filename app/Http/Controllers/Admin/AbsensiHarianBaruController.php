<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

// ✅ IMPORT MODEL YANG DIPERLUKAN
use App\Models\Santri;
use App\Models\AbsensiHarian;
use App\Models\WaliNotification; 
use Illuminate\Support\Str; 


class AbsensiHarianBaruController extends Controller
{
    /**
     * Data Kegiatan yang Mungkin Ada (Static)
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
            'Ngaji Siang' => 'fas fa-book-reader',
            'Ngaji Sore' => 'fas fa-book',
            'Sekolah Formal' => 'fas fa-school'
        ],
        'Lainnya' => [
            'Roan Kebersihan Pagi' => 'fas fa-broom',
            'Roan Kebersihan Sore' => 'fas fa-broom',
            'Lain-lain' => 'fas fa-info-circle'
        ]
    ];

    /**
     * Mock Data: Daftar semua kelas yang tersedia.
     */
    private function getMockKelasData() {
        return [
            1 => 'Kelas 7 MTs',
            2 => 'Kelas 8 MTs',
            3 => 'Kelas 9 MTs',
            4 => 'Kelas 10 MA',
            5 => 'Kelas 11 MA',
            6 => 'Kelas 12 MA',
            7 => 'Mutakhorijin (Kelas 13)'
        ];
    }
    
    // ----------------------------------------------------
    // --- Langkah 1: INDEX ---
    // ----------------------------------------------------
    public function index()
    {
        $kelasList = $this->getMockKelasData();
        $date = Carbon::now()->translatedFormat('d F Y');

        return view('admin.absensi.harian.index', compact('kelasList', 'date'));
    }

    // ----------------------------------------------------
    // --- Langkah 2: SELECT ACTIVITY ---
    // ----------------------------------------------------
    public function selectActivity($kelas_id)
    {
        $kelas_id = (int) $kelas_id;
        $kelasList = $this->getMockKelasData();
        
        if (!isset($kelasList[$kelas_id])) {
            return redirect()->route('admin.absensi_baru.index')->with('error', 'Kelas tidak ditemukan.');
        }

        $kelas_nama = $kelasList[$kelas_id];
        $activities = self::$allActivities;
        
        // Logika Filtering Kegiatan (dibiarkan lengkap)
        $isMTs = in_array($kelas_id, [1, 2, 3]);
        $isMA = in_array($kelas_id, [4, 5, 6]);
        
        $mengajiKey = 'Mengaji & Formal';
        $lainnyaKey = 'Lainnya';
        
        if ($isMTs) {
            unset($activities[$mengajiKey]['Ngaji Pagi']);
            unset($activities[$mengajiKey]['Ngaji Siang']);
            unset($activities[$lainnyaKey]['Roan Kebersihan Pagi']);
        } elseif ($isMA) {
            unset($activities[$mengajiKey]['Ngaji Siang']);
            unset($activities[$mengajiKey]['Ngaji Sore']);
            unset($activities[$lainnyaKey]['Roan Kebersihan Sore']);
        } else {
            unset($activities[$mengajiKey]['Ngaji Sore']);
            unset($activities[$lainnyaKey]['Roan Kebersihan Sore']);
        }

        $date = Carbon::now()->translatedFormat('d F Y');

        return view('admin.absensi.harian.select_activity', compact('kelas_id', 'kelas_nama', 'activities', 'date'));
    }

    // ----------------------------------------------------
    // --- Langkah 3: CREATE ---
    // ----------------------------------------------------
    public function create(Request $request)
    {
        $kelas_id = $request->input('kelas');
        $kegiatan_spesifik = $request->input('kegiatan_spesifik');

        if (!$kelas_id || !$kegiatan_spesifik) {
             return redirect()->route('admin.absensi_baru.index')->with('error', 'Parameter tidak lengkap.');
        }

        $kelas_id = (int) $kelas_id;

        // Mengambil daftar santri berdasarkan kelas_id
        $santri = Santri::where('kelas_id', $kelas_id)
                         ->orderBy('nama_lengkap', 'asc')
                         ->get();
        
        $kelas_nama = $this->getMockKelasData()[$kelas_id] ?? 'Kelas Tidak Dikenal';
        $date = Carbon::now()->translatedFormat('d F Y');

        return view('admin.absensi.harian.create', compact('kelas_id', 'kelas_nama', 'kegiatan_spesifik', 'santri', 'date'));
    }

    // ----------------------------------------------------
    // --- Langkah 4: STORE ---
    // ----------------------------------------------------
    public function store(Request $request)
    {
        // 1. VALIDASI INPUT
        $request->validate([
            'kelas_id' => 'required|integer',
            'kegiatan_spesifik' => 'required|string',
            'tanggal_absensi' => 'required|date',
            'kehadiran' => 'required|array',
            'keterangan' => 'nullable|array',
        ]);
        
        $adminId = Auth::id();
        $kelas_id = $request->kelas_id;
        $kegiatan_spesifik = $request->kegiatan_spesifik;
        $tanggal_absensi = $request->tanggal_absensi;
        $status_kehadiran = $request->kehadiran;
        $keterangan_santri = $request->keterangan ?? [];
        
        $savedCount = 0;
        
        // Cek Duplikasi Unik (Pencegahan input ganda)
        $existingInput = AbsensiHarian::where('tanggal_absensi', $tanggal_absensi)
                                          ->where('jenis_kegiatan', $kegiatan_spesifik)
                                          ->exists();
        
        if ($existingInput) {
            $kelas_nama = $this->getMockKelasData()[(int) $kelas_id] ?? 'Kelas';
            
            $errorMessage = "⚠️ MAAF! Absensi kegiatan '{$kegiatan_spesifik}' untuk tanggal " .
                            Carbon::parse($tanggal_absensi)->translatedFormat('d F Y') .
                            " sudah terisi.";
                            
            return redirect()->back()
                ->withInput()
                ->with('error', $errorMessage);
        }
        
        // 2. LOOPING DAN PENYIMPANAN DATA (Dilakukan dalam Transaction)
        DB::transaction(function () use ($status_kehadiran, $keterangan_santri, $tanggal_absensi, $kegiatan_spesifik, $adminId, &$savedCount) {
            
            $validStatuses = ['Hadir', 'Alfa', 'Izin', 'Sakit'];

            foreach ($status_kehadiran as $santri_id => $status) {
                
                if (!in_array($status, $validStatuses)) {
                    continue;
                }

                // Ambil data Santri
                $santri = Santri::find($santri_id); 
                
                // Jika Santri tidak ditemukan, lewati.
                if (!$santri) { 
                    continue; 
                }
                
                // 🛑 PERBAIKAN 1: Ambil Wali ID dari kolom yang BENAR
                $waliId = $santri->wali_santri_id; 
                
                
                // Hapus data lama (Mekanisme Edit/Overwrite)
                AbsensiHarian::where('santri_id', $santri_id)
                            ->where('tanggal_absensi', $tanggal_absensi)
                            ->where('jenis_kegiatan', $kegiatan_spesifik)
                            ->delete();

                // Simpan data baru ABSENSI
                AbsensiHarian::create([
                    'santri_id' => $santri_id,
                    'wali_input_id' => $adminId,
                    'tanggal_absensi' => $tanggal_absensi,
                    'jenis_kegiatan' => $kegiatan_spesifik,
                    'status' => $status,
                    'keterangan' => $keterangan_santri[$santri_id] ?? null,
                ]);
                
                // 🔔 LOGIKA NOTIFIKASI: Hanya jika status non-Hadir DAN waliId terisi 🔔
                if ($status != 'Hadir' && $waliId) { 
                    
                    $keteranganDetail = $keterangan_santri[$santri_id] ?? null;

                    $notifTitle = "Absensi Santri: " . $santri->nama_lengkap;
                    $notifBody = "Status {$santri->nama_lengkap} pada kegiatan '{$kegiatan_spesifik}' tanggal " . 
                                 Carbon::parse($tanggal_absensi)->translatedFormat('d F Y') . 
                                 " adalah {$status}." .
                                 ($keteranganDetail ? " Keterangan: " . Str::limit($keteranganDetail, 50) : "");

                    WaliNotification::create([
                        'user_id' => $waliId, // ID Wali Santri (Penerima)
                        'title' => $notifTitle,
                        'body' => $notifBody,
                        
                        // 🛑 PERBAIKAN 2 & 3: Menggunakan 'wali.absensi.show' dan parameter Santri ID
                        'link' => route('wali.absensi.show', [ 
                            'santri' => $santri->id, 
                            'tanggal' => $tanggal_absensi
                        ]), 
                        'is_read' => false,
                    ]);
                }
                
                $savedCount++;
            }
        });
        
        // 3. RESPON PENGEMBALIAN SUKSES
        $kelas_nama = $this->getMockKelasData()[(int) $kelas_id] ?? 'Kelas';
        
        if ($savedCount > 0) {
            $message = "Absensi untuk {$kelas_nama} kegiatan '{$kegiatan_spesifik}' (untuk {$savedCount} santri) berhasil disimpan! ✅";
            return redirect()->route('admin.absensi_baru.index')->with('success', $message);
        } else {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Tidak ada data absensi valid yang tersimpan. Pastikan data Santri tersedia di database.');
        }
    }
}