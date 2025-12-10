<?php

namespace App\Events;

use App\Models\User;
use App\Models\Tagihan;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class NewBillCreated
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Wali Santri (Penerima Notifikasi).
     * @var \App\Models\User
     */
    public $user; 
    
    /**
     * Objek Tagihan yang baru dibuat.
     * @var \App\Models\Tagihan
     */
    public $tagihan; 

    /**
     * Create a new event instance.
     */
    public function __construct(User $user, Tagihan $tagihan)
    {
        $this->user = $user;
        $this->tagihan = $tagihan;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [];
    }
}