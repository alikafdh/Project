<x-admin-layout title="Pasien Reminder WhatsApp">
    <div class="space-y-6" x-data="{ 
        registerModalOpen: false,
        testModalOpen: false,
        selectedReminder: null,
        targetPhone: '',
        openRegisterModal() {
            this.registerModalOpen = true;
        },
        openTestModal(reminder) {
            this.selectedReminder = reminder;
            this.targetPhone = reminder.nomor_wa;
            this.testModalOpen = true;
        }
    }">
        <!-- Sub-Tabs Horizontal Navigation Bar -->
        <div class="flex items-center justify-between flex-wrap gap-4">
            <x-admin.reminder-nav active="patients" />
            
            <button type="button" 
                    @click="openRegisterModal()" 
                    class="h-11 px-5 rounded-xl text-white font-bold text-xs flex items-center gap-2 shadow-sm transition-all hover:opacity-95" 
                    style="background-color: #2E7D32;">
                <span class="material-symbols-outlined text-[18px]">person_add</span>
                <span>+ Daftarkan Pasien Baru</span>
            </button>
        </div>

        <!-- Header Section -->
        <div class="space-y-1">
            <div class="flex items-center gap-1.5 text-xs text-slate-500 font-medium">
                <span>Admin Portal</span>
                <span class="material-symbols-outlined text-[14px]">chevron_right</span>
                <span>Kelola Reminder WhatsApp</span>
                <span class="material-symbols-outlined text-[14px]">chevron_right</span>
                <span class="text-[#2E7D32] font-semibold">Pasien Terdaftar</span>
            </div>
            <h1 class="text-2xl font-bold text-slate-800 tracking-tight">Daftar Pasien Reminder WhatsApp</h1>
            <p class="text-sm text-slate-500 max-w-3xl leading-relaxed">
                Manajemen data pasien terdaftar untuk pengiriman otomatis notifikasi kontrol, edukasi kesehatan, dan jadwal posyandu balita via WhatsApp Gateway UPTD Puskesmas Cilimus.
            </p>
        </div>

        <!-- 4 Summary Metric Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-sm flex items-center justify-between">
                <div>
                    <span class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Total Pasien Terdaftar</span>
                    <h3 class="text-2xl font-bold text-[#2E7D32] mt-1">{{ $totalPatients }}</h3>
                    <p class="text-xs text-slate-500 mt-0.5">Pasien sasaran notifikasi</p>
                </div>
                <div class="w-12 h-12 rounded-xl bg-emerald-50 flex items-center justify-center text-[#2E7D32]">
                    <span class="material-symbols-outlined text-[26px]">groups</span>
                </div>
            </div>

            <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-sm flex items-center justify-between">
                <div>
                    <span class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Pasien Status Aktif</span>
                    <h3 class="text-2xl font-bold text-emerald-700 mt-1">{{ $activePatients }}</h3>
                    <p class="text-xs text-emerald-600 font-medium flex items-center gap-1 mt-0.5">
                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-600"></span> Siap dikirimi broadcast
                    </p>
                </div>
                <div class="w-12 h-12 rounded-xl bg-emerald-50 flex items-center justify-center text-emerald-600">
                    <span class="material-symbols-outlined text-[26px]">check_circle</span>
                </div>
            </div>

            <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-sm flex items-center justify-between">
                <div>
                    <span class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Pasien Nonaktif</span>
                    <h3 class="text-2xl font-bold text-slate-600 mt-1">{{ $inactivePatients }}</h3>
                    <p class="text-xs text-slate-400 mt-0.5">Pesan dijeda sementara</p>
                </div>
                <div class="w-12 h-12 rounded-xl bg-slate-100 flex items-center justify-center text-slate-500">
                    <span class="material-symbols-outlined text-[26px]">pause_circle</span>
                </div>
            </div>

            <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-sm flex items-center justify-between">
                <div>
                    <span class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Jadwal Aktif Terdaftar</span>
                    <h3 class="text-2xl font-bold text-[#2E7D32] mt-1">{{ $scheduledThisWeek }}</h3>
                    <p class="text-xs text-emerald-600 font-medium flex items-center gap-1 mt-0.5">
                        <span class="material-symbols-outlined text-[14px]">schedule_send</span> Terhubung ke gateway
                    </p>
                </div>
                <div class="w-12 h-12 rounded-xl bg-emerald-50 flex items-center justify-center text-[#2E7D32]">
                    <span class="material-symbols-outlined text-[26px]">notifications_active</span>
                </div>
            </div>
        </div>

        <!-- Filter & Search Toolbar -->
        <div class="bg-white p-4 rounded-2xl border border-slate-200/80 shadow-sm">
            <form method="GET" action="{{ route('admin.reminders.patients') }}" class="flex flex-col md:flex-row items-stretch md:items-center justify-between gap-3">
                <div class="relative flex-1">
                    <span class="material-symbols-outlined absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-[20px]">search</span>
                    <input type="text" 
                        name="search" 
                        value="{{ request('search') }}" 
                        placeholder="Cari nama pasien atau nomor WhatsApp..." 
                        class="w-full h-11 pl-10 pr-4 rounded-xl bg-slate-50 border border-slate-200 text-sm text-slate-800 placeholder:text-slate-400 focus:bg-white focus:border-[#2E7D32] focus:ring-[#2E7D32] transition-all">
                </div>

                <div class="flex flex-wrap items-center gap-2.5">
                    <!-- Filter Klaster -->
                    <div class="min-w-[190px]">
                        <select name="klaster_id" class="w-full h-11 px-3 rounded-xl bg-slate-50 border border-slate-200 text-xs font-medium text-slate-700 focus:bg-white focus:border-[#2E7D32] focus:ring-[#2E7D32] cursor-pointer">
                            <option value="">Semua Klaster ILP</option>
                            @foreach($klasters as $klaster)
                                <option value="{{ $klaster->id }}" {{ request('klaster_id') == $klaster->id ? 'selected' : '' }}>
                                    {{ $klaster->nama }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Filter Status -->
                    <div class="min-w-[130px]">
                        <select name="status" class="w-full h-11 px-3 rounded-xl bg-slate-50 border border-slate-200 text-xs font-medium text-slate-700 focus:bg-white focus:border-[#2E7D32] focus:ring-[#2E7D32] cursor-pointer">
                            <option value="">Semua Status</option>
                            <option value="aktif" {{ request('status') === 'aktif' ? 'selected' : '' }}>Status Aktif</option>
                            <option value="nonaktif" {{ request('status') === 'nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                        </select>
                    </div>

                    <button type="submit" class="h-11 px-4 rounded-xl bg-slate-800 text-white text-xs font-semibold hover:bg-slate-900 transition-colors flex items-center gap-1.5 shadow-sm">
                        <span class="material-symbols-outlined text-[16px]">filter_list</span>
                        <span>Filter</span>
                    </button>

                    @if(request()->anyFilled(['search', 'klaster_id', 'status']))
                        <a href="{{ route('admin.reminders.patients') }}" class="h-11 px-3 rounded-xl border border-slate-200 text-xs font-medium text-slate-500 hover:text-slate-800 hover:bg-slate-50 flex items-center transition-colors">
                            Reset
                        </a>
                    @endif
                </div>
            </form>
        </div>

        <!-- Tabel Data Pasien -->
        <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm overflow-hidden flex flex-col">
            <div class="overflow-x-auto w-full">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50/80 border-b border-slate-200 text-slate-500 text-xs uppercase tracking-wider font-semibold">
                            <th class="py-4 px-4 w-12 text-center">No</th>
                            <th class="py-4 px-4">Nama Pasien</th>
                            <th class="py-4 px-3">Nomor WhatsApp</th>
                            <th class="py-4 px-3">Klaster Sasaran</th>
                            <th class="py-4 px-3">Jadwal Blast</th>
                            <th class="py-4 px-4">Cuplikan Pesan</th>
                            <th class="py-4 px-3 text-center">Status</th>
                            <th class="py-4 px-4 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-sm">
                        @forelse($patients as $index => $patient)
                            <tr class="hover:bg-slate-50/70 transition-colors group">
                                <td class="py-4 px-4 text-center text-xs font-mono text-slate-400">
                                    {{ $patients->firstItem() + $index }}
                                </td>
                                
                                <td class="py-4 px-4 font-bold text-slate-800 whitespace-nowrap">
                                    <div class="flex items-center gap-2">
                                        <div class="w-8 h-8 rounded-full bg-emerald-100 text-[#2E7D32] flex items-center justify-center font-bold text-xs">
                                            {{ strtoupper(substr($patient->nama_pasien, 0, 2)) }}
                                        </div>
                                        <div>
                                            <div>{{ $patient->nama_pasien }}</div>
                                            <div class="text-[11px] text-slate-400 font-normal">ID: #RM-{{ str_pad($patient->id, 4, '0', STR_PAD_LEFT) }}</div>
                                        </div>
                                    </div>
                                </td>

                                <td class="py-4 px-3 whitespace-nowrap">
                                    <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $patient->nomor_wa) }}" target="_blank" class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg text-xs font-mono font-semibold bg-emerald-50 text-emerald-800 border border-emerald-200 hover:bg-emerald-100 transition-colors">
                                        <span class="material-symbols-outlined text-[15px] text-[#2E7D32]">chat</span>
                                        <span>{{ $patient->nomor_wa }}</span>
                                    </a>
                                </td>

                                <td class="py-4 px-3 whitespace-nowrap">
                                    @if($patient->klaster)
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-slate-100 text-slate-700 border border-slate-200">
                                            {{ $patient->klaster->nama }}
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-slate-50 text-slate-400">
                                            Umum
                                        </span>
                                    @endif
                                </td>

                                <td class="py-4 px-3 whitespace-nowrap text-xs text-slate-600">
                                    <div class="font-semibold text-slate-800">{{ $patient->jadwal ?? 'Setiap Bulan' }}</div>
                                    <div class="text-[11px] text-slate-400 flex items-center gap-1 mt-0.5">
                                        <span class="material-symbols-outlined text-[12px]">schedule</span>
                                        {{ $patient->jam_kirim ? substr($patient->jam_kirim, 0, 5) : '08:00' }} WIB
                                    </div>
                                </td>

                                <td class="py-4 px-4 min-w-[220px] max-w-xs text-xs text-slate-500">
                                    <p class="line-clamp-2 leading-relaxed bg-slate-50 p-2 rounded-lg border border-slate-100">
                                        {{ $patient->template_pesan }}
                                    </p>
                                </td>

                                <td class="py-4 px-3 text-center whitespace-nowrap">
                                    @if($patient->status === 'aktif')
                                        <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-800 border border-emerald-200">
                                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-600"></span>
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
                                            @click="openTestModal({ id: {{ $patient->id }}, nama_pasien: '{{ addslashes($patient->nama_pasien) }}', nomor_wa: '{{ $patient->nomor_wa }}' })"
                                            class="inline-flex items-center gap-1 px-2.5 py-1.5 rounded-lg border border-emerald-200 text-xs font-semibold text-[#2E7D32] hover:bg-emerald-50 transition-colors"
                                            title="Uji coba kirim pesan WhatsApp">
                                        <span class="material-symbols-outlined text-[15px]">send</span>
                                        <span>Tes Kirim</span>
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="py-12 px-6 text-center text-slate-400">
                                    <div class="flex flex-col items-center justify-center">
                                        <div class="w-12 h-12 rounded-full bg-slate-100 flex items-center justify-center text-slate-400 mb-3">
                                            <span class="material-symbols-outlined text-[26px]">person_off</span>
                                        </div>
                                        <p class="font-semibold text-slate-600">Belum ada pasien reminder terdaftar.</p>
                                        <p class="text-xs text-slate-400 mt-1">Gunakan tombol "+ Daftarkan Pasien Baru" di atas untuk mendaftarkan nomor WhatsApp pasien.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($patients->hasPages())
                <div class="p-4 border-t border-slate-100 bg-slate-50/50">
                    {{ $patients->links() }}
                </div>
            @endif
        </div>

        <!-- MODAL DAFTARKAN PASIEN BARU (Alpine.js) -->
        <div x-show="registerModalOpen" 
             x-cloak 
             class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm"
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-150"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0">
            <div @click.away="registerModalOpen = false" class="bg-white w-full max-w-lg rounded-2xl p-6 shadow-2xl border border-slate-100 max-h-[90vh] overflow-y-auto">
                <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                    <div class="flex items-center gap-2">
                        <div class="w-8 h-8 rounded-lg bg-emerald-100 text-[#2E7D32] flex items-center justify-center">
                            <span class="material-symbols-outlined text-[18px]">person_add</span>
                        </div>
                        <h3 class="text-base font-bold text-slate-800">Daftarkan Pasien Reminder Baru</h3>
                    </div>
                    <button type="button" @click="registerModalOpen = false" class="p-1 rounded-lg text-slate-400 hover:text-slate-700">
                        <span class="material-symbols-outlined text-[20px]">close</span>
                    </button>
                </div>

                <form action="{{ route('admin.reminders.storePatient') }}" method="POST" class="mt-4 space-y-4">
                    @csrf

                    <div>
                        <label for="nama_pasien" class="text-xs font-bold text-slate-700 block mb-1">
                            Nama Lengkap Pasien <span class="text-rose-500">*</span>
                        </label>
                        <input type="text" name="nama_pasien" id="nama_pasien" required placeholder="Contoh: Ny. Siti Rahmawati" class="w-full h-10 px-3 rounded-xl border-slate-200 text-xs focus:border-[#2E7D32] focus:ring-[#2E7D32]">
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        <div>
                            <label for="nomor_wa" class="text-xs font-bold text-slate-700 block mb-1">
                                Nomor WhatsApp (E.164) <span class="text-rose-500">*</span>
                            </label>
                            <input type="text" name="nomor_wa" id="nomor_wa" required placeholder="08xxxxxxxxxx atau +628..." class="w-full h-10 px-3 rounded-xl border-slate-200 text-xs focus:border-[#2E7D32] focus:ring-[#2E7D32]">
                        </div>

                        <div>
                            <label for="klaster_id" class="text-xs font-bold text-slate-700 block mb-1">
                                Klaster ILP <span class="text-rose-500">*</span>
                            </label>
                            <select name="klaster_id" id="klaster_id" required class="w-full h-10 px-3 rounded-xl border-slate-200 text-xs focus:border-[#2E7D32] focus:ring-[#2E7D32]">
                                <option value="">-- Pilih Klaster --</option>
                                @foreach($klasters as $klaster)
                                    <option value="{{ $klaster->id }}">{{ $klaster->nama }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                        <div>
                            <label for="tipe_interval" class="text-xs font-bold text-slate-700 block mb-1">Interval</label>
                            <select name="tipe_interval" id="tipe_interval" class="w-full h-10 px-2.5 rounded-xl border-slate-200 text-xs focus:border-[#2E7D32] focus:ring-[#2E7D32]">
                                <option value="bulanan">Bulanan</option>
                                <option value="sekali">Sekali Jalan</option>
                            </select>
                        </div>
                        <div>
                            <label for="hari_ke" class="text-xs font-bold text-slate-700 block mb-1">Tanggal Kirim</label>
                            <input type="number" name="hari_ke" id="hari_ke" min="1" max="31" placeholder="Tgl 1-31" class="w-full h-10 px-3 rounded-xl border-slate-200 text-xs focus:border-[#2E7D32] focus:ring-[#2E7D32]">
                        </div>
                        <div>
                            <label for="jam_kirim" class="text-xs font-bold text-slate-700 block mb-1">Jam Blast</label>
                            <input type="time" name="jam_kirim" id="jam_kirim" value="08:00" class="w-full h-10 px-2.5 rounded-xl border-slate-200 text-xs focus:border-[#2E7D32] focus:ring-[#2E7D32]">
                        </div>
                    </div>

                    <div>
                        <label for="template_pesan" class="text-xs font-bold text-slate-700 block mb-1">
                            Template Pesan WhatsApp <span class="text-rose-500">*</span>
                        </label>
                        <textarea name="template_pesan" id="template_pesan" rows="4" required class="w-full p-3 rounded-xl border-slate-200 text-xs text-slate-700 focus:border-[#2E7D32] focus:ring-[#2E7D32]">Halo Ibu/Bpk {nama_pasien}, mengingatkan kembali jadwal pemeriksaan rutin Anda di {nama_puskesmas} pada {tanggal}. Mohon hadir tepat waktu. Terima kasih.</textarea>
                        <div class="flex items-center gap-1.5 mt-1 text-[11px] text-slate-400">
                            <span>Variabel token:</span>
                            <span class="px-1.5 py-0.5 rounded bg-slate-100 text-[#2E7D32] font-mono font-semibold">{nama_pasien}</span>
                            <span class="px-1.5 py-0.5 rounded bg-slate-100 text-[#2E7D32] font-mono font-semibold">{tanggal}</span>
                            <span class="px-1.5 py-0.5 rounded bg-slate-100 text-[#2E7D32] font-mono font-semibold">{nama_puskesmas}</span>
                        </div>
                    </div>

                    <div>
                        <label for="status" class="text-xs font-bold text-slate-700 block mb-1">Status Keaktifan</label>
                        <select name="status" id="status" class="w-full h-10 px-3 rounded-xl border-slate-200 text-xs focus:border-[#2E7D32] focus:ring-[#2E7D32]">
                            <option value="aktif">Aktif (Kirim otomatis sesuai jadwal)</option>
                            <option value="nonaktif">Nonaktif (Jeda sementara)</option>
                        </select>
                    </div>

                    <div class="mt-6 flex items-center justify-end gap-3 pt-3 border-t border-slate-100">
                        <button type="button" @click="registerModalOpen = false" class="px-4 py-2 rounded-xl border border-slate-200 text-xs font-semibold text-slate-600 hover:bg-slate-50">
                            Batal
                        </button>
                        <button type="submit" class="px-5 py-2 rounded-xl text-white text-xs font-bold shadow-md hover:opacity-95" style="background-color: #2E7D32;">
                            Simpan Pasien
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- MODAL UJI COBA KIRIM WHATSAPP (Alpine.js) -->
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
                    <input type="hidden" name="reminder_id" :value="selectedReminder?.id">

                    <div>
                        <label class="text-xs font-bold text-slate-700 block mb-1">Sasaran Pasien:</label>
                        <div class="p-3 rounded-xl bg-slate-50 border border-slate-200 text-xs text-slate-800 font-semibold" x-text="selectedReminder?.nama_pasien"></div>
                    </div>

                    <div>
                        <label for="test_phone" class="text-xs font-bold text-slate-700 block mb-1">
                            Nomor WhatsApp Tujuan:
                        </label>
                        <input type="text" name="target_phone" id="test_phone" x-model="targetPhone" required class="w-full h-10 px-3 rounded-xl border-slate-200 text-xs font-mono focus:border-[#2E7D32] focus:ring-[#2E7D32]">
                        <span class="text-[11px] text-slate-400 mt-1 block">Anda dapat mengganti dengan nomor WhatsApp Anda untuk pengujian.</span>
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
