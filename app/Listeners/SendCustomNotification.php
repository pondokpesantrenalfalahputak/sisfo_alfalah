<?php

namespace App\Listeners;

use App\Events\AttendanceUpdated;
use App\Events\PaymentStatusUpdated;
use App\Events\NewAnnouncementPosted;
use App\Events\NewBillCreated; 
use App\Jobs\SendWaliNotificationJob;
use App\Models\User; 
use Illuminate\Contracts\Queue\ShouldQueue; 
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon; // ✅ Import Carbon

class SendCustomNotification implements ShouldQueue
{
    use InteractsWithQueue; 

    /**
     * Handle the event.
     */
    public function handle(object $event): void
    {
        if ($event instanceof PaymentStatusUpdated) {
            $this->handlePaymentStatusUpdated($event);
        }

        if ($event instanceof AttendanceUpdated) {
            $this->handleAttendanceUpdated($event);
        }
        
        if ($event instanceof NewBillCreated) {
            $this->handleNewBillCreated($event);
        }

        if ($event instanceof NewAnnouncementPosted) {
            $this->handleNewAnnouncementPosted($event);
        }
    }

    // --- LOGIKA PER EVENT ---

    protected function handleNewBillCreated(NewBillCreated $event)
    {
        try {
            $wali = $event->user;
            $tagihan = $event->tagihan;
            
            // Logika Format Data
            $jumlahFormat = number_format($tagihan->jumlah_tagihan, 0, ',', '.'); 
            
            // Menggunakan format yang aman untuk tanggal
            $jatuhTempo = Carbon::parse($tagihan->tanggal_jatuh_tempo)->format('d F Y'); 
            
            $notifTitle = "🏷️ Tagihan Baru: " . Str::limit($tagihan->jenis_tagihan, 30);
            $notifBody = "Tagihan {$tagihan->jenis_tagihan} sebesar Rp. {$jumlahFormat} telah ditambahkan. Jatuh tempo: {$jatuhTempo}";
            $link = route('wali.tagihan.show', $tagihan->id); 
            
            SendWaliNotificationJob::dispatch($wali->id, $notifTitle, $notifBody, $link);
            
            // ✅ LOGGING KEBERHASILAN DISPATCH
            Log::info("Tagihan Baru Job DISPATCHED for Wali ID: " . $wali->id . " Tagihan ID: " . $tagihan->id);

        } catch (\Exception $e) {
            // ✅ LOGGING KEGAGALAN SPESIFIK DI handleNewBillCreated
            Log::error("KRITIS: Gagal merakit/mendispatch notifikasi Tagihan Baru (Listener): " . $e->getMessage() . " pada baris " . $e->getLine());
        }
    }
    
    protected function handlePaymentStatusUpdated(PaymentStatusUpdated $event)
    {
        try {
            $pembayaran = $event->pembayaran;
            $status = $pembayaran->status_konfirmasi; 
            $tagihan = $pembayaran->tagihan;
            $waliId = $event->user->id; 
            
            $jumlahFormat = number_format($pembayaran->jumlah_bayar, 0, ',', '.');

            $notifTitle = "Konfirmasi Pembayaran: " . Str::limit($tagihan->jenis_tagihan, 30);
            $notifBody = "Pembayaran sebesar Rp. {$jumlahFormat} telah {$status} oleh Admin.";
            $link = route('wali.tagihan.show', $tagihan->id); 
            
            SendWaliNotificationJob::dispatch($waliId, $notifTitle, $notifBody, $link);
            Log::info("PaymentStatusUpdated Job DISPATCHED for Wali ID: " . $waliId);

        } catch (\Exception $e) {
            Log::error("KRITIS: Gagal mendispatch notifikasi Pembayaran (Listener): " . $e->getMessage() . " pada baris " . $e->getLine());
        }
    }

    protected function handleAttendanceUpdated(AttendanceUpdated $event)
    {
        try {
            $waliId = $event->user->id; 
            $context = $event->context; 
            $keterangan = $event->keterangan;
            
            $notifTitle = "Update Absensi: {$context}";
            $notifBody = "Data Absensi {$context} ({$keterangan}) santri Anda telah diperbarui.";
            $link = route('wali.absensi.index'); 
            
            SendWaliNotificationJob::dispatch($waliId, $notifTitle, $notifBody, $link);
            Log::info("AttendanceUpdated Job DISPATCHED for Wali ID: " . $waliId);

        } catch (\Exception $e) {
            Log::error("Gagal mendispatch notifikasi Absensi (Listener): " . $e->getMessage());
        }
    }

    protected function handleNewAnnouncementPosted(NewAnnouncementPosted $event)
    {
        try {
            $pengumuman = $event->pengumuman;
            
            // Mencari SEMUA user yang memiliki role 'wali_santri'
            $waliUsers = User::where('role', 'wali_santri')->get(); 

            // Perakitan Pesan
            $notifTitle = "📢 Pengumuman Baru: " . Str::limit($pengumuman->judul, 40);
            $notifBody = "Telah dipublikasikan pengumuman baru dengan kategori {$pengumuman->kategori}.";
            $link = route('wali.pengumuman.show', $pengumuman->id);

            // Dispatch Job untuk setiap Wali.
            foreach ($waliUsers as $wali) {
                SendWaliNotificationJob::dispatch($wali->id, $notifTitle, $notifBody, $link);
            }
            Log::info("NewAnnouncementPosted Job DISPATCHED for " . $waliUsers->count() . " Walis.");
            
        } catch (\Exception $e) {
            Log::error("Gagal mendispatch notifikasi Pengumuman Massal: " . $e->getMessage());
        }
    }
}