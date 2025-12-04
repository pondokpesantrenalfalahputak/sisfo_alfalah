<?php

namespace App\Events;

use App\Models\User;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class AttendanceUpdated
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $user; // Wali Santri (Penerima)
    public $context; // 'Harian' atau 'Bulanan'
    public $keterangan; // Nama kegiatan/bulan tahun

    public function __construct(User $user, string $context, string $keterangan)
    {
        $this->user = $user;
        $this->context = $context;
        $this->keterangan = $keterangan;
    }
}