<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="x-ua-compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="description" content="RKP Desa Management System - Powered by Duralux" />
    <meta name="keyword" content="rkp, desa, management" />
    <meta name="author" content="RKP Desa Team" />

    <!--! Title !-->
    <title>@yield('title', 'Dashboard') - RKP Desa</title>

    <!--! Favicon !-->
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('admin-template/assets/images/Logo Sipdes 2 Persegi.png') }}" />

    <!--! Bootstrap CSS !-->
    <link rel="stylesheet" type="text/css" href="{{ asset('admin-template/assets/css/bootstrap.min.css') }}" />

    <!--! Vendors CSS !-->
    <link rel="stylesheet" type="text/css" href="{{ asset('admin-template/assets/vendors/css/vendors.min.css') }}" />
    <link rel="stylesheet" type="text/css"
        href="{{ asset('admin-template/assets/vendors/css/daterangepicker.min.css') }}" />

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
        
        /* Fix for last row being cut off in tables */
        .table-responsive {
            margin-bottom: 0;
            padding-bottom: 20px !important;
            overflow-x: auto;
        }
        
        /* Force margin at the bottom of the table to prevent clipping of shadows/borders and push footer down */
        .table-responsive > .table.mb-0 {
            margin-bottom: 0 !important;
        }

        /* Allow overflow on desktop to prevent clipping of dropdowns/shadows */
        @media (min-width: 992px) {
            .table-responsive {
                overflow: visible !important;
            }
        }

        /* Smaller Pagination */
        .page-link {
            font-size: 11px !important;
            padding: 0.4rem 0.6rem !important;
        }

        .page-item .page-link {
            display: flex;
            align-items: center;
            height: 30px;
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
        (function() {
            // Mobile navigation toggle
            var mobileToggle = document.getElementById('mobile-collapse');
            var nav = document.querySelector('.nxl-navigation');

            if (mobileToggle && nav) {
                mobileToggle.addEventListener('click', function(e) {
                    e.preventDefault();
                    nav.classList.toggle('active');
                });
            }

            // Desktop mini menu toggle
            var miniToggle = document.getElementById('menu-mini-button');
            var expendToggle = document.getElementById('menu-expend-button');
            var body = document.body;

            function toggleSidebar(e) {
                e.preventDefault();
                body.classList.toggle('sidebar-mini');
            }

            if (miniToggle) {
                miniToggle.addEventListener('click', toggleSidebar);
            }
            
            if (expendToggle) {
                expendToggle.addEventListener('click', toggleSidebar);
            }
        })();
    </script>

    @stack('scripts')
</body>

</html>
