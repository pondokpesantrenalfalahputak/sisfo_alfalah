<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Spatie\Sitemap\Sitemap; 
use Spatie\Sitemap\Tags\Url;
use App\Models\Pengumuman; // Model sudah terkonfirmasi benar

class GenerateSitemap extends Command
{
    protected $signature = 'sitemap:generate';
    protected $description = 'Generate the sitemap file for public URLs only.';

    public function handle(): int
    {
        $this->info('Memulai pembuatan Sitemap untuk konten publik...');

        try {
            $baseUrl = config('app.url'); 
            
            if (!$baseUrl) {
                $this->error("APP_URL tidak didefinisikan di .env.");
                return 1;
            }

            $sitemap = Sitemap::create(); 

            // =======================================================
            // A. Halaman Statis Publik
            // =======================================================
            $this->info('Menambahkan halaman statis publik...');

            // Halaman Beranda
            $sitemap->add(Url::create($baseUrl . '/')
                ->setPriority(1.0)
                ->setChangeFrequency(Url::CHANGE_FREQUENCY_DAILY) 
            );

            // Halaman Login & Register
            $sitemap->add(Url::create($baseUrl . '/login')->setPriority(0.8));
            $sitemap->add(Url::create($baseUrl . '/register')->setPriority(0.8));
            
            
            // =======================================================
            // B. Konten Dinamis Publik (Koreksi Query Sesuai Model)
            // =======================================================
            $this->info('Menambahkan konten dinamis publik dari database...');

            // --- Koreksi Query untuk Model Pengumuman ---
            try {
                // KOREKSI 1: Menggunakan kolom 'status' dengan nilai 'published' (Asumsi)
                // KOREKSI 2: Menggunakan ->get() agar query berjalan
                $pengumumans = Pengumuman::where('status', 'published')->get(); 
                
                foreach ($pengumumans as $item) {
                    // KOREKSI 3: Menggunakan ID Pengumuman sebagai URL (bukan slug)
                    // ASUMSI RUTE: /pengumuman-publik/{id}
                    $sitemap->add(Url::create($baseUrl . "/pengumuman-publik/{$item->id}") 
                        ->setLastModificationDate($item->tanggal_publikasi ?? $item->updated_at ?? now())
                        ->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY)
                        ->setPriority(0.9)
                    );
                }
                $this->info('-> Berhasil menambahkan ' . $pengumumans->count() . ' Pengumuman publik.');
            } catch (\Exception $e) {
                // Jika error di sini, berarti koneksi DB gagal atau nilai 'published' salah
                $this->error('-> Gagal query data Model Pengumuman. Periksa nilai kolom status (contoh: published vs 1).');
            }
            
            
            // =======================================================
            // C. Simpan File ke Public Directory
            // =======================================================
            $sitemap->writeToFile(public_path('sitemap.xml'));

            $this->info('Sitemap berhasil dibuat dan disimpan di ' . public_path('sitemap.xml'));
            $this->info('STATUS: SIAP UNTUK DIKIRIMKAN KE GOOGLE SEARCH CONSOLE.');
            
            return 0;

        } catch (\Throwable $e) {
            $this->error('Gagal membuat sitemap secara keseluruhan.');
            $this->error('Error: ' . $e->getMessage());
            return 1;
        }
    }
}