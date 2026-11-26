@extends('layouts.app')

@section('title', 'Settings')
@section('page-title', 'Settings')

@section('content')
    <x-page-header
        title="Settings"
        subtitle="Manage your profile, preferences, and future integration placeholders."
    />

    <div class="row g-4">
        <div class="col-12 col-lg-8 d-flex flex-column gap-4">
            {{-- Profile --}}
            <section class="card app-card" aria-labelledby="settingsProfileHeading">
                <div class="card-body p-3 p-sm-4">
                    <h2 class="h6 fw-bold text-dark mb-1" id="settingsProfileHeading">Profile</h2>
                    <p class="text-muted small mb-3">Basic personal account details.</p>

                    <form onsubmit="return false;">
                        <div class="row g-3">
                            <div class="col-12 col-sm-6">
                                <label for="profileName" class="form-label small fw-medium">Full Name</label>
                                <input type="text" id="profileName" class="form-control" value="{{ auth()->user()?->name ?? 'Budi Santoso' }}">
                            </div>
                            <div class="col-12 col-sm-6">
                                <label for="profileEmail" class="form-label small fw-medium">Email Address</label>
                                <input type="email" id="profileEmail" class="form-control" value="{{ auth()->user()?->email ?? 'budi@dompetku.id' }}">
                            </div>
                            <div class="col-12 col-sm-6">
                                <label for="profileCurrency" class="form-label small fw-medium">Display Currency</label>
                                <select id="profileCurrency" class="form-select">
                                    <option value="IDR" selected>IDR — Indonesian Rupiah (Rp)</option>
                                    <option value="USD">USD — US Dollar ($)</option>
                                </select>
                            </div>
                        </div>
                        <div class="mt-3 pt-2">
                            <button type="button" class="btn btn-sm btn-emerald">Save Profile (UI Placeholder)</button>
                        </div>
                    </form>
                </div>
            </section>

            {{-- Appearance & Default Wallet --}}
            <section class="card app-card" aria-labelledby="settingsAppearanceHeading">
                <div class="card-body p-3 p-sm-4">
                    <h2 class="h6 fw-bold text-dark mb-1" id="settingsAppearanceHeading">Appearance &amp; Default Wallet</h2>
                    <p class="text-muted small mb-3">Customize your workspace look and default transaction source.</p>

                    <div class="row g-3">
                        <div class="col-12 col-sm-6">
                            <label for="appearanceTheme" class="form-label small fw-medium">Theme</label>
                            <select id="appearanceTheme" class="form-select">
                                <option value="light" selected>Light (Minimalist Default)</option>
                                <option value="system">System Preference (Phase 2)</option>
                            </select>
                        </div>
                        <div class="col-12 col-sm-6">
                            <label for="defaultWallet" class="form-label small fw-medium">Default Wallet</label>
                            <select id="defaultWallet" class="form-select">
                                <option value="cash">Cash</option>
                                <option value="bca" selected>BCA (Bank Account)</option>
                                <option value="dana">DANA (E-Wallet)</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-check form-switch mt-3">
                        <input class="form-check-input" type="checkbox" role="switch" id="compactModeSwitch">
                        <label class="form-check-label small" for="compactModeSwitch">
                            Use compact transaction list density
                        </label>
                    </div>
                </div>
            </section>

            {{-- Integrations (Placeholders Only) --}}
            <section class="card app-card" aria-labelledby="settingsIntegrationsHeading">
                <div class="card-body p-3 p-sm-4">
                    <h2 class="h6 fw-bold text-dark mb-1" id="settingsIntegrationsHeading">Integrations</h2>
                    <p class="text-muted small mb-3">External services planned for later phases (UI placeholders only).</p>

                    <div class="d-flex flex-column gap-3">
                        {{-- Google Drive Integration Placeholder --}}
                        <div class="p-3 border rounded-3 d-flex flex-column flex-sm-row align-items-sm-center justify-content-between gap-3">
                            <div class="d-flex align-items-start gap-3">
                                <span class="icon-chip icon-chip-primary flex-shrink-0">
                                    <i class="bi bi-cloud-arrow-up fs-5"></i>
                                </span>
                                <div class="min-w-0">
                                    <div class="d-flex flex-wrap align-items-center gap-2">
                                        <span class="fw-semibold small text-dark">Google Drive Integration</span>
                                        <span class="badge bg-light text-muted border fw-normal">Not Connected</span>
                                    </div>
                                    <div class="text-muted small">Backup receipts and monthly exports automatically to Google Drive.</div>
                                </div>
                            </div>
                            <button type="button" class="btn btn-sm btn-light border flex-shrink-0" disabled>
                                Connect (Soon)
                            </button>
                        </div>

                        {{-- Telegram Integration Placeholder --}}
                        <div class="p-3 border rounded-3 d-flex flex-column flex-sm-row align-items-sm-center justify-content-between gap-3">
                            <div class="d-flex align-items-start gap-3">
                                <span class="icon-chip icon-chip-info flex-shrink-0">
                                    <i class="bi bi-telegram fs-5"></i>
                                </span>
                                <div class="min-w-0">
                                    <div class="d-flex flex-wrap align-items-center gap-2">
                                        <span class="fw-semibold small text-dark">Telegram Integration</span>
                                        <span class="badge bg-light text-muted border fw-normal">Not Connected</span>
                                    </div>
                                    <div class="text-muted small">Record quick expenses and receive daily summaries via Telegram bot.</div>
                                </div>
                            </div>
                            <button type="button" class="btn btn-sm btn-light border flex-shrink-0" disabled>
                                Connect (Soon)
                            </button>
                        </div>
                    </div>
                </div>
            </section>
        </div>

        {{-- Right Column: Security --}}
        <div class="col-12 col-lg-4">
            <section class="card app-card" aria-labelledby="settingsSecurityHeading">
                <div class="card-body p-3 p-sm-4">
                    <div class="d-flex align-items-center gap-2 mb-2">
                        <span class="icon-chip icon-chip-emerald">
                            <i class="bi bi-shield-check"></i>
                        </span>
                        <div>
                            <h2 class="h6 fw-bold text-dark mb-0" id="settingsSecurityHeading">Security</h2>
                            <span class="text-muted" style="font-size: 0.78rem;">Access &amp; privacy controls</span>
                        </div>
                    </div>

                    <div class="d-flex flex-column gap-3 mt-3">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" role="switch" id="hideBalancesDefault">
                            <label class="form-check-label small" for="hideBalancesDefault">
                                Mask wallet balances on startup
                            </label>
                        </div>

                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" role="switch" id="twoFactorPlaceholder" disabled>
                            <label class="form-check-label small text-muted" for="twoFactorPlaceholder">
                                Two-factor authentication (Phase 2)
                            </label>
                        </div>

                        <hr class="my-1">

                        <button type="button" class="btn btn-sm btn-light border w-100" disabled>
                            <i class="bi bi-key me-1"></i> Change Password (Phase 2)
                        </button>
                    </div>
                </div>
            </section>
        </div>
    </div>
@endsection
