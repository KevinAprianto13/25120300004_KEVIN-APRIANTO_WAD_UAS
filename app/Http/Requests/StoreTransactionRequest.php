<?php

namespace App\Http\Requests;

use App\Models\Product;
use Illuminate\Foundation\Http\FormRequest;

class StoreTransactionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user() !== null;
    }

    public function rules(): array
    {
        return [
            'product_id' => ['required', 'exists:products,id'],
            'type' => ['required', 'in:in,out'],
            'quantity' => ['required', 'integer', 'min:1'],
            'transaction_date' => ['required', 'date'],
            'note' => ['nullable', 'string', 'max:255'],
        ];
    }

    public function messages(): array
    {
        return [
            'product_id.required' => 'Produk wajib dipilih.',
            'product_id.exists' => 'Produk yang dipilih tidak ditemukan.',
            'type.required' => 'Jenis transaksi wajib dipilih.',
            'type.in' => 'Jenis transaksi hanya boleh barang masuk (in) atau keluar (out).',
            'quantity.required' => 'Jumlah barang wajib diisi.',
            'quantity.min' => 'Jumlah barang minimal 1 unit.',
            'transaction_date.required' => 'Tanggal transaksi wajib diisi.',
            'transaction_date.date' => 'Format tanggal tidak valid.',
            'note.max' => 'Catatan maksimal 255 karakter.',
        ];
    }

    /**
     * Configure the validator instance for custom stock sufficiency check.
     */
    public function withValidator($validator): void
    {
        $validator->after(function ($validator) {
            if ($this->type === 'out' && $this->product_id && $this->quantity) {
                $product = Product::find($this->product_id);
                if ($product && $this->quantity > $product->stock) {
                    $validator->errors()->add(
                        'quantity',
                        "Stok tidak mencukupi! Stok saat ini untuk '{$product->name}' adalah {$product->stock} unit, sedangkan permintaan keluar adalah {$this->quantity} unit."
                    );
                }
            }
        });
    }
}
