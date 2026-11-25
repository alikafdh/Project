<x-admin-layout title="Kotak Saran Warga">
    <div class="space-y-6" x-data="{
        detailModalOpen: false,
        selectedFeedback: null,
        openDetail(item) {
            this.selectedFeedback = item;
            this.detailModalOpen = true;
        },
        cleanWhatsAppNumber(phone) {
            if (!phone) return '';
            let cleaned = phone.replace(/[^0-9]/g, '');
            if (cleaned.startsWith('0')) {
                cleaned = '62' + cleaned.substring(1);
            }
            return cleaned;
        },
        getWhatsAppLink(item) {
            if (!item) return '#';
            const phone = this.cleanWhatsAppNumber(item.kontak);
            const text = encodeURIComponent('Halo Ibu/Bpk ' + item.nama_pengirim + ', kami dari Manajemen UPTD Puskesmas Cilimus menindaklanjuti masukan Anda terkait \'' + item.subjek + '\'. Terima kasih.');
            return 'https://wa.me/' + phone + '?text=' + text;
        }
    }">
        <!-- Top Breadcrumb & Page Header -->
        <div class="space-y-1">
            <div class="flex items-center gap-1.5 text-xs text-slate-500 font-medium">
                <span>Admin Portal</span>
                <span class="material-symbols-outlined text-[14px]">chevron_right</span>
                <span>Layanan Publik</span>
                <span class="material-symbols-outlined text-[14px]">chevron_right</span>
                <span class="text-[#2E7D32] font-semibold">Kotak Saran</span>
            </div>
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 pt-1">
                <div>
                    <h1 class="text-2xl font-bold text-slate-800 tracking-tight">Kotak Masuk Kritik &amp; Saran Masyarakat</h1>
                    <p class="text-sm text-slate-500 max-w-3xl leading-relaxed mt-0.5">
                        Kelola aspirasi warga, pengaduan layanan kesehatan, serta masukan peningkatan mutu fasilitas di lingkungan kerja UPTD Puskesmas Cilimus.
                    </p>
                </div>
            </div>
        </div>

        <!-- 3 SUMMARY METRIC CARDS DI ATAS -->
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
            <!-- Card 1: Total Masukan -->
            <div class="bg-white p-6 rounded-2xl border border-slate-200/80 shadow-sm flex items-center justify-between">
                <div>
                    <span class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Total Masukan</span>
                    <h3 class="text-3xl font-bold text-slate-800 mt-1">{{ $totalFeedback }}</h3>
                    <p class="text-xs text-slate-500 mt-1 flex items-center gap-1">
                        <span class="material-symbols-outlined text-[15px] text-slate-400">inbox</span>
                        <span>Aspirasi warga tercatat</span>
                    </p>
                </div>
                <div class="w-12 h-12 rounded-xl bg-slate-100 flex items-center justify-center text-slate-700">
                    <span class="material-symbols-outlined text-[26px]">all_inbox</span>
                </div>
            </div>

            <!-- Card 2: Belum Dibaca (Aksen Oranye) -->
            <div class="p-6 rounded-2xl border border-amber-200 bg-amber-50/60 shadow-sm flex items-center justify-between">
                <div>
                    <span class="text-xs font-bold text-amber-800 uppercase tracking-wider">Belum Dibaca</span>
                    <h3 class="text-3xl font-bold text-amber-900 mt-1">{{ $unreadFeedback }}</h3>
                    <p class="text-xs text-amber-700 font-medium mt-1 flex items-center gap-1.5">
                        <span class="w-2 h-2 rounded-full bg-amber-500 animate-pulse"></span>
                        <span>Perlu tindak lanjut segera</span>
                    </p>
                </div>
                <div class="w-12 h-12 rounded-xl bg-amber-100 text-amber-700 flex items-center justify-center">
                    <span class="material-symbols-outlined text-[26px]">mark_email_unread</span>
                </div>
            </div>

            <!-- Card 3: Sudah Ditindaklanjuti (Aksen Hijau) -->
            <div class="p-6 rounded-2xl border border-emerald-200 bg-emerald-50/60 shadow-sm flex items-center justify-between">
                <div>
                    <span class="text-xs font-bold text-emerald-800 uppercase tracking-wider">Sudah Ditindaklanjuti</span>
                    <h3 class="text-3xl font-bold text-emerald-900 mt-1">{{ $resolvedFeedback }}</h3>
                    <p class="text-xs text-emerald-700 font-medium mt-1 flex items-center gap-1">
                        <span class="material-symbols-outlined text-[15px] text-emerald-600">done_all</span>
                        <span>Telah direspon &amp; dibaca</span>
                    </p>
                </div>
                <div class="w-12 h-12 rounded-xl bg-emerald-100 text-emerald-700 flex items-center justify-center">
                    <span class="material-symbols-outlined text-[26px]">task_alt</span>
                </div>
            </div>
        </div>

        <!-- Filter & Search Toolbar -->
        <div class="bg-white p-4 rounded-2xl border border-slate-200/80 shadow-sm">
            <form method="GET" action="{{ route('admin.saran.index') }}" class="flex flex-col md:flex-row items-stretch md:items-center justify-between gap-3">
                <div class="relative flex-1">
                    <span class="material-symbols-outlined absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-[20px]">search</span>
                    <input type="text" 
                        name="search" 
                        value="{{ request('search') }}" 
                        placeholder="Cari nama pengirim, kontak, atau subjek saran..." 
                        class="w-full h-11 pl-10 pr-4 rounded-xl bg-slate-50 border border-slate-200 text-sm text-slate-800 placeholder:text-slate-400 focus:bg-white focus:border-[#2E7D32] focus:ring-[#2E7D32] transition-all">
                </div>

                <div class="flex flex-wrap items-center gap-2.5">
                    <!-- Filter Status -->
                    <div class="min-w-[140px]">
                        <select name="status" class="w-full h-11 px-3 rounded-xl bg-slate-50 border border-slate-200 text-xs font-medium text-slate-700 focus:bg-white focus:border-[#2E7D32] focus:ring-[#2E7D32] cursor-pointer">
                            <option value="">Semua Status</option>
                            <option value="baru" {{ request('status') === 'baru' ? 'selected' : '' }}>🟠 BARU (Belum Dibaca)</option>
                            <option value="dibaca" {{ request('status') === 'dibaca' ? 'selected' : '' }}>🟢 Sudah Dibaca</option>
                            <option value="selesai" {{ request('status') === 'selesai' ? 'selected' : '' }}>✅ Selesai</option>
                        </select>
                    </div>

                    <!-- Filter Klaster -->
                    <div class="min-w-[180px]">
                        <select name="klaster_id" class="w-full h-11 px-3 rounded-xl bg-slate-50 border border-slate-200 text-xs font-medium text-slate-700 focus:bg-white focus:border-[#2E7D32] focus:ring-[#2E7D32] cursor-pointer">
                            <option value="">Semua Klaster Layanan</option>
                            @foreach($klasters as $klaster)
                                <option value="{{ $klaster->id }}" {{ request('klaster_id') == $klaster->id ? 'selected' : '' }}>
                                    {{ $klaster->nama }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <button type="submit" class="h-11 px-4 rounded-xl bg-slate-800 text-white text-xs font-semibold hover:bg-slate-900 transition-colors flex items-center gap-1.5 shadow-sm">
                        <span class="material-symbols-outlined text-[16px]">filter_list</span>
                        <span>Filter</span>
                    </button>

                    @if(request()->anyFilled(['search', 'status', 'klaster_id']))
                        <a href="{{ route('admin.saran.index') }}" class="h-11 px-3 rounded-xl border border-slate-200 text-xs font-medium text-slate-500 hover:text-slate-800 hover:bg-slate-50 flex items-center transition-colors">
                            Reset
                        </a>
                    @endif
                </div>
            </form>
        </div>

        <!-- TABEL DATA INBOX (8 KOLOM) -->
        <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm overflow-hidden flex flex-col">
            <div class="overflow-x-auto w-full">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50/80 border-b border-slate-200 text-slate-500 text-xs uppercase tracking-wider font-semibold">
                            <!-- Kolom 1: Checkbox -->
                            <th class="py-4 pl-4 pr-2 w-10 text-center">
                                <input type="checkbox" class="w-4 h-4 rounded border-slate-300 text-[#2E7D32] focus:ring-[#2E7D32] cursor-pointer">
                            </th>
                            <!-- Kolom 2: Nama Pengirim -->
                            <th class="py-4 px-4 min-w-[160px]">Nama Pengirim</th>
                            <!-- Kolom 3: WA / Email (Bersusun) -->
                            <th class="py-4 px-4 min-w-[190px]">WA / Email</th>
                            <!-- Kolom 4: Klaster ILP Tujuan -->
                            <th class="py-4 px-3 min-w-[150px]">Klaster Tujuan</th>
                            <!-- Kolom 5: Subjek -->
                            <th class="py-4 px-4 min-w-[240px]">Subjek &amp; Pesan</th>
                            <!-- Kolom 6: Waktu Masuk -->
                            <th class="py-4 px-3 min-w-[130px]">Waktu Masuk</th>
                            <!-- Kolom 7: Status Badge -->
                            <th class="py-4 px-3 text-center min-w-[120px]">Status</th>
                            <!-- Kolom 8: Aksi -->
                            <th class="py-4 px-4 text-right min-w-[130px]">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-sm">
                        @forelse($feedbacks as $item)
                            <tr class="transition-colors group cursor-pointer {{ $item->status === 'baru' ? 'bg-amber-50/40 hover:bg-amber-50/70 border-l-4 border-l-amber-500' : 'hover:bg-slate-50/70' }}"
                                @click="openDetail({
                                    id: {{ $item->id }},
                                    nama_pengirim: '{{ addslashes($item->nama_pengirim) }}',
                                    kontak: '{{ addslashes($item->kontak) }}',
                                    klaster_nama: '{{ addslashes($item->klaster->nama ?? 'Umum / Non-Klaster') }}',
                                    subjek: '{{ addslashes($item->subjek) }}',
                                    isi_pesan: '{{ addslashes(str_replace(["\r", "\n"], ' ', $item->isi_pesan)) }}',
                                    status: '{{ $item->status }}',
                                    catatan_internal: '{{ addslashes($item->catatan_internal ?? '') }}',
                                    waktu_masuk: '{{ $item->created_at->format('d M Y, H:i') }} WIB',
                                    diff: '{{ $item->created_at->diffForHumans() }}',
                                    read_url: '{{ route('admin.saran.read', $item) }}',
                                    destroy_url: '{{ route('admin.saran.destroy', $item) }}'
                                })">
                                <!-- 1. Checkbox -->
                                <td class="py-4 pl-4 pr-2 text-center" @click.stop>
                                    <input type="checkbox" class="w-4 h-4 rounded border-slate-300 text-[#2E7D32] focus:ring-[#2E7D32] cursor-pointer">
                                </td>

                                <!-- 2. Nama Pengirim -->
                                <td class="py-4 px-4 font-bold text-slate-800 whitespace-nowrap">
                                    <div class="flex items-center gap-2">
                                        <div class="w-8 h-8 rounded-full {{ $item->status === 'baru' ? 'bg-amber-200 text-amber-900' : 'bg-slate-100 text-slate-700' }} flex items-center justify-center font-bold text-xs flex-shrink-0">
                                            {{ strtoupper(substr($item->nama_pengirim, 0, 2)) }}
                                        </div>
                                        <div>
                                            <div class="group-hover:text-[#2E7D32] transition-colors">{{ $item->nama_pengirim }}</div>
                                            <div class="text-[11px] font-mono text-slate-400 font-normal">#TK-{{ str_pad($item->id, 4, '0', STR_PAD_LEFT) }}</div>
                                        </div>
                                    </div>
                                </td>

                                <!-- 3. WA / Email (Bersusun) -->
                                <td class="py-4 px-4 text-xs whitespace-nowrap" @click.stop>
                                    @php
                                        $isPhone = preg_match('/^[0-9\+\-\s]{7,16}$/', $item->kontak) || str_starts_with($item->kontak, '+62') || str_starts_with($item->kontak, '08');
                                        $isEmail = str_contains($item->kontak, '@');
                                    @endphp
                                    <div class="space-y-1">
                                        <!-- Baris 1: WhatsApp / Nomor Telepon -->
                                        <div class="flex items-center gap-1.5 text-slate-700 font-mono">
                                            <span class="material-symbols-outlined text-[15px] text-[#2E7D32]">chat</span>
                                            @if($isPhone)
                                                <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $item->kontak) }}" target="_blank" class="hover:underline hover:text-[#2E7D32]">
                                                    {{ $item->kontak }}
                                                </a>
                                            @else
                                                <span class="text-slate-600">{{ $isEmail ? '-' : $item->kontak }}</span>
                                            @endif
                                        </div>
                                        <!-- Baris 2: Email -->
                                        <div class="flex items-center gap-1.5 text-slate-500">
                                            <span class="material-symbols-outlined text-[15px] text-blue-500">mail</span>
                                            @if($isEmail)
                                                <a href="mailto:{{ $item->kontak }}" class="hover:underline hover:text-blue-600">
                                                    {{ $item->kontak }}
                                                </a>
                                            @else
                                                <span class="text-slate-400 text-[11px]">-</span>
                                            @endif
                                        </div>
                                    </div>
                                </td>

                                <!-- 4. Klaster ILP Tujuan -->
                                <td class="py-4 px-3 whitespace-nowrap">
                                    @if($item->klaster)
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-slate-100 text-slate-700 border border-slate-200">
                                            {{ $item->klaster->nama }}
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-slate-50 text-slate-400">
                                            Umum / CS
                                        </span>
                                    @endif
                                </td>

                                <!-- 5. Subjek -->
                                <td class="py-4 px-4 min-w-[240px] max-w-sm">
                                    <div class="font-bold text-slate-800 line-clamp-1 group-hover:text-[#2E7D32] transition-colors">
                                        {{ $item->subjek }}
                                    </div>
                                    <p class="text-xs text-slate-400 line-clamp-1 mt-0.5 font-normal">
                                        {{ $item->isi_pesan }}
                                    </p>
                                </td>

                                <!-- 6. Waktu Masuk -->
                                <td class="py-4 px-3 whitespace-nowrap text-xs text-slate-500">
                                    <div>{{ $item->created_at->format('d M Y') }}</div>
                                    <div class="text-[11px] text-slate-400">{{ $item->created_at->format('H:i') }} WIB &bull; {{ $item->created_at->diffForHumans() }}</div>
                                </td>

                                <!-- 7. Status Badge: Oranye "BARU" / Hijau "Sudah Dibaca" -->
                                <td class="py-4 px-3 text-center whitespace-nowrap">
                                    @if($item->status === 'baru')
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-xs font-bold bg-amber-100 text-amber-800 border border-amber-200 shadow-2xs">
                                            <span class="w-1.5 h-1.5 rounded-full bg-amber-600 animate-pulse"></span>
                                            BARU
                                        </span>
                                    @elseif($item->status === 'dibaca')
                                        <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-semibold bg-emerald-100 text-emerald-800 border border-emerald-200">
                                            <span class="material-symbols-outlined text-[13px]">done</span>
                                            Sudah Dibaca
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-semibold bg-blue-100 text-blue-800 border border-blue-200">
                                            <span class="material-symbols-outlined text-[13px]">done_all</span>
                                            Selesai
                                        </span>
                                    @endif
                                </td>

                                <!-- 8. Aksi -->
                                <td class="py-4 px-4 text-right whitespace-nowrap" @click.stop>
                                    <div class="inline-flex items-center gap-1">
                                        <button type="button" 
                                                @click="openDetail({
                                                    id: {{ $item->id }},
                                                    nama_pengirim: '{{ addslashes($item->nama_pengirim) }}',
                                                    kontak: '{{ addslashes($item->kontak) }}',
                                                    klaster_nama: '{{ addslashes($item->klaster->nama ?? 'Umum / Non-Klaster') }}',
                                                    subjek: '{{ addslashes($item->subjek) }}',
                                                    isi_pesan: '{{ addslashes(str_replace(["\r", "\n"], ' ', $item->isi_pesan)) }}',
                                                    status: '{{ $item->status }}',
                                                    catatan_internal: '{{ addslashes($item->catatan_internal ?? '') }}',
                                                    waktu_masuk: '{{ $item->created_at->format('d M Y, H:i') }} WIB',
                                                    diff: '{{ $item->created_at->diffForHumans() }}',
                                                    read_url: '{{ route('admin.saran.read', $item) }}',
                                                    destroy_url: '{{ route('admin.saran.destroy', $item) }}'
                                                })"
                                                class="p-2 rounded-lg text-slate-500 hover:text-[#2E7D32] hover:bg-emerald-50 transition-colors"
                                                title="Baca Rincian Masukan">
                                            <span class="material-symbols-outlined text-[18px]">visibility</span>
                                        </button>

                                        <form action="{{ route('admin.saran.destroy', $item) }}" method="POST" class="inline-block" onsubmit="return confirm('Hapus pesan masukan warga ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="p-2 rounded-lg text-slate-500 hover:text-rose-600 hover:bg-rose-50 transition-colors" title="Hapus Saran">
                                                <span class="material-symbols-outlined text-[18px]">delete</span>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="py-12 px-6 text-center text-slate-400">
                                    <div class="flex flex-col items-center justify-center">
                                        <div class="w-12 h-12 rounded-full bg-slate-100 flex items-center justify-center text-slate-400 mb-3">
                                            <span class="material-symbols-outlined text-[26px]">inbox</span>
                                        </div>
                                        <p class="font-semibold text-slate-600">Kotak masuk saran masih kosong.</p>
                                        <p class="text-xs text-slate-400 mt-1">Aspirasi atau pengaduan yang dikirim masyarakat melalui portal publik akan tampil di sini.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($feedbacks->hasPages())
                <div class="p-4 border-t border-slate-100 bg-slate-50/50">
                    {{ $feedbacks->links() }}
                </div>
            @endif
        </div>

        <!-- MODAL DETAIL BACA PESAN (Alpine.js) -->
        <div x-show="detailModalOpen" 
             x-cloak 
             class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm"
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-150"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0">
            <div @click.away="detailModalOpen = false" class="bg-white w-full max-w-2xl rounded-2xl p-6 shadow-2xl border border-slate-100 max-h-[90vh] overflow-y-auto">
                <!-- Modal Header -->
                <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                    <div class="flex items-center gap-2.5">
                        <span class="px-2.5 py-1 rounded-full text-xs font-mono font-bold bg-slate-100 text-slate-700" x-text="'#TK-' + String(selectedFeedback?.id).padStart(4, '0')"></span>
                        <template x-if="selectedFeedback?.status === 'baru'">
                            <span class="px-2.5 py-0.5 rounded-full text-xs font-bold bg-amber-100 text-amber-800 border border-amber-200">BARU</span>
                        </template>
                        <template x-if="selectedFeedback?.status !== 'baru'">
                            <span class="px-2.5 py-0.5 rounded-full text-xs font-semibold bg-emerald-100 text-emerald-800 border border-emerald-200" x-text="selectedFeedback?.status === 'selesai' ? 'Selesai' : 'Sudah Dibaca'"></span>
                        </template>
                    </div>
                    <button type="button" @click="detailModalOpen = false" class="p-1 rounded-lg text-slate-400 hover:text-slate-700">
                        <span class="material-symbols-outlined text-[20px]">close</span>
                    </button>
                </div>

                <!-- Subjek & Metadata Warga -->
                <div class="mt-4 space-y-4">
                    <div>
                        <h2 class="text-xl font-bold text-slate-800 leading-snug" x-text="selectedFeedback?.subjek"></h2>
                        <div class="mt-2 grid grid-cols-1 sm:grid-cols-2 gap-2 text-xs bg-slate-50 p-3.5 rounded-xl border border-slate-200/70">
                            <div>
                                <span class="text-slate-400 block text-[11px]">Nama Pengirim:</span>
                                <span class="font-bold text-slate-800" x-text="selectedFeedback?.nama_pengirim"></span>
                            </div>
                            <div>
                                <span class="text-slate-400 block text-[11px]">Kontak WhatsApp / Email:</span>
                                <span class="font-mono font-semibold text-slate-800" x-text="selectedFeedback?.kontak"></span>
                            </div>
                            <div>
                                <span class="text-slate-400 block text-[11px]">Klaster Layanan:</span>
                                <span class="font-medium text-slate-700" x-text="selectedFeedback?.klaster_nama"></span>
                            </div>
                            <div>
                                <span class="text-slate-400 block text-[11px]">Waktu Masuk:</span>
                                <span class="font-medium text-slate-700" x-text="selectedFeedback?.waktu_masuk"></span>
                            </div>
                        </div>
                    </div>

                    <!-- Isi Pesan Lengkap -->
                    <div>
                        <span class="text-xs font-bold text-slate-700 block mb-1.5 uppercase tracking-wider">Isi Masukan / Saran Lengkap:</span>
                        <div class="p-4 rounded-xl bg-slate-50 border border-slate-200 text-sm text-slate-700 leading-relaxed whitespace-pre-line" x-text="selectedFeedback?.isi_pesan"></div>
                    </div>

                    <!-- Form Catatan Tindak Lanjut & Ubah Status -->
                    <form :action="selectedFeedback?.read_url" method="POST" class="space-y-3 pt-2">
                        @csrf
                        @method('PATCH')

                        <div>
                            <label for="modal_catatan_internal" class="text-xs font-bold text-slate-700 block mb-1">
                                Catatan Tindak Lanjut Petugas (Internal):
                            </label>
                            <textarea name="catatan_internal" id="modal_catatan_internal" rows="2" x-model="selectedFeedback.catatan_internal" placeholder="Tuliskan respon atau tindakan yang telah diambil..." class="w-full p-2.5 rounded-xl border-slate-200 text-xs text-slate-800 focus:border-[#2E7D32] focus:ring-[#2E7D32]"></textarea>
                        </div>

                        <div class="flex items-center justify-between flex-wrap gap-3 pt-3 border-t border-slate-100">
                            <!-- Tombol Balas via WhatsApp -->
                            <a :href="getWhatsAppLink(selectedFeedback)" 
                               target="_blank" 
                               class="h-10 px-4 rounded-xl text-white text-xs font-bold shadow-sm flex items-center gap-1.5 transition-all hover:opacity-95" 
                               style="background-color: #25D366;">
                                <span class="material-symbols-outlined text-[18px]">chat</span>
                                <span>Balas via WhatsApp</span>
                            </a>

                            <div class="flex items-center gap-2">
                                <input type="hidden" name="status" value="dibaca">
                                
                                <button type="submit" class="h-10 px-4 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold shadow-sm transition-colors flex items-center gap-1">
                                    <span class="material-symbols-outlined text-[16px]">check</span>
                                    <span>Tandai Sudah Dibaca</span>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
