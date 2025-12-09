@extends('layouts.wali')

@section('title', $pengumuman->judul)
@section('page_title', 'Detail Pengumuman')

@section('content')

    @php
        // --- LOGIKA KATEGORI & WARNA ---
        $colorClass = 'info'; 
        $iconClass = 'fas fa-info-circle';
        
        if (stripos($pengumuman->kategori, 'Penting') !== false) {
            $colorClass = 'danger';
            $iconClass = 'fas fa-exclamation-triangle';
        } elseif (stripos($pengumuman->kategori, 'Keuangan') !== false) {
            $colorClass = 'warning';
            $iconClass = 'fas fa-money-bill-wave';
        }
        
        $borderColor = "border-$colorClass";
        
        // --- LOGIKA FORMAT TANGGAL ---
        $formattedDate = $pengumuman->tanggal_publikasi->translatedFormat('d F Y') . ' pukul ' . $pengumuman->tanggal_publikasi->translatedFormat('H:i') . ' WIB';

        // --- URL BERBAGI (Diperlukan untuk fitur sharing) ---
        $currentUrl = url()->current(); 
        $shareText = urlencode("Pengumuman Penting: " . $pengumuman->judul . " - Selengkapnya di: $currentUrl");
        $whatsappUrl = "https://wa.me/?text=$shareText";
    @endphp

    {{-- HEADER HALAMAN DAN TOMBOL KEMBALI --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="h4 fw-bold text-dark mb-0">
            <i class="fas fa-bullhorn me-2 text-primary"></i> Detail Pengumuman
        </h2>
        {{-- Tombol Kembali --}}
        <a href="{{ route('wali.pengumuman.index') }}" class="btn btn-sm btn-outline-secondary rounded-pill px-3 shadow-sm">
            <i class="fas fa-arrow-left me-1"></i> Kembali ke Daftar
        </a>
    </div>

    <hr class="mt-0">

    {{-- STRUKTUR UTAMA KONTEN --}}
    <div class="row g-4">
        
        {{-- KOLOM KIRI (ISI PENGUMUMAN) - Diberi Aksen Warna --}}
        <div class="col-lg-8">
            {{-- Duplikasi Kartu Dihapus. Kartu Utama diberi border atas aksen warna --}}
            <div class="card shadow-lg border-0 rounded-4 border-top border-4 {{ $borderColor }}">
                <div class="card-body p-4 p-md-5">
                    
                    {{-- JUDUL UTAMA DENGAN LATAR BELAKANG HALUS --}}
                    <h1 class="fw-bolder text-dark mb-4 fs-2 pb-3 text-center bg-light px-4 py-3 rounded-3 border-bottom">
                        {{ $pengumuman->judul }}
                    </h1>
                    
                    {{-- KONTEN PENGUMUMAN --}}
                    <div class="pengumuman-content mb-5 fs-6 text-dark lh-base">
                        {!! $pengumuman->isi !!}
                    </div>
                </div>
            </div>
        </div>

        {{-- KOLOM KANAN (INFO META/SIDEBAR) --}}
        <div class="col-lg-4">
            
            {{-- Kartu Info Meta --}}
            <div class="card shadow-lg border-0 rounded-4 border-top border-4 {{ $borderColor }} mb-4">
                <div class="card-header bg-white p-3 border-bottom rounded-top-4">
                    <span class="fw-bold text-secondary small text-uppercase">Informasi Publikasi</span>
                </div>
                <div class="card-body p-4">
                    
                    {{-- Kategori --}}
                    <div class="mb-3">
                        <p class="small text-muted mb-1">
                            <i class="{{ $iconClass }} me-1 text-{{ $colorClass }}"></i> Kategori
                        </p>
                        <span class="badge bg-{{ $colorClass }} fw-bold py-2 px-3 fs-6 rounded-pill">
                            {{ $pengumuman->kategori ?? 'Umum' }}
                        </span>
                    </div>

                    <hr class="my-3">
                    
                    {{-- Tanggal Publikasi --}}
                    <div class="mb-3">
                        <p class="small text-muted mb-1">
                            <i class="fas fa-calendar-alt me-1 text-secondary"></i> Tanggal Publikasi
                        </p>
                        <p class="fw-semibold text-dark fs-6">{{ $formattedDate }}</p>
                    </div>
                </div>
            </div>

            {{-- Kartu Aksi Cepat --}}
            <div class="card shadow-sm border-0 rounded-4">
                <div class="card-body p-4">
                    <p class="fw-bold text-secondary small text-uppercase mb-3">Aksi Cepat</p>
                    
                    {{-- Tombol Cetak --}}
                    <button onclick="window.print()" class="btn btn-outline-primary w-100 btn-md rounded-pill mb-2">
                        <i class="fas fa-print me-2"></i> Cetak Pengumuman
                    </button>

                    {{-- Tombol Berbagi WhatsApp --}}
                    <a href="{{ $whatsappUrl }}" target="_blank" class="btn btn-success w-100 btn-md rounded-pill mb-3">
                        <i class="fab fa-whatsapp me-2"></i> Bagikan (WhatsApp)
                    </a>

                    <hr class="my-2">

                    {{-- Tombol Navigasi Cepat --}}
                    <a href="{{ route('wali.pengumuman.index') }}" class="btn btn-light w-100 btn-md rounded-pill mt-3 text-secondary">
                        <i class="fas fa-list me-2"></i> Lihat Semua Pengumuman
                    </a>
                </div>
            </div>
        </div>
    </div>

    <hr class="my-4">

    @push('css')
    <style>
        /* Gaya Dasar untuk Keterbacaan Konten (Rich Text) */
        .pengumuman-content p {
            margin-bottom: 1.25rem;
            line-height: 1.8;
            text-align: justify;
        }
        
        /* Gambar (Dibuat rata tengah dan responsif) */
        .pengumuman-content img {
            max-width: 100%;
            height: auto;
            border-radius: 12px;
            margin: 15px auto; 
            display: block; 
            box-shadow: 0 4px 10px rgba(0,0,0,0.1); 
        }
        
        /* Tabel (Dibuat responsif dan bersih) */
        .pengumuman-content table {
            width: 100% !important;
            max-width: 100%;
            border-collapse: collapse;
            margin-bottom: 1.5rem;
            display: block;
            overflow-x: auto; 
            border: 1px solid #e9ecef;
            border-radius: 8px;
        }
        .pengumuman-content table th {
            background-color: #f8f9fa;
            font-weight: bold;
        }
        .pengumuman-content table td, 
        .pengumuman-content table th {
            border: 1px solid #dee2e6;
            padding: 12px;
            font-size: 0.95rem;
            vertical-align: top;
        }
        
        /* List */
        .pengumuman-content ul,
        .pengumuman-content ol {
            padding-left: 30px;
            margin-bottom: 1.5rem;
            line-height: 1.8;
        }
        
        /* Heading di Dalam Konten */
        .pengumuman-content h2, 
        .pengumuman-content h3, 
        .pengumuman-content h4 {
            margin-top: 2rem;
            margin-bottom: 1rem;
            font-weight: 700;
            color: #343a40;
        }

        /* Responsif Seluler */
        @media (max-width: 767.98px) {
            .card-body {
                padding: 1.5rem !important;
            }
            .pengumuman-content {
                font-size: 1rem;
            }
            .fs-2 { 
                font-size: 1.5rem !important;
            }
        }
        
        /* Gaya untuk Cetak: Sembunyikan tombol aksi saat dicetak */
        @media print {
            .card-header, /* Sembunyikan header card meta */
            .btn, /* Sembunyikan semua tombol */
            .d-flex.justify-content-between.align-items-center.mb-4, /* Sembunyikan header page */
            hr { /* Sembunyikan semua garis pemisah */
                display: none !important;
            }
            
            .card {
                box-shadow: none !important;
                border: none !important;
            }
            
            /* Paksa kolom konten utama menempati lebar penuh saat dicetak */
            .col-lg-8 {
                width: 100%;
                max-width: 100%;
                flex: 0 0 100%;
            }
            .col-lg-4 {
                display: none; /* Sembunyikan sidebar info meta saat dicetak */
            }
            
            /* Sesuaikan padding card body agar konten cetak penuh */
            .card-body {
                padding: 0 !important;
            }
            
            /* Judul cetak lebih rapi tanpa background */
            h1.bg-light {
                background: none !important;
                border-bottom: 1px solid #ccc !important;
                padding-left: 0 !important;
                padding-right: 0 !important;
            }
            
            /* Konten lebih padat saat dicetak */
            .pengumuman-content p {
                line-height: 1.5;
                margin-bottom: 0.5rem;
            }
        }
    </style>
    @endpush
@endsection