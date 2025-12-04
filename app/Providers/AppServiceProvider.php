<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
// 💡 IMPORT BARU
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use App\Models\WaliNotification; // Model Notifikasi
use Illuminate\Support\Str; // Diperlukan jika Anda menggunakan Str::is (seperti di layout)
use App\Console\Commands\GenerateSitemap;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Register application console commands when Kernel is not used
        $this->commands([
            GenerateSitemap::class,
        ]);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // View Composer untuk semua tampilan di folder 'wali'
        View::composer('wali.*', function ($view) {
            // Cek apakah user sedang login dan apakah user tersebut adalah Wali Santri
            // Asumsi: Method isWaliSantri() ada di model User Anda
            if (Auth::check() && Auth::user()->isWaliSantri()) { 
                
                // Hitung notifikasi yang belum dibaca
                $unreadCount = WaliNotification::where('user_id', Auth::id())
                                             ->where('is_read', false)
                                             ->count();
                
                $view->with('unreadCount', $unreadCount);
            } else {
                $view->with('unreadCount', 0);
            }
        });
    }
}