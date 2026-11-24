@extends('layouts.admin')

@section('content')
<div class="max-w-2xl mx-auto space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-xl font-bold text-slate-800">Ubah Data Klaster ILP</h1>
            <p class="text-sm text-slate-500">Perbarui informasi rincian klaster</p>
        </div>
        <a href="{{ route('admin.klaster.index') }}" class="text-xs font-semibold text-slate-500 hover:text-slate-800">← Kembali</a>
    </div>

    <div class="bg-white p-6 sm:p-8 rounded-2xl border border-slate-200 shadow-sm">
        <form action="{{ route('admin.klaster.update', $klaster) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <div>
                <label for="nama" class="block text-sm font-semibold text-slate-700">Nama Klaster <span class="text-rose-500">*</span></label>
                <input type="text" name="nama" id="nama" value="{{ old('nama', $klaster->nama) }}" required class="mt-1.5 block w-full rounded-xl border-slate-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 text-sm">
            </div>

            <div>
                <label for="deskripsi" class="block text-sm font-semibold text-slate-700">Deskripsi & Ruang Lingkup</label>
                <textarea name="deskripsi" id="deskripsi" rows="4" class="mt-1.5 block w-full rounded-xl border-slate-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 text-sm">{{ old('deskripsi', $klaster->deskripsi) }}</textarea>
            </div>

            <div class="flex items-center justify-end space-x-3 pt-4 border-t border-slate-100">
                <a href="{{ route('admin.klaster.index') }}" class="px-4 py-2.5 rounded-xl border border-slate-200 text-slate-700 font-medium text-sm hover:bg-slate-50">Batal</a>
                <button type="submit" class="px-5 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-semibold text-sm shadow-sm shadow-emerald-700/30">Perbarui Data</button>
            </div>
        </form>
    </div>
</div>
@endsection
