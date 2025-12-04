<?php

namespace App\Http\Controllers\WaliSantri;

use App\Http\Controllers\Controller;
use App\Models\WaliNotification; // ⬅️ IMPORT Model Kustom Anda di sini!
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WaliNotifikasiController extends Controller
{
    /**
     * Menampilkan daftar notifikasi kustom untuk Wali Santri yang sedang login.
     */
    public function index()
    {
        $notifikasis = WaliNotification::where('user_id', Auth::id())
                        ->orderBy('created_at', 'desc')
                        ->paginate(15); 
        
        // Catatan: Jika Anda tidak menghitung $unreadNotificationsCount di View Composer,
        // Anda bisa menghitungnya di sini dan mempassingnya ke view
        // $unreadNotificationsCount = Auth::user()->waliNotifications()->where('is_read', false)->count();

        return view('wali.notifikasi.index', compact('notifikasis'));
    }

    /**
     * Menandai semua notifikasi milik user yang sedang login sebagai sudah dibaca.
     */
    public function markAllRead()
    {
        // Update semua notifikasi yang belum dibaca milik user ini
        WaliNotification::where('user_id', Auth::id())
            ->where('is_read', false)
            ->update(['is_read' => true]);

        return redirect()->route('wali.notifikasi.index')->with('success', 'Semua notifikasi telah ditandai sebagai sudah dibaca.');
    }
    
    /**
     * Menandai satu notifikasi spesifik sebagai sudah dibaca dan mengarahkannya ke link.
     * @param \App\Models\WaliNotification $notifikasi Menggunakan Route Model Binding
     */
    public function markRead(WaliNotification $notifikasi)
    {
        // Cek Keamanan: Pastikan notifikasi ini benar-benar milik user yang sedang login
        if ($notifikasi->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }
        
        // Tandai sebagai sudah dibaca
        if (!$notifikasi->is_read) {
            $notifikasi->update(['is_read' => true]);
        }

        // Redirect ke link notifikasi, atau ke halaman daftar jika link kosong
        return redirect($notifikasi->link ?? route('wali.notifikasi.index'));
    }
}