<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProductController extends Controller
{
    /**
     * Display a listing of products with search and category filter.
     */
    public function index(Request $request): View
    {
        $search = $request->input('search');
        $categoryId = $request->input('category_id');
        $stockFilter = $request->input('stock_filter');

        $categories = Category::orderBy('name')->get();

        $products = Product::with('category')
            ->when($search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                      ->orWhere('sku', 'like', "%{$search}%");
                });
            })
            ->when($categoryId, function ($query, $categoryId) {
                $query->where('category_id', $categoryId);
            })
            ->when($stockFilter === 'low', function ($query) {
                $query->whereColumn('stock', '<=', 'min_stock');
            })
            ->when($stockFilter === 'out', function ($query) {
                $query->where('stock', 0);
            })
            ->latest('id')
            ->paginate(10)
            ->withQueryString();

        return view('products.index', compact('products', 'categories', 'search', 'categoryId', 'stockFilter'));
    }

    /**
     * Show the form for creating a new product (admin only).
     */
    public function create(): View
    {
        $this->ensureAdmin();
        $categories = Category::orderBy('name')->get();

        return view('products.create', compact('categories'));
    }

    /**
     * Store a newly created product in storage (admin only).
     */
    public function store(StoreProductRequest $request): RedirectResponse
    {
        $this->ensureAdmin();
        Product::create($request->validated());

        return redirect()->route('products.index')
            ->with('success', 'Produk baru berhasil ditambahkan.');
    }

    /**
     * Display the specified product details and recent stock history.
     */
    public function show(Product $product): View
    {
        $product->load(['category', 'stockTransactions.user']);
        $recentTransactions = $product->stockTransactions()
            ->with('user')
            ->latest('id')
            ->take(10)
            ->get();

        return view('products.show', compact('product', 'recentTransactions'));
    }

    /**
     * Show the form for editing the specified product (admin only).
     */
    public function edit(Product $product): View
    {
        $this->ensureAdmin();
        $categories = Category::orderBy('name')->get();

        return view('products.edit', compact('product', 'categories'));
    }

    /**
     * Update the specified product in storage (admin only).
     */
    public function update(UpdateProductRequest $request, Product $product): RedirectResponse
    {
        $this->ensureAdmin();
        $product->update($request->validated());

        return redirect()->route('products.index')
            ->with('success', 'Data produk berhasil diperbarui.');
    }

    /**
     * Remove the specified product from storage (admin only, ON DELETE RESTRICT).
     */
    public function destroy(Product $product): RedirectResponse
    {
        $this->ensureAdmin();

        // Enforce ON DELETE RESTRICT check
        if ($product->stockTransactions()->count() > 0) {
            return redirect()->route('products.index')->with(
                'error',
                "Gagal menghapus! Produk '{$product->name}' memiliki {$product->stockTransactions()->count()} riwayat transaksi stok yang tidak boleh dihapus (Restriksi Relasi)."
            );
        }

        $product->delete();

        return redirect()->route('products.index')
            ->with('success', 'Produk berhasil dihapus.');
    }

    /**
     * Internal helper to verify admin role for modification actions.
     */
    private function ensureAdmin(): void
    {
        if (! auth()->user() || ! auth()->user()->isAdmin()) {
            abort(403, 'Akses Ditolak: Hanya Admin yang dapat memodifikasi data produk.');
        }
    }
}
