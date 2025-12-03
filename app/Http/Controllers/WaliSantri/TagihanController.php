<?php

namespace App\Http\Controllers\WaliSantri;

use App\Http\Controllers\Controller;
use App\Models\Tagihan;
use App\Models\Rekening;
use App\Models\Pembayaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth; // Tetap gunakan Auth untuk konsistensi atau ganti ke auth() helper

class TagihanController extends Controller
{
    /**
     * Menampilkan daftar semua tagihan dan riwayat pembayaran untuk wali ini.
     */
    public function index()
    {
        // Menggunakan helper auth() lebih singkat daripada Auth::id()
        $waliSantriId = auth()->id(); 
        
        // 1. Tagihan Aktif
        $tagihans = Tagihan::whereHas('santri', function ($query) use ($waliSantriId) {
            $query->where('wali_santri_id', $waliSantriId);
        })
        // Pastikan relasi santri.kelas di-load
        ->with(['santri.kelas', 'pembayarans'])
        ->get(); 

        // 2. Riwayat Pembayaran
        $riwayatPembayaran = Pembayaran::where('user_id', $waliSantriId)
                                       // Eager load 'rekening'
                                       ->with(['tagihan.santri', 'rekening'])
                                       ->orderBy('created_at', 'desc')
                                       ->get();

        return view('wali.tagihan.index', compact('tagihans', 'riwayatPembayaran'));
    }

    /**
     * Menampilkan detail satu tagihan, sisa pembayaran, dan riwayat pembayaran spesifik.
     */
    public function show(Tagihan $tagihan)
    {
        // Pastikan tagihan milik santri wali yang sedang login
        if ($tagihan->santri->wali_santri_id !== auth()->id()) {
            abort(403, 'Akses Ditolak. Tagihan ini bukan milik santri Anda.');
        }

        // Ambil semua rekening bank tujuan
        // Model Rekening harus sudah di-set: protected $table = 'rekening_banks';
        $rekenings = Rekening::all(); 
        
        // Ambil total bayar terkonfirmasi (Menggunakan accessor Model Tagihan)
        // Diasumsikan accessor total_bayar_terkonfirmasi ada di Model Tagihan
        $totalBayarTerkonfirmasi = $tagihan->total_bayar_terkonfirmasi; 

        // Hitung sisa tagihan
        $sisaTagihan = $tagihan->jumlah_tagihan - $totalBayarTerkonfirmasi;
        
        // Riwayat Pembayaran: Eager load 'rekening' untuk menghindari N+1 problem di view
        $pembayarans = $tagihan->pembayarans()->with('rekening')->orderBy('created_at', 'desc')->get(); 

        return view('wali.tagihan.show', compact('tagihan', 'rekenings', 'sisaTagihan', 'pembayarans'));
    }

    /**
     * Memproses pengiriman bukti pembayaran untuk tagihan.
     */
    public function bayar(Request $request, Tagihan $tagihan)
    {
        // Pastikan tagihan milik santri wali yang sedang login
        if ($tagihan->santri->wali_santri_id !== auth()->id()) {
            abort(403, 'Akses Ditolak. Tagihan ini bukan milik santri Anda.');
        }

        // Validasi input
        $request->validate([
            'jumlah_bayar' => 'required|numeric|min:1',
            // ✅ PERBAIKAN: Menggunakan nama tabel yang benar: rekening_banks
            'rekening_id' => 'required|exists:rekening_banks,id', 
            'bukti_pembayaran' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // Simpan file bukti pembayaran
        // Pastikan Anda sudah mengkonfigurasi disk 'public' agar dapat diakses
        $buktiPath = $request->file('bukti_pembayaran')->store('bukti_pembayaran', 'public');
        
        // Ambil data Rekening berdasarkan ID yang dipilih
        // Ini berjalan dengan benar karena Model Rekening sudah diarahkan ke tabel rekening_banks
        $rekeningDipilih = Rekening::find($request->rekening_id);

        if (!$rekeningDipilih) {
            // Seharusnya tidak terjangkau jika validasi 'exists' berhasil
            return back()->with('error', 'Rekening tujuan pembayaran tidak ditemukan.');
        }

        // Buat string untuk field 'metode_pembayaran'
        $metodePembayaranValue = $rekeningDipilih->nama_bank . ' - ' . $rekeningDipilih->atas_nama;


        // Buat pembayaran baru
        Pembayaran::create([
            'tagihan_id' => $tagihan->id,
            'user_id' => auth()->id(), // ID Wali Santri
            'rekening_id' => $request->rekening_id, // Foreign Key Rekening
            'jumlah_bayar' => $request->jumlah_bayar,
            'bukti_pembayaran' => $buktiPath,
            'status_konfirmasi' => 'Menunggu', 
            'metode_pembayaran' => $metodePembayaranValue, 
        ]);

        return redirect()->route('wali.tagihan.show', $tagihan)->with('success', 'Pembayaran berhasil dikirim dan menunggu konfirmasi admin.');
    }
}