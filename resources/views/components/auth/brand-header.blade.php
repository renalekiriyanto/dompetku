@props([
    'heading',
    'subheading',
])

<div class="text-center mb-4">
    <div class="d-inline-flex align-items-center gap-2 mb-3">
        <span class="brand-mark d-inline-flex align-items-center justify-content-center rounded-3">
            <i class="bi bi-wallet2 fs-5" aria-hidden="true"></i>
        </span>
        <div class="text-start">
            <span class="d-block fw-bold text-dark lh-sm">Dompetku</span>
            <small class="text-muted d-block" style="font-size: 0.72rem;">Personal Finance</small>
        </div>
    </div>

    <h1 class="h4 fw-bold text-dark mb-1">{{ $heading }}</h1>
    <p class="text-muted small mb-0">{{ $subheading }}</p>
</div>
