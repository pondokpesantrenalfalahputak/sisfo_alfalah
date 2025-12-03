@extends('layouts.admin')

@section('title', 'Tambah Pengumuman')
@section('page_title', 'Buat Pengumuman Baru')

@section('header_actions')
    {{-- Tombol untuk kembali ke Daftar Pengumuman --}}
    <a href="{{ route('admin.pengumuman.index') }}" class="btn btn-outline-secondary shadow-sm rounded-pill d-flex align-items-center fw-semibold px-3">
        <i class="fas fa-bullhorn me-2"></i>
        Daftar Pengumuman
    </a>
@endsection

@section('content')

<div class="container-fluid">
    <div class="row">
        <div class="col-12">

            <h2 class="mb-4 text-dark fw-bold">📣 Buat Pengumuman Baru</h2>

            <div class="card shadow-lg border-0 rounded-4">
                
                {{-- HEADER CARD DENGAN WARNA PRIMER --}}
                <div class="card-header bg-primary text-white p-4 rounded-top-4">
                    <h4 class="mb-0 fw-bold fs-5"><i class="fas fa-plus-circle me-2"></i> Formulir Buat Pengumuman</h4>
                    <p class="text-white-50 small mb-0">Masukkan detail pengumuman yang akan dipublikasikan ke Wali Santri.</p>
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

                    <form action="{{ route('admin.pengumuman.store') }}" method="POST">
                        @csrf
                        
                        <div class="row g-4">
                            
                            {{-- Judul Pengumuman --}}
                            <div class="col-12">
                                <label for="judul" class="form-label fw-semibold">Judul Pengumuman <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-heading"></i></span>
                                    <input type="text" name="judul" id="judul" 
                                           class="form-control form-control-lg @error('judul') is-invalid @enderror" 
                                           placeholder="Judul Pengumuman" value="{{ old('judul') }}" required>
                                    @error('judul')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                            </div>
                            
                            {{-- Isi Pengumuman (Textarea) --}}
                            <div class="col-12">
                                <label for="isi" class="form-label fw-semibold">Isi Pengumuman <span class="text-danger">*</span></label>
                                <textarea name="isi" id="isi" 
                                          class="form-control @error('isi') is-invalid @enderror" 
                                          placeholder="Tuliskan isi detail pengumuman di sini..." 
                                          rows="8" required>{{ old('isi') }}</textarea>
                                @error('isi')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                <small class="form-text text-muted">Isi pengumuman akan ditampilkan kepada Wali Santri.</small>
                            </div>

                            {{-- TANGGAL PUBLIKASI --}}
                            <div class="col-md-4 col-sm-6">
                                <label for="tanggal_publikasi" class="form-label fw-semibold">Tanggal Publikasi <span class="text-danger">*</span></label>
                                <div class="input-group input-group-lg">
                                    <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                                    <input type="date" name="tanggal_publikasi" id="tanggal_publikasi" 
                                           class="form-control @error('tanggal_publikasi') is-invalid @enderror" 
                                           value="{{ old('tanggal_publikasi', date('Y-m-d')) }}" required>
                                    @error('tanggal_publikasi')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                            </div>

                            {{-- KATEGORI --}}
                            <div class="col-md-4 col-sm-6">
                                <label for="kategori" class="form-label fw-semibold">Kategori (Opsional)</label>
                                <div class="input-group input-group-lg">
                                    <span class="input-group-text"><i class="fas fa-tag"></i></span>
                                    <input type="text" name="kategori" id="kategori" 
                                           class="form-control @error('kategori') is-invalid @enderror" 
                                           placeholder="Cth: Keuangan, Akademik" value="{{ old('kategori') }}">
                                    @error('kategori')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                            </div>

                            {{-- STATUS PUBLIKASI --}}
                            <div class="col-md-4 col-12">
                                <label for="status" class="form-label fw-semibold">Status Publikasi <span class="text-danger">*</span></label>
                                <div class="input-group input-group-lg">
                                    <span class="input-group-text"><i class="fas fa-broadcast-tower"></i></span>
                                    <select name="status" id="status" class="form-select @error('status') is-invalid @enderror" required>
                                        <option value="draft" {{ old('status') == 'draft' ? 'selected' : '' }}>Draft (Tidak Tampil)</option>
                                        <option value="published" {{ old('status', 'published') == 'published' ? 'selected' : '' }}>Published (Tampil di Wali)</option>
                                    </select>
                                    @error('status')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                            </div>
                            
                        </div>
                        
                        <hr class="mt-5 mb-4 border-dark opacity-25">
                        
                        {{-- Tombol Aksi --}}
                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('admin.pengumuman.index') }}" class="btn btn-outline-secondary px-4 shadow-sm fw-semibold rounded-pill">
                                <i class="fas fa-times me-2"></i> Batal
                            </a>
                            <button type="submit" class="btn btn-primary px-4 shadow-lg fw-bold rounded-pill">
                                <i class="fas fa-save me-2"></i> Simpan Pengumuman
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection