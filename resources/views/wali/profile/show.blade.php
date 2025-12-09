@extends('layouts.wali')

@section('title', 'Profil Pengguna')
@section('page_title', 'Pengaturan Profil Saya')


@section('content')

@if (session('error'))
    <div class="alert alert-danger alert-dismissible fade show border-0 rounded-3 alert-flat" role="alert">
        <i class="fas fa-times-circle me-2"></i> {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

{{-- Notifikasi Error Validasi Khusus Password --}}
@if ($errors->has('current_password') || $errors->has('password'))
    <div class="alert alert-warning alert-dismissible fade show border-0 rounded-3 alert-flat" role="alert">
        <i class="fas fa-exclamation-triangle me-2"></i> Gagal mengganti kata sandi. Silakan cek form Ubah Kata Sandi di tab merah.
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif


<div class="row g-4">
    
    {{-- Kolom Kiri: Detail Profil (Visual Card) --}}
    <div class="col-lg-4">
        {{-- Card Minimalis dengan border kiri yang tebal --}}
        <div class="card h-100 rounded-4 border-0 card-flat border-start border-primary border-5">
            <div class="card-body text-center p-4">
                
                {{-- Foto Profil Placeholder --}}
                <div class="mb-4 profile-ring-flat">
                    <img class="rounded-circle border border-2 border-light" 
                         src="https://placehold.co/180x180/3B82F6/FFFFFF?text={{ strtoupper(substr($user->name, 0, 1)) }}" 
                         alt="Profil" style="width: 150px; height: 150px; object-fit: cover;">
                </div>

                <div class="text-start mt-4">
                    <p class="mb-1 text-muted small"><i class="fas fa-user-circle me-2 text-primary"></i> Nama Lengkap</p>
                    <h4 class="fw-bolder text-dark mb-3">{{ $user->name }}</h4>
                    
                    <p class="mb-1 text-muted small"><i class="fas fa-envelope me-2 text-primary"></i> Alamat Email</p>
                    <p class="text-secondary mb-3 fw-semibold">{{ $user->email }}</p>
                </div>

                <hr class="text-muted">

                <div class="d-grid gap-2">
                    <span class="badge bg-primary text-uppercase p-2 mb-2 fs-6 rounded-pill">
                        <i class="fas fa-shield-alt me-2"></i> Peran: {{ $user->role ?? 'Wali Santri' }}
                    </span>
                    <small class="text-muted mt-2">
                        <i class="fas fa-calendar-check me-1"></i> Bergabung Sejak: <span class="fw-semibold">{{ $user->created_at->translatedFormat('d M Y') }}</span>
                    </small>
                </div>
            </div>
            <div class="card-footer bg-light border-0 text-center small rounded-bottom-4">
                 <p class="mb-0 text-secondary">
                    Status akun Anda adalah Aktif sebagai Wali Santri.
                </p>
            </div>
        </div>
    </div>

    {{-- Kolom Kanan: Form Edit Data dan Password --}}
    <div class="col-lg-8">
        
        {{-- TAB NAVIGATION (Clean pills on white background) --}}
        <ul class="nav nav-pills mb-4 p-2 bg-white rounded-4 shadow-sm nav-tab-custom-flat" id="profileTab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link @if (!($errors->has('current_password') || $errors->has('password'))) active @endif fw-bold rounded-3 px-4 me-2 text-dark" id="data-tab" data-bs-toggle="tab" data-bs-target="#data-section" type="button" role="tab" aria-controls="data-section" aria-selected="@if (!($errors->has('current_password') || $errors->has('password'))) true @else false @endif">
                    <i class="fas fa-user-edit me-1"></i> Perbarui Data
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link @if ($errors->has('current_password') || $errors->has('password')) active tab-danger @endif fw-bold rounded-3 px-4 text-dark" id="password-tab" data-bs-toggle="tab" data-bs-target="#password-section" type="button" role="tab" aria-controls="password-section" aria-selected="@if ($errors->has('current_password') || $errors->has('password')) true @else false @endif">
                    <i class="fas fa-lock me-1"></i> Ubah Kata Sandi
                </button>
            </li>
        </ul>

        <div class="tab-content">
            
            {{-- TAB 1: PERBARUI DATA PENGGUNA --}}
            <div class="tab-pane fade @if (!($errors->has('current_password') || $errors->has('password'))) show active @endif" id="data-section" role="tabpanel" aria-labelledby="data-tab">
                <div class="card border-0 rounded-4 card-flat border-top border-4 border-primary">
                    <div class="card-header bg-light border-bottom p-4 rounded-top-4">
                         <h5 class="fw-bold text-primary mb-0"><i class="fas fa-info-circle me-2"></i> Informasi Dasar Akun</h5>
                         <small class="text-muted">Perbarui nama dan alamat email yang terkait dengan akun Anda.</small>
                    </div>
                    <div class="card-body p-4">
                        <form action="{{ route('wali.profile.update') }}" method="POST"> 
                            @csrf
                            @method('PUT')
                            
                            <div class="row g-4">
                                {{-- Mengganti form-floating dengan form standar --}}
                                <div class="col-md-6">
                                    <label for="name" class="form-label fw-semibold">Nama Lengkap</label>
                                    <input type="text" name="name" id="name" class="form-control form-control-lg @error('name') is-invalid @enderror rounded-3" value="{{ old('name', $user->name) }}" required>
                                    @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div> 
                                <div class="col-md-6">
                                    <label for="email" class="form-label fw-semibold">Alamat Email</label>
                                    <input type="email" name="email" id="email" class="form-control form-control-lg @error('email') is-invalid @enderror rounded-3" value="{{ old('email', $user->email) }}" required>
                                    @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                            </div>
                            
                            <hr class="mt-5 mb-4">
                            <div class="d-flex justify-content-end">
                                <button type="submit" class="btn btn-primary px-5 btn-lg rounded-pill btn-hover-grow">
                                    <i class="fas fa-save me-2"></i> Simpan Perubahan
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            {{-- TAB 2: UBAH KATA SANDI --}}
            <div class="tab-pane fade @if ($errors->has('current_password') || $errors->has('password')) show active @endif" id="password-section" role="tabpanel" aria-labelledby="password-tab">
                 <div class="card border-0 rounded-4 card-flat border-top border-4 border-danger">
                    <div class="card-header bg-light border-bottom p-4 rounded-top-4">
                         <h5 class="fw-bold text-danger mb-0"><i class="fas fa-key me-2"></i> Ubah Kata Sandi</h5>
                         <small class="text-muted">Gunakan kata sandi yang kuat dan unik untuk melindungi akun Anda.</small>
                    </div>
                    <div class="card-body p-4">
                        <form action="{{ route('wali.profile.password') }}" method="POST">
                            @csrf
                            @method('PUT')
                            
                            <div class="row g-4">
                                <div class="col-12">
                                    <label for="current_password" class="form-label fw-semibold">Kata Sandi Saat Ini (Lama)</label>
                                    <input type="password" name="current_password" id="current_password" class="form-control form-control-lg @error('current_password') is-invalid @enderror rounded-3" required>
                                    @error('current_password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                                <div class="col-md-6">
                                    <label for="password" class="form-label fw-semibold">Kata Sandi Baru</label>
                                    <input type="password" name="password" id="password" class="form-control form-control-lg @error('password') is-invalid @enderror rounded-3" required>
                                    @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                                <div class="col-md-6">
                                    <label for="password_confirmation" class="form-label fw-semibold">Konfirmasi Kata Sandi Baru</label>
                                    <input type="password" name="password_confirmation" id="password_confirmation" class="form-control form-control-lg @error('password') is-invalid @enderror rounded-3" required>
                                    @if($errors->has('password') && strpos($errors->first('password'), 'confirmation') !== false)
                                        <div class="invalid-feedback">Konfirmasi kata sandi tidak cocok.</div>
                                    @endif
                                </div>
                            </div>
                            
                            <hr class="mt-5 mb-4">
                            <div class="d-flex justify-content-end">
                                <button type="submit" class="btn btn-danger px-5 btn-lg rounded-pill btn-hover-grow">
                                    <i class="fas fa-lock me-2"></i> Ganti Kata Sandi
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        
    </div>
</div>

@push('css')
<style>
    /* Mengganti shadow dengan border tipis untuk kesan flat/clean */
    .card-flat {
        box-shadow: 0 0 0 1px rgba(0, 0, 0, 0.05), 0 1px 3px rgba(0, 0, 0, 0.05); /* Shadow sangat minimal */
        transition: all 0.3s ease-in-out;
    }
    .card-flat:hover {
        transform: translateY(-2px); /* Gerakan lift yang halus */
        box-shadow: 0 0 0 1px rgba(0, 0, 0, 0.1), 0 5px 15px rgba(0, 0, 0, 0.08);
    }
    
    /* Input Form yang lebih besar dan rounded */
    .form-control-lg {
        padding: 0.75rem 1rem;
    }

    /* Efek tombol Grow/Scale saat di hover */
    .btn-hover-grow:hover {
        transform: scale(1.03);
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.15);
    }
    .btn-hover-grow {
        transition: all 0.2s ease-in-out;
    }

    /* Styling untuk nav-pills */
    .nav-tab-custom-flat .nav-link {
        color: #495057; 
        background-color: transparent;
        transition: all 0.3s;
    }
    
    /* Tab Data: Warna Primary (Biru) - Flat Effect */
    #data-tab.nav-link.active {
        background-color: #0d6efd; 
        color: white !important;
        box-shadow: 0 2px 5px rgba(13, 110, 253, 0.2); /* Shadow minimal */
    }
    
    /* Tab Password: Warna Danger (Merah) - Flat Effect */
    #password-tab.nav-link.active {
        background-color: #dc3545; 
        color: white !important;
        box-shadow: 0 2px 5px rgba(220, 53, 69, 0.2); /* Shadow minimal */
    }

    /* Styling untuk Foto Profil */
    .profile-ring-flat img {
        outline: 4px solid #0d6efd; /* Ring luar berwarna primary */
        outline-offset: 4px; /* Memberi jarak antara foto dan ring */
        box-shadow: 0 0 0 6px #ffffff; /* Menggantikan border Bootstrap */
        border: none !important;
    }
    .profile-ring-flat {
        padding: 6px;
    }
</style>
@endpush

@push('js')
<script>
    // Script untuk otomatis beralih ke tab Kata Sandi jika ada error validasi
    document.addEventListener('DOMContentLoaded', function() {
        @if ($errors->has('current_password') || $errors->has('password'))
            var passwordTab = document.getElementById('password-tab');
            var bsTab = new bootstrap.Tab(passwordTab);
            bsTab.show();
        @endif
    });
</script>
@endpush
@endsection