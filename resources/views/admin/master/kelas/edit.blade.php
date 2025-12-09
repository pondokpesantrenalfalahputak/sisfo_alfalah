@extends('layouts.admin')

@section('title', 'Edit Data Kelas')
@section('page_title', 'Edit Kelas: ' . $kela->nama_kelas)

@section('content')

<div class="container-fluid">
    <div class="row">
        <div class="col-12">

            <div class="card shadow-lg border-0 rounded-4">
                
                {{-- HEADER CARD --}}
                <div class="card-header bg-warning text-dark p-4 rounded-top-4 border-bottom border-light">
                    <h5 class="mb-0 fw-bold fs-6"><i class="fas fa-edit me-2"></i> Formulir Perubahan Data Kelas</h5>
                    <p class="text-dark-50 small mb-0">Sesuaikan Nama Kelas dan Tingkat Pendidikan.</p>
                </div>
                
                <div class="card-body p-4">
                    
                    {{-- Tampilkan error validasi jika ada --}}
                    @if ($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show rounded-3 shadow-sm border-danger" role="alert">
                            <h6 class="alert-heading fw-bold"><i class="fas fa-exclamation-circle me-2"></i> Kesalahan Input Terdeteksi:</h6>
                            <ul class="mb-0 ps-3 small">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
                    
                    <form action="{{ route('admin.kelas.update', ['kela' => $kela]) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="row g-4">

                            {{-- Nama Kelas --}}
                            <div class="col-md-6">
                                {{-- LABEL DIPERBAIKI: Menggunakan atribut for yang sesuai dengan id input --}}
                                <label for="nama_kelas" class="form-label fw-semibold small text-muted mb-1">Nama Kelas <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light text-primary border-end-0"><i class="fas fa-school"></i></span>
                                    <input type="text" name="nama_kelas" id="nama_kelas"
                                           class="form-control @error('nama_kelas') is-invalid @enderror"
                                           placeholder="Contoh: VII A, X IPA 1"
                                           value="{{ old('nama_kelas', $kela->nama_kelas) }}" required>
                                </div>
                                @error('nama_kelas')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @else
                                    <small class="text-muted d-block mt-1">Masukkan nama kelas secara lengkap.</small>
                                @enderror
                            </div>

                            {{-- Tingkat (Select Box) --}}
                            <div class="col-md-6">
                                {{-- LABEL DIPERBAIKI: Menggunakan atribut for yang sesuai dengan id input --}}
                                <label for="tingkat" class="form-label fw-semibold small text-muted mb-1">Tingkat Kelas <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light text-info border-end-0"><i class="fas fa-layer-group"></i></span>
                                    <select name="tingkat" id="tingkat"
                                            class="form-select @error('tingkat') is-invalid @enderror" required>
                                        <option value="">-- Pilih Tingkat --</option>

                                        {{-- Daftar tingkat kelas --}}
                                        @php
                                            $tingkatKelas = [7, 8, 9, 10, 11, 12, 13];
                                        @endphp

                                        @foreach ($tingkatKelas as $tingkatOption)
                                            <option value="{{ $tingkatOption }}" {{ old('tingkat', $kela->tingkat) == $tingkatOption ? 'selected' : '' }}>Tingkat {{ $tingkatOption }}</option>
                                        @endforeach

                                    </select>
                                </div>
                                @error('tingkat')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @else
                                    <small class="text-muted d-block mt-1">Pilih tingkat/level kelas yang relevan (7-13).</small>
                                @enderror
                            </div>

                        </div>
                        
                        <hr class="mt-5 mb-4 border-warning opacity-25">
                        
                        {{-- Tombol Aksi --}}
                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('admin.kelas.index') }}" class="btn btn-outline-secondary px-4 shadow-sm fw-semibold rounded-pill">
                                <i class="fas fa-times me-2"></i> Batal
                            </a>
                            <button type="submit" class="btn btn-warning px-4 shadow-lg fw-bold text-dark rounded-pill">
                                <i class="fas fa-redo me-2"></i> Update Kelas
                            </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection