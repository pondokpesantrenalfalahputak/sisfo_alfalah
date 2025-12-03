<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Jalankan migrasi.
     */
    public function up(): void
    {
        Schema::table('absensi_harians', function (Blueprint $table) {
            // Mengubah kolom status menjadi Varchar dengan panjang 20 karakter
            $table->string('status', 20)->change(); 
        });
    }

    /**
     * Balikkan migrasi.
     */
    public function down(): void
    {
        Schema::table('absensi_harians', function (Blueprint $table) {
            // Mengembalikan ke panjang yang lebih pendek
            $table->string('status', 5)->change(); 
        });
    }
};