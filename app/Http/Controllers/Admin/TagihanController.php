<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tagihan;
use App\Models\Santri;
use App\Models\User; 
use App\Events\PaymentStatusUpdated; 
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class TagihanController extends Controller
{
    // Daftar jenis tagihan yang sudah diperbarui
    protected $jenisTagihan = [
        'Kos Makan',
        'Galon',
        'Kas Diniah',
        'Denda',
        'Tabungan Wali Songo',
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

        Tagihan::create($validatedData);

        return redirect()->route('admin.tagihan.index')->with('success', 'Tagihan berhasil ditambahkan.');
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
     * Memproses konfirmasi atau penolakan pembayaran dari Admin.
     */
    public function prosesKonfirmasi(Request $request, \App\Models\Pembayaran $pembayaran)
    {
        $request->validate([
            'status' => 'required|in:Dikonfirmasi,Ditolak',
        ]);

        $newStatus = $request->status;
        
        // 1. Update Status Pembayaran
        $pembayaran->update([
            'status_konfirmasi' => $newStatus,
        ]);
        
        $tagihan = $pembayaran->tagihan;
        
        // 2. Update status tagihan jika diperlukan
        if ($newStatus === 'Dikonfirmasi') {
            $totalPembayaranBelumDikonfirmasi = $tagihan->pembayarans()
                                                ->where('status_konfirmasi', '!=', 'Dikonfirmasi')
                                                ->count();
                                                
            if ($totalPembayaranBelumDikonfirmasi === 0) {
                 $tagihan->update(['status' => 'Lunas']);
            }
        } 

        // 🚀 START NOTIFIKASI WALI SANTRI - Pemicu Event
        $santri = $tagihan->santri;
        
        if ($santri && $santri->wali_santri_id) {
            $waliSantri = User::find($santri->wali_santri_id);
            
            if ($waliSantri) {
                event(new PaymentStatusUpdated($waliSantri, $pembayaran, $newStatus));
            }
        }
        // 🚀 END NOTIFIKASI WALI SANTRI
        
        $pesan = ($newStatus === 'Dikonfirmasi') 
                 ? 'Pembayaran berhasil dikonfirmasi dan notifikasi telah dikirim.' 
                 : 'Pembayaran berhasil ditolak dan notifikasi telah dikirim.';

        return redirect()->route('admin.tagihan.konfirmasi.index')->with('success', $pesan);
    }

    public function riwayatPembayaran()
    {
        $pembayarans = \App\Models\Pembayaran::with('tagihan.santri')->orderBy('created_at', 'desc')->paginate(20);
        return view('admin.pembayaran.riwayat', compact('pembayarans'));
    }
}