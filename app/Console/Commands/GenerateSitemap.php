<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Route;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\SitemapGenerator;
use Spatie\Sitemap\Tags\Url;

class GenerateSitemap extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sitemap:generate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate the sitemap.';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $this->info('Generating sitemap via crawler...');

        try {
            $baseUrl = config('app.url', 'https://sisfoalfalahputak.online');

            SitemapGenerator::create($baseUrl)
                ->shouldCrawl(function (\Psr\Http\Message\UriInterface $url) {
                    // Only crawl the main domain
                    if (!str_contains($url->getHost(), 'sisfoalfalahputak.online')) {
                        return false;
                    }

                    $path = $url->getPath();

                    // Exclude auth/admin/internal paths
                    $exclude = ['/login', '/register', '/password', '/admin', '/dashboard', '/api'];
                    foreach ($exclude as $pattern) {
                        if (str_contains($path, $pattern)) {
                            return false;
                        }
                    }

                    return true;
                })
                ->getSitemap()
                ->writeToDisk('public', 'sitemap.xml');

            $this->info('Sitemap written to ' . public_path('sitemap.xml'));

            return 0;
        } catch (\Throwable $e) {
            $this->error('Failed to generate sitemap: ' . $e->getMessage());
            return 1;
        }
    }
}
