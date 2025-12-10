<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $__env->yieldContent('title', 'Admin Panel'); ?> - Al-Falah Putak</title>
    <meta name="description" content="Sistem Informasi Akademik Pesantren (SIAP) Al-Falah Putak: Akses data santri, pengumuman, tagihan, dan absensi harian secara real-time. Informasi terpusat untuk Wali Santri dan Staf." />
    
    
    <link rel="icon" href="<?php echo e(asset('Images/kop pondok.png')); ?>" sizes="32x32" />
    <link rel="icon" type="image/png" href="<?php echo e(asset('Images/kop pondok.png')); ?>" sizes="192x192" />
    <link rel="apple-touch-icon" href="<?php echo e(asset('Images/kop pondok.png')); ?>" />
    
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&display=swap" rel="stylesheet"> 
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    
    <style>
        /* === VARIABEL WARNA & KONSTANTA === */
        :root {
            --primary-color: #0b2f56; 
            --secondary-color: #ffc107; 
            --text-light: #b3cde0; 
            --hover-bg: #1c4a75; 
            --active-bg: #ffc107; 
            --active-text: #0b2f56; 
            --sidebar-width: 280px;
            --header-height: 65px;
            --transition-speed: 0.3s;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: #f4f6f9; 
            overflow-x: hidden;
        }
        
        /* --- GLOBAL & TRANSITIONS --- */
        .card, .btn, a, .nav-link, #menu-toggle {
            transition: all var(--transition-speed) cubic-bezier(0.25, 0.8, 0.25, 1);
        }
        .shadow-soft { box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08)!important; }
        .h1, .h2, .h3, .h4, .h5, .h6, h1, h2, h3, h4, h5, h6 { font-weight: 700; }
        .small-text { font-size: 0.85rem; }

        /* === SIDEBAR STYLING === */
        #sidebar {
            width: var(--sidebar-width); background-color: var(--primary-color); 
            color: #fff; position: fixed; top: 0; left: 0; height: 100vh;
            transition: transform var(--transition-speed) ease-in-out; 
            z-index: 1050; /* Di atas Navbar dan Overlay */
            transform: translateX(0); 
            box-shadow: 4px 0 15px rgba(0, 0, 0, 0.2); 
        }
        #sidebar .nav-link {
            color: var(--text-light); padding: 12px 18px; margin-bottom: 5px; 
            border-radius: 8px; font-weight: 500; display: flex; align-items: center;
        }
        #sidebar .nav-link i { font-size: 1.1rem; width: 25px; margin-right: 12px; text-align: center; }
        #sidebar .nav-link:hover { background-color: var(--hover-bg); color: #fff; }
        #sidebar .nav-link.active {
            background-color: var(--active-bg); color: var(--active-text) !important; 
            font-weight: 700; box-shadow: 0 4px 10px rgba(255, 193, 7, 0.4); 
        }
        #sidebar .menu-title {
            color: var(--text-light); padding: 0 18px; margin-top: 15px; margin-bottom: 5px; 
            font-size: 0.75rem; 
        }
        #sidebar .overflow-auto::-webkit-scrollbar { width: 6px; }
        #sidebar .overflow-auto::-webkit-scrollbar-thumb { background-color: rgba(255, 255, 255, 0.3); border-radius: 10px; }
        #sidebar .overflow-auto::-webkit-scrollbar-track { background: rgba(0, 0, 0, 0.1); }

        /* === MAIN CONTENT & NAVBAR === */
        #main-content {
            margin-left: var(--sidebar-width); padding-top: var(--header-height); 
            min-height: 100vh; display: flex; flex-direction: column; 
            transition: margin-left var(--transition-speed) ease-in-out;
        }
        .navbar-top {
            height: var(--header-height); z-index: 1040; 
            box-shadow: 0 1px 10px rgba(0, 0, 0, 0.08);
            width: calc(100% - var(--sidebar-width)); 
            margin-left: var(--sidebar-width);
            transition: margin-left var(--transition-speed) ease-in-out, width var(--transition-speed) ease-in-out;
        }
        .content-wrapper { flex-grow: 1; padding-bottom: 30px !important; }
        
        /* Breadcrumb separator icon */
        .breadcrumb-item + .breadcrumb-item::before {
            content: "\f105"; font-family: "Font Awesome 6 Free"; font-weight: 900;
        }
        
        /* === RESPONSIVE MOBILE === */
        @media (max-width: 991px) {
            /* 1. Sidebar Default Hidden */
            #sidebar { 
                transform: translateX(calc(-1 * var(--sidebar-width))); 
            }
            /* 2. Sidebar Visible */
            #sidebar.show { 
                transform: translateX(0); 
                box-shadow: 5px 0 20px rgba(0, 0, 0, 0.6); 
            }
            
            /* 3. Main Content Full Width */
            #main-content { 
                margin-left: 0; 
            }
            
            /* 4. Navbar Full Width */
            .navbar-top { 
                margin-left: 0; 
                width: 100%; 
            }
            
            /* 5. Mobile Brand/Logo Styling */
            .navbar-brand.mobile-brand {
                margin-right: auto;
                margin-left: 10px; 
            }
            
            /* 6. Tombol Toggle Styling */
            #menu-toggle {
                height: 38px;
                width: 38px;
                padding: 0 !important;
                display: inline-flex !important; 
                align-items: center; 
                justify-content: center;
            }
            
            /* 7. Overlay Visibility (Z-index 1030, di bawah Navbar) */
            #overlay {
                z-index: 1030;
            }
        }
        
        /* Hilangkan tombol toggle di desktop */
        @media (min-width: 992px) {
            #menu-toggle {
                display: none !important;
            }
        }
    </style>
    <?php echo $__env->yieldPushContent('css'); ?>
</head>
<body>

    
    <div id="overlay" class="d-none fixed-top w-100 h-100 bg-black opacity-50" style="display: none;"></div>

    <?php
        // LOGIKA PHP (Data & Rute)
        use Illuminate\Support\Facades\Auth;
        use Illuminate\Support\Facades\Route;
        use Illuminate\Support\Str;
        
        $isAuthenticated = Auth::check();
        $isAdmin = $isAuthenticated && method_exists(Auth::user(), 'isAdmin') && Auth::user()->isAdmin();
        
        $currentRoute = Route::currentRouteName();
        $dashboardRoute = $isAuthenticated ? ($isAdmin ? 'admin.dashboard' : 'wali.dashboard') : 'login';
        $profileRoute = $isAuthenticated ? ($isAdmin ? 'admin.profile.show' : 'wali.profile.show') : 'login';

        $isActive = fn($routeName) => $currentRoute === $routeName ? 'active' : '';
        $isActivePattern = function($patterns) use ($currentRoute) {
            if (!$currentRoute) return '';
            foreach ($patterns as $pattern) {
                if (Str::is($pattern, $currentRoute)) {
                    return 'active';
                }
            }
            return '';
        };

        $pendingPayments = 0;
        if ($isAuthenticated && $isAdmin) {
            try {
                // Asumsi: Model Pembayaran ada
                // Ganti dengan logic Anda yang sebenarnya untuk menghitung pembayaran tertunda
                $pendingPayments = 5; 
            } catch (\Throwable $e) {
                $pendingPayments = 0;
            }
        }

        $pageTitle = 'Dashboard';
        // Logika penentuan Judul Halaman
        if ($currentRoute) {
            $baseName = Str::after($currentRoute, '.');
            if (Str::contains($baseName, 'dashboard')) { $pageTitle = 'Dashboard'; } 
            elseif (Str::contains($baseName, 'tagihan') || Str::contains($baseName, 'pembayaran')) { $pageTitle = 'Tagihan & Pembayaran'; } 
            elseif (Str::contains($baseName, 'santri')) { $pageTitle = 'Data Santri'; } 
            elseif (Str::contains($baseName, 'absensi')) { $pageTitle = 'Absensi'; } 
            elseif (Str::contains($baseName, 'pengumuman')) { $pageTitle = 'Pengumuman'; } 
            elseif (Str::contains($baseName, 'konfirmasi')) { $pageTitle = 'Konfirmasi Pembayaran'; }
            elseif (Str::contains($baseName, 'guru')) { $pageTitle = 'Data Guru'; }
            elseif (Str::contains($baseName, 'kelas')) { $pageTitle = 'Data Kelas'; }
            else { $pageTitle = ucwords(str_replace(['.', '_', '-'], ' ', $baseName)); }
        }
    ?>

    
    <aside id="sidebar" class="d-flex flex-column">
        
        
        <div class="p-4 border-bottom border-light border-opacity-25 d-flex flex-column align-items-center"> 
            <a href="<?php echo e(route($dashboardRoute)); ?>" class="text-decoration-none text-center"> 
                
                <img src="<?php echo e(asset('Images/kop pondok.png')); ?>" 
                    alt="Logo Al-Falah Putak" 
                    class="mb-2" 
                    style="height: 60px; width: 60px; object-fit: cover; border-radius: 50%;"> 
                    
                <h5 class="text-white fw-bold mb-0">AL-FALAH PUTAK</h5>
                <small class="text-white-50 small-text">Panel <?php echo e($isAdmin ? 'Admin' : 'Wali Santri'); ?></small>
            </a>
        </div>
        
        <nav class="pt-3 pb-3 flex-grow-1 overflow-auto">
            <h6 class="text-uppercase menu-title fw-semibold small">MENU UTAMA</h6>

            <ul class="nav flex-column px-3"> 
                <li class="nav-item">
                    <a class="nav-link <?php echo e($isActive($dashboardRoute)); ?>" href="<?php echo e(route($dashboardRoute)); ?>">
                        <i class="fas fa-tachometer-alt fa-fw"></i> <span>Dashboard</span>
                    </a>
                </li>
                
                <?php if($isAdmin): ?>
                    
                    
                    <h6 class="text-uppercase menu-title fw-semibold small">DATA MASTER</h6>

                    <li class="nav-item">
                        <a class="nav-link <?php echo e($isActivePattern(['admin.santri*', 'admin.ortu*'])); ?>" href="<?php echo e(route('admin.santri.index')); ?>">
                            <i class="fas fa-user-graduate fa-fw"></i> <span>Santri & Ortu</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo e($isActivePattern(['admin.guru*'])); ?>" href="<?php echo e(route('admin.guru.index')); ?>">
                            <i class="fas fa-chalkboard-teacher fa-fw"></i> <span>Guru</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo e($isActivePattern(['admin.kelas*'])); ?>" href="<?php echo e(route('admin.kelas.index')); ?>">
                            <i class="fas fa-school fa-fw"></i> <span>Kelas</span>
                        </a>
                    </li>
                    
                    <h6 class="text-uppercase menu-title fw-semibold small">KEGIATAN & ABSENSI</h6>

                    <li class="nav-item">
                        <a class="nav-link <?php echo e($isActivePattern(['admin.absensi_baru.index', 'admin.absensi_baru.create'])); ?>" href="<?php echo e(route('admin.absensi_baru.index')); ?>">
                            <i class="fas fa-calendar-check fa-fw"></i> <span>Absensi Harian</span>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link <?php echo e($isActivePattern(['admin.absensi_rekap*'])); ?>" href="<?php echo e(route('admin.absensi_rekap.index')); ?>">
                            <i class="fas fa-clipboard-check fa-fw"></i> <span>Rekap Alpha Bulanan</span>
                        </a>
                    </li>

                    <h6 class="text-uppercase menu-title fw-semibold small">MANAJEMEN KEUANGAN</h6>

                    <li class="nav-item">
                        <a class="nav-link <?php echo e($isActive('admin.tagihan.konfirmasi.index')); ?>" href="<?php echo e(route('admin.tagihan.konfirmasi.index')); ?>">
                            <i class="fas fa-check-double fa-fw"></i> <span>Konfirmasi Bayar</span>
                            <?php if($pendingPayments > 0): ?>
                                <span class="badge rounded-pill bg-danger ms-auto" style="font-size: 0.65em;"><?php echo e($pendingPayments > 99 ? '99+' : $pendingPayments); ?></span>
                            <?php endif; ?>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo e($isActivePattern(['admin.tagihan.index', 'admin.tagihan.create'])); ?>" href="<?php echo e(route('admin.tagihan.index')); ?>">
                            <i class="fas fa-list-alt fa-fw"></i> <span>Daftar Tagihan</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo e($isActivePattern(['admin.pembayaran.riwayat', 'admin.pembayaran.show'])); ?>" href="<?php echo e(route('admin.pembayaran.riwayat')); ?>">
                            <i class="fas fa-history fa-fw"></i> <span>Riwayat Pembayaran</span>
                        </a>
                    </li>

                    <h6 class="text-uppercase menu-title fw-semibold small">PENGATURAN SISTEM</h6>

                    <li class="nav-item">
                        <a class="nav-link <?php echo e($isActivePattern(['admin.user*'])); ?>" href="<?php echo e(route('admin.user.index')); ?>">
                            <i class="fas fa-users fa-fw"></i> <span>User & Akses</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo e($isActivePattern(['admin.rekening*'])); ?>" href="<?php echo e(route('admin.rekening.index')); ?>">
                            <i class="fas fa-university fa-fw"></i> <span>Rekening Bank</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo e($isActivePattern(['admin.pengumuman*'])); ?>" href="<?php echo e(route('admin.pengumuman.index')); ?>" >
                            <i class="fas fa-bullhorn fa-fw"></i> <span>Pengumuman</span>
                        </a>
                    </li>
                <?php else: ?>
                    
                    
                    <li class="nav-item">
                        <a class="nav-link <?php echo e($isActivePattern(['wali.tagihan*', 'wali.pembayaran*'])); ?>" href="<?php echo e(route('wali.tagihan.index')); ?>">
                            <i class="fas fa-money-bill-wave fa-fw"></i> <span>Tagihan & Pembayaran</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo e($isActive('wali.absensi.index')); ?>" href="<?php echo e(route('wali.absensi.index')); ?>">
                            <i class="fas fa-calendar-alt fa-fw"></i> <span>Absensi Santri</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo e($isActive('wali.santri.index')); ?>" href="<?php echo e(route('wali.santri.index')); ?>">
                            <i class="fas fa-user-graduate fa-fw"></i> <span>Data Santri</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo e($isActive('wali.pengumuman.index')); ?>" href="<?php echo e(route('wali.pengumuman.index')); ?>">
                            <i class="fas fa-bullhorn fa-fw"></i> <span>Pengumuman</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo e($isActive('wali.notifications.index')); ?>" href="<?php echo e(route('wali.notifications.index')); ?>">
                            <i class="fas fa-bell fa-fw"></i> <span>Pusat Notifikasi</span>
                        </a>
                    </li>
                <?php endif; ?>
            </ul>
        </nav>
        
        
        <div class="p-4 border-top border-light border-opacity-25 mt-auto sidebar-footer">
            <form method="POST" action="<?php echo e(route('logout')); ?>" class="mb-3">
                <?php echo csrf_field(); ?>
                <button type="submit" class="btn btn-sm btn-warning w-100 d-flex align-items-center justify-content-center fw-semibold shadow-soft"> 
                    <i class="fas fa-sign-out-alt me-2"></i>
                    Logout
                </button>
            </form>
            <div class="text-center small-text text-white-50">
                <p class="mb-0">Panel SISFO v1.0</p>
            </div>
        </div>
    </aside>

    <main id="main-content">
        
        
        <nav class="navbar navbar-expand-lg navbar-light bg-white fixed-top navbar-top">
            <div class="container-fluid"> 
                
                
                <button id="menu-toggle" class="btn btn-primary d-lg-none shadow" type="button">
                    <i class="fas fa-bars"></i>
                </button>
                
                
                <a class="navbar-brand fw-bolder fs-5 d-lg-none mobile-brand" 
                   href="<?php echo e(route($dashboardRoute)); ?>"
                   style="color: var(--primary-color) !important; font-size: 1.50rem !important;">
                    <span style="color: var(--secondary-color) !important;">AL-FALAH</span> PUTAK
                </a>

                
                <div class="d-none d-lg-block">
                    <h6 class="text-muted mb-0 small-text"><?php echo $__env->yieldContent('page_title', $pageTitle); ?></h6>
                </div>
                
                
                <div class="ms-auto d-flex align-items-center">
                    <?php if(auth()->guard()->check()): ?>
                        
                        
                        <a href="<?php echo e($isAdmin ? route('admin.tagihan.konfirmasi.index') : route('wali.notifications.index')); ?>" 
                           class="notification-btn text-dark position-relative me-2 p-3" 
                           title="<?php echo e($isAdmin ? 'Konfirmasi Pembayaran' : 'Notifikasi Anda'); ?>"
                           style="line-height: 1;">
                            <i class="fas fa-bell fs-5 text-secondary"></i>
                            <?php if($pendingPayments > 0 && $isAdmin): ?>
                                <span class="position-absolute translate-middle badge rounded-circle bg-danger p-1 border border-light" style="top: 10px; right: 5px; font-size: 0.6em;"> 
                                    <?php echo e($pendingPayments > 9 ? '9+' : $pendingPayments); ?>

                                </span>
                            <?php endif; ?>
                        </a>

                        <div class="dropdown">
                            <button class="btn btn-link text-decoration-none dropdown-toggle p-0 d-flex align-items-center" type="button" data-bs-toggle="dropdown" aria-expanded="false" title="Menu Profil"> 
                                <img class="rounded-circle border border-warning border-3 bg-light" 
                                     src="https://ui-avatars.com/api/?name=<?php echo e(urlencode(Auth::user()->name ?? 'User')); ?>&background=0b2f56&color=ffffff&bold=true" 
                                     alt="Profil" style="width: 40px; height: 40px; object-fit: cover;">
                                <span class="d-none d-lg-inline text-dark ms-2 fw-semibold"><?php echo e(Auth::user()->name ?? 'User'); ?></span>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end shadow-soft border-0">
                                <li>
                                    <h6 class="dropdown-header text-uppercase small text-muted"><?php echo e(Auth::user()->name ?? 'User'); ?></h6>
                                </li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <a class="dropdown-item" href="<?php echo e(route($profileRoute)); ?>">
                                        <i class="fas fa-user-circle fa-fw me-2 text-primary"></i> Profil Saya
                                    </a>
                                </li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form method="POST" action="<?php echo e(route('logout')); ?>">
                                        <?php echo csrf_field(); ?>
                                        <button type="submit" class="dropdown-item text-danger">
                                            <i class="fas fa-sign-out-alt fa-fw me-2"></i> Logout
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </nav>

        <div class="container-fluid py-4 content-wrapper">
            
            
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4 pb-2 border-bottom border-light">
                <div>
                    
                    <h1 class="h3 fw-bold text-primary mb-1"><?php echo $__env->yieldContent('page_title', $pageTitle); ?></h1>
                    
                    
                    <nav aria-label="breadcrumb" class="mt-1">
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item">
                                <a href="<?php echo e(route($dashboardRoute)); ?>" class="text-decoration-none small-text">
                                    <i class="fas fa-home me-1"></i> Home
                                </a>
                            </li>
                            
                            <?php echo $__env->yieldContent('breadcrumb_items'); ?> 
                            
                            <li class="breadcrumb-item active text-primary fw-semibold small-text" aria-current="page"><?php echo $__env->yieldContent('page_title', $pageTitle); ?></li>
                        </ol>
                    </nav>
                </div>
                <div class="d-flex ms-auto mt-2 mt-md-0">
                    <?php echo $__env->yieldContent('header_actions'); ?> 
                </div>
            </div>
            
            
            <?php if(session('error')): ?>
                <div class="alert alert-danger alert-dismissible fade show shadow-soft" role="alert">
                    <i class="fas fa-exclamation-triangle me-2"></i> <?php echo e(session('error')); ?>

                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>
            <?php if(session('success')): ?>
                <div class="alert alert-success alert-dismissible fade show shadow-soft" role="alert">
                    <i class="fas fa-check-circle me-2"></i> <?php echo e(session('success')); ?>

                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            <?php echo $__env->yieldContent('content'); ?>

        </div>

        
        <footer class="bg-white border-top mt-auto py-3">
            <div class="container-fluid text-center small-text text-muted">
                <p class="mb-0">&copy; <?php echo e(date('Y')); ?> SISFO Al-Falah Putak.</p>
            </div>
        </footer>
    </main>

    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    
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
                    overlay.style.display = 'block'; 
                    body.style.overflow = 'hidden'; 
                } else {
                    sidebar.classList.remove('show');
                    overlay.classList.add('d-none');
                    overlay.style.display = 'none'; 
                    body.style.overflow = ''; 
                }
            };
            
            if (menuToggle) {
                menuToggle.addEventListener('click', (e) => {
                    e.stopPropagation(); 
                    toggleMenu();
                });
            }
            
            overlay.addEventListener('click', toggleMenu);
            
            document.querySelectorAll('#sidebar .nav-link').forEach(item => {
                item.addEventListener('click', () => {
                    if (window.innerWidth < 992) {
                        if (sidebar.classList.contains('show')) {
                            setTimeout(toggleMenu, 150); 
                        }
                    }
                });
            });

            window.addEventListener('resize', () => {
                if (window.innerWidth >= 992) {
                    sidebar.classList.remove('show');
                    overlay.classList.add('d-none');
                    overlay.style.display = 'none';
                    body.style.overflow = '';
                }
            });
        });
    </script>

    <?php echo $__env->yieldPushContent('scripts'); ?>
</body>
</html><?php /**PATH /home/axioo/Unduhan/_sisfo-laravel/resources/views/layouts/admin.blade.php ENDPATH**/ ?>