<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Login - Sistem Pelaporan</title>

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            min-height: 100vh;

            background-color: #e0e6ed;

            font-family:
                "Segoe UI",
                Tahoma,
                Geneva,
                Verdana,
                sans-serif;

            display: flex;
            align-items: center;
            justify-content: center;

            padding: 20px;
        }


        /* =========================================
           LOGIN CARD
        ========================================= */

        .login-card {
            width: 100%;
            max-width: 900px;

            min-height: 560px;

            background: #ffffff;

            display: flex;

            border-radius: 30px;

            overflow: hidden;

            box-shadow:
                0 10px 25px rgba(0, 0, 0, 0.10);
        }


        /* =========================================
           PANEL KIRI
        ========================================= */

        .panel-left {
            width: 50%;

            padding: 50px;

            display: flex;
            flex-direction: column;

            align-items: center;
            justify-content: center;

            text-align: center;
        }


        .panel-left h1 {
            margin: 0 0 30px;

            font-size: 22px;

            line-height: 1.4;

            color: #212035;
        }


        /* =========================================
           LOGO
        ========================================= */

        .logo-wrapper {
            margin-bottom: 25px;
        }


        .logo-wrapper img {
            display: block;

            width: 150px;
            height: auto;
        }


        .panel-description {
            margin: 0;

            max-width: 350px;

            color: #718096;

            font-size: 13px;

            font-weight: 600;

            line-height: 1.6;
        }


        /* =========================================
           PANEL KANAN
        ========================================= */

        .panel-right {
            width: 50%;

            background-color: #1f1f2e;

            padding: 50px;

            color: #ffffff;

            display: flex;
            flex-direction: column;
            justify-content: center;
        }


        .panel-right h2 {
            margin: 0;

            text-align: center;

            font-size: 28px;

            font-weight: 700;
        }


        .login-subtitle {
            margin: 8px 0 30px;

            text-align: center;

            color: #ffffff;

            opacity: 0.8;

            font-size: 12px;
        }


        /* =========================================
           ERROR
        ========================================= */

        .alert-error {
            margin-bottom: 20px;

            padding: 12px 15px;

            background: #f8d7da;

            color: #842029;

            border-radius: 10px;

            font-size: 12px;
        }


        .alert-error ul {
            margin: 0;

            padding-left: 18px;
        }


        /* =========================================
           FORM
        ========================================= */

        .form-group {
            margin-bottom: 20px;
        }


        .form-label {
            display: block;

            margin-bottom: 8px;

            color: #ffffff;

            font-size: 12px;

            font-weight: 700;
        }


        .input-wrapper {
            position: relative;
        }


        .input-icon {
            position: absolute;

            left: 15px;
            top: 50%;

            transform: translateY(-50%);

            color: #4A5568;

            z-index: 2;

            width: 18px;
            height: 18px;
        }

        .input-icon svg {
            width: 100%;
            height: 100%;

            fill: currentColor;
        }


        .form-input {
            width: 100%;

            height: 48px;

            padding: 0 45px;

            border: none;

            border-radius: 12px;

            background: #ffffff;

            color: #212035;

            font-family: inherit;

            font-size: 13px;

            outline: none;
        }


        .form-input::placeholder {
            color: #a0aec0;
        }


        .form-input:focus {
            outline: 2px solid #a0aec0;
        }


        /* =========================================
           PASSWORD EYE
        ========================================= */

        .eye-button {
            position: absolute;

            right: 15px;
            top: 50%;

            transform: translateY(-50%);

            width: 20px;
            height: 20px;

            padding: 0;

            border: none;

            background: transparent;

            color: #4A5568;

            cursor: pointer;

            display: flex;
            align-items: center;
            justify-content: center;
        }

        .eye-button svg {
            width: 18px;
            height: 18px;

            fill: currentColor;
        }


        /* =========================================
           LOGIN BUTTON
        ========================================= */

        .btn-login {
            width: 100%;

            height: 48px;

            margin-top: 5px;

            border: none;

            border-radius: 30px;

            background-color: #a0aec0;

            color: #1f1f2e;

            font-family: inherit;

            font-size: 13px;

            font-weight: 700;

            cursor: pointer;

            transition: 0.2s ease;
        }


        .btn-login:hover {
            background-color: #cbd5e0;
        }


        /* =========================================
           LUPA PASSWORD
        ========================================= */

        .forgot-password {
            margin-top: 15px;

            text-align: right;
        }


        .forgot-password a {
            color: #ffffff;

            opacity: 0.8;

            font-size: 12px;

            text-decoration: underline;

            transition: 0.2s ease;
        }


        .forgot-password a:hover {
            opacity: 1;
        }


        /* =========================================
           COPYRIGHT
        ========================================= */

        .copyright {
            margin-top: 35px;

            text-align: center;

            color: #ffffff;

            opacity: 0.8;

            font-size: 11px;
        }


        /* =========================================
           RESPONSIVE
        ========================================= */

        @media (max-width: 768px) {

            .login-card {
                flex-direction: column;

                max-width: 500px;
            }


            .panel-left,
            .panel-right {
                width: 100%;
            }


            .panel-left {
                padding: 40px 30px;
            }


            .panel-right {
                padding: 40px 30px;
            }


            .panel-left h1 {
                font-size: 20px;
            }

        }
    </style>
