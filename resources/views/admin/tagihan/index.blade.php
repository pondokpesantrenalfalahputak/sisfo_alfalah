@extends('layouts.admin')

@section('title', 'Manajemen Tagihan')
@section('page_title', 'Manajemen Tagihan Pembayaran')

@section('header_actions')
    {{-- Tombol Tambah Tagihan Baru (Rounded-Pill) --}}
    <a href="{{ route('admin.tagihan.create') }}" class="btn btn-warning shadow-sm rounded-pill d-flex align-items-center fw-bold px-3 text-dark">
        <i class="fas fa-plus me-2"></i> Tambah Tagihan Baru
    </a>
@endsection

@section('content')

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <h2 class="mb-4 text-dark fw-bolder">🧾 Manajemen Tagihan Pembayaran</h2>
        </div>
    </div>
    
    {{-- Notifikasi Sukses --}}
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show rounded-3 shadow-sm" role="alert">
            <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    {{-- 2. RINGKASAN DATA (SUMMARY CARDS) - Ditingkatkan Keterbacaan Angka --}}
    @php
        // Pastikan variabel ini tersedia di view dari controller
        $totalTagihan = $tagihans->count();
        $totalNominal = $tagihans->sum('jumlah_tagihan');
        $belumLunas = $tagihans->where('status', 'Belum Lunas')->count();
        $lunas = $tagihans->where('status', 'Lunas')->count();
    @endphp

    <div class="row mb-5 g-4">
        
        {{-- Card: Total Tagihan --}}
        <div class="col-xl-3 col-md-6">
            <div class="card border-0 rounded-4 shadow-lg h-100 bg-primary-subtle border-start border-5 border-primary">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="text-sm fw-bold text-primary text-uppercase mb-1">Total Tagihan (Data)</div>
                            <div class="h2 fw-bolder mb-0 text-dark">{{ $totalTagihan }}</div>
                        </div>
                        <i class="fas fa-list-alt fa-3x text-primary opacity-25"></i>
                    </div>
                </div>
            </div>
        </div>

        {{-- Card: Belum Lunas --}}
        <div class="col-xl-3 col-md-6">
            <div class="card border-0 rounded-4 shadow-lg h-100 bg-danger-subtle border-start border-5 border-danger">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="text-sm fw-bold text-danger text-uppercase mb-1">Tagihan Belum Lunas</div>
                            <div class="h2 fw-bolder mb-0 text-dark">{{ $belumLunas }}</div>
                        </div>
                        <i class="fas fa-times-circle fa-3x text-danger opacity-25"></i>
                    </div>
                </div>
            </div>
        </div>

        {{-- Card: Sudah Lunas --}}
        <div class="col-xl-3 col-md-6">
            <div class="card border-0 rounded-4 shadow-lg h-100 bg-success-subtle border-start border-5 border-success">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="text-sm fw-bold text-success text-uppercase mb-1">Tagihan Sudah Lunas</div>
                            <div class="h2 fw-bolder mb-0 text-dark">{{ $lunas }}</div>
                        </div>
                        <i class="fas fa-check-circle fa-3x text-success opacity-25"></i>
                    </div>
                </div>
            </div>
        </div>

        {{-- Card: Total Nominal Tagihan --}}
        <div class="col-xl-3 col-md-6">
            <div class="card border-0 rounded-4 shadow-lg h-100 bg-info-subtle border-start border-5 border-info">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="text-sm fw-bold text-info text-uppercase mb-1">Total Nominal Tagihan</div>
                            <div class="h4 fw-bolder mb-0 text-dark">Rp {{ number_format($totalNominal, 0, ',', '.') }}</div>
                        </div>
                        <i class="fas fa-wallet fa-3x text-info opacity-25"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- 3. TABEL/CARD LIST DAFTAR TAGIHAN --}}
    <div class="card shadow-lg mb-4 rounded-4">
        <div class="card-header py-3 bg-dark text-white rounded-top-4">
            <h6 class="m-0 fw-bold fs-5"><i class="fas fa-table me-2"></i> Daftar Tagihan Keseluruhan</h6>
        </div>
        <div class="card-body p-4">
            
            {{-- ========================================================= --}}
            {{-- 1. Tampilan Desktop (Tabel) --}}
            {{-- ========================================================= --}}
            <div class="table-responsive d-none d-md-block">
                <table class="table table-hover align-middle mb-0" id="dataTable" width="100%" cellspacing="0">
                    <thead class="table-dark text-nowrap">
                        <tr>
                            <th class="text-center" style="width: 5%;">#</th>
                            <th style="width: 25%;">Santri & Kelas</th>
                            <th style="width: 15%;">Jenis Tagihan</th>
                            <th class="text-end" style="width: 15%;">Jumlah</th>
                            <th style="width: 15%;">Tgl. Dibuat</th>
                            <th style="width: 15%;">Jatuh Tempo</th>
                            <th class="text-center" style="width: 10%;">Status</th>
                            <th class="text-center" style="width: 10%;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($tagihans as $index => $tagihan)
                            <tr>
                                <td class="text-center">{{ $index + 1 }}</td>
                                <td>
                                    <div class="fw-bolder text-dark">{{ $tagihan->santri->nama_lengkap ?? 'N/A' }}</div>
                                    <small class="text-secondary"><i class="fas fa-school me-1"></i> {{ $tagihan->santri->kelas->nama_kelas ?? 'N/A' }}</small>
                                </td>
                                <td>
                                    <span class="badge bg-secondary p-2 fw-semibold">{{ $tagihan->jenis_tagihan }}</span>
                                </td>
                                <td class="text-end fw-bolder text-primary">
                                    Rp {{ number_format($tagihan->jumlah_tagihan, 0, ',', '.') }}
                                </td>
                                <td><small class="text-muted">{{ \Carbon\Carbon::parse($tagihan->tanggal_tagihan)->translatedFormat('d M Y') }}</small></td>
                                <td>
                                    @php
                                        $dueDate = \Carbon\Carbon::parse($tagihan->tanggal_jatuh_tempo);
                                        $isOverdue = $tagihan->status != 'Lunas' && $dueDate->isPast();
                                    @endphp
                                    <span class="{{ $isOverdue ? 'fw-bolder text-danger' : 'text-success' }}">
                                        {{ $dueDate->translatedFormat('d M Y') }}
                                    </span>
                                    @if ($isOverdue)
                                        <span class="badge bg-danger ms-1 fw-bold">LEWAT</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    @if ($tagihan->status == 'Lunas')
                                        <span class="badge bg-success p-2 fw-bold w-100"><i class="fas fa-check-circle"></i> Lunas</span>
                                    @else
                                        <span class="badge bg-warning p-2 fw-bold text-dark w-100"><i class="fas fa-clock"></i> Belum Lunas</span>
                                    @endif
                                </td>
                                <td class="text-center text-nowrap">
                                    <div class="btn-group btn-group-sm" role="group">
                                        <a href="{{ route('admin.tagihan.show', $tagihan) }}" class="btn btn-primary" title="Detail">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.tagihan.edit', $tagihan) }}" class="btn btn-warning" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('admin.tagihan.destroy', $tagihan) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger" title="Hapus" onclick="return confirm('APAKAH YAKIN? Menghapus tagihan ini akan menghapus data permanen.')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center py-5 bg-light rounded-bottom-4">
                                    <i class="fas fa-box-open fa-3x text-muted mb-3"></i>
                                    <h5 class="mb-0 fw-bold">Tidak ada data tagihan yang ditemukan.</h5>
                                    <p class="mb-0 mt-2">Silakan klik tombol "Tambah Tagihan Baru" di atas untuk memulai.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- ========================================================= --}}
            {{-- 2. Tampilan Mobile (Card List) --}}
            {{-- ========================================================= --}}
            <div class="d-md-none px-0">
                @forelse ($tagihans as $index => $tagihan)
                    @php
                        $dueDate = \Carbon\Carbon::parse($tagihan->tanggal_jatuh_tempo);
                        $isOverdue = $tagihan->status != 'Lunas' && $dueDate->isPast();
                        $statusClass = $tagihan->status == 'Lunas' ? 'border-success' : ($isOverdue ? 'border-danger' : 'border-warning');
                    @endphp
                    
                    <div class="card mb-3 shadow-sm rounded-3 border-start border-5 {{ $statusClass }}">
                        <div class="card-body p-3">
                            
                            {{-- Baris 1: Nama Santri & Status --}}
                            <div class="d-flex justify-content-between align-items-start border-bottom pb-2 mb-2">
                                <div>
                                    <h6 class="text-muted mb-0 small"><i class="fas fa-user-graduate me-1"></i> SANTRI #{{ $index + 1 }}</h6>
                                    <h5 class="card-title fw-bolder text-dark mb-0">{{ $tagihan->santri->nama_lengkap ?? 'N/A' }}</h5>
                                    <small class="text-secondary"><i class="fas fa-school me-1"></i> Kelas: {{ $tagihan->santri->kelas->nama_kelas ?? 'N/A' }}</small>
                                </div>
                                <div class="text-end">
                                    @if ($tagihan->status == 'Lunas')
                                        <span class="badge bg-success p-2 fw-bold"><i class="fas fa-check-circle"></i> Lunas</span>
                                    @else
                                        <span class="badge bg-warning p-2 fw-bold text-dark"><i class="fas fa-clock"></i> Belum Lunas</span>
                                    @endif
                                </div>
                            </div>
                            
                            {{-- Baris 2: Jumlah & Jenis Tagihan --}}
                            <div class="row pt-2 pb-2">
                                <div class="col-6">
                                    <h6 class="text-muted small mb-1">JUMLAH TAGIHAN</h6>
                                    <span class="fw-bolder fs-5 text-primary">Rp {{ number_format($tagihan->jumlah_tagihan, 0, ',', '.') }}</span>
                                </div>
                                <div class="col-6 text-end">
                                    <h6 class="text-muted small mb-1">JENIS TAGIHAN</h6>
                                    <span class="badge bg-secondary p-2 fw-semibold">{{ $tagihan->jenis_tagihan }}</span>
                                </div>
                            </div>
                            <hr class="my-2">

                            {{-- Baris 3: Tanggal & Jatuh Tempo --}}
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <div>
                                    <h6 class="text-muted small mb-1">Tgl. Dibuat</h6>
                                    <small class="text-muted fw-semibold">{{ \Carbon\Carbon::parse($tagihan->tanggal_tagihan)->translatedFormat('d M Y') }}</small>
                                </div>
                                <div class="text-end">
                                    <h6 class="text-muted small mb-1">JATUH TEMPO</h6>
                                    <span class="{{ $isOverdue ? 'fw-bolder text-danger' : 'fw-bold text-success' }}">
                                        {{ $dueDate->translatedFormat('d M Y') }}
                                    </span>
                                    @if ($isOverdue)
                                        <small class="badge bg-danger ms-1">LEWAT</small>
                                    @endif
                                </div>
                            </div>
                            
                            {{-- Aksi --}}
                            <div class="d-flex justify-content-end pt-2 gap-2 border-top">
                                <a href="{{ route('admin.tagihan.show', $tagihan) }}" class="btn btn-sm btn-info fw-semibold rounded-pill" title="Detail">
                                    <i class="fas fa-eye"></i> Detail
                                </a>
                                <a href="{{ route('admin.tagihan.edit', $tagihan) }}" class="btn btn-sm btn-warning fw-semibold rounded-pill" title="Edit Data">
                                    <i class="fas fa-edit"></i> Edit
                                </a>
                                
                                <form action="{{ route('admin.tagihan.destroy', $tagihan) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger fw-semibold rounded-pill" title="Hapus Tagihan" onclick="return confirm('APAKAH YAKIN? Menghapus tagihan ini akan menghapus data permanen.')">
                                        <i class="fas fa-trash"></i> Hapus
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-5 text-muted bg-light rounded-3 shadow-sm mx-3">
                        <i class="fas fa-box-open fa-3x text-muted mb-3"></i>
                        <h5 class="mb-0 fw-bold">Tidak ada data tagihan yang ditemukan.</h5>
                        <p class="mb-0 mt-2">Silakan klik tombol "Tambah Tagihan Baru" di atas untuk memulai.</p>
                        <a href="{{ route('admin.tagihan.create') }}" class="btn btn-sm btn-primary mt-3 rounded-pill px-3">Buat Tagihan Pertama</a>
                    </div>
                @endforelse
            </div>

        </div>
    </div>
</div>
@endsection