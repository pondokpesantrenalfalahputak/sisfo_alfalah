@extends('layouts.wali')

@section('title', 'Semua Pengumuman')
@section('page_title', 'Semua Pengumuman')

@section('content')

    <div class="row justify-content-center">
        <div class="col-lg-10 col-xl-9">
            <div class="card shadow-lg border-0 rounded-4 overflow-hidden">
                
                {{-- CARD HEADER DENGAN GRADIENT & IKON --}}
                <div class="card-header bg-primary text-white fw-bold d-flex align-items-center p-3">
                    <i class="fas fa-bullhorn me-2 fa-lg"></i> Daftar Pengumuman
                </div>
                
                <div class="card-body p-3 p-md-4">
                    
                    @forelse ($pengumumen as $pengumuman)
                        @php
                            // Tentukan warna dan ikon berdasarkan kategori
                            $colorClass = 'primary';
                            $iconClass = 'fas fa-info-circle';
                            
                            if (stripos($pengumuman->kategori, 'Penting') !== false) {
                                $colorClass = 'danger';
                                $iconClass = 'fas fa-exclamation-triangle';
                            } elseif (stripos($pengumuman->kategori, 'Keuangan') !== false) {
                                $colorClass = 'warning';
                                $iconClass = 'fas fa-money-bill-wave';
                            }
                            // Border color untuk penerapan border permanen
                            $borderColor = "border-$colorClass";
                        @endphp

                        {{-- PERUBAHAN: Tambahkan kelas $borderColor di sini --}}
                        <div class="card mb-4 border-0 shadow-sm hover-lift rounded-3 border-start-0 border-4 {{ $borderColor }} custom-announcement-card">
                            
                            {{-- Link Overlay --}}
                            <a href="{{ route('wali.pengumuman.show', $pengumuman) }}" class="stretched-link" aria-label="Baca selengkapnya tentang {{ $pengumuman->judul }}"></a>

                            <div class="row g-0 align-items-center">
                                
                                {{-- 1. IKON / INDIKATOR KATEGORI (KOLOM KIRI) --}}
                                <div class="col-1 d-none d-sm-flex justify-content-center align-items-center p-3">
                                    <i class="{{ $iconClass }} fa-2x text-{{ $colorClass }}" aria-hidden="true"></i>
                                </div>

                                {{-- 2. KONTEN UTAMA (KOLOM TENGAH) --}}
                                <div class="col-sm-8 col-12 p-3 p-md-4">
                                    
                                    <div class="d-flex align-items-center mb-1 flex-wrap">
                                        {{-- KATEGORI --}}
                                        @if ($pengumuman->kategori)
                                            <span class="badge bg-{{ $colorClass }} text-white fw-bold me-2 mb-1">
                                                {{ $pengumuman->kategori }}
                                            </span>
                                        @endif
                                        
                                        {{-- TANGGAL MOBILE --}}
                                        <span class="text-muted small d-sm-none mb-1">
                                            <i class="fas fa-calendar-alt me-1"></i> {{ $pengumuman->tanggal_publikasi->translatedFormat('d M Y') }}
                                        </span>
                                    </div>
                                    
                                    {{-- JUDUL --}}
                                    <h5 class="fw-bolder text-dark mb-1 lh-sm fs-5 text-truncate"> 
                                        {{ $pengumuman->judul }}
                                    </h5>
                                    
                                    {{-- RINGKASAN ISI --}}
                                    <p class="text-secondary small mb-0 text-truncate-3-lines"> 
                                        {{ Str::limit(strip_tags($pengumuman->isi), 120, '...') }} 
                                    </p>
                                </div>
                                
                                {{-- 3. TANGGAL (KOLOM KANAN, DESKTOP ONLY) --}}
                                <div class="col-sm-3 d-none d-sm-block text-end pe-4 py-3 border-start">
                                    <span class="d-block text-muted small fw-medium">Tanggal Publikasi</span>
                                    <span class="fw-bold text-dark d-block">
                                        {{ $pengumuman->tanggal_publikasi->translatedFormat('d F Y') }}
                                    </span>
                                    <small class="text-primary fw-semibold mt-2 d-block">
                                        Baca Selengkapnya <i class="fas fa-arrow-right ms-1"></i>
                                    </small>
                                </div>

                                {{-- INDIKATOR MOBILE --}}
                                <div class="col-12 d-sm-none border-top pt-2 pb-2 px-4">
                                    <small class="text-primary fw-semibold d-block">
                                        Baca Selengkapnya <i class="fas fa-chevron-right ms-1"></i>
                                    </small>
                                </div>
                            </div>
                        </div>
                        
                    @empty
                        <div class="alert alert-info text-center py-5 rounded-3 border-0 shadow-sm">
                            <h5 class="mb-2 fw-bold"><i class="fas fa-info-circle fa-2x"></i></h5>
                            <p class="mb-0 fw-bold fs-6">Tidak Ada Pengumuman Aktif Saat Ini</p>
                            <p class="small text-secondary mb-0">Mohon cek kembali di lain waktu untuk informasi terbaru dari lembaga.</p>
                        </div>
                    @endforelse
                </div>
                
                {{-- FOOTER untuk PAGINATION --}}
                @if (method_exists($pengumumen, 'links'))
                    <div class="card-footer bg-light p-3 border-top">
                        <div class="d-flex justify-content-center">
                            {{ $pengumumen->links('pagination::bootstrap-5') }}
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    @push('styles')
    <style>
        /* Efek Hover yang lebih modern */
        .hover-lift {
            transition: all 0.2s ease-in-out;
            border-left-width: 5px !important; /* Memastikan lebar border kiri 5px */
        }

        .hover-lift:hover {
            transform: translateY(-3px); 
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.15) !important;
            background-color: #fcfcfc; /* Sedikit shading saat dihover */
            cursor: pointer;
        }

        /* Style untuk membatasi ringkasan isi pengumuman hingga 3 baris */
        .text-truncate-3-lines {
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        /* Pada mobile, batasi ringkasan menjadi 2 baris agar lebih ringkas */
        @media (max-width: 575.98px) {
             .text-truncate-3-lines {
                -webkit-line-clamp: 2;
            }
        }
        .stretched-link {
            z-index: 1;
        }
    </style>
    @endpush
@endsection