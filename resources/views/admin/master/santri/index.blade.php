@extends('layouts.admin')

@section('title', 'Data Santri')
@section('page_title', 'Daftar Santri')

@section('styles')
<style>
    /* Transisi Halus */
    .smooth-transition {
        transition: all 0.2s ease-in-out;
    }
    
    /* Tabel Desktop: Kerapian dan Keselarasan */
    .table-desktop thead th {
        background-color: var(--bs-primary) !important;
        color: #fff;
        font-size: 0.8rem;
        padding: 0.75rem 0.5rem;
        vertical-align: middle;
        text-transform: uppercase;
        font-weight: 600;
        border-color: var(--bs-primary) !important;
    }
    .table-desktop tbody td {
        font-size: 0.85rem; 
        padding: 0.75rem 0.5rem;
        vertical-align: middle;
    }
    .table-hover tbody tr:hover {
        background-color: var(--bs-light) !important;
    }
    
    /* Search Bar Standard */
    .search-input-group {
        border-radius: 0.5rem;
    }

    /* Card Mobile: Struktur Description List (dl) untuk kerapian Label/Value */
    .santri-card-mobile {
        border: 1px solid var(--bs-gray-300);
        border-radius: 0.5rem;
        box-shadow: none;
    }
    
    /* Description List (dl) Styling */
    .dl-data-santri dt {
        font-size: 0.75rem;
        color: var(--bs-secondary); 
        text-transform: uppercase;
        font-weight: 500;
        margin-right: 0.5rem;
        width: 40%; 
    }
    .dl-data-santri dd {
        font-size: 0.875rem;
        font-weight: 600;
        margin-bottom: 0.5rem;
        width: 60%;
    }
    .dl-data-santri {
        margin-bottom: 0 !important;
    }

    /* === PERBAIKAN UTAMA: TOMBOL AKSI MOBILE SANGAT COMPACT (HANYA IKON) === */
    .action-mobile-container .btn {
        padding: 0.4rem 0.5rem !important; /* Padding sangat kecil */
        font-size: 0.7rem !important; /* Ukuran font ikon/teks sangat kecil */
        flex-grow: 1; /* Agar membagi ruang secara merata */
    }
    .action-mobile-container .btn i {
        font-size: 0.85rem; /* Ukuran ikon sedikit lebih besar dari font container */
    }
    
    /* Penyesuaian Tombol Header Mobile */
    @media (max-width: 767.98px) {
        .btn-header-mobile {
            padding: 0.4rem 0.8rem !important;
            font-size: 0.8rem !important;
        }
    }
</style>
@endsection

@section('header_actions')
    {{-- Tombol Tambah Santri - Desktop Version --}}
    <div class="d-none d-md-block">
        <a href="{{ route('admin.santri.create') }}" class="btn btn-primary d-flex align-items-center fw-semibold px-4 py-2 border-0 shadow-sm rounded-3 smooth-transition">
            <i class="fas fa-user-plus me-2"></i>
            Tambah Santri Baru
        </a>
    </div>
@endsection

@section('content')

