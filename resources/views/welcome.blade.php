<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIAP AL-FALAH PUTAK</title>

    <meta name="google-site-verification" content="YZijbyw0-7ALwnUh_RzgJxEJRToGG2qpLcvh6P5Oqls" />

    {{-- ✅ Link Bootstrap CDN --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    {{-- ✅ Link Font Inter --}}
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    {{-- ✅ Link Font Awesome --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">


    {{-- ✅ CSS INLINE (KUSTOM) --}}
    <style>
        :root {
            /* Warna Teal disesuaikan agar kontras pada latar belakang terang */
            --teal-primary: #047857; /* Dibuat lebih gelap dari 14B8A6 */
            --teal-dark: #065F46; 
            --gray-bg: #F9FAFB;
            --blue-primary: #0b2f56;
        }
        
        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--gray-bg);
            color: #4B5563;
        }

        /* === 1. NAVBAR STYLING & STICKY FIX === */
        .navbar-custom {
            position: fixed; 
            top: 0;
            width: 100%;
            z-index: 1050; 
            transition: all 0.3s;
        }
        .navbar-custom.scrolled {
            background-color: #fff !important;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }
        
        /* Padding untuk menghindari konten tertutup navbar fixed-top */
        .main-content {
            padding-top: 65px; 
        }

        /* ⬇️ PERBAIKAN: MENGECILKAN UKURAN NAVBAR (LINK) */
        .navbar-nav .nav-link {
            padding-top: 0.5rem;    
            padding-bottom: 0.5rem;
            font-size: 0.95rem; /* Sedikit dikecilkan */
        }
        /* ⬆️ AKHIR PERBAIKAN */

        /* Style untuk Tombol Login/Register di mobile */
        .mobile-buttons {
            padding-top: 1rem;
            border-top: 1px solid rgba(0, 0, 0, 0.1);
            margin-top: 0.5rem;
        }
        @media (max-width: 991.98px) {
            .navbar-custom {
                background-color: #fff !important; 
            }
            .navbar-custom .navbar-collapse {
                padding: 1rem 0.5rem; 
                background-color: #fff;
                border-radius: 0 0 8px 8px;
            }
        }
        
        /* === 2. HERO SECTION STYLING (DIREVISI UNTUK KONTRAST) === */
        .hero-section {
            background-size: cover;
            background-position: center;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            position: relative;
            /* MOBILE/DEFAULT: 50% dari tinggi layar */
            min-height: 50vh; 
            padding-top: 6rem; 
            padding-bottom: 6rem; 
        }
        
        /* DESKTOP: Perluas tinggi Hero Section di layar besar (lebar >= 992px) */
        @media (min-width: 992px) { 
            .hero-section {
                min-height: 85vh; /* Tinggi 65% untuk Desktop */
                padding-top: 8rem;
                padding-bottom: 8rem;
            }
        }
        
        .hero-overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: rgba(0, 0, 0, 0.65); 
        }
        .hero-content {
            position: relative;
            z-index: 10;
        }
        /* Penyesuaian font agar tidak terlalu besar di mobile */
        .hero-title {
            font-size: 1.8rem; 
        }
        .hero-subtitle { /* Dibuat lebih besar dan tebal */
            font-size: 1.3rem; 
            text-shadow: 0 0 5px rgba(0, 0, 0, 0.6); /* Efek bayangan ringan agar menonjol */
        }
        .hero-body-text { /* NEW STYLE: Untuk Paragraf Muqaddimah */
            font-size: 1rem;
            text-shadow: 0 0 5px rgba(0, 0, 0, 0.4);
            line-height: 1.6; /* Tambah jarak baris */
        }
        @media (min-width: 768px) {
            .hero-title {
                font-size: 2.5rem; 
            }
            .hero-subtitle {
                font-size: 1.8rem;
            }
        }
        /* === 3. UTILITY STYLING === */
        .btn-teal {
            background-color: var(--teal-primary);
            color: white;
            border-color: var(--teal-primary);
            transition: background-color 0.2s, transform 0.2s;
        }
        .btn-teal:hover {
            background-color: var(--teal-dark);
            color: white;
            border-color: var(--teal-dark);
            transform: translateY(-2px);
        }
        .card-shadow {
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
        }
        .footer-custom {
            background-color: #374151; /* Gray 700 */
        }
    </style>
</head>
<body>

    {{-- HEADER/NAVBAR --}}
    <header class="navbar-custom bg-transparent" id="navbarHeader">
        {{-- ⬇️ PERBAIKAN: py-3 diganti py-2 untuk mengecilkan tinggi navbar --}}
        <nav class="navbar navbar-expand-lg container px-4 py-2"> 
            <div class="container-fluid px-0">
                
                {{-- Logo and Title --}}
                <a class="navbar-brand d-flex align-items-center" href="#">
                    <img src="{{ asset('Images/kop pondok.png') }}"
                            alt="Logo Pondok Pesantren Al-Falah Putak"
                            class="rounded-circle me-2" style="height: 35px; width: 35px; object-fit: cover;">
                    
                    {{-- Judul responsif: Al-Falah Putak di mobile, PONDOK PESANTREN AL-FALAH di desktop --}}
                    <h1 class="fs-6 fw-bold mb-0 text-dark d-block d-md-none" style="color: var(--blue-primary);">AL-FALAH PUTAK</h1> 
                    <h1 class="fs-5 fw-bold mb-0 text-dark d-none d-md-block" style="color: var(--blue-primary);">PONDOK PESANTREN AL-FALAH</h1>
                </a>

                {{-- Mobile Toggler --}}
                <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                {{-- Navigation Links (Collapsed Content) --}}
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav mx-auto mb-2 mb-lg-0 pt-3 pt-lg-0">
                        <li class="nav-item">
                            <a class="nav-link" href="#tentang-kami">Tentang Kami</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#profil">Keunggulan</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#biaya-pendaftaran">Biaya</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#galeri">Galeri</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#kontak">Kontak</a>
                        </li>
                    </ul>
                    
                    {{-- Login/Register Buttons (Desktop) --}}
                    <div class="d-none d-lg-flex align-items-center">
                        <a href="{{ route('login') }}" class="btn btn-outline-secondary me-2">Login</a>
                        <a href="{{ route('register') }}" class="btn btn-teal">Registrasi</a>
                    </div>

                    {{-- Login/Register Buttons (Mobile) --}}
                    <div class="d-lg-none mobile-buttons">
                        <a href="{{ route('login') }}" class="btn btn-outline-secondary w-100 mb-2">Login</a>
                        <a href="{{ route('register') }}" class="btn btn-teal w-100">Registrasi</a>
                    </div>
                </div>
            </div>
        </nav>
    </header>

    <main class="main-content">
        {{-- HERO SECTION --}}
        <section class="hero-section text-white" style="background-image: url('{{ asset('Images/Gambar WhatsApp 2025-08-08 pukul 19.51.39_1513872e.jpg') }}');">
            <div class="hero-overlay"></div>
            <div class="hero-content container py-5">
                {{-- ⬇️ KONTEN DENGAN PERBAIKAN KONTRAST --}}
                <h2 class="hero-title fw-bolder mb-3 lh-sm">
                    SELAMAT DATANG DI<br>PONDOK PESANTREN MODERN AL-FALAH PUTAK
                </h2>
                <p class="hero-subtitle fw-bold mb-4 text-light">
                    Mencetak Generasi Terbaik yang Qur'ani, Cerdas, Mandiri, dan Berakhlak Mulia
                </p>
                <div class="row justify-content-center">
                    <div class="col-lg-8">
                        {{-- Menggunakan text-white dan class hero-body-text untuk kontras maksimal --}}
                        <p class="mb-5 text-white fw-medium hero-body-text">
                            Assalamu'alaikum Warahmatullahi Wabarakatuh. Kami adalah lembaga pendidikan Islam yang teguh memegang komitmen menciptakan keseimbangan sempurna: mendalam dalam Ilmu Agama (Tahfidz & Diniyah), unggul dalam Pengetahuan Umum, dan adaptif terhadap Teknologi terkini.
                        </p>
                    </div>
                </div>
                {{-- ⬆️ AKHIR PERBAIKAN KONTRAST --}}
                
                {{-- Tombol Dibuat Stacked di Mobile --}}
                <div class="d-grid gap-3 col-10 col-sm-8 col-md-6 mx-auto d-md-flex justify-content-center">
                    <a href="#profil" class="btn btn-light btn-lg btn-explore fw-bold px-4">
                        Jelajahi Profil Kami
                    </a>
                    <a href="https://wa.me/6285773172782?text=Assalamu'alaikum%20Warahmatullahi%20Wabarakatuh.%0ASaya%20ingin%20bertanya%20mengenai%20pendaftaran%20santri%20baru%20di%20Pondok%20Pesantren%20Al-Falah%20Putak."
                        target="_blank"
                        class="btn btn-teal btn-lg fw-bold px-4">
                        Informasi Pendaftaran
                    </a>
                </div>
            </div>
        </section>

        {{-- TENTANG KAMI SECTION --}}
        <section id="tentang-kami" class="py-5 py-md-5 bg-white">
            <div class="container px-4">
                <div class="text-center mb-5">
                    <h2 class="fs-2 fw-bold text-dark">Tentang Kami</h2>
                    <p class="text-muted mt-2">Mengenal lebih dalam Pondok Pesantren Al-Falah Putak.</p>
                </div>
                
                <div class="row justify-content-center">
                    <div class="col-lg-10">
                        <div class="row g-4 g-lg-5"> 
                            <div class="col-lg-6">
                                {{-- Muqaddimah --}}
                                <div class="mb-4">
                                    <h3 class="fs-4 fw-bold text-dark mb-3">Muqaddimah</h3>
                                    <p class="text-secondary-emphasis small">
                                        Pondok Pesantren Salafiyah dan Tahfidz Al-qur'an Al-Falah Putak adalah yayasan pendidikan Islam yang berkonsentrasi dalam memadukan kurikulum pendidikan nasional (FORMAL), pendidikan diniyah (MADIN), dan kursus komputer sebagai solusi yang tepat untuk mengarahkan pendidikan anak akhir kita.
                                    </p>
                                </div>
                                {{-- Visi & Misi --}}
                                <div class="card card-shadow border-0 bg-light p-4 mb-4">
                                    <h4 class="fs-5 fw-bold text-dark mb-3">Visi & Misi</h4>
                                    <p class="fw-semibold text-dark mb-1 small">Visi Pondok Pesantren</p>
                                    <p class="text-secondary-emphasis small">Berprestasi dalam iptek dan bertakwa serta berwawasan lingkungan.</p>
                                    <p class="fw-semibold text-dark mt-3 mb-1 small">Misi Pondok Pesantren</p>
                                    <ul class="list-unstyled text-secondary-emphasis ps-3 small">
                                        <li><i class="fas fa-check-circle text-teal-primary me-2"></i> Melaksanakan pengembangan dan bimbingan secara efektif dan efisien.</li>
                                        <li><i class="fas fa-check-circle text-teal-primary me-2"></i> Menumbuhkan semangat untuk belajar menghayati dan mengamalkan ajaran agama Islam.</li>
                                        <li><i class="fas fa-check-circle text-teal-primary me-2"></i> Bekerjasama dengan masyarakat untuk mencapai tujuan pendidikan.</li>
                                    </ul>
                                </div>
                                {{-- Profil Singkat --}}
                                <div>
                                    <h3 class="fs-4 fw-bold text-dark mb-3">Profil Singkat</h3>
                                    <dl class="row text-secondary-emphasis small">
                                        <dt class="col-5 fw-semibold">Nama Yayasan</dt>
                                        <dd class="col-7">Yayasan Pondok Pesantren Al-Falah</dd>
                                        <dt class="col-5 fw-semibold">Tanggal Berdiri</dt>
                                        <dd class="col-7">29 September 2006</dd>
                                        <dt class="col-5 fw-semibold">Pimpinan</dt>
                                        <dd class="col-7">KH. MURSYIDI</dd>
                                        <dt class="col-5 fw-semibold">Nomor Statistik</dt>
                                        <dd class="col-7">502016030011</dd>
                                    </dl>
                                </div>
                            </div>
                            
                            <div class="col-lg-6">
                                {{-- Unit Pendidikan --}}
                                <div class="card card-shadow border-0 bg-light p-4 mb-4">
                                    <h3 class="fs-4 fw-bold text-dark mb-3">Unit Pendidikan</h3>
                                    <div class="row small">
                                        <div class="col-6">
                                            <h4 class="fs-5 fw-semibold text-dark mb-2">Non Formal</h4>
                                            <ul class="list-unstyled text-secondary-emphasis ps-3">
                                                <li><i class="fas fa-book-open text-primary me-2 small"></i> Madrasah Diniyah Ula</li>
                                                <li><i class="fas fa-book-open text-primary me-2 small"></i> Madrasah Diniyah Wustho</li>
                                                <li><i class="fas fa-book-open text-primary me-2 small"></i> Madrasah Diniyah Ulya</li>
                                                <li><i class="fas fa-book-open text-primary me-2 small"></i> Tahfidzul Qur'an</li>
                                            </ul>
                                        </div>
                                        <div class="col-6">
                                            <h4 class="fs-5 fw-semibold text-dark mb-2">Formal</h4>
                                            <ul class="list-unstyled text-secondary-emphasis ps-3">
                                                <li><i class="fas fa-graduation-cap text-primary me-2 small"></i> Madrasah Ibtidaiyah (MI)</li>
                                                <li><i class="fas fa-graduation-cap text-primary me-2 small"></i> Madrasah Tsanawiyah (MTS)</li>
                                                <li><i class="fas fa-graduation-cap text-primary me-2 small"></i> Madrasah Aliyah (MA)</li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                
                                {{-- Ekstrakurikuler --}}
                                <div class="card card-shadow border-0 bg-light p-4">
                                    <h3 class="fs-4 fw-bold text-dark mb-3">Ekstrakurikuler</h3>
                                    <div class="row small text-secondary-emphasis">
                                        <div class="col-sm-6"><p class="mb-1"><i class="fas fa-feather-alt text-teal-primary me-2 small"></i> Seni Sholawat, Hadroh</p></div>
                                        <div class="col-sm-6"><p class="mb-1"><i class="fas fa-desktop text-teal-primary me-2 small"></i> Kursus Komputer</p></div>
                                        <div class="col-sm-6"><p class="mb-1"><i class="fas fa-microphone-alt text-teal-primary me-2 small"></i> Khithobah (Pidato)</p></div>
                                        <div class="col-sm-6"><p class="mb-1"><i class="fas fa-book-reader text-teal-primary me-2 small"></i> Kursus Nahwu Shorof</p></div>
                                        <div class="col-sm-6"><p class="mb-1"><i class="fas fa-quran text-teal-primary me-2 small"></i> Tilawatil Qur'an</p></div>
                                        <div class="col-sm-6"><p class="mb-1"><i class="fas fa-globe text-teal-primary me-2 small"></i> Kursus Bahasa Inggris</p></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        
        {{-- BIAYA & SYARAT SECTION --}}
        <section id="biaya-pendaftaran" class="py-5 py-md-5 bg-light">
            <div class="container px-4">
                <div class="text-center mb-5">
                    <h2 class="fs-2 fw-bold text-dark">Biaya & Syarat Pendaftaran</h2>
                    <p class="text-muted mt-2">Rincian biaya dan persyaratan untuk calon santri baru.</p>
                </div>
                
                {{-- Tabel Biaya (Menggunakan table-responsive agar mudah di-scroll di mobile) --}}
                <div class="table-responsive card-shadow rounded-3">
                    <table class="table table-hover align-middle mb-0 bg-white small text-nowrap">
                        <thead class="bg-teal-primary text-white">
                            <tr>
                                <th class="p-3">Jenis Biaya</th>
                                <th class="p-3 text-center">Khusus Pondok</th>
                                <th class="p-3 text-center">MI & Pondok</th>
                                <th class="p-3 text-center">MTs & Pondok</th>
                                <th class="p-3 text-center">MA & Pondok</th>
                            </tr>
                        </thead>
                        <tbody class="text-secondary-emphasis">
                            {{-- Data Biaya Dikembalikan ke Asli --}}
                            <tr><td class="p-3">Pendaftaran</td><td class="text-center">Rp 50.000</td><td class="text-center">Rp 50.000</td><td class="text-center">Rp 50.000</td><td class="text-center">Rp 50.000</td></tr>
                            <tr><td class="p-3">Infaq Bangunan</td><td class="text-center">Rp 800.000</td><td class="text-center">Rp 250.000</td><td class="text-center">Rp 800.000</td><td class="text-center">Rp 800.000</td></tr>
                            <tr><td class="p-3">Peraga Qiroati</td><td class="text-center">Rp 100.000</td><td class="text-center">-</td><td class="text-center">Rp 100.000</td><td class="text-center">Rp 100.000</td></tr>
                            <tr><td class="p-3">Kost Makan Perbulan</td><td class="text-center">Rp 400.000</td><td class="text-center">Rp 400.000</td><td class="text-center">Rp 400.000</td><td class="text-center">Rp 400.000</td></tr>
                            <tr><td class="p-3">Syahriyah Perbulan</td><td class="text-center">Rp 100.000</td><td class="text-center">Rp 100.000</td><td class="text-center">Rp 100.000</td><td class="text-center">Rp 100.000</td></tr>
                            <tr><td class="p-3">Lemari</td><td class="text-center">Rp 625.000</td><td class="text-center">Rp 625.000</td><td class="text-center">Rp 625.000</td><td class="text-center">Rp 625.000</td></tr>
                            <tr class="table-warning">
                                <td class="p-3 fw-bold">TOTAL BIAYA</td>
                                <td class="p-3 text-center fw-bold">Rp 2.075.000</td> 
                                <td class="p-3 text-center fw-bold">Rp 1.525.000</td> 
                                <td class="p-3 text-center fw-bold">Rp 2.075.000</td> 
                                <td class="p-3 text-center fw-bold">Rp 2.075.000</td> 
                            </tr>
                        </tbody>
                    </table>
                </div>

                {{-- Catatan (Dibuat dalam card untuk highlight) --}}
                <div class="mt-4 px-3">
                    <div class="card p-3 bg-white border-warning border-3 border-start shadow-sm">
                        <h3 class="fs-6 fw-bold text-dark mb-2"><i class="fas fa-exclamation-circle text-warning me-2"></i>Catatan Penting</h3>
                        <ul class="text-secondary-emphasis small list-unstyled ps-3 mb-0">
                            <li><i class="fas fa-info-circle text-teal-primary me-2"></i> Biaya kos makan dan syahriyah khusus bagi santri yang menetap (mukim) di pondok.</li>
                            <li><i class="fas fa-info-circle text-teal-primary me-2"></i> Bagi siswa yang berdomisili diluar desa Putak, diwajibkan mukim/menetap di pondok kecuali yang masih MI.</li>
                        </ul>
                    </div>
                </div>
            </div>
        </section>
        
        {{-- GALERI --}}
        <section id="galeri" class="py-5 py-md-5 bg-white">
            <div class="container px-4">
                <div class="text-center mb-5">
                    <h2 class="fs-2 fw-bold text-dark">Galeri Kegiatan</h2>
                    <p class="text-muted mt-2">Momen-momen berharga di pesantren kami.</p>
                </div>
                {{-- Grid gambar yang responsif --}}
                <div class="row g-3">
                    <div class="col-6 col-md-3">
                        <img class="img-fluid rounded shadow-sm object-fit-cover w-100" src="{{ asset('Images/WhatsApp Image 2025-06-11 at 23.53.25.jpeg') }}" alt="Galeri foto 1" loading="lazy" style="aspect-ratio: 1/1;">
                    </div>
                    <div class="col-6 col-md-3">
                        <img class="img-fluid rounded shadow-sm object-fit-cover w-100" src="{{ asset('Images/IMG-20250806-WA0019.jpg') }}" alt="Galeri foto 2" loading="lazy" style="aspect-ratio: 1/1;">
                    </div>
                    <div class="col-6 col-md-3">
                        <img class="img-fluid rounded shadow-sm object-fit-cover w-100" src="{{ asset('Images/WhatsApp Image 2024-10-02 at 09.00.59.jpeg') }}" alt="Galeri foto 3" loading="lazy" style="aspect-ratio: 1/1;">
                    </div>
                    <div class="col-6 col-md-3">
                        <img class="img-fluid rounded shadow-sm object-fit-cover w-100" src="{{ asset('Images/IMG_2785.JPG') }}" alt="Galeri foto 4" loading="lazy" style="aspect-ratio: 1/1;">
                    </div>
                </div>
            </div>
        </section>

        {{-- TESTIMONI --}}
        <section class="py-5 py-md-5 bg-light">
            <div class="container px-4">
                <div class="text-center mb-5">
                    <h2 class="fs-2 fw-bold text-dark">Testimoni Santri</h2>
                    <p class="text-muted mt-2">Apa kata mereka tentang Pondok Pesantren Al-Falah Putak?</p>
                </div>
                {{-- Layout testimoni yang responsif --}}
                <div class="row g-4 justify-content-center">
                    <div class="col-lg-4 col-md-6">
                        <div class="card p-4 card-shadow border-start border-4 border-teal-primary h-100">
                            <i class="fas fa-quote-left fs-4 text-teal-primary mb-3"></i>
                            <p class="text-secondary-emphasis mb-3 fst-italic small">"Pondok Pesantren Al-Falah Putak telah mengubah hidup saya. Saya belajar banyak tentang agama dan teknologi di sini."</p>
                            <div class="mt-auto">
                                <p class="fw-bold mb-0 text-dark small">MUHAMMAD MAJID</p>
                                <span class="text-muted small">Santri Kelas Mahasiswa</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6">
                        <div class="card p-4 card-shadow border-start border-4 border-teal-primary h-100">
                            <i class="fas fa-quote-left fs-4 text-teal-primary mb-3"></i>
                            <p class="text-secondary-emphasis mb-3 fst-italic small">"Lingkungan yang kondusif dan guru-guru yang peduli membuat saya betah belajar di sini."</p>
                            <div class="mt-auto">
                                <p class="fw-bold mb-0 text-dark small">DANIL ALI SABILA</p>
                                <span class="text-muted small">Santri Kelas XI</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    {{-- FOOTER --}}
    <footer id="kontak" class="footer-custom text-white">
        <div class="container px-4 py-5 py-md-5">
            <div class="row g-4">
                <div class="col-md-6 col-lg-4">
                    <h5 class="fw-bold mb-3">Pondok Pesantren AL-FALAH</h5>
                    <p class="text-white-50 small">Lembaga pendidikan Islam yang berdedikasi untuk mencetak generasi rabbani yang cerdas, mandiri, dan berakhlak mulia.</p>
                </div>
                <div class="col-md-6 col-lg-4">
                    <h5 class="fw-bold mb-3">Tautan Cepat</h5>
                    <ul class="list-unstyled small">
                        <li><a href="#tentang-kami" class="text-white-50 text-decoration-none">Tentang Kami</a></li>
                        <li><a href="#biaya-pendaftaran" class="text-white-50 text-decoration-none">Pendaftaran</a></li>
                        <li><a href="{{ route('login') }}" class="text-white-50 text-decoration-none">Login Panel</a></li>
                    </ul>
                </div>
                <div class="col-md-6 col-lg-4">
                    <h5 class="fw-bold mb-3">Hubungi Kami</h5>
                    <ul class="list-unstyled small">
                        <li class="d-flex mb-2"><i class="fas fa-map-marker-alt fa-fw me-2 mt-1"></i> <span class="text-white-50">Dusun II Ds. Putak Kec.Gelumbang Kab.Muara Enim Sumatera Selatan 31171</span></li>
                        <li class="mb-2"><i class="fas fa-phone-alt fa-fw me-2"></i> <span class="text-white-50">+62 857-7317-2782</span></li>
                        <li class="mb-2"><i class="fas fa-envelope fa-fw me-2"></i> <span class="text-white-50">alfalahputak@gmail.com</span></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="bg-dark py-3">
            <div class="container text-center small text-white-50">
                &copy; {{ date('Y') }} Al-Falah Putak. Hak Cipta Dilindungi.
            </div>
        </div>
    </footer>


    {{-- ✅ Bootstrap JS CDN --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

    {{-- Script kustom (untuk efek navbar scroll dan menutup menu mobile) --}}
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const navbarHeader = document.getElementById('navbarHeader');

            // Fungsi untuk mengaktifkan/menonaktifkan class 'scrolled' pada navbar
            const handleScroll = () => {
                if (window.scrollY > 50) {
                    navbarHeader.classList.add('scrolled');
                } else {
                    navbarHeader.classList.remove('scrolled');
                }
            };

            handleScroll();
            window.addEventListener('scroll', handleScroll);

            // Menutup menu mobile setelah link diklik (UX improvement)
            const navbarCollapse = document.getElementById('navbarNav');
            const navLinks = navbarCollapse.querySelectorAll('.nav-link');
            
            navLinks.forEach(link => {
                link.addEventListener('click', () => {
                    if (window.innerWidth < 992) { 
                        const bsCollapse = bootstrap.Collapse.getInstance(navbarCollapse) || new bootstrap.Collapse(navbarCollapse, { toggle: false });
                        bsCollapse.hide();
                    }
                });
            });
        });
    </script>
</body>
</html>