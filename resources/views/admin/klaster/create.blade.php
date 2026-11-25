@extends('layouts.admin')

@section('content')
<div class="max-w-2xl mx-auto space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-xl font-bold text-slate-800">Tambah Klaster ILP</h1>
            <p class="text-sm text-slate-500">Mendaftarkan rumpun pelayanan kesehatan siklus hidup baru</p>
        </div>
        <a href="{{ route('admin.klaster.index') }}" class="text-xs font-semibold text-slate-500 hover:text-slate-800">← Kembali</a>
    </div>

    <div class="bg-white p-6 sm:p-8 rounded-2xl border border-slate-200 shadow-sm">
        <form action="{{ route('admin.klaster.store') }}" method="POST" class="space-y-6">
            @csrf
            <div>
                <label for="nama" class="block text-sm font-semibold text-slate-700">Nama Klaster <span class="text-rose-500">*</span></label>
                <input type="text" name="nama" id="nama" value="{{ old('nama') }}" placeholder="Contoh: Klaster 2: Pelayanan Ibu & Anak" required class="mt-1.5 block w-full rounded-xl border-slate-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 text-sm">
            </div>

            <div>
                <label for="deskripsi" class="block text-sm font-semibold text-slate-700">Deskripsi & Ruang Lingkup</label>
                <textarea name="deskripsi" id="deskripsi" rows="4" placeholder="Uraian ringkas fokus penanganan pelayanan kesehatan pada klaster ini..." class="mt-1.5 block w-full rounded-xl border-slate-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 text-sm">{{ old('deskripsi') }}</textarea>
            </div>

            <div class="flex items-center justify-end space-x-3 pt-4 border-t border-slate-100">
                <a href="{{ route('admin.klaster.index') }}" class="px-4 py-2.5 rounded-xl border border-slate-200 text-slate-700 font-medium text-sm hover:bg-slate-50">Batal</a>
                <button type="submit" class="px-5 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-semibold text-sm shadow-sm shadow-emerald-700/30">Simpan Klaster</button>
            </div>
        </form>
    </div>
</div>
@endsection
