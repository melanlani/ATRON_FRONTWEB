    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="Content-Language" content="en">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <link rel="shortcut icon" href="{{ asset('/assets/images/atron/logo-inverse.png') }}" type="image/x-icon">
    <title>ATRON- Do It Easy And Achieve More.</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, shrink-to-fit=no" />
    <meta name="description" content="This is an example dashboard created using build-in elements and components.">
    <meta name="msapplication-tap-highlight" content="no">

    <link rel="stylesheet" type="text/css" href="{{ asset('/assets/css/pe-icon-7-stroke.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('/assets/css/main.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('/assets/css/jquery.dataTables.css') }}">
    <style type="text/css">
    .app-header__logo .logo-src{
        background: url({{ asset('/assets/images/atron/logo-inverse.png') }});
        width: 150px; height: 54px; margin-left: 22px
    }
    .hamburger-inner, .hamburger-inner::before, .hamburger-inner::after{
        background-color: #d41515;
    }
    .hamburger.is-active .hamburger-inner, .hamburger.is-active .hamburger-inner::before, .hamburger.is-active .hamburger-inner::after{
        background-color: #d41515;
    }
    .app-theme-white .app-footer .app-footer__inner, .app-theme-white .app-header{
        background: #ffffff;
    }
    .app-sidebar__heading{
        color: #bd0606;
    }
    .btn-danger{
        background-color: #ce0c0c;
    }
    .text-red {
        color: #ce0c0c;
    }
    .bg-red{
        background-color: #ce0c0c;
    }
    .badge-danger{
        background-color: #ce0c0c;
    }
    .btn-outline-danger:hover{
        background-color: #ce0c0c;
    }
    .loader {
        position: fixed;
        left: 0px;
        top: 0px;
        width: 100%;
        height: 100%;
        z-index: 9999;
        opacity: .8;
        background: url({{ asset('/assets/images/atron/loading2.gif') }}) 50% 50% no-repeat rgb(249,249,249);
    }
    </style>