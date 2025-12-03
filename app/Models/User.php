<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * Atribut yang dapat diisi secara massal (Mass Assignable).
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role', // Sangat penting untuk otorisasi
    ];

    /**
     * Atribut yang disembunyikan untuk serialisasi.
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Mendefinisikan tipe cast untuk atribut model.
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // --- RELASI ---

    /**
     * Relasi ke Santri: Wali Santri (User) memiliki banyak Santri.
     */
    public function santris(): HasMany
    {
        // Kunci asing di tabel 'santris' adalah 'wali_santri_id'
        return $this->hasMany(Santri::class, 'wali_santri_id');
    }

    // --- HELPER UNTUK ROLE (Otorisasi Middleware) ---

    /**
     * Mengecek apakah user memiliki role 'admin'.
     */
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    /**
     * Mengecek apakah user memiliki role 'wali_santri'.
     * Digunakan oleh WaliSantriMiddleware.
     */
    public function isWaliSantri(): bool
    {
        return $this->role === 'wali_santri';
    }
}