<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tagihan;
use App\Models\Santri;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon; // Wajib diimport

class TagihanController extends Controller
{
    public function index()
    {
        $tagihans = Tagihan::with('santri')->get();
        return view('admin.tagihan.index', compact('tagihans'));
    }

    public function create()
    {
        $santris = Santri::all();
        // Variabel ini diperlukan oleh view/form
        $jenisTagihan = ['SPP', 'Uang Pangkal', 'Daftar Ulang', 'Lainnya'];
        return view('admin.tagihan.create', compact('santris', 'jenisTagihan'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'santri_id' => 'required|exists:santris,id',
            'jenis_tagihan' => 'required|string|max:255',
            // Gunakan 'jumlah_tagihan' sesuai nama field di form
            'jumlah_tagihan' => 'required|numeric|min:0', 
            'tanggal_jatuh_tempo' => 'required|date|after_or_equal:' . Carbon::now()->toDateString(),
            'keterangan' => 'nullable|string',
        ]);
        
        // Isi tanggal_tagihan dan status secara otomatis
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
        // Variabel ini diperlukan oleh view/form
        $jenisTagihan = ['SPP', 'Uang Pangkal', 'Daftar Ulang', 'Lainnya'];
        return view('admin.tagihan.edit', compact('tagihan', 'santris', 'jenisTagihan'));
    }

    public function update(Request $request, Tagihan $tagihan)
    {
        $request->validate([
            'santri_id' => 'required|exists:santris,id',
            'jenis_tagihan' => 'required|string|max:255',
            // Gunakan 'jumlah_tagihan' sesuai nama field di form
            'jumlah_tagihan' => 'required|numeric|min:0', 
            'tanggal_jatuh_tempo' => 'required|date',
            'keterangan' => 'nullable|string',
        ]);
        
        // Hanya update field yang ada di request, kecualikan field yang tidak boleh diubah
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
     * Mengubah $request->action menjadi $request->status agar sesuai dengan field name di view.
     */
    public function prosesKonfirmasi(Request $request, \App\Models\Pembayaran $pembayaran)
    {
        $request->validate([
            // 💡 PERBAIKAN: Mengganti 'action' menjadi 'status'
            'status' => 'required|in:Dikonfirmasi,Ditolak',
        ]);

        // Gunakan $request->status yang sudah divalidasi
        $newStatus = $request->status;
        
        // 1. Update Status Pembayaran
        $pembayaran->update([
            'status_konfirmasi' => $newStatus,
            // Anda mungkin ingin menambahkan admin_id dan tanggal konfirmasi di sini
            // 'admin_id' => auth()->id(), 
            // 'tanggal_konfirmasi' => Carbon::now(),
        ]);
        
        $tagihan = $pembayaran->tagihan;
        
        // 2. Update status tagihan jika diperlukan
        if ($newStatus === 'Dikonfirmasi') {
            // Logika untuk mengecek apakah semua bagian tagihan sudah dikonfirmasi
            // (Logika ini hanya memeriksa status konfirmasi, bukan jumlah nominal)
            // Jika ada status 'Menunggu' atau 'Ditolak', status Tagihan TIDAK boleh Lunas
            $totalPembayaranBelumDikonfirmasi = $tagihan->pembayarans()
                                                ->where('status_konfirmasi', '!=', 'Dikonfirmasi')
                                                ->count();
                                                
            // Catatan: Logika yang lebih aman adalah membandingkan SUM(jumlah_bayar) vs jumlah_tagihan
            // Namun, mengikuti logika Anda saat ini: jika tidak ada lagi yang berstatus selain 'Dikonfirmasi'
            if ($totalPembayaranBelumDikonfirmasi === 0) {
                 $tagihan->update(['status' => 'Lunas']);
            }
        } 
        
        // Jika ditolak, tagihan harusnya tetap Belum Lunas (atau status sebelumnya)
        // Kita tidak perlu melakukan apa-apa pada tagihan jika ditolak.

        $pesan = ($newStatus === 'Dikonfirmasi') 
                 ? 'Pembayaran berhasil dikonfirmasi dan status tagihan diperbarui (jika lunas).' 
                 : 'Pembayaran berhasil ditolak.';


        // 3. Redirect ke halaman konfirmasi
        return redirect()->route('admin.tagihan.konfirmasi.index')->with('success', $pesan);
    }

    public function riwayatPembayaran()
    {
        $pembayarans = \App\Models\Pembayaran::with('tagihan.santri')->orderBy('created_at', 'desc')->paginate(20);
        return view('admin.pembayaran.riwayat', compact('pembayarans'));
    }
}