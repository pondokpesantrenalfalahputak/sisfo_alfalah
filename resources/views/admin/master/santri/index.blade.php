@extends('layouts.admin')

@section('title', 'Data Santri')
@section('page_title', 'Daftar Santri')

@section('styles')
<style>
    /* Transisi untuk elemen dinamis */
    .smooth-transition {
        transition: all 0.3s ease-in-out;
    }
    /* Efek hover pada baris tabel */
    .table-hover tbody tr:hover {
        background-color: #f8f9fa !important;
        transform: scale(1.005);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.05);
    }
    /* Tombol Aksi di mobile lebih kecil dan ringkas */
    @media (max-width: 767.98px) {
        /* Memperkecil tombol Tambah Santri di header mobile */
        .btn-header-mobile {
            padding: 0.5rem 1rem !important;
            font-size: 0.875rem !important;
        }
        .btn-header-mobile i {
            font-size: 0.8rem;
        }
        /* Mengubah tata letak header_actions di mobile agar rapi */
        .header-action-container {
            width: 100%;
            display: flex;
            justify-content: flex-end;
            margin-top: 1rem; /* Memberi jarak dari page title */
        }
    }
</style>
@endsection

@section('header_actions')
    {{-- Tombol Tambah Santri - Diperkecil di mobile --}}
    {{-- Menggunakan d-inline-block d-md-block untuk mengontrol display --}}
    <div class="header-action-container d-none d-md-block">
        <a href="{{ route('admin.santri.create') }}" class="btn btn-primary d-flex align-items-center fw-semibold px-4 py-2 border-0 shadow-sm rounded-3 smooth-transition">
            <i class="fas fa-plus me-2"></i>
            Tambah Santri Baru
        </a>
    </div>
@endsection

@section('content')

