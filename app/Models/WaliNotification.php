<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WaliNotification extends Model
{
    use HasFactory;
    
    // Ganti ini dengan nama tabel notifikasi kustom Anda
    protected $table = 'wali_notifications'; 

    protected $fillable = [
        'user_id', 
        'title', 
        'body', 
        'link', 
        'is_read', 
        'created_at', 
        'updated_at'
    ];
    
    // Pastikan kolom boolean 'is_read' di-cast
    protected $casts = [
        'is_read' => 'boolean',
    ];
    
    // Relasi ke User (Wali Santri)
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}