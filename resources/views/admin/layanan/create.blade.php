@extends('layouts.admin')

@section('content')
<div class="max-w-3xl mx-auto space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-xl font-bold text-slate-800">Tambah Layanan / Poliklinik</h1>
            <p class="text-sm text-slate-500">Mendaftarkan unit poliklinik baru pada sistem portal</p>
        </div>
        <a href="{{ route('admin.layanan.index') }}" class="text-xs font-semibold text-slate-500 hover:text-slate-800">← Kembali</a>
    </div>

    <div class="bg-white p-6 sm:p-8 rounded-2xl border border-slate-200 shadow-sm">
        <form action="{{ route('admin.layanan.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <div>
                    <label for="nama_poli" class="block text-sm font-semibold text-slate-700">Nama Poliklinik <span class="text-rose-500">*</span></label>
                    <input type="text" name="nama_poli" id="nama_poli" value="{{ old('nama_poli') }}" placeholder="Contoh: Poli KIA & KB" required class="mt-1.5 block w-full rounded-xl border-slate-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 text-sm">
                </div>

                <div>
                    <label for="klaster_id" class="block text-sm font-semibold text-slate-700">Klaster ILP <span class="text-rose-500">*</span></label>
                    <select name="klaster_id" id="klaster_id" required class="mt-1.5 block w-full rounded-xl border-slate-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 text-sm">
                        <option value="">-- Pilih Klaster ILP --</option>
                        @foreach($klasters as $klaster)
                            <option value="{{ $klaster->id }}" {{ old('klaster_id') == $klaster->id ? 'selected' : '' }}>{{ $klaster->nama }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <div>
                    <label for="jadwal_praktik" class="block text-sm font-semibold text-slate-700">Jadwal Praktik Pelayanan <span class="text-rose-500">*</span></label>
                    <input type="text" name="jadwal_praktik" id="jadwal_praktik" value="{{ old('jadwal_praktik', 'Senin–Jumat | 07:30–12:00 WIB') }}" required class="mt-1.5 block w-full rounded-xl border-slate-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 text-sm">
                </div>

                <div>
                    <label for="tenaga_medis" class="block text-sm font-semibold text-slate-700">Dokter / Tenaga Medis Penanggung Jawab</label>
                    <input type="text" name="tenaga_medis" id="tenaga_medis" value="{{ old('tenaga_medis') }}" placeholder="Contoh: Bd. Hj. Titin Suprihatin, S.Tr.Keb" class="mt-1.5 block w-full rounded-xl border-slate-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 text-sm">
                </div>
            </div>

            <div>
                <label for="deskripsi" class="block text-sm font-semibold text-slate-700">Deskripsi & Jenis Tindakan Medis</label>
                <textarea name="deskripsi" id="deskripsi" rows="3" placeholder="Uraian layanan pemeriksaan, konsultasi, dan tindakan medis..." class="mt-1.5 block w-full rounded-xl border-slate-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 text-sm">{{ old('deskripsi') }}</textarea>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <div>
                    <label for="status" class="block text-sm font-semibold text-slate-700">Status Layanan <span class="text-rose-500">*</span></label>
                    <select name="status" id="status" required class="mt-1.5 block w-full rounded-xl border-slate-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 text-sm">
                        <option value="aktif" {{ old('status') === 'aktif' ? 'selected' : '' }}>Aktif Melayani</option>
                        <option value="nonaktif" {{ old('status') === 'nonaktif' ? 'selected' : '' }}>Nonaktif / Sementara Tutup</option>
                    </select>
                </div>

                <div>
                    <label for="gambar_alur" class="block text-sm font-semibold text-slate-700">Unggah Gambar Alur Poli (Opsional)</label>
                    <input type="file" name="gambar_alur" id="gambar_alur" accept="image/*" class="mt-1.5 block w-full text-xs text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-emerald-50 file:text-emerald-700 hover:file:bg-emerald-100">
                </div>
            </div>

            <div class="flex items-center justify-end space-x-3 pt-4 border-t border-slate-100">
                <a href="{{ route('admin.layanan.index') }}" class="px-4 py-2.5 rounded-xl border border-slate-200 text-slate-700 font-medium text-sm hover:bg-slate-50">Batal</a>
                <button type="submit" class="px-5 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-semibold text-sm shadow-sm shadow-emerald-700/30">Simpan Poliklinik</button>
            </div>
        </form>
    </div>
</div>
@endsection
