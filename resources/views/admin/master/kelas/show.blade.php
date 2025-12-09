@extends('layouts.admin')

@section('title', 'Detail Kelas')
@section('page_title', 'Detail Kelas: ' . $kela->nama_kelas)

@section('content')

<div class="container-fluid">
    <div class="row">
        <div class="col-12">

            <div class="card shadow-lg border-0 rounded-4">
                
                {{-- HEADER CARD DENGAN WARNA PRIMER (Font diperkecil menjadi small text-white-75) --}}
                <div class="card-header bg-primary text-white p-4 rounded-top-4">
                    <h5 class="mb-0 fw-bold fs-6"><i class="fas fa-school me-2"></i> Informasi Data Kelas</h5>
                    <p class="text-white-50 small mb-0">Rincian lengkap mengenai kelas: {{ $kela->nama_kelas }}.</p>
                </div>
                
                <div class="card-body p-4">
                    
                    <div class="row g-4">
                        
                        {{-- KOLOM KIRI: NAMA KELAS --}}
                        <div class="col-lg-6">
                            {{-- Menggunakan h6 untuk sub-judul --}}
                            <h7 class="fw-bold text-dark mb-3 border-bottom pb-2 text-primary"><i class="fas fa-tag me-2"></i> Nama Kelas</h7>
                            
                            <div class="p-3 bg-light rounded-3 shadow-sm border-start border-5 border-primary">
                                <label class="form-label fw-semibold text-muted small mb-1">Nama Kelas Lengkap</label>
                                {{-- Mengubah fs-2 menjadi fs-4 agar tidak terlalu mendominasi --}}
                                <p class="mb-0 fs-4 text-dark fw-bolder">{{ $kela->nama_kelas }}</p>
                            </div>
                        </div>

                        {{-- KOLOM KANAN: TINGKAT --}}
                        <div class="col-lg-6">
                            {{-- Menggunakan h6 untuk sub-judul --}}
                            <h7 class="fw-bold text-dark mb-3 border-bottom pb-2 text-info"><i class="fas fa-layer-group me-2"></i> Tingkat Pendidikan</h7>

                            <div class="p-3 bg-light rounded-3 shadow-sm border-start border-5 border-info">
                                <label class="form-label fw-semibold text-muted small mb-1">Tingkat Kelas</label>
                                <p class="mb-0">
                                    {{-- Mengubah fs-6 agar lebih halus --}}
                                    <span class="badge bg-info p-2 fw-bold text-dark small">Tingkat {{ $kela->tingkat }}</span>
                                </p>
                            </div>
                        </div>
                        
                    </div>

                    {{-- Metadata Section --}}
                    <div class="row mt-5 pt-4">
                        <h6 class="fw-bold text-secondary mb-3"><i class="fas fa-history me-1"></i> Log Data</h6>
                        
                        {{-- Dibuat Pada --}}
                        <div class="col-md-6 mb-3">
                            <div class="p-3 border rounded bg-light shadow-sm">
                                <small class="text-muted d-block fw-semibold mb-1">Dibuat Pada</small>
                                <i class="far fa-calendar-alt me-1 text-primary small"></i>
                                <span class="text-dark fw-semibold small">{{ $kela->created_at->translatedFormat('d F Y') }}</span>
                                <span class="text-muted small">pukul {{ $kela->created_at->format('H:i') }}</span>
                            </div>
                        </div>
                        
                        {{-- Terakhir Diperbarui --}}
                        <div class="col-md-6 mb-3">
                            <div class="p-3 border rounded bg-light shadow-sm">
                                <small class="text-muted d-block fw-semibold mb-1">Terakhir Diperbarui</small>
                                <i class="far fa-clock me-1 text-warning small"></i>
                                <span class="text-dark fw-semibold small">{{ $kela->updated_at->translatedFormat('d F Y') }}</span>
                                <span class="text-muted small">pukul {{ $kela->updated_at->format('H:i') }}</span>
                            </div>
                        </div>
                    </div>
                    
                </div>

                {{-- CARD FOOTER: Action Buttons --}}
                <div class="card-footer bg-light border-0 rounded-bottom-4 p-4">
                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        
                        {{-- Tombol Edit --}}
                        <a href="{{ route('admin.kelas.edit', ['kela' => $kela]) }}" class="btn btn-warning shadow-sm fw-bold w-100 w-md-auto text-dark rounded-pill px-4 small">
                            <i class="fas fa-edit me-2"></i> Edit Data
                        </a>
                        
                        {{-- Tombol Hapus --}}
                        <form action="{{ route('admin.kelas.destroy', ['kela' => $kela]) }}" method="POST" class="d-inline w-100 w-md-auto">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger shadow-sm fw-bold w-100 rounded-pill px-4 small" onclick="return confirm('APAKAH ANDA YAKIN ingin menghapus kelas {{ $kela->nama_kelas }}? Tindakan ini tidak dapat dibatalkan.')">
                                <i class="fas fa-trash me-2"></i> Hapus Kelas
                            </button>
                        </form>

                        {{-- Tombol Kembali --}}
                        <a href="{{ route('admin.kelas.index') }}" class="btn btn-secondary shadow-sm fw-bold w-100 w-md-auto rounded-pill px-4 small">
                            <i class="fas fa-list me-2"></i> Daftar Kelas
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection