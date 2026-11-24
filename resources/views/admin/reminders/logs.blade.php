@extends('layouts.admin')

@section('content')
<div class="space-y-6">
    <!-- Header with 3 Tabs -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 border-b border-slate-200 pb-4">
        <div>
            <h1 class="text-xl font-bold text-slate-800">Riwayat Transmisi Log WhatsApp</h1>
            <p class="text-sm text-slate-500">Catatan audit log pengiriman pesan gateway dan status respon</p>
        </div>
        <div class="flex items-center space-x-2">
            <a href="{{ route('admin.reminders.export.excel') }}" class="inline-flex items-center px-3.5 py-2 rounded-xl border border-slate-200 text-xs font-semibold text-slate-700 bg-white hover:bg-slate-50">
                📥 Ekspor CSV/Excel
            </a>
            <a href="{{ route('admin.reminders.export.pdf') }}" target="_blank" class="inline-flex items-center px-3.5 py-2 rounded-xl border border-slate-200 text-xs font-semibold text-slate-700 bg-white hover:bg-slate-50">
                🖨️ Cetak Laporan
            </a>
        </div>
    </div>

    <!-- Navigation Tabs -->
    <div class="flex space-x-1 rounded-xl bg-slate-200/70 p-1 max-w-md">
        <a href="{{ route('admin.reminders.schedules') }}" class="w-full text-center py-2 text-xs font-bold rounded-lg transition-all {{ request()->routeIs('admin.reminders.schedules') ? 'bg-white text-emerald-800 shadow-sm' : 'text-slate-600 hover:text-slate-900' }}">
            Jadwal Blast
        </a>
        <a href="{{ route('admin.reminders.patients') }}" class="w-full text-center py-2 text-xs font-bold rounded-lg transition-all {{ request()->routeIs('admin.reminders.patients') ? 'bg-white text-emerald-800 shadow-sm' : 'text-slate-600 hover:text-slate-900' }}">
            Data Pasien Sasaran
        </a>
        <a href="{{ route('admin.reminders.logs') }}" class="w-full text-center py-2 text-xs font-bold rounded-lg transition-all {{ request()->routeIs('admin.reminders.logs') ? 'bg-white text-emerald-800 shadow-sm' : 'text-slate-600 hover:text-slate-900' }}">
            Riwayat Log Kirim
        </a>
    </div>

    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead class="bg-slate-50 text-slate-500 uppercase text-xs tracking-wider border-b border-slate-100">
                    <tr>
                        <th class="px-6 py-4 font-semibold">Waktu Kirim</th>
                        <th class="px-6 py-4 font-semibold">Tujuan Pasien</th>
                        <th class="px-6 py-4 font-semibold">Pesan Terkirim</th>
                        <th class="px-6 py-4 font-semibold text-center">Status</th>
                        <th class="px-6 py-4 font-semibold">Keterangan Gateway</th>
                        <th class="px-6 py-4 font-semibold text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($logs as $log)
                        <tr class="hover:bg-slate-50 transition-colors">
                            <td class="px-6 py-4 text-xs text-slate-500 whitespace-nowrap">
                                {{ $log->waktu_kirim->isoFormat('D MMM Y, HH:mm:ss') }}
                            </td>
                            <td class="px-6 py-4">
                                <div class="font-bold text-slate-800 text-xs">{{ $log->reminder->nama_pasien ?? 'Pasien Terhapus' }}</div>
                                <div class="text-[11px] font-mono text-slate-400">{{ $log->reminder->nomor_wa ?? '-' }}</div>
                            </td>
                            <td class="px-6 py-4 max-w-sm text-xs text-slate-600">
                                <div class="line-clamp-2 italic bg-slate-50 p-2 rounded border border-slate-100">
                                    "{{ $log->pesan_terkirim ?? '-' }}"
                                </div>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-semibold {{ $log->status === 'berhasil' ? 'bg-emerald-100 text-emerald-800' : ($log->status === 'gagal' ? 'bg-rose-100 text-rose-800' : 'bg-amber-100 text-amber-800') }}">
                                    {{ ucfirst($log->status) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-xs text-slate-500">
                                {{ $log->keterangan }}
                            </td>
                            <td class="px-6 py-4 text-right">
                                @if($log->status === 'gagal')
                                    <form action="{{ route('admin.reminders.retry', $log->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="inline-flex items-center px-2.5 py-1 rounded-lg bg-rose-50 text-rose-700 hover:bg-rose-100 text-xs font-semibold">
                                            Kirim Ulang
                                        </button>
                                    </form>
                                @else
                                    <span class="text-xs text-slate-300">—</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center text-slate-400">Belum ada catatan log pengiriman.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="p-4 border-t border-slate-100">
            {{ $logs->links() }}
        </div>
    </div>
</div>
@endsection
