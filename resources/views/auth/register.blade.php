<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrasi - Sistem Pelaporan</title>
    <style>
        * { box-sizing: border-box; }
        body {
            margin: 0; min-height: 100vh; padding: 24px;
            display: flex; align-items: center; justify-content: center;
            background: #e0e6ed;
            font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
        }
        .register-card {
            width: 100%; max-width: 520px; padding: 42px;
            background: #fff; border-radius: 24px;
            box-shadow: 0 10px 25px rgba(0,0,0,.10);
        }
        h1 { margin: 0; color: #212035; font-size: 25px; text-align: center; }
        .subtitle { margin: 9px 0 28px; color: #718096; font-size: 13px; text-align: center; line-height: 1.6; }
        .form-group { margin-bottom: 18px; }
        label { display: block; margin-bottom: 7px; color: #303044; font-size: 13px; font-weight: 700; }
        input {
            width: 100%; height: 46px; padding: 0 14px;
            border: 1px solid #d5dbe3; border-radius: 10px;
            color: #212035; font: inherit; font-size: 13px; outline: none;
        }
        input:focus { border-color: #64748b; box-shadow: 0 0 0 3px rgba(100,116,139,.12); }
        .hint { margin-top: 6px; color: #718096; font-size: 11px; }
        .error-box { margin-bottom: 18px; padding: 12px 15px; border-radius: 10px; background: #f8d7da; color: #842029; font-size: 12px; }
        .error-box ul { margin: 0; padding-left: 18px; }
        .btn-register {
            width: 100%; height: 47px; margin-top: 5px; border: 0;
            border-radius: 24px; background: #1f1f2e; color: #fff;
            font: inherit; font-size: 13px; font-weight: 700; cursor: pointer;
        }
        .btn-register:hover { background: #343449; }
        .login-link { margin-top: 20px; color: #718096; font-size: 12px; text-align: center; }
        a { color: #343449; font-weight: 700; }
        @media (max-width: 520px) { .register-card { padding: 30px 22px; } }
    </style>
</head>
<body>
    <main class="register-card">
        <h1>Registrasi Akun</h1>
        <p class="subtitle">Buat akun pelapor menggunakan email mahasiswa Universitas Malikussaleh.</p>

        @if ($errors->any())
            <div class="error-box">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('register.process') }}" method="POST">
            @csrf

            <div class="form-group">
                <label for="name">Nama Lengkap</label>
                <input type="text" id="name" name="name" value="{{ old('name') }}"
                    placeholder="Masukkan nama lengkap" maxlength="255" required autofocus>
            </div>

            <div class="form-group">
                <label for="email">Email Mahasiswa</label>
                <input type="email" id="email" name="email" value="{{ old('email') }}"
                    placeholder="nama@mhs.unimal.ac.id" required>
                <div class="hint">Wajib menggunakan alamat email @mhs.unimal.ac.id.</div>
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password"
                    placeholder="Minimal 8 karakter" minlength="8" required>
            </div>

            <div class="form-group">
                <label for="password_confirmation">Konfirmasi Password</label>
                <input type="password" id="password_confirmation" name="password_confirmation"
                    placeholder="Ulangi password" minlength="8" required>
            </div>

            <button type="submit" class="btn-register">Daftar</button>
        </form>

        <div class="login-link">
            Sudah punya akun? <a href="{{ route('login') }}">Login di sini</a>
        </div>
    </main>
</body>
</html>
