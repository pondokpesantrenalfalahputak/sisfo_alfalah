@extends('layouts.admin')

@section('title', 'Tambah Santri')
@section('page_title', 'Tambah Santri Baru')

@section('header_actions')
    {{-- Tombol untuk kembali ke Daftar Santri --}}
    <a href="{{ route('admin.santri.index') }}" class="btn btn-outline-secondary shadow-sm rounded-pill d-flex align-items-center fw-semibold px-3">
        <i class="fas fa-list me-2"></i>
        Daftar Santri
    </a>
@endsection

@section('content')

<div class="container-fluid">
    <div class="row">
        <div class="col-12">

            <h2 class="mb-4 text-dark fw-bold">➕ Pendaftaran Santri Baru</h2>

            <div class="card shadow-lg border-0 rounded-4">
                
                {{-- HEADER CARD DENGAN WARNA PRIMER --}}
                <div class="card-header bg-primary text-white p-4 rounded-top-4">
                    <h4 class="mb-0 fw-bold fs-5"><i class="fas fa-user-plus me-2"></i> Formulir Pendaftaran Santri</h4>
                    <p class="text-white-50 small mb-0">Lengkapi data pribadi, akademik, dan status santri baru di bawah ini.</p>
                </div>
                
                <div class="card-body p-4">
                    
                    {{-- Tampilkan error validasi jika ada --}}
                    @if ($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show rounded-3 shadow-sm" role="alert">
                            <h6 class="alert-heading fw-bold"><i class="fas fa-exclamation-triangle me-2"></i> Mohon koreksi kesalahan berikut:</h6>
                            <ul class="mb-0 ps-3">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <form action="{{ route('admin.santri.store') }}" method="POST">
                        @csrf
                        
                        {{-- Bagian I: Data Pribadi Santri --}}
                        <h5 class="fw-bold text-dark mb-4 mt-2 border-bottom pb-2 text-primary"><i class="fas fa-id-card me-2"></i> Data Pribadi</h5>
                        <div class="row g-4">
                            
                            {{-- Nama Lengkap --}}
                            <div class="col-md-6">
                                <label for="nama_lengkap" class="form-label fw-semibold">Nama Lengkap <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-user"></i></span>
                                    <input type="text" name="nama_lengkap" id="nama_lengkap" 
                                           class="form-control form-control-lg @error('nama_lengkap') is-invalid @enderror" 
                                           placeholder="Nama Lengkap Santri" value="{{ old('nama_lengkap') }}" required>
                                    @error('nama_lengkap')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                            </div>
                            
                            {{-- NISN --}}
                            <div class="col-md-6">
                                <label for="nisn" class="form-label fw-semibold">NISN <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-fingerprint"></i></span>
                                    <input type="text" name="nisn" id="nisn" 
                                           class="form-control form-control-lg @error('nisn') is-invalid @enderror" 
                                           placeholder="Nomor Induk Siswa Nasional" value="{{ old('nisn') }}" required>
                                    @error('nisn')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                            </div>
                            
                            {{-- Jenis Kelamin --}}
                            <div class="col-md-6">
                                <label for="jenis_kelamin" class="form-label fw-semibold">Jenis Kelamin <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-venus-mars"></i></span>
                                    <select name="jenis_kelamin" id="jenis_kelamin" class="form-select form-select-lg @error('jenis_kelamin') is-invalid @enderror" required>
                                        <option value="" disabled selected>-- Pilih Jenis Kelamin --</option>
                                        <option value="Laki-laki" {{ old('jenis_kelamin') == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                                        <option value="Perempuan" {{ old('jenis_kelamin') == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                                    </select>
                                    @error('jenis_kelamin')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                            </div>
                            
                            {{-- Tanggal Lahir --}}
                            <div class="col-md-6">
                                <label for="tanggal_lahir" class="form-label fw-semibold">Tanggal Lahir <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
                                    <input type="date" name="tanggal_lahir" id="tanggal_lahir" 
                                           class="form-control form-control-lg @error('tanggal_lahir') is-invalid @enderror" 
                                           value="{{ old('tanggal_lahir') }}" required>
                                    @error('tanggal_lahir')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                            </div>
                            
                        </div>
                        
                        <hr class="mt-5 mb-4 border-primary opacity-25">
                        
                        {{-- Bagian II: Data Akademik dan Wali --}}
                        <h5 class="fw-bold text-dark mb-4 mt-2 border-bottom pb-2 text-warning"><i class="fas fa-graduation-cap me-2"></i> Data Akademik & Wali</h5>
                        <div class="row g-4">
                            
                            {{-- Kelas --}}
                            <div class="col-md-6">
                                <label for="kelas_id" class="form-label fw-semibold">Kelas <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-school"></i></span>
                                    <select name="kelas_id" id="kelas_id" class="form-select form-select-lg @error('kelas_id') is-invalid @enderror" required>
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
                            <div class="col-md-6">
                                <label for="wali_santri_id" class="form-label fw-semibold">Wali Santri <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-user-tie"></i></span>
                                    <select name="wali_santri_id" id="wali_santri_id" class="form-select form-select-lg @error('wali_santri_id') is-invalid @enderror" required>
                                        <option value="" disabled selected>-- Pilih Wali Santri --</option>
                                        @foreach ($walis as $wali)
                                            <option value="{{ $wali->id }}" {{ old('wali_santri_id') == $wali->id ? 'selected' : '' }}>
                                                {{ $wali->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('wali_santri_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                            </div>
                            
                        </div>
                        
                        <hr class="mt-5 mb-4 border-primary opacity-25">

                        {{-- Bagian III: Alamat dan Status --}}
                        <h5 class="fw-bold text-dark mb-4 mt-2 border-bottom pb-2 text-success"><i class="fas fa-map-marker-alt me-2"></i> Alamat & Status</h5>
                        <div class="row g-4">
                            
                            {{-- Alamat (Menggunakan Input Group biasa) --}}
                            <div class="col-md-8">
                                <label for="alamat" class="form-label fw-semibold">Alamat Lengkap</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-home"></i></span>
                                    <textarea name="alamat" id="alamat" class="form-control @error('alamat') is-invalid @enderror" 
                                            placeholder="Alamat Lengkap Domisili Santri" rows="3">{{ old('alamat') }}</textarea>
                                    @error('alamat')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                            </div>
                            
                            {{-- Status --}}
                            <div class="col-md-4">
                                <label for="status" class="form-label fw-semibold">Status Keaktifan <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-check-circle"></i></span>
                                    <select name="status" id="status" class="form-select form-select-lg @error('status') is-invalid @enderror" required>
                                        <option value="Aktif" {{ old('status', 'Aktif') == 'Aktif' ? 'selected' : '' }}>Aktif</option>
                                        <option value="Tidak Aktif" {{ old('status') == 'Tidak Aktif' ? 'selected' : '' }}>Tidak Aktif</option>
                                    </select>
                                    @error('status')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                            </div>
                            
                        </div>
                        
                        <hr class="mt-5 mb-4 border-dark opacity-25">
                        
                        {{-- Tombol Aksi --}}
                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('admin.santri.index') }}" class="btn btn-outline-secondary px-4 shadow-sm fw-semibold rounded-pill">
                                <i class="fas fa-times me-2"></i> Batal
                            </a>
                            <button type="submit" class="btn btn-primary px-4 shadow-lg fw-bold rounded-pill">
                                <i class="fas fa-user-plus me-2"></i> Simpan Santri
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection