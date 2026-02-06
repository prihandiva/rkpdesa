<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Admin Login')</title>

    @if (file_exists(public_path('admin-template/assets/vendors/css/vendors.min.css')))
        <link rel="stylesheet" href="{{ asset('admin-template/assets/vendors/css/vendors.min.css') }}">
    @endif

    @if (file_exists(public_path('admin-template/assets/css/bootstrap.min.css')))
        <link rel="stylesheet" href="{{ asset('admin-template/assets/css/bootstrap.min.css') }}">
        @if (file_exists(public_path('admin-template/assets/css/theme.min.css')))
            <link rel="stylesheet" href="{{ asset('admin-template/assets/css/theme.min.css') }}">
        @endif
    @else
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet">
    @endif

    @stack('styles')
</head>

<body class="d-flex align-items-center" style="min-height:100vh;">
    <div class="container">
        @yield('content')
    </div>

    @if (file_exists(public_path('admin-template/assets/vendors/js/jquery.min.js')))
        <script src="{{ asset('admin-template/assets/vendors/js/jquery.min.js') }}"></script>
    @else
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    @endif

    @if (file_exists(public_path('admin-template/assets/vendors/js/vendors.min.js')))
        <script src="{{ asset('admin-template/assets/vendors/js/vendors.min.js') }}"></script>
    @endif

    @if (file_exists(public_path('admin-template/assets/js/bootstrap.min.js')))
        <script src="{{ asset('admin-template/assets/js/bootstrap.min.js') }}"></script>
    @else
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"></script>
    @endif

    @stack('scripts')
</body>

</html>
