<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Panel') - Al-Falah Putak</title>
    <meta name="description" content="Sistem Informasi Akademik Pesantren (SIAP) Al-Falah Putak: Akses data santri, pengumuman, tagihan, dan absensi harian secara real-time. Informasi terpusat untuk Wali Santri dan Staf." />
    <meta name="google-site-verification" content="YZijbyw0-7ALwnUh_RzgJxEJRToGG2qpLcvh6P5Oqls" />
    
    <link rel="icon" type="image/png" href="{{ asset('Images/kop pondok.png') }}" />
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&display=swap" rel="stylesheet"> 
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    
    <style>
        /* === VARIABEL WARNA & KONSTANTA === */
        :root {
            --primary-color: #0b2f56; /* Biru Tua */
            --secondary-color: #ffc107; /* Kuning Emas/Warning */
            --text-light: #b3cde0; /* Teks terang untuk sidebar */
            --hover-bg: #1c4a75; /* Background hover yang lebih jelas */
            --active-bg: #ffc107; /* Background aktif */
            --active-text: #0b2f56; /* Teks aktif (Primary Color) */
            --section-separator: #2c4a75; /* Pemisah lebih gelap */
            --sidebar-width: 280px;
            --header-height: 65px;
            --border-radius-lg: 12px;
            --transition-speed: 0.3s;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: #f4f6f9; 
            overflow-x: hidden;
        }
        
        /* --- GLOBAL ENHANCEMENTS --- */
        .card, .btn, a, .nav-link, #menu-toggle {
            transition: all var(--transition-speed) cubic-bezier(0.25, 0.8, 0.25, 1);
        }
        .shadow-soft { box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08)!important; }
        .card, .modal-content, .btn-lg, .dropdown-menu { border-radius: var(--border-radius-lg); }
        .h1, .h2, .h3, .h4, .h5, .h6, h1, h2, h3, h4, h5, h6 { font-weight: 700; }

        /* === SIDEBAR STYLING === */
        #sidebar {
            width: var(--sidebar-width); background-color: var(--primary-color); 
            color: #fff; position: fixed; height: 100vh; padding-top: 0;
            transition: transform var(--transition-speed) ease-in-out; 
            z-index: 1050; box-shadow: 4px 0 15px rgba(0, 0, 0, 0.2); 
            transform: translateX(0); 
        }
        #sidebar .overflow-auto::-webkit-scrollbar { width: 5px; }
        #sidebar .overflow-auto::-webkit-scrollbar-thumb { background-color: rgba(255, 255, 255, 0.3); border-radius: 10px; }
        #sidebar .nav-link {
            color: var(--text-light); padding: 12px 18px; margin-bottom: 5px; 
            border-radius: 6px; font-weight: 500; display: flex; align-items: center;
        }
        #sidebar .nav-link i { font-size: 1.1rem; width: 20px; margin-right: 15px; }
        #sidebar .nav-link:hover { background-color: var(--hover-bg); color: #fff; transform: translateX(3px); }
        #sidebar .nav-link.active {
            background-color: var(--active-bg); color: var(--active-text) !important; 
            font-weight: 700; box-shadow: 0 4px 10px rgba(255, 193, 7, 0.4); transform: translateX(0);
        }
        #sidebar .menu-title {
            color: var(--text-light); padding-bottom: 5px; margin-bottom: 10px; padding-left: 18px; 
        }

        /* === MAIN CONTENT & NAVBAR === */
        #main-content {
            margin-left: var(--sidebar-width); padding-top: var(--header-height); 
            min-height: 100vh; display: flex; flex-direction: column; 
            transition: margin-left var(--transition-speed) ease-in-out;
        }
        .navbar-top {
            height: var(--header-height); z-index: 1040; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
            width: calc(100% - var(--sidebar-width)); margin-left: var(--sidebar-width);
            transition: margin-left var(--transition-speed) ease-in-out, width var(--transition-speed) ease-in-out;
        }
        .content-wrapper { flex-grow: 1; padding-bottom: 20px !important; }
        .breadcrumb-item + .breadcrumb-item::before {
            content: "\f105"; font-family: "Font Awesome 6 Free"; font-weight: 900;
            font-size: 0.8rem; color: #ccc; margin-right: 0.5rem; margin-left: 0.5rem;
        }

        /* === RESPONSIVE MOBILE (FIXED) === */
        @media (max-width: 768px) {
            #sidebar { transform: translateX(calc(-1 * var(--sidebar-width))); }
            #sidebar.show { transform: translateX(0); box-shadow: 5px 0 15px rgba(0, 0, 0, 0.5); }
            /* Mengganti @yield('mobile_padding_top', '65px') dengan variabel CSS yang konsisten */
            #main-content { margin-left: 0; padding-top: var(--header-height); } 
            .navbar-top { margin-left: 0; width: 100%; }
            #menu-toggle {
                background-color: var(--primary-color) !important; border-color: var(--primary-color) !important;
                left: 15px; top: 6px !important; z-index: 1060;
            }
            .navbar-top .container-fluid { padding-left: 60px !important; padding-right: 15px !important; }
            .content-wrapper .h3 { font-size: 1.5rem; }
        }
    </style>
