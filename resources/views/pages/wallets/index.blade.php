@extends('layouts.app')

@section('title', 'Wallets')
@section('page-title', 'Wallets')

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
@endphp

@section('content')
    <x-page-header
        title="Wallets"
        subtitle="Manage your cash, bank accounts, and digital wallets."
    >
        <button
            type="button"
            class="btn btn-light border d-inline-flex align-items-center gap-2"
            data-balance-toggle
            aria-pressed="false"
        >
            <i class="bi bi-eye"></i>
            <span data-balance-toggle-label>Hide</span>
        </button>

        <button
            type="button"
            class="btn btn-emerald d-inline-flex align-items-center gap-2"
            data-bs-toggle="modal"
            data-bs-target="#walletModal"
            data-wallet-modal-title="Add New Wallet"
        >
            <i class="bi bi-plus-lg"></i>
            <span>Add Wallet</span>
        </button>
    </x-page-header>

    {{-- Combined Summary Strip --}}
    <div class="card app-card mb-4">
        <div class="card-body p-3 p-sm-4 d-flex flex-column flex-sm-row align-items-sm-center justify-content-between gap-3">
            <div>
                <div class="text-muted small mb-1">Combined Active Balance</div>
                <div
                    class="h3 fw-bold text-dark tabular-nums mb-0"
                    data-balance-value="Rp 24.850.000"
                    data-balance-mask="Rp ••••••••"
                >
                    Rp 24.850.000
                </div>
            </div>
            <div class="d-flex align-items-center gap-3">
                <div class="text-sm-end">
                    <div class="text-muted small">Active Wallets</div>
                    <div class="fw-semibold text-dark">{{ count($wallets) }} accounts</div>
                </div>
                <span class="icon-chip icon-chip-emerald">
                    <i class="bi bi-wallet2 fs-5"></i>
                </span>
            </div>
        </div>
    </div>

    {{-- Wallet Cards Grid --}}
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
                    :show-actions="true"
                />
            </div>
        @endforeach
    </div>
@endsection

@push('modals')
    {{-- Add / Edit Wallet Placeholder Modal --}}
    <div class="modal fade" id="walletModal" tabindex="-1" aria-labelledby="walletModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow">
                <div class="modal-header border-bottom">
                    <h2 class="modal-title h6 fw-bold" id="walletModalLabel">Add New Wallet</h2>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form onsubmit="return false;">
                    <div class="modal-body p-4">
                        <div class="mb-3">
                            <label for="walletName" class="form-label small fw-medium">Wallet Name</label>
                            <input type="text" id="walletName" class="form-control" placeholder="e.g. Mandiri, GoPay, Cash">
                        </div>
                        <div class="mb-3">
                            <label for="walletType" class="form-label small fw-medium">Wallet Type</label>
                            <select id="walletType" class="form-select">
                                <option>Cash</option>
                                <option>Bank Account</option>
                                <option>E-Wallet</option>
                                <option>Savings</option>
                            </select>
                        </div>
                        <div class="mb-0">
                            <label for="walletBalance" class="form-label small fw-medium">Initial Balance (IDR)</label>
                            <input type="text" id="walletBalance" class="form-control" placeholder="e.g. 1000000">
                        </div>
                    </div>
                    <div class="modal-footer border-top">
                        <button type="button" class="btn btn-light border" data-bs-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-emerald" data-bs-dismiss="modal">Save Placeholder</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Delete Wallet Confirmation Placeholder Modal --}}
    <div class="modal fade" id="deleteWalletModal" tabindex="-1" aria-labelledby="deleteWalletModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-sm">
            <div class="modal-content border-0 shadow">
                <div class="modal-body p-4 text-center">
                    <span class="icon-chip icon-chip-danger icon-chip-lg mx-auto mb-3">
                        <i class="bi bi-trash fs-4"></i>
                    </span>
                    <h2 class="h6 fw-bold mb-1" id="deleteWalletModalLabel">Delete Wallet?</h2>
                    <p class="text-muted small mb-4">
                        This is a UI confirmation placeholder for <strong data-delete-wallet-name>this wallet</strong>.
                    </p>
                    <div class="d-flex gap-2 justify-content-center">
                        <button type="button" class="btn btn-light border flex-fill" data-bs-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-danger flex-fill" data-bs-dismiss="modal">Delete</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endpush
