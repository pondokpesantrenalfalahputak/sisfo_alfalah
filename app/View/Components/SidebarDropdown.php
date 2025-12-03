<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\Support\Str;

class SidebarDropdown extends Component
{
    public $icon;
    public $activeOn;
    public $currentRoute;

    public function __construct($icon, $activeOn = [], $currentRoute)
    {
        $this->icon = $icon;
        $this->activeOn = is_array($activeOn) ? $activeOn : [$activeOn];
        $this->currentRoute = $currentRoute;
    }

    /**
     * Tentukan apakah dropdown saat ini aktif (dibuka otomatis).
     */
    public function isActive()
    {
        // Cek apakah rute saat ini cocok dengan salah satu pola 'activeOn'
        foreach ($this->activeOn as $pattern) {
            if (Str::is($pattern, $this->currentRoute)) {
                return true;
            }
        }
        return false;
    }

    public function render()
    {
        return view('components.sidebar-dropdown');
    }
}