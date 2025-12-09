@extends('layouts.admin')

@section('title', 'Detail Guru')
@section('page_title', 'Detail Data Guru')

@section('content')
            <div class="card shadow-sm border-0 rounded-4 overflow-hidden">
                
                {{-- CARD HEADER: Bersih dan Fokus --}}
                <div class="card-header bg-white border-bottom p-4">
                    <h5 class="mb-0 fw-bold text-dark"><i class="fas fa-id-card me-2 text-primary"></i> Detail Informasi Pendidik</h5>
                </div>
                
                {{-- CARD BODY --}}
                <div class="card-body p-4 p-md-5">
                    
                    <div class="row g-5"> 
                        
                        {{-- KOLOM KIRI: IDENTITAS DAN NAMA --}}
                        <div class="col-lg-6">
                            <h6 class="fw-bold mb-4 text-primary"><i class="fas fa-user-circle me-2"></i> Data Identitas</h6>
                            
                            {{-- NUPTK (Penting) --}}
                            <div class="d-flex justify-content-between py-2 border-bottom">
                                <span class="text-muted fw-semibold">NUPTK</span>
                                <span class="fw-bolder text-dark">{{ $guru->nuptk }}</span>
                            </div>

                            {{-- Nama Lengkap --}}
                            <div class="d-flex justify-content-between py-2 border-bottom">
                                <span class="text-muted fw-semibold">Nama Lengkap</span>
                                <span class="fw-bolder text-dark">{{ $guru->nama_lengkap }}</span>
                            </div>
                        </div>

                        {{-- KOLOM KANAN: JABATAN & KONTAK --}}
                        <div class="col-lg-6 border-start border-lg ps-lg-5 pt-4 pt-lg-0"> 
                            <h6 class="fw-bold mb-4 text-warning"><i class="fas fa-briefcase me-2"></i> Posisi dan Kontak</h6>

                            {{-- Jabatan --}}
                            <div class="d-flex justify-content-between py-2 border-bottom">
                                <span class="text-muted fw-semibold">Jabatan</span>
                                <span class="badge bg-warning text-dark p-2 fw-bold">{{ $guru->jabatan }}</span>
                            </div>

                            {{-- Nomor Kontak --}}
                            <div class="d-flex justify-content-between py-2 border-bottom">
                                <span class="text-muted fw-semibold">Nomor HP</span>
                                <span class="fw-bolder text-success">{{ $guru->no_hp }}</span>
                            </div>
                        </div>
                        
                    </div>
                    
                    {{-- Riwayat Data (Log) --}}
                    <div class="row mt-5 pt-4 border-top">
                        <h6 class="fw-bold text-secondary mb-3"><i class="fas fa-history me-1"></i> Riwayat Pencatatan</h6>
                        
                        {{-- Dibuat Pada --}}
                        <div class="col-md-6 mb-3">
                            <div class="p-3 border-start border-primary border-4 rounded bg-light">
                                <small class="text-muted fw-semibold d-block mb-1">Dibuat Pada</small>
                                <span class="text-dark fw-semibold small">{{ $guru->created_at->translatedFormat('d F Y, H:i') }}</span>
                                <small class="text-secondary d-block mt-1">({{ $guru->created_at->diffForHumans() }})</small>
                            </div>
                        </div>
                        
                        {{-- Terakhir Diperbarui --}}
                        <div class="col-md-6 mb-3">
                             <div class="p-3 border-start border-warning border-4 rounded bg-light">
                                <small class="text-muted fw-semibold d-block mb-1">Terakhir Diperbarui</small>
                                <span class="text-dark fw-semibold small">{{ $guru->updated_at->translatedFormat('d F Y, H:i') }}</span>
                                <small class="text-secondary d-block mt-1">({{ $guru->updated_at->diffForHumans() }})</small>
                            </div>
                        </div>
                    </div>
                    
                </div>

                {{-- CARD FOOTER: Action Buttons --}}
                <div class="card-footer bg-light border-0 rounded-bottom-4 p-4">
                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        
                        {{-- Edit --}}
                        <a href="{{ route('admin.guru.edit', $guru) }}" class="btn btn-warning shadow-sm fw-bold w-100 w-md-auto text-dark rounded-pill px-4 order-1">
                            <i class="fas fa-edit me-2"></i> Edit Data
                        </a>
                        
                        {{-- Kembali --}}
                        <a href="{{ route('admin.guru.index') }}" class="btn btn-outline-secondary shadow-sm fw-bold w-100 w-md-auto rounded-pill px-4 order-2">
                            <i class="fas fa-list me-2"></i> Daftar Guru
                        </a>

                        {{-- Hapus --}}
                        <form action="{{ route('admin.guru.destroy', $guru) }}" method="POST" class="d-inline w-100 w-md-auto order-3">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-outline-danger shadow-sm fw-bold w-100 rounded-pill px-4" onclick="return confirm('APAKAH ANDA YAKIN ingin menghapus data guru: {{ $guru->nama_lengkap }}? Tindakan ini tidak dapat dibatalkan.')">
                                <i class="fas fa-trash me-2"></i> Hapus
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection