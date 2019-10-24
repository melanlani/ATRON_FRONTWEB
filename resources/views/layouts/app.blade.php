<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <link rel="shortcut icon" href="{{ asset('/assets/images/atron/logo-inverse.png') }}" type="image/x-icon">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>ATRON- Do It Easy And Achieve More.</title>

    <!-- Scripts -->
    <script src="{{ asset('assets/scripts/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('assets/css/app.css') }}" rel="stylesheet">
    <style type="text/css">
        #main {
            background-image: url({{ asset('/assets/images/atron/login.jpg') }});
            height: 657px;
            width: 1366px;
            background-repeat: no-repeat;
        }
        .card {
            margin-top: 150px;
            background-color: #ffffff7d;
        }
    </style>
</head>
<body>
    <div id="main">
        <main class="py-4">
            @yield('content')
        </main>
    </div>
</body>
</html>
