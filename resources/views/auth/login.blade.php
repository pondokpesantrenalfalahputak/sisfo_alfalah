@extends('layouts.guest')

@section('title', 'Login Wali Santri')

@section('content')

<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-7 col-lg-5">
            <div class="card shadow-lg-custom border-0 rounded-4">
                
                <div class="card-header bg-primary text-white text-center py-4 rounded-top-4">
                    <img src="{{ asset('Images/image.png') }}" alt="Logo Al-Falah" class="img-fluid mb-2" style="height: 60px;">
                    <h4 class="fw-bold mb-0">Portal Wali Santri</h4>
                    <p class="small mb-0 text-warning">Masuk untuk melihat data santri</p>
                </div>
                
                <div class="card-body p-4 p-md-5">

                    @if ($errors->any())
                        <div class="alert alert-danger mb-4">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    
                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="mb-3">
                            <label for="email" class="form-label fw-medium">
                                <i class="fas fa-envelope me-1"></i> Email
                            </label>
                            <input type="email" 
                                   class="form-control form-control-lg @error('email') is-invalid @enderror" 
                                   id="email" 
                                   name="email" 
                                   value="{{ old('email') }}" 
                                   required 
                                   autofocus>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- START: PERUBAHAN INPUT PASSWORD --}}
                        <div class="mb-4">
                            <label for="password" class="form-label fw-medium">
                                <i class="fas fa-lock me-1"></i> Password
                            </label>
                            <div class="input-group input-group-lg">
                                <input type="password" 
                                       class="form-control @error('password') is-invalid @enderror" 
                                       id="password" 
                                       name="password" 
                                       required>
                                <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                                    {{-- Ikon Mata --}}
                                    <i class="fas fa-eye" id="eyeIcon"></i> 
                                </button>
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        {{-- END: PERUBAHAN INPUT PASSWORD --}}

                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="remember" id="remember_me">
                                <label class="form-check-label small" for="remember_me">
                                    Ingat Saya
                                </label>
                            </div>
                            
                            @if (Route::has('password.request'))
                                <a class="small text-muted" href="{{ route('password.request') }}">
                                    Lupa Password?
                                </a>
                            @endif
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-warning btn-lg fw-bold text-primary shadow-sm">
                                <i class="fas fa-sign-in-alt me-2"></i> MASUK
                            </button>
                        </div>
                    </form>
                </div>
                
                {{-- START: PERUBAHAN CARD FOOTER --}}
                <div class="card-footer text-center bg-light border-0 py-3 rounded-bottom-4">
                    {{-- Cek apakah rute register tersedia sebelum menampilkannya --}}
                    @if (Route::has('register'))
                        <p class="small text-muted mb-0">
                            Belum punya akun? 
                            <a href="{{ route('register') }}" class="fw-bold text-primary text-decoration-none">
                                Daftar di sini.
                            </a>
                        </p>
                    @else
                        <p class="small text-muted mb-0">
                            Belum punya akun? Hubungi Admin Pondok.
                        </p>
                    @endif
                </div>
                {{-- END: PERUBAHAN CARD FOOTER --}}
            </div>
        </div>
    </div>
</div>

@endsection

{{-- START: SCRIPT JAVASCRIPT --}}
@push('scripts')
<script>
    const togglePassword = document.querySelector('#togglePassword');
    const password = document.querySelector('#password');
    const eyeIcon = document.querySelector('#eyeIcon');

    togglePassword.addEventListener('click', function (e) {
        // Toggle antara tipe 'password' dan 'text'
        const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
        password.setAttribute('type', type);
        
        // Ganti ikon mata
        if (eyeIcon.classList.contains('fa-eye')) {
            eyeIcon.classList.remove('fa-eye');
            eyeIcon.classList.add('fa-eye-slash'); // Mata tertutup
        } else {
            eyeIcon.classList.remove('fa-eye-slash');
            eyeIcon.classList.add('fa-eye'); // Mata terbuka
        }
    });
</script>
@endpush
{{-- END: SCRIPT JAVASCRIPT --}}