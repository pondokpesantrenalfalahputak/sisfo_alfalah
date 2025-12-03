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
        Schema::create('pembayarans', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('tagihan_id');
            $table->unsignedBigInteger('user_id');
            $table->decimal('jumlah_bayar', 15, 2);
            $table->string('metode_pembayaran', 100);
            $table->string('bukti_pembayaran')->nullable();
            $table->enum('status_konfirmasi', ['Menunggu', 'Dikonfirmasi', 'Ditolak'])->default('Menunggu');
            $table->timestamp('tanggal_bayar')->nullable();
            $table->text('catatan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pembayarans');
    }
};
