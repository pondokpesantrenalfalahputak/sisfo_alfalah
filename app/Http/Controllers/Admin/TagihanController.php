<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tagihan;
use App\Models\Santri;
use App\Models\User; 
use App\Events\PaymentStatusUpdated;
use App\Events\NewBillCreated; // ✅ Import Event Baru Tagihan
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;   
use Illuminate\Support\Facades\Log;   

class TagihanController extends Controller
{
    // Daftar jenis tagihan
    protected $jenisTagihan = [
        'Kos Makan',
        'Galon',
        'Kas Diniah',
        'Denda',
        'Tabungan Wali Songo',
        'LKS',
        'Lainnya'
    ];
    
    public function index()
    {
        $tagihans = Tagihan::with('santri')->get();
        return view('admin.tagihan.index', compact('tagihans'));
    }

    public function create()
    {
        $santris = Santri::all();
        $jenisTagihan = $this->jenisTagihan;
        return view('admin.tagihan.create', compact('santris', 'jenisTagihan'));
    }

    /**
     * Menyimpan tagihan baru dan memicu notifikasi kepada Wali Santri.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'santri_id' => 'required|exists:santris,id',
            'jenis_tagihan' => 'required|string|max:255',
            'jumlah_tagihan' => 'required|numeric|min:0', 
            'tanggal_jatuh_tempo' => 'required|date|after_or_equal:' . Carbon::now()->toDateString(),
            'keterangan' => 'nullable|string',
        ]);
        
        $validatedData['tanggal_tagihan'] = Carbon::now()->toDateString();
        $validatedData['status'] = 'Belum Lunas';

        $tagihan = Tagihan::create($validatedData); 

        // 🔔 LOGIKA NOTIFIKASI TAGIHAN BARU 🔔
        $santri = $tagihan->santri;

        if ($santri && $santri->wali_santri_id) {
            $waliSantri = User::find($santri->wali_santri_id);
            
            if ($waliSantri) {
                
                Log::debug("BILL CREATED: Attempting to notify Wali ID: " . $waliSantri->id . " for Tagihan ID: " . $tagihan->id);
                
                // ✅ FIX: Ganti PaymentStatusUpdated dengan NewBillCreated
                event(new NewBillCreated($waliSantri, $tagihan)); 
            }
        }
        // 🔔 END NOTIFIKASI TAGIHAN BARU 🔔

        $pesan = 'Tagihan berhasil ditambahkan. Notifikasi tagihan baru telah dikirim.';
        return redirect()->route('admin.tagihan.index')->with('success', $pesan);
    }

    public function show(Tagihan $tagihan)
    {
        return view('admin.tagihan.show', compact('tagihan'));
    }

    public function edit(Tagihan $tagihan)
    {
        $santris = Santri::all();
        $jenisTagihan = $this->jenisTagihan;
        return view('admin.tagihan.edit', compact('tagihan', 'santris', 'jenisTagihan'));
    }

    public function update(Request $request, Tagihan $tagihan)
    {
        $request->validate([
            'santri_id' => 'required|exists:santris,id',
            'jenis_tagihan' => 'required|string|max:255',
            'jumlah_tagihan' => 'required|numeric|min:0', 
            'tanggal_jatuh_tempo' => 'required|date',
            'keterangan' => 'nullable|string',
        ]);
        
        $dataToUpdate = $request->except(['tanggal_tagihan', 'status']); 

        $tagihan->update($dataToUpdate);

        return redirect()->route('admin.tagihan.index')->with('success', 'Tagihan berhasil diperbarui.');
    }

    public function destroy(Tagihan $tagihan)
    {
        $tagihan->delete();
        return redirect()->route('admin.tagihan.index')->with('success', 'Tagihan berhasil dihapus.');
    }

    public function konfirmasiPembayaran()
    {
        $pembayarans = \App\Models\Pembayaran::where('status_konfirmasi', 'Menunggu')->with('tagihan.santri')->get();
        return view('admin.konfirmasi.index', compact('pembayarans'));
    }

    /**
     * Memproses konfirmasi atau penolakan pembayaran dari Admin (Memicu Event Queue).
     */
    public function prosesKonfirmasi(Request $request, \App\Models\Pembayaran $pembayaran)
    {
        $request->validate([
            'status' => 'required|in:Dikonfirmasi,Ditolak',
        ]);

        $newStatus = $request->status;
        $tagihan = $pembayaran->tagihan;

        DB::beginTransaction(); 
        try {
            // 1. Update Status Pembayaran
            $pembayaran->update([
                'status_konfirmasi' => $newStatus,
            ]);
            
            // 2. Update status tagihan jika dikonfirmasi
            if ($newStatus === 'Dikonfirmasi') {
                $isFullyPaid = $tagihan->pembayarans()
                                    ->where('status_konfirmasi', '!=', 'Dikonfirmasi')
                                    ->doesntExist();
                
                if ($isFullyPaid) {
                    $tagihan->update(['status' => 'Lunas']);
                }
            } 

            // 3. Pemicu Event Notifikasi (ASINKRON)
            $santri = $tagihan->santri;
            
            if ($santri && $santri->wali_santri_id) {
                $waliSantri = User::find($santri->wali_santri_id);
                
                if ($waliSantri) {
                    
                    Log::debug("PAYMENT EVENT DISPATCH ATTEMPTED for Wali ID: " . $waliSantri->id . " Status: " . $newStatus . " | Pembayaran ID: " . $pembayaran->id);
                    
                    event(new PaymentStatusUpdated($waliSantri, $pembayaran, $newStatus));
                } else {
                    Log::warning("PAYMENT NOTIF FAILED: Wali Santri ID ({$santri->wali_santri_id}) tidak ditemukan di tabel users.");
                }
            } else {
                $santriIdLog = $santri->id ?? 'N/A';
                Log::warning("PAYMENT NOTIF FAILED: Santri ID ({$santriIdLog}) tidak memiliki wali_santri_id.");
            }

            DB::commit(); 
            
            $pesan = ($newStatus === 'Dikonfirmasi') 
                    ? 'Pembayaran berhasil dikonfirmasi dan notifikasi telah dikirim ke Queue.' 
                    : 'Pembayaran berhasil ditolak dan notifikasi telah dikirim ke Queue.';

            return redirect()->route('admin.tagihan.konfirmasi.index')->with('success', $pesan);

        } catch (\Exception $e) {
            DB::rollBack(); 
            Log::error("FATAL ERROR during prosesKonfirmasi: " . $e->getMessage() . " on line " . $e->getLine());
            return back()->with('error', 'Gagal memproses konfirmasi: ' . $e->getMessage());
        }
    }

    public function riwayatPembayaran()
    {
        $pembayarans = \App\Models\Pembayaran::with('tagihan.santri')->orderBy('created_at', 'desc')->paginate(20);
        return view('admin.pembayaran.riwayat', compact('pembayarans'));
    }
}