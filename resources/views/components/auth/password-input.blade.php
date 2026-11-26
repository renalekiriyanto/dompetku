@props([
    'id',
    'name',
    'label',
    'autocomplete' => 'current-password',
    'enterkeyhint' => 'done',
    'minlength' => null,
    'hint' => null,
    'placeholder' => 'Enter your password',
])

@php
    $hasError = $errors->has($name);
    $hintId = $hint ? $id . '-hint' : null;
    $errorId = $hasError ? $id . '-error' : null;
    $describedBy = collect([$hintId, $errorId])->filter()->implode(' ');
@endphp

<div class="mb-3">
    <div class="d-flex flex-wrap align-items-center justify-content-between gap-2 mb-1">
        <label for="{{ $id }}" class="form-label small fw-medium text-dark mb-0">{{ $label }}</label>
        @isset($labelAside)
            {{ $labelAside }}
        @endisset
    </div>

    @if ($hint)
        <p id="{{ $hintId }}" class="text-muted mb-1" style="font-size: 0.78rem;">{{ $hint }}</p>
    @endif

    <div class="input-group has-validation">
        <input
            type="password"
            id="{{ $id }}"
            name="{{ $name }}"
            class="form-control @if($hasError) is-invalid @endif"
            autocomplete="{{ $autocomplete }}"
            enterkeyhint="{{ $enterkeyhint }}"
            placeholder="{{ $placeholder }}"
            @if ($minlength) minlength="{{ $minlength }}" @endif
            required
            @if ($hasError) aria-invalid="true" @endif
            @if ($describedBy !== '') aria-describedby="{{ $describedBy }}" @endif
        >
        <button
            type="button"
            class="btn btn-outline-secondary password-toggle-btn"
            data-password-toggle
            data-target="{{ $id }}"
            data-label-show="Show {{ strtolower($label) }}"
            data-label-hide="Hide {{ strtolower($label) }}"
            aria-pressed="false"
            aria-label="Show {{ strtolower($label) }}"
        >
            <i class="bi bi-eye" aria-hidden="true"></i>
        </button>

        @if ($hasError)
            <div id="{{ $errorId }}" class="invalid-feedback">
                {{ $errors->first($name) }}
            </div>
        @endif
    </div>
</div>
