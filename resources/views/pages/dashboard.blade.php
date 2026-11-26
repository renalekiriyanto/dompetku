@extends('layouts.app')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@php
    $wallets = [
        [
            'name' => 'Cash',
            'type' => 'Cash',
            'balance' => 'Rp 1.350.000',
            'icon' => 'bi-cash-coin',
            'accent' => 'emerald',
            'hint' => 'Physical',
        ],
        [
            'name' => 'BCA',
            'type' => 'Bank Account',
            'balance' => 'Rp 18.750.000',
            'icon' => 'bi-bank',
            'accent' => 'primary',
            'hint' => '•••• 4821',
        ],
        [
            'name' => 'DANA',
            'type' => 'E-Wallet',
            'balance' => 'Rp 4.750.000',
            'icon' => 'bi-phone',
            'accent' => 'info',
            'hint' => '0812••••90',
        ],
    ];

    $recentTransactions = [
        [
            'description' => 'Gaji Bulanan PT Maju Jaya',
            'category' => 'Salary',
            'date' => '25 Nov 2026',
            'wallet' => 'BCA',
            'amount' => 'Rp 11.500.000',
            'type' => 'income',
            'icon' => 'bi-briefcase',
        ],
        [
            'description' => 'Belanja Bulanan Superindo',
            'category' => 'Groceries',
            'date' => '24 Nov 2026',
            'wallet' => 'BCA',
            'amount' => 'Rp 685.000',
            'type' => 'expense',
            'icon' => 'bi-bag',
        ],
        [
            'description' => 'Kopi Kenangan & Makan Siang',
            'category' => 'Food & Dining',
            'date' => '23 Nov 2026',
            'wallet' => 'DANA',
            'amount' => 'Rp 78.000',
            'type' => 'expense',
            'icon' => 'bi-cup-hot',
        ],
        [
            'description' => 'Top Up Token Listrik PLN',
            'category' => 'Utilities & Bills',
            'date' => '21 Nov 2026',
            'wallet' => 'BCA',
            'amount' => 'Rp 250.000',
            'type' => 'expense',
            'icon' => 'bi-lightning-charge',
        ],
        [
            'description' => 'Jasa Desain UI Freelance',
            'category' => 'Freelance',
            'date' => '19 Nov 2026',
            'wallet' => 'DANA',
            'amount' => 'Rp 1.000.000',
            'type' => 'income',
            'icon' => 'bi-laptop',
        ],
        [
            'description' => 'Isi Bensin Pertamax',
            'category' => 'Transport',
            'date' => '18 Nov 2026',
            'wallet' => 'Cash',
            'amount' => 'Rp 150.000',
            'type' => 'expense',
            'icon' => 'bi-fuel-pump',
        ],
    ];
@endphp

