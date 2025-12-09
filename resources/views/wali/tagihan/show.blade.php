@extends('layouts.wali')

@php
    use Illuminate\Support\Facades\Session;
    use Illuminate\Support\Facades\Storage;
    use Carbon\Carbon;

    // Set locale Carbon
    Carbon::setLocale('id');

    // Hitungan Tagihan
    $status_lunas = $tagihan->isLunas();
    $sisaTagihan = $tagihan->jumlah_tagihan - $tagihan->total_bayar_terkonfirmasi;
@endphp

@section('title', 'Detail Tagihan')
@section('page_title', 'Faktur Tagihan: ' . ($tagihan->keterangan ?? $tagihan->jenis_tagihan))

@push('css')
<style>
/* CSS khusus untuk tampilan Riwayat Pembayaran di Mobile */
@media (max-width: 767.98px) {
    /* Sembunyikan Header Tabel di Mobile */
    .riwayat-table thead {
        display: none;
    }

    /* Ubah Baris Tabel menjadi Blok Card di Mobile */
    .riwayat-table tbody, 
    .riwayat-table tr {
        display: block;
        width: 100%;
    }

    /* Styling setiap data cell */
    .riwayat-table td {
        display: block;
        text-align: right !important; /* Data rata kanan */
        padding: 8px 15px;
        position: relative;
        border: none;
    }

    /* Tambahkan Label untuk Setiap Data Cell (Pseudo-element) */
    .riwayat-table td::before {
        content: attr(data-label); /* Mengambil label dari atribut data-label di HTML */
        position: absolute;
        left: 15px;
        font-weight: 600;
        text-align: left;
        color: #6c757d; /* Warna abu-abu muted */
    }
    
    /* Beri sedikit jarak antar entri (baris) */
    .riwayat-table tr {
        margin-bottom: 15px;
        border: 1px solid #dee2e6;
        border-radius: 8px;
        box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
    }
    
    /* Hapus border atas untuk entri pertama di baris */
    .riwayat-table tr:first-child {
        border-top: none;
    }
}
</style>
@endpush

