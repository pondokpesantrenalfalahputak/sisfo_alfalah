@extends('layouts.admin')

@section('title', 'Konfirmasi Pembayaran')
@section('page_title', 'Konfirmasi Pembayaran')

@section('header_actions')
    {{-- Tombol Aksi (Link ke Riwayat Pembayaran) --}}
    <a href="{{ route('admin.pembayaran.riwayat') }}" class="btn btn-outline-secondary shadow-sm rounded-pill d-flex align-items-center fw-semibold px-3">
        <i class="fas fa-history me-2"></i>
        Riwayat Pembayaran
    </a>
@endsection

@section('content')

<div class="container-fluid">
    <div class="row">
        <div class="col-12">

            <h2 class="mb-4 text-dark fw-bold">🧾 Konfirmasi Pembayaran</h2>

            {{-- Slot untuk Notifikasi Sukses/Gagal --}}
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show rounded-3 shadow-sm" role="alert">
                    <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show rounded-3 shadow-sm" role="alert">
                    <i class="fas fa-exclamation-triangle me-2"></i> {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="card shadow-lg border-0 rounded-4">
                
                {{-- HEADER CARD --}}
                <div class="card-header bg-warning text-dark p-4 rounded-top-4">
                    <h4 class="mb-1 fw-bolder fs-4"><i class="fas fa-check-double me-2"></i> Transaksi Menunggu Konfirmasi</h4>
                    <p class="mb-0 small fw-semibold">
                        Anda memiliki <span class="badge bg-danger text-white fs-6 fw-bolder">{{ count($pembayarans) ?? 0 }}</span> transaksi yang memerlukan persetujuan.
                    </p>
                </div>
                
                <div class="card-body p-4">

                    {{-- === 1. TAMPILAN DESKTOP (TABLE) === --}}
                    <div class="d-none d-md-block">
                        <div class="table-responsive">
                            <table class="table table-striped table-hover align-middle mb-0">
                                <thead class="table-dark text-nowrap">
                                    <tr>
                                        <th style="width: 5%;" class="text-center">#</th>
                                        <th style="width: 15%;">Pembayar & Tanggal</th>
                                        <th style="width: 15%;">Untuk Santri</th>
                                        <th style="width: 20%;">Detail Tagihan</th>
                                        <th style="width: 15%;" class="text-end">Jumlah Bayar</th>
                                        <th style="width: 30%;" class="text-center">Aksi Konfirmasi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($pembayarans as $pembayaran)
                                    <tr class="fw-semibold">
                                        <td class="text-center">{{ $loop->iteration }}</td>
                                        {{-- PEMBAYAR & TANGGAL --}}
                                        <td>
                                            <p class="mb-0 fw-bold text-dark">{{ $pembayaran->user->name }}</p>
                                            <span class="text-muted small text-nowrap">
                                                <i class="fas fa-calendar-alt me-1"></i> Tgl Bayar: {{ \Carbon\Carbon::parse($pembayaran->tanggal_pembayaran)->format('d M Y') }}
                                            </span>
                                        </td>
                                        {{-- UNTUK SANTRI --}}
                                        <td>
                                            <p class="mb-0 fw-bold text-primary">{{ $pembayaran->tagihan->santri->nama_lengkap }}</p>
                                            <span class="badge bg-info text-dark fw-bold">{{ $pembayaran->tagihan->santri->kelas->nama_kelas ?? 'N/A' }}</span>
                                        </td>
                                        {{-- DETAIL TAGIHAN --}}
                                        <td>
                                            <span class="badge bg-secondary mb-1 fw-bold">{{ $pembayaran->tagihan->jenis_tagihan }}</span>
                                            <p class="text-muted small mb-0">{{ Str::limit($pembayaran->tagihan->keterangan ?? 'Tanpa keterangan.', 40) }}</p>
                                        </td>
                                        {{-- JUMLAH BAYAR --}}
                                        <td class="fw-bolder text-success fs-5 text-end text-nowrap"> 
                                            Rp {{ number_format($pembayaran->jumlah_bayar, 0, ',', '.') }}
                                        </td>
                                        {{-- AKSI --}}
                                        <td class="text-center text-nowrap">
                                            <div class="d-flex justify-content-center gap-1"> 
                                                
                                                {{-- Button BUKTI --}}
                                                <a href="{{ Storage::url($pembayaran->bukti_pembayaran) }}" target="_blank" class="btn btn-sm btn-outline-primary fw-bold" data-bs-toggle="tooltip" title="Lihat Bukti Pembayaran">
                                                    <i class="fas fa-image"></i>
                                                </a>

                                                {{-- Form Konfirmasi --}}
                                                <form action="{{ route('admin.tagihan.konfirmasi.proses', $pembayaran) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    <input type="hidden" name="status" value="Dikonfirmasi">
                                                    <button type="submit" class="btn btn-sm btn-success fw-bold" title="Setujui Pembayaran" onclick="return confirm('KONFIRMASI? Anda yakin ingin menyetujui pembayaran ini?')" style="min-width: 80px;">
                                                        Setujui
                                                    </button>
                                                </form>
                                                {{-- Form Tolak --}}
                                                <form action="{{ route('admin.tagihan.konfirmasi.proses', $pembayaran) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    <input type="hidden" name="status" value="Ditolak">
                                                    <button type="submit" class="btn btn-sm btn-outline-danger fw-bold" title="Tolak Pembayaran" onclick="return confirm('TOLAK? Anda yakin ingin menolak pembayaran ini?')" style="min-width: 80px;">
                                                        Tolak
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="6" class="text-center py-5 text-muted bg-light">
                                            <i class="fas fa-thumbs-up me-2 fa-3x mb-3 text-success"></i>
                                            <h5 class="mb-1 fw-bold">Semua Selesai!</h5>
                                            <p class="mb-0">Tidak ada transaksi yang menunggu konfirmasi saat ini.</p>
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                    
                    {{-- === 2. TAMPILAN MOBILE (LIST CARD) === --}}
                    <div class="d-md-none">
                        <div class="list-group">
                            @forelse ($pembayarans as $pembayaran)
                                <div class="list-group-item list-group-item-action mb-3 shadow-sm rounded-3 border border-warning">
                                    
                                    {{-- Baris 1: ID & Santri --}}
                                    <div class="d-flex w-100 justify-content-between align-items-center mb-2 pb-2 border-bottom">
                                        <span class="badge bg-warning text-dark fw-bolder me-2">#{{ $loop->iteration }}</span>
                                        <h6 class="mb-0 fw-bold text-primary">{{ $pembayaran->tagihan->santri->nama_lengkap }}</h6>
                                        <span class="badge bg-info text-dark fw-bold">{{ $pembayaran->tagihan->santri->kelas->nama_kelas ?? 'N/A' }}</span>
                                    </div>

                                    {{-- Baris 2: Jumlah Bayar --}}
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <span class="small text-muted fw-semibold">Jumlah Dibayar:</span>
                                        <span class="fw-bolder text-success fs-5">Rp {{ number_format($pembayaran->jumlah_bayar, 0, ',', '.') }}</span>
                                    </div>
                                    
                                    {{-- Baris 3: Detail Tagihan --}}
                                    <div class="mb-3">
                                        <span class="badge bg-secondary mb-1 fw-bold">{{ $pembayaran->tagihan->jenis_tagihan }}</span>
                                        <p class="text-muted small mb-0">Tgl Bayar: {{ \Carbon\Carbon::parse($pembayaran->tanggal_pembayaran)->format('d M Y') }}</p>
                                        <p class="text-muted small mb-0">Pembayar: {{ $pembayaran->user->name }}</p>
                                        <p class="text-muted small mb-0">Ket. Tagihan: {{ Str::limit($pembayaran->tagihan->keterangan ?? 'Tanpa keterangan.', 50) }}</p>
                                    </div>

                                    {{-- Baris 4: AKSI --}}
                                    <div class="d-grid gap-2 d-flex justify-content-between pt-2 border-top">
                                        {{-- Button BUKTI --}}
                                        <a href="{{ Storage::url($pembayaran->bukti_pembayaran) }}" target="_blank" class="btn btn-sm btn-outline-primary fw-bold flex-fill">
                                            <i class="fas fa-image me-1"></i> Bukti
                                        </a>

                                        {{-- Form Konfirmasi --}}
                                        <form action="{{ route('admin.tagihan.konfirmasi.proses', $pembayaran) }}" method="POST" class="d-inline flex-fill">
                                            @csrf
                                            <input type="hidden" name="status" value="Dikonfirmasi">
                                            <button type="submit" class="btn btn-sm btn-success w-100 fw-bold" onclick="return confirm('KONFIRMASI? Anda yakin ingin menyetujui pembayaran ini?')">
                                                <i class="fas fa-check"></i> Setujui
                                            </button>
                                        </form>
                                        {{-- Form Tolak --}}
                                        <form action="{{ route('admin.tagihan.konfirmasi.proses', $pembayaran) }}" method="POST" class="d-inline flex-fill">
                                            @csrf
                                            <input type="hidden" name="status" value="Ditolak">
                                            <button type="submit" class="btn btn-sm btn-outline-danger w-100 fw-bold" onclick="return confirm('TOLAK? Anda yakin ingin menolak pembayaran ini?')">
                                                <i class="fas fa-times"></i> Tolak
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            @empty
                                <div class="alert alert-success text-center py-5 rounded-3">
                                    <i class="fas fa-thumbs-up me-2 fa-3x mb-3 text-success"></i>
                                    <h5 class="mb-1 fw-bold">Semua Selesai!</h5>
                                    <p class="mb-0">Tidak ada transaksi yang menunggu konfirmasi saat ini.</p>
                                </div>
                            @endforelse
                        </div>
                    </div>
                    
                </div>
            </div>

        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    // Inisialisasi Tooltip Bootstrap (Hanya digunakan di tampilan desktop/tabel)
    document.addEventListener('DOMContentLoaded', function () {
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        })
    });
</script>
@endpush