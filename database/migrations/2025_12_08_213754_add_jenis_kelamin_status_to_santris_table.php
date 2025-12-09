<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Jalankan migrasi.
     */
    public function up(): void
    {
        Schema::table('santris', function (Blueprint $table) {
            // Tambahkan kolom jenis_kelamin
            $table->enum('jenis_kelamin', ['Laki-laki', 'Perempuan'])->after('nisn')->nullable();
            
            // Tambahkan kolom status
            $table->enum('status', ['Aktif', 'Non-aktif', 'Lulus'])->default('Aktif')->after('alamat');
            
            // Kolom tambahan lainnya yang mungkin hilang
            //$table->date('tanggal_lahir')->after('jenis_kelamin')->nullable();
            //$table->text('alamat')->after('tanggal_lahir')->nullable();
        });
    }

    /**
     * Balikkan (rollback) migrasi.
     */
    public function down(): void
    {
        Schema::table('santris', function (Blueprint $table) {
            $table->dropColumn(['jenis_kelamin', 'status', 'tanggal_lahir', 'alamat']);
        });
    }
};