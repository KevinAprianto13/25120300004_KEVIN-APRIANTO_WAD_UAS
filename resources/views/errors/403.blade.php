<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>403 - Akses Ditolak | GudangKu</title>
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
            text-align: center;
        }
        .box {
            background-color: #fff;
            border: 1px solid #ddd;
            border-radius: 4px;
            max-width: 420px;
            width: 100%;
            padding: 30px;
        }
        .code {
            font-size: 28px;
            font-weight: 800;
            color: #c0392b;
            margin-bottom: 8px;
        }
        h1 {
            font-size: 16px;
            font-weight: 700;
            margin-bottom: 10px;
        }
        p {
            font-size: 13px;
            color: #777;
            line-height: 1.5;
            margin-bottom: 18px;
        }
        .btn {
            display: inline-block;
            background-color: #2980b9;
            color: #fff;
            text-decoration: none;
            padding: 7px 16px;
            border-radius: 3px;
            font-size: 13px;
            font-weight: 600;
        }
        .btn:hover {
            background-color: #2472a4;
        }
    </style>
</head>
<body>
    <div class="box">
        <div class="code">403</div>
        <h1>Akses Ditolak</h1>
        <p>
            {{ $exception->getMessage() ?: 'Anda tidak memiliki akses untuk halaman ini.' }}
        </p>
        <a href="{{ route('dashboard') }}" class="btn">Kembali ke Dashboard</a>
    </div>
</body>
</html>
