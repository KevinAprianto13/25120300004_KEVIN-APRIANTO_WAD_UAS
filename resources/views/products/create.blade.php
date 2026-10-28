@extends('layouts.app')

@section('title', 'Tambah Produk')
@section('page_title', 'Tambah Produk')

@section('content')
<div class="card" style="max-width: 700px;">
    <div class="card-header">
        <h3>Form Produk Baru</h3>
        <a href="{{ route('products.index') }}" class="btn btn-secondary btn-sm">← Kembali</a>
    </div>

    <div class="card-body">
        <form action="{{ route('products.store') }}" method="POST" id="form-create-product">
            @csrf

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px;">
                <div class="form-group">
                    <label class="form-label" for="prod-category">Kategori <span class="required">*</span></label>
                    <select id="prod-category" name="category_id" class="form-select" required autofocus>
                        <option value="">-- Pilih --</option>
                        @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>
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
                    <input type="text" id="prod-sku" name="sku" class="form-control" placeholder="Contoh: ELK-009" value="{{ old('sku') }}" required>
                    @error('sku')
                    <div class="form-error">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="form-group">
                <label class="form-label" for="prod-name">Nama Barang <span class="required">*</span></label>
                <input type="text" id="prod-name" name="name" class="form-control" placeholder="Nama produk" value="{{ old('name') }}" required>
                @error('name')
                <div class="form-error">{{ $message }}</div>
                @enderror
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 16px;">
                <div class="form-group">
                    <label class="form-label" for="prod-stock">Stok Awal <span class="required">*</span></label>
                    <input type="number" id="prod-stock" name="stock" class="form-control" min="0" value="{{ old('stock', 0) }}" required>
                    @error('stock')
                    <div class="form-error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label" for="prod-min-stock">Batas Minimum <span class="required">*</span></label>
                    <input type="number" id="prod-min-stock" name="min_stock" class="form-control" min="0" value="{{ old('min_stock', 5) }}" required>
                    @error('min_stock')
                    <div class="form-error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label" for="prod-price">Harga (Rp) <span class="required">*</span></label>
                    <input type="number" id="prod-price" name="price" class="form-control" min="0" step="100" placeholder="85000" value="{{ old('price') }}" required>
                    @error('price')
                    <div class="form-error">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div style="display: flex; gap: 8px; margin-top: 20px;">
                <button type="submit" class="btn btn-primary" id="btn-save-product">Simpan</button>
                <a href="{{ route('products.index') }}" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection
