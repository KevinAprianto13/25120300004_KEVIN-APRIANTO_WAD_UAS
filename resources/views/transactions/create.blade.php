@extends('layouts.app')

@section('title', 'Catat Transaksi Stok')
@section('page_title', 'Catat Barang Masuk / Keluar')

@section('content')
<div class="card" style="max-width: 720px;">
    <div class="card-header">
        <div>
            <h3 class="card-title">Form Mutasi Stok Gudang</h3>
            <span class="card-subtitle">Pencatatan resmi barang masuk atau barang keluar (otomatis mengubah stok)</span>
        </div>
        <a href="{{ route('transactions.index') }}" class="btn btn-secondary btn-sm">
            ← Lihat Riwayat
        </a>
    </div>

    <div class="card-body">
        <form action="{{ route('transactions.store') }}" method="POST" id="form-create-transaction">
            @csrf

            <!-- Product Selection -->
            <div class="form-group">
                <label class="form-label" for="tx-product">
                    Pilih Produk <span class="required">*</span>
                </label>
                <select id="tx-product" name="product_id" class="form-select" required autofocus onchange="updateStockHint()">
                    <option value="">-- Pilih Barang Dari Inventaris --</option>
                    @foreach($products as $p)
                    <option value="{{ $p->id }}" data-stock="{{ $p->stock }}" data-sku="{{ $p->sku }}" {{ old('product_id') == $p->id ? 'selected' : '' }}>
                        [{{ $p->sku }}] {{ $p->name }} (Sisa Stok: {{ $p->stock }} unit)
                    </option>
                    @endforeach
                </select>
                @error('product_id')
                <div class="form-error">{{ $message }}</div>
                @enderror
                <!-- Live stock indicator hint -->
                <div id="stock-hint" style="display: none; margin-top: 8px; font-size: 0.85rem; padding: 8px 12px; border-radius: 8px; background: #f8fafc; border: 1px solid #e2e8f0;">
                    Stok saat ini: <strong id="hint-current-stock" style="color: #2563eb;">0</strong> unit
                </div>
            </div>

            <!-- Transaction Type Selection -->
            <div class="form-group">
                <label class="form-label">
                    Jenis Transaksi Mutasi <span class="required">*</span>
                </label>
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 14px;">
                    <label style="display: flex; align-items: center; gap: 10px; padding: 14px; border: 2px solid #e2e8f0; border-radius: 10px; cursor: pointer; transition: all 0.2s;" id="label-type-in">
                        <input type="radio" name="type" value="in" {{ old('type', 'in') === 'in' ? 'checked' : '' }} onchange="checkTypeStyle()" required>
                        <div>
                            <strong style="color: #059669; font-size: 0.95rem;">📥 Barang Masuk (IN)</strong>
                            <div style="font-size: 0.75rem; color: #64748b;">Menambah jumlah stok fisik di gudang</div>
                        </div>
                    </label>

                    <label style="display: flex; align-items: center; gap: 10px; padding: 14px; border: 2px solid #e2e8f0; border-radius: 10px; cursor: pointer; transition: all 0.2s;" id="label-type-out">
                        <input type="radio" name="type" value="out" {{ old('type') === 'out' ? 'checked' : '' }} onchange="checkTypeStyle()" required>
                        <div>
                            <strong style="color: #dc2626; font-size: 0.95rem;">📤 Barang Keluar (OUT)</strong>
                            <div style="font-size: 0.75rem; color: #64748b;">Mengurangi stok (ditolak jika stok kurang)</div>
                        </div>
                    </label>
                </div>
                @error('type')
                <div class="form-error">{{ $message }}</div>
                @enderror
            </div>

            <!-- Quantity & Date Grid -->
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                <div class="form-group">
                    <label class="form-label" for="tx-quantity">
                        Jumlah Unit <span class="required">*</span>
                    </label>
                    <input type="number" id="tx-quantity" name="quantity" class="form-control" min="1" placeholder="Minimal 1 unit" value="{{ old('quantity') }}" required>
                    @error('quantity')
                    <div class="form-error" id="error-quantity-msg">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                        {{ $message }}
                    </div>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label" for="tx-date">
                        Tanggal Transaksi <span class="required">*</span>
                    </label>
                    <input type="date" id="tx-date" name="transaction_date" class="form-control" value="{{ old('transaction_date', date('Y-m-d')) }}" required>
                    @error('transaction_date')
                    <div class="form-error">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <!-- Note / Memo -->
            <div class="form-group">
                <label class="form-label" for="tx-note">
                    Catatan / Keperluan (Opsional)
                </label>
                <input type="text" id="tx-note" name="note" class="form-control" placeholder="Contoh: Penerimaan supplier PT Maju / Pengambilan divisi TI" value="{{ old('note') }}" maxlength="255">
                @error('note')
                <div class="form-error">{{ $message }}</div>
                @enderror
            </div>

            <div style="display: flex; gap: 12px; margin-top: 24px;">
                <button type="submit" class="btn btn-primary" id="btn-submit-transaction">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/></svg>
                    Simpan & Update Stok
                </button>
                <a href="{{ route('transactions.index') }}" class="btn btn-secondary">
                    Batal
                </a>
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
            const stock = selected.getAttribute('data-stock');
            hintStock.textContent = stock;
            hintBox.style.display = 'block';
        } else {
            hintBox.style.display = 'none';
        }
    }

    function checkTypeStyle() {
        const inRadio = document.querySelector('input[name="type"][value="in"]');
        const labelIn = document.getElementById('label-type-in');
        const labelOut = document.getElementById('label-type-out');

        if (inRadio.checked) {
            labelIn.style.borderColor = '#10b981';
            labelIn.style.background = '#ecfdf5';
            labelOut.style.borderColor = '#e2e8f0';
            labelOut.style.background = '#ffffff';
        } else {
            labelOut.style.borderColor = '#ef4444';
            labelOut.style.background = '#fef2f2';
            labelIn.style.borderColor = '#e2e8f0';
            labelIn.style.background = '#ffffff';
        }
    }

    // Initialize state on load
    document.addEventListener('DOMContentLoaded', () => {
        updateStockHint();
        checkTypeStyle();
    });
</script>
@endsection
