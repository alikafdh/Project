<x-admin-layout title="Jadwal & Template Reminder">
    <div class="space-y-6" x-data="{
        templatePesan: 'Halo Ibu/Bpk {nama_pasien}, mengingatkan kembali jadwal kontrol / posyandu Anda di {nama_puskesmas} pada {tanggal}. Mohon hadir tepat waktu. Terima kasih.',
        insertToken(token) {
            const textarea = document.getElementById('template_pesan_input');
            if (textarea) {
                const start = textarea.selectionStart;
                const end = textarea.selectionEnd;
                const text = textarea.value;
                textarea.value = text.substring(0, start) + token + text.substring(end);
                this.templatePesan = textarea.value;
                textarea.focus();
                textarea.setSelectionRange(start + token.length, start + token.length);
            } else {
                this.templatePesan += ' ' + token;
            }
        },
        testModalOpen: false,
        testReminderId: '',
        testPhone: '',
        testPesan: '',
        openTestModal(reminder) {
            this.testReminderId = reminder.id;
            this.testPhone = reminder.nomor_wa;
            this.testPesan = reminder.template_pesan;
            this.testModalOpen = true;
        }
    }">
        <!-- Sub-Tabs Horizontal Navigation Bar -->
        <div class="flex items-center justify-between flex-wrap gap-4">
            <x-admin.reminder-nav active="schedules" />

            <a href="#form-buat-jadwal" 
               class="h-11 px-5 rounded-xl text-white font-bold text-xs flex items-center gap-2 shadow-sm transition-all hover:opacity-95" 
               style="background-color: #2E7D32;">
                <span class="material-symbols-outlined text-[18px]">add_circle</span>
                <span>+ Buat Jadwal Baru</span>
            </a>
        </div>

        <!-- Header Section -->
        <div class="space-y-1">
            <div class="flex items-center gap-1.5 text-xs text-slate-500 font-medium">
                <span>Admin Portal</span>
                <span class="material-symbols-outlined text-[14px]">chevron_right</span>
                <span>Kelola Reminder WhatsApp</span>
                <span class="material-symbols-outlined text-[14px]">chevron_right</span>
                <span class="text-[#2E7D32] font-semibold">Jadwal &amp; Template</span>
            </div>
            <h1 class="text-2xl font-bold text-slate-800 tracking-tight">Jadwal &amp; Template Reminder WhatsApp</h1>
            <p class="text-sm text-slate-500 max-w-3xl leading-relaxed">
                Kelola konfigurasi pengiriman pesan pengingat kesehatan berkala untuk skrining posyandu, kepatuhan minum obat TB-DOTS, kontrol Prolanis, serta imunisasi balita berdasarkan klaster Integrasi Layanan Primer (ILP).
            </p>
        </div>

        <!-- 4 Summary Metric Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-sm flex items-center justify-between">
                <div>
                    <span class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Total Jadwal Aktif</span>
                    <h3 class="text-2xl font-bold text-[#2E7D32] mt-1">{{ $totalSchedules }}</h3>
                    <p class="text-xs text-emerald-600 font-medium flex items-center gap-1 mt-0.5">
                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-600"></span> Automasi aktif harian
                    </p>
                </div>
                <div class="w-12 h-12 rounded-xl bg-emerald-50 flex items-center justify-center text-[#2E7D32]">
                    <span class="material-symbols-outlined text-[26px]">calendar_month</span>
                </div>
            </div>

            <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-sm flex items-center justify-between">
                <div>
                    <span class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Sasaran Pasien</span>
                    <h3 class="text-2xl font-bold text-slate-800 mt-1">{{ $totalPatients }}</h3>
                    <p class="text-xs text-slate-500 mt-0.5">Nomor WA terdaftar</p>
                </div>
                <div class="w-12 h-12 rounded-xl bg-slate-100 flex items-center justify-center text-slate-700">
                    <span class="material-symbols-outlined text-[26px]">groups</span>
                </div>
            </div>

            <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-sm flex items-center justify-between">
                <div>
                    <span class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Terkirim Bulan Ini</span>
                    <h3 class="text-2xl font-bold text-blue-700 mt-1">{{ $totalSentThisMonth }}</h3>
                    <p class="text-xs text-blue-600 font-medium flex items-center gap-1 mt-0.5">
                        <span class="material-symbols-outlined text-[14px]">mark_chat_read</span> Pesan berhasil
                    </p>
                </div>
                <div class="w-12 h-12 rounded-xl bg-blue-50 flex items-center justify-center text-blue-600">
                    <span class="material-symbols-outlined text-[26px]">forward_to_inbox</span>
                </div>
            </div>

            <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-sm flex items-center justify-between">
                <div>
                    <span class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Tingkat Keberhasilan</span>
                    <h3 class="text-2xl font-bold text-emerald-700 mt-1">{{ $successRate }}%</h3>
                    <p class="text-xs text-emerald-600 font-medium flex items-center gap-1 mt-0.5">
                        <span class="material-symbols-outlined text-[14px]">verified</span> Gateway stabil
                    </p>
                </div>
                <div class="w-12 h-12 rounded-xl bg-emerald-50 flex items-center justify-center text-emerald-600">
                    <span class="material-symbols-outlined text-[26px]">query_stats</span>
                </div>
            </div>
        </div>

        <!-- Section Tabel Jadwal Blast Pengingat -->
        <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm overflow-hidden flex flex-col">
            <div class="p-5 border-b border-slate-100 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <div>
                    <h2 class="text-base font-bold text-slate-800">Daftar Jadwal Pengiriman Aktif</h2>
                    <p class="text-xs text-slate-400 mt-0.5">Automasi pesan WhatsApp terjadwal via Cron Scheduler UPTD Puskesmas Cilimus.</p>
                </div>

                <!-- Filter search -->
                <form method="GET" action="{{ route('admin.reminders.schedules') }}" class="flex items-center gap-2">
                    <div class="relative w-48 sm:w-60">
                        <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-[18px]">search</span>
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama reminder / jadwal..." class="w-full h-10 pl-9 pr-3 rounded-xl bg-slate-50 border border-slate-200 text-xs focus:bg-white focus:border-[#2E7D32] focus:ring-[#2E7D32]">
                    </div>
                    <button type="submit" class="h-10 px-3 rounded-xl bg-slate-800 text-white text-xs font-semibold hover:bg-slate-900 transition-colors">
                        Filter
                    </button>
                    @if(request()->filled('search'))
                        <a href="{{ route('admin.reminders.schedules') }}" class="text-xs text-slate-400 hover:text-slate-600 underline">Reset</a>
                    @endif
                </form>
            </div>

            <div class="overflow-x-auto w-full">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50/80 border-b border-slate-200 text-slate-500 text-xs uppercase tracking-wider font-semibold">
                            <th class="py-4 px-4 w-12 text-center">#</th>
                            <th class="py-4 px-4">Nama Pengingat &amp; Pasien</th>
                            <th class="py-4 px-3">Target Klaster</th>
                            <th class="py-4 px-3">Frekuensi / Jadwal</th>
                            <th class="py-4 px-3">Jam Kirim</th>
                            <th class="py-4 px-4 min-w-[280px]">Preview Template WhatsApp</th>
                            <th class="py-4 px-3 text-center">Status</th>
                            <th class="py-4 px-4 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-sm">
                        @forelse($reminders as $index => $item)
                            <tr class="hover:bg-slate-50/70 transition-colors group">
                                <td class="py-4 px-4 text-center text-xs font-mono text-slate-400">
                                    {{ $reminders->firstItem() + $index }}
                                </td>

                                <td class="py-4 px-4 font-bold text-slate-800 whitespace-nowrap">
                                    <div class="text-slate-800">{{ $item->nama_pasien }}</div>
                                    <div class="text-[11px] font-mono text-slate-400 font-normal">{{ $item->nomor_wa }}</div>
                                </td>

                                <td class="py-4 px-3 whitespace-nowrap">
                                    @if($item->klaster)
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-slate-100 text-slate-700 border border-slate-200">
                                            {{ $item->klaster->nama }}
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-slate-50 text-slate-400">
                                            Umum
                                        </span>
                                    @endif
                                </td>

                                <td class="py-4 px-3 whitespace-nowrap text-xs text-slate-700">
                                    <div class="font-semibold text-[#2E7D32]">{{ $item->jadwal ?? 'Bulanan' }}</div>
                                    <div class="text-[11px] text-slate-400 uppercase tracking-wider">{{ $item->tipe_interval }}</div>
                                </td>

                                <td class="py-4 px-3 whitespace-nowrap text-xs font-mono text-slate-600">
                                    {{ $item->jam_kirim ? substr($item->jam_kirim, 0, 5) : '08:00' }} WIB
                                </td>

                                <td class="py-4 px-4 text-xs text-slate-600 max-w-xs">
                                    <div class="p-2 rounded-xl bg-slate-50 border border-slate-100 line-clamp-2 font-sans">
                                        {{ $item->template_pesan }}
                                    </div>
                                </td>

                                <td class="py-4 px-3 text-center whitespace-nowrap">
                                    @if($item->status === 'aktif')
                                        <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-800 border border-emerald-200">
                                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-600 animate-pulse"></span>
                                            Aktif
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-semibold bg-slate-100 text-slate-600 border border-slate-200">
                                            Nonaktif
                                        </span>
                                    @endif
                                </td>

                                <td class="py-4 px-4 text-right whitespace-nowrap">
                                    <button type="button" 
                                            @click="openTestModal({ id: {{ $item->id }}, nama_pasien: '{{ addslashes($item->nama_pasien) }}', nomor_wa: '{{ $item->nomor_wa }}', template_pesan: '{{ addslashes($item->template_pesan) }}' })"
                                            class="inline-flex items-center gap-1 px-3 py-1.5 rounded-lg border border-emerald-200 text-xs font-semibold text-[#2E7D32] hover:bg-emerald-50 transition-colors"
                                            title="Uji coba kirim pesan WA">
                                        <span class="material-symbols-outlined text-[15px]">send</span>
                                        <span>Uji Kirim</span>
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="py-10 px-6 text-center text-slate-400">
                                    Belum ada data jadwal reminder terdaftar.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($reminders->hasPages())
                <div class="p-4 border-t border-slate-100 bg-slate-50/50">
                    {{ $reminders->links() }}
                </div>
            @endif
        </div>

        <!-- FORM KONFIGURASI PESAN DENGAN CHIP TOKEN KLIK-UNTUK-SISIP (id="form-buat-jadwal") -->
        <div id="form-buat-jadwal" class="bg-white p-6 rounded-2xl border border-slate-200/80 shadow-sm space-y-6">
            <div class="flex items-center gap-2 pb-3 border-b border-slate-100">
                <div class="w-9 h-9 rounded-xl bg-emerald-50 text-[#2E7D32] flex items-center justify-center">
                    <span class="material-symbols-outlined text-[20px]">add_task</span>
                </div>
                <div>
                    <h2 class="text-base font-bold text-slate-800">Formulir Konfigurasi Pesan &amp; Buat Jadwal Baru</h2>
                    <p class="text-xs text-slate-400">Gunakan chip token untuk menyisipkan variabel otomatis ke template pesan.</p>
                </div>
            </div>

            <form action="{{ route('admin.reminders.storeSchedule') }}" method="POST" class="space-y-5">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label for="sched_nama_pasien" class="text-xs font-bold text-slate-700 block mb-1">
                            Nama Pasien / Sasaran <span class="text-rose-500">*</span>
                        </label>
                        <input type="text" name="nama_pasien" id="sched_nama_pasien" required placeholder="Contoh: Balita Posyandu Melati 1" class="w-full h-11 px-3 rounded-xl border-slate-200 text-xs focus:border-[#2E7D32] focus:ring-[#2E7D32]">
                    </div>

                    <div>
                        <label for="sched_nomor_wa" class="text-xs font-bold text-slate-700 block mb-1">
                            Nomor WhatsApp Tujuan (E.164) <span class="text-rose-500">*</span>
                        </label>
                        <input type="text" name="nomor_wa" id="sched_nomor_wa" required placeholder="08xxxxxxxxxx atau +628..." class="w-full h-11 px-3 rounded-xl border-slate-200 text-xs font-mono focus:border-[#2E7D32] focus:ring-[#2E7D32]">
                    </div>

                    <div>
                        <label for="sched_klaster_id" class="text-xs font-bold text-slate-700 block mb-1">
                            Klaster ILP Terkait <span class="text-rose-500">*</span>
                        </label>
                        <select name="klaster_id" id="sched_klaster_id" required class="w-full h-11 px-3 rounded-xl border-slate-200 text-xs focus:border-[#2E7D32] focus:ring-[#2E7D32]">
                            <option value="">-- Pilih Klaster --</option>
                            @foreach($klasters as $klaster)
                                <option value="{{ $klaster->id }}">{{ $klaster->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <div>
                        <label for="sched_tipe_interval" class="text-xs font-bold text-slate-700 block mb-1">Tipe Frekuensi</label>
                        <select name="tipe_interval" id="sched_tipe_interval" class="w-full h-11 px-3 rounded-xl border-slate-200 text-xs focus:border-[#2E7D32] focus:ring-[#2E7D32]">
                            <option value="bulanan">Bulanan (Berulang)</option>
                            <option value="sekali">Sekali Jalan</option>
                        </select>
                    </div>

                    <div>
                        <label for="sched_hari_ke" class="text-xs font-bold text-slate-700 block mb-1">Tanggal Kirim Bulanan</label>
                        <input type="number" name="hari_ke" id="sched_hari_ke" min="1" max="31" placeholder="Contoh: 24" class="w-full h-11 px-3 rounded-xl border-slate-200 text-xs focus:border-[#2E7D32] focus:ring-[#2E7D32]">
                    </div>

                    <div>
                        <label for="sched_tanggal_spesifik" class="text-xs font-bold text-slate-700 block mb-1">Tanggal Spesifik (Jika Sekali)</label>
                        <input type="date" name="tanggal_spesifik" id="sched_tanggal_spesifik" class="w-full h-11 px-3 rounded-xl border-slate-200 text-xs focus:border-[#2E7D32] focus:ring-[#2E7D32]">
                    </div>

                    <div>
                        <label for="sched_jam_kirim" class="text-xs font-bold text-slate-700 block mb-1">Jam Blast Otomatis <span class="text-rose-500">*</span></label>
                        <input type="time" name="jam_kirim" id="sched_jam_kirim" value="08:00" required class="w-full h-11 px-3 rounded-xl border-slate-200 text-xs focus:border-[#2E7D32] focus:ring-[#2E7D32]">
                    </div>
                </div>

                <!-- Template Pesan dengan Chip Token -->
                <div class="space-y-2">
                    <div class="flex items-center justify-between flex-wrap gap-2">
                        <label for="template_pesan_input" class="text-xs font-bold text-slate-700">
                            Konfigurasi Template Pesan Pengingat <span class="text-rose-500">*</span>
                        </label>
                        
                        <!-- CHIP TOKEN KLIK-UNTUK-SISIP -->
                        <div class="flex items-center gap-1.5 flex-wrap">
                            <span class="text-[11px] font-semibold text-slate-400">Sisipkan token:</span>
                            <button type="button" 
                                    @click="insertToken('{nama_pasien}')" 
                                    class="px-2.5 py-1 rounded-lg text-xs font-mono font-semibold bg-emerald-50 text-[#2E7D32] border border-emerald-200 hover:bg-emerald-100 transition-colors shadow-2xs">
                                + {nama_pasien}
                            </button>
                            <button type="button" 
                                    @click="insertToken('{tanggal}')" 
                                    class="px-2.5 py-1 rounded-lg text-xs font-mono font-semibold bg-emerald-50 text-[#2E7D32] border border-emerald-200 hover:bg-emerald-100 transition-colors shadow-2xs">
                                + {tanggal}
                            </button>
                            <button type="button" 
                                    @click="insertToken('{nama_puskesmas}')" 
                                    class="px-2.5 py-1 rounded-lg text-xs font-mono font-semibold bg-emerald-50 text-[#2E7D32] border border-emerald-200 hover:bg-emerald-100 transition-colors shadow-2xs">
                                + {nama_puskesmas}
                            </button>
                        </div>
                    </div>

                    <textarea name="template_pesan" 
                              id="template_pesan_input" 
                              x-model="templatePesan" 
                              rows="4" 
                              required 
                              class="w-full p-3.5 rounded-xl border-slate-200 text-xs text-slate-800 leading-relaxed focus:border-[#2E7D32] focus:ring-[#2E7D32] shadow-inner"></textarea>

                    <div class="flex items-center justify-between text-[11px] text-slate-400">
                        <span>Pesan WhatsApp akan otomatis menggantikan token {variabel} sesuai data pasien sasaran saat transmisi.</span>
                        <span class="text-emerald-700 font-medium">Pratinjau Variabel Aktif</span>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label for="sched_jadwal" class="text-xs font-bold text-slate-700 block mb-1">Label Jadwal (Opsional)</label>
                        <input type="text" name="jadwal" id="sched_jadwal" placeholder="Contoh: Setiap Tgl 24 Posyandu Melati" class="w-full h-11 px-3 rounded-xl border-slate-200 text-xs focus:border-[#2E7D32] focus:ring-[#2E7D32]">
                    </div>

                    <div>
                        <label for="sched_status" class="text-xs font-bold text-slate-700 block mb-1">Status Keaktifan</label>
                        <select name="status" id="sched_status" class="w-full h-11 px-3 rounded-xl border-slate-200 text-xs focus:border-[#2E7D32] focus:ring-[#2E7D32]">
                            <option value="aktif">Aktif (Kirim otomatis)</option>
                            <option value="nonaktif">Nonaktif (Simpan draf)</option>
                        </select>
                    </div>
                </div>

                <div class="flex items-center justify-end gap-3 pt-4 border-t border-slate-100">
                    <button type="reset" class="px-5 py-2.5 rounded-xl border border-slate-200 text-xs font-semibold text-slate-600 hover:bg-slate-50 transition-colors">
                        Reset
                    </button>
                    <button type="submit" class="px-6 py-2.5 rounded-xl text-white text-xs font-bold shadow-md hover:opacity-95 transition-all flex items-center gap-2" style="background-color: #2E7D32;">
                        <span class="material-symbols-outlined text-[18px]">save</span>
                        <span>Simpan Jadwal &amp; Template</span>
                    </button>
                </div>
            </form>
        </div>

        <!-- MODAL UJI COBA KIRIM WA -->
        <div x-show="testModalOpen" 
             x-cloak 
             class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm">
            <div @click.away="testModalOpen = false" class="bg-white w-full max-w-md rounded-2xl p-6 shadow-2xl border border-slate-100">
                <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                    <h3 class="text-base font-bold text-slate-800 flex items-center gap-2">
                        <span class="material-symbols-outlined text-[#2E7D32] text-[20px]">send</span>
                        <span>Uji Coba Kirim Pesan WA</span>
                    </h3>
                    <button type="button" @click="testModalOpen = false" class="p-1 rounded-lg text-slate-400 hover:text-slate-700">
                        <span class="material-symbols-outlined text-[20px]">close</span>
                    </button>
                </div>

                <form action="{{ route('admin.reminders.sendTest') }}" method="POST" class="mt-4 space-y-4">
                    @csrf
                    <input type="hidden" name="reminder_id" :value="testReminderId">

                    <div>
                        <label for="test_phone_sched" class="text-xs font-bold text-slate-700 block mb-1">
                            Nomor WhatsApp Tujuan:
                        </label>
                        <input type="text" name="target_phone" id="test_phone_sched" x-model="testPhone" required class="w-full h-10 px-3 rounded-xl border-slate-200 text-xs font-mono focus:border-[#2E7D32] focus:ring-[#2E7D32]">
                        <span class="text-[11px] text-slate-400 mt-1 block">Nomor tujuan untuk pengujian gateway WhatsApp.</span>
                    </div>

                    <div class="mt-6 flex items-center justify-end gap-3 pt-3 border-t border-slate-100">
                        <button type="button" @click="testModalOpen = false" class="px-4 py-2 rounded-xl border border-slate-200 text-xs font-semibold text-slate-600 hover:bg-slate-50">
                            Batal
                        </button>
                        <button type="submit" class="px-5 py-2 rounded-xl text-white text-xs font-bold shadow-md hover:opacity-95 flex items-center gap-1.5" style="background-color: #2E7D32;">
                            <span class="material-symbols-outlined text-[16px]">send</span>
                            <span>Kirim Sekarang</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-admin-layout>
