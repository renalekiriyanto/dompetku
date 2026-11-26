@php
    $navItems = [
        [
            'label' => 'Dashboard',
            'route' => 'dashboard',
            'pattern' => 'dashboard',
            'icon' => 'bi-grid',
            'iconActive' => 'bi-grid-fill',
        ],
        [
            'label' => 'Transactions',
            'route' => 'transactions.index',
            'pattern' => 'transactions.*',
            'icon' => 'bi-arrow-left-right',
            'iconActive' => 'bi-arrow-left-right',
        ],
        [
            'label' => 'Wallets',
            'route' => 'wallets.index',
            'pattern' => 'wallets.*',
            'icon' => 'bi-wallet2',
            'iconActive' => 'bi-wallet-fill',
        ],
        [
            'label' => 'Categories',
            'route' => 'categories.index',
            'pattern' => 'categories.*',
            'icon' => 'bi-tags',
            'iconActive' => 'bi-tags-fill',
        ],
        [
            'label' => 'Reports',
            'route' => 'reports.index',
            'pattern' => 'reports.*',
            'icon' => 'bi-bar-chart-line',
            'iconActive' => 'bi-bar-chart-line-fill',
        ],
        [
            'label' => 'Settings',
            'route' => 'settings.index',
            'pattern' => 'settings.*',
            'icon' => 'bi-gear',
            'iconActive' => 'bi-gear-fill',
        ],
    ];
@endphp

<aside class="app-sidebar d-none d-lg-flex flex-column bg-white border-end" aria-label="Main navigation">
    {{-- Brand --}}
    <div class="sidebar-brand d-flex align-items-center gap-2 px-4 py-3 border-bottom">
        <a href="{{ route('dashboard') }}" class="d-flex align-items-center gap-2 text-decoration-none">
            <span class="brand-mark d-inline-flex align-items-center justify-content-center rounded-3">
                <i class="bi bi-wallet2 fs-5"></i>
            </span>
            <div>
                <span class="d-block fw-bold text-dark lh-sm">Dompetku</span>
                <small class="text-muted d-block" style="font-size: 0.72rem;">Personal Finance</small>
            </div>
        </a>
    </div>

    {{-- Navigation Links --}}
    <nav class="sidebar-nav flex-grow-1 px-3 py-3">
        <ul class="nav flex-column gap-1">
            @foreach ($navItems as $item)
                @php
                    $isActive = request()->routeIs($item['pattern']);
                @endphp
                <li class="nav-item">
                    <a
                        href="{{ route($item['route']) }}"
                        class="nav-link sidebar-link d-flex align-items-center gap-3 px-3 py-2 rounded-3 {{ $isActive ? 'active' : '' }}"
                        @if($isActive) aria-current="page" @endif
                    >
                        <i class="bi {{ $isActive ? $item['iconActive'] : $item['icon'] }} fs-5"></i>
                        <span>{{ $item['label'] }}</span>
                    </a>
                </li>
            @endforeach
        </ul>
    </nav>

    {{-- User Profile Footer --}}
    <div class="sidebar-footer p-3 border-top">
        <a href="{{ route('settings.index') }}" class="d-flex align-items-center gap-2 p-2 rounded-3 text-decoration-none sidebar-user-card mb-2">
            <span class="avatar-circle d-inline-flex align-items-center justify-content-center fw-semibold">
                {{ auth()->user()?->initials() ?? 'U' }}
            </span>
            <div class="min-w-0 flex-grow-1">
                <div class="fw-semibold text-dark small text-truncate">{{ auth()->user()?->name ?? 'User' }}</div>
                <div class="text-muted text-truncate" style="font-size: 0.75rem;">{{ auth()->user()?->email ?? '' }}</div>
            </div>
            <i class="bi bi-chevron-right text-muted small" aria-hidden="true"></i>
        </a>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="btn btn-sm btn-light border w-100 d-flex align-items-center justify-content-center gap-2 text-muted">
                <i class="bi bi-box-arrow-right" aria-hidden="true"></i>
                <span>Sign Out</span>
            </button>
        </form>
    </div>
</aside>
