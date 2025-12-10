<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk - SIAP AL-FALAH</title>
    <meta name="description" content="Sistem Informasi Akademik Pesantren (SIAP) Al-Falah Putak: Akses data santri, pengumuman, tagihan, dan absensi harian secara real-time. Informasi terpusat untuk Wali Santri dan Staf." />
    <link rel="icon" type="image/png" href="{{ asset('kop pondok.png') }}" />
    
    {{-- ✅ Link Bootstrap CDN --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    {{-- ✅ Link Font Inter --}}
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    {{-- ✅ Link Font Awesome --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    
    {{-- CSS KUSTOM (Responsif & Perbaikan Font Mobile) --}}
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #F3F4F6;
        }
        .bg-login-image {
            background-image: url('{{ asset('Images/1728115006026 copy.png') }}');
            background-size: cover;
            background-position: center 30%;
            /* TINGGI KHUSUS UNTUK MOBILE */
            min-height: 300px;
            height: 200px; 
        }
        @media (min-width: 768px) {
            .bg-login-image {
                /* Kembali ke tinggi besar untuk desktop */
                min-height: 550px; 
                height: auto; 
            }
        }

        .card-login {
            border: none;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25); 
        }
        .hero-text-overlay {
            position: absolute;
            inset: 0;
            background-color: rgba(17, 24, 39, 0.5); 
        }
        .btn-primary-custom {
            background-color: #2563EB;
            border-color: #2563EB;
            transition: background-color 0.2s;
        }
        .btn-primary-custom:hover {
            background-color: #1D4ED8;
            border-color: #1D4ED8;
        }
        /* Penyesuaian agar toggle password tetap di atas input-group-text */
        .password-input-container {
            position: relative;
        }
        .toggle-password {
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            color: #6B7280;
            z-index: 10;
            border: none;
            background: none;
            padding: 0;
        }
        
        /* PADDING FORM RESPONSIF */
        .p-form {
            padding: 2rem !important; 
        }
        @media (min-width: 768px) {
            .p-form {
                padding: 4.5rem !important; 
            }
        }
        @media (min-width: 992px) {
            .p-form {
                padding: 5rem !important; 
            }
        }
        .form-label.small {
            font-size: 0.9rem; 
            font-weight: 600 !important; 
        }

        /* Memastikan invalid-feedback muncul dengan gaya merah saat di luar input-group */
        .invalid-feedback.d-block {
            display: block !important;
        }

        /* ========================================================= */
        /* 🎨 PERBAIKAN FONT MOBILE (Semua yang < 768px) */
        /* ========================================================= */
        .card-login .h2.fw-bolder {
            /* Judul utama "MASUK AKUN WALISANTRI" */
            font-size: 1.5rem !important; 
        }

        .card-login .p-form p.small {
            /* Teks di bawah judul */
            font-size: 0.8rem !important;
        }

        .card-login .form-control-lg {
            /* Input Form (Email/NIS dan Password) */
            padding: 0.5rem 1rem !important; 
            height: auto;
            min-height: 44px;
            font-size: 1rem !important; 
        }
        
        .card-login .btn-lg {
            /* Tombol MASUK */
            padding: 0.6rem 1rem !important; 
            font-size: 1rem !important; 
        }

        /* Penyesuaian Hero Text di Mobile (agar tidak terlalu menonjol) */
        .hero-text-overlay + .position-relative h1.h3 {
            font-size: 1.25rem !important; 
        }
        .hero-text-overlay + .position-relative p.h5 {
            font-size: 1rem !important; 
        }

        /* Mengurangi jarak vertikal pada mobile */
        @media (max-width: 767.98px) {
            .mb-md-5 {
                /* Mengganti margin-bottom 3rem dengan 1.5rem */
                margin-bottom: 1.5rem !important; 
            }
        }

    </style>
</head>
<body>
    <div class="d-flex align-items-center justify-content-center min-vh-100 p-3">
        <div class="card card-login w-100 mx-auto" style="max-width: 1200px;"> 
            <div class="row g-0">

                {{-- Kiri: Hero Section/Gambar (col-12 di Mobile, col-md-6 di Desktop) --}}
                <div class="col-12 col-md-6 bg-login-image d-flex flex-column justify-content-end position-relative text-white p-4 p-md-5">
                    <div class="hero-text-overlay"></div>
                    <div class="position-relative z-1">
                        <span class="bg-warning text-black fw-bold badge px-3 py-1 rounded-pill mb-1">
                            SELAMAT DATANG
                        </span>

                        <h1 class="h3 fw-bold lh-sm mb-1">Sistem Informasi Akademik</h1>
                        <p class="h5">PONPES AL-FALAH PUTAK</p>
                        <p class="small">kec.Gelumbang kab.Muara Enim</p>
                    </div>
                </div>

                {{-- Kanan: Form Login (col-12 di Mobile, col-md-6 di Desktop) --}}
                <div class="col-12 col-md-6 bg-white p-form"> 
                    
                    <div class="text-center mb-4 mb-md-5"> 
                        <img src="{{ asset('Images/kop pondok.png') }}" alt="Logo Pesantren" style="width: 80px; height: 80px;">
                    </div>
                    
                    <h2 class="h3 fw-bolder text-gray-800 text-center mb-4 mb-md-5">MASUK AKUN WALISANTRI</h2> 
                    
                    <p class="text-center text-secondary mt-2 mb-4 mb-md-5 small"> 
                        Gunakan Email atau NIS Santri dan Password Anda untuk masuk ke sistem.
                    </p>

                    {{-- Form Login NIS/NISN --}}
                    <form action="{{ route('login') }}" method="POST">
                        @csrf
                        
                        {{-- 1. Field: Email / NIS / NISN --}}
                        <div class="mb-4 mb-md-5"> 
                            <label for="login_id" class="form-label small fw-medium text-gray-700">Email / NIS</label>
                            
                            {{-- Tambahan: Input Group untuk Icon --}}
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-user-circle"></i></span>
                                <input 
                                    type="text" 
                                    id="login_id" 
                                    name="login_id" 
                                    placeholder="Masukkan Email, NIS, atau NISN" 
                                    class="form-control form-control-lg @error('login_id') is-invalid @enderror" 
                                    required 
                                    autocomplete="username"
                                    value="{{ old('login_id') }}"
                                >
                            </div>

                            @error('login_id')
                                <div class="invalid-feedback small d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- 2. Field: Password --}}
                        <div class="mb-4 mb-md-5">
                            <label for="password" class="form-label small fw-medium text-gray-700">Password</label>
                            
                            {{-- Tambahan: Input Group untuk Icon dan Container Password --}}
                            <div class="password-input-container input-group">
                                <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                <input type="password" id="password" name="password" placeholder="Masukkan password" 
                                    class="form-control form-control-lg @error('password') is-invalid @enderror" 
                                    required autocomplete="current-password">
                                <button type="button" id="togglePasswordBtn" class="toggle-password">
                                    <i class="fas fa-eye" id="eye-icon"></i>
                                </button>
                            </div>

                            @error('password')
                                <div class="invalid-feedback small">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex align-items-center justify-content-between mb-4 mb-md-5">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="remember" id="remember-me">
                                <label class="form-check-label small text-gray-900" for="remember-me">
                                    Ingatkan saya
                                </label>
                            </div>
                            
                            {{-- Pesan Pengganti Lupa Password --}}
                            <div class="text-end">
                                <p class="small text-danger fw-bold mb-0">
                                    Lupa Password? Lapor ke Teknisi!
                                </p>
                            </div>
                        </div>

                        <button type="submit" class="w-100 btn btn-lg btn-primary-custom fw-bold mb-4 mb-md-5">
                            <i class="fas fa-sign-in-alt me-2"></i> MASUK KE SISTEM
                        </button>
                    </form>

                    {{-- Footer: Jarak atas mt-4 di mobile, mt-5 di desktop --}}
                    <div class="mt-4 mt-md-5 pt-3 text-center border-top"> 
                        <p class="small text-secondary">
                            Belum punya akun?
                            <a href="{{ route('register') }}" class="fw-medium text-decoration-none" style="color: #2563EB;">Daftar</a>
                        </p>
                    </div>

                    <div class="mt-2 text-center">
                        <p class="small text-muted">Powered by <span class="fw-bold" style="color: #1E40AF;">SANTRILOCAL</span></p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- ✅ Bootstrap JS CDN --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    
    {{-- Custom JavaScript untuk Toggle Password --}}
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const toggleButton = document.getElementById('togglePasswordBtn');
            const passwordInput = document.getElementById('password');
            const eyeIcon = document.getElementById('eye-icon');

            if (toggleButton && passwordInput && eyeIcon) {
                toggleButton.addEventListener('click', () => {
                    // Toggle tipe input
                    const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                    passwordInput.setAttribute('type', type);

                    // Toggle ikon mata
                    if (type === 'password') {
                        eyeIcon.classList.remove('fa-eye-slash');
                        eyeIcon.classList.add('fa-eye');
                    } else {
                        eyeIcon.classList.remove('fa-eye');
                        eyeIcon.classList.add('fa-eye-slash');
                    }
                });
            }
        });
    </script>
</body>
</html>