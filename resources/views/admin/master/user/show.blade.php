@extends('layouts.admin')

@section('title', 'Detail User')
@section('page_title', 'Detail Pengguna: ' . $user->name)

@section('header_actions')
    {{-- Tombol Aksi di Header (Desktop Only) --}}
    <div class="d-none d-md-flex align-items-center gap-2">
        <a href="{{ route('admin.user.edit', $user) }}" class="btn btn-warning shadow-sm fw-semibold rounded-pill px-3">
            <i class="fas fa-edit me-2"></i>
            Edit Data
        </a>
        <a href="{{ route('admin.user.index') }}" class="btn btn-outline-secondary shadow-sm fw-semibold rounded-pill px-3">
            <i class="fas fa-arrow-left me-2"></i>
            Daftar User
        </a>
    </div>
@endsection

@section('content')

<div class="container-fluid">
    <div class="row">
        <div class="col-12">

            <h2 class="mb-4 text-dark fw-bold">👁️ Profil Pengguna: {{ $user->name }}</h2>

            {{-- Tombol Navigasi Alternatif di Mobile --}}
            <div class="d-flex d-md-none justify-content-between mb-3 gap-2">
                <a href="{{ route('admin.user.edit', $user) }}" class="btn btn-warning btn-sm shadow-sm flex-fill fw-bold rounded-pill">
                    <i class="fas fa-edit"></i> Edit
                </a>
                <a href="{{ route('admin.user.index') }}" class="btn btn-outline-secondary btn-sm shadow-sm flex-fill fw-bold rounded-pill">
                    <i class="fas fa-arrow-left"></i> Kembali
                </a>
            </div>

            <div class="card shadow-lg border-0 rounded-4">
                
                {{-- HEADER CARD DENGAN WARNA PRIMER --}}
                <div class="card-header bg-primary text-white p-4 rounded-top-4">
                    <h4 class="mb-0 fw-bold fs-5"><i class="fas fa-id-card-alt me-2"></i> Profil Pengguna</h4>
                    <p class="text-white-50 small mb-0">Informasi lengkap mengenai pengguna {{ $user->name }}.</p>
                </div>
                
                <div class="card-body p-4">
                    
                    {{-- Bagian 1: Data Akun Utama --}}
                    <h5 class="fw-bold text-dark mb-4 border-bottom pb-2 text-primary"><i class="fas fa-user-circle me-2"></i> Data Akun Utama</h5>
                    
                    <div class="row g-4">
                        
                        {{-- Nama Lengkap --}}
                        <div class="col-lg-6">
                            <div class="p-3 bg-light rounded-3 border-start border-4 border-primary">
                                <label class="fw-semibold text-muted small mb-0">Nama Lengkap</label>
                                <p class="mb-0 fs-3 text-dark fw-bolder">{{ $user->name }}</p>
                            </div>
                        </div>

                        {{-- Email & Role --}}
                        <div class="col-lg-6">
                            <div class="p-3 bg-light rounded-3 border-start border-4 border-info">
                                <label class="fw-semibold text-muted small mb-0">Email / Peran (Role)</label>
                                @php
                                    $badgeClass = match($user->role) {
                                        'admin' => 'primary',
                                        'wali_santri' => 'info text-dark',
                                        default => 'secondary',
                                    };
                                    $roleDisplay = ucfirst(str_replace('_', ' ', $user->role));
                                @endphp
                                <div class="d-flex justify-content-between align-items-center">
                                    <p class="mb-0 fs-5 fw-bold text-secondary">{{ $user->email }}</p>
                                    <span class="badge bg-{{ $badgeClass }} p-2 fw-bold fs-6">
                                        {{ $roleDisplay }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row g-4 mt-3">
                        {{-- Status Verifikasi Email --}}
                        <div class="col-12">
                            <label class="form-label fw-semibold text-muted mb-1">Status Verifikasi Email</label>
                            <p class="mb-0 fs-5">
                                @if ($user->email_verified_at)
                                    <span class="text-success fw-bold"><i class="fas fa-check-circle me-2"></i> Terverifikasi</span>
                                    <span class="text-muted small">pada {{ $user->email_verified_at->translatedFormat('d F Y') }} pukul {{ $user->email_verified_at->format('H:i') }}</span>
                                @else
                                    <span class="text-danger fw-bold"><i class="fas fa-times-circle me-2"></i> Belum Diverifikasi</span>
                                @endif
                            </p>
                        </div>
                    </div>
                    
                    <hr class="mt-5 mb-4 border-dark opacity-25">

                    {{-- Bagian 2: Data Waktu Sistem --}}
                    <h6 class="fw-bold text-secondary mb-3"><i class="fas fa-history me-1"></i> Log Data</h6>

                    <div class="row g-3">
                        {{-- Dibuat Pada --}}
                        <div class="col-md-6">
                            <div class="p-3 border rounded bg-light shadow-sm">
                                <small class="text-muted d-block fw-semibold mb-1">Dibuat Pada</small>
                                <i class="far fa-calendar-alt me-2 text-primary"></i>
                                <span class="text-dark fw-semibold">{{ $user->created_at->translatedFormat('d F Y') }}</span>
                                <span class="text-muted small">pukul {{ $user->created_at->format('H:i') }}</span>
                            </div>
                        </div>
                        
                        {{-- Diupdate Terakhir --}}
                        <div class="col-md-6">
                             <div class="p-3 border rounded bg-light shadow-sm">
                                <small class="text-muted d-block fw-semibold mb-1">Terakhir Diperbarui</small>
                                <i class="far fa-clock me-2 text-warning"></i>
                                <span class="text-dark fw-semibold">{{ $user->updated_at->translatedFormat('d F Y') }}</span>
                                <span class="text-muted small">pukul {{ $user->updated_at->format('H:i') }}</span>
                            </div>
                        </div>
                    </div>
                    
                </div>

                {{-- CARD FOOTER: Action Buttons --}}
                <div class="card-footer bg-light border-0 rounded-bottom-4 p-4">
                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        
                        {{-- Tombol Edit --}}
                        <a href="{{ route('admin.user.edit', $user) }}" class="btn btn-warning shadow-sm fw-bold w-100 w-md-auto text-dark rounded-pill px-4 order-md-1">
                            <i class="fas fa-edit me-2"></i> Edit Data
                        </a>
                        
                        {{-- Tombol Hapus --}}
                        <form action="{{ route('admin.user.destroy', $user) }}" method="POST" class="d-inline w-100 w-md-auto order-md-2">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger shadow-sm fw-bold w-100 rounded-pill px-4" onclick="return confirm('APAKAH ANDA YAKIN ingin menghapus user {{ $user->name }}? Tindakan ini tidak dapat dibatalkan.')">
                                <i class="fas fa-trash me-2"></i> Hapus User
                            </button>
                        </form>

                        {{-- Tombol Kembali --}}
                        <a href="{{ route('admin.user.index') }}" class="btn btn-secondary shadow-sm fw-bold w-100 w-md-auto rounded-pill px-4 order-md-3">
                            <i class="fas fa-list me-2"></i> Daftar User
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection