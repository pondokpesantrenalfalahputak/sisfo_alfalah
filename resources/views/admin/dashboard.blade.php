@extends('layouts.admin')

@section('title', 'Dashboard Utama')
@section('page_title', 'Dashboard Utama')

@section('content')

    {{-- SECTION 1: METRIC CARDS --}}
    <div class="row g-4 mb-5">
        
        {{-- KARTU 1: Santri (Primary) --}}
        <div class="col-xl-3 col-md-6 col-12">
            <div class="card bg-primary text-white shadow-sm h-100 border-0 overflow-hidden" style="border-radius: 1.5rem;">
                <div class="card-body p-4">
                    <div class="row align-items-center">
                        <div class="col me-2">
                            <div class="text-xs fw-medium text-uppercase mb-1 text-white-75 opacity-75">
                                Jumlah Santri Aktif
                            </div>
                            <h2 class="h2 fw-bolder mb-0 text-white">{{ $totalSantri ?? 0 }}</h2>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-user-graduate fa-3x text-white-50 opacity-75"></i>
                        </div>
                    </div>
                </div>
                <div class="card-footer bg-primary border-0 pt-2 pb-2" style="background-color: rgba(0,0,0,0.1) !important;">
                     <a href="{{ route('admin.santri.index') }}" class="text-white small fw-bold text-decoration-none d-flex align-items-center justify-content-between p-1">
                        <span>Lihat Detail</span> 
                        <i class="fas fa-arrow-circle-right ms-1"></i>
                    </a>
                </div>
            </div>
        </div>

        {{-- KARTU 2: Tagihan Belum Lunas (Danger) --}}
        <div class="col-xl-3 col-md-6 col-12">
            <div class="card bg-danger text-white shadow-sm h-100 border-0 overflow-hidden" style="border-radius: 1.5rem;">
                 <div class="card-body p-4">
                    <div class="row align-items-center">
                        <div class="col me-2">
                            <div class="text-xs fw-medium text-uppercase mb-1 text-white-75 opacity-75">
                                Total Tunggakan
                            </div>
                            {{-- Menggunakan data $totalTagihanBelumLunas dari Controller --}}
                            <h2 class="fw-bolder mb-0 text-white fs-5 fs-md-4" style="font-size: 1.4rem;">
                                Rp {{ number_format($totalTagihanBelumLunas ?? 0, 0, ',', '.') }}
                            </h2>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-money-bill-wave fa-3x text-white-50 opacity-75"></i>
                        </div>
                    </div>
                </div>
                <div class="card-footer bg-danger border-0 pt-2 pb-2" style="background-color: rgba(0,0,0,0.1) !important;">
                     <a href="{{ route('admin.tagihan.index') }}" class="text-white small fw-bold text-decoration-none d-flex align-items-center justify-content-between p-1">
                        <span>Kelola Pembayaran</span>
                        <i class="fas fa-arrow-circle-right ms-1"></i>
                    </a>
                </div>
            </div>
        </div>

        {{-- KARTU 3: Pengumuman Aktif (Success) --}}
        <div class="col-xl-3 col-md-6 col-12">
            <div class="card bg-success text-white shadow-sm h-100 border-0 overflow-hidden" style="border-radius: 1.5rem;">
                <div class="card-body p-4">
                    <div class="row align-items-center">
                        <div class="col me-2">
                            <div class="text-xs fw-medium text-uppercase mb-1 text-white-75 opacity-75">
                                Total Pengumuman
                            </div>
                            <h2 class="h2 fw-bolder mb-0 text-white">{{ $totalPengumuman ?? 0 }}</h2>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-bullhorn fa-3x text-white-50 opacity-75"></i>
                        </div>
                    </div>
                </div>
                <div class="card-footer bg-success border-0 pt-2 pb-2" style="background-color: rgba(0,0,0,0.1) !important;">
                     <a href="{{ route('admin.pengumuman.index') }}" class="text-white small fw-bold text-decoration-none d-flex align-items-center justify-content-between p-1">
                        <span>Buat Pengumuman</span> 
                        <i class="fas fa-arrow-circle-right ms-1"></i>
                    </a>
                </div>
            </div>
        </div>

         {{-- KARTU 4: Total Guru (Info) --}}
        <div class="col-xl-3 col-md-6 col-12">
            <div class="card bg-info text-white shadow-sm h-100 border-0 overflow-hidden" style="border-radius: 1.5rem;">
                <div class="card-body p-4">
                    <div class="row align-items-center">
                        <div class="col me-2">
                            <div class="text-xs fw-medium text-uppercase mb-1 text-white-75 opacity-75">
                                Total Guru
                            </div>
                            <h2 class="h2 fw-bolder mb-0 text-white">{{ $totalGuru ?? 0 }}</h2>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-chalkboard-teacher fa-3x text-white-50 opacity-75"></i>
                        </div>
                    </div>
                </div>
                <div class="card-footer bg-info border-0 pt-2 pb-2" style="background-color: rgba(0,0,0,0.1) !important;">
                     <a href="{{ route('admin.guru.index') }}" class="text-white small fw-bold text-decoration-none d-flex align-items-center justify-content-between p-1">
                        <span>Kelola Akun</span> 
                        <i class="fas fa-arrow-circle-right ms-1"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
    
    <hr class="my-5">

    {{-- SECTION 2: GRAFIK & VISUALISASI --}}
    <div class="row g-4 mb-5">
        
        {{-- KOLOM BESAR (8/12): Area Grafik Pendaftaran Santri --}}
        <div class="col-lg-8 col-12">
            <div class="card shadow border-0 h-100" style="border-radius: 1.5rem;">
                <div class="card-header bg-white py-3 border-bottom" style="border-top-left-radius: 1.5rem; border-top-right-radius: 1.5rem;">
                    <h6 class="m-0 fw-bold text-primary"><i class="fas fa-chart-area me-2"></i> Statistik Pendaftaran Santri (Tahun Ini)</h6>
                </div>
                <div class="card-body pt-4 pb-2 px-3 px-md-4">
                    <div style="height: 300px;"> 
                        <canvas id="pendaftaranChart"></canvas>
                    </div>
                    
                    {{-- Placeholder jika data pendaftaran kosong --}}
                    <div id="chartPlaceholder" class="text-center text-muted p-5" style="display: none;">
                        <i class="fas fa-chart-line display-4 mb-3"></i>
                        <p class="mb-0">Belum ada data pendaftaran santri untuk tahun ini.</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- KOLOM KECIL (4/12): Status Keuangan DINAMIS --}}
        <div class="col-lg-4 col-12">
            <div class="card shadow border-0 h-100" style="border-radius: 1.5rem;">
                 <div class="card-header bg-white py-3 border-bottom" style="border-top-left-radius: 1.5rem; border-top-right-radius: 1.5rem;">
                    <h6 class="m-0 fw-bold text-primary"><i class="fas fa-tasks me-2"></i> Status Keuangan</h6>
                </div>
                <div class="card-body p-4">
                    <h4 class="h6 fw-semibold mb-3">Persentase Tagihan Lunas (Tahun Ini)</h4>
                    
                    {{-- DATA DINAMIS: Persentase Lunas --}}
                    <div class="mb-2 d-flex justify-content-between small text-muted">
                        <span>Lunas:</span>
                        <span>{{ $persentaseLunas ?? 0 }}%</span>
                    </div>
                    {{-- Progress Bar --}}
                    <div class="progress mb-4" style="height: 12px; border-radius: 10px;">
                        <div class="progress-bar bg-success" role="progressbar" style="width: {{ $persentaseLunas ?? 0 }}%; border-radius: 10px;" aria-valuenow="{{ $persentaseLunas ?? 0 }}" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                    
                    <h4 class="h6 fw-semibold mb-3 mt-4">Ringkasan Cepat Bulan Ini</h4>
                    <ul class="list-group list-group-flush small">
                        <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                            Tagihan Bulan Ini
                            {{-- DATA DINAMIS: Tagihan Bulan Ini --}}
                            <span class="badge bg-primary rounded-pill">{{ $tagihanBulanIni ?? 0 }} Tagihan</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                            Terlambat Bayar
                            {{-- DATA DINAMIS: Santri Terlambat Bayar --}}
                            <span class="badge bg-danger rounded-pill">{{ $santriTerlambatBayar ?? 0 }} Santri</span>
                        </li>
                    </ul>
                    
                    <p class="small text-muted mt-3 mb-0">Rincian lebih lanjut dapat dilihat di menu Keuangan.</p>
                </div>
            </div>
        </div>
    </div>
    
    <hr class="my-5">

    {{-- SECTION 3: TABEL DATA TERBARU (Pengumuman) --}}
    <div class="row g-3">
        <div class="col-12">
            <div class="card shadow border-0" style="border-radius: 1.5rem;">
                <div class="card-header bg-white py-3 border-bottom" style="border-top-left-radius: 1.5rem; border-top-right-radius: 1.5rem;">
                    <h6 class="m-0 fw-bold text-primary"><i class="fas fa-list-alt me-2"></i>Pengumuman Terbaru</h6>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th class="small py-3 text-uppercase text-nowrap">Judul</th>
                                    {{-- Kolom Isi Singkat hanya muncul di tablet ke atas (md) --}}
                                    <th class="small py-3 text-uppercase d-none d-md-table-cell">Isi Singkat</th>
                                    <th class="small py-3 text-uppercase text-nowrap">Tanggal</th>
                                    <th class="small py-3 text-uppercase">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($pengumumans as $pengumuman)
                                <tr>
                                    <td class="small fw-semibold">{{ $pengumuman->judul }}</td>
                                    <td class="small text-muted d-none d-md-table-cell">{{ Str::limit(strip_tags($pengumuman->isi), 50) }}</td>
                                    <td class="small text-nowrap">{{ \Carbon\Carbon::parse($pengumuman->tanggal_publikasi)->translatedFormat('d M Y') }}</td>
                                    <td class="small">
                                        <a href="{{ route('admin.pengumuman.show', $pengumuman) }}" class="btn btn-sm btn-outline-primary py-0 px-2">Lihat</a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="text-center text-muted py-4 small">Tidak ada pengumuman terbaru.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer bg-light text-center py-3" style="border-bottom-left-radius: 1.5rem; border-bottom-right-radius: 1.5rem;">
                    <a href="{{ route('admin.pengumuman.index') }}" class="small fw-bold text-primary text-decoration-none">
                        Lihat Semua Pengumuman <i class="fas fa-chevron-right ms-1"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>

