<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Suplemen App')</title>
    <meta name="theme-color" content="#0d6efd">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="mobile-web-app-capable" content="yes">

    <!-- PWA Manifest -->
    <link rel="manifest" href="{{ asset('mobile/manifest.json') }}">
    <link rel="apple-touch-icon" href="{{ asset('mobile/app/icons/icon-192x192.png') }}">


    <link rel="stylesheet" href="{{ asset('mobile/styles/bootstrap.css') }}">
    <link rel="stylesheet" href="{{ asset('mobile/styles/style.css') }}">
    <link rel="stylesheet" href="{{ asset('mobile/fonts/css/fontawesome-all.min.css') }}">

    {{-- <link rel="stylesheet" href="{{ asset('mobile/styles/bootstrap.css') }}">
    <link rel="stylesheet" href="{{ asset('mobile/styles/style.css') }}">
    <link rel="stylesheet" href="{{ asset('mobile/fonts/css/fontawesome-all.min.css') }}"> --}}
    {{-- <link rel="manifest" href="{{ asset('mobile/_manifest.json') }}" data-pwa-version="set_in_manifest_and_pwa_js">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('mobile/app/icons/icon-192x192.png') }}">
</head> --}}

<body class="theme-light" data-highlight="blue2">

    <div id="preloader">
        <div class="spinner-border color-highlight" role="status"></div>
    </div>

    <div id="page">
        {{-- Header --}}
        <div class="header header-fixed header-auto-show header-logo-app">
            <a href="#" class="header-title">AZURES</a>
            <a href="#" data-menu="menu-main" class="header-icon header-icon-1"><i class="fas fa-bars"></i></a>
            <a href="#" data-toggle-theme class="header-icon header-icon-2 show-on-theme-dark"><i
                    class="fas fa-sun"></i></a>
            <a href="#" data-toggle-theme class="header-icon header-icon-2 show-on-theme-light"><i
                    class="fas fa-moon"></i></a>
            <a href="#" data-menu="menu-highlights" class="header-icon header-icon-3"><i
                    class="fas fa-brush"></i></a>
        </div>

        {{-- Page content --}}
        @yield('content')

        {{-- Footer --}}
    </div>

    <script src="{{ asset('mobile/scripts/bootstrap.min.js') }}"></script>
    <script src="{{ asset('mobile/scripts/custom.js') }}"></script>
    <script src="{{ asset('mobile/_service-worker.js') }}"></script>

    @stack('scripts')
</body>

</html>
