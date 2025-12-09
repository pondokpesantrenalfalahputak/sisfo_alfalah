@extends('layouts.admin')

@section('title', 'Detail User')
@section('page_title', 'Detail Pengguna: ' . $user->name)

{{-- Tombol Aksi di Header dihilangkan, diganti dengan Tombol Kembali Sederhana di Mobile --}}
@section('header_actions')
    {{-- Tombol Kembali ke Daftar User (Mobile Only) --}}
    <a href="{{ route('admin.user.index') }}" class="btn btn-outline-secondary shadow-sm rounded-pill d-md-none d-flex align-items-center fw-semibold px-3">
        <i class="fas fa-list me-2"></i>
        Daftar User
    </a>
@endsection

@section('content')

<div class="container-fluid">
    <div class="row">
        <div class="col-12">

            <div class="card shadow-lg border-0 rounded-4 border-start border-5 border-primary">
                
                {{-- HEADER CARD --}}
                <div class="card-header bg-primary text-white p-4 rounded-top-4">
                    <h4 class="mb-0 fw-bold fs-5"><i class="fas fa-user-circle me-2"></i> Profil Pengguna</h4>
                    <p class="text-white-50 small mb-0">Informasi lengkap mengenai pengguna {{ $user->name }}.</p>
                </div>
                
                <div class="card-body p-4">
                    
                    {{-- Bagian 1: Data Akun Utama --}}
                    <h5 class="fw-bold text-dark mb-3 border-bottom pb-2 text-primary"><i class="fas fa-id-card-alt me-2"></i> Data Akun Utama</h5>
                    
                    {{-- Mengganti g-4 menjadi g-3 untuk kerapian mobile --}}
                    <div class="row g-3"> 
                        
                        {{-- Nama Lengkap --}}
                        <div class="col-lg-6">
                            <div class="p-3 bg-light rounded-3 border-start border-5 border-primary shadow-sm">
                                <label class="fw-semibold text-muted small mb-0">Nama Lengkap</label>
                                {{-- Penyesuaian Font: fs-4 di desktop, fs-5 di mobile --}}
                                <p class="mb-0 fw-bolder fs-5 fs-md-4 text-dark">{{ $user->name }}</p> 
                            </div>
                        </div>

                        {{-- Email & Role --}}
                        <div class="col-lg-6">
                            @php
                                $badgeClass = match($user->role) {
                                    'admin' => 'danger', 
                                    'wali_santri' => 'primary',
                                    default => 'secondary',
                                };
                                $roleDisplay = ucfirst(str_replace('_', ' ', $user->role));
                            @endphp
                            <div class="p-3 bg-light rounded-3 border-start border-5 border-info shadow-sm">
                                <label class="fw-semibold text-muted small mb-0">Email / Peran (Role)</label>
                                <div class="d-flex justify-content-between align-items-center">
                                    {{-- Font Email dikecilkan --}}
                                    <p class="mb-0 fw-semibold text-secondary text-truncate small">{{ $user->email }}</p> 
                                    <span class="badge bg-{{ $badgeClass }} p-2 fw-bold small rounded-pill ms-3">
                                        {{ $roleDisplay }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Status Verifikasi Email --}}
                    <div class="row g-3 mt-1"> 
                        <div class="col-12">
                            <label class="form-label fw-semibold text-muted small mb-1 mt-3"><i class="fas fa-envelope-open-text me-1"></i> Status Verifikasi Email</label>
                            <div class="p-3 border rounded bg-white shadow-sm">
                                @if ($user->email_verified_at)
                                    <span class="text-success fw-bold me-2 small"><i class="fas fa-check-circle me-1"></i> Terverifikasi</span>
                                    {{-- Menggunakan fs-7 jika ada di template, atau tetap small --}}
                                    <span class="text-muted small">pada {{ $user->email_verified_at->translatedFormat('d F Y') }} pukul {{ $user->email_verified_at->format('H:i') }}</span>
                                @else
                                    <span class="text-danger fw-bold small"><i class="fas fa-times-circle me-1"></i> Belum Diverifikasi</span>
                                @endif
                            </div>
                        </div>
                    </div>
                    
                    <hr class="mt-5 mb-4 border-dark opacity-25">

                    {{-- Bagian 2: Data Waktu Sistem --}}
                    <h5 class="fw-bold text-secondary mb-3 border-bottom pb-2"><i class="fas fa-history me-2"></i> Log Data Sistem</h5>

                    <div class="row g-3">
                        {{-- Dibuat Pada --}}
                        <div class="col-md-6">
                            <div class="p-3 border rounded bg-light shadow-sm">
                                <small class="text-muted d-block fw-semibold mb-1">Dibuat Pada</small>
                                <i class="far fa-calendar-alt me-2 text-primary"></i>
                                <span class="text-dark fw-semibold small">{{ $user->created_at->translatedFormat('d F Y') }}</span>
                                <span class="text-muted small">{{ $user->created_at->format('H:i') }}</span>
                            </div>
                        </div>
                        
                        {{-- Diupdate Terakhir --}}
                        <div class="col-md-6">
                             <div class="p-3 border rounded bg-light shadow-sm">
                                <small class="text-muted d-block fw-semibold mb-1">Terakhir Diperbarui</small>
                                <i class="far fa-clock me-2 text-warning"></i>
                                <span class="text-dark fw-semibold small">{{ $user->updated_at->translatedFormat('d F Y') }}</span>
                                <span class="text-muted small">{{ $user->updated_at->format('H:i') }}</span>
                            </div>
                        </div>
                    </div>
                    
                </div>

                {{-- CARD FOOTER: Action Buttons (Responsif) --}}
                <div class="card-footer bg-light border-0 rounded-bottom-4 p-4">
                    {{-- d-grid gap-2 untuk Mobile (full-width), d-flex justify-content-md-end untuk Desktop --}}
                    <div class="d-grid gap-3 d-md-flex justify-content-md-end">
                        
                        {{-- Tombol Edit (Tampil pertama di desktop, kedua di mobile) --}}
                        <a href="{{ route('admin.user.edit', $user) }}" class="btn btn-warning shadow-sm fw-bold text-dark rounded-pill px-4 order-md-1">
                            <i class="fas fa-edit me-2"></i> Edit Data
                        </a>
                        
                        {{-- Tombol Hapus (Tampil kedua di desktop, ketiga di mobile) --}}
                        {{-- Menggunakan d-grid agar full-width di mobile --}}
                        <form action="{{ route('admin.user.destroy', $user) }}" method="POST" class="d-grid order-md-2">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger shadow-sm fw-bold rounded-pill px-4" onclick="return confirm('APAKAH ANDA YAKIN ingin menghapus user {{ $user->name }}? Tindakan ini tidak dapat dibatalkan.')">
                                <i class="fas fa-trash me-2"></i> Hapus User
                            </button>
                        </form>

                         {{-- Tombol Kembali ke Daftar User (Tampil terakhir di desktop, pertama di mobile) --}}
                        <a href="{{ route('admin.user.index') }}" class="btn btn-outline-secondary shadow-sm fw-bold rounded-pill px-4 order-md-3">
                            <i class="fas fa-list me-2"></i> Daftar User
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection