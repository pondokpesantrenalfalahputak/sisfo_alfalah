@extends('layouts.admin')

@section('title', 'Edit Tagihan')
@section('page_title', 'Edit Data Tagihan Pembayaran')

@section('header_actions')
    {{-- Tombol untuk kembali ke Daftar Tagihan --}}
    <a href="{{ route('admin.tagihan.index') }}" class="btn btn-outline-secondary shadow-sm rounded-pill d-flex align-items-center fw-semibold px-3">
        <i class="fas fa-list-alt me-2"></i>
        Daftar Tagihan
    </a>
@endsection

@section('content')

<div class="container-fluid">
    <div class="row">
        <div class="col-12">


            <div class="card shadow-lg border-0 rounded-4 border-start border-5 border-warning">
                
                {{-- HEADER CARD --}}
                <div class="card-header bg-primary text-white p-4 rounded-top-4">
                    <h4 class="mb-0 fw-bold fs-5"><i class="fas fa-edit me-2"></i> Edit Tagihan: {{ $tagihan->jenis_tagihan }}</h4>
                    <p class="text-white-50 small mb-0">Perbarui detail tagihan untuk santri {{ $tagihan->santri->nama_lengkap ?? 'N/A' }}.</p>
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
                    
                    {{-- Form Edit Tagihan --}}
                    <form action="{{ route('admin.tagihan.update', $tagihan) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="row g-4">
                            
                            {{-- Santri (ID) --}}
                            <div class="col-md-6">
                                <label for="santri_id" class="form-label fw-semibold">Pilih Santri <span class="text-danger">*</span></label>
                                <div class="input-group input-group-lg">
                                    <span class="input-group-text"><i class="fas fa-user-graduate"></i></span>
                                    <select name="santri_id" id="santri_id" 
                                            class="form-select @error('santri_id') is-invalid @enderror" required>
                                        <option value="">-- Pilih Santri --</option>
                                        {{-- $santris dilewatkan dari controller --}}
                                        @foreach ($santris as $santri)
                                            <option value="{{ $santri->id }}" 
                                                    {{ old('santri_id', $tagihan->santri_id) == $santri->id ? 'selected' : '' }}>
                                                {{ $santri->nama_lengkap }} (Kelas: {{ $santri->kelas->nama_kelas ?? 'N/A' }})
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('santri_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                            </div>
                            
                            {{-- Jenis Tagihan --}}
                            <div class="col-md-6">
                                <label for="jenis_tagihan" class="form-label fw-semibold">Jenis Tagihan <span class="text-danger">*</span></label>
                                <div class="input-group input-group-lg">
                                    <span class="input-group-text"><i class="fas fa-file-invoice"></i></span>
                                    <select name="jenis_tagihan" id="jenis_tagihan" 
                                            class="form-select @error('jenis_tagihan') is-invalid @enderror" required>
                                        <option value="">-- Pilih Jenis Tagihan --</option>
                                        {{-- $jenisTagihan dilewatkan dari controller --}}
                                        @foreach ($jenisTagihan as $jenis)
                                            <option value="{{ $jenis }}" 
                                                    {{ old('jenis_tagihan', $tagihan->jenis_tagihan) == $jenis ? 'selected' : '' }}>
                                                {{ $jenis }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('jenis_tagihan')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                            </div>

                            {{-- Jumlah Tagihan --}}
                            <div class="col-md-6">
                                <label for="jumlah_tagihan" class="form-label fw-semibold">Jumlah Tagihan (Rp) <span class="text-danger">*</span></label>
                                <div class="input-group input-group-lg">
                                    <span class="input-group-text">Rp</span>
                                    <input type="number" name="jumlah_tagihan" id="jumlah_tagihan" 
                                           class="form-control @error('jumlah_tagihan') is-invalid @enderror" 
                                           placeholder="Contoh: 550000" 
                                           value="{{ old('jumlah_tagihan', $tagihan->jumlah_tagihan) }}" 
                                           required min="0" step="1000">
                                    @error('jumlah_tagihan')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                            </div>
                            
                            {{-- Tanggal Jatuh Tempo --}}
                            <div class="col-md-6">
                                <label for="tanggal_jatuh_tempo" class="form-label fw-semibold">Tanggal Jatuh Tempo <span class="text-danger">*</span></label>
                                <div class="input-group input-group-lg">
                                    <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
                                    <input type="date" name="tanggal_jatuh_tempo" id="tanggal_jatuh_tempo" 
                                           class="form-control @error('tanggal_jatuh_tempo') is-invalid @enderror" 
                                           value="{{ old('tanggal_jatuh_tempo', \Carbon\Carbon::parse($tagihan->tanggal_jatuh_tempo)->format('Y-m-d')) }}" 
                                           required>
                                    @error('tanggal_jatuh_tempo')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                            </div>
                            
                            {{-- Tanggal Tagihan (Optional: Hidden atau Readonly) --}}
                            {{-- Asumsi tanggal tagihan tidak diubah, hanya jatuh tempo yang diubah --}}
                            <input type="hidden" name="tanggal_tagihan" value="{{ $tagihan->tanggal_tagihan }}">

                            {{-- Status Tagihan (Jika status bisa diubah manual) --}}
                            <div class="col-md-6">
                                <label for="status" class="form-label fw-semibold">Status Pembayaran <span class="text-danger">*</span></label>
                                <div class="input-group input-group-lg">
                                    <span class="input-group-text"><i class="fas fa-check-double"></i></span>
                                    <select name="status" id="status" 
                                            class="form-select @error('status') is-invalid @enderror" required>
                                        <option value="Belum Lunas" {{ old('status', $tagihan->status) == 'Belum Lunas' ? 'selected' : '' }}>Belum Lunas</option>
                                        <option value="Lunas" {{ old('status', $tagihan->status) == 'Lunas' ? 'selected' : '' }}>Lunas</option>
                                    </select>
                                    @error('status')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                            </div>

                            {{-- Keterangan --}}
                            <div class="col-md-12">
                                <label for="keterangan" class="form-label fw-semibold">Keterangan (Opsional)</label>
                                <div class="input-group input-group-lg">
                                    <span class="input-group-text"><i class="fas fa-info-circle"></i></span>
                                    <textarea name="keterangan" id="keterangan" 
                                              class="form-control @error('keterangan') is-invalid @enderror" 
                                              placeholder="Contoh: Pembayaran SPP bulan lalu yang belum dibayar" 
                                              rows="3">{{ old('keterangan', $tagihan->keterangan) }}</textarea>
                                    @error('keterangan')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                            </div>
                            
                        </div>
                        
                        <hr class="mt-5 mb-4 border-dark opacity-25">
                        
                        {{-- Tombol Aksi --}}
                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('admin.tagihan.index') }}" class="btn btn-outline-secondary px-4 shadow-sm fw-semibold rounded-pill">
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