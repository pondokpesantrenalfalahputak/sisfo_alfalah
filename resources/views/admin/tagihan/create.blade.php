@extends('layouts.admin')

@section('title', 'Buat Tagihan Baru')
@section('page_title', 'Formulir Tagihan Baru')

@section('header_actions')
    {{-- Tombol Kembali --}}
    <a href="{{ route('admin.tagihan.index') }}" class="btn btn-outline-secondary shadow-sm rounded-pill d-flex align-items-center fw-semibold px-3">
        <i class="fas fa-list-alt me-2"></i>
        Daftar Tagihan
    </a>
@endsection

@section('content')

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <h2 class="mb-4 text-dark fw-bold">➕ Buat Tagihan Pembayaran Baru</h2>

            <div class="card shadow-lg border-0 rounded-4 border-start border-5 border-primary">
                
                {{-- HEADER CARD --}}
                <div class="card-header bg-primary text-white p-4 rounded-top-4">
                    <h4 class="mb-0 fw-bold fs-5"><i class="fas fa-plus-circle me-2"></i> Isi Detail Tagihan</h4>
                    <p class="text-white-50 small mb-0">Lengkapi formulir di bawah untuk membuat tagihan pembayaran baru.</p>
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
                    
                    {{-- Form Buat Tagihan --}}
                    <form action="{{ route('admin.tagihan.store') }}" method="POST">
                        @csrf
                        
                        <div class="row g-4">
                            
                            {{-- Kolom Kiri --}}
                            <div class="col-md-6">
                                
                                {{-- Santri ID --}}
                                <div>
                                    <label for="santri_id" class="form-label fw-semibold">Pilih Santri Penerima <span class="text-danger">*</span></label>
                                    <div class="input-group input-group-lg">
                                        <span class="input-group-text"><i class="fas fa-user-graduate"></i></span>
                                        <select name="santri_id" id="santri_id" class="form-select @error('santri_id') is-invalid @enderror" required>
                                            <option value="">-- Pilih Santri --</option>
                                            @foreach ($santris as $santri)
                                                <option value="{{ $santri->id }}" 
                                                    {{ old('santri_id') == $santri->id ? 'selected' : '' }}>
                                                    {{ $santri->nama_lengkap ?? $santri->nama }} (Kelas: {{ $santri->kelas->nama_kelas ?? 'N/A' }})
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('santri_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    </div>
                                </div>
                                
                                {{-- Jenis Tagihan --}}
                                <div class="mt-4">
                                    <label for="jenis_tagihan" class="form-label fw-semibold">Jenis Tagihan <span class="text-danger">*</span></label>
                                    <div class="input-group input-group-lg">
                                        <span class="input-group-text"><i class="fas fa-file-invoice"></i></span>
                                        <select name="jenis_tagihan" id="jenis_tagihan" class="form-select @error('jenis_tagihan') is-invalid @enderror" required>
                                            <option value="">-- Pilih Jenis --</option>
                                            @foreach ($jenisTagihan as $jenis)
                                                <option value="{{ $jenis }}" 
                                                    {{ old('jenis_tagihan') == $jenis ? 'selected' : '' }}>
                                                    {{ $jenis }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('jenis_tagihan')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    </div>
                                </div>

                                {{-- Nominal (Jumlah Tagihan) --}}
                                <div class="mt-4">
                                    <label for="jumlah_tagihan" class="form-label fw-semibold">Nominal Tagihan (Rp) <span class="text-danger">*</span></label>
                                    <div class="input-group input-group-lg">
                                        <span class="input-group-text">Rp</span>
                                        <input type="number" name="jumlah_tagihan" id="jumlah_tagihan" class="form-control @error('jumlah_tagihan') is-invalid @enderror" 
                                            placeholder="Contoh: 550000"
                                            value="{{ old('jumlah_tagihan') }}" required min="0" step="1000">
                                        @error('jumlah_tagihan')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    </div>
                                </div>
                            </div>

                            {{-- Kolom Kanan --}}
                            <div class="col-md-6">
                                
                                {{-- Tanggal Tagihan (Info Only) --}}
                                <div>
                                    <label for="tanggal_tagihan_info" class="form-label fw-semibold">Tanggal Dibuat</label>
                                    <div class="input-group input-group-lg">
                                        <span class="input-group-text"><i class="fas fa-calendar-check"></i></span>
                                        <input type="text" id="tanggal_tagihan_info" class="form-control bg-light" 
                                               value="{{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}" readonly>
                                    </div>
                                    <small class="text-info fst-italic">Tanggal tagihan akan otomatis dicatat hari ini.</small>
                                </div>

                                {{-- Tanggal Jatuh Tempo --}}
                                <div class="mt-4">
                                    <label for="tanggal_jatuh_tempo" class="form-label fw-semibold">Tanggal Jatuh Tempo <span class="text-danger">*</span></label>
                                    <div class="input-group input-group-lg">
                                        <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
                                        <input type="date" name="tanggal_jatuh_tempo" id="tanggal_jatuh_tempo" class="form-control @error('tanggal_jatuh_tempo') is-invalid @enderror" 
                                            value="{{ old('tanggal_jatuh_tempo', \Carbon\Carbon::now()->addDays(7)->format('Y-m-d')) }}" required>
                                    </div>
                                    @error('tanggal_jatuh_tempo')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>

                                {{-- Keterangan --}}
                                <div class="mt-4">
                                    <label for="keterangan" class="form-label fw-semibold">Keterangan (Opsional)</label>
                                    <div class="input-group input-group-lg">
                                        <span class="input-group-text"><i class="fas fa-comment-dots"></i></span>
                                        <textarea name="keterangan" id="keterangan" class="form-control @error('keterangan') is-invalid @enderror" 
                                                  placeholder="Contoh: SPP Bulan Januari 2026" 
                                                  rows="3">{{ old('keterangan') }}</textarea>
                                        @error('keterangan')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    </div>
                                </div>

                            </div> {{-- End Kolom Kanan --}}
                        </div> {{-- End Row --}}
                        
                        <hr class="mt-5 mb-4 border-dark opacity-25">
                        
                        {{-- Tombol Aksi --}}
                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('admin.tagihan.index') }}" class="btn btn-outline-secondary px-4 shadow-sm fw-semibold rounded-pill">
                                <i class="fas fa-times me-2"></i> Batal
                            </a>
                            <button type="submit" class="btn btn-primary px-4 shadow-lg fw-bold rounded-pill">
                                <i class="fas fa-save me-2"></i> Buat & Simpan Tagihan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection