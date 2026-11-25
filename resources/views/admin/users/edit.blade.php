@extends('layouts.admin')

@section('content')
<div class="max-w-2xl mx-auto space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-xl font-bold text-slate-800">Ubah Data Akun Petugas</h1>
            <p class="text-sm text-slate-500">Perbarui identitas, peran hak akses, atau reset kata sandi</p>
        </div>
        <a href="{{ route('admin.users.index') }}" class="text-xs font-semibold text-slate-500 hover:text-slate-800">← Kembali</a>
    </div>

    <div class="bg-white p-6 sm:p-8 rounded-2xl border border-slate-200 shadow-sm">
        <form action="{{ route('admin.users.update', $user) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <div>
                <label for="nama_lengkap" class="block text-sm font-semibold text-slate-700">Nama Lengkap & Gelar <span class="text-rose-500">*</span></label>
                <input type="text" name="nama_lengkap" id="nama_lengkap" value="{{ old('nama_lengkap', $user->nama_lengkap) }}" required class="mt-1.5 block w-full rounded-xl border-slate-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 text-sm">
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <div>
                    <label for="username" class="block text-sm font-semibold text-slate-700">Username Login <span class="text-rose-500">*</span></label>
                    <input type="text" name="username" id="username" value="{{ old('username', $user->username) }}" required class="mt-1.5 block w-full rounded-xl border-slate-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 text-sm">
                </div>

                <div>
                    <label for="email" class="block text-sm font-semibold text-slate-700">Alamat Email <span class="text-rose-500">*</span></label>
                    <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}" required class="mt-1.5 block w-full rounded-xl border-slate-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 text-sm">
                </div>
            </div>

            <div>
                <label for="password" class="block text-sm font-semibold text-slate-700">Ubah Kata Sandi (Kosongkan bila tidak diubah)</label>
                <input type="password" name="password" id="password" placeholder="Masukkan sandi baru jika ingin reset" class="mt-1.5 block w-full rounded-xl border-slate-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 text-sm">
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <div>
                    <label for="peran" class="block text-sm font-semibold text-slate-700">Peran Hak Akses <span class="text-rose-500">*</span></label>
                    <select name="peran" id="peran" required class="mt-1.5 block w-full rounded-xl border-slate-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 text-sm">
                        <option value="admin" {{ old('peran', $user->peran) === 'admin' ? 'selected' : '' }}>Admin Petugas</option>
                        <option value="superadmin" {{ old('peran', $user->peran) === 'superadmin' ? 'selected' : '' }}>Superadmin</option>
                    </select>
                </div>

                <div>
                    <label for="status" class="block text-sm font-semibold text-slate-700">Status Keaktifan <span class="text-rose-500">*</span></label>
                    <select name="status" id="status" required class="mt-1.5 block w-full rounded-xl border-slate-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 text-sm">
                        <option value="aktif" {{ old('status', $user->status) === 'aktif' ? 'selected' : '' }}>Aktif</option>
                        <option value="nonaktif" {{ old('status', $user->status) === 'nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                    </select>
                </div>
            </div>

            <div class="flex items-center justify-end space-x-3 pt-4 border-t border-slate-100">
                <a href="{{ route('admin.users.index') }}" class="px-4 py-2.5 rounded-xl border border-slate-200 text-slate-700 font-medium text-sm hover:bg-slate-50">Batal</a>
                <button type="submit" class="px-5 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-semibold text-sm shadow-sm shadow-emerald-700/30">Perbarui Akun</button>
            </div>
        </form>
    </div>
</div>
@endsection
