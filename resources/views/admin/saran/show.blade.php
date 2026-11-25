@extends('layouts.admin')

@section('content')
<div class="max-w-3xl mx-auto space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-xl font-bold text-slate-800">Detail Pesan Saran Warga</h1>
            <p class="text-sm text-slate-500">Masuk pada {{ $saran->created_at->isoFormat('dddd, D MMMM Y - HH:mm') }} WIB</p>
        </div>
        <a href="{{ route('admin.saran.index') }}" class="text-xs font-semibold text-slate-500 hover:text-slate-800">← Kembali ke Kotak Masuk</a>
    </div>

    <!-- Kartu Informasi Pesan -->
    <div class="bg-white p-6 sm:p-8 rounded-2xl border border-slate-200 shadow-sm space-y-6">
        <div class="flex items-start justify-between border-b border-slate-100 pb-4">
            <div>
                <span class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Identitas Pengirim</span>
                <h3 class="text-lg font-bold text-slate-800 mt-1">{{ $saran->nama_pengirim }}</h3>
                <p class="text-xs text-emerald-700 font-mono mt-0.5">{{ $saran->kontak }}</p>
            </div>
            <div class="text-right">
                <span class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Klaster Terkait</span>
                <p class="text-xs font-semibold text-slate-700 mt-1">{{ $saran->klaster->nama ?? 'Umum / Lainnya' }}</p>
            </div>
        </div>

        <div>
            <h2 class="text-base font-bold text-slate-800">{{ $saran->subjek }}</h2>
            <div class="mt-3 p-4 rounded-xl bg-slate-50 border border-slate-100 text-sm text-slate-700 leading-relaxed whitespace-pre-line">
                {{ $saran->isi_pesan }}
            </div>
        </div>

        <!-- Formulir Tindak Lanjut Internal -->
        <div class="border-t border-slate-100 pt-6">
            <h3 class="text-sm font-bold text-slate-800 mb-4">Tindak Lanjut & Catatan Internal Staf</h3>
            <form action="{{ route('admin.saran.read', $saran) }}" method="POST" class="space-y-4">
                @csrf
                @method('PATCH')

                <div>
                    <label for="status" class="block text-xs font-semibold text-slate-700 uppercase tracking-wider">Status Penanganan</label>
                    <select name="status" id="status" class="mt-1.5 block w-full sm:w-64 rounded-xl border-slate-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 text-sm">
                        <option value="baru" {{ $saran->status === 'baru' ? 'selected' : '' }}>Baru</option>
                        <option value="dibaca" {{ $saran->status === 'dibaca' ? 'selected' : '' }}>Sudah Dibaca</option>
                        <option value="selesai" {{ $saran->status === 'selesai' ? 'selected' : '' }}>Selesai Ditindaklanjuti</option>
                    </select>
                </div>

                <div>
                    <label for="catatan_internal" class="block text-xs font-semibold text-slate-700 uppercase tracking-wider">Catatan Petugas</label>
                    <textarea name="catatan_internal" id="catatan_internal" rows="3" placeholder="Catatan respons staf, koordinasi internal, atau kontak tindak lanjut..." class="mt-1.5 block w-full rounded-xl border-slate-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 text-sm">{{ old('catatan_internal', $saran->catatan_internal) }}</textarea>
                </div>

                <div class="flex items-center justify-between pt-2">
                    <form action="{{ route('admin.saran.destroy', $saran) }}" method="POST" onsubmit="return confirm('Hapus saran ini?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-xs font-medium text-rose-600 hover:text-rose-800">
                            Hapus Saran Permanen
                        </button>
                    </form>

                    <button type="submit" class="px-5 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-semibold text-sm shadow-sm shadow-emerald-700/30">
                        Simpan Tindak Lanjut
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
