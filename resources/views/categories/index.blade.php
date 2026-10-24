@extends('layouts.app')

@section('title', 'Kategori Produk')
@section('page_title', 'Kelola Kategori Produk')

@section('content')
<div class="card">
    <div class="card-header">
        <div>
            <h3 class="card-title">Daftar Kategori</h3>
            <span class="card-subtitle">Pengelompokan barang inventaris gudang</span>
        </div>
        <a href="{{ route('categories.create') }}" class="btn btn-primary" id="btn-add-category">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 5v14M5 12h14"/></svg>
            Tambah Kategori Baru
        </a>
    </div>

    <div class="card-body">
        <!-- Search Bar -->
        <form action="{{ route('categories.index') }}" method="GET" style="margin-bottom: 24px; display: flex; gap: 12px; max-width: 480px;">
            <input type="text" name="search" class="form-control" placeholder="Cari nama atau deskripsi kategori..." value="{{ $search ?? '' }}">
            <button type="submit" class="btn btn-secondary">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/></svg>
                Cari
            </button>
            @if(!empty($search))
            <a href="{{ route('categories.index') }}" class="btn btn-secondary" title="Reset Pencarian">Reset</a>
            @endif
        </form>

        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th style="width: 60px;">#</th>
                        <th>Nama Kategori</th>
                        <th>Deskripsi</th>
                        <th style="width: 140px; text-align: center;">Jumlah Produk</th>
                        <th style="width: 160px; text-align: right;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($categories as $category)
                    <tr>
                        <td>{{ $loop->iteration + ($categories->currentPage() - 1) * $categories->perPage() }}</td>
                        <td>
                            <strong style="color: #0f172a; font-size: 0.95rem;">{{ $category->name }}</strong>
                        </td>
                        <td style="color: #64748b; max-width: 320px;">
                            {{ $category->description ?: '-' }}
                        </td>
                        <td style="text-align: center;">
                            <span class="badge badge-primary">
                                {{ $category->products_count }} Produk
                            </span>
                        </td>
                        <td style="text-align: right;">
                            <div style="display: inline-flex; gap: 6px;">
                                <a href="{{ route('categories.edit', $category) }}" class="btn btn-secondary btn-sm" title="Edit Kategori">
                                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 3a2.85 2.83 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5Z"/></svg>
                                    Ubah
                                </a>
                                <form action="{{ route('categories.destroy', $category) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus kategori \'{{ $category->name }}\'? Jika ada produk yang menggunakan kategori ini, sistem akan menolaknya.')" style="margin: 0;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" title="Hapus Kategori">
                                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 6h18M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"/></svg>
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" style="text-align: center; padding: 40px; color: #94a3b8;">
                            Tidak ada kategori yang ditemukan.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div style="margin-top: 20px;">
            {{ $categories->links() }}
        </div>
    </div>
</div>
@endsection
