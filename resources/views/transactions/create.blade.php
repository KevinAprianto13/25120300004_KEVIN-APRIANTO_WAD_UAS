@extends('layouts.app')

@section('title', 'Catat Transaksi')
@section('page_title', 'Catat Transaksi')

@section('content')
<div class="card" style="max-width: 680px;">
    <div class="card-header">
        <h3>Form Transaksi Stok</h3>
        <a href="{{ route('transactions.index') }}" class="btn btn-secondary btn-sm">← Riwayat</a>
    </div>

    <div class="card-body">
        <form action="{{ route('transactions.store') }}" method="POST" id="form-create-transaction">
            @csrf

            <div class="form-group">
                <label class="form-label" for="tx-product">Produk <span class="required">*</span></label>
                <select id="tx-product" name="product_id" class="form-select" required autofocus onchange="updateStockHint()">
                    <option value="">-- Pilih Produk --</option>
                    @foreach($products as $p)
                    <option value="{{ $p->id }}" data-stock="{{ $p->stock }}" data-sku="{{ $p->sku }}" {{ old('product_id') == $p->id ? 'selected' : '' }}>
                        [{{ $p->sku }}] {{ $p->name }} (stok: {{ $p->stock }})
                    </option>
                    @endforeach
                </select>
                @error('product_id')
                <div class="form-error">{{ $message }}</div>
                @enderror
                <div id="stock-hint" style="display: none; margin-top: 6px; font-size: 12px; color: #555;">
                    Stok saat ini: <strong id="hint-current-stock">0</strong>
                </div>
            </div>

            <div class="form-group">
                <label class="form-label">Jenis <span class="required">*</span></label>
                <div style="display: flex; gap: 16px; margin-top: 4px;">
                    <label style="display: flex; align-items: center; gap: 6px; cursor: pointer; font-size: 13px;">
                        <input type="radio" name="type" value="in" {{ old('type', 'in') === 'in' ? 'checked' : '' }} required>
                        Barang Masuk
                    </label>
                    <label style="display: flex; align-items: center; gap: 6px; cursor: pointer; font-size: 13px;">
                        <input type="radio" name="type" value="out" {{ old('type') === 'out' ? 'checked' : '' }} required>
                        Barang Keluar
                    </label>
                </div>
                @error('type')
                <div class="form-error">{{ $message }}</div>
                @enderror
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px;">
                <div class="form-group">
                    <label class="form-label" for="tx-quantity">Jumlah <span class="required">*</span></label>
                    <input type="number" id="tx-quantity" name="quantity" class="form-control" min="1" placeholder="Jumlah unit" value="{{ old('quantity') }}" required>
                    @error('quantity')
                    <div class="form-error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label" for="tx-date">Tanggal <span class="required">*</span></label>
                    <input type="date" id="tx-date" name="transaction_date" class="form-control" value="{{ old('transaction_date', date('Y-m-d')) }}" required>
                    @error('transaction_date')
                    <div class="form-error">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="form-group">
                <label class="form-label" for="tx-note">Catatan</label>
                <input type="text" id="tx-note" name="note" class="form-control" placeholder="Opsional" value="{{ old('note') }}" maxlength="255">
                @error('note')
                <div class="form-error">{{ $message }}</div>
                @enderror
            </div>

            <div style="display: flex; gap: 8px; margin-top: 20px;">
                <button type="submit" class="btn btn-primary" id="btn-submit-transaction">Simpan</button>
                <a href="{{ route('transactions.index') }}" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
    function updateStockHint() {
        const select = document.getElementById('tx-product');
        const selected = select.options[select.selectedIndex];
        const hintBox = document.getElementById('stock-hint');
        const hintStock = document.getElementById('hint-current-stock');

        if (selected && selected.value) {
            hintStock.textContent = selected.getAttribute('data-stock');
            hintBox.style.display = 'block';
        } else {
            hintBox.style.display = 'none';
        }
    }

    document.addEventListener('DOMContentLoaded', () => {
        updateStockHint();
    });
</script>
@endsection
