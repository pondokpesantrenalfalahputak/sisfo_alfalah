<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations. (MENAMBAHKAN KUNCI ASING)
     * * Menambahkan Foreign Keys:
     * - 'tagihan_id' merujuk ke 'id' di tabel 'tagihans'
     * - 'user_id' merujuk ke 'id' di tabel 'users'
     */
    public function up(): void
    {
        Schema::table('pembayarans', function (Blueprint $table) {
            // Menambahkan Foreign Key untuk Tagihan (ON DELETE CASCADE)
            $table->foreign('tagihan_id')->references('id')->on('tagihans')->onDelete('cascade');
            
            // Menambahkan Foreign Key untuk User (Petugas yang memproses atau Santri yang membayar)
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations. (MENGHAPUS KUNCI ASING)
     * * Menghapus Foreign Keys yang telah dibuat di metode up().
     */
    public function down(): void
    {
        Schema::table('pembayarans', function (Blueprint $table) {
            
            // Hapus foreign key untuk tagihan_id (Laravel 8+ merekomendasikan sintaks array)
            $table->dropForeign(['tagihan_id']);
            
            // Hapus foreign key untuk user_id
            $table->dropForeign(['user_id']);
        });
    }
};