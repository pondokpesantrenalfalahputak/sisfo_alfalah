<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Builder; // Import Builder untuk Scope

class AbsensiRekapitulasi extends Model
{
    use HasFactory;
    
    // Sesuaikan nama tabel
    protected $table = 'absensi_rekapitulasi';
    
    protected $guarded = ['id'];

    // Atribut yang akan di-append (ditambahkan) saat model diubah ke array/JSON
    protected $appends = ['total_alpha']; // <-- BARIS BARU

    // List atribut yang berisi status absensi Alpha
    public const ALPHA_FIELDS = [
        'ngaji_alpha', 'sholat_alpha', 'roan_alpha'
    ];

    // =========================================================================
    // RELATIONS
    // =========================================================================

    public function santri()
    {
        return $this->belongsTo(Santri::class);
    }

    public function kelas()
    {
        return $this->belongsTo(KelasSantri::class, 'kelas_id');
    }

    public function waliInput()
    {
        return $this->belongsTo(User::class, 'wali_input_id');
    }

    // =========================================================================
    // ACCESSORS (Membaca Data)
    // =========================================================================

    /**
     * Aksesor untuk menghitung total Alpha dari semua kategori.
     * Dapat diakses sebagai $absensi->total_alpha
     */
    public function getTotalAlphaAttribute(): int
    {
        return $this->ngaji_alpha + $this->sholat_alpha + $this->roan_alpha;
    }

    // =========================================================================
    // LOCAL SCOPES (Query Builder)
    // =========================================================================

    /**
     * Scope untuk memfilter berdasarkan Bulan dan Tahun.
     * Contoh: AbsensiRekapitulasi::filterBulanTahun(11, 2024)->get();
     */
    public function scopeFilterBulanTahun(Builder $query, int $bulan, int $tahun): void
    {
        $query->where('bulan', $bulan)
              ->where('tahun', $tahun);
    }
}