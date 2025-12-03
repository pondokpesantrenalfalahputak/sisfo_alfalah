<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Rekening extends Model
{
    use HasFactory;

    /**
     * Nama tabel di database yang terhubung dengan Model ini.
     * Ditetapkan secara eksplisit karena nama tabel di-rename menjadi 'rekening_banks'.
     */
    protected $table = 'rekening_banks'; 

    /**
     * Atribut yang tidak boleh diisi (mass assignable), di sini hanya 'id'.
     */
    protected $guarded = ['id'];
}