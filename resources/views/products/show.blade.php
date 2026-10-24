@extends('layouts.app')

@section('title', 'Detail Produk - ' . $product->name)
@section('page_title', 'Detail Produk & Mutasi')

@section('content')
<div style="display: flex; gap: 24px; flex-wrap: wrap; margin-bottom: 24px;">
    <!-- Product Profile Card -->
    <div class="card" style="flex: 1; min-width: 320px;">
        <div class="card-header">
            <div>
                <h3 class="card-title">{{ $product->name }}</h3>
                <span class="card-subtitle">Kode SKU: <code>{{ $product->sku }}</code></span>
            </div>
            @if(Auth::user()->isAdmin())
            <a href="{{ route('products.edit', $product) }}" class="btn btn-secondary btn-sm">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 3a2.85 2.83 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5Z"/></svg>
                Ubah Data
            </a>
            @endif
        </div>
        <div class="card-body">
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px; margin-bottom: 20px;">
                <div>
                    <div style="font-size: 0.75rem; color: #64748b; font-weight: 700; text-transform: uppercase;">Kategori</div>
                    <div style="font-size: 1rem; font-weight: 700; color: #0f172a; margin-top: 4px;">
                        <span class="badge badge-primary">{{ $product->category->name ?? '-' }}</span>
                    </div>
                </div>

                <div>
                    <div style="font-size: 0.75rem; color: #64748b; font-weight: 700; text-transform: uppercase;">Harga Satuan</div>
                    <div style="font-size: 1.15rem; font-weight: 800; color: #2563eb; margin-top: 4px;">
                        Rp {{ number_format($product->price, 0, ',', '.') }}
                    </div>
                </div>

                <div>
                    <div style="font-size: 0.75rem; color: #64748b; font-weight: 700; text-transform: uppercase;">Batas Stok Menipis</div>
                    <div style="font-size: 1rem; font-weight: 700; color: #334155; margin-top: 4px;">
                        {{ $product->min_stock }} unit
                    </div>
                </div>

                <div>
                    <div style="font-size: 0.75rem; color: #64748b; font-weight: 700; text-transform: uppercase;">Status Stok Fisik</div>
                    <div style="margin-top: 4px;">
                        @if($product->stock === 0)
                        <span class="badge badge-danger" style="font-size: 0.85rem; padding: 5px 12px;">⛔ Stok Habis (0)</span>
                        @elseif($product->isLowStock())
                        <span class="badge badge-warning" style="font-size: 0.85rem; padding: 5px 12px;">⚠️ Menipis ({{ $product->stock }} unit)</span>
                        @else
                        <span class="badge badge-success" style="font-size: 0.85rem; padding: 5px 12px;">✓ Aman ({{ $product->stock }} unit)</span>
                        @endif
                    </div>
                </div>
            </div>

            <div style="padding-top: 16px; border-top: 1px solid var(--border-color); display: flex; gap: 10px;">
                <a href="{{ route('transactions.create') }}" class="btn btn-primary btn-sm">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 5v14M5 12h14"/></svg>
                    Catat Mutasi Stok Produk Ini
                </a>
                <a href="{{ route('products.index') }}" class="btn btn-secondary btn-sm">
                    Kembali ke Katalog
                </a>
            </div>
        </div>
    </div>
</div>

<!-- History of transactions for this product -->
<div class="card">
    <div class="card-header">
        <div>
            <h3 class="card-title">Riwayat Mutasi Produk Ini</h3>
            <span class="card-subtitle">Semua catatan barang masuk dan keluar untuk item ini</span>
        </div>
    </div>
    <div class="card-body" style="padding: 0;">
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>Tanggal</th>
                        <th>Jenis Transaksi</th>
                        <th>Jumlah</th>
                        <th>Keterangan / Catatan</th>
                        <th>Petugas</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($recentTransactions as $tx)
                    <tr>
                        <td>{{ \Carbon\Carbon::parse($tx->transaction_date)->format('d F Y') }}</td>
                        <td>
                            @if($tx->type === 'in')
                            <span class="badge badge-success">Masuk (IN)</span>
                            @else
                            <span class="badge badge-danger">Keluar (OUT)</span>
                            @endif
                        </td>
                        <td>
                            <strong style="{{ $tx->type === 'in' ? 'color: #059669;' : 'color: #dc2626;' }}">
                                {{ $tx->type === 'in' ? '+' : '-' }}{{ $tx->quantity }} unit
                            </strong>
                        </td>
                        <td style="color: #64748b;">
                            {{ $tx->note ?: '-' }}
                        </td>
                        <td>
                            <strong>{{ $tx->user->name ?? 'User' }}</strong>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" style="text-align: center; padding: 36px; color: #94a3b8;">
                            Belum ada riwayat transaksi tercatat untuk produk ini.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
