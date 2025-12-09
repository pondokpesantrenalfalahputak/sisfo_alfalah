<?php

namespace App\Listeners;

use App\Events\PaymentStatusUpdated;
use App\Events\AttendanceUpdated;
use App\Events\NewAnnouncementPosted;
use App\Models\WaliNotification;
use App\Models\User; 
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Str;

class SendCustomNotification
{
    /**
     * Handle the event.
     */
    public function handle(object $event): void
    {
        // 1. PAYMENT
        if ($event instanceof PaymentStatusUpdated) {
            $this->handlePaymentStatusUpdated($event);
        }

        // 2. ATTENDANCE
        if ($event instanceof AttendanceUpdated) {
            $this->handleAttendanceUpdated($event);
        }

        // 3. ANNOUNCEMENT (Notifikasi massal)
        if ($event instanceof NewAnnouncementPosted) {
            $this->handleNewAnnouncementPosted($event);
        }
    }

    // ------------------------------------------------------------------
    // LOGIKA PER EVENT
    // ------------------------------------------------------------------

    /**
     * Logika untuk menangani Event PaymentStatusUpdated (Notifikasi per individu).
     */
    protected function handlePaymentStatusUpdated(PaymentStatusUpdated $event)
    {
        try {
            $status = $event->status;
            $waliId = $event->user->id; 
            $pembayaran = $event->pembayaran;

            // Pastikan relasi tagihan tersedia
            $tagihan = $pembayaran->tagihan;

            $notifTitle = "Konfirmasi Pembayaran: " . Str::limit($tagihan->jenis_tagihan, 30);
            $notifBody = "Pembayaran sebesar Rp. " . number_format($pembayaran->jumlah_bayar) . " telah {$status} oleh Admin.";
            
            WaliNotification::create([
                'user_id' => $waliId,
                'title' => $notifTitle,
                'body' => $notifBody,
                // ✅ PERBAIKAN: Mengganti route('wali.tagihan.detail') menjadi route('wali.tagihan.show')
                'link' => route('wali.tagihan.show', $tagihan->id), 
                'is_read' => false,
            ]);
        } catch (\Exception $e) {
            \Log::error("Gagal membuat notifikasi Pembayaran (Listener): " . $e->getMessage());
        }
    }

    /**
     * Logika untuk menangani Event AttendanceUpdated (Notifikasi per individu).
     */
    protected function handleAttendanceUpdated(AttendanceUpdated $event)
    {
        try {
            $waliId = $event->user->id; 
            $context = $event->context; 
            $keterangan = $event->keterangan;

            $notifTitle = "Update Absensi: {$context}";
            $notifBody = "Data Absensi {$context} ({$keterangan}) santri Anda telah diperbarui.";
            
            WaliNotification::create([
                'user_id' => $waliId,
                'title' => $notifTitle,
                'body' => $notifBody,
                'link' => route('wali.absensi.index'), 
                'is_read' => false,
            ]);
        } catch (\Exception $e) {
            \Log::error("Gagal membuat notifikasi Absensi (Listener): " . $e->getMessage());
        }
    }

    /**
     * Logika untuk menangani Event NewAnnouncementPosted (Notifikasi Massal).
     */
    protected function handleNewAnnouncementPosted(NewAnnouncementPosted $event)
    {
        try {
            $pengumuman = $event->pengumuman;
            
            // Mencari SEMUA user yang memiliki role 'wali_santri'
            $waliUsers = User::where('role', 'wali_santri')->get(); 

            $notifTitle = "Pengumuman Baru: " . Str::limit($pengumuman->judul, 40);
            $notifBody = "Telah dipublikasikan pengumuman baru dengan kategori {$pengumuman->kategori}.";
            
            // Loop untuk membuat notifikasi bagi setiap Wali
            foreach ($waliUsers as $wali) {
                WaliNotification::create([
                    'user_id' => $wali->id,
                    'title' => $notifTitle,
                    'body' => $notifBody,
                    'link' => route('wali.pengumuman.show', $pengumuman->id), // Menggunakan show, asumsi ini detail pengumuman
                    'is_read' => false,
                ]);
            }
        } catch (\Exception $e) {
             // Jika terjadi error, catat di log agar bisa dilacak
            \Log::error("Gagal membuat notifikasi Pengumuman Massal (Listener): " . $e->getMessage());
        }
    }
}