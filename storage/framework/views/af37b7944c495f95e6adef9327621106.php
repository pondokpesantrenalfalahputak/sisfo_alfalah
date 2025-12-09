<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $__env->yieldContent('title', 'Portal Wali Santri'); ?> - Al-Falah Putak</title>
    <meta name="description" content="Sistem Informasi Akademik Pesantren (SIAP) Al-Falah Putak: Akses data santri, pengumuman, tagihan, dan absensi harian secara real-time. Informasi terpusat untuk Wali Santri dan Staf." />

    <meta name="google-site-verification" content="YZijbyw0-7ALwnUh_RzgJxEJRToGG2qpLcvh6P5Oqls" />
    
    <link rel="icon" type="image/png" href="<?php echo e(asset('Images/kop pondok.png')); ?>" />
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&display=swap" rel="stylesheet">
    
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
        
        /* 💡 PERBAIKAN 1: Menghilangkan border dan radius pada logo offcanvas */
        .offcanvas-logo {
            height: 80px;
            width: auto;
            /* border: 2px solid rgba(255, 255, 255, 0.5);  <-- DIHILANGKAN */
            /* border-radius: 50%; <-- DIHILANGKAN */
        }

        /* Penyesuaian Offcanvas Header (Logo) */
        .offcanvas-header {
            /* Sedikit diperhalus */
            padding-top: 3rem !important; 
            padding-bottom: 8rem !important; /* Disesuaikan agar tidak terlalu jauh */
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
        
        /* Styling Offcanvas Navigation (Mobile) */
        .offcanvas-body {
            padding: 0.5rem; 
        }

        .offcanvas-body .nav-link {
            padding: 0.75rem 1rem; 
            color: #495057;
            font-weight: 500;
            transition: background-color 0.2s, color 0.2s;
            display: flex;
            align-items: center; 
            margin-bottom: 0.2rem; 
            border-radius: 0.5rem;
        }

        .offcanvas-body .nav-link i {
            font-size: 1.1rem; 
            width: 20px; 
            text-align: center;
            margin-right: 1rem; 
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
            padding: 10px 0; 
        }

        .notification-badge {
            position: absolute;
            top: 5px; 
            right: -5px; 
            padding: 2px 6px;
            border-radius: 50%;
            background: #e74c3c; 
            color: white;
            font-size: 0.65rem;
            font-weight: bold;
            border: 1px solid white; 
            line-height: 1;
            z-index: 10;
        }

        /* --- STYLES UMUM --- */
        .breadcrumb { margin-bottom: 0; }
        .breadcrumb-item a { color: #6c757d; text-decoration: none; }
        .content-wrapper { flex-grow: 1; }
        
        footer { margin-top: 3rem !important; }
    </style>
</head>
<body>

    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" defer></script>

    <?php
        $currentRoute = Route::currentRouteName();
        // Memastikan isActive mendukung pola wildcard
        $isActive = fn($routePattern) => \Illuminate\Support\Str::is($routePattern, $currentRoute) ? 'active' : '';
        
        // Logic untuk menentukan Page Title dari Route (Disederhanakan)
        $pageTitle = trim(str_replace(['wali.', 'index', 'show', 'tagihan', 'pembayaran', 'profil'], '', ucwords(str_replace('.', ' ', $currentRoute))));
        $pageTitle = empty($pageTitle) || $pageTitle == 'Dashboard' ? 'Dashboard' : $pageTitle;
        if (\Illuminate\Support\Str::contains($currentRoute, 'tagihan')) $pageTitle = 'Tagihan & Pembayaran';
        if (\Illuminate\Support\Str::contains($currentRoute, 'santri')) $pageTitle = 'Data Santri';
        if (\Illuminate\Support\Str::contains($currentRoute, 'absensi')) $pageTitle = 'Absensi Santri';
        if (\Illuminate\Support\Str::contains($currentRoute, 'pengumuman')) $pageTitle = 'Pengumuman';

    ?>

    <header class="header-custom shadow-lg-custom sticky-top">
        <div class="container-fluid px-4 h-100">
            <div class="d-flex align-items-center justify-content-between h-100">
                
                
                <button class="btn btn-link p-0 d-lg-none" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasWaliNav" aria-controls="offcanvasWaliNav" aria-label="Toggle navigation">
                    <i class="fas fa-bars fa-lg text-white"></i>
                </button>
                
                <div class="flex-shrink-0 d-flex align-items-center">
                    <h1 class="h5 fw-bolder text-white mb-0">
                        <span class="text-warning">AL-FALAH PUTAK</span>
                    </h1>
                    <p class="small text-white-50 mb-0 ms-3 d-none d-md-inline d-lg-block">Portal Wali Santri</p>
                </div>

                <div class="d-flex align-items-center gap-3">
                    
                    
                    <span class="d-none d-lg-inline text-white fw-medium small">
                        Selamat Datang, <?php echo e(Auth::user()->name ?? 'Wali Santri'); ?>

                    </span>

                    
                    <a href="<?php echo e(route('wali.notifikasi.index')); ?>" class="notification-icon text-warning" aria-label="Notifikasi">
                        <i class="fas fa-bell fa-lg"></i>
                        <?php if(isset($unreadCount) && $unreadCount > 0): ?>
                            <span class="notification-badge"><?php echo e($unreadCount > 9 ? '9+' : $unreadCount); ?></span>
                        <?php endif; ?>
                    </a>
                    
                    <div class="dropdown">
                        <button id="profile-toggle" class="btn btn-warning rounded-circle p-0 border border-2 border-white" type="button" data-bs-toggle="dropdown" aria-expanded="false" style="width: 40px; height: 40px;">
                            <img class="rounded-circle object-cover" 
                                style="width: 100%; height: 100%; border: none;" 
                                src="https://ui-avatars.com/api/?name=<?php echo e(urlencode(Auth::user()->name)); ?>&background=ffc107&color=0b2f56&bold=true" 
                                alt="Foto Profil Wali">
                        </button>
                        
                        <ul id="profile-dropdown" class="dropdown-menu dropdown-menu-end shadow-lg border-0">
                            <h6 class="dropdown-header fw-bold text-truncate"><?php echo e(Auth::user()->name ?? 'Wali Santri'); ?></h6>
                            <li><hr class="dropdown-divider"></li>
                            
                            <li>
                                <a class="dropdown-item" href="<?php echo e(route('wali.profile.show')); ?>">
                                    <i class="fas fa-user-circle fa-fw me-2"></i> Profil Saya
                                </a>
                            </li>
                            
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
                </div>
            </div>
        </div>
    </header>

    
    <div class="offcanvas offcanvas-start bg-light d-lg-none" tabindex="-1" id="offcanvasWaliNav" aria-labelledby="offcanvasWaliNavLabel">
        
        
        <div class="offcanvas-header header-custom text-white shadow-lg-custom d-flex flex-column pt-4 pb-3 position-relative">
            
            <button type="button" class="btn-close text-reset btn-close-white position-absolute top-0 end-0 mt-3 me-3" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            
            
            <img src="<?php echo e(asset('Images/kop pondok.png')); ?>" alt="Logo Al-Falah" class="offcanvas-logo mb-2">
            
            <h5 class="offcanvas-title fw-bold text-center" id="offcanvasWaliNavLabel">PORTAL WALI SANTRI</h5>
        </div>

        <div class="offcanvas-body d-flex flex-column">
            
            <a href="<?php echo e(route('wali.dashboard')); ?>" 
            class="nav-link <?php echo e($isActive('wali.dashboard')); ?>">
                <i class="fas fa-tachometer-alt fa-fw"></i> Dashboard
            </a>
            
            <a href="<?php echo e(route('wali.tagihan.index')); ?>" 
            class="nav-link <?php echo e($isActive('wali.tagihan*')); ?>">
                <i class="fas fa-file-invoice-dollar fa-fw"></i> Tagihan & Pembayaran
            </a>
            
            <a href="<?php echo e(route('wali.santri.index')); ?>" 
            class="nav-link <?php echo e($isActive('wali.santri.*')); ?>">
                <i class="fas fa-user-graduate fa-fw"></i> Data Santri
            </a>

            <a href="<?php echo e(route('wali.absensi.index')); ?>" 
            class="nav-link <?php echo e($isActive('wali.absensi.*')); ?>">
                <i class="fas fa-clipboard-check fa-fw"></i> Absensi Santri
            </a>
            
            
            <a href="<?php echo e(route('wali.notifikasi.index')); ?>" 
            class="nav-link <?php echo e($isActive('wali.notifikasi.*')); ?> position-relative">
                <i class="fas fa-bell fa-fw"></i> Notifikasi
                <?php if(isset($unreadCount) && $unreadCount > 0): ?>
                    <span class="position-absolute end-0 me-3 badge rounded-pill bg-danger border border-light">
                        <?php echo e($unreadCount > 9 ? '9+' : $unreadCount); ?>

                    </span>
                <?php endif; ?>
            </a>
            
            <a href="<?php echo e(route('wali.pengumuman.index')); ?>" 
            class="nav-link <?php echo e($isActive('wali.pengumuman*')); ?>">
                <i class="fas fa-bullhorn fa-fw"></i> Pengumuman
            </a>

            <div class="mt-auto">
                <hr class="my-3">
                <p class="small text-muted text-center">v<?php echo e(config('app.version', '1.0')); ?></p>
            </div>
        </div>
    </div>

    
    <nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom sticky-top main-nav d-none d-lg-block">
        <div class="container-fluid px-4">
            <div class="navbar-nav flex-row w-100" id="nav-menu">
                <a href="<?php echo e(route('wali.dashboard')); ?>" class="nav-link px-3 py-3 me-3 <?php echo e($isActive('wali.dashboard')); ?>"><i class="fas fa-tachometer-alt me-1"></i> Dashboard</a>
                <a href="<?php echo e(route('wali.tagihan.index')); ?>" class="nav-link px-3 py-3 me-3 <?php echo e($isActive('wali.tagihan*')); ?>"><i class="fas fa-file-invoice-dollar me-1"></i> Tagihan & Pembayaran</a>

                <a href="<?php echo e(route('wali.santri.index')); ?>" class="nav-link px-3 py-3 me-3 <?php echo e($isActive('wali.santri.*')); ?>"><i class="fas fa-user-graduate me-1"></i> Data Santri</a>

                <a href="<?php echo e(route('wali.absensi.index')); ?>" class="nav-link px-3 py-3 me-3 <?php echo e($isActive('wali.absensi.*')); ?>"><i class="fas fa-clipboard-check me-1"></i> Absensi Santri</a>

                <a href="<?php echo e(route('wali.pengumuman.index')); ?>" class="nav-link px-3 py-3 me-3 <?php echo e($isActive('wali.pengumuman*')); ?>"><i class="fas fa-bullhorn me-1"></i> Pengumuman</a>
            </div>
        </div>
    </nav>

    <main class="container-fluid px-4 py-4 content-wrapper">
        
        <div class="d-flex justify-content-between align-items-center mb-4 pb-3 border-bottom border-light">
            <div>
                <h1 class="h4 fw-bold text-dark mb-1"><?php echo $__env->yieldContent('page_title', $pageTitle); ?></h1>
                <nav aria-label="breadcrumb" class="d-none d-sm-block">
                    <ol class="breadcrumb mb-0 small">
                        <li class="breadcrumb-item"><a href="<?php echo e(route('wali.dashboard')); ?>">Home</a></li>
                        <li class="breadcrumb-item active text-secondary" aria-current="page"><?php echo $__env->yieldContent('page_title', $pageTitle); ?></li>
                    </ol>
                </nav>
            </div>
            
            <?php echo $__env->yieldContent('header_actions'); ?>
        </div>

        <?php if(session('error')): ?>
            <div class="alert alert-danger alert-dismissible fade show shadow-lg-custom" role="alert">
                <i class="fas fa-exclamation-triangle me-2"></i> Terjadi Kesalahan! <?php echo e(session('error')); ?>

                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <?php echo $__env->yieldContent('content'); ?>
    </main>

    <footer class="bg-white p-3 text-center small text-muted border-top shadow-lg-custom">
        <p class="mb-0">Dukungan Jakastra Official | Kebijakan Privasi</p>
        <p class="mb-0">&copy; <?php echo e(date('Y')); ?> SISFO Al-Falah Putak. Hak Cipta Dilindungi.</p>
    </footer>

    <?php echo $__env->yieldPushContent('js'); ?>

</body>
</html><?php /**PATH /home/axioo/Unduhan/_sisfo-laravel/resources/views/layouts/wali.blade.php ENDPATH**/ ?>