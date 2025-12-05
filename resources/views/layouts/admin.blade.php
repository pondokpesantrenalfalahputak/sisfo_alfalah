<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Al-Falah Putak') - Admin Dashboard</title>

    <meta name="google-site-verification" content="YZijbyw0-7ALwnUh_RzgJxEJRToGG2qpLcvh6P5Oqls" />
    
    <link rel="icon" type="image/png" href="{{ asset('Images/kop pondok.png') }}" />
    
    {{-- ✅ Bootstrap Bundle with Popper --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" defer></script>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&display=swap" rel="stylesheet"> 
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    
    <style>
        :root {
            --primary-color: #0b2f56; /* Biru Tua */
            --secondary-color: #ffc107; /* Kuning Emas/Warning */
            --text-light: #b3cde0;
            --hover-bg: #0d47a1;
            --section-separator: #2c4a75; /* Pemisah lebih gelap */
            --sidebar-width: 280px;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: #f4f6f9; 
        }
        
        /* === SIDEBAR STYLING === */
        #sidebar {
            width: var(--sidebar-width);
            background-color: var(--primary-color); 
            color: #fff;
            position: fixed;
            height: 100vh;
            padding-top: 0;
            transition: all 0.3s;
            z-index: 1050;
            /* Tambahan: Menggunakan flex-shrink untuk konten utama */
            flex-shrink: 0; 
        }
        #sidebar .nav-link {
            color: var(--text-light); 
            padding: 12px 20px;
            margin-bottom: 3px; 
            border-radius: 8px;
            transition: background-color 0.2s, color 0.2s;
            font-weight: 500;
        }
        #sidebar .nav-link:hover {
            background-color: var(--hover-bg); 
            color: #fff;
        }
        /* Perbaikan: Mengatur style icon untuk link aktif */
        #sidebar .nav-link.active {
            background-color: var(--secondary-color); 
            color: var(--primary-color); 
            font-weight: bold;
            box-shadow: 0 4px 10px rgba(255, 193, 7, 0.4); 
        }
        #sidebar .nav-link.active .fas, #sidebar .nav-link.active .far {
            color: var(--primary-color); /* Memastikan icon juga primary color */
        }
        
        #sidebar .menu-title {
            color: var(--text-light);
            border-bottom: 1px solid var(--section-separator);
            padding-bottom: 5px;
            margin-bottom: 10px;
            padding-left: 20px; /* Menyamakan padding kiri */
            padding-right: 20px;
        }
        
        /* === MAIN CONTENT & NAVBAR === */
        #main-content {
            margin-left: var(--sidebar-width); 
            padding-top: 70px; 
            min-height: 100vh;
            display: flex; 
            flex-direction: column; 
            transition: margin-left 0.3s;
        }
        .navbar-top {
            height: 70px; 
            z-index: 1040;
        }
        .content-wrapper {
            flex-grow: 1; 
        }
        .text-breadcrumb-active {
            color: var(--secondary-color) !important;
        }
        /* Menggunakan kelas Bootstrap utility untuk ikon */
        .breadcrumb-item + .breadcrumb-item::before {
            content: "\f054"; 
            font-family: "Font Awesome 6 Free";
            font-weight: 900;
            font-size: 0.7rem;
            color: #ccc;
            margin-right: 0.5rem;
            margin-left: 0.5rem;
        }

        /* === MOBILE VIEW === */
        @media (max-width: 768px) {
            #sidebar {
                margin-left: calc(-1 * var(--sidebar-width));
                transform: translateX(0);
                /* Tambahan: Tambahkan overflow-y pada nav agar menu mobile bisa discroll */
            }
            #sidebar.show {
                margin-left: 0;
            }
            #main-content {
                margin-left: 0;
            }
            .navbar-top .container-fluid {
                padding-left: 70px !important; 
                padding-right: 15px !important;
            }
            #menu-toggle {
                background-color: var(--primary-color) !important;
                border-color: var(--primary-color) !important;
            }
        }
    </style>
