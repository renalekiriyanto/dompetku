<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
    <title>@yield('title', 'Dashboard') — Dompetku</title>

    {{-- Google Fonts: Inter (clean fintech typography) --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    {{-- Bootstrap 5.3 CSS & Bootstrap Icons (CDN — easy to swap to local public/vendor/ later) --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">

    {{-- Application Custom Stylesheet --}}
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    @stack('styles')
</head>
<body class="app-body">
    <div class="app-shell d-flex min-dvh-100">
        {{-- Desktop Left Sidebar --}}
        <x-sidebar />

        {{-- Main Column: Topbar + Content + Mobile Bottom Nav --}}
        <div class="app-main flex-grow-1 d-flex flex-column min-w-0">
            <x-topbar :title="trim($__env->yieldContent('page-title', 'Dashboard'))" />

            <main class="app-content flex-grow-1">
                <div class="container-fluid app-container py-3 py-lg-4 px-3 px-lg-4">
                    @yield('content')
                </div>
            </main>
        </div>
    </div>

    {{-- Mobile Bottom Navigation & More Offcanvas --}}
    <x-mobile-navbar />

    {{-- Optional Page-Level Modals --}}
    @stack('modals')

    {{-- Bootstrap 5.3 JS Bundle (includes Popper) --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

    {{-- Chart.js (only needed on pages with charts, or globally available via CDN) --}}
    @stack('vendor-scripts')

    {{-- Application Vanilla JavaScript --}}
    <script src="{{ asset('js/app.js') }}" defer></script>
    @stack('scripts')
</body>
</html>
