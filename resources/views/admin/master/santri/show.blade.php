@extends('layouts.admin')

@section('title', 'Detail Santri')
@section('page_title', 'Detail Santri: ' . $santri->nama_lengkap)

@section('header_actions')
    {{-- Tombol Aksi di Header (Desktop Only) --}}
    <div class="d-none d-md-flex align-items-center gap-2">
        <a href="{{ route('admin.santri.edit', $santri) }}" class="btn btn-warning shadow-sm fw-semibold rounded-pill px-3">
            <i class="fas fa-edit me-2"></i>
            Edit Data
        </a>
        <a href="{{ route('admin.santri.index') }}" class="btn btn-outline-secondary shadow-sm fw-semibold rounded-pill px-3">
            <i class="fas fa-arrow-left me-2"></i>
            Daftar Santri
        </a>
    </div>
@endsection

@section('content')

<div class="container-fluid">
    <div class="row">
        <div class="col-12">

            <h2 class="mb-4 text-dark fw-bold">👁️ Profil Santri: {{ $santri->nama_lengkap }}</h2>

            {{-- Tombol Navigasi Alternatif di Mobile --}}
            <div class="d-flex d-md-none justify-content-between mb-3 gap-2">
                <a href="{{ route('admin.santri.edit', $santri) }}" class="btn btn-warning btn-sm shadow-sm flex-fill fw-bold rounded-pill">
                    <i class="fas fa-edit"></i> Edit
                </a>
                <a href="{{ route('admin.santri.index') }}" class="btn btn-outline-secondary btn-sm shadow-sm flex-fill fw-bold rounded-pill">
                    <i class="fas fa-arrow-left"></i> Kembali
                </a>
            </div>

            <div class="card shadow-lg border-0 rounded-4">
                
                {{-- HEADER CARD DENGAN WARNA PRIMER --}}
                <div class="card-header bg-primary text-white p-4 rounded-top-4">
                    <h4 class="mb-0 fw-bold fs-5"><i class="fas fa-user-check me-2"></i> Profil Santri</h4>
                    <p class="text-white-50 small mb-0">Informasi lengkap mengenai santri {{ $santri->nama_lengkap }}.</p>
                </div>
                
                <div class="card-body p-4">
                    
                    {{-- Bagian 1: Data Utama dan Status --}}
                    <h5 class="fw-bold text-dark mb-4 border-bottom pb-2 text-primary"><i class="fas fa-id-card me-2"></i> Data Pribadi Utama</h5>
                    
                    <div class="row g-4">
                        
                        {{-- Nama Lengkap --}}
                        <div class="col-lg-6">
                            <div class="p-3 bg-light rounded-3 border-start border-4 border-primary">
                                <label class="fw-semibold text-muted small mb-0">Nama Lengkap</label>
                                <p class="mb-0 fs-3 text-dark fw-bolder">{{ $santri->nama_lengkap }}</p>
                            </div>
                        </div>

                        {{-- NISN & Status --}}
                        <div class="col-lg-6">
                            <div class="p-3 bg-light rounded-3 border-start border-4 border-info">
                                <label class="fw-semibold text-muted small mb-0">NISN / Status</label>
                                <div class="d-flex justify-content-between align-items-center">
                                    <p class="mb-0 fs-4 fw-bold text-primary">{{ $santri->nisn }}</p>
                                    <span class="badge bg-{{ $santri->status == 'Aktif' ? 'success' : 'secondary' }} p-2 fw-bold fs-6">
                                        {{ $santri->status }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Data Detail Pribadi --}}
                    <div class="row g-4 mt-3">
                        {{-- Jenis Kelamin --}}
                        <div class="col-md-6">
                            <label class="form-label fw-semibold text-muted mb-1">Jenis Kelamin</label>
                            <p class="mb-0 text-dark fw-semibold">{{ $santri->jenis_kelamin }}</p>
                        </div>
                        
                        {{-- Tanggal Lahir --}}
                        <div class="col-md-6">
                            <label class="form-label fw-semibold text-muted mb-1">Tanggal Lahir</label>
                            <p class="mb-0 text-dark fw-semibold">{{ $santri->tanggal_lahir ? $santri->tanggal_lahir->translatedFormat('d F Y') : '-' }}</p>
                        </div>
                    </div>
                    
                    <hr class="mt-5 mb-4 border-primary opacity-25">
                    
                    {{-- Bagian 2: Data Akademik dan Asosiasi --}}
                    <h5 class="fw-bold text-dark mb-4 border-bottom pb-2 text-warning"><i class="fas fa-graduation-cap me-2"></i> Data Akademik & Wali</h5>

                    <div class="row g-4">
                        {{-- Kelas --}}
                        <div class="col-md-6">
                            <label class="form-label fw-semibold text-muted mb-1">Kelas</label>
                            <p class="mb-0">
                                <span class="badge bg-info text-dark p-2 fw-bold fs-6">{{ $santri->kelas->nama_kelas ?? 'N/A' }}</span>
                            </p>
                        </div>

                        {{-- Wali Santri --}}
                        <div class="col-md-6">
                            <label class="form-label fw-semibold text-muted mb-1">Wali Santri</label>
                            <p class="mb-0 text-dark fw-bold">{{ $santri->waliSantri->name ?? '-' }}</p>
                        </div>
                    </div>

                    <div class="row g-4 mt-3">
                        {{-- Alamat (Selalu full width) --}}
                        <div class="col-12">
                            <label class="form-label fw-semibold text-muted mb-1">Alamat Lengkap</label>
                            <div class="p-3 border rounded bg-light">{{ $santri->alamat ?? '-' }}</div>
                        </div>
                    </div>


                    <hr class="mt-5 mb-4 border-dark opacity-25">

                    {{-- Bagian 3: Data Waktu Sistem --}}
                    <h6 class="fw-bold text-secondary mb-3"><i class="fas fa-history me-1"></i> Log Data</h6>

                    <div class="row g-3">
                        {{-- Dibuat Pada --}}
                        <div class="col-md-6">
                            <div class="p-3 border rounded bg-light shadow-sm">
                                <small class="text-muted d-block fw-semibold mb-1">Dibuat Pada</small>
                                <i class="far fa-calendar-alt me-2 text-primary"></i>
                                <span class="text-dark fw-semibold">{{ $santri->created_at->translatedFormat('d F Y') }}</span>
                                <span class="text-muted small">pukul {{ $santri->created_at->format('H:i') }}</span>
                            </div>
                        </div>
                        
                        {{-- Diupdate Terakhir --}}
                        <div class="col-md-6">
                             <div class="p-3 border rounded bg-light shadow-sm">
                                <small class="text-muted d-block fw-semibold mb-1">Terakhir Diperbarui</small>
                                <i class="far fa-clock me-2 text-warning"></i>
                                <span class="text-dark fw-semibold">{{ $santri->updated_at->translatedFormat('d F Y') }}</span>
                                <span class="text-muted small">pukul {{ $santri->updated_at->format('H:i') }}</span>
                            </div>
                        </div>
                    </div>
                    
                </div>

                {{-- CARD FOOTER: Action Buttons --}}
                <div class="card-footer bg-light border-0 rounded-bottom-4 p-4">
                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        
                        {{-- Tombol Edit --}}
                        <a href="{{ route('admin.santri.edit', $santri) }}" class="btn btn-warning shadow-sm fw-bold w-100 w-md-auto text-dark rounded-pill px-4 order-md-1">
                            <i class="fas fa-edit me-2"></i> Edit Data
                        </a>
                        
                        {{-- Tombol Hapus --}}
                        <form action="{{ route('admin.santri.destroy', $santri) }}" method="POST" class="d-inline w-100 w-md-auto order-md-2">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger shadow-sm fw-bold w-100 rounded-pill px-4" onclick="return confirm('APAKAH ANDA YAKIN ingin menghapus santri {{ $santri->nama_lengkap }}? Tindakan ini tidak dapat dibatalkan.')">
                                <i class="fas fa-trash me-2"></i> Hapus Santri
                            </button>
                        </form>

                        {{-- Tombol Kembali --}}
                        <a href="{{ route('admin.santri.index') }}" class="btn btn-secondary shadow-sm fw-bold w-100 w-md-auto rounded-pill px-4 order-md-3">
                            <i class="fas fa-list me-2"></i> Daftar Santri
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection