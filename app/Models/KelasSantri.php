<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Builder;

class KelasSantri extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_kelas',
        'tingkat', // Contoh: 7, 10, 13 (atau MTs, MA, MUTAKHORIJIN)
    ];

    protected $table = 'kelas_santris';

    // Relasi ke Santri
    public function santris()
    {
        return $this->hasMany(Santri::class, 'kelas_id');
    }

    // --- LOCAL SCOPES ---

    /**
     * Scope untuk memfilter kelas berdasarkan Tingkat MTs.
     * Menggunakan kondisi OR untuk menangani tingkat numerik (7, 8, 9)
     */
    public function scopeMts(Builder $query): void
    {
        $query->where('tingkat', 'MTs')
              ->orWhereIn('tingkat', [7, 8, 9]);
    }

    /**
     * Scope untuk memfilter kelas berdasarkan Tingkat MA.
     * Menggunakan kondisi OR untuk menangani tingkat numerik (10, 11, 12)
     */
    public function scopeMa(Builder $query): void
    {
        $query->where('tingkat', 'MA')
              ->orWhereIn('tingkat', [10, 11, 12]);
    }
    
    /**
     * Scope untuk memfilter kelas berdasarkan Tingkat MUTAKHORIJIN.
     * Menggunakan kondisi OR untuk menangani tingkat numerik (13)
     */
    public function scopeMutakhorijin(Builder $query): void
    {
        $query->where('tingkat', 'MUTAKHORIJIN')
              ->orWhere('tingkat', 13);
    }
}