@section('content')
    {{-- A. Greeting Section --}}
    <section class="mb-4" aria-label="Greeting">
        <div class="d-flex flex-column flex-sm-row align-items-sm-center justify-content-between gap-2">
            <div>
                <h1 class="h4 fw-bold text-dark mb-1">Good evening, {{ auth()->user()?->firstName() ?? 'Budi' }}</h1>
                <p class="text-muted small mb-0">Here is a quick overview of your personal finances today.</p>
            </div>
            <div class="text-sm-end">
                <span class="badge bg-white text-dark border fw-medium px-3 py-2 rounded-pill">
                    <i class="bi bi-calendar3 text-emerald me-1"></i>
                    {{ now()->format('l, d F Y') }}
                </span>
            </div>
        </div>
    </section>

    {{-- B. Total Balance Card & C. Income / Expense Summary --}}
    <section class="row g-3 mb-4" aria-label="Balance and cashflow summary">
        <div class="col-12 col-lg-5">
            <div class="card app-card balance-hero-card h-100">
                <div class="card-body p-3 p-sm-4 d-flex flex-column justify-content-between gap-3">
                    <div class="d-flex align-items-center justify-content-between gap-2">
                        <span class="text-muted small fw-medium">Total Balance</span>
                        <button
                            type="button"
                            class="btn btn-sm btn-light border d-inline-flex align-items-center gap-1 rounded-pill px-2 py-1"
                            data-balance-toggle
                            aria-pressed="false"
                            aria-label="Hide balance"
                        >
                            <i class="bi bi-eye"></i>
                            <span class="small" data-balance-toggle-label>Hide</span>
                        </button>
                    </div>

                    <div>
                        <div
                            class="balance-hero-amount fw-bold text-dark tabular-nums mb-1"
                            data-balance-value="Rp 24.850.000"
                            data-balance-mask="Rp ••••••••"
                        >
                            Rp 24.850.000
                        </div>
                        <p class="text-muted mb-0" style="font-size: 0.8rem;">
                            <i class="bi bi-check-circle-fill text-emerald me-1"></i>
                            Total balance across 3 active wallets
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 col-lg-7">
            <div class="row g-3 h-100">
                <div class="col-12 col-sm-6">
                    <x-summary-card
                        title="Total Income"
                        amount="Rp 12.500.000"
                        icon="bi-arrow-down-left-circle"
                        tone="emerald"
                        subtitle="November 2026 • +8.2% vs Oct"
                    />
                </div>
                <div class="col-12 col-sm-6">
                    <x-summary-card
                        title="Total Expense"
                        amount="Rp 6.420.000"
                        icon="bi-arrow-up-right-circle"
                        tone="danger"
                        subtitle="November 2026 • 51% of income"
                    />
                </div>
            </div>
        </div>
    </section>

    {{-- D. Wallet Overview --}}
    <section class="mb-4" aria-label="Wallet overview">
        <div class="d-flex align-items-center justify-content-between mb-3">
            <div>
                <h2 class="h6 fw-bold text-dark mb-0">My Wallets</h2>
                <p class="text-muted mb-0" style="font-size: 0.8rem;">Active cash, bank, and e-wallet balances</p>
            </div>
            <a href="{{ route('wallets.index') }}" class="btn btn-sm btn-link text-emerald text-decoration-none fw-medium px-0">
                See all <i class="bi bi-arrow-right ms-1"></i>
            </a>
        </div>

        <div class="row g-3">
            @foreach ($wallets as $wallet)
                <div class="col-12 col-md-6 col-xl-4">
                    <x-wallet-card
                        :name="$wallet['name']"
                        :type="$wallet['type']"
                        :balance="$wallet['balance']"
                        :icon="$wallet['icon']"
                        :accent="$wallet['accent']"
                        :account-hint="$wallet['hint']"
                    />
                </div>
            @endforeach
        </div>
    </section>

    {{-- E. Recent Transactions & F. Monthly Financial Overview --}}
    <section class="row g-4" aria-label="Transactions and monthly overview">
        {{-- F. Monthly Financial Overview (Chart.js) --}}
        <div class="col-12 col-xl-7 order-2 order-xl-1">
            <div class="card app-card h-100">
                <div class="card-body p-3 p-sm-4">
                    <div class="d-flex flex-wrap align-items-center justify-content-between gap-2 mb-3">
                        <div>
                            <h2 class="h6 fw-bold text-dark mb-0">Monthly Financial Overview</h2>
                            <p class="text-muted mb-0" style="font-size: 0.8rem;">Income vs expenses over the last 6 months</p>
                        </div>
                        <a href="{{ route('reports.index') }}" class="btn btn-sm btn-light border">
                            Full Report
                        </a>
                    </div>

                    <div class="chart-container">
                        <canvas id="dashboardCashflowChart" aria-label="Monthly income versus expenses chart" role="img"></canvas>
                    </div>
                </div>
            </div>
        </div>

        {{-- E. Recent Transactions --}}
        <div class="col-12 col-xl-5 order-1 order-xl-2">
            <div class="card app-card h-100">
                <div class="card-body p-3 p-sm-4">
                    <div class="d-flex align-items-center justify-content-between mb-2">
                        <div>
                            <h2 class="h6 fw-bold text-dark mb-0">Recent Transactions</h2>
                            <p class="text-muted mb-0" style="font-size: 0.8rem;">Latest activity across wallets</p>
                        </div>
                        <a href="{{ route('transactions.index') }}" class="btn btn-sm btn-link text-emerald text-decoration-none fw-medium px-0">
                            View all <i class="bi bi-arrow-right ms-1"></i>
                        </a>
                    </div>

                    <div class="transaction-list">
                        @foreach ($recentTransactions as $tx)
                            <x-transaction-item
                                :description="$tx['description']"
                                :category="$tx['category']"
                                :date="$tx['date']"
                                :wallet="$tx['wallet']"
                                :amount="$tx['amount']"
                                :type="$tx['type']"
                                :icon="$tx['icon']"
                            />
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('vendor-scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.6/dist/chart.umd.min.js" crossorigin="anonymous"></script>
@endpush
