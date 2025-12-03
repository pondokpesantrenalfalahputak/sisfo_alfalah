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
        // Ubah nama tabel dari 'rekenings' menjadi 'rekening_banks'
        Schema::rename('rekenings', 'rekening_banks'); 
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Kembalikan nama tabel (Rollback)
        Schema::rename('rekening_banks', 'rekenings');
    }
};