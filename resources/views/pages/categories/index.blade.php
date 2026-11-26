@extends('layouts.app')

@section('title', 'Categories')
@section('page-title', 'Categories')

@php
    $incomeCategories = [
        ['name' => 'Salary', 'icon' => 'bi-briefcase', 'note' => 'Monthly payroll & fixed income'],
        ['name' => 'Freelance', 'icon' => 'bi-laptop', 'note' => 'Client projects & consulting'],
        ['name' => 'Investment Return', 'icon' => 'bi-graph-up-arrow', 'note' => 'Dividends, deposits & mutual funds'],
        ['name' => 'Bonus', 'icon' => 'bi-award', 'note' => 'Performance bonus & THR'],
        ['name' => 'Gift', 'icon' => 'bi-gift', 'note' => 'Personal gifts & reimbursements'],
    ];

    $expenseCategories = [
        ['name' => 'Food & Dining', 'icon' => 'bi-cup-hot', 'note' => 'Daily meals, coffee & restaurants'],
        ['name' => 'Groceries', 'icon' => 'bi-bag', 'note' => 'Supermarket & household supplies'],
        ['name' => 'Transport', 'icon' => 'bi-fuel-pump', 'note' => 'Fuel, parking, toll & ride-hailing'],
        ['name' => 'Utilities & Bills', 'icon' => 'bi-lightning-charge', 'note' => 'Electricity, water, internet & mobile'],
        ['name' => 'Housing', 'icon' => 'bi-house', 'note' => 'Rent, maintenance & home repairs'],
        ['name' => 'Entertainment', 'icon' => 'bi-film', 'note' => 'Streaming, cinema & hobbies'],
        ['name' => 'Health', 'icon' => 'bi-heart-pulse', 'note' => 'Pharmacy, clinic & insurance'],
    ];
@endphp

@section('content')
    <x-page-header
        title="Categories"
        subtitle="Organize how your income and expenses are grouped."
    >
        <button
            type="button"
            class="btn btn-emerald d-inline-flex align-items-center gap-2"
            data-bs-toggle="modal"
            data-bs-target="#categoryModal"
            data-category-modal-title="Add Category"
            data-category-type="expense"
        >
            <i class="bi bi-plus-lg"></i>
            <span>Add Category</span>
        </button>
    </x-page-header>

    <div class="row g-4">
        {{-- Income Categories --}}
        <div class="col-12 col-lg-6">
            <div class="card app-card h-100">
                <div class="card-header bg-white border-bottom py-3 px-3 px-sm-4 d-flex flex-wrap align-items-center justify-content-between gap-2">
                    <div class="d-flex flex-wrap align-items-center gap-2 min-w-0">
                        <span class="badge bg-emerald-soft text-emerald rounded-pill px-2 py-1">Income</span>
                        <h2 class="h6 fw-bold mb-0">Income Categories</h2>
                    </div>
                    <button
                        type="button"
                        class="btn btn-sm btn-outline-emerald flex-shrink-0"
                        data-bs-toggle="modal"
                        data-bs-target="#categoryModal"
                        data-category-modal-title="Add Income Category"
                        data-category-type="income"
                    >
                        <i class="bi bi-plus-lg me-1"></i>Add
                    </button>
                </div>
                <div class="list-group list-group-flush">
                    @foreach ($incomeCategories as $category)
                        <div class="list-group-item px-3 px-sm-4 py-3 d-flex align-items-center justify-content-between gap-2 gap-sm-3">
                            <div class="d-flex align-items-center gap-2 gap-sm-3 min-w-0">
                                <span class="icon-chip icon-chip-emerald flex-shrink-0">
                                    <i class="bi {{ $category['icon'] }}"></i>
                                </span>
                                <div class="min-w-0">
                                    <div class="fw-medium text-dark text-break">{{ $category['name'] }}</div>
                                    <div class="text-muted small text-break">{{ $category['note'] }}</div>
                                </div>
                            </div>
                            <button
                                type="button"
                                class="btn btn-sm btn-light border flex-shrink-0"
                                data-bs-toggle="modal"
                                data-bs-target="#categoryModal"
                                data-category-modal-title="Edit Category — {{ $category['name'] }}"
                                data-category-type="income"
                            >
                                <i class="bi bi-pencil me-1"></i>Edit
                            </button>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- Expense Categories --}}
        <div class="col-12 col-lg-6">
            <div class="card app-card h-100">
                <div class="card-header bg-white border-bottom py-3 px-3 px-sm-4 d-flex flex-wrap align-items-center justify-content-between gap-2">
                    <div class="d-flex flex-wrap align-items-center gap-2 min-w-0">
                        <span class="badge bg-light text-dark border rounded-pill px-2 py-1">Expense</span>
                        <h2 class="h6 fw-bold mb-0">Expense Categories</h2>
                    </div>
                    <button
                        type="button"
                        class="btn btn-sm btn-light border flex-shrink-0"
                        data-bs-toggle="modal"
                        data-bs-target="#categoryModal"
                        data-category-modal-title="Add Expense Category"
                        data-category-type="expense"
                    >
                        <i class="bi bi-plus-lg me-1"></i>Add
                    </button>
                </div>
                <div class="list-group list-group-flush">
                    @foreach ($expenseCategories as $category)
                        <div class="list-group-item px-3 px-sm-4 py-3 d-flex align-items-center justify-content-between gap-2 gap-sm-3">
                            <div class="d-flex align-items-center gap-2 gap-sm-3 min-w-0">
                                <span class="icon-chip icon-chip-danger flex-shrink-0">
                                    <i class="bi {{ $category['icon'] }}"></i>
                                </span>
                                <div class="min-w-0">
                                    <div class="fw-medium text-dark text-break">{{ $category['name'] }}</div>
                                    <div class="text-muted small text-break">{{ $category['note'] }}</div>
                                </div>
                            </div>
                            <button
                                type="button"
                                class="btn btn-sm btn-light border flex-shrink-0"
                                data-bs-toggle="modal"
                                data-bs-target="#categoryModal"
                                data-category-modal-title="Edit Category — {{ $category['name'] }}"
                                data-category-type="expense"
                            >
                                <i class="bi bi-pencil me-1"></i>Edit
                            </button>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection

@push('modals')
    <div class="modal fade" id="categoryModal" tabindex="-1" aria-labelledby="categoryModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow">
                <div class="modal-header border-bottom">
                    <h2 class="modal-title h6 fw-bold" id="categoryModalLabel">Add Category</h2>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form onsubmit="return false;">
                    <div class="modal-body p-4">
                        <div class="mb-3">
                            <label for="catType" class="form-label small fw-medium">Category Type</label>
                            <select id="catType" class="form-select" data-category-type-select>
                                <option value="income">Income</option>
                                <option value="expense" selected>Expense</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="catName" class="form-label small fw-medium">Category Name</label>
                            <input type="text" id="catName" class="form-control" placeholder="e.g. Subscriptions">
                        </div>
                        <div class="mb-0">
                            <label for="catNote" class="form-label small fw-medium">Short Description</label>
                            <input type="text" id="catNote" class="form-control" placeholder="Optional note">
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
@endpush
