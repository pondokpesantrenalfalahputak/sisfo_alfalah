<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tagihan extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    protected $casts = ['tanggal_jatuh_tempo' => 'date'];

    // Relasi ke Santri (Satu Tagihan milik satu Santri)
    public function santri()
    {
        return $this->belongsTo(Santri::class, 'santri_id');
    }

    // Relasi ke Pembayaran (Satu Tagihan bisa memiliki banyak Pembayaran)
    // Direkomendasikan menggunakan nama jamak 'pembayarans' untuk relasi HasMany
    public function pembayarans()
    {
        return $this->hasMany(Pembayaran::class);
    }
    
    /**
     * Accessor: Mendapatkan total pembayaran yang sudah Dikonfirmasi Admin.
     * Dapat diakses secara dinamis via $tagihan->total_bayar_terkonfirmasi
     *
     * CATATAN: Fungsi ini HARUS mengembalikan nilai (numerik), BUKAN objek relasi.
     * Jika Anda menggunakan nama method yang sama dengan relasi lain, Laravel mungkin bingung.
     * Karena Anda menggunakan nama fungsi ini, pastikan panggilan di view menggunakan snake_case:
     * $tagihan->total_bayar_terkonfirmasi
     */
    public function getTotalBayarTerkonfirmasiAttribute()
    {
        // Panggil relasi 'pembayarans' (relasi HasMany yang baru kita definisikan)
        return $this->pembayarans()
                    ->where('status_konfirmasi', 'Dikonfirmasi')
                    ->sum('jumlah_bayar');
    }

    /**
     * Helper: Mengecek apakah tagihan sudah lunas.
     */
    public function isLunas()
    {
        // Panggil Accessor menggunakan properti dinamis snake_case
        return $this->jumlah_tagihan <= $this->total_bayar_terkonfirmasi;
    }
}