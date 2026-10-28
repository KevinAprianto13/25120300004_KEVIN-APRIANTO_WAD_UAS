<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Akun - GudangKu</title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
            background-color: #f5f5f5;
            color: #333;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        .register-card {
            background-color: #fff;
            border: 1px solid #ddd;
            border-radius: 4px;
            width: 100%;
            max-width: 400px;
            padding: 28px;
        }
        .register-header {
            text-align: center;
            margin-bottom: 20px;
        }
        .register-header h1 {
            font-size: 20px;
            font-weight: 700;
            color: #333;
        }
        .register-header p {
            font-size: 13px;
            color: #777;
            margin-top: 4px;
        }
        .form-group { margin-bottom: 14px; }
        .form-label {
            display: block;
            margin-bottom: 4px;
            font-size: 13px;
            font-weight: 600;
            color: #444;
        }
        .form-control {
            width: 100%;
            padding: 8px 10px;
            border: 1px solid #ccc;
            border-radius: 3px;
            font-size: 14px;
            font-family: inherit;
        }
        .form-control:focus {
            outline: none;
            border-color: #2980b9;
        }
        .btn-submit {
            width: 100%;
            background-color: #2980b9;
            color: #fff;
            border: none;
            padding: 9px;
            border-radius: 3px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            margin-top: 6px;
            font-family: inherit;
        }
        .btn-submit:hover { background-color: #2472a4; }
        .footer-link {
            text-align: center;
            margin-top: 16px;
            font-size: 13px;
            color: #777;
        }
        .footer-link a {
            color: #2980b9;
            text-decoration: none;
            font-weight: 600;
        }
        .footer-link a:hover { text-decoration: underline; }
        .alert-danger {
            padding: 8px 12px;
            border-radius: 3px;
            font-size: 13px;
            margin-bottom: 14px;
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
    </style>
</head>
<body>
    <div class="register-card">
        <div class="register-header">
            <h1>Daftar Akun</h1>
            <p>Buat akun staff baru</p>
        </div>

        @if($errors->any())
        <div class="alert-danger">
            {{ $errors->first() }}
        </div>
        @endif

        <form action="{{ route('register') }}" method="POST">
            @csrf
            <div class="form-group">
                <label class="form-label" for="name">Nama Lengkap</label>
                <input type="text" id="name" name="name" class="form-control" placeholder="Nama lengkap" value="{{ old('name') }}" required autofocus>
            </div>

            <div class="form-group">
                <label class="form-label" for="email">Email</label>
                <input type="email" id="email" name="email" class="form-control" placeholder="email@contoh.com" value="{{ old('email') }}" required>
            </div>

            <div class="form-group">
                <label class="form-label" for="password">Password</label>
                <input type="password" id="password" name="password" class="form-control" placeholder="Minimal 6 karakter" required>
            </div>

            <div class="form-group">
                <label class="form-label" for="password_confirmation">Konfirmasi Password</label>
                <input type="password" id="password_confirmation" name="password_confirmation" class="form-control" placeholder="Ulangi password" required>
            </div>

            <button type="submit" class="btn-submit">Daftar</button>
        </form>

        <div class="footer-link">
            Sudah punya akun? <a href="{{ route('login') }}">Masuk</a>
        </div>
    </div>
</body>
</html>
