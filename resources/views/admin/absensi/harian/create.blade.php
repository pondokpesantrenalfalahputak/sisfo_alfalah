@extends('layouts.admin')

@section('page_title', 'Input Absensi ' . $kelas_nama . ' - ' . $kegiatan_spesifik)

@php use Carbon\Carbon; @endphp

@section('content')

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <h2 class="mb-4 text-dark">📝 Input Absensi Harian <span class="badge bg-danger ms-2 fs-6 rounded-pill shadow-sm">Langkah 3</span></h2>
            
            {{-- Pesan Error (Diperlukan untuk menampilkan pesan Duplikasi dari Controller) --}}
            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-triangle me-2"></i> {!! session('error') !!}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="card shadow mb-4 border-left-danger rounded-4">
                <div class="card-header py-3 bg-danger text-white d-flex justify-content-between align-items-center rounded-top-4">
                    <h5 class="m-0 font-weight-bold text-white">
                        Absensi {{ $kegiatan_spesifik }} | Kelas {{ $kelas_nama }}
                    </h5>
                    <small class="badge bg-light text-dark shadow-sm rounded-pill px-3 py-2">Tanggal: {{ $date }}</small>
                </div>
                
                <div class="card-body p-4">
                    {{-- Tombol Ganti Kegiatan --}}
                    <a href="{{ route('admin.absensi_baru.select_activity', $kelas_id) }}" class="btn btn-sm btn-outline-secondary mb-4 rounded-pill">
                        <i class="fas fa-chevron-left me-1"></i> Ganti Kegiatan
                    </a>

                    <p class="text-muted small border-bottom pb-3 mb-4">Pilih status kehadiran (Hadir/Sakit/Izin/Alfa) untuk setiap santri di kelas ini.</p>

                    {{-- Formulir Absensi --}}
                    <form action="{{ route('admin.absensi_baru.store') }}" method="POST">
                        @csrf
                        
                        {{-- Hidden inputs --}}
                        <input type="hidden" name="kelas_id" value="{{ $kelas_id }}">
                        <input type="hidden" name="kegiatan_spesifik" value="{{ $kegiatan_spesifik }}">
                        {{-- Mengambil tanggal hari ini dari PHP/Controller --}}
                        <input type="hidden" name="tanggal_absensi" value="{{ Carbon::now()->toDateString() }}">

                        {{-- === 1. TAMPILAN DESKTOP (TABLE) === --}}
                        <div class="table-responsive d-none d-md-block"> 
                            <table class="table table-bordered table-hover table-sm" id="absensiTable" width="100%" cellspacing="0">
                                <thead class="text-center table-light">
                                    <tr>
                                        <th rowspan="2" class="align-middle" style="width: 5%;">#</th>
                                        <th rowspan="2" class="align-middle text-start" style="min-width: 150px;">Nama Santri (NISN)</th>
                                        <th colspan="4" class="align-middle fw-bold">Status Kehadiran</th>
                                        <th rowspan="2" class="align-middle" style="min-width: 150px;">Keterangan (Opsional)</th>
                                    </tr>
                                    <tr class="fw-normal">
                                        <th style="width: 7%;"><i class="fas fa-check-circle text-success"></i> Hadir</th>
                                        <th style="width: 7%;"><i class="fas fa-bed text-warning"></i> Sakit</th>
                                        <th style="width: 7%;"><i class="fas fa-user-clock text-info"></i> Izin</th>
                                        <th style="width: 7%;"><i class="fas fa-times-circle text-danger"></i> Alfa</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($santri as $index => $s)
                                    @php 
                                        // Set default Hadir untuk semua santri
                                        $defaultKehadiran = 'Hadir'; 
                                    @endphp
                                    <tr>
                                        <td class="text-center align-middle">{{ $index + 1 }}</td>
                                        <td class="align-middle fw-semibold">{{ $s->nama_lengkap }}<br><small class="text-muted fw-normal">({{ $s->nisn ?? '-' }})</small></td>
                                        
                                        @foreach (['Hadir', 'Sakit', 'Izin', 'Alfa'] as $status)
                                            <td class="text-center align-middle">
                                                <input class="form-check-input" type="radio" 
                                                       name="kehadiran[{{ $s->id }}]" value="{{ $status }}" 
                                                       {{ ($status == $defaultKehadiran) ? 'checked' : '' }} required>
                                            </td>
                                        @endforeach
                                        
                                        <td class="align-middle">
                                            <input type="text" class="form-control form-control-sm" 
                                                   name="keterangan[{{ $s->id }}]" 
                                                   placeholder="Wajib diisi jika S/I/A..." maxlength="100">
                                        </td>
                                    </tr>
                                    @empty
                                    <tr><td colspan="7" class="text-center py-4 bg-light"><i class="fas fa-exclamation-triangle me-2 text-warning"></i> Tidak ada data santri untuk kelas ini.</td></tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        
                        {{-- === 2. TAMPILAN MOBILE (LIST CARD) === --}}
                        <div class="d-md-none">
                            <div class="list-group">
                                @forelse ($santri as $index => $s)
                                    @php $defaultKehadiran = 'Hadir'; @endphp
                                    <div class="list-group-item list-group-item-action mb-3 shadow-sm rounded-3 p-3">
                                        <div class="d-flex w-100 justify-content-between">
                                            <h6 class="mb-1 fw-bold text-dark">{{ $index + 1 }}. {{ $s->nama_lengkap }}</h6>
                                            <small class="text-muted">NISN: {{ $s->nisn ?? '-' }}</small>
                                        </div>
                                        
                                        <div class="mt-3">
                                            <p class="mb-2 small fw-semibold">Status Kehadiran:</p>
                                            <div class="btn-group btn-group-sm w-100" role="group" aria-label="Status Kehadiran">
                                                @foreach (['Hadir', 'Sakit', 'Izin', 'Alfa'] as $status)
                                                    @php
                                                        $statusClass = match ($status) {
                                                            'Hadir' => 'btn-outline-success',
                                                            'Sakit' => 'btn-outline-warning',
                                                            'Izin' => 'btn-outline-info',
                                                            'Alfa' => 'btn-outline-danger',
                                                        };
                                                    @endphp
                                                    <input type="radio" class="btn-check" 
                                                           name="kehadiran[{{ $s->id }}]" 
                                                           id="mobile-{{ $s->id }}-{{ $status }}" 
                                                           value="{{ $status }}" 
                                                           {{ ($status == $defaultKehadiran) ? 'checked' : '' }} 
                                                           required>
                                                    <label class="btn {{ $statusClass }} flex-fill" 
                                                           for="mobile-{{ $s->id }}-{{ $status }}">{{ $status[0] }}</label>
                                                @endforeach
                                            </div>
                                        </div>

                                        <div class="mt-3">
                                            <input type="text" class="form-control form-control-sm" 
                                                   name="keterangan[{{ $s->id }}]" 
                                                   placeholder="Keterangan (Wajib jika S/I/A)..." 
                                                   maxlength="100">
                                        </div>
                                    </div>
                                @empty
                                    <div class="alert alert-warning text-center py-4">Tidak ada data santri untuk kelas ini.</div>
                                @endforelse
                            </div>
                        </div>


                        {{-- Tombol Submit (Sticky di Mobile) --}}
                        <div class="d-grid mt-4 sticky-bottom-custom p-3 bg-white border-top shadow-lg">
                            <button type="submit" class="btn btn-danger btn-lg shadow-sm rounded-pill">
                                <i class="fas fa-save me-2"></i> SIMPAN ABSENSI {{ strtoupper($kegiatan_spesifik) }}
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
        /* Tambahkan padding di bawah konten agar tidak tertutup tombol */
        .card-body {
            padding-bottom: 90px !important; 
        }
        /* Styling untuk radio button group di mobile */
        .btn-check:checked + .btn-outline-success,
        .btn-check:checked + .btn-outline-warning,
        .btn-check:checked + .btn-outline-info,
        .btn-check:checked + .btn-outline-danger {
            color: #fff;
        }
        .btn-check:checked + .btn-outline-success { background-color: #198754; border-color: #198754; }
        .btn-check:checked + .btn-outline-warning { background-color: #ffc107; border-color: #ffc107; color: #000; }
        .btn-check:checked + .btn-outline-info { background-color: #0dcaf0; border-color: #0dcaf0; color: #000; }
        .btn-check:checked + .btn-outline-danger { background-color: #dc3545; border-color: #dc3545; }
    }
</style>
@endpush

@endsection