</head>
<body>

    {{-- Tombol Toggle Menu (Fixed Mobile) --}}
    <button id="menu-toggle" class="btn btn-primary d-md-none position-fixed top-0 start-0 m-3 shadow" style="z-index: 1060;">
        <i class="fas fa-bars"></i>
    </button>
    
    {{-- Overlay (Fixed Mobile) --}}
    <div id="overlay" class="d-none d-md-none fixed-top w-100 h-100 bg-black opacity-50" style="z-index: 1040;"></div>

    <aside id="sidebar" class="d-flex flex-column">
        
        @php
            // Memeriksa otentikasi dan peran sekali di awal
            $isAuthenticated = Auth::check();
            $isAdmin = $isAuthenticated && method_exists(Auth::user(), 'isAdmin') && Auth::user()->isAdmin();
            
            // Variabel Rute Dinamis
            $dashboardRoute = $isAuthenticated ? ($isAdmin ? 'admin.dashboard' : 'wali.dashboard') : 'login';
            $profileRoute = $isAuthenticated ? ($isAdmin ? 'admin.profile.show' : 'wali.profile.show') : 'login';
        @endphp

        {{-- START: HEADER SIDEBAR (LOGO AND TITLE) --}}
        <div class="p-4 border-bottom border-light border-opacity-25 d-flex flex-column align-items-center"> 
            <a href="{{ route($dashboardRoute) }}" class="text-decoration-none text-center"> 
                
                <img src="{{ asset('Images/image.png') }}" 
                     alt="Logo Al-Falah Putak" 
                     class="mb-2 rounded-circle" 
                     style="height: 60px; width: 60px; object-fit: cover; border: 2px solid var(--secondary-color);"> 
                     
                <h5 class="text-white fw-bold mb-0">AL-FALAH PUTAK</h5>
                <small class="text-white-50">Admin Panel</small>
            </a>
        </div>
        {{-- END: HEADER SIDEBAR --}}
        
        <nav class="p-3 flex-grow-1 overflow-auto">
            <h6 class="text-uppercase menu-title fw-semibold mb-3 small">MENU UTAMA</h6>

            <ul class="nav flex-column">
                @php
                    $currentRoute = Route::currentRouteName();
                    
                    $isActive = fn($routeName) => $currentRoute == $routeName ? 'active' : '';
                    
                    // Fungsi yang diperbaiki untuk mendukung pola rute seperti 'admin.absensi.harian.create'
                    $isActivePattern = function($patterns) use ($currentRoute) {
                        foreach ($patterns as $pattern) {
                            if (\Illuminate\Support\Str::is($pattern, $currentRoute)) {
                                return 'active';
                            }
                        }
                        return '';
                    };

                    $pendingPayments = 0;
                    if ($isAdmin) {
                        try {
                            $pendingPayments = \App\Models\Pembayaran::where('status_konfirmasi', 'Menunggu')->count(); 
                        } catch (\Throwable $e) {
                            $pendingPayments = 0;
                        }
                    }
                @endphp

                @if($isAdmin)
                    {{-- Navigasi untuk ADMIN --}}

                    <li class="nav-item">
                        <a class="nav-link {{ $isActive('admin.dashboard') }}" href="{{ route('admin.dashboard') }}">
                            <i class="fas fa-tachometer-alt fa-fw me-3"></i> Dashboard
                        </a>
                    </li>
                    
                    <h6 class="text-uppercase menu-title fw-semibold mt-4 mb-3 small">DATA MASTER</h6>

                    <li class="nav-item">
                        <a class="nav-link {{ $isActivePattern(['admin.santri*', 'admin.ortu*']) }}" href="{{ route('admin.santri.index') }}">
                            <i class="fas fa-user-graduate fa-fw me-3"></i> Santri & Ortu
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ $isActive('admin.guru.index') }}" href="{{ route('admin.guru.index') }}">
                            <i class="fas fa-chalkboard-teacher fa-fw me-3"></i> Guru
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ $isActive('admin.kelas.index') }}" href="{{ route('admin.kelas.index') }}">
                            <i class="fas fa-school fa-fw me-3"></i> Kelas
                        </a>
                    </li>
                    
                    <h6 class="text-uppercase menu-title fw-semibold mt-4 mb-3 small">KEGIATAN & ABSENSI</h6>

                    {{-- ✅ MENU BARU: ABSENSI HARIAN --}}
                    <li class="nav-item">
                        <a class="nav-link {{ $isActivePattern(['admin.absensi_baru.index', 'admin.absensi_baru.*']) }}" href="{{ route('admin.absensi_baru.index') }}">
                            <i class="fas fa-calendar-check fa-fw me-3"></i> Absensi Harian
                        </a>
                    </li>

                    {{-- ✅ REKAP ABSENSI --}}
                    <li class="nav-item">
                        <a class="nav-link {{ $isActivePattern(['admin.absensi_rekap*']) }}" href="{{ route('admin.absensi_rekap.index') }}">
                            <i class="fas fa-clipboard-check fa-fw me-3"></i> Rekap Alpha Bulanan
                        </a>
                    </li>

                    <h6 class="text-uppercase menu-title fw-semibold mt-4 mb-3 small">MANAJEMEN KEUANGAN</h6>

                    <li class="nav-item">
                        <a class="nav-link {{ $isActive('admin.tagihan.konfirmasi.index') }}" href="{{ route('admin.tagihan.konfirmasi.index') }}">
                            <i class="fas fa-check-double fa-fw me-3"></i> Konfirmasi Bayar
                            @if ($pendingPayments > 0)
                                <span class="badge rounded-pill bg-danger ms-2" style="font-size: 0.65em;">{{ $pendingPayments > 99 ? '99+' : $pendingPayments }}</span>
                            @endif
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ $isActivePattern(['admin.tagihan.index', 'admin.tagihan.create']) }}" href="{{ route('admin.tagihan.index') }}">
                            <i class="fas fa-list-alt fa-fw me-3"></i> Daftar Tagihan
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ $isActivePattern(['admin.pembayaran.riwayat', 'admin.pembayaran.show']) }}" href="{{ route('admin.pembayaran.riwayat') }}">
                            <i class="fas fa-history fa-fw me-3"></i> Riwayat Pembayaran
                        </a>
                    </li>

                    <h6 class="text-uppercase menu-title fw-semibold mt-4 mb-3 small">PENGATURAN SISTEM</h6>

                    {{-- Pengaturan --}}
                    <li class="nav-item">
                        <a class="nav-link {{ $isActive('admin.user.index') }}" href="{{ route('admin.user.index') }}">
                            <i class="fas fa-users fa-fw me-3"></i> User & Akses
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ $isActivePattern(['admin.rekening*']) }}" href="{{ route('admin.rekening.index') }}">
                            <i class="fas fa-university fa-fw me-3"></i> Rekening Bank
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ $isActivePattern(['admin.pengumuman*']) }}" href="{{ route('admin.pengumuman.index') }}" >
                            <i class="fas fa-bullhorn fa-fw me-3"></i> Pengumuman
                        </a>
                    </li>
                @else
                    {{-- Navigasi untuk WALI SANTRI --}}
                    
                    <li class="nav-item">
                        <a class="nav-link {{ $isActive('wali.dashboard') }}" href="{{ route('wali.dashboard') }}">
                            <i class="fas fa-tachometer-alt fa-fw me-3"></i> Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ $isActivePattern(['wali.tagihan', 'wali.pembayaran']) }}" href="{{ route('wali.tagihan.index') }}">
                            <i class="fas fa-money-bill-wave fa-fw me-3"></i> Tagihan & Pembayaran
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ $isActive('wali.absensi.index') }}" href="{{ route('wali.absensi.index') }}">
                            <i class="fas fa-calendar-alt fa-fw me-3"></i> Absensi Santri
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ $isActive('wali.santri.index') }}" href="{{ route('wali.santri.index') }}">
                            <i class="fas fa-user-graduate fa-fw me-3"></i> Data Santri
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ $isActive('wali.pengumuman.index') }}" href="{{ route('wali.pengumuman.index') }}">
                            <i class="fas fa-bullhorn fa-fw me-3"></i> Pengumuman
                        </a>
                    </li>
                @endif
            </ul>
        </nav>
        
        {{-- Footer Sidebar --}}
        <div class="p-4 border-top border-light border-opacity-25 mt-auto">
            
            <form method="POST" action="{{ route('logout') }}" class="mb-3">
                @csrf
                <button type="submit" class="btn btn-sm btn-outline-light w-100 d-flex align-items-center justify-content-center">
                    <i class="fas fa-sign-out-alt me-2"></i>
                    Logout
                </button>
            </form>

            <div class="text-center small text-white-50">
                <p class="mb-0">Panel Admin SISFO v1.0</p>
            </div>
        </div>
    </aside>

    <main id="main-content">
        
        <nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom shadow-sm fixed-top navbar-top">
            <div class="container-fluid"> 
                
                {{-- START: BRAND AL-FALAH PUTAK (VERSI MOBILE - KIRI) --}}
                <a class="navbar-brand fw-bolder fs-5 d-md-none" 
                   href="{{ route($dashboardRoute) }}"
                   style="color: var(--primary-color) !important; font-size: 1.3rem !important;">
                    <span style="color: var(--secondary-color) !important;">AL-FALAH PUTAK</span>
                </a>
                {{-- END: BRAND AL-FALAH PUTAK (VERSI MOBILE) --}}

                {{-- START: JUDUL DI NAVBAR (DESKTOP ONLY) --}}
                <div class="d-none d-md-block">
                    {{-- Judul tetap di content, tapi tambahkan placeholder untuk alignment --}}
                </div>
                {{-- END: JUDUL DI NAVBAR (DESKTOP ONLY) --}}

                {{-- Konten Lonceng/Profil di kanan (ms-auto) --}}
                <div class="ms-auto">
                    @auth
                    <div class="d-flex align-items-center">
                        
                        {{-- Notifikasi Lonceng --}}
                        <a href="{{ $isAdmin ? route('admin.tagihan.konfirmasi.index') : '#' }}" 
                           class="btn btn-link text-dark position-relative me-3" 
                           type="button" style="width: 40px; height: 40px; text-decoration: none;">
                            <i class="fas fa-bell fs-5"></i>
                            @if ($pendingPayments > 0)
                                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger p-1 small">
                                    {{ $pendingPayments > 9 ? '9+' : $pendingPayments }}
                                    <span class="visually-hidden">notifikasi baru</span>
                                </span>
                            @endif
                        </a>

                        <div class="dropdown">
                            <button class="btn btn-link text-decoration-none dropdown-toggle p-0" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <img class="rounded-circle border border-warning border-3 bg-light" 
                                     src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=2563eb&color=ffffff&bold=true" 
                                     alt="Profil" style="width: 40px; height: 40px; object-fit: cover;">
                                <span class="d-none d-lg-inline text-dark ms-2 fw-semibold">{{ Auth::user()->name }}</span>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end shadow border-0">
                                <li>
                                    <a class="dropdown-item" href="{{ route($profileRoute) }}">
                                        <i class="fas fa-user-circle fa-fw me-2"></i> Profil Saya
                                    </a>
                                </li>
                                <li><hr class="dropdown-divider"></li>
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
                    @endauth
                </div>
            </div>
        </nav>

        <div class="container-fluid py-4 content-wrapper">
            
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    {{-- Judul Halaman --}}
                    <h1 class="h3 fw-bold text-primary mb-1">@yield('page_title', 'Dashboard')</h1>
                    
                    {{-- Breadcrumb --}}
                    <nav aria-label="breadcrumb" class="mt-1">
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item">
                                <a href="{{ route($dashboardRoute) }}" class="text-decoration-none text-muted small">
                                    <i class="fas fa-home me-1"></i> Home
                                </a>
                            </li>
                            {{-- Yield Breadcrumb Items (Jika ada) --}}
                            @yield('breadcrumb_items') 
                            
                            {{-- Item terakhir --}}
                            <li class="breadcrumb-item active text-breadcrumb-active fw-semibold small" aria-current="page">@yield('page_title', 'Dashboard')</li>
                        </ol>
                    </nav>
                </div>
                <div class="d-flex ms-auto">
                    @yield('header_actions') 
                </div>
            </div>

            @yield('content')

        </div>

        {{-- START: FOOTER COPYRIGHT DI BAWAH MAIN CONTENT --}}
        <footer class="bg-white border-top mt-auto py-3">
            <div class="container-fluid text-center small text-muted">
                <p class="mb-0">&copy; {{ date('Y') }} Al-Falah Putak. Code By JAKASTRA OFFICIAL. Hak Cipta Dilindungi.</p>
            </div>
        </footer>
        {{-- END: FOOTER COPYRIGHT DI BAWAH MAIN CONTENT --}}
    </main>

    {{-- Script untuk Toggle Sidebar --}}
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const sidebar = document.getElementById('sidebar');
            const menuToggle = document.getElementById('menu-toggle');
            const overlay = document.getElementById('overlay');
            
            const toggleMenu = () => {
                const isHidden = !sidebar.classList.contains('show');
                if (isHidden) {
                    sidebar.classList.add('show');
                    overlay.classList.remove('d-none');
                } else {
                    sidebar.classList.remove('show');
                    overlay.classList.add('d-none');
                }
            };
            
            menuToggle.addEventListener('click', toggleMenu);
            overlay.addEventListener('click', toggleMenu);
            
            // Tutup sidebar saat link diklik di mobile
            document.querySelectorAll('#sidebar .nav-link').forEach(item => {
                item.addEventListener('click', () => {
                    if (window.innerWidth < 768) {
                        if (sidebar.classList.contains('show')) {
                            // Delay sebentar agar navigasi selesai sebelum toggle
                            setTimeout(toggleMenu, 150); 
                        }
                    }
                });
            });

            // Pastikan sidebar tertutup saat resize ke desktop
            window.addEventListener('resize', () => {
                if (window.innerWidth >= 768) {
                    sidebar.classList.remove('show');
                    overlay.classList.add('d-none');
                }
            });
        });
    </script>
</body>
</html>