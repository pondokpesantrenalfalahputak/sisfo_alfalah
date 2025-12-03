<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Ubah kolom wali_santri_id agar dapat menerima nilai NULL
        Schema::table('santris', function (Blueprint $table) {
            $table->foreignId('wali_santri_id')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Kembalikan kolom ke keadaan NOT NULL (jika diperlukan)
        // Perhatikan bahwa ini akan gagal jika ada baris dengan NULL saat ini.
        // Jika Anda yakin tidak ada baris NULL saat ini:
        Schema::table('santris', function (Blueprint $table) {
            $table->foreignId('wali_santri_id')->nullable(false)->change();
        });
    }
};