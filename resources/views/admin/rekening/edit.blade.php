@extends('layouts.admin')

@section('title', 'Edit Rekening')
@section('page_title', 'Edit Data Rekening Bank')

@section('header_actions')
    {{-- Tombol untuk kembali ke Daftar Rekening --}}
    <a href="{{ route('admin.rekening.index') }}" class="btn btn-outline-secondary shadow-sm rounded-pill d-flex align-items-center fw-semibold px-3">
        <i class="fas fa-list-alt me-2"></i>
        Daftar Rekening
    </a>
@endsection

@section('content')

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <h2 class="mb-4 text-dark fw-bold">✍️ Edit Rekening Bank</h2>

            <div class="card shadow-lg border-0 rounded-4 border-start border-5 border-warning">
                
                {{-- HEADER CARD DENGAN WARNA PRIMER --}}
                <div class="card-header bg-primary text-white p-4 rounded-top-4">
                    <h4 class="mb-0 fw-bold fs-5"><i class="fas fa-edit me-2"></i> Edit Rekening: {{ $rekening->nama_bank }}</h4>
                    <p class="text-white-50 small mb-0">Perbarui informasi rekening bank. Nomor rekening ini saat ini: <strong class="text-white">{{ $rekening->nomor_rekening }}</strong></p>
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
                    
                    <form action="{{ route('admin.rekening.update', $rekening) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="row g-4">
                            
                            {{-- Nama Bank --}}
                            <div class="col-md-6">
                                <label for="nama_bank" class="form-label fw-semibold">Nama Bank <span class="text-danger">*</span></label>
                                <div class="input-group input-group-lg">
                                    <span class="input-group-text"><i class="fas fa-university"></i></span>
                                    <input type="text" name="nama_bank" id="nama_bank" 
                                           class="form-control @error('nama_bank') is-invalid @enderror" 
                                           placeholder="Contoh: BRI, Mandiri" value="{{ old('nama_bank', $rekening->nama_bank) }}" required>
                                    @error('nama_bank')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                            </div>
                            
                            {{-- Nomor Rekening --}}
                            <div class="col-md-6">
                                <label for="nomor_rekening" class="form-label fw-semibold">Nomor Rekening <span class="text-danger">*</span></label>
                                <div class="input-group input-group-lg">
                                    <span class="input-group-text"><i class="fas fa-credit-card"></i></span>
                                    <input type="text" name="nomor_rekening" id="nomor_rekening" 
                                           class="form-control @error('nomor_rekening') is-invalid @enderror" 
                                           placeholder="Masukkan Nomor Rekening Tanpa Spasi" 
                                           value="{{ old('nomor_rekening', $rekening->nomor_rekening) }}" 
                                           required
                                           inputmode="numeric" 
                                           pattern="[0-9]+">
                                    @error('nomor_rekening')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                            </div>
                            
                            {{-- Atas Nama --}}
                            <div class="col-md-6">
                                <label for="atas_nama" class="form-label fw-semibold">Atas Nama Pemilik Rekening <span class="text-danger">*</span></label>
                                <div class="input-group input-group-lg">
                                    <span class="input-group-text"><i class="fas fa-user-circle"></i></span>
                                    <input type="text" name="atas_nama" id="atas_nama" 
                                           class="form-control @error('atas_nama') is-invalid @enderror" 
                                           placeholder="Masukkan Nama Lengkap Sesuai Rekening" value="{{ old('atas_nama', $rekening->atas_nama) }}" required>
                                    @error('atas_nama')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                            </div>
                            
                            {{-- Keterangan --}}
                            <div class="col-md-6">
                                <label for="keterangan" class="form-label fw-semibold">Keterangan (Opsional)</label>
                                <div class="input-group input-group-lg">
                                    <span class="input-group-text"><i class="fas fa-info-circle"></i></span>
                                    <textarea name="keterangan" id="keterangan" 
                                              class="form-control @error('keterangan') is-invalid @enderror" 
                                              placeholder="Contoh: Rekening khusus pembayaran SPP" 
                                              rows="3">{{ old('keterangan', $rekening->keterangan) }}</textarea>
                                    @error('keterangan')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                            </div>
                            
                        </div>
                        
                        <hr class="mt-5 mb-4 border-dark opacity-25">
                        
                        {{-- Tombol Aksi --}}
                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('admin.rekening.index') }}" class="btn btn-outline-secondary px-4 shadow-sm fw-semibold rounded-pill">
                                <i class="fas fa-times me-2"></i> Batal
                            </a>
                            <button type="submit" class="btn btn-warning px-4 shadow-lg fw-bold text-dark rounded-pill">
                                <i class="fas fa-save me-2"></i> Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection