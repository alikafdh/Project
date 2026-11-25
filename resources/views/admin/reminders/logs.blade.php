<x-admin-layout title="Log Pengiriman WhatsApp">
    <div class="space-y-6">
        <!-- Sub-Tabs Horizontal Navigation Bar & Action Buttons -->
        <div class="flex items-center justify-between flex-wrap gap-4">
            <x-admin.reminder-nav active="logs" />

            <!-- Tombol Terpisah Export Excel (Hijau) & Export PDF (Merah) -->
            <div class="flex items-center gap-2.5">
                <a href="{{ route('admin.reminders.export.excel') }}" 
                   class="h-10 px-4 rounded-xl text-white font-semibold text-xs flex items-center gap-2 shadow-sm transition-all hover:opacity-95" 
                   style="background-color: #059669;">
                    <span class="material-symbols-outlined text-[18px]">table_view</span>
                    <span>Export Excel</span>
                </a>

                <a href="{{ route('admin.reminders.export.pdf') }}" 
                   target="_blank"
                   class="h-10 px-4 rounded-xl text-white font-semibold text-xs flex items-center gap-2 shadow-sm transition-all hover:opacity-95" 
                   style="background-color: #E11D48;">
                    <span class="material-symbols-outlined text-[18px]">picture_as_pdf</span>
                    <span>Export PDF</span>
                </a>
            </div>
        </div>

        <!-- Header Section -->
        <div class="space-y-1">
            <div class="flex items-center gap-1.5 text-xs text-slate-500 font-medium">
                <span>Admin Portal</span>
                <span class="material-symbols-outlined text-[14px]">chevron_right</span>
                <span>Kelola Reminder WhatsApp</span>
                <span class="material-symbols-outlined text-[14px]">chevron_right</span>
                <span class="text-[#2E7D32] font-semibold">Log Transmisi</span>
            </div>
            <h1 class="text-2xl font-bold text-slate-800 tracking-tight">Riwayat Pengiriman Reminder WhatsApp</h1>
            <p class="text-sm text-slate-500 max-w-3xl leading-relaxed">
                Log pemantauan transmisi notifikasi jadwal kontrol, posyandu balita, dan kepatuhan obat pasien secara real-time via WhatsApp API Gateway Puskesmas Cilimus.
            </p>
        </div>

        <!-- 3 Summary Metric Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-sm flex items-center justify-between">
                <div>
                    <span class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Total Berhasil Terkirim</span>
                    <h3 class="text-2xl font-bold text-emerald-700 mt-1">{{ $totalSent }}</h3>
                    <p class="text-xs text-emerald-600 font-medium flex items-center gap-1 mt-0.5">
                        <span class="material-symbols-outlined text-[14px]">verified</span> Gateway status 200 OK
                    </p>
                </div>
                <div class="w-12 h-12 rounded-xl bg-emerald-50 flex items-center justify-center text-emerald-600">
                    <span class="material-symbols-outlined text-[26px]">mark_chat_read</span>
                </div>
            </div>

            <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-sm flex items-center justify-between">
                <div>
                    <span class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Gagal Transmisi</span>
                    <h3 class="text-2xl font-bold text-rose-600 mt-1">{{ $totalFailed }}</h3>
                    <p class="text-xs text-rose-500 font-medium flex items-center gap-1 mt-0.5">
                        <span class="material-symbols-outlined text-[14px]">error</span> Dapat dikirim ulang
                    </p>
                </div>
                <div class="w-12 h-12 rounded-xl bg-rose-50 flex items-center justify-center text-rose-600">
                    <span class="material-symbols-outlined text-[26px]">sms_failed</span>
                </div>
            </div>

            <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-sm flex items-center justify-between">
                <div>
                    <span class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Dalam Antrean / Pending</span>
                    <h3 class="text-2xl font-bold text-slate-700 mt-1">{{ $totalPending }}</h3>
                    <p class="text-xs text-slate-400 mt-0.5">Menunggu waktu cron blast</p>
                </div>
                <div class="w-12 h-12 rounded-xl bg-slate-100 flex items-center justify-center text-slate-600">
                    <span class="material-symbols-outlined text-[26px]">pending_actions</span>
                </div>
            </div>
        </div>

        <!-- Filter Bar: Dropdown Nama Reminder & Tanggal -->
        <div class="bg-white p-4 rounded-2xl border border-slate-200/80 shadow-sm">
            <form method="GET" action="{{ route('admin.reminders.logs') }}" class="flex flex-col md:flex-row items-stretch md:items-center justify-between gap-3">
                <div class="flex flex-wrap items-center gap-3 flex-1">
                    <!-- Dropdown Nama Reminder -->
                    <div class="min-w-[220px] flex-1">
                        <select name="nama_reminder" class="w-full h-11 px-3 rounded-xl bg-slate-50 border border-slate-200 text-xs font-medium text-slate-700 focus:bg-white focus:border-[#2E7D32] focus:ring-[#2E7D32] cursor-pointer">
                            <option value="">Semua Sasaran Pasien / Reminder</option>
                            @foreach($allReminders as $reminderOption)
                                <option value="{{ $reminderOption->nama_pasien }}" {{ request('nama_reminder') == $reminderOption->nama_pasien ? 'selected' : '' }}>
                                    {{ $reminderOption->nama_pasien }} ({{ $reminderOption->jadwal ?? 'Bulanan' }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Filter Tanggal -->
                    <div class="w-48">
                        <input type="date" 
                            name="tanggal" 
                            value="{{ request('tanggal') }}" 
                            class="w-full h-11 px-3 rounded-xl bg-slate-50 border border-slate-200 text-xs text-slate-700 focus:bg-white focus:border-[#2E7D32] focus:ring-[#2E7D32]">
                    </div>

                    <!-- Filter Status -->
                    <div class="w-36">
                        <select name="status" class="w-full h-11 px-3 rounded-xl bg-slate-50 border border-slate-200 text-xs font-medium text-slate-700 focus:bg-white focus:border-[#2E7D32] focus:ring-[#2E7D32] cursor-pointer">
                            <option value="">Semua Status</option>
                            <option value="berhasil" {{ request('status') === 'berhasil' ? 'selected' : '' }}>Berhasil</option>
                            <option value="gagal" {{ request('status') === 'gagal' ? 'selected' : '' }}>Gagal</option>
                            <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending</option>
                        </select>
                    </div>
                </div>

                <div class="flex items-center gap-2">
                    <button type="submit" class="h-11 px-5 rounded-xl bg-slate-800 text-white text-xs font-semibold hover:bg-slate-900 transition-colors flex items-center gap-1.5 shadow-sm">
                        <span class="material-symbols-outlined text-[16px]">filter_list</span>
                        <span>Filter</span>
                    </button>

                    @if(request()->anyFilled(['nama_reminder', 'tanggal', 'status']))
                        <a href="{{ route('admin.reminders.logs') }}" class="h-11 px-3 rounded-xl border border-slate-200 text-xs font-medium text-slate-500 hover:text-slate-800 hover:bg-slate-50 flex items-center transition-colors">
                            Reset
                        </a>
                    @endif
                </div>
            </form>
        </div>

        <!-- Tabel Log Transmisi Pesan -->
        <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm overflow-hidden flex flex-col">
            <div class="overflow-x-auto w-full">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50/80 border-b border-slate-200 text-slate-500 text-xs uppercase tracking-wider font-semibold">
                            <th class="py-4 px-4 w-12 text-center">ID</th>
                            <th class="py-4 px-4">Pasien &amp; Nomor WA</th>
                            <th class="py-4 px-3">Klaster ILP</th>
                            <th class="py-4 px-3">Waktu Transmisi</th>
                            <th class="py-4 px-4 min-w-[260px]">Teks Pesan Terkirim</th>
                            <th class="py-4 px-3 text-center">Status</th>
                            <th class="py-4 px-4">Keterangan Gateway</th>
                            <th class="py-4 px-4 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-sm">
                        @forelse($logs as $log)
                            <tr class="transition-colors group {{ $log->status === 'gagal' ? 'bg-rose-50/70 border-l-4 border-l-rose-500 text-rose-950 hover:bg-rose-100/50' : 'hover:bg-slate-50/70' }}">
                                <td class="py-4 px-4 text-center text-xs font-mono text-slate-400">
                                    #{{ $log->id }}
                                </td>

                                <td class="py-4 px-4 font-bold text-slate-800 whitespace-nowrap">
                                    <div>{{ $log->reminder->nama_pasien ?? 'Pasien Anonim' }}</div>
                                    <div class="text-[11px] font-mono text-slate-400 font-normal">
                                        {{ $log->reminder->nomor_wa ?? '-' }}
                                    </div>
                                </td>

                                <td class="py-4 px-3 whitespace-nowrap">
                                    @if($log->reminder && $log->reminder->klaster)
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-slate-100 text-slate-700 border border-slate-200">
                                            {{ $log->reminder->klaster->nama }}
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-slate-50 text-slate-400">
                                            Umum
                                        </span>
                                    @endif
                                </td>

                                <td class="py-4 px-3 whitespace-nowrap text-xs text-slate-600">
                                    <div>{{ $log->waktu_kirim ? $log->waktu_kirim->format('d M Y') : '-' }}</div>
                                    <div class="text-[11px] text-slate-400 font-mono">{{ $log->waktu_kirim ? $log->waktu_kirim->format('H:i:s') . ' WIB' : '-' }}</div>
                                </td>

                                <td class="py-4 px-4 text-xs text-slate-600 max-w-sm">
                                    <div class="p-2 rounded-xl {{ $log->status === 'gagal' ? 'bg-white/80 border border-rose-200' : 'bg-slate-50 border border-slate-100' }} line-clamp-2">
                                        {{ $log->pesan_terkirim }}
                                    </div>
                                </td>

                                <!-- Status Badge: Hijau "Berhasil", Merah "Gagal" -->
                                <td class="py-4 px-3 text-center whitespace-nowrap">
                                    @if($log->status === 'berhasil')
                                        <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-semibold bg-emerald-100 text-emerald-800 border border-emerald-200">
                                            <span class="w-1.5 h-1.5 rounded-full bg-[#2E7D32]"></span>
                                            Berhasil
                                        </span>
                                    @elseif($log->status === 'gagal')
                                        <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-semibold bg-rose-200 text-rose-800 border border-rose-300">
                                            <span class="w-1.5 h-1.5 rounded-full bg-rose-600"></span>
                                            Gagal
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-semibold bg-slate-100 text-slate-600 border border-slate-200">
                                            Pending
                                        </span>
                                    @endif
                                </td>

                                <td class="py-4 px-4 text-xs font-mono {{ $log->status === 'gagal' ? 'text-rose-700 font-semibold' : 'text-slate-500' }} max-w-xs truncate">
                                    {{ $log->keterangan ?? '-' }}
                                </td>

                                <td class="py-4 px-4 text-right whitespace-nowrap">
                                    @if($log->status === 'gagal')
                                        <!-- Tombol Kirim Ulang -->
                                        <form action="{{ route('admin.reminders.retry', $log->id) }}" method="POST" class="inline-block">
                                            @csrf
                                            <button type="submit" 
                                                    class="inline-flex items-center gap-1 px-3 py-1.5 rounded-xl bg-rose-600 hover:bg-rose-700 text-white text-xs font-semibold shadow-sm transition-all"
                                                    title="Kirim ulang pesan ke nomor pasien">
                                                <span class="material-symbols-outlined text-[15px]">refresh</span>
                                                <span>Kirim Ulang</span>
                                            </button>
                                        </form>
                                    @else
                                        <span class="text-xs text-slate-300 font-mono">Terkirim</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="py-10 px-6 text-center text-slate-400">
                                    Belum ada catatan riwayat pengiriman pesan WhatsApp.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($logs->hasPages())
                <div class="p-4 border-t border-slate-100 bg-slate-50/50">
                    {{ $logs->links() }}
                </div>
            @endif
        </div>
    </div>
</x-admin-layout>
