<!doctype html>
<html lang="id">

<head>

    <meta charset="utf-8">

    <!-- MOBILE -->
    <meta name="viewport"
          content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">

    <meta name="theme-color" content="#1d4ed8">

    <meta name="mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-capable" content="yes">

    <!-- ANTI CACHE -->
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate">
    <meta http-equiv="Pragma" content="no-cache">
    <meta http-equiv="Expires" content="0">

    <!-- TITLE -->
    <title>E-Absensi</title>

    <!-- PWA -->
    <link rel="manifest" href="{{ asset('manifest.json') }}">

    <!-- ICON -->
    <link rel="icon"
          type="image/png"
          href="{{ asset('assets/img/favicon.png') }}">

    <link rel="apple-touch-icon"
          href="{{ asset('assets/img/icon/192x192.png') }}">

    <!-- CSS -->
    <link rel="stylesheet"
          href="{{ asset('assets/css/inc/bootstrap/bootstrap.min.css') }}">

    <link rel="stylesheet"
          href="{{ asset('assets/css/style.css') }}">

    <link rel="stylesheet"
          href="{{ asset('assets/css/inc/owl-carousel/owl.carousel.min.css') }}">

    <link rel="stylesheet"
          href="{{ asset('assets/css/inc/owl-carousel/owl.theme.default.css') }}">

    <!-- STYLE -->
    <style>

        html,
        body{
            margin:0;
            padding:0;
            width:100%;
            min-height:100vh;
            overflow-x:hidden;
            background:#1d3b8b;
            font-family:Arial, sans-serif;
        }

        body{
            display:flex;
            flex-direction:column;
        }

        #appCapsule{
            width:100%;
            overflow-x:hidden;
            flex:1;
            padding-bottom:80px;
        }

        /* LOGIN FORM */

        .login-form{
            width:100%;
            padding:25px;
            margin-top:10px;
        }

        .login-form .section{
            margin-bottom:18px;
        }

        /* INPUT */

        .form-control{
            width:100% !important;
            height:55px !important;
            border-radius:16px !important;
            font-size:16px !important;
            padding-left:50px !important;
            border:none !important;
            box-shadow:none !important;
        }

        /* BUTTON */

        .btn{
            width:100%;
            height:50px;
            border-radius:14px;
            font-size:16px;
            font-weight:bold;
            border:none;
            background:#facc15;
            color:#000;
        }

        .btn:hover{
            background:#eab308;
            color:#000;
        }

        /* IMAGE */

        img{
            max-width:100%;
            height:auto;
        }

        /* LOGO */

        .logo-login{
            width:120px;
            display:block;
            margin:auto;
            margin-top:20px;
            margin-bottom:20px;
        }

        .logo-bottom{
            width:180px;
            display:block;
            margin:auto;
            margin-top:40px;
        }

        /* TITLE */

        .title-login{
            color:#fff;
            font-size:22px;
            font-weight:bold;
            text-align:left;
            margin-bottom:5px;
        }

        .subtitle-login{
            color:#fff;
            font-size:16px;
            margin-bottom:20px;
        }

        /* LINK */

        a{
            color:#fff;
        }

        /* MOBILE */

        @media(max-width:768px){

            .login-form{
                padding:20px;
            }

            .form-control{
                height:52px !important;
                font-size:15px !important;
            }

            .btn{
                height:48px;
                font-size:15px;
            }

        }

    </style>

</head>

<body>

    @yield('header')

    <div id="appCapsule">
        @yield('content')
    </div>

    @include('layouts.bottomNav')

    @include('layouts.script')

    @stack('myscript')

</body>

</html>