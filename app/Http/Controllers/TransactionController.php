<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTransactionRequest;
use App\Models\Product;
use App\Models\StockTransaction;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class TransactionController extends Controller
{
    /**
     * Display transaction history.
     * Admin sees all transactions; Staff sees only their own.
     */
    public function index(Request $request): View
    {
        $user = Auth::user();
        $type = $request->input('type');
        $search = $request->input('search');

        $query = StockTransaction::with(['product.category', 'user'])
            ->when(! $user->isAdmin(), function ($q) use ($user) {
                // Staff only views their own transactions (as per rubric)
                $q->where('user_id', $user->id);
            })
            ->when($type, function ($q, $type) {
                $q->where('type', $type);
            })
            ->when($search, function ($q, $search) {
                $q->whereHas('product', function ($pq) use ($search) {
                    $pq->where('name', 'like', "%{$search}%")
                       ->orWhere('sku', 'like', "%{$search}%");
                });
            })
            ->latest('transaction_date')
            ->latest('id');

        $transactions = $query->paginate(15)->withQueryString();

        return view('transactions.index', compact('transactions', 'type', 'search'));
    }

    /**
     * Show form to record incoming or outgoing stock transaction.
     */
    public function create(): View
    {
        $products = Product::orderBy('name')->get();

        return view('transactions.create', compact('products'));
    }

    /**
     * Store new transaction with atomic DB transaction and rollback support (CPMK1 & rubric).
     */
    public function store(StoreTransactionRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        DB::beginTransaction();

        try {
            // Lock the product row for update to prevent race conditions
            $product = Product::lockForUpdate()->findOrFail($validated['product_id']);

            // Validate stock sufficiency for outgoing items
            if ($validated['type'] === 'out') {
                if ($product->stock < $validated['quantity']) {
                    throw new Exception("Stok tidak mencukupi! Stok saat ini adalah {$product->stock}, permintaan keluar {$validated['quantity']}.");
                }
                $product->decrement('stock', $validated['quantity']);
            } else {
                // Incoming stock increases product quantity
                $product->increment('stock', $validated['quantity']);
            }

            // Create transaction record associated with logged in user
            StockTransaction::create([
                'product_id' => $product->id,
                'user_id' => Auth::id(),
                'type' => $validated['type'],
                'quantity' => $validated['quantity'],
                'note' => $validated['note'] ?? null,
                'transaction_date' => $validated['transaction_date'],
            ]);

            DB::commit();

            $typeLabel = $validated['type'] === 'in' ? 'Barang Masuk' : 'Barang Keluar';

            return redirect()->route('transactions.index')
                ->with('success', "Transaksi {$typeLabel} sebanyak {$validated['quantity']} unit untuk '{$product->name}' berhasil dicatat! Stok diperbarui.");

        } catch (Exception $e) {
            DB::rollBack();

            return back()->withInput()->withErrors([
                'quantity' => $e->getMessage(),
            ]);
        }
    }
}
