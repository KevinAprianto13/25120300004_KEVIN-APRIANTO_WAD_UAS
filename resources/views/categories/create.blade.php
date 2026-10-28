@extends('layouts.app')

@section('title', 'Tambah Kategori')
@section('page_title', 'Tambah Kategori')

@section('content')
<div class="card" style="max-width: 600px;">
    <div class="card-header">
        <h3>Form Kategori Baru</h3>
        <a href="{{ route('categories.index') }}" class="btn btn-secondary btn-sm">← Kembali</a>
    </div>

    <div class="card-body">
        <form action="{{ route('categories.store') }}" method="POST" id="form-create-category">
            @csrf

            <div class="form-group">
                <label class="form-label" for="category-name">Nama <span class="required">*</span></label>
                <input type="text" id="category-name" name="name" class="form-control" placeholder="Nama kategori" value="{{ old('name') }}" required autofocus>
                @error('name')
                <div class="form-error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label class="form-label" for="category-desc">Deskripsi</label>
                <textarea id="category-desc" name="description" rows="3" class="form-control" placeholder="Opsional">{{ old('description') }}</textarea>
                @error('description')
                <div class="form-error">{{ $message }}</div>
                @enderror
            </div>

            <div style="display: flex; gap: 8px; margin-top: 20px;">
                <button type="submit" class="btn btn-primary" id="btn-save-category">Simpan</button>
                <a href="{{ route('categories.index') }}" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection
