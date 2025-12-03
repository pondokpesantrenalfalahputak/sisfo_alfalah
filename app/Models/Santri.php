<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

// Pastikan Anda mengimpor semua Model yang berelasi
use App\Models\User;
use App\Models\KelasSantri;
use App\Models\Tagihan;
use App\Models\AbsensiRekapitulasi; 
// Model Absensi Harian yang baru kita buat
use App\Models\AbsensiHarian; 

class Santri extends Model
{
    use HasFactory;
    
    // Atribut yang tidak boleh diisi mass assignable
    protected $guarded = ['id'];
    
    // Casting tipe data
    protected $casts = ['tanggal_lahir' => 'date']; 

    // --- ACCESSOR ---

    /**
     * Accessor: Memetakan kolom 'nama_lengkap' (di DB) 
     * menjadi properti 'nama' (di view: $santri->nama).
     */
    public function getNamaAttribute()
    {
        return $this->attributes['nama_lengkap'];
    }

    /**
     * Accessor: Memetakan kolom 'nisn' (di DB) 
     * menjadi properti 'nis' (di view: $santri->nis).
     */
    public function getNisAttribute()
    {
        return $this->attributes['nisn'];
    }

    // --- RELASI ---

    /**
     * Relasi ke Model User (Wali Santri).
     * Kolom foreign key: 'wali_santri_id'.
     */
    public function waliSantri()
    {
        return $this->belongsTo(User::class, 'wali_santri_id');
    }

    /**
     * Relasi ke Model KelasSantri.
     */
    public function kelas()
    {
        return $this->belongsTo(KelasSantri::class, 'kelas_id');
    }

    /**
     * Relasi ke Model Tagihan (One-to-Many).
     */
    public function tagihans() 
    {
        return $this->hasMany(Tagihan::class);
    }

    /**
     * Relasi ke Model AbsensiRekapitulasi (One-to-Many, untuk rekap bulanan).
     */
    public function absensiRekapitulasi() 
    {
        return $this->hasMany(AbsensiRekapitulasi::class);
    }
    
    /**
     * Relasi ke Model AbsensiHarian (One-to-Many, untuk log harian).
     */
    public function absensiHarians() 
    {
        return $this->hasMany(AbsensiHarian::class);
    }
}