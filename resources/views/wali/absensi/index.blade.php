@extends('layouts.wali') 

@section('title', 'Rekapitulasi Absensi Bulanan')
@section('page_title', 'Rekapitulasi Absensi Bulanan')

@section('content')

    {{-- Ambil Bulan & Tahun dari Query String --}}
    @php
        // Pastikan Carbon sudah di-import/digunakan (asumsi di layout/Controller sudah ada use Carbon\Carbon)
        $bulanFilter = request('bulan', \Carbon\Carbon::now()->month);
        $tahunFilter = request('tahun', \Carbon\Carbon::now()->year);
        $isFiltered = request()->has('bulan') || request()->has('tahun');
        
        // Setup Carbon untuk mendapatkan nama bulan
        $carbonClass = \Carbon\Carbon::class; // Untuk referensi di Blade
    @endphp

    <div class="row">
        {{-- Formulir Pemilihan Bulan/Tahun (FILTER) --}}
        <div class="col-12 mb-5">
            <div class="card border-0 shadow-sm rounded-4 bg-light p-4">
                <form method="GET" action="{{ route('wali.absensi.index') }}" class="row g-3 align-items-center">
                    <div class="col-12">
                        <h6 class="mb-0 fw-bold text-primary">
                            <i class="fas fa-calendar-alt me-2"></i> Filter Periode Absensi
                        </h6>
                    </div>
                    
                    <div class="col-sm-4 col-6">
                        <select name="bulan" class="form-select form-select-sm rounded-pill shadow-sm">
                            @for ($m = 1; $m <= 12; $m++)
                                <option value="{{ $m }}" {{ (string)$m === (string)$bulanFilter ? 'selected' : '' }}>
                                    {{ $carbonClass::create()->month($m)->translatedFormat('F') }}
                                </option>
                            @endfor
                        </select>
                    </div>
                    <div class="col-sm-3 col-6">
                        <select name="tahun" class="form-select form-select-sm rounded-pill shadow-sm">
                            @for ($y = $carbonClass::now()->year; $y >= 2020; $y--)
                                <option value="{{ $y }}" {{ (string)$y === (string)$tahunFilter ? 'selected' : '' }}>{{ $y }}</option>
                            @endfor
                        </select>
                    </div>
                    
                    <div class="col-sm-5 col-12 d-flex justify-content-end">
                        <button type="submit" class="btn btn-primary btn-sm me-2 flex-fill rounded-pill shadow">
                            <i class="fas fa-check me-1"></i> Terapkan
                        </button>
                        @if($isFiltered)
                            <a href="{{ route('wali.absensi.index') }}" class="btn btn-outline-secondary btn-sm rounded-pill shadow-sm">Reset</a>
                        @endif
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <div class="row">
    @forelse ($santriList as $santri)
        <div class="col-lg-12 mb-5">
            
            {{-- HEADER SANTRI (Modern Card Header & Action) --}}
            <div class="card border-0 shadow-lg mb-4 rounded-4">
                
                <div class="card-header bg-primary text-white d-flex flex-column flex-md-row align-items-md-center py-3 px-4 rounded-top-4">
                    <div class="d-flex align-items-center mb-2 mb-md-0">
                        <i class="fas fa-graduation-cap me-3 fs-3"></i>
                        <div>
                            <h5 class="mb-0 fw-bolder">{{ strtoupper($santri->nama_lengkap) }}</h5> 
                            <small class="badge bg-light text-primary fw-semibold rounded-pill">{{ $santri->kelas->nama_kelas ?? 'Kelas N/A' }} | NISN: {{ $santri->nisn }}</small>
                        </div>
                    </div>
                    
                    {{-- ✅ LINK ABSENSI HARIAN (Dibuat menonjol) --}}
                    <a href="{{ route('wali.absensi.show', $santri->id) }}" class="btn btn-md btn-light text-primary ms-md-auto fw-bold rounded-pill shadow-sm">
                        <i class="fas fa-calendar-day me-1"></i> Lihat Absensi Harian
                    </a>
                </div>
                
                <div class="card-body p-4">

                    {{-- 1. RINGKASAN CUMULATIVE ALPHA/FILTERED ALPHA --}}
                    @php
                        $absensiRiwayat = $santri->absensiRekapitulasi; 
                        
                        $totalAlphaKumulatif = $absensiRiwayat->sum('ngaji_alpha') + 
                                               $absensiRiwayat->sum('sholat_alpha') + 
                                               $absensiRiwayat->sum('roan_alpha');
                        
                        $statusClass = $totalAlphaKumulatif >= 5 ? 'danger' : ($totalAlphaKumulatif > 0 ? 'warning' : 'success');
                        $statusIcon = $totalAlphaKumulatif >= 5 ? 'fas fa-exclamation-triangle' : ($totalAlphaKumulatif > 0 ? 'fas fa-exclamation-circle' : 'fas fa-check-circle');
                    @endphp

                    <div class="mb-5 p-4 rounded-4 border border-{{ $statusClass }} bg-{{ $statusClass }} bg-opacity-10 shadow-sm">
                        <div class="row align-items-center">
                            <div class="col-12 col-md-4 text-center border-end-md">
                                <span class="fw-bolder display-4 text-{{ $statusClass }}">{{ $totalAlphaKumulatif }}</span>
                                <p class="text-muted mb-0 small text-uppercase mt-1 fw-bold">
                                    Total ALPHA 
                                </p>
                                <p class="badge bg-{{ $statusClass }} mt-1 px-3">
                                    @if($isFiltered) Bulan Ini @else Kumulatif @endif
                                </p>
                            </div>
                            <div class="col-12 col-md-8 mt-3 mt-md-0">
                                <p class="small mb-0 text-{{ $statusClass }} fw-bolder fs-6">
                                    <i class="{{ $statusIcon }} me-2"></i> 
                                    @if($totalAlphaKumulatif >= 5)
                                        Perlu Tindakan Cepat (Di atas batas toleransi)
                                    @elseif($totalAlphaKumulatif > 0)
                                        Ada Catatan Alpha Bulan Ini/Kumulatif
                                    @else
                                        Disiplin Sangat Baik
                                    @endif
                                </p>
                                <p class="text-secondary small mt-1 mb-0">Rincian ketidakdisiplinan yang tercatat pada periode yang dipilih.</p>
                            </div>
                        </div>
                    </div>
                    
                    <h6 class="fw-bold mb-4 mt-3 text-dark border-bottom pb-2">
                        <i class="fas fa-history me-2 text-secondary"></i> Riwayat Absensi Bulanan
                    </h6>

                    {{-- 2. DETAIL RIWAYAT --}}
                    
                    @if ($absensiRiwayat->count() > 0)
                        
                        {{-- DEKSTOP VIEW (Tabel Standar) --}}
                        <div class="table-responsive d-none d-md-block">
                             <table class="table table-bordered table-striped table-sm small table-hover align-middle rounded-3 overflow-hidden" width="100%" cellspacing="0">
                                <thead class="table-dark text-center">
                                    <tr>
                                        <th rowspan="2" style="width: 15%;">PERIODE</th>
                                        <th colspan="3" class="bg-danger">RINCIAN ALPHA (Hari)</th>
                                        <th rowspan="2" class="bg-primary text-white" style="width: 8%;">TOTAL</th>
                                        <th rowspan="2" style="width: 30%;">KETERANGAN PENGURUS</th> 
                                        <th rowspan="2" style="width: 15%;">INPUT OLEH</th>
                                    </tr>
                                    <tr>
                                        <th class="p-1 bg-danger text-white">Ngaji</th>
                                        <th class="p-1 bg-danger text-white">Sholat</th>
                                        <th class="p-1 bg-danger text-white">Roan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($absensiRiwayat as $rekap)
                                        @php
                                            $totalClass = ($rekap->total_alpha > 0) ? 'bg-primary text-white fw-bold' : 'text-success fw-bold';
                                            $rowClass = ($rekap->total_alpha > 5) ? 'table-danger' : ''; 
                                        @endphp
                                        <tr class="{{ $rowClass }}">
                                            <td class="fw-semibold">{{ $carbonClass::createFromDate($rekap->tahun, $rekap->bulan, 1)->translatedFormat('F Y') }}</td>
                                            
                                            <td class="text-center">
                                                @if ($rekap->ngaji_alpha > 0)
                                                    <span class="badge bg-danger p-2">{{ $rekap->ngaji_alpha }}</span>
                                                @else
                                                    <span class="text-secondary small">0</span>
                                                @endif
                                            </td>
                                            
                                            <td class="text-center">
                                                @if ($rekap->sholat_alpha > 0)
                                                    <span class="badge bg-danger p-2">{{ $rekap->sholat_alpha }}</span>
                                                @else
                                                    <span class="text-secondary small">0</span>
                                                @endif
                                            </td>

                                            <td class="text-center">
                                                @if ($rekap->roan_alpha > 0)
                                                    <span class="badge bg-danger p-2">{{ $rekap->roan_alpha }}</span>
                                                @else
                                                    <span class="text-secondary small">0</span>
                                                @endif
                                            </td>

                                            <td class="text-center {{ $totalClass }} border-start border-white">
                                                <strong class="fs-6">{{ $rekap->total_alpha }}</strong>
                                            </td>

                                            <td class="small text-muted text-wrap">
                                                @if($rekap->keterangan)
                                                    {{ Str::limit($rekap->keterangan, 70) }}
                                                @else
                                                    <em class="text-secondary">- Tidak ada catatan -</em>
                                                @endif
                                            </td>

                                            <td class="small text-muted text-center">{{ $rekap->waliInput->name ?? 'Sistem' }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        
                        {{-- MOBILE VIEW (LIST CARD DITINGKATKAN) --}}
                        <div class="list-group d-block d-md-none">
                            @foreach ($absensiRiwayat as $rekap)
                                @php
                                    $cardBorderClass = ($rekap->total_alpha >= 5) ? 'border-danger' : (($rekap->total_alpha > 0) ? 'border-warning' : 'border-success');
                                    $alphaIcon = ($rekap->total_alpha >= 5) ? 'fas fa-frown text-danger' : (($rekap->total_alpha > 0) ? 'fas fa-exclamation-triangle text-warning' : 'fas fa-star text-success');
                                @endphp
                                
                                <div class="list-group-item list-group-item-action mb-3 p-3 shadow-sm rounded-3 border {{ $cardBorderClass }}" aria-current="true">
                                    <div class="d-flex w-100 justify-content-between align-items-center">
                                        <h6 class="mb-1 fw-bold">
                                            <i class="{{ $alphaIcon }} me-2"></i> 
                                            {{ $carbonClass::createFromDate($rekap->tahun, $rekap->bulan, 1)->translatedFormat('F Y') }}
                                        </h6>
                                        <span class="badge bg-primary fs-6 py-2 px-3 rounded-pill shadow-sm">
                                            Total: {{ $rekap->total_alpha }}
                                        </span>
                                    </div>
                                    <hr class="my-2">
                                    
                                    {{-- DETAIL ALPHA DIBUAT DENGAN GRID DAN BADGE --}}
                                    <div class="row row-cols-3 text-center small fw-semibold mb-3">
                                        <div class="col">
                                            Ngaji: 
                                            <span class="badge bg-{{ $rekap->ngaji_alpha > 0 ? 'danger' : 'success' }}">{{ $rekap->ngaji_alpha }}</span>
                                        </div>
                                        <div class="col">
                                            Sholat: 
                                            <span class="badge bg-{{ $rekap->sholat_alpha > 0 ? 'danger' : 'success' }}">{{ $rekap->sholat_alpha }}</span>
                                        </div>
                                        <div class="col">
                                            Roan: 
                                            <span class="badge bg-{{ $rekap->roan_alpha > 0 ? 'danger' : 'success' }}">{{ $rekap->roan_alpha }}</span>
                                        </div>
                                    </div>
                                    
                                    <hr class="my-2">

                                    {{-- KETERANGAN DAN INPUT OLEH --}}
                                    <div class="small text-muted">
                                        <p class="mb-1 fw-semibold text-dark">
                                            <i class="fas fa-comment-dots me-1 text-primary"></i> Keterangan Pengurus:
                                        </p>
                                        <p class="mb-0 text-wrap ms-3 fst-italic">
                                            {{ $rekap->keterangan ?? 'Tidak ada catatan.' }}
                                        </p>
                                        <p class="mb-0 mt-2 text-end">
                                            <i class="fas fa-user-tag me-1"></i> Input Oleh: <strong class="text-dark">{{ $rekap->waliInput->name ?? 'Sistem' }}</strong>
                                        </p>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                    @else
                        {{-- 3. JIKA DATA KOSONG --}}
                        <div class="alert alert-light text-center py-4 border rounded-4">
                            <i class="fas fa-search-minus me-2 fs-5 text-secondary"></i> 
                            <p class="mb-0 mt-2 fw-semibold">Tidak ditemukan data rekapitulasi Alpha untuk periode ini.</p>
                            <small class="text-muted">Pastikan periode Bulan/Tahun yang dipilih sudah benar.</small>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    @empty
        {{-- 4. JIKA TIDAK ADA SANTRI SAMA SEKALI --}}
        <div class="col-12">
            <div class="alert alert-danger text-center py-5 shadow-lg rounded-4">
                <i class="fas fa-user-times me-2 fs-3"></i> 
                <p class="mb-0 mt-3 fw-bold fs-5">Tidak ada data santri yang terdaftar di bawah perwalian akun Anda.</p>
                <p class="mb-0 small">Hubungi Admin jika ini adalah kesalahan.</p>
            </div>
        </div>
    @endforelse
    </div>
@endsection