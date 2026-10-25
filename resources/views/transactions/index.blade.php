@extends('layouts.app')

@section('title', 'Riwayat Transaksi')
@section('page_title', 'Riwayat Mutasi Transaksi Stok')

@section('content')
<div class="card">
    <div class="card-header">
        <div>
            <h3 class="card-title">
                Riwayat Transaksi Stok
                @if(!Auth::user()->isAdmin())
                <span style="font-size: 0.85rem; font-weight: normal; color: #64748b;">(Menampilkan transaksi yang Anda catat)</span>
                @else
                <span style="font-size: 0.85rem; font-weight: normal; color: #64748b;">(Semua transaksi gudang)</span>
                @endif
            </h3>
            <span class="card-subtitle">Pencatatan pergerakan barang masuk dan barang keluar secara akurat</span>
        </div>
        <a href="{{ route('transactions.create') }}" class="btn btn-primary" id="btn-create-transaction">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 5v14M5 12h14"/></svg>
            Catat Transaksi Baru
        </a>
    </div>

    <div class="card-body">
        <!-- Filter bar -->
        <form action="{{ route('transactions.index') }}" method="GET" style="margin-bottom: 24px; display: flex; flex-wrap: wrap; gap: 12px; align-items: center;">
            <div style="flex: 1; min-width: 240px;">
                <input type="text" name="search" class="form-control" placeholder="Cari nama barang atau kode SKU..." value="{{ $search ?? '' }}">
            </div>

            <div style="min-width: 180px;">
                <select name="type" class="form-select">
                    <option value="">Semua Jenis Mutasi</option>
                    <option value="in" {{ ($type ?? '') === 'in' ? 'selected' : '' }}>📥 Barang Masuk (IN)</option>
                    <option value="out" {{ ($type ?? '') === 'out' ? 'selected' : '' }}>📤 Barang Keluar (OUT)</option>
                </select>
            </div>

            <button type="submit" class="btn btn-secondary">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/></svg>
                Filter
            </button>

            @if(!empty($search) || !empty($type))
            <a href="{{ route('transactions.index') }}" class="btn btn-secondary" title="Reset Filter">Reset</a>
            @endif
        </form>

        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th style="width: 60px;">#</th>
                        <th>Tanggal</th>
                        <th>Kode SKU</th>
                        <th>Nama Produk</th>
                        <th>Kategori</th>
                        <th style="text-align: center;">Jenis Mutasi</th>
                        <th style="text-align: right;">Jumlah</th>
                        <th>Catatan</th>
                        <th>Petugas Pelapor</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($transactions as $tx)
                    <tr>
                        <td>{{ $loop->iteration + ($transactions->currentPage() - 1) * $transactions->perPage() }}</td>
                        <td style="font-weight: 600; color: #1e293b;">
                            {{ \Carbon\Carbon::parse($tx->transaction_date)->format('d/m/Y') }}
                        </td>
                        <td>
                            <code style="background: #f1f5f9; padding: 2px 7px; border-radius: 4px; font-weight: 700; color: #334155; font-size: 0.8rem;">
                                {{ $tx->product->sku ?? '-' }}
                            </code>
                        </td>
                        <td>
                            <strong style="color: #0f172a;">{{ $tx->product->name ?? 'Produk Dihapus' }}</strong>
                        </td>
                        <td>
                            <span class="badge badge-primary">
                                {{ $tx->product->category->name ?? '-' }}
                            </span>
                        </td>
                        <td style="text-align: center;">
                            @if($tx->type === 'in')
                            <span class="badge badge-success">
                                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M12 5v14M5 12l7-7 7 7"/></svg>
                                Masuk (IN)
                            </span>
                            @else
                            <span class="badge badge-danger">
                                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M12 19V5M5 12l7 7 7-7"/></svg>
                                Keluar (OUT)
                            </span>
                            @endif
                        </td>
                        <td style="text-align: right;">
                            <strong style="font-size: 0.95rem; {{ $tx->type === 'in' ? 'color: #059669;' : 'color: #dc2626;' }}">
                                {{ $tx->type === 'in' ? '+' : '-' }}{{ $tx->quantity }} unit
                            </strong>
                        </td>
                        <td style="color: #64748b; font-size: 0.82rem; max-width: 220px;">
                            {{ $tx->note ?: '-' }}
                        </td>
                        <td>
                            <div style="font-weight: 600; color: #334155;">{{ $tx->user->name ?? 'User' }}</div>
                            <span style="font-size: 0.7rem; color: #94a3b8; text-transform: uppercase;">{{ $tx->user->role ?? '' }}</span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="9" style="text-align: center; padding: 40px; color: #94a3b8;">
                            Belum ada riwayat transaksi yang tercatat.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div style="margin-top: 20px;">
            {{ $transactions->links() }}
        </div>
    </div>
</div>
@endsection
