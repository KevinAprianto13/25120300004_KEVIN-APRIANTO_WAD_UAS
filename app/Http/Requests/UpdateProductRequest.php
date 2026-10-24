<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user() && $this->user()->isAdmin();
    }

    public function rules(): array
    {
        $productId = $this->route('product') instanceof \App\Models\Product 
            ? $this->route('product')->id 
            : $this->route('product');

        return [
            'category_id' => ['required', 'exists:categories,id'],
            'sku' => [
                'required',
                'string',
                'max:50',
                Rule::unique('products', 'sku')->ignore($productId),
            ],
            'name' => ['required', 'string', 'max:150'],
            'stock' => ['required', 'integer', 'min:0'],
            'min_stock' => ['required', 'integer', 'min:0'],
            'price' => ['required', 'numeric', 'min:0'],
        ];
    }

    public function messages(): array
    {
        return [
            'category_id.required' => 'Kategori produk wajib dipilih.',
            'category_id.exists' => 'Kategori yang dipilih tidak valid.',
            'sku.required' => 'Kode SKU wajib diisi.',
            'sku.unique' => 'Kode SKU sudah digunakan produk lain.',
            'name.required' => 'Nama produk wajib diisi.',
            'stock.required' => 'Jumlah stok awal wajib diisi.',
            'stock.min' => 'Stok tidak boleh bernilai negatif.',
            'min_stock.required' => 'Batas stok minimum wajib diisi.',
            'min_stock.min' => 'Batas stok minimum tidak boleh negatif.',
            'price.required' => 'Harga produk wajib diisi.',
            'price.min' => 'Harga tidak boleh bernilai negatif.',
        ];
    }
}
