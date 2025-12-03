@extends('layouts.admin')

@section('title', 'Tambah Guru')
@section('page_title', 'Tambah Guru Baru')

@section('header_actions')
    {{-- Tombol untuk kembali ke Daftar Guru --}}
    <a href="{{ route('admin.guru.index') }}" class="btn btn-outline-secondary shadow-sm rounded-pill d-flex align-items-center fw-semibold px-3">
        <i class="fas fa-list me-2"></i>
        Daftar Guru
    </a>
@endsection

@section('content')

<div class="container-fluid">
    <div class="row">
        <div class="col-12">

            <h2 class="mb-4 text-dark fw-bold">🧑‍🏫 Tambah Guru Baru</h2>

            <div class="card shadow-lg border-0 rounded-4">
                
                {{-- HEADER CARD DENGAN WARNA PRIMER --}}
                <div class="card-header bg-primary text-white p-4 rounded-top-4">
                    <h4 class="mb-0 fw-bold fs-5"><i class="fas fa-user-plus me-2"></i> Formulir Tambah Data Guru</h4>
                    <p class="text-white-50 small mb-0">Lengkapi data di bawah ini untuk menambahkan data guru baru ke sistem.</p>
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
                    
                    <form action="{{ route('admin.guru.store') }}" method="POST">
                        @csrf
                        
                        {{-- Bagian I: Informasi Dasar Guru --}}
                        <h5 class="fw-bold text-dark mb-4 mt-2 border-bottom pb-2 text-primary"><i class="fas fa-id-card me-2"></i> Informasi Utama</h5>
                        
                        <div class="row g-4">
                            
                            {{-- Nama Lengkap --}}
                            <div class="col-md-6">
                                <label for="nama_lengkap" class="form-label fw-semibold">Nama Lengkap <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-user"></i></span>
                                    <input type="text" name="nama_lengkap" id="nama_lengkap" 
                                           class="form-control form-control-lg @error('nama_lengkap') is-invalid @enderror" 
                                           placeholder="Nama Lengkap Guru" value="{{ old('nama_lengkap') }}" required>
                                    @error('nama_lengkap')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                            </div>
                            
                            {{-- NUPTK --}}
                            <div class="col-md-6">
                                <label for="nuptk" class="form-label fw-semibold">NUPTK <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-fingerprint"></i></span>
                                    <input type="text" name="nuptk" id="nuptk" 
                                           class="form-control form-control-lg @error('nuptk') is-invalid @enderror" 
                                           placeholder="Nomor Unik Pendidik" value="{{ old('nuptk') }}" required>
                                    @error('nuptk')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                                <small class="text-muted d-block mt-1">Nomor Unik Pendidik dan Tenaga Kependidikan.</small>
                            </div>
                            
                        </div>
                        
                        {{-- Bagian II: Detail Tugas dan Kontak --}}
                        <h5 class="fw-bold text-dark mb-4 mt-5 border-bottom pb-2 text-primary"><i class="fas fa-briefcase me-2"></i> Detail Tugas & Kontak</h5>
                        
                        <div class="row g-4">

                            {{-- Jabatan --}}
                            <div class="col-md-6">
                                <label for="jabatan" class="form-label fw-semibold">Jabatan <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-graduation-cap"></i></span>
                                    <input type="text" name="jabatan" id="jabatan" 
                                           class="form-control form-control-lg @error('jabatan') is-invalid @enderror" 
                                           placeholder="Contoh: Guru Kelas, Kepala Sekolah" value="{{ old('jabatan') }}" required>
                                    @error('jabatan')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                            </div>
                            
                            {{-- No HP --}}
                            <div class="col-md-6">
                                <label for="no_hp" class="form-label fw-semibold">Nomor HP <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-phone"></i></span>
                                    <input type="text" name="no_hp" id="no_hp" 
                                           class="form-control form-control-lg @error('no_hp') is-invalid @enderror" 
                                           placeholder="Contoh: 08123456789" value="{{ old('no_hp') }}" required>
                                    @error('no_hp')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                            </div>

                        </div>
                        
                        <hr class="mt-5 mb-4 border-primary opacity-25">
                        
                        {{-- Tombol Aksi --}}
                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('admin.guru.index') }}" class="btn btn-outline-secondary me-2 px-4 shadow-sm fw-semibold rounded-pill">
                                <i class="fas fa-times me-2"></i> Batal
                            </a>
                            <button type="submit" class="btn btn-primary px-4 shadow-lg fw-bold rounded-pill">
                                <i class="fas fa-save me-2"></i> Simpan Data Guru
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection