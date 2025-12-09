@extends('layouts.admin')

@section('title', 'Data User')
@section('page_title', 'Daftar Pengguna Sistem')

{{-- Tombol Tambah User (Hanya Tampil di Desktop: d-none d-md-flex) --}}
@section('header_actions')
    <a href="{{ route('admin.user.create') }}" class="btn btn-primary shadow-lg rounded-pill d-none d-md-flex align-items-center fw-bold px-4">
        <i class="fas fa-user-plus me-2"></i>
        Tambah User Baru
    </a>
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

            <div class="card shadow-lg border-0 rounded-4 overflow-hidden">
                
                {{-- CARD HEADER DENGAN SEARCH BAR DAN TOMBOL MOBILE --}}
                <div class="card-header bg-white border-bottom p-4">
                    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center">
                        
                        {{-- KONTROL AKSI (Search dan Tombol Mobile) --}}
                        <div class="w-100 w-md-auto">
                            
                            {{-- Search Bar Aktif (Rounded pill) --}}
                            <form action="{{ route('admin.user.index') }}" method="GET" class="d-flex input-group input-group-sm rounded-pill overflow-hidden shadow-sm mb-3 mb-md-0">
                                <input type="text" name="search" class="form-control border-0 ps-3" placeholder="Cari Nama/Email..." value="{{ request('search') }}">
                                <button type="submit" class="btn btn-primary px-3" title="Cari Data"><i class="fas fa-search"></i></button>
                                @if(request('search'))
                                    <a href="{{ route('admin.user.index') }}" class="btn btn-danger px-3" title="Hapus Pencarian"><i class="fas fa-times"></i></a>
                                @endif
                            </form>

                            {{-- Tombol Tambah User (Hanya Tampil di Mobile: d-md-none) --}}
                            <a href="{{ route('admin.user.create') }}" class="btn btn-primary btn-block shadow-sm rounded-pill d-md-none fw-bold w-100">
                                <i class="fas fa-user-plus me-1"></i> Tambah User Baru
                            </a>
                        </div>
                    </div>
                </div>
                
                <div class="card-body p-0">
                    
                    {{-- ========================================================= --}}
                    {{-- 1. Tampilan Desktop (Tabel) --}}
                    {{-- ========================================================= --}}
                    <div class="table-responsive d-none d-md-block">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light text-nowrap">
                                <tr>
                                    <th style="width: 5%;" class="text-center">No</th>
                                    <th style="width: 25%;">Nama</th>
                                    <th style="width: 30%;">Email</th>
                                    <th style="width: 15%;">Role</th>
                                    <th style="width: 25%;" class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($users as $user)
                                @php
                                    $badgeClass = match($user->role) {
                                        'admin' => 'danger',
                                        'wali_santri' => 'primary',
                                        default => 'secondary',
                                    };
                                @endphp
                                <tr>
                                    <td class="text-center text-muted">{{ $loop->iteration }}</td>
                                    <td class="fw-bold text-dark">{{ $user->name }}</td>
                                    <td class="text-muted">{{ $user->email }}</td>
                                    <td>
                                        <span class="badge bg-{{ $badgeClass }} fw-bold p-2 rounded-pill">
                                            {{ ucfirst(str_replace('_', ' ', $user->role)) }}
                                        </span>
                                    </td>
                                    <td class="text-center text-nowrap">
                                        {{-- Tombol Aksi (DENGAN JARAK: d-flex gap-2) --}}
                                        <div class="d-flex justify-content-center gap-2" role="group">
                                            <a href="{{ route('admin.user.show', $user) }}" class="btn btn-sm btn-outline-primary" title="Lihat Detail">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('admin.user.edit', $user) }}" class="btn btn-sm btn-outline-warning" title="Edit Data">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            
                                            {{-- Form Hapus --}}
                                            <form action="{{ route('admin.user.destroy', $user) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger" title="Hapus Data" onclick="return confirm('Apakah Anda yakin ingin menghapus user: {{ $user->name }}? Tindakan ini tidak dapat dibatalkan.')">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center py-5 text-muted bg-light">
                                            <i class="fas fa-user-times me-2 fa-3x mb-3 text-secondary"></i>
                                            <h5 class="mb-0 fw-bold">Tidak ada data pengguna yang ditemukan.</h5>
                                            <p class="mb-0 mt-2">Silakan klik tombol Tambah User Baru di atas.</p>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    
                    {{-- ========================================================= --}}
                    {{-- 2. Tampilan Mobile (Card List) --}}
                    {{-- ========================================================= --}}
                    <div class="d-md-none p-4">
                        @forelse($users as $user)
                            @php
                                $badgeClass = match($user->role) {
                                    'admin' => 'danger',
                                    'wali_santri' => 'primary',
                                    default => 'secondary',
                                };
                                $roleDisplay = ucfirst(str_replace('_', ' ', $user->role));
                                
                                $borderColor = match($user->role) {
                                    'admin' => 'danger',
                                    'wali_santri' => 'primary',
                                    default => 'secondary',
                                };
                            @endphp
                            <div class="card mb-3 shadow-sm rounded-4 border-start border-4 border-{{ $borderColor }}">
                                <div class="card-body p-3">
                                    
                                    {{-- HEADER CARD MOBILE --}}
                                    <div class="d-flex justify-content-between align-items-center mb-3 pb-2 border-bottom border-dashed">
                                        <div>
                                            <h6 class="text-muted mb-0 small fw-semibold">PENGGUNA {{ $loop->iteration }}</h6>
                                        </div>
                                        <span class="badge bg-{{ $badgeClass }} p-2 fw-bold rounded-pill">{{ $roleDisplay }}</span>
                                    </div>
                                    
                                    {{-- DETAIL PENGGUNA --}}
                                    <div class="mb-3">
                                        <div class="d-flex align-items-center mb-2">
                                            <i class="fas fa-user-circle me-3 text-primary fs-6"></i>
                                            <div>
                                                <span class="d-block small text-muted">Nama Lengkap</span>
                                                <span class="fw-bold text-dark fs-6">{{ $user->name }}</span>
                                            </div>
                                        </div>
                                        <div class="d-flex align-items-center">
                                            <i class="fas fa-envelope me-3 text-primary fs-6"></i>
                                            <div>
                                                <span class="d-block small text-muted">Email</span>
                                                <span class="fw-bold text-secondary small">{{ $user->email }}</span>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- Aksi (Ringkas) --}}
                                    <div class="d-flex gap-2 justify-content-end pt-2 border-top">
                                        
                                        <a href="{{ route('admin.user.show', $user) }}" class="btn btn-sm btn-outline-primary fw-semibold px-3" title="Lihat Detail">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.user.edit', $user) }}" class="btn btn-sm btn-outline-warning fw-semibold px-3" title="Edit Data">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        
                                        <form action="{{ route('admin.user.destroy', $user) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger fw-semibold px-3" title="Hapus Data" onclick="return confirm('Apakah Anda yakin ingin menghapus user: {{ $user->name }}? Tindakan ini tidak dapat dibatalkan.')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-5 text-muted bg-light rounded-4 shadow-sm">
                                <i class="fas fa-user-times me-2 fa-3x mb-3 text-secondary"></i>
                                <h5 class="mb-0 fw-bold">Tidak ada data pengguna yang ditemukan.</h5>
                                <p class="mb-0 mt-2 small">Silakan gunakan tombol Tambah User Baru di atas.</p>
                            </div>
                        @endforelse
                    </div>
                    
                    
                    {{-- Paginasi --}}
                    @if ($users instanceof \Illuminate\Pagination\LengthAwarePaginator)
                        <div class="card-footer bg-white border-top p-3 rounded-bottom-4">
                            <div class="d-flex justify-content-center justify-content-md-end">
                                {{ $users->links() }}
                            </div>
                        </div>
                    @endif
                    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection