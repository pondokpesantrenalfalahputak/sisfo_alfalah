@extends('layouts.admin')

@section('title', 'Dashboard Utama')
@section('page_title', 'Dashboard Utama')

@section('content')

    {{-- Kartu Ringkasan Data (Menggunakan grid dan card Bootstrap) --}}
    <div class="mb-5">
        
        {{-- Area Metrik Utama --}}
        <div class="row g-4">
            
            {{-- KARTU 1: Santri (Aksen Amber/Warning) --}}
            <div class="col-lg-4 col-md-6 col-12">
                <div class="card bg-warning text-white shadow-lg border-0 h-100" 
                     style="background-color: #f7931e !important; transform: none; transition: transform 0.3s;"
                     onmouseover="this.style.transform='scale(1.03)'; this.style.boxShadow='0 0.5rem 1rem rgba(0,0,0,0.2) !important';"
                     onmouseout="this.style.transform='none'; this.style.boxShadow='0 1rem 3rem rgba(0,0,0,.175)!important';">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <small class="text-uppercase text-white-75 fw-semibold tracking-wider">Jumlah Santri</small>
                                <h1 class="display-3 fw-bolder mt-2">{{ $totalSantri ?? 0 }}</h1>
                                <p class="text-sm text-white-75 mb-0">Santri Aktif Keseluruhan</p>
                            </div>
                            {{-- Ikon Besar dengan Opasitas --}}
                            <i class="fas fa-user-graduate text-white-50 opacity-25" style="font-size: 4rem;"></i>
                        </div>
                    </div>
                </div>
            </div>

            {{-- KARTU 2: Tagihan Belum Lunas (Aksen Merah/Danger) --}}
            <div class="col-lg-4 col-md-6 col-12">
                <div class="card bg-danger text-white shadow-lg border-0 h-100"
                     style="transform: none; transition: transform 0.3s;"
                     onmouseover="this.style.transform='scale(1.03)'; this.style.boxShadow='0 0.5rem 1rem rgba(0,0,0,0.2) !important';"
                     onmouseout="this.style.transform='none'; this.style.boxShadow='0 1rem 3rem rgba(0,0,0,.175)!important';">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <small class="text-uppercase text-white-75 fw-semibold tracking-wider">Tagihan Belum Lunas</small>
                                <h2 class="h1 fw-bolder mt-2">Rp {{ number_format($totalTagihanBelumLunas ?? 0, 0, ',', '.') }}</h2>
                                <p class="text-sm text-white-75 mb-0">Total Tunggakan Bulan Ini</p>
                            </div>
                            {{-- Ikon Besar dengan Opasitas --}}
                            <i class="fas fa-money-bill-wave text-white-50 opacity-25" style="font-size: 4rem;"></i>
                        </div>
                    </div>
                </div>
            </div>

            {{-- KARTU 3: Pengumuman Aktif (Aksen Biru Tua/Primary) --}}
            <div class="col-lg-4 col-md-12 col-12">
                <div class="card text-white shadow-lg border-0 h-100" 
                     style="background-color: #0d47a1; transform: none; transition: transform 0.3s;"
                     onmouseover="this.style.transform='scale(1.03)'; this.style.boxShadow='0 0.5rem 1rem rgba(0,0,0,0.2) !important';"
                     onmouseout="this.style.transform='none'; this.style.boxShadow='0 1rem 3rem rgba(0,0,0,.175)!important';">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <small class="text-uppercase text-white-75 fw-semibold tracking-wider">Pengumuman Aktif</small>
                                <h1 class="display-3 fw-bolder mt-2">{{ $totalPengumuman ?? 0 }}</h1>
                                <p class="text-sm text-white-75 mb-0">Pengumuman yang Sedang Tayang</p>
                            </div>
                            {{-- Ikon Besar dengan Opasitas --}}
                            <i class="fas fa-bullhorn text-white-50 opacity-25" style="font-size: 4rem;"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <hr class="my-5">
    
    {{-- Pengumuman Terbaru --}}
    <div class="card shadow-lg border-0">
        <div class="card-body p-4 p-md-5">
            <h3 class="h4 fw-bold text-primary mb-4 border-bottom pb-3 d-flex align-items-center">
                <i class="fas fa-bullhorn text-warning me-3"></i> Pengumuman Terbaru
            </h3>
            
            <div class="row g-4">
                @forelse($pengumumans->take(3) as $pengumuman)
                {{-- Kartu Pengumuman Tunggal --}}
                <div class="col-md-4">
                    <div class="card bg-light shadow-sm border h-100 hover-shadow transition-shadow">
                        <div class="card-body d-flex flex-column justify-content-between">
                            <div>
                                <h4 class="h5 fw-semibold text-dark mb-2 text-truncate" title="{{ $pengumuman->judul }}">
                                    {{ $pengumuman->judul }}
                                </h4>
                                <p class="small text-muted mb-3 fw-medium">
                                    {{ \Carbon\Carbon::parse($pengumuman->tanggal_publikasi)->translatedFormat('d F Y') }}
                                </p>
                                <p class="card-text text-secondary mb-4 line-clamp-3" style="max-height: 4.5em; overflow: hidden;">
                                    {{ Str::limit($pengumuman->isi, 100) }}
                                </p>
                            </div>
                            <a href="{{ route('admin.pengumuman.show', $pengumuman) }}" class="small fw-semibold text-warning text-decoration-none mt-auto align-self-end d-flex align-items-center">
                                Baca Selengkapnya
                                <i class="fas fa-arrow-right small ms-2"></i>
                            </a>
                        </div>
                    </div>
                </div>
                @empty
                <div class="col-12">
                    <div class="p-5 text-center text-muted bg-light rounded border border-dashed border-secondary">
                        <i class="fas fa-inbox display-4 mb-3"></i>
                        <p class="fw-medium mb-0">Belum ada pengumuman yang tersedia saat ini.</p>
                    </div>
                </div>
                @endforelse
            </div>
            
            @if(isset($pengumumans) && $pengumumans->count() > 3)
            <div class="text-center mt-5">
                <a href="{{ route('admin.pengumuman.index') }}" class="btn btn-outline-primary btn-lg shadow-sm">
                    Lihat Semua Pengumuman
                </a>
            </div>
            @endif
        </div>
    </div>

@endsection