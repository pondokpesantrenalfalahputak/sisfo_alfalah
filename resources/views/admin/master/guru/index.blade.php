@extends('layouts.admin')

@section('title', 'Data Guru')
@section('page_title', 'Daftar Guru')

@section('styles')
<style>
    /* Global Card Style Consistency */
    .card-master {
        border-radius: 0.75rem !important;
        box-shadow: 0 0.5rem 1.5rem rgba(0, 0, 0, 0.1) !important;
        border: none !important;
    }
    .card-header-main {
        padding: 1rem 1.5rem;
    }
    
    /* MOBILE ADJUSTMENTS */
    @media (max-width: 767.98px) {
        
        /* Mengurangi padding di card body mobile */
        .card-body.p-0 > .d-md-none {
            padding: 0.75rem !important;
        }

        /* Styling Kartu Item */
        .guru-card-item {
            border: 1px solid var(--bs-gray-300) !important;
            box-shadow: none !important;
            border-radius: 0.5rem !important;
        }
        .guru-card-item .card-body {
            padding: 0.9rem !important; /* Padding kartu lebih kecil */
        }
        
        /* Nama dan Jabatan */
        .guru-card-item .card-title {
            font-size: 0.9rem !important;
            margin-bottom: 0.1rem !important;
        }
        .guru-card-item .badge {
            padding: 0.3rem 0.6rem !important;
            font-size: 0.65rem !important;
        }
        
        /* Detail Tambahan (NUPTK, No HP) */
        .guru-card-item .list-unstyled {
            font-size: 0.75rem; 
            margin-bottom: 0.75rem !important;
            padding-top: 0.5rem;
            border-top: 1px dashed var(--bs-gray-200);
            margin-top: 0.5rem;
        }
        
        /* Keterangan No Urut */
        .no-urut-mobile {
            font-size: 0.65rem;
            padding: 0.2rem 0.5rem;
            border-radius: 0.25rem;
            background-color: var(--bs-light);
        }

        /* Tombol Aksi Mobile (FOKUS PERBAIKAN - Hanya Ikon) */
        .guru-action-group .btn {
            /* Sangat kecil: fokus pada ikon */
            padding: 0.3rem 0.45rem !important; /* Padding vertikal dan horizontal diminimalkan */
            font-size: 0.7rem !important; /* Ukuran ikon */
            font-weight: 600 !important;
            border-radius: 0.3rem; 
        }
        
        /* Tombol Tambah Guru di Mobile */
        .d-md-none .mb-3 .btn-primary {
             padding: 0.5rem 1rem !important;
             font-size: 0.8rem;
        }
        
        /* Form Search di Header Mobile */
        .card-header-main {
            padding: 1rem !important;
        }
        .card-header-main .input-group-sm .form-control,
        .card-header-main .input-group-sm .btn {
            font-size: 0.8rem;
            padding: 0.5rem 0.75rem;
        }
    }
</style>
@endsection

{{-- Tombol aksi header disembunyikan di Mobile --}}
@section('header_actions')
    <a href="{{ route('admin.guru.create') }}" class="btn btn-primary btn-sm px-3 shadow-sm rounded d-flex align-items-center fw-semibold d-none d-md-flex">
        <i class="fas fa-plus me-2"></i>
        Tambah Guru Baru
    </a>
@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">

            {{-- Slot Notifikasi --}}
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show rounded-3 shadow-sm border-0" role="alert">
                    <i class="fas fa-check-circle me-2"></i> Berhasil! {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="card card-master rounded-4 overflow-hidden">
                
                {{-- Card Header: Judul dan Pencarian --}}
                <div class="card-header bg-white border-bottom card-header-main">
                    <div class="d-flex flex-column flex-md-row justify-content-end align-items-md-center">
                        
                        {{-- Form Search/Filter --}}
                        <div class="w-100 w-md-auto">
                            <form action="{{ route('admin.guru.index') }}" method="GET" class="d-flex input-group input-group-sm">
                                <input type="text" name="search" class="form-control shadow-none" placeholder="Cari Nama Pendidik..." value="{{ request('search') }}">
                                <button type="submit" class="btn btn-outline-secondary" title="Cari Data"><i class="fas fa-search"></i></button>
                                @if(request('search'))
                                    <a href="{{ route('admin.guru.index') }}" class="btn btn-outline-danger" title="Hapus Pencarian"><i class="fas fa-times"></i></a>
                                @endif
                            </form>
                        </div>
                    </div>
                    
                    {{-- Keterangan Jumlah Data --}}
                    @php
                        $totalData = ($gurus instanceof \Illuminate\Pagination\LengthAwarePaginator) ? $gurus->total() : $gurus->count();
                    @endphp
                    <p class="text-muted small mb-0 mt-3 d-none d-md-block">Total {{ $totalData }} data guru terdaftar.</p>
                </div>
                
                <div class="card-body p-0">
                    
                    {{-- 1. Tampilan Desktop (Tabel) --}}
                    <div class="table-responsive d-none d-md-block">
                        <table class="table table-striped table-hover align-middle mb-0">
                            <thead class="table-light text-nowrap">
                                <tr class="fw-bold text-uppercase small">
                                    <th style="width: 5%;" class="text-center">#</th>
                                    <th style="width: 25%;">Nama Lengkap</th>
                                    <th style="width: 15%;">NUPTK</th>
                                    <th style="width: 20%;">Jabatan</th>
                                    <th style="width: 15%;">No HP</th>
                                    <th style="width: 20%;" class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($gurus as $guru)
                                <tr>
                                    <td class="text-center text-muted small">
                                        @if ($gurus instanceof \Illuminate\Pagination\LengthAwarePaginator)
                                            {{ $loop->iteration + ($gurus->currentPage() - 1) * $gurus->perPage() }}
                                        @else
                                            {{ $loop->iteration }}
                                        @endif
                                    </td>
                                    <td class="fw-semibold text-dark">{{ $guru->nama_lengkap }}</td>
                                    <td><span class="fw-bold text-secondary text-nowrap small">{{ $guru->nuptk }}</span></td>
                                    <td><span class="badge bg-info text-dark p-2 fw-semibold text-nowrap">{{ $guru->jabatan }}</span></td>
                                    <td><span class="fw-semibold text-nowrap">{{ $guru->no_hp }}</span></td>
                                    <td class="text-center text-nowrap">
                                        {{-- Tombol Aksi Desktop --}}
                                        <div class="d-flex justify-content-center gap-2" role="group">
                                            <a href="{{ route('admin.guru.show', $guru) }}" class="btn btn-primary btn-sm" title="Lihat Detail"><i class="fas fa-eye"></i></a>
                                            <a href="{{ route('admin.guru.edit', $guru) }}" class="btn btn-warning btn-sm" title="Edit Data"><i class="fas fa-edit"></i></a>
                                            
                                            <form action="{{ route('admin.guru.destroy', $guru) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm" title="Hapus Data" onclick="return confirm('APAKAH YAKIN? Anda akan menghapus data guru: {{ $guru->nama_lengkap }}?')">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center py-5 text-muted bg-light border-0">
                                            <i class="fas fa-box-open me-2 fa-3x mb-3 text-secondary"></i>
                                            <h5 class="mb-0 fw-bold">Data guru kosong.</h5>
                                            <p class="mb-0 mt-2">Belum ada guru yang ditambahkan ke dalam sistem.</p>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    
                    {{-- 2. Tampilan Mobile (Card List) --}}
                    <div class="d-md-none p-3">
                        {{-- Tombol Tambah Baru (Mobile Only) --}}
                        <div class="mb-3">
                            <a href="{{ route('admin.guru.create') }}" class="btn btn-primary w-100 fw-semibold shadow-sm rounded-pill">
                                <i class="fas fa-plus me-1"></i> Tambah Guru Baru
                            </a>
                        </div>
                        
                        @forelse ($gurus as $guru)
                            <div class="card mb-3 guru-card-item">
                                <div class="card-body p-3">
                                    
                                    {{-- Baris Utama (Nama & Jabatan) --}}
                                    <div class="d-flex justify-content-between align-items-center mb-1">
                                        <div class="me-2">
                                            <h6 class="card-title fw-bold text-dark mb-1">{{ $guru->nama_lengkap }}</h6>
                                            <span class="badge bg-info text-dark p-1 fw-bold text-nowrap flex-shrink-0 mt-1"><i class="fas fa-user-tie me-1"></i> {{ $guru->jabatan }}</span>
                                        </div>
                                        <span class="text-muted no-urut-mobile">#{{ 
                                            ($gurus instanceof \Illuminate\Pagination\LengthAwarePaginator) ? 
                                            $loop->iteration + ($gurus->currentPage() - 1) * $gurus->perPage() : 
                                            $loop->iteration 
                                        }}</span>
                                    </div>
                                    
                                    
                                    {{-- Detail Tambahan --}}
                                    <ul class="list-unstyled small text-muted mb-3">
                                        <li class="mb-1"><i class="fas fa-fingerprint me-2 text-primary opacity-75"></i> NUPTK: <span class="fw-semibold text-dark">{{ $guru->nuptk }}</span></li>
                                        <li class="mb-1"><i class="fas fa-phone me-2 text-primary opacity-75"></i> No HP: <span class="fw-semibold text-dark">{{ $guru->no_hp }}</span></li>
                                    </ul>

                                    {{-- Aksi Mobile (3 Tombol - HANYA IKON) --}}
                                    <div class="d-flex justify-content-end pt-2 guru-action-group">
                                        <div class="d-flex gap-2" role="group">
                                            {{-- Detail --}}
                                            <a href="{{ route('admin.guru.show', $guru) }}" class="btn btn-outline-primary" title="Detail">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            {{-- Edit --}}
                                            <a href="{{ route('admin.guru.edit', $guru) }}" class="btn btn-outline-warning" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            
                                            {{-- Hapus --}}
                                            <form action="{{ route('admin.guru.destroy', $guru) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-outline-danger" title="Hapus" onclick="return confirm('Yakin ingin menghapus guru {{ $guru->nama_lengkap }}?')">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-5 text-muted bg-light rounded-3 shadow-sm">
                                <i class="fas fa-frown fa-3x mb-3 text-secondary opacity-75"></i>
                                <h5 class="mb-0 fw-bold">Data guru kosong.</h5>
                                <p class="mb-0 mt-2">Silakan klik tombol Tambah Guru Baru di atas.</p>
                            </div>
                        @endforelse
                    </div>
                    
                    
                    {{-- Paginasi --}}
                    @if ($gurus instanceof \Illuminate\Pagination\LengthAwarePaginator)
                        <div class="card-footer bg-light border-top py-3 rounded-bottom-4">
                            <div class="d-flex justify-content-center justify-content-md-end">
                                {{ $gurus->onEachSide(1)->links('pagination::bootstrap-5') }}
                            </div>
                        </div>
                    @endif
                    
                </div>
            </div>

        </div>
    </div>
</div>
@endsection