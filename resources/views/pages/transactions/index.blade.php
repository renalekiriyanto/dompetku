@extends('layouts.app')

@section('title', 'Transactions')
@section('page-title', 'Transactions')

@php
    $transactions = [
        [
            'description' => 'Gaji Bulanan PT Maju Jaya',
            'category' => 'Salary',
            'date' => '25 Nov 2026',
            'period' => '2026-11',
            'wallet' => 'BCA',
            'amount' => 'Rp 11.500.000',
            'type' => 'income',
            'icon' => 'bi-briefcase',
        ],
        [
            'description' => 'Belanja Bulanan Superindo',
            'category' => 'Groceries',
            'date' => '24 Nov 2026',
            'period' => '2026-11',
            'wallet' => 'BCA',
            'amount' => 'Rp 685.000',
            'type' => 'expense',
            'icon' => 'bi-bag',
        ],
        [
            'description' => 'Top Up Saldo DANA',
            'category' => 'Wallet Transfer',
            'date' => '23 Nov 2026',
            'period' => '2026-11',
            'wallet' => 'BCA → DANA',
            'amount' => 'Rp 1.000.000',
            'type' => 'transfer',
            'icon' => 'bi-arrow-left-right',
        ],
        [
            'description' => 'Kopi Kenangan & Makan Siang',
            'category' => 'Food & Dining',
            'date' => '23 Nov 2026',
            'period' => '2026-11',
            'wallet' => 'DANA',
            'amount' => 'Rp 78.000',
            'type' => 'expense',
            'icon' => 'bi-cup-hot',
        ],
        [
            'description' => 'Top Up Token Listrik PLN',
            'category' => 'Utilities & Bills',
            'date' => '21 Nov 2026',
            'period' => '2026-11',
            'wallet' => 'BCA',
            'amount' => 'Rp 250.000',
            'type' => 'expense',
            'icon' => 'bi-lightning-charge',
        ],
        [
            'description' => 'Jasa Desain UI Freelance',
            'category' => 'Freelance',
            'date' => '19 Nov 2026',
            'period' => '2026-11',
            'wallet' => 'DANA',
            'amount' => 'Rp 1.000.000',
            'type' => 'income',
            'icon' => 'bi-laptop',
        ],
        [
            'description' => 'Isi Bensin Pertamax',
            'category' => 'Transport',
            'date' => '18 Nov 2026',
            'period' => '2026-11',
            'wallet' => 'Cash',
            'amount' => 'Rp 150.000',
            'type' => 'expense',
            'icon' => 'bi-fuel-pump',
        ],
        [
            'description' => 'Tarik Tunai ATM BCA',
            'category' => 'Wallet Transfer',
            'date' => '15 Nov 2026',
            'period' => '2026-11',
            'wallet' => 'BCA → Cash',
            'amount' => 'Rp 500.000',
            'type' => 'transfer',
            'icon' => 'bi-arrow-left-right',
        ],
        [
            'description' => 'Tagihan Internet Indihome',
            'category' => 'Utilities & Bills',
            'date' => '28 Oct 2026',
            'period' => '2026-10',
            'wallet' => 'BCA',
            'amount' => 'Rp 375.000',
            'type' => 'expense',
            'icon' => 'bi-wifi',
        ],
    ];
@endphp

