@extends('layouts.admin')

@section('title', 'Data Kelas')
@section('page_title', 'Daftar Kelas')

@section('header_actions')
    {{-- Tombol Tambah Kelas --}}
    <a href="{{ route('admin.kelas.create') }}" class="btn btn-primary shadow-sm rounded-pill d-flex align-items-center fw-semibold px-3">
        <i class="fas fa-plus me-2"></i>
        Tambah Kelas Baru
    </a>
@endsection

@section('content')

<div class="container-fluid">
    <div class="row">
        <div class="col-12">

            <h2 class="mb-4 text-dark fw-bold">🏫 Data Kelas</h2>

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
                        <h5 class="mb-2 mb-md-0 fw-bold fs-5"><i class="fas fa-school me-2"></i> Data Kelas Tersedia</h5>
                        
                        {{-- Form Search/Filter --}}
                        <div class="w-100 w-md-auto mt-2 mt-md-0">
                            <form action="{{ route('admin.kelas.index') }}" method="GET" class="d-flex input-group input-group-sm">
                                <input type="text" name="search" class="form-control" placeholder="Cari Nama Kelas..." value="{{ request('search') }}">
                                <button type="submit" class="btn btn-outline-light" title="Cari Data"><i class="fas fa-search"></i></button>
                                @if(request('search'))
                                    <a href="{{ route('admin.kelas.index') }}" class="btn btn-outline-danger" title="Hapus Pencarian"><i class="fas fa-times"></i></a>
                                @endif
                            </form>
                        </div>
                    </div>
                    <p class="text-white-50 small mb-0 mt-2 d-none d-md-block">Total {{ $kelas->count() ?? 0 }} data kelas terdaftar dalam sistem.</p>
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
                                    <th style="width: 40%;">Nama Kelas</th>
                                    <th style="width: 30%;">Tingkat</th>
                                    <th style="width: 25%;" class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($kelas as $k)
                                <tr>
                                    <td class="text-center">{{ $loop->iteration }}</td>
                                    <td class="fw-semibold text-dark">{{ $k->nama_kelas }}</td>
                                    {{-- Menggunakan warna badge yang lebih menonjol --}}
                                    <td><span class="badge bg-info text-dark p-2 fw-bold text-nowrap">Tingkat {{ $k->tingkat }}</span></td>
                                    <td class="text-center text-nowrap">
                                        {{-- Tombol Aksi --}}
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('admin.kelas.show', ['kela' => $k]) }}" class="btn btn-sm btn-outline-primary" title="Lihat Detail">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('admin.kelas.edit', ['kela' => $k]) }}" class="btn btn-sm btn-outline-warning" title="Edit Data">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            
                                            {{-- Form Hapus --}}
                                            <form action="{{ route('admin.kelas.destroy', ['kela' => $k]) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger" title="Hapus Data" onclick="return confirm('APAKAH YAKIN? Anda akan menghapus kelas {{ $k->nama_kelas }}? Tindakan ini tidak dapat dibatalkan.')">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center py-5 text-muted bg-light">
                                            <i class="fas fa-exclamation-circle me-2 fa-3x mb-3 text-secondary"></i>
                                            <h5 class="mb-0 fw-bold">Belum ada data kelas yang ditambahkan.</h5>
                                            <p class="mb-0 mt-2">Silakan klik tombol Tambah Kelas Baru di atas.</p>
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
                        @forelse($kelas as $k)
                            <div class="card mb-3 shadow-sm rounded-3 border-start border-4 border-primary">
                                <div class="card-body">
                                    
                                    {{-- Baris Utama --}}
                                    <div class="d-flex justify-content-between align-items-center mb-2 pb-2 border-bottom">
                                        <h5 class="card-title fw-bold text-dark mb-0">{{ $k->nama_kelas }}</h5>
                                        {{-- Menggunakan warna badge yang lebih menonjol --}}
                                        <span class="badge bg-info text-dark p-2 fw-bold text-nowrap">Tingkat {{ $k->tingkat }}</span>
                                    </div>
                                    
                                    <p class="text-muted small mb-3">ID Kelas: #{{ $loop->iteration }}</p>

                                    {{-- Aksi --}}
                                    <div class="d-grid gap-2 d-sm-flex justify-content-sm-end pt-2">
                                        {{-- Tombol Aksi Mobile --}}
                                        <a href="{{ route('admin.kelas.show', ['kela' => $k]) }}" class="btn btn-sm btn-outline-primary fw-semibold flex-fill" title="Lihat Detail">
                                            <i class="fas fa-eye me-1"></i> Detail
                                        </a>
                                        <a href="{{ route('admin.kelas.edit', ['kela' => $k]) }}" class="btn btn-sm btn-warning text-dark fw-semibold flex-fill" title="Edit Data">
                                            <i class="fas fa-edit me-1"></i> Edit
                                        </a>
                                        
                                        {{-- Form Hapus Mobile --}}
                                        <form action="{{ route('admin.kelas.destroy', ['kela' => $k]) }}" method="POST" class="d-inline flex-fill">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger w-100 fw-semibold" title="Hapus Data" onclick="return confirm('APAKAH YAKIN? Anda akan menghapus kelas {{ $k->nama_kelas }}?')">
                                                <i class="fas fa-trash me-1"></i> Hapus
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-5 text-muted bg-light rounded-3 shadow-sm">
                                <i class="fas fa-exclamation-circle me-2 fa-3x mb-3 text-secondary"></i>
                                <h5 class="mb-0 fw-bold">Belum ada data kelas yang ditambahkan.</h5>
                                <p class="mb-0 mt-2">Silakan klik tombol Tambah Kelas Baru untuk memulai.</p>
                            </div>
                        @endforelse
                    </div>
                    
                    
                    {{-- Paginasi --}}
                    @if ($kelas instanceof \Illuminate\Pagination\LengthAwarePaginator)
                        <div class="card-footer bg-light border-0 pt-3 rounded-bottom-4">
                            <div class="d-flex justify-content-center justify-content-md-end">
                                {{ $kelas->links() }}
                            </div>
                        </div>
                    @endif
                    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection