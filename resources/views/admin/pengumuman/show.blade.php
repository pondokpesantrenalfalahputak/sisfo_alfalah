@extends('layouts.admin')

@section('title', 'Detail Pengumuman')
@section('page_title', 'Pengumuman: ' . $pengumuman->judul)

@section('header_actions')
    {{-- Tombol Aksi di Header (Desktop Only) --}}
    <div class="d-none d-md-flex align-items-center gap-2">
        <a href="{{ route('admin.pengumuman.edit', $pengumuman) }}" class="btn btn-warning shadow-sm fw-semibold rounded-pill px-3">
            <i class="fas fa-edit me-2"></i>
            Edit Pengumuman
        </a>
        <a href="{{ route('admin.pengumuman.index') }}" class="btn btn-outline-secondary shadow-sm fw-semibold rounded-pill px-3">
            <i class="fas fa-arrow-left me-2"></i>
            Daftar Pengumuman
        </a>
    </div>
@endsection

@section('content')

<div class="container-fluid">
    <div class="row">
        <div class="col-12">

            <h2 class="mb-4 text-dark fw-bold">📰 Detail Pengumuman</h2>

            {{-- Tombol Navigasi Alternatif di Mobile --}}
            <div class="d-flex d-md-none justify-content-between mb-3 gap-2">
                <a href="{{ route('admin.pengumuman.edit', $pengumuman) }}" class="btn btn-warning btn-sm shadow-sm flex-fill fw-bold rounded-pill">
                    <i class="fas fa-edit"></i> Edit
                </a>
                <a href="{{ route('admin.pengumuman.index') }}" class="btn btn-outline-secondary btn-sm shadow-sm flex-fill fw-bold rounded-pill">
                    <i class="fas fa-arrow-left"></i> Kembali
                </a>
            </div>

            <div class="card shadow-lg border-0 rounded-4">
                
                {{-- HEADER CARD DENGAN WARNA PRIMER --}}
                <div class="card-header bg-primary text-white p-4 rounded-top-4">
                    <h4 class="mb-0 fw-bold fs-5"><i class="fas fa-bullhorn me-2"></i> Pengumuman Pesantren</h4>
                    <p class="text-white-50 small mb-0">Informasi lengkap mengenai pengumuman: {{ $pengumuman->judul }}.</p>
                </div>
                
                <div class="card-body p-4">
                    
                    {{-- Judul Utama --}}
                    <h2 class="fw-bolder text-dark mb-4 border-bottom pb-2">{{ $pengumuman->judul }}</h2>

                    {{-- Status dan Metadata --}}
                    <h6 class="fw-bold text-dark mb-3"><i class="fas fa-info-circle me-1"></i> Informasi Publikasi</h6>
                    <div class="row g-3 mb-5">
                        
                        {{-- Status Publikasi --}}
                        <div class="col-md-4">
                            @php
                                $status = $pengumuman->status;
                                $statusClass = $status === 'published' ? 'bg-success text-white' : 'bg-secondary text-white';
                                $statusIcon = $status === 'published' ? 'fa-check-circle' : 'fa-pencil-alt';
                            @endphp
                            <div class="p-3 rounded-3 shadow-sm {{ $statusClass }}">
                                <small class="d-block fw-semibold mb-1 opacity-75">STATUS</small>
                                <h5 class="mb-0 fw-bold"><i class="fas {{ $statusIcon }} me-2"></i> {{ ucfirst($status) }}</h5>
                            </div>
                        </div>

                        {{-- Kategori --}}
                        <div class="col-md-4">
                            <div class="p-3 rounded-3 shadow-sm bg-info-subtle border border-info border-opacity-25">
                                <small class="d-block fw-semibold text-info-emphasis mb-1">KATEGORI</small>
                                <h5 class="mb-0 fw-bold text-info"><i class="fas fa-tag me-2"></i> {{ $pengumuman->kategori ?? 'Umum' }}</h5>
                            </div>
                        </div>
                        
                        {{-- Tanggal Publikasi --}}
                        <div class="col-md-4">
                             <div class="p-3 rounded-3 shadow-sm bg-primary-subtle border border-primary border-opacity-25">
                                <small class="d-block fw-semibold text-primary-emphasis mb-1">TANGGAL PUBLIKASI</small>
                                <h5 class="mb-0 fw-bold text-primary"><i class="fas fa-calendar-alt me-2"></i> {{ \Carbon\Carbon::parse($pengumuman->tanggal_publikasi)->translatedFormat('d F Y') }}</h5>
                            </div>
                        </div>
                    </div>
                    
                    {{-- Isi Pengumuman (Content Box) --}}
                    <div class="p-4 border border-primary rounded-3 bg-white shadow-sm">
                        <h5 class="fw-bold text-primary mb-3"><i class="fas fa-file-alt me-2"></i> Isi Pengumuman:</h5>
                        <div class="pengumuman-content text-dark fs-6 lh-lg border-top pt-3 mt-3">
                            {!! $pengumuman->isi !!} 
                        </div>
                    </div>
                    
                    {{-- Metadata Tambahan (Log Data) --}}
                    <h6 class="fw-bold text-secondary mt-5 mb-3"><i class="fas fa-history me-1"></i> Log Data</h6>
                    <div class="row g-3">
                        {{-- Dibuat Pada --}}
                        <div class="col-md-6">
                            <div class="p-3 bg-light rounded border shadow-sm">
                                <small class="text-muted d-block fw-semibold mb-1">Dibuat Pada</small>
                                <i class="far fa-calendar-alt me-2 text-primary"></i>
                                <span class="text-dark fw-semibold">{{ $pengumuman->created_at->translatedFormat('d F Y') }}</span>
                                <span class="text-muted small">({{ $pengumuman->created_at->format('H:i') }})</span>
                            </div>
                        </div>
                        
                        {{-- Terakhir Diperbarui --}}
                        <div class="col-md-6">
                             <div class="p-3 bg-light rounded border shadow-sm">
                                <small class="text-muted d-block fw-semibold mb-1">Terakhir Diperbarui</small>
                                <i class="far fa-clock me-2 text-warning"></i>
                                <span class="text-dark fw-semibold">{{ $pengumuman->updated_at->translatedFormat('d F Y') }}</span>
                                <span class="text-muted small">({{ $pengumuman->updated_at->format('H:i') }})</span>
                            </div>
                        </div>
                    </div>
                    
                </div>

                {{-- CARD FOOTER: Action Buttons --}}
                <div class="card-footer bg-light border-0 rounded-bottom-4 p-4">
                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        
                        {{-- Tombol Edit --}}
                        <a href="{{ route('admin.pengumuman.edit', $pengumuman) }}" class="btn btn-warning shadow-sm fw-bold w-100 w-md-auto text-dark rounded-pill px-4 order-md-1">
                            <i class="fas fa-edit me-2"></i> Edit Pengumuman
                        </a>
                        
                        {{-- Tombol Hapus --}}
                        <form action="{{ route('admin.pengumuman.destroy', $pengumuman) }}" method="POST" class="d-inline w-100 w-md-auto order-md-2">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger shadow-sm fw-bold w-100 rounded-pill px-4" onclick="return confirm('APAKAH ANDA YAKIN ingin menghapus pengumuman ini? Tindakan ini tidak dapat dibatalkan.')">
                                <i class="fas fa-trash me-2"></i> Hapus
                            </button>
                        </form>

                        {{-- Tombol Kembali --}}
                        <a href="{{ route('admin.pengumuman.index') }}" class="btn btn-secondary shadow-sm fw-bold w-100 w-md-auto rounded-pill px-4 order-md-3">
                            <i class="fas fa-list me-2"></i> Daftar Pengumuman
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection