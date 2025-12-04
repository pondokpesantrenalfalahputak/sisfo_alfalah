@extends('layouts.admin')

@section('title', 'Kelola Pengumuman')
@section('page_title', 'Daftar Pengumuman Pesantren')

@section('header_actions')
    {{-- Tombol Tambah Pengumuman --}}
    <a href="{{ route('admin.pengumuman.create') }}" class="btn btn-primary shadow-sm rounded-pill d-flex align-items-center fw-semibold px-3">
        <i class="fas fa-plus me-2"></i> Tambah Pengumuman Baru
    </a>
@endsection

@section('content')

<div class="container-fluid">
    <div class="row">
        <div class="col-12">

            <h2 class="mb-4 text-dark fw-bold">📢 Kelola Pengumuman</h2>

            {{-- Slot untuk Notifikasi Sukses/Gagal --}}
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show rounded-3 shadow-sm" role="alert">
                    <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="card shadow-lg border-0 rounded-4">
                
                {{-- CARD HEADER DENGAN WARNA PRIMER --}}
                <div class="card-header bg-primary text-white p-4 rounded-top-4">
                    <h5 class="mb-0 fw-bold fs-5"><i class="fas fa-bullhorn me-2"></i> Daftar Seluruh Pengumuman</h5>
                    <p class="text-white-50 small mb-0">Kelola dan publikasikan pengumuman penting untuk Wali Santri.</p>
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
                                    <th style="width: 30%;">Judul Pengumuman</th>
                                    <th style="width: 15%;">Kategori</th>
                                    <th style="width: 15%;">Tanggal Publikasi</th>
                                    <th style="width: 15%;">Status</th>
                                    <th style="width: 20%;" class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($pengumumans as $pengumuman)
                                <tr>
                                    <td class="text-center">{{ $loop->iteration }}</td>
                                    <td>
                                        <strong class="text-dark">{{ $pengumuman->judul }}</strong><br>
                                        <small class="text-secondary">{{ Str::limit(strip_tags($pengumuman->isi), 70, '...') }}</small>
                                    </td>
                                    <td>
                                         {{-- KATEGORI --}}
                                         <span class="badge bg-info-subtle text-info-emphasis fw-semibold p-2">
                                            {{ $pengumuman->kategori ?? 'Umum' }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="fw-semibold text-secondary">{{ \Carbon\Carbon::parse($pengumuman->tanggal_publikasi)->translatedFormat('d M Y') }}</span>
                                    </td>
                                    <td>
                                        {{-- STATUS --}}
                                        @if ($pengumuman->status === 'published')
                                            <span class="badge bg-success p-2 fw-bold">
                                                <i class="fas fa-check-circle me-1"></i> Published
                                            </span>
                                        @else
                                            <span class="badge bg-secondary p-2 fw-bold">
                                                <i class="fas fa-pencil-alt me-1"></i> Draft
                                            </span>
                                        @endif
                                    </td>
                                    <td class="text-center text-nowrap">
                                        {{-- Tombol Aksi --}}
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('admin.pengumuman.show', $pengumuman) }}" class="btn btn-sm btn-outline-info" title="Lihat Detail">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('admin.pengumuman.edit', $pengumuman) }}" class="btn btn-sm btn-outline-warning" title="Edit Pengumuman">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            
                                            {{-- Form Hapus --}}
                                            <form action="{{ route('admin.pengumuman.destroy', $pengumuman) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger" title="Hapus Pengumuman" onclick="return confirm('Apakah Anda yakin ingin menghapus pengumuman: {{ $pengumuman->judul }}? Tindakan ini tidak dapat dibatalkan.')">
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
                                            <h5 class="mb-0 fw-bold">Belum ada data pengumuman yang tersedia.</h5>
                                            <p class="mb-0 mt-2">Silakan klik tombol Tambah Pengumuman Baru di atas untuk membuat pengumuman.</p>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    {{-- ========================================================= --}}
                    {{-- 2. Tampilan Mobile (Card List) --}}
                    {{-- ========================================================= --}}
                    <div class="d-md-none p-4 pt-4">
                        @forelse($pengumumans as $pengumuman)
                            {{-- Mengubah border color berdasarkan status --}}
                            <div class="card mb-3 shadow-sm rounded-3 border-start border-5 {{ $pengumuman->status === 'published' ? 'border-success' : 'border-secondary' }}">
                                <div class="card-body p-3">
                                    
                                    {{-- Baris 1: Judul dan Status --}}
                                    <div class="d-flex justify-content-between align-items-start mb-2 border-bottom pb-2">
                                        <div>
                                            <h6 class="text-muted mb-0 small">{{ $pengumuman->kategori ?? 'UMUM' }} | #{{ $loop->iteration }}</h6>
                                            <h5 class="card-title fw-bold text-dark mb-1">{{ $pengumuman->judul }}</h5>
                                        </div>
                                        {{-- Badge Status Mobile --}}
                                        @if ($pengumuman->status === 'published')
                                            <span class="badge bg-success p-2 fw-bold">Published</span>
                                        @else
                                            <span class="badge bg-secondary p-2 fw-bold">Draft</span>
                                        @endif
                                    </div>
                                    
                                    {{-- Ringkasan Isi --}}
                                    <p class="card-text small text-secondary mb-3">{{ Str::limit(strip_tags($pengumuman->isi), 100, '...') }}</p>
                                    
                                    {{-- Tanggal --}}
                                    <p class="card-text small text-muted mb-3">
                                        <i class="far fa-calendar-alt me-1"></i>
                                        Publikasi: <span class="fw-semibold">{{ \Carbon\Carbon::parse($pengumuman->tanggal_publikasi)->translatedFormat('d F Y') }}</span>
                                    </p>

                                    {{-- Aksi --}}
                                    <div class="d-grid gap-2 d-sm-flex justify-content-sm-end pt-2">
                                        <a href="{{ route('admin.pengumuman.show', $pengumuman) }}" class="btn btn-sm btn-info text-white fw-semibold flex-fill" title="Lihat Detail">
                                            <i class="fas fa-eye me-1"></i> Detail
                                        </a>
                                        <a href="{{ route('admin.pengumuman.edit', $pengumuman) }}" class="btn btn-sm btn-warning text-dark fw-semibold flex-fill" title="Edit Pengumuman">
                                            <i class="fas fa-edit me-1"></i> Edit
                                        </a>
                                        
                                        <form action="{{ route('admin.pengumuman.destroy', $pengumuman) }}" method="POST" class="d-inline flex-fill">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger w-100 fw-semibold" title="Hapus Pengumuman" onclick="return confirm('Apakah Anda yakin ingin menghapus pengumuman: {{ $pengumuman->judul }}? Tindakan ini tidak dapat dibatalkan.')">
                                                <i class="fas fa-trash me-1"></i> Hapus
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-5 text-muted bg-light rounded-3 shadow-sm">
                                <i class="fas fa-exclamation-circle me-2 fa-3x mb-3 text-secondary"></i>
                                <h5 class="mb-0 fw-bold">Belum ada data pengumuman yang tersedia.</h5>
                                <p class="mb-0 mt-2">Silakan klik tombol Tambah Pengumuman Baru di atas untuk membuat pengumuman.</p>
                            </div>
                        @endforelse
                    </div>
                    
                </div>
                
                {{-- Paginasi --}}
                @if ($pengumumans instanceof \Illuminate\Pagination\LengthAwarePaginator)
                    <div class="card-footer bg-light border-0 pt-3 rounded-bottom-4">
                        <div class="d-flex justify-content-center justify-content-md-end">
                            {{ $pengumumans->links() }}
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection