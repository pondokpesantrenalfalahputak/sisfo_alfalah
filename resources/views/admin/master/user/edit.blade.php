@extends('layouts.admin')

@section('title', 'Edit User')
@section('page_title', 'Edit Data User: ' . $user->name)

@section('header_actions')
    {{-- Tombol untuk kembali ke Daftar User (Desktop) --}}
    <a href="{{ route('admin.user.index') }}" class="btn btn-outline-secondary shadow-sm rounded-pill d-none d-md-flex align-items-center fw-semibold px-4">
        <i class="fas fa-list me-2"></i>
        Daftar User
    </a>
@endsection

@section('content')

<div class="container-fluid">
    <div class="row">
        <div class="col-12">

            {{-- Menghilangkan h2 dan menggantinya dengan section title --}}

            <div class="card shadow-lg border-0 rounded-4 border-start border-5 border-warning">
                
                {{-- HEADER CARD --}}
                <div class="card-header bg-warning text-dark p-4 rounded-top-4">
                    <h4 class="mb-0 fw-bold fs-5"><i class="fas fa-user-edit me-2"></i> Formulir Edit Data User</h4>
                    <p class="text-secondary small mb-0">Lakukan perubahan pada detail akun dan peran untuk user {{ $user->name }}.</p>
                </div>
                
                <div class="card-body p-4">

                    {{-- Tampilkan error validasi jika ada --}}
                    @if ($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show rounded-3 shadow-sm mb-4" role="alert">
                            <h6 class="alert-heading fw-bold"><i class="fas fa-exclamation-triangle me-2"></i> Mohon koreksi kesalahan berikut:</h6>
                            <ul class="mb-0 ps-3 small">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
                    
                    <form action="{{ route('admin.user.update', $user) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        {{-- Bagian I: Data Akun --}}
                        <h5 class="fw-bold text-dark mb-3 mt-2 border-bottom pb-2 text-primary"><i class="fas fa-user me-2"></i> Data Akun Utama</h5>
                        <div class="row g-3">
                            
                            {{-- Nama --}}
                            <div class="col-md-6">
                                <label for="name" class="form-label fw-semibold small">Nama Lengkap/Alias <span class="text-danger">*</span></label>
                                <div class="input-group input-group-sm-down">
                                    <span class="input-group-text"><i class="fas fa-signature"></i></span>
                                    {{-- Menghapus form-control-lg --}}
                                    <input type="text" name="name" id="name" 
                                           class="form-control @error('name') is-invalid @enderror" 
                                           placeholder="Nama Lengkap/Alias" value="{{ old('name', $user->name) }}" required>
                                    @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                            </div>
                            
                            {{-- Email --}}
                            <div class="col-md-6">
                                <label for="email" class="form-label fw-semibold small">Email <span class="text-danger">*</span></label>
                                <div class="input-group input-group-sm-down">
                                    <span class="input-group-text"><i class="fas fa-at"></i></span>
                                    {{-- Menghapus form-control-lg --}}
                                    <input type="email" name="email" id="email" 
                                           class="form-control @error('email') is-invalid @enderror" 
                                           placeholder="Alamat Email" value="{{ old('email', $user->email) }}" required>
                                    @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                            </div>
                            
                            {{-- Role --}}
                            <div class="col-12">
                                <label for="role" class="form-label fw-semibold small">Peran (Role) User <span class="text-danger">*</span></label>
                                <div class="input-group input-group-sm-down">
                                    <span class="input-group-text"><i class="fas fa-user-tag"></i></span>
                                    {{-- Menghapus form-select-lg --}}
                                    <select name="role" id="role" class="form-select @error('role') is-invalid @enderror" required>
                                        <option value="">-- Pilih Role --</option>
                                        <option value="admin" {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>Admin (Pengelola Sistem)</option>
                                        <option value="wali_santri" {{ old('role', $user->role) == 'wali_santri' ? 'selected' : '' }}>Wali Santri (Akses Portal Wali)</option>
                                    </select>
                                    @error('role')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                            </div>
                            
                        </div>
                        
                        <hr class="mt-5 mb-4 border-warning opacity-25">
                        
                        {{-- Bagian II: Keamanan (Password) --}}
                        <h5 class="fw-bold text-dark mb-3 mt-2 border-bottom pb-2 text-danger"><i class="fas fa-lock me-2"></i> Ganti Password (Opsional)</h5>
                        <div class="alert alert-info rounded-3 small shadow-sm" role="alert">
                            <i class="fas fa-info-circle me-2"></i> Kosongkan kolom password di bawah ini jika Anda tidak ingin mengubah password user.
                        </div>
                        <div class="row g-3">
                            
                            {{-- Password Baru --}}
                            <div class="col-md-6">
                                <label for="password" class="form-label fw-semibold small">Password Baru</label>
                                <div class="input-group input-group-sm-down">
                                    <span class="input-group-text"><i class="fas fa-key"></i></span>
                                    {{-- Menghapus form-control-lg dan Tombol Tampilkan Sandi --}}
                                    <input type="password" name="password" id="password" 
                                           class="form-control @error('password') is-invalid @enderror" 
                                           placeholder="Masukkan Password Baru">
                                    @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                            </div>
                            
                            {{-- Konfirmasi Password --}}
                            <div class="col-md-6">
                                <label for="password_confirmation" class="form-label fw-semibold small">Konfirmasi Password Baru</label>
                                <div class="input-group input-group-sm-down">
                                    <span class="input-group-text"><i class="fas fa-check-double"></i></span>
                                    {{-- Menghapus form-control-lg dan Tombol Tampilkan Sandi --}}
                                    <input type="password" name="password_confirmation" id="password_confirmation" 
                                           class="form-control" 
                                           placeholder="Konfirmasi Password Baru">
                                </div>
                            </div>
                            
                        </div>
                        
                        <hr class="mt-5 mb-4 border-dark opacity-25">
                        
                        {{-- Tombol Aksi (Full-width Mobile) --}}
                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            {{-- Tombol Batal --}}
                            <a href="{{ route('admin.user.index') }}" class="btn btn-outline-secondary px-4 shadow-sm fw-semibold rounded-pill order-2 order-md-1">
                                <i class="fas fa-times me-2"></i> Batal
                            </a>
                            {{-- Tombol Update --}}
                            <button type="submit" class="btn btn-warning px-4 shadow-lg fw-bold text-dark rounded-pill order-1 order-md-2">
                                <i class="fas fa-redo me-2"></i> Update User
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
{{-- Menghapus script toggle password --}}
@endsection