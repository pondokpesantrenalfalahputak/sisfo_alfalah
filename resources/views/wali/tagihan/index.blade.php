@extends('layouts.wali')

@section('title', 'Tagihan & Pembayaran')
@section('page_title', 'Daftar Tagihan')

@section('content')

    @php
        // Filter tagihan: Hanya tampilkan yang BELUM LUNAS (atau Sebagian Lunas)
        $tagihansAktif = $tagihans->filter(function ($tagihan) {
            // Kita asumsikan ada method isLunas() di Model Tagihan
            return !$tagihan->isLunas();
        });
    @endphp
    
    {{-- NAV TABS: Tetap Rapi & Clean --}}
    <ul class="nav nav-pills mb-4 justify-content-center justify-content-md-start p-2 rounded-pill bg-white shadow-sm clean-nav" id="myTab" role="tablist">
        <li class="nav-item me-2" role="presentation">
            <button class="nav-link active fw-bold px-4 py-2 rounded-pill text-dark" id="tagihan-tab" data-bs-toggle="tab" data-bs-target="#tagihan-content" type="button" role="tab" aria-controls="tagihan-content" aria-selected="true">
                <i class="fas fa-file-invoice-dollar me-2 text-danger"></i> Tagihan Aktif ({{ $tagihansAktif->count() }})
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link fw-bold px-4 py-2 rounded-pill text-dark" id="riwayat-tab" data-bs-toggle="tab" data-bs-target="#riwayat-content" type="button" role="tab" aria-controls="riwayat-content" aria-selected="false">
                <i class="fas fa-history me-2 text-primary"></i> Riwayat Pembayaran ({{ $riwayatPembayaran->count() }})
            </button>
        </li>
    </ul>

    <div class="tab-content" id="myTabContent">
        
        {{-- TAB: TAGIHAN AKTIF --}}
        <div class="tab-pane fade show active" id="tagihan-content" role="tabpanel" aria-labelledby="tagihan-tab">
            <div class="card shadow-lg border-0 rounded-4">
                {{-- CARD HEADER DENGAN TEMA (BOX 70%) --}}
                <div class="card-header bg-danger text-white fw-bold rounded-top-4 p-3 header-themed">
                    <i class="fas fa-money-check-alt me-2"></i> Daftar Tagihan yang Belum Lunas
                </div>
                <div class="card-body p-3 p-md-4">
            
                    @if ($tagihansAktif->isEmpty()) 
                        {{-- Konten kosong yang rapi --}}
                        <div class="text-center py-5 text-muted bg-light rounded border-danger border-2 border-dashed">
                            <i class="fas fa-check-circle me-2 fa-3x text-success mb-2"></i>
                            <h5 class="mb-0 mt-3 fw-bold">Tidak ada tagihan aktif saat ini.</h5>
                            <p class="small mb-0">Semua tagihan Anda telah lunas. Terima kasih!</p>
                        </div>
                    @else
                        {{-- 1. DESKTOP VIEW (Tidak ada perubahan signifikan) --}}
                        <div class="table-responsive d-none d-md-block">
                            <table class="table table-striped table-hover align-middle mb-0 small">
                                <thead class="table-light">
                                    <tr>
                                        <th style="width: 5%;">#</th>
                                        <th style="width: 25%;">Santri & Kelas</th>
                                        <th style="width: 25%;">Deskripsi Tagihan</th>
                                        <th style="width: 15%;" class="text-center">Jatuh Tempo</th>
                                        <th style="width: 15%;" class="text-end">Jumlah</th>
                                        <th style="width: 10%;" class="text-center">Status</th>
                                        <th style="width: 10%;" class="text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($tagihansAktif as $index => $tagihan)
                                        <tr>
                                            <td class="text-muted">{{ $index + 1 }}</td>
                                            <td>
                                                <span class="fw-semibold text-dark">{{ $tagihan->santri->nama ?? 'Nama Santri Kosong' }}</span> 
                                                <br>
                                                <small class="text-secondary">{{ $tagihan->santri->kelas->nama_kelas ?? 'Kelas N/A' }}</small>
                                            </td>
                                            <td class="small text-muted">{{ $tagihan->keterangan ?? $tagihan->jenis_tagihan }}</td>
                                            <td class="text-center text-nowrap small fw-bold text-danger">{{ $tagihan->tanggal_jatuh_tempo->translatedFormat('d F Y') }}</td>
                                            <td class="fw-bolder text-end text-dark fs-6">Rp {{ number_format($tagihan->jumlah_tagihan, 0, ',', '.') }}</td>
                                            <td class="text-center">
                                                @if ($tagihan->total_bayar_terkonfirmasi > 0)
                                                    <span class="badge bg-warning text-dark px-2 py-1 fw-bold rounded-pill">SEBAGIAN</span>
                                                @else
                                                    <span class="badge bg-danger text-white px-2 py-1 fw-bold rounded-pill">BELUM LUNAS</span>
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                <a href="{{ route('wali.tagihan.show', $tagihan) }}" class="btn btn-sm btn-danger rounded-circle p-2" title="Lihat Detail & Bayar">
                                                    <i class="fas fa-arrow-right"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        
                        {{-- 2. MOBILE VIEW (Penyempurnaan Dinamis) --}}
                        <div class="list-group d-block d-md-none">
                            @foreach ($tagihansAktif as $tagihan)
                                @php
                                    $statusColor = (($tagihan->total_bayar_terkonfirmasi > 0) ? 'warning' : 'danger');
                                    $statusLabel = (($tagihan->total_bayar_terkonfirmasi > 0) ? 'SEBAGIAN LUNAS' : 'BELUM LUNAS');
                                    $isExpired = $tagihan->tanggal_jatuh_tempo->lt(now()) && $statusLabel != 'SEBAGIAN LUNAS';
                                @endphp
                                
                                {{-- Menggunakan mb-4 untuk jarak yang lebih lega --}}
                                <div class="card mb-4 shadow-sm border border-2 border-{{ $statusColor }} rounded-3 card-hover-shadow"> 
                                    <div class="card-body p-3 bg-white rounded-2">
                                        {{-- Row 1: Santri & Jt Tempo --}}
                                        <div class="d-flex justify-content-between align-items-start mb-2">
                                            <div>
                                                <span class="fw-bolder text-dark text-truncate fs-6">{{ $tagihan->santri->nama ?? 'Santri N/A' }}</span>
                                                <p class="mb-0 extra-small text-muted">{{ $tagihan->santri->kelas->nama_kelas ?? 'Kelas N/A' }}</p>
                                            </div>
                                            {{-- Penekanan pada Jatuh Tempo --}}
                                            <div class="flex-shrink-0 text-end">
                                                <p class="mb-0 extra-small fw-bold text-muted">
                                                    <i class="fas fa-calendar-alt me-1"></i> Jatuh Tempo: 
                                                </p>
                                                <span class="small fw-bolder text-{{ $isExpired ? 'danger' : 'primary' }} text-uppercase">
                                                     {{ $tagihan->tanggal_jatuh_tempo->translatedFormat('d M Y') }}
                                                </span>
                                            </div>
                                        </div>
                                        
                                        <hr class="my-2">
                                        
                                        {{-- Row 2: Deskripsi dan Jumlah --}}
                                        <p class="mb-2 extra-small text-dark fw-semibold"><i class="fas fa-file-invoice me-1 text-secondary"></i> {{ $tagihan->keterangan ?? $tagihan->jenis_tagihan }}</p>

                                        <div class="d-flex justify-content-between align-items-center mt-3">
                                            {{-- JUMLAH TAGIHAN --}}
                                            <div>
                                                <p class="mb-0 extra-small text-muted">Jumlah Tagihan</p>
                                                <span class="fw-bolder text-dark fs-5 flex-grow-1">
                                                    Rp {{ number_format($tagihan->jumlah_tagihan, 0, ',', '.') }}
                                                </span>
                                            </div>
                                            
                                            {{-- STATUS BADGE --}}
                                            <span class="badge bg-{{ $statusColor }} text-white py-2 px-3 fw-bold rounded-pill flex-shrink-0 extra-small">
                                                {{ $statusLabel }}
                                            </span>
                                        </div>

                                        {{-- ACTION BUTTON (Tombol Outline dengan efek hover) --}}
                                        <div class="mt-3 text-end">
                                            <a href="{{ route('wali.tagihan.show', $tagihan) }}" class="btn btn-outline-danger btn-sm rounded-pill fw-bold text-uppercase detail-button">
                                                <i class="fas fa-arrow-right me-1"></i> DETAIL & BAYAR
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- TAB: RIWAYAT PEMBAYARAN --}}
        <div class="tab-pane fade" id="riwayat-content" role="tabpanel" aria-labelledby="riwayat-tab">
            <div class="card shadow-lg border-0 rounded-4">
                 {{-- CARD HEADER DENGAN TEMA (BOX 70%) --}}
                <div class="card-header bg-primary text-white fw-bold rounded-top-4 p-3 header-themed">
                    <i class="fas fa-receipt me-2"></i> Riwayat Pembayaran Anda
                </div>
                <div class="card-body p-3 p-md-4">
            
                    @if ($riwayatPembayaran->isEmpty())
                        <div class="text-center py-5 text-muted bg-light rounded border-info border-2 border-dashed">
                            <i class="fas fa-box-open me-2 fa-3x text-info mb-2"></i>
                            <h5 class="mb-0 mt-3 fw-bold">Belum ada riwayat pembayaran.</h5>
                            <p class="small mb-0">Riwayat akan muncul di sini setelah pembayaran terkonfirmasi.</p>
                        </div>
                    @else
                        {{-- 3. DESKTOP VIEW (Tidak ada perubahan signifikan) --}}
                        <div class="table-responsive d-none d-md-block">
                            <table class="table table-striped table-hover align-middle mb-0 small">
                                <thead class="table-light">
                                    <tr>
                                        <th style="width: 5%;">#</th>
                                        <th style="width: 30%;">Tagihan (Santri)</th>
                                        <th style="width: 15%;">Tanggal Bayar</th>
                                        <th style="width: 20%;" class="text-end">Jumlah Bayar</th>
                                        <th style="width: 15%;">Metode</th>
                                        <th style="width: 15%;" class="text-center">Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($riwayatPembayaran as $index => $pembayaran)
                                        @php
                                            $statusClass = [
                                                'Menunggu' => 'bg-warning text-dark',
                                                'Dikonfirmasi' => 'bg-success text-white',
                                                'Ditolak' => 'bg-danger text-white',
                                            ][$pembayaran->status_konfirmasi] ?? 'bg-secondary text-white';
                                        @endphp
                                        <tr>
                                            <td class="text-muted">{{ $index + 1 }}</td>
                                            <td>
                                                <span class="fw-semibold text-dark">{{ $pembayaran->tagihan->santri->nama ?? 'Santri N/A' }}</span>
                                                <br>
                                                <small class="text-secondary">{{ $pembayaran->tagihan->keterangan ?? 'Pembayaran' }}</small>
                                            </td>
                                            <td class="text-nowrap small text-muted">{{ $pembayaran->created_at->translatedFormat('d M Y H:i') }}</td>
                                            <td class="text-end fw-bolder text-dark fs-6">Rp {{ number_format($pembayaran->jumlah_bayar, 0, ',', '.') }}</td>
                                            <td class="small">{{ $pembayaran->rekening->nama_bank ?? 'Transfer' }}</td>
                                            <td class="text-center">
                                                <span class="badge {{ $statusClass }} py-1 px-2 fw-bold rounded-pill">{{ $pembayaran->status_konfirmasi }}</span>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        
                        {{-- 4. MOBILE VIEW (Penyempurnaan Riwayat) --}}
                        <div class="list-group d-block d-md-none">
                            @foreach ($riwayatPembayaran as $pembayaran)
                                @php
                                    $statusColor = [
                                        'Menunggu' => 'border-warning',
                                        'Dikonfirmasi' => 'border-success',
                                        'Ditolak' => 'border-danger',
                                    ][$pembayaran->status_konfirmasi] ?? 'border-secondary';
                                    $statusBadge = [
                                        'Menunggu' => 'bg-warning text-dark',
                                        'Dikonfirmasi' => 'bg-success text-white',
                                        'Ditolak' => 'bg-danger text-white',
                                    ][$pembayaran->status_konfirmasi] ?? 'bg-secondary';
                                @endphp
                                
                                {{-- Menggunakan mb-4 untuk jarak yang lebih lega --}}
                                <div class="card mb-4 shadow-sm border border-2 {{ $statusColor }} rounded-3 card-hover-shadow">
                                    <div class="card-body p-3 bg-white rounded-2">
                                        {{-- Row 1: Santri & Status --}}
                                        <div class="d-flex w-100 justify-content-between align-items-start">
                                            <span class="fw-bold text-dark text-truncate fs-6">{{ $pembayaran->tagihan->santri->nama ?? 'Santri N/A' }}</span>
                                            <span class="badge {{ $statusBadge }} py-1 px-3 fw-bolder rounded-pill flex-shrink-0 extra-small">{{ $pembayaran->status_konfirmasi }}</span>
                                        </div>
                                        <p class="mb-1 extra-small text-muted text-truncate"><i class="fas fa-tag me-1"></i> {{ $pembayaran->tagihan->keterangan ?? 'Pembayaran' }}</p>

                                        <hr class="my-2">
                                        
                                        {{-- Row 2: Detail Pembayaran --}}
                                        <div class="row extra-small text-secondary align-items-center">
                                            <div class="col-6 mb-1">
                                                <i class="fas fa-calendar-check me-1 text-primary"></i> Tgl Bayar: <strong class="text-dark">{{ $pembayaran->created_at->translatedFormat('d M Y') }}</strong>
                                            </div>
                                            <div class="col-6 mb-1 text-end">
                                                <i class="fas fa-money-check-alt me-1 text-primary"></i> Met.: <strong class="text-dark">{{ $pembayaran->rekening->nama_bank ?? 'Transfer' }}</strong>
                                            </div>
                                            <div class="col-12 mt-2 text-center">
                                                {{-- JUMLAH PEMBAYARAN (Ditekankan) --}}
                                                <p class="mb-1 extra-small text-muted">Jumlah Bayar Terkonfirmasi</p>
                                                <span class="fw-bolder text-primary fs-5 border-bottom border-top border-primary border-2 px-3 py-1 d-inline-block">
                                                    Rp {{ number_format($pembayaran->jumlah_bayar, 0, ',', '.') }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    {{-- CSS KUSTOM --}}
    @push('css')
    <style>
        .clean-nav .nav-link.active {
            background-color: #ffffff !important; 
            color: #dc3545 !important; 
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            position: relative;
        }

        /* Khusus untuk tab Riwayat */
        .clean-nav li:last-child .nav-link.active {
             color: var(--bs-primary) !important;
        }

        .border-dashed {
            border-style: dashed !important;
        }

        /* Card Header Lebih Ramping dan Berkontras */
        .header-themed {
            padding-top: 1rem !important; 
            padding-bottom: 1rem !important;
            font-size: 1.1rem;
        }

        /* Menyesuaikan ukuran teks untuk mobile */
        .extra-small {
            font-size: 0.75rem !important; 
        }

        /* Hover effect untuk mobile card */
        .card-hover-shadow:hover {
            transform: translateY(-2px);
            transition: all 0.2s ease-in-out;
            box-shadow: 0 8px 15px rgba(0, 0, 0, 0.15) !important;
        }

        /* Penyesuaian font utama Mobile Card */
        @media (max-width: 767.98px) {
            .card-body .fs-5 {
                font-size: 1.2rem !important; 
            }
            .card-body .fs-6 {
                font-size: 0.95rem !important; 
            }
            
            /* Menyesuaikan tombol outline agar terlihat lebih lembut */
            .btn-outline-danger {
                border-width: 1.5px !important; 
            }

             /* Mengurangi ukuran badge agar tidak terlalu besar di mobile */
            .card-body .badge {
                font-size: 0.65rem !important; 
            }
        }
    </style>
    @endpush
@endsection