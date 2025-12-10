@extends('layouts.admin')

@section('page_title', 'Pilih Kegiatan Absensi')

@section('content')

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            {{-- CARD UTAMA --}}
            <div class="card shadow mb-4 border-left-warning rounded-4"> {{-- Tambahkan border-left-warning --}}
                <div class="card-header py-3 bg-warning text-dark d-flex flex-column flex-md-row justify-content-between align-items-md-center rounded-top-4">
                    <h7 class="m-0 font-weight-bold text-dark fs-5 mb-2 mb-md-0">
                        <i class="fas fa-school me-1"></i> Kegiatan untuk Kelas {{ $kelas_nama }}
                    </h7>
                    <span class="badge bg-light text-dark shadow-sm rounded-pill px-3 py-2 fw-semibold">
                        <i class="fas fa-calendar-alt me-1"></i> Tanggal:{{ $date }}
                    </span>
                </div>
                
                <div class="card-body p-4">
                    
                    {{-- Tombol Ganti Kelas (Diperhalus) --}}
                    <a href="{{ route('admin.absensi_baru.index') }}" class="btn btn-sm btn-outline-secondary mb-4 rounded-pill px-3 fw-semibold">
                        <i class="fas fa-arrow-left me-1"></i> Ganti Kelas
                    </a>
                    
                    <p class="text-info small border-bottom pb-3 mb-4 fw-semibold">
                        <i class="fas fa-info-circle me-1"></i> Pilih kategori kegiatan, lalu klik pada kegiatan spesifik di bawah ini untuk memulai input absensi.
                    </p>
                    
                    <div class="row g-3 g-md-4"> {{-- Gunakan g-3/g-4 untuk kerapian mobile --}}
                        @forelse ($activities as $jenis => $kegiatanList)
                            {{-- Responsivitas: 1 kolom di mobile, 2 di tablet, 3 di desktop --}}
                            <div class="col-lg-4 col-md-6 col-12"> {{-- col-12 memastikan 1 kolom penuh di mobile --}}
                                @php
                                    // SINKRONISASI: Penentuan warna border berdasarkan Jenis Kegiatan
                                    $borderColor = match ($jenis) {
                                        'Sholat' => 'primary', // Biru
                                        'Mengaji & Formal' => 'success', // Hijau
                                        'Lainnya' => 'info', // Biru Muda
                                        default => 'secondary',
                                    };
                                @endphp
                                
                                {{-- Card Kategori Kegiatan --}}
                                <div class="card h-100 shadow-sm border-0 border-start border-{{ $borderColor }} card-hover rounded-4"> {{-- shadow-lg diubah menjadi shadow-sm --}}
                                    <div class="card-body p-3 p-md-4"> {{-- Padding dikurangi di mobile --}}
                                        <h5 class="card-title font-weight-bold text-{{ $borderColor }} mb-3 pb-2 border-bottom border-{{ $borderColor }} fs-6"> {{-- Ukuran Judul Kategori dikecilkan (fs-6) --}}
                                            <i class="fas fa-layer-group me-2"></i> {{ $jenis }}
                                        </h5>
                                        
                                        <div class="list-group list-group-flush">
                                            @foreach ($kegiatanList as $kegiatan_spesifik => $icon)
                                                {{-- Tombol Kegiatan Spesifik --}}
                                                <a href="{{ 
                                                        route('admin.absensi_baru.create', [
                                                            'kelas' => $kelas_id,
                                                            'kegiatan_spesifik' => $kegiatan_spesifik 
                                                        ]) 
                                                    }}" 
                                                    class="list-group-item list-group-item-action py-2 px-0 d-flex justify-content-between align-items-center fw-medium text-sm"> {{-- Padding vertikal & horizontal dikurangi, teks dikecilkan --}}
                                                    <div class="text-truncate">
                                                        <i class="{{ $icon }} me-2 text-{{ $borderColor }}"></i> 
                                                        <span>{{ $kegiatan_spesifik }}</span>
                                                    </div>
                                                    <i class="fas fa-chevron-right small text-{{ $borderColor }}"></i> {{-- Ikon panah diubah --}}
                                                </a>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="col-12">
                                <div class="alert alert-warning text-center py-5 rounded-3 border-dashed">
                                    <i class="fas fa-exclamation-triangle fa-2x mb-2"></i>
                                    <h5 class="fw-bold">Tidak Ada Kegiatan Tersedia</h5>
                                    <p class="mb-0">Mohon pastikan daftar kegiatan sudah dikonfigurasi di sistem.</p>
                                </div>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('css')
<style>
    /* Custom utility class untuk teks kecil (jika tidak ada di template) */
    .text-sm {
        font-size: 0.875rem !important; /* Ukuran default small/text-sm Bootstrap */
    }
    
    /* Efek Hover untuk Kartu Kategori */
    .card-hover:hover {
        transform: translateY(-3px); /* Efek hover dibuat lebih halus */
        box-shadow: 0 5px 10px rgba(0, 0, 0, 0.1) !important; /* Bayangan dibuat lebih tipis */
        transition: all 0.3s ease-in-out;
    }
    
    /* Efek Hover untuk Item Kegiatan */
    .list-group-item-action:hover {
        background-color: #f8f9fa; /* Lebih ringan dari default */
    }
    
    /* Perbaikan Visual List Group Item */
    .list-group-item {
        border-color: #f3f3f3; /* Membuat garis pemisah lebih samar */
    }

     /* Dashed border for empty state */
    .border-dashed {
        border: 2px dashed #ffc107 !important;
        padding: 2rem;
    }
    
    /* Penyesuaian Mobile: Mengatasi kolom penuh */
    @media (max-width: 767px) {
        .col-12 {
            width: 100%;
        }
        /* Memastikan padding di card body minimal di mobile */
        .card-body {
            padding: 1.25rem !important; 
        }
        .list-group-item-action {
             font-size: 0.85rem !important; /* Teks kegiatan sedikit dikecilkan di mobile */
        }
    }
</style>
@endpush

@endsection