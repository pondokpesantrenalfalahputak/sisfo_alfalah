<?php

namespace App\Providers;

use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

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
        // 🚀 DAFTAR EVENT KHUSUS UNTUK NOTIFIKASI KUSTOM
        'App\Events\PaymentStatusUpdated' => [
            'App\Listeners\SendCustomNotification',
        ],
        'App\Events\AttendanceUpdated' => [
            'App\Listeners\SendCustomNotification',
        ],
        'App\Events\NewAnnouncementPosted' => [
            'App\Listeners\SendCustomNotification',
        ],
    ];

    /**
     * Register any events for your application.
     */
    public function boot(): void
    {
        parent::boot();
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     */
    public function shouldDiscoverEvents(): bool
    {
        return false;
    }
}