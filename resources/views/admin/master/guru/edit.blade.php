@extends('layouts.admin')

@section('title', 'Edit Data Guru')
@section('page_title', 'Edit Data Guru' )

@section('styles')
<style>
    /* Global Card Style Consistency */
    .card-master {
        border-radius: 0.75rem !important;
        box-shadow: 0 0.5rem 1.5rem rgba(0, 0, 0, 0.1) !important;
        border: none !important;
    }
    /* Style untuk form-label agar seragam */
    .form-label {
        margin-bottom: 0.3rem;
        font-size: 0.9rem;
    }

    /* ------------------------------------------- */
    /* MOBILE ADJUSTMENTS (FOKUS TOMBOL AKSI) */
    /* ------------------------------------------- */
    @media (max-width: 767.98px) {
        .card-body {
            padding: 1rem !important;
        }
        
        /* Heading Section mobile */
        h6.text-warning {
            font-size: 0.95rem !important;
            margin-top: 1.5rem !important;
            margin-bottom: 0.75rem !important;
        }

        /* Input Group lebih kecil di mobile */
        .input-group-text {
            padding: 0.4rem 0.75rem !important;
        }
        .form-control {
            padding: 0.4rem 0.75rem !important;
        }
        
        /* Tombol Aksi Footer Mobile (DIBUAT SEJAJAR DAN SANGAT KECIL) */
        .card-body .action-buttons {
            justify-content: space-between !important; /* Agar merata */
            gap: 0.5rem !important;
        }
        .card-body .action-buttons .btn {
            width: auto !important; /* Biarkan lebar mengikuti konten */
            font-size: 0.75rem !important; /* Font tombol sangat kecil */
            padding: 0.3rem 0.6rem !important; /* Padding sangat minimal */
            border-radius: 50rem !important; /* Pastikan tetap kapsul */
        }
    }
</style>
@endsection

@section('content')

<div class="container-fluid">
    <div class="row">
        <div class="col-12">

            {{-- Judul Halaman --}}
            <h5 class="mb-4 text-dark fw-bold d-none d-md-block">✏️ Edit Data Guru</h5>

            <div class="card card-master shadow-lg border-0 rounded-4">
                
                {{-- HEADER CARD --}}
                <div class="card-header bg-warning text-dark p-3 rounded-top-4">
                    <h5 class="mb-0 fw-bold"><i class="fas fa-edit me-2"></i> Formulir Edit Data Guru</h5>
                    <p class="text-secondary small mb-0">Lakukan perubahan pada data guru **{{ $guru->nama_lengkap }}** di formulir di bawah ini.</p>
                </div>
                
                <div class="card-body p-4">
                    
                    {{-- Tampilkan error validasi jika ada --}}
                    @if ($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show rounded-3 shadow-sm" role="alert">
                            <h6 class="alert-heading fw-bold"><i class="fas fa-exclamation-triangle me-2"></i> Mohon koreksi kesalahan berikut:</h6>
                            <ul class="mb-0 ps-3 small">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <form action="{{ route('admin.guru.update', $guru) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        {{-- Bagian I: Informasi Identitas --}}
                        <h6 class="fw-bold text-dark mb-4 mt-2 border-bottom pb-2 text-primary"><i class="fas fa-id-card me-2"></i> Informasi Identitas</h6>
                        
                        <div class="row g-3">
                            
                            {{-- Nama Lengkap --}}
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="nama_lengkap" class="form-label fw-semibold">Nama Lengkap <span class="text-danger">*</span></label>
                                    <div class="input-group input-group-sm">
                                        <span class="input-group-text bg-light text-primary"><i class="fas fa-user"></i></span>
                                        <input type="text" name="nama_lengkap" id="nama_lengkap" 
                                               class="form-control @error('nama_lengkap') is-invalid @enderror" 
                                               placeholder="Nama Lengkap Guru" value="{{ old('nama_lengkap', $guru->nama_lengkap) }}" required>
                                        @error('nama_lengkap')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    </div>
                                </div>
                            </div>
                            
                            {{-- NUPTK --}}
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="nuptk" class="form-label fw-semibold">NUPTK <span class="text-danger">*</span></label>
                                    <div class="input-group input-group-sm">
                                        <span class="input-group-text bg-light text-primary"><i class="fas fa-fingerprint"></i></span>
                                        <input type="text" name="nuptk" id="nuptk" 
                                               class="form-control @error('nuptk') is-invalid @enderror" 
                                               placeholder="Nomor Unik Pendidik" value="{{ old('nuptk', $guru->nuptk) }}" required>
                                        @error('nuptk')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    </div>
                                    <small class="text-muted d-block mt-1">Nomor Unik Pendidik dan Tenaga Kependidikan.</small>
                                </div>
                            </div>
                        </div>

                        {{-- Bagian II: Detail Tugas dan Kontak --}}
                        <h6 class="fw-bold text-dark mb-4 mt-4 border-bottom pb-2 text-success"><i class="fas fa-briefcase me-2"></i> Detail Tugas & Kontak</h6>
                        
                        <div class="row g-3">
                            
                            {{-- Jabatan --}}
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="jabatan" class="form-label fw-semibold">Jabatan <span class="text-danger">*</span></label>
                                    <div class="input-group input-group-sm">
                                        <span class="input-group-text bg-light text-success"><i class="fas fa-graduation-cap"></i></span>
                                        <input type="text" name="jabatan" id="jabatan" 
                                               class="form-control @error('jabatan') is-invalid @enderror" 
                                               placeholder="Contoh: Guru Kelas, Kepala Sekolah" value="{{ old('jabatan', $guru->jabatan) }}" required>
                                        @error('jabatan')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    </div>
                                </div>
                            </div>
                            
                            {{-- No HP --}}
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="no_hp" class="form-label fw-semibold">Nomor HP <span class="text-danger">*</span></label>
                                    <div class="input-group input-group-sm">
                                        <span class="input-group-text bg-light text-success"><i class="fas fa-phone"></i></span>
                                        <input type="text" name="no_hp" id="no_hp" 
                                               class="form-control @error('no_hp') is-invalid @enderror" 
                                               placeholder="Contoh: 08123456789" value="{{ old('no_hp', $guru->no_hp) }}" required>
                                        @error('no_hp')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <hr class="mt-4 mb-4 border-secondary opacity-25">

                        {{-- Tombol Aksi (DIFOKUSKAN AGAR RAPI DI MOBILE) --}}
                        <div class="d-flex justify-content-end gap-3 pt-2 action-buttons">
                            
                            {{-- Tombol Kembali --}}
                            <a href="{{ route('admin.guru.index') }}" class="btn btn-outline-secondary btn-sm shadow-sm fw-semibold rounded-pill">
                                <i class="fas fa-arrow-left me-2"></i> Kembali
                            </a>

                            {{-- Tombol Update --}}
                            <button type="submit" class="btn btn-warning btn-sm shadow-lg fw-bold text-dark rounded-pill">
                                <i class="fas fa-redo me-2"></i> Update Data
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection