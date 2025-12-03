@props(['route', 'currentRoute', 'icon' => 'fas fa-circle', 'activeOn' => [], 'badge' => 0])

@php
    // Perbaikan: $route adalah URL string, bukan objek route
    $routeName = '';

    if (is_string($route)) {
        // Jika $route adalah URL string, ekstrak nama route dari URL
        $routeName = Route::currentRouteName(); // Fallback ke route saat ini
        // Atau gunakan pendekatan sederhana: bandingkan URL dengan request saat ini
        if (url()->current() === $route) {
            $routeName = $currentRoute;
        }
    } elseif (method_exists($route, 'getName')) {
        $routeName = $route->getName();
    }

    $isActive = $currentRoute === $routeName;

    // Cek apakah aktif berdasarkan pola (wildcard)
    if (!$isActive && is_array($activeOn)) {
        foreach ($activeOn as $pattern) {
            if (Str::is($pattern, $currentRoute)) {
                $isActive = true;
                break;
            }
        }
    }

    $baseClasses = 'flex items-center space-x-4 p-3 rounded-xl transition-all w-full text-left relative text-blue-200 hover:bg-blue-800 hover:text-white';
    $activeClasses = 'bg-amber-400 text-blue-900 font-bold active hover:bg-amber-500 hover:text-blue-900';
@endphp

<a href="{{ $route }}" class="{{ $baseClasses }} {{ $isActive ? $activeClasses : '' }}">
    <i class="{{ $icon }} w-5 h-5 flex-shrink-0"></i>
    <span class="truncate">{{ $slot }}</span>

    @if ($badge > 0)
        {{-- Badge Notifikasi --}}
        <span class="absolute right-3 top-1/2 transform -translate-y-1/2 inline-flex items-center justify-center px-2 py-0.5 text-xs font-semibold leading-none text-red-100 bg-red-600 rounded-full ml-3">
            {{ $badge }}
        </span>
    @endif
</a>
