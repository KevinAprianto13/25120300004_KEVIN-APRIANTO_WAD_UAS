<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title', 'GudangKu') - Sistem Manajemen Inventaris Gudang</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #2563eb;
            --primary-hover: #1d4ed8;
            --primary-light: #eff6ff;
            --secondary: #0f172a;
            --sidebar-bg: #0b1329;
            --sidebar-active: #1e293b;
            --sidebar-text: #94a3b8;
            --sidebar-text-active: #ffffff;
            --body-bg: #f8fafc;
            --card-bg: #ffffff;
            --border-color: #e2e8f0;
            --text-main: #0f172a;
            --text-muted: #64748b;
            --success: #10b981;
            --success-light: #ecfdf5;
            --warning: #f59e0b;
            --warning-light: #fffbeb;
            --danger: #ef4444;
            --danger-light: #fef2f2;
            --info: #06b6d4;
            --info-light: #ecfeff;
            --radius-md: 10px;
            --radius-lg: 16px;
            --shadow-sm: 0 1px 2px 0 rgb(0 0 0 / 0.05);
            --shadow-md: 0 4px 6px -1px rgb(0 0 0 / 0.07), 0 2px 4px -2px rgb(0 0 0 / 0.05);
            --shadow-lg: 0 10px 15px -3px rgb(0 0 0 / 0.08), 0 4px 6px -4px rgb(0 0 0 / 0.05);
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: var(--body-bg);
            color: var(--text-main);
            min-height: 100vh;
            display: flex;
            overflow-x: hidden;
        }

        /* Sidebar */
        .sidebar {
            width: 270px;
            background: linear-gradient(180deg, #0b1329 0%, #0f172a 100%);
            color: #ffffff;
            display: flex;
            flex-direction: column;
            position: fixed;
            top: 0;
            bottom: 0;
            left: 0;
            z-index: 100;
            border-right: 1px solid rgba(255, 255, 255, 0.08);
            transition: transform 0.3s ease;
        }

        .sidebar-brand {
            padding: 24px 20px;
            display: flex;
            align-items: center;
            gap: 12px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.08);
        }

        .brand-icon {
            width: 40px;
            height: 40px;
            border-radius: 10px;
            background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 4px 12px rgba(37, 99, 235, 0.4);
        }

        .brand-text h2 {
            font-size: 1.15rem;
            font-weight: 800;
            letter-spacing: -0.02em;
            color: #ffffff;
        }

        .brand-text span {
            font-size: 0.72rem;
            color: #94a3b8;
            letter-spacing: 0.05em;
            text-transform: uppercase;
        }

        .sidebar-nav {
            padding: 20px 14px;
            flex-grow: 1;
            overflow-y: auto;
            display: flex;
            flex-direction: column;
            gap: 6px;
        }

        .nav-section-title {
            font-size: 0.7rem;
            font-weight: 700;
            color: #64748b;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            padding: 12px 12px 6px 12px;
        }

        .nav-link {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 10px 14px;
            border-radius: var(--radius-md);
            color: var(--sidebar-text);
            text-decoration: none;
            font-size: 0.9rem;
            font-weight: 500;
            transition: all 0.2s ease;
        }

        .nav-link:hover {
            color: var(--sidebar-text-active);
            background: rgba(255, 255, 255, 0.06);
            transform: translateX(3px);
        }

        .nav-link.active {
            color: #ffffff;
            background: linear-gradient(90deg, rgba(37, 99, 235, 0.3) 0%, rgba(37, 99, 235, 0.1) 100%);
            border-left: 3px solid var(--primary);
            font-weight: 600;
        }

        .nav-link svg {
            width: 18px;
            height: 18px;
            stroke-width: 2;
        }

        .badge-role {
            font-size: 0.65rem;
            padding: 2px 7px;
            border-radius: 9999px;
            text-transform: uppercase;
            font-weight: 700;
            letter-spacing: 0.05em;
            margin-left: auto;
        }

        .badge-role-admin {
            background: rgba(239, 68, 68, 0.2);
            color: #fca5a5;
            border: 1px solid rgba(239, 68, 68, 0.4);
        }

        .badge-role-staff {
            background: rgba(16, 185, 129, 0.2);
            color: #6ee7b7;
            border: 1px solid rgba(16, 185, 129, 0.4);
        }

        .sidebar-footer {
            padding: 18px 16px;
            border-top: 1px solid rgba(255, 255, 255, 0.08);
            background: rgba(0, 0, 0, 0.15);
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .user-profile {
            display: flex;
            align-items: center;
            gap: 10px;
            overflow: hidden;
        }

        .user-avatar {
            width: 38px;
            height: 38px;
            border-radius: 50%;
            background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            color: #ffffff;
            font-size: 0.9rem;
            flex-shrink: 0;
        }

        .user-info {
            display: flex;
            flex-direction: column;
            overflow: hidden;
        }

        .user-name {
            font-size: 0.85rem;
            font-weight: 600;
            color: #f8fafc;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .user-email {
            font-size: 0.72rem;
            color: #94a3b8;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .logout-btn {
            background: transparent;
            border: none;
            color: #94a3b8;
            cursor: pointer;
            padding: 8px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            transition: all 0.2s;
        }

        .logout-btn:hover {
            color: #f87171;
            background: rgba(239, 68, 68, 0.1);
        }

        /* Main Content */
        .main-wrapper {
            margin-left: 270px;
            flex: 1;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        .top-navbar {
            height: 68px;
            background: #ffffff;
            border-bottom: 1px solid var(--border-color);
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 32px;
            position: sticky;
            top: 0;
            z-index: 90;
        }

        .navbar-breadcrumb {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 0.88rem;
            color: var(--text-muted);
        }

        .navbar-breadcrumb strong {
            color: var(--text-main);
            font-weight: 700;
        }

        .navbar-actions {
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .content-area {
            padding: 32px;
            flex: 1;
        }

        /* Flash Messages */
        .alert {
            padding: 14px 18px;
            border-radius: var(--radius-md);
            margin-bottom: 24px;
            display: flex;
            align-items: center;
            gap: 12px;
            font-size: 0.9rem;
            font-weight: 500;
            animation: slideDown 0.3s ease;
        }

        @keyframes slideDown {
            from { opacity: 0; transform: translateY(-8px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .alert-success {
            background: var(--success-light);
            color: #065f46;
            border: 1px solid #a7f3d0;
        }

        .alert-error, .alert-danger {
            background: var(--danger-light);
            color: #991b1b;
            border: 1px solid #fecaca;
        }

        .alert-warning {
            background: var(--warning-light);
            color: #92400e;
            border: 1px solid #fde68a;
        }

        /* UI Cards */
        .card {
            background: var(--card-bg);
            border-radius: var(--radius-lg);
            border: 1px solid var(--border-color);
            box-shadow: var(--shadow-sm);
            margin-bottom: 24px;
            overflow: hidden;
            transition: box-shadow 0.2s ease;
        }

        .card:hover {
            box-shadow: var(--shadow-md);
        }

        .card-header {
            padding: 20px 24px;
            border-bottom: 1px solid var(--border-color);
            display: flex;
            align-items: center;
            justify-content: space-between;
            background: #ffffff;
        }

        .card-title {
            font-size: 1.05rem;
            font-weight: 700;
            color: var(--text-main);
        }

        .card-subtitle {
            font-size: 0.8rem;
            color: var(--text-muted);
            margin-top: 2px;
        }

        .card-body {
            padding: 24px;
        }

        /* Buttons */
        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            padding: 9px 18px;
            border-radius: var(--radius-md);
            font-size: 0.875rem;
            font-weight: 600;
            text-decoration: none;
            cursor: pointer;
            transition: all 0.2s ease;
            border: 1px solid transparent;
        }

        .btn-primary {
            background: var(--primary);
            color: #ffffff;
            box-shadow: 0 2px 4px rgba(37, 99, 235, 0.25);
        }

        .btn-primary:hover {
            background: var(--primary-hover);
            box-shadow: 0 4px 8px rgba(37, 99, 235, 0.35);
            transform: translateY(-1px);
        }

        .btn-secondary {
            background: #f1f5f9;
            color: #334155;
            border-color: #cbd5e1;
        }

        .btn-secondary:hover {
            background: #e2e8f0;
            color: #0f172a;
        }

        .btn-danger {
            background: var(--danger);
            color: #ffffff;
        }

        .btn-danger:hover {
            background: #dc2626;
        }

        .btn-success {
            background: var(--success);
            color: #ffffff;
        }

        .btn-success:hover {
            background: #059669;
        }

        .btn-sm {
            padding: 6px 12px;
            font-size: 0.8rem;
            border-radius: 8px;
        }

        /* Form Controls */
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

        .form-label .required {
            color: var(--danger);
        }

        .form-control, .form-select {
            width: 100%;
            padding: 10px 14px;
            border-radius: var(--radius-md);
            border: 1px solid var(--border-color);
            background: #ffffff;
            font-family: inherit;
            font-size: 0.9rem;
            color: var(--text-main);
            transition: all 0.2s;
        }

        .form-control:focus, .form-select:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.15);
        }

        .form-error {
            color: var(--danger);
            font-size: 0.8rem;
            margin-top: 6px;
            display: flex;
            align-items: center;
            gap: 4px;
        }

        /* Tables */
        .table-responsive {
            width: 100%;
            overflow-x: auto;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            text-align: left;
            font-size: 0.88rem;
        }

        .table th {
            background: #f8fafc;
            color: #475569;
            font-weight: 700;
            text-transform: uppercase;
            font-size: 0.72rem;
            letter-spacing: 0.05em;
            padding: 14px 18px;
            border-bottom: 1px solid var(--border-color);
        }

        .table td {
            padding: 16px 18px;
            border-bottom: 1px solid var(--border-color);
            color: #334155;
            vertical-align: middle;
        }

        .table tbody tr:hover {
            background: #f8fafc;
        }

        /* Badges */
        .badge {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 4px 10px;
            border-radius: 9999px;
            font-size: 0.75rem;
            font-weight: 700;
        }

        .badge-success {
            background: var(--success-light);
            color: #047857;
            border: 1px solid #a7f3d0;
        }

        .badge-warning {
            background: var(--warning-light);
            color: #b45309;
            border: 1px solid #fde68a;
        }

        .badge-danger {
            background: var(--danger-light);
            color: #b91c1c;
            border: 1px solid #fecaca;
        }

        .badge-primary {
            background: var(--primary-light);
            color: #1d4ed8;
            border: 1px solid #bfdbfe;
        }

        /* Responsive Layout */
        @media (max-width: 992px) {
            .sidebar {
                transform: translateX(-100%);
            }
            .sidebar.show {
                transform: translateX(0);
            }
            .main-wrapper {
                margin-left: 0;
            }
        }
    </style>
    @yield('styles')
</head>
<body>
    <!-- Sidebar Navigation -->
    <aside class="sidebar" id="appSidebar">
        <div class="sidebar-brand">
            <div class="brand-icon">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#ffffff" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M21 8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16Z"/>
                    <path d="m3.3 7 8.7 5 8.7-5"/>
                    <path d="M12 22V12"/>
                </svg>
            </div>
            <div class="brand-text">
                <h2>GudangKu</h2>
                <span>Manajemen Inventaris</span>
            </div>
        </div>

        <nav class="sidebar-nav">
            <div class="nav-section-title">Menu Utama</div>
            <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" id="nav-dashboard">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><rect width="7" height="9" x="3" y="3" rx="1"/><rect width="7" height="5" x="14" y="3" rx="1"/><rect width="7" height="9" x="14" y="12" rx="1"/><rect width="7" height="5" x="3" y="16" rx="1"/></svg>
                Dashboard
            </a>

            <div class="nav-section-title">Katalog & Stok</div>
            @if(Auth::user()->isAdmin())
            <a href="{{ route('categories.index') }}" class="nav-link {{ request()->routeIs('categories.*') ? 'active' : '' }}" id="nav-categories">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M4 20h16a2 2 0 0 0 2-2V8a2 2 0 0 0-2-2h-7.93a2 2 0 0 1-1.66-.9l-.82-1.2A2 2 0 0 0 7.93 3H4a2 2 0 0 0-2 2v13c0 1.1.9 2 2 2Z"/></svg>
                Kategori Produk
                <span class="badge-role badge-role-admin">Admin</span>
            </a>
            @endif

            <a href="{{ route('products.index') }}" class="nav-link {{ request()->routeIs('products.*') ? 'active' : '' }}" id="nav-products">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M16.5 9.4 7.55 4.24a1.78 1.78 0 0 0-2.5 1.55v12.42a1.78 1.78 0 0 0 2.5 1.55L16.5 14.6a1.78 1.78 0 0 0 0-3.2Z"/><path d="m21 16-4-2.3v-3.4l4-2.3"/></svg>
                Daftar Produk
            </a>

            <div class="nav-section-title">Transaksi Gudang</div>
            <a href="{{ route('transactions.create') }}" class="nav-link {{ request()->routeIs('transactions.create') ? 'active' : '' }}" id="nav-tx-create">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M12 5v14M5 12h14"/></svg>
                Catat Transaksi
            </a>

            <a href="{{ route('transactions.index') }}" class="nav-link {{ request()->routeIs('transactions.index') ? 'active' : '' }}" id="nav-transactions">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M3 3v18h18"/><path d="m19 9-5 5-4-4-3 3"/></svg>
                Riwayat Transaksi
            </a>

            @if(Auth::user()->isAdmin())
            <div class="nav-section-title">Sistem & Pengguna</div>
            <a href="{{ route('users.index') }}" class="nav-link {{ request()->routeIs('users.*') ? 'active' : '' }}" id="nav-users">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                Manajemen Pengguna
                <span class="badge-role badge-role-admin">Admin</span>
            </a>
            @endif
        </nav>

        <div class="sidebar-footer">
            <div class="user-profile">
                <div class="user-avatar">
                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                </div>
                <div class="user-info">
                    <span class="user-name">{{ Auth::user()->name }}</span>
                    <span class="user-email">Role: <strong>{{ ucfirst(Auth::user()->role) }}</strong></span>
                </div>
            </div>
            <form action="{{ route('logout') }}" method="POST" style="margin: 0;">
                @csrf
                <button type="submit" class="logout-btn" title="Keluar / Logout" id="btn-sidebar-logout">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
                </button>
            </form>
        </div>
    </aside>

    <!-- Main Content Wrapper -->
    <div class="main-wrapper">
        <header class="top-navbar">
            <div class="navbar-breadcrumb">
                <span>GudangKu</span>
                <span>/</span>
                <strong>@yield('page_title', 'Halaman')</strong>
            </div>
            <div class="navbar-actions">
                <span class="badge {{ Auth::user()->isAdmin() ? 'badge-danger' : 'badge-success' }}">
                    ● Role: {{ strtoupper(Auth::user()->role) }}
                </span>
            </div>
        </header>

        <main class="content-area">
            <!-- Flash Message Alerts -->
            @if(session('success'))
            <div class="alert alert-success" id="flash-success">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                <div>{{ session('success') }}</div>
            </div>
            @endif

            @if(session('error'))
            <div class="alert alert-error" id="flash-error">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>
                <div>{{ session('error') }}</div>
            </div>
            @endif

            @if($errors->any())
            <div class="alert alert-error">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m21.73 18-8-14a2 2 0 0 0-3.48 0l-8 14A2 2 0 0 0 4 21h16a2 2 0 0 0 1.73-3Z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>
                <div>
                    <strong>Terdapat kesalahan input:</strong>
                    <ul style="margin-left: 20px; margin-top: 4px;">
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
