@extends('layouts.wali')

@section('title', 'Detail Santri')
@section('page_title', 'Detail Santri')

@section('content')

    {{-- Menggunakan card-flat dengan border-top accent --}}
    <div class="card border-0 mb-4 rounded-4 card-flat border-top border-5 border-primary">
        
        {{-- CARD HEADER (Clean) --}}
        <div class="card-header bg-light border-bottom fw-bold p-3 d-flex align-items-center rounded-top-4">
            <i class="fas fa-id-card me-2 fs-5 text-primary"></i><span class="ms-1 text-dark">{{ strtoupper($santri->nama) }}</span>
        </div>
        
        <div class="card-body p-4 p-lg-5">
            
            <div class="row g-4">
                
                {{-- KOTAK INFORMASI UTAMA SANTRI --}}
                <div class="col-md-6">
                    {{-- Menggunakan border-top success --}}
                    <div class="card h-100 border-0 shadow-sm rounded-4 card-flat border-top border-4 border-success card-detail-info">
                        <div class="card-body p-4">
                            <h5 class="fw-bold text-success mb-4 pb-2 border-bottom border-success-subtle">
                                <i class="fas fa-user-graduate me-2"></i> Data Pribadi Santri
                            </h5>
                            
                            {{-- Menggunakan List Group item yang lebih visual --}}
                            <div class="list-group list-group-flush small">
                                
                                {{-- Nama Lengkap --}}
                                <div class="list-group-item d-flex justify-content-between px-0 py-3 item-detail">
                                    <span class="text-muted fw-semibold"><i class="fas fa-signature me-2 text-success-emphasis"></i> Nama Lengkap</span>
                                    <span class="fw-bold text-dark text-end">{{ $santri->nama }}</span>
                                </div>
                                
                                {{-- NIS / NISN --}}
                                <div class="list-group-item d-flex justify-content-between px-0 py-3 item-detail">
                                    <span class="text-muted fw-semibold"><i class="fas fa-id-badge me-2 text-success-emphasis"></i> NIS </span>
                                    <span class="text-end text-secondary">{{ $santri->nis ?? '-' }} / {{ $santri->nisn ?? '-' }}</span>
                                </div>
                                
                                {{-- Jenis Kelamin --}}
                                <div class="list-group-item d-flex justify-content-between px-0 py-3 item-detail">
                                    <span class="text-muted fw-semibold"><i class="fas fa-venus-mars me-2 text-success-emphasis"></i> Jenis Kelamin</span>
                                    <span class="text-end fw-semibold">{{ $santri->jenis_kelamin ?? '-' }}</span>
                                </div>
                                
                                {{-- Tempat/Tgl Lahir --}}
                                <div class="list-group-item d-flex justify-content-between px-0 py-3 item-detail">
                                    <span class="text-muted fw-semibold"><i class="fas fa-birthday-cake me-2 text-success-emphasis"></i> Tempat/Tgl Lahir</span>
                                    <span class="text-end text-secondary">
                                        {{ $santri->tempat_lahir ?? '-' }}, {{ $santri->tanggal_lahir ? $santri->tanggal_lahir->translatedFormat('d F Y') : '-' }}
                                    </span>
                                </div>
                                
                                {{-- Alamat --}}
                                <div class="list-group-item d-flex justify-content-between px-0 py-3 item-detail">
                                    <span class="text-muted fw-semibold"><i class="fas fa-map-marker-alt me-2 text-success-emphasis"></i> Alamat</span>
                                    {{-- Menggunakan text-wrap untuk alamat panjang --}}
                                    <span class="text-wrap text-end text-secondary" style="max-width: 60%;">{{ $santri->alamat ?? '-' }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- KOTAK INFORMASI AKADEMIK & WALI --}}
                <div class="col-md-6">
                    {{-- Menggunakan border-top info --}}
                    <div class="card h-100 border-0 shadow-sm rounded-4 card-flat border-top border-4 border-info card-detail-info">
                        <div class="card-body p-4">
                            <h5 class="fw-bold text-info mb-4 pb-2 border-bottom border-info-subtle">
                                <i class="fas fa-bookmark me-2"></i> Akademik & Perwalian
                            </h5>
                            
                            {{-- Menggunakan List Group item yang lebih visual --}}
                            <div class="list-group list-group-flush small">
                                
                                {{-- Kelas Aktif --}}
                                <div class="list-group-item d-flex justify-content-between px-0 py-3 item-detail">
                                    <span class="text-muted fw-semibold"><i class="fas fa-school me-2 text-info-emphasis"></i> Kelas Aktif</span>
                                    <span class="badge bg-info text-dark fw-bold p-2 rounded-pill">
                                        {{ $santri->kelas->nama_kelas ?? 'Belum Ada Kelas' }}
                                    </span>
                                </div>
                                
                                {{-- Nomor Telepon --}}
                                <div class="list-group-item d-flex justify-content-between px-0 py-3 item-detail">
                                    <span class="text-muted fw-semibold"><i class="fas fa-phone me-2 text-info-emphasis"></i> Nomor Telepon</span>
                                    <span class="text-end text-secondary">{{ $santri->no_hp ?? '-' }}</span>
                                </div>
                                
                                {{-- Wali Santri --}}
                                <div class="list-group-item d-flex justify-content-between px-0 py-3 item-detail">
                                    <span class="text-muted fw-semibold"><i class="fas fa-user-tie me-2 text-info-emphasis"></i> Wali Santri</span>
                                    <span class="fw-bold text-dark text-end">
                                        {{ $santri->user->name ?? 'Tidak Terdaftar' }}
                                    </span>
                                </div>
                                
                                {{-- Status --}}
                                <div class="list-group-item d-flex justify-content-between px-0 py-3 item-detail">
                                    <span class="text-muted fw-semibold"><i class="fas fa-check-circle me-2 text-info-emphasis"></i> Status</span>
                                    <span class="badge bg-success fw-bold py-2 rounded-pill">Aktif</span>
                                </div>
                                
                                {{-- ID Wali --}}
                                <div class="list-group-item d-flex justify-content-between px-0 py-3 item-detail">
                                    <span class="text-muted fw-semibold"><i class="fas fa-hashtag me-2 text-info-emphasis"></i> ID Wali</span>
                                    <span class="text-end text-secondary">{{ $santri->wali_santri_id ?? '-' }}</span>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>

            ---

            {{-- Bagian Tautan Aksi Cepat (UKURAN TOMBOL DIESUAIKAN) --}}
            <div class="row mt-5 pt-4">
                <div class="col-12">
                    <h5 class="fw-bold text-dark mb-3"><i class="fas fa-bolt me-1 text-warning"></i> Akses Cepat Informasi</h5>
                    
                    {{-- d-grid gap-3 untuk mobile, d-md-flex untuk desktop. btn-lg hanya aktif di mobile (w-100 d-md-block memastikan lebar penuh di mobile) --}}
                    <div class="d-grid gap-3 d-md-flex flex-wrap">
                        
                        {{-- Tombol 1: Absensi --}}
                        <a href="{{ route('wali.absensi.index') }}?santri_id={{ $santri->id }}" 
                           class="btn btn-danger btn-md w-100 d-md-block btn-lg rounded-3 px-4 btn-hover-scale">
                            <i class="fas fa-calendar-times me-1"></i> Lihat Rekap Absensi
                        </a>
                        
                        {{-- Tombol 2: Tagihan --}}
                        <a href="{{ route('wali.tagihan.index') }}" 
                           class="btn btn-warning text-dark btn-md w-100 d-md-block btn-lg rounded-3 px-4 btn-hover-scale">
                            <i class="fas fa-receipt me-1"></i> Cek Tagihan
                        </a>
                        
                        {{-- Tombol 3: Nilai (Disabled) --}}
                        <a href="#" 
                           class="btn btn-outline-success btn-md w-100 d-md-block btn-lg rounded-3 px-4 btn-hover-scale disabled" title="Fitur Segera Hadir">
                            <i class="fas fa-calculator me-1"></i> Cek Nilai Akademik
                        </a>
                    </div>
                </div>
            </div>
            
        </div>

        {{-- CARD FOOTER: Tombol Kembali dibuat menonjol --}}
        <div class="card-footer bg-light p-3 rounded-bottom-4 text-end">
            <a href="{{ route('wali.santri.index') }}" class="btn btn-secondary btn-md rounded-3 px-4">
                <i class="fas fa-arrow-left me-1"></i> Kembali ke Daftar Santri
            </a>
        </div>
    </div>
@endsection

@push('css')
    <style>
        /* Gaya Card Flat Minimalis */
        .card-flat {
            box-shadow: 0 0 0 1px rgba(0, 0, 0, 0.05), 0 2px 5px rgba(0, 0, 0, 0.03); 
            transition: all 0.3s ease-in-out;
        }

        /* Styling untuk item list group */
        .card-detail-info .list-group-item {
            border-bottom: 1px solid #eee;
        }
        .card-detail-info .list-group-item:last-child {
            border-bottom: none;
        }

        /* Efek Scale pada Tombol Aksi Cepat */
        .btn-hover-scale {
            transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
        }
        .btn-hover-scale:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        /* Media Query untuk Mobile (Menerapkan btn-lg hanya pada layar kecil) */
        @media (max-width: 767.98px) {
            .btn-lg {
                /* Mengaktifkan btn-lg dari Bootstrap untuk mobile */
                font-size: 1.25rem; 
                padding: 0.5rem 1rem;
            }
            .w-100 {
                width: 100% !important;
            }
        }

        /* Override untuk desktop agar tombol btn-lg tidak aktif */
        @media (min-width: 768px) {
            .btn-lg {
                /* Menghilangkan efek btn-lg saat di desktop */
                font-size: 1rem; 
                padding: 0.375rem 0.75rem; 
            }
            /* Memastikan lebar tombol sesuai konten di desktop */
            .w-100.d-md-block {
                width: auto !important; 
            }
        }
    </style>
@endpush