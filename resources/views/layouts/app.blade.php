<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'GudangKu') - Sistem Inventaris</title>
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
            background-color: #f5f5f5;
            color: #333;
            min-height: 100vh;
            display: flex;
            font-size: 14px;
            line-height: 1.6;
        }

        a { color: #1a5dc8; }

        /* Sidebar */
        .sidebar {
            width: 220px;
            background-color: #2c3e50;
            color: #fff;
            display: flex;
            flex-direction: column;
            position: fixed;
            top: 0;
            bottom: 0;
            left: 0;
            z-index: 100;
        }

        .sidebar-brand {
            padding: 16px;
            border-bottom: 1px solid #3d566e;
        }

        .sidebar-brand h2 {
            font-size: 16px;
            font-weight: 700;
            margin: 0;
        }

        .sidebar-brand small {
            font-size: 11px;
            color: #95a5a6;
        }

        .sidebar-menu {
            padding: 12px 8px;
            flex: 1;
            overflow-y: auto;
        }

        .menu-title {
            font-size: 10px;
            font-weight: 700;
            text-transform: uppercase;
            color: #7f8c8d;
            padding: 10px 10px 4px;
            letter-spacing: 0.05em;
        }

        .nav-item {
            display: block;
            padding: 8px 12px;
            color: #bdc3c7;
            text-decoration: none;
            font-size: 13px;
            border-radius: 3px;
            margin-bottom: 1px;
        }

        .nav-item:hover {
            color: #fff;
            background-color: #34495e;
        }

        .nav-item.active {
            color: #fff;
            background-color: #2980b9;
        }

        .sidebar-user {
            padding: 12px 14px;
            border-top: 1px solid #3d566e;
            background-color: #243342;
            display: flex;
            align-items: center;
            justify-content: space-between;
            font-size: 12px;
        }

        .user-name {
            font-weight: 600;
            color: #ecf0f1;
        }

        .user-role-label {
            font-size: 11px;
            color: #95a5a6;
            text-transform: capitalize;
        }

        .btn-logout {
            background: none;
            border: 1px solid #7f8c8d;
            color: #bdc3c7;
            cursor: pointer;
            padding: 4px 10px;
            border-radius: 3px;
            font-size: 11px;
        }

        .btn-logout:hover {
            color: #e74c3c;
            border-color: #e74c3c;
        }

        /* Main Content */
        .main-wrapper {
            margin-left: 220px;
            flex: 1;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        .topbar {
            height: 48px;
            background-color: #fff;
            border-bottom: 1px solid #ddd;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 20px;
            position: sticky;
            top: 0;
            z-index: 50;
            font-size: 13px;
        }

        .topbar-title {
            color: #666;
        }

        .topbar-title strong {
            color: #333;
        }

        .content {
            padding: 20px;
            flex: 1;
        }

        /* Cards */
        .card {
            background-color: #fff;
            border: 1px solid #ddd;
            border-radius: 4px;
            margin-bottom: 16px;
        }

        .card-header {
            padding: 12px 16px;
            border-bottom: 1px solid #ddd;
            display: flex;
            align-items: center;
            justify-content: space-between;
            background-color: #fafafa;
        }

        .card-header h3 {
            font-size: 14px;
            font-weight: 600;
            color: #333;
            margin: 0;
        }

        .card-body {
            padding: 16px;
        }

        /* Buttons */
        .btn {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            padding: 6px 12px;
            border-radius: 3px;
            font-size: 13px;
            font-weight: 500;
            text-decoration: none;
            border: 1px solid transparent;
            cursor: pointer;
            font-family: inherit;
        }

        .btn-primary {
            background-color: #2980b9;
            color: #fff;
            border-color: #2472a4;
        }
        .btn-primary:hover {
            background-color: #2472a4;
        }

        .btn-secondary {
            background-color: #fff;
            color: #555;
            border-color: #ccc;
        }
        .btn-secondary:hover {
            background-color: #f5f5f5;
        }

        .btn-danger {
            background-color: #c0392b;
            color: #fff;
            border-color: #a93226;
        }
        .btn-danger:hover {
            background-color: #a93226;
        }

        .btn-sm {
            padding: 4px 8px;
            font-size: 12px;
        }

        /* Forms */
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

        .form-label .req, .required {
            color: #c0392b;
        }

        .form-control, .form-select {
            width: 100%;
            padding: 7px 10px;
            border: 1px solid #ccc;
            border-radius: 3px;
            font-family: inherit;
            font-size: 13px;
            color: #333;
            background-color: #fff;
        }

        .form-control:focus, .form-select:focus {
            outline: none;
            border-color: #2980b9;
            box-shadow: 0 0 0 2px rgba(41, 128, 185, 0.15);
        }

        .form-error {
            color: #c0392b;
            font-size: 12px;
            margin-top: 3px;
        }

        /* Table */
        .table-responsive {
            width: 100%;
            overflow-x: auto;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            font-size: 13px;
            text-align: left;
        }

        .table th {
            background-color: #f9f9f9;
            color: #555;
            font-weight: 600;
            padding: 8px 12px;
            border-bottom: 2px solid #ddd;
            font-size: 12px;
        }

        .table td {
            padding: 8px 12px;
            border-bottom: 1px solid #eee;
            color: #444;
            vertical-align: middle;
        }

        .table tbody tr:hover {
            background-color: #f9f9f9;
        }

        /* Badges */
        .badge {
            display: inline-block;
            padding: 2px 6px;
            border-radius: 3px;
            font-size: 11px;
            font-weight: 600;
        }

        .badge-success { background-color: #d4edda; color: #155724; }
        .badge-danger { background-color: #f8d7da; color: #721c24; }
        .badge-warning { background-color: #fff3cd; color: #856404; }
        .badge-info { background-color: #d1ecf1; color: #0c5460; }
        .badge-neutral { background-color: #e9ecef; color: #555; }
        .badge-primary { background-color: #d6eaf8; color: #1a5276; }

        /* Alerts */
        .alert {
            padding: 10px 14px;
            border-radius: 3px;
            margin-bottom: 16px;
            font-size: 13px;
        }

        .alert-success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .alert-error, .alert-danger {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
    </style>
    @yield('styles')
</head>
<body>
    <!-- Sidebar -->
    <aside class="sidebar">
        <div class="sidebar-brand">
            <h2>GudangKu</h2>
            <small>Sistem Inventaris</small>
        </div>

        <nav class="sidebar-menu">
            <div class="menu-title">Menu Utama</div>
            <a href="{{ route('dashboard') }}" class="nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}" id="nav-dashboard">
                Dashboard
            </a>

            <div class="menu-title">Inventaris</div>
            @if(Auth::user()->isAdmin())
            <a href="{{ route('categories.index') }}" class="nav-item {{ request()->routeIs('categories.*') ? 'active' : '' }}" id="nav-categories">
                Kategori
            </a>
            @endif

            <a href="{{ route('products.index') }}" class="nav-item {{ request()->routeIs('products.*') ? 'active' : '' }}" id="nav-products">
                Produk
            </a>

            <div class="menu-title">Transaksi</div>
            <a href="{{ route('transactions.create') }}" class="nav-item {{ request()->routeIs('transactions.create') ? 'active' : '' }}" id="nav-tx-create">
                Catat Transaksi
            </a>

            <a href="{{ route('transactions.index') }}" class="nav-item {{ request()->routeIs('transactions.index') ? 'active' : '' }}" id="nav-transactions">
                Riwayat Transaksi
            </a>

            @if(Auth::user()->isAdmin())
            <div class="menu-title">Pengaturan</div>
            <a href="{{ route('users.index') }}" class="nav-item {{ request()->routeIs('users.*') ? 'active' : '' }}" id="nav-users">
                Kelola Pengguna
            </a>
            @endif
        </nav>

        <div class="sidebar-user">
            <div>
                <span class="user-name">{{ Auth::user()->name }}</span><br>
                <span class="user-role-label">{{ Auth::user()->role }}</span>
            </div>
            <form action="{{ route('logout') }}" method="POST" style="margin: 0;">
                @csrf
                <button type="submit" class="btn-logout" title="Logout">Keluar</button>
            </form>
        </div>
    </aside>

    <!-- Main Content Area -->
    <div class="main-wrapper">
        <header class="topbar">
            <div class="topbar-title">
                <strong>@yield('page_title', 'Halaman')</strong>
            </div>
            <div>
                <span class="badge {{ Auth::user()->isAdmin() ? 'badge-danger' : 'badge-success' }}">
                    {{ strtoupper(Auth::user()->role) }}
                </span>
            </div>
        </header>

        <main class="content">
            @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
            @endif

            @if(session('error'))
            <div class="alert alert-error">
                {{ session('error') }}
            </div>
            @endif

            @if($errors->any())
            <div class="alert alert-error">
                <div>
                    <strong>Perhatian:</strong>
                    <ul style="margin-left: 18px; margin-top: 4px;">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
            @endif

            @yield('content')
        </main>
    </div>

    @yield('scripts')
</body>
</html>
