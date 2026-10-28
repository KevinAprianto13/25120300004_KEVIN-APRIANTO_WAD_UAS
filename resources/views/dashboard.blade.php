@extends('layouts.app')

@section('title', 'Dashboard')
@section('page_title', 'Dashboard')

@section('content')
<style>
    .stat-row {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
        gap: 12px;
        margin-bottom: 16px;
    }
    .stat-box {
        background-color: #fff;
        border: 1px solid #ddd;
        border-radius: 4px;
        padding: 14px 16px;
    }
    .stat-box-title {
        font-size: 12px;
        color: #777;
        margin-bottom: 4px;
    }
    .stat-box-value {
        font-size: 24px;
        font-weight: 700;
        color: #333;
    }
    .dashboard-grid {
        display: grid;
        grid-template-columns: 2fr 1fr;
        gap: 16px;
    }
    @media (max-width: 992px) {
        .dashboard-grid {
            grid-template-columns: 1fr;
        }
    }
</style>

<!-- Quick Action -->
<div style="margin-bottom: 16px; display: flex; gap: 8px;">
    <a href="{{ route('transactions.create') }}" class="btn btn-primary" id="btn-quick-transaction">
        + Catat Transaksi
    </a>
    @if(Auth::user()->isAdmin())
    <a href="{{ route('products.create') }}" class="btn btn-secondary" id="btn-quick-add-product">
        + Tambah Produk
    </a>
    @endif
</div>

<!-- Stat Cards -->
<div class="stat-row">
    <div class="stat-box">
        <div class="stat-box-title">Total Produk</div>
        <div class="stat-box-value">{{ $totalProducts }}</div>
    </div>

    <div class="stat-box">
        <div class="stat-box-title">Total Kategori</div>
        <div class="stat-box-value">{{ $totalCategories }}</div>
    </div>

    <div class="stat-box">
        <div class="stat-box-title" style="color: #856404;">Stok Menipis</div>
        <div class="stat-box-value" style="color: #856404;">{{ $lowStockCount }}</div>
    </div>

    <div class="stat-box">
        <div class="stat-box-title">Total Unit</div>
        <div class="stat-box-value">{{ number_format($totalStockUnits, 0, ',', '.') }}</div>
    </div>
</div>

<!-- Main Section -->
<div class="dashboard-grid">
    <!-- 5 Recent Transactions -->
    <div class="card">
        <div class="card-header">
            <h3>5 Transaksi Terakhir</h3>
            <a href="{{ route('transactions.index') }}" class="btn btn-secondary btn-sm">Lihat Semua</a>
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
                            <th>Petugas</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentTransactions as $tx)
                        <tr>
                            <td>{{ \Carbon\Carbon::parse($tx->transaction_date)->format('d/m/Y') }}</td>
                            <td>
                                <strong>{{ $tx->product->name ?? '-' }}</strong>
                                <div style="font-size: 11px; color: #999;">{{ $tx->product->sku ?? '-' }}</div>
                            </td>
                            <td>
                                @if($tx->type === 'in')
                                <span class="badge badge-success">Masuk</span>
                                @else
                                <span class="badge badge-danger">Keluar</span>
                                @endif
                            </td>
                            <td>
                                <strong style="{{ $tx->type === 'in' ? 'color: #155724;' : 'color: #721c24;' }}">
                                    {{ $tx->type === 'in' ? '+' : '-' }}{{ $tx->quantity }}
                                </strong>
                            </td>
                            <td>{{ $tx->user->name ?? '-' }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" style="text-align: center; padding: 20px; color: #999;">
                                Belum ada transaksi.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Low Stock Alert -->
    <div class="card">
        <div class="card-header">
            <h3>Peringatan Stok</h3>
        </div>
        <div class="card-body">
            @forelse($lowStockProducts as $low)
            <div style="display: flex; justify-content: space-between; padding: 8px 10px; background-color: #fff3cd; border: 1px solid #ffc107; border-radius: 3px; margin-bottom: 6px; font-size: 13px;">
                <div>
                    <strong>{{ $low->name }}</strong>
                    <div style="font-size: 11px; color: #856404;">Min: {{ $low->min_stock }}</div>
                </div>
                <span class="badge badge-danger">Sisa: {{ $low->stock }}</span>
            </div>
            @empty
            <div style="text-align: center; padding: 20px; color: #155724;">
                <strong>Stok Aman</strong>
                <p style="font-size: 12px; color: #999; margin-top: 4px;">Semua stok di atas batas minimum.</p>
            </div>
            @endforelse

            <div style="margin-top: 12px;">
                <a href="{{ route('products.index', ['stock_filter' => 'low']) }}" class="btn btn-secondary btn-sm" style="width: 100%; justify-content: center;">
                    Lihat Produk Stok Menipis
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
