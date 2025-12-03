<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AbsensiRekapitulasi;
use App\Models\Santri;
use App\Models\KelasSantri;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AbsensiRekapitulasiController extends Controller
{
    /**
     * READ: Menampilkan riwayat rekapitulasi (Index/Tabel Utama).
     * Filter berdasarkan Bulan dan Tahun.
     */
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

    /**
     * CREATE: Menampilkan form input rekapitulasi bulanan massal (createMulti).
     */
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

            // Ambil data rekapitulasi yang sudah tersimpan
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
     * STORE: Menyimpan data rekapitulasi bulanan massal (storeMulti).
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
        
        DB::beginTransaction();
        try {
            foreach ($request->absensi as $item) {
                // Cari atau buat entri rekapitulasi bulanan
                $absensi = AbsensiRekapitulasi::firstOrNew([
                    'santri_id' => $item['santri_id'],
                    'bulan' => $bulan,
                    'tahun' => $tahun,
                ]);

                // Update data rekapitulasi
                $absensi->fill([
                    'wali_input_id' => $waliInputId,
                    'kelas_id' => $kelasId,
                    
                    'ngaji_alpha' => $item['ngaji_alpha'] ?? 0,
                    'sholat_alpha' => $item['sholat_alpha'] ?? 0,
                    'roan_alpha' => $item['roan_alpha'] ?? 0,
                    
                    'keterangan' => $item['keterangan'] ?? null,
                ])->save();
            }
            
            DB::commit();
            return redirect()->route('admin.absensi_rekap.index', ['bulan' => $bulan, 'tahun' => $tahun])
                             ->with('success', 'Rekapitulasi absensi bulan ' . Carbon::createFromDate($tahun, $bulan)->translatedFormat('F Y') . ' berhasil disimpan.');
            
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal menyimpan data rekapitulasi: ' . $e->getMessage());
        }
    }

    /**
     * UPDATE: Menampilkan form edit (Diarahkan ke createMulti).
     */
    public function edit(AbsensiRekapitulasi $absensi_rekap)
    {
        // Redirect ke form input massal, membawa bulan, tahun, dan kelas untuk pre-select
        return redirect()->route('admin.absensi_rekap.create_multi', [
            'bulan' => $absensi_rekap->bulan,
            'tahun' => $absensi_rekap->tahun,
            'kelas_id' => $absensi_rekap->kelas_id
        ]);
    }

    /**
     * DELETE: Menghapus data absensi.
     */
    public function destroy(AbsensiRekapitulasi $absensi_rekap)
    {
        $bulan = $absensi_rekap->bulan;
        $tahun = $absensi_rekap->tahun;
        $absensi_rekap->delete();
        return back()->with('success', 'Rekapitulasi absensi santri ' . $absensi_rekap->santri->nama_lengkap . ' bulan ini berhasil dihapus.')
                     ->withInput(['bulan' => $bulan, 'tahun' => $tahun]);
    }
}