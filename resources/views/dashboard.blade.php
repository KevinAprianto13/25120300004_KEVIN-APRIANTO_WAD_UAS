@extends('layouts.app')

@section('title', 'Dashboard')
@section('page_title', 'Dashboard Ringkasan Inventaris')

@section('content')
<style>
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(230px, 1fr));
        gap: 20px;
        margin-bottom: 28px;
    }

    .stat-card {
        background: #ffffff;
        border-radius: var(--radius-lg);
        padding: 22px;
        border: 1px solid var(--border-color);
        box-shadow: var(--shadow-sm);
        display: flex;
        align-items: center;
        gap: 18px;
        transition: transform 0.2s, box-shadow 0.2s;
    }

    .stat-card:hover {
        transform: translateY(-2px);
        box-shadow: var(--shadow-md);
    }

    .stat-icon {
        width: 54px;
        height: 54px;
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    .stat-info {
        display: flex;
        flex-direction: column;
    }

    .stat-value {
        font-size: 1.85rem;
        font-weight: 800;
        color: var(--text-main);
        line-height: 1.2;
    }

    .stat-label {
        font-size: 0.82rem;
        color: var(--text-muted);
        font-weight: 600;
        margin-top: 2px;
    }

    .icon-blue { background: #eff6ff; color: #2563eb; }
    .icon-purple { background: #f5f3ff; color: #7c3aed; }
    .icon-amber { background: #fffbeb; color: #d97706; }
    .icon-emerald { background: #ecfdf5; color: #059669; }

    .quick-actions-bar {
        background: #ffffff;
        border-radius: var(--radius-lg);
        border: 1px solid var(--border-color);
        padding: 16px 24px;
        margin-bottom: 28px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 16px;
    }

    .dashboard-two-col {
        display: grid;
        grid-template-columns: 2fr 1fr;
        gap: 24px;
    }

    @media (max-width: 1024px) {
        .dashboard-two-col {
            grid-template-columns: 1fr;
        }
    }

    .low-stock-item {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 12px 14px;
        border-radius: 10px;
        background: #fffbeb;
        border: 1px solid #fef3c7;
        margin-bottom: 10px;
    }

    .low-stock-info h4 {
        font-size: 0.88rem;
        font-weight: 700;
        color: #92400e;
    }

    .low-stock-info span {
        font-size: 0.75rem;
        color: #b45309;
    }

    .stock-pill-critical {
        background: #ef4444;
        color: #ffffff;
        font-weight: 800;
        font-size: 0.75rem;
        padding: 4px 10px;
        border-radius: 9999px;
    }
</style>

<!-- Top Quick Actions Bar -->
<div class="quick-actions-bar">
    <div>
        <h3 style="font-size: 1.05rem; font-weight: 800; color: #0f172a;">Aksi Cepat Gudang</h3>
        <p style="font-size: 0.8rem; color: #64748b;">Mulai pencatatan mutasi barang atau kelola master data gudang</p>
    </div>
    <div style="display: flex; gap: 10px; flex-wrap: wrap;">
        <a href="{{ route('transactions.create') }}" class="btn btn-primary" id="btn-quick-transaction">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 5v14M5 12h14"/></svg>
            Catat Barang Masuk / Keluar
        </a>
        @if(Auth::user()->isAdmin())
        <a href="{{ route('products.create') }}" class="btn btn-secondary" id="btn-quick-add-product">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect width="18" height="18" x="3" y="3" rx="2"/><path d="M12 8v8M8 12h8"/></svg>
            Tambah Produk
        </a>
        @endif
    </div>
</div>

<!-- 4 Summary Stat Cards -->
<div class="stats-grid">
    <div class="stat-card" id="card-total-products">
        <div class="stat-icon icon-blue">
            <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m7.5 4.27 9 5.15"/><path d="M21 8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16Z"/><path d="m3.3 7 8.7 5 8.7-5"/><path d="M12 22V12"/></svg>
        </div>
        <div class="stat-info">
            <span class="stat-value">{{ $totalProducts }}</span>
            <span class="stat-label">Total Produk</span>
        </div>
    </div>

    <div class="stat-card" id="card-total-categories">
        <div class="stat-icon icon-purple">
            <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 20h16a2 2 0 0 0 2-2V8a2 2 0 0 0-2-2h-7.93a2 2 0 0 1-1.66-.9l-.82-1.2A2 2 0 0 0 7.93 3H4a2 2 0 0 0-2 2v13c0 1.1.9 2 2 2Z"/></svg>
        </div>
        <div class="stat-info">
            <span class="stat-value">{{ $totalCategories }}</span>
            <span class="stat-label">Total Kategori</span>
        </div>
    </div>

    <div class="stat-card" id="card-low-stock">
        <div class="stat-icon icon-amber">
            <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m21.73 18-8-14a2 2 0 0 0-3.48 0l-8 14A2 2 0 0 0 4 21h16a2 2 0 0 0 1.73-3Z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>
        </div>
        <div class="stat-info">
            <span class="stat-value" style="color: #d97706;">{{ $lowStockCount }}</span>
            <span class="stat-label">Stok Menipis</span>
        </div>
    </div>

    <div class="stat-card" id="card-total-units">
        <div class="stat-icon icon-emerald">
            <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16Z"/><circle cx="12" cy="12" r="4"/></svg>
        </div>
        <div class="stat-info">
            <span class="stat-value">{{ number_format($totalStockUnits, 0, ',', '.') }}</span>
            <span class="stat-label">Total Unit Fisik</span>
        </div>
    </div>
</div>

<!-- Main Section: 5 Recent Transactions + Low Stock Alert Panel -->
<div class="dashboard-two-col">
    <!-- 5 Transaksi Terbaru (Feature 2) -->
    <div class="card">
        <div class="card-header">
            <div>
                <h3 class="card-title">5 Transaksi Terbaru</h3>
                <span class="card-subtitle">Aktivitas pergerakan stok mutasi terkini</span>
            </div>
            <a href="{{ route('transactions.index') }}" class="btn btn-secondary btn-sm" id="link-all-transactions">
                Lihat Semua Riwayat →
            </a>
        </div>
        <div class="card-body" style="padding: 0;">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Tanggal</th>
                            <th>Produk</th>
                            <th>Jenis</th>
                            <th>Jumlah</th>
                            <th>Dicatat Oleh</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentTransactions as $tx)
                        <tr>
                            <td style="font-weight: 500;">
                                {{ \Carbon\Carbon::parse($tx->transaction_date)->format('d M Y') }}
                            </td>
                            <td>
                                <strong style="color: #0f172a;">{{ $tx->product->name ?? '-' }}</strong>
                                <div style="font-size: 0.75rem; color: #64748b;">SKU: {{ $tx->product->sku ?? '-' }}</div>
                            </td>
                            <td>
                                @if($tx->type === 'in')
                                <span class="badge badge-success">
                                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M12 5v14M5 12l7-7 7 7"/></svg>
                                    Masuk (IN)
                                </span>
                                @else
                                <span class="badge badge-danger">
                                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M12 19V5M5 12l7 7 7-7"/></svg>
                                    Keluar (OUT)
                                </span>
                                @endif
                            </td>
                            <td>
                                <strong style="font-size: 0.95rem; {{ $tx->type === 'in' ? 'color: #059669;' : 'color: #dc2626;' }}">
                                    {{ $tx->type === 'in' ? '+' : '-' }}{{ $tx->quantity }} unit
                                </strong>
                            </td>
                            <td>
                                <span style="font-weight: 600; color: #475569;">{{ $tx->user->name ?? 'User' }}</span>
                                <div style="font-size: 0.7rem; color: #94a3b8;">{{ ucfirst($tx->user->role ?? '') }}</div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" style="text-align: center; padding: 36px; color: #94a3b8;">
                                Belum ada riwayat transaksi yang dicatat.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Alert Produk Stok Menipis -->
    <div class="card">
        <div class="card-header">
            <div>
                <h3 class="card-title" style="display: flex; align-items: center; gap: 8px;">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#d97706" stroke-width="2.5"><path d="m21.73 18-8-14a2 2 0 0 0-3.48 0l-8 14A2 2 0 0 0 4 21h16a2 2 0 0 0 1.73-3Z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>
                    Peringatan Stok Menipis
                </h3>
                <span class="card-subtitle">Produk yang berada di bawah batas minimum</span>
            </div>
        </div>
        <div class="card-body">
            @forelse($lowStockProducts as $low)
            <div class="low-stock-item">
                <div class="low-stock-info">
                    <h4>{{ $low->name }}</h4>
                    <span>SKU: {{ $low->sku }} | Batas Min: {{ $low->min_stock }} unit</span>
                </div>
                <div class="stock-pill-critical">
                    Sisa: {{ $low->stock }}
                </div>
            </div>
            @empty
            <div style="text-align: center; padding: 30px; color: #059669;">
                <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="margin: 0 auto 10px;"><circle cx="12" cy="12" r="10"/><path d="m9 12 2 2 4-4"/></svg>
                <div style="font-weight: 700;">Stok Gudang Aman</div>
                <p style="font-size: 0.8rem; color: #64748b; margin-top: 4px;">Tidak ada produk yang berada di bawah ambang batas minimum saat ini.</p>
            </div>
            @endforelse

            <div style="margin-top: 18px;">
                <a href="{{ route('products.index', ['stock_filter' => 'low']) }}" class="btn btn-secondary btn-sm" style="width: 100%;">
                    Filter Semua Produk Kritis
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
