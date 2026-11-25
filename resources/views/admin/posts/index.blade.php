<x-admin-layout title="Kelola Informasi">
    <div class="space-y-6" x-data="{ 
        deleteModalOpen: false, 
        deleteUrl: '', 
        deleteTitle: '',
        previewModalOpen: false,
        previewData: { judul: '', tipe: '', klaster: '', author: '', tanggal: '', thumbnail: '', isi: '' },
        openDeleteModal(url, title) {
            this.deleteUrl = url;
            this.deleteTitle = title;
            this.deleteModalOpen = true;
        },
        openPreview(post) {
            this.previewData = post;
            this.previewModalOpen = true;
        }
    }">
        <!-- Top Breadcrumb & Title Section -->
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div class="space-y-1">
                <div class="flex items-center gap-1.5 text-xs text-slate-500 font-medium">
                    <span>Admin Portal</span>
                    <span class="material-symbols-outlined text-[14px]">chevron_right</span>
                    <span>UPTD Puskesmas Cilimus</span>
                    <span class="material-symbols-outlined text-[14px]">chevron_right</span>
                    <span class="text-[#2E7D32] font-semibold">Kelola Informasi</span>
                </div>
                <h1 class="text-2xl font-bold text-slate-800 tracking-tight">Kelola Informasi &amp; Konten Publikasi</h1>
                <p class="text-sm text-slate-500 max-w-2xl leading-relaxed">
                    Manajemen dan kurasi publikasi laporan program kerja, edukasi kesehatan masyarakat, serta agenda posyandu terintegrasi di wilayah kerja Kecamatan Cilimus.
                </p>
            </div>
            <div class="flex items-center gap-3 self-start md:self-auto">
                <a href="{{ route('admin.posts.create') }}" class="h-11 px-5 rounded-xl text-white font-bold flex items-center gap-2 shadow-sm transition-all hover:opacity-95" style="background-color: #2E7D32;">
                    <span class="material-symbols-outlined text-[20px]">add_circle</span>
                    <span>+ Tambah Konten Baru</span>
                </a>
            </div>
        </div>

        <!-- 4 Summary Metric Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-sm flex items-center justify-between">
                <div>
                    <span class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Total Publikasi</span>
                    <h3 class="text-2xl font-bold text-slate-800 mt-1">{{ $totalPosts }}</h3>
                    <p class="text-xs text-emerald-600 font-medium flex items-center gap-1 mt-0.5">
                        <span class="material-symbols-outlined text-[14px]">article</span> Laporan &bull; Berita &bull; Agenda
                    </p>
                </div>
                <div class="w-12 h-12 rounded-xl bg-slate-100 flex items-center justify-center text-slate-700">
                    <span class="material-symbols-outlined text-[24px]">library_books</span>
                </div>
            </div>

            <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-sm flex items-center justify-between">
                <div>
                    <span class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Terbit (Live)</span>
                    <h3 class="text-2xl font-bold text-emerald-700 mt-1">{{ $publishedPosts }}</h3>
                    <p class="text-xs text-slate-500 mt-0.5">Akses publik aktif</p>
                </div>
                <div class="w-12 h-12 rounded-xl bg-emerald-50 flex items-center justify-center text-emerald-600">
                    <span class="material-symbols-outlined text-[24px]">check_circle</span>
                </div>
            </div>

            <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-sm flex items-center justify-between">
                <div>
                    <span class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Draf Internal</span>
                    <h3 class="text-2xl font-bold text-amber-600 mt-1">{{ $draftPosts }}</h3>
                    <p class="text-xs text-slate-500 mt-0.5">Belum dipublikasikan</p>
                </div>
                <div class="w-12 h-12 rounded-xl bg-amber-50 flex items-center justify-center text-amber-600">
                    <span class="material-symbols-outlined text-[24px]">edit_note</span>
                </div>
            </div>

            <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-sm flex items-center justify-between">
                <div>
                    <span class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Total Tayangan</span>
                    <h3 class="text-2xl font-bold text-slate-800 mt-1">{{ number_format($totalViews) }}</h3>
                    <p class="text-xs text-[#2E7D32] font-medium flex items-center gap-1 mt-0.5">
                        <span class="material-symbols-outlined text-[14px]">visibility</span> Dibaca oleh warga
                    </p>
                </div>
                <div class="w-12 h-12 rounded-xl bg-emerald-50 flex items-center justify-center text-[#2E7D32]">
                    <span class="material-symbols-outlined text-[24px]">query_stats</span>
                </div>
            </div>
        </div>

        <!-- Filter & Search Toolbar -->
        <div class="bg-white p-4 rounded-2xl border border-slate-200/80 shadow-sm">
            <form method="GET" action="{{ route('admin.posts.index') }}" class="flex flex-col lg:flex-row items-stretch lg:items-center justify-between gap-3">
                <div class="relative flex-1">
                    <span class="material-symbols-outlined absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-[20px]">search</span>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari judul konten atau kata kunci..." class="w-full h-11 pl-10 pr-4 rounded-xl bg-slate-50 border border-slate-200 text-sm text-slate-800 placeholder:text-slate-400 focus:bg-white focus:border-[#2E7D32] focus:ring-[#2E7D32] transition-all">
                </div>

                <div class="flex flex-wrap items-center gap-2.5">
                    <!-- Filter Tipe -->
                    <div class="min-w-[140px]">
                        <select name="tipe" class="w-full h-11 px-3 rounded-xl bg-slate-50 border border-slate-200 text-xs font-medium text-slate-700 focus:bg-white focus:border-[#2E7D32] focus:ring-[#2E7D32] cursor-pointer">
                            <option value="">Semua Tipe</option>
                            <option value="berita" {{ request('tipe') === 'berita' ? 'selected' : '' }}>📰 Berita Kesehatan</option>
                            <option value="laporan" {{ request('tipe') === 'laporan' ? 'selected' : '' }}>📄 Laporan Program</option>
                            <option value="agenda" {{ request('tipe') === 'agenda' ? 'selected' : '' }}>📅 Agenda Kegiatan</option>
                        </select>
                    </div>

                    <!-- Filter Klaster -->
                    <div class="min-w-[180px]">
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
                    <div class="min-w-[140px]">
                        <select name="status" class="w-full h-11 px-3 rounded-xl bg-slate-50 border border-slate-200 text-xs font-medium text-slate-700 focus:bg-white focus:border-[#2E7D32] focus:ring-[#2E7D32] cursor-pointer">
                            <option value="">Semua Status</option>
                            <option value="published" {{ request('status') === 'published' ? 'selected' : '' }}>Published (Terbit)</option>
                            <option value="draft" {{ request('status') === 'draft' ? 'selected' : '' }}>Draft (Konsep)</option>
                        </select>
                    </div>

                    <button type="submit" class="h-11 px-4 rounded-xl bg-slate-800 text-white text-xs font-semibold hover:bg-slate-900 transition-colors flex items-center gap-1.5 shadow-sm">
                        <span class="material-symbols-outlined text-[16px]">filter_list</span>
                        <span>Filter</span>
                    </button>

                    @if(request()->anyFilled(['search', 'tipe', 'klaster_id', 'status']))
                        <a href="{{ route('admin.posts.index') }}" class="h-11 px-3 rounded-xl border border-slate-200 text-xs font-medium text-slate-500 hover:text-slate-800 hover:bg-slate-50 flex items-center transition-colors">
                            Reset
                        </a>
                    @endif
                </div>
            </form>
        </div>

        <!-- Table Data Section -->
        <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm overflow-hidden flex flex-col">
            <div class="overflow-x-auto w-full">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50/80 border-b border-slate-200 text-slate-500 text-xs uppercase tracking-wider font-semibold">
                            <th class="py-4 px-4 w-12 text-center">No</th>
                            <th class="py-4 px-3 w-20">Thumbnail</th>
                            <th class="py-4 px-4">Judul Post &amp; Penulis</th>
                            <th class="py-4 px-3">Tipe</th>
                            <th class="py-4 px-3">Klaster Layanan</th>
                            <th class="py-4 px-3 text-center">Status</th>
                            <th class="py-4 px-4">Tanggal Dibuat</th>
                            <th class="py-4 px-4 text-right sticky right-0 z-20 bg-slate-50 shadow-[-4px_0_6px_-2px_rgba(0,0,0,0.06)] min-w-[140px]">
                                Aksi
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-sm">
                        @forelse($posts as $index => $post)
                            <tr class="hover:bg-slate-50/70 transition-colors group">
                                <!-- No -->
                                <td class="py-4 px-4 text-center text-xs font-mono text-slate-400">
                                    {{ $posts->firstItem() + $index }}
                                </td>

                                <!-- Thumbnail (w-20) -->
                                <td class="py-4 px-3">
                                    <div class="w-20 h-14 rounded-lg overflow-hidden bg-slate-100 border border-slate-200 flex-shrink-0 flex items-center justify-center">
                                        @if($post->foto_thumbnail)
                                            <img src="{{ asset('storage/' . $post->foto_thumbnail) }}" alt="{{ $post->judul }}" class="w-full h-full object-cover">
                                        @else
                                            <div class="text-slate-400 flex flex-col items-center justify-center">
                                                <span class="material-symbols-outlined text-[20px]">
                                                    @if($post->tipe === 'laporan') picture_as_pdf
                                                    @elseif($post->tipe === 'agenda') event
                                                    @else article
                                                    @endif
                                                </span>
                                            </div>
                                        @endif
                                    </div>
                                </td>

                                <!-- Judul Post & Penulis -->
                                <td class="py-4 px-4 min-w-[260px] max-w-md">
                                    <div class="font-bold text-slate-800 line-clamp-1 group-hover:text-[#2E7D32] transition-colors">
                                        {{ $post->judul }}
                                    </div>
                                    <div class="flex items-center gap-1.5 mt-1 text-xs text-slate-400">
                                        <span class="material-symbols-outlined text-[13px]">person</span>
                                        <span class="truncate">{{ $post->author->nama_lengkap ?? 'Petugas Puskesmas' }}</span>
                                        <span>&bull;</span>
                                        <span class="flex items-center gap-0.5">
                                            <span class="material-symbols-outlined text-[12px]">visibility</span>
                                            {{ number_format($post->views) }}
                                        </span>
                                    </div>
                                </td>

                                <!-- Tipe Badge -->
                                <td class="py-4 px-3 whitespace-nowrap">
                                    @if($post->tipe === 'laporan')
                                        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                            <span class="material-symbols-outlined text-[14px]">assignment_turned_in</span>
                                            Laporan
                                        </span>
                                    @elseif($post->tipe === 'agenda')
                                        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-semibold bg-amber-50 text-amber-700 border border-amber-200">
                                            <span class="material-symbols-outlined text-[14px]">event</span>
                                            Agenda
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-semibold bg-green-50 text-[#2E7D32] border border-green-200">
                                            <span class="material-symbols-outlined text-[14px]">newspaper</span>
                                            Berita
                                        </span>
                                    @endif
                                </td>

                                <!-- Klaster Badge -->
                                <td class="py-4 px-3 whitespace-nowrap">
                                    @if($post->klaster)
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-slate-100 text-slate-700 border border-slate-200">
                                            {{ $post->klaster->nama }}
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-slate-50 text-slate-400 border border-slate-200">
                                            Umum / Lintas
                                        </span>
                                    @endif
                                </td>

                                <!-- Status Badge -->
                                <td class="py-4 px-3 text-center whitespace-nowrap">
                                    @if($post->status === 'published')
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-800 border border-emerald-200">
                                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-600 animate-pulse"></span>
                                            Terbit
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-xs font-semibold bg-slate-100 text-slate-600 border border-slate-200">
                                            <span class="w-1.5 h-1.5 rounded-full bg-slate-400"></span>
                                            Draft
                                        </span>
                                    @endif
                                </td>

                                <!-- Tanggal Dibuat -->
                                <td class="py-4 px-4 whitespace-nowrap text-xs text-slate-500">
                                    <div>{{ $post->created_at->format('d M Y') }}</div>
                                    <div class="text-[11px] text-slate-400">{{ $post->created_at->format('H:i') }} WIB</div>
                                </td>

                                <!-- Kolom Aksi STICKY RIGHT -->
                                <td class="py-4 px-4 text-right whitespace-nowrap sticky right-0 z-10 bg-white group-hover:bg-slate-50 shadow-[-4px_0_6px_-2px_rgba(0,0,0,0.06)]">
                                    <div class="inline-flex items-center gap-1 justify-end">
                                        <!-- Tombol Pratinjau (lihat di publik / modal ringkas) -->
                                        <button type="button" 
                                            @click="openPreview({
                                                judul: '{{ addslashes($post->judul) }}',
                                                tipe: '{{ $post->tipe }}',
                                                klaster: '{{ $post->klaster->nama ?? 'Pengumuman Umum' }}',
                                                author: '{{ $post->author->nama_lengkap ?? 'Petugas Puskesmas' }}',
                                                tanggal: '{{ $post->created_at->format('d M Y, H:i') }} WIB',
                                                thumbnail: '{{ $post->foto_thumbnail ? asset('storage/' . $post->foto_thumbnail) : '' }}',
                                                isi: '{{ addslashes(strip_tags($post->isi)) }}'
                                            })"
                                            class="p-2 rounded-lg text-slate-500 hover:text-[#2E7D32] hover:bg-emerald-50 transition-colors" 
                                            title="Pratinjau Konten">
                                            <span class="material-symbols-outlined text-[18px]">visibility</span>
                                        </button>

                                        <!-- Tombol Edit -->
                                        <a href="{{ route('admin.posts.edit', $post) }}" 
                                            class="p-2 rounded-lg text-slate-500 hover:text-[#2E7D32] hover:bg-emerald-50 transition-colors" 
                                            title="Edit Postingan">
                                            <span class="material-symbols-outlined text-[18px]">edit</span>
                                        </a>

                                        <!-- Tombol Hapus (Modal Konfirmasi) -->
                                        <button type="button" 
                                            @click="openDeleteModal('{{ route('admin.posts.destroy', $post) }}', '{{ addslashes($post->judul) }}')"
                                            class="p-2 rounded-lg text-slate-500 hover:text-rose-600 hover:bg-rose-50 transition-colors" 
                                            title="Hapus Postingan">
                                            <span class="material-symbols-outlined text-[18px]">delete</span>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="py-12 px-6 text-center text-slate-400">
                                    <div class="flex flex-col items-center justify-center">
                                        <div class="w-12 h-12 rounded-full bg-slate-100 flex items-center justify-center text-slate-400 mb-3">
                                            <span class="material-symbols-outlined text-[26px]">article</span>
                                        </div>
                                        <p class="font-semibold text-slate-600">Belum ada konten publikasi ditemukan.</p>
                                        <p class="text-xs text-slate-400 mt-1">Coba sesuaikan kata kunci pencarian atau buat postingan baru.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination Bar -->
            @if($posts->hasPages())
                <div class="p-4 border-t border-slate-100 bg-slate-50/50">
                    {{ $posts->links() }}
                </div>
            @endif
        </div>

        <!-- MODAL KONFIRMASI HAPUS (Alpine.js) -->
        <div x-show="deleteModalOpen" 
             x-cloak 
             class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm"
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-150"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0">
            <div @click.away="deleteModalOpen = false" class="bg-white w-full max-w-md rounded-2xl p-6 shadow-2xl border border-slate-100 transform transition-all">
                <div class="flex items-start gap-4">
                    <div class="w-11 h-11 rounded-full bg-rose-100 text-rose-600 flex items-center justify-center flex-shrink-0">
                        <span class="material-symbols-outlined text-[24px]">warning</span>
                    </div>
                    <div>
                        <h3 class="text-base font-bold text-slate-800">Hapus Konten Publikasi?</h3>
                        <p class="text-xs text-slate-500 mt-1 leading-relaxed">
                            Tindakan ini tidak dapat dibatalkan. Berkas lampiran dan foto sampul terkait juga akan dihapus dari server.
                        </p>
                        <div class="mt-3 p-3 rounded-xl bg-slate-50 border border-slate-200 text-xs font-semibold text-slate-700 truncate" x-text="deleteTitle"></div>
                    </div>
                </div>

                <div class="mt-6 flex items-center justify-end gap-3">
                    <button type="button" @click="deleteModalOpen = false" class="px-4 py-2.5 rounded-xl border border-slate-200 text-xs font-semibold text-slate-600 hover:bg-slate-50 transition-colors">
                        Batal
                    </button>
                    <form :action="deleteUrl" method="POST" class="inline-block">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="px-4 py-2.5 rounded-xl bg-rose-600 hover:bg-rose-700 text-white text-xs font-semibold shadow-sm transition-colors flex items-center gap-1.5">
                            <span class="material-symbols-outlined text-[16px]">delete</span>
                            <span>Ya, Hapus Postingan</span>
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- MODAL PRATINJAU KONTEN CEPAT (Alpine.js) -->
        <div x-show="previewModalOpen" 
             x-cloak 
             class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm"
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-150"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0">
            <div @click.away="previewModalOpen = false" class="bg-white w-full max-w-2xl rounded-2xl p-6 shadow-2xl border border-slate-100 max-h-[85vh] overflow-y-auto">
                <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                    <div class="flex items-center gap-2">
                        <span class="px-2.5 py-0.5 rounded-full text-xs font-semibold uppercase bg-emerald-50 text-emerald-800" x-text="previewData.tipe"></span>
                        <span class="text-xs text-slate-400" x-text="previewData.klaster"></span>
                    </div>
                    <button type="button" @click="previewModalOpen = false" class="p-1 rounded-lg text-slate-400 hover:text-slate-700 hover:bg-slate-100">
                        <span class="material-symbols-outlined text-[20px]">close</span>
                    </button>
                </div>

                <div class="mt-4 space-y-4">
                    <h2 class="text-lg font-bold text-slate-800 leading-snug" x-text="previewData.judul"></h2>
                    
                    <div class="flex items-center gap-3 text-xs text-slate-400 pb-2 border-b border-slate-100">
                        <span class="flex items-center gap-1">
                            <span class="material-symbols-outlined text-[14px]">person</span>
                            <span x-text="previewData.author"></span>
                        </span>
                        <span>&bull;</span>
                        <span class="flex items-center gap-1">
                            <span class="material-symbols-outlined text-[14px]">schedule</span>
                            <span x-text="previewData.tanggal"></span>
                        </span>
                    </div>

                    <template x-if="previewData.thumbnail">
                        <div class="rounded-xl overflow-hidden max-h-60 bg-slate-100 border border-slate-200">
                            <img :src="previewData.thumbnail" class="w-full h-full object-cover">
                        </div>
                    </template>

                    <div class="text-sm text-slate-600 leading-relaxed max-h-48 overflow-y-auto p-3 bg-slate-50 rounded-xl whitespace-pre-line" x-text="previewData.isi"></div>
                </div>

                <div class="mt-6 flex justify-end">
                    <button type="button" @click="previewModalOpen = false" class="px-4 py-2 rounded-xl bg-slate-800 text-white text-xs font-semibold hover:bg-slate-900">
                        Tutup Pratinjau
                    </button>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
