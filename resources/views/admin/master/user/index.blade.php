@extends('layouts.admin')

@section('title', 'Data User')
@section('page_title', 'Daftar Pengguna Sistem')

@section('header_actions')
    {{-- Tombol Tambah User --}}
    <a href="{{ route('admin.user.create') }}" class="btn btn-primary shadow-sm rounded-pill d-flex align-items-center fw-semibold px-3">
        <i class="fas fa-plus me-2"></i>
        Tambah User Baru
    </a>
@endsection

@section('content')

<div class="container-fluid">
    <div class="row">
        <div class="col-12">

            <h2 class="mb-4 text-dark fw-bold">⚙️ Daftar Pengguna Sistem</h2>

            {{-- Slot untuk Notifikasi Sukses/Gagal --}}
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show rounded-3 shadow-sm" role="alert">
                    <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="card shadow-lg border-0 rounded-4">
                
                {{-- CARD HEADER DENGAN WARNA PRIMER DAN SEARCH (SIAP PAKAI) --}}
                <div class="card-header bg-primary text-white p-4 rounded-top-4">
                    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center">
                        <h5 class="mb-2 mb-md-0 fw-bold fs-5"><i class="fas fa-users-cog me-2"></i> Data Seluruh Pengguna</h5>
                        
                        {{-- Search Bar (Dapat diaktifkan jika diperlukan) --}}
                        {{-- <div class="w-100 w-md-auto mt-2 mt-md-0">
                            <form action="{{ route('admin.user.index') }}" method="GET" class="d-flex input-group input-group-sm">
                                <input type="text" name="search" class="form-control" placeholder="Cari Nama/Email..." value="{{ request('search') }}">
                                <button type="submit" class="btn btn-outline-light" title="Cari Data"><i class="fas fa-search"></i></button>
                                @if(request('search'))
                                    <a href="{{ route('admin.user.index') }}" class="btn btn-outline-danger" title="Hapus Pencarian"><i class="fas fa-times"></i></a>
                                @endif
                            </form>
                        </div> --}}
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
                                        'admin' => 'primary',
                                        'wali_santri' => 'info text-dark',
                                        default => 'secondary',
                                    };
                                @endphp
                                <tr>
                                    <td class="text-center">{{ $loop->iteration }}</td>
                                    <td class="fw-bold">{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>
                                        <span class="badge bg-{{ $badgeClass }} fw-bold p-2">
                                            {{ ucfirst(str_replace('_', ' ', $user->role)) }}
                                        </span>
                                    </td>
                                    <td class="text-center text-nowrap">
                                        {{-- Tombol Aksi --}}
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('admin.user.show', $user) }}" class="btn btn-sm btn-outline-info" title="Lihat Detail">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('admin.user.edit', $user) }}" class="btn btn-sm btn-outline-warning" title="Edit Data">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            
                                            {{-- Form Hapus --}}
                                            <form action="{{ route('admin.user.destroy', $user) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger" title="Hapus Data" onclick="return confirm('Apakah Anda yakin ingin menghapus user: {{ $user->name }}? Tindakan ini tidak dapat dibatalkan.')">
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
                                            <p class="mb-0 mt-2">Silakan klik tombol Tambah User Baru untuk membuat akun.</p>
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
                        @forelse($users as $user)
                            @php
                                $badgeClass = match($user->role) {
                                    'admin' => 'primary',
                                    'wali_santri' => 'info text-dark',
                                    default => 'secondary',
                                };
                                $roleDisplay = ucfirst(str_replace('_', ' ', $user->role));
                                
                                $borderColor = match($user->role) {
                                    'admin' => 'warning',
                                    'wali_santri' => 'primary',
                                    default => 'secondary',
                                };
                            @endphp
                            <div class="card mb-3 shadow-sm rounded-3 border-start border-4 border-{{ $borderColor }}">
                                <div class="card-body p-3">
                                    
                                    <div class="d-flex justify-content-between align-items-start mb-2 pb-2 border-bottom">
                                        <div>
                                            <h6 class="text-muted mb-0 small">PENGGUNA (#{{ $loop->iteration }})</h6>
                                            <h5 class="card-title fw-bold text-dark mb-1">{{ $user->name }}</h5>
                                        </div>
                                        <span class="badge bg-{{ $badgeClass }} p-2 fw-bold">{{ $roleDisplay }}</span>
                                    </div>
                                    
                                    <div class="row small mb-3">
                                        <div class="col-12">
                                            <span class="text-muted d-block fw-semibold">Email</span>
                                            <span class="fw-bold text-secondary">{{ $user->email }}</span>
                                        </div>
                                    </div>

                                    {{-- Aksi (Full-width buttons) --}}
                                    <div class="d-grid gap-2 d-sm-flex justify-content-sm-end pt-2">
                                        
                                        <a href="{{ route('admin.user.show', $user) }}" class="btn btn-sm btn-info text-white fw-semibold flex-fill" title="Lihat Detail">
                                            <i class="fas fa-eye me-1"></i> Detail
                                        </a>
                                        <a href="{{ route('admin.user.edit', $user) }}" class="btn btn-sm btn-warning text-dark fw-semibold flex-fill" title="Edit Data">
                                            <i class="fas fa-edit me-1"></i> Edit
                                        </a>
                                        
                                        <form action="{{ route('admin.user.destroy', $user) }}" method="POST" class="d-inline flex-fill">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger w-100 fw-semibold" title="Hapus Data" onclick="return confirm('Apakah Anda yakin ingin menghapus user: {{ $user->name }}? Tindakan ini tidak dapat dibatalkan.')">
                                                <i class="fas fa-trash me-1"></i> Hapus
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-5 text-muted bg-light rounded-3 shadow-sm">
                                <i class="fas fa-user-times me-2 fa-3x mb-3 text-secondary"></i>
                                <h5 class="mb-0 fw-bold">Tidak ada data pengguna yang ditemukan.</h5>
                                <p class="mb-0 mt-2">Silakan klik tombol Tambah User Baru untuk membuat akun.</p>
                            </div>
                        @endforelse
                    </div>
                    
                    
                    {{-- Paginasi --}}
                    @if ($users instanceof \Illuminate\Pagination\LengthAwarePaginator)
                        <div class="card-footer bg-light border-0 pt-3 rounded-bottom-4">
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