@extends('layouts.app')

@section('title', 'Daftar Produk')
@section('page_title', 'Katalog & Stok Produk')

@section('content')
<div class="card">
    <div class="card-header">
        <div>
            <h3 class="card-title">Inventaris Produk Gudang</h3>
            <span class="card-subtitle">Semua data item barang, level stok, dan harga</span>
        </div>
        @if(Auth::user()->isAdmin())
        <a href="{{ route('products.create') }}" class="btn btn-primary" id="btn-add-product">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 5v14M5 12h14"/></svg>
            Tambah Produk Baru
        </a>
        @endif
    </div>

    <div class="card-body">
        <!-- Filter and Search Bar (Section C.4: pencarian dan filter kategori) -->
        <form action="{{ route('products.index') }}" method="GET" style="margin-bottom: 24px; display: flex; flex-wrap: wrap; gap: 12px; align-items: center;">
            <div style="flex: 1; min-width: 240px;">
                <input type="text" name="search" class="form-control" placeholder="Cari nama barang atau kode SKU..." value="{{ $search ?? '' }}">
            </div>

            <div style="min-width: 200px;">
                <select name="category_id" class="form-select">
                    <option value="">Semua Kategori</option>
                    @foreach($categories as $cat)
                    <option value="{{ $cat->id }}" {{ (string)($categoryId ?? '') === (string)$cat->id ? 'selected' : '' }}>
                        {{ $cat->name }}
                    </option>
                    @endforeach
                </select>
            </div>

            <div style="min-width: 170px;">
                <select name="stock_filter" class="form-select">
                    <option value="">Semua Status Stok</option>
                    <option value="low" {{ ($stockFilter ?? '') === 'low' ? 'selected' : '' }}>⚠️ Stok Menipis</option>
                    <option value="out" {{ ($stockFilter ?? '') === 'out' ? 'selected' : '' }}>⛔ Stok Habis (0)</option>
                </select>
            </div>

            <button type="submit" class="btn btn-secondary">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/></svg>
                Filter
            </button>

            @if(!empty($search) || !empty($categoryId) || !empty($stockFilter))
            <a href="{{ route('products.index') }}" class="btn btn-secondary" title="Reset Filter">Reset</a>
            @endif
        </form>

        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>SKU</th>
                        <th>Nama Produk</th>
                        <th>Kategori</th>
                        <th style="text-align: right;">Harga Satuan</th>
                        <th style="text-align: center;">Batas Min</th>
                        <th style="text-align: center;">Stok Saat Ini</th>
                        <th style="text-align: right;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($products as $product)
                    <tr>
                        <td>
                            <code style="background: #f1f5f9; padding: 3px 8px; border-radius: 6px; font-weight: 700; color: #1e293b; font-size: 0.82rem;">
                                {{ $product->sku }}
                            </code>
                        </td>
                        <td>
                            <a href="{{ route('products.show', $product) }}" style="text-decoration: none; color: #0f172a; font-weight: 700; font-size: 0.92rem;">
                                {{ $product->name }}
                            </a>
                        </td>
                        <td>
                            <span class="badge badge-primary">
                                {{ $product->category->name ?? '-' }}
                            </span>
                        </td>
                        <td style="text-align: right; font-weight: 600; color: #334155;">
                            Rp {{ number_format($product->price, 0, ',', '.') }}
                        </td>
                        <td style="text-align: center; color: #64748b;">
                            {{ $product->min_stock }} unit
                        </td>
                        <td style="text-align: center;">
                            @if($product->stock === 0)
                            <span class="badge badge-danger">
                                ⛔ Habis (0)
                            </span>
                            @elseif($product->isLowStock())
                            <span class="badge badge-warning" title="Stok di bawah atau sama dengan batas minimum {{ $product->min_stock }}">
                                ⚠️ Menipis ({{ $product->stock }})
                            </span>
                            @else
                            <span class="badge badge-success">
                                ✓ {{ $product->stock }} unit
                            </span>
                            @endif
                        </td>
                        <td style="text-align: right;">
                            <div style="display: inline-flex; gap: 6px;">
                                <a href="{{ route('products.show', $product) }}" class="btn btn-secondary btn-sm" title="Lihat Detail Produk">
                                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z"/><circle cx="12" cy="12" r="3"/></svg>
                                    Detail
                                </a>

                                @if(Auth::user()->isAdmin())
                                <a href="{{ route('products.edit', $product) }}" class="btn btn-secondary btn-sm" title="Ubah Produk">
                                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 3a2.85 2.83 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5Z"/></svg>
                                    Ubah
                                </a>
                                <form action="{{ route('products.destroy', $product) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus produk \'{{ $product->name }}\'? Jika memiliki transaksi stok, penghapusan akan ditolak demi keamanan data.')" style="margin: 0;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" title="Hapus Produk">
                                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 6h18M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"/></svg>
                                        Hapus
                                    </button>
                                </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" style="text-align: center; padding: 40px; color: #94a3b8;">
                            Tidak ada produk yang cocok dengan kriteria filter Anda.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div style="margin-top: 20px;">
            {{ $products->links() }}
        </div>
    </div>
</div>
@endsection