<div class="container-fluid">
    <div class="row">
        <div class="col-12">

            {{-- Tombol Tambah Santri di mobile (Diposisikan di atas card) --}}
            <div class="d-flex justify-content-end mb-3 d-md-none">
                <a href="{{ route('admin.santri.create') }}" class="btn btn-primary btn-header-mobile d-flex align-items-center fw-semibold border-0 shadow-sm rounded-3 smooth-transition">
                    <i class="fas fa-user-plus me-1"></i> Tambah Baru
                </a>
            </div>

            @php
                $perPage = $santris instanceof \Illuminate\Pagination\LengthAwarePaginator ? $santris->perPage() : 10;
                $currentPage = $santris instanceof \Illuminate\Pagination\LengthAwarePaginator ? $santris->currentPage() : 1;
                $startIndex = ($currentPage - 1) * $perPage;
            @endphp

            {{-- CARD UTAMA DATA SANTRI (Minimal Shadow) --}}
            <div class="card shadow-sm border-0 rounded-4 smooth-transition">
                
                {{-- CARD HEADER: Search Bar --}}
                <div class="card-header bg-white border-bottom-0 p-4 rounded-top-4">
                    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
                        
                        {{-- Search Bar Standard --}}
                        <div class="w-100 w-md-50">
                            <form action="{{ route('admin.santri.index') }}" method="GET" class="d-flex search-input-group border border-light-subtle">
                                <input type="text" name="search" class="form-control border-0 ps-3" placeholder="Cari NIS atau Nama santri..." value="{{ request('search') }}">
                                <button type="submit" class="btn btn-primary text-white border-0 rounded-start-0" title="Cari Data"><i class="fas fa-search"></i></button>
                                @if(request('search'))
                                    <a href="{{ route('admin.santri.index') }}" class="btn btn-secondary text-white border-0 rounded-start-0" title="Hapus Pencarian"><i class="fas fa-times"></i></a>
                                @endif
                            </form>
                        </div>
                    </div>
                </div>
                
                <div class="card-body p-0">
                    
                    {{-- ========================================================= --}}
                    {{-- 1. Tampilan Desktop (Tabel Standar Bootstrap Rapi) --}}
                    {{-- ========================================================= --}}
                    <div class="table-responsive d-none d-md-block">
                        <table class="table table-desktop table-hover align-middle mb-0">
                            <thead>
                                <tr>
                                    <th style="width: 5%;" class="text-center rounded-top-start-4">ID</th>
                                    <th style="width: 10%;">NIS</th>
                                    <th style="width: 20%;">Nama Lengkap</th>
                                    <th style="width: 15%;">Kelas</th>
                                    <th style="width: 15%;">Wali Santri</th>
                                    <th style="width: 10%;" class="text-center">J. Kelamin</th>
                                    <th style="width: 10%;" class="text-center">Status</th>
                                    <th style="width: 15%;" class="text-center rounded-top-end-4">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($santris as $index => $santri)
                                <tr class="smooth-transition">
                                    <td class="text-center text-muted small">{{ $startIndex + $index + 1 }}</td>
                                    <td class="fw-bold text-dark">{{ $santri->nisn }}</td>
                                    <td class="fw-semibold text-primary">{{ $santri->nama_lengkap }}</td>
                                    <td>
                                        <span class="badge rounded-pill bg-info-subtle text-info fw-bold px-3 py-1">{{ $santri->kelas?->nama_kelas ?? 'Tanpa Kelas' }}</span>
                                    </td>
                                    <td><span class="text-muted small">{{ $santri->waliSantri?->name ?? '-' }}</span></td>
                                    <td class="text-center"><span class="small">{{ $santri->jenis_kelamin }}</span></td>
                                    <td class="text-center">
                                        <span class="badge rounded-pill bg-{{ $santri->status == 'Aktif' ? 'success' : 'secondary' }} text-white fw-bold px-3 py-1">
                                            {{ $santri->status }}
                                        </span>
                                    </td>
                                    <td class="text-center text-nowrap">
                                        {{-- Tombol Aksi Bundar Standard --}}
                                        <div class="d-flex justify-content-center smooth-transition gap-1"> 
                                            <a href="{{ route('admin.santri.show', $santri) }}" class="btn btn-sm btn-outline-primary rounded-circle p-0" title="Lihat Detail" style="width: 28px; height: 28px;">
                                                <i class="fas fa-eye small"></i>
                                            </a>
                                            <a href="{{ route('admin.santri.edit', $santri) }}" class="btn btn-sm btn-outline-warning rounded-circle p-0" title="Edit Data" style="width: 28px; height: 28px;">
                                                <i class="fas fa-edit small"></i>
                                            </a>
                                            
                                            {{-- Form Hapus --}}
                                            <form action="{{ route('admin.santri.destroy', $santri) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger delete-confirm rounded-circle p-0" title="Hapus Data" data-santri="{{ $santri->nama_lengkap }}" style="width: 28px; height: 28px;">
                                                    <i class="fas fa-trash small"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="text-center py-5 text-muted bg-light">
                                            <i class="fas fa-box-open me-2 fa-4x mb-3 text-secondary"></i>
                                            <h4 class="mb-0 fw-bold">Data santri tidak ditemukan.</h4>
                                            <p class="mb-0 mt-2">Silakan <a href="{{ route('admin.santri.create') }}" class="text-primary fw-semibold">tambah santri baru</a>.</p>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    
                    {{-- ========================================================= --}}
                    {{-- 2. Tampilan Mobile (Description List Rapi) --}}
                    {{-- ========================================================= --}}
                    <div class="d-md-none p-3">
                        @forelse($santris as $index => $santri)
                            <div class="card mb-3 santri-card-mobile smooth-transition">
                                
                                {{-- Card Body: Nama, NISN, Status --}}
                                <div class="card-body pb-0">
                                    <div class="d-flex justify-content-between align-items-start mb-3">
                                        <div>
                                            <h5 class="card-title-mobile fw-bold text-primary mb-1">{{ $santri->nama_lengkap }}</h5>
                                            <small class="text-muted fs-6">
                                                NIS: <span class="fw-semibold text-dark">{{ $santri->nisn }}</span> 
                                                | ID{{ $startIndex + $index + 1 }}
                                            </small>
                                        </div>
                                        <span class="badge rounded-pill bg-{{ $santri->status == 'Aktif' ? 'success' : 'secondary' }} text-white fw-bold px-3 py-2 align-self-start">
                                            {{ $santri->status }}
                                        </span>
                                    </div>
                                    
                                    <hr class="mt-0 text-muted opacity-50">

                                    {{-- DETAIL DATA (Description List) --}}
                                    <dl class="row dl-data-santri">
                                        
                                        {{-- Kelas --}}
                                        <dt class="col-4">Kelas</dt>
                                        <dd class="col-8">
                                            <span class="badge rounded-pill bg-info-subtle text-info fw-bold card-data-value px-3 py-1">{{ $santri->kelas?->nama_kelas ?? 'Tanpa Kelas' }}</span>
                                        </dd>
                                        
                                        {{-- Jenis Kelamin --}}
                                        <dt class="col-4">Jenis Kelamin</dt>
                                        <dd class="col-8">
                                            <span class="fw-semibold text-dark">{{ $santri->jenis_kelamin }}</span>
                                        </dd>
                                        
                                        {{-- Wali Santri --}}
                                        <dt class="col-4">Wali Santri</dt>
                                        <dd class="col-8">
                                            <span class="fw-bold text-secondary">{{ $santri->waliSantri?->name ?? '-' }}</span>
                                        </dd>

                                    </dl>
                                </div>
                                
                                {{-- AKSI (Card Footer Rapi & Compact) --}}
                                <div class="card-footer bg-white pt-2 pb-3 border-top-0 rounded-bottom-3">
                                    <div class="d-flex gap-2 action-mobile-container">
                                        
                                        {{-- HANYA IKON UNTUK PENGHEMATAN RUANG --}}
                                        <a href="{{ route('admin.santri.show', $santri) }}" class="btn btn-outline-primary fw-semibold w-100 smooth-transition" title="Lihat Detail">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.santri.edit', $santri) }}" class="btn btn-outline-warning fw-semibold w-100 smooth-transition" title="Edit Data">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        
                                        <form action="{{ route('admin.santri.destroy', $santri) }}" method="POST" class="d-inline w-100">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-outline-danger w-100 fw-semibold delete-confirm smooth-transition" title="Hapus Data" data-santri="{{ $santri->nama_lengkap }}">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </div>

                            </div>
                        @empty
                            <div class="text-center py-5 text-muted bg-white rounded-4 shadow-sm border">
                                <i class="fas fa-box-open me-2 fa-3x mb-3 text-secondary"></i>
                                <h5 class="mb-0 fw-bold">Tidak ada data santri.</h5>
                                <p class="mb-0 mt-2">Silakan klik tombol "Tambah Baru" di atas.</p>
                            </div>
                        @endforelse
                    </div>
                    
                    
                    {{-- Paginasi --}}
                    @if ($santris instanceof \Illuminate\Pagination\LengthAwarePaginator)
                        <div class="card-footer bg-light border-0 pt-3 rounded-bottom-4">
                            <div class="d-flex flex-column flex-md-row justify-content-between align-items-center small text-muted">
                                <div class="mb-2 mb-md-0">
                                    Menampilkan {{ $santris->firstItem() ?? 0 }} hingga {{ $santris->lastItem() ?? 0 }} dari {{ $santris->total() }} data
                                </div>
                                <div>
                                    {{ $santris->appends(request()->query())->links('pagination::bootstrap-5') }}
                                </div>
                            </div>
                        </div>
                    @endif
                    
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Konfirmasi Hapus untuk konsistensi
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.delete-confirm').forEach(button => {
            button.addEventListener('click', function(e) {
                const santriName = this.getAttribute('data-santri');
                
                if (!confirm(`Apakah Anda yakin ingin menghapus santri: ${santriName}? Tindakan ini tidak dapat dibatalkan.`)) {
                    e.preventDefault();
                }
            });
        });
    });
</script>
@endsection