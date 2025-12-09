@extends('layouts.admin')

@section('title', 'Manajemen Tagihan')
@section('page_title', 'Manajemen Tagihan Pembayaran')

@push('styles')
<style>
    /* Mengurangi ukuran font pada tabel desktop untuk kerapihan */
    .table-hover td, .table-hover th {
        font-size: 0.85rem; 
    }
    
    /* Penyesuaian font pada elemen Card List Mobile untuk keterbacaan optimal */
    @media (max-width: 767.98px) {
        
        /* Card Background dan Shadow */
        .mobile-tagihan-card {
            box-shadow: 0 1px 4px 0 rgba(0, 0, 0, 0.1), 0 1px 3px 0 rgba(0, 0, 0, 0.08); 
            transition: transform 0.2s; 
        }
        .mobile-tagihan-card:active {
            transform: scale(0.99); 
        }
        
        /* Nama Santri (Judul Utama Card) */
        .mobile-card-title {
            font-size: 0.85rem !important; 
            font-weight: 700 !important;
        }
        
        /* Teks detail kecil (ID, Kelas, Label, Tanggal) */
        .mobile-detail-text {
            font-size: 0.6rem !important; 
            color: #6c757d !important; 
        }
        
        /* Jumlah tagihan (Paling Menonjol) */
        .mobile-amount-text {
            font-size: 1.0rem !important; 
        }
        
        /* Badge status/jenis */
        .mobile-badge {
            font-size: 0.7rem !important; 
            padding: 0.3rem 0.6rem !important; 
        }
        
        /* Tombol Aksi */
        .mobile-action-btn {
            font-size: 0.65rem !important; 
            padding: 0.35rem 0.7rem !important; 
        }
        /* Mengurangi border kiri untuk tampilan yang lebih ramping */
        .mobile-tagihan-card.border-start {
             border-left-width: 4px !important; 
        }
    }
</style>
@endpush


@section('header_actions')
    {{-- Tombol Tambah Tagihan Baru (MUNCUL DI HEADER HANYA UNTUK DESKTOP d-md-flex) --}}
    <a href="{{ route('admin.tagihan.create') }}" class="btn btn-warning shadow-lg rounded-pill d-none d-md-flex align-items-center fw-bold px-4 py-2 text-dark">
        <i class="fas fa-plus me-2"></i> Buat Tagihan Baru
    </a>
@endsection


@section('content')

<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">

            {{-- TOMBOL (MUNCUL DI MOBILE - MENGGANTIKAN JUDUL) --}}
            <a href="{{ route('admin.tagihan.create') }}" class="btn btn-warning shadow-lg rounded-pill d-flex align-items-center justify-content-center fw-bold px-4 py-2 text-dark d-block d-md-none">
                <i class="fas fa-plus me-2"></i> Buat Tagihan Baru
            </a>
            
        </div>
    </div>
    
    {{-- 
        ⚠️ CATATAN PERBAIKAN: 
        Blok notifikasi sukses (session('success')) telah DIHAPUS dari sini 
        karena diasumsikan sudah ada di layout utama ('layouts.admin') 
        untuk menghindari pesan duplikat.
    --}}

    {{-- 2. RINGKASAN DATA (SUMMARY CARDS - TERSEMBUNYI DI MOBILE) --}}
    @php
        // Variabel untuk Summary Cards
        $totalTagihan = $tagihans->count();
        $totalNominal = $tagihans->sum('jumlah_tagihan');
        $belumLunas = $tagihans->where('status', 'Belum Lunas')->count();
        $lunas = $tagihans->where('status', 'Lunas')->count();
    @endphp

    {{-- KONTROL TAMPILAN: d-none menyembunyikan di mobile, d-md-flex menampilkan di tablet/desktop --}}
    <div class="row mb-5 g-4 d-none d-md-flex"> 
        
        {{-- Card: Total Tagihan --}}
        <div class="col-xl-3 col-md-6">
            <div class="card border-0 rounded-4 shadow-lg h-100 bg-white">
                <div class="card-body p-4 border-start border-5 border-primary rounded-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="text-xs fw-bold text-primary text-uppercase mb-1">Total Tagihan Keseluruhan</div>
                            <div class="h2 fw-bolder mb-0 text-dark">{{ number_format($totalTagihan, 0, ',', '.') }}</div>
                        </div>
                        <i class="fas fa-list-alt fa-3x text-primary opacity-25"></i>
                    </div>
                </div>
            </div>
        </div>

        {{-- Card: Belum Lunas --}}
        <div class="col-xl-3 col-md-6">
            <div class="card border-0 rounded-4 shadow-lg h-100 bg-white">
                <div class="card-body p-4 border-start border-5 border-danger rounded-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="text-xs fw-bold text-danger text-uppercase mb-1">Tagihan Belum Lunas</div>
                            <div class="h2 fw-bolder mb-0 text-dark">{{ number_format($belumLunas, 0, ',', '.') }}</div>
                        </div>
                        <i class="fas fa-exclamation-triangle fa-3x text-danger opacity-25"></i>
                    </div>
                </div>
            </div>
        </div>

        {{-- Card: Sudah Lunas --}}
        <div class="col-xl-3 col-md-6">
            <div class="card border-0 rounded-4 shadow-lg h-100 bg-white">
                <div class="card-body p-4 border-start border-5 border-success rounded-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="text-xs fw-bold text-success text-uppercase mb-1">Tagihan Sudah Lunas</div>
                            <div class="h2 fw-bolder mb-0 text-dark">{{ number_format($lunas, 0, ',', '.') }}</div>
                        </div>
                        <i class="fas fa-check-circle fa-3x text-success opacity-25"></i>
                    </div>
                </div>
            </div>
        </div>

        {{-- Card: Total Nominal Tagihan --}}
        <div class="col-xl-3 col-md-6">
            <div class="card border-0 rounded-4 shadow-lg h-100 bg-white">
                <div class="card-body p-4 border-start border-5 border-info rounded-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="text-xs fw-bold text-info text-uppercase mb-1">Total Nominal Seluruh Tagihan</div>
                            <div class="h4 fw-bolder mb-0 text-dark">Rp {{ number_format($totalNominal, 0, ',', '.') }}</div>
                        </div>
                        <i class="fas fa-money-bill-wave fa-3x text-info opacity-25"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- ========================================================= --}}
    {{-- 3. TABEL/CARD LIST DAFTAR TAGIHAN --}}
    {{-- ========================================================= --}}
    <div class="card shadow-lg mb-4 rounded-4">
        {{-- Header Card --}}
        <div class="card-header py-3 bg-primary text-white rounded-top-4">
            <h6 class="m-0 fw-bold fs-5"><i class="fas fa-table me-2"></i> Daftar Tagihan Keseluruhan</h6>
            <p class="mb-0 small text-white-50">Tabel ringkas informasi tagihan santri.</p>
        </div>
        <div class="card-body p-4">
            
            {{-- ========================================================= --}}
            {{-- 1. Tampilan Desktop (Tabel) --}}
            {{-- ========================================================= --}}
            <div class="table-responsive d-none d-md-block">
                <table class="table table-hover table-striped align-middle mb-0" id="dataTable" width="100%" cellspacing="0">
                    <thead class="table-dark text-nowrap">
                        <tr>
                            <th class="text-center" style="width: 5%;">No</th>
                            <th style="width: 25%;">Santri & Kelas</th>
                            <th style="width: 15%;">Jenis Tagihan</th>
                            <th class="text-end" style="width: 15%;">Jumlah</th>
                            <th style="width: 15%;">Tgl. Dibuat</th>
                            <th style="width: 15%;">Jatuh Tempo</th>
                            <th class="text-center" style="width: 10%;">Status</th>
                            <th class="text-center" style="width: 10%;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($tagihans as $index => $tagihan)
                            <tr>
                                <td class="text-center">{{ $index + 1 }}</td>
                                <td>
                                    <div class="fw-bolder text-dark">{{ $tagihan->santri->nama_lengkap ?? 'N/A' }}</div>
                                    <small class="text-secondary"><i class="fas fa-school me-1"></i> {{ $tagihan->santri->kelas->nama_kelas ?? 'N/A' }}</small>
                                </td>
                                <td>
                                    <span class="badge bg-secondary p-2 fw-semibold rounded-pill">{{ $tagihan->jenis_tagihan }}</span>
                                </td>
                                <td class="text-end fw-bolder text-primary">
                                    Rp {{ number_format($tagihan->jumlah_tagihan, 0, ',', '.') }}
                                </td>
                                <td><small class="text-muted">{{ \Carbon\Carbon::parse($tagihan->tanggal_tagihan)->translatedFormat('d M Y') }}</small></td>
                                <td>
                                    @php
                                        $dueDate = \Carbon\Carbon::parse($tagihan->tanggal_jatuh_tempo);
                                        $isOverdue = $tagihan->status != 'Lunas' && $dueDate->isPast();
                                    @endphp
                                    <span class="{{ $isOverdue ? 'fw-bolder text-danger' : 'text-success' }}">
                                        {{ $dueDate->translatedFormat('d M Y') }}
                                    </span>
                                    @if ($isOverdue)
                                        <span class="badge bg-danger ms-1 fw-bold rounded-pill">LEWAT</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    @if ($tagihan->status == 'Lunas')
                                        <span class="badge bg-success p-2 fw-bold w-100 rounded-pill"><i class="fas fa-check-circle"></i> Lunas</span>
                                    @else
                                        <span class="badge bg-warning p-2 fw-bold text-dark w-100 rounded-pill"><i class="fas fa-clock"></i> Belum Lunas</span>
                                    @endif
                                </td>
                                <td class="text-center text-nowrap">
                                    {{-- Tombol Aksi Desktop dengan Jarak (me-1) --}}
                                    <a href="{{ route('admin.tagihan.show', $tagihan) }}" class="btn btn-primary btn-sm rounded-pill shadow-sm me-1" title="Detail">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.tagihan.edit', $tagihan) }}" class="btn btn-warning btn-sm rounded-pill shadow-sm me-1" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('admin.tagihan.destroy', $tagihan) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm rounded-pill shadow-sm" title="Hapus" onclick="return confirm('APAKAH YAKIN? Menghapus tagihan ini akan menghapus data permanen.')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center py-5 bg-light rounded-bottom-4">
                                    <i class="fas fa-box-open fa-3x text-muted mb-3"></i>
                                    <h5 class="mb-0 fw-bold">Tidak ada data tagihan yang ditemukan.</h5>
                                    <p class="mb-0 mt-2">Silakan klik tombol "Buat Tagihan Baru" di atas untuk memulai.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- ========================================================= --}}
            {{-- 2. Tampilan Mobile (Card List) --}}
            {{-- ========================================================= --}}
            <div class="d-md-none px-0">
                @forelse ($tagihans as $index => $tagihan)
                    @php
                        $dueDate = \Carbon\Carbon::parse($tagihan->tanggal_jatuh_tempo);
                        $isOverdue = $tagihan->status != 'Lunas' && $dueDate->isPast();
                        $statusClass = $tagihan->status == 'Lunas' ? 'border-success' : ($isOverdue ? 'border-danger' : 'border-warning');
                    @endphp
                    
                    {{-- Card utama dengan shadow, border kiri, dan efek tap --}}
                    <div class="card mb-3 mobile-tagihan-card rounded-3 border-start border-2 {{ $statusClass }}">
                        <div class="card-body p-3">
                            
                            {{-- Baris 1: Nama Santri & Status --}}
                            <div class="d-flex justify-content-between align-items-start border-bottom pb-2 mb-2">
                                <div>
                                    <h6 class="mb-0 mobile-detail-text"><i class="fas fa-hashtag me-1"></i> ID {{ $index + 1 }}</h6>
                                    {{-- Nama Santri dibuat bold dan lebih kecil --}}
                                    <h5 class="card-title text-dark mb-0 mobile-card-title">{{ $tagihan->santri->nama_lengkap ?? 'N/A' }}</h5>
                                    <small class="mobile-detail-text"><i class="fas fa-school me-1"></i> Kelas: {{ $tagihan->santri->kelas->nama_kelas ?? 'N/A' }}</small>
                                </div>
                                <div class="text-end">
                                    {{-- Status badge --}}
                                    @if ($tagihan->status == 'Lunas')
                                        <span class="badge bg-success mobile-badge fw-bold rounded-pill"><i class="fas fa-check-circle"></i> Lunas</span>
                                    @else
                                        <span class="badge bg-warning mobile-badge fw-bold text-dark rounded-pill"><i class="fas fa-clock"></i> Belum Lunas</span>
                                    @endif
                                </div>
                            </div>
                            
                            {{-- Baris 2: Jumlah & Jenis Tagihan (Menggunakan grid 50/50) --}}
                            <div class="row pt-2 pb-2 align-items-center">
                                <div class="col-6">
                                    <h6 class="mobile-detail-text mb-1 text-uppercase">Jumlah Tagihan</h6>
                                    {{-- Jumlah (Paling Menonjol) --}}
                                    <span class="fw-bolder mobile-amount-text text-primary">Rp {{ number_format($tagihan->jumlah_tagihan, 0, ',', '.') }}</span>
                                </div>
                                <div class="col-6 text-end">
                                    <h6 class="mobile-detail-text mb-1 text-uppercase">Jenis Tagihan</h6>
                                    {{-- Jenis tagihan badge --}}
                                    <span class="badge bg-secondary mobile-badge fw-semibold rounded-pill">{{ $tagihan->jenis_tagihan }}</span>
                                </div>
                            </div>
                            <hr class="my-2">

                            {{-- Baris 3: Tanggal & Jatuh Tempo (Menggunakan flexbox) --}}
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <div>
                                    <h6 class="mobile-detail-text mb-1 text-uppercase">Tgl. Dibuat</h6>
                                    <small class="fw-semibold mobile-detail-text">{{ \Carbon\Carbon::parse($tagihan->tanggal_tagihan)->translatedFormat('d M Y') }}</small>
                                </div>
                                <div class="text-end">
                                    <h6 class="mobile-detail-text mb-1 text-uppercase">Jatuh Tempo</h6>
                                    {{-- Tanggal Jatuh Tempo --}}
                                    <span class="{{ $isOverdue ? 'fw-bolder text-danger' : 'fw-bold text-success' }} mobile-detail-text">
                                        {{ $dueDate->translatedFormat('d M Y') }}
                                    </span>
                                    @if ($isOverdue)
                                        <small class="badge bg-danger ms-1 rounded-pill mobile-detail-text">LEWAT</small>
                                    @endif
                                </div>
                            </div>
                            
                            {{-- Aksi --}}
                            <div class="d-grid gap-2 d-sm-flex justify-content-sm-end pt-2 border-top">
                                <a href="{{ route('admin.tagihan.show', $tagihan) }}" class="btn btn-sm btn-primary fw-semibold rounded-pill mobile-action-btn" title="Detail">
                                    <i class="fas fa-eye me-1"></i> Detail
                                </a>
                                <a href="{{ route('admin.tagihan.edit', $tagihan) }}" class="btn btn-sm btn-warning fw-semibold rounded-pill mobile-action-btn" title="Edit Data">
                                    <i class="fas fa-edit me-1"></i> Edit
                                </a>
                                
                                <form action="{{ route('admin.tagihan.destroy', $tagihan) }}" method="POST" class="d-inline d-grid">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger fw-semibold rounded-pill mobile-action-btn" title="Hapus Tagihan" onclick="return confirm('APAKAH YAKIN? Menghapus tagihan ini akan menghapus data permanen.')">
                                        <i class="fas fa-trash me-1"></i> Hapus
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-5 text-muted bg-light rounded-3 shadow-sm">
                        <i class="fas fa-box-open fa-3x text-muted mb-3"></i>
                        <h5 class="mb-0 fw-bold">Tidak ada data tagihan yang ditemukan.</h5>
                        <p class="mb-0 mt-2">Silakan klik tombol "Buat Tagihan Baru" di atas untuk memulai.</p>
                        <a href="{{ route('admin.tagihan.create') }}" class="btn btn-sm btn-primary mt-3 rounded-pill px-3">Buat Tagihan Pertama</a>
                    </div>
                @endforelse
            </div>

        </div>
    </div>
</div>
@endsection