@extends('layouts.admin')

@section('title', 'Detail Guru')
@section('page_title', 'Detail Data Guru: ' . $guru->nama_lengkap)

@section('header_actions')
    {{-- Tombol Aksi di Header (Desktop Only) --}}
    <div class="d-none d-md-flex align-items-center gap-2">
        <a href="{{ route('admin.guru.edit', $guru) }}" class="btn btn-warning shadow-sm fw-semibold rounded-pill px-3">
            <i class="fas fa-edit me-2"></i>
            Edit Data
        </a>
        <a href="{{ route('admin.guru.index') }}" class="btn btn-outline-secondary shadow-sm fw-semibold rounded-pill px-3">
            <i class="fas fa-arrow-left me-2"></i>
            Daftar Guru
        </a>
    </div>
@endsection

@section('content')

<div class="container-fluid">
    <div class="row">
        <div class="col-12">

            <h2 class="mb-4 text-dark fw-bold">👁️ Detail Data Guru</h2>

            {{-- Tombol Navigasi Alternatif di Mobile --}}
            <div class="d-flex d-md-none justify-content-between mb-3 gap-2">
                <a href="{{ route('admin.guru.edit', $guru) }}" class="btn btn-warning btn-sm shadow-sm flex-fill fw-bold rounded-pill">
                    <i class="fas fa-edit"></i> Edit
                </a>
                <a href="{{ route('admin.guru.index') }}" class="btn btn-outline-secondary btn-sm shadow-sm flex-fill fw-bold rounded-pill">
                    <i class="fas fa-arrow-left"></i> Kembali
                </a>
            </div>

            <div class="card shadow-lg border-0 rounded-4">
                
                {{-- HEADER CARD DENGAN WARNA PRIMER --}}
                <div class="card-header bg-primary text-white p-4 rounded-top-4">
                    <h4 class="mb-0 fw-bold fs-5"><i class="fas fa-chalkboard-teacher me-2"></i> Detail Data Guru</h4>
                    <p class="text-white-50 small mb-0">Informasi lengkap mengenai guru: {{ $guru->nama_lengkap }}.</p>
                </div>
                
                <div class="card-body p-4">
                    
                    <div class="row g-4">
                        
                        {{-- KOLOM KIRI: INFORMASI UTAMA & NUPTK --}}
                        <div class="col-lg-6">
                            <h5 class="fw-bold text-dark mb-3 border-bottom pb-2 text-primary"><i class="fas fa-user me-2"></i> Profil Utama</h5>
                            
                            <div class="p-4 bg-light rounded-3 shadow-sm border-start border-5 border-primary">
                                <label class="form-label fw-semibold text-muted small mb-0">Nama Lengkap</label>
                                <p class="mb-3 fs-2 text-dark fw-bolder">{{ $guru->nama_lengkap }}</p>

                                <label class="form-label fw-semibold text-muted small mb-0">NUPTK</label>
                                <p class="mb-0 fs-5 text-secondary fw-semibold">{{ $guru->nuptk }}</p>
                            </div>
                        </div>

                        {{-- KOLOM KANAN: JABATAN & KONTAK --}}
                        <div class="col-lg-6">
                            <h5 class="fw-bold text-dark mb-3 border-bottom pb-2 text-warning"><i class="fas fa-briefcase me-2"></i> Detail Tugas & Kontak</h5>

                            <div class="p-4 bg-light rounded-3 shadow-sm border-start border-5 border-warning">
                                <label class="form-label fw-semibold text-muted small mb-0">Jabatan</label>
                                <p class="mb-3 fs-5">
                                    <span class="badge bg-warning text-dark p-2 fw-bold fs-6">{{ $guru->jabatan }}</span>
                                </p>

                                <label class="form-label fw-semibold text-muted small mb-0">Nomor HP</label>
                                <p class="mb-0 fs-5 text-dark">
                                    <i class="fas fa-phone me-2 text-success"></i>
                                    <span class="fw-bold">{{ $guru->no_hp }}</span>
                                </p>
                            </div>
                        </div>
                        
                    </div>
                    
                    {{-- Metadata Section --}}
                    <div class="row mt-5 pt-4 border-top">
                        <h6 class="fw-bold text-secondary mb-3"><i class="fas fa-history me-1"></i> Log Data</h6>
                        
                        {{-- Dibuat Pada --}}
                        <div class="col-md-6 mb-3">
                            <div class="p-3 border rounded bg-light shadow-sm">
                                <small class="text-muted d-block fw-semibold mb-1">Dibuat Pada</small>
                                <i class="far fa-calendar-alt me-2 text-primary"></i>
                                <span class="text-dark fw-semibold">{{ $guru->created_at->translatedFormat('d F Y') }}</span>
                                <span class="text-muted small">pukul {{ $guru->created_at->format('H:i') }}</span>
                            </div>
                        </div>
                        
                        {{-- Terakhir Diperbarui --}}
                        <div class="col-md-6 mb-3">
                             <div class="p-3 border rounded bg-light shadow-sm">
                                <small class="text-muted d-block fw-semibold mb-1">Terakhir Diperbarui</small>
                                <i class="far fa-clock me-2 text-warning"></i>
                                <span class="text-dark fw-semibold">{{ $guru->updated_at->translatedFormat('d F Y') }}</span>
                                <span class="text-muted small">pukul {{ $guru->updated_at->format('H:i') }}</span>
                            </div>
                        </div>
                    </div>
                    
                </div>

                {{-- CARD FOOTER: Action Buttons --}}
                <div class="card-footer bg-light border-0 rounded-bottom-4 p-4">
                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        
                        {{-- Tombol Edit --}}
                        <a href="{{ route('admin.guru.edit', $guru) }}" class="btn btn-warning shadow-sm fw-bold w-100 w-md-auto text-dark rounded-pill px-4">
                            <i class="fas fa-edit me-2"></i> Edit Data
                        </a>
                        
                        {{-- Tombol Hapus --}}
                        <form action="{{ route('admin.guru.destroy', $guru) }}" method="POST" class="d-inline w-100 w-md-auto">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger shadow-sm fw-bold w-100 rounded-pill px-4" onclick="return confirm('APAKAH ANDA YAKIN ingin menghapus data guru: {{ $guru->nama_lengkap }}? Tindakan ini tidak dapat dibatalkan.')">
                                <i class="fas fa-trash me-2"></i> Hapus Guru
                            </button>
                        </form>

                        {{-- Tombol Kembali --}}
                        <a href="{{ route('admin.guru.index') }}" class="btn btn-secondary shadow-sm fw-bold w-100 w-md-auto rounded-pill px-4">
                            <i class="fas fa-list me-2"></i> Daftar Guru
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection