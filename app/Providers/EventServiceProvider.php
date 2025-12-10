<?php

namespace App\Providers;

use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

// 🚀 Import semua Event dan Listener yang digunakan
use App\Events\PaymentStatusUpdated;
use App\Events\AttendanceUpdated;
use App\Events\NewAnnouncementPosted;
use App\Events\NewBillCreated; // ✅ Event Baru
use App\Listeners\SendCustomNotification; 

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        
        // ✅ Konfigurasi Listener Tunggal untuk semua Event Notifikasi
        PaymentStatusUpdated::class => [
            SendCustomNotification::class,
        ],
        AttendanceUpdated::class => [
            SendCustomNotification::class,
        ],
        NewAnnouncementPosted::class => [
            SendCustomNotification::class,
        ],
        NewBillCreated::class => [ // ✅ Tambahkan mapping Tagihan Baru
            SendCustomNotification::class,
        ],
    ];

    /**
     * Register any events for your application.
     */
    public function boot(): void
    {
        // 
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     */
    public function shouldDiscoverEvents(): bool
    {
        return false;
    }
}