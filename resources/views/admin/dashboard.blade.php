@extends('layouts.admin')

@section('content')
<div class="space-y-8">
    <!-- Welcome Banner -->
    <div class="relative overflow-hidden rounded-2xl bg-gradient-to-r from-emerald-800 to-teal-700 p-8 text-white shadow-lg">
        <div class="relative z-10 max-w-2xl">
            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-emerald-500/30 text-emerald-100 border border-emerald-400/30 mb-3">
                Integrasi Pelayanan Primer (ILP) Kemenkes RI
            </span>
            <h1 class="text-2xl sm:text-3xl font-extrabold tracking-tight">Selamat Datang, {{ auth()->user()->nama_lengkap }}!</h1>
            <p class="mt-2 text-sm text-emerald-100 leading-relaxed">
                Anda masuk sebagai <strong class="text-white">{{ strtoupper(auth()->user()->peran) }}</strong>. Gunakan panel ini untuk memantau data operasional puskesmas, moderasi saran warga, dan otomasi reminder kesehatan.
            </p>
        </div>
        <div class="absolute -right-10 -bottom-10 w-64 h-64 rounded-full bg-emerald-600/20 blur-2xl"></div>
    </div>

    <!-- Stat Cards Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-6 gap-4">
        <!-- Klaster ILP -->
        <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-sm hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between">
                <span class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Klaster ILP</span>
                <span class="w-8 h-8 rounded-lg bg-emerald-50 text-emerald-600 flex items-center justify-center font-bold text-sm">🏛</span>
            </div>
            <div class="mt-3 flex items-baseline justify-between">
                <span class="text-2xl font-extrabold text-slate-800">{{ $totalKlaster }}</span>
                <span class="text-xs text-slate-400">5 Siklus Hidup</span>
            </div>
        </div>

        <!-- Layanan Aktif -->
        <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-sm hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between">
                <span class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Poliklinik</span>
                <span class="w-8 h-8 rounded-lg bg-teal-50 text-teal-600 flex items-center justify-center font-bold text-sm">🏥</span>
            </div>
            <div class="mt-3 flex items-baseline justify-between">
                <span class="text-2xl font-extrabold text-slate-800">{{ $totalLayanan }}</span>
                <span class="text-xs text-teal-600 font-medium">Aktif Layani</span>
            </div>
        </div>

        <!-- Postingan Publikasi -->
        <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-sm hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between">
                <span class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Informasi</span>
                <span class="w-8 h-8 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center font-bold text-sm">📰</span>
            </div>
            <div class="mt-3 flex items-baseline justify-between">
                <span class="text-2xl font-extrabold text-slate-800">{{ $totalPosts }}</span>
                <span class="text-xs text-slate-400">Published</span>
            </div>
        </div>

        <!-- Kotak Saran Baru -->
        <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-sm hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between">
                <span class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Saran Masuk</span>
                <span class="w-8 h-8 rounded-lg bg-amber-50 text-amber-600 flex items-center justify-center font-bold text-sm">📬</span>
            </div>
            <div class="mt-3 flex items-baseline justify-between">
                <span class="text-2xl font-extrabold text-slate-800">{{ $totalSaranBaru }}</span>
                <span class="text-xs text-amber-600 font-semibold">Belum Dibaca</span>
            </div>
        </div>

        <!-- Pasien Reminder -->
        <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-sm hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between">
                <span class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Reminder WA</span>
                <span class="w-8 h-8 rounded-lg bg-indigo-50 text-indigo-600 flex items-center justify-center font-bold text-sm">💬</span>
            </div>
            <div class="mt-3 flex items-baseline justify-between">
                <span class="text-2xl font-extrabold text-slate-800">{{ $totalPasienReminder }}</span>
                <span class="text-xs text-slate-400">Sasaran Pasien</span>
            </div>
        </div>

        <!-- Blast Terkirim -->
        <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-sm hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between">
                <span class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Kirim Sukses</span>
                <span class="w-8 h-8 rounded-lg bg-emerald-50 text-emerald-600 flex items-center justify-center font-bold text-sm">✅</span>
            </div>
            <div class="mt-3 flex items-baseline justify-between">
                <span class="text-2xl font-extrabold text-slate-800">{{ $totalLogsBerhasil }}</span>
                <span class="text-xs text-emerald-600 font-semibold">Terkirim</span>
            </div>
        </div>
    </div>

    <!-- Main 2-Column Section -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- Kotak Saran Warga Terkini -->
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
            <div class="p-6 border-b border-slate-100 flex items-center justify-between">
                <div>
                    <h3 class="font-bold text-slate-800 text-base">Kotak Saran Warga Terkini</h3>
                    <p class="text-xs text-slate-500 mt-0.5">Umpan balik masyarakat melalui formulir portal</p>
                </div>
                <a href="{{ route('admin.saran.index') }}" class="text-xs font-semibold text-emerald-600 hover:text-emerald-700">Lihat Semua →</a>
            </div>
            <div class="divide-y divide-slate-100">
                @forelse($recentFeedbacks as $feedback)
                    <div class="p-5 hover:bg-slate-50 transition-colors">
                        <div class="flex items-start justify-between">
                            <div>
                                <span class="font-semibold text-sm text-slate-800">{{ $feedback->nama_pengirim }}</span>
                                <span class="text-xs text-slate-400 ml-2 font-mono">({{ $feedback->kontak }})</span>
                            </div>
                            <span class="inline-flex items-center px-2 py-0.5 rounded text-[11px] font-semibold {{ $feedback->status === 'baru' ? 'bg-amber-100 text-amber-800' : ($feedback->status === 'selesai' ? 'bg-emerald-100 text-emerald-800' : 'bg-slate-100 text-slate-700') }}">
                                {{ ucfirst($feedback->status) }}
                            </span>
                        </div>
                        <h4 class="text-xs font-semibold text-slate-700 mt-1">{{ $feedback->subjek }}</h4>
                        <p class="text-xs text-slate-600 mt-1 line-clamp-2 leading-relaxed">{{ $feedback->isi_pesan }}</p>
                        <div class="mt-2.5 flex items-center justify-between text-[11px] text-slate-400">
                            <span>Klaster: {{ $feedback->klaster->nama ?? 'Umum / Lainnya' }}</span>
                            <span>{{ $feedback->created_at->diffForHumans() }}</span>
                        </div>
                    </div>
                @empty
                    <div class="p-8 text-center text-sm text-slate-400">Belum ada pesan saran masuk dari masyarakat.</div>
                @endforelse
            </div>
        </div>

        <!-- Log Pengiriman Reminder WhatsApp -->
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
            <div class="p-6 border-b border-slate-100 flex items-center justify-between">
                <div>
                    <h3 class="font-bold text-slate-800 text-base">Riwayat Transmisi WhatsApp</h3>
                    <p class="text-xs text-slate-500 mt-0.5">Log eksekusi cron scheduler dan gateway status</p>
                </div>
                <a href="{{ route('admin.reminders.logs') }}" class="text-xs font-semibold text-emerald-600 hover:text-emerald-700">Lihat Semua →</a>
            </div>
            <div class="divide-y divide-slate-100">
                @forelse($recentLogs as $log)
                    <div class="p-5 hover:bg-slate-50 transition-colors">
                        <div class="flex items-start justify-between">
                            <div>
                                <span class="font-semibold text-sm text-slate-800">{{ $log->reminder->nama_pasien ?? 'Pasien' }}</span>
                                <span class="text-xs text-slate-400 ml-2 font-mono">{{ $log->reminder->nomor_wa ?? '-' }}</span>
                            </div>
                            <span class="inline-flex items-center px-2 py-0.5 rounded text-[11px] font-semibold {{ $log->status === 'berhasil' ? 'bg-emerald-100 text-emerald-800' : 'bg-rose-100 text-rose-800' }}">
                                {{ ucfirst($log->status) }}
                            </span>
                        </div>
                        <p class="text-xs text-slate-600 mt-1.5 italic bg-slate-50 p-2.5 rounded-lg border border-slate-100 line-clamp-2">
                            "{{ $log->pesan_terkirim ?? '-' }}"
                        </p>
                        <div class="mt-2.5 flex items-center justify-between text-[11px] text-slate-400">
                            <span>{{ $log->keterangan }}</span>
                            <span>{{ $log->waktu_kirim->isoFormat('D MMM Y, HH:mm') }}</span>
                        </div>
                    </div>
                @empty
                    <div class="p-8 text-center text-sm text-slate-400">Belum ada riwayat blast pesan WhatsApp.</div>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection
