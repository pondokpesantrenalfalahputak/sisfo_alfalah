<?php

return [
    // Static routes to always include in the sitemap.
    // You can provide either a URI (starting with '/') or a route name.
    'static_routes' => [
        '/', // homepage
        // Example placeholders (edit to match your app):
        // '/tentang', // jika Anda memiliki halaman statis /tentang
        // 'pages.contact', // jika Anda memiliki route bernama pages.contact
    ],

    // Models to include in the sitemap. Each item must define:
    // - model: fully qualified class name
    // - route: route name to generate the item URL
    // - param: route parameter name (usually route-model binding key)
    // - where: optional where array for the query
    // - changefreq: optional changefreq (daily, weekly, monthly...)
    // - priority: optional priority (0.0 - 1.0)
    'models' => [
        // Example for announcements (pengumuman). Edit or remove as needed.
        [
            'model' => App\Models\Pengumuman::class,
            'route' => 'wali.pengumuman.show',
            'param' => 'pengumuman',
            'where' => ['status' => 'published'],
            'changefreq' => 'weekly',
            'priority' => 0.6,
        ],
    ],

    // Default change frequency and priority for entries
    'default_changefreq' => 'monthly',
    'default_priority' => 0.5,

    // Exclude patterns (not used by default builder but can be used
    // if you implement crawling). Keep typical auth/admin routes here.
    'exclude_patterns' => [
        '/login*',
        '/register*',
        '/password/*',
        '/admin*',
        '/wali*',
        '/dashboard*',
    ],
];
