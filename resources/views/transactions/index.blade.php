@extends('layouts.app')

@section('title', 'Riwayat Transaksi')
@section('page_title', 'Riwayat Transaksi')

@section('content')
<div class="card">
    <div class="card-header">
        <h3>
            Transaksi
            @if(!Auth::user()->isAdmin())
            <span style="font-size: 12px; font-weight: normal; color: #888;">(milik Anda)</span>
            @endif
        </h3>
        <a href="{{ route('transactions.create') }}" class="btn btn-primary btn-sm" id="btn-create-transaction">+ Catat Baru</a>
    </div>

    <div class="card-body">
        <form action="{{ route('transactions.index') }}" method="GET" style="margin-bottom: 16px; display: flex; flex-wrap: wrap; gap: 8px; align-items: center;">
            <div style="flex: 1; min-width: 200px;">
                <input type="text" name="search" class="form-control" placeholder="Cari nama / SKU..." value="{{ $search ?? '' }}">
            </div>
            <div style="min-width: 140px;">
                <select name="type" class="form-select">
                    <option value="">Semua Jenis</option>
                    <option value="in" {{ ($type ?? '') === 'in' ? 'selected' : '' }}>Masuk</option>
                    <option value="out" {{ ($type ?? '') === 'out' ? 'selected' : '' }}>Keluar</option>
                </select>
            </div>
            <button type="submit" class="btn btn-secondary">Filter</button>
            @if(!empty($search) || !empty($type))
            <a href="{{ route('transactions.index') }}" class="btn btn-secondary">Reset</a>
            @endif
        </form>

        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th style="width: 50px;">#</th>
                        <th>Tanggal</th>
                        <th>SKU</th>
                        <th>Produk</th>
                        <th>Kategori</th>
                        <th style="text-align: center;">Jenis</th>
                        <th style="text-align: right;">Jumlah</th>
                        <th>Catatan</th>
                        <th>Petugas</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($transactions as $tx)
                    <tr>
                        <td>{{ $loop->iteration + ($transactions->currentPage() - 1) * $transactions->perPage() }}</td>
                        <td style="font-weight: 600;">{{ \Carbon\Carbon::parse($tx->transaction_date)->format('d/m/Y') }}</td>
                        <td><code>{{ $tx->product->sku ?? '-' }}</code></td>
                        <td><strong>{{ $tx->product->name ?? '-' }}</strong></td>
                        <td>{{ $tx->product->category->name ?? '-' }}</td>
                        <td style="text-align: center;">
                            @if($tx->type === 'in')
                            <span class="badge badge-success">Masuk</span>
                            @else
                            <span class="badge badge-danger">Keluar</span>
                            @endif
                        </td>
                        <td style="text-align: right;">
                            <strong style="{{ $tx->type === 'in' ? 'color: #155724;' : 'color: #721c24;' }}">
                                {{ $tx->type === 'in' ? '+' : '-' }}{{ $tx->quantity }}
                            </strong>
                        </td>
                        <td style="color: #888; font-size: 12px;">{{ $tx->note ?: '-' }}</td>
                        <td>
                            {{ $tx->user->name ?? '-' }}
                            <span style="font-size: 10px; color: #aaa; text-transform: uppercase;">{{ $tx->user->role ?? '' }}</span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="9" style="text-align: center; padding: 30px; color: #999;">
                            Belum ada transaksi.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div style="margin-top: 16px;">
            {{ $transactions->links() }}
        </div>
    </div>
</div>
@endsection
