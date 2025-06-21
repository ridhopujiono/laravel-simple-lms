<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard - Mazer Admin')</title>

    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300;400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('templates/dist/assets/css/bootstrap.css') }}">
    <link rel="stylesheet" href="{{ asset('templates/dist/assets/vendors/iconly/bold.css') }}">
    <link rel="stylesheet" href="{{ asset('templates/dist/assets/vendors/perfect-scrollbar/perfect-scrollbar.css') }}">
    <link rel="stylesheet" href="{{ asset('templates/dist/assets/vendors/bootstrap-icons/bootstrap-icons.css') }}">
    <link rel="stylesheet" href="{{ asset('templates/dist/assets/css/app.css') }}">
    <link rel="shortcut icon" href="{{ asset('templates/dist/assets/images/favicon.svg') }}" type="image/x-icon">
    <!-- Include Editor style. -->
    <script src="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.snow.css" rel="stylesheet">
    @commentsStyles
</head>

<body>
    <div id="app">
        @include('layouts.sidebar')
        <div id="main">
            @include('layouts.topbar')

            <div class="page-content">
                @yield('content')
            </div>

            @include('layouts.footer')
        </div>
    </div>

    <script src="{{ asset('templates/dist/assets/vendors/perfect-scrollbar/perfect-scrollbar.min.js') }}"></script>
    <script src="{{ asset('templates/dist/assets/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('templates/dist/assets/vendors/apexcharts/apexcharts.js') }}"></script>
    <script src="{{ asset('templates/dist/assets/js/pages/dashboard.js') }}"></script>
    <script src="{{ asset('templates/dist/assets/js/main.js') }}"></script>

    @stack('scripts')
    @commentsScripts
</body>

</html>
