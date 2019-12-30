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
            background-repeat: no-repeat;
            background-attachment: fixed;
            background-position: center;
            -webkit-background-size: 100% 100%;
            -moz-background-size: 100% 100%;
            -o-background-size: 100% 100%;
            background-size: 100% 100%;
        }
        .card {
            margin-top: 100px;
            background-color: #ffffff7d;
        }
        .col-form-new-label {
            padding-top: calc(.375rem + 1px);
            padding-bottom: calc(.375rem + 1px);
            margin-bottom: 0;
            font-size: 11px;
            line-height: 0.6;
        }
        .text-md-center {
            text-align: -webkit-center;
        }
        .text-color {
            color: red;
        }
    </style>
</head>
<body id="main">
        <main class="py-4">
            @yield('content')
        </main>
</body>
</html>
