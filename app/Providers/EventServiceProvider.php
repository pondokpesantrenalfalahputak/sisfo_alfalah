<?php

namespace App\Providers;

use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

// 🚀 Import semua Event dan Listener yang digunakan
use App\Events\PaymentStatusUpdated;
use App\Events\AttendanceUpdated;
use App\Events\NewAnnouncementPosted;
// Ganti ini sesuai dengan nama Listener yang sebenarnya Anda buat
use App\Listeners\SendCustomNotification; 
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * Menggunakan syntax ::class untuk memastikan Laravel dapat menemukan kelas dengan benar.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        // ✅ PERBAIKAN: Menggunakan ::class untuk semua Event dan Listener
        PaymentStatusUpdated::class => [
            SendCustomNotification::class,
        ],
        AttendanceUpdated::class => [
            SendCustomNotification::class,
        ],
        NewAnnouncementPosted::class => [
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