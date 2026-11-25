@extends('layouts.admin')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-xl font-bold text-slate-800">Profil Instansi Puskesmas</h1>
            <p class="text-sm text-slate-500">Kelola visi, misi, kontak resmi, struktur organisasi, dan foto fasilitas</p>
        </div>
    </div>

    <div class="bg-white p-6 sm:p-8 rounded-2xl border border-slate-200 shadow-sm">
        <form action="{{ route('admin.profil.update') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
            @csrf
            @method('PUT')

            <!-- Bagian Visi & Misi -->
            <div class="space-y-4">
                <h2 class="text-base font-bold text-emerald-900 border-b border-emerald-100 pb-2">Visi & Misi Instansi</h2>
                
                <div>
                    <label for="visi" class="block text-sm font-semibold text-slate-700">Visi Puskesmas <span class="text-rose-500">*</span></label>
                    <textarea name="visi" id="visi" rows="3" required class="mt-1.5 block w-full rounded-xl border-slate-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 text-sm">{{ old('visi', $profil->visi) }}</textarea>
                </div>

                <div>
                    <label for="misi_text" class="block text-sm font-semibold text-slate-700">Poin-poin Misi (Pisahkan per baris) <span class="text-rose-500">*</span></label>
                    @php
                        $misiVal = is_array($profil->misi) ? implode("\n", $profil->misi) : '';
                    @endphp
                    <textarea name="misi_text" id="misi_text" rows="6" required placeholder="Tuliskan setiap poin misi pada baris baru..." class="mt-1.5 block w-full rounded-xl border-slate-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 text-sm">{{ old('misi_text', $misiVal) }}</textarea>
                    <p class="text-xs text-slate-400 mt-1">Setiap baris teks baru otomatis tersimpan sebagai satu poin butir misi.</p>
                </div>

                <div>
                    <label for="wilayah_kerja" class="block text-sm font-semibold text-slate-700">Wilayah Kerja Binaan</label>
                    <textarea name="wilayah_kerja" id="wilayah_kerja" rows="2" class="mt-1.5 block w-full rounded-xl border-slate-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 text-sm">{{ old('wilayah_kerja', $profil->wilayah_kerja) }}</textarea>
                </div>
            </div>

            <!-- Bagian Kontak & Lokasi -->
            <div class="space-y-4">
                <h2 class="text-base font-bold text-emerald-900 border-b border-emerald-100 pb-2">Kontak Resmi & Alamat</h2>

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
                    <div>
                        <label for="no_telepon" class="block text-sm font-semibold text-slate-700">Nomor Telepon Kantor <span class="text-rose-500">*</span></label>
                        <input type="text" name="no_telepon" id="no_telepon" value="{{ old('no_telepon', $profil->no_telepon) }}" required class="mt-1.5 block w-full rounded-xl border-slate-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 text-sm">
                    </div>

                    <div>
                        <label for="wa_number" class="block text-sm font-semibold text-slate-700">Nomor WhatsApp Resmi <span class="text-rose-500">*</span></label>
                        <input type="text" name="wa_number" id="wa_number" value="{{ old('wa_number', $profil->wa_number) }}" placeholder="6281123456789" required class="mt-1.5 block w-full rounded-xl border-slate-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 text-sm">
                    </div>

                    <div>
                        <label for="email" class="block text-sm font-semibold text-slate-700">Email Resmi Puskesmas <span class="text-rose-500">*</span></label>
                        <input type="email" name="email" id="email" value="{{ old('email', $profil->email) }}" required class="mt-1.5 block w-full rounded-xl border-slate-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 text-sm">
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <div>
                        <label for="alamat" class="block text-sm font-semibold text-slate-700">Alamat Lengkap <span class="text-rose-500">*</span></label>
                        <input type="text" name="alamat" id="alamat" value="{{ old('alamat', $profil->alamat) }}" required class="mt-1.5 block w-full rounded-xl border-slate-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 text-sm">
                    </div>

                    <div>
                        <label for="koordinat_peta" class="block text-sm font-semibold text-slate-700">Koordinat Peta (Latitude, Longitude)</label>
                        <input type="text" name="koordinat_peta" id="koordinat_peta" value="{{ old('koordinat_peta', $profil->koordinat_peta) }}" placeholder="-6.9829285,108.4989679" class="mt-1.5 block w-full rounded-xl border-slate-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 text-sm">
                    </div>
                </div>
            </div>

            <!-- Bagian Unggah Berkas & Gambar -->
            <div class="space-y-4">
                <h2 class="text-base font-bold text-emerald-900 border-b border-emerald-100 pb-2">Berkas Visual & Identitas</h2>

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
                    <!-- Logo -->
                    <div class="p-4 rounded-xl border border-slate-200 bg-slate-50">
                        <label for="logo" class="block text-xs font-bold text-slate-700 uppercase">Logo Puskesmas</label>
                        @if($profil->logo)
                            <div class="my-2 p-2 bg-white rounded border border-slate-200 flex items-center justify-center h-20">
                                <img src="{{ asset('storage/' . $profil->logo) }}" alt="Logo" class="max-h-16 object-contain">
                            </div>
                        @endif
                        <input type="file" name="logo" id="logo" accept="image/*" class="mt-2 block w-full text-xs text-slate-500 file:mr-2 file:py-1 file:px-2.5 file:rounded-lg file:border-0 file:text-xs file:bg-emerald-100 file:text-emerald-800">
                    </div>

                    <!-- Foto Fasilitas -->
                    <div class="p-4 rounded-xl border border-slate-200 bg-slate-50">
                        <label for="foto_fasilitas" class="block text-xs font-bold text-slate-700 uppercase">Foto Gedung Fasilitas</label>
                        @if($profil->foto_fasilitas)
                            <div class="my-2 p-2 bg-white rounded border border-slate-200 flex items-center justify-center h-20">
                                <img src="{{ asset('storage/' . $profil->foto_fasilitas) }}" alt="Fasilitas" class="max-h-16 object-cover rounded">
                            </div>
                        @endif
                        <input type="file" name="foto_fasilitas" id="foto_fasilitas" accept="image/*" class="mt-2 block w-full text-xs text-slate-500 file:mr-2 file:py-1 file:px-2.5 file:rounded-lg file:border-0 file:text-xs file:bg-emerald-100 file:text-emerald-800">
                    </div>

                    <!-- Bagan Struktur Organisasi -->
                    <div class="p-4 rounded-xl border border-slate-200 bg-slate-50">
                        <label for="strukt_organisasi" class="block text-xs font-bold text-slate-700 uppercase">Bagan SOTK Organisasi</label>
                        @if($profil->strukt_organisasi)
                            <div class="my-2 p-2 bg-white rounded border border-slate-200 flex items-center justify-center h-20">
                                <img src="{{ asset('storage/' . $profil->strukt_organisasi) }}" alt="SOTK" class="max-h-16 object-contain">
                            </div>
                        @endif
                        <input type="file" name="strukt_organisasi" id="strukt_organisasi" accept="image/*" class="mt-2 block w-full text-xs text-slate-500 file:mr-2 file:py-1 file:px-2.5 file:rounded-lg file:border-0 file:text-xs file:bg-emerald-100 file:text-emerald-800">
                    </div>
                </div>
            </div>

            <div class="flex items-center justify-end pt-4 border-t border-slate-100">
                <button type="submit" class="px-6 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-semibold text-sm shadow-sm shadow-emerald-700/30">
                    Simpan Perubahan Profil
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
