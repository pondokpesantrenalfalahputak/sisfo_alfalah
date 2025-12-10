@extends('layouts.admin')

@section('page_title', 'Pilih Kelas Absensi Harian')

@section('content')

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            
            {{-- CARD UTAMA --}}
            <div class="card shadow mb-4 border-left-primary rounded-4"> {{-- border-left-primary untuk penekanan --}}
                <div class="card-header py-3 bg-primary text-white d-flex flex-column flex-md-row justify-content-between align-items-md-center rounded-top-4">
                    <span class="badge bg-light text-dark shadow-sm rounded-pill px-3 py-2 fw-semibold">
                        <i class="fas fa-calendar-alt me-1"></i> Tanggal: {{ $date }}
                    </span>
                </div>
                
                <div class="card-body p-4">
                    <p class="text-info small border-bottom pb-3 mb-4 fw-semibold">
                        <i class="fas fa-info-circle me-1"></i> Silakan pilih kelas yang ingin diinput absensinya untuk melanjutkan ke pemilihan kegiatan.
                    </p>
                    
                    {{-- Daftar Kelas dalam Grid --}}
                    <div class="row g-3 g-md-4"> {{-- Menggunakan g-3/g-4 untuk responsivitas gap --}}
                        @forelse ($kelasListData as $kelas)
                            @php
                                $tingkat = (int) $kelas->tingkat; 
                                
                                $color = match (true) {
                                    $tingkat >= 7 && $tingkat <= 9 => 'success',   // MTs
                                    $tingkat >= 10 && $tingkat <= 12 => 'info',    // MA
                                    $tingkat == 13 => 'danger',                   // Mutakhorijin
                                    default => 'secondary',
                                };
                                
                                $level = match (true) {
                                    $tingkat >= 7 && $tingkat <= 9 => 'MTs (Tsanawiyah)',
                                    $tingkat >= 10 && $tingkat <= 12 => 'MA (Aliyah)',
                                    $tingkat == 13 => 'Mutakhorijin',
                                    default => 'Tingkat Lain',
                                };
                            @endphp
                            
                            {{-- Card Kelas --}}
                            <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 col-12"> {{-- Di mobile penuh (col-12) atau setengah (col-sm-6) --}}
                                <a href="{{ route('admin.absensi_baru.select_activity', $kelas->id) }}" class="text-decoration-none d-block card-link-item">
                                    {{-- Mengubah border-start menjadi border-end untuk tampilan yang lebih modern --}}
                                    <div class="card card-hover border-0 border-end border-5 border-{{ $color }} shadow-sm h-100 rounded-4">
                                        <div class="card-body p-4 d-flex align-items-center">
                                            <div class="flex-grow-1">
                                                {{-- Tingkat (Dibuat lebih kecil) --}}
                                                <div class="font-weight-bold text-uppercase text-{{ $color }} text-xs mb-1"> 
                                                    {{ $level }}
                                                </div>
                                                {{-- Nama Kelas (Teks Utama) --}}
                                                <div class="h5 mb-0 font-weight-bold text-dark fs-4 text-truncate">{{ $kelas->nama_kelas }}</div>
                                                <p class="small text-muted mt-2 mb-0 fw-semibold">
                                                    <i class="fas fa-hand-point-right me-1"></i> Klik untuk Absensi
                                                </p>
                                            </div>
                                            <div class="ms-3 flex-shrink-0">
                                                {{-- Icon panah/sekolah berwarna sesuai tema --}}
                                                <i class="fas fa-arrow-circle-right fa-2x text-{{ $color }} opacity-75 card-icon"></i>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        @empty
                            <div class="col-12">
                                <div class="alert alert-warning text-center py-5 rounded-3 border-dashed">
                                    <i class="fas fa-exclamation-triangle fa-2x mb-2"></i>
                                    <h5 class="fw-bold">Tidak Ada Kelas Aktif</h5>
                                    <p class="mb-0">Mohon pastikan data kelas sudah terdaftar dan aktif di sistem.</p>
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
    /* Custom utility class untuk teks ekstra kecil (jika tidak ada di template) */
    .text-xs {
        font-size: 0.75rem !important;
    }
    
    /* Custom effect for hover */
    .card-link-item .card-hover:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 15px rgba(0, 0, 0, 0.15) !important;
        transition: all 0.3s ease-in-out;
    }
    
    /* Ikon dan border color effect on hover */
    .card-link-item:hover .card-icon {
        transform: translateX(5px);
        transition: transform 0.3s ease;
    }

    /* Dashed border for empty state */
    .border-dashed {
        border: 2px dashed #ffc107 !important;
        padding: 2rem;
    }

    /* Penyesuaian tampilan mobile */
    @media (max-width: 767px) {
        /* Kartu di mobile tampil 2 kolom */
        .col-sm-6 {
            flex: 0 0 auto;
            width: 50%;
        }
        /* Jika ingin 1 kolom penuh di mobile, ganti col-sm-6 dengan col-12 */
        
        .card-body {
            padding: 1rem !important; /* Kurangi padding di mobile */
        }
        .fa-2x {
            font-size: 1.5em; /* Perkecil ikon di mobile */
        }
    }
</style>
@endpush

@endsection