@extends('layouts.admin')

@section('page_title', 'Rekapitulasi Absensi Bulanan')

@push('styles')
<style>
    /* Styling Card Modern */
    .card-modern {
        border: none;
        border-radius: 1rem !important;
        box-shadow: 0 0.5rem 1.5rem rgba(0, 0, 0, 0.08);
    }
    
    /* Warna Aksen */
    .bg-dark-blue { background-color: #0d47a1 !important; } 
    .text-danger-alpha { color: #dc3545 !important; }
    
    /* Styling untuk Tabel Responsif Mobile (Kode CSS Anda sudah sangat baik, tidak diubah) */
    @media (max-width: 767.98px) {
        /* ... CSS responsif Anda ... */
        .table-responsive table { border: 0; }
        .table-responsive table thead { display: none; }
        .table-responsive table tr { display: block; margin-bottom: 0.8rem; border: 1px solid #dee2e6; border-radius: 0.5rem; }
        .table-responsive table td { display: block; text-align: right !important; padding-left: 50% !important; position: relative; }
        .table-responsive table td:before { content: attr(data-label); position: absolute; left: 0; width: 50%; padding-left: 1rem; font-weight: 600; text-align: left; color: #495057; }
        .mobile-label-alpha { background-color: #f8d7da; font-weight: bold !important; }
        .mobile-label-total { background-color: #ffc107; color: #212529; font-weight: bold !important; }
    }
</style>
@endpush

@section('content')

{{-- 
    START: FUNGSI PHP UNTUK RENDER ACTION BUTTONS 
    Ini menggantikan @include('admin.absensi_rekap.action_buttons') yang hilang
--}}
@php
    $alphaWarningLimit = 3; 

    // Mendefinisikan fungsi helper untuk Action Buttons
    function renderActionButtons($absensi) {
        // Pastikan relasi santri ada sebelum mengakses nama_lengkap
        $santriName = optional($absensi->santri)->nama_lengkap ?? 'Santri Tidak Dikenal'; 
        
        // URL Edit (menggunakan route create_multi untuk edit satuan)
        $editUrl = route('admin.absensi_rekap.create_multi', [
            'bulan' => $absensi->bulan, 
            'tahun' => $absensi->tahun, 
            'kelas_id' => $absensi->kelas_id,
            'santri_id' => $absensi->santri_id // Menambahkan santri_id untuk edit spesifik
        ]);

        // URL Delete
        $deleteUrl = route('admin.absensi_rekap.destroy', $absensi->id);

        echo "
        <a href=\"{$editUrl}\" class=\"btn btn-sm btn-warning rounded-pill px-3 shadow-sm\" title=\"Edit Data Satuan\">
            <i class=\"fas fa-pencil-alt\"></i>
        </a>
        <form action=\"{$deleteUrl}\" method=\"POST\" class=\"d-inline\" onsubmit=\"return confirm('Yakin ingin menghapus REKAPITULASI ALPHA SANTRI {$santriName} bulan ini? Tindakan ini tidak dapat dibatalkan.');\">
            " . csrf_field() . method_field('DELETE') . "
            <button type=\"submit\" class=\"btn btn-sm btn-danger rounded-pill px-3 shadow-sm\" title=\"Hapus Data Satuan\">
                <i class=\"fas fa-trash-alt\"></i>
            </button>
        </form>
        ";
    }
@endphp
{{-- END: FUNGSI PHP UNTUK RENDER ACTION BUTTONS --}}

<div class="container-fluid">
    <div class="row">
        <div class="col-12">

            <h2 class="mb-4 text-dark fw-bold">📊 Rekapitulasi Absensi Bulanan</h2>

            <div class="card card-modern mb-4">
                
                {{-- START: CARD HEADER (Filter & Action) --}}
                <div class="card-header py-3 bg-white border-bottom-0 rounded-top-4">
                    
                    {{-- Judul Bulan --}}
                    <h5 class="m-0 font-weight-bold text-dark text-center pb-3 border-bottom border-light">
                        Data Alpha Bulan {{ \Carbon\Carbon::createFromDate($tahun, $bulan)->translatedFormat('F Y') }}
                    </h5>
                    
                    <div class="d-flex justify-content-between align-items-center flex-column flex-lg-row pt-3">
                        
                        {{-- Formulir Pemilihan Bulan/Tahun (Filter) - Mobile Friendly --}}
                        <form method="GET" action="{{ route('admin.absensi_rekap.index') }}" class="d-flex flex-wrap justify-content-center align-items-center gap-2 p-2 w-100 mb-3 mb-lg-0">
                            
                            <strong class="me-lg-2 text-dark small text-nowrap w-100 text-center d-lg-block d-none">Tampilkan Bulan:</strong>
                            
                            <select name="bulan" class="form-select form-select-sm fw-semibold flex-grow-1">
                                @for ($m = 1; $m <= 12; $m++)
                                    <option value="{{ $m }}" {{ $m == $bulan ? 'selected' : '' }}>
                                        {{ \Carbon\Carbon::create()->month($m)->translatedFormat('F') }}
                                    </option>
                                @endfor
                            </select>
                            <select name="tahun" class="form-select form-select-sm fw-semibold" style="width: 100px;">
                                @for ($y = Carbon\Carbon::now()->year; $y >= 2020; $y--)
                                    <option value="{{ $y }}" {{ $y == $tahun ? 'selected' : '' }}>{{ $y }}</option>
                                @endfor
                            </select>
                            <button type="submit" class="btn btn-primary btn-sm px-3 flex-shrink-0"><i class="fas fa-search"></i> Cari</button>
                        </form>

                        {{-- Tombol Aksi Pindah ke Form Input Massal --}}
                        <a href="{{ route('admin.absensi_rekap.create_multi', ['bulan' => $bulan, 'tahun' => $tahun]) }}" class="btn btn-success btn-icon-split shadow-sm rounded-pill px-4 flex-shrink-0 mt-2 mt-lg-0">
                            <span class="text fw-bold">
                                <i class="fas fa-edit me-1"></i> Input/Edit Massal
                            </span>
                        </a>
                    </div>
                </div>
                {{-- END: CARD HEADER --}}

                <div class="card-body p-4">
                    @if (session('success'))
                        <div class="alert alert-success rounded-3 shadow-sm"><i class="fas fa-check-circle me-1"></i> {{ session('success') }}</div>
                    @endif
                    @if (session('error'))
                        <div class="alert alert-danger rounded-3 shadow-sm"><i class="fas fa-times-circle me-1"></i> {{ session('error') }}</div>
                    @endif

                    <div class="table-responsive">
                        {{-- DEKSTOP: Tabel Klasik --}}
                        <table class="table table-hover table-bordered align-middle d-none d-md-table" width="100%" cellspacing="0">
                            {{-- ... Thead Tabel Klasik (Tidak Berubah) ... --}}
                            <thead class="bg-dark-blue text-white text-center">
                                <tr>
                                    <th rowspan="2" class="align-middle text-nowrap" style="width: 5%;">No</th>
                                    <th rowspan="2" class="align-middle text-start text-nowrap" style="min-width: 180px;">Nama Santri</th>
                                    <th rowspan="2" class="align-middle text-center text-nowrap" style="width: 8%;">Kelas</th>
                                    <th colspan="4" class="text-center bg-danger">Jumlah Alpha (Hari)</th>
                                    <th rowspan="2" class="align-middle text-center" style="width: 15%;">Keterangan</th>
                                    <th rowspan="2" class="align-middle text-center text-nowrap" style="width: 10%;">Aksi</th>
                                </tr>
                                <tr>
                                    <th class="text-center p-2 bg-danger-alpha text-white text-nowrap" title="Alpha Ngaji (Tidak Hadir)">Ngaji</th>
                                    <th class="text-center p-2 bg-danger-alpha text-white text-nowrap" title="Alpha Sholat (Tidak Ikut Sholat Wajib/Sunnah)">Sholat</th>
                                    <th class="text-center p-2 bg-danger-alpha text-white text-nowrap" title="Alpha Roan (Tidak Ikut Kerja Bakti)">Roan</th>
                                    <th class="text-center p-2 bg-warning text-dark fw-bolder text-nowrap" style="width: 8%;">Total</th> {{-- Kolom Total --}}
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($absensis as $index => $absensi)
                                @php
                                    $totalAlpha = $absensi->ngaji_alpha + $absensi->sholat_alpha + $absensi->roan_alpha;
                                    $rowClass = ($totalAlpha >= $alphaWarningLimit) ? 'table-danger border-start border-5 border-danger fw-semibold' : 'fw-semibold'; 
                                @endphp
                                <tr class="{{ $rowClass }}">
                                    <td class="text-center align-middle">{{ $absensis->firstItem() + $index }}</td>
                                    <td class="align-middle text-dark">{{ $absensi->santri->nama_lengkap }}</td>
                                    <td class="text-center align-middle">{{ $absensi->kelas->nama_kelas ?? '-' }}</td>
                                    
                                    {{-- Alpha Status Ngaji, Sholat, Roan (Tidak Berubah) --}}
                                    <td class="text-center align-middle">
                                        @if ($absensi->ngaji_alpha > 0)
                                            <span class="badge bg-danger p-2">{{ $absensi->ngaji_alpha }}</span>
                                        @else
                                            <span class="text-success small fw-normal">0</span>
                                        @endif
                                    </td>
                                    <td class="text-center align-middle">
                                        @if ($absensi->sholat_alpha > 0)
                                            <span class="badge bg-danger p-2">{{ $absensi->sholat_alpha }}</span>
                                        @else
                                            <span class="text-success small fw-normal">0</span>
                                        @endif
                                    </td>
                                    <td class="text-center align-middle">
                                        @if ($absensi->roan_alpha > 0)
                                            <span class="badge bg-danger p-2">{{ $absensi->roan_alpha }}</span>
                                        @else
                                            <span class="text-success small fw-normal">0</span>
                                        @endif
                                    </td>
                                    {{-- TOTAL ALPHA (Highlight) --}}
                                    <td class="text-center align-middle bg-warning text-dark fw-bolder">
                                        <span class="fs-6">{{ $totalAlpha }}</span>
                                    </td>

                                    {{-- Keterangan --}}
                                    <td class="small align-middle text-muted">{{ $absensi->keterangan ?? '-' }}</td>

                                    {{-- Aksi --}}
                                    <td class="text-center align-middle text-nowrap">
                                        <div class="d-flex justify-content-center gap-1">
                                            {{-- GANTI DENGAN PEMANGGILAN FUNGSI INLINE --}}
                                            @php renderActionButtons($absensi) @endphp 
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="9" class="text-center p-4 bg-light">
                                        <i class="fas fa-info-circle me-1 fa-3x text-info mb-2"></i><br>
                                        <h6 class="fw-bold">Tidak ada data rekapitulasi Alpha.</h6>
                                        <p class="small mb-0">Silakan pilih bulan/tahun lain atau klik tombol Input/Edit Rekap Massal di atas.</p>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                        
                        {{-- MOBILE: Tabel dalam bentuk Card/List --}}
                        <div class="d-md-none">
                            @forelse ($absensis as $index => $absensi)
                            @php
                                $totalAlpha = $absensi->ngaji_alpha + $absensi->sholat_alpha + $absensi->roan_alpha;
                                $cardClass = ($totalAlpha >= $alphaWarningLimit) ? 'border-danger shadow-sm' : 'border-light shadow-sm';
                                $alphaBg = ($totalAlpha >= $alphaWarningLimit) ? 'bg-danger text-white' : 'bg-warning text-dark';
                            @endphp
                            <div class="card {{ $cardClass }} mb-3 rounded-3 border-start border-5 p-2">
                                {{-- ... Isi Card (Tidak Berubah) ... --}}
                                <div class="card-body p-3">
                                    <div class="d-flex justify-content-between align-items-start mb-2 border-bottom pb-2">
                                        <h6 class="mb-0 fw-bold text-dark">
                                            {{ $absensis->firstItem() + $index }}. {{ $absensi->santri->nama_lengkap }}
                                        </h6>
                                        <span class="badge bg-primary rounded-pill fw-bold">{{ $absensi->kelas->nama_kelas ?? 'Non-Kelas' }}</span>
                                    </div>

                                    <div class="row g-2">
                                        {{-- Total Alpha (Paling Menonjol) --}}
                                        <div class="col-4">
                                            <div class="p-2 text-center rounded {{ $alphaBg }}">
                                                <small class="d-block text-uppercase fw-semibold opacity-75">Total</small>
                                                <span class="fw-bolder fs-5">{{ $totalAlpha }}</span>
                                            </div>
                                        </div>
                                        {{-- Rincian Alpha --}}
                                        <div class="col-8">
                                            <div class="d-flex justify-content-around text-center h-100">
                                                <div class="flex-fill border-end pe-2">
                                                    <small class="d-block fw-semibold text-muted">Ngaji</small>
                                                    <span class="badge bg-danger">{{ $absensi->ngaji_alpha }}</span>
                                                </div>
                                                <div class="flex-fill border-end px-2">
                                                    <small class="d-block fw-semibold text-muted">Sholat</small>
                                                    <span class="badge bg-danger">{{ $absensi->sholat_alpha }}</span>
                                                </div>
                                                <div class="flex-fill ps-2">
                                                    <small class="d-block fw-semibold text-muted">Roan</small>
                                                    <span class="badge bg-danger">{{ $absensi->roan_alpha }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    {{-- Keterangan --}}
                                    <p class="small text-muted mt-3 mb-2 border-top pt-2">
                                        <span class="fw-semibold">Ket:</span> {{ $absensi->keterangan ?? '-' }}
                                    </p>
                                    
                                    {{-- Aksi --}}
                                    <div class="d-flex justify-content-end gap-2 mt-2">
                                        {{-- GANTI DENGAN PEMANGGILAN FUNGSI INLINE --}}
                                        @php renderActionButtons($absensi) @endphp
                                    </div>
                                </div>
                            </div>
                            @empty
                            <div class="p-4 text-center text-muted bg-light rounded-4 border border-dashed border-secondary">
                                <i class="fas fa-info-circle me-1 fa-3x text-info mb-2"></i><br>
                                <h6 class="fw-bold">Tidak ada data rekapitulasi Alpha.</h6>
                                <p class="small mb-0">Silakan pilih bulan/tahun lain atau klik tombol Input/Edit Rekap Massal di atas.</p>
                            </div>
                            @endforelse
                        </div>
                    </div>
                    
                    <div class="d-flex justify-content-end mt-3">
                        {{ $absensis->links() }}
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection