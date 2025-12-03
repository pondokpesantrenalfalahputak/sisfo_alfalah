<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations (Menjalankan Migrasi).
     * Ini menambahkan kolom 'kategori'.
     */
    public function up(): void
    {
        Schema::table('pengumumen', function (Blueprint $table) {
            // Menambahkan kolom 'kategori' dengan tipe data STRING (maks 100 karakter)
            // Kolom ini diatur sebagai nullable (boleh kosong) dan ditempatkan setelah kolom 'judul'.
            $table->string('kategori', 100)->nullable()->after('judul');
        });
    }

    /**
     * Reverse the migrations (Membatalkan Migrasi).
     * Ini menghapus kolom 'kategori' jika rollback dijalankan.
     */
    public function down(): void
    {
        Schema::table('pengumumen', function (Blueprint $table) {
            // Menghapus kolom 'kategori'.
            $table->dropColumn('kategori');
        });
    }
};