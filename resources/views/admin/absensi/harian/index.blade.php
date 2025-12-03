@extends('layouts.admin')

@section('page_title', 'Pilih Kelas Absensi Harian')

@section('content')

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <h2 class="mb-4 text-dark fw-bold">🗓️ Input Absensi Harian <span class="badge bg-primary fs-6 rounded-pill shadow-sm">Langkah 1</span></h2>
            
            {{-- Pesan Sukses/Error/Warning --}}
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show rounded-3 shadow-sm" role="alert">
                    <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show rounded-3 shadow-sm" role="alert">
                    <i class="fas fa-exclamation-triangle me-2"></i> {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            @if(session('warning'))
                <div class="alert alert-warning alert-dismissible fade show rounded-3 shadow-sm" role="alert">
                    <i class="fas fa-exclamation-circle me-2"></i> {{ session('warning') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            
            <div class="card shadow mb-4 border-0 rounded-4">
                <div class="card-header py-3 bg-primary text-white d-flex justify-content-between align-items-center rounded-top-4">
                    <h5 class="m-0 font-weight-bold text-white fs-5">
                        Pilih Kelas Absensi
                    </h5>
                    <small class="badge bg-light text-dark shadow-sm rounded-pill px-3 py-2 fw-bold">
                         <i class="fas fa-calendar-alt me-1"></i> Tanggal: {{ $date }}
                    </small>
                </div>
                
                <div class="card-body p-4">
                    <p class="text-muted small border-bottom pb-3 mb-4 fw-semibold">Silakan pilih kelas yang ingin diinput absensinya untuk melanjutkan ke pemilihan kegiatan.</p>
                    
                    <div class="row g-4">
                        @forelse ($kelasList as $id => $nama)
                            @php
                                // Penentuan warna dan level berdasarkan ID
                                $color = match (true) {
                                    $id >= 4 && $id <= 6 => 'success',   // MTs (Kelas 7, 8, 9)
                                    $id >= 7 && $id <= 9 => 'info',      // MA (Kelas 10, 11, 12)
                                    $id == 10 => 'danger',              // Kelas Khusus/Tambahan
                                    default => 'secondary',
                                };
                                
                                $level = match (true) {
                                    $id >= 4 && $id <= 6 => 'MTs (Tsanawiyah)',
                                    $id >= 7 && $id <= 9 => 'MA (Aliyah)',
                                    default => 'Umum',
                                };
                            @endphp
                            
                            {{-- Card Kelas --}}
                            <div class="col-xl-3 col-lg-4 col-md-6 col-sm-12 mb-2">
                                <a href="{{ route('admin.absensi_baru.select_activity', $id) }}" class="text-decoration-none d-block">
                                    <div class="card card-hover border-0 border-start border-5 border-{{ $color }} shadow-lg h-100 rounded-3">
                                        <div class="card-body p-4">
                                            <div class="d-flex align-items-center">
                                                <div class="flex-grow-1">
                                                    <div class="font-weight-bold text-uppercase text-{{ $color }} mb-1 small">
                                                        {{ $level }}
                                                    </div>
                                                    <div class="h5 mb-0 font-weight-bold text-dark fs-4">{{ $nama }}</div>
                                                    <p class="small text-muted mt-2 mb-0 fw-semibold">Lanjutkan ke Pilih Kegiatan</p>
                                                </div>
                                                <div class="ms-3 flex-shrink-0">
                                                    {{-- Icon panah/sekolah berwarna sesuai tema --}}
                                                    <i class="fas fa-school fa-3x text-{{ $color }} opacity-75"></i>
                                                </div>
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
    /* Custom effect for hover */
    .card-hover:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 15px rgba(0, 0, 0, 0.15) !important;
        transition: all 0.3s ease-in-out;
    }
    /* Dashed border for empty state */
    .border-dashed {
        border: 2px dashed #ffc107 !important;
    }
</style>
@endpush

@endsection