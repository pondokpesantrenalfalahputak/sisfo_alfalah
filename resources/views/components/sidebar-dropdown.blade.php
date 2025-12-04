@props(['icon', 'activeOn', 'currentRoute'])

@php
    // Memanggil method isActive dari kelas komponen untuk menentukan status aktif
    $isActive = $isActive(); 
    $baseClasses = 'flex items-center space-x-4 p-3 rounded-xl transition-all w-full text-left relative text-blue-200 hover:bg-blue-800 hover:text-white';
    $activeClasses = 'bg-amber-400 text-blue-900 font-bold active hover:bg-amber-500 hover:text-blue-900';
    // Menentukan apakah dropdown harus terbuka saat dimuat (jika aktif)
    $isOpen = $isActive ? 'true' : 'false';
@endphp

<div x-data="{ open: {{ $isOpen }} }">
    {{-- Tombol Utama Dropdown --}}
    <button @click="open = !open" 
            class="{{ $baseClasses }} {{ $isActive ? $activeClasses : '' }}"
            aria-expanded="open"
            :class="{ 'mb-2': open }"
    >
        <i class="{{ $icon }} w-5 h-5 flex-shrink-0"></i>
        <span class="truncate flex-grow font-semibold">{{ $slot }}</span>
        {{-- Ikon panah --}}
        <i class="fas fa-chevron-right w-4 h-4 transition-transform duration-200" :class="{ 'rotate-90': open }"></i>
    </button>

    {{-- Sub-menu --}}
    {{-- Menggunakan class padding dan border agar terlihat sub-item --}}
    <div x-show="open" 
         x-cloak 
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 transform translate-y-[-10px]"
         x-transition:enter-end="opacity-100 transform translate-y-0"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100 transform translate-y-0"
         x-transition:leave-end="opacity-0 transform translate-y-[-10px]"
         class="ml-6 py-2 border-l border-blue-700 space-y-1"
    >
        {{ $subitems }}
    </div>
</div>