@endsection

{{-- PUSH SCRIPT UNTUK CHART.JS --}}
@push('js')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // 1. Cek Ketersediaan Chart.js
    if (typeof Chart === 'undefined') {
        console.error("Chart.js library not found. Please ensure it is loaded in the layout.");
        return;
    }

    // 2. Ambil Data dan Elemen
    const chartData = @json($chartData);
    const ctx = document.getElementById('pendaftaranChart');
    const placeholder = document.getElementById('chartPlaceholder');

    if (!ctx) {
        console.error("Elemen canvas dengan ID 'pendaftaranChart' tidak ditemukan.");
        return;
    }

    // 3. Cek Apakah Ada Data Pendaftaran
    // Cek apakah data ada dan setidaknya satu bulan memiliki pendaftaran > 0
    const hasData = chartData && chartData.data && Array.isArray(chartData.data) && chartData.data.some(count => count > 0);

    if (hasData) {
        // Tampilkan canvas dan sembunyikan placeholder
        ctx.style.display = 'block';
        if (placeholder) {
            placeholder.style.display = 'none';
        }

        // 4. Inisialisasi Chart.js
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: chartData.labels,
                datasets: [{
                    label: 'Jumlah Pendaftaran Santri',
                    data: chartData.data,
                    backgroundColor: 'rgba(54, 162, 235, 0.7)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1,
                    borderRadius: 5,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: true,
                        position: 'top',
                    },
                    tooltip: {
                        mode: 'index',
                        intersect: false,
                    }
                },
                scales: {
                    x: {
                        grid: {
                            display: false
                        }
                    },
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Jumlah Santri'
                        },
                        ticks: {
                            callback: function(value) {
                                // Pastikan nilai tick adalah integer (tidak ada 1.5 santri)
                                if (Number.isInteger(value)) {
                                    return value;
                                }
                            }
                        }
                    }
                }
            }
        });
    } else {
        // Sembunyikan canvas dan tampilkan placeholder
        ctx.style.display = 'none';
        if (placeholder) {
            placeholder.style.display = 'block';
        }
    }
});
</script>
@endpush