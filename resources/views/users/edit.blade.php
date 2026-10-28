@extends('layouts.app')

@section('title', 'Ubah Pengguna')
@section('page_title', 'Ubah Pengguna')

@section('content')
<div class="card" style="max-width: 620px;">
    <div class="card-header">
        <h3>Ubah: {{ $user->name }}</h3>
        <a href="{{ route('users.index') }}" class="btn btn-secondary btn-sm">← Kembali</a>
    </div>

    <div class="card-body">
        <form action="{{ route('users.update', $user) }}" method="POST" id="form-edit-user">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label class="form-label" for="user-name">Nama <span class="required">*</span></label>
                <input type="text" id="user-name" name="name" class="form-control" value="{{ old('name', $user->name) }}" required autofocus>
                @error('name')
                <div class="form-error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label class="form-label" for="user-email">Email <span class="required">*</span></label>
                <input type="email" id="user-email" name="email" class="form-control" value="{{ old('email', $user->email) }}" required>
                @error('email')
                <div class="form-error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label class="form-label" for="user-role">Role <span class="required">*</span></label>
                <select id="user-role" name="role" class="form-select" required>
                    <option value="staff" {{ old('role', $user->role) === 'staff' ? 'selected' : '' }}>Staff</option>
                    <option value="admin" {{ old('role', $user->role) === 'admin' ? 'selected' : '' }}>Admin</option>
                </select>
                @error('role')
                <div class="form-error">{{ $message }}</div>
                @enderror
            </div>

            <fieldset style="border: 1px solid #ddd; padding: 14px; border-radius: 3px; margin-bottom: 16px;">
                <legend style="font-size: 13px; font-weight: 600; color: #555; padding: 0 6px;">Ubah Password (opsional)</legend>
                <p style="font-size: 12px; color: #888; margin-bottom: 10px;">Kosongkan jika tidak ingin mengubah password.</p>
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px;">
                    <div>
                        <label class="form-label" for="user-password">Password Baru</label>
                        <input type="password" id="user-password" name="password" class="form-control" placeholder="Min 6 karakter">
                        @error('password')
                        <div class="form-error">{{ $message }}</div>
                        @enderror
                    </div>
                    <div>
                        <label class="form-label" for="user-password-confirmation">Konfirmasi</label>
                        <input type="password" id="user-password-confirmation" name="password_confirmation" class="form-control" placeholder="Ulangi password">
                    </div>
                </div>
            </fieldset>

            <div style="display: flex; gap: 8px; margin-top: 20px;">
                <button type="submit" class="btn btn-primary" id="btn-update-user">Simpan</button>
                <a href="{{ route('users.index') }}" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection
