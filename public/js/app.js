/**
 * Dompetku — Frontend UI Interactions (Phase 1)
 * Pure vanilla JavaScript for UI interactions without fake backend persistence.
 */

document.addEventListener('DOMContentLoaded', () => {
    initBalanceToggle();
    initPasswordToggles();
    initAuthFormSubmitState();
    initTransactionFilters();
    initModalContext();
    initReportPeriodSelector();
    initCharts();
});

/**
 * 0. Auth Password Visibility Toggle & Submit State
 */
function initPasswordToggles() {
    const toggleButtons = document.querySelectorAll('[data-password-toggle]');
    if (toggleButtons.length === 0) return;

    toggleButtons.forEach((button) => {
        button.addEventListener('click', () => {
            const targetId = button.getAttribute('data-target');
            const input = targetId ? document.getElementById(targetId) : null;
            if (!input) return;

            const isVisible = input.type === 'text';
            const nextVisible = !isVisible;
            input.type = nextVisible ? 'text' : 'password';

            button.setAttribute('aria-pressed', String(nextVisible));
            const labelShow = button.getAttribute('data-label-show') || 'Show password';
            const labelHide = button.getAttribute('data-label-hide') || 'Hide password';
            button.setAttribute('aria-label', nextVisible ? labelHide : labelShow);

            const icon = button.querySelector('i');
            if (icon) {
                icon.className = nextVisible ? 'bi bi-eye-slash' : 'bi bi-eye';
            }
        });
    });
}

function initAuthFormSubmitState() {
    const authForms = document.querySelectorAll('[data-auth-form]');
    authForms.forEach((form) => {
        form.addEventListener('submit', () => {
            const submitButton = form.querySelector('button[type="submit"]');
            if (submitButton && !submitButton.disabled) {
                submitButton.disabled = true;
            }
        });
    });
}

/**
 * 1. Hide / Show Total Balance Toggle
 */
function initBalanceToggle() {
    const toggleButtons = document.querySelectorAll('[data-balance-toggle]');
    if (toggleButtons.length === 0) return;

    const storageKey = 'dompetku_balance_hidden';
    let isHidden = localStorage.getItem(storageKey) === 'true';

    const applyVisibilityState = () => {
        const balanceElements = document.querySelectorAll('[data-balance-value]');
        balanceElements.forEach((el) => {
            const original = el.getAttribute('data-balance-value');
            const mask = el.getAttribute('data-balance-mask') || 'Rp ••••••••';
            el.textContent = isHidden ? mask : original;
        });

        toggleButtons.forEach((btn) => {
            btn.setAttribute('aria-pressed', String(isHidden));
            btn.setAttribute('aria-label', isHidden ? 'Show balance' : 'Hide balance');

            const icon = btn.querySelector('i');
            if (icon) {
                icon.className = isHidden ? 'bi bi-eye-slash' : 'bi bi-eye';
            }

            const label = btn.querySelector('[data-balance-toggle-label]');
            if (label) {
                label.textContent = isHidden ? 'Show' : 'Hide';
            }
        });
    };

    applyVisibilityState();

    toggleButtons.forEach((btn) => {
        btn.addEventListener('click', () => {
            isHidden = !isHidden;
            localStorage.setItem(storageKey, String(isHidden));
            applyVisibilityState();
        });
    });
}

/**
 * 2. Transactions Page Client-Side Filter (UI Preview on Dummy Data)
 */
function initTransactionFilters() {
    const filterRoot = document.querySelector('[data-transactions-filter-root]');
    if (!filterRoot) return;

    const searchInput = filterRoot.querySelector('[data-tx-search]');
    const dateFilter = filterRoot.querySelector('[data-tx-date]');
    const typeButtons = filterRoot.querySelectorAll('[data-tx-type-filter]');
    const resetButtons = filterRoot.querySelectorAll('[data-tx-reset]');
    const rows = filterRoot.querySelectorAll('[data-tx-item]');
    const desktopWrapper = filterRoot.querySelector('[data-tx-desktop-wrapper]');
    const mobileWrapper = filterRoot.querySelector('[data-tx-mobile-wrapper]');
    const emptyState = filterRoot.querySelector('[data-tx-empty]');
    const countLabel = filterRoot.querySelector('[data-tx-count]');

    let activeType = 'all';

    const applyFilters = () => {
        const query = (searchInput?.value || '').trim().toLowerCase();
        const selectedPeriod = dateFilter?.value || 'all';
        let visibleItems = 0;

        rows.forEach((item) => {
            const itemType = item.getAttribute('data-type') || '';
            const itemPeriod = item.getAttribute('data-period') || '';
            const itemText = (item.getAttribute('data-search') || '').toLowerCase();

            const matchesType = activeType === 'all' || itemType === activeType;
            const matchesPeriod = selectedPeriod === 'all' || itemPeriod === selectedPeriod;
            const matchesQuery = query === '' || itemText.includes(query);

            const isVisible = matchesType && matchesPeriod && matchesQuery;
            item.classList.toggle('d-none', !isVisible);

            // Count unique items using desktop rows (each transaction appears once in desktop table & once in mobile list)
            if (isVisible && item.hasAttribute('data-tx-primary')) {
                visibleItems += 1;
            }
        });

        if (countLabel) {
            countLabel.textContent = `${visibleItems} transaction${visibleItems === 1 ? '' : 's'}`;
        }

        const hasResults = visibleItems > 0;
        if (desktopWrapper) desktopWrapper.classList.toggle('d-none', !hasResults);
        if (mobileWrapper) mobileWrapper.classList.toggle('d-none', !hasResults);
        if (emptyState) emptyState.classList.toggle('d-none', hasResults);
    };

    typeButtons.forEach((btn) => {
        btn.addEventListener('click', () => {
            activeType = btn.getAttribute('data-tx-type-filter') || 'all';
            typeButtons.forEach((b) => b.classList.toggle('active', b === btn));
            applyFilters();
        });
    });

    if (searchInput) {
        searchInput.addEventListener('input', applyFilters);
    }

    if (dateFilter) {
        dateFilter.addEventListener('change', applyFilters);
    }

    resetButtons.forEach((btn) => {
        btn.addEventListener('click', () => {
            activeType = 'all';
            if (searchInput) searchInput.value = '';
            if (dateFilter) dateFilter.value = 'all';
            typeButtons.forEach((b) => {
                b.classList.toggle('active', b.getAttribute('data-tx-type-filter') === 'all');
            });
            applyFilters();
        });
    });

    applyFilters();
}

/**
 * 3. Modal Context Helpers (Wallet / Category Edit & Delete Placeholders)
 */
function initModalContext() {
    const walletModal = document.getElementById('walletModal');
    if (walletModal) {
        walletModal.addEventListener('show.bs.modal', (event) => {
            const trigger = event.relatedTarget;
            const title = trigger?.getAttribute('data-wallet-modal-title') || 'Add New Wallet';
            const titleEl = walletModal.querySelector('.modal-title');
            if (titleEl) titleEl.textContent = title;
        });
    }

    const deleteWalletModal = document.getElementById('deleteWalletModal');
    if (deleteWalletModal) {
        deleteWalletModal.addEventListener('show.bs.modal', (event) => {
            const trigger = event.relatedTarget;
            const walletName = trigger?.getAttribute('data-wallet-name') || 'this wallet';
            const targetEl = deleteWalletModal.querySelector('[data-delete-wallet-name]');
            if (targetEl) targetEl.textContent = walletName;
        });
    }

    const categoryModal = document.getElementById('categoryModal');
    if (categoryModal) {
        categoryModal.addEventListener('show.bs.modal', (event) => {
            const trigger = event.relatedTarget;
            const title = trigger?.getAttribute('data-category-modal-title') || 'Add Category';
            const catType = trigger?.getAttribute('data-category-type') || 'expense';
            const titleEl = categoryModal.querySelector('.modal-title');
            const typeSelect = categoryModal.querySelector('[data-category-type-select]');
            if (titleEl) titleEl.textContent = title;
            if (typeSelect) typeSelect.value = catType;
        });
    }
}

/**
 * 4. Reports Page Period Selector
 */
let reportsChartInstance = null;

const REPORT_PERIOD_DATA = {
    weekly: {
        label: 'Last 7 Days (19 Nov – 25 Nov 2026)',
        income: 'Rp 2.500.000',
        expense: 'Rp 1.180.000',
        net: '+ Rp 1.320.000',
        labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
        incomeSeries: [0, 1000000, 0, 500000, 1000000, 0, 0],
        expenseSeries: [120000, 185000, 95000, 210000, 260000, 190000, 120000],
    },
    monthly: {
        label: 'November 2026',
        income: 'Rp 12.500.000',
        expense: 'Rp 6.420.000',
        net: '+ Rp 6.080.000',
        labels: ['Week 1', 'Week 2', 'Week 3', 'Week 4'],
        incomeSeries: [11500000, 0, 1000000, 0],
        expenseSeries: [1850000, 1420000, 1680000, 1470000],
    },
    yearly: {
        label: 'Full Year 2026',
        income: 'Rp 142.800.000',
        expense: 'Rp 79.450.000',
        net: '+ Rp 63.350.000',
        labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
        incomeSeries: [11.5, 11.5, 12.2, 11.8, 12.5, 13.0, 11.5, 12.0, 11.9, 12.4, 12.5, 0].map((v) => v * 1000000),
        expenseSeries: [6.8, 6.4, 7.1, 6.9, 7.5, 6.6, 6.9, 7.2, 6.7, 6.9, 6.42, 0].map((v) => v * 1000000),
    },
    custom: {
        label: 'Custom Range Preview',
        income: 'Rp 24.900.000',
        expense: 'Rp 13.350.000',
        net: '+ Rp 11.550.000',
        labels: ['Oct W1', 'Oct W2', 'Oct W3', 'Oct W4', 'Nov W1', 'Nov W2', 'Nov W3', 'Nov W4'],
        incomeSeries: [11500000, 400000, 500000, 0, 11500000, 0, 1000000, 0],
        expenseSeries: [1750000, 1600000, 1850000, 1730000, 1850000, 1420000, 1680000, 1470000],
    },
};

