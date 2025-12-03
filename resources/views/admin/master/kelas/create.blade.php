@extends('layouts.admin')

@section('title', 'Tambah Kelas')
@section('page_title', 'Tambah Kelas Baru')

@section('header_actions')
    {{-- Tombol untuk kembali ke Daftar Kelas --}}
    <a href="{{ route('admin.kelas.index') }}" class="btn btn-outline-secondary shadow-sm rounded-pill d-flex align-items-center fw-semibold px-3">
        <i class="fas fa-list me-2"></i>
        Daftar Kelas
    </a>
@endsection

@section('content')

<div class="container-fluid">
    <div class="row">
        <div class="col-12">

            <h2 class="mb-4 text-dark fw-bold">➕ Tambah Kelas Baru</h2>

            <div class="card shadow-lg border-0 rounded-4">
                
                {{-- HEADER CARD DENGAN WARNA PRIMER --}}
                <div class="card-header bg-primary text-white p-4 rounded-top-4">
                    <h4 class="mb-0 fw-bold fs-5"><i class="fas fa-plus-square me-2"></i> Formulir Tambah Kelas</h4>
                    <p class="text-white-50 small mb-0">Masukkan detail nama dan tingkat kelas yang akan ditambahkan.</p>
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
                    
                    <form action="{{ route('admin.kelas.store') }}" method="POST">
                        @csrf
                        
                        <div class="row g-4">
                            
                            {{-- Nama Kelas --}}
                            <div class="col-md-6">
                                <label for="nama_kelas" class="form-label fw-semibold">Nama Kelas <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-school"></i></span>
                                    <input type="text" name="nama_kelas" id="nama_kelas" 
                                           class="form-control form-control-lg @error('nama_kelas') is-invalid @enderror" 
                                           placeholder="Contoh: 7A, 10B, Mutakhorijin" 
                                           value="{{ old('nama_kelas') }}" required>
                                    @error('nama_kelas')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                            </div>
                            
                            {{-- Tingkat (Select Box) --}}
                            <div class="col-md-6">
                                <label for="tingkat" class="form-label fw-semibold">Tingkat Kelas <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-layer-group"></i></span>
                                    <select name="tingkat" id="tingkat" 
                                            class="form-select form-select-lg @error('tingkat') is-invalid @enderror" required>
                                        <option value="">-- Pilih Tingkat --</option>
                                        
                                        {{-- Daftar tingkat kelas yang spesifik (7, 8, 9, 10, 11, 12, 13) --}}
                                        @php
                                            $tingkatKelas = [7, 8, 9, 10, 11, 12, 13];
                                        @endphp
                                        
                                        @foreach ($tingkatKelas as $tingkatOption)
                                            <option value="{{ $tingkatOption }}" {{ old('tingkat') == $tingkatOption ? 'selected' : '' }}>Tingkat {{ $tingkatOption }}</option>
                                        @endforeach

                                    </select>
                                    @error('tingkat')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                                <small class="text-muted d-block mt-1">Pilih tingkat/level kelas (7-13).</small>
                            </div>
                            
                        </div>
                        
                        <hr class="mt-5 mb-4 border-primary opacity-25">
                        
                        {{-- Tombol Aksi --}}
                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('admin.kelas.index') }}" class="btn btn-outline-secondary px-4 shadow-sm fw-semibold rounded-pill">
                                <i class="fas fa-times me-2"></i> Batal
                            </a>
                            <button type="submit" class="btn btn-primary px-4 shadow-lg fw-bold rounded-pill">
                                <i class="fas fa-save me-2"></i> Simpan Kelas
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection