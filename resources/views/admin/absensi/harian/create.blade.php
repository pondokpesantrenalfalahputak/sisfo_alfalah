@extends('layouts.admin')

@section('page_title', 'Input Absensi ' . $kelas_nama . ' - ' . $kegiatan_spesifik)

@php use Carbon\Carbon; @endphp

@section('content')

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            
            {{-- Pesan Error --}}
            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show small" role="alert">
                    <i class="fas fa-exclamation-triangle me-2"></i> {!! session('error') !!}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            {{-- CARD UTAMA ABSENSI --}}
            {{-- WARNA BORDER DIUBAH DARI DANGER MENJADI PRIMARY --}}
            <div class="card shadow mb-4 border-start border-primary border-5 rounded-4"> 
                
                {{-- HEADER CARD --}}
                {{-- WARNA HEADER DIUBAH DARI DANGER MENJADI PRIMARY --}}
                <div class="card-header bg-primary text-white d-flex flex-column flex-md-row justify-content-between align-items-md-center p-3 rounded-top-4">
                    <div>
                        <h6 class="m-0 font-weight-bold fs-6">
                            Absensi {{ $kegiatan_spesifik }} | Kelas {{ $kelas_nama }}
                        </h6>
                    </div>
                    <span class="badge bg-light text-dark shadow-sm rounded-pill px-3 py-1 mt-2 mt-md-0 small">
                        <i class="fas fa-calendar-alt me-1"></i> Tanggal:{{ $date }}
                    </span>
                </div>
                
                <div class="card-body p-4 pt-3">
                    <p class="text-muted small border-bottom pb-2 mb-3"><i class="fas fa-info-circle me-1"></i> Pilih status kehadiran (H/S/I/A) untuk setiap santri.</p>

                    {{-- Formulir Absensi --}}
                    <form action="{{ route('admin.absensi_baru.store') }}" method="POST">
                        @csrf
                        
                        {{-- Hidden inputs --}}
                        <input type="hidden" name="kelas_id" value="{{ $kelas_id }}">
                        <input type="hidden" name="kegiatan_spesifik" value="{{ $kegiatan_spesifik }}">
                        <input type="hidden" name="tanggal_absensi" value="{{ Carbon::now()->toDateString() }}">

                        {{-- === 1. TAMPILAN DESKTOP (TABLE) === --}}
                        <div class="table-responsive d-none d-md-block"> 
                            <table class="table table-bordered table-hover table-sm" id="absensiTable" width="100%" cellspacing="0">
                                {{-- THEAD DIUBAH DARI DANGER MENJADI PRIMARY --}}
                                <thead class="text-center table-primary text-white"> 
                                    <tr>
                                        <th rowspan="2" class="align-middle bg-primary" style="width: 5%;">#</th>
                                        <th rowspan="2" class="align-middle text-start bg-primary" style="min-width: 150px;">Nama Santri (NIS)</th>
                                        <th colspan="4" class="align-middle fw-bold bg-primary">Status Kehadiran</th>
                                        <th rowspan="2" class="align-middle bg-primary" style="min-width: 150px;">Keterangan (Opsional)</th>
                                    </tr>
                                    <tr class="fw-normal bg-light text-dark">
                                        <th style="width: 7%;"><i class="fas fa-check-circle text-success"></i> Hadir</th>
                                        <th style="width: 7%;"><i class="fas fa-bed text-warning"></i> Sakit</th>
                                        <th style="width: 7%;"><i class="fas fa-user-clock text-info"></i> Izin</th>
                                        <th style="width: 7%;"><i class="fas fa-times-circle text-danger"></i> Alfa</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($santri as $index => $s)
                                    @php $defaultKehadiran = 'Hadir'; @endphp
                                    <tr class="align-middle">
                                        <td class="text-center small">{{ $index + 1 }}</td>
                                        <td class="fw-semibold small">{{ $s->nama_lengkap }}<br><small class="text-muted fw-normal">({{ $s->nisn ?? '-' }})</small></td>
                                        
                                        @foreach (['Hadir', 'Sakit', 'Izin', 'Alfa'] as $status)
                                            <td class="text-center">
                                                <input class="form-check-input" type="radio" 
                                                       name="kehadiran[{{ $s->id }}]" value="{{ $status }}" 
                                                       {{ ($status == $defaultKehadiran) ? 'checked' : '' }} required>
                                            </td>
                                        @endforeach
                                        
                                        <td>
                                            <input type="text" class="form-control form-control-sm small" 
                                                   name="keterangan[{{ $s->id }}]" 
                                                   placeholder="Wajib diisi jika S/I/A..." maxlength="100">
                                        </td>
                                    </tr>
                                    @empty
                                    <tr><td colspan="7" class="text-center py-4 bg-light small"><i class="fas fa-exclamation-triangle me-2 text-warning"></i> Tidak ada data santri untuk kelas ini.</td></tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        
                        {{-- === 2. TAMPILAN MOBILE (LIST CARD) === --}}
                        <div class="d-md-none">
                            <div class="list-group">
                                @forelse ($santri as $index => $s)
                                    @php $defaultKehadiran = 'Hadir'; @endphp
                                    {{-- WARNA BORDER DIUBAH DARI DANGER MENJADI PRIMARY --}}
                                    <div class="list-group-item mb-2 shadow-sm rounded-3 p-3 border-start border-primary border-4"> 
                                        <div class="d-flex w-100 justify-content-between align-items-center">
                                            <p class="mb-0 fw-bold text-dark small">{{ $index + 1 }}. {{ $s->nama_lengkap }}</p>
                                            <span class="badge bg-secondary-subtle text-secondary fw-normal small">NIS: {{ $s->nisn ?? '-' }}</span>
                                        </div>
                                        <hr class="my-2">
                                        
                                        {{-- Pilihan Kehadiran --}}
                                        <div class="my-2">
                                            {{-- WARNA TEKS DIUBAH DARI DANGER MENJADI PRIMARY --}}
                                            <p class="mb-1 small fw-semibold text-primary"><i class="fas fa-bullseye me-1"></i> Status Kehadiran:</p>
                                            <div class="btn-group btn-group-sm w-100" role="group" aria-label="Status Kehadiran">
                                                @foreach (['Hadir', 'Sakit', 'Izin', 'Alfa'] as $status)
                                                    @php
                                                        $statusClass = match ($status) {
                                                            'Hadir' => 'btn-outline-success',
                                                            'Sakit' => 'btn-outline-warning',
                                                            'Izin' => 'btn-outline-info',
                                                            'Alfa' => 'btn-outline-danger', // Tetap Danger untuk Alfa/Absen
                                                        };
                                                        $statusLabel = match ($status) {
                                                            'Hadir' => 'H',
                                                            'Sakit' => 'S',
                                                            'Izin' => 'I',
                                                            'Alfa' => 'A',
                                                        };
                                                    @endphp
                                                    <input type="radio" class="btn-check" 
                                                           name="kehadiran[{{ $s->id }}]" 
                                                           id="mobile-{{ $s->id }}-{{ $status }}" 
                                                           value="{{ $status }}" 
                                                           {{ ($status == $defaultKehadiran) ? 'checked' : '' }} 
                                                           required>
                                                    <label class="btn {{ $statusClass }} flex-fill small" 
                                                           for="mobile-{{ $s->id }}-{{ $status }}">{{ $statusLabel }}</label>
                                                @endforeach
                                            </div>
                                        </div>

                                        {{-- Keterangan --}}
                                        <div class="my-2">
                                            <p class="mb-1 small text-muted"><i class="fas fa-comment-alt me-1"></i> Keterangan (Opsional):</p>
                                            <input type="text" class="form-control form-control-sm small" 
                                                   name="keterangan[{{ $s->id }}]" 
                                                   placeholder="Wajib diisi jika S/I/A..." 
                                                   maxlength="100">
                                        </div>
                                    </div>
                                @empty
                                    <div class="alert alert-warning text-center py-4 small">Tidak ada data santri untuk kelas ini.</div>
                                @endforelse
                            </div>
                        </div>


                        {{-- Tombol Submit (Sticky di Mobile) --}}
                        <div class="d-grid mt-4 sticky-bottom-custom p-3 bg-white border-top shadow-lg">
                            {{-- WARNA TOMBOL DIUBAH DARI DANGER MENJADI PRIMARY --}}
                            <button type="submit" class="btn btn-primary shadow-lg rounded-3 fw-bold"> 
                                <i class="fas fa-save me-2"></i> SIMPAN ABSENSI
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@push('css')
<style>
    /* Membuat tombol submit tetap terlihat di bagian bawah layar mobile */
    @media (max-width: 767px) {
        .sticky-bottom-custom {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            z-index: 1000;
        }
        .card-body {
            padding-bottom: 70px !important;
        }
        
        /* === PERHALUSAN WARNA STATUS PADA TOMBOL MOBILE YANG DIPILIH === */
        
        .btn-check:checked + .btn-outline-success,
        .btn-check:checked + .btn-outline-warning,
        .btn-check:checked + .btn-outline-info,
        .btn-check:checked + .btn-outline-danger {
            color: #fff; 
            font-weight: bold; 
        }

        /* Hadir (Success - Hijau) - Dibiarkan */
        .btn-check:checked + .btn-outline-success { 
            background-color: #198754; 
            border-color: #198754; 
        }

        /* Sakit (Warning - Kuning) - Diperhalus */
        .btn-check:checked + .btn-outline-warning { 
            /* Menggunakan warna Amber yang lebih tua dan tidak terlalu neon */
            background-color: #f7a31b; 
            border-color: #f7a31b; 
            color: #000; 
        }

        /* Izin (Info - Biru Muda) - Diperhalus */
        .btn-check:checked + .btn-outline-info { 
            /* Menggunakan warna Cyan yang lebih tua/muted */
            background-color: #0d8ca3; 
            border-color: #0d8ca3; 
            color: #fff; /* Teks putih untuk kontras dengan latar belakang gelap */
        }

        /* Alfa (Danger - Merah) - Dibiarkan */
        .btn-check:checked + .btn-outline-danger { 
            background-color: #dc3545; 
            border-color: #dc3545; 
        }
    }
</style>
@endpush

@endsection