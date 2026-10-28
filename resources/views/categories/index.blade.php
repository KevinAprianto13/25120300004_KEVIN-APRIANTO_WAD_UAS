@extends('layouts.app')

@section('title', 'Kategori')
@section('page_title', 'Kategori Produk')

@section('content')
<div class="card">
    <div class="card-header">
        <h3>Kategori</h3>
        <a href="{{ route('categories.create') }}" class="btn btn-primary btn-sm" id="btn-add-category">+ Tambah</a>
    </div>

    <div class="card-body">
        <form action="{{ route('categories.index') }}" method="GET" style="margin-bottom: 16px; display: flex; gap: 8px; max-width: 400px;">
            <input type="text" name="search" class="form-control" placeholder="Cari kategori..." value="{{ $search ?? '' }}">
            <button type="submit" class="btn btn-secondary">Cari</button>
            @if(!empty($search))
            <a href="{{ route('categories.index') }}" class="btn btn-secondary">Reset</a>
            @endif
        </form>

        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th style="width: 50px;">#</th>
                        <th>Nama</th>
                        <th>Deskripsi</th>
                        <th style="text-align: center;">Produk</th>
                        <th style="text-align: right;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($categories as $category)
                    <tr>
                        <td>{{ $loop->iteration + ($categories->currentPage() - 1) * $categories->perPage() }}</td>
                        <td><strong>{{ $category->name }}</strong></td>
                        <td style="color: #888;">{{ $category->description ?: '-' }}</td>
                        <td style="text-align: center;">{{ $category->products_count }}</td>
                        <td style="text-align: right;">
                            <div style="display: inline-flex; gap: 4px;">
                                <a href="{{ route('categories.edit', $category) }}" class="btn btn-secondary btn-sm">Ubah</a>
                                <form action="{{ route('categories.destroy', $category) }}" method="POST" onsubmit="return confirm('Hapus kategori \'{{ $category->name }}\'?')" style="margin: 0;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" style="text-align: center; padding: 30px; color: #999;">
                            Tidak ada kategori.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div style="margin-top: 16px;">
            {{ $categories->links() }}
        </div>
    </div>
</div>
@endsection
