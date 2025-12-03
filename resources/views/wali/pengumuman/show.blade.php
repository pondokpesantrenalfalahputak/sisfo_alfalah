@extends('layouts.wali')

@section('title', $pengumuman->judul)
@section('page_title', 'Detail Pengumuman')

@section('content')

    @php
        // Tentukan warna border berdasarkan kategori (Contoh sederhana)
        $borderColor = 'border-info'; // Default
        if (stripos($pengumuman->kategori, 'Penting') !== false) {
            $borderColor = 'border-danger';
        } elseif (stripos($pengumuman->kategori, 'Keuangan') !== false) {
            $borderColor = 'border-warning';
        }
    @endphp

    <div class="card shadow-lg border-0 mb-4 rounded-4 border-start border-5 {{ $borderColor }}">
        
        {{-- CARD HEADER: Menampilkan nama halaman dan tombol aksi penting --}}
        <div class="card-header bg-primary text-white p-3 d-flex justify-content-between align-items-center rounded-top-4">
            <div class="d-flex align-items-center">
                <i class="fas fa-bullhorn me-2 fa-lg"></i>
                <span class="fw-bold">Detail Pengumuman</span>
            </div>
            
            {{-- Tombol Kembali diletakkan di Header untuk Akses Cepat --}}
            <a href="{{ route('wali.pengumuman.index') }}" class="btn btn-sm btn-light text-primary shadow-sm ms-auto rounded-pill px-3">
                <i class="fas fa-arrow-left me-1"></i> Kembali
            </a>
        </div>
        
        <div class="card-body p-4">
            
            {{-- JUDUL PENGUMUMAN DIBUAT SANGAT BESAR DAN TEBAL --}}
            <h1 class="fw-bolder text-dark mb-4 fs-3 border-bottom pb-2">{{ $pengumuman->judul }}</h1>
            
            {{-- HEADER INFO: Kategori dan Tanggal (Lebih mudah dipindai) --}}
            <div class="d-flex flex-wrap gap-3 align-items-center mb-4">
                
                {{-- Kategori Pengumuman --}}
                <span class="badge bg-primary fw-bold py-2 px-3 fs-6">
                    <i class="fas fa-tag me-1"></i> {{ $pengumuman->kategori ?? 'Umum' }}
                </span>

                {{-- Tanggal Publikasi --}}
                <span class="text-muted small py-2">
                    <i class="fas fa-calendar-alt me-1 text-secondary"></i> Dipublikasikan: 
                    <span class="fw-semibold text-dark">{{ $pengumuman->tanggal_publikasi->translatedFormat('d F Y H:i') }}</span>
                </span>
            </div>
            
            {{-- KONTEN UTAMA (ISI PENGUMUMAN) --}}
            {{-- Tambahkan styling khusus untuk memastikan konten HTML terlihat rapi --}}
            <div class="pengumuman-content mb-5 fs-6 text-dark lh-base p-3 border rounded bg-light-subtle">
                {!! $pengumuman->isi !!}
            </div>
            
            <hr class="my-4">
            
            {{-- TOMBOL KEMBALI DI BAGIAN BAWAH (Dibuat lebih menonjol) --}}
             <a href="{{ route('wali.pengumuman.index') }}" class="btn btn-secondary w-100 w-md-auto btn-lg shadow rounded-pill px-4">
                <i class="fas fa-list me-2"></i> Lihat Semua Pengumuman
            </a>
        </div>
    </div>

    @push('css')
    <style>
        /* CSS untuk memperbaiki tampilan konten Rich Text di dalam pengumuman */
        .pengumuman-content img {
            max-width: 100%;
            height: auto;
            border-radius: 8px;
            margin: 10px 0;
            display: block; /* Memastikan gambar blok */
        }
        .pengumuman-content table {
            width: 100% !important;
            max-width: 100%;
            border-collapse: collapse;
            margin-bottom: 1rem;
            display: block;
            overflow-x: auto; /* Memastikan tabel responsif */
        }
        .pengumuman-content table td, 
        .pengumuman-content table th {
            border: 1px solid #dee2e6;
            padding: 8px;
            font-size: small;
        }
        .pengumuman-content ul,
        .pengumuman-content ol {
            padding-left: 20px;
            margin-bottom: 1rem;
        }
        .pengumuman-content h2, 
        .pengumuman-content h3, 
        .pengumuman-content h4 {
            margin-top: 1.5rem;
            margin-bottom: 0.5rem;
            font-weight: bold;
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .pengumuman-content {
                font-size: 0.95rem;
                padding: 10px;
            }
        }
    </style>
    @endpush
@endsection