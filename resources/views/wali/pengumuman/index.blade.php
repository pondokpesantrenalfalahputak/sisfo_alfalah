@extends('layouts.wali')

@section('title', 'Semua Pengumuman')
@section('page_title', 'Semua Pengumuman')

@section('content')

    <div class="row">
        <div class="col-12">
            <div class="card shadow-lg border-0 rounded-4">
                <div class="card-header bg-primary text-white fw-bold d-flex align-items-center p-3 rounded-top-4">
                    <i class="fas fa-bullhorn me-2 fa-lg"></i> Daftar Pengumuman
                </div>
                <div class="card-body p-4">
                    
                    @forelse ($pengumumen as $pengumuman)
                        @php
                            // Tentukan warna border berdasarkan kategori (Contoh sederhana)
                            $borderColor = 'border-info'; // Default
                            if (stripos($pengumuman->kategori, 'Penting') !== false) {
                                $borderColor = 'border-danger';
                            } elseif (stripos($pengumuman->kategori, 'Keuangan') !== false) {
                                $borderColor = 'border-warning';
                            }
                        @endphp

                        {{-- CARD PENGUMUMAN --}}
                        <div class="card mb-4 shadow-sm border-start border-4 {{ $borderColor }} position-relative overflow-hidden hover-effect rounded-3">
                            
                            {{-- Link Overlay --}}
                            <a href="{{ route('wali.pengumuman.show', $pengumuman) }}" class="stretched-link" aria-label="Baca selengkapnya tentang {{ $pengumuman->judul }}"></a>

                            <div class="card-body p-3 p-md-4">
                                
                                <div class="d-flex justify-content-between align-items-start mb-2">
                                    
                                    <div class="flex-grow-1 me-3">
                                        {{-- KATEGORI DAN TANGGAL MOBILE --}}
                                        <div class="d-flex align-items-center mb-1 flex-wrap">
                                            @if ($pengumuman->kategori)
                                                <span class="badge bg-primary fw-bold me-2 mb-1">{{ $pengumuman->kategori }}</span>
                                            @endif
                                            
                                            <span class="text-muted small d-md-none mb-1">
                                                <i class="fas fa-calendar-alt me-1"></i> {{ $pengumuman->tanggal_publikasi->translatedFormat('d M Y') }}
                                            </span>
                                        </div>
                                        
                                        {{-- JUDUL --}}
                                        <h5 class="fw-bolder text-dark mb-0 lh-sm fs-5"> 
                                            {{ $pengumuman->judul }}
                                        </h5>
                                    </div>
                                    
                                    {{-- TANGGAL PUBLIKASI DESKTOP --}}
                                    <span class="text-muted small flex-shrink-0 d-none d-md-block mt-1 text-end">
                                        <i class="fas fa-calendar-alt me-1"></i> <br class="d-none d-lg-block"> {{ $pengumuman->tanggal_publikasi->translatedFormat('d F Y') }}
                                    </span>
                                </div>
                                
                                {{-- RINGKASAN ISI --}}
                                <p class="text-secondary mt-2 mb-2 small text-truncate-3-lines"> 
                                    {{ Str::limit(strip_tags($pengumuman->isi), 180, '...') }} 
                                </p>
                                
                                {{-- INDIKATOR AKSI --}}
                                <small class="text-primary fw-semibold d-block mt-2">
                                    <i class="fas fa-book-open me-1"></i> Ketuk untuk Baca Selengkapnya
                                </small>
                            </div>
                        </div>
                        
                    @empty
                        <div class="alert alert-info text-center py-5 rounded-3 border-0 shadow-sm">
                            <h5 class="mb-2 fw-bold"><i class="fas fa-info-circle me-2 fa-2x"></i></h5>
                            <p class="mb-0 fw-bold fs-6">Tidak Ada Pengumuman Aktif Saat Ini</p>
                            <p class="small text-secondary mb-0">Mohon cek kembali di lain waktu untuk informasi terbaru dari lembaga.</p>
                        </div>
                    @endforelse
                </div>
                
                {{-- FOOTER untuk PAGINATION --}}
                @if (method_exists($pengumumen, 'links'))
                    <div class="card-footer bg-light p-3 rounded-bottom-4">
                        <div class="d-flex justify-content-center">
                            {{ $pengumumen->links('pagination::bootstrap-5') }}
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    {{-- CSS KUSTOM --}}
    @push('styles')
    <style>
        .hover-effect:hover {
            border-color: var(--bs-primary) !important;
            background-color: #f8f9fa !important; /* light grey background */
            transition: all 0.2s ease-in-out;
            transform: translateY(-1px); /* slight lift */
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1) !important;
            cursor: pointer;
        }
        .stretched-link {
            z-index: 1;
        }
        /* Style untuk membatasi ringkasan isi pengumuman hingga 3 baris di mobile */
        .text-truncate-3-lines {
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden;
            text-overflow: ellipsis;
        }
    </style>
    @endpush
@endsection