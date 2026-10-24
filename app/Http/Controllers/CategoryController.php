<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Models\Category;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CategoryController extends Controller
{
    /**
     * Display a listing of categories with search.
     */
    public function index(Request $request): View
    {
        $search = $request->input('search');

        $categories = Category::withCount('products')
            ->when($search, function ($query, $search) {
                $query->where('name', 'like', "%{$search}%")
                      ->orWhere('description', 'like', "%{$search}%");
            })
            ->orderBy('name')
            ->paginate(10)
            ->withQueryString();

        return view('categories.index', compact('categories', 'search'));
    }

    /**
     * Show the form for creating a new category.
     */
    public function create(): View
    {
        return view('categories.create');
    }

    /**
     * Store a newly created category in storage.
     */
    public function store(StoreCategoryRequest $request): RedirectResponse
    {
        Category::create($request->validated());

        return redirect()->route('categories.index')
            ->with('success', 'Kategori baru berhasil ditambahkan.');
    }

    /**
     * Display the specified category or view products in this category.
     */
    public function show(Category $category): RedirectResponse
    {
        return redirect()->route('products.index', ['category_id' => $category->id]);
    }

    /**
     * Show the form for editing the specified category.
     */
    public function edit(Category $category): View
    {
        return view('categories.edit', compact('category'));
    }

    /**
     * Update the specified category in storage.
     */
    public function update(UpdateCategoryRequest $request, Category $category): RedirectResponse
    {
        $category->update($request->validated());

        return redirect()->route('categories.index')
            ->with('success', 'Data kategori berhasil diperbarui.');
    }

    /**
     * Remove the specified category from storage (respecting ON DELETE RESTRICT).
     */
    public function destroy(Category $category): RedirectResponse
    {
        // Enforce ON DELETE RESTRICT safeguard
        if ($category->products()->count() > 0) {
            return redirect()->route('categories.index')->with(
                'error',
                "Gagal menghapus! Kategori '{$category->name}' masih memiliki {$category->products()->count()} produk terkait (Restriksi Relasi)."
            );
        }

        $category->delete();

        return redirect()->route('categories.index')
            ->with('success', 'Kategori berhasil dihapus.');
    }
}