</head>


<body>


    <div class="login-card">


        <!-- =====================================
             PANEL KIRI
        ====================================== -->

        <div class="panel-left">

            <h1>
                Sistem Pelaporan Kerusakan<br>
                Fasilitas Fakultas Teknik
            </h1>


            <div class="logo-wrapper">

                <img
                    src="{{ asset('images/logo-unimal.png') }}"
                    alt="Logo Universitas Malikussaleh"
                >

            </div>


            <p class="panel-description">
                Silakan masuk menggunakan akun Anda untuk
                mulai membuat atau mengelola laporan kerusakan.
            </p>

        </div>


        <!-- =====================================
             PANEL KANAN
        ====================================== -->

        <div class="panel-right">

            <h2>
                Login Form
            </h2>


            <p class="login-subtitle">
                Masukkan email dan password akun Anda
            </p>


            <!-- ERROR -->

            @if ($errors->any())

                <div class="alert-error">

                    <ul>

                        @foreach ($errors->all() as $error)

                            <li>
                                {{ $error }}
                            </li>

                        @endforeach

                    </ul>

                </div>

            @endif


            <!-- FORM -->

            <form
                action="{{ route('login.process') }}"
                method="POST"
            >

                @csrf


                <!-- EMAIL -->

                <div class="form-group">

                    <label
                        for="email"
                        class="form-label"
                    >
                        Email
                    </label>


                    <div class="input-wrapper">

                        <span class="input-icon">
                            <svg viewBox="0 0 24 24">
                                <path d="M3 5h18v14H3V5zm2 2v.5l7 5 7-5V7l-7 5-7-5z"/>
                            </svg>
                        </span>


                        <input
                            type="email"
                            id="email"
                            name="email"
                            class="form-input"
                            value="{{ old('email') }}"
                            placeholder="Masukkan email"
                            required
                        >

                    </div>

                </div>


                <!-- PASSWORD -->

                <div class="form-group">

                    <label
                        for="password"
                        class="form-label"
                    >
                        Password
                    </label>


                    <div class="input-wrapper">

                        <span class="input-icon">
                            <svg viewBox="0 0 24 24">
                                <path d="M17 9V7a5 5 0 0 0-10 0v2H5v12h14V9h-2zm-8-2a3 3 0 0 1 6 0v2H9V7zm3 5a2 2 0 0 1 1 3.73V18h-2v-2.27A2 2 0 0 1 12 12z"/>
                            </svg>
                        </span>


                        <input
                            type="password"
                            id="password"
                            name="password"
                            class="form-input"
                            placeholder="Masukkan Password"
                            required
                        >


                        <button
                            type="button"
                            class="eye-button"
                            id="togglePassword"
                            aria-label="Tampilkan password"
                        >
                            <svg id="eyeIcon" viewBox="0 0 24 24">
                                <path d="M12 5c-5 0-9 7-9 7s4 7 9 7 9-7 9-7-4-7-9-7zm0 12a5 5 0 1 1 0-10 5 5 0 0 1 0 10zm0-2a3 3 0 1 0 0-6 3 3 0 0 0 0 6z"/>
                            </svg>
                        </button>

                    </div>

                </div>


                <!-- LOGIN -->

                <button
                    type="submit"
                    class="btn-login"
                >
                    Login
                </button>

            </form>


            <!-- REGISTRASI -->
            <div class="forgot-password" style="text-align: center; margin-top: 18px;">
                Belum punya akun?
                <a href="{{ route('register') }}">Daftar di sini</a>
            </div>

            <!-- LUPA PASSWORD -->
            <div class="forgot-password">
                <a href="{{ route('password.request') }}">
                    Lupa Password?
                </a>
            </div>


            <!-- COPYRIGHT -->

            <div class="copyright">
                © 2026 Universitas Malikussaleh
            </div>

        </div>

    </div>


    <script>
        const togglePassword = document.getElementById('togglePassword');
        const passwordInput = document.getElementById('password');
        const eyeIcon = document.getElementById('eyeIcon');

        togglePassword.addEventListener('click', function () {

            if (passwordInput.type === 'password') {

                passwordInput.type = 'text';

                eyeIcon.innerHTML = `
                    <path d="M3.27 2L2 3.27l3.1 3.1C3.05 7.84 1.5 10 1.5 12
                    c0 0 3.5 7 10.5 7 1.93 0 3.57-.5 4.94-1.23L19.73 21
                    21 19.73 3.27 2zM12 17c-2.76 0-5.19-2.12-7.08-5
                    .73-1.06 1.54-2.15 2.48-2.95l2.15 2.15A3 3 0 0 0 12 15
                    c.28 0 .55-.04.8-.11l2.16 2.16C14.1 16.7 13.08 17 12 17z"/>
                `;

            } else {

                passwordInput.type = 'password';

                eyeIcon.innerHTML = `
                    <path d="M12 5c-5 0-9 7-9 7s4 7 9 7 9-7 9-7-4-7-9-7zm0
                    12a5 5 0 1 1 0-10 5 5 0 0 1 0 10zm0-2a3 3 0 1 0 0-6
                    3 3 0 0 0 0 6z"/>
                `;
            }
        });
    </script>


</body>

</html>