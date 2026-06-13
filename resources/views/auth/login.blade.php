<!doctype html>
<html lang="id">

<head>
    <meta charset="utf-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">

    <meta name="theme-color" content="#233E86">

    <title>E-Absensi</title>

    <link rel="icon" type="image/png" href="{{ asset('assets/img/favicon.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('assets/img/icon/192x192.png') }}">

    <link rel="stylesheet" href="{{ asset('assets/css/inc/bootstrap/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">

    <style>
        * {
            box-sizing: border-box;
        }

        html,
        body {
            margin: 0;
            padding: 0;
            width: 100%;
            min-height: 100vh;
            overflow-x: hidden;
            background: #233E86;
            font-family: Arial, sans-serif;
        }

        .login-page {
            width: 100%;
            min-height: 100vh;
            background: #233E86;
            padding: 35px 22px 25px;
            display: flex;
            flex-direction: column;
        }

        .login-logo {
            width: 145px;
            margin-bottom: 25px;
        }

        .login-title {
            color: #ffffff;
            font-size: 32px;
            font-weight: 800;
            margin-bottom: 6px;
        }

        .login-subtitle {
            color: #ffffff;
            font-size: 17px;
            font-weight: 700;
            margin-bottom: 26px;
        }

        .form-group {
            margin-bottom: 14px;
        }

        .input-wrapper {
            position: relative;
            width: 100%;
        }

        .input-icon {
            position: absolute;
            left: 16px;
            top: 50%;
            transform: translateY(-50%);
            color: #2563eb;
            font-size: 23px;
            z-index: 2;
        }

        .eye-icon {
            position: absolute;
            right: 16px;
            top: 50%;
            transform: translateY(-50%);
            color: #2563eb;
            font-size: 23px;
            cursor: pointer;
            z-index: 2;
        }

        .form-control {
            width: 100%;
            height: 56px;
            border-radius: 15px;
            border: none;
            font-size: 16px;
            padding-left: 52px;
            padding-right: 52px;
            background: #ffffff;
            box-shadow: 0 2px 6px rgba(0,0,0,0.25);
        }

        .form-control:focus {
            outline: none;
            box-shadow: 0 0 0 3px rgba(250, 204, 21, 0.45);
        }

        .forgot {
            display: block;
            color: #ffffff;
            font-size: 14px;
            margin: 4px 0 14px;
            text-decoration: underline;
        }

        .btn-login {
            width: 100%;
            height: 52px;
            border: none;
            border-radius: 14px;
            background: #F5C000;
            color: #000000;
            font-size: 16px;
            font-weight: 800;
            box-shadow: 0 3px 7px rgba(0,0,0,0.25);
        }

        .btn-login:active {
            transform: scale(0.98);
        }

        .footer-logo {
            margin-top: auto;
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 10px;
            padding-top: 35px;
        }

        .footer-logo img {
            width: 40px;
            height: 40px;
            object-fit: contain;
        }

        .footer-logo span {
            color: #F5C000;
            font-size: 13px;
            font-weight: 800;
            white-space: nowrap;
        }

        .alert {
            border-radius: 12px;
            font-size: 14px;
        }
    </style>
</head>

<body>

<div class="login-page">

    <img src="{{ asset('assets/img/login/fingerlocation.png') }}"
         class="login-logo"
         alt="Logo Absensi">

    <h1 class="login-title">E-Absensi</h1>
    <div class="login-subtitle">Silahkan Login</div>

    @if(Session::has('warning'))
        <div class="alert alert-danger">
            {{ Session::get('warning') }}
        </div>
    @endif

    <form action="/proseslogin" method="POST">
    @csrf

        <div class="form-group">
            <div class="input-wrapper">
                <ion-icon name="person-outline" class="input-icon"></ion-icon>

                <input type="text"
                       name="nik"
                       class="form-control"
                       placeholder="NIK"
                       autocomplete="off"
                       required>
            </div>
        </div>

        <div class="form-group">
            <div class="input-wrapper">
                <ion-icon name="key-outline" class="input-icon"></ion-icon>

                <input type="password"
                       name="password"
                       id="password"
                       class="form-control"
                       placeholder="Password"
                       autocomplete="off"
                       required>

                <ion-icon id="togglePassword"
                          name="eye-off-outline"
                          class="eye-icon"></ion-icon>
            </div>
        </div>

        <a href="#" class="forgot">Forgot Password?</a>

        <button type="submit" class="btn-login">
            Log in
        </button>
    </form>

    <div class="footer-logo">
        <img src="{{ asset('assets/img/login/logo.png') }}" alt="Logo PT">
        <span>PT PRABU PERMANA PUTRA</span>
    </div>

</div>

<script src="{{ asset('assets/js/lib/jquery-3.4.1.min.js') }}"></script>
<script src="{{ asset('assets/js/lib/popper.min.js') }}"></script>
<script src="{{ asset('assets/js/lib/bootstrap.min.js') }}"></script>

<script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const password = document.getElementById("password");
        const toggle = document.getElementById("togglePassword");

        toggle.addEventListener("click", function () {
            if (password.type === "password") {
                password.type = "text";
                toggle.setAttribute("name", "eye-outline");
            } else {
                password.type = "password";
                toggle.setAttribute("name", "eye-off-outline");
            }
        });
    });
</script>

</body>
</html>