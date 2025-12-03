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
        Schema::create('tagihans', function (Blueprint $table) {
            $table->id();
            
            // 1. Relasi Santri dengan ON DELETE CASCADE (Sudah benar)
            $table->foreignId('santri_id')
                  ->constrained('santris')
                  ->onDelete('cascade'); // <-- Implementasi ON DELETE CASCADE di sini
                  
            // 2. Kolom tanggal_tagihan yang hilang (Wajib ditambahkan)
            $table->date('tanggal_tagihan'); // <-- TAMBAH INI

            // Kolom lainnya
            $table->enum('jenis_tagihan', ['SPP', 'Galon', 'Denda', 'Uang Kas', 'Uang Pembangunan']);
            $table->decimal('jumlah_tagihan', 10, 2);
            $table->date('tanggal_jatuh_tempo');
            $table->enum('status', ['Belum Lunas', 'Lunas'])->default('Belum Lunas');
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tagihans');
    }
};
