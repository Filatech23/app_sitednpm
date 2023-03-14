<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <!-- <script src="{{ asset('js/app.js') }}" defer></script> -->

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <!-- Styles -->
    <link href="{{ asset('assets/css/app.min.css') }}" rel="stylesheet">
    
    <!-- Css du template  -->
    <script src="{{ asset('assets/js/layout.js') }}"></script>
        <!-- Bootstrap Css -->
        <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
        <!-- Icons Css -->
        <link href="{{ asset('assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
        <!-- App Css-->
        <link href="{{ asset('assets/css/mystyle.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ asset('assets/css/app.min.css') }}" rel="stylesheet" type="text/css" />
        <!-- custom Css-->
        <link href="{{ asset('assets/css/custom.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- Fin : Css du template  -->

</head>
<body >
    <style>
        .auth-fluid {
            position: relative;
            display: flex;
            align-items: center;
            min-height: 100vh;
            flex-direction: row;
            align-items: stretch;
            background: url(../assets/docs/logos/bg-auth.jpg) center;
            background-size: cover;
        }
        .auth-fluid .auth-fluid-form-box {
            max-width: 480px;
            border-radius: 0;
            z-index: 2;
            padding: 3rem 2rem;
            background-color: #fff;
            position: relative;
            width: 100%;
        }
        .h-100 {
            height: 100%!important;
        }
        .align-items-center {
            align-items: center!important;
        }
        .d-flex {
            display: flex!important;
        }
        .auth-fluid .auth-fluid-right {
            padding: 6rem 3rem;
            flex: 1;
            position: relative;
            color: #fff;
            background-color: rgba(0,0,0,.3);
        }

        .auth-user-testimonial {
            position: absolute;
            margin: 0 auto;
            padding: 0 1.75rem;
            bottom: 3rem;
            left: 0;
            right: 0;
        }
    </style>
    <div id="app">
        <!-- py-4 -->
        <main class="">
            @yield('content')
        </main>
    </div>

    <!-- FIN : TEMPALTE -->
    <!-- @yield('JS_content') -->
    <script src="{{ asset('assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
        <script src="{{ asset('assets/libs/simplebar/simplebar.min.js') }}"></script>
        <script src="{{ asset('assets/libs/node-waves/waves.min.js') }}"></script>
        <script src="{{ asset('assets/libs/feather-icons/feather.min.js') }}"></script>
        <script src="{{ asset('assets/js/pages/plugins/lord-icon-2.1.0.js') }}"></script>
        <script src="{{ asset('assets/js/plugins.js') }}"></script>

        <!-- particles js -->
        <script src="{{ asset('assets/libs/particles.js/particles.js') }}"></script>
        <!-- particles app js -->
        <script src="{{ asset('assets/js/pages/particles.app.js') }}"></script>
        <!-- password-addon init -->
        <script src="{{ asset('assets/js/pages/password-addon.init.js') }}"></script>

        <!-- App js -->
        <script src="{{ asset('assets/js/app.js') }}"></script>
</body>
</html>
