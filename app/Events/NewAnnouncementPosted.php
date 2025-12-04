<?php

namespace App\Events;

use App\Models\User;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class NewAnnouncementPosted
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $user; // Wali Santri (Penerima)
    public $pengumuman;

    public function __construct(User $user, \App\Models\Pengumuman $pengumuman)
    {
        $this->user = $user;
        $this->pengumuman = $pengumuman;
    }
}