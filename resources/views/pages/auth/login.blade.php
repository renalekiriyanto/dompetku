@extends('layouts.guest')

@section('title', 'Sign In')

@section('content')
    <div class="card app-card auth-card">
        <div class="card-body p-3 p-sm-4">
            <x-auth.brand-header
                heading="Welcome back"
                subheading="Sign in to view your wallets, budgets, and transactions."
            />

            <x-auth.status-alert />

            <form method="POST" action="{{ route('login.store') }}" data-auth-form>
                @csrf

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
                    autocomplete="current-password"
                    enterkeyhint="done"
                    placeholder="Enter your password"
                >
                    <x-slot:labelAside>
                        <span class="text-muted" style="font-size: 0.78rem;" title="Password reset is not implemented yet">
                            Forgot password? (Coming soon)
                        </span>
                    </x-slot:labelAside>
                </x-auth.password-input>

                <div class="form-check mb-3">
                    <input
                        class="form-check-input"
                        type="checkbox"
                        id="remember"
                        name="remember"
                        value="1"
                        @checked(old('remember'))
                    >
                    <label class="form-check-label small text-muted" for="remember">
                        Remember me
                    </label>
                </div>

                <button type="submit" class="btn btn-emerald w-100 auth-submit-btn">
                    Sign In
                </button>
            </form>

            <div class="auth-divider my-3 text-muted small">
                <span>or</span>
            </div>

            <x-auth.google-button label="Continue with Google" />

            <p class="text-center text-muted small mt-4 mb-0">
                Don't have an account?
                <a href="{{ route('register') }}" class="text-emerald fw-semibold text-decoration-none">
                    Create an account
                </a>
            </p>
        </div>
    </div>
@endsection
