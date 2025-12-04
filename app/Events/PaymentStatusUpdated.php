<?php

namespace App\Events;

use App\Models\User;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class PaymentStatusUpdated
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $user; // Wali Santri (Penerima)
    public $pembayaran;
    public $status;

    public function __construct(User $user, \App\Models\Pembayaran $pembayaran, string $status)
    {
        $this->user = $user;
        $this->pembayaran = $pembayaran;
        $this->status = $status;
    }
}