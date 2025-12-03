@extends('layouts.admin')

@section('title', 'Tambah User')
@section('page_title', 'Registrasi User Baru')

@section('header_actions')
    {{-- Tombol untuk kembali ke Daftar User --}}
    <a href="{{ route('admin.user.index') }}" class="btn btn-outline-secondary shadow-sm rounded-pill d-flex align-items-center fw-semibold px-3">
        <i class="fas fa-list me-2"></i>
        Daftar User
    </a>
@endsection

@section('content')

<div class="container-fluid">
    <div class="row">
        <div class="col-12">

            <h2 class="mb-4 text-dark fw-bold">👤 Registrasi User Baru</h2>

            <div class="card shadow-lg border-0 rounded-4">
                
                {{-- HEADER CARD DENGAN WARNA PRIMER --}}
                <div class="card-header bg-primary text-white p-4 rounded-top-4">
                    <h4 class="mb-0 fw-bold fs-5"><i class="fas fa-user-plus me-2"></i> Formulir Tambah User</h4>
                    <p class="text-white-50 small mb-0">Masukkan detail akun dan tentukan peran (role) untuk user baru.</p>
                </div>
                
                <div class="card-body p-4">

                    {{-- Tampilkan error validasi jika ada --}}
                    @if ($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show rounded-3 shadow-sm" role="alert">
                            <h6 class="alert-heading fw-bold"><i class="fas fa-exclamation-triangle me-2"></i> Mohon koreksi kesalahan berikut:</h6>
                            <ul class="mb-0 ps-3">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <form action="{{ route('admin.user.store') }}" method="POST">
                        @csrf
                        
                        {{-- Bagian I: Data Akun --}}
                        <h5 class="fw-bold text-dark mb-4 mt-2 border-bottom pb-2 text-primary"><i class="fas fa-user me-2"></i> Data Akun User</h5>
                        <div class="row g-4">
                            
                            {{-- Nama --}}
                            <div class="col-md-6">
                                <label for="name" class="form-label fw-semibold">Nama Lengkap/Alias <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-signature"></i></span>
                                    <input type="text" name="name" id="name" 
                                           class="form-control form-control-lg @error('name') is-invalid @enderror" 
                                           placeholder="Nama Lengkap/Alias" value="{{ old('name') }}" required>
                                    @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                            </div>
                            
                            {{-- Email --}}
                            <div class="col-md-6">
                                <label for="email" class="form-label fw-semibold">Email <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-at"></i></span>
                                    <input type="email" name="email" id="email" 
                                           class="form-control form-control-lg @error('email') is-invalid @enderror" 
                                           placeholder="Alamat Email" value="{{ old('email') }}" required>
                                    @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                            </div>
                            
                            {{-- Role --}}
                            <div class="col-12">
                                <label for="role" class="form-label fw-semibold">Peran (Role) User <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-user-tag"></i></span>
                                    <select name="role" id="role" class="form-select form-select-lg @error('role') is-invalid @enderror" required>
                                        <option value="">-- Pilih Role --</option>
                                        <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin (Pengelola Sistem)</option>
                                        <option value="wali_santri" {{ old('role') == 'wali_santri' ? 'selected' : '' }}>Wali Santri (Akses Portal Wali)</option>
                                    </select>
                                    @error('role')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                            </div>
                            
                        </div>
                        
                        <hr class="mt-5 mb-4 border-primary opacity-25">
                        
                        {{-- Bagian II: Keamanan (Password) --}}
                        <h5 class="fw-bold text-dark mb-4 mt-2 border-bottom pb-2 text-danger"><i class="fas fa-lock me-2"></i> Keamanan (Password)</h5>
                        <div class="row g-4">
                            
                            {{-- Password --}}
                            <div class="col-md-6">
                                <label for="password" class="form-label fw-semibold">Password <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-key"></i></span>
                                    <input type="password" name="password" id="password" 
                                           class="form-control form-control-lg @error('password') is-invalid @enderror" 
                                           placeholder="Password Baru" required>
                                    <button class="btn btn-outline-secondary" type="button" id="togglePassword" title="Tampilkan/Sembunyikan Password">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                            </div>
                            
                            {{-- Konfirmasi Password --}}
                            <div class="col-md-6">
                                <label for="password_confirmation" class="form-label fw-semibold">Konfirmasi Password <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-check-double"></i></span>
                                    <input type="password" name="password_confirmation" id="password_confirmation" 
                                           class="form-control form-control-lg" 
                                           placeholder="Konfirmasi Password" required>
                                    <button class="btn btn-outline-secondary" type="button" id="toggleConfirmPassword" title="Tampilkan/Sembunyikan Konfirmasi Password">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </div>
                            </div>
                            
                        </div>
                        
                        <hr class="mt-5 mb-4 border-dark opacity-25">
                        
                        {{-- Tombol Aksi --}}
                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('admin.user.index') }}" class="btn btn-outline-secondary px-4 shadow-sm fw-semibold rounded-pill">
                                <i class="fas fa-times me-2"></i> Batal
                            </a>
                            <button type="submit" class="btn btn-primary px-4 shadow-lg fw-bold rounded-pill">
                                <i class="fas fa-user-plus me-2"></i> Simpan User
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Fungsi universal untuk mengaktifkan toggle password
    function setupPasswordToggle(inputId, toggleBtnId) {
        const passwordInput = document.getElementById(inputId);
        const toggleButton = document.getElementById(toggleBtnId);

        if (!passwordInput || !toggleButton) return;

        toggleButton.addEventListener('click', function() {
            // Toggle type input antara 'password' dan 'text'
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);

            // Ganti ikon mata
            const icon = toggleButton.querySelector('i');
            icon.classList.toggle('fa-eye');
            icon.classList.toggle('fa-eye-slash'); // Gunakan ikon mata dicoret
        });
    }

    document.addEventListener('DOMContentLoaded', function() {
        // Terapkan toggle untuk input Password utama
        setupPasswordToggle('password', 'togglePassword');
        
        // Terapkan toggle untuk input Konfirmasi Password
        setupPasswordToggle('password_confirmation', 'toggleConfirmPassword');
    });
</script>
@endpush