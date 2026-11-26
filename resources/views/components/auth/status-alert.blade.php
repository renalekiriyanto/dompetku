@if (session('status'))
    <div class="alert alert-success d-flex align-items-start gap-2 small py-2 px-3 mb-3" role="status">
        <i class="bi bi-check-circle-fill mt-1 flex-shrink-0" aria-hidden="true"></i>
        <div>{{ session('status') }}</div>
    </div>
@endif

@if ($errors->has('auth') || session('error'))
    <div class="alert alert-danger d-flex align-items-start gap-2 small py-2 px-3 mb-3" role="alert">
        <i class="bi bi-exclamation-circle-fill mt-1 flex-shrink-0" aria-hidden="true"></i>
        <div>{{ $errors->first('auth') ?: session('error') }}</div>
    </div>
@endif
