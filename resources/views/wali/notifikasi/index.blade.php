@extends('layouts.wali')

@section('title', 'Notifikasi Anda')

@section('content')
<div class="container py-4">
    <h2 class="mb-4">Notifikasi Terbaru Anda</h2>
    
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    {{-- Memanggil variabel notifikasis dari Controller --}}
    @if($notifikasis->isEmpty())
        <div class="alert alert-info">
            Anda tidak memiliki notifikasi baru saat ini.
        </div>
    @else
        <div class="list-group">
            @foreach($notifikasis as $notifikasi)
                <a href="{{ $notifikasi->link ?? '#' }}" 
                   class="list-group-item list-group-item-action 
                   @if(!$notifikasi->is_read) list-group-item-light fw-bold shadow-sm @endif"
                   onclick="event.preventDefault(); document.getElementById('read-form-{{ $notifikasi->id }}').submit();">
                    
                    <div class="d-flex w-100 justify-content-between">
                        <h5 class="mb-1">
                            {{ $notifikasi->title }}
                        </h5>
                        <small class="@if(!$notifikasi->is_read) text-primary @else text-muted @endif">
                            {{ $notifikasi->created_at->diffForHumans() }}
                        </small>
                    </div>
                    
                    <p class="mb-1 text-truncate text-secondary">{{ $notifikasi->body }}</p>
                    
                    @if(!$notifikasi->is_read)
                        <small class="text-danger fw-bold">Belum Dibaca</small>
                    @else
                        <small class="text-success">Dibaca</small>
                    @endif
                </a>
                
                {{-- Form untuk menandai sudah dibaca --}}
                <form id="read-form-{{ $notifikasi->id }}" 
                      action="{{ route('wali.notifikasi.mark_read', $notifikasi->id) }}" 
                      method="POST" style="display: none;">
                    @csrf
                </form>

            @endforeach
        </div>
        
        <div class="mt-4">
            {{ $notifikasis->links() }}
        </div>
        
        {{-- Tombol tandai semua sudah dibaca (Opsional) --}}
        <form action="{{ route('wali.notifikasi.mark_all_read') }}" method="POST" class="mt-3">
            @csrf
            <button type="submit" class="btn btn-primary btn-sm">
                Tandai Semua Sudah Dibaca
            </button>
        </form>
    @endif
</div>
@endsection