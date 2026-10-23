<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk - GudangKu Inventaris</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #2563eb;
            --primary-hover: #1d4ed8;
            --secondary: #0b1329;
            --body-bg: #0f172a;
            --card-bg: #ffffff;
            --text-main: #0f172a;
            --text-muted: #64748b;
            --border-color: #e2e8f0;
            --danger: #ef4444;
            --radius-lg: 18px;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: radial-gradient(circle at top right, #1e293b, #0b1329 80%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 24px;
            color: #ffffff;
        }

        .auth-container {
            width: 100%;
            max-width: 440px;
        }

        .brand-header {
            text-align: center;
            margin-bottom: 30px;
        }

        .brand-logo {
            width: 56px;
            height: 56px;
            margin: 0 auto 16px;
            border-radius: 14px;
            background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 8px 24px rgba(37, 99, 235, 0.45);
        }

        .brand-header h1 {
            font-size: 1.75rem;
            font-weight: 800;
            letter-spacing: -0.02em;
            color: #ffffff;
        }

        .brand-header p {
            color: #94a3b8;
            font-size: 0.9rem;
            margin-top: 6px;
        }

        .auth-card {
            background: #ffffff;
            color: var(--text-main);
            border-radius: var(--radius-lg);
            padding: 36px 32px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.35);
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-label {
            display: block;
            margin-bottom: 8px;
            font-size: 0.875rem;
            font-weight: 600;
            color: #334155;
        }

        .form-control {
            width: 100%;
            padding: 12px 14px;
            border-radius: 10px;
            border: 1px solid var(--border-color);
            font-family: inherit;
            font-size: 0.92rem;
            color: var(--text-main);
            transition: all 0.2s;
        }

        .form-control:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.15);
        }

        .form-check {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 0.85rem;
            color: #64748b;
            margin-bottom: 22px;
        }

        .btn-submit {
            width: 100%;
            padding: 13px;
            border-radius: 10px;
            background: var(--primary);
            color: #ffffff;
            border: none;
            font-family: inherit;
            font-size: 0.95rem;
            font-weight: 700;
            cursor: pointer;
            box-shadow: 0 4px 14px rgba(37, 99, 235, 0.35);
            transition: all 0.2s;
        }

        .btn-submit:hover {
            background: var(--primary-hover);
            transform: translateY(-1px);
        }

        .demo-box {
            margin-top: 24px;
            padding: 14px;
            background: #f8fafc;
            border-radius: 10px;
            border: 1px dashed #cbd5e1;
            font-size: 0.8rem;
            color: #475569;
        }

        .demo-box-title {
            font-weight: 700;
            color: #1e293b;
            margin-bottom: 8px;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .demo-btn-group {
            display: flex;
            gap: 8px;
            margin-top: 8px;
        }

        .demo-btn {
            flex: 1;
            padding: 6px 10px;
            border-radius: 6px;
            border: 1px solid #cbd5e1;
            background: #ffffff;
            font-size: 0.75rem;
            font-weight: 600;
            cursor: pointer;
            color: #334155;
            transition: all 0.15s;
        }

        .demo-btn:hover {
            background: #eff6ff;
            border-color: #93c5fd;
            color: #1d4ed8;
        }

        .auth-footer {
            margin-top: 20px;
            text-align: center;
            font-size: 0.88rem;
            color: #64748b;
        }

        .auth-footer a {
            color: var(--primary);
            text-decoration: none;
            font-weight: 600;
        }

        .auth-footer a:hover {
            text-decoration: underline;
        }

        .alert-error {
            background: #fef2f2;
            color: #991b1b;
            border: 1px solid #fecaca;
            padding: 12px 14px;
            border-radius: 10px;
            margin-bottom: 20px;
            font-size: 0.85rem;
        }

        .alert-success {
            background: #ecfdf5;
            color: #065f46;
            border: 1px solid #a7f3d0;
            padding: 12px 14px;
            border-radius: 10px;
            margin-bottom: 20px;
            font-size: 0.85rem;
        }
    </style>
</head>
<body>
    <div class="auth-container">
        <div class="brand-header">
            <div class="brand-logo">
                <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="#ffffff" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M21 8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16Z"/>
                    <path d="m3.3 7 8.7 5 8.7-5"/>
                    <path d="M12 22V12"/>
                </svg>
            </div>
            <h1>GudangKu</h1>
            <p>Sistem Manajemen Stok & Inventaris Gudang</p>
        </div>

        <div class="auth-card">
            @if(session('success'))
            <div class="alert-success">
                {{ session('success') }}
            </div>
            @endif

            @if($errors->any())
            <div class="alert-error">
                {{ $errors->first() }}
            </div>
            @endif

            <form action="{{ route('login') }}" method="POST" id="form-login">
                @csrf
                <div class="form-group">
                    <label class="form-label" for="login-email">Alamat Email</label>
                    <input type="email" id="login-email" name="email" class="form-control" placeholder="nama@gudangku.test" value="{{ old('email') }}" required autofocus>
                </div>

                <div class="form-group">
                    <label class="form-label" for="login-password">Password</label>
                    <input type="password" id="login-password" name="password" class="form-control" placeholder="Masukkan password" required>
                </div>

                <div class="form-check">
                    <input type="checkbox" id="remember" name="remember">
                    <label for="remember">Ingat Saya di Perangkat Ini</label>
                </div>

                <button type="submit" class="btn-submit" id="btn-login-submit">
                    Masuk ke Dashboard
                </button>
            </form>

            <!-- Quick Demo Credentials Box for Easy Testing -->
            <div class="demo-box">
                <div class="demo-box-title">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M12 16v-4"/><path d="M12 8h.01"/></svg>
                    Akun Pengujian (Sesuai Draf Bagian G):
                </div>
                <div class="demo-btn-group">
                    <button type="button" class="demo-btn" onclick="fillAdmin()">Login Admin</button>
                    <button type="button" class="demo-btn" onclick="fillStaff()">Login Staff</button>
                </div>
            </div>

            <div class="auth-footer">
                Belum punya akun? <a href="{{ route('register') }}" id="link-register">Daftar Akun Baru</a>
            </div>
        </div>
    </div>

    <script>
        function fillAdmin() {
            document.getElementById('login-email').value = 'admin@gudangku.test';
            document.getElementById('login-password').value = 'password123';
        }
        function fillStaff() {
            document.getElementById('login-email').value = 'staff@gudangku.test';
            document.getElementById('login-password').value = 'password123';
        }
    </script>
</body>
</html>
