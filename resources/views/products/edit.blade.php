@extends('layouts.app')

@section('title', 'Ubah Produk')
@section('page_title', 'Ubah Data Produk')

@section('content')
<div class="card" style="max-width: 760px;">
    <div class="card-header">
        <div>
            <h3 class="card-title">Form Ubah Data Produk</h3>
            <span class="card-subtitle">Perbarui data spesifikasi dan parameter stok '{{ $product->name }}'</span>
        </div>
        <a href="{{ route('products.index') }}" class="btn btn-secondary btn-sm">
            ← Kembali ke Katalog
        </a>
    </div>

    <div class="card-body">
        <form action="{{ route('products.update', $product) }}" method="POST" id="form-edit-product">
            @csrf
            @method('PUT')

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                <div class="form-group">
                    <label class="form-label" for="prod-category">
                        Kategori Barang <span class="required">*</span>
                    </label>
                    <select id="prod-category" name="category_id" class="form-select" required autofocus>
                        @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ old('category_id', $product->category_id) == $cat->id ? 'selected' : '' }}>
                            {{ $cat->name }}
                        </option>
                        @endforeach
                    </select>
                    @error('category_id')
                    <div class="form-error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label" for="prod-sku">
                        Kode SKU (Stock Keeping Unit) <span class="required">*</span>
                    </label>
                    <input type="text" id="prod-sku" name="sku" class="form-control" value="{{ old('sku', $product->sku) }}" required>
                    @error('sku')
                    <div class="form-error">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="form-group">
                <label class="form-label" for="prod-name">
                    Nama Barang Lengkap <span class="required">*</span>
                </label>
                <input type="text" id="prod-name" name="name" class="form-control" value="{{ old('name', $product->name) }}" required>
                @error('name')
                <div class="form-error">{{ $message }}</div>
                @enderror
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 20px;">
                <div class="form-group">
                    <label class="form-label" for="prod-stock">
                        Stok Saat Ini <span class="required">*</span>
                    </label>
                    <input type="number" id="prod-stock" name="stock" class="form-control" min="0" value="{{ old('stock', $product->stock) }}" required>
                    @error('stock')
                    <div class="form-error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label" for="prod-min-stock">
                        Batas Stok Menipis <span class="required">*</span>
                    </label>
                    <input type="number" id="prod-min-stock" name="min_stock" class="form-control" min="0" value="{{ old('min_stock', $product->min_stock) }}" required>
                    @error('min_stock')
                    <div class="form-error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label" for="prod-price">
                        Harga Satuan (Rp) <span class="required">*</span>
                    </label>
                    <input type="number" id="prod-price" name="price" class="form-control" min="0" step="100" value="{{ old('price', (int)$product->price) }}" required>
                    @error('price')
                    <div class="form-error">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div style="display: flex; gap: 12px; margin-top: 24px;">
                <button type="submit" class="btn btn-primary" id="btn-update-product">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/></svg>
                    Simpan Perubahan
                </button>
                <a href="{{ route('products.index') }}" class="btn btn-secondary">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
