<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="x-ua-compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="description" content="RKP Desa Management System - Powered by Duralux" />
    <meta name="keyword" content="rkp, desa, management" />
    <meta name="author" content="RKP Desa Team" />
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!--! Title !-->
    <title>@yield('title', 'Dashboard') - RKP Desa</title>

    <script>
        // Early theme initialization to prevent flash
        (function() {
            const savedTheme = localStorage.getItem('admin-theme') || 'light';
            document.documentElement.setAttribute('data-theme', savedTheme);
        })();
    </script>

    <!--! Favicon !-->
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('admin-template/assets/images/Logo Sipdes 2 Persegi.png') }}" />

    <!--! Bootstrap CSS !-->
    <link rel="stylesheet" type="text/css" href="{{ asset('admin-template/assets/css/bootstrap.min.css') }}" />

    <!--! Vendors CSS !-->
    <link rel="stylesheet" type="text/css" href="{{ asset('admin-template/assets/vendors/css/vendors.min.css') }}" />
    <link rel="stylesheet" type="text/css"
        href="{{ asset('admin-template/assets/vendors/css/daterangepicker.min.css') }}" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

    <!--! Theme CSS !-->
    <link rel="stylesheet" type="text/css" href="{{ asset('admin-template/assets/css/theme.min.css') }}" />

    <!--! Custom CSS !-->
    <style>
        :root {
            --primary-color: #4b3bdb;
            --secondary-color: #6c757d;
            --success-color: #28a745;
            --danger-color: #dc3545;
            --warning-color: #ffc107;
            --info-color: #17a2b8;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: #f7f9fc;
        }

        /* ─── DARK MODE SYSTEM ─── */
        [data-theme="dark"] {
            --bs-body-bg: #0f172a;
            --bs-body-color: #f1f5f9;
            --bs-card-bg: #1e293b;
            --bs-card-border-color: #334155;
            --bs-border-color: #334155;
            --bs-tertiary-bg: #1e293b;
            background-color: #0f172a !important;
        }
        [data-theme="dark"] body { background-color: #0f172a !important; color: #f1f5f9; }
        [data-theme="dark"] .nxl-container { background-color: #0f172a !important; }
        [data-theme="dark"] .page-header { background-color: #0f172a !important; color: #f1f5f9; border-bottom: 1px solid #1e293b; }
        [data-theme="dark"] .card { background-color: #1e293b !important; border-color: #334155 !important; color: #f1f5f9; }
        [data-theme="dark"] .card-header { background-color: #1e293b !important; border-bottom-color: #334155 !important; color: #f1f5f9; }
        [data-theme="dark"] .card-body { background-color: #1e293b !important; }
        [data-theme="dark"] .table { color: #f1f5f9 !important; --bs-table-hover-color: #f1f5f9; --bs-table-hover-bg: #334155; --bs-table-bg: transparent; }
        [data-theme="dark"] .table td, [data-theme="dark"] .table th { background-color: transparent !important; color: #f1f5f9 !important; border-color: #334155 !important; }
        [data-theme="dark"] .table-light { --bs-table-bg: #334155; --bs-table-color: #f1f5f9; }
        [data-theme="dark"] .nxl-header { background-color: #1e293b !important; border-bottom: 1px solid #334155; color: #f1f5f9; }
        [data-theme="dark"] .breadcrumb-item, [data-theme="dark"] .text-muted { color: #94a3b8 !important; }
        [data-theme="dark"] .breadcrumb-item.active { color: #f1f5f9 !important; }
        [data-theme="dark"] .form-control, [data-theme="dark"] .form-select { background-color: #1e293b !important; border-color: #334155 !important; color: #f1f5f9; }
        [data-theme="dark"] .list-group-item { background-color: #1e293b !important; border-color: #334155 !important; color: #f1f5f9; }
        [data-theme="dark"] .dropdown-menu { background-color: #1e293b !important; border-color: #334155 !important; color: #f1f5f9; }
        [data-theme="dark"] .dropdown-item { color: #f1f5f9; }
        [data-theme="dark"] .dropdown-item:hover { background-color: #334155; }
        [data-theme="dark"] .nxl-navigation { background-color: #1e293b !important; border-right: 1px solid #334155; }
        [data-theme="dark"] .nxl-navigation .nxl-header { background-color: #1e293b !important; border-bottom: 1px solid #334155; }
        [data-theme="dark"] .nxl-micon i, [data-theme="dark"] .nxl-mtext { color: #f1f5f9 !important; }
        [data-theme="dark"] .nxl-link:hover { background-color: #334155 !important; }
        [data-theme="dark"] .bg-white { background-color: #1e293b !important; }
        [data-theme="dark"] .bg-light { background-color: #0f172a !important; }
        [data-theme="dark"] .text-dark { color: #f1f5f9 !important; }
        [data-theme="dark"] .modal-content { background-color: #1e293b !important; color: #f1f5f9; }
        [data-theme="dark"] .pagination .page-link { background-color: #1e293b; border-color: #334155; color: #f1f5f9; }
        [data-theme="dark"] .nxl-h-item .avatar-text.bg-light-primary { background: #334155 !important; }
        [data-theme="dark"] .accordion-item { background-color: #1e293b !important; border-color: #334155 !important; color: #f1f5f9; }
        [data-theme="dark"] .accordion-button { background-color: #1e293b !important; color: #f1f5f9 !important; }
        [data-theme="dark"] .accordion-button:not(.collapsed) { background-color: #334155 !important; box-shadow: none; }
        [data-theme="dark"] .accordion-body { background-color: #1e293b !important; }

        .page-header {
            margin-bottom: 1.5rem;
        }

        .page-content {
            padding: 2rem 1rem;
            min-height: calc(100vh - 200px);
        }

        .card {
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.08);
            border: 1px solid rgba(0, 0, 0, 0.05);
            border-radius: 0.5rem;
            margin-bottom: 1.5rem;
        }

        .card-header {
            background-color: #f8f9fa;
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
            padding: 1.25rem;
        }

        .btn-primary {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }

        .btn-primary:hover {
            background-color: #3d2fa8;
            border-color: #3d2fa8;
        }

        @media (max-width: 991px) {
            .nxl-navigation {
                position: fixed;
                left: 0;
                top: 0;
                width: 280px;
                height: 100vh;
                z-index: 1000;
                background-color: #fff;
                transform: translateX(-100%);
                transition: transform 0.3s ease;
            }

            .nxl-navigation.active {
                transform: translateX(0);
            }

            .nxl-container {
                width: 100%;
                margin-left: 0;
            }

            .page-content {
                margin-left: 0;
            }
        }

        @media (min-width: 992px) {
            body {
                display: flex;
            }

            .nxl-navigation {
                position: fixed;
                left: 0;
                top: 0;
                width: 280px;
                height: 100vh;
                overflow-y: auto;
                z-index: 100;
            }

            .nxl-container {
                margin-left: 280px;
                width: calc(100% - 280px);
                display: flex;
                flex-direction: column;
                min-height: 100vh;
            }

            .nxl-header {
                margin-left: 0;
            }

            .page-content {
                margin-left: 0;
            }
        }
        
        /* 
         * TABLE LAYOUT FIXES
         * ---------------------------------------------------------
         */
        
        /* 1. Ensure table container has bottom padding to reveal bottom border/shadows */
        .table-responsive {
            margin-bottom: 0 !important;
            padding-bottom: 12px !important;
        }

        /* 2. Prevent cells from clipping their contents vertically */
        .table > tbody > tr > td, 
        .table > tbody > tr > th {
            vertical-align: middle;
            padding-top: 1rem;
            padding-bottom: 1rem;
        }

        /* 3. Action Buttons Standardization */
        /* Remove explicit min-height or margin that might push it out of bounds */
        .table td .btn-sm {
            padding: 0.35rem 0.5rem !important;
            font-size: 11px !important;
            line-height: 1 !important;
            height: auto !important; /* Let padding define height */
            margin: 0 !important; /* Remove margin to fix alignment */
            display: inline-flex !important;
            align-items: center;
            justify-content: center;
            gap: 4px !important; /* Spacing between icon and text */
            border: 1px solid transparent !important; /* PREVENT HOVER JUMPING */
            box-sizing: border-box !important;
        }

        /* Specifically address outline buttons that get borders on hover */
        .table td .btn-outline-primary, 
        .table td .btn-outline-secondary, 
        .table td .btn-outline-success, 
        .table td .btn-outline-danger, 
        .table td .btn-outline-warning, 
        .table td .btn-outline-info,
        .table td .btn-outline-dark {
            border-color: currentColor !important; /* Forces border to exist constantly, matching text color */
        }

        /* Standardize icon sizing within buttons */
        .table td .btn-sm i, 
        .table td .btn-sm svg {
            width: 12px !important;
            height: 12px !important;
            font-size: 12px !important; /* For icon fonts */
            line-height: 1 !important;
        }
        
        /* Ensure the flex container for buttons doesn't cause overflow */
        .table td .d-flex {
            align-items: center;
            gap: 0.5rem !important; /* Use gap instead of margin on buttons */
        }

        /* Desktop specific tweaks */
        @media (min-width: 992px) {
            .table-responsive {
                overflow: visible !important; /* Safe to turn off scrolling on desktop */
                padding-bottom: 0 !important; /* Remove padding if overflow is visible */
            }
            .table-responsive > .table {
                margin-bottom: 0 !important;
            }
        }
        .page-link {
            font-size: 11px !important;
            padding: 0.4rem 0.6rem !important;
        }

        .page-item .page-link {
            display: flex;
            align-items: center;
            height: 30px;
        }

        /* Sesuaikan ukuran font select form */
        .form-select {
            font-size: 13px !important;
        }
        .form-select option[value=""] {
            color: #6c757d;
        }
        
        /* ══════════════════════════════════════════════════
         * STATUS BADGE SYSTEM — Vibrant Solid Palette
         * Konsisten dengan dashboard redesign.
         * ══════════════════════════════════════════════════ */
        .badge[class*="badge-status-"] {
            font-size: 11px;
            font-weight: 600;
            border-radius: 20px;
            padding: 5px 12px;
            letter-spacing: 0.3px;
            display: inline-flex;
            align-items: center;
            gap: 5px;
            transition: filter 0.15s;
        }
        .badge[class*="badge-status-"]:before {
            content: '';
            display: inline-block;
            width: 6px; height: 6px;
            border-radius: 50%;
            background: currentColor;
            opacity: 0.7;
            flex-shrink: 0;
        }

        /* Proses — Indigo */
        .badge-status-proses    { background:#dbeafe !important; color:#1d4ed8 !important; box-shadow: 0 1px 4px rgba(29,78,216,0.15); }
        /* Pending — Amber */
        .badge-status-pending   { background:#fef3c7 !important; color:#92400e !important; box-shadow: 0 1px 4px rgba(146,64,14,0.15); }
        /* Terverifikasi — Emerald */
        .badge-status-terverifikasi { background:#d1fae5 !important; color:#065f46 !important; box-shadow: 0 1px 4px rgba(6,95,70,0.15); }
        /* Gagal Terverifikasi — Red */
        .badge-status-gagal     { background:#fee2e2 !important; color:#991b1b !important; box-shadow: 0 1px 4px rgba(153,27,27,0.15); }
        /* Disetujui — Green */
        .badge-status-disetujui { background:#dcfce7 !important; color:#166534 !important; box-shadow: 0 1px 4px rgba(22,101,52,0.15); }
        /* Menunggu BPD — Violet */
        .badge-status-menunggu-bpd { background:#ede9fe !important; color:#5b21b6 !important; box-shadow: 0 1px 4px rgba(91,33,182,0.15); }
        /* Ditolak BPD — Rose/Pink */
        .badge-status-ditolak-bpd  { background:#fce7f3 !important; color:#9d174d !important; box-shadow: 0 1px 4px rgba(157,23,77,0.15); }

        /* Existing utility backgrounds if needed by old parts */
        .bg-light-primary { background-color: rgba(75, 59, 219, 0.1) !important; }
        .bg-light-success { background-color: rgba(40, 167, 69, 0.1) !important; }
        .bg-light-info { background-color: rgba(23, 162, 184, 0.1) !important; }
        .bg-light-danger { background-color: rgba(220, 53, 69, 0.1) !important; }
        .bg-light-warning { background-color: rgba(255, 193, 7, 0.1) !important; }
        .bg-light-secondary { background-color: rgba(108, 117, 125, 0.1) !important; }
        .bg-purple { background-color: #6f42c1 !important; color: #fff !important; }

        /* ─── Button Hover Transitions ─── */
        .btn {
            transition: all 0.2s ease-in-out !important;
        }

        /* Soft-colored button hover states */
        .btn.bg-light-primary:hover {
            background-color: rgba(75, 59, 219, 0.25) !important;
            color: #3224a8 !important;
            transform: translateY(-1px);
            box-shadow: 0 3px 8px rgba(75, 59, 219, 0.2) !important;
        }
        .btn.bg-light-success:hover {
            background-color: rgba(40, 167, 69, 0.25) !important;
            color: #1e7e34 !important;
            transform: translateY(-1px);
            box-shadow: 0 3px 8px rgba(40, 167, 69, 0.2) !important;
        }
        .btn.bg-light-info:hover {
            background-color: rgba(23, 162, 184, 0.25) !important;
            color: #117a8b !important;
            transform: translateY(-1px);
            box-shadow: 0 3px 8px rgba(23, 162, 184, 0.2) !important;
        }
        .btn.bg-light-danger:hover {
            background-color: rgba(220, 53, 69, 0.25) !important;
            color: #bd2130 !important;
            transform: translateY(-1px);
            box-shadow: 0 3px 8px rgba(220, 53, 69, 0.2) !important;
        }
        .btn.bg-light-warning:hover {
            background-color: rgba(255, 193, 7, 0.25) !important;
            color: #d39e00 !important;
            transform: translateY(-1px);
            box-shadow: 0 3px 8px rgba(255, 193, 7, 0.2) !important;
        }
        .btn.bg-light-secondary:hover {
            background-color: rgba(108, 117, 125, 0.25) !important;
            color: #545b62 !important;
            transform: translateY(-1px);
            box-shadow: 0 3px 8px rgba(108, 117, 125, 0.2) !important;
        }

        /* Solid button hover states */
        .btn-primary:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 10px rgba(75, 59, 219, 0.35) !important;
        }
        .btn-success:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 10px rgba(40, 167, 69, 0.35) !important;
        }
        .btn-danger:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 10px rgba(220, 53, 69, 0.35) !important;
        }
        .btn-warning:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 10px rgba(255, 193, 7, 0.35) !important;
        }
        .btn-info:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 10px rgba(23, 162, 184, 0.35) !important;
        }
        .btn-secondary:hover, .btn-light-secondary:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 10px rgba(108, 117, 125, 0.35) !important;
        }

        /* Active/pressed state - subtle press-down effect */
        .btn:active {
            transform: translateY(0px) !important;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1) !important;
        }
    
        /* Sidebar Mini (Collapsed) - Added for responsiveness */

        /* Sidebar Mini (Collapsed) - Added for responsiveness */
        @media (min-width: 992px) {
            body.sidebar-mini .nxl-navigation {
                width: 80px;
                z-index: 1000;
                transition: width 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
                overflow-x: hidden; /* Prevent horizontal scroll or messy overflow during transition */
            }

            /* Expand on Hover */
            body.sidebar-mini .nxl-navigation:hover {
                width: 280px;
                box-shadow: 0 0 20px rgba(0,0,0,0.1);
            }

            body.sidebar-mini .nxl-container {
                margin-left: 80px;
                width: calc(100% - 80px);
            }

            body.sidebar-mini .nxl-header {
                left: 80px;
                width: calc(100% - 80px);
                transition: left 0.3s cubic-bezier(0.25, 0.8, 0.25, 1), width 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
            }
            
            /* Text Handling */
            body.sidebar-mini .nxl-mtext {
                display: none;
                opacity: 0;
                white-space: nowrap;
                transition: opacity 0.2s ease;
            }

            /* Show text only after a slight delay to allow width expansion */
            body.sidebar-mini .nxl-navigation:hover .nxl-mtext {
                display: inline-block;
                opacity: 1;
                transition-delay: 0.15s; 
            }
            
            /* Caption Handling */
            body.sidebar-mini .nxl-caption label {
                display: none;
                opacity: 0;
                white-space: nowrap;
                transition: opacity 0.2s ease;
            }

            body.sidebar-mini .nxl-navigation:hover .nxl-caption label {
                display: block;
                opacity: 1;
                transition-delay: 0.15s;
            }

            /* Icon Alignment */
            body.sidebar-mini .nxl-micon {
                margin-right: 0;
                justify-content: center;
                min-width: 20px; /* Ensure icon doesn't shrink */
                transition: all 0.3s ease;
            }

            body.sidebar-mini .nxl-navigation:hover .nxl-micon {
                margin-right: 10px;
                justify-content: center; /* Keep icon centered in its space, or align if needed */
            }
            
            /* Link Justification & Padding */
            body.sidebar-mini .nxl-item .nxl-link {
                justify-content: center;
                padding-left: 0;
                padding-right: 0;
                transition: all 0.3s ease;
            }
            
            body.sidebar-mini .nxl-navigation:hover .nxl-item .nxl-link {
                justify-content: flex-start;
                padding-left: 25px; /* Add padding to align items nicely */
                padding-right: 20px;
            }
            
            /* Logo Handling - Crucial for fixing jump/cut-off */
            body.sidebar-mini .m-header {
                display: flex;
                align-items: center;
                justify-content: center; /* Center logo by default in mini */
                padding: 0;
                overflow: hidden; /* Clip overflowing content during transition */
                transition: all 0.3s ease;
            }

            body.sidebar-mini .m-header .logo-lg {
                display: none;
                opacity: 0;
                transition: opacity 0.2s ease;
            }
            
            /* Show large logo on hover with delay */
            body.sidebar-mini .nxl-navigation:hover .m-header .logo-lg {
                display: inline-block;
                opacity: 1;
                transition-delay: 0.1s; 
            }
            
            body.sidebar-mini .m-header .logo-sm {
                display: block !important;
                margin: 0 auto;
                opacity: 1;
                transition: opacity 0.1s ease;
            }

            /* Hide small logo on hover */
            body.sidebar-mini .nxl-navigation:hover .m-header .logo-sm {
                display: none !important;
                opacity: 0;
            }
            
            /* Align header content to left on hover */
            body.sidebar-mini .nxl-navigation:hover .m-header {
                justify-content: flex-start;
                padding-left: 25px; /* Match link padding */
            }

            /* Hide downloads card */
            body.sidebar-mini .nxl-navigation .card {
                display: none;
                opacity: 0;
                transition: opacity 0.2s ease;
            }
            
            body.sidebar-mini .nxl-navigation:hover .card {
                display: block;
                opacity: 1;
                transition-delay: 0.2s;
            }
            
            /* Toggle Buttons */
            body.sidebar-mini #menu-mini-button {
                display: none !important;
            }
            
            body.sidebar-mini #menu-expend-button {
                display: flex !important;
            }
        }
    </style>

    @stack('styles')
</head>

<body class="app-skin-light app-header-light app-navigation-light">
    <!--! ================================================================ !-->
    <!--! [Start] Sidebar !-->
    <!--! ================================================================ !-->
    @include('admin.partials.sidebar')
    <!--! [End] Sidebar !-->
    @include('admin.partials.header')
    <!--! ================================================================ !-->
    <!--! [Start] Main App Wrapper !-->
    <!--! ================================================================ !-->
    <div class="nxl-container">
        <!--! [Start] Header !-->
        {{-- @include('admin.partials.header') --}}
        <!--! [End] Header !-->

        <!--! ================================================================ !-->
        <!--! [Start] Main Content Area !-->
        <!--! ================================================================ !-->
        <main class="nxl-main">
            <div class="nxl-container-fluid">
                <div class="nxl-content-right">
                    <div class="nxl-content-wrapper">
                        <!--! [Start] Breadcrumb !-->
                        @if (isset($breadcrumb))
                            <nav aria-label="breadcrumb" class="mb-3">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                                    @foreach ($breadcrumb as $item)
                                        @if ($loop->last)
                                            <li class="breadcrumb-item active">{{ $item }}</li>
                                        @else
                                            <li class="breadcrumb-item"><a href="#">{{ $item }}</a></li>
                                        @endif
                                    @endforeach
                                </ol>
                            </nav>
                        @endif
                        <!--! [End] Breadcrumb !-->

                        <!--! [Start] Content !-->
                        <div class="nxl-content-body">
                            @yield('content')
                        </div>
                        <!--! [End] Content !-->
                    </div>
                </div>
            </div>
        </main>
        <!--! ================================================================ !-->
        <!--! [End] Main Content Area !-->
        <!--! ================================================================ !-->

        <!--! Footer !-->
        @include('admin.partials.footer')
    </div>
    <!--! ================================================================ !-->
    <!--! [End] Main App Wrapper !-->
    <!--! ================================================================ !-->
    <!--! [Start] Script: Vendors !-->
    <!--! ================================================================ !-->
    <script src="{{ asset('admin-template/assets/vendors/js/vendors.min.js') }}"></script>
    <script src="{{ asset('admin-template/assets/vendors/js/daterangepicker.min.js') }}"></script>
    <script src="{{ asset('admin-template/assets/vendors/js/apexcharts.min.js') }}"></script>
    <script src="{{ asset('admin-template/assets/vendors/js/circle-progress.min.js') }}"></script>
    <!--! [End] Script: Vendors !-->

    <!--! ================================================================ !-->
    <!--! [Start] Script: Theme !-->
    <!--! ================================================================ !-->
    <script src="{{ asset('admin-template/assets/js/common-init.min.js') }}"></script>
    <script src="{{ asset('admin-template/assets/js/dashboard-init.min.js') }}"></script>
    <script src="{{ asset('admin-template/assets/js/theme-customizer-init.min.js') }}"></script>
    <!--! [End] Script: Theme !-->

    <!--! Custom Scripts !-->
    <script>
        /* ─── Sidebar Toggle System ─── */
        (function() {
            var nav          = document.querySelector('.nxl-navigation');
            var body         = document.body;
            var BREAKPOINT   = 992; // px — same as Bootstrap lg

            /* ── helpers ── */
            function isMobile() { return window.innerWidth < BREAKPOINT; }

            /* ── backdrop overlay for mobile ── */
            var overlay = document.createElement('div');
            overlay.id = 'sidebar-overlay';
            overlay.style.cssText = [
                'display:none',
                'position:fixed',
                'inset:0',
                'background:rgba(0,0,0,0.45)',
                'z-index:999',
                'transition:opacity 0.3s'
            ].join(';');
            document.body.appendChild(overlay);

            function openMobileSidebar() {
                nav.classList.add('active');
                overlay.style.display = 'block';
                setTimeout(function() { overlay.style.opacity = '1'; }, 10);
                body.style.overflow = 'hidden'; // prevent background scroll
            }

            function closeMobileSidebar() {
                nav.classList.remove('active');
                overlay.style.opacity = '0';
                setTimeout(function() { overlay.style.display = 'none'; }, 300);
                body.style.overflow = '';
            }

            function collapseDesktopSidebar() {
                body.classList.add('sidebar-mini');
            }

            function expandDesktopSidebar() {
                body.classList.remove('sidebar-mini');
            }

            /* ── Hamburger (mobile ≤991px) ── */
            var mobileToggle = document.getElementById('mobile-collapse');
            if (mobileToggle) {
                mobileToggle.addEventListener('click', function(e) {
                    e.preventDefault();
                    if (isMobile()) {
                        if (nav.classList.contains('active')) {
                            closeMobileSidebar();
                        } else {
                            openMobileSidebar();
                        }
                    }
                });
            }

            /* ── Overlay click → close mobile sidebar ── */
            overlay.addEventListener('click', function() {
                closeMobileSidebar();
            });

            /* ── Mini button (collapse desktop sidebar) ── */
            var miniToggle = document.getElementById('menu-mini-button');
            if (miniToggle) {
                miniToggle.addEventListener('click', function(e) {
                    e.preventDefault();
                    if (!isMobile()) {
                        collapseDesktopSidebar();
                    }
                });
            }

            /* ── Expand button (restore full desktop sidebar) ── */
            var expendToggle = document.getElementById('menu-expend-button');
            if (expendToggle) {
                expendToggle.addEventListener('click', function(e) {
                    e.preventDefault();
                    if (!isMobile()) {
                        expandDesktopSidebar();
                    }
                });
            }

            /* ── Window resize: clean up stale state ── */
            var resizeTimer;
            window.addEventListener('resize', function() {
                clearTimeout(resizeTimer);
                resizeTimer = setTimeout(function() {
                    if (!isMobile()) {
                        // Coming from/to desktop: close any mobile state
                        closeMobileSidebar();
                    } else {
                        // Coming to mobile: remove desktop-only classes so sidebar
                        // doesn't appear stuck in mini mode on mobile
                        body.classList.remove('sidebar-mini');
                    }
                }, 150);
            });
        })();
    </script>


    <!--! [Start] Global Master Table Filter & Export -->
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // ─── FILTER: Toggle search bar & real-time filtering ───
        var filterBtn = document.querySelector('[data-filter-btn]');
        var filterRow = document.getElementById('masterFilterRow');
        var filterInput = document.getElementById('masterFilterInput');
        var filterClear = document.getElementById('masterFilterClear');
        var masterTable = document.getElementById('masterTable');

        if (filterBtn && filterRow && filterInput && masterTable) {
            filterBtn.addEventListener('click', function() {
                var isHidden = filterRow.style.display === 'none' || filterRow.style.display === '';
                filterRow.style.display = isHidden ? 'flex' : 'none';
                if (isHidden) {
                    filterInput.focus();
                } else {
                    filterInput.value = '';
                    filterTable('');
                }
            });

            filterInput.addEventListener('input', function() {
                filterTable(this.value);
            });

            if (filterClear) {
                filterClear.addEventListener('click', function() {
                    filterInput.value = '';
                    filterTable('');
                    filterInput.focus();
                });
            }

            function filterTable(keyword) {
                var rows = masterTable.querySelectorAll('tbody tr');
                var lowerKeyword = keyword.toLowerCase().trim();
                var visibleCount = 0;

                rows.forEach(function(row) {
                    if (row.querySelector('td[colspan]')) return; // skip empty-state row
                    var cells = row.querySelectorAll('td');
                    var text = '';
                    cells.forEach(function(cell, idx) {
                        // Skip last column (Aksi)
                        if (idx < cells.length - 1) {
                            text += ' ' + cell.textContent;
                        }
                    });
                    var match = text.toLowerCase().indexOf(lowerKeyword) > -1;
                    row.style.display = match ? '' : 'none';
                    if (match) visibleCount++;
                });

                // Show/hide "no results" message
                var noResult = document.getElementById('masterFilterNoResult');
                if (noResult) {
                    noResult.style.display = (visibleCount === 0 && lowerKeyword !== '') ? '' : 'none';
                }
            }
        }

        // ─── EXPORT: Download table data as CSV ───
        var exportBtn = document.querySelector('[data-export-btn]');
        if (exportBtn && masterTable) {
            exportBtn.addEventListener('click', function() {
                var exportName = exportBtn.getAttribute('data-export-name') || 'data_export';
                var thead = masterTable.querySelector('thead');
                var tbody = masterTable.querySelector('tbody');
                var csvRows = [];

                // Header row (skip last column = Aksi)
                if (thead) {
                    var headerCells = thead.querySelectorAll('th');
                    var headers = [];
                    for (var i = 0; i < headerCells.length - 1; i++) {
                        headers.push('"' + headerCells[i].textContent.trim().replace(/"/g, '""') + '"');
                    }
                    csvRows.push(headers.join(','));
                }

                // Data rows
                if (tbody) {
                    var dataRows = tbody.querySelectorAll('tr');
                    dataRows.forEach(function(row) {
                        if (row.querySelector('td[colspan]')) return; // skip empty-state
                        if (row.style.display === 'none') return; // skip filtered-out rows
                        var cells = row.querySelectorAll('td');
                        var rowData = [];
                        for (var i = 0; i < cells.length - 1; i++) {
                            var val = cells[i].textContent.trim().replace(/\s+/g, ' ').replace(/"/g, '""');
                            rowData.push('"' + val + '"');
                        }
                        csvRows.push(rowData.join(','));
                    });
                }

                // BOM for UTF-8 + download
                var csvContent = '\uFEFF' + csvRows.join('\n');
                var blob = new Blob([csvContent], { type: 'text/csv;charset=utf-8;' });
                var url = URL.createObjectURL(blob);
                var link = document.createElement('a');
                link.setAttribute('href', url);
                link.setAttribute('download', exportName + '.csv');
                document.body.appendChild(link);
                link.click();
                document.body.removeChild(link);
                URL.revokeObjectURL(url);
            });
        }
    });
    </script>
    <!--! [End] Global Master Table Filter & Export -->

    <!--! [Start] SweetAlert2 Global Handler -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // 1. Global Session Alerts
        @if(session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: "{{ session('success') }}",
                timer: 3000,
                showConfirmButton: false
            });
        @endif

        @if(session('error'))
            Swal.fire({
                icon: 'error',
                title: 'Gagal!',
                text: "{{ session('error') }}",
                confirmButtonColor: '#4b3bdb'
            });
        @endif

        // 2. Global Delete Interceptor
        document.body.addEventListener('submit', function(e) {
            let form = e.target;
            let isDelete = form && form.tagName === 'FORM' && form.querySelector('input[name="_method"][value="DELETE"]');
            
            if (isDelete || (form && form.classList.contains('form-delete'))) {
                e.preventDefault();
                let dataName = form.getAttribute('data-name') || 'data ini';
                
                Swal.fire({
                    title: 'Hapus Data?',
                    text: 'anda akan menghapus "' + dataName + '" pemulihan hanya bisa dilakukan admin.',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#dc3545',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Ya, Hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            }
        });

        // 3. Global Save Interceptor (Catch generic POST/PUT forms for Create/Edit)
        document.body.addEventListener('submit', function(e) {
            let form = e.target;
            
            if (form && form.tagName === 'FORM' && form.method.toUpperCase() === 'POST') {
                // Skip DELETE forms (handled by delete interceptor)
                if (form.querySelector('input[name="_method"][value="DELETE"]')) return;
                
                // Skip GET-method spoofing or search/filter forms
                if (form.getAttribute('method') && form.getAttribute('method').toUpperCase() === 'GET') return;

                // Skip forms that explicitly opt-out, or special system forms
                if (form.classList.contains('no-swal') || 
                    form.id === 'bulkActionForm' || 
                    form.id === 'bulkSubmitForm' || 
                    (form.action && form.action.includes('logout'))) return;

                e.preventDefault();
                
                Swal.fire({
                    title: 'Simpan Data?',
                    text: 'Apakah Anda yakin ingin menyimpan data ini?',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#4b3bdb',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Ya, Simpan!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        Swal.fire({
                            title: 'Menyimpan...',
                            allowOutsideClick: false,
                            didOpen: () => {
                                Swal.showLoading();
                            }
                        });
                        form.submit();
                    }
                });
            }
        });
    });
    </script>
    <!--! [End] SweetAlert2 Global Handler -->

    @stack('scripts')
</body>

</html>