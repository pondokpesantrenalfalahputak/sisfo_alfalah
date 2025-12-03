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
        Schema::create('pengumumen', function (Blueprint $table) {
            $table->id();
            
            // >>> KOLOM YANG HILANG DITAMBAHKAN DI SINI <<<
            
            // Judul pengumuman (Diperlukan oleh view)
            $table->string('judul', 255); 
            
            // Isi/konten pengumuman (Diperlukan oleh view)
            $table->text('isi'); 
            
            // Kolom tanggal yang menyebabkan error sebelumnya.
            // Kita gunakan 'date' atau 'datetime'
            $table->date('tanggal_publikasi'); 
            
            // Status, misal: 'draft' atau 'published' (Opsional, tapi disarankan)
            $table->enum('status', ['draft', 'published'])->default('draft');
            
            // >>> AKHIR KOLOM YANG HILANG <<<

            $table->timestamps(); // Ini membuat created_at dan updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengumumen');
    }
};