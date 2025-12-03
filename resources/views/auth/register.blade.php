@extends('layouts.guest')

@section('title', 'Registrasi Wali Santri Baru')

@section('content')

<div class="container my-5">
    <div class="row justify-content-center">
        {{-- Menggunakan col-md-8 atau col-lg-6 karena form registrasi lebih panjang --}}
        <div class="col-md-8 col-lg-6"> 
            <div class="card shadow-lg-custom border-0 rounded-4">
                
                <div class="card-header bg-primary text-white text-center py-4 rounded-top-4">
                    <img src="{{ asset('Images/image.png') }}" alt="Logo Pondok" class="img-fluid mb-2" style="height: 60px;">
                    <h4 class="fw-bold mb-0">Pendaftaran Akun Wali Santri</h4>
                    <p class="small mb-0 text-warning">Isi data di bawah ini untuk membuat akun baru</p>
                </div>
                
                <div class="card-body p-4 p-md-5">

                    {{-- 1. Pesan Kesalahan Validasi (Laravel Error) --}}
                    @if ($errors->any())
                        <div class="alert alert-danger mb-4">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    
                    {{-- 2. Formulir Registrasi --}}
                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        {{-- Input Nama Lengkap --}}
                        <div class="mb-3">
                            <label for="name" class="form-label fw-medium">
                                <i class="fas fa-user me-1"></i> Nama Lengkap
                            </label>
                            <input type="text" 
                                   class="form-control form-control-lg @error('name') is-invalid @enderror" 
                                   id="name" 
                                   name="name" 
                                   value="{{ old('name') }}" 
                                   required 
                                   autofocus>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Input Email --}}
                        <div class="mb-3">
                            <label for="email" class="form-label fw-medium">
                                <i class="fas fa-envelope me-1"></i> Email
                            </label>
                            <input type="email" 
                                   class="form-control form-control-lg @error('email') is-invalid @enderror" 
                                   id="email" 
                                   name="email" 
                                   value="{{ old('email') }}" 
                                   required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Input Password (Dengan Show Password) --}}
                        <div class="mb-3">
                            <label for="password" class="form-label fw-medium">
                                <i class="fas fa-lock me-1"></i> Password
                            </label>
                            <div class="input-group input-group-lg">
                                <input type="password" 
                                       class="form-control @error('password') is-invalid @enderror" 
                                       id="password" 
                                       name="password" 
                                       required 
                                       autocomplete="new-password">
                                <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                                    <i class="fas fa-eye" id="eyeIcon"></i> 
                                </button>
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        {{-- Input Konfirmasi Password (Dengan Show Password) --}}
                        <div class="mb-4">
                            <label for="password_confirmation" class="form-label fw-medium">
                                <i class="fas fa-lock me-1"></i> Konfirmasi Password
                            </label>
                            <div class="input-group input-group-lg">
                                <input type="password" 
                                       class="form-control" 
                                       id="password_confirmation" 
                                       name="password_confirmation" 
                                       required 
                                       autocomplete="new-password">
                                <button class="btn btn-outline-secondary" type="button" id="togglePasswordConfirm">
                                    <i class="fas fa-eye" id="eyeIconConfirm"></i> 
                                </button>
                            </div>
                        </div>
                        
                        {{-- Tombol Submit --}}
                        <div class="d-grid gap-2 mb-3">
                            <button type="submit" class="btn btn-warning btn-lg fw-bold text-primary shadow-sm">
                                <i class="fas fa-user-plus me-2"></i> REGISTRASI
                            </button>
                        </div>
                        
                        {{-- Tautan Sudah Punya Akun --}}
                        <div class="text-center">
                            <a class="small text-muted" href="{{ route('login') }}">
                                Sudah punya akun? Masuk di sini.
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

{{-- START: SCRIPT JAVASCRIPT untuk Tampilkan Kata Sandi --}}
@push('scripts')
<script>
    // Fungsi umum untuk toggle password
    function setupPasswordToggle(toggleId, inputId, iconId) {
        const toggleBtn = document.querySelector(toggleId);
        const inputField = document.querySelector(inputId);
        const icon = document.querySelector(iconId);

        toggleBtn.addEventListener('click', function (e) {
            const type = inputField.getAttribute('type') === 'password' ? 'text' : 'password';
            inputField.setAttribute('type', type);
            
            // Ganti ikon mata
            if (icon.classList.contains('fa-eye')) {
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        });
    }

    // Terapkan untuk Password Utama
    setupPasswordToggle('#togglePassword', '#password', '#eyeIcon');
    
    // Terapkan untuk Konfirmasi Password
    setupPasswordToggle('#togglePasswordConfirm', '#password_confirmation', '#eyeIconConfirm');
</script>
@endpush
{{-- END: SCRIPT JAVASCRIPT --}}