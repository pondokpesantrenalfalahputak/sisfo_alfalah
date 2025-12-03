<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB; 

return new class extends Migration
{
    /**
     * ID Kelas default yang harus ada di tabel 'kelas_santris'.
     * Menggunakan ID 10 (Kelas 7) yang sudah terkonfirmasi ada.
     */
    private const ID_KELAS_DEFAULT = 10; 

    /**
     * Run the migrations. (Mengubah ke ON DELETE SET NULL)
     */
    public function up(): void
    {
        // Pastikan Anda telah menjalankan: composer require doctrine/dbal
        Schema::table('santris', function (Blueprint $table) {
            
            // 1. Hapus Kunci Asing LAMA
            $table->dropForeign(['kelas_id']); 

            // 2. Ubah Kolom menjadi Nullable
            $table->foreignId('kelas_id')->nullable()->change();

            // 3. Tambahkan kembali Kunci Asing dengan ON DELETE SET NULL
            $table->foreign('kelas_id')
                  ->references('id')->on('kelas_santris')
                  ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     * Mengembalikan kelas_id menjadi non-nullable dan foreign key menjadi ON DELETE RESTRICT (default).
     */
    public function down(): void
    {
        // 1. HAPUS KUNCI ASING YANG ADA DENGAN RAW SQL (di luar closure Schema::table)
        // Ini adalah langkah teraman untuk menangani Error 1091 (kunci tidak ditemukan).
        $possibleKeys = [
            'santris_kelas_id_foreign', // Kunci default Laravel
            'santris_kelas_id_set_null_foreign', // Kunci potensial jika nama diubah oleh DB
        ];

        foreach ($possibleKeys as $keyName) {
            try {
                // Mencoba menghapus kunci secara eksplisit
                DB::statement('ALTER TABLE santris DROP FOREIGN KEY ' . $keyName);
            } catch (\Exception $e) {
                // Lanjutkan/abaikan jika errornya 1091 (kunci tidak ada)
                if (strpos($e->getMessage(), '1091') === false) {
                    throw $e;
                }
            }
        }

        // 2. LANJUTKAN OPERASI PENGEMBALIAN KOLOM DI DALAM CLOSURE
        Schema::table('santris', function (Blueprint $table) {
            
            // 3. AMAN: Isi semua nilai NULL yang ada dengan ID Kelas Default (10)
            DB::table('santris')
                ->whereNull('kelas_id')
                ->update(['kelas_id' => self::ID_KELAS_DEFAULT]); 

            // 4. Kembalikan Kolom menjadi Non-Nullable (Hanya CHANGE)
            // Ini HANYA memodifikasi properti kolom, tidak mencoba membuat kolom lagi.
            $table->foreignId('kelas_id')->nullable(false)->change(); 
            
            // 5. Tambahkan kembali Kunci Asing dengan mekanisme default (ON DELETE RESTRICT)
            // PENTING: Gunakan foreign() dan references() untuk menghindari error 'Duplicate Column'
            $table->foreign('kelas_id')
                  ->references('id')->on('kelas_santris')
                  ->onDelete('restrict');
        });
    }
};