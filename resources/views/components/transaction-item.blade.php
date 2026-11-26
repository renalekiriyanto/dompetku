@props([
    'description',
    'category',
    'date',
    'wallet',
    'amount',
    'type' => 'expense', // income | expense | transfer
    'icon' => null,
])

@php
    $isIncome = $type === 'income';
    $isTransfer = $type === 'transfer';

    $resolvedIcon = $icon ?? match ($type) {
        'income' => 'bi-arrow-down-left',
        'transfer' => 'bi-arrow-left-right',
        default => 'bi-arrow-up-right',
    };

    $chipClass = match ($type) {
        'income' => 'icon-chip-emerald',
        'transfer' => 'icon-chip-info',
        default => 'icon-chip-danger',
    };

    $amountClass = match ($type) {
        'income' => 'text-emerald',
        'transfer' => 'text-secondary',
        default => 'text-dark',
    };

    $prefix = match ($type) {
        'income' => '+ ',
        'expense' => '- ',
        default => '',
    };
@endphp

<div {{ $attributes->merge(['class' => 'transaction-item d-flex align-items-start align-items-sm-center justify-content-between gap-2 gap-sm-3 py-3']) }}>
    <div class="d-flex align-items-start align-items-sm-center gap-2 gap-sm-3 min-w-0">
        <span class="icon-chip {{ $chipClass }} flex-shrink-0">
            <i class="bi {{ $resolvedIcon }}"></i>
        </span>
        <div class="min-w-0">
            <div class="fw-medium text-dark text-break lh-sm mb-1">{{ $description }}</div>
            <div class="d-flex flex-wrap align-items-center gap-1 gap-sm-2 text-muted" style="font-size: 0.78rem;">
                <span>{{ $category }}</span>
                <span aria-hidden="true">&bull;</span>
                <span>{{ $wallet }}</span>
                <span aria-hidden="true">&bull;</span>
                <span>{{ $date }}</span>
            </div>
        </div>
    </div>

    <div class="text-end flex-shrink-0">
        <div class="fw-semibold tabular-nums {{ $amountClass }}">
            {{ $prefix }}{{ $amount }}
        </div>
        <span class="badge rounded-pill text-capitalize fw-normal {{ $isIncome ? 'bg-emerald-soft text-emerald' : ($isTransfer ? 'bg-info-soft text-info-emphasis' : 'bg-light text-muted border') }}" style="font-size: 0.7rem;">
            {{ $type }}
        </span>
    </div>
</div>
