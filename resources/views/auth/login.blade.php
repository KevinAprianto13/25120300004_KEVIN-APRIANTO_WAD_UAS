<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - GudangKu</title>
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
        .login-card {
            background-color: #fff;
            border: 1px solid #ddd;
            border-radius: 4px;
            width: 100%;
            max-width: 380px;
            padding: 28px;
        }
        .login-header {
            text-align: center;
            margin-bottom: 20px;
        }
        .login-header h1 {
            font-size: 20px;
            font-weight: 700;
            color: #333;
        }
        .login-header p {
            font-size: 13px;
            color: #777;
            margin-top: 4px;
        }
        .form-group {
            margin-bottom: 14px;
        }
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
        .btn-submit:hover {
            background-color: #2472a4;
        }
        .demo-box {
            margin-top: 18px;
            padding: 10px;
            background-color: #f9f9f9;
            border: 1px solid #ddd;
            border-radius: 3px;
            font-size: 12px;
        }
        .demo-title {
            font-weight: 600;
            color: #555;
            margin-bottom: 8px;
        }
        .demo-btns {
            display: flex;
            gap: 8px;
        }
        .btn-demo {
            flex: 1;
            padding: 5px;
            border: 1px solid #ccc;
            background-color: #fff;
            border-radius: 3px;
            font-size: 11px;
            font-weight: 600;
            cursor: pointer;
            color: #555;
            font-family: inherit;
        }
        .btn-demo:hover {
            background-color: #f0f0f0;
        }
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
        .footer-link a:hover {
            text-decoration: underline;
        }
        .alert {
            padding: 8px 12px;
            border-radius: 3px;
            font-size: 13px;
            margin-bottom: 14px;
        }
        .alert-danger { background-color: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; }
        .alert-success { background-color: #d4edda; color: #155724; border: 1px solid #c3e6cb; }
    </style>
</head>
<body>
    <div class="login-card">
        <div class="login-header">
            <h1>GudangKu</h1>
            <p>Masuk ke sistem inventaris</p>
        </div>

        @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
        @endif

        @if($errors->any())
        <div class="alert alert-danger">
            {{ $errors->first() }}
        </div>
        @endif

        <form action="{{ route('login') }}" method="POST">
            @csrf
            <div class="form-group">
                <label class="form-label" for="email">Email</label>
                <input type="email" id="email" name="email" class="form-control" placeholder="nama@gudangku.test" value="{{ old('email') }}" required autofocus>
            </div>

            <div class="form-group">
                <label class="form-label" for="password">Password</label>
                <input type="password" id="password" name="password" class="form-control" placeholder="Password" required>
            </div>

            <div style="display: flex; align-items: center; gap: 6px; margin-bottom: 14px; font-size: 13px; color: #666;">
                <input type="checkbox" id="remember" name="remember">
                <label for="remember">Ingat saya</label>
            </div>

            <button type="submit" class="btn-submit">Masuk</button>
        </form>

        <div class="demo-box">
            <div class="demo-title">Akun Demo:</div>
            <div class="demo-btns">
                <button type="button" class="btn-demo" onclick="fillAdmin()">Admin</button>
                <button type="button" class="btn-demo" onclick="fillStaff()">Staff</button>
            </div>
        </div>

        <div class="footer-link">
            Belum punya akun? <a href="{{ route('register') }}">Daftar</a>
        </div>
    </div>

    <script>
        function fillAdmin() {
            document.getElementById('email').value = 'admin@gudangku.test';
            document.getElementById('password').value = 'password123';
        }
        function fillStaff() {
            document.getElementById('email').value = 'staff@gudangku.test';
            document.getElementById('password').value = 'password123';
        }
    </script>
</body>
</html>
