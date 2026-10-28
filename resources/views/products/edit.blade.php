@extends('layouts.app')

@section('title', 'Ubah Produk')
@section('page_title', 'Ubah Produk')

@section('content')
<div class="card" style="max-width: 700px;">
    <div class="card-header">
        <h3>Ubah: {{ $product->name }}</h3>
        <a href="{{ route('products.index') }}" class="btn btn-secondary btn-sm">← Kembali</a>
    </div>

    <div class="card-body">
        <form action="{{ route('products.update', $product) }}" method="POST" id="form-edit-product">
            @csrf
            @method('PUT')

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px;">
                <div class="form-group">
                    <label class="form-label" for="prod-category">Kategori <span class="required">*</span></label>
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
                    <label class="form-label" for="prod-sku">SKU <span class="required">*</span></label>
                    <input type="text" id="prod-sku" name="sku" class="form-control" value="{{ old('sku', $product->sku) }}" required>
                    @error('sku')
                    <div class="form-error">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="form-group">
                <label class="form-label" for="prod-name">Nama Barang <span class="required">*</span></label>
                <input type="text" id="prod-name" name="name" class="form-control" value="{{ old('name', $product->name) }}" required>
                @error('name')
                <div class="form-error">{{ $message }}</div>
                @enderror
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 16px;">
                <div class="form-group">
                    <label class="form-label" for="prod-stock">Stok <span class="required">*</span></label>
                    <input type="number" id="prod-stock" name="stock" class="form-control" min="0" value="{{ old('stock', $product->stock) }}" required>
                    @error('stock')
                    <div class="form-error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label" for="prod-min-stock">Batas Minimum <span class="required">*</span></label>
                    <input type="number" id="prod-min-stock" name="min_stock" class="form-control" min="0" value="{{ old('min_stock', $product->min_stock) }}" required>
                    @error('min_stock')
                    <div class="form-error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label" for="prod-price">Harga (Rp) <span class="required">*</span></label>
                    <input type="number" id="prod-price" name="price" class="form-control" min="0" step="100" value="{{ old('price', (int)$product->price) }}" required>
                    @error('price')
                    <div class="form-error">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div style="display: flex; gap: 8px; margin-top: 20px;">
                <button type="submit" class="btn btn-primary" id="btn-update-product">Simpan</button>
                <a href="{{ route('products.index') }}" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection
