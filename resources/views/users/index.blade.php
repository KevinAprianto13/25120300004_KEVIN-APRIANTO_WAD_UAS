@extends('layouts.app')

@section('title', 'Kelola Pengguna')
@section('page_title', 'Kelola Pengguna')

@section('content')
<div class="card">
    <div class="card-header">
        <h3>Pengguna</h3>
        <a href="{{ route('users.create') }}" class="btn btn-primary btn-sm" id="btn-add-user">+ Tambah</a>
    </div>

    <div class="card-body">
        <form action="{{ route('users.index') }}" method="GET" style="margin-bottom: 16px; display: flex; flex-wrap: wrap; gap: 8px; align-items: center;">
            <div style="flex: 1; min-width: 200px;">
                <input type="text" name="search" class="form-control" placeholder="Cari nama / email..." value="{{ $search ?? '' }}">
            </div>
            <div style="min-width: 140px;">
                <select name="role" class="form-select">
                    <option value="">Semua Role</option>
                    <option value="admin" {{ ($roleFilter ?? '') === 'admin' ? 'selected' : '' }}>Admin</option>
                    <option value="staff" {{ ($roleFilter ?? '') === 'staff' ? 'selected' : '' }}>Staff</option>
                </select>
            </div>
            <button type="submit" class="btn btn-secondary">Filter</button>
            @if(!empty($search) || !empty($roleFilter))
            <a href="{{ route('users.index') }}" class="btn btn-secondary">Reset</a>
            @endif
        </form>

        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th style="width: 50px;">#</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th style="text-align: center;">Role</th>
                        <th style="text-align: center;">Transaksi</th>
                        <th>Terdaftar</th>
                        <th style="text-align: right;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $u)
                    <tr>
                        <td>{{ $loop->iteration + ($users->currentPage() - 1) * $users->perPage() }}</td>
                        <td>
                            <strong>{{ $u->name }}</strong>
                            @if(Auth::id() === $u->id)
                            <span style="font-size: 11px; color: #888;">(Anda)</span>
                            @endif
                        </td>
                        <td>{{ $u->email }}</td>
                        <td style="text-align: center;">
                            @if($u->role === 'admin')
                            <span class="badge badge-danger">ADMIN</span>
                            @else
                            <span class="badge badge-success">STAFF</span>
                            @endif
                        </td>
                        <td style="text-align: center;">{{ $u->stock_transactions_count }}</td>
                        <td style="color: #888; font-size: 12px;">{{ $u->created_at->format('d M Y') }}</td>
                        <td style="text-align: right;">
                            <div style="display: inline-flex; gap: 4px;">
                                <a href="{{ route('users.edit', $u) }}" class="btn btn-secondary btn-sm">Ubah</a>
                                @if(Auth::id() !== $u->id)
                                <form action="{{ route('users.destroy', $u) }}" method="POST" onsubmit="return confirm('Hapus akun \'{{ $u->name }}\'?')" style="margin: 0;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                                </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" style="text-align: center; padding: 30px; color: #999;">
                            Tidak ada pengguna.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div style="margin-top: 16px;">
            {{ $users->links() }}
        </div>
    </div>
</div>
@endsection
