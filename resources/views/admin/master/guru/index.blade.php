@extends('layouts.admin')

@section('title', 'Data Guru')
@section('page_title', 'Daftar Guru')

@section('header_actions')
    {{-- Tombol Tambah Guru --}}
    <a href="{{ route('admin.guru.create') }}" class="btn btn-primary shadow-sm rounded-pill d-flex align-items-center fw-semibold px-3">
        <i class="fas fa-plus me-2"></i>
        Tambah Guru Baru
    </a>
@endsection

@section('content')

<div class="container-fluid">
    <div class="row">
        <div class="col-12">

            <h2 class="mb-4 text-dark fw-bold">🧑‍🏫 Data Guru</h2>

            {{-- Slot untuk Notifikasi Sukses/Gagal --}}
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show rounded-3 shadow-sm" role="alert">
                    <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="card shadow-lg border-0 rounded-4">
                
                <div class="card-header bg-primary text-white p-4 rounded-top-4">
                    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center">
                        <h5 class="mb-2 mb-md-0 fw-bold fs-5"><i class="fas fa-chalkboard-teacher me-2"></i> Daftar Data Guru</h5>
                        
                        {{-- Search dan Filter Bar yang lebih responsif --}}
                        <div class="w-100 w-md-auto mt-2 mt-md-0">
                            <form action="{{ route('admin.guru.index') }}" method="GET" class="d-flex input-group input-group-sm">
                                <input type="text" name="search" class="form-control" placeholder="Cari Nama/NUPTK..." value="{{ request('search') }}">
                                <button type="submit" class="btn btn-outline-light" title="Cari Data"><i class="fas fa-search"></i></button>
                                @if(request('search'))
                                    <a href="{{ route('admin.guru.index') }}" class="btn btn-outline-danger" title="Hapus Pencarian"><i class="fas fa-times"></i></a>
                                @endif
                            </form>
                        </div>
                    </div>
                </div>
                
                <div class="card-body p-0">
                    
                    {{-- ========================================================= --}}
                    {{-- 1. Tampilan Desktop (Tabel) --}}
                    {{-- ========================================================= --}}
                    <div class="table-responsive d-none d-md-block">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-dark text-nowrap">
                                <tr>
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
                                        <td class="text-center">{{ $loop->iteration }}</td>
                                        <td class="fw-semibold text-dark">{{ $guru->nama_lengkap }}</td>
                                        <td><span class="fw-bold text-secondary text-nowrap">{{ $guru->nuptk }}</span></td>
                                        <td><span class="badge bg-info text-dark fw-bold">{{ $guru->jabatan }}</span></td>
                                        <td><span class="fw-semibold text-nowrap">{{ $guru->no_hp }}</span></td>
                                        <td class="text-center text-nowrap">
                                            {{-- Tombol Aksi --}}
                                            <div class="btn-group" role="group">
                                                <a href="{{ route('admin.guru.show', $guru) }}" class="btn btn-sm btn-outline-primary" title="Lihat Detail">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a href="{{ route('admin.guru.edit', $guru) }}" class="btn btn-sm btn-outline-warning" title="Edit Data">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                
                                                {{-- Form Hapus --}}
                                                <form action="{{ route('admin.guru.destroy', $guru) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger" title="Hapus Data" onclick="return confirm('APAKAH YAKIN? Anda akan menghapus data guru: {{ $guru->nama_lengkap }}?')">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center py-5 text-muted bg-light">
                                            <i class="fas fa-exclamation-circle me-2 fa-3x mb-3 text-secondary"></i>
                                            <h5 class="mb-0 fw-bold">Tidak ada data guru yang ditemukan.</h5>
                                            <p class="mb-0 mt-2">Silakan tambahkan data guru baru atau cek kembali kata kunci pencarian Anda.</p>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    
                    {{-- ========================================================= --}}
                    {{-- 2. Tampilan Mobile (Card List) --}}
                    {{-- ========================================================= --}}
                    <div class="d-md-none p-3">
                        @forelse ($gurus as $index => $guru)
                            <div class="card mb-3 shadow-sm rounded-3 border-start border-4 border-primary">
                                <div class="card-body p-3">
                                    
                                    {{-- Baris Utama: Nama & Jabatan --}}
                                    <div class="d-flex justify-content-between align-items-start mb-2 pb-2 border-bottom">
                                        <h5 class="card-title fw-bold text-primary mb-0">{{ $index + 1 }}. {{ $guru->nama_lengkap }}</h5>
                                        <span class="badge bg-info p-2 fw-bold text-dark text-nowrap">{{ $guru->jabatan }}</span>
                                    </div>
                                    
                                    {{-- Detail Info --}}
                                    <div class="row small g-2 mb-3">
                                        <div class="col-12">
                                            <p class="mb-1"><i class="fas fa-fingerprint me-2 text-secondary"></i> NUPTK: <span class="fw-bold text-dark">{{ $guru->nuptk }}</span></p>
                                        </div>
                                        <div class="col-12">
                                            <p class="mb-0"><i class="fas fa-phone me-2 text-secondary"></i> No HP:<span class="fw-semibold">{{ $guru->no_hp }}</span></p>
                                        </div>
                                    </div>

                                    {{-- Aksi (Dibuat full-width button group) --}}
                                    <div class="d-grid gap-2 d-sm-flex justify-content-sm-end pt-2">
                                        {{-- Tombol Aksi Mobile --}}
                                        <a href="{{ route('admin.guru.show', $guru) }}" class="btn btn-sm btn-outline-primary fw-semibold flex-fill" title="Lihat Detail">
                                            <i class="fas fa-eye me-1"></i> Detail
                                        </a>
                                        <a href="{{ route('admin.guru.edit', $guru) }}" class="btn btn-sm btn-warning text-dark fw-semibold flex-fill" title="Edit Data">
                                            <i class="fas fa-edit me-1"></i> Edit
                                        </a>
                                        
                                        {{-- Form Hapus Mobile --}}
                                        <form action="{{ route('admin.guru.destroy', $guru) }}" method="POST" class="d-inline flex-fill">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger w-100 fw-semibold" title="Hapus Data" onclick="return confirm('APAKAH YAKIN? Anda akan menghapus data guru: {{ $guru->nama_lengkap }}?')">
                                                <i class="fas fa-trash me-1"></i> Hapus
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-5 text-muted bg-light rounded-3 shadow-sm">
                                <i class="fas fa-exclamation-circle me-2 fa-3x mb-3 text-secondary"></i>
                                <h5 class="mb-0 fw-bold">Tidak ada data guru yang ditemukan.</h5>
                                <p class="mb-0 mt-2">Silakan tambahkan data guru baru.</p>
                            </div>
                        @endforelse
                    </div>
                    
                    {{-- Paginasi --}}
                    @if ($gurus instanceof \Illuminate\Pagination\LengthAwarePaginator)
                        <div class="card-footer bg-light border-0 pt-3 rounded-bottom-4">
                            <div class="d-flex justify-content-center justify-content-md-end">
                                {{ $gurus->links() }}
                            </div>
                        </div>
                    @endif
                    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection