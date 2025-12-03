@extends('layouts.admin')

@section('page_title', 'Input Rekapitulasi Alpha Bulanan')

@push('styles')
<style>
    /* Styling Card Modern (Soft UI / Clean) */
    .card-soft {
        border: none;
        border-radius: 1.25rem !important; /* Sudut lebih membulat */
        background-color: #ffffff; 
        /* Shadow sangat lembut untuk efek elevasi */
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.05); 
    }
    
    /* Warna Aksen Baru untuk Header */
    .bg-primary-header { background-color: #007bff !important; } /* Primary Blue yang Jelas */
    
    /* Input Style Khusus Alpha */
    .alpha-input {
        max-width: 65px !important; /* Sangat ringkas */
        padding: 0.25rem;
        height: auto;
        font-weight: 700;
        text-align: center;
        border: 1px solid #ff4d4d; /* Merah untuk penekanan Alpha */
        transition: all 0.2s;
        border-radius: 0.5rem;
        background-color: #fffafa; /* Latar belakang sedikit merah */
    }
    .alpha-input:focus {
        border-color: #ff0000;
        box-shadow: 0 0 0 0.2rem rgba(255, 0, 0, 0.25);
    }
    
    /* Hover/Focus pada Baris yang Diubah */
    .table-responsive tbody tr:hover {
        background-color: #f7fafc;
    }

    /* MOBILE OPTIMIZATION */
    @media (max-width: 767.98px) {
        /* Filter Layout: Vertikal dan Rapi */
        #filter-form .row > div {
            flex-basis: 100% !important;
            margin-bottom: 0.5rem;
        }
        
        #filter-form .col-lg-4.col-12 {
            flex-direction: column;
            gap: 0.5rem;
        }
        
        /* Tabel: Membuat kolom input alpha berada di tengah sel */
        .table-responsive table .alpha-input {
            max-width: 100%; 
            display: inline-block; 
        }
        
        /* Simpan Button full width */
        .btn-save-mobile {
            width: 100%;
        }
    }
</style>
@endpush

@section('content')

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <h2 class="mb-4 text-dark fw-bold">📝 Input Rekapitulasi Alpha Bulanan</h2>

            <div class="card card-soft mb-4">
                
                {{-- PERBAIKAN: Judul Sub-Seksi Yang Anda Blok, Dibuat Jelas dan Modern --}}
                <div class="card-header py-3 bg-white border-bottom-0 rounded-top-5">
                    <h4 class="m-0 fw-bolder text-dark pb-2 border-bottom border-secondary border-opacity-25">
                        <i class="fas fa-edit me-2 text-primary"></i> Input/Edit Rekapitulasi Jumlah Alpha
                    </h4>
                </div>
                {{-- AKHIR PERBAIKAN JUDUL SUB-SEKSI --}}

                <div class="card-body p-4">
                    
                    {{-- START: Formulir Pemilihan Bulan, Tahun, dan Kelas (Filter Card) --}}
                    <div class="p-4 mb-4 border border-info rounded-4 bg-light shadow-sm">
                        <h6 class="fw-bold text-dark mb-3"><i class="fas fa-filter me-2 text-info"></i> Pilih Periode dan Kelas</h6>
                        
                        <form method="GET" action="{{ route('admin.absensi_rekap.create_multi') }}" id="filter-form">
                            <div class="row g-3 align-items-end">
                                
                                <div class="col-lg-3 col-md-4 col-12">
                                    <label for="bulan" class="form-label small fw-semibold">Bulan</label>
                                    <select name="bulan" id="bulan" class="form-select form-select-sm rounded-3" required>
                                        @for ($m = 1; $m <= 12; $m++)
                                            <option value="{{ $m }}" {{ $m == $bulan ? 'selected' : '' }}>
                                                {{ \Carbon\Carbon::create()->month($m)->translatedFormat('F') }}
                                            </option>
                                        @endfor
                                    </select>
                                </div>
                                
                                <div class="col-lg-2 col-md-3 col-12">
                                    <label for="tahun" class="form-label small fw-semibold">Tahun</label>
                                    <select name="tahun" id="tahun" class="form-select form-select-sm rounded-3" required>
                                        @for ($y = Carbon\Carbon::now()->year; $y >= 2020; $y--)
                                            <option value="{{ $y }}" {{ $y == $tahun ? 'selected' : '' }}>{{ $y }}</option>
                                        @endfor
                                    </select>
                                </div>
                                
                                <div class="col-lg-3 col-md-5 col-12">
                                    <label for="kelas_id" class="form-label small fw-semibold">Kelas</label>
                                    <select name="kelas_id" id="kelas_id" class="form-select form-select-sm rounded-3" required>
                                        <option value="">-- Pilih Kelas --</option>
                                        @foreach ($kelasOptions as $kelas)
                                            <option value="{{ $kelas->id }}" {{ $kelas->id == $kelasId ? 'selected' : '' }}>
                                                {{ $kelas->nama_kelas }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                
                                <div class="col-lg-4 col-12 d-flex justify-content-start gap-2">
                                    <button type="submit" class="btn btn-info btn-sm rounded-pill px-3 fw-semibold flex-grow-1">
                                        <i class="fas fa-search me-1"></i> Tampilkan Santri
                                    </button>
                                    <a href="{{ route('admin.absensi_rekap.index') }}" class="btn btn-secondary btn-sm rounded-pill px-3 fw-semibold flex-grow-1">
                                         <i class="fas fa-arrow-left me-1"></i> Rekapitulasi
                                    </a>
                                </div>
                            </div>
                        </form>
                    </div>
                    {{-- END: Formulir Pemilihan Bulan, Tahun, dan Kelas --}}

                    @if (session('success'))
                        <div class="alert alert-success rounded-3 shadow-sm"><i class="fas fa-check-circle me-1"></i> {{ session('success') }}</div>
                    @endif
                    @if (session('error'))
                        <div class="alert alert-danger rounded-3 shadow-sm"><i class="fas fa-times-circle me-1"></i> {{ session('error') }}</div>
                    @endif

                    {{-- Konten Input --}}
                    @if ($kelasId && isset($santris) && $santris->isNotEmpty())
                        
                        <h5 class="mb-3 text-dark fw-bold border-bottom pb-2">
                            <i class="fas fa-users me-2 text-primary"></i> Daftar Santri Kelas 
                            <span class="text-primary">{{ $kelasOptions->find($kelasId)->nama_kelas ?? 'N/A' }}</span>
                            <small class="text-muted ms-3 fs-6 d-block d-md-inline">Periode: {{ Carbon\Carbon::createFromDate($tahun, $bulan)->translatedFormat('F Y') }}</small>
                        </h5>
                        
                        <div class="alert alert-danger small p-3 shadow-sm border-danger bg-light rounded-4">
                            <i class="fas fa-exclamation-triangle me-1"></i> Penting: Isi kolom dengan umlah hari Alpha(Tidak Hadir Tanpa Keterangan). Gunakan 0 jika tidak ada Alpha. Data yang sudah ada akan diperbarui.
                        </div>
                        
                        {{-- Formulir Input Rekapitulasi --}}
                        <form method="POST" action="{{ route('admin.absensi_rekap.store_multi') }}">
                            @csrf
                            <input type="hidden" name="bulan" value="{{ $bulan }}">
                            <input type="hidden" name="tahun" value="{{ $tahun }}">
                            <input type="hidden" name="kelas_id" value="{{ $kelasId }}">

                            <div class="table-responsive">
                                <table class="table table-bordered table-sm align-middle w-100" cellspacing="0">
                                    <thead class="bg-primary-header text-white text-center">
                                        <tr>
                                            <th rowspan="2" class="align-middle text-center text-nowrap" style="width: 5%; background-color: #0069d9 !important;">No</th>
                                            <th rowspan="2" class="align-middle text-start text-nowrap" style="width: 25%; min-width: 150px; background-color: #0069d9 !important;">Nama Santri</th>
                                            <th colspan="3" class="text-center text-white" style="background-color: #ff4d4d !important;">Alpha (Hari)</th>
                                            <th rowspan="2" class="align-middle text-nowrap" style="width: 30%; min-width: 180px; background-color: #0069d9 !important;">Keterangan Tambahan</th>
                                        </tr>
                                        <tr>
                                            <th class="text-center text-white text-nowrap" style="width: 10%; background-color: #e53935 !important;">Ngaji</th>
                                            <th class="text-center text-white text-nowrap" style="width: 10%; background-color: #e53935 !important;">Sholat</th>
                                            <th class="text-center text-white text-nowrap" style="width: 10%; background-color: #e53935 !important;">Roan</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($santris as $index => $santri)
                                            @php
                                                $absensiSaatIni = $dataAbsensiTersimpan->get($santri->id);
                                                $ngajiA = $absensiSaatIni ? $absensiSaatIni->ngaji_alpha : 0;
                                                $sholatA = $absensiSaatIni ? $absensiSaatIni->sholat_alpha : 0;
                                                $roanA = $absensiSaatIni ? $absensiSaatIni->roan_alpha : 0;
                                                $keterangan = $absensiSaatIni ? $absensiSaatIni->keterangan : '';
                                                
                                                // Tentukan warna latar jika ada data Alpha yang tersimpan
                                                $rowClass = ($ngajiA > 0 || $sholatA > 0 || $roanA > 0) ? 'table-warning border-start border-4 border-warning fw-semibold' : 'fw-semibold';
                                            @endphp
                                            <tr class="{{ $rowClass }}">
                                                <td class="text-center align-middle">{{ $index + 1 }}</td>
                                                <td class="align-middle text-dark text-nowrap">
                                                    <input type="hidden" name="absensi[{{ $index }}][santri_id]" value="{{ $santri->id }}">
                                                    {{ $santri->nama_lengkap }}
                                                </td>
                                                
                                                {{-- Alpha Ngaji --}}
                                                <td class="text-center align-middle">
                                                    <input type="number" min="0" name="absensi[{{ $index }}][ngaji_alpha]" 
                                                           class="form-control form-control-sm alpha-input mx-auto" 
                                                           value="{{ old('absensi.' . $index . '.ngaji_alpha', $ngajiA) }}"
                                                           placeholder="0">
                                                </td>
                                                
                                                {{-- Alpha Sholat --}}
                                                <td class="text-center align-middle">
                                                    <input type="number" min="0" name="absensi[{{ $index }}][sholat_alpha]" 
                                                           class="form-control form-control-sm alpha-input mx-auto" 
                                                           value="{{ old('absensi.' . $index . '.sholat_alpha', $sholatA) }}"
                                                           placeholder="0">
                                                </td>
                                                
                                                {{-- Alpha Roan --}}
                                                <td class="text-center align-middle">
                                                    <input type="number" min="0" name="absensi[{{ $index }}][roan_alpha]" 
                                                           class="form-control form-control-sm alpha-input mx-auto" 
                                                           value="{{ old('absensi.' . $index . '.roan_alpha', $roanA) }}"
                                                           placeholder="0">
                                                </td>
                                                
                                                {{-- Keterangan --}}
                                                <td class="align-middle">
                                                    <input type="text" name="absensi[{{ $index }}][keterangan]" 
                                                           class="form-control form-control-sm rounded-3" 
                                                           value="{{ old('absensi.' . $index . '.keterangan', $keterangan) }}" 
                                                           placeholder="Misal: Sakit/Pulang kampung">
                                                </td>
                                            </tr>
                                            {{-- Menampilkan error validasi --}}
                                            @if($errors->has('absensi.' . $index . '.ngaji_alpha') || $errors->has('absensi.' . $index . '.sholat_alpha') || $errors->has('absensi.' . $index . '.roan_alpha')) 
                                                <tr class="table-danger"><td colspan="6" class="small text-danger fw-bold text-center">⚠️ Error input angka pada baris Santri {{ $santri->nama_lengkap }}. Mohon periksa kembali.</td></tr> 
                                            @endif
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <div class="d-grid d-md-flex justify-content-md-end mt-4">
                                <button type="submit" class="btn btn-success btn-lg shadow rounded-pill px-4 btn-save-mobile">
                                    <span class="icon text-white-50">
                                        <i class="fas fa-database me-2"></i>
                                    </span>
                                    <span class="text fw-bold">Simpan Data Rekap Alpha ({{ $santris->count() }} Santri)</span>
                                </button>
                            </div>
                        </form>

                    @elseif ($kelasId)
                        {{-- $santris kosong atau tidak ditemukan --}}
                        <div class="alert alert-warning p-4 text-center rounded-4 border border-dashed-info">
                            <i class="fas fa-users-slash fa-2x mb-2"></i><br>
                            <h5 class="fw-bold">Tidak ditemukan santri aktif.</h5>
                            <p class="mb-0">Mohon periksa data kelas {{ $kelasOptions->find($kelasId)->nama_kelas ?? 'N/A' }} atau pilih kelas yang berbeda.</p>
                        </div>
                    @else
                        {{-- $kelasId belum dipilih --}}
                        <div class="alert alert-info p-4 text-center rounded-4 border border-dashed-info">
                            <i class="fas fa-mouse-pointer fa-2x mb-2"></i><br>
                            <h5 class="fw-bold">Menunggu Seleksi Filter</h5>
                            <p class="mb-0">Silakan pilih Bulan, Tahun, dan Kelas pada bagian filter di atas untuk menampilkan daftar santri dan memulai input rekapitulasi.</p>
                        </div>
                    @endif
                    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection