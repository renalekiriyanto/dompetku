@extends('layouts.guest')

@section('title', 'Create Account')

@section('content')
    <div class="card app-card auth-card">
        <div class="card-body p-3 p-sm-4">
            <x-auth.brand-header
                heading="Create your account"
                subheading="Start tracking your wallets, income, and expenses with Dompetku."
            />

            <x-auth.status-alert />

            <form method="POST" action="{{ route('register.store') }}" data-auth-form>
                @csrf

                <div class="mb-3">
                    <label for="name" class="form-label small fw-medium text-dark mb-1">Full name</label>
                    <input
                        type="text"
                        id="name"
                        name="name"
                        value="{{ old('name') }}"
                        class="form-control @error('name') is-invalid @enderror"
                        autocomplete="name"
                        enterkeyhint="next"
                        placeholder="Budi Santoso"
                        required
                        @error('name')
                            aria-invalid="true"
                            aria-describedby="name-error"
                        @enderror
                    >
                    @error('name')
                        <div id="name-error" class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label small fw-medium text-dark mb-1">Email address</label>
                    <input
                        type="email"
                        id="email"
                        name="email"
                        value="{{ old('email') }}"
                        class="form-control @error('email') is-invalid @enderror"
                        autocomplete="username"
                        autocapitalize="none"
                        spellcheck="false"
                        enterkeyhint="next"
                        placeholder="name@example.com"
                        required
                        @error('email')
                            aria-invalid="true"
                            aria-describedby="email-error"
                        @enderror
                    >
                    @error('email')
                        <div id="email-error" class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <x-auth.password-input
                    id="password"
                    name="password"
                    label="Password"
                    autocomplete="new-password"
                    enterkeyhint="next"
                    minlength="8"
                    hint="Use at least 8 characters."
                    placeholder="Create a password"
                />

                <x-auth.password-input
                    id="password_confirmation"
                    name="password_confirmation"
                    label="Confirm password"
                    autocomplete="new-password"
                    enterkeyhint="done"
                    minlength="8"
                    placeholder="Re-enter your password"
                />

                <button type="submit" class="btn btn-emerald w-100 auth-submit-btn">
                    Create Account
                </button>
            </form>

            <div class="auth-divider my-3 text-muted small">
                <span>or</span>
            </div>

            <x-auth.google-button label="Sign up with Google" />

            <p class="text-center text-muted small mt-4 mb-0">
                Already have an account?
                <a href="{{ route('login') }}" class="text-emerald fw-semibold text-decoration-none">
                    Sign in
                </a>
            </p>
        </div>
    </div>
@endsection
