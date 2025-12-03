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
        Schema::create('absensi_harians', function (Blueprint $table) {
            $table->id();
            
            // Relasi
            $table->foreignId('santri_id')->constrained('santris')->onDelete('cascade');
            $table->foreignId('wali_input_id')->constrained('users')->onDelete('restrict'); 
            
            // Detail Absensi
            $table->date('tanggal_absensi');
            
            // Kolom untuk memegang jenis kegiatan (Subuh, Qiroati, Roan Pagi, Sekolah MTs, dll.)
            $table->string('jenis_kegiatan', 50); 
            
            // Status: Hadir, Izin, Alpha, Sakit
            $table->enum('status', ['Hadir', 'Izin', 'Alpha', 'Sakit'])->default('Hadir'); // ✅ Dikonfirmasi: Default adalah 'Hadir'
            
            $table->text('keterangan')->nullable();
            
            // Mencegah duplikasi data: Santri tidak boleh memiliki status yang sama
            // untuk kegiatan dan tanggal yang sama.
            $table->unique(['santri_id', 'tanggal_absensi', 'jenis_kegiatan']);
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('absensi_harians');
    }
};