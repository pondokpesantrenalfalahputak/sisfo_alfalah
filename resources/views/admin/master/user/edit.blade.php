@extends('layouts.admin')

@section('title', 'Edit User')
@section('page_title', 'Edit Data User: ' . $user->name)

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

            <h2 class="mb-4 text-dark fw-bold">✏️ Edit User: {{ $user->name }}</h2>

            <div class="card shadow-lg border-0 rounded-4 border-start border-5 border-warning">
                
                {{-- HEADER CARD DENGAN WARNA PRIMER --}}
                <div class="card-header bg-primary text-white p-4 rounded-top-4">
                    <h4 class="mb-0 fw-bold fs-5"><i class="fas fa-user-edit me-2"></i> Formulir Edit Data User</h4>
                    <p class="text-white-50 small mb-0">Lakukan perubahan pada detail akun dan peran untuk user {{ $user->name }}.</p>
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
                    
                    <form action="{{ route('admin.user.update', $user) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        {{-- Bagian I: Data Akun --}}
                        <h5 class="fw-bold text-dark mb-4 mt-2 border-bottom pb-2 text-warning"><i class="fas fa-user me-2"></i> Data Akun User</h5>
                        <div class="row g-4">
                            
                            {{-- Nama --}}
                            <div class="col-md-6">
                                <label for="name" class="form-label fw-semibold">Nama Lengkap/Alias <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-signature"></i></span>
                                    <input type="text" name="name" id="name" 
                                           class="form-control form-control-lg @error('name') is-invalid @enderror" 
                                           placeholder="Nama Lengkap/Alias" value="{{ old('name', $user->name) }}" required>
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
                                           placeholder="Alamat Email" value="{{ old('email', $user->email) }}" required>
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
                                        <option value="admin" {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>Admin (Pengelola Sistem)</option>
                                        <option value="wali_santri" {{ old('role', $user->role) == 'wali_santri' ? 'selected' : '' }}>Wali Santri (Akses Portal Wali)</option>
                                    </select>
                                    @error('role')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                            </div>
                            
                        </div>
                        
                        <hr class="mt-5 mb-4 border-primary opacity-25">
                        
                        {{-- Bagian II: Keamanan (Password) --}}
                        <h5 class="fw-bold text-dark mb-3 mt-2 border-bottom pb-2 text-danger"><i class="fas fa-lock me-2"></i> Ganti Password (Opsional)</h5>
                        <div class="alert alert-info rounded-3 small shadow-sm" role="alert">
                            <i class="fas fa-info-circle me-2"></i> Kosongkan kolom password di bawah ini jika Anda tidak ingin mengubah password user.
                        </div>
                        <div class="row g-4">
                            
                            {{-- Password Baru --}}
                            <div class="col-md-6">
                                <label for="password" class="form-label fw-semibold">Password Baru</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-key"></i></span>
                                    <input type="password" name="password" id="password" 
                                           class="form-control form-control-lg @error('password') is-invalid @enderror" 
                                           placeholder="Masukkan Password Baru">
                                    <button class="btn btn-outline-secondary" type="button" id="togglePassword" title="Tampilkan/Sembunyikan Password">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                            </div>
                            
                            {{-- Konfirmasi Password --}}
                            <div class="col-md-6">
                                <label for="password_confirmation" class="form-label fw-semibold">Konfirmasi Password Baru</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-check-double"></i></span>
                                    <input type="password" name="password_confirmation" id="password_confirmation" 
                                           class="form-control form-control-lg" 
                                           placeholder="Konfirmasi Password Baru">
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
                            <button type="submit" class="btn btn-warning px-4 shadow-lg fw-bold text-dark rounded-pill">
                                <i class="fas fa-redo me-2"></i> Update User
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
            icon.classList.toggle('fa-eye-slash'); // Ikon mata dicoret
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