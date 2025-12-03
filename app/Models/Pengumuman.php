<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengumuman extends Model
{
    use HasFactory;

    protected $fillable = [
        'judul',
        'isi',
        'tanggal_publikasi',
        'status', // Asumsi kolom status ditambahkan untuk kontrol admin
        'kategori',
    ];

    // Jika Anda ingin kolom tanggal_publikasi otomatis menjadi objek Carbon
    protected $casts = [
        'tanggal_publikasi' => 'datetime',
    ];
}