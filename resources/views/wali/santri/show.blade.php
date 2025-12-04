@extends('layouts.wali')

@section('title', 'Detail Santri')
@section('page_title', 'Detail Santri: ' . $santri->nama)

@section('content')
    <div class="card shadow-lg border-0 mb-4 rounded-4">
        
        {{-- CARD HEADER: Menampilkan nama santri dengan background primary --}}
        <div class="card-header bg-primary text-white fw-bold p-3 d-flex align-items-center rounded-top-4">
            <i class="fas fa-id-card me-2 fa-lg"></i> DETAIL LENGKAP: <span class="ms-1">{{ strtoupper($santri->nama) }}</span>
        </div>
        
        <div class="card-body p-4">
            
            <div class="row">
                
                {{-- KOTAK INFORMASI UTAMA SANTRI --}}
                <div class="col-md-6 mb-4">
                    <div class="card h-100 border-start border-5 border-success shadow-sm rounded-3">
                        <div class="card-body p-4">
                            <h5 class="fw-bold text-success mb-3 pb-2 border-bottom"><i class="fas fa-user-graduate me-2"></i> Data Pribadi Santri</h5>
                            
                            {{-- Menggunakan List Group untuk detail yang lebih rapi di Mobile --}}
                            <div class="list-group list-group-flush small">
                                
                                <div class="list-group-item d-flex justify-content-between px-0 py-2">
                                    <span class="text-muted">Nama Lengkap</span>
                                    <span class="fw-bold text-dark text-end">{{ $santri->nama }}</span>
                                </div>
                                
                                <div class="list-group-item d-flex justify-content-between px-0 py-2">
                                    <span class="text-muted">NIS / NISN</span>
                                    <span class="text-end">{{ $santri->nis ?? '-' }} / {{ $santri->nisn ?? '-' }}</span>
                                </div>
                                
                                <div class="list-group-item d-flex justify-content-between px-0 py-2">
                                    <span class="text-muted">Jenis Kelamin</span>
                                    <span class="text-end">{{ $santri->jenis_kelamin ?? '-' }}</span>
                                </div>
                                
                                <div class="list-group-item d-flex justify-content-between px-0 py-2">
                                    <span class="text-muted">Tempat/Tgl Lahir</span>
                                    <span class="text-end">
                                        {{ $santri->tempat_lahir ?? '-' }}, {{ $santri->tanggal_lahir ? $santri->tanggal_lahir->translatedFormat('d F Y') : '-' }}
                                    </span>
                                </div>
                                
                                <div class="list-group-item d-flex justify-content-between px-0 py-2">
                                    <span class="text-muted">Alamat</span>
                                    <span class="text-wrap text-end" style="max-width: 60%;">{{ $santri->alamat ?? '-' }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- KOTAK INFORMASI AKADEMIK & WALI --}}
                <div class="col-md-6 mb-4">
                    <div class="card h-100 border-start border-5 border-info shadow-sm rounded-3">
                        <div class="card-body p-4">
                            <h5 class="fw-bold text-info mb-3 pb-2 border-bottom"><i class="fas fa-bookmark me-2"></i> Akademik & Perwalian</h5>
                            
                            {{-- Menggunakan List Group untuk detail yang lebih rapi di Mobile --}}
                            <div class="list-group list-group-flush small">
                                
                                <div class="list-group-item d-flex justify-content-between px-0 py-2">
                                    <span class="text-muted">Kelas Aktif</span>
                                    <span class="badge bg-primary fw-bold p-2">
                                        {{ $santri->kelas->nama_kelas ?? 'Belum Ada Kelas' }}
                                    </span>
                                </div>
                                
                                <div class="list-group-item d-flex justify-content-between px-0 py-2">
                                    <span class="text-muted">Nomor Telepon</span>
                                    <span class="text-end">{{ $santri->no_hp ?? '-' }}</span>
                                </div>
                                
                                <div class="list-group-item d-flex justify-content-between px-0 py-2">
                                    <span class="text-muted">Wali Santri</span>
                                    <span class="fw-semibold text-dark text-end">
                                        {{ $santri->user->name ?? 'Tidak Terdaftar' }}
                                    </span>
                                </div>
                                
                                <div class="list-group-item d-flex justify-content-between px-0 py-2">
                                    <span class="text-muted">Status</span>
                                    <span class="badge bg-success-subtle text-success-emphasis fw-bold py-2">Aktif</span>
                                </div>
                                
                                <div class="list-group-item d-flex justify-content-between px-0 py-2">
                                    <span class="text-muted">ID Wali</span>
                                    <span class="text-end">{{ $santri->wali_santri_id ?? '-' }}</span>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Bagian Tautan Aksi Cepat (Dibuat lebih menonjol) --}}
            <div class="row mt-4 pt-3 border-top">
                <div class="col-12">
                    <h5 class="fw-bold text-dark mb-3"><i class="fas fa-bolt me-1 text-warning"></i> Akses Cepat Informasi</h5>
                    <div class="d-flex flex-wrap gap-2">
                        
                        <a href="{{ route('wali.absensi.index') }}?santri_id={{ $santri->id }}" class="btn btn-danger btn-lg shadow-sm rounded-pill px-4 flex-grow-1 flex-md-grow-0">
                            <i class="fas fa-calendar-times me-1"></i> Lihat Rekap Alpha
                        </a>
                        
                        {{-- Contoh: Link ke Tagihan Santri Spesifik --}}
                        <a href="{{ route('wali.tagihan.index') }}" class="btn btn-warning text-dark btn-lg shadow-sm rounded-pill px-4 flex-grow-1 flex-md-grow-0">
                            <i class="fas fa-receipt me-1"></i> Cek Tagihan
                        </a>
                        
                        {{-- Tambahkan link lain jika ada, misal: Nilai --}}
                        {{-- <a href="#" class="btn btn-outline-success btn-lg shadow-sm rounded-pill px-4 flex-grow-1 flex-md-grow-0">
                            <i class="fas fa-calculator me-1"></i> Cek Nilai Akademik
                        </a> --}}
                    </div>
                </div>
            </div>
            
        </div>

        {{-- CARD FOOTER: Tombol Kembali dibuat responsif dan menonjol --}}
        <div class="card-footer bg-light p-3 rounded-bottom-4">
            <a href="{{ route('wali.santri.index') }}" class="btn btn-secondary w-100 w-md-auto btn-lg rounded-pill px-4">
                <i class="fas fa-arrow-left me-1"></i> Kembali ke Daftar Santri
            </a>
        </div>
    </div>
@endsection