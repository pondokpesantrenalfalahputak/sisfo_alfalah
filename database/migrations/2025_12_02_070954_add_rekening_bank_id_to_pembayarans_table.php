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
        Schema::table('pembayarans', function (Blueprint $table) {
            
            // <-- PERBAIKAN: Menggunakan foreignId() dan constrained() untuk mencegah error 150 -->
            // Ini akan membuat kolom BIGINT UNSIGNED dan menetapkan kunci asing
            // yang merujuk ke tabel 'rekening_banks' (nama baru dari tabel 'rekenings').
            $table->foreignId('rekening_bank_id') 
                  ->nullable()
                  ->constrained('rekening_banks') // <-- BENAR SETELAH RENAME
                  ->onDelete('set null')
                  ->after('metode_pembayaran');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pembayarans', function (Blueprint $table) {
            // Urutan penghapusan: Hapus kunci asing dulu, baru kolomnya
            $table->dropForeign(['rekening_bank_id']);
            $table->dropColumn('rekening_bank_id');
        });
    }
};