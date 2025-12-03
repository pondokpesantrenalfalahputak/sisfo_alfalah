<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Pembayaran extends Model
{
    use HasFactory;
    
    // Gunakan guarded agar fleksibel dalam mass assignment, kecuali 'id'
    protected $guarded = ['id'];
    
    // Pastikan Anda juga memasukkan kolom baru jika ada, seperti 'rekening_id'
    // atau 'rekening_bank_id' yang Anda gunakan di migrasi. Kita asumsikan 'rekening_id'.

    /**
     * Relasi ke Tagihan.
     */
    public function tagihan()
    {
        return $this->belongsTo(Tagihan::class);
    }

    /**
     * Relasi ke Wali Santri/User yang melakukan pembayaran.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id'); 
    }
    
    /**
     * Relasi ke Rekening Bank Tujuan Pembayaran.
     */
    public function rekening()
    {
        // PERBAIKAN: Menggunakan nama Model yang benar (App\Models\Rekening)
        // Foreign key di tabel pembayarans kita asumsikan 'rekening_id'
        return $this->belongsTo(Rekening::class, 'rekening_id'); 
    }
}