@extends('layouts.wali')

@section('title', 'Profil Pengguna')
@section('page_title', 'Pengaturan Profil Saya')

@section('header_actions')
    {{-- Tombol Kembali ke Dashboard Wali --}}
    <a href="{{ route('wali.dashboard') }}" class="btn btn-outline-secondary shadow-sm d-flex align-items-center fw-semibold rounded-pill px-4">
        <i class="fas fa-arrow-left me-2"></i>
        Kembali ke Dashboard
    </a>
@endsection

@section('content')

{{-- Notifikasi --}}
@if (session('success'))
    <div class="alert alert-success alert-dismissible fade show shadow-sm rounded-3" role="alert">
        <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

@if (session('error'))
    <div class="alert alert-danger alert-dismissible fade show shadow-sm rounded-3" role="alert">
        <i class="fas fa-times-circle me-2"></i> {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<div class="row">
    
    {{-- Kolom Kiri: Detail Profil (Visual Card) --}}
    <div class="col-lg-4 mb-4">
        <div class="card shadow-lg border-0 h-100 rounded-4">
            <div class="card-body text-center p-4">
                
                {{-- Foto Profil Placeholder (Lebih besar) --}}
                <div class="mb-4">
                    <img class="rounded-circle border border-primary border-4 shadow-lg" 
                         src="https://placehold.co/180x180/3B82F6/FFFFFF?text={{ strtoupper(substr($user->name, 0, 1)) }}" 
                         alt="Profil" style="width: 150px; height: 150px; object-fit: cover;">
                </div>

                <h4 class="fw-bolder text-dark mt-3">{{ $user->name }}</h4>
                <p class="text-secondary mb-4">{{ $user->email }}</p>

                <div class="d-grid gap-2">
                    <span class="badge bg-primary text-uppercase p-2 mb-2 fs-6 rounded-pill">
                        <i class="fas fa-shield-alt me-2"></i> Peran: {{ $user->role ?? 'N/A' }}
                    </span>
                    <small class="text-muted mt-2">
                        <i class="fas fa-calendar-check me-1"></i> Bergabung Sejak: <span class="fw-semibold">{{ $user->created_at->translatedFormat('d M Y') }}</span>
                    </small>
                </div>
            </div>
            <div class="card-footer bg-light text-center small rounded-bottom-4">
                 <p class="mb-0 text-secondary">
                    Status akun Anda adalah Aktif sebagai Wali Santri.
                </p>
            </div>
        </div>
    </div>

    {{-- Kolom Kanan: Form Edit Data dan Password --}}
    <div class="col-lg-8">
        
        {{-- TAB NAVIGATION (Menggunakan nav-pills untuk estetika modern) --}}
        <ul class="nav nav-pills mb-4 p-2 bg-light rounded-pill shadow-sm" id="profileTab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active fw-bold rounded-pill px-4 me-2 text-dark" id="data-tab" data-bs-toggle="tab" data-bs-target="#data-section" type="button" role="tab" aria-controls="data-section" aria-selected="true">
                    <i class="fas fa-user-edit me-1"></i> Perbarui Data
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link fw-bold rounded-pill px-4 text-dark" id="password-tab" data-bs-toggle="tab" data-bs-target="#password-section" type="button" role="tab" aria-controls="password-section" aria-selected="false">
                    <i class="fas fa-lock me-1"></i> Ubah Kata Sandi
                </button>
            </li>
        </ul>

        <div class="tab-content">
            
            {{-- TAB 1: PERBARUI DATA PENGGUNA --}}
            <div class="tab-pane fade show active" id="data-section" role="tabpanel" aria-labelledby="data-tab">
                <div class="card shadow-lg border-0 rounded-4">
                    <div class="card-header bg-white border-bottom p-4 rounded-top-4">
                         <h5 class="fw-bold text-primary mb-0"><i class="fas fa-info-circle me-2"></i> Informasi Dasar Akun</h5>
                    </div>
                    <div class="card-body p-4">
                        {{-- RUTE WALI --}}
                        <form action="{{ route('wali.profile.update') }}" method="POST"> 
                            @csrf
                            @method('PUT')
                            
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" placeholder="Nama Lengkap" value="{{ old('name', $user->name) }}" required>
                                        <label for="name">Nama Lengkap</label>
                                        @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    </div>
                                </div> 
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror" placeholder="Alamat Email" value="{{ old('email', $user->email) }}" required>
                                        <label for="email">Alamat Email</label>
                                        @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    </div>
                                </div>
                            </div>
                            
                            <hr class="mt-5 mb-4">
                            <div class="d-flex justify-content-end">
                                <button type="submit" class="btn btn-primary px-5 shadow btn-lg rounded-pill">
                                    <i class="fas fa-save me-2"></i> Simpan Perubahan
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            {{-- TAB 2: UBAH KATA SANDI --}}
            <div class="tab-pane fade" id="password-section" role="tabpanel" aria-labelledby="password-tab">
                 <div class="card shadow-lg border-0 rounded-4">
                    <div class="card-header bg-danger text-white border-bottom p-4 rounded-top-4">
                         <h5 class="fw-bold mb-0"><i class="fas fa-key me-2"></i> Ubah Kata Sandi</h5>
                         <small>Masukkan kata sandi lama untuk verifikasi, lalu masukkan kata sandi baru Anda.</small>
                    </div>
                    <div class="card-body p-4">
                        {{-- RUTE WALI --}}
                        <form action="{{ route('wali.profile.password') }}" method="POST">
                            @csrf
                            @method('PUT')
                            
                            <div class="row g-3">
                                <div class="col-12">
                                    <div class="form-floating">
                                        <input type="password" name="current_password" id="current_password" class="form-control @error('current_password') is-invalid @enderror" placeholder="Kata Sandi Saat Ini" required>
                                        <label for="current_password">Kata Sandi Saat Ini (Lama)</label>
                                        @error('current_password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="password" name="password" id="password" class="form-control @error('password') is-invalid @enderror" placeholder="Kata Sandi Baru" required>
                                        <label for="password">Kata Sandi Baru</label>
                                        @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" placeholder="Konfirmasi Kata Sandi Baru" required>
                                        <label for="password_confirmation">Konfirmasi Kata Sandi Baru</label>
                                    </div>
                                </div>
                            </div>
                            
                            <hr class="mt-5 mb-4">
                            <div class="d-flex justify-content-end">
                                <button type="submit" class="btn btn-danger px-5 shadow btn-lg rounded-pill">
                                    <i class="fas fa-lock me-2"></i> Ganti Kata Sandi
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        
    </div>
</div>

@push('css')
<style>
    /* Styling khusus untuk nav-pills */
    .nav-pills .nav-link {
        color: #495057; /* Default text color */
        background-color: transparent;
        transition: all 0.3s;
    }
    .nav-pills .nav-link.active {
        background-color: #0d6efd; /* Warna primary Bootstrap */
        color: white !important;
        box-shadow: 0 4px 10px rgba(13, 110, 253, 0.3);
    }
    
    /* Styling untuk tab Ubah Kata Sandi saat aktif */
    #password-tab.nav-link.active {
        background-color: #dc3545; /* Warna danger Bootstrap */
        box-shadow: 0 4px 10px rgba(220, 53, 69, 0.3);
    }
</style>
@endpush
@endsection