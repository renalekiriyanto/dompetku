@props([
    'title',
    'amount',
    'icon' => 'bi-cash-stack',
    'tone' => 'neutral', // emerald | danger | neutral
    'subtitle' => null,
    'maskable' => false,
])

@php
    $chipClass = match ($tone) {
        'emerald' => 'icon-chip-emerald',
        'danger' => 'icon-chip-danger',
        default => 'icon-chip-neutral',
    };

    $amountClass = match ($tone) {
        'emerald' => 'text-emerald',
        'danger' => 'text-danger-soft',
        default => 'text-dark',
    };
@endphp

<div {{ $attributes->merge(['class' => 'card app-card h-100']) }}>
    <div class="card-body p-3 p-sm-4">
        <div class="d-flex align-items-start justify-content-between gap-3">
            <div class="min-w-0">
                <div class="text-muted small fw-medium mb-1">{{ $title }}</div>
                <div
                    class="summary-card-amount fw-bold tabular-nums {{ $amountClass }} mb-1"
                    @if($maskable) data-balance-value="{{ $amount }}" data-balance-mask="Rp ••••••••" @endif
                >
                    {{ $amount }}
                </div>
                @if ($subtitle)
                    <div class="text-muted" style="font-size: 0.78rem;">{{ $subtitle }}</div>
                @endif
            </div>
            <span class="icon-chip {{ $chipClass }} flex-shrink-0">
                <i class="bi {{ $icon }} fs-5"></i>
            </span>
        </div>
    </div>
</div>
