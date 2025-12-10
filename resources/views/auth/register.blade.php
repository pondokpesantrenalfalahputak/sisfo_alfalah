<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar - SIAP AL-FALAH</title>
    <meta name="description" content="Sistem Informasi Akademik Pesantren (SIAP) Al-Falah Putak: Akses data santri, pengumuman, tagihan, dan absensi harian secara real-time. Informasi terpusat untuk Wali Santri dan Staf." />
    <link rel="icon" type="image/png" href="{{ asset('kop pondok.png') }}" />
    
    {{-- ✅ Link Bootstrap CDN --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    {{-- ✅ Link Font Inter --}}
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    {{-- ✅ Link Font Awesome --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    
    {{-- CSS KUSTOM (Untuk Styling Layout) --}}
    <style>
        :root {
            /* Definisi warna kustom */
            --blue-primary: #2563EB;
            --blue-dark: #1D4ED8;
            --gray-text: #6B7280;
            --background-body: #F3F4F6;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--background-body);
        }
        .bg-login-image {
            /* Ganti path image sesuai lokasi */
            background-image: url('{{ asset('Images/1728115006026 copy.png') }}');
            background-size: cover;
            /* PERBAIKAN: Background position disetel ke tengah-bawah untuk menampilkan subjek utama */
            background-position: center 25%; 
            min-height: 280px;
        }
        @media (min-width: 568px) {
            .bg-login-image {
                min-height: auto;
                /* Background position disetel ke tengah untuk tampilan desktop */
                background-position: center;
            }
        }
        .card-register {
            border: none;
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }
        .hero-text-overlay {
            position: absolute;
            inset: 0;
            background-color: rgba(17, 24, 39, 0.5); 
        }
        .password-input-container {
            position: relative;
        }
        .toggle-password {
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            color: var(--gray-text);
            z-index: 10;
        }
        /* Style untuk tombol kustom */
        .btn-primary-custom {
            background-color: var(--blue-primary);
            border-color: var(--blue-primary);
            transition: background-color 0.2s;
        }
        .btn-primary-custom:hover {
            background-color: var(--blue-dark);
            border-color: var(--blue-dark);
        }

        /* ========================================================= */
        /* 🎨 PERBAIKAN FONT & SPACING MOBILE (Semua yang < 768px) */
        /* ========================================================= */

        /* Mengurangi Padding pada Form di Mobile (Agar Konten Lebih Banyak) */
        @media (max-width: 767.98px) {
            .col-md-6.bg-white {
                padding: 1.5rem !important; /* Dari 2rem/p-4 menjadi 1.5rem */
            }
            
            /* Judul utama "Buat Akun Wali Santri" */
            .col-md-6.bg-white .h4 {
                font-size: 1.25rem !important;
            }

            /* Subjudul Form ("Data Wali Santri", "Data Santri", dll) */
            .col-md-6.bg-white .fs-6 {
                font-size: 1rem !important;
            }

            /* Mengurangi ukuran input dan select agar lebih kompak */
            .form-control, 
            .form-select,
            .form-control[type="date"],
            .form-control[type="email"],
            .form-control[type="text"],
            .form-control[type="password"] {
                padding: 0.5rem 0.75rem !important; /* Padding input lebih kecil */
                height: auto;
                min-height: 40px; /* Tinggi minimum input lebih rendah */
                font-size: 0.95rem !important;
            }

            /* Mengurangi margin/jarak vertikal antar field */
            .mb-3 {
                margin-bottom: 0.8rem !important; /* Dari 1rem menjadi 0.8rem */
            }
            
            /* Mengurangi margin di bawah alert */
            .alert.alert-danger {
                margin-bottom: 1rem !important;
            }
            
            /* Mengurangi margin di bawah tombol Daftar */
            .w-100.btn-lg {
                margin-bottom: 1.5rem !important;
                padding: 0.6rem 1rem !important;
                font-size: 1rem !important;
            }
        }
    </style>
</head>
<body>
    <div class="d-flex align-items-center justify-content-center min-vh-100 p-3">
        <div class="card card-register w-100 mx-auto" style="max-width: 1200px;">
            <div class="row g-0">
                {{-- Kiri: Hero Section/Gambar --}}
                <div class="col-md-6 bg-login-image d-flex flex-column justify-content-end position-relative text-white p-4 p-md-5">
                    <div class="hero-text-overlay"></div>
                    <div class="position-relative z-1">
                        <span class="bg-warning text-black fw-bold badge px-3 py-1 rounded-pill mb-1">
                            SELAMAT DATANG
                        </span>
                        <h1 class="h3 fw-bold lh-sm mb-1">Sistem Informasi Akademik Pesantren</h1>
                        <p class="h5">AL-FALAH PUTAK</p>
                    </div>
                </div>

                {{-- Kanan: Form Register --}}
                <div class="col-md-6 bg-white p-4 p-md-5">
                    <div class="text-center mb-4">
                        <img src="{{ asset('Images/kop pondok.png') }}" alt="Logo pesantren" style="width: 80px; height: 80px;">
                    </div>

                    <h2 class="h4 fw-bold text-center text-gray-800">Buat Akun Wali Santri</h2>
                    <p class="text-center text-secondary mb-4 small">
                        Daftarkan akun Anda (Wali Santri) dan data Santri yang diasuh.
                    </p>

                    {{-- Menampilkan Error Validasi --}}
                    @if ($errors->any())
                        <div class="alert alert-danger py-2" role="alert">
                            <h4 class="alert-heading small fw-bold mb-1"><i class="fas fa-exclamation-triangle me-1"></i> Pendaftaran Gagal! Pastikan Semua Terisi</h4>
                            <ul class="mb-0 small ps-3">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    {{-- FORM REGISTER --}}
                    <form action="{{ route('register') }}" method="POST">
                        @csrf
                        
                        <h5 class="fs-6 fw-bold text-dark border-bottom pb-2 mb-3 mt-4">Data Wali Santri</h5>
                        
                        {{-- 1. Field: Nama Wali (name) --}}
                        <div class="mb-3">
                            <label for="name" class="form-label small fw-medium text-gray-700">Nama Lengkap Wali*</label>
                            <input type="text" id="name" name="name" placeholder="Nama lengkap Wali/Orang Tua"
                                class="form-control @error('name') is-invalid @enderror"
                                value="{{ old('name') }}" required autocomplete="name" autofocus>
                            @error('name')
                                <div class="invalid-feedback small">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- 2. Field: Email (email) --}}
                        <div class="mb-3">
                            <label for="email" class="form-label small fw-medium text-gray-700">Email*</label>
                            <input type="email" id="email" name="email" placeholder="Alamat email aktif (untuk login)"
                                class="form-control @error('email') is-invalid @enderror"
                                value="{{ old('email') }}" required autocomplete="email">
                            @error('email')
                                <div class="invalid-feedback small">{{ $message }}</div>
                            @enderror
                        </div>

                        <h5 class="fs-6 fw-bold text-dark border-bottom pb-2 mb-3 mt-4">Data Santri</h5>
                        
                        {{-- 3. Field: Nama Santri (nama_santri) --}}
                        <div class="mb-3">
                            <label for="nama_santri" class="form-label small fw-medium text-gray-700">Nama Lengkap Santri*</label>
                            <input type="text" id="nama_santri" name="nama_santri" placeholder="Nama lengkap calon santri"
                                class="form-control @error('nama_santri') is-invalid @enderror"
                                value="{{ old('nama_santri') }}" required>
                            @error('nama_santri')
                                <div class="invalid-feedback small">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="row">
                            {{-- 4. Field: Kelas Santri (kelas_id) --}}
                            <div class="col-md-6 mb-3">
                                <label for="kelas_id" class="form-label small fw-medium text-gray-700">Pilih Kelas*</label>
                                <select id="kelas_id" name="kelas_id" class="form-select @error('kelas_id') is-invalid @enderror" required>
                                    <option value="" disabled selected>Pilih Kelas...</option>
                                    {{-- Loop data kelas yang dikirim dari controller --}}
                                    @isset($kelas)
                                        @foreach ($kelas as $k)
                                            <option value="{{ $k->id }}" {{ old('kelas_id') == $k->id ? 'selected' : '' }}>
                                                {{ $k->nama_kelas }}
                                            </option>
                                        @endforeach
                                    @endisset
                                </select>
                                @error('kelas_id')
                                    <div class="invalid-feedback small">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- 5. Field: Tanggal Lahir Santri (tanggal_lahir_santri) --}}
                            <div class="col-md-6 mb-3">
                                <label for="tanggal_lahir_santri" class="form-label small fw-medium text-gray-700">Tgl. Lahir Santri*</label>
                                <input type="date" id="tanggal_lahir_santri" name="tanggal_lahir_santri"
                                    class="form-control @error('tanggal_lahir_santri') is-invalid @enderror"
                                    value="{{ old('tanggal_lahir_santri') }}" required>
                                @error('tanggal_lahir_santri')
                                    <div class="invalid-feedback small">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        {{-- 6. Field: Alamat Santri (alamat_santri) --}}
                        <div class="mb-3">
                            <label for="alamat_santri" class="form-label small fw-medium text-gray-700">Alamat Santri*</label>
                            <textarea id="alamat_santri" name="alamat_santri" placeholder="Alamat lengkap santri saat ini"
                                class="form-control @error('alamat_santri') is-invalid @enderror" rows="3"
                                required>{{ old('alamat_santri') }}</textarea>
                            @error('alamat_santri')
                                <div class="invalid-feedback small">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        {{-- 7. Field: NISN (nis) --}}
                        <div class="mb-3">
                            <label for="nis" class="form-label small fw-medium text-gray-700">NIS Santri*</label>
                            <input type="text" id="nis" name="nis" placeholder="Nomor Induk Siswa Nasional (jika ada)"
                                class="form-control @error('nis') is-invalid @enderror"
                                value="{{ old('nis') }}">
                            @error('nis')
                                <div class="invalid-feedback small">{{ $message }}</div>
                            @enderror
                        </div>

                        <h5 class="fs-6 fw-bold text-dark border-bottom pb-2 mb-3 mt-4">Buat Password Akun</h5>

                        {{-- 8. Field: Password (password) --}}
                        <div class="mb-3">
                            <label for="password" class="form-label small fw-medium text-gray-700">Password*</label>
                            <div class="password-input-container">
                                <input type="password" id="password" name="password" placeholder="Buat password Anda"
                                    class="form-control @error('password') is-invalid @enderror"
                                    required autocomplete="new-password">
                                <span class="toggle-password" data-target="password">
                                    <i class="fas fa-eye"></i>
                                </span>
                            </div>
                            @error('password')
                                <div class="invalid-feedback small d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- 9. Field: Konfirmasi Password (password_confirmation) --}}
                        <div class="mb-4">
                            <label for="password_confirmation" class="form-label small fw-medium text-gray-700">Konfirmasi Password*</label>
                            <div class="password-input-container">
                                <input type="password" id="password_confirmation" name="password_confirmation" placeholder="Ulangi password Anda"
                                    class="form-control" required autocomplete="one-time-code">
                                <span class="toggle-password" data-target="password_confirmation">
                                    <i class="fas fa-eye"></i>
                                </span>
                            </div>
                        </div>

                        <button type="submit" class="w-100 btn btn-lg btn-primary-custom fw-bold">
                            <i class="fas fa-user-plus me-2"></i> Daftarkan Akun Wali
                        </button>
                    </form>

                    <div class="mt-4 text-center">
                        <p class="small text-secondary">
                            Sudah punya akun?
                            <a href="{{ route('login') }}" class="fw-medium text-decoration-none" style="color: var(--blue-primary);">Masuk</a>
                        </p>
                    </div>

                    <div class="mt-4 text-center">
                        <p class="small text-muted">Powered by <span class="fw-bold" style="color: #1E40AF;">SANTRI_LOCAL</span></p>
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
            const toggleButtons = document.querySelectorAll('.toggle-password');

            toggleButtons.forEach(button => {
                button.addEventListener('click', () => {
                    const targetId = button.getAttribute('data-target');
                    const targetInput = document.getElementById(targetId);
                    const icon = button.querySelector('i');

                    // Toggle tipe input
                    const isPassword = targetInput.getAttribute('type') === 'password';
                    const newType = isPassword ? 'text' : 'password';
                    targetInput.setAttribute('type', newType);

                    // Toggle ikon mata
                    if (isPassword) {
                        // Jika berubah dari 'password' ke 'text' (terbuka)
                        icon.classList.remove('fa-eye');
                        icon.classList.add('fa-eye-slash');
                    } else {
                        // Jika berubah dari 'text' ke 'password' (tertutup)
                        icon.classList.remove('fa-eye-slash');
                        icon.classList.add('fa-eye');
                    }
                });
            });
        });
    </script>
</body>
</html>