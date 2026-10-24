@extends('layouts.app')

@section('title', 'Ubah Kategori')
@section('page_title', 'Ubah Data Kategori')

@section('content')
<div class="card" style="max-width: 650px;">
    <div class="card-header">
        <div>
            <h3 class="card-title">Form Edit Kategori</h3>
            <span class="card-subtitle">Perbarui data kelompok inventaris '{{ $category->name }}'</span>
        </div>
        <a href="{{ route('categories.index') }}" class="btn btn-secondary btn-sm">
            ← Kembali ke Daftar
        </a>
    </div>

    <div class="card-body">
        <form action="{{ route('categories.update', $category) }}" method="POST" id="form-edit-category">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label class="form-label" for="category-name">
                    Nama Kategori <span class="required">*</span>
                </label>
                <input type="text" id="category-name" name="name" class="form-control" value="{{ old('name', $category->name) }}" required autofocus>
                @error('name')
                <div class="form-error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label class="form-label" for="category-desc">Deskripsi Kategori (Opsional)</label>
                <textarea id="category-desc" name="description" rows="4" class="form-control">{{ old('description', $category->description) }}</textarea>
                @error('description')
                <div class="form-error">{{ $message }}</div>
                @enderror
            </div>

            <div style="display: flex; gap: 12px; margin-top: 24px;">
                <button type="submit" class="btn btn-primary" id="btn-update-category">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/></svg>
                    Simpan Perubahan
                </button>
                <a href="{{ route('categories.index') }}" class="btn btn-secondary">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
