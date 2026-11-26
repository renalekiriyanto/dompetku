@props([
    'title' => 'Dashboard',
])

<header class="app-topbar sticky-top bg-white border-bottom">
    <div class="container-fluid app-container d-flex align-items-center justify-content-between py-2 py-lg-3 px-3 px-lg-4">
        {{-- Mobile Brand + Title / Desktop Page Title --}}
        <div class="d-flex align-items-center gap-2 min-w-0">
            <a href="{{ route('dashboard') }}" class="d-inline-flex d-lg-none align-items-center justify-content-center brand-mark brand-mark-sm rounded-3 text-decoration-none flex-shrink-0" aria-label="Dompetku Home">
                <i class="bi bi-wallet2"></i>
            </a>
            <div class="min-w-0">
                <span class="d-block d-lg-none text-muted text-uppercase fw-semibold" style="font-size: 0.65rem; letter-spacing: 0.06em;">Dompetku</span>
                <span class="d-block fw-semibold text-dark text-truncate topbar-title">{{ $title }}</span>
            </div>
        </div>

        {{-- Right Actions --}}
        <div class="d-flex align-items-center gap-2">
            {{-- Quick Add Shortcut --}}
            <a href="{{ route('transactions.index') }}" class="btn btn-sm btn-emerald d-none d-sm-inline-flex align-items-center gap-1">
                <i class="bi bi-plus-lg"></i>
                <span>Record</span>
            </a>

            {{-- Notifications Dropdown --}}
            <div class="dropdown">
                <button
                    class="btn btn-icon-subtle position-relative"
                    type="button"
                    data-bs-toggle="dropdown"
                    aria-expanded="false"
                    aria-label="Notifications"
                >
                    <i class="bi bi-bell"></i>
                    <span class="position-absolute top-0 start-100 translate-middle p-1 bg-emerald rounded-circle border border-white" style="margin-top: 6px; margin-left: -6px;">
                        <span class="visually-hidden">New notifications</span>
                    </span>
                </button>
                <div class="dropdown-menu dropdown-menu-end shadow-sm border app-dropdown-menu p-0">
                    <div class="px-3 py-2 border-bottom d-flex justify-content-between align-items-center">
                        <span class="fw-semibold small">Notifications</span>
                        <span class="badge bg-emerald-soft text-emerald">2 new</span>
                    </div>
                    <div class="p-2">
                        <div class="dropdown-item rounded-2 py-2 px-2 text-wrap">
                            <div class="small fw-medium text-dark">Monthly budget check</div>
                            <div class="text-muted" style="font-size: 0.75rem;">You have spent 51% of this month's income.</div>
                        </div>
                        <div class="dropdown-item rounded-2 py-2 px-2 text-wrap">
                            <div class="small fw-medium text-dark">UI template mode</div>
                            <div class="text-muted" style="font-size: 0.75rem;">Connect your database in Phase 2 to sync live data.</div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- User Menu Dropdown --}}
            <div class="dropdown">
                <button
                    class="btn btn-light btn-sm d-flex align-items-center gap-2 border rounded-pill ps-1 pe-2 py-1"
                    type="button"
                    data-bs-toggle="dropdown"
                    aria-expanded="false"
                    aria-label="Account menu"
                >
                    <span class="avatar-circle avatar-circle-sm d-inline-flex align-items-center justify-content-center fw-semibold">
                        {{ auth()->user()?->initials() ?? 'U' }}
                    </span>
                    <span class="d-none d-md-inline small fw-medium text-dark">{{ auth()->user()?->firstName() ?? 'Account' }}</span>
                    <i class="bi bi-chevron-down small text-muted d-none d-md-inline" aria-hidden="true"></i>
                </button>
                <ul class="dropdown-menu dropdown-menu-end shadow-sm border app-dropdown-menu">
                    <li class="px-3 py-2 border-bottom">
                        <div class="fw-semibold small text-dark text-truncate">{{ auth()->user()?->name ?? 'User' }}</div>
                        <div class="text-muted text-truncate" style="font-size: 0.75rem;">{{ auth()->user()?->email ?? 'Personal Workspace' }}</div>
                    </li>
                    <li>
                        <a class="dropdown-item d-flex align-items-center gap-2 py-2" href="{{ route('settings.index') }}">
                            <i class="bi bi-person text-muted" aria-hidden="true"></i>
                            <span>Profile &amp; Settings</span>
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item d-flex align-items-center gap-2 py-2" href="{{ route('wallets.index') }}">
                            <i class="bi bi-wallet2 text-muted" aria-hidden="true"></i>
                            <span>Manage Wallets</span>
                        </a>
                    </li>
                    <li><hr class="dropdown-divider my-1"></li>
                    <li>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="dropdown-item d-flex align-items-center gap-2 py-2 text-danger">
                                <i class="bi bi-box-arrow-right" aria-hidden="true"></i>
                                <span>Sign Out</span>
                            </button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</header>
