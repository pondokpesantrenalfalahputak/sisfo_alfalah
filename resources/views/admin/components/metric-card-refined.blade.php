{{-- resources/views/admin/components/metric-card-refined.blade.php --}}

<div class="card dashboard-card {{ $bg_class ?? 'bg-secondary text-white' }} shadow-soft h-100 hover-shadow">
    {{-- Tambahkan kelas metric-card-body untuk penyesuaian padding di mobile --}}
    <div class="card-body p-4 metric-card-body">
        <div class="d-flex align-items-center justify-content-between">
            <div>
                <div class="small-text opacity-75 mb-1 text-uppercase fw-semibold">{{ $title }}</div>
                <h4 class="metric-card-text mb-0">{{ $value }}</h4>
            </div>
            <i class="{{ $icon ?? 'fas fa-info-circle' }} fs-1 opacity-75"></i>
        </div>
    </div>
</div>