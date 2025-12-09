<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

// Pastikan Anda mengimpor semua Model yang berelasi
use App\Models\User;
use App\Models\KelasSantri;
use App\Models\Tagihan;
use App\Models\AbsensiRekapitulasi; 
use App\Models\AbsensiHarian; 

class Santri extends Model
{
    use HasFactory;
    
    // --------------------------------------------------------
    // --- KONFIGURASI PENTING UNTUK MASS ASSIGNMENT (REGISTER) ---
    // --------------------------------------------------------
    
    /**
     * Atribut yang dapat diisi secara massal (digunakan oleh controller@store)
     * Tambahkan semua kolom yang diisi saat registrasi di sini.
     */
    protected $fillable = [
        'wali_santri_id',
        'nama_lengkap',
        'nisn', 
        'tanggal_lahir', 
        'kelas_id',
        'alamat',
        'tempat_lahir',
        'jenis_kelamin', // <<< TAMBAHKAN INI
        'status',

    ];
    
    /**
     * Casting tipe data
     */
    protected $casts = [
        'tanggal_lahir' => 'date'
    ]; 

    // --------------------------------------------------------
    // --- ACCESSOR (Untuk mapping nama kolom di View/Blade) ---
    // --------------------------------------------------------

    /**
     * Accessor: Memetakan kolom 'nama_lengkap' (di DB) 
     * menjadi properti 'nama' (di view: $santri->nama).
     */
    public function getNamaAttribute(): string
    {
        return $this->attributes['nama_lengkap'];
    }

    /**
     * Accessor: Memetakan kolom 'nisn' (di DB) 
     * menjadi properti 'nis' (di view: $santri->nis).
     */
    public function getNisAttribute(): ?string
    {
        return $this->attributes['nisn'];
    }

    // --------------------------------------------------------
    // --- RELASI (Relationships) ---
    // --------------------------------------------------------

    /**
     * Relasi ke Model User (Wali Santri).
     */
    public function waliSantri(): BelongsTo
    {
        return $this->belongsTo(User::class, 'wali_santri_id');
    }

    /**
     * Relasi ke Model KelasSantri.
     */
    public function kelas(): BelongsTo
    {
        return $this->belongsTo(KelasSantri::class, 'kelas_id');
    }

    /**
     * Relasi ke Model Tagihan (One-to-Many).
     */
    public function tagihans(): HasMany
    {
        return $this->hasMany(Tagihan::class);
    }

    /**
     * Relasi ke Model AbsensiRekapitulasi (One-to-Many, rekap bulanan).
     */
    public function absensiRekapitulasi(): HasMany
    {
        return $this->hasMany(AbsensiRekapitulasi::class);
    }
    
    /**
     * Relasi ke Model AbsensiHarian (One-to-Many, log harian).
     */
    public function absensiHarians(): HasMany
    {
        return $this->hasMany(AbsensiHarian::class);
    }
}