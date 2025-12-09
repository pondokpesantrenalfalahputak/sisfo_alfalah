<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Jalankan migrasi.
     * Metode ini mengubah kolom 'jenis_tagihan' menjadi 255 karakter.
     */
    public function up(): void
    {
        Schema::table('tagihans', function (Blueprint $table) {
            // Memperluas kolom 'jenis_tagihan' menjadi 255 karakter
            $table->string('jenis_tagihan', 255)->change();
        });
    }

    /**
     * Kembalikan migrasi.
     * Metode ini mengembalikan kolom 'jenis_tagihan' ke 50 karakter (asumsi nilai awal).
     */
    public function down(): void
    {
        Schema::table('tagihans', function (Blueprint $table) {
            // Mengembalikan nilai ke ukuran yang lebih kecil (sesuaikan jika aslinya bukan 50)
            $table->string('jenis_tagihan', 50)->change(); 
        });
    }
};