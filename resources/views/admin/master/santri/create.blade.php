@extends('layouts.admin')

@section('title', 'Tambah Santri')
@section('page_title', 'Tambah Santri Baru')

@section('styles')
<style>
    /* Styling Card Utama */
    .form-card {
        border-radius: 1rem !important; /* Sudut lebih membulat */
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.05) !important; /* Bayangan halus */
    }
    
    /* Styling Card Section */
    .section-card {
        border: 1px solid var(--bs-gray-300);
        border-radius: 0.75rem;
        margin-bottom: 1.5rem;
    }

    /* Input Field Standardisasi */
    .form-label {
        font-weight: 600;
        font-size: 0.8rem;
        color: var(--bs-gray-700) !important; /* Label lebih gelap */
        margin-bottom: 0.3rem; /* Jarak label ke input */
        text-transform: uppercase;
    }
    .input-group-text {
        background-color: var(--bs-gray-100);
        color: var(--bs-primary);
    }
    .form-control, .form-select {
        border-color: var(--bs-gray-300);
        border-radius: 0.375rem;
        font-size: 0.9rem; /* Mengurangi ukuran font input/select */
    }

    /* Header Section yang Rapi */
    .section-title {
        background-color: var(--bs-light);
        padding: 0.75rem 1.5rem;
        border-bottom: 1px solid var(--bs-gray-300);
        font-size: 0.9rem;
        font-weight: 700;
        border-radius: 0.75rem 0.75rem 0 0;
    }

    /* ========================================= */
    /* PERBAIKAN KHUSUS MOBILE (max-width: 767.98px) */
    /* ========================================= */
    @media (max-width: 767.98px) {
        
        /* Card Utama */
        .card-header {
            padding: 1rem !important; /* Header card utama lebih kecil */
        }
        .card-body {
            padding: 1rem !important; /* Padding body card utama lebih kecil */
        }
        
        /* Section Card */
        .section-card {
            margin-bottom: 1rem; /* Jarak antar section lebih rapat */
        }
        .section-title {
            padding: 0.6rem 1rem; /* Padding header section lebih kecil */
            font-size: 0.85rem;
        }

        /* Card Body di dalam Section */
        .section-card .card-body {
            padding: 1rem !important; /* Padding body section lebih kecil */
        }

        /* Tombol Aksi */
        .btn {
            font-size: 0.8rem !important; /* Ukuran font tombol lebih kecil */
            padding: 0.5rem 1rem !important; /* Padding tombol lebih ramping */
            flex-grow: 1; /* Agar tombol membagi lebar secara merata */
        }
    }
</style>
@endsection

@section('content')