<div class="container-fluid">
    <div class="row">
        <div class="col-12">

            {{-- Slot untuk Notifikasi Sukses/Gagal --}}
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show rounded-3 shadow-sm border-0" role="alert">
                    <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            
            {{-- Tombol Tambah Santri di mobile (Diposisikan di atas card) --}}
            <div class="d-flex justify-content-end mb-3 d-md-none">
                <a href="{{ route('admin.santri.create') }}" class="btn btn-primary btn-header-mobile d-flex align-items-center fw-semibold border-0 shadow-sm rounded-3 smooth-transition">
                    <i class="fas fa-plus me-1"></i> Tambah Baru
                </a>
            </div>

            @php
                $perPage = $santris instanceof \Illuminate\Pagination\LengthAwarePaginator ? $santris->perPage() : 10;
                $currentPage = $santris instanceof \Illuminate\Pagination\LengthAwarePaginator ? $santris->currentPage() : 1;
                $startIndex = ($currentPage - 1) * $perPage;
            @endphp

            <div class="card shadow-lg border-0 rounded-4 smooth-transition">
                
                {{-- CARD HEADER: Search Bar yang Lebih Halus --}}
                <div class="card-header bg-white border-bottom-0 p-4 rounded-top-4">
                    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center">
                        
                        {{-- Search Bar Modern --}}
                        <div class="w-100 w-md-auto mt-2 mt-md-0">
                            <form action="{{ route('admin.santri.index') }}" method="GET" class="d-flex input-group input-group-sm rounded-pill overflow-hidden shadow-sm border border-light-subtle">
                                <input type="text" name="search" class="form-control border-0 ps-3" placeholder="Cari NISN atau Nama..." value="{{ request('search') }}">
                                <button type="submit" class="btn btn-primary text-white border-0" title="Cari Data"><i class="fas fa-search"></i></button>
                                @if(request('search'))
                                    {{-- Tombol reset pencarian --}}
                                    <a href="{{ route('admin.santri.index') }}" class="btn btn-secondary text-white border-0" title="Hapus Pencarian"><i class="fas fa-times"></i></a>
                                @endif
                            </form>
                        </div>
                    </div>
                </div>
                
                <div class="card-body p-0">
                    
                    {{-- ========================================================= --}}
                    {{-- 1. Tampilan Desktop (Tabel Minimalis & Halus) --}}
                    {{-- ========================================================= --}}
                    <div class="table-responsive d-none d-md-block">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="bg-primary-subtle text-primary fw-bold">
                                <tr>
                                    <th style="width: 5%;" class="text-center">#</th>
                                    <th style="width: 10%;">NISN</th>
                                    <th style="width: 20%;">Nama Lengkap</th>
                                    <th style="width: 15%;">Kelas</th>
                                    <th style="width: 15%;">Wali Santri</th>
                                    <th style="width: 10%;">J. Kelamin</th>
                                    <th style="width: 10%;">Status</th>
                                    <th style="width: 15%;" class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($santris as $index => $santri)
                                <tr class="border-bottom-0 smooth-transition">
                                    <td class="text-center text-muted small">{{ $startIndex + $index + 1 }}</td>
                                    <td class="fw-bold text-dark">{{ $santri->nisn }}</td>
                                    <td class="fw-semibold text-primary">{{ $santri->nama_lengkap }}</td>
                                    <td>
                                        <span class="badge rounded-pill bg-info-subtle text-info fw-bold px-3 py-1">{{ $santri->kelas?->nama_kelas ?? 'Tanpa Kelas' }}</span>
                                    </td>
                                    <td><span class="text-muted small">{{ $santri->waliSantri?->name ?? '-' }}</span></td>
                                    <td>{{ $santri->jenis_kelamin }}</td>
                                    <td>
                                        <span class="badge rounded-pill bg-{{ $santri->status == 'Aktif' ? 'success' : 'secondary' }} text-white fw-bold px-3 py-1">
                                            {{ $santri->status }}
                                        </span>
                                    </td>
                                    <td class="text-center text-nowrap">
                                        {{-- Tombol Aksi Minimalis --}}
                                        <div class="btn-group btn-group-sm smooth-transition" role="group">
                                            <a href="{{ route('admin.santri.show', $santri) }}" class="btn btn-outline-primary" title="Lihat Detail">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('admin.santri.edit', $santri) }}" class="btn btn-outline-warning" title="Edit Data">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            
                                            {{-- Form Hapus --}}
                                            <form action="{{ route('admin.santri.destroy', $santri) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-outline-danger delete-confirm" title="Hapus Data" data-santri="{{ $santri->nama_lengkap }}">
                                                    <i class="fas fa-trash"></i>
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
                    {{-- 2. Tampilan Mobile (Card List Halus) - SUDAH DIPERBAIKI --}}
                    {{-- ========================================================= --}}
                    <div class="d-md-none p-3">
                        @forelse($santris as $index => $santri)
                            <div class="card mb-3 shadow-sm rounded-3 border-0 smooth-transition">
                                <div class="card-body p-3">
                                    {{-- Konten Mobile Header --}}
                                    <div class="d-flex justify-content-between align-items-start mb-3 border-bottom pb-2">
                                        <div>
                                            <h6 class="text-muted mb-0 small">
                                                #{{ $startIndex + $index + 1 }} | NISN: 
                                                <span class="fw-bold text-dark">{{ $santri->nisn }}</span>
                                            </h6>
                                            <h5 class="card-title fw-bold text-primary mb-1 mt-1">{{ $santri->nama_lengkap }}</h5>
                                        </div>
                                        <span class="badge rounded-pill bg-{{ $santri->status == 'Aktif' ? 'success' : 'secondary' }} text-white p-2 fw-bold align-self-center">
                                            {{ $santri->status }}
                                        </span>
                                    </div>
                                    
                                    {{-- Data Detail Vertikal (col-12) --}}
                                    <div class="row small g-2 mb-4">
                                        {{-- Kelas: col-12 --}}
                                        <div class="col-12 mb-2"> 
                                            <span class="text-muted d-block fw-normal small">Kelas</span>
                                            <span class="badge rounded-pill bg-info-subtle text-info fw-bold">{{ $santri->kelas?->nama_kelas ?? 'Tanpa Kelas' }}</span>
                                        </div>
                                        
                                        {{-- Jenis Kelamin: col-12 (Perbaikan) --}}
                                        <div class="col-12">
                                            <span class="text-muted d-block fw-normal small">Jenis Kelamin</span>
                                            <span class="fw-semibold text-dark">{{ $santri->jenis_kelamin }}</span>
                                        </div>
                                        
                                        {{-- Wali Santri: col-12 --}}
                                        <div class="col-12 mt-2">
                                            <span class="text-muted d-block fw-normal small">Wali Santri</span>
                                            <span class="fw-bold text-secondary">{{ $santri->waliSantri?->name ?? '-' }}</span>
                                        </div>
                                    </div>

                                    {{-- Aksi --}}
                                    <div class="d-flex gap-2 pt-2 border-top">
                                        
                                        <a href="{{ route('admin.santri.show', $santri) }}" class="btn btn-sm btn-outline-primary fw-semibold w-100 smooth-transition" title="Lihat Detail">
                                            <i class="fas fa-eye me-1"></i> Detail
                                        </a>
                                        <a href="{{ route('admin.santri.edit', $santri) }}" class="btn btn-sm btn-outline-warning fw-semibold w-100 smooth-transition" title="Edit Data">
                                            <i class="fas fa-edit me-1"></i> Edit
                                        </a>
                                        
                                        <form action="{{ route('admin.santri.destroy', $santri) }}" method="POST" class="d-inline w-100">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger w-100 fw-semibold delete-confirm smooth-transition" title="Hapus Data" data-santri="{{ $santri->nama_lengkap }}">
                                                <i class="fas fa-trash me-1"></i> Hapus
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-5 text-muted bg-white rounded-4 shadow-sm border">
                                <i class="fas fa-box-open me-2 fa-3x mb-3 text-secondary"></i>
                                <h5 class="mb-0 fw-bold">Tidak ada data santri.</h5>
                                <p class="mb-0 mt-2">Silakan klik tombol "Tambah Santri Baru".</p>
                            </div>
                        @endforelse
                    </div>
                    
                    
                    {{-- Paginasi --}}
                    @if ($santris instanceof \Illuminate\Pagination\LengthAwarePaginator)
                        <div class="card-footer bg-light border-0 pt-3 rounded-bottom-4">
                            <div class="d-flex flex-column flex-md-row justify-content-between align-items-center small text-muted">
                                <div class="mb-2 mb-md-0">
                                    Menampilkan { $santris->firstItem() ?? 0 }} hingga {{ $santris->lastItem() ?? 0 }} dari {{ $santris->total() }} data
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