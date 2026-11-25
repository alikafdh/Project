@extends('layouts.admin')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-xl font-bold text-slate-800">Master Data Klaster ILP</h1>
            <p class="text-sm text-slate-500">Strukturisasi 5 Klaster Siklus Hidup Standar Kemenkes RI</p>
        </div>
        <a href="{{ route('admin.klaster.create') }}" class="inline-flex items-center justify-center px-4 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-medium text-sm shadow-sm shadow-emerald-700/30 transition-all">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
            Tambah Klaster Baru
        </a>
    </div>

    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead class="bg-slate-50 border-b border-slate-200 text-slate-500 uppercase text-xs tracking-wider">
                    <tr>
                        <th class="px-6 py-4 font-semibold">Nama Klaster</th>
                        <th class="px-6 py-4 font-semibold">Slug Identifikasi</th>
                        <th class="px-6 py-4 font-semibold text-center">Poliklinik</th>
                        <th class="px-6 py-4 font-semibold text-center">Artikel</th>
                        <th class="px-6 py-4 font-semibold text-center">Pasien WA</th>
                        <th class="px-6 py-4 font-semibold text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($klasters as $klaster)
                        <tr class="hover:bg-slate-50 transition-colors">
                            <td class="px-6 py-4">
                                <div class="font-bold text-slate-800">{{ $klaster->nama }}</div>
                                <p class="text-xs text-slate-500 mt-0.5 line-clamp-1">{{ $klaster->deskripsi ?? 'Tidak ada deskripsi.' }}</p>
                            </td>
                            <td class="px-6 py-4 font-mono text-xs text-emerald-700 font-medium">
                                {{ $klaster->slug }}
                            </td>
                            <td class="px-6 py-4 text-center">
                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700">
                                    {{ $klaster->layanan_count }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-semibold bg-green-50 text-[#2E7D32]">
                                    {{ $klaster->posts_count }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-semibold bg-[#E8F5E9] text-[#1B5E20]">
                                    {{ $klaster->reminders_count }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-right space-x-2">
                                <a href="{{ route('admin.klaster.edit', $klaster) }}" class="inline-flex items-center px-2.5 py-1.5 rounded-lg border border-slate-200 text-xs font-medium text-slate-700 hover:bg-slate-100">
                                    Ubah
                                </a>
                                <form action="{{ route('admin.klaster.destroy', $klaster) }}" method="POST" class="inline-block" onsubmit="return confirm('Apakah Anda yakin ingin menghapus klaster ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="inline-flex items-center px-2.5 py-1.5 rounded-lg border border-rose-200 text-xs font-medium text-rose-600 hover:bg-rose-50">
                                        Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center text-slate-400">Belum ada data Klaster ILP.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