@section('content')
    <x-page-header
        title="Transactions"
        subtitle="Track your income, expenses, and transfers across all wallets."
    >
        <button
            type="button"
            class="btn btn-emerald d-inline-flex align-items-center gap-2"
            data-bs-toggle="modal"
            data-bs-target="#addTransactionModal"
        >
            <i class="bi bi-plus-lg"></i>
            <span>Add Transaction</span>
        </button>
    </x-page-header>

    <div class="card app-card" data-transactions-filter-root>
        {{-- Filter Toolbar --}}
        <div class="card-body p-3 p-sm-4 border-bottom">
            <div class="row g-3 align-items-center mb-3">
                <div class="col-12 col-md-6 col-xl-5">
                    <div class="input-group">
                        <span class="input-group-text bg-white border-end-0 text-muted">
                            <i class="bi bi-search"></i>
                        </span>
                        <input
                            type="search"
                            class="form-control border-start-0 ps-0"
                            placeholder="Search description, category, or wallet..."
                            aria-label="Search transactions"
                            data-tx-search
                        >
                    </div>
                </div>

                <div class="col-12 col-sm-7 col-md-4 col-xl-4">
                    <div class="input-group">
                        <span class="input-group-text bg-white text-muted">
                            <i class="bi bi-calendar3"></i>
                        </span>
                        <select class="form-select" aria-label="Filter by period" data-tx-date>
                            <option value="all">All Dates (Placeholder)</option>
                            <option value="2026-11">November 2026</option>
                            <option value="2026-10">October 2026</option>
                        </select>
                    </div>
                </div>

                <div class="col-12 col-sm-5 col-md-2 col-xl-3 text-sm-end">
                    <span class="text-muted small" data-tx-count>{{ count($transactions) }} transactions</span>
                </div>
            </div>

            {{-- Type Filter Pills --}}
            <div class="d-flex flex-wrap align-items-center gap-2" role="group" aria-label="Filter by transaction type">
                <button type="button" class="filter-pill active" data-tx-type-filter="all">All</button>
                <button type="button" class="filter-pill" data-tx-type-filter="income">Income</button>
                <button type="button" class="filter-pill" data-tx-type-filter="expense">Expense</button>
                <button type="button" class="filter-pill" data-tx-type-filter="transfer">Transfer</button>
            </div>
        </div>

        {{-- Desktop Table View --}}
        <div class="d-none d-md-block table-responsive" tabindex="0" role="region" aria-label="Transactions table" data-tx-desktop-wrapper>
            <table class="table table-hover app-table mb-0">
                <thead>
                    <tr>
                        <th scope="col" class="ps-4">Transaction</th>
                        <th scope="col">Category</th>
                        <th scope="col">Wallet</th>
                        <th scope="col">Date</th>
                        <th scope="col">Type</th>
                        <th scope="col" class="text-end pe-4">Amount</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($transactions as $tx)
                        @php
                            $isIncome = $tx['type'] === 'income';
                            $isTransfer = $tx['type'] === 'transfer';
                            $prefix = $isIncome ? '+ ' : ($tx['type'] === 'expense' ? '- ' : '');
                            $amountClass = $isIncome ? 'text-emerald' : ($isTransfer ? 'text-secondary' : 'text-dark');
                            $badgeClass = $isIncome
                                ? 'bg-emerald-soft text-emerald'
                                : ($isTransfer ? 'bg-info-soft text-info-emphasis' : 'bg-light text-muted border');
                            $chipClass = $isIncome
                                ? 'icon-chip-emerald'
                                : ($isTransfer ? 'icon-chip-info' : 'icon-chip-danger');
                        @endphp
                        <tr
                            data-tx-item
                            data-tx-primary
                            data-type="{{ $tx['type'] }}"
                            data-period="{{ $tx['period'] }}"
                            data-search="{{ $tx['description'] }} {{ $tx['category'] }} {{ $tx['wallet'] }}"
                        >
                            <td class="ps-4">
                                <div class="d-flex align-items-center gap-3">
                                    <span class="icon-chip {{ $chipClass }} flex-shrink-0">
                                        <i class="bi {{ $tx['icon'] }}"></i>
                                    </span>
                                    <span class="fw-medium text-dark">{{ $tx['description'] }}</span>
                                </div>
                            </td>
                            <td class="text-muted small">{{ $tx['category'] }}</td>
                            <td class="text-muted small">{{ $tx['wallet'] }}</td>
                            <td class="text-muted small">{{ $tx['date'] }}</td>
                            <td>
                                <span class="badge rounded-pill text-capitalize fw-normal {{ $badgeClass }}">
                                    {{ $tx['type'] }}
                                </span>
                            </td>
                            <td class="text-end pe-4 fw-semibold tabular-nums {{ $amountClass }}">
                                {{ $prefix }}{{ $tx['amount'] }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- Mobile Card List View (Zero Horizontal Scroll) --}}
        <div class="d-md-none px-3 transaction-list" data-tx-mobile-wrapper>
            @foreach ($transactions as $tx)
                <div
                    data-tx-item
                    data-type="{{ $tx['type'] }}"
                    data-period="{{ $tx['period'] }}"
                    data-search="{{ $tx['description'] }} {{ $tx['category'] }} {{ $tx['wallet'] }}"
                >
                    <x-transaction-item
                        :description="$tx['description']"
                        :category="$tx['category']"
                        :date="$tx['date']"
                        :wallet="$tx['wallet']"
                        :amount="$tx['amount']"
                        :type="$tx['type']"
                        :icon="$tx['icon']"
                    />
                </div>
            @endforeach
        </div>

        {{-- Empty State --}}
        <div class="d-none" data-tx-empty>
            <x-empty-state
                icon="bi-search"
                title="No matching transactions"
                description="Try adjusting your search keywords, date filter, or transaction type."
            >
                <button type="button" class="btn btn-sm btn-outline-emerald" data-tx-reset>
                    Reset Filters
                </button>
            </x-empty-state>
        </div>
    </div>
@endsection

@push('modals')
    <div class="modal fade" id="addTransactionModal" tabindex="-1" aria-labelledby="addTransactionModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow">
                <div class="modal-header border-bottom">
                    <h2 class="modal-title h6 fw-bold" id="addTransactionModalLabel">Add Transaction (UI Preview)</h2>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form onsubmit="return false;">
                    <div class="modal-body p-4">
                        <div class="alert alert-light border small text-muted mb-3">
                            <i class="bi bi-info-circle me-1"></i>
                            This form is a UI template placeholder. Backend saving will be connected in Phase 2.
                        </div>
                        <div class="mb-3">
                            <label for="txType" class="form-label small fw-medium">Transaction Type</label>
                            <select id="txType" class="form-select">
                                <option value="expense" selected>Expense</option>
                                <option value="income">Income</option>
                                <option value="transfer">Transfer</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="txAmount" class="form-label small fw-medium">Amount (IDR)</label>
                            <input type="text" id="txAmount" class="form-control" placeholder="e.g. 50000">
                        </div>
                        <div class="row g-3 mb-3">
                            <div class="col-12 col-sm-6">
                                <label for="txWallet" class="form-label small fw-medium">Wallet</label>
                                <select id="txWallet" class="form-select">
                                    <option>Cash</option>
                                    <option>BCA</option>
                                    <option>DANA</option>
                                </select>
                            </div>
                            <div class="col-12 col-sm-6">
                                <label for="txCategory" class="form-label small fw-medium">Category</label>
                                <select id="txCategory" class="form-select">
                                    <option>Food &amp; Dining</option>
                                    <option>Groceries</option>
                                    <option>Transport</option>
                                    <option>Salary</option>
                                </select>
                            </div>
                        </div>
                        <div class="mb-0">
                            <label for="txDescription" class="form-label small fw-medium">Description</label>
                            <input type="text" id="txDescription" class="form-control" placeholder="e.g. Makan siang warteg">
                        </div>
                    </div>
                    <div class="modal-footer border-top">
                        <button type="button" class="btn btn-light border" data-bs-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-emerald" data-bs-dismiss="modal">Save Preview</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endpush
