@extends('layouts.app')

@section('title', 'Tambah Pengguna')
@section('page_title', 'Tambah Pengguna')

@section('content')
<div class="card" style="max-width: 620px;">
    <div class="card-header">
        <h3>Form Pengguna Baru</h3>
        <a href="{{ route('users.index') }}" class="btn btn-secondary btn-sm">← Kembali</a>
    </div>

    <div class="card-body">
        <form action="{{ route('users.store') }}" method="POST" id="form-create-user">
            @csrf

            <div class="form-group">
                <label class="form-label" for="user-name">Nama <span class="required">*</span></label>
                <input type="text" id="user-name" name="name" class="form-control" placeholder="Nama lengkap" value="{{ old('name') }}" required autofocus>
                @error('name')
                <div class="form-error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label class="form-label" for="user-email">Email <span class="required">*</span></label>
                <input type="email" id="user-email" name="email" class="form-control" placeholder="email@contoh.com" value="{{ old('email') }}" required>
                @error('email')
                <div class="form-error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label class="form-label" for="user-role">Role <span class="required">*</span></label>
                <select id="user-role" name="role" class="form-select" required>
                    <option value="staff" {{ old('role') === 'staff' ? 'selected' : '' }}>Staff</option>
                    <option value="admin" {{ old('role') === 'admin' ? 'selected' : '' }}>Admin</option>
                </select>
                @error('role')
                <div class="form-error">{{ $message }}</div>
                @enderror
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px;">
                <div class="form-group">
                    <label class="form-label" for="user-password">Password <span class="required">*</span></label>
                    <input type="password" id="user-password" name="password" class="form-control" placeholder="Min 6 karakter" required>
                    @error('password')
                    <div class="form-error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label" for="user-password-confirmation">Konfirmasi <span class="required">*</span></label>
                    <input type="password" id="user-password-confirmation" name="password_confirmation" class="form-control" placeholder="Ulangi password" required>
                </div>
            </div>

            <div style="display: flex; gap: 8px; margin-top: 20px;">
                <button type="submit" class="btn btn-primary" id="btn-save-user">Simpan</button>
                <a href="{{ route('users.index') }}" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection
