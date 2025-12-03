@extends('layouts.admin')

@section('title', 'Data Santri')
@section('page_title', 'Daftar Santri')

@section('header_actions')
    {{-- Tombol Tambah Santri --}}
    <a href="{{ route('admin.santri.create') }}" class="btn btn-primary shadow-sm rounded-pill d-flex align-items-center fw-semibold px-3">
        <i class="fas fa-plus me-2"></i>
        Tambah Santri Baru
    </a>
@endsection

@section('content')

<div class="container-fluid">
    <div class="row">
        <div class="col-12">

            <h2 class="mb-4 text-dark fw-bold">🧑‍🎓 Data Santri</h2>

            {{-- Slot untuk Notifikasi Sukses/Gagal --}}
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show rounded-3 shadow-sm" role="alert">
                    <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="card shadow-lg border-0 rounded-4">
                
                {{-- CARD HEADER DENGAN WARNA PRIMER DAN SEARCH --}}
                <div class="card-header bg-primary text-white p-4 rounded-top-4">
                    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center">
                        <h5 class="mb-2 mb-md-0 fw-bold fs-5"><i class="fas fa-users me-2"></i> Data Seluruh Santri</h5>
                        
                        {{-- Search dan Filter Bar yang lebih responsif --}}
                        <div class="w-100 w-md-auto mt-2 mt-md-0">
                            <form action="{{ route('admin.santri.index') }}" method="GET" class="d-flex input-group input-group-sm">
                                <input type="text" name="search" class="form-control" placeholder="Cari Santri/NISN..." value="{{ request('search') }}">
                                <button type="submit" class="btn btn-outline-light" title="Cari Data"><i class="fas fa-search"></i></button>
                                @if(request('search'))
                                    <a href="{{ route('admin.santri.index') }}" class="btn btn-outline-danger" title="Hapus Pencarian"><i class="fas fa-times"></i></a>
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
                                @forelse($santris as $santri)
                                <tr>
                                    <td class="text-center">{{ $loop->iteration }}</td>
                                    <td class="fw-bold text-primary">{{ $santri->nisn }}</td>
                                    <td class="fw-semibold">{{ $santri->nama_lengkap }}</td>
                                    <td>
                                        <span class="badge bg-info text-dark fw-bold">{{ $santri->kelas->nama_kelas ?? 'Belum Ada Kelas' }}</span>
                                    </td>
                                    <td>{{ $santri->waliSantri->name ?? '-' }}</td>
                                    <td>{{ $santri->jenis_kelamin }}</td>
                                    <td>
                                        <span class="badge bg-{{ $santri->status == 'Aktif' ? 'success' : 'secondary' }} text-white fw-bold">
                                            {{ $santri->status }}
                                        </span>
                                    </td>
                                    <td class="text-center text-nowrap">
                                        {{-- Tombol Aksi --}}
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('admin.santri.show', $santri) }}" class="btn btn-sm btn-outline-info" title="Lihat Detail">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('admin.santri.edit', $santri) }}" class="btn btn-sm btn-outline-warning" title="Edit Data">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            
                                            {{-- Form Hapus --}}
                                            <form action="{{ route('admin.santri.destroy', $santri) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger" title="Hapus Data" onclick="return confirm('Apakah Anda yakin ingin menghapus santri: {{ $santri->nama_lengkap }}? Tindakan ini tidak dapat dibatalkan.')">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="text-center py-5 text-muted bg-light">
                                            <i class="fas fa-exclamation-circle me-2 fa-3x mb-3 text-secondary"></i>
                                            <h5 class="mb-0 fw-bold">Tidak ada data santri yang ditemukan.</h5>
                                            <p class="mb-0 mt-2">Silakan klik tombol Tambah Santri Baru untuk memulai.</p>
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
                        @forelse($santris as $santri)
                            <div class="card mb-3 shadow-sm rounded-3 border-start border-4 border-primary">
                                <div class="card-body p-3">
                                    <div class="d-flex justify-content-between align-items-start mb-2 pb-2 border-bottom">
                                        <div>
                                            <h6 class="text-muted mb-0 small">NISN: <span class="fw-bold text-primary">{{ $santri->nisn }}</span></h6>
                                            <h5 class="card-title fw-bold text-dark mb-1">{{ $loop->iteration }}. {{ $santri->nama_lengkap }}</h5>
                                        </div>
                                        <span class="badge bg-{{ $santri->status == 'Aktif' ? 'success' : 'secondary' }} text-white p-2 fw-bold">
                                            {{ $santri->status }}
                                        </span>
                                    </div>
                                    
                                    <div class="row small g-2 mb-3">
                                        <div class="col-6">
                                            <span class="text-muted d-block fw-semibold">Kelas</span>
                                            <span class="badge bg-info text-dark fw-bold">{{ $santri->kelas->nama_kelas ?? '-' }}</span>
                                        </div>
                                        <div class="col-6">
                                            <span class="text-muted d-block fw-semibold">Jenis Kelamin</span>
                                            <span class="fw-semibold text-dark">{{ $santri->jenis_kelamin }}</span>
                                        </div>
                                        <div class="col-12 mt-2">
                                            <span class="text-muted d-block fw-semibold">Wali Santri</span>
                                            <span class="fw-bold text-secondary">{{ $santri->waliSantri->name ?? '-' }}</span>
                                        </div>
                                    </div>

                                    {{-- Aksi (Full-width buttons) --}}
                                    <div class="d-grid gap-2 d-sm-flex justify-content-sm-end pt-2">
                                        
                                        <a href="{{ route('admin.santri.show', $santri) }}" class="btn btn-sm btn-info text-white fw-semibold flex-fill" title="Lihat Detail">
                                            <i class="fas fa-eye me-1"></i> Detail
                                        </a>
                                        <a href="{{ route('admin.santri.edit', $santri) }}" class="btn btn-sm btn-warning text-dark fw-semibold flex-fill" title="Edit Data">
                                            <i class="fas fa-edit me-1"></i> Edit
                                        </a>
                                        
                                        <form action="{{ route('admin.santri.destroy', $santri) }}" method="POST" class="d-inline flex-fill">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger w-100 fw-semibold" title="Hapus Data" onclick="return confirm('Apakah Anda yakin ingin menghapus santri: {{ $santri->nama_lengkap }}? Tindakan ini tidak dapat dibatalkan.')">
                                                <i class="fas fa-trash me-1"></i> Hapus
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-5 text-muted bg-light rounded-3 shadow-sm">
                                <i class="fas fa-exclamation-circle me-2 fa-3x mb-3 text-secondary"></i>
                                <h5 class="mb-0 fw-bold">Tidak ada data santri yang ditemukan.</h5>
                                <p class="mb-0 mt-2">Silakan klik tombol Tambah Santri Baru untuk memulai.</p>
                            </div>
                        @endforelse
                    </div>
                    
                    
                    {{-- Paginasi --}}
                    @if ($santris instanceof \Illuminate\Pagination\LengthAwarePaginator)
                        <div class="card-footer bg-light border-0 pt-3 rounded-bottom-4">
                            <div class="d-flex justify-content-center justify-content-md-end">
                                {{ $santris->links() }}
                            </div>
                        </div>
                    @endif
                    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection