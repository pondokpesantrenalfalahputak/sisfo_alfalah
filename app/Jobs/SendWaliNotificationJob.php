<?php

namespace App\Jobs;

use App\Models\WaliNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class SendWaliNotificationJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $waliId;
    protected $title;
    protected $body;
    protected $link;

    /**
     * Buat instance Job baru.
     */
    public function __construct(int $waliId, string $title, string $body, ?string $link = null)
    {
        $this->waliId = $waliId;
        $this->title = $title;
        $this->body = $body;
        $this->link = $link;
    }

    /**
     * Jalankan Job. Tugasnya HANYA menyimpan notifikasi ke DB.
     */
    public function handle(): void
    {
        // ✅ LOGGING AWAL: Catat bahwa Job sudah mulai diproses
        Log::info("JOB STARTING: Processing notification for Wali ID: {$this->waliId}. Title: {$this->title}"); 
        
        try {
            WaliNotification::create([
                'user_id' => $this->waliId,
                'title' => $this->title,
                'body' => $this->body,
                'link' => $this->link,
                'is_read' => false,
            ]);
            
            // ✅ LOGGING SUKSES: Catat jika Job berhasil menyimpan ke DB
            Log::info("JOB SUCCESS: Notification successfully created for Wali ID: {$this->waliId}.");

        } catch (\Exception $e) {
            // ✅ LOGGING GAGAL KRITIS: Catat error lengkap jika Job gagal
            Log::error("JOB FAILED TO CREATE NOTIFICATION for Wali ID {$this->waliId}: " . $e->getMessage() . " on line " . $e->getLine());
            
            // Re-throw exception agar Job di-handle oleh Queue Worker (misalnya dimasukkan ke tabel failed_jobs)
            throw $e;
        }
    }
}