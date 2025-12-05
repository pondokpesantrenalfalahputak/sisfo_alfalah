<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Portal Wali Santri') - Al-Falah Putak</title>
    <meta name="description" content="Sistem Informasi Akademik Pesantren (SIAP) Al-Falah Putak: Akses data santri, pengumuman, tagihan, dan absensi harian secara real-time. Informasi terpusat untuk Wali Santri dan Staf." />

    <meta name="google-site-verification" content="YZijbyw0-7ALwnUh_RzgJxEJRToGG2qpLcvh6P5Oqls" />
    
    <link rel="icon" type="image/png" href="{{ asset('Images/kop pondok.png') }}" />
    {{-- Memuat Bootstrap CSS --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&display=swap" rel="stylesheet">
    {{-- Memuat Font Awesome untuk Ikon --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <style>
        :root {
            --primary-color: #0b2f56; /* Biru Tua */
            --secondary-color: #ffc107; /* Kuning Emas/Warning */
            --bg-light: #f8f9fa;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--bg-light);
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        /* --- UI/UX ENHANCEMENTS --- */

        .shadow-lg-custom {
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.05) !important;
        }
    
        .header-custom {
            background-color: var(--primary-color) !important;
            height: 60px;
        }

        .offcanvas-logo {
            height: 80px;
            width: auto;
            border: 2px solid rgba(255, 255, 255, 0.5); 
            border-radius: 50%;
        }

        /* Penyesuaian Offcanvas Header (Logo) */
        .offcanvas-header {
            padding-top: 3rem !important; 
            padding-bottom: 10rem !important;
        }

        /* Navigasi Utama (Desktop) */
        .main-nav {
            display: none; 
            border-top: 1px solid #dee2e6; 
        }

        @media (min-width: 992px) { 
            .main-nav {
                display: block;
                top: 60px; 
                z-index: 1020;
                box-shadow: 0 0.25rem 0.75rem rgba(0, 0, 0, 0.05) !important; 
            }

            .main-nav .nav-link {
                color: var(--primary-color);
                font-weight: 500;
                transition: color 0.2s, border-bottom 0.2s;
            }

            .main-nav .nav-link.active {
                border-bottom: 3px solid var(--secondary-color);
                color: var(--primary-color) !important;
                padding-bottom: 1rem !important;
            }

            .main-nav .nav-link:not(.active):hover {
                color: var(--secondary-color);
            }
        }
        
        /* Styling Offcanvas Navigation (Mobile) - KERAPIAN TINGGI */
        .offcanvas-body {
            padding: 0.5rem; /* Padding konsisten di body */
        }

        .offcanvas-body .nav-link {
            padding: 0.75rem 1rem; /* Padding yang lebih baik */
            color: #495057;
            font-weight: 500;
            transition: background-color 0.2s, color 0.2s;
            display: flex;
            align-items: center; 
            margin-bottom: 0.2rem; /* Spasi antar link */
            border-radius: 0.5rem;
        }

        .offcanvas-body .nav-link i {
            font-size: 1.1rem; 
            width: 20px; /* Jaminan lebar tetap untuk semua ikon */
            text-align: center;
            margin-right: 1rem; /* Jarak konsisten ikon ke teks */
        }

        .offcanvas-body .nav-link.active {
            background-color: var(--primary-color);
            color: white !important;
            box-shadow: 0 3px 8px rgba(11, 47, 86, 0.3);
            font-weight: 600;
        }

        .offcanvas-body .nav-link:not(.active):hover {
            background-color: rgba(11, 47, 86, 0.05); 
            color: var(--primary-color);
        }

        /* --- STYLES KHUSUS NOTIFIKASI LONCENG --- */
        .notification-icon {
            position: relative; 
            display: inline-block;
            text-decoration: none;
            padding: 10px 0; /* Memberi ruang di sekitar ikon */
        }

        .notification-badge {
            position: absolute;
            top: 5px; /* Atur posisi vertikal relatif terhadap tombol */
            right: -5px; /* Atur posisi horizontal relatif terhadap tombol */
            padding: 2px 6px;
            border-radius: 50%;
            background: #e74c3c; /* Merah */
            color: white;
            font-size: 0.65rem;
            font-weight: bold;
            border: 1px solid white; 
            line-height: 1;
            z-index: 10;
        }

        /* --- END STYLES KHUSUS NOTIFIKASI LONCENG --- */
        /* --- STYLES UMUM --- */
        .breadcrumb { margin-bottom: 0; }
        .breadcrumb-item a { color: #6c757d; text-decoration: none; }
        .content-wrapper { flex-grow: 1; }
        
        footer { margin-top: 3rem !important; }
    </style>
</head>
<body>

    {{-- Script untuk memanggil JS --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" defer></script>

    @php
        $currentRoute = Route::currentRouteName();
        // Memastikan isActive mendukung pola wildcard
        $isActive = fn($routePattern) => \Illuminate\Support\Str::is($routePattern, $currentRoute) ? 'active' : '';
        // Variabel $pendingPayments dihapus/diganti karena kita menggunakan $unreadCount dari View Composer
        // Logic untuk menentukan Page Title dari Route (Disederhanakan)
        $pageTitle = trim(str_replace(['wali.', 'index', 'show', 'tagihan', 'pembayaran', 'profil'], '', ucwords(str_replace('.', ' ', $currentRoute))));
        $pageTitle = empty($pageTitle) || $pageTitle == 'Dashboard' ? 'Dashboard' : $pageTitle;
        if (\Illuminate\Support\Str::contains($currentRoute, 'tagihan')) $pageTitle = 'Tagihan & Pembayaran';
        if (\Illuminate\Support\Str::contains($currentRoute, 'santri')) $pageTitle = 'Data Santri';
        if (\Illuminate\Support\Str::contains($currentRoute, 'absensi')) $pageTitle = 'Absensi Santri';
        if (\Illuminate\Support\Str::contains($currentRoute, 'pengumuman')) $pageTitle = 'Pengumuman';

    @endphp

    <header class="header-custom shadow-lg-custom sticky-top">
        <div class="container-fluid px-4 h-100">
            <div class="d-flex align-items-center justify-content-between h-100">
                
                {{-- Tombol Hamburger untuk Mobile Offcanvas (Hanya terlihat di Mobile) --}}
                <button class="btn btn-link p-0 d-lg-none" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasWaliNav" aria-controls="offcanvasWaliNav" aria-label="Toggle navigation">
                    <i class="fas fa-bars fa-lg text-white"></i>
                </button>
                
                <div class="flex-shrink-0 d-flex align-items-center">
                    {{-- HEADER UTAMA: Tetap 60px --}}
                    <h1 class="h5 fw-bolder text-white mb-0">
                        <span class="text-warning">AL-FALAH PUTAK</span>
                    </h1>
                    <p class="small text-white-50 mb-0 ms-3 d-none d-md-inline d-lg-block">Portal Wali Santri</p>
                </div>

                <div class="d-flex align-items-center gap-3">
                    
                    {{-- Sapaan (Hanya Desktop) --}}
                    <span class="d-none d-lg-inline text-white fw-medium small">
                        Selamat Datang, {{ Auth::user()->name ?? 'Wali Santri' }}
                    </span>

                    {{-- 🛑 NOTIFIKASI LONCENG BARU (Menggunakan $unreadCount) 🛑 --}}
                    <a href="{{ route('wali.notifikasi.index') }}" class="notification-icon text-warning" aria-label="Notifikasi">
                        <i class="fas fa-bell fa-lg"></i>
                        @if(isset($unreadCount) && $unreadCount > 0)
                            <span class="notification-badge">{{ $unreadCount > 9 ? '9+' : $unreadCount }}</span>
                        @endif
                    </a>
                    
                    <div class="dropdown">
                        <button id="profile-toggle" class="btn btn-warning rounded-circle p-0 border border-2 border-white" type="button" data-bs-toggle="dropdown" aria-expanded="false" style="width: 40px; height: 40px;">
                            <img class="rounded-circle object-cover" 
                                style="width: 100%; height: 100%; border: none;" 
                                src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=ffc107&color=0b2f56&bold=true" 
                                alt="Foto Profil Wali">
                        </button>
                        
                        <ul id="profile-dropdown" class="dropdown-menu dropdown-menu-end shadow-lg border-0">
                            <h6 class="dropdown-header fw-bold text-truncate">{{ Auth::user()->name ?? 'Wali Santri' }}</h6>
                            <li><hr class="dropdown-divider"></li>
                            
                            {{-- BARIS DIPERBAIKI: Menggunakan dropdown-item dan ikon --}}
                            <li>
                                <a class="dropdown-item" href="{{ route('wali.profile.show') }}">
                                    <i class="fas fa-user-circle fa-fw me-2"></i> Profil Saya
                                </a>
                            </li>
                            
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="dropdown-item text-danger">
                                        <i class="fas fa-sign-out-alt fa-fw me-2"></i> Logout
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </header>

    {{-- 2. Offcanvas Navigation (Mobile Only) --}}
    <div class="offcanvas offcanvas-start bg-light d-lg-none" tabindex="-1" id="offcanvasWaliNav" aria-labelledby="offcanvasWaliNavLabel">
        
        {{-- Offcanvas Header: Logo Tengah, Tulisan Bawah --}}
        <div class="offcanvas-header header-custom text-white shadow-lg-custom d-flex flex-column pt-4 pb-3 position-relative">
            {{-- Tombol Close di pojok kanan atas Offcanvas Header --}}
            <button type="button" class="btn-close text-reset btn-close-white position-absolute top-0 end-0 mt-3 me-3" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            <img src="{{ asset('Images/kop pondok.png') }}" alt="Logo Al-Falah" class="offcanvas-logo mb-2">
            <h5 class="offcanvas-title fw-bold text-center" id="offcanvasWaliNavLabel">PORTAL WALI SANTRI</h5>
        </div>

        <div class="offcanvas-body d-flex flex-column">
            
            <a href="{{ route('wali.dashboard') }}" 
            class="nav-link {{ $isActive('wali.dashboard') }}">
                <i class="fas fa-tachometer-alt fa-fw"></i> Dashboard
            </a>
            
            <a href="{{ route('wali.tagihan.index') }}" 
            class="nav-link {{ $isActive('wali.tagihan*') }}">
                <i class="fas fa-file-invoice-dollar fa-fw"></i> Tagihan & Pembayaran
            </a>
            
            <a href="{{ route('wali.santri.index') }}" 
            class="nav-link {{ $isActive('wali.santri.*') }}">
                <i class="fas fa-user-graduate fa-fw"></i> Data Santri
            </a>

            {{-- START: MENU ABSENSI BARU (MOBILE) --}}
            <a href="{{ route('wali.absensi.index') }}" 
            class="nav-link {{ $isActive('wali.absensi.*') }}">
                <i class="fas fa-clipboard-check fa-fw"></i> Absensi Santri
            </a>
            {{-- END: MENU ABSENSI BARU (MOBILE) --}}
            {{-- 🛑 MENU NOTIFIKASI DI OFFCANVAS (MOBILE) 🛑 --}}
            <a href="{{ route('wali.notifikasi.index') }}" 
            class="nav-link {{ $isActive('wali.notifikasi.*') }} position-relative">
                <i class="fas fa-bell fa-fw"></i> Notifikasi
                @if(isset($unreadCount) && $unreadCount > 0)
                    <span class="position-absolute end-0 me-3 badge rounded-pill bg-danger border border-light">
                        {{ $unreadCount > 9 ? '9+' : $unreadCount }}
                    </span>
                @endif
            </a>
            
            <a href="{{ route('wali.pengumuman.index') }}" 
            class="nav-link {{ $isActive('wali.pengumuman*') }}">
                <i class="fas fa-bullhorn fa-fw"></i> Pengumuman
            </a>

            <div class="mt-auto">
                <hr class="my-3">
                <p class="small text-muted text-center">v{{ config('app.version', '1.0') }}</p>
            </div>
        </div>
    </div>

    {{-- 2B. Sub-Navbar untuk Navigasi Utama (Desktop Only) --}}
    <nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom sticky-top main-nav d-none d-lg-block">
        <div class="container-fluid px-4">
            <div class="navbar-nav flex-row w-100" id="nav-menu">
                <a href="{{ route('wali.dashboard') }}" class="nav-link px-3 py-3 me-3 {{ $isActive('wali.dashboard') }}"><i class="fas fa-tachometer-alt me-1"></i> Dashboard</a>
                <a href="{{ route('wali.tagihan.index') }}" class="nav-link px-3 py-3 me-3 {{ $isActive('wali.tagihan*') }}"><i class="fas fa-file-invoice-dollar me-1"></i> Tagihan & Pembayaran</a>

                <a href="{{ route('wali.santri.index') }}" class="nav-link px-3 py-3 me-3 {{ $isActive('wali.santri.*') }}"><i class="fas fa-user-graduate me-1"></i> Data Santri</a>

                {{-- START: MENU ABSENSI BARU (DESKTOP) --}}
                <a href="{{ route('wali.absensi.index') }}" class="nav-link px-3 py-3 me-3 {{ $isActive('wali.absensi.*') }}"><i class="fas fa-clipboard-check me-1"></i> Absensi Santri</a>
                {{-- END: MENU ABSENSI BARU (DESKTOP) --}}

                <a href="{{ route('wali.pengumuman.index') }}" class="nav-link px-3 py-3 me-3 {{ $isActive('wali.pengumuman*') }}"><i class="fas fa-bullhorn me-1"></i> Pengumuman</a>
            </div>
        </div>
    </nav>

    <main class="container-fluid px-4 py-4 content-wrapper">
        
        <div class="d-flex justify-content-between align-items-center mb-4 pb-3 border-bottom border-light">
            <div>
                <h1 class="h4 fw-bold text-dark mb-1">@yield('page_title', $pageTitle)</h1>
                <nav aria-label="breadcrumb" class="d-none d-sm-block">
                    <ol class="breadcrumb mb-0 small">
                        <li class="breadcrumb-item"><a href="{{ route('wali.dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item active text-secondary" aria-current="page">@yield('page_title', $pageTitle)</li>
                    </ol>
                </nav>
            </div>
            
            @yield('header_actions')
        </div>

        {{-- Pesan Sukses/Error --}}
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show shadow-lg-custom" role="alert">
                <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show shadow-lg-custom" role="alert">
                <i class="fas fa-exclamation-triangle me-2"></i> {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @yield('content')
    </main>

    <footer class="bg-white p-3 text-center small text-muted border-top shadow-lg-custom">
        <p class="mb-0">Dukungan Jakastra Official | Kebijakan Privasi</p>
        <p class="mb-0">&copy; {{ date('Y') }} SISFO Al-Falah Putak. Hak Cipta Dilindungi.</p>
    </footer>

</body>
</html>