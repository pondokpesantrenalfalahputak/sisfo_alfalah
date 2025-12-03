@extends('layouts.admin')

@section('page_title', 'Pilih Kegiatan Absensi')

@section('content')

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <h2 class="mb-4 text-dark fw-bold">📋 Pilih Kegiatan Absensi <span class="badge bg-warning fs-6 rounded-pill shadow-sm">Langkah 2</span></h2>
            
            <div class="card shadow mb-4 border-0 rounded-4">
                <div class="card-header py-3 bg-warning text-dark d-flex justify-content-between align-items-center rounded-top-4">
                    <h5 class="m-0 font-weight-bold text-dark fs-5">
                        Pilih Kegiatan untuk Kelas {{ $kelas_nama }}
                    </h5>
                    <small class="badge bg-light text-dark shadow-sm rounded-pill px-3 py-2 fw-bold">
                        <i class="fas fa-calendar-alt me-1"></i> Tanggal: {{ $date }}
                    </small>
                </div>
                
                <div class="card-body p-4">
                    
                    {{-- Tombol Ganti Kelas (Lebih menonjol) --}}
                    <a href="{{ route('admin.absensi_baru.index') }}" class="btn btn-outline-primary mb-4 rounded-pill px-4 fw-semibold">
                        <i class="fas fa-arrow-alt-circle-left me-1"></i> Ganti Kelas
                    </a>
                    
                    <p class="text-muted small border-bottom pb-3 mb-4 fw-semibold">Pilih kategori kegiatan, lalu klik pada kegiatan spesifik di bawah ini untuk memulai input absensi.</p>
                    
                    <div class="row g-4">
                        @forelse ($activities as $jenis => $kegiatanList)
                            {{-- Responsivitas: 1 kolom di mobile, 2 di tablet, 3 di desktop --}}
                            <div class="col-lg-4 col-md-6 mb-2">
                                @php
                                    // Penentuan warna border berdasarkan urutan loop
                                    $borderColor = match ($loop->iteration % 3) {
                                        1 => 'primary',
                                        2 => 'success',
                                        0 => 'info',
                                        default => 'secondary',
                                    };
                                @endphp
                                
                                <div class="card h-100 shadow-lg border-0 border-start border-4 border-{{ $borderColor }} card-hover rounded-3">
                                    <div class="card-body p-4">
                                        <h5 class="card-title font-weight-bold text-{{ $borderColor }} mb-3 pb-2 border-bottom border-{{ $borderColor }}">
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
                                                    class="list-group-item list-group-item-action py-3 d-flex justify-content-between align-items-center fw-medium">
                                                    <div>
                                                        <i class="{{ $icon }} me-2 text-{{ $borderColor }}"></i> 
                                                        <span>{{ $kegiatan_spesifik }}</span>
                                                    </div>
                                                    <i class="fas fa-arrow-right small text-{{ $borderColor }}"></i>
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
    /* Efek Hover untuk Kartu Kategori */
    .card-hover:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 15px rgba(0, 0, 0, 0.15) !important;
        transition: all 0.3s ease-in-out;
    }
    /* Efek Hover untuk Item Kegiatan */
    .list-group-item-action:hover {
        background-color: #e9ecef; /* Slightly darker than default hover */
    }
     /* Dashed border for empty state */
    .border-dashed {
        border: 2px dashed #ffc107 !important;
    }
</style>
@endpush

@endsection