@extends('layouts.app')

@section('title', 'Detail Produk - ' . $product->name)
@section('page_title', 'Detail Produk')

@section('content')
<div class="card" style="max-width: 800px; margin-bottom: 16px;">
    <div class="card-header">
        <h3>{{ $product->name }}</h3>
        @if(Auth::user()->isAdmin())
        <a href="{{ route('products.edit', $product) }}" class="btn btn-secondary btn-sm">Ubah</a>
        @endif
    </div>
    <div class="card-body">
        <table style="font-size: 13px; line-height: 2;">
            <tr><td style="color: #888; padding-right: 20px;">SKU</td><td><code>{{ $product->sku }}</code></td></tr>
            <tr><td style="color: #888; padding-right: 20px;">Kategori</td><td>{{ $product->category->name ?? '-' }}</td></tr>
            <tr><td style="color: #888; padding-right: 20px;">Harga</td><td><strong>Rp {{ number_format($product->price, 0, ',', '.') }}</strong></td></tr>
            <tr><td style="color: #888; padding-right: 20px;">Batas Minimum</td><td>{{ $product->min_stock }} unit</td></tr>
            <tr>
                <td style="color: #888; padding-right: 20px;">Stok</td>
                <td>
                    @if($product->stock === 0)
                    <span class="badge badge-danger">Habis (0)</span>
                    @elseif($product->isLowStock())
                    <span class="badge badge-warning">Menipis ({{ $product->stock }})</span>
                    @else
                    <span class="badge badge-success">{{ $product->stock }} unit</span>
                    @endif
                </td>
            </tr>
        </table>

        <div style="margin-top: 16px; display: flex; gap: 8px;">
            <a href="{{ route('transactions.create') }}" class="btn btn-primary btn-sm">Catat Transaksi</a>
            <a href="{{ route('products.index') }}" class="btn btn-secondary btn-sm">Kembali</a>
        </div>
    </div>
</div>

<!-- Transaction History -->
<div class="card">
    <div class="card-header">
        <h3>Riwayat Mutasi</h3>
    </div>
    <div class="card-body" style="padding: 0;">
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>Tanggal</th>
                        <th>Jenis</th>
                        <th>Jumlah</th>
                        <th>Catatan</th>
                        <th>Petugas</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($recentTransactions as $tx)
                    <tr>
                        <td>{{ \Carbon\Carbon::parse($tx->transaction_date)->format('d/m/Y') }}</td>
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
                        <td style="color: #888;">{{ $tx->note ?: '-' }}</td>
                        <td><strong>{{ $tx->user->name ?? '-' }}</strong></td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" style="text-align: center; padding: 24px; color: #999;">
                            Belum ada riwayat transaksi.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
