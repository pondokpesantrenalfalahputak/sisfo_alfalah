<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str; 

// ✅ IMPORT KOMPONEN QUEUE/EVENT
use App\Models\User; // Digunakan untuk find Wali Santri
use App\Events\AttendanceUpdated; 

// ✅ IMPORT MODEL YANG DIPERLUKAN
use App\Models\Santri;
use App\Models\AbsensiHarian;
use App\Models\KelasSantri; 
// App\Models\WaliNotification TIDAK diimpor karena diganti Event/Queue

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

    // ----------------------------------------------------
    // --- Langkah 1: INDEX (PILIH KELAS) ---
    // ----------------------------------------------------
    public function index()
    {
        $kelasListData = KelasSantri::orderBy('tingkat', 'asc')->get();
        $date = Carbon::now()->translatedFormat('d F Y');
        return view('admin.absensi.harian.index', compact('kelasListData', 'date'));
    }

    // ----------------------------------------------------
    // --- Langkah 2: SELECT ACTIVITY (PILIH KEGIATAN) ---
    // ----------------------------------------------------
    public function selectActivity($kelas_id)
    {
        $kelas_id = (int) $kelas_id;
        
        $kelasData = KelasSantri::all()->pluck('nama_kelas', 'id');
        
        if (!isset($kelasData[$kelas_id])) {
            return redirect()->route('admin.absensi_baru.index')->with('error', 'Kelas tidak ditemukan.');
        }

        $kelas_nama = $kelasData[$kelas_id];
        $activities = self::$allActivities;
        
        // Logika Filtering Kegiatan
        $isMTs = in_array($kelas_id, [1, 2, 3]); 
        $isMA = in_array($kelas_id, [4, 5, 6]);
        
        $mengajiKey = 'Mengaji & Formal';
        $lainnyaKey = 'Lainnya';
        
        // PERHATIAN: Logika Filtering disinkronkan agar konsisten
        if ($isMTs) {
            unset($activities[$mengajiKey]['Ngaji sore']);
            unset($activities[$mengajiKey]['Ngaji Siang']);
            unset($activities[$lainnyaKey]['Roan Kebersihan sore']);
        } elseif ($isMA) {
            unset($activities[$mengajiKey]['Ngaji pagi']);
            unset($activities[$mengajiKey]['Ngaji siang']);
            unset($activities[$lainnyaKey]['Roan Kebersihan pagi']);
        } else {
            // Logika default jika kelas_id tidak tergolong MTs/MA tertentu
            unset($activities[$mengajiKey]['Ngaji pagi']);
            unset($activities[$mengajiKey]['Ngaji siang']);
            unset($activities[$lainnyaKey]['Roan Kebersihan pagi']);
        }

        $date = Carbon::now()->translatedFormat('d F Y');

        return view('admin.absensi.harian.select_activity', compact('kelas_id', 'kelas_nama', 'activities', 'date'));
    }

    // ----------------------------------------------------
    // --- Langkah 3: CREATE (TAMPILKAN FORM) ---
    // ----------------------------------------------------
    public function create(Request $request)
    {
        $kelas_id = $request->input('kelas');
        $kegiatan_spesifik = $request->input('kegiatan_spesifik');

        if (!$kelas_id || !$kegiatan_spesifik) {
             return redirect()->route('admin.absensi_baru.index')->with('error', 'Parameter tidak lengkap.');
        }

        $kelas_id = (int) $kelas_id;

        $kelas_nama = KelasSantri::where('id', $kelas_id)->value('nama_kelas') ?? 'Kelas Tidak Dikenal';

        $santri = Santri::where('kelas_id', $kelas_id)
                         ->orderBy('nama_lengkap', 'asc')
                         ->get();
        
        $date = Carbon::now()->translatedFormat('d F Y');

        return view('admin.absensi.harian.create', compact('kelas_id', 'kelas_nama', 'kegiatan_spesifik', 'santri', 'date'));
    }

    // ----------------------------------------------------
    // --- Langkah 4: STORE (PROSES SIMPAN + QUEUE NOTIFIKASI) ---
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
            $kelas_nama = KelasSantri::where('id', (int) $kelas_id)->value('nama_kelas') ?? 'Kelas';
            
            $errorMessage = "⚠️ MAAF! Absensi kegiatan '{$kegiatan_spesifik}' untuk tanggal " .
                            Carbon::parse($tanggal_absensi)->translatedFormat('d F Y') .
                            " sudah terisi.";
                            
            return redirect()->back()->withInput()->with('error', $errorMessage);
        }
        
        // 2. LOOPING DAN PENYIMPANAN DATA (Dilakukan dalam Transaction)
        DB::transaction(function () use ($status_kehadiran, $keterangan_santri, $tanggal_absensi, $kegiatan_spesifik, $adminId, &$savedCount) {
            
            $validStatuses = ['Hadir', 'Alfa', 'Izin', 'Sakit'];

            foreach ($status_kehadiran as $santri_id => $status) {
                
                if (!in_array($status, $validStatuses)) { continue; }

                $santri = Santri::find($santri_id); 
                if (!$santri) { continue; }
                
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
                
                // 🔔 LOGIKA NOTIFIKASI: Memicu Event (ASINKRON) 🔔
                if ($status != 'Hadir' && $waliId) { 
                    
                    $waliSantri = User::find($waliId);
                    
                    if($waliSantri){
                        // PICU EVENT - Listener akan menangani pembuatan WaliNotification
                        event(new AttendanceUpdated(
                            $waliSantri, 
                            'Harian',
                            $kegiatan_spesifik 
                        ));
                    }
                }
                
                $savedCount++;
            }
        });
        
        // 3. RESPON PENGEMBALIAN SUKSES
        $kelas_nama = KelasSantri::where('id', (int) $kelas_id)->value('nama_kelas') ?? 'Kelas';
        
        if ($savedCount > 0) {
            $message = "Absensi untuk {$kelas_nama} kegiatan '{$kegiatan_spesifik}' (untuk {$savedCount} santri) berhasil disimpan! Notifikasi non-hadir telah dikirim ke Queue. ✅";
            return redirect()->route('admin.absensi_baru.index')->with('success', $message);
        } else {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Tidak ada data absensi valid yang tersimpan. Pastikan data Santri tersedia di database.');
        }
    }
}