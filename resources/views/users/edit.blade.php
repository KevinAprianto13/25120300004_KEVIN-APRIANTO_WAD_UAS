@extends('layouts.app')

@section('title', 'Ubah Pengguna')
@section('page_title', 'Ubah Data Pengguna')

@section('content')
<div class="card" style="max-width: 680px;">
    <div class="card-header">
        <div>
            <h3 class="card-title">Form Ubah Pengguna</h3>
            <span class="card-subtitle">Perbarui data profil dan hak akses '{{ $user->name }}'</span>
        </div>
        <a href="{{ route('users.index') }}" class="btn btn-secondary btn-sm">
            ← Kembali ke Daftar
        </a>
    </div>

    <div class="card-body">
        <form action="{{ route('users.update', $user) }}" method="POST" id="form-edit-user">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label class="form-label" for="user-name">
                    Nama Lengkap <span class="required">*</span>
                </label>
                <input type="text" id="user-name" name="name" class="form-control" value="{{ old('name', $user->name) }}" required autofocus>
                @error('name')
                <div class="form-error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label class="form-label" for="user-email">
                    Alamat Email <span class="required">*</span>
                </label>
                <input type="email" id="user-email" name="email" class="form-control" value="{{ old('email', $user->email) }}" required>
                @error('email')
                <div class="form-error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label class="form-label" for="user-role">
                    Role / Hak Akses <span class="required">*</span>
                </label>
                <select id="user-role" name="role" class="form-select" required>
                    <option value="staff" {{ old('role', $user->role) === 'staff' ? 'selected' : '' }}>Staff Gudang (Pencatatan & Riwayat Milik Sendiri)</option>
                    <option value="admin" {{ old('role', $user->role) === 'admin' ? 'selected' : '' }}>Administrator (Akses Penuh Seluruh Fitur & Master Data)</option>
                </select>
                @error('role')
                <div class="form-error">{{ $message }}</div>
                @enderror
            </div>

            <div style="background: #f8fafc; padding: 18px; border-radius: 10px; border: 1px dashed #cbd5e1; margin-bottom: 20px;">
                <div style="font-weight: 700; font-size: 0.88rem; color: #334155; margin-bottom: 6px;">
                    Ubah Password (Opsional)
                </div>
                <p style="font-size: 0.78rem; color: #64748b; margin-bottom: 14px;">
                    Kosongkan kedua kolom di bawah jika tidak ingin mengganti password pengguna ini.
                </p>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                    <div>
                        <label class="form-label" for="user-password">Password Baru</label>
                        <input type="password" id="user-password" name="password" class="form-control" placeholder="Minimal 6 karakter">
                        @error('password')
                        <div class="form-error">{{ $message }}</div>
                        @enderror
                    </div>

                    <div>
                        <label class="form-label" for="user-password-confirmation">Konfirmasi Password</label>
                        <input type="password" id="user-password-confirmation" name="password_confirmation" class="form-control" placeholder="Ulangi password baru">
                    </div>
                </div>
            </div>

            <div style="display: flex; gap: 12px; margin-top: 24px;">
                <button type="submit" class="btn btn-primary" id="btn-update-user">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/></svg>
                    Simpan Perubahan
                </button>
                <a href="{{ route('users.index') }}" class="btn btn-secondary">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
