<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrasi Akun - GudangKu</title>
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
            max-width: 460px;
        }

        .brand-header {
            text-align: center;
            margin-bottom: 26px;
        }

        .brand-logo {
            width: 52px;
            height: 52px;
            margin: 0 auto 14px;
            border-radius: 14px;
            background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 8px 24px rgba(37, 99, 235, 0.45);
        }

        .brand-header h1 {
            font-size: 1.65rem;
            font-weight: 800;
            letter-spacing: -0.02em;
            color: #ffffff;
        }

        .brand-header p {
            color: #94a3b8;
            font-size: 0.88rem;
            margin-top: 4px;
        }

        .auth-card {
            background: #ffffff;
            color: var(--text-main);
            border-radius: var(--radius-lg);
            padding: 34px 32px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.35);
        }

        .form-group {
            margin-bottom: 18px;
        }

        .form-label {
            display: block;
            margin-bottom: 7px;
            font-size: 0.875rem;
            font-weight: 600;
            color: #334155;
        }

        .form-control {
            width: 100%;
            padding: 11px 14px;
            border-radius: 10px;
            border: 1px solid var(--border-color);
            font-family: inherit;
            font-size: 0.9rem;
            color: var(--text-main);
            transition: all 0.2s;
        }

        .form-control:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.15);
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
            margin-top: 8px;
        }

        .btn-submit:hover {
            background: var(--primary-hover);
            transform: translateY(-1px);
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
    </style>
</head>
<body>
    <div class="auth-container">
        <div class="brand-header">
            <div class="brand-logo">
                <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="#ffffff" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M21 8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16Z"/>
                    <path d="m3.3 7 8.7 5 8.7-5"/>
                    <path d="M12 22V12"/>
                </svg>
            </div>
            <h1>Daftar Akun Baru</h1>
            <p>Bergabung sebagai Staff Operasional Gudang</p>
        </div>

        <div class="auth-card">
            @if($errors->any())
            <div class="alert-error">
                {{ $errors->first() }}
            </div>
            @endif

            <form action="{{ route('register') }}" method="POST" id="form-register">
                @csrf
                <div class="form-group">
                    <label class="form-label" for="reg-name">Nama Lengkap</label>
                    <input type="text" id="reg-name" name="name" class="form-control" placeholder="Contoh: Budi Pratama" value="{{ old('name') }}" required autofocus>
                </div>

                <div class="form-group">
                    <label class="form-label" for="reg-email">Alamat Email</label>
                    <input type="email" id="reg-email" name="email" class="form-control" placeholder="budi@gudangku.test" value="{{ old('email') }}" required>
                </div>

                <div class="form-group">
                    <label class="form-label" for="reg-password">Password (Minimal 6 Karakter)</label>
                    <input type="password" id="reg-password" name="password" class="form-control" placeholder="Buat password aman" required>
                </div>

                <div class="form-group">
                    <label class="form-label" for="reg-password-confirmation">Konfirmasi Password</label>
                    <input type="password" id="reg-password-confirmation" name="password_confirmation" class="form-control" placeholder="Ulangi password" required>
                </div>

                <button type="submit" class="btn-submit" id="btn-register-submit">
                    Daftar Sekarang
                </button>
            </form>

            <div class="auth-footer">
                Sudah memiliki akun? <a href="{{ route('login') }}" id="link-login">Masuk Disini</a>
            </div>
        </div>
    </div>
</body>
</html>