<div class="container-fluid">
    <div class="row">
        <div class="col-12">

            {{-- Judul Mobile --}}
            <h3 class="mb-4 text-dark fw-bold border-bottom pb-2 d-block d-md-none">Pendaftaran Santri Baru</h3> 

            <div class="card form-card border-0">
                
                {{-- HEADER CARD UTAMA (Minimalis) --}}
                <div class="card-header bg-white p-4 border-bottom rounded-top-4">
                    <h4 class="mb-0 fw-bold text-primary fs-5"><i class="fas fa-user-plus me-2"></i> Formulir Pendaftaran Santri Baru</h4>
                    <p class="text-muted small mb-0 mt-1">Pastikan semua kolom bertanda (<span class="text-danger">*</span>) telah terisi dengan benar.</p>
                </div>
                
                <div class="card-body p-3 p-md-5">
                    
                    {{-- Tampilkan error validasi jika ada --}}
                    @if ($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show rounded-3 shadow-sm border-0 small mb-5" role="alert">
                            <h6 class="alert-heading fw-bold text-danger fs-6"><i class="fas fa-exclamation-circle me-2"></i> Ada Kesalahan Validasi!</h6>
                            <p class="small mb-2">Mohon periksa dan koreksi input Anda:</p>
                            <ul class="mb-0 ps-4 list-unstyled">
                                @foreach ($errors->all() as $error)
                                    <li class="small text-danger"><i class="fas fa-dot-circle fa-xs me-2"></i>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <form action="{{ route('admin.santri.store') }}" method="POST">
                        @csrf
                        
                        {{-- ======================================================= --}}
                        {{-- Bagian I: Data Pribadi Santri --}}
                        {{-- ======================================================= --}}
                        <div class="section-card">
                            <div class="section-title text-primary"><i class="fas fa-id-card me-2"></i> Data Pribadi</div>
                            
                            <div class="card-body p-4 p-md-5">
                                <div class="row g-3 g-md-4">
                                    
                                    {{-- Nama Lengkap --}}
                                    <div class="col-md-6 col-12">
                                        <label for="nama_lengkap" class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-user"></i></span>
                                            <input type="text" name="nama_lengkap" id="nama_lengkap" 
                                                   class="form-control @error('nama_lengkap') is-invalid @enderror" 
                                                   placeholder="Nama Lengkap Santri" value="{{ old('nama_lengkap') }}" required>
                                            @error('nama_lengkap')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                        </div>
                                    </div>
                                    
                                    {{-- NISN --}}
                                    <div class="col-md-6 col-12">
                                        <label for="nisn" class="form-label">NIS <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-fingerprint"></i></span>
                                            <input type="text" name="nisn" id="nisn" 
                                                   class="form-control @error('nisn') is-invalid @enderror" 
                                                   placeholder="Nomor Induk Santri" value="{{ old('nisn') }}" required>
                                            @error('nisn')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                        </div>
                                    </div>
                                    
                                    {{-- Jenis Kelamin --}}
                                    <div class="col-md-6 col-12">
                                        <label for="jenis_kelamin" class="form-label">Jenis Kelamin <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-venus-mars"></i></span>
                                            <select name="jenis_kelamin" id="jenis_kelamin" class="form-select @error('jenis_kelamin') is-invalid @enderror" required>
                                                <option value="" disabled selected>-- Pilih Jenis Kelamin --</option>
                                                <option value="Laki-laki" {{ old('jenis_kelamin') == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                                                <option value="Perempuan" {{ old('jenis_kelamin') == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                                            </select>
                                            @error('jenis_kelamin')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                        </div>
                                    </div>
                                    
                                    {{-- Tanggal Lahir --}}
                                    <div class="col-md-6 col-12">
                                        <label for="tanggal_lahir" class="form-label">Tanggal Lahir <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
                                            <input type="date" name="tanggal_lahir" id="tanggal_lahir" 
                                                   class="form-control @error('tanggal_lahir') is-invalid @enderror" 
                                                   value="{{ old('tanggal_lahir') }}" required>
                                            @error('tanggal_lahir')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                        </div>
                                    </div>
                                    
                                </div>
                            </div> {{-- End Card Body I --}}
                        </div> {{-- End Section Card I --}}

                        
                        {{-- ======================================================= --}}
                        {{-- Bagian II: Data Akademik dan Wali --}}
                        {{-- ======================================================= --}}
                        <div class="section-card">
                            <div class="section-title text-warning"><i class="fas fa-graduation-cap me-2"></i> Data Akademik & Wali</div>
                            
                            <div class="card-body p-4 p-md-5">
                                <div class="row g-3 g-md-4">
                                    
                                    {{-- Kelas --}}
                                    <div class="col-md-6 col-12">
                                        <label for="kelas_id" class="form-label">Kelas <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-school"></i></span>
                                            <select name="kelas_id" id="kelas_id" class="form-select @error('kelas_id') is-invalid @enderror" required>
                                                <option value="" disabled selected>-- Pilih Kelas --</option>
                                                @foreach ($kelas as $k)
                                                    <option value="{{ $k->id }}" {{ old('kelas_id') == $k->id ? 'selected' : '' }}>
                                                        {{ $k->nama_kelas }} (Tingkat {{ $k->tingkat }})
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('kelas_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                        </div>
                                    </div>
                                    
                                    {{-- Wali Santri --}}
                                    <div class="col-md-6 col-12">
                                        <label for="wali_santri_id" class="form-label">Wali Santri <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-user-tie"></i></span>
                                            <select name="wali_santri_id" id="wali_santri_id" class="form-select @error('wali_santri_id') is-invalid @enderror" required>
                                                <option value="" disabled selected>-- Pilih Wali Santri --</option>
                                                @foreach ($waliSantri as $wali) 
                                                    <option value="{{ $wali->id }}" {{ old('wali_santri_id') == $wali->id ? 'selected' : '' }}>
                                                        {{ $wali->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('wali_santri_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                        </div>
                                    </div>
                                    
                                </div>
                            </div> {{-- End Card Body II --}}
                        </div> {{-- End Section Card II --}}
                        

                        {{-- ======================================================= --}}
                        {{-- Bagian III: Alamat dan Status --}}
                        {{-- ======================================================= --}}
                        <div class="section-card">
                            <div class="section-title text-success"><i class="fas fa-map-marker-alt me-2"></i> Alamat & Status</div>
                            
                            <div class="card-body p-4 p-md-5">
                                <div class="row g-3 g-md-4">
                                    
                                    {{-- Alamat --}}
                                    <div class="col-md-8 col-12">
                                        <label for="alamat" class="form-label">Alamat Lengkap</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-home"></i></span>
                                            <textarea name="alamat" id="alamat" class="form-control @error('alamat') is-invalid @enderror" 
                                                    placeholder="Alamat Lengkap Domisili Santri" rows="3">{{ old('alamat') }}</textarea>
                                            @error('alamat')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                        </div>
                                    </div>
                                    
                                    {{-- Status --}}
                                    <div class="col-md-4 col-12">
                                        <label for="status" class="form-label">Status Keaktifan <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-check-circle"></i></span>
                                            <select name="status" id="status" class="form-select @error('status') is-invalid @enderror" required>
                                                <option value="Aktif" {{ old('status', 'Aktif') == 'Aktif' ? 'selected' : '' }}>Aktif</option>
                                                <option value="Non-aktif" {{ old('status') == 'Non-aktif' ? 'selected' : '' }}>Non-aktif</option>
                                                <option value="Lulus" {{ old('status') == 'Lulus' ? 'selected' : '' }}>Lulus</option>
                                            </select>
                                            @error('status')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                        </div>
                                    </div>
                                    
                                </div>
                            </div> {{-- End Card Body III --}}
                        </div> {{-- End Section Card III --}}
                        
                        
                        {{-- Tombol Aksi (Ramping untuk Mobile) --}}
                        <div class="d-flex flex-row justify-content-end gap-2 pt-3">
                            <a href="{{ route('admin.santri.index') }}" class="btn btn-outline-secondary shadow-sm fw-semibold rounded-pill">
                                <i class="fas fa-times me-2 d-none d-sm-inline"></i> Batal
                            </a>
                            <button type="submit" class="btn btn-primary shadow-lg fw-bold rounded-pill">
                                <i class="fas fa-save me-2 d-none d-sm-inline"></i> Simpan Santri
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection