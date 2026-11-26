@props([
    'name',
    'type',
    'balance',
    'icon' => 'bi-wallet2',
    'accent' => 'emerald', // emerald | primary | info | dark
    'accountHint' => null,
    'showActions' => false,
])

@php
    $chipClass = match ($accent) {
        'primary' => 'icon-chip-primary',
        'info' => 'icon-chip-info',
        'dark' => 'icon-chip-neutral',
        default => 'icon-chip-emerald',
    };
@endphp

<div {{ $attributes->merge(['class' => 'card app-card wallet-card h-100']) }}>
    <div class="card-body p-3 p-sm-4 d-flex flex-column justify-content-between gap-3">
        <div class="d-flex align-items-start justify-content-between gap-2">
            <div class="d-flex align-items-center gap-3 min-w-0">
                <span class="icon-chip {{ $chipClass }} flex-shrink-0">
                    <i class="bi {{ $icon }} fs-5"></i>
                </span>
                <div class="min-w-0">
                    <div class="fw-semibold text-dark text-truncate">{{ $name }}</div>
                    <div class="text-muted small">{{ $type }}</div>
                </div>
            </div>

            @if ($showActions)
                <div class="dropdown">
                    <button
                        class="btn btn-sm btn-icon-subtle"
                        type="button"
                        data-bs-toggle="dropdown"
                        aria-expanded="false"
                        aria-label="Wallet actions for {{ $name }}"
                    >
                        <i class="bi bi-three-dots-vertical"></i>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end shadow-sm border app-dropdown-menu">
                        <li>
                            <button
                                type="button"
                                class="dropdown-item d-flex align-items-center gap-2"
                                data-bs-toggle="modal"
                                data-bs-target="#walletModal"
                                data-wallet-modal-title="Edit Wallet — {{ $name }}"
                            >
                                <i class="bi bi-pencil text-muted"></i>
                                <span>Edit Wallet</span>
                            </button>
                        </li>
                        <li>
                            <button
                                type="button"
                                class="dropdown-item d-flex align-items-center gap-2 text-danger"
                                data-bs-toggle="modal"
                                data-bs-target="#deleteWalletModal"
                                data-wallet-name="{{ $name }}"
                            >
                                <i class="bi bi-trash"></i>
                                <span>Delete Wallet</span>
                            </button>
                        </li>
                    </ul>
                </div>
            @endif
        </div>

        <div class="pt-2 border-top d-flex flex-wrap align-items-end justify-content-between gap-2">
            <div class="min-w-0">
                <div class="text-muted" style="font-size: 0.72rem;">Current Balance</div>
                <div
                    class="fs-5 fw-bold text-dark tabular-nums"
                    data-balance-value="{{ $balance }}"
                    data-balance-mask="Rp ••••••••"
                >
                    {{ $balance }}
                </div>
            </div>
            @if ($accountHint)
                <span class="badge bg-light text-muted border fw-normal flex-shrink-0">{{ $accountHint }}</span>
            @endif
        </div>
    </div>
</div>
