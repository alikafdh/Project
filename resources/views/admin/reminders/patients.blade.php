@extends('layouts.admin')

@section('content')
<div class="space-y-6">
    <!-- Header with 3 Tabs -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 border-b border-slate-200 pb-4">
        <div>
            <h1 class="text-xl font-bold text-slate-800">Data Pasien Sasaran Reminder</h1>
            <p class="text-sm text-slate-500">Daftar kontak warga/pasien yang terdaftar dalam program pengingat berkala</p>
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
                        <th class="px-6 py-4 font-semibold">Nama Pasien</th>
                        <th class="px-6 py-4 font-semibold">Nomor WhatsApp</th>
                        <th class="px-6 py-4 font-semibold">Program / Klaster</th>
                        <th class="px-6 py-4 font-semibold">Jadwal Kontrol</th>
                        <th class="px-6 py-4 font-semibold text-center">Status Keaktifan</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($patients as $patient)
                        <tr class="hover:bg-slate-50 transition-colors">
                            <td class="px-6 py-4 font-bold text-slate-800">
                                {{ $patient->nama_pasien }}
                            </td>
                            <td class="px-6 py-4 font-mono text-xs text-emerald-700">
                                <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $patient->nomor_wa) }}" target="_blank" class="hover:underline">
                                    {{ $patient->nomor_wa }} ↗
                                </a>
                            </td>
                            <td class="px-6 py-4 text-xs text-slate-600">
                                {{ $patient->klaster->nama ?? '-' }}
                            </td>
                            <td class="px-6 py-4 text-xs text-slate-700">
                                {{ $patient->jadwal ?? 'Bulanan' }}
                            </td>
                            <td class="px-6 py-4 text-center">
                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-semibold {{ $patient->status === 'aktif' ? 'bg-emerald-100 text-emerald-800' : 'bg-slate-100 text-slate-600' }}">
                                    {{ ucfirst($patient->status) }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center text-slate-400">Belum ada pasien terdaftar.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="p-4 border-t border-slate-100">
            {{ $patients->links() }}
        </div>
    </div>
</div>
@endsection
