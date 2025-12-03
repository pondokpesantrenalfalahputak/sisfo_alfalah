@extends('layouts.wali') 

@php use Carbon\Carbon; @endphp

@section('title', 'Absensi Harian ' . $santri->nama_lengkap)
@section('page_title', 'Absensi Harian ' . $santri->nama_lengkap)

@section('content')

<div class="container-fluid">
    <div class="row">
        <div class="col-12">

            {{-- HEADER SANTRI (Modern Card Header) --}}
            <div class="card border-0 shadow-lg mb-4 rounded-4">
                <div class="card-header bg-primary text-white d-flex flex-column flex-md-row align-items-md-center py-3 px-4 rounded-top-4">
                    <div class="d-flex align-items-center mb-2 mb-md-0">
                        <i class="fas fa-graduation-cap me-3 fs-3"></i>
                        <div>
                            <h5 class="mb-0 fw-bolder">{{ strtoupper($santri->nama_lengcap) }}</h5>
                            <small class="badge bg-light text-primary fw-semibold rounded-pill">{{ $santri->kelas->nama_kelas ?? 'Kelas N/A' }} | NISN: {{ $santri->nisn }}</small>
                        </div>
                    </div>
                    {{-- Tombol Kembali (Dibuat menonjol) --}}
                    <a href="{{ route('wali.absensi.index') }}" class="btn btn-md btn-light text-primary ms-md-auto fw-bold rounded-pill shadow-sm">
                        <i class="fas fa-chevron-left me-1"></i> Kembali ke Rekap
                    </a>
                </div>
            </div>

            {{-- FILTER TANGGAL (Modern Form Style) --}}
            <div class="card border-0 shadow-sm bg-light p-4 mb-5 rounded-4">
                <form method="GET" action="{{ route('wali.absensi.show', $santri->id) }}" class="row g-3 align-items-center">
                    <div class="col-12">
                        <h6 class="mb-0 fw-bold text-primary">
                            <i class="fas fa-calendar-check me-2"></i> Pilih Tanggal Absensi
                        </h6>
                    </div>
                    
                    {{-- Input Tanggal --}}
                    <div class="col-sm-4 col-6">
                        <input type="date" name="tanggal" class="form-control form-control-sm rounded-pill shadow-sm" 
                               value="{{ $dateFilter }}" max="{{ Carbon::now()->toDateString() }}">
                    </div>
                    
                    {{-- Tombol Terapkan --}}
                    <div class="col-sm-3 col-6">
                        <button type="submit" class="btn btn-primary btn-sm flex-fill rounded-pill shadow-sm">Lihat Data</button>
                    </div>

                    {{-- Quick Select dari Tanggal Tersedia (Dibuat responsif) --}}
                    @if ($availableDates->count() > 0)
                    <div class="col-12 mt-3">
                        <p class="small text-muted mb-2 fw-semibold">Tanggal dengan data absensi:</p>
                        <div class="d-flex flex-wrap gap-2">
                            @foreach ($availableDates as $date)
                                @php
                                    $isActive = $date === $dateFilter ? 'btn-info text-white shadow' : 'btn-outline-secondary';
                                @endphp
                                <a href="{{ route('wali.absensi.show', ['santri' => $santri->id, 'tanggal' => $date]) }}" 
                                   class="btn btn-sm {{ $isActive }} rounded-pill">
                                    {{ Carbon::parse($date)->translatedFormat('d M') }}
                                </a>
                            @endforeach
                        </div>
                    </div>
                    @endif
                </form>
            </div>


            {{-- HASIL ABSENSI HARIAN --}}
            <h5 class="mt-4 mb-4 fw-bold text-dark border-bottom pb-2">
                Detail Kehadiran Tanggal: 
                <span class="text-danger">
                    <i class="fas fa-calendar me-2"></i> {{ Carbon::parse($dateFilter)->translatedFormat('l, d F Y') }}
                </span> 
            </h5>

            @if ($absensiHarian->isEmpty())
                <div class="alert alert-warning text-center py-4 border rounded-4 shadow-sm">
                    <i class="fas fa-calendar-times me-2 fs-4 text-secondary"></i> 
                    <p class="mb-0 mt-2 fw-semibold">Tidak ditemukan data absensi untuk tanggal ini.</p>
                </div>
            @else
                
                {{-- Logika Penentuan Warna Status --}}
                @php
                    $statusColorMap = [
                        'Hadir' => 'success',
                        'Sakit' => 'warning',
                        'Izin' => 'info',
                        'Alfa' => 'danger',
                    ];
                @endphp

                {{-- === 1. TAMPILAN DESKTOP (TABLE) === --}}
                <div class="table-responsive d-none d-md-block">
                    <table class="table table-bordered table-striped table-sm small table-hover align-middle rounded-3 overflow-hidden" width="100%" cellspacing="0">
                        <thead class="table-dark text-center">
                            <tr>
                                <th style="width: 5%;">#</th>
                                <th style="width: 25%;">Kegiatan</th>
                                <th style="width: 15%;">Status Kehadiran</th>
                                <th style="width: 55%;">Keterangan (Admin)</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($absensiHarian as $index => $absensi)
                                @php
                                    $statusClass = $statusColorMap[$absensi->status] ?? 'secondary';
                                    $rowClass = ($absensi->status == 'Alfa') ? 'table-danger' : '';
                                @endphp
                                <tr class="{{ $rowClass }}">
                                    <td class="text-center align-middle">{{ $index + 1 }}</td>
                                    <td class="align-middle fw-semibold">{{ $absensi->jenis_kegiatan }}</td>
                                    <td class="text-center align-middle">
                                        <span class="badge bg-{{ $statusClass }} p-2 shadow-sm">{{ $absensi->status }}</span>
                                    </td>
                                    <td class="align-middle small text-muted">
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
                <div class="d-md-none">
                    <div class="list-group">
                        @foreach ($absensiHarian as $index => $absensi)
                            @php
                                $statusClass = $statusColorMap[$absensi->status] ?? 'secondary';
                                $borderClass = ($absensi->status == 'Alfa') ? 'border-danger' : 'border-light';
                            @endphp
                            
                            <div class="list-group-item list-group-item-action mb-3 p-3 shadow-sm rounded-3 border-start-{{ $statusClass }} border-start-5 {{ $borderClass }}">
                                
                                {{-- Judul dan Status --}}
                                <div class="d-flex w-100 justify-content-between align-items-center mb-2">
                                    <h6 class="mb-0 fw-bold text-dark">
                                        {{ $index + 1 }}. {{ $absensi->jenis_kegiatan }}
                                    </h6>
                                    <span class="badge bg-{{ $statusClass }} py-2 px-3 fw-bold rounded-pill shadow-sm">
                                        {{ $absensi->status }}
                                    </span>
                                </div>
                                
                                <hr class="my-2">

                                {{-- Keterangan --}}
                                <p class="small mb-1 fw-semibold text-muted">
                                    <i class="fas fa-comment-dots me-1 text-primary"></i> Keterangan Pengurus:
                                </p>
                                <p class="mb-0 small text-wrap ms-3 fst-italic">
                                    {{ $absensi->keterangan ?? 'Tidak ada catatan.' }}
                                </p>
                            </div>
                        @endforeach
                    </div>
                </div>

            @endif

        </div>
    </div>
</div>

@endsection