@extends('layouts.admin')

@section('title', 'Edit Santri')
@section('page_title', 'Edit Data Santri' )

@section('header_actions')
@endsection

@section('content')

<div class="container-fluid">
    <div class="row">
        <div class="col-12">

            {{-- Judul utama di atas card dipertahankan ukurannya agar jelas --}}
            <h5 class="mb-4 text-dark fw-bold"><i class="fas fa-pencil-alt me-2 text-warning opacity-75"></i> Edit Santri: {{ $santri->nama_lengkap }}</h5>

            <div class="card shadow-lg border-0 rounded-4 border-start border-5 border-warning">
                
                {{-- HEADER CARD --}}
                <div class="card-header bg-primary text-white p-4 rounded-top-4">
                    <h4 class="mb-0 fw-bold fs-5"><i class="fas fa-user-edit me-2"></i> Formulir Edit Data Santri</h4>
                    <p class="text-white-50 small mb-0">Lakukan perubahan data untuk santri {{ $santri->nama_lengkap }} dengan hati-hati.</p>
                </div>
                
                <div class="card-body p-4 p-md-5">

                    {{-- Tampilkan error validasi jika ada --}}
                    @if ($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show rounded-3 shadow-sm border-0" role="alert">
                            <h6 class="alert-heading fw-bold text-danger"><i class="fas fa-exclamation-circle me-2"></i> Ada Kesalahan Validasi!</h6>
                            <p class="small mb-2">Mohon periksa dan koreksi input Anda:</p>
                            <ul class="mb-0 ps-4 list-unstyled">
                                @foreach ($errors->all() as $error)
                                    <li class="small text-danger"><i class="fas fa-dot-circle fa-xs me-2"></i>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
                    
                    <form action="{{ route('admin.santri.update', $santri) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        {{-- Bagian I: Data Pribadi Santri --}}
                        {{-- Judul bagian diubah ke fs-6 (ukuran font terkecil di Bootstrap) --}}
                        <h6 class="fw-bold text-dark mb-1 mt-2 text-warning fs-6"><i class="fas fa-id-card me-2"></i> Data Pribadi</h6>
                        <hr class="mt-2 mb-4 border-warning opacity-25">
                        
                        <div class="row g-4">
                            
                            {{-- Nama Lengkap --}}
                            <div class="col-md-6">
                                <label for="nama_lengkap" class="form-label fw-medium text-muted small">Nama Lengkap <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-user"></i></span>
                                    <input type="text" name="nama_lengkap" id="nama_lengkap" 
                                           class="form-control @error('nama_lengkap') is-invalid @enderror" 
                                           placeholder="Nama Lengkap Santri" value="{{ old('nama_lengkap', $santri->nama_lengkap) }}" required>
                                    @error('nama_lengkap')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                            </div>
                            
                            {{-- NISN --}}
                            <div class="col-md-6">
                                <label for="nisn" class="form-label fw-medium text-muted small">NISN <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-fingerprint"></i></span>
                                    <input type="text" name="nisn" id="nisn" 
                                           class="form-control @error('nisn') is-invalid @enderror" 
                                           placeholder="Nomor Induk Siswa Nasional" value="{{ old('nisn', $santri->nisn) }}" required>
                                    @error('nisn')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                            </div>
                            
                            {{-- Jenis Kelamin --}}
                            <div class="col-md-6">
                                <label for="jenis_kelamin" class="form-label fw-medium text-muted small">Jenis Kelamin <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-venus-mars"></i></span>
                                    <select name="jenis_kelamin" id="jenis_kelamin" class="form-select @error('jenis_kelamin') is-invalid @enderror" required>
                                        <option value="">-- Pilih Jenis Kelamin --</option>
                                        <option value="Laki-laki" {{ old('jenis_kelamin', $santri->jenis_kelamin) == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                                        <option value="Perempuan" {{ old('jenis_kelamin', $santri->jenis_kelamin) == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                                    </select>
                                    @error('jenis_kelamin')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                            </div>
                            
                            {{-- Tanggal Lahir --}}
                            <div class="col-md-6">
                                <label for="tanggal_lahir" class="form-label fw-medium text-muted small">Tanggal Lahir <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
                                    <input type="date" name="tanggal_lahir" id="tanggal_lahir" 
                                           class="form-control @error('tanggal_lahir') is-invalid @enderror" 
                                           value="{{ old('tanggal_lahir', $santri->tanggal_lahir ? $santri->tanggal_lahir->format('Y-m-d') : '') }}" required>
                                    @error('tanggal_lahir')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                            </div>
                            
                        </div>
                        
                        <hr class="mt-5 mb-4 border-secondary opacity-25"> 
                        
                        {{-- Bagian II: Data Akademik dan Wali --}}
                        {{-- Judul bagian diubah ke fs-6 --}}
                        <h6 class="fw-bold text-dark mb-1 mt-2 text-info fs-6"><i class="fas fa-graduation-cap me-2"></i> Data Akademik & Wali</h6>
                        <hr class="mt-2 mb-4 border-info opacity-25">
                        <div class="row g-4">
                            
                            {{-- Kelas --}}
                            <div class="col-md-6">
                                <label for="kelas_id" class="form-label fw-medium text-muted small">Kelas <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-school"></i></span>
                                    <select name="kelas_id" id="kelas_id" class="form-select @error('kelas_id') is-invalid @enderror" required>
                                        <option value="">-- Pilih Kelas --</option>
                                        @foreach ($kelas as $k)
                                            <option value="{{ $k->id }}" {{ old('kelas_id', $santri->kelas_id) == $k->id ? 'selected' : '' }}>
                                                {{ $k->nama_kelas }} (Tingkat {{ $k->tingkat }})
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('kelas_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                            </div>
                            
                            {{-- Wali Santri --}}
                            <div class="col-md-6">
                                <label for="wali_santri_id" class="form-label fw-medium text-muted small">Wali Santri <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-user-tie"></i></span>
                                    <select name="wali_santri_id" id="wali_santri_id" class="form-select @error('wali_santri_id') is-invalid @enderror" required>
                                        <option value="">-- Pilih Wali Santri --</option>
                                        @foreach ($walis as $wali)
                                            <option value="{{ $wali->id }}" {{ old('wali_santri_id', $santri->wali_santri_id) == $wali->id ? 'selected' : '' }}>
                                                {{ $wali->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('wali_santri_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                            </div>
                            
                        </div>
                        
                        <hr class="mt-5 mb-4 border-secondary opacity-25">

                        {{-- Bagian III: Alamat dan Status --}}
                        {{-- Judul bagian diubah ke fs-6 --}}
                        <h6 class="fw-bold text-dark mb-1 mt-2 text-success fs-6"><i class="fas fa-map-marker-alt me-2"></i> Alamat & Status</h6>
                        <hr class="mt-2 mb-4 border-success opacity-25">
                        <div class="row g-4">
                            
                            {{-- Alamat (Textarea) --}}
                            <div class="col-md-8">
                                <label for="alamat" class="form-label fw-medium text-muted small">Alamat Lengkap</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-home"></i></span>
                                    <textarea name="alamat" id="alamat" class="form-control @error('alamat') is-invalid @enderror" 
                                            placeholder="Alamat Lengkap Domisili Santri" rows="3">{{ old('alamat', $santri->alamat) }}</textarea>
                                    @error('alamat')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                            </div>
                            
                            {{-- Status --}}
                            <div class="col-md-4">
                                <label for="status" class="form-label fw-medium text-muted small">Status Keaktifan <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-check-circle"></i></span>
                                    <select name="status" id="status" class="form-select @error('status') is-invalid @enderror" required>
                                        <option value="Aktif" {{ old('status', $santri->status) == 'Aktif' ? 'selected' : '' }}>Aktif</option>
                                        <option value="Tidak Aktif" {{ old('status', $santri->status) == 'Tidak Aktif' ? 'selected' : '' }}>Tidak Aktif</option>
                                    </select>
                                    @error('status')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                            </div>
                            
                        </div>
                        
                        <hr class="mt-5 mb-4 border-dark opacity-10">
                        
                        {{-- Tombol Aksi --}}
                        <div class="d-flex justify-content-end gap-2 pt-3">
                            <a href="{{ route('admin.santri.index') }}" class="btn btn-outline-secondary px-4 shadow-sm fw-semibold rounded-pill">
                                <i class="fas fa-times me-2"></i> Batal
                            </a>
                            <button type="submit" class="btn btn-warning px-4 shadow-lg fw-bold text-dark rounded-pill">
                                <i class="fas fa-redo me-2"></i> Update Data
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection