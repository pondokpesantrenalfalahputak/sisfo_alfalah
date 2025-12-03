@extends('layouts.wali')

@section('title', 'Dashboard')
@section('page_title', 'Dashboard Wali Santri')

@section('content')

    {{-- KARTU RINGKASAN DATA (RINGKASAN UTAMA) --}}
    <div class="row g-4 mb-5">
        
        {{-- 1. Total Santri --}}
        <div class="col-sm-6 col-lg-4">
            <div class="card shadow-lg border-start border-primary border-5 h-100 rounded-3 card-summary">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            {{-- Teks lebih jelas --}}
                            <p class="text-uppercase text-primary mb-1 small fw-bold">Santri Asuhan</p> 
                            {{-- Nilai lebih besar dan menonjol --}}
                            <h2 class="fw-bolder mb-0 display-6 text-dark">{{ $santriCount }}</h2>
                        </div>
                        <i class="fas fa-user-friends fa-4x text-primary opacity-25"></i>
                    </div>
                    <hr class="my-3">
                    <a href="{{ route('wali.santri.index') }}" class="small fw-semibold text-primary text-decoration-none d-flex align-items-center stretched-link">
                        Lihat Detail Santri <i class="fas fa-arrow-right ms-auto"></i>
                    </a>
                </div>
            </div>
        </div>

        {{-- 2. Tagihan Belum Lunas --}}
        <div class="col-sm-6 col-lg-4">
            <div class="card shadow-lg border-start border-danger border-5 h-100 rounded-3 card-summary">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <p class="text-uppercase text-danger mb-1 small fw-bold">Tagihan Belum Lunas</p>
                            <h2 class="fw-bolder mb-0 display-6 {{ $tagihanBelumLunasCount > 0 ? 'text-danger' : 'text-dark' }}">
                                {{ $tagihanBelumLunasCount }}
                            </h2>
                            <span class="small text-muted">Tagihan Mendesak</span>
                        </div>
                        <i class="fas fa-file-invoice-dollar fa-4x text-danger opacity-25"></i>
                    </div>
                    <hr class="my-3">
                    <a href="{{ route('wali.tagihan.index') }}" class="small fw-semibold text-danger text-decoration-none d-flex align-items-center stretched-link">
                        Cek Tagihan Sekarang <i class="fas fa-arrow-right ms-auto"></i>
                    </a>
                </div>
            </div>
        </div>

        {{-- 3. Menunggu Konfirmasi --}}
        <div class="col-sm-6 col-lg-4">
            <div class="card shadow-lg border-start border-warning border-5 h-100 rounded-3 card-summary">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <p class="text-uppercase text-warning mb-1 small fw-bold">Konfirmasi Pembayaran</p>
                            <h2 class="fw-bolder mb-0 display-6 {{ $pembayaranMenungguCount > 0 ? 'text-warning' : 'text-dark' }}">
                                {{ $pembayaranMenungguCount }}
                            </h2>
                            <span class="small text-muted">Bukti Menunggu Verifikasi</span>
                        </div>
                        <i class="fas fa-clock fa-4x text-warning opacity-25"></i>
                    </div>
                    <hr class="my-3">
                    {{-- Target tab Riwayat Pembayaran --}}
                    <a href="{{ route('wali.tagihan.index') }}#riwayat-content" class="small fw-semibold text-warning text-decoration-none d-flex align-items-center stretched-link">
                        Lihat Riwayat Pembayaran <i class="fas fa-arrow-right ms-auto"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
    
    {{-- RINGKASAN DATA SANTRI --}}
    @if ($santris->count() > 0)
        <div class="card shadow-lg border-0 mt-4 mb-5 rounded-4">
            <div class="card-header bg-primary text-white fw-bold d-flex align-items-center p-3 rounded-top-4">
                <i class="fas fa-user-graduate me-2 fa-lg"></i> Ringkasan Santri yang Anda Asuh
            </div>
            <div class="card-body p-0 p-md-4">
                
                {{-- DESKTOP VIEW: TABLE (Ditingkatkan) --}}
                <div class="table-responsive d-none d-md-block">
                    <table class="table table-striped table-hover mb-0 align-middle small">
                        <thead class="table-light">
                            <tr>
                                <th scope="col" style="width: 5%;">#</th>
                                <th scope="col" style="width: 40%;">Nama Santri</th>
                                <th scope="col" style="width: 25%;">Kelas</th>
                                <th scope="col" style="width: 15%;">Status</th>
                                <th scope="col" class="text-center" style="width: 15%;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($santris as $index => $santri)
                                <tr>
                                    <td class="text-muted">{{ $index + 1 }}</td>
                                    <td><span class="fw-semibold text-dark">{{ $santri->nama }}</span></td>
                                    <td>
                                        <span class="badge bg-info-subtle text-info-emphasis fw-semibold">{{ $santri->kelas->nama_kelas ?? 'N/A' }}</span>
                                    </td>
                                    <td>
                                        <span class="badge bg-success-subtle text-success-emphasis fw-semibold">{{ $santri->status ?? 'Aktif' }}</span>
                                    </td>
                                    <td class="text-center">
                                        <a href="{{ route('wali.santri.show', $santri) }}" class="btn btn-sm btn-primary rounded-pill px-3" title="Lihat Data {{ $santri->nama }}">
                                            <i class="fas fa-eye me-1"></i> Detail
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                {{-- MOBILE VIEW: STACKED CARDS (Ditingkatkan) --}}
                <div class="list-group d-block d-md-none p-3">
                    @foreach ($santris as $index => $santri)
                        <div class="list-group-item list-group-item-action mb-3 shadow-sm border-start border-5 border-primary rounded-3 card-mobile-santri">
                            <div class="d-flex w-100 justify-content-between align-items-center mb-2">
                                <h6 class="mb-0 fw-bold text-dark">{{ $index + 1 }}. {{ $santri->nama }}</h6>
                                <span class="badge bg-success-subtle text-success-emphasis fw-semibold">{{ $santri->status ?? 'Aktif' }}</span>
                            </div>
                            
                            <hr class="my-2">
                            
                            <p class="mb-1 small text-muted d-flex justify-content-between">
                                <span><i class="fas fa-school me-1"></i> Kelas:</span> 
                                <span class="fw-bold text-primary">{{ $santri->kelas->nama_kelas ?? 'N/A' }}</span>
                            </p>
                            
                            <div class="mt-3 text-end">
                                <a href="{{ route('wali.santri.show', $santri) }}" class="btn btn-sm btn-primary w-100 rounded-pill">
                                    <i class="fas fa-eye me-1"></i> Lihat Profil & Detail Absensi
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>

            </div>
        </div>
    @endif


    {{-- PENGUMUMAN TERBARU --}}
    <div class="row mt-4">
        <div class="col-md-12">
            <div class="card shadow-lg border-0 rounded-4">
                <div class="card-header bg-info text-white fw-bold d-flex align-items-center p-3 rounded-top-4">
                    <i class="fas fa-bullhorn me-2 fa-lg"></i> Pengumuman Terbaru
                </div>
                <div class="card-body p-0">
                    
                    @forelse ($pengumumanTerbaru as $p)
                    <div class="list-group-item list-group-item-action border-top-0 border-end-0 border-start-0 py-3 px-4 pengumuman-item">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <h6 class="fw-bold text-dark me-3 mb-0">
                                <span class="badge bg-primary me-2 small">{{ $p->kategori ?? 'Umum' }}</span>
                                {{ $p->judul }}
                            </h6>
                            <span class="badge bg-secondary-subtle text-secondary-emphasis py-1 px-2 flex-shrink-0 text-nowrap small fw-normal">
                                <i class="fas fa-calendar-alt me-1"></i> {{ \Carbon\Carbon::parse($p->tanggal_publikasi)->translatedFormat('d M Y') }}
                            </span>
                        </div>
                        
                        <p class="text-secondary small mb-3">
                            {{ Str::limit(strip_tags($p->isi), 150, '...') }} 
                        </p>
                        
                        <a href="{{ route('wali.pengumuman.show', $p) }}" class="btn btn-sm btn-primary rounded-pill">
                            Baca Selengkapnya <i class="fas fa-arrow-right ms-1"></i>
                        </a>
                    </div>
                    @empty
                    <div class="alert alert-info text-center py-4 rounded-3 border-0 m-4 shadow-sm">
                        <h5 class="mb-2"><i class="fas fa-info-circle me-2"></i> Belum Ada Pengumuman Aktif</h5>
                        <p class="mb-0">Mohon cek kembali di lain waktu untuk informasi terbaru.</p>
                    </div>
                    @endforelse
                </div>
                <div class="card-footer text-center bg-light p-3 rounded-bottom-4">
                    <a href="{{ route('wali.pengumuman.index') }}" class="btn btn-sm btn-link text-primary fw-bold text-decoration-none">
                        Lihat Semua Pengumuman <i class="fas fa-external-link-alt ms-1"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>

    {{-- CSS Kustom Tambahan --}}
    @push('css')
    <style>
        /* Efek hover pada kartu ringkasan */
        .card-summary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 15px rgba(0, 0, 0, 0.1) !important;
            transition: all 0.3s ease-in-out;
        }

        /* Memastikan link action card full width */
        .card-summary a.stretched-link {
            position: relative;
            z-index: 10;
        }

        /* Efek hover pada item pengumuman */
        .pengumuman-item:hover {
            background-color: #f8f9fa; /* Warna terang saat hover */
        }
        
        /* Penyesuaian Mobile: Nilai lebih besar di summary card */
        @media (max-width: 576px) {
            .display-6 {
                font-size: 2rem; /* Menyesuaikan ukuran display-6 agar tidak terlalu besar di mobile */
            }
            .card-summary .fa-4x {
                font-size: 3rem !important;
            }
        }
    </style>
    @endpush
@endsection