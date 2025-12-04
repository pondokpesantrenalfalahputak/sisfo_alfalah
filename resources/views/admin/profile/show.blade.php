@extends('layouts.admin')

@section('title', 'Profil Pengguna')
@section('page_title', 'Pengaturan Profil Saya')

{{-- Menentukan tab mana yang harus aktif setelah submit, terutama jika ada error validasi --}}
@php
    $activeTab = 'data';
    if ($errors->has('current_password') || $errors->has('password') || session('error') === 'Kata sandi lama salah.') {
        $activeTab = 'password';
    }
@endphp

@section('header_actions')
    <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary shadow-sm rounded-pill d-flex align-items-center fw-semibold px-3">
        <i class="fas fa-arrow-left me-2"></i>
        Kembali ke Dashboard
    </a>
@endsection

@section('content')

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <h2 class="mb-4 text-dark fw-bold">⚙️ Pengaturan Profil Saya</h2>
        </div>
    </div>
    
    {{-- Notifikasi --}}
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show rounded-3 shadow-sm" role="alert">
            <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show rounded-3 shadow-sm" role="alert">
            <i class="fas fa-times-circle me-2"></i> {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row">
        
        {{-- Kolom Kiri: Detail Profil (Sticky di Desktop) --}}
        <div class="col-lg-4 mb-4">
            <div class="card shadow-lg border-0 rounded-4 h-100 sticky-top" style="top: 15px;">
                <div class="card-body text-center p-4">
                    
                    {{-- Foto Profil Placeholder --}}
                    <div class="mb-3">
                        <img class="rounded-circle border border-warning border-4 shadow-sm" 
                             src="https://placehold.co/150x150/0D6EFD/FFFFFF?text={{ strtoupper(substr($user->name, 0, 1)) }}" 
                             alt="Profil" style="width: 130px; height: 130px; object-fit: cover;">
                    </div>

                    <h4 class="fw-bolder text-dark mt-3">{{ $user->name }}</h4>
                    <p class="text-muted mb-4 fs-6">{{ $user->email }}</p>

                    <div class="d-grid gap-2">
                        <span class="badge bg-primary text-uppercase p-2 mb-2 fs-6 rounded-pill">
                            <i class="fas fa-shield-alt me-2"></i> Peran: {{ $user->role ?? 'N/A' }}
                        </span>
                        <small class="text-secondary fw-semibold">
                            <i class="fas fa-calendar-alt me-1"></i> Bergabung Sejak: {{ $user->created_at->translatedFormat('d F Y') }}
                        </small>
                    </div>
                </div>
                <div class="card-footer bg-light text-center small rounded-bottom-4">
                     <p class="mb-0 text-secondary">
                        <i class="fas fa-info-circle me-1"></i> Data Anda aman dan terenkripsi.
                    </p>
                </div>
            </div>
        </div>

        {{-- Kolom Kanan: Form Edit Data dan Password --}}
        <div class="col-lg-8">
            
            {{-- TAB NAVIGATION --}}
            <ul class="nav nav-pills nav-fill mb-4" id="profileTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link fw-bold {{ $activeTab == 'data' ? 'active' : '' }} rounded-pill me-2 shadow-sm" id="data-tab" data-bs-toggle="tab" data-bs-target="#data-section" type="button" role="tab" aria-controls="data-section" aria-selected="{{ $activeTab == 'data' ? 'true' : 'false' }}">
                        <i class="fas fa-user-edit me-2"></i> Perbarui Data
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link fw-bold {{ $activeTab == 'password' ? 'active' : '' }} rounded-pill shadow-sm" id="password-tab" data-bs-toggle="tab" data-bs-target="#password-section" type="button" role="tab" aria-controls="password-section" aria-selected="{{ $activeTab == 'password' ? 'true' : 'false' }}">
                        <i class="fas fa-lock me-2"></i> Ubah Kata Sandi
                    </button>
                </li>
            </ul>

            <div class="tab-content">
                
                {{-- TAB 1: PERBARUI DATA PENGGUNA --}}
                <div class="tab-pane fade {{ $activeTab == 'data' ? 'show active' : '' }}" id="data-section" role="tabpanel" aria-labelledby="data-tab">
                    <div class="card shadow-lg border-0 rounded-4 border-start border-5 border-primary">
                        <div class="card-header bg-primary text-white p-4 rounded-top-4">
                             <h5 class="fw-bold mb-0"><i class="fas fa-info-circle me-2"></i> Informasi Dasar</h5>
                        </div>
                        <div class="card-body p-4">
                            <form action="{{ route('admin.profile.update') }}" method="POST">
                                @csrf
                                @method('PUT')
                                
                                <div class="row g-4">
                                    <div class="col-md-6">
                                        <label for="name" class="form-label fw-semibold">Nama Lengkap</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-user"></i></span>
                                            <input type="text" name="name" id="name" class="form-control form-control-lg @error('name') is-invalid @enderror" placeholder="Nama Lengkap" value="{{ old('name', $user->name) }}" required>
                                            @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="email" class="form-label fw-semibold">Alamat Email</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                            <input type="email" name="email" id="email" class="form-control form-control-lg @error('email') is-invalid @enderror" placeholder="Alamat Email" value="{{ old('email', $user->email) }}" required>
                                            @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                        </div>
                                    </div>
                                </div>
                                
                                <hr class="mt-5 mb-4 border-dark opacity-25">
                                <div class="d-flex justify-content-end">
                                    <button type="submit" class="btn btn-primary px-4 shadow-lg fw-bold rounded-pill">
                                        <i class="fas fa-save me-2"></i> Simpan Perubahan Data
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                {{-- TAB 2: UBAH KATA SANDI --}}
                <div class="tab-pane fade {{ $activeTab == 'password' ? 'show active' : '' }}" id="password-section" role="tabpanel" aria-labelledby="password-tab">
                     <div class="card shadow-lg border-0 rounded-4 border-start border-5 border-danger">
                        <div class="card-header bg-danger text-white p-4 rounded-top-4">
                             <h5 class="fw-bold mb-0"><i class="fas fa-unlock-alt me-2"></i> Ubah Kata Sandi</h5>
                             <small class="text-white-50">Masukkan kata sandi lama untuk memverifikasi, lalu masukkan kata sandi baru Anda.</small>
                        </div>
                        <div class="card-body p-4">
                            <form action="{{ route('admin.profile.password') }}" method="POST">
                                @csrf
                                @method('PUT')
                                
                                <div class="row g-4">
                                    <div class="col-12">
                                        <label for="current_password" class="form-label fw-semibold">Kata Sandi Saat Ini (Lama)</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-shield-alt"></i></span>
                                            <input type="password" name="current_password" id="current_password" class="form-control form-control-lg @error('current_password') is-invalid @enderror" placeholder="Kata Sandi Saat Ini" required>
                                            @error('current_password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="password" class="form-label fw-semibold">Kata Sandi Baru</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-key"></i></span>
                                            <input type="password" name="password" id="password" class="form-control form-control-lg @error('password') is-invalid @enderror" placeholder="Kata Sandi Baru" required>
                                            @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="password_confirmation" class="form-label fw-semibold">Konfirmasi Kata Sandi Baru</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-check-circle"></i></span>
                                            <input type="password" name="password_confirmation" id="password_confirmation" class="form-control form-control-lg" placeholder="Konfirmasi Kata Sandi Baru" required>
                                        </div>
                                    </div>
                                </div>
                                
                                <hr class="mt-5 mb-4 border-dark opacity-25">
                                <div class="d-flex justify-content-end">
                                    <button type="submit" class="btn btn-danger px-4 shadow-lg fw-bold rounded-pill">
                                        <i class="fas fa-redo-alt me-2"></i> Ganti Kata Sandi
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
    </div>
</div>

{{-- Script untuk memastikan tab yang benar aktif setelah validasi gagal --}}
@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var activeTab = '{{ $activeTab }}';
        var tabElement = document.getElementById(activeTab + '-tab');
        if (tabElement) {
            new bootstrap.Tab(tabElement).show();
        }
    });
</script>
@endpush
@endsection