</head>
<body>

    {{-- Tombol Toggle Menu (Fixed Mobile) --}}
    <button id="menu-toggle" class="btn btn-primary d-md-none position-fixed top-0 start-0 m-2 shadow" style="z-index: 1060;">
        <i class="fas fa-bars"></i>
    </button>
    
    {{-- Overlay (Fixed Mobile) --}}
    <div id="overlay" class="d-none fixed-top w-100 h-100 bg-black opacity-50" style="z-index: 1040;"></div>

    @php
        // 1. PENGECEKAN AUTENTIKASI DAN PERAN (ROLE CHECK)
        $isAuthenticated = Auth::check();
        $isAdmin = $isAuthenticated && method_exists(Auth::user(), 'isAdmin') && Auth::user()->isAdmin();
        
        // 2. LOGIKA RUTE DINAMIS
        $currentRoute = Route::currentRouteName();
        $dashboardRoute = $isAuthenticated ? ($isAdmin ? 'admin.dashboard' : 'wali.dashboard') : 'login';
        $profileRoute = $isAuthenticated ? ($isAdmin ? 'admin.profile.show' : 'wali.profile.show') : 'login';

        // 3. FUNGSI UNTUK STATUS ACTIVE
        $isActive = fn($routeName) => $currentRoute == $routeName ? 'active' : '';
        $isActivePattern = function($patterns) use ($currentRoute) {
            foreach ($patterns as $pattern) {
                if (\Illuminate\Support\Str::is($pattern, $currentRoute)) {
                    return 'active';
                }
            }
            return '';
        };

        // 4. LOGIKA BADGE NOTIFIKASI
        $pendingPayments = 0;
        if ($isAuthenticated && $isAdmin) {
            try {
                $pendingPayments = \App\Models\Pembayaran::where('status_konfirmasi', 'Menunggu')->count(); 
            } catch (\Throwable $e) {
                $pendingPayments = 0;
            }
        }

        // 5. PENENTUAN JUDUL HALAMAN UTAMA (Untuk breadcrumb dan @yield('page_title'))
        $pageTitle = 'Dashboard';
        if ($currentRoute) {
            $baseName = str_replace(['admin.', 'wali.'], '', $currentRoute);
            if (\Illuminate\Support\Str::contains($baseName, 'dashboard')) {
                $pageTitle = 'Dashboard';
            } elseif (\Illuminate\Support\Str::contains($baseName, 'tagihan') || \Illuminate\Support\Str::contains($baseName, 'pembayaran')) {
                $pageTitle = 'Tagihan & Pembayaran';
            } elseif (\Illuminate\Support\Str::contains($baseName, 'santri')) {
                $pageTitle = 'Data Santri';
            } elseif (\Illuminate\Support\Str::contains($baseName, 'absensi')) {
                $pageTitle = 'Absensi';
            } elseif (\Illuminate\Support\Str::contains($baseName, 'pengumuman')) {
                $pageTitle = 'Pengumuman';
            } elseif (\Illuminate\Support\Str::contains($baseName, 'konfirmasi')) {
                $pageTitle = 'Konfirmasi Pembayaran';
            } else {
                $pageTitle = ucwords(str_replace(['.', '_'], ' ', $baseName));
            }
        }
    @endphp

    <aside id="sidebar" class="d-flex flex-column">
        
        {{-- START: HEADER SIDEBAR (LOGO AND TITLE) --}}
        <div class="p-4 border-bottom border-light border-opacity-25 d-flex flex-column align-items-center"> 
            <a href="{{ route($dashboardRoute) }}" class="text-decoration-none text-center"> 
                
                <img src="{{ asset('Images/kop pondok.png') }}" 
                    alt="Logo Al-Falah Putak" 
                    class="mb-2" 
                    style="height: 60px; width: 60px; object-fit: cover; border-radius: 50%;"> 
                    
                <h5 class="text-white fw-bold mb-0">AL-FALAH PUTAK</h5>
                <small class="text-white-50">Panel {{ $isAdmin ? 'Admin' : 'Wali Santri' }}</small>
            </a>
        </div>
        {{-- END: HEADER SIDEBAR --}}
        
        <nav class="pt-3 pb-3 flex-grow-1 overflow-auto">
            <h6 class="text-uppercase menu-title fw-semibold mb-3 small">MENU UTAMA</h6>

            <ul class="nav flex-column px-3"> 
                <li class="nav-item">
                    <a class="nav-link {{ $isActive($dashboardRoute) }}" href="{{ route($dashboardRoute) }}">
                        <i class="fas fa-tachometer-alt fa-fw"></i> Dashboard
                    </a>
                </li>
                
                @if($isAdmin)
                    {{-- Navigasi untuk ADMIN --}}
                    
                    <h6 class="text-uppercase menu-title fw-semibold mt-4 mb-3 small">DATA MASTER</h6>

                    <li class="nav-item">
                        <a class="nav-link {{ $isActivePattern(['admin.santri*', 'admin.ortu*']) }}" href="{{ route('admin.santri.index') }}">
                            <i class="fas fa-user-graduate fa-fw"></i> Santri & Ortu
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ $isActivePattern(['admin.guru*']) }}" href="{{ route('admin.guru.index') }}">
                            <i class="fas fa-chalkboard-teacher fa-fw"></i> Guru
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ $isActivePattern(['admin.kelas*']) }}" href="{{ route('admin.kelas.index') }}">
                            <i class="fas fa-school fa-fw"></i> Kelas
                        </a>
                    </li>
                    
                    <h6 class="text-uppercase menu-title fw-semibold mt-4 mb-3 small">KEGIATAN & ABSENSI</h6>

                    <li class="nav-item">
                        <a class="nav-link {{ $isActivePattern(['admin.absensi_baru.index', 'admin.absensi_baru.create']) }}" href="{{ route('admin.absensi_baru.index') }}">
                            <i class="fas fa-calendar-check fa-fw"></i> Absensi Harian
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link {{ $isActivePattern(['admin.absensi_rekap*']) }}" href="{{ route('admin.absensi_rekap.index') }}">
                            <i class="fas fa-clipboard-check fa-fw"></i> Rekap Alpha Bulanan
                        </a>
                    </li>

                    <h6 class="text-uppercase menu-title fw-semibold mt-4 mb-3 small">MANAJEMEN KEUANGAN</h6>

                    <li class="nav-item">
                        <a class="nav-link {{ $isActive('admin.tagihan.konfirmasi.index') }}" href="{{ route('admin.tagihan.konfirmasi.index') }}">
                            <i class="fas fa-check-double fa-fw"></i> Konfirmasi Bayar
                            @if ($pendingPayments > 0)
                                <span class="badge rounded-pill bg-danger ms-auto" style="font-size: 0.65em;">{{ $pendingPayments > 99 ? '99+' : $pendingPayments }}</span>
                            @endif
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ $isActivePattern(['admin.tagihan.index', 'admin.tagihan.create']) }}" href="{{ route('admin.tagihan.index') }}">
                            <i class="fas fa-list-alt fa-fw"></i> Daftar Tagihan
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ $isActivePattern(['admin.pembayaran.riwayat', 'admin.pembayaran.show']) }}" href="{{ route('admin.pembayaran.riwayat') }}">
                            <i class="fas fa-history fa-fw"></i> Riwayat Pembayaran
                        </a>
                    </li>

                    <h6 class="text-uppercase menu-title fw-semibold mt-4 mb-3 small">PENGATURAN SISTEM</h6>

                    <li class="nav-item">
                        <a class="nav-link {{ $isActivePattern(['admin.user*']) }}" href="{{ route('admin.user.index') }}">
                            <i class="fas fa-users fa-fw"></i> User & Akses
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ $isActivePattern(['admin.rekening*']) }}" href="{{ route('admin.rekening.index') }}">
                            <i class="fas fa-university fa-fw"></i> Rekening Bank
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ $isActivePattern(['admin.pengumuman*']) }}" href="{{ route('admin.pengumuman.index') }}" >
                            <i class="fas fa-bullhorn fa-fw"></i> Pengumuman
                        </a>
                    </li>
                @else
                    {{-- Navigasi untuk WALI SANTRI --}}
                    
                    <li class="nav-item">
                        <a class="nav-link {{ $isActivePattern(['wali.tagihan*', 'wali.pembayaran*']) }}" href="{{ route('wali.tagihan.index') }}">
                            <i class="fas fa-money-bill-wave fa-fw"></i> Tagihan & Pembayaran
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ $isActive('wali.absensi.index') }}" href="{{ route('wali.absensi.index') }}">
                            <i class="fas fa-calendar-alt fa-fw"></i> Absensi Santri
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ $isActive('wali.santri.index') }}" href="{{ route('wali.santri.index') }}">
                            <i class="fas fa-user-graduate fa-fw"></i> Data Santri
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ $isActive('wali.pengumuman.index') }}" href="{{ route('wali.pengumuman.index') }}">
                            <i class="fas fa-bullhorn fa-fw"></i> Pengumuman
                        </a>
                    </li>
                @endif
            </ul>
        </nav>
        
        {{-- Footer Sidebar --}}
        <div class="p-4 border-top border-light border-opacity-25 mt-auto">
            
            <form method="POST" action="{{ route('logout') }}" class="mb-3">
                @csrf
                <button type="submit" class="btn btn-sm btn-warning w-100 d-flex align-items-center justify-content-center fw-semibold" style="color: var(--primary-color);"> 
                    <i class="fas fa-sign-out-alt me-2"></i>
                    Logout
                </button>
            </form>

            <div class="text-center small text-white-50">
                <p class="mb-0">Panel SISFO v1.0</p>
            </div>
        </div>
    </aside>

    <main id="main-content">
        
        {{-- Navbar Top - Fixed Header --}}
        <nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom shadow-sm fixed-top navbar-top">
            <div class="container-fluid"> 
                
                {{-- BRAND (MOBILE) --}}
                <a class="navbar-brand fw-bolder fs-5 d-md-none" 
                   href="{{ route($dashboardRoute) }}"
                   style="color: var(--primary-color) !important; font-size: 1.5rem !important;">
                    <span style="color: var(--secondary-color) !important;">AL-FALAH</span> PUTAK
                </a>

                <div class="ms-auto">
                    @auth
                    <div class="d-flex align-items-center">
                        
                        {{-- Notifikasi Lonceng --}}
                        <a href="{{ $isAdmin ? route('admin.tagihan.konfirmasi.index') : '#' }}" 
                           class="btn btn-link text-dark position-relative me-2 p-2" 
                           type="button" style="width: 40px; height: 40px; text-decoration: none;">
                            <i class="fas fa-bell fs-5 text-secondary"></i>
                            @if ($pendingPayments > 0 && $isAdmin)
                                <span class="position-absolute top-0 start-100 translate-middle badge rounded-circle bg-danger p-1 border border-light"> 
                                    {{ $pendingPayments > 9 ? '9+' : $pendingPayments }}
                                    <span class="visually-hidden">notifikasi baru</span>
                                </span>
                            @endif
                        </a>

                        <div class="dropdown">
                            <button class="btn btn-link text-decoration-none dropdown-toggle p-0 d-flex align-items-center" type="button" data-bs-toggle="dropdown" aria-expanded="false"> 
                                <img class="rounded-circle border border-warning border-3 bg-light" 
                                     src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name ?? 'User') }}&background=0b2f56&color=ffffff&bold=true" 
                                     alt="Profil" style="width: 40px; height: 40px; object-fit: cover;">
                                <span class="d-none d-lg-inline text-dark ms-2 fw-semibold">{{ Auth::user()->name ?? 'User' }}</span>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end shadow-soft border-0">
                                <li>
                                    <h6 class="dropdown-header text-uppercase small text-muted">{{ Auth::user()->name ?? 'User' }}</h6>
                                </li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <a class="dropdown-item" href="{{ route($profileRoute) }}">
                                        <i class="fas fa-user-circle fa-fw me-2 text-primary"></i> Profil Saya
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
            
            {{-- Header Konten (Judul & Breadcrumb) --}}
            <div class="d-flex justify-content-between align-items-center mb-4 pb-2 border-bottom border-light">
                <div>
                    {{-- Judul Halaman --}}
                    <h1 class="h3 fw-bold text-primary mb-1">@yield('page_title', $pageTitle)</h1>
                    
                    {{-- Breadcrumb --}}
                    <nav aria-label="breadcrumb" class="mt-1">
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item">
                                <a href="{{ route($dashboardRoute) }}" class="text-decoration-none small">
                                    <i class="fas fa-home me-1"></i> Home
                                </a>
                            </li>
                            
                            @yield('breadcrumb_items') 
                            
                            {{-- Item terakhir disetel secara dinamis berdasarkan $pageTitle --}}
                            <li class="breadcrumb-item active text-primary fw-semibold small" aria-current="page">@yield('page_title', $pageTitle)</li>
                        </ol>
                    </nav>
                </div>
                <div class="d-flex ms-auto">
                    @yield('header_actions') 
                </div>
            </div>
            
            {{-- Notifikasi Session --}}
            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show shadow-soft" role="alert">
                    <i class="fas fa-exclamation-triangle me-2"></i> Terjadi Kesalahan! {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show shadow-soft" role="alert">
                    <i class="fas fa-check-circle me-2"></i> Berhasil! {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @yield('content')

        </div>

        {{-- FOOTER --}}
        <footer class="bg-white border-top mt-auto py-3">
            <div class="container-fluid text-center small text-muted">
                <p class="mb-0">&copy; {{ date('Y') }} Jakastra Official. Hak Cipta Dilindungi.</p>
            </div>
        </footer>
    </main>

    {{-- Bootstrap JS Bundle --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>

    {{-- Script untuk Toggle Sidebar --}}
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const sidebar = document.getElementById('sidebar');
            const menuToggle = document.getElementById('menu-toggle');
            const overlay = document.getElementById('overlay');
            const body = document.body;
            
            const toggleMenu = () => {
                const isHidden = !sidebar.classList.contains('show');
                
                if (isHidden) {
                    sidebar.classList.add('show');
                    overlay.classList.remove('d-none');
                    body.style.overflow = 'hidden'; 
                } else {
                    sidebar.classList.remove('show');
                    overlay.classList.add('d-none');
                    body.style.overflow = ''; 
                }
            };
            
            menuToggle.addEventListener('click', (e) => {
                e.stopPropagation(); 
                toggleMenu();
            });
            overlay.addEventListener('click', toggleMenu);
            
            document.querySelectorAll('#sidebar .nav-link').forEach(item => {
                item.addEventListener('click', () => {
                    if (window.innerWidth < 769) {
                        if (!item.hasAttribute('data-bs-toggle')) { 
                            if (sidebar.classList.contains('show')) {
                                setTimeout(toggleMenu, 150); 
                            }
                        }
                    }
                });
            });

            window.addEventListener('resize', () => {
                if (window.innerWidth >= 769) {
                    sidebar.classList.remove('show');
                    overlay.classList.add('d-none');
                    body.style.overflow = '';
                }
            });
        });
    </script>

    @stack('js')
</body>
</html>