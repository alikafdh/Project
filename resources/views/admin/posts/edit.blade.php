@extends('layouts.admin')

@section('content')
<div class="max-w-4xl mx-auto space-y-6" x-data="{ tipe: '{{ old('tipe', $post->tipe) }}' }">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-xl font-bold text-slate-800">Ubah Data Postingan</h1>
            <p class="text-sm text-slate-500">Perbarui naskah atau lampiran berkas dokumen</p>
        </div>
        <a href="{{ route('admin.posts.index') }}" class="text-xs font-semibold text-slate-500 hover:text-slate-800">← Kembali</a>
    </div>

    <div class="bg-white p-6 sm:p-8 rounded-2xl border border-slate-200 shadow-sm">
        <form action="{{ route('admin.posts.update', $post) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')

            <!-- Judul -->
            <div>
                <label for="judul" class="block text-sm font-semibold text-slate-700">Judul Postingan <span class="text-rose-500">*</span></label>
                <input type="text" name="judul" id="judul" value="{{ old('judul', $post->judul) }}" required class="mt-1.5 block w-full rounded-xl border-slate-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 text-sm">
            </div>

            <!-- Tipe, Klaster, Status Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
                <div>
                    <label for="tipe" class="block text-sm font-semibold text-slate-700">Kategori Tipe <span class="text-rose-500">*</span></label>
                    <select name="tipe" id="tipe" x-model="tipe" required class="mt-1.5 block w-full rounded-xl border-slate-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 text-sm">
                        <option value="berita" {{ old('tipe', $post->tipe) === 'berita' ? 'selected' : '' }}>Berita / Artikel</option>
                        <option value="laporan" {{ old('tipe', $post->tipe) === 'laporan' ? 'selected' : '' }}>Laporan Kinerja (PDF)</option>
                        <option value="agenda" {{ old('tipe', $post->tipe) === 'agenda' ? 'selected' : '' }}>Agenda Kegiatan</option>
                    </select>
                </div>

                <div>
                    <label for="klaster_id" class="block text-sm font-semibold text-slate-700">Klaster ILP</label>
                    <select name="klaster_id" id="klaster_id" class="mt-1.5 block w-full rounded-xl border-slate-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 text-sm">
                        <option value="">-- Pengumuman Umum (Non-Klaster) --</option>
                        @foreach($klasters as $klaster)
                            <option value="{{ $klaster->id }}" {{ old('klaster_id', $post->klaster_id) == $klaster->id ? 'selected' : '' }}>{{ $klaster->nama }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="status" class="block text-sm font-semibold text-slate-700">Status Publikasi <span class="text-rose-500">*</span></label>
                    <select name="status" id="status" required class="mt-1.5 block w-full rounded-xl border-slate-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 text-sm">
                        <option value="published" {{ old('status', $post->status) === 'published' ? 'selected' : '' }}>Published (Terbit)</option>
                        <option value="draft" {{ old('status', $post->status) === 'draft' ? 'selected' : '' }}>Draft (Konsep)</option>
                    </select>
                </div>
            </div>

            <!-- Khusus Laporan Form Fields -->
            <div x-show="tipe === 'laporan'" class="p-4 rounded-xl bg-purple-50/70 border border-purple-100 space-y-4">
                <h3 class="text-xs font-bold text-purple-900 uppercase tracking-wider">Kelengkapan Laporan Kinerja Instansi</h3>
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <div>
                        <label for="periode_bulan" class="block text-xs font-semibold text-slate-700">Periode Bulan</label>
                        <input type="text" name="periode_bulan" id="periode_bulan" value="{{ old('periode_bulan', $post->periode_bulan) }}" class="mt-1 block w-full rounded-xl border-slate-300 text-xs">
                    </div>
                    <div>
                        <label for="periode_tahun" class="block text-xs font-semibold text-slate-700">Periode Tahun</label>
                        <input type="number" name="periode_tahun" id="periode_tahun" value="{{ old('periode_tahun', $post->periode_tahun) }}" class="mt-1 block w-full rounded-xl border-slate-300 text-xs">
                    </div>
                    <div>
                        <label for="file_pdf" class="block text-xs font-semibold text-slate-700">Unggah PDF Baru (Opsional)</label>
                        @if($post->file_pdf)
                            <div class="mb-1 text-[11px] text-purple-700 truncate font-mono">{{ $post->file_pdf }}</div>
                        @endif
                        <input type="file" name="file_pdf" id="file_pdf" accept=".pdf" class="mt-1 block w-full text-xs text-slate-500 file:mr-2 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-xs file:bg-purple-100 file:text-purple-800">
                    </div>
                </div>
            </div>

            <!-- Khusus Agenda Form Fields -->
            <div x-show="tipe === 'agenda'" class="p-4 rounded-xl bg-amber-50/70 border border-amber-100 space-y-4">
                <h3 class="text-xs font-bold text-amber-900 uppercase tracking-wider">Detail Kegiatan / Posyandu</h3>
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <div>
                        <label for="waktu_kegiatan" class="block text-xs font-semibold text-slate-700">Waktu Pelaksanaan</label>
                        <input type="datetime-local" name="waktu_kegiatan" id="waktu_kegiatan" value="{{ old('waktu_kegiatan', $post->waktu_kegiatan ? $post->waktu_kegiatan->format('Y-m-d\TH:i') : '') }}" class="mt-1 block w-full rounded-xl border-slate-300 text-xs">
                    </div>
                    <div>
                        <label for="lokasi_kegiatan" class="block text-xs font-semibold text-slate-700">Lokasi / Tempat</label>
                        <input type="text" name="lokasi_kegiatan" id="lokasi_kegiatan" value="{{ old('lokasi_kegiatan', $post->lokasi_kegiatan) }}" class="mt-1 block w-full rounded-xl border-slate-300 text-xs">
                    </div>
                    <div>
                        <label for="sasaran_peserta" class="block text-xs font-semibold text-slate-700">Sasaran Peserta</label>
                        <input type="text" name="sasaran_peserta" id="sasaran_peserta" value="{{ old('sasaran_peserta', $post->sasaran_peserta) }}" class="mt-1 block w-full rounded-xl border-slate-300 text-xs">
                    </div>
                </div>
            </div>

            <!-- Thumbnail -->
            <div>
                <label for="foto_thumbnail" class="block text-sm font-semibold text-slate-700">Foto Sampul Baru (Opsional)</label>
                @if($post->foto_thumbnail)
                    <div class="mb-2 text-xs text-emerald-700 font-mono">Berkas saat ini: {{ $post->foto_thumbnail }}</div>
                @endif
                <input type="file" name="foto_thumbnail" id="foto_thumbnail" accept="image/*" class="mt-1.5 block w-full text-xs text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-emerald-50 file:text-emerald-700 hover:file:bg-emerald-100">
            </div>

            <!-- Konten Isi -->
            <div>
                <label for="isi" class="block text-sm font-semibold text-slate-700">Konten Isi Informasi <span class="text-rose-500">*</span></label>
                <textarea name="isi" id="isi" rows="10" required class="mt-1.5 block w-full rounded-xl border-slate-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 text-sm font-sans">{{ old('isi', $post->isi) }}</textarea>
            </div>

            <div class="flex items-center justify-end space-x-3 pt-4 border-t border-slate-100">
                <a href="{{ route('admin.posts.index') }}" class="px-4 py-2.5 rounded-xl border border-slate-200 text-slate-700 font-medium text-sm hover:bg-slate-50">Batal</a>
                <button type="submit" class="px-5 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-semibold text-sm shadow-sm shadow-emerald-700/30">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>
@endsection
