@extends('layouts.app')

@section('title', 'Daftar Produk')
@section('page_title', 'Daftar Produk')

@section('content')
<div class="card">
    <div class="card-header">
        <h3>Produk</h3>
        @if(Auth::user()->isAdmin())
        <a href="{{ route('products.create') }}" class="btn btn-primary btn-sm" id="btn-add-product">+ Tambah</a>
        @endif
    </div>

    <div class="card-body">
        <!-- Filter -->
        <form action="{{ route('products.index') }}" method="GET" style="margin-bottom: 16px; display: flex; flex-wrap: wrap; gap: 8px; align-items: center;">
            <div style="flex: 1; min-width: 200px;">
                <input type="text" name="search" class="form-control" placeholder="Cari nama / SKU..." value="{{ $search ?? '' }}">
            </div>
            <div style="min-width: 160px;">
                <select name="category_id" class="form-select">
                    <option value="">Semua Kategori</option>
                    @foreach($categories as $cat)
                    <option value="{{ $cat->id }}" {{ (string)($categoryId ?? '') === (string)$cat->id ? 'selected' : '' }}>
                        {{ $cat->name }}
                    </option>
                    @endforeach
                </select>
            </div>
            <div style="min-width: 140px;">
                <select name="stock_filter" class="form-select">
                    <option value="">Semua Stok</option>
                    <option value="low" {{ ($stockFilter ?? '') === 'low' ? 'selected' : '' }}>Stok Menipis</option>
                    <option value="out" {{ ($stockFilter ?? '') === 'out' ? 'selected' : '' }}>Stok Habis</option>
                </select>
            </div>
            <button type="submit" class="btn btn-secondary">Filter</button>
            @if(!empty($search) || !empty($categoryId) || !empty($stockFilter))
            <a href="{{ route('products.index') }}" class="btn btn-secondary">Reset</a>
            @endif
        </form>

        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>SKU</th>
                        <th>Nama</th>
                        <th>Kategori</th>
                        <th style="text-align: right;">Harga</th>
                        <th style="text-align: center;">Min</th>
                        <th style="text-align: center;">Stok</th>
                        <th style="text-align: right;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($products as $product)
                    <tr>
                        <td><code>{{ $product->sku }}</code></td>
                        <td>
                            <a href="{{ route('products.show', $product) }}" style="text-decoration: none; color: #333; font-weight: 600;">
                                {{ $product->name }}
                            </a>
                        </td>
                        <td>{{ $product->category->name ?? '-' }}</td>
                        <td style="text-align: right;">Rp {{ number_format($product->price, 0, ',', '.') }}</td>
                        <td style="text-align: center; color: #888;">{{ $product->min_stock }}</td>
                        <td style="text-align: center;">
                            @if($product->stock === 0)
                            <span class="badge badge-danger">Habis</span>
                            @elseif($product->isLowStock())
                            <span class="badge badge-warning">{{ $product->stock }}</span>
                            @else
                            <span class="badge badge-success">{{ $product->stock }}</span>
                            @endif
                        </td>
                        <td style="text-align: right;">
                            <div style="display: inline-flex; gap: 4px;">
                                <a href="{{ route('products.show', $product) }}" class="btn btn-secondary btn-sm">Detail</a>

                                @if(Auth::user()->isAdmin())
                                <a href="{{ route('products.edit', $product) }}" class="btn btn-secondary btn-sm">Ubah</a>
                                <form action="{{ route('products.destroy', $product) }}" method="POST" onsubmit="return confirm('Hapus produk \'{{ $product->name }}\'?')" style="margin: 0;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                                </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" style="text-align: center; padding: 30px; color: #999;">
                            Tidak ada produk ditemukan.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div style="margin-top: 16px;">
            {{ $products->links() }}
        </div>
    </div>
</div>
@endsection
