<x-admin-layout title="Dashboard Utama CMS">
    <div class="flex flex-col gap-6">

        <!-- HEADER BANNER: Sambutan & Ringkasan Status Sistem -->
        <section class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4 bg-white p-6 rounded-2xl border border-slate-200/80 shadow-xs">
            <div class="flex flex-col gap-2">
                <div class="inline-flex items-center gap-1.5 text-[#2E7D32] font-bold text-xs tracking-wider uppercase">
                    <span class="material-symbols-outlined text-[18px]">verified</span>
                    <span>UPTD PUSKESMAS CILIMUS • PORTAL MANAJEMEN TERINTEGRASI</span>
                </div>
                <h1 class="text-2xl lg:text-3xl font-extrabold text-slate-900 tracking-tight">Dashboard Utama CMS</h1>
                <p class="text-slate-600 text-sm max-w-2xl">
                    Selamat datang kembali, <strong>{{ auth()->user()->nama_lengkap ?? 'Administrator' }}</strong>. Berikut ringkasan kinerja publikasi informasi, otomasi reminder WhatsApp, dan kotak saran masyarakat hari ini.
                </p>
                <div class="flex flex-wrap items-center gap-2 pt-1 text-xs font-medium text-slate-500">
                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md bg-slate-100 text-slate-700">
                        <span class="material-symbols-outlined text-[15px] text-slate-500">calendar_month</span>
                        <span>{{ now()->translatedFormat('l, d F Y') }}</span>
                    </span>
                    <span class="text-slate-300">•</span>
                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md bg-emerald-50 text-emerald-700 font-semibold border border-emerald-100">
                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-ping"></span>
                        <span>Sistem Online • Status Aktif</span>
                    </span>
                    <span class="text-slate-300">•</span>
                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md bg-blue-50 text-blue-700 font-semibold border border-blue-100">
                        <span class="material-symbols-outlined text-[15px] text-blue-600">hub</span>
                        <span>Standar ILP Kemenkes RI</span>
                    </span>
                </div>
            </div>

            <!-- Tombol Aksi Cepat Header -->
            <div class="flex flex-wrap items-center gap-3 self-start lg:self-center">
                <a href="{{ route('admin.reminders.patients') }}" 
                   class="border-2 border-[#2E7D32] text-[#2E7D32] hover:bg-emerald-50 font-semibold text-xs sm:text-sm px-4 py-2.5 rounded-xl flex items-center gap-2 transition-all shadow-xs">
                    <span class="material-symbols-outlined text-[18px]">chat</span>
                    <span>Kelola Reminder Pasien</span>
                </a>
                <a href="{{ route('admin.posts.create') }}" 
                   class="bg-[#2E7D32] hover:bg-[#1B5E20] text-white font-semibold text-xs sm:text-sm px-4 py-2.5 rounded-xl shadow-xs flex items-center gap-2 transition-all">
                    <span class="material-symbols-outlined text-[18px]">add_circle</span>
                    <span>+ Buat Informasi Baru</span>
                </a>
            </div>
        </section>

        <!-- SEKSI 1: 4 METRIC CARDS RESPONSIF -->
        <section class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-5">
            <!-- Card 1: Total Post Terbit (Aksen Hijau) -->
            <div class="bg-emerald-50 border border-emerald-200 text-emerald-800 p-5 rounded-2xl shadow-xs flex flex-col justify-between hover:shadow-md transition-all">
                <div class="flex items-start justify-between">
                    <div class="w-12 h-12 rounded-xl bg-white flex items-center justify-center text-[#2E7D32] shadow-xs border border-emerald-200">
                        <span class="material-symbols-outlined text-[26px]">newspaper</span>
                    </div>
                    <span class="px-2.5 py-0.5 rounded-full bg-emerald-200/80 text-emerald-900 text-xs font-bold">
                        Publikasi
                    </span>
                </div>
                <div class="mt-4">
                    <span class="text-xs font-semibold uppercase tracking-wider text-emerald-700">Total Post Terbit</span>
                    <div class="text-3xl font-extrabold text-slate-900 mt-1">{{ $totalPost }}</div>
                </div>
                <div class="mt-3 pt-2.5 border-t border-emerald-200/60 text-xs text-emerald-700 font-medium">
                    Laporan · Berita · Agenda
                </div>
            </div>

            <!-- Card 2: Pasien Reminder (Aksen Biru) -->
            <div class="bg-blue-50 border border-blue-200 text-blue-800 p-5 rounded-2xl shadow-xs flex flex-col justify-between hover:shadow-md transition-all">
                <div class="flex items-start justify-between">
                    <div class="w-12 h-12 rounded-xl bg-white flex items-center justify-center text-blue-600 shadow-xs border border-blue-200">
                        <span class="material-symbols-outlined text-[26px]">group</span>
                    </div>
                    <span class="px-2.5 py-0.5 rounded-full bg-blue-200/80 text-blue-900 text-xs font-bold">
                        Otomasi WA
                    </span>
                </div>
                <div class="mt-4">
                    <span class="text-xs font-semibold uppercase tracking-wider text-blue-700">Pasien Reminder</span>
                    <div class="text-3xl font-extrabold text-slate-900 mt-1">{{ $totalPasienReminder }}</div>
                </div>
                <div class="mt-3 pt-2.5 border-t border-blue-200/60 text-xs text-blue-700 font-medium flex items-center gap-1.5">
                    <span>Sasaran Aktif Terdaftar</span>
                </div>
            </div>

            <!-- Card 3: WA Berhasil Terkirim (Aksen Hijau) -->
            <div class="bg-green-50 border border-green-200 text-green-800 p-5 rounded-2xl shadow-xs flex flex-col justify-between hover:shadow-md transition-all">
                <div class="flex items-start justify-between">
                    <div class="w-12 h-12 rounded-xl bg-white flex items-center justify-center text-green-600 shadow-xs border border-green-200">
                        <span class="material-symbols-outlined text-[26px]">send</span>
                    </div>
                    <span class="px-2.5 py-0.5 rounded-full bg-green-200/80 text-green-900 text-xs font-bold inline-flex items-center gap-0.5">
                        <span class="material-symbols-outlined text-[14px]">check_circle</span> Sukses
                    </span>
                </div>
                <div class="mt-4">
                    <span class="text-xs font-semibold uppercase tracking-wider text-green-700">WA Berhasil Terkirim</span>
                    <div class="text-3xl font-extrabold text-slate-900 mt-1">{{ $totalWaBerhasil }}</div>
                </div>
                <div class="mt-3 pt-2.5 border-t border-green-200/60 text-xs text-green-700 font-medium">
                    Terkirim Sukses via Gateway
                </div>
            </div>

            <!-- Card 4: Saran Belum Dibaca (Aksen Oranye) -->
            <div class="bg-orange-50 border border-orange-200 text-orange-800 p-5 rounded-2xl shadow-xs flex flex-col justify-between hover:shadow-md transition-all">
                <div class="flex items-start justify-between">
                    <div class="w-12 h-12 rounded-xl bg-white flex items-center justify-center text-orange-600 shadow-xs border border-orange-200">
                        <span class="material-symbols-outlined text-[26px]">mark_email_unread</span>
                    </div>
                    @if($totalSaranBelumDibaca > 0)
                        <span class="px-2.5 py-0.5 rounded-full bg-rose-500 text-white text-xs font-bold animate-pulse">
                            Penting
                        </span>
                    @else
                        <span class="px-2.5 py-0.5 rounded-full bg-orange-200/80 text-orange-900 text-xs font-bold">
                            Nihil
                        </span>
                    @endif
                </div>
                <div class="mt-4">
                    <span class="text-xs font-semibold uppercase tracking-wider text-orange-700">Saran Belum Dibaca</span>
                    <div class="text-3xl font-extrabold text-slate-900 mt-1 flex items-baseline gap-2">
                        <span class="{{ $totalSaranBelumDibaca > 0 ? 'text-rose-600' : 'text-slate-900' }}">{{ $totalSaranBelumDibaca }}</span>
                        <span class="text-xs font-normal text-slate-500">masukan baru</span>
                    </div>
                </div>
                <div class="mt-3 pt-2.5 border-t border-orange-200/60 text-xs text-orange-700 font-medium flex items-center justify-between">
                    <span>Menunggu Tindak Lanjut</span>
                    <a href="{{ route('admin.saran.index') }}" class="text-[#2E7D32] font-semibold hover:underline">Buka Kotak Saran →</a>
                </div>
            </div>
        </section>

        <!-- SEKSI 2: GRID 2 KOLOM (Konten Terbaru & Saran Terkini) -->
        <section class="grid grid-cols-1 xl:grid-cols-12 gap-6 items-start">

            <!-- Kolom Kiri: Tabel Konten Terbaru (approx 7 cols) -->
            <div class="xl:col-span-7 bg-white p-6 rounded-2xl border border-slate-200/80 shadow-xs flex flex-col gap-4">
                <div class="flex items-center justify-between pb-2 border-b border-slate-100">
                    <div>
                        <h2 class="text-base lg:text-lg font-bold text-slate-900">Konten Terbaru</h2>
                        <p class="text-xs text-slate-500 mt-0.5">5 publikasi artikel, warta, laporan akuntabilitas, dan agenda terakhir</p>
                    </div>
                    <div class="flex items-center gap-2">
                        <a href="{{ route('admin.posts.index') }}" 
                           class="px-3 py-1.5 rounded-lg border border-slate-200 text-xs font-semibold text-slate-700 hover:bg-slate-50 transition-colors">
                            Lihat Semua
                        </a>
                        <a href="{{ route('admin.posts.create') }}" 
                           class="px-3 py-1.5 rounded-lg bg-[#2E7D32] hover:bg-[#1B5E20] text-white text-xs font-semibold flex items-center gap-1 transition-colors shadow-xs">
                            <span class="material-symbols-outlined text-[16px]">add</span>
                            <span>Tambah</span>
                        </a>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm">
                        <thead>
                            <tr class="bg-slate-50 text-slate-500 text-xs font-semibold uppercase tracking-wider">
                                <th class="py-2.5 px-3 rounded-l-lg w-16" scope="col">Thumbnail</th>
                                <th class="py-2.5 px-3" scope="col">Judul Post</th>
                                <th class="py-2.5 px-2" scope="col">Tipe</th>
                                <th class="py-2.5 px-2" scope="col">Status</th>
                                <th class="py-2.5 px-3" scope="col">Tanggal</th>
                                <th class="py-2.5 px-3 rounded-r-lg text-right" scope="col">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 text-slate-700">
                            @forelse($kontenTerbaru as $post)
                                <tr class="hover:bg-slate-50/80 transition-colors">
                                    <!-- Kolom Thumbnail (56x40px) -->
                                    <td class="py-3 px-3">
                                        <div class="w-14 h-10 rounded-lg bg-emerald-50 border border-emerald-100 flex items-center justify-center text-emerald-700 font-bold overflow-hidden flex-shrink-0 shadow-2xs">
                                            @if($post->foto_thumbnail)
                                                <img src="{{ asset($post->foto_thumbnail) }}" alt="{{ $post->judul }}" class="w-full h-full object-cover">
                                            @else
                                                <span class="material-symbols-outlined text-[20px]">
                                                    {{ $post->tipe === 'laporan' ? 'analytics' : ($post->tipe === 'agenda' ? 'event' : 'newspaper') }}
                                                </span>
                                            @endif
                                        </div>
                                    </td>

                                    <!-- Kolom Judul Post -->
                                    <td class="py-3 px-3">
                                        <div class="flex flex-col min-w-0">
                                            <a href="{{ route('admin.posts.edit', $post) }}" class="font-semibold text-slate-900 hover:text-[#2E7D32] transition-colors leading-snug line-clamp-1" title="{{ $post->judul }}">
                                                {{ $post->judul }}
                                            </a>
                                            <span class="text-xs text-slate-400 mt-0.5">
                                                Penulis: {{ $post->author->nama_lengkap ?? 'Administrator' }}
                                            </span>
                                        </div>
                                    </td>

                                    <!-- Kolom Tipe Badge -->
                                    <td class="py-3 px-2 whitespace-nowrap">
                                        @if($post->tipe === 'laporan')
                                            <span class="px-2.5 py-0.5 rounded-full bg-emerald-50 text-[#15803D] border border-emerald-200 font-bold text-xs uppercase">
                                                Laporan
                                            </span>
                                        @elseif($post->tipe === 'agenda')
                                            <span class="px-2.5 py-0.5 rounded-full bg-orange-50 text-[#EA580C] border border-orange-200 font-bold text-xs uppercase">
                                                Agenda
                                            </span>
                                        @else
                                            <span class="px-2.5 py-0.5 rounded-full bg-blue-50 text-[#1D4ED8] border border-blue-200 font-bold text-xs uppercase">
                                                Berita
                                            </span>
                                        @endif
                                    </td>

                                    <!-- Kolom Status Badge -->
                                    <td class="py-3 px-2 whitespace-nowrap">
                                        @if($post->status === 'published')
                                            <span class="px-2 py-0.5 rounded-md bg-emerald-100 text-emerald-800 text-xs font-semibold">
                                                Published
                                            </span>
                                        @else
                                            <span class="px-2 py-0.5 rounded-md bg-slate-100 text-slate-600 text-xs font-medium">
                                                Draft
                                            </span>
                                        @endif
                                    </td>

                                    <!-- Kolom Tanggal -->
                                    <td class="py-3 px-3 whitespace-nowrap text-xs text-slate-500">
                                        {{ $post->created_at ? $post->created_at->format('d M Y') : '-' }}
                                    </td>

                                    <!-- Kolom Aksi Edit -->
                                    <td class="py-3 px-3 text-right whitespace-nowrap">
                                        <a href="{{ route('admin.posts.edit', $post) }}" 
                                           class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg text-xs font-semibold text-[#2E7D32] hover:bg-emerald-50 transition-colors">
                                            <span class="material-symbols-outlined text-[15px]">edit</span>
                                            <span>Edit</span>
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="py-8 text-center text-slate-400 text-sm">
                                        Belum ada konten publikasi yang dibuat.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Kolom Kanan: Tabel Saran Terkini (approx 5 cols) -->
            <div class="xl:col-span-5 bg-white p-6 rounded-2xl border border-slate-200/80 shadow-xs flex flex-col gap-4">
                <div class="flex items-center justify-between pb-2 border-b border-slate-100">
                    <div class="flex items-center gap-2">
                        <h2 class="text-base lg:text-lg font-bold text-slate-900">Saran Terkini</h2>
                        @if($totalSaranBelumDibaca > 0)
                            <span class="px-2 py-0.5 rounded-full bg-rose-500 text-white font-bold text-xs shadow-2xs">
                                {{ $totalSaranBelumDibaca }} Baru
                            </span>
                        @endif
                    </div>
                    <a href="{{ route('admin.saran.index') }}" class="text-xs font-semibold text-[#2E7D32] hover:underline flex items-center gap-1">
                        <span>Kotak Masuk</span>
                        <span class="material-symbols-outlined text-[14px]">arrow_forward</span>
                    </a>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm">
                        <thead>
                            <tr class="bg-slate-50 text-slate-500 text-xs font-semibold uppercase tracking-wider">
                                <th class="py-2.5 px-3 rounded-l-lg" scope="col">Nama Pengirim</th>
                                <th class="py-2.5 px-2" scope="col">Klaster</th>
                                <th class="py-2.5 px-2" scope="col">Waktu Masuk</th>
                                <th class="py-2.5 px-3 rounded-r-lg text-right" scope="col">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 text-slate-700">
                            @forelse($saranTerkini as $saran)
                                <tr class="hover:bg-slate-50/80 transition-colors">
                                    <td class="py-3 px-3">
                                        <div class="flex items-center gap-2">
                                            <span class="w-2 h-2 rounded-full bg-rose-500 flex-shrink-0 animate-ping"></span>
                                            <div class="flex flex-col min-w-0">
                                                <a href="{{ route('admin.saran.show', $saran) }}" class="font-semibold text-slate-900 hover:text-[#2E7D32] transition-colors leading-tight line-clamp-1" title="{{ $saran->nama_pengirim }}">
                                                    {{ $saran->nama_pengirim }}
                                                </a>
                                                <span class="text-[11px] text-slate-400 truncate max-w-[140px]">{{ $saran->subjek }}</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="py-3 px-2 text-xs font-medium text-slate-600 whitespace-nowrap">
                                        {{ $saran->klaster->nama ?? 'Umum' }}
                                    </td>
                                    <td class="py-3 px-2 text-xs text-slate-500 whitespace-nowrap">
                                        {{ $saran->created_at ? $saran->created_at->diffForHumans() : '-' }}
                                    </td>
                                    <td class="py-3 px-3 text-right whitespace-nowrap">
                                        <span class="bg-red-100 text-red-700 font-bold text-xs px-2.5 py-0.5 rounded-full">
                                            Baru
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="py-8 text-center text-slate-400 text-sm">
                                        Tidak ada pesan saran baru yang belum dibaca.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </section>

        <!-- SEKSI 3: TABEL LOG REMINDER TERAKHIR -->
        <section class="bg-white p-6 rounded-2xl border border-slate-200/80 shadow-xs flex flex-col gap-4">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 pb-2 border-b border-slate-100">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-emerald-50 border border-emerald-100 flex items-center justify-center text-[#2E7D32]">
                        <span class="material-symbols-outlined text-[24px]">history</span>
                    </div>
                    <div>
                        <h2 class="text-base lg:text-lg font-bold text-slate-900">Log Reminder Terakhir</h2>
                        <p class="text-xs text-slate-500">Notifikasi otomatis, broadcast jadwal kontrol, dan pesan pengingat kesehatan</p>
                    </div>
                </div>

                <div class="flex items-center gap-3">
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-emerald-50 text-emerald-700 border border-emerald-200 text-xs font-semibold">
                        <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                        <span>WhatsApp Blast Gateway: Aktif</span>
                    </span>
                    <a href="{{ route('admin.reminders.logs') }}" class="text-xs font-semibold text-[#2E7D32] hover:underline flex items-center gap-1">
                        <span>Lihat Semua Log</span>
                        <span class="material-symbols-outlined text-[14px]">arrow_forward</span>
                    </a>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm">
                    <thead>
                        <tr class="bg-slate-50 text-slate-500 text-xs font-semibold uppercase tracking-wider">
                            <th class="py-2.5 px-4 rounded-l-lg" scope="col">Waktu Kirim</th>
                            <th class="py-2.5 px-4" scope="col">Nama Pasien</th>
                            <th class="py-2.5 px-3" scope="col">No WA</th>
                            <th class="py-2.5 px-3" scope="col">Status</th>
                            <th class="py-2.5 px-4" scope="col">Keterangan / Pesan Terkirim</th>
                            <th class="py-2.5 px-4 rounded-r-lg text-right" scope="col">Rincian</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-slate-700">
                        @forelse($logReminderTerakhir as $log)
                            <tr class="hover:bg-slate-50/80 transition-colors">
                                <!-- Waktu Kirim -->
                                <td class="py-3 px-4 whitespace-nowrap text-xs text-slate-600 font-medium">
                                    {{ $log->waktu_kirim ? $log->waktu_kirim->format('d M Y H:i') : ($log->created_at ? $log->created_at->format('d M Y H:i') : '-') }} WIB
                                </td>

                                <!-- Nama Pasien -->
                                <td class="py-3 px-4 whitespace-nowrap font-semibold text-slate-900">
                                    {{ $log->reminder->nama_pasien ?? 'Pasien Puskesmas' }}
                                </td>

                                <!-- No WA -->
                                <td class="py-3 px-3 whitespace-nowrap font-mono text-xs text-slate-600">
                                    {{ $log->reminder->nomor_wa ?? '-' }}
                                </td>

                                <!-- Status Badge -->
                                <td class="py-3 px-3 whitespace-nowrap">
                                    @if($log->status === 'berhasil')
                                        <span class="px-2.5 py-0.5 rounded-full bg-emerald-100 text-emerald-800 text-xs font-bold inline-flex items-center gap-1">
                                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-600"></span> Berhasil
                                        </span>
                                    @elseif($log->status === 'gagal')
                                        <span class="px-2.5 py-0.5 rounded-full bg-rose-100 text-rose-800 text-xs font-bold inline-flex items-center gap-1">
                                            <span class="w-1.5 h-1.5 rounded-full bg-rose-600"></span> Gagal
                                        </span>
                                    @else
                                        <span class="px-2.5 py-0.5 rounded-full bg-amber-100 text-amber-800 text-xs font-bold inline-flex items-center gap-1">
                                            <span class="w-1.5 h-1.5 rounded-full bg-amber-600"></span> Pending
                                        </span>
                                    @endif
                                </td>

                                <!-- Keterangan / Pesan Terkirim -->
                                <td class="py-3 px-4 text-xs text-slate-500 max-w-xs truncate" title="{{ $log->pesan_terkirim ?? $log->keterangan }}">
                                    {{ $log->keterangan ?? \Illuminate\Support\Str::limit($log->pesan_terkirim, 45) }}
                                </td>

                                <!-- Rincian Tombol -->
                                <td class="py-3 px-4 text-right whitespace-nowrap">
                                    <a href="{{ route('admin.reminders.logs') }}" 
                                       class="inline-flex items-center gap-1 px-3 py-1.5 rounded-lg border border-slate-200 text-xs font-semibold text-slate-700 hover:bg-slate-50 hover:text-[#2E7D32] transition-colors">
                                        <span class="material-symbols-outlined text-[15px]">visibility</span>
                                        <span>Rincian</span>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="py-8 text-center text-slate-400 text-sm">
                                    Belum ada catatan log transmisi pesan reminder WhatsApp.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </section>

    </div>
</x-admin-layout>
