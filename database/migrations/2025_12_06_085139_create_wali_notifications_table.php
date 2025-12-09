<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Jalankan migrasi.
     * Metode ini membuat tabel 'wali_notifications'.
     */
    public function up(): void
    {
        Schema::create('wali_notifications', function (Blueprint $table) {
            $table->id();
            // Menghubungkan notifikasi ini ke Wali Santri di tabel 'users'.
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            
            $table->string('title'); // Judul notifikasi (misalnya: Pembayaran Dikonfirmasi)
            $table->text('body');    // Isi notifikasi (deskripsi detail)
            $table->string('link')->nullable(); // URL tautan ke halaman detail (misalnya: detail tagihan)
            $table->boolean('is_read')->default(false); // Status sudah dibaca atau belum
            $table->timestamps();    // Kolom created_at dan updated_at
        });
    }

    /**
     * Kembalikan migrasi.
     * Metode ini menghapus tabel 'wali_notifications' jika migrasi di-rollback.
     */
    public function down(): void
    {
        Schema::dropIfExists('wali_notifications');
    }
};