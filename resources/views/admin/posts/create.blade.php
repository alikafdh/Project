@extends('layouts.admin')

@section('content')
<div class="max-w-4xl mx-auto space-y-6" x-data="{ tipe: '{{ old('tipe', 'berita') }}' }">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-xl font-bold text-slate-800">Tulis Informasi Baru</h1>
            <p class="text-sm text-slate-500">Menerbitkan berita kesehatan, laporan kinerja PDF, atau agenda posyandu</p>
        </div>
        <a href="{{ route('admin.posts.index') }}" class="text-xs font-semibold text-slate-500 hover:text-slate-800">← Kembali</a>
    </div>

    <div class="bg-white p-6 sm:p-8 rounded-2xl border border-slate-200 shadow-sm">
        <form action="{{ route('admin.posts.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf

            <!-- Judul -->
            <div>
                <label for="judul" class="block text-sm font-semibold text-slate-700">Judul Postingan <span class="text-rose-500">*</span></label>
                <input type="text" name="judul" id="judul" value="{{ old('judul') }}" placeholder="Judul berita edukasi atau laporan..." required class="mt-1.5 block w-full rounded-xl border-slate-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 text-sm">
            </div>

            <!-- Tipe, Klaster, Status Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
                <div>
                    <label for="tipe" class="block text-sm font-semibold text-slate-700">Kategori Tipe <span class="text-rose-500">*</span></label>
                    <select name="tipe" id="tipe" x-model="tipe" required class="mt-1.5 block w-full rounded-xl border-slate-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 text-sm">
                        <option value="berita">Berita / Artikel</option>
                        <option value="laporan">Laporan Kinerja (PDF)</option>
                        <option value="agenda">Agenda Kegiatan</option>
                    </select>
                </div>

                <div>
                    <label for="klaster_id" class="block text-sm font-semibold text-slate-700">Klaster ILP</label>
                    <select name="klaster_id" id="klaster_id" class="mt-1.5 block w-full rounded-xl border-slate-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 text-sm">
                        <option value="">-- Pengumuman Umum (Non-Klaster) --</option>
                        @foreach($klasters as $klaster)
                            <option value="{{ $klaster->id }}" {{ old('klaster_id') == $klaster->id ? 'selected' : '' }}>{{ $klaster->nama }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="status" class="block text-sm font-semibold text-slate-700">Status Publikasi <span class="text-rose-500">*</span></label>
                    <select name="status" id="status" required class="mt-1.5 block w-full rounded-xl border-slate-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 text-sm">
                        <option value="published" {{ old('status') === 'published' ? 'selected' : '' }}>Published (Terbit)</option>
                        <option value="draft" {{ old('status') === 'draft' ? 'selected' : '' }}>Draft (Konsep)</option>
                    </select>
                </div>
            </div>

            <!-- Khusus Laporan Form Fields -->
            <div x-show="tipe === 'laporan'" class="p-4 rounded-xl bg-purple-50/70 border border-purple-100 space-y-4" style="display: none;">
                <h3 class="text-xs font-bold text-purple-900 uppercase tracking-wider">Kelengkapan Laporan Kinerja Instansi</h3>
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <div>
                        <label for="periode_bulan" class="block text-xs font-semibold text-slate-700">Periode Bulan</label>
                        <input type="text" name="periode_bulan" id="periode_bulan" value="{{ old('periode_bulan') }}" placeholder="Contoh: Triwulan III / Oktober" class="mt-1 block w-full rounded-xl border-slate-300 text-xs">
                    </div>
                    <div>
                        <label for="periode_tahun" class="block text-xs font-semibold text-slate-700">Periode Tahun</label>
                        <input type="number" name="periode_tahun" id="periode_tahun" value="{{ old('periode_tahun', date('Y')) }}" class="mt-1 block w-full rounded-xl border-slate-300 text-xs">
                    </div>
                    <div>
                        <label for="file_pdf" class="block text-xs font-semibold text-slate-700">Dokumen PDF Laporan</label>
                        <input type="file" name="file_pdf" id="file_pdf" accept=".pdf" class="mt-1 block w-full text-xs text-slate-500 file:mr-2 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-xs file:bg-purple-100 file:text-purple-800">
                    </div>
                </div>
            </div>

            <!-- Khusus Agenda Form Fields -->
            <div x-show="tipe === 'agenda'" class="p-4 rounded-xl bg-amber-50/70 border border-amber-100 space-y-4" style="display: none;">
                <h3 class="text-xs font-bold text-amber-900 uppercase tracking-wider">Detail Kegiatan / Posyandu</h3>
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <div>
                        <label for="waktu_kegiatan" class="block text-xs font-semibold text-slate-700">Waktu Pelaksanaan</label>
                        <input type="datetime-local" name="waktu_kegiatan" id="waktu_kegiatan" value="{{ old('waktu_kegiatan') }}" class="mt-1 block w-full rounded-xl border-slate-300 text-xs">
                    </div>
                    <div>
                        <label for="lokasi_kegiatan" class="block text-xs font-semibold text-slate-700">Lokasi / Tempat</label>
                        <input type="text" name="lokasi_kegiatan" id="lokasi_kegiatan" value="{{ old('lokasi_kegiatan') }}" placeholder="Contoh: Balai Desa Cibeureum" class="mt-1 block w-full rounded-xl border-slate-300 text-xs">
                    </div>
                    <div>
                        <label for="sasaran_peserta" class="block text-xs font-semibold text-slate-700">Sasaran Peserta</label>
                        <input type="text" name="sasaran_peserta" id="sasaran_peserta" value="{{ old('sasaran_peserta') }}" placeholder="Contoh: Balita 0-59 bulan" class="mt-1 block w-full rounded-xl border-slate-300 text-xs">
                    </div>
                </div>
            </div>

            <!-- Thumbnail -->
            <div>
                <label for="foto_thumbnail" class="block text-sm font-semibold text-slate-700">Foto Sampul / Cover (Rasio 16:9)</label>
                <input type="file" name="foto_thumbnail" id="foto_thumbnail" accept="image/*" class="mt-1.5 block w-full text-xs text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-emerald-50 file:text-emerald-700 hover:file:bg-emerald-100">
            </div>

            <!-- Konten Isi -->
            <div>
                <label for="isi" class="block text-sm font-semibold text-slate-700">Konten Isi Informasi <span class="text-rose-500">*</span></label>
                <textarea name="isi" id="isi" rows="10" placeholder="Tuliskan isi berita edukasi atau rincian laporan secara komprehensif..." required class="mt-1.5 block w-full rounded-xl border-slate-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 text-sm font-sans">{{ old('isi') }}</textarea>
                <p class="text-xs text-slate-400 mt-1">Mendukung format HTML standar (paragraf, tebal, miring, list berpoin).</p>
            </div>

            <div class="flex items-center justify-end space-x-3 pt-4 border-t border-slate-100">
                <a href="{{ route('admin.posts.index') }}" class="px-4 py-2.5 rounded-xl border border-slate-200 text-slate-700 font-medium text-sm hover:bg-slate-50">Batal</a>
                <button type="submit" class="px-5 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-semibold text-sm shadow-sm shadow-emerald-700/30">Terbitkan Postingan</button>
            </div>
        </form>
    </div>
</div>
@endsection
