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
        Schema::create('santris', function (Blueprint $table) {
            $table->id();
            $table->foreignId('wali_santri_id')->constrained('users'); // Terhubung ke user (wali)
            $table->foreignId('kelas_id')->constrained('kelas_santris');
            $table->string('nama_lengkap');
            $table->string('nisn')->unique();
            $table->string('tempat_lahir')->nullable();
            $table->date('tanggal_lahir')->nullable();
            $table->string('alamat')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('santris');
    }
};
