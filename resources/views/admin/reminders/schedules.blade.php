@extends('layouts.admin')

@section('content')
<div class="space-y-6">
    <!-- Header with 3 Tabs -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 border-b border-slate-200 pb-4">
        <div>
            <h1 class="text-xl font-bold text-slate-800">Otomasi Reminder WhatsApp Pasien</h1>
            <p class="text-sm text-slate-500">Pengingat kontrol rutin hipertensi/diabetes dan posyandu balita</p>
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

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- List Jadwal -->
        <div class="lg:col-span-2 bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
            <div class="p-6 border-b border-slate-100 flex items-center justify-between">
                <h2 class="font-bold text-slate-800 text-base">Daftar Jadwal Pengingat</h2>
                <span class="text-xs text-slate-400">Total: {{ $reminders->total() }} Jadwal</span>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm">
                    <thead class="bg-slate-50 text-slate-500 uppercase text-xs tracking-wider border-b border-slate-100">
                        <tr>
                            <th class="px-6 py-3 font-semibold">Nama Pasien</th>
                            <th class="px-6 py-3 font-semibold">Klaster</th>
                            <th class="px-6 py-3 font-semibold">Jadwal Blast</th>
                            <th class="px-6 py-3 font-semibold text-center">Status</th>
                            <th class="px-6 py-3 font-semibold text-right">Tes Kirim</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($reminders as $reminder)
                            <tr class="hover:bg-slate-50 transition-colors">
                                <td class="px-6 py-4">
                                    <div class="font-bold text-slate-800">{{ $reminder->nama_pasien }}</div>
                                    <div class="text-xs text-slate-400 font-mono">{{ $reminder->nomor_wa }}</div>
                                </td>
                                <td class="px-6 py-4 text-xs text-slate-600">
                                    {{ $reminder->klaster->nama ?? '-' }}
                                </td>
                                <td class="px-6 py-4 text-xs font-medium text-emerald-700">
                                    {{ $reminder->jadwal ?? ('Pukul ' . $reminder->jam_kirim) }}
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-semibold {{ $reminder->status === 'aktif' ? 'bg-emerald-100 text-emerald-800' : 'bg-slate-100 text-slate-600' }}">
                                        {{ ucfirst($reminder->status) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <form action="{{ route('admin.reminders.sendTest') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="reminder_id" value="{{ $reminder->id }}">
                                        <button type="submit" class="inline-flex items-center px-3 py-1.5 rounded-lg bg-emerald-50 text-emerald-700 hover:bg-emerald-100 font-semibold text-xs transition-colors">
                                            Kirim Tes
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-12 text-center text-slate-400">Belum ada jadwal reminder terdaftar.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="p-4 border-t border-slate-100">
                {{ $reminders->links() }}
            </div>
        </div>

        <!-- Form Tambah Jadwal -->
        <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm space-y-4">
            <h3 class="font-bold text-slate-800 text-base">Buat Jadwal Baru</h3>
            <form action="{{ route('admin.reminders.storeSchedule') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-xs font-semibold text-slate-700">Nama Pasien <span class="text-rose-500">*</span></label>
                    <input type="text" name="nama_pasien" required placeholder="Contoh: Ibu Siti Aisyah" class="mt-1 block w-full rounded-xl border-slate-300 text-xs">
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-700">Nomor WhatsApp (E.164) <span class="text-rose-500">*</span></label>
                    <input type="text" name="nomor_wa" required placeholder="+628123456789" class="mt-1 block w-full rounded-xl border-slate-300 text-xs">
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-700">Klaster Rumpun <span class="text-rose-500">*</span></label>
                    <select name="klaster_id" required class="mt-1 block w-full rounded-xl border-slate-300 text-xs">
                        @foreach($klasters as $klaster)
                            <option value="{{ $klaster->id }}">{{ $klaster->nama }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-semibold text-slate-700">Interval</label>
                        <select name="tipe_interval" class="mt-1 block w-full rounded-xl border-slate-300 text-xs">
                            <option value="bulanan">Bulanan</option>
                            <option value="sekali">Sekali Jalan</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-700">Tanggal/Hari ke-</label>
                        <input type="number" name="hari_ke" min="1" max="31" value="24" class="mt-1 block w-full rounded-xl border-slate-300 text-xs">
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-semibold text-slate-700">Jam Kirim</label>
                        <input type="time" name="jam_kirim" value="08:00" class="mt-1 block w-full rounded-xl border-slate-300 text-xs">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-700">Status</label>
                        <select name="status" class="mt-1 block w-full rounded-xl border-slate-300 text-xs">
                            <option value="aktif">Aktif</option>
                            <option value="nonaktif">Nonaktif</option>
                        </select>
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-700">Template Pesan WhatsApp <span class="text-rose-500">*</span></label>
                    <textarea name="template_pesan" rows="4" required class="mt-1 block w-full rounded-xl border-slate-300 text-xs font-sans">Halo {nama_pasien}, mengingatkan jadwal kontrol berkala pada tanggal {tanggal}. Salam sehat Puskesmas Cilimus.</textarea>
                    <p class="text-[11px] text-slate-400 mt-1">Token didukung: <code>{nama_pasien}</code>, <code>{tanggal}</code>, <code>{lokasi_kegiatan}</code></p>
                </div>

                <button type="submit" class="w-full py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-semibold text-xs shadow-sm shadow-emerald-700/30">
                    Simpan Jadwal Pengingat
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
