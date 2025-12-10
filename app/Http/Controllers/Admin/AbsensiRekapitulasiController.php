<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AbsensiRekapitulasi;
use App\Models\Santri;
use App\Models\KelasSantri;
use App\Models\User; // ✅ Import User
use App\Events\AttendanceUpdated; // ✅ Import Event
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AbsensiRekapitulasiController extends Controller
{
    // ... (index, createMulti, edit, destroy methods tidak berubah) ...
    
    public function index(Request $request)
    {
        $bulan = $request->input('bulan', Carbon::now()->month);
        $tahun = $request->input('tahun', Carbon::now()->year);

        $absensis = AbsensiRekapitulasi::with(['santri', 'kelas', 'waliInput'])
            ->where('bulan', $bulan)
            ->where('tahun', $tahun)
            ->orderBy('kelas_id')
            ->orderBy('santri_id')
            ->paginate(20);

        return view('admin.absensi_rekap.index', compact('absensis', 'bulan', 'tahun'));
    }

    public function createMulti(Request $request)
    {
        $bulan = $request->input('bulan', Carbon::now()->month);
        $tahun = $request->input('tahun', Carbon::now()->year);
        $kelasId = $request->input('kelas_id');
        
        $kelasOptions = KelasSantri::all();
        $santris = collect([]);
        $dataAbsensiTersimpan = collect([]);

        if ($kelasId) {
            $santris = Santri::where('kelas_id', $kelasId)
                            ->orderBy('nama_lengkap')
                            ->get();

            $dataAbsensiTersimpan = AbsensiRekapitulasi::where('kelas_id', $kelasId)
                                  ->where('bulan', $bulan)
                                  ->where('tahun', $tahun)
                                  ->get()
                                  ->keyBy('santri_id');
        }

        return view('admin.absensi_rekap.create_multi', compact(
            'bulan', 
            'tahun',
            'kelasId',
            'kelasOptions', 
            'santris', 
            'dataAbsensiTersimpan'
        ));
    }


    /**
     * STORE: Menyimpan data rekapitulasi bulanan massal dan memicu Event Notifikasi (Queue).
     */
    public function storeMulti(Request $request)
    {
        $request->validate([
            'bulan' => ['required', 'integer', 'min:1', 'max:12'],
            'tahun' => ['required', 'integer', 'min:2020'],
            'kelas_id' => ['required', 'exists:kelas_santris,id'],
            'absensi' => ['required', 'array'],
            'absensi.*.santri_id' => ['required', 'exists:santris,id'],
            'absensi.*.ngaji_alpha' => ['nullable', 'integer', 'min:0'],
            'absensi.*.sholat_alpha' => ['nullable', 'integer', 'min:0'],
            'absensi.*.roan_alpha' => ['nullable', 'integer', 'min:0'],
            'absensi.*.keterangan' => ['nullable', 'string', 'max:255'],
        ]);

        $bulan = $request->input('bulan');
        $tahun = $request->input('tahun');
        $kelasId = $request->input('kelas_id');
        $waliInputId = auth()->id();
        
        $tanggalRekap = Carbon::createFromDate($tahun, $bulan);
        $bulanTahunStr = $tanggalRekap->translatedFormat('F Y');

        DB::beginTransaction();
        try {
            foreach ($request->absensi as $item) {
                
                $santri = Santri::find($item['santri_id']);
                
                $absensi = AbsensiRekapitulasi::firstOrNew([
                    'santri_id' => $item['santri_id'],
                    'bulan' => $bulan,
                    'tahun' => $tahun,
                ]);

                // Cek apakah ada perubahan data untuk Notifikasi
                $isNewRecord = !$absensi->exists;
                $isDataChanged = $isNewRecord || 
                                 $absensi->ngaji_alpha != ($item['ngaji_alpha'] ?? 0) ||
                                 $absensi->sholat_alpha != ($item['sholat_alpha'] ?? 0) ||
                                 $absensi->roan_alpha != ($item['roan_alpha'] ?? 0);

                // Update data rekapitulasi
                $absensi->fill([
                    'wali_input_id' => $waliInputId,
                    'kelas_id' => $kelasId,
                    'ngaji_alpha' => $item['ngaji_alpha'] ?? 0,
                    'sholat_alpha' => $item['sholat_alpha'] ?? 0,
                    'roan_alpha' => $item['roan_alpha'] ?? 0,
                    'keterangan' => $item['keterangan'] ?? null,
                ])->save();

                // 🔔 Memicu Notifikasi Rekapitulasi Bulanan (Event Queue) 🔔
                if ($santri && $santri->wali_santri_id && $isDataChanged) {
                    $waliSantri = User::find($santri->wali_santri_id);
                    
                    if ($waliSantri) {
                        event(new AttendanceUpdated(
                            $waliSantri, // User Wali Santri (Penerima)
                            'Bulanan', // Context
                            $bulanTahunStr // Keterangan
                        ));
                    }
                }
            }
            
            DB::commit();
            return redirect()->route('admin.absensi_rekap.index', ['bulan' => $bulan, 'tahun' => $tahun])
                             ->with('success', 'Rekapitulasi absensi bulan ' . $bulanTahunStr . ' berhasil disimpan dan notifikasi dikirim ke queue.');
            
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal menyimpan data rekapitulasi: ' . $e->getMessage());
        }
    }

    public function edit(AbsensiRekapitulasi $absensi_rekap)
    {
        return redirect()->route('admin.absensi_rekap.create_multi', [
            'bulan' => $absensi_rekap->bulan,
            'tahun' => $absensi_rekap->tahun,
            'kelas_id' => $absensi_rekap->kelas_id
        ]);
    }

    public function destroy(AbsensiRekapitulasi $absensi_rekap)
    {
        $bulan = $absensi_rekap->bulan;
        $tahun = $absensi_rekap->tahun;
        $absensi_rekap->delete();
        return back()->with('success', 'Rekapitulasi absensi santri ' . $absensi_rekap->santri->nama_lengkap . ' bulan ini berhasil dihapus.')
                     ->withInput(['bulan' => $bulan, 'tahun' => $tahun]);
    }
}