@extends('layouts.wali')

@section('title', 'Detail Tagihan')
@section('page_title', 'Detail Tagihan: ' . ($tagihan->keterangan ?? $tagihan->jenis_tagihan))

@section('content')

    {{-- Pesan Status (Success/Error/Warning) --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-triangle me-2"></i> {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row">
        
        {{-- Detail Tagihan & Rincian Pembayaran --}}
        <div class="col-lg-7 mb-4">
            <div class="card shadow-lg h-100 border-0 rounded-4">
                <div class="card-header bg-primary text-white fw-bold d-flex align-items-center p-3 rounded-top-4">
                    <i class="fas fa-file-invoice me-2 fa-lg"></i> Informasi Tagihan
                </div>
                <div class="card-body p-4">
                    
                    {{-- DETAIL UTAMA --}}
                    <h5 class="fw-bold text-dark mb-4 pb-2 border-bottom"><i class="fas fa-user-graduate me-2 text-primary"></i> Data Santri & Tagihan</h5>
                    
                    {{-- Detail Tagihan dalam bentuk List Group yang lebih rapi di mobile --}}
                    <div class="list-group list-group-flush mb-4">
                        <div class="list-group-item d-flex justify-content-between align-items-center px-0">
                            <span class="text-muted small">Santri</span>
                            <span class="fw-bolder text-dark">{{ $tagihan->santri->nama ?? 'N/A' }}</span>
                        </div>
                        <div class="list-group-item d-flex justify-content-between align-items-center px-0">
                            <span class="text-muted small">Kelas</span>
                            <span class="badge bg-info-subtle text-info-emphasis fw-bold">{{ $tagihan->santri->kelas->nama_kelas ?? 'N/A' }}</span>
                        </div>
                        <div class="list-group-item d-flex justify-content-between align-items-center px-0">
                            <span class="text-muted small">Deskripsi Tagihan</span>
                            <span class="fw-semibold text-wrap text-end" style="max-width: 60%;">{{ $tagihan->keterangan ?? $tagihan->jenis_tagihan }}</span>
                        </div>
                        <div class="list-group-item d-flex justify-content-between align-items-center px-0">
                            <span class="text-muted small">Tanggal Tagihan</span>
                            <span class="small">{{ $tagihan->created_at->translatedFormat('d F Y') }}</span>
                        </div>
                        <div class="list-group-item d-flex justify-content-between align-items-center px-0 border-bottom-0">
                            <span class="text-muted small">Batas Pembayaran</span>
                            <span class="text-danger fw-bolder">
                                <i class="fas fa-clock me-1"></i> {{ $tagihan->tanggal_jatuh_tempo->translatedFormat('d F Y') }}
                            </span>
                        </div>
                    </div>
                    
                    {{-- RINCIAN KEUANGAN (Dibuat dalam bentuk Card-Like) --}}
                    <h5 class="fw-bold text-dark mt-4 mb-3 pb-2 border-bottom"><i class="fas fa-calculator me-2 text-primary"></i> Rincian Keuangan</h5>
                    
                    <div class="row g-2">
                        <div class="col-12">
                            <div class="card bg-light shadow-sm border-start border-primary border-4 py-2 px-3">
                                <div class="d-flex justify-content-between">
                                    <div class="small text-muted">Jumlah Tagihan</div>
                                    <div class="fw-bolder text-primary fs-6">Rp {{ number_format($tagihan->jumlah_tagihan, 0, ',', '.') }}</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="card bg-success-subtle border-start border-success border-4 py-2 px-3">
                                <div class="d-flex justify-content-between">
                                    <div class="small text-success fw-semibold">Total Dibayar (Terkonfirmasi)</div>
                                    <div class="fw-bolder text-success fs-6">Rp {{ number_format($tagihan->total_bayar_terkonfirmasi, 0, ',', '.') }}</div> 
                                </div>
                            </div>
                        </div>
                        <div class="col-12 mt-3">
                            <div class="card bg-white shadow-lg border-start border-4 {{ $sisaTagihan > 0 ? 'border-danger' : 'border-success' }} py-3 px-3">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="fw-bold fs-5 text-dark">Sisa Pembayaran</div>
                                    <div class="fw-bolder fs-4 {{ $sisaTagihan > 0 ? 'text-danger' : 'text-success' }}">
                                        Rp {{ number_format($sisaTagihan, 0, ',', '.') }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        {{-- Form Pembayaran / Status Lunas --}}
        <div class="col-lg-5 mb-4">
            @if ($tagihan->isLunas())
                <div class="card shadow-lg h-100 border-0 rounded-4">
                    <div class="card-body text-center py-5 bg-success text-white rounded-4">
                        <i class="fas fa-check-circle fa-4x mb-3"></i>
                        <h4 class="fw-bolder">TAGIHAN INI SUDAH LUNAS</h4>
                        <p class="mb-0 fs-6">Pembayaran telah dikonfirmasi dan selesai. Terima kasih.</p>
                        <hr class="text-white-50 my-4">
                        <a href="{{ route('wali.tagihan.index') }}" class="btn btn-light btn-lg rounded-pill">
                             <i class="fas fa-arrow-left me-1"></i> Kembali ke Daftar Tagihan
                        </a>
                    </div>
                </div>
            @else
                <div class="card shadow-lg border-0 border-top border-5 border-danger h-100 rounded-4">
                    <div class="card-header bg-danger text-white fw-bolder d-flex align-items-center p-3 rounded-top-4">
                        <i class="fas fa-hand-holding-usd me-2 fa-lg"></i> Form Konfirmasi Pembayaran
                    </div>
                    <div class="card-body p-4">
                        <form action="{{ route('wali.tagihan.bayar', $tagihan) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            
                            {{-- JUMLAH BAYAR --}}
                            <div class="mb-3">
                                <label for="jumlah_bayar" class="form-label fw-semibold">Jumlah yang Dibayarkan</label>
                                <div class="input-group input-group-lg">
                                    <span class="input-group-text bg-light fw-bold">Rp</span>
                                    <input type="number" name="jumlah_bayar" id="jumlah_bayar" class="form-control @error('jumlah_bayar') is-invalid @enderror" 
                                           value="{{ old('jumlah_bayar', $sisaTagihan) }}" required min="1" max="{{ $sisaTagihan }}" placeholder="Masukkan jumlah...">
                                </div>
                                <div class="form-text text-danger fw-semibold mt-2">Maksimal yang harus dibayar: <span class="fs-6 fw-bolder">Rp {{ number_format($sisaTagihan, 0, ',', '.') }}</span></div>
                                @error('jumlah_bayar') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            {{-- REKENING TUJUAN --}}
                            <div class="mb-3">
                                <label for="rekening_id" class="form-label fw-semibold">Transfer ke Rekening Tujuan</label>
                                <select name="rekening_id" id="rekening_id" class="form-select @error('rekening_id') is-invalid @enderror" required>
                                    <option value="">Pilih Rekening Tujuan...</option>
                                    @foreach ($rekenings as $rekening)
                                        <option value="{{ $rekening->id }}" {{ old('rekening_id') == $rekening->id ? 'selected' : '' }}>
                                            [{{ $rekening->nama_bank }}] A/N: {{ $rekening->atas_nama }} ({{ $rekening->nomor_rekening }})
                                        </option>
                                    @endforeach
                                </select>
                                <div class="form-text">Pastikan Anda memilih rekening tujuan yang benar.</div>
                                @error('rekening_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            {{-- BUKTI PEMBAYARAN --}}
                            <div class="mb-4">
                                <label for="bukti_pembayaran" class="form-label fw-semibold">Upload Bukti Pembayaran (JPG/PNG)</label>
                                <input type="file" name="bukti_pembayaran" id="bukti_pembayaran" class="form-control @error('bukti_pembayaran') is-invalid @enderror" required accept="image/jpeg, image/png">
                                <div class="form-text">Maksimal 2MB. Bukti ini wajib untuk verifikasi Admin.</div>
                                @error('bukti_pembayaran') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <button type="submit" class="btn btn-success w-100 mt-2 btn-lg shadow rounded-pill">
                                <i class="fas fa-paper-plane me-2"></i> Konfirmasi Pembayaran
                            </button>
                        </form>
                    </div>
                </div>
            @endif
        </div>
    </div>
    
    {{-- Riwayat Pembayaran untuk Tagihan Ini --}}
    <div class="row mt-4">
        <div class="col-lg-12">
            <div class="card shadow-lg border-0 rounded-4">
                <div class="card-header bg-info text-white fw-bold d-flex align-items-center p-3 rounded-top-4">
                    <i class="fas fa-receipt me-2 fa-lg"></i> Riwayat Pembayaran (untuk tagihan ini)
                </div>
                <div class="card-body p-0 p-md-4">
                    
                    @if ($pembayarans->isEmpty())
                         <div class="text-center py-4 text-muted bg-light rounded border-0">
                            <i class="fas fa-box-open me-2 fs-4"></i>
                            <p class="mb-0 mt-2">Belum ada riwayat pembayaran untuk tagihan ini.</p>
                        </div>
                    @else
                        
                        {{-- DESKTOP VIEW (Tabel Standar) --}}
                        <div class="table-responsive d-none d-md-block">
                            <table class="table table-striped table-hover mb-0 align-middle small">
                                <thead class="table-light">
                                    <tr>
                                        <th style="width: 5%;">#</th>
                                        <th style="width: 20%;">Tanggal Bayar</th>
                                        <th style="width: 25%;" class="text-end">Jumlah Bayar</th>
                                        <th style="width: 30%;" class="text-center">Status Konfirmasi</th>
                                        <th style="width: 20%;" class="text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($pembayarans as $index => $pembayaran)
                                        @php
                                            $statusClass = [
                                                'Menunggu' => 'bg-warning text-dark',
                                                'Dikonfirmasi' => 'bg-success-subtle text-success-emphasis',
                                                'Ditolak' => 'bg-danger-subtle text-danger-emphasis',
                                            ][$pembayaran->status_konfirmasi] ?? 'bg-secondary';
                                        @endphp
                                        <tr>
                                            <td class="text-muted">{{ $index + 1 }}</td>
                                            <td class="text-nowrap small text-muted">{{ $pembayaran->created_at->translatedFormat('d M Y H:i') }}</td>
                                            <td class="text-end fw-bolder text-dark fs-6">Rp {{ number_format($pembayaran->jumlah_bayar, 0, ',', '.') }}</td>
                                            <td class="text-center">
                                                <span class="badge {{ $statusClass }} py-2 px-3 fw-bold">{{ $pembayaran->status_konfirmasi }}</span>
                                            </td>
                                            <td class="text-center">
                                                <a href="{{ Storage::url($pembayaran->bukti_pembayaran) }}" target="_blank" class="btn btn-sm btn-outline-info rounded-pill" title="Lihat Bukti Pembayaran">
                                                    <i class="fas fa-image me-1"></i> Bukti
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        
                        {{-- MOBILE VIEW (Stacked Cards/List Group) --}}
                        <div class="list-group d-block d-md-none p-3">
                            @foreach ($pembayarans as $index => $pembayaran)
                                @php
                                    $statusColor = [
                                        'Menunggu' => 'border-warning',
                                        'Dikonfirmasi' => 'border-success',
                                        'Ditolak' => 'border-danger',
                                    ][$pembayaran->status_konfirmasi] ?? 'border-secondary';
                                    $statusBadge = [
                                        'Menunggu' => 'bg-warning text-dark',
                                        'Dikonfirmasi' => 'bg-success-subtle text-success-emphasis',
                                        'Ditolak' => 'bg-danger-subtle text-danger-emphasis',
                                    ][$pembayaran->status_konfirmasi] ?? 'bg-secondary';
                                @endphp
                                <div class="list-group-item list-group-item-action mb-3 shadow-sm border border-4 {{ $statusColor }} rounded-3">
                                    <div class="d-flex w-100 justify-content-between align-items-center">
                                        <h6 class="mb-1 fw-bold text-dark">Pembayaran ke-{{ $index + 1 }}</h6>
                                        <span class="badge {{ $statusBadge }} py-2 px-3 fw-bold flex-shrink-0">{{ $pembayaran->status_konfirmasi }}</span>
                                    </div>
                                    <hr class="my-2">
                                    <div class="row small text-secondary">
                                        <div class="col-12 mb-2">
                                            <i class="fas fa-calendar-check me-1"></i> Tgl Bayar: <strong class="text-dark">{{ $pembayaran->created_at->translatedFormat('d M Y H:i') }}</strong>
                                        </div>
                                        <div class="col-12 mb-2">
                                            <i class="fas fa-money-bill-wave me-1"></i> Jumlah: 
                                            <span class="badge bg-primary fs-6 py-1 px-2 fw-bold ms-1">
                                                Rp {{ number_format($pembayaran->jumlah_bayar, 0, ',', '.') }}
                                            </span>
                                        </div>
                                    </div>
                                    <div class="mt-2 text-center">
                                        <a href="{{ Storage::url($pembayaran->bukti_pembayaran) }}" target="_blank" class="btn btn-sm btn-outline-info w-100 rounded-pill">
                                            <i class="fas fa-image me-1"></i> Lihat Bukti Pembayaran
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    
    {{-- Tombol Kembali di Bawah --}}
    <div class="row mt-4 mb-5">
        <div class="col-12 text-center text-md-end">
            <a href="{{ route('wali.tagihan.index') }}" class="btn btn-secondary btn-lg rounded-pill px-4">
                <i class="fas fa-arrow-left me-1"></i> Kembali ke Daftar Tagihan
            </a>
        </div>
    </div>
@endsection