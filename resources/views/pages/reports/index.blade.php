@extends('layouts.app')

@section('title', 'Reports')
@section('page-title', 'Reports')

@php
    $topCategories = [
        ['name' => 'Groceries', 'amount' => 'Rp 2.150.000', 'percent' => 33],
        ['name' => 'Food & Dining', 'amount' => 'Rp 1.620.000', 'percent' => 25],
        ['name' => 'Utilities & Bills', 'amount' => 'Rp 1.180.000', 'percent' => 18],
        ['name' => 'Transport', 'amount' => 'Rp 890.000', 'percent' => 14],
        ['name' => 'Entertainment', 'amount' => 'Rp 580.000', 'percent' => 10],
    ];
@endphp

@section('content')
    <x-page-header
        title="Reports"
        subtitle="Review cash flow trends and top spending categories."
    >
        <div class="dropdown">
            <button
                class="btn btn-outline-emerald dropdown-toggle d-inline-flex align-items-center gap-2"
                type="button"
                data-bs-toggle="dropdown"
                aria-expanded="false"
            >
                <i class="bi bi-download"></i>
                <span>Export Report</span>
            </button>
            <ul class="dropdown-menu dropdown-menu-sm-end shadow-sm border app-dropdown-menu">
                <li>
                    <button type="button" class="dropdown-item d-flex align-items-center gap-2" disabled>
                        <i class="bi bi-filetype-pdf text-muted"></i>
                        <span>Export PDF (Phase 2)</span>
                    </button>
                </li>
                <li>
                    <button type="button" class="dropdown-item d-flex align-items-center gap-2" disabled>
                        <i class="bi bi-filetype-csv text-muted"></i>
                        <span>Export CSV (Phase 2)</span>
                    </button>
                </li>
            </ul>
        </div>
    </x-page-header>

    {{-- Period Selector --}}
    <div class="card app-card mb-4" data-report-period-root>
        <div class="card-body p-3 p-sm-4">
            <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3">
                <div class="d-flex flex-wrap align-items-center gap-2" role="group" aria-label="Report period">
                    <button type="button" class="filter-pill" data-period-btn="weekly">Weekly</button>
                    <button type="button" class="filter-pill active" data-period-btn="monthly">Monthly</button>
                    <button type="button" class="filter-pill" data-period-btn="yearly">Yearly</button>
                    <button type="button" class="filter-pill" data-period-btn="custom">Custom Period</button>
                </div>

                <div class="text-muted small">
                    Showing: <strong class="text-dark" id="activePeriodLabel">November 2026</strong>
                </div>
            </div>

            {{-- Custom Period Date Inputs (Shown when Custom Period is selected) --}}
            <div id="customPeriodFields" class="row g-3 mt-2 pt-3 border-top d-none">
                <div class="col-12 col-sm-6 col-md-4">
                    <label for="reportStartDate" class="form-label small fw-medium">Start Date</label>
                    <input type="date" id="reportStartDate" class="form-control" value="2026-10-01">
                </div>
                <div class="col-12 col-sm-6 col-md-4">
                    <label for="reportEndDate" class="form-label small fw-medium">End Date</label>
                    <input type="date" id="reportEndDate" class="form-control" value="2026-11-25">
                </div>
                <div class="col-12 col-md-4 col-lg-auto d-flex align-items-end">
                    <span class="badge bg-light text-muted border py-2 px-3 w-100">UI Preview</span>
                </div>
            </div>
        </div>
    </div>

    {{-- Income, Expense, Net Cash Flow Summaries --}}
    <div class="row g-3 mb-4">
        <div class="col-12 col-md-6 col-xl-4">
            <div class="card app-card h-100">
                <div class="card-body p-3 p-sm-4 d-flex align-items-start justify-content-between gap-3">
                    <div class="min-w-0">
                        <div class="text-muted small fw-medium mb-1">Income Summary</div>
                        <div class="summary-card-amount fw-bold text-emerald tabular-nums" data-report-income>Rp 12.500.000</div>
                        <div class="text-muted small">All inflow sources</div>
                    </div>
                    <span class="icon-chip icon-chip-emerald flex-shrink-0">
                        <i class="bi bi-arrow-down-left-circle fs-5"></i>
                    </span>
                </div>
            </div>
        </div>

        <div class="col-12 col-md-6 col-xl-4">
            <div class="card app-card h-100">
                <div class="card-body p-3 p-sm-4 d-flex align-items-start justify-content-between gap-3">
                    <div class="min-w-0">
                        <div class="text-muted small fw-medium mb-1">Expense Summary</div>
                        <div class="summary-card-amount fw-bold text-danger-soft tabular-nums" data-report-expense>Rp 6.420.000</div>
                        <div class="text-muted small">All spending categories</div>
                    </div>
                    <span class="icon-chip icon-chip-danger flex-shrink-0">
                        <i class="bi bi-arrow-up-right-circle fs-5"></i>
                    </span>
                </div>
            </div>
        </div>

        <div class="col-12 col-md-12 col-xl-4">
            <div class="card app-card h-100">
                <div class="card-body p-3 p-sm-4 d-flex align-items-start justify-content-between gap-3">
                    <div class="min-w-0">
                        <div class="text-muted small fw-medium mb-1">Net Cash Flow</div>
                        <div class="summary-card-amount fw-bold text-dark tabular-nums" data-report-net>+ Rp 6.080.000</div>
                        <div class="text-muted small">Income minus expenses</div>
                    </div>
                    <span class="icon-chip icon-chip-neutral flex-shrink-0">
                        <i class="bi bi-activity fs-5"></i>
                    </span>
                </div>
            </div>
        </div>
    </div>

    {{-- Chart + Top Spending Categories --}}
    <div class="row g-4">
        <div class="col-12 col-xl-7">
            <div class="card app-card h-100">
                <div class="card-body p-3 p-sm-4">
                    <div class="mb-3">
                        <h2 class="h6 fw-bold text-dark mb-0">Cash Flow Breakdown</h2>
                        <p class="text-muted mb-0" style="font-size: 0.8rem;">Visual summary for the selected period</p>
                    </div>
                    <div class="chart-container">
                        <canvas id="reportsOverviewChart" aria-label="Cash flow breakdown chart" role="img"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 col-xl-5">
            <div class="card app-card h-100">
                <div class="card-body p-3 p-sm-4">
                    <div class="mb-3">
                        <h2 class="h6 fw-bold text-dark mb-0">Top Spending Categories</h2>
                        <p class="text-muted mb-0" style="font-size: 0.8rem;">Highest expense share this period</p>
                    </div>

                    <div class="d-flex flex-column gap-3">
                        @foreach ($topCategories as $cat)
                            <div>
                                <div class="d-flex flex-wrap justify-content-between align-items-center gap-1 mb-1">
                                    <span class="small fw-medium text-dark">{{ $cat['name'] }}</span>
                                    <span class="small text-muted tabular-nums">
                                        <strong class="text-dark">{{ $cat['amount'] }}</strong> ({{ $cat['percent'] }}%)
                                    </span>
                                </div>
                                <div class="progress progress-thin" role="progressbar" aria-valuenow="{{ $cat['percent'] }}" aria-valuemin="0" aria-valuemax="100" aria-label="{{ $cat['name'] }}">
                                    <div class="progress-bar" style="width: {{ $cat['percent'] }}%"></div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('vendor-scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.6/dist/chart.umd.min.js" crossorigin="anonymous"></script>
@endpush
