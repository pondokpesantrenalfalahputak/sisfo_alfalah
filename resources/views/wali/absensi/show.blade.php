@extends('layouts.wali') 

@php use Carbon\Carbon; @endphp

@section('title', 'Absensi Harian ')
@section('page_title', 'Absensi Harian ')

@section('content')

<div class="container-fluid">
    <div class="row">
        <div class="col-12">

            {{-- HEADER SANTRI & KEMBALI --}}
            <div class="card border-0 shadow-lg mb-5 rounded-4 card-santri-detail">
                <div class="card-header bg-primary text-white d-flex flex-column flex-md-row align-items-md-center py-3 px-4 rounded-top-4">
                    <div class="d-flex align-items-center mb-2 mb-md-0">
                        <i class="fas fa-user-graduate me-3 fs-3 flex-shrink-0"></i>
                        <div>
                            <h5 class="mb-0 fw-bolder text-uppercase">{{ $santri->nama_lengkap }}</h5>
                            <small class="badge bg-light text-primary fw-semibold rounded-pill mt-1">{{ $santri->kelas->nama_kelas ?? 'Kelas N/A' }} | NIS: {{ $santri->nisn }}</small>
                        </div>
                    </div>
                    {{-- Tombol Kembali --}}
                    <a href="{{ route('wali.absensi.index') }}" class="btn btn-md btn-light text-primary ms-md-auto fw-bold rounded-pill shadow-sm mt-2 mt-md-0 action-link">
                        <i class="fas fa-chevron-left me-1"></i> Kembali ke Rekap
                    </a>
                </div>
            </div>

            {{-- FILTER TANGGAL (Modern Form Style) --}}
            <div class="card border-0 shadow-sm bg-white p-4 mb-5 rounded-4 filter-card-custom">
                <form method="GET" action="{{ route('wali.absensi.show', $santri->id) }}" class="row g-3 align-items-center">
                    <div class="col-12 mb-2">
                        <h5 class="mb-0 fw-bold text-dark">
                            <i class="fas fa-calendar-alt me-2 text-primary"></i> Pilih Tanggal Absensi
                        </h5>
                    </div>
                    
                    {{-- Input Tanggal --}}
                    <div class="col-sm-4 col-12">
                         <label for="tanggal_input" class="form-label small text-muted mb-1 d-none d-sm-block"></label>
                        <input type="date" name="tanggal" id="tanggal_input" class="form-control form-control-sm rounded-pill shadow-sm" 
                               value="{{ $dateFilter }}" max="{{ Carbon::now()->toDateString() }}">
                    </div>
                    
                    {{-- Tombol Terapkan --}}
                    <div class="col-sm-3 col-6 d-flex align-items-end">
                        <button type="submit" class="btn btn-primary btn-sm flex-fill rounded-pill shadow-md fw-semibold">
                            <i class="fas fa-search me-1"></i> Cari Data
                        </button>
                    </div>

                    {{-- Tombol Reset --}}
                    @if(request()->has('tanggal'))
                    <div class="col-sm-2 col-6 d-flex align-items-end">
                        <a href="{{ route('wali.absensi.show', $santri->id) }}" class="btn btn-outline-secondary btn-sm flex-fill rounded-pill shadow-sm">Reset</a>
                    </div>
                    @endif


                    {{-- Quick Select dari Tanggal Tersedia --}}
                    @if ($availableDates->count() > 0)
                    <div class="col-12 mt-4 border-top pt-3">
                        <p class="small text-muted mb-2 fw-semibold"><i class="fas fa-history me-1"></i> Riwayat Singkat:</p>
                        <div class="d-flex flex-wrap gap-2 quick-select-dates">
                            @foreach ($availableDates as $date)
                                @php
                                    $isActive = $date === $dateFilter ? 'btn-info text-white shadow-md' : 'btn-outline-secondary';
                                @endphp
                                <a href="{{ route('wali.absensi.show', ['santri' => $santri->id, 'tanggal' => $date]) }}" 
                                   class="btn btn-sm {{ $isActive }} rounded-pill fw-medium quick-date-item">
                                    {{ Carbon::parse($date)->translatedFormat('d M') }}
                                </a>
                            @endforeach
                        </div>
                    </div>
                    @endif
                </form>
            </div>


            {{-- JUDUL HASIL ABSENSI (REVISI: Tanggal di bawah judul, warna bg-info) --}}
            <div class="mb-4 border-bottom pb-2">
                <h5 class="fw-bold text-dark mb-1">
                    <i class="fas fa-info-circle me-2 text-primary"></i> Detail Kehadiran Harian
                </h5>
                {{-- Badge Tanggal diletakkan di baris terpisah dengan warna bg-info --}}
                <span class="badge bg-info text-white p-2 shadow-sm fs-6 fw-semibold text-nowrap title-date-mobile">
                    {{ Carbon::parse($dateFilter)->translatedFormat('l, d F Y') }}
                </span>
            </div>

            @if ($absensiHarian->isEmpty())
                <div class="alert alert-light text-center py-5 border rounded-4 shadow-sm">
                    <i class="fas fa-calendar-times me-2 fs-3 text-secondary"></i> 
                    <p class="mb-0 mt-3 fw-semibold fs-6">Tidak ditemukan data absensi untuk tanggal ini.</p>
                    <small class="text-muted">Pilih tanggal lain atau pastikan data telah diinput oleh pengurus.</small>
                </div>
            @else
                
                {{-- Logika Penentuan Warna Status (TELAH DIREVISI) --}}
                @php
                    $statusColorMap = [
                        'Hadir' => 'success', // Hijau (Sesuai permintaan)
                        'Sakit' => 'info',    // Biru/Cyan
                        'Izin' => 'warning',  // Kuning (Sesuai permintaan)
                        'Alfa' => 'danger',   // Merah (Sesuai permintaan)
                    ];
                @endphp

                {{-- === 1. TAMPILAN DESKTOP (TABLE) === --}}
                <div class="table-responsive d-none d-md-block shadow-sm rounded-4 overflow-hidden mb-5">
                    <table class="table table-bordered table-sm small table-hover align-middle table-rekap-desktop" width="100%" cellspacing="0">
                        <thead class="table-dark text-center">
                            <tr>
                                <th style="width: 5%;">#</th>
                                <th style="width: 25%;">Kegiatan Wajib</th>
                                <th style="width: 15%;">Status Kehadiran</th>
                                <th style="width: 55%;">Keterangan Pengurus</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($absensiHarian as $index => $absensi)
                                @php
                                    $statusClass = $statusColorMap[$absensi->status] ?? 'secondary';
                                    $rowClass = ($absensi->status == 'Alfa') ? 'table-danger' : '';
                                @endphp
                                <tr class="{{ $rowClass }}">
                                    <td class="text-center align-middle fw-bold">{{ $index + 1 }}</td>
                                    <td class="align-middle fw-semibold text-dark">{{ $absensi->jenis_kegiatan }}</td>
                                    <td class="text-center align-middle">
                                        <span class="badge bg-{{ $statusClass }} p-2 shadow-sm fw-bold rounded-pill status-badge">{{ $absensi->status }}</span>
                                    </td>
                                    <td class="align-middle small text-muted text-wrap">
                                        @if($absensi->keterangan)
                                            {{ $absensi->keterangan }}
                                        @else
                                            <em class="text-secondary">- Tidak ada catatan -</em>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                {{-- === 2. TAMPILAN MOBILE (LIST CARD) === --}}
                <div class="d-md-none list-group-detail-mobile mb-5">
                    <div class="list-group">
                        @foreach ($absensiHarian as $index => $absensi)
                            @php
                                $statusClass = $statusColorMap[$absensi->status] ?? 'secondary';
                                // Gunakan border start yang tebal untuk highlight status
                                $borderClass = ($absensi->status == 'Alfa') ? 'border-danger shadow-lg' : 'border-light shadow-sm';
                                $iconStatus = ($absensi->status == 'Alfa') ? 'fas fa-exclamation-triangle text-danger' : 'fas fa-clipboard-check text-success';
                            @endphp
                            
                            <div class="list-group-item list-group-item-action mb-3 p-3 rounded-4 border-start-5 border-start-{{ $statusClass }} {{ $borderClass }} list-item-custom">
                                
                                {{-- Baris 1: Judul Kegiatan & Status --}}
                                <div class="d-flex w-100 justify-content-between align-items-center mb-2">
                                    <h6 class="mb-0 fw-bold text-dark flex-grow-1 text-truncate">
                                        {{ $index + 1 }}. {{ $absensi->jenis_kegiatan }}
                                    </h6>
                                    <span class="badge bg-{{ $statusClass }} py-2 px-3 fw-bold rounded-pill shadow-sm status-badge-mobile ms-2 flex-shrink-0">
                                        {{ $absensi->status }}
                                    </span>
                                </div>
                                
                                <hr class="my-2">

                                {{-- Baris 2: Keterangan --}}
                                <div class="small text-muted keterangan-mobile">
                                    <p class="mb-1 fw-semibold text-dark">
                                        <i class="fas fa-comment-dots me-1 text-primary"></i> Catatan Pengurus:
                                    </p>
                                    <p class="mb-0 text-wrap ms-3 fst-italic text-secondary description-text">
                                        {{ $absensi->keterangan ?? 'Tidak ada catatan.' }}
                                    </p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

        </div>
    </div>
