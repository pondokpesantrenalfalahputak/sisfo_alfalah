@extends('layouts.admin')

@section('title', 'Detail Rekening')
@section('page_title', 'Detail Rekening: ' . $rekening->nama_bank)

@section('header_actions')
    {{-- Tombol Edit --}}
    <a href="{{ route('admin.rekening.edit', $rekening) }}" class="btn btn-warning shadow-sm rounded-pill d-flex align-items-center fw-semibold me-2 px-3">
        <i class="fas fa-edit me-2"></i>
        Edit Rekening
    </a>
    {{-- Tombol Kembali --}}
    <a href="{{ route('admin.rekening.index') }}" class="btn btn-outline-secondary shadow-sm rounded-pill d-flex align-items-center fw-semibold px-3">
        <i class="fas fa-arrow-left me-2"></i>
        Kembali ke Daftar
    </a>
@endsection

@section('content')

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <h2 class="mb-4 text-dark fw-bold">🔎 Detail Rekening Pembayaran</h2>

            <div class="card shadow-lg border-0 rounded-4 border-start border-5 border-primary">
                
                {{-- HEADER CARD DENGAN WARNA PRIMER --}}
                <div class="card-header bg-primary text-white p-4 rounded-top-4">
                    <h4 class="mb-0 fw-bold fs-5"><i class="fas fa-university me-2"></i> Rincian Rekening Pembayaran</h4>
                    <p class="text-white-50 small mb-0">Detail lengkap rekening bank: {{ $rekening->nama_bank }}.</p>
                </div>
                
                <div class="card-body p-4">
                    
                    {{-- Tampilan Utama Rekening & Tombol Copy --}}
                    <div class="p-4 mb-5 border border-2 border-primary rounded-3 bg-primary-subtle shadow-sm">
                        <h6 class="fw-bold text-primary mb-1"><i class="fas fa-money-check-alt me-1"></i> NOMOR REKENING UTAMA</h6>
                        
                        <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between mt-2">
                            <p class="lead text-dark fw-bolder mb-2 mb-md-0 fs-2 me-3 text-break">{{ $rekening->nomor_rekening }}</p>
                            
                            {{-- Tombol Salin/Copy --}}
                            <button 
                                class="btn btn-lg btn-primary fw-bold text-uppercase px-4 rounded-pill shadow-sm w-100 w-md-auto" 
                                onclick="copyRekening('{{ $rekening->nomor_rekening }}', this)" 
                                title="Salin Nomor Rekening">
                                <i class="fas fa-copy me-1"></i> <span id="copyText">Salin Nomor</span>
                            </button>
                        </div>

                        <p class="small text-muted mt-3 mb-0 border-top pt-2">Atas Nama: <strong class="text-dark">{{ $rekening->atas_nama }}</strong></p>
                    </div>

                    <h6 class="fw-bold text-dark mb-4"><i class="fas fa-clipboard-list me-1"></i> Detail Rincian & Keterangan</h6>
                    <div class="row g-4">
                        
                        {{-- Nama Bank & Atas Nama --}}
                        <div class="col-md-6">
                            <div class="p-3 bg-light rounded-3 border-start border-4 border-success shadow-sm">
                                <label class="form-label fw-semibold text-muted small mb-0">Nama Bank</label>
                                <p class="mb-3 fs-5 text-success fw-bold">{{ $rekening->nama_bank }}</p>
                                
                                <label class="form-label fw-semibold text-muted small mb-0">Atas Nama Pemilik</label>
                                <p class="mb-0 fs-5 text-dark fw-bold">{{ $rekening->atas_nama }}</p>
                            </div>
                        </div>
                        
                        {{-- Keterangan --}}
                        <div class="col-md-6">
                            <div class="p-3 bg-light rounded-3 border-start border-4 border-info shadow-sm h-100">
                                <label class="form-label fw-semibold text-muted small mb-0">Keterangan Tambahan</label>
                                <p class="mb-0 text-wrap text-dark fst-italic lh-base">
                                    {{ $rekening->keterangan ?: 'Tidak ada keterangan tambahan yang dicantumkan.' }}
                                </p>
                            </div>
                        </div>
                    </div>

                    {{-- Metadata Section --}}
                    <div class="row mt-5 pt-4 border-top">
                        <h6 class="fw-bold text-secondary mb-3"><i class="fas fa-chart-line me-1"></i> Metadata & Log Data</h6>
                        
                        {{-- Dibuat Pada --}}
                        <div class="col-md-6 mb-3">
                            <div class="p-3 border rounded-3 bg-light shadow-sm">
                                <small class="text-muted d-block fw-semibold mb-1">Dibuat Pada</small>
                                <i class="far fa-calendar-alt me-2 text-primary"></i>
                                <span class="text-dark fw-semibold">{{ $rekening->created_at->translatedFormat('d F Y') }}</span>
                                <span class="text-muted small">pukul {{ $rekening->created_at->format('H:i') }}</span>
                            </div>
                        </div>
                        
                        {{-- Terakhir Diperbarui --}}
                        <div class="col-md-6 mb-3">
                             <div class="p-3 border rounded-3 bg-light shadow-sm">
                                <small class="text-muted d-block fw-semibold mb-1">Terakhir Diperbarui</small>
                                <i class="far fa-clock me-2 text-warning"></i>
                                <span class="text-dark fw-semibold">{{ $rekening->updated_at->translatedFormat('d F Y') }}</span>
                                <span class="text-muted small">pukul {{ $rekening->updated_at->format('H:i') }}</span>
                            </div>
                        </div>
                    </div>
                    
                </div>

                {{-- CARD FOOTER: Action Buttons --}}
                <div class="card-footer bg-light border-0 rounded-bottom-4 p-4">
                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        
                        {{-- Tombol Edit --}}
                        <a href="{{ route('admin.rekening.edit', $rekening) }}" class="btn btn-warning shadow-lg fw-bold w-100 w-md-auto text-dark rounded-pill px-4">
                            <i class="fas fa-edit me-2"></i> Edit Data
                        </a>
                        
                        {{-- Tombol Hapus --}}
                        <form action="{{ route('admin.rekening.destroy', $rekening) }}" method="POST" class="d-inline w-100 w-md-auto">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger shadow-lg fw-bold w-100 rounded-pill px-4" onclick="return confirm('APAKAH ANDA YAKIN ingin menghapus rekening {{ $rekening->nama_bank }} ini? Tindakan ini tidak dapat dibatalkan.')">
                                <i class="fas fa-trash me-2"></i> Hapus Permanen
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    /**
     * Fungsi untuk menyalin teks ke clipboard dan memberikan feedback visual.
     * @param {string} textToCopy 
     * @param {HTMLElement} buttonElement 
     */
    function copyRekening(textToCopy, buttonElement) {
        // Salin teks
        navigator.clipboard.writeText(textToCopy).then(() => {
            
            // Simpan teks dan ikon asli
            const originalHtml = buttonElement.innerHTML;
            const originalClass = 'btn-primary';

            // Update feedback visual
            buttonElement.innerHTML = '<i class="fas fa-check me-1"></i> TERSALIN!';
            buttonElement.classList.remove(originalClass);
            buttonElement.classList.add('btn-success');
            
            // Kembalikan ke keadaan semula setelah 2 detik
            setTimeout(() => {
                buttonElement.innerHTML = originalHtml;
                buttonElement.classList.remove('btn-success');
                buttonElement.classList.add(originalClass);
            }, 2000);
            
        }).catch(err => {
            console.error('Gagal menyalin: ', err);
            alert('Gagal menyalin nomor rekening. Pastikan browser Anda mendukung fitur ini.');
        });
    }
</script>
@endpush