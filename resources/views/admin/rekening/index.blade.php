@extends('layouts.admin')

@section('title', 'Kelola Rekening')
@section('page_title', 'Daftar Rekening Pembayaran')

@section('header_actions')
    {{-- Tambahkan d-none d-md-flex untuk menyembunyikan di mobile --}}
    <a href="{{ route('admin.rekening.create') }}" class="btn btn-success shadow-sm d-none d-md-flex align-items-center fw-semibold">
        <i class="fas fa-plus me-2"></i> Tambah Rekening Baru
    </a>
@endsection

@section('content')

{{-- Notifikasi Sukses/Gagal --}}
@if (session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

{{-- 2. Tombol Aksi untuk MOBILE (Tampil di atas Card) --}}
{{-- Gunakan d-block d-md-none: Selalu tampil kecuali di breakpoint md (desktop) ke atas --}}
<div class="d-block d-md-none mb-3 px-3">
    <a href="{{ route('admin.rekening.create') }}" class="btn btn-success shadow-sm d-flex align-items-center fw-semibold w-100">
        <i class="fas fa-plus me-2"></i> Tambah Rekening Baru
    </a>
</div>
<hr class="d-block d-md-none border-secondary-subtle">
<div class="card shadow border-left-success">
    {{-- CARD HEADER --}}
    <div class="card-header bg-primary text-white p-4">
        <h5 class="mb-0 fw-bold"><i class="fas fa-university me-2"></i> Daftar Rekening Pembayaran</h5>
        <p class="text-white-50 small mb-0">Kelola daftar rekening yang digunakan untuk penerimaan pembayaran santri.</p>
    </div>
    
    <div class="card-body p-0">
        
        {{-- ========================================================= --}}
        {{-- 1. Tampilan Desktop (Tabel) --}}
        {{-- ========================================================= --}}
        <div class="table-responsive d-none d-md-block">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-dark"> {{-- Menggunakan warna gelap untuk header tabel --}}
                    <tr>
                        <th style="width: 5%;" class="text-center">#</th>
                        <th style="width: 20%;">Nama Bank</th>
                        <th style="width: 25%;">Nomor Rekening</th>
                        <th style="width: 20%;">Atas Nama</th>
                        <th style="width: 20%;">Keterangan</th>
                        <th style="width: 10%;" class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($rekenings as $rekening)
                    <tr>
                        <td class="text-center">{{ $loop->iteration }}</td>
                        <td>
                            <strong class="text-primary">{{ $rekening->nama_bank }}</strong>
                        </td>
                        <td>
                            <span class="fw-bold fs-6 text-dark bg-light p-1 rounded d-inline-block">{{ $rekening->nomor_rekening }}</span>
                        </td>
                        <td>
                            <span class="fw-semibold text-dark">{{ $rekening->atas_nama }}</span>
                        </td>
                        <td>
                            <small class="text-muted">{{ Str::limit($rekening->keterangan ?: 'Tidak ada keterangan', 40) }}</small>
                        </td>
                        <td class="text-center">
                            {{-- Tombol Aksi - Gunakan btn-group untuk kerapian --}}
                            <div class="btn-group" role="group">
                                <a href="{{ route('admin.rekening.edit', $rekening) }}" class="btn btn-sm btn-warning" title="Edit Data">
                                    <i class="fas fa-edit"></i>
                                </a>
                                
                                <form action="{{ route('admin.rekening.destroy', $rekening) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" title="Hapus Rekening" onclick="return confirm('APAKAH YAKIN? Menghapus rekening {{ $rekening->nama_bank }} akan memengaruhi pembayaran.')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-5 text-muted bg-light">
                            <i class="fas fa-money-check-alt fa-3x mb-3 text-secondary"></i>
                            <h5 class="mb-0">Belum ada data rekening yang terdaftar.</h5>
                            <p class="mb-0 mt-2">Silakan tambahkan rekening pembayaran untuk menerima tagihan.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- ========================================================= --}}
        {{-- 2. Tampilan Mobile (Card List) --}}
        {{-- ========================================================= --}}
        <div class="d-md-none p-3">
            @forelse ($rekenings as $rekening)
                <div class="card mb-3 shadow border-start border-2 border-success">
                    <div class="card-body">
                        
                        {{-- Baris 1: Bank dan Atas Nama --}}
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <div>
                                <h6 class="text-muted mb-0 small"><i class="fas fa-university me-1"></i> REKENING {{ $loop->iteration }}</h6>
                                <h4 class="card-title fw-bold text-primary mb-0">{{ $rekening->nama_bank }}</h4>
                            </div>
                            <span class="badge bg-secondary p-2">{{ $rekening->atas_nama }}</span>
                        </div>
                        <hr class="my-2">
                        
                        {{-- Nomor Rekening --}}
                        <div class="mb-3 p-2 bg-light rounded">
                            <h6 class="text-muted small mb-1">NOMOR REKENING</h6>
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="fw-bolder fs-5 text-dark">{{ $rekening->nomor_rekening }}</span>
                                {{-- Tombol Copy (Opsional, tapi bagus untuk UX) --}}
                                <button class="btn btn-sm btn-outline-success" onclick="copyToClipboard('{{ $rekening->nomor_rekening }}', this)" title="Salin Nomor Rekening">
                                    <i class="fas fa-copy"></i> Salin
                                </button>
                            </div>
                        </div>
                        
                        {{-- Keterangan --}}
                        <div class="mb-3">
                            <h6 class="text-muted small mb-1">Keterangan</h6>
                            <p class="small mb-0 fst-italic">{{ $rekening->keterangan ?: 'Tidak ada keterangan spesifik.' }}</p>
                        </div>
                        
                        <hr class="my-2">

                        {{-- Aksi --}}
                        <div class="d-flex justify-content-end pt-2 gap-2">
                            <a href="{{ route('admin.rekening.edit', $rekening) }}" class="btn btn-sm btn-warning" title="Edit Data">
                                <i class="fas fa-edit"></i> Edit
                            </a>
                            
                            <form action="{{ route('admin.rekening.destroy', $rekening) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" title="Hapus Rekening" onclick="return confirm('APAKAH YAKIN? Menghapus rekening {{ $rekening->nama_bank }} akan memengaruhi pembayaran.')">
                                    <i class="fas fa-trash"></i> Hapus
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @empty
                <div class="text-center py-5 text-muted bg-light rounded">
                    <i class="fas fa-money-check-alt fa-3x mb-3 text-secondary"></i>
                    <h5 class="mb-0">Belum ada data rekening yang terdaftar.</h5>
                    <p class="mb-0 mt-2">Silakan klik tombol Tambah Rekening Baru di atas untuk menambahkan rekening bank.</p>
                </div>
            @endforelse
        </div>
        
    </div>
    
    {{-- Paginasi --}}
    @if ($rekenings instanceof \Illuminate\Pagination\LengthAwarePaginator)
        <div class="card-footer bg-light border-0">
            <div class="d-flex justify-content-center justify-content-md-end">
                {{ $rekenings->links() }}
            </div>
        </div>
    @endif
</div>
@endsection

@push('scripts')
<script>
    function copyToClipboard(textToCopy, buttonElement) {
        navigator.clipboard.writeText(textToCopy).then(function() {
            // Perubahan visual sementara
            let originalHtml = buttonElement.innerHTML;
            buttonElement.innerHTML = '<i class="fas fa-check"></i> Disalin!';
            buttonElement.classList.remove('btn-outline-success');
            buttonElement.classList.add('btn-success');
            
            setTimeout(() => {
                buttonElement.innerHTML = originalHtml;
                buttonElement.classList.remove('btn-success');
                buttonElement.classList.add('btn-outline-success');
            }, 1000);

        }, function(err) {
            console.error('Could not copy text: ', err);
            alert('Gagal menyalin nomor rekening.');
        });
    }
</script>
@endpush