@extends('layouts.admin')

@section('title', 'Riwayat Pembayaran')
@section('page_title', 'Semua Riwayat Pembayaran')

@push('styles')
<style>
    /* CSS KUSTOM KHUSUS UNTUK TAMPILAN RINGKAS */
    
    /* Penyesuaian Tabel Desktop (dibiarkan kecil seperti sebelumnya) */
    .table-hover td, .table-hover th {
        font-size: 0.85rem !important; 
    }
    .table-hover small {
        font-size: 0.75rem !important;
    }

    /* Penyesuaian Mobile (D-MD-NONE) - FOKUS UTAMA */
    @media (max-width: 767.98px) {
        /* Card umum */
        .mobile-riwayat-card {
            border: 1px solid #e5e7eb !important; 
            box-shadow: 0 1px 3px rgba(0,0,0,0.05);
        }
        
        /* Judul/Nama Santri */
        .mobile-riwayat-header {
            font-size: 0.85rem !important; /* Dikecilkan lagi */
        }
        
        /* Teks Detail (Kelas, Tanggal, Label Santri/Status) */
        .mobile-riwayat-detail {
            font-size: 0.6rem !important; /* Sangat kecil */
        }
        
        /* Nominal Bayar (Masih perlu menonjol sedikit) */
        .mobile-riwayat-amount {
             font-size: 0.95rem !important; /* Dikecilkan */
        }
        
        /* Badge Status & Tagihan */
        .mobile-riwayat-status-badge {
            font-size: 0.65rem !important; /* Sangat kecil */
            padding: 0.2em 0.4em !important;
        }
        
        /* Tombol Aksi Mobile */
        .mobile-riwayat-action-btn {
            padding: 0.25rem 0.35rem !important; 
            font-size: 0.7rem !important; /* Sangat kecil */
        }
    }
</style>
@endpush


@section('content')

<div class="container-fluid">
    <div class="row">
        <div class="col-12">

            {{-- Notifikasi Sukses/Gagal (Jika ada) --}}
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show rounded-3 shadow-sm" role="alert">
                    <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="card shadow-lg border-0 rounded-4">
                
                {{-- CARD HEADER DENGAN WARNA PRIMER --}}
                <div class="card-header bg-primary text-white p-4 rounded-top-4">
                    <h5 class="mb-0 fw-bold fs-5"><i class="fas fa-history me-2"></i> Riwayat Transaksi Pembayaran</h5>
                    <p class="text-white-50 small mb-0">Kelola dan konfirmasi semua riwayat pembayaran santri.</p>
                </div>
                
                {{-- Filter & Search Section --}}
                <div class="card-body p-4 pb-0">
                    <div class="row mb-4 align-items-center g-3">
                        
                        {{-- Search Bar --}}
                        <div class="col-12 col-md-6">
                            <form method="GET" class="d-flex" id="search-form">
                                <input type="hidden" name="status" value="{{ request('status') }}"> 
                                
                                {{-- Input grup di mobile mungkin terlihat besar, gunakan input-group standar --}}
                                <div class="input-group shadow-sm">
                                    <input type="text" name="search" class="form-control form-control-md" placeholder="Cari berdasarkan nama santri..." value="{{ request('search') }}">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-search me-1"></i>
                                        <span class="d-none d-sm-inline">Cari</span>
                                    </button>
                                    @if(request('search'))
                                        <a href="{{ route('admin.pembayaran.riwayat', ['status' => request('status')]) }}" class="btn btn-outline-danger" title="Hapus Pencarian"><i class="fas fa-times"></i></a>
                                    @endif
                                </div>
                            </form>
                        </div>
                        
                        {{-- Filter Status --}}
                        <div class="col-12 col-md-4 offset-md-2">
                            <form method="GET" id="status-filter-form">
                                <input type="hidden" name="search" value="{{ request('search') }}"> 
                                
                                {{-- Select di mobile gunakan form-select standar --}}
                                <select name="status" class="form-select form-select-md shadow-sm" onchange="document.getElementById('status-filter-form').submit()">
                                    <option value="">-- Filter Berdasarkan Status --</option>
                                    <option value="Menunggu" {{ request('status') == 'Menunggu' ? 'selected' : '' }}>Menunggu Konfirmasi</option>
                                    <option value="Dikonfirmasi" {{ request('status') == 'Dikonfirmasi' ? 'selected' : '' }}>Dikonfirmasi</option>
                                    <option value="Ditolak" {{ request('status') == 'Ditolak' ? 'selected' : '' }}>Ditolak</option>
                                </select>
                            </form>
                        </div>
                    </div>
                </div>

                {{-- Data Section (Table / Card List) --}}
                <div class="p-0">
                    
                    {{-- ========================================================= --}}
                    {{-- 1. Tampilan Desktop (Tabel) --}}
                    {{-- (Tidak berubah, menggunakan font 0.85rem) --}}
                    {{-- ========================================================= --}}
                    <div class="table-responsive d-none d-md-block">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-dark text-nowrap">
                                <tr>
                                    <th style="width: 5%;">#</th>
                                    <th style="width: 15%;">Tanggal Transaksi</th>
                                    <th style="width: 25%;">Santri & Kelas</th>
                                    <th style="width: 20%;">Jenis Tagihan</th>
                                    <th style="width: 15%;" class="text-end">Nominal Bayar</th>
                                    <th style="width: 10%;">Status</th>
                                    <th style="width: 10%;" class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($pembayarans as $pembayaran)
                                <tr> 
                                    <td><small>{{ $pembayarans->firstItem() + $loop->index }}</small></td>
                                    <td>
                                        <span class="fw-semibold">{{ $pembayaran->created_at->translatedFormat('d M Y') }}</span><br>
                                        <small class="text-muted">{{ $pembayaran->created_at->format('H:i') }} WIB</small>
                                    </td>
                                    <td>
                                        <strong class="text-dark">{{ $pembayaran->tagihan->santri->nama_lengkap ?? 'N/A' }}</strong><br>
                                        <small class="text-secondary">Kelas: {{ $pembayaran->tagihan->santri->kelas->nama_kelas ?? 'N/A' }}</small>
                                    </td>
                                    <td>
                                         <span class="badge bg-primary p-2 fw-semibold"><small>{{ $pembayaran->tagihan->jenis_tagihan ?? 'N/A' }}</small></span>
                                    </td>
                                    <td class="text-end">
                                        <span class="fw-bolder fs-6 text-success">Rp {{ number_format($pembayaran->jumlah_bayar, 0, ',', '.') }}</span>
                                    </td>
                                    <td>
                                        @php
                                            $status = $pembayaran->status_konfirmasi;
                                            $badgeClass = match($status) {
                                                'Dikonfirmasi' => 'success',
                                                'Ditolak' => 'danger',
                                                default => 'warning text-dark',
                                            };
                                        @endphp
                                        <span class="badge bg-{{ $badgeClass }} p-2 fw-semibold"><small>{{ $status }}</small></span>
                                    </td>
                                    <td class="text-center text-nowrap">
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('admin.tagihan.show', $pembayaran->tagihan_id) }}" class="btn btn-sm btn-primary small" title="Lihat Detail & Konfirmasi">
                                                <i class="fas fa-clipboard-check"></i> Detail
                                            </a>
                                            @if($pembayaran->bukti_pembayaran)
                                                <a href="{{ Storage::url($pembayaran->bukti_pembayaran) }}" target="_blank" class="btn btn-sm btn-info text-white small" title="Lihat Bukti Bayar">
                                                    <i class="fas fa-file-image"></i>
                                                </a>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7" class="text-center py-5 bg-light">
                                        <i class="fas fa-receipt fa-3x text-muted mb-3"></i>
                                        <h5 class="mb-0 fw-bold">Tidak ada riwayat pembayaran yang ditemukan.</h5>
                                        <p class="text-muted">Coba reset filter atau gunakan kata kunci lain.</p>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    {{-- ========================================================= --}}
                    {{-- 2. Tampilan Mobile (Card List) --}}
                    {{-- (Menggunakan kelas font yang sangat kecil) --}}
                    {{-- ========================================================= --}}
                    <div class="d-md-none p-4 pt-0">
                        @forelse($pembayarans as $pembayaran)
                            @php
                                $status = $pembayaran->status_konfirmasi;
                                $badgeClass = match($status) {
                                    'Dikonfirmasi' => 'success',
                                    'Ditolak' => 'danger',
                                    default => 'warning text-dark',
                                };
                            @endphp
                            {{-- Border kiri berdasarkan status --}}
                            <div class="card mb-3 mobile-riwayat-card rounded-3 border-start border-2 border-{{ $badgeClass }}">
                                <div class="card-body p-3">
                                    
                                    {{-- Baris 1: Santri & Kelas --}}
                                    <div class="d-flex justify-content-between align-items-start mb-2 border-bottom pb-2">
                                        <div>
                                            <h6 class="text-muted mb-0 mobile-riwayat-detail fw-normal">SANTRI ({{ $pembayarans->firstItem() + $loop->index }})</h6>
                                            <h5 class="card-title fw-bold text-dark mb-1 mobile-riwayat-header">{{ $pembayaran->tagihan->santri->nama_lengkap ?? 'N/A' }}</h5>
                                            <small class="text-secondary mobile-riwayat-detail fw-normal">Kelas: {{ $pembayaran->tagihan->santri->kelas->nama_kelas ?? 'N/A' }}</small>
                                        </div>
                                        {{-- Jenis Tagihan --}}
                                        <span class="badge bg-primary fw-semibold mobile-riwayat-status-badge">{{ $pembayaran->tagihan->jenis_tagihan ?? 'N/A' }}</span>
                                    </div>

                                    
                                    {{-- Baris 2: Status, Nominal dan Tanggal --}}
                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                        <div>
                                            <span class="text-muted mobile-riwayat-detail d-block fw-normal">STATUS</span>
                                            <span class="badge bg-{{ $badgeClass }} fw-bold mobile-riwayat-status-badge">{{ $status }}</span>
                                        </div>
                                        <div class="text-end">
                                            <span class="text-muted mobile-riwayat-detail d-block fw-normal">NOMINAL BAYAR</span>
                                            <span class="fw-bolder text-success mobile-riwayat-amount">Rp {{ number_format($pembayaran->jumlah_bayar, 0, ',', '.') }}</span>
                                        </div>
                                    </div>
                                    
                                    <div class="text-end mobile-riwayat-detail text-muted border-top pt-2 fw-normal">
                                        <i class="fas fa-clock me-1"></i> 
                                        Transaksi: {{ $pembayaran->created_at->translatedFormat('d M Y, H:i') }}
                                    </div>
                                    
                                    {{-- Baris 3: Aksi --}}
                                    <div class="d-grid gap-2 d-sm-flex justify-content-sm-end pt-3">
                                        <a href="{{ route('admin.tagihan.show', $pembayaran->tagihan_id) }}" class="btn btn-sm btn-primary fw-semibold flex-fill mobile-riwayat-action-btn" title="Detail & Konfirmasi">
                                            <i class="fas fa-clipboard-check me-1"></i> Detail & Konfirmasi
                                        </a>
                                        @if($pembayaran->bukti_pembayaran)
                                            <a href="{{ Storage::url($pembayaran->bukti_pembayaran) }}" target="_blank" class="btn btn-sm btn-info text-white fw-semibold mobile-riwayat-action-btn" title="Lihat Bukti Bayar">
                                                <i class="fas fa-file-image me-1"></i> Bukti
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-5 text-muted bg-light rounded-3 shadow-sm mx-3">
                                <i class="fas fa-receipt fa-3x text-secondary mb-3"></i>
                                <h5 class="mb-0 fw-bold">Tidak ada riwayat pembayaran yang ditemukan.</h5>
                                <p class="text-muted">Coba reset filter atau gunakan kata kunci lain.</p>
                            </div>
                        @endforelse
                    </div>

                </div>
                
                {{-- Pagination --}}
                @if($pembayarans->hasPages())
                <div class="card-footer bg-light border-0 pt-3 rounded-bottom-4">
                    <div class="d-flex justify-content-center justify-content-md-end">
                        {{ $pembayarans->links() }}
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection