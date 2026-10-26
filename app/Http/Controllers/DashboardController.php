<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\StockTransaction;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * Display the inventory dashboard.
     */
    public function index(Request $request): View
    {
        $totalProducts = Product::count();
        $totalCategories = Category::count();
        $lowStockCount = Product::whereColumn('stock', '<=', 'min_stock')->count();

        // 5 latest transactions as specified in rubric
        $recentTransactions = StockTransaction::with(['product', 'user'])
            ->latest('id')
            ->take(5)
            ->get();

        // Products with critical/low stock for quick dashboard alert
        $lowStockProducts = Product::with('category')
            ->whereColumn('stock', '<=', 'min_stock')
            ->orderBy('stock', 'asc')
            ->take(6)
            ->get();

        // Total stock units in warehouse
        $totalStockUnits = (int) Product::sum('stock');

        return view('dashboard', compact(
            'totalProducts',
            'totalCategories',
            'lowStockCount',
            'recentTransactions',
            'lowStockProducts',
            'totalStockUnits'
        ));
    }
}
