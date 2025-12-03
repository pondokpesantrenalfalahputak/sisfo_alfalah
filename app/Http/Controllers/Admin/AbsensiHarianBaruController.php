<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
// ✅ IMPORT MODEL YANG DIPERLUKAN
use App\Models\Santri; 
use App\Models\AbsensiHarian; 
use Illuminate\Support\Facades\Auth; 
// Model KelasSantri dikomentari karena menggunakan mock data untuk saat ini.
// use App\Models\KelasSantri; 

class AbsensiHarianBaruController extends Controller
{
    /**
     * Data Kegiatan yang Mungkin Ada
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
        // Kegiatan yang spesifik berdasarkan waktu/tingkat
        'Mengaji & Formal' => [
            'Qiroati' => 'fas fa-book-reader',
            'Ngaji Pagi' => 'fas fa-book-open',
            'Ngaji Siang' => 'fas fa-book-reader',
            'Ngaji Sore' => 'fas fa-book',
            'Sekolah Formal' => 'fas fa-school'
        ],
        // Kegiatan Lainnya (Roan)
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
        // PERHATIAN: Ini adalah data statis (MOCK). Ganti dengan query database yang sebenarnya di implementasi nyata.
        return [
            4 => 'Kelas 7 MTs',
            5 => 'Kelas 8 MTs',
            6 => 'Kelas 9 MTs',
            7 => 'Kelas 10 MA',
            8 => 'Kelas 11 MA',
            9 => 'Kelas 12 MA',
            10 => 'Mutakhorijin (Kelas 13)'
        ];
    }
    
    // --- Langkah 1: INDEX ---
    public function index()
    {
        $kelasList = $this->getMockKelasData();
        // Menggunakan Carbon untuk mendapatkan tanggal hari ini dalam format bahasa Indonesia
        $date = Carbon::now()->translatedFormat('d F Y');

        return view('admin.absensi.harian.index', compact('kelasList', 'date')); 
    }

    // --- Langkah 2: SELECT ACTIVITY (Memfilter Kegiatan Berdasarkan Kelas) ---
    public function selectActivity($kelas_id)
    {
        $kelas_id = (int) $kelas_id; 
        $kelasList = $this->getMockKelasData();
        
        if (!isset($kelasList[$kelas_id])) {
            return redirect()->route('admin.absensi_baru.index')->with('error', 'Kelas tidak ditemukan.');
        }

        $kelas_nama = $kelasList[$kelas_id];
        $activities = self::$allActivities;
        
        // Logika filtering kegiatan berdasarkan tipe Kelas
        $isMTs = in_array($kelas_id, [4, 5, 6]);
        $isMA = in_array($kelas_id, [7, 8, 9]);
        $isMutakhorijin = ($kelas_id == 10);
        
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
        } elseif ($isMutakhorijin) {
            unset($activities[$mengajiKey]['Ngaji Sore']);
            unset($activities[$lainnyaKey]['Roan Kebersihan Sore']);
        } else {
            // Logika default jika kelas tidak dikenal
            unset($activities[$mengajiKey]['Ngaji Pagi']);
            unset($activities[$mengajiKey]['Ngaji Siang']);
            unset($activities[$mengajiKey]['Ngaji Sore']);
            unset($activities[$lainnyaKey]['Roan Kebersihan Pagi']);
            unset($activities[$lainnyaKey]['Roan Kebersihan Sore']);
        }

        $date = Carbon::now()->translatedFormat('d F Y');

        return view('admin.absensi.harian.select_activity', compact('kelas_id', 'kelas_nama', 'activities', 'date'));
    }

    // --- Langkah 3: CREATE (Menampilkan Daftar Santri) ---
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

    // --- Langkah 4: STORE (Implementasi Unique Input Check) ---
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
        
        // 🚨 Cek Duplikasi Unik (1 Kegiatan 1 Kali Per Hari) 🚨
        $existingInputCount = AbsensiHarian::where('tanggal_absensi', $tanggal_absensi)
                                          ->where('jenis_kegiatan', $kegiatan_spesifik)
                                          ->exists(); 
        
        if ($existingInputCount) {
             // ❌ LOGIKA PENOLAKAN DENGAN PESAN RAMAH
            $kelas_nama = $this->getMockKelasData()[(int) $kelas_id] ?? 'Kelas';
            
            $errorMessage = "⚠️ MAAF! Absensi kegiatan '{$kegiatan_spesifik}' untuk tanggal " . 
                            Carbon::parse($tanggal_absensi)->translatedFormat('d F Y') . 
                            " sudah terisi. Anda harus memilih kategori kegiatan lain yang belum terinput.";
                            
            // Langsung kembalikan error
            return redirect()->back()
                ->withInput()
                ->with('error', $errorMessage);
        }
        
        // 2. LOOPING DAN PENYIMPANAN DATA (Jika lulus cek duplikasi)
        foreach ($status_kehadiran as $santri_id => $status) {
            
            if (!in_array($status, ['Hadir', 'Alfa', 'Izin', 'Sakit'])) {
                 continue; 
            }

            // Hapus data lama (Mekanisme Edit/Overwrite jika Admin memproses data yang sama sebelum Unique Check diaktifkan)
            AbsensiHarian::where('santri_id', $santri_id)
                         ->where('tanggal_absensi', $tanggal_absensi)
                         ->where('jenis_kegiatan', $kegiatan_spesifik)
                         ->delete();

            // Simpan data baru
            AbsensiHarian::create([
                'santri_id' => $santri_id,
                'wali_input_id' => $adminId, 
                'tanggal_absensi' => $tanggal_absensi,
                'jenis_kegiatan' => $kegiatan_spesifik,
                'status' => $status,
                'keterangan' => $keterangan_santri[$santri_id] ?? null,
            ]);
            $savedCount++;
        }
        
        // 3. RESPON PENGEMBALIAN SUKSES
        $kelas_nama = $this->getMockKelasData()[(int) $kelas_id] ?? 'Kelas';
        
        if ($savedCount > 0) {
            $message = "Absensi untuk {$kelas_nama} kegiatan '{$kegiatan_spesifik}' (untuk {$savedCount} santri) berhasil disimpan! ✅";
            return redirect()->route('admin.absensi_baru.index')->with('success', $message);
        } else {
             return redirect()->back()
                ->withInput()
                ->with('error', 'Tidak ada data absensi valid yang tersimpan. Pastikan Anda memilih status kehadiran.');
        }
    }
}