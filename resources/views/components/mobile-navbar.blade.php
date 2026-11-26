@php
    $isMoreActive = request()->routeIs('categories.*', 'settings.*');
@endphp

<nav class="mobile-bottom-nav d-lg-none fixed-bottom bg-white border-top" aria-label="Mobile navigation">
    <div class="d-flex justify-content-around align-items-stretch h-100">
        <a
            href="{{ route('dashboard') }}"
            class="mobile-nav-item flex-fill d-flex flex-column align-items-center justify-content-center text-decoration-none {{ request()->routeIs('dashboard') ? 'active' : '' }}"
            @if(request()->routeIs('dashboard')) aria-current="page" @endif
        >
            <i class="bi {{ request()->routeIs('dashboard') ? 'bi-house-door-fill' : 'bi-house-door' }}"></i>
            <span>Home</span>
        </a>

        <a
            href="{{ route('transactions.index') }}"
            class="mobile-nav-item flex-fill d-flex flex-column align-items-center justify-content-center text-decoration-none {{ request()->routeIs('transactions.*') ? 'active' : '' }}"
            @if(request()->routeIs('transactions.*')) aria-current="page" @endif
        >
            <i class="bi bi-arrow-left-right"></i>
            <span>Transactions</span>
        </a>

        <a
            href="{{ route('wallets.index') }}"
            class="mobile-nav-item flex-fill d-flex flex-column align-items-center justify-content-center text-decoration-none {{ request()->routeIs('wallets.*') ? 'active' : '' }}"
            @if(request()->routeIs('wallets.*')) aria-current="page" @endif
        >
            <i class="bi {{ request()->routeIs('wallets.*') ? 'bi-wallet-fill' : 'bi-wallet2' }}"></i>
            <span>Wallets</span>
        </a>

        <a
            href="{{ route('reports.index') }}"
            class="mobile-nav-item flex-fill d-flex flex-column align-items-center justify-content-center text-decoration-none {{ request()->routeIs('reports.*') ? 'active' : '' }}"
            @if(request()->routeIs('reports.*')) aria-current="page" @endif
        >
            <i class="bi {{ request()->routeIs('reports.*') ? 'bi-bar-chart-line-fill' : 'bi-bar-chart-line' }}"></i>
            <span>Reports</span>
        </a>

        <button
            type="button"
            class="mobile-nav-item btn border-0 bg-transparent flex-fill d-flex flex-column align-items-center justify-content-center {{ $isMoreActive ? 'active' : '' }}"
            data-bs-toggle="offcanvas"
            data-bs-target="#mobileMoreOffcanvas"
            aria-controls="mobileMoreOffcanvas"
        >
            <i class="bi bi-grid"></i>
            <span>More</span>
        </button>
    </div>
</nav>

{{-- Mobile "More" Offcanvas Menu --}}
<div
    class="offcanvas offcanvas-bottom d-lg-none mobile-more-offcanvas"
    tabindex="-1"
    id="mobileMoreOffcanvas"
    aria-labelledby="mobileMoreOffcanvasLabel"
>
    <div class="offcanvas-header border-bottom pb-3">
        <div class="d-flex align-items-center gap-2">
            <span class="brand-mark brand-mark-sm d-inline-flex align-items-center justify-content-center rounded-3">
                <i class="bi bi-wallet2"></i>
            </span>
            <h2 class="offcanvas-title h6 mb-0 fw-semibold" id="mobileMoreOffcanvasLabel">More Menu</h2>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body pt-3 pb-4">
        <div class="list-group list-group-flush gap-2">
            <a
                href="{{ route('categories.index') }}"
                class="list-group-item list-group-item-action border rounded-3 d-flex align-items-center justify-content-between py-3 {{ request()->routeIs('categories.*') ? 'active-more-item' : '' }}"
            >
                <div class="d-flex align-items-center gap-3 min-w-0">
                    <span class="icon-chip icon-chip-emerald flex-shrink-0">
                        <i class="bi bi-tags"></i>
                    </span>
                    <div class="min-w-0">
                        <div class="fw-semibold small text-dark">Categories</div>
                        <div class="text-muted" style="font-size: 0.78rem;">Manage income &amp; expense categories</div>
                    </div>
                </div>
                <i class="bi bi-chevron-right text-muted small flex-shrink-0"></i>
            </a>

            <a
                href="{{ route('settings.index') }}"
                class="list-group-item list-group-item-action border rounded-3 d-flex align-items-center justify-content-between py-3 {{ request()->routeIs('settings.*') ? 'active-more-item' : '' }}"
            >
                <div class="d-flex align-items-center gap-3 min-w-0">
                    <span class="icon-chip icon-chip-neutral flex-shrink-0">
                        <i class="bi bi-gear"></i>
                    </span>
                    <div class="min-w-0">
                        <div class="fw-semibold small text-dark">Settings</div>
                        <div class="text-muted" style="font-size: 0.78rem;">Profile, appearance &amp; integrations</div>
                    </div>
                </div>
                <i class="bi bi-chevron-right text-muted small flex-shrink-0"></i>
            </a>

            <form method="POST" action="{{ route('logout') }}" class="mt-2">
                @csrf
                <button type="submit" class="btn btn-outline-danger w-100 d-flex align-items-center justify-content-center gap-2 py-2">
                    <i class="bi bi-box-arrow-right" aria-hidden="true"></i>
                    <span>Sign Out</span>
                </button>
            </form>
        </div>
    </div>
</div>