</div>

@push('css')
<style>
    /* Custom Variables & Global Styling */
    :root {
        --bs-primary: #1e88e5; 
        --bs-success: #43a047;
        --bs-warning: #ffb300;
        --bs-info: #039be5;
        --bs-danger: #e53935;
        --bs-secondary: #6c757d;
        --bs-border-radius: 0.75rem; 
    }
    .container-fluid {
        padding-top: 1.5rem;
    }
    .card {
        border-radius: var(--bs-border-radius);
    }
    .shadow-md {
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15) !important;
    }

    /* Santri Header Styling */
    .card-santri-detail {
        border-left: 6px solid var(--bs-primary);
    }
    .card-santri-detail .action-link:hover {
        background-color: #f0f0f0;
    }

    /* Filter Card Styling */
    .filter-card-custom {
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08) !important;
    }
    .filter-card-custom input[type="date"] {
        padding-left: 1rem;
    }
    .quick-select-dates {
        overflow-x: auto;
        flex-wrap: nowrap;
        padding-bottom: 0.5rem; /* Untuk scrollbar mobile */
    }
    .quick-date-item {
        white-space: nowrap;
    }

    /* Table Styling (Desktop) */
    .table-rekap-desktop thead th {
        background-color: #343a40;
        color: white;
        border-color: #343a40 !important;
    }
    .table-rekap-desktop tbody tr:hover {
        background-color: #f8f9fa;
    }
    .status-badge {
        min-width: 70px;
    }

    /* List Group Styling (Mobile) - REVISI/TAMBAHAN */
    .list-group-detail-mobile .list-item-custom {
        transition: transform 0.2s;
        /* Menyesuaikan padding karena ada border-start-5 */
        padding-left: 1rem;
    }
    .list-group-detail-mobile .list-item-custom:hover {
        transform: translateY(-2px);
    }
    .status-badge-mobile {
        min-width: 65px;
        text-align: center;
        font-size: 0.75rem; /* Sedikit dikecilkan agar lebih padat */
    }
    /* Menambahkan border start yang tebal di CSS */
    .border-start-5 {
        border-left-width: 0.5rem !important; 
        border-left-style: solid !important;
        padding-left: 1.5rem !important; /* Tambah padding agar konten tidak terlalu dekat dengan border */
    }
    /* Definisi warna border start */
    .border-start-success { border-left-color: var(--bs-success) !important; }
    .border-start-warning { border-left-color: var(--bs-warning) !important; }
    .border-start-info { border-left-color: var(--bs-info) !important; }
    .border-start-danger { border-left-color: var(--bs-danger) !important; }
    .border-start-secondary { border-left-color: var(--bs-secondary) !important; }

    .description-text {
        line-height: 1.4;
        white-space: normal; /* Memastikan teks keterangan wrap dengan baik */
    }

    .border-danger { border-color: var(--bs-danger) !important; }
    .border-light { border-color: #e9ecef !important; }

    /* REVISI: Styling untuk Judul Detail Kehadiran Harian di Mobile */
    .title-date-mobile {
        font-size: 0.9rem !important; 
        display: inline-block; 
        margin-top: 0.5rem; 
        /* Pastikan badge info menggunakan warna info dari root */
        background-color: var(--bs-info) !important;
    }


    /* Media Queries for Responsiveness */
    @media (max-width: 767.98px) {
        .card-santri-detail .action-link {
            width: 100%;
            margin-top: 1rem !important;
            margin-left: 0 !important;
        }
        .filter-card-custom .btn {
            font-size: 0.85rem;
        }
    }
</style>
@endpush
@endsection