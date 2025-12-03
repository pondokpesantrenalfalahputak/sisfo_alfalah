@extends('layouts.admin')

@section('title', 'Detail Tagihan')
@section('page_title', 'Rincian Tagihan Pembayaran')

@section('header_actions')
    {{-- Container Flex untuk tombol header --}}
    {{-- Di mobile (default): Tumpuk Vertikal (flex-column) --}}
    {{-- Di desktop (sm ke atas): Berdampingan Horizontal (flex-sm-row) --}}
    {{-- Gap 2 antar tombol --}}
    <div class="d-flex flex-column flex-sm-row gap-2 w-100 w-sm-auto"> 
        
        {{-- Tombol Edit --}}
        <a href="{{ route('admin.tagihan.edit', $tagihan) }}" 
           class="btn btn-warning shadow-sm rounded-pill d-flex align-items-center justify-content-center fw-semibold px-3 w-100 w-sm-auto"> 
           {{-- w-100 di mobile, w-sm-auto di desktop --}}
            <i class="fas fa-edit me-2"></i>
            Edit Tagihan
        </a>
        
        {{-- Tombol Kembali --}}
        <a href="{{ route('admin.tagihan.index') }}" 
           class="btn btn-outline-secondary shadow-sm rounded-pill d-flex align-items-center justify-content-center fw-semibold px-3 w-100 w-sm-auto">
            <i class="fas fa-arrow-left me-2"></i>
            Kembali ke Daftar
        </a>
        
    </div>
@endsection

@section('content')

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <h2 class="mb-4 text-dark fw-bold">🔍 Rincian Tagihan #{{ $tagihan->id }}</h2>
        </div>
    </div>

    <div class="row g-4">
        
        {{-- KOLOM KIRI: Detail Tagihan Utama --}}
        <div class="col-lg-6">
            
            {{-- Kartu Utama: Ringkasan & Detail --}}
            <div class="card shadow-lg border-0 rounded-4 mb-4 border-start border-5 border-primary">
                
                <div class="card-header bg-primary text-white p-4 rounded-top-4">
                    <h5 class="mb-0 fw-bold"><i class="fas fa-file-invoice-dollar me-2"></i> Ringkasan Pembayaran</h5>
                </div>

                <div class="card-body p-4">
                    
                    {{-- BOX UTAMA: NOMINAL & STATUS (Tegaskan Visual) --}}
                    <div class="p-4 mb-4 border border-2 {{ $tagihan->status == 'Lunas' ? 'border-success bg-success-subtle' : 'border-danger bg-danger-subtle' }} rounded-3 shadow-sm">
                        <h6 class="fw-bold text-muted mb-1 text-uppercase small">Total Tagihan</h6>
                        <p class="lead fw-bolder mb-3 fs-1 {{ $tagihan->status == 'Lunas' ? 'text-success' : 'text-danger' }}">
                            Rp {{ number_format($tagihan->jumlah_tagihan, 0, ',', '.') }}
                        </p>
                        
                        <h6 class="fw-bold text-muted mb-1 text-uppercase small">Status</h6>
                        <span class="badge {{ $tagihan->status == 'Lunas' ? 'bg-success' : 'bg-warning text-dark' }} p-3 fs-6 fw-bold">
                            <i class="fas {{ $tagihan->status == 'Lunas' ? 'fa-check-circle' : 'fa-clock' }} me-2"></i>
                            {{ $tagihan->status }}
                        </span>
                    </div>

                    {{-- DETAIL TAGIHAN (Menggunakan List Group untuk kerapian dan mobile) --}}
                    <ul class="list-group list-group-flush border rounded-3">
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <div class="text-muted small">ID Tagihan</div>
                            <div class="fw-semibold text-dark">{{ $tagihan->id }}</div>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <div class="text-muted small">Jenis Tagihan</div>
                            <div class="fw-semibold text-dark">{{ $tagihan->jenis_tagihan }}</div>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <div class="text-muted small">Tanggal Dibuat</div>
                            <div class="fw-semibold text-dark">{{ \Carbon\Carbon::parse($tagihan->tanggal_tagihan)->translatedFormat('d F Y') }}</div>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <div class="text-muted small">Jatuh Tempo</div>
                            @php
                                $dueDate = \Carbon\Carbon::parse($tagihan->tanggal_jatuh_tempo);
                                $isOverdue = $tagihan->status != 'Lunas' && $dueDate->isPast();
                            @endphp
                            <div class="fw-bolder {{ $isOverdue ? 'text-danger' : 'text-dark' }}">
                                {{ $dueDate->translatedFormat('d F Y') }}
                                @if ($isOverdue)
                                    <span class="badge bg-danger ms-2">LEWAT</span>
                                @endif
                            </div>
                        </li>
                        <li class="list-group-item">
                            <div class="text-muted small mb-1">Keterangan:</div>
                            <p class="mb-0 fst-italic text-wrap text-secondary">{{ $tagihan->keterangan ?? 'Tidak ada keterangan.' }}</p>
                        </li>
                    </ul>
                </div>
                
                {{-- CARD FOOTER: Action Buttons (Block di mobile) --}}
                <div class="card-footer bg-light border-0 rounded-bottom-4 p-4">
                    <div class="d-flex justify-content-end gap-2 flex-column flex-sm-row"> 
                        <a href="{{ route('admin.tagihan.edit', $tagihan) }}" class="btn btn-warning shadow-sm fw-bold rounded-pill px-4 text-dark order-sm-1 order-2">
                            <i class="fas fa-edit me-2"></i> Edit Data
                        </a>
                        
                        <form action="{{ route('admin.tagihan.destroy', $tagihan) }}" method="POST" class="d-inline w-100 w-sm-auto order-sm-2 order-1">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger shadow-sm fw-bold rounded-pill px-4 w-100" onclick="return confirm('APAKAH ANDA YAKIN ingin menghapus tagihan ini? Tindakan ini tidak dapat dibatalkan.')">
                                <i class="fas fa-trash me-2"></i> Hapus
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        
        {{-- KOLOM KANAN: Detail Santri & Riwayat Pembayaran --}}
        <div class="col-lg-6">
            
            {{-- Kartu: Informasi Santri --}}
            <div class="card shadow-lg border-0 rounded-4 mb-4 border-start border-5 border-info">
                <div class="card-header py-3 bg-info text-white rounded-top-4">
                    <h5 class="m-0 fw-bold"><i class="fas fa-user-graduate me-2"></i> Informasi Santri</h5>
                </div>
                <div class="card-body p-4">
                    {{-- DETAIL SANTRI (Menggunakan List Group) --}}
                    <ul class="list-group list-group-flush border rounded-3">
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <div class="text-muted small">Nama Santri</div>
                            <div class="fw-bold text-dark">{{ $tagihan->santri->nama_lengkap ?? $tagihan->santri->nama ?? 'N/A' }}</div>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <div class="text-muted small">Kelas</div>
                            <div class="fw-semibold text-secondary">{{ $tagihan->santri->kelas->nama_kelas ?? 'N/A' }}</div>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <div class="text-muted small">Wali Santri</div>
                            <div class="fw-semibold text-dark">{{ $tagihan->santri->waliSantri->name ?? 'N/A' }}</div>
                        </li>
                    </ul>
                </div>
            </div>
            
            {{-- Kartu: Riwayat Pembayaran --}}
            <div class="card shadow-lg border-0 rounded-4 border-start border-5 border-success">
                <div class="card-header py-3 bg-success text-white rounded-top-4">
                    <h5 class="m-0 fw-bold"><i class="fas fa-history me-2"></i> Riwayat Pembayaran</h5>
                </div>
                <div class="card-body p-4">
                    @if ($tagihan->pembayarans->isEmpty())
                        <div class="text-center py-4 bg-light rounded-3 border">
                            <i class="fas fa-money-check-alt fa-3x text-muted mb-3"></i>
                            <h6 class="mb-0 text-muted fw-bold">Belum ada pembayaran yang tercatat.</h6>
                        </div>
                    @else
                        <div class="table-responsive">
                            <table class="table table-sm table-striped table-hover align-middle mb-0 border">
                                <thead class="table-light">
                                    <tr>
                                        <th style="width: 25%;">Tgl Bayar</th>
                                        <th class="text-end" style="width: 30%;">Jumlah</th>
                                        <th style="width: 20%;">Metode</th>
                                        <th class="text-center" style="width: 25%;">Konfirmasi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($tagihan->pembayarans as $pembayaran)
                                        <tr>
                                            <td><small class="text-muted">{{ \Carbon\Carbon::parse($pembayaran->tanggal_bayar ?? $pembayaran->created_at)->format('d/m/Y') }}</small></td>
                                            <td class="text-end fw-bold text-primary">Rp {{ number_format($pembayaran->jumlah_bayar, 0, ',', '.') }}</td>
                                            <td><small>{{ $pembayaran->metode_pembayaran }}</small></td>
                                            <td class="text-center">
                                                @php
                                                    $status = $pembayaran->status_konfirmasi;
                                                    $class = $status == 'Dikonfirmasi' ? 'success' : ($status == 'Ditolak' ? 'danger' : 'warning text-dark');
                                                @endphp
                                                <span class="badge bg-{{ $class }} fw-semibold">{{ $status }}</span>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection