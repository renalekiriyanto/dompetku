@props([
    'title',
    'subtitle' => null,
])

<div {{ $attributes->merge(['class' => 'page-header d-flex flex-column flex-sm-row align-items-sm-center justify-content-between gap-3 mb-4']) }}>
    <div>
        <h1 class="h4 fw-bold text-dark mb-1">{{ $title }}</h1>
        @if ($subtitle)
            <p class="text-muted small mb-0">{{ $subtitle }}</p>
        @endif
    </div>

    @if (trim($slot) !== '')
        <div class="d-flex flex-wrap align-items-center gap-2">
            {{ $slot }}
        </div>
    @endif
</div>