@section('content')

    {{-- Pesan Status --}}
    @if(session('success'))
        @php
            $displayMessage = is_array(Session::get('success')) ? Session::get('success')[0] : Session::get('success');
        @endphp
        <div class="alert alert-success alert-dismissible fade show shadow-sm border-0 rounded-3" role="alert">
            <i class="fas fa-check-circle me-2"></i> <strong>Berhasil!</strong> {{ $displayMessage }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show shadow-sm border-0 rounded-3" role="alert">
            <i class="fas fa-exclamation-triangle me-2"></i> <strong>Kesalahan!</strong> {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row">
        
        {{-- BLOK KIRI: DETAIL INVOICE & RANGKUMAN --}}
        <div class="col-lg-7 mb-4">
            <div class="card shadow-lg h-100 border-0 rounded-4 border-top border-5 border-primary">
                <div class="card-header bg-primary text-white fw-bold d-flex align-items-center p-3 rounded-top-4">
                    <i class="fas fa-file-invoice me-2 fa-lg"></i> Faktur Tagihan #{{ $tagihan->id }}
                </div>
                <div class="card-body p-4">
                    
                    {{-- Status Tagihan --}}
                    <div class="text-end mb-4">
                        @if ($status_lunas)
                            <span class="badge bg-success py-2 px-3 fw-bolder rounded-pill fs-6"><i class="fas fa-check-circle me-1"></i> LUNAS</span>
                        @else
                            <span class="badge bg-danger py-2 px-3 fw-bolder rounded-pill fs-6"><i class="fas fa-exclamation-triangle me-1"></i> BELUM LUNAS</span>
                        @endif
                    </div>
                    
                    {{-- Detail Tagihan --}}
                    <h5 class="fw-bold text-dark mb-3 pb-2 border-bottom"><i class="fas fa-info-circle me-2 text-primary"></i> Rincian Tagihan</h5>
                    
                    <dl class="row mb-4 small">
                        <dt class="col-5 text-muted">Untuk Santri:</dt>
                        <dd class="col-7 text-end fw-bolder">{{ $tagihan->santri->nama ?? 'N/A' }}</dd>
                        
                        <dt class="col-5 text-muted">Kelas:</dt>
                        <dd class="col-7 text-end fw-semibold">{{ $tagihan->santri->kelas->nama_kelas ?? 'N/A' }}</dd>
                        
                        <dt class="col-5 text-muted">Deskripsi Tagihan:</dt>
                        <dd class="col-7 text-end text-wrap">{{ $tagihan->keterangan ?? $tagihan->jenis_tagihan }}</dd>

                        <dt class="col-5 text-muted">Jatuh Tempo:</dt>
                        <dd class="col-7 text-end text-danger fw-bolder">{{ $tagihan->tanggal_jatuh_tempo->translatedFormat('d F Y') }}</dd>
                    </dl>
                    
                    <hr>

                    {{-- RANGKUMAN KEUANGAN --}}
                    <h5 class="fw-bold text-dark mt-4 mb-3 pb-2 border-bottom"><i class="fas fa-calculator me-2 text-primary"></i> Ringkasan Pembayaran</h5>
                    
                    <ul class="list-group list-group-flush mb-4">
                        <li class="list-group-item d-flex justify-content-between px-0 py-2 bg-light rounded-top">
                            <span class="fw-semibold">Total Tagihan:</span>
                            <span class="fw-bolder text-dark">Rp {{ number_format($tagihan->jumlah_tagihan, 0, ',', '.') }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between px-0 py-2 border-bottom">
                            <span class="fw-semibold text-success">Terkonfirmasi:</span>
                            <span class="fw-bolder text-success">Rp {{ number_format($tagihan->total_bayar_terkonfirmasi, 0, ',', '.') }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between px-0 py-3 bg-light-subtle rounded-bottom">
                            <span class="fw-bold fs-6 text-uppercase {{ $sisaTagihan > 0 ? 'text-danger' : 'text-success' }}">Sisa Tagihan</span>
                            <span class="fw-bolder fs-7 {{ $sisaTagihan > 0 ? 'text-danger' : 'text-success' }}">
                                Rp {{ number_format($sisaTagihan, 0, ',', '.') }}
                            </span>
                        </li>
                    </ul>

                </div>
            </div>
        </div>

        {{-- BLOK KANAN: INSTRUKSI & FORM KONFIRMASI --}}
        <div class="col-lg-5 mb-4">
            
            @if ($status_lunas)
                {{-- LUNAS CARD --}}
                <div class="card shadow-lg h-100 border-0 rounded-4">
                    <div class="card-body text-center py-5 bg-success text-white rounded-4">
                        <i class="fas fa-check-circle fa-4x mb-3"></i>
                        <h4 class="fw-bolder">TAGIHAN INI SUDAH LUNAS</h4>
                        <p class="mb-0 fs-6">Terima kasih. Pembayaran telah selesai.</p>
                        <hr class="text-white-50 my-4">
                        {{-- btn-md --}}
                        <a href="{{ route('wali.tagihan.index') }}" class="btn btn-light btn-md rounded-pill">
                             <i class="fas fa-arrow-left me-1"></i> Kembali
                        </a>
                    </div>
                </div>
            @else
                {{-- INSTRUKSI TRANSFER (DENGAN TOMBOL SALIN) --}}
                <div class="card shadow-lg mb-4 border-0 rounded-4 border-top border-5 border-info">
                    <div class="card-header bg-info text-white fw-bolder d-flex align-items-center p-3 rounded-top-4">
                        <i class="fas fa-university me-2 fa-lg"></i> Instruksi Transfer
                    </div>
                    <div class="card-body p-4">
                        <p class="mb-3 fw-bold">Transfer sebesar <span class="text-danger fw-bolder">Rp {{ number_format($sisaTagihan, 0, ',', '.') }}</span> ke salah satu rekening:</p>
                        
                        <ul class="list-group list-group-flush mb-3 border rounded bg-light p-3">
                            {{-- ASUMSI: Iterasi Rekening Tujuan --}}
                            @forelse ($rekenings as $rekening)
                                <li class="list-group-item px-0 d-flex flex-column align-items-start border-start-0 border-end-0 py-3">
                                    <span class="fw-bold text-dark mb-1">{{ $rekening->nama_bank }}</span>
                                    <div class="d-flex align-items-center justify-content-between w-100">
                                        {{-- Nomor Rekening --}}
                                        <span class="fw-bolder text-primary fs-5 rekening-number" id="rek-{{ $rekening->id }}">
                                            {{ $rekening->nomor_rekening }}
                                        </span>
                                        {{-- Tombol Salin --}}
                                        <button type="button" class="btn btn-sm btn-outline-primary copy-btn flex-shrink-0"
                                                data-rek-number="{{ $rekening->nomor_rekening }}"
                                                onclick="copyToClipboard('{{ $rekening->nomor_rekening }}', this)">
                                            <i class="fas fa-copy me-1"></i> Salin
                                        </button>
                                    </div>
                                    <small class="text-muted mt-1">A.N. {{ $rekening->atas_nama }}</small>
                                </li>
                            @empty
                                <li class="list-group-item text-center text-muted">Data rekening tujuan tidak tersedia.</li>
                            @endforelse
                        </ul>
                        <p class="small text-muted mb-0"><i class="fas fa-info-circle me-1"></i> Klik tombol Salin untuk menghindari kesalahan pengetikan.</p>
                    </div>
                </div>
                
                {{-- FORM KONFIRMASI PEMBAYARAN --}}
                <div class="card shadow-lg border-0 border-top border-5 border-danger rounded-4">
                    <div class="card-header bg-danger text-white fw-bolder d-flex align-items-center p-3 rounded-top-4">
                        <i class="fas fa-paperclip me-2 fa-lg"></i> Konfirmasi Pembayaran
                    </div>
                    <div class="card-body p-4">
                        <form action="{{ route('wali.tagihan.bayar', $tagihan) }}" method="POST" enctype="multipart/form-data" id="form-bayar"> 
                            @csrf
                            
                            {{-- JUMLAH BAYAR --}}
                            <div class="mb-3">
                                <label for="jumlah_bayar" class="form-label fw-semibold">Nominal Dibayarkan</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light fw-bold">Rp</span>
                                    <input type="number" name="jumlah_bayar" id="jumlah_bayar" class="form-control @error('jumlah_bayar') is-invalid @enderror" 
                                        value="{{ old('jumlah_bayar', $sisaTagihan) }}" required min="1" max="{{ $sisaTagihan }}" placeholder="Masukkan jumlah...">
                                </div>
                                <div class="form-text text-danger fw-semibold mt-2">Wajib: Rp {{ number_format($sisaTagihan, 0, ',', '.') }}</div>
                                @error('jumlah_bayar') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            {{-- REKENING TUJUAN --}}
                            <div class="mb-3">
                                <label for="rekening_id" class="form-label fw-semibold">Pilih Rekening Tujuan Transfer</label>
                                <select name="rekening_id" id="rekening_id" class="form-select @error('rekening_id') is-invalid @enderror" required>
                                    <option value="">-- Pilih Rekening --</option>
                                    @foreach ($rekenings as $rekening)
                                        <option value="{{ $rekening->id }}" {{ old('rekening_id') == $rekening->id ? 'selected' : '' }}>
                                            [{{ $rekening->nama_bank }}] A/N: {{ $rekening->atas_nama }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('rekening_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            {{-- BUKTI PEMBAYARAN --}}
                            <div class="mb-4">
                                <label for="bukti_pembayaran" class="form-label fw-semibold">Upload Bukti Pembayaran (JPG/PNG)</label>
                                <input type="file" name="bukti_pembayaran" id="bukti_pembayaran" class="form-control @error('bukti_pembayaran') is-invalid @enderror" required accept="image/jpeg, image/png">
                                <div class="form-text">Maksimal 2MB.</div>
                                @error('bukti_pembayaran') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <button type="submit" id="btn-konfirmasi" class="btn btn-danger w-100 mt-2 btn-lg shadow rounded-pill">
                                <i class="fas fa-paper-plane me-2"></i> Konfirmasi Pembayaran
                            </button>
                        </form>
                    </div>
                </div>
            @endif
        </div>
    </div>
    
    <hr class="my-4">

    {{-- Riwayat Pembayaran (Mobile Card View Optimized) --}}
    <div class="row mt-4 mb-5">
        <div class="col-lg-12">
            <div class="card shadow-lg border-0 rounded-4">
                <div class="card-header bg-info text-white fw-bold d-flex align-items-center p-3 rounded-top-4">
                    <i class="fas fa-receipt me-2 fa-lg"></i> Riwayat Pembayaran Anda
                </div>
                <div class="card-body p-4">
                    @if ($pembayarans->isEmpty())
                         <div class="text-center py-4 text-muted bg-light rounded border-0">
                            <i class="fas fa-box-open me-2 fs-4"></i>
                            <p class="mb-0 mt-2">Belum ada riwayat pembayaran untuk tagihan ini.</p>
                        </div>
                    @else
                        {{-- Tabel Responsif untuk Riwayat dengan class riwayat-table --}}
                        <div class="table-responsive">
                            <table class="table table-striped table-hover mb-0 align-middle small riwayat-table">
                                <thead class="table-light">
                                    <tr>
                                        <th>No</th>
                                        <th>Tanggal Bayar</th>
                                        <th class="text-end">Jumlah</th>
                                        <th class="text-center">Status</th>
                                        <th class="text-center">Bukti</th> 
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($pembayarans as $index => $pembayaran)
                                        @php
                                            $statusBadge = [
                                                'Menunggu' => 'bg-warning text-dark',
                                                'Dikonfirmasi' => 'bg-success-subtle text-success-emphasis',
                                                'Ditolak' => 'bg-danger-subtle text-danger-emphasis',
                                            ][$pembayaran->status_konfirmasi] ?? 'bg-secondary';
                                        @endphp
                                        <tr>
                                            {{-- Penambahan data-label untuk mobile view --}}
                                            <td class="text-muted" data-label="No. Transaksi">#{{ $index + 1 }}</td> 
                                            <td class="text-nowrap small text-muted" data-label="Tanggal Bayar">{{ $pembayaran->created_at->translatedFormat('d M Y H:i') }}</td>
                                            <td class="text-end fw-bolder text-dark" data-label="Jumlah Bayar">Rp {{ number_format($pembayaran->jumlah_bayar, 0, ',', '.') }}</td>
                                            <td class="text-center" data-label="Status Konfirmasi">
                                                <span class="badge {{ $statusBadge }} py-1 px-2 fw-bold">{{ $pembayaran->status_konfirmasi }}</span>
                                            </td>
                                            {{-- Penyesuaian: Mengganti teks "Lihat Bukti" menjadi ikon untuk efisiensi ruang di mobile --}}
                                            <td class="text-center" data-label="Bukti Transfer">
                                                @if ($pembayaran->bukti_pembayaran)
                                                <a href="{{ Storage::url($pembayaran->bukti_pembayaran) }}" target="_blank" class="btn btn-sm btn-outline-info rounded-pill px-2" title="Lihat Bukti Pembayaran">
                                                    <i class="fas fa-eye"></i> 
                                                </a>
                                                @else
                                                <span class="text-muted small">N/A</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    
    {{-- Tombol Navigasi Akhir --}}
    <div class="row mt-4 mb-5">
        <div class="col-12 text-center">
            {{-- btn-md --}}
            <a href="{{ route('wali.tagihan.index') }}" class="btn btn-secondary btn-md rounded-pill px-4">
                <i class="fas fa-arrow-left me-1"></i> Kembali ke Daftar Tagihan
            </a>
        </div>
    </div>
@endsection

@push('js')
    <script>
        // Fungsi Salin (Copy-to-Clipboard) - Diletakkan di scope global
        function copyToClipboard(text, button) {
            // Hilangkan spasi jika ada, untuk memastikan nomor rekening yang disalin benar
            const textToCopy = text.trim().replace(/\s/g, ''); 
            
            if (navigator.clipboard) {
                // Metode modern (Async Clipboard API)
                navigator.clipboard.writeText(textToCopy).then(function() {
                    const originalIcon = button.querySelector('i').className;
                    const originalText = button.innerHTML;

                    // Feedback visual
                    button.innerHTML = '<i class="fas fa-check me-1"></i> Tersalin!';
                    button.classList.remove('btn-outline-primary');
                    button.classList.add('btn-success');

                    // Kembalikan ke kondisi awal setelah 2 detik
                    setTimeout(() => {
                        button.innerHTML = originalText; // Mengembalikan innerHTML penuh untuk menjaga struktur
                        button.querySelector('i').className = originalIcon; // Mengembalikan ikon
                        button.classList.remove('btn-success');
                        button.classList.add('btn-outline-primary');
                        button.innerHTML = '<i class="fas fa-copy me-1"></i> Salin'; // Memastikan teks kembali benar
                    }, 2000);

                }).catch(function(err) {
                    console.error('Gagal menyalin teks: ', err);
                    alert('Gagal menyalin. Silakan salin manual: ' + text);
                });
            } else {
                // Fallback untuk browser lama (Sync Command)
                const textarea = document.createElement('textarea');
                textarea.value = textToCopy;
                textarea.style.position = 'fixed'; 
                textarea.style.top = 0; 
                textarea.style.left = 0; 
                document.body.appendChild(textarea);
                textarea.focus();
                textarea.select();
                try {
                    document.execCommand('copy');
                    // Tidak perlu alert karena sudah ada feedback di tombol, tapi di fallback ini kita pakai alert
                } catch (err) {
                    alert('Gagal menyalin. Silakan salin manual: ' + text);
                }
                document.body.removeChild(textarea);
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            const formBayar = document.getElementById('form-bayar');
            const btnKonfirmasi = document.getElementById('btn-konfirmasi');

            if (btnKonfirmasi && formBayar) {
                // Fungsi untuk menonaktifkan tombol dan menampilkan loading
                function disableButton() {
                    btnKonfirmasi.disabled = true;
                    btnKonfirmasi.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Memproses...';
                }

                // Listener saat form disubmit
                formBayar.addEventListener('submit', function(e) {
                    // Hanya matikan tombol jika validasi form berhasil
                    // (Browser akan menjalankan validasi native HTML5 sebelum ini)
                    if (formBayar.checkValidity()) {
                        disableButton();
                    }
                });
            }
        });
    </script>
@endpush