<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class UserController extends Controller
{
    /**
     * Display a listing of users (Admin only).
     */
    public function index(Request $request): View
    {
        $search = $request->input('search');
        $roleFilter = $request->input('role');

        $users = User::withCount('stockTransactions')
            ->when($search, function ($query, $search) {
                $query->where('name', 'like', "%{$search}%")
                      ->orWhere('email', 'like', "%{$search}%");
            })
            ->when($roleFilter, function ($query, $roleFilter) {
                $query->where('role', $roleFilter);
            })
            ->orderBy('id', 'desc')
            ->paginate(10)
            ->withQueryString();

        return view('users.index', compact('users', 'search', 'roleFilter'));
    }

    /**
     * Show the form for creating a new user.
     */
    public function create(): View
    {
        return view('users.create');
    }

    /**
     * Store a newly created user in storage.
     */
    public function store(StoreUserRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => $validated['role'],
        ]);

        return redirect()->route('users.index')
            ->with('success', "Pengguna {$validated['name']} berhasil ditambahkan.");
    }

    /**
     * Display the specified user profile (redirects to edit).
     */
    public function show(User $user): RedirectResponse
    {
        return redirect()->route('users.edit', $user);
    }

    /**
     * Show the form for editing the specified user.
     */
    public function edit(User $user): View
    {
        return view('users.edit', compact('user'));
    }

    /**
     * Update the specified user in storage.
     */
    public function update(UpdateUserRequest $request, User $user): RedirectResponse
    {
        $validated = $request->validated();

        $data = [
            'name' => $validated['name'],
            'email' => $validated['email'],
            'role' => $validated['role'],
        ];

        // Only update password if provided
        if (! empty($validated['password'])) {
            $data['password'] = Hash::make($validated['password']);
        }

        // Prevent self demotion from admin if current user is the only admin
        if ($user->id === Auth::id() && $validated['role'] !== 'admin') {
            return back()->withInput()->with('error', 'Anda tidak dapat mencabut hak akses Admin dari akun Anda sendiri.');
        }

        $user->update($data);

        return redirect()->route('users.index')
            ->with('success', "Data pengguna {$user->name} berhasil diperbarui.");
    }

    /**
     * Remove the specified user from storage (ON DELETE RESTRICT safeguard).
     */
    public function destroy(User $user): RedirectResponse
    {
        // Prevent deleting oneself
        if ($user->id === Auth::id()) {
            return redirect()->route('users.index')
                ->with('error', 'Anda tidak dapat menghapus akun Anda sendiri saat sedang login.');
        }

        // Enforce ON DELETE RESTRICT
        if ($user->stockTransactions()->count() > 0) {
            return redirect()->route('users.index')->with(
                'error',
                "Gagal menghapus! Pengguna '{$user->name}' memiliki {$user->stockTransactions()->count()} riwayat transaksi yang tercatat di gudang (Restriksi Relasi)."
            );
        }

        $user->delete();

        return redirect()->route('users.index')
            ->with('success', 'Pengguna berhasil dihapus.');
    }
}
