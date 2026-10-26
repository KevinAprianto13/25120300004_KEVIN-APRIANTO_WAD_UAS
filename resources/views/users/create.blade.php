@extends('layouts.app')

@section('title', 'Tambah Pengguna')
@section('page_title', 'Tambah Pengguna Baru')

@section('content')
<div class="card" style="max-width: 680px;">
    <div class="card-header">
        <div>
            <h3 class="card-title">Form Pendaftaran Pengguna</h3>
            <span class="card-subtitle">Buat akun akses baru untuk Admin atau Staff Gudang</span>
        </div>
        <a href="{{ route('users.index') }}" class="btn btn-secondary btn-sm">
            ← Kembali ke Daftar
        </a>
    </div>

    <div class="card-body">
        <form action="{{ route('users.store') }}" method="POST" id="form-create-user">
            @csrf

            <div class="form-group">
                <label class="form-label" for="user-name">
                    Nama Lengkap <span class="required">*</span>
                </label>
                <input type="text" id="user-name" name="name" class="form-control" placeholder="Contoh: Rahmat Hidayat" value="{{ old('name') }}" required autofocus>
                @error('name')
                <div class="form-error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label class="form-label" for="user-email">
                    Alamat Email <span class="required">*</span>
                </label>
                <input type="email" id="user-email" name="email" class="form-control" placeholder="nama@gudangku.test" value="{{ old('email') }}" required>
                @error('email')
                <div class="form-error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label class="form-label" for="user-role">
                    Role / Hak Akses <span class="required">*</span>
                </label>
                <select id="user-role" name="role" class="form-select" required>
                    <option value="staff" {{ old('role') === 'staff' ? 'selected' : '' }}>Staff Gudang (Pencatatan & Riwayat Milik Sendiri)</option>
                    <option value="admin" {{ old('role') === 'admin' ? 'selected' : '' }}>Administrator (Akses Penuh Seluruh Fitur & Master Data)</option>
                </select>
                @error('role')
                <div class="form-error">{{ $message }}</div>
                @enderror
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                <div class="form-group">
                    <label class="form-label" for="user-password">
                        Password <span class="required">*</span>
                    </label>
                    <input type="password" id="user-password" name="password" class="form-control" placeholder="Minimal 6 karakter" required>
                    @error('password')
                    <div class="form-error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label" for="user-password-confirmation">
                        Konfirmasi Password <span class="required">*</span>
                    </label>
                    <input type="password" id="user-password-confirmation" name="password_confirmation" class="form-control" placeholder="Ulangi password" required>
                </div>
            </div>

            <div style="display: flex; gap: 12px; margin-top: 24px;">
                <button type="submit" class="btn btn-primary" id="btn-save-user">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/></svg>
                    Simpan Pengguna
                </button>
                <a href="{{ route('users.index') }}" class="btn btn-secondary">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
