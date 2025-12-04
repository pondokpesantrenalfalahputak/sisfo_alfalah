@extends('layouts.admin')

@section('title', 'Edit Pengumuman')
@section('page_title', 'Edit Pengumuman: ' . $pengumuman->judul)

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

            <h2 class="mb-4 text-dark fw-bold">📝 Edit Pengumuman</h2>

            {{-- Menambahkan border-start untuk visual 'Edit' --}}
            <div class="card shadow-lg border-0 rounded-4 border-start border-5 border-warning">
                
                {{-- HEADER CARD DENGAN WARNA PRIMER --}}
                <div class="card-header bg-primary text-white p-4 rounded-top-4">
                    <h4 class="mb-0 fw-bold fs-5"><i class="fas fa-edit me-2"></i> Formulir Edit Pengumuman</h4>
                    <p class="text-white-50 small mb-0">Lakukan perubahan pada detail dan status publikasi pengumuman {{ $pengumuman->judul }}.</p>
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

                    <form action="{{ route('admin.pengumuman.update', $pengumuman) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="row g-4">
                            
                            {{-- Judul Pengumuman --}}
                            <div class="col-12">
                                <label for="judul" class="form-label fw-semibold">Judul Pengumuman <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-heading"></i></span>
                                    <input type="text" name="judul" id="judul" 
                                           class="form-control form-control-lg @error('judul') is-invalid @enderror" 
                                           placeholder="Judul Pengumuman" value="{{ old('judul', $pengumuman->judul) }}" required>
                                    @error('judul')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                            </div>
                            
                            {{-- Isi Pengumuman (Textarea) --}}
                            <div class="col-12">
                                <label for="isi" class="form-label fw-semibold">Isi Pengumuman <span class="text-danger">*</span></label>
                                <textarea name="isi" id="isi" 
                                          class="form-control @error('isi') is-invalid @enderror" 
                                          placeholder="Tuliskan isi detail pengumuman di sini..." 
                                          rows="8" required>{{ old('isi', $pengumuman->isi) }}</textarea>
                                @error('isi')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                <small class="form-text text-muted">Isi pengumuman akan ditampilkan kepada Wali Santri.</small>
                            </div>

                            {{-- TANGGAL PUBLIKASI --}}
                            <div class="col-md-4 col-sm-6">
                                <label for="tanggal_publikasi" class="form-label fw-semibold">Tanggal Publikasi <span class="text-danger">*</span></label>
                                <div class="input-group input-group-lg">
                                    <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                                    @php
                                        // Mengubah objek Carbon atau string menjadi format Y-m-d untuk input type="date"
                                        $tanggalPublikasiValue = $pengumuman->tanggal_publikasi ? 
                                            \Carbon\Carbon::parse($pengumuman->tanggal_publikasi)->format('Y-m-d') : 
                                            date('Y-m-d');
                                    @endphp
                                    <input type="date" name="tanggal_publikasi" id="tanggal_publikasi" 
                                           class="form-control @error('tanggal_publikasi') is-invalid @enderror" 
                                           value="{{ old('tanggal_publikasi', $tanggalPublikasiValue) }}" required>
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
                                           placeholder="Cth: Keuangan, Akademik" 
                                           value="{{ old('kategori', $pengumuman->kategori) }}">
                                    @error('kategori')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                            </div>

                            {{-- STATUS PUBLIKASI --}}
                            <div class="col-md-4 col-12">
                                <label for="status" class="form-label fw-semibold">Status Publikasi <span class="text-danger">*</span></label>
                                <div class="input-group input-group-lg">
                                    <span class="input-group-text"><i class="fas fa-broadcast-tower"></i></span>
                                    <select name="status" id="status" class="form-select @error('status') is-invalid @enderror" required>
                                        <option value="draft" {{ old('status', $pengumuman->status) == 'draft' ? 'selected' : '' }}>Draft (Tidak Tampil)</option>
                                        <option value="published" {{ old('status', $pengumuman->status) == 'published' ? 'selected' : '' }}>Published (Tampil di Wali)</option>
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
                            <button type="submit" class="btn btn-warning px-4 shadow-lg fw-bold text-dark rounded-pill">
                                <i class="fas fa-redo-alt me-2"></i> Update Pengumuman
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection