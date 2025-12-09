@extends('layouts.admin')

@section('title', 'Data Kelas')
@section('page_title', 'Daftar Kelas')

@section('header_actions')
    <a href="{{ route('admin.kelas.create') }}" class="btn btn-primary btn-sm px-3 shadow-sm rounded-pill d-none d-md-flex align-items-center fw-semibold">
        <i class="fas fa-plus me-2"></i>
        Tambah Kelas Baru
    </a>
@endsection

@section('content')

<div class="container-fluid">
    <div class="row">
        <div class="col-12">


            <div class="card shadow-lg border-0 rounded-4 overflow-hidden">
                
                {{-- CARD HEADER --}}
                <div class="card-header bg-white border-bottom p-4">
                    
                    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">

                        {{-- Form Search/Filter (Lebar 100% di Mobile) --}}
                        <div class="w-100 w-md-auto">
                            <form action="{{ route('admin.kelas.index') }}" method="GET" class="d-flex input-group input-group-sm">
                                <input type="text" name="search" class="form-control shadow-none" placeholder="Cari Nama Kelas..." value="{{ request('search') }}">
                                <button type="submit" class="btn btn-outline-secondary" title="Cari Data"><i class="fas fa-search"></i></button>
                                @if(request('search'))
                                    <a href="{{ route('admin.kelas.index') }}" class="btn btn-outline-danger" title="Hapus Pencarian"><i class="fas fa-times"></i></a>
                                @endif
                            </form>
                        </div>
                        
                        {{-- Tombol Tambah Kelas (Hanya tampil di Mobile, menyelaraskan dengan search) --}}
                        <div class="w-100 d-md-none">
                            <a href="{{ route('admin.kelas.create') }}" class="btn btn-primary btn-sm w-100 shadow-sm rounded-pill d-flex align-items-center justify-content-center fw-semibold">
                                <i class="fas fa-plus me-2"></i>
                                Tambah Kelas Baru
                            </a>
                        </div>
                    </div>
                    
                    {{-- Keterangan Jumlah Data --}}
                    @php
                        $totalData = ($kelas instanceof \Illuminate\Pagination\LengthAwarePaginator) ? $kelas->total() : $kelas->count();
                    @endphp
                    <p class="text-muted small mb-0 mt-3">Total {{ $totalData }} data kelas terdaftar.</p>
                </div>
                
                <div class="card-body p-0">

                    {{-- ========================================================= --}}
                    {{-- 1. Tampilan Desktop (Tabel Seragam) --}}
                    {{-- ========================================================= --}}
                    <div class="table-responsive d-none d-md-block">
                        <table class="table table-striped table-hover align-middle mb-0">
                            <thead class="table-light text-nowrap">
                                <tr class="fw-bold text-uppercase small">
                                    <th style="width: 5%;" class="text-center">No</th>
                                    <th style="width: 40%;">Nama Kelas</th>
                                    <th style="width: 30%;">Tingkat</th>
                                    <th style="width: 25%;" class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($kelas as $k)
                                <tr>
                                    <td class="text-center text-muted small">
                                        @if ($kelas instanceof \Illuminate\Pagination\LengthAwarePaginator)
                                            {{ $loop->iteration + ($kelas->currentPage() - 1) * $kelas->perPage() }}
                                        @else
                                            {{ $loop->iteration }}
                                        @endif
                                    </td>
                                    <td class="fw-semibold text-dark">
                                        {{ $k->nama_kelas }}
                                        <div class="small text-muted mt-1">ID:{{ $k->id }}</div>
                                    </td>
                                    <td><span class="badge bg-info text-dark p-2 fw-semibold text-nowrap"><i class="fas fa-layer-group me-1"></i> Level {{ $k->tingkat }}</span></td>
                                    <td class="text-center text-nowrap">
                                        {{-- Tombol Aksi Desktop --}}
                                        <div class="d-flex justify-content-center gap-2" role="group">
                                            <a href="{{ route('admin.kelas.show', ['kela' => $k]) }}" class="btn btn-primary btn-sm" title="Lihat Detail">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('admin.kelas.edit', ['kela' => $k]) }}" class="btn btn-warning btn-sm" title="Edit Data">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            
                                            {{-- Form Hapus --}}
                                            <form action="{{ route('admin.kelas.destroy', ['kela' => $k]) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm" title="Hapus Data" onclick="return confirm('APAKAH YAKIN? Anda akan menghapus kelas {{ $k->nama_kelas }}? Tindakan ini tidak dapat dibatalkan.')">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                    <tr>
                                        {{-- Empty State Seragam --}}
                                        <td colspan="4" class="text-center py-5 text-muted bg-light border-0">
                                            <i class="fas fa-box-open me-2 fa-3x mb-3 text-secondary"></i>
                                            <h5 class="mb-0 fw-bold">Data kelas kosong.</h5>
                                            <p class="mb-0 mt-2">Belum ada kelas yang ditambahkan ke dalam sistem.</p>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    
                    {{-- ========================================================= --}}
                    {{-- 2. Tampilan Mobile (Card List Diperhalus dan Berjarak) --}}
                    {{-- ========================================================= --}}
                    <div class="d-md-none p-3">
                        @forelse($kelas as $k)
                            <div class="card mb-3 shadow-sm rounded-3 border">
                                <div class="card-body p-3">
                                    
                                    {{-- Baris Utama --}}
                                    <div class="d-flex justify-content-between align-items-center mb-3 pb-2 border-bottom">
                                        <div class="me-2">
                                            <h6 class="card-title fw-bold text-dark mb-0 fs-6">{{ $k->nama_kelas }}</h6>
                                            <p class="text-muted small mb-0 mt-1">
                                                No.{{ 
                                                    ($kelas instanceof \Illuminate\Pagination\LengthAwarePaginator) 
                                                        ? $loop->iteration + ($kelas->currentPage() - 1) * $kelas->perPage() 
                                                        : $loop->iteration 
                                                }}
                                            </p>
                                        </div>
                                        {{-- Badge Tingkat --}}
                                        <span class="badge bg-info text-dark p-2 fw-bold text-nowrap flex-shrink-0"><i class="fas fa-layer-group me-1"></i> Level {{ $k->tingkat }}</span>
                                    </div>
                                    
                                    <div class="d-flex gap-2 w-100 pt-2">
                                        
                                        {{-- Detail --}}
                                        <a href="{{ route('admin.kelas.show', ['kela' => $k]) }}" class="btn btn-primary btn-sm w-100 fw-semibold">
                                            <i class="fas fa-eye me-1"></i> Detail
                                        </a>

                                        {{-- Edit (Ikon saja, 1/3 dari sisanya) --}}
                                        <a href="{{ route('admin.kelas.edit', ['kela' => $k]) }}" class="btn btn-warning btn-sm fw-semibold">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        
                                        {{-- Form Hapus Mobile (Ikon saja, 1/3 dari sisanya) --}}
                                        <form action="{{ route('admin.kelas.destroy', ['kela' => $k]) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus kelas {{ $k->nama_kelas }}?')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-5 text-muted bg-light rounded-3 shadow-sm">
                                <i class="fas fa-frown fa-3x mb-3 text-secondary opacity-75"></i>
                                <h5 class="mb-0 fw-bold">Data kelas kosong.</h5>
                                <p class="mb-0 mt-2">Silakan klik tombol Tambah Kelas Baru di atas.</p>
                            </div>
                        @endforelse
                    </div>
                    
                    
                    {{-- Paginasi --}}
                    @if ($kelas instanceof \Illuminate\Pagination\LengthAwarePaginator)
                        <div class="card-footer bg-light border-top py-3 rounded-bottom-4">
                            <div class="d-flex justify-content-center justify-content-md-end">
                                {{ $kelas->onEachSide(1)->links('pagination::bootstrap-5') }}
                            </div>
                        </div>
                    @endif
                    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection