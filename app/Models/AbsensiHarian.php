<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
// ✅ TAMBAHKAN IMPOR USER
use App\Models\User; 

class AbsensiHarian extends Model
{
    use HasFactory;
    
    // Nama tabel
    protected $table = 'absensi_harians';
    
    // Karena Anda menggunakan $guarded = ['id'], semua kolom selain 'id' bisa diisi.
    protected $guarded = ['id']; 

    // Atribut yang harus di-cast ke tipe data tertentu
    protected $casts = [
        'tanggal_absensi' => 'date',
    ];

    // =========================================================================
    // RELATIONS
    // =========================================================================

    public function santri()
    {
        return $this->belongsTo(Santri::class);
    }

    public function waliInput()
    {
        // Siapa yang menginput/merecord absensi
        return $this->belongsTo(User::class, 'wali_input_id');
    }
}