@props([
    'icon' => 'bi-inbox',
    'title' => 'Nothing here yet',
    'description' => 'There are no items matching your current view.',
    'actionLabel' => null,
    'actionUrl' => null,
])

<div {{ $attributes->merge(['class' => 'empty-state text-center py-5 px-3']) }}>
    <span class="icon-chip icon-chip-neutral icon-chip-lg mx-auto mb-3">
        <i class="bi {{ $icon }} fs-4"></i>
    </span>
    <h3 class="h6 fw-semibold text-dark mb-1">{{ $title }}</h3>
    <p class="text-muted small mx-auto mb-3" style="max-width: 340px;">
        {{ $description }}
    </p>

    @if ($actionLabel && $actionUrl)
        <a href="{{ $actionUrl }}" class="btn btn-sm btn-emerald">
            {{ $actionLabel }}
        </a>
    @elseif (trim($slot) !== '')
        <div>{{ $slot }}</div>
    @endif
</div>
