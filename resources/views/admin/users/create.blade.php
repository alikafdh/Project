@extends('layouts.admin')

@section('content')
<div class="max-w-2xl mx-auto space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-xl font-bold text-slate-800">Tambah Akun Petugas Pengelola</h1>
            <p class="text-sm text-slate-500">Mendaftarkan akun baru untuk staf Puskesmas</p>
        </div>
        <a href="{{ route('admin.users.index') }}" class="text-xs font-semibold text-slate-500 hover:text-slate-800">← Kembali</a>
    </div>

    <div class="bg-white p-6 sm:p-8 rounded-2xl border border-slate-200 shadow-sm">
        <form action="{{ route('admin.users.store') }}" method="POST" class="space-y-6">
            @csrf

            <div>
                <label for="nama_lengkap" class="block text-sm font-semibold text-slate-700">Nama Lengkap & Gelar <span class="text-rose-500">*</span></label>
                <input type="text" name="nama_lengkap" id="nama_lengkap" value="{{ old('nama_lengkap') }}" placeholder="Contoh: dr. H. Hendra Wijaya" required class="mt-1.5 block w-full rounded-xl border-slate-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 text-sm">
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <div>
                    <label for="username" class="block text-sm font-semibold text-slate-700">Username Login <span class="text-rose-500">*</span></label>
                    <input type="text" name="username" id="username" value="{{ old('username') }}" placeholder="hendrawijaya" required class="mt-1.5 block w-full rounded-xl border-slate-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 text-sm">
                </div>

                <div>
                    <label for="email" class="block text-sm font-semibold text-slate-700">Alamat Email <span class="text-rose-500">*</span></label>
                    <input type="email" name="email" id="email" value="{{ old('email') }}" placeholder="hendra@puskesmascilimus.id" required class="mt-1.5 block w-full rounded-xl border-slate-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 text-sm">
                </div>
            </div>

            <div>
                <label for="password" class="block text-sm font-semibold text-slate-700">Kata Sandi (Password) <span class="text-rose-500">*</span></label>
                <input type="password" name="password" id="password" required placeholder="Minimal 8 karakter" class="mt-1.5 block w-full rounded-xl border-slate-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 text-sm">
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <div>
                    <label for="peran" class="block text-sm font-semibold text-slate-700">Peran Hak Akses <span class="text-rose-500">*</span></label>
                    <select name="peran" id="peran" required class="mt-1.5 block w-full rounded-xl border-slate-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 text-sm">
                        <option value="admin" {{ old('peran') === 'admin' ? 'selected' : '' }}>Admin Petugas (Pengelola Konten)</option>
                        <option value="superadmin" {{ old('peran') === 'superadmin' ? 'selected' : '' }}>Superadmin (Hak Penuh)</option>
                    </select>
                </div>

                <div>
                    <label for="status" class="block text-sm font-semibold text-slate-700">Status Keaktifan <span class="text-rose-500">*</span></label>
                    <select name="status" id="status" required class="mt-1.5 block w-full rounded-xl border-slate-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 text-sm">
                        <option value="aktif" {{ old('status') === 'aktif' ? 'selected' : '' }}>Aktif</option>
                        <option value="nonaktif" {{ old('status') === 'nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                    </select>
                </div>
            </div>

            <div class="flex items-center justify-end space-x-3 pt-4 border-t border-slate-100">
                <a href="{{ route('admin.users.index') }}" class="px-4 py-2.5 rounded-xl border border-slate-200 text-slate-700 font-medium text-sm hover:bg-slate-50">Batal</a>
                <button type="submit" class="px-5 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-semibold text-sm shadow-sm shadow-emerald-700/30">Daftarkan Petugas</button>
            </div>
        </form>
    </div>
</div>
@endsection
