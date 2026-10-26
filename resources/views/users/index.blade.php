@extends('layouts.app')

@section('title', 'Manajemen Pengguna')
@section('page_title', 'Kelola Pengguna & Hak Akses')

@section('content')
<div class="card">
    <div class="card-header">
        <div>
            <h3 class="card-title">Manajemen Akun Pengguna</h3>
            <span class="card-subtitle">Pengaturan hak akses Administrator dan Staff Operasional</span>
        </div>
        <a href="{{ route('users.create') }}" class="btn btn-primary" id="btn-add-user">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><line x1="19" y1="8" x2="19" y2="14"/><line x1="22" y1="11" x2="16" y2="11"/></svg>
            Tambah Pengguna Baru
        </a>
    </div>

    <div class="card-body">
        <!-- Search and Filter Bar -->
        <form action="{{ route('users.index') }}" method="GET" style="margin-bottom: 24px; display: flex; flex-wrap: wrap; gap: 12px; align-items: center;">
            <div style="flex: 1; min-width: 240px;">
                <input type="text" name="search" class="form-control" placeholder="Cari nama atau email pengguna..." value="{{ $search ?? '' }}">
            </div>

            <div style="min-width: 170px;">
                <select name="role" class="form-select">
                    <option value="">Semua Role</option>
                    <option value="admin" {{ ($roleFilter ?? '') === 'admin' ? 'selected' : '' }}>Admin</option>
                    <option value="staff" {{ ($roleFilter ?? '') === 'staff' ? 'selected' : '' }}>Staff</option>
                </select>
            </div>

            <button type="submit" class="btn btn-secondary">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/></svg>
                Filter
            </button>

            @if(!empty($search) || !empty($roleFilter))
            <a href="{{ route('users.index') }}" class="btn btn-secondary" title="Reset Filter">Reset</a>
            @endif
        </form>

        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th style="width: 60px;">#</th>
                        <th>Nama Pengguna</th>
                        <th>Alamat Email</th>
                        <th style="text-align: center;">Role / Akses</th>
                        <th style="text-align: center;">Transaksi Dicatat</th>
                        <th>Terdaftar Sejak</th>
                        <th style="text-align: right;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $u)
                    <tr>
                        <td>{{ $loop->iteration + ($users->currentPage() - 1) * $users->perPage() }}</td>
                        <td>
                            <strong style="color: #0f172a; font-size: 0.95rem;">{{ $u->name }}</strong>
                            @if(Auth::id() === $u->id)
                            <span class="badge badge-primary" style="margin-left: 6px; font-size: 0.68rem;">(Akun Anda)</span>
                            @endif
                        </td>
                        <td>
                            <span style="color: #475569;">{{ $u->email }}</span>
                        </td>
                        <td style="text-align: center;">
                            @if($u->role === 'admin')
                            <span class="badge badge-danger">ADMIN</span>
                            @else
                            <span class="badge badge-success">STAFF</span>
                            @endif
                        </td>
                        <td style="text-align: center;">
                            <span class="badge badge-primary">{{ $u->stock_transactions_count }} Transaksi</span>
                        </td>
                        <td style="color: #64748b; font-size: 0.82rem;">
                            {{ $u->created_at->format('d M Y') }}
                        </td>
                        <td style="text-align: right;">
                            <div style="display: inline-flex; gap: 6px;">
                                <a href="{{ route('users.edit', $u) }}" class="btn btn-secondary btn-sm" title="Ubah User">
                                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 3a2.85 2.83 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5Z"/></svg>
                                    Ubah
                                </a>

                                @if(Auth::id() !== $u->id)
                                <form action="{{ route('users.destroy', $u) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus akun \'{{ $u->name }}\'? Jika akun ini memiliki catatan transaksi, penghapusan akan ditolak demi integritas data.')" style="margin: 0;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" title="Hapus User">
                                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 6h18M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"/></svg>
                                        Hapus
                                    </button>
                                </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" style="text-align: center; padding: 40px; color: #94a3b8;">
                            Tidak ada data pengguna yang ditemukan.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div style="margin-top: 20px;">
            {{ $users->links() }}
        </div>
    </div>
</div>
@endsection
