@props([
    'label' => 'Continue with Google',
])

<a
    href="{{ route('auth.google.redirect') }}"
    class="btn btn-light border w-100 d-inline-flex align-items-center justify-content-center gap-2 auth-google-btn"
>
    <svg width="18" height="18" viewBox="0 0 24 24" aria-hidden="true">
        <path fill="#EA4335" d="M12 10.2v3.9h5.4c-.2 1.3-1.5 3.9-5.4 3.9-3.3 0-6-2.7-6-6s2.7-6 6-6c1.9 0 3.1.8 3.8 1.5l2.6-2.5C16.7 3.4 14.6 2.5 12 2.5 6.8 2.5 2.5 6.8 2.5 12s4.3 9.5 9.5 9.5c5.5 0 9.1-3.9 9.1-9.3 0-.6-.1-1.1-.2-1.6H12z"/>
        <path fill="#34A853" d="M3.7 7.6l3.2 2.3C7.8 8 9.7 6.8 12 6.8c1.9 0 3.1.8 3.8 1.5l2.6-2.5C16.7 3.4 14.6 2.5 12 2.5 8.2 2.5 4.9 4.7 3.7 7.6z"/>
        <path fill="#FBBC05" d="M12 21.5c2.5 0 4.6-.8 6.1-2.3l-2.8-2.3c-.8.5-1.8.9-3.3.9-2.6 0-4.8-1.7-5.6-4.1l-3.2 2.5C4.5 19.3 8 21.5 12 21.5z"/>
        <path fill="#4285F4" d="M21.1 12.2c0-.6-.1-1.1-.2-1.6H12v3.9h5.4c-.3 1.3-1.1 2.4-2.1 3l2.8 2.3c1.7-1.5 3-3.9 3-7.6z"/>
    </svg>
    <span>{{ $label }}</span>
</a>