function initReportPeriodSelector() {
    const periodRoot = document.querySelector('[data-report-period-root]');
    if (!periodRoot) return;

    const buttons = periodRoot.querySelectorAll('[data-period-btn]');
    const customFields = document.getElementById('customPeriodFields');
    const activePeriodLabel = document.getElementById('activePeriodLabel');
    const incomeEl = document.querySelector('[data-report-income]');
    const expenseEl = document.querySelector('[data-report-expense]');
    const netEl = document.querySelector('[data-report-net]');

    const updatePeriodUI = (periodKey) => {
        const data = REPORT_PERIOD_DATA[periodKey] || REPORT_PERIOD_DATA.monthly;

        buttons.forEach((btn) => {
            btn.classList.toggle('active', btn.getAttribute('data-period-btn') === periodKey);
        });

        if (customFields) {
            customFields.classList.toggle('d-none', periodKey !== 'custom');
        }

        if (activePeriodLabel) activePeriodLabel.textContent = data.label;
        if (incomeEl) incomeEl.textContent = data.income;
        if (expenseEl) expenseEl.textContent = data.expense;
        if (netEl) netEl.textContent = data.net;

        if (reportsChartInstance) {
            reportsChartInstance.data.labels = data.labels;
            reportsChartInstance.data.datasets[0].data = data.incomeSeries;
            reportsChartInstance.data.datasets[1].data = data.expenseSeries;
            reportsChartInstance.update();
        }
    };

    buttons.forEach((btn) => {
        btn.addEventListener('click', () => {
            const periodKey = btn.getAttribute('data-period-btn') || 'monthly';
            updatePeriodUI(periodKey);
        });
    });
}

/**
 * 5. Responsive Chart.js Initializer
 */
function formatRupiahCompact(value) {
    if (value >= 1000000) {
        return `Rp ${(value / 1000000).toFixed(value % 1000000 === 0 ? 0 : 1)} jt`;
    }
    if (value >= 1000) {
        return `Rp ${(value / 1000).toFixed(0)} rb`;
    }
    return `Rp ${value}`;
}

function formatRupiahFull(value) {
    return 'Rp ' + new Intl.NumberFormat('id-ID').format(value);
}

function buildBarChartConfig(labels, incomeData, expenseData) {
    return {
        type: 'bar',
        data: {
            labels,
            datasets: [
                {
                    label: 'Income',
                    data: incomeData,
                    backgroundColor: '#059669',
                    borderRadius: 6,
                    barPercentage: 0.72,
                    categoryPercentage: 0.68,
                },
                {
                    label: 'Expense',
                    data: expenseData,
                    backgroundColor: '#cbd5e1',
                    borderRadius: 6,
                    barPercentage: 0.72,
                    categoryPercentage: 0.68,
                },
            ],
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            interaction: {
                mode: 'index',
                intersect: false,
            },
            plugins: {
                legend: {
                    position: 'top',
                    align: 'end',
                    labels: {
                        usePointStyle: true,
                        pointStyle: 'circle',
                        boxWidth: 8,
                        color: '#475569',
                        font: { family: 'Inter, system-ui, sans-serif', size: 12 },
                    },
                },
                tooltip: {
                    backgroundColor: '#0f172a',
                    padding: 10,
                    cornerRadius: 8,
                    callbacks: {
                        label: (ctx) => `${ctx.dataset.label}: ${formatRupiahFull(ctx.parsed.y)}`,
                    },
                },
            },
            scales: {
                x: {
                    grid: { display: false },
                    ticks: {
                        color: '#64748b',
                        font: { size: 11 },
                        autoSkip: true,
                        maxRotation: 45,
                        minRotation: 0,
                    },
                },
                y: {
                    beginAtZero: true,
                    border: { display: false },
                    grid: { color: '#f1f5f9' },
                    ticks: {
                        color: '#64748b',
                        font: { size: 11 },
                        callback: (value) => formatRupiahCompact(value),
                    },
                },
            },
        },
    };
}

function initCharts() {
    if (typeof Chart === 'undefined') return;

    const dashboardCanvas = document.getElementById('dashboardCashflowChart');
    if (dashboardCanvas) {
        new Chart(
            dashboardCanvas,
            buildBarChartConfig(
                ['Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov'],
                [11200000, 11800000, 12100000, 11500000, 12400000, 12500000],
                [6100000, 6850000, 7200000, 6400000, 6930000, 6420000]
            )
        );
    }

    const reportsCanvas = document.getElementById('reportsOverviewChart');
    if (reportsCanvas) {
        const initial = REPORT_PERIOD_DATA.monthly;
        reportsChartInstance = new Chart(
            reportsCanvas,
            buildBarChartConfig(initial.labels, initial.incomeSeries, initial.expenseSeries)
        );
    }
}
