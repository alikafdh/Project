@extends('layouts.admin')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-xl font-bold text-slate-800">Kotak Masuk Saran & Kritik Warga</h1>
            <p class="text-sm text-slate-500">Aspirasi dan pengaduan mutu pelayanan dari masyarakat</p>
        </div>
    </div>

    <!-- Filter Status -->
    <div class="bg-white p-4 rounded-2xl border border-slate-200 shadow-sm flex items-center justify-between">
        <form method="GET" action="{{ route('admin.saran.index') }}" class="flex items-center space-x-3">
            <select name="status" onchange="this.form.submit()" class="rounded-xl border-slate-300 text-xs font-medium focus:border-emerald-500 focus:ring-emerald-500">
                <option value="">Semua Status Saran</option>
                <option value="baru" {{ request('status') === 'baru' ? 'selected' : '' }}>Saran Baru (Belum Dibaca)</option>
                <option value="dibaca" {{ request('status') === 'dibaca' ? 'selected' : '' }}>Sudah Dibaca</option>
                <option value="selesai" {{ request('status') === 'selesai' ? 'selected' : '' }}>Selesai Ditindaklanjuti</option>
            </select>
        </form>
    </div>

    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead class="bg-slate-50 border-b border-slate-200 text-slate-500 uppercase text-xs tracking-wider">
                    <tr>
                        <th class="px-6 py-4 font-semibold">Pengirim & Kontak</th>
                        <th class="px-6 py-4 font-semibold">Subjek Pesan</th>
                        <th class="px-6 py-4 font-semibold">Klaster Rumpun</th>
                        <th class="px-6 py-4 font-semibold">Waktu Masuk</th>
                        <th class="px-6 py-4 font-semibold text-center">Status</th>
                        <th class="px-6 py-4 font-semibold text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($feedbacks as $feedback)
                        <tr class="hover:bg-slate-50 transition-colors {{ $feedback->status === 'baru' ? 'bg-amber-50/30' : '' }}">
                            <td class="px-6 py-4">
                                <div class="font-bold text-slate-800">{{ $feedback->nama_pengirim }}</div>
                                <div class="text-xs text-slate-400 font-mono">{{ $feedback->kontak }}</div>
                            </td>
                            <td class="px-6 py-4 max-w-xs">
                                <div class="font-semibold text-slate-700 text-xs line-clamp-1">{{ $feedback->subjek }}</div>
                                <div class="text-xs text-slate-500 line-clamp-1">{{ $feedback->isi_pesan }}</div>
                            </td>
                            <td class="px-6 py-4 text-xs">
                                <span class="text-slate-600">{{ $feedback->klaster->nama ?? 'Umum / Lainnya' }}</span>
                            </td>
                            <td class="px-6 py-4 text-xs text-slate-500">
                                {{ $feedback->created_at->diffForHumans() }}
                            </td>
                            <td class="px-6 py-4 text-center">
                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-semibold {{ $feedback->status === 'baru' ? 'bg-amber-100 text-amber-800 font-bold' : ($feedback->status === 'selesai' ? 'bg-emerald-100 text-emerald-800' : 'bg-slate-100 text-slate-700') }}">
                                    {{ ucfirst($feedback->status) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-right space-x-2">
                                <a href="{{ route('admin.saran.show', $feedback) }}" class="inline-flex items-center px-2.5 py-1.5 rounded-lg border border-slate-200 text-xs font-medium text-slate-700 hover:bg-slate-100">
                                    Buka Detail
                                </a>
                                <form action="{{ route('admin.saran.destroy', $feedback) }}" method="POST" class="inline-block" onsubmit="return confirm('Hapus pesan saran ini?');">
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
                            <td colspan="6" class="px-6 py-12 text-center text-slate-400">Belum ada data saran atau kritik warga.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="p-4 border-t border-slate-100">
            {{ $feedbacks->links() }}
        </div>
    </div>
</div>
@endsection
