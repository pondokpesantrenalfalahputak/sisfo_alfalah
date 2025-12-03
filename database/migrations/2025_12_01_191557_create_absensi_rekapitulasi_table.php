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
        Schema::create('absensi_rekapitulasi', function (Blueprint $table) {
            $table->id();
            $table->foreignId('santri_id')->constrained('santris')->onDelete('cascade');
            $table->foreignId('kelas_id')->constrained('kelas_santris')->onDelete('cascade');
            $table->foreignId('wali_input_id')->constrained('users')->onDelete('restrict'); // Siapa yang merekap

            $table->integer('bulan'); // 1 sampai 12
            $table->integer('tahun'); // Contoh: 2024
            
            // --- REKAPITULASI ALPHA SAJA ---
            $table->unsignedSmallInteger('ngaji_alpha')->default(0);
            $table->unsignedSmallInteger('sholat_alpha')->default(0);
            $table->unsignedSmallInteger('roan_alpha')->default(0);
            
            $table->text('keterangan')->nullable();
            
            // Mencegah duplikasi rekap bulanan untuk santri yang sama
            $table->unique(['santri_id', 'bulan', 'tahun']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('absensi_rekapitulasi');
    }
};