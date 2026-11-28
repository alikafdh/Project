@php
    $homeUrl = \Illuminate\Support\Facades\Route::has('public.home') ? route('public.home') : url('/');
    $postsIndexUrl = \Illuminate\Support\Facades\Route::has('public.posts.index') ? route('public.posts.index') : url('/informasi');
    $hasPostShow = \Illuminate\Support\Facades\Route::has('public.posts.show');
    $hasPostDownload = \Illuminate\Support\Facades\Route::has('public.posts.download');

    $badgeStyle = match ($post->tipe) {
        'laporan' => ['bg' => 'bg-[#ECFDF5] text-[#15803D]', 'label' => 'LAPORAN PROGRAM KERJA', 'grad' => 'from-[#003822] to-[#2E7D32]', 'icon' => 'analytics'],
        'agenda' => ['bg' => 'bg-[#FFF7ED] text-[#EA580C]', 'label' => 'AGENDA KEGIATAN', 'grad' => 'from-orange-600 to-amber-600', 'icon' => 'event'],
        default => ['bg' => 'bg-[#EFF6FF] text-[#1D4ED8]', 'label' => 'BERITA KESEHATAN', 'grad' => 'from-blue-700 to-indigo-700', 'icon' => 'newspaper'],
    };

    $wordCount = str_word_count(strip_tags($post->isi ?? ''));
    $readMinutes = max(1, (int) ceil($wordCount / 200));

    $thumbExists = ! empty($post->foto_thumbnail) && file_exists(public_path('storage/' . $post->foto_thumbnail));

    $pdfExists = ! empty($post->file_pdf) && \Illuminate\Support\Facades\Storage::disk('public')->exists($post->file_pdf);
    $pdfSizeLabel = $pdfExists
        ? number_format(\Illuminate\Support\Facades\Storage::disk('public')->size($post->file_pdf) / 1024, 0) . ' KB'
        : 'Dokumen Resmi PDF';

    $downloadUrl = $hasPostDownload
        ? route('public.posts.download', $post->slug)
        : url('/informasi/' . $post->slug . '/unduh-pdf');

    $shareUrl = urlencode(url()->current());
    $shareTitle = urlencode($post->judul);
@endphp

<x-app-layout>
    <x-slot name="title">{{ $post->judul }}</x-slot>

    <section class="py-10 lg:py-14 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-10">
            {{-- ================================================================= --}}
            {{-- KOLOM UTAMA (70% -> lg:col-span-8)                                --}}
            {{-- ================================================================= --}}
            <article class="lg:col-span-8 space-y-6">
                {{-- Breadcrumb Hierarkis --}}
                <nav aria-label="Breadcrumb" class="flex flex-wrap items-center gap-2 text-xs text-slate-500 font-medium">
                    <a href="{{ $homeUrl }}" class="hover:text-[#2E7D32] transition-colors inline-flex items-center gap-1">
                        <span class="material-symbols-outlined text-[15px]">home</span>
                        <span>Beranda</span>
                    </a>
                    <span>/</span>
                    <a href="{{ $postsIndexUrl }}" class="hover:text-[#2E7D32] transition-colors">Informasi &amp; Publikasi</a>
                    <span>/</span>
                    <a href="{{ $postsIndexUrl . '?tipe=' . $post->tipe }}" class="hover:text-[#2E7D32] transition-colors capitalize">{{ $post->tipe }}</a>
                    <span>/</span>
                    <span class="text-slate-800 font-semibold truncate max-w-xs">{{ $post->judul }}</span>
                </nav>

                {{-- Badge Tipe + Badge Klaster --}}
                <div class="flex flex-wrap items-center gap-2">
                    <span class="px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider {{ $badgeStyle['bg'] }}">
                        {{ $badgeStyle['label'] }}
                    </span>
                    @if($post->klaster)
                        <span class="px-3 py-1 rounded-full bg-slate-100 text-slate-700 text-xs font-semibold">
                            {{ $post->klaster->nama }}
                        </span>
                    @endif
                </div>

                {{-- Judul H1 Besar dan Tebal --}}
                <h1 class="text-2xl sm:text-3xl lg:text-4xl font-extrabold text-slate-900 leading-tight tracking-tight">
                    {{ $post->judul }}
                </h1>

                {{-- Meta Row --}}
                <div class="flex flex-wrap items-center gap-x-5 gap-y-2 py-3 border-y border-slate-200 text-xs sm:text-sm text-slate-600">
                    <span class="inline-flex items-center gap-1.5">
                        <span class="material-symbols-outlined text-[17px] text-[#2E7D32]">calendar_today</span>
                        <span>{{ $post->created_at->translatedFormat('d F Y') }}</span>
                    </span>
                    <span class="inline-flex items-center gap-1.5">
                        <span class="material-symbols-outlined text-[17px] text-[#2E7D32]">person</span>
                        <span>{{ $post->author->nama_lengkap ?? 'Humas Puskesmas' }}</span>
                    </span>
                    @if($post->klaster)
                        <span class="inline-flex items-center gap-1.5">
                            <span class="material-symbols-outlined text-[17px] text-[#2E7D32]">hub</span>
                            <span>{{ $post->klaster->nama }}</span>
                        </span>
                    @endif
                    <span class="inline-flex items-center gap-1.5">
                        <span class="material-symbols-outlined text-[17px] text-[#2E7D32]">schedule</span>
                        <span>{{ $readMinutes }} menit baca</span>
                    </span>
                </div>

                {{-- Foto Utama Resolusi Tinggi --}}
                <figure class="overflow-hidden rounded-2xl shadow-sm border border-slate-200 bg-gradient-to-br {{ $badgeStyle['grad'] }}">
                    @if($thumbExists)
                        <img src="{{ asset('storage/' . $post->foto_thumbnail) }}"
                             alt="{{ $post->judul }}"
                             class="aspect-video w-full object-cover rounded-2xl">
                    @else
                        <div class="aspect-video w-full flex flex-col items-center justify-center text-white/90 p-6">
                            <span class="material-symbols-outlined text-[56px]">{{ $badgeStyle['icon'] }}</span>
                            <span class="text-xs font-bold uppercase tracking-wider mt-2">{{ $badgeStyle['label'] }}</span>
                        </div>
                    @endif
                </figure>

                {{-- KHUSUS TIPE LAPORAN --}}
                @if($post->tipe === 'laporan')
                    <div class="space-y-4">
                        <div class="bg-[#ECFDF5] border border-emerald-200 rounded-2xl p-6 space-y-2">
                            <div class="flex items-center gap-2 text-[#15803D] text-xs font-bold uppercase tracking-wider">
                                <span class="material-symbols-outlined text-[18px]">verified</span>
                                <span>Laporan Akuntabilitas Kinerja</span>
                            </div>
                            <p class="text-sm sm:text-base text-emerald-950 font-semibold">
                                Periode Pelaksanaan: {{ $post->periode_bulan }} {{ $post->periode_tahun }}
                            </p>
                            <p class="text-xs sm:text-sm text-emerald-900/80">
                                Dokumen publikasi resmi UPTD Puskesmas Cilimus sebagai bentuk transparansi capaian program kerja kesehatan masyarakat.
                            </p>
                        </div>

                        @if($post->file_pdf)
                            <div class="bg-white border border-slate-200 rounded-2xl p-5 shadow-xs flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                                <div class="flex items-center gap-4 min-w-0">
                                    <div class="w-12 h-12 rounded-xl bg-rose-50 text-rose-600 flex items-center justify-center flex-shrink-0">
                                        <span class="material-symbols-outlined text-[28px]">picture_as_pdf</span>
                                    </div>
                                    <div class="min-w-0">
                                        <p class="text-sm font-bold text-slate-900 truncate">{{ basename($post->file_pdf) }}</p>
                                        <p class="text-xs text-slate-500 mt-0.5">Format PDF • {{ $pdfSizeLabel }}</p>
                                    </div>
                                </div>

                                <a href="{{ $downloadUrl }}"
                                   class="inline-flex items-center justify-center gap-2 bg-[#2E7D32] hover:bg-[#1B5E20] text-white font-semibold px-5 py-2.5 rounded-xl text-sm flex-shrink-0 transition-colors">
                                    <span class="material-symbols-outlined text-[18px]">download</span>
                                    <span>Unduh Laporan Lengkap</span>
                                </a>
                            </div>
                        @endif
                    </div>
                @endif

                {{-- KHUSUS TIPE AGENDA --}}
                @if($post->tipe === 'agenda')
                    <div class="bg-[#FFF7ED] border border-orange-200 rounded-2xl p-6 space-y-4">
                        <div class="flex items-center gap-2 text-[#EA580C] text-xs font-bold uppercase tracking-wider">
                            <span class="material-symbols-outlined text-[18px]">event_available</span>
                            <span>Informasi Jadwal Kegiatan</span>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 text-sm">
                            <div class="bg-white/80 rounded-xl p-3.5 border border-orange-200/70">
                                <p class="text-xs font-bold text-[#EA580C] uppercase">Tanggal &amp; Waktu</p>
                                <p class="font-semibold text-slate-900 mt-1">
                                    {{ $post->waktu_kegiatan ? $post->waktu_kegiatan->translatedFormat('d F Y, H:i') . ' WIB' : '-' }}
                                </p>
                            </div>
                            <div class="bg-white/80 rounded-xl p-3.5 border border-orange-200/70">
                                <p class="text-xs font-bold text-[#EA580C] uppercase">Lokasi</p>
                                <p class="font-semibold text-slate-900 mt-1">{{ $post->lokasi_kegiatan ?? 'UPTD Puskesmas Cilimus' }}</p>
                            </div>
                            <div class="bg-white/80 rounded-xl p-3.5 border border-orange-200/70">
                                <p class="text-xs font-bold text-[#EA580C] uppercase">Sasaran</p>
                                <p class="font-semibold text-slate-900 mt-1">{{ $post->sasaran_peserta ?? 'Masyarakat Umum' }}</p>
                            </div>
                        </div>
                    </div>
                @endif

                {{-- Badan Artikel (Narasi HTML WYSIWYG) --}}
                <div class="bg-white rounded-2xl p-6 sm:p-8 border border-slate-200/90 shadow-xs">
                    <div class="space-y-4 text-slate-700 text-base leading-relaxed [&_h2]:text-xl [&_h2]:font-bold [&_h2]:text-slate-900 [&_h3]:text-lg [&_h3]:font-bold [&_h3]:text-slate-900 [&_ul]:list-disc [&_ul]:pl-5 [&_ol]:list-decimal [&_ol]:pl-5 [&_blockquote]:border-l-4 [&_blockquote]:border-[#2E7D32] [&_blockquote]:pl-4 [&_blockquote]:italic [&_a]:text-[#2E7D32] [&_a]:underline">
                        {!! $post->isi !!}
                    </div>
                </div>

                {{-- Tombol Bagikan (Share) --}}
                <div class="bg-white rounded-2xl p-5 border border-slate-200/90 flex flex-wrap items-center justify-between gap-4">
                    <span class="text-sm font-bold text-slate-800">Bagikan informasi ini:</span>
                    <div class="flex flex-wrap items-center gap-3">
                        <a href="https://wa.me/?text={{ $shareTitle }}%20{{ $shareUrl }}"
                           target="_blank"
                           rel="noopener noreferrer"
                           class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-[#25D366] hover:bg-[#1ebe5d] text-white text-xs sm:text-sm font-semibold transition-colors">
                            <span>WhatsApp</span>
                        </a>
                        <a href="https://www.facebook.com/sharer/sharer.php?u={{ $shareUrl }}"
                           target="_blank"
                           rel="noopener noreferrer"
                           class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-[#1877F2] hover:bg-[#1565d8] text-white text-xs sm:text-sm font-semibold transition-colors">
                            <span>Facebook</span>
                        </a>
                    </div>
                </div>
            </article>

            {{-- ================================================================= --}}
            {{-- SIDEBAR STICKY (30% -> lg:col-span-4)                             --}}
            {{-- ================================================================= --}}
            <aside class="lg:col-span-4 lg:sticky lg:top-28 space-y-6 self-start">
                {{-- Widget 1: Kategori Informasi --}}
                <div class="bg-white rounded-2xl p-6 border border-slate-200/90 shadow-xs space-y-4">
                    <h2 class="text-base font-bold text-slate-900 flex items-center gap-2">
                        <span class="material-symbols-outlined text-[20px] text-[#2E7D32]">category</span>
                        <span>Kategori Informasi</span>
                    </h2>
                    <ul class="space-y-2 text-sm">
                        <li>
                            <a href="{{ $postsIndexUrl . '?tipe=laporan' }}"
                               class="flex items-center justify-between px-3.5 py-2.5 rounded-xl bg-[#ECFDF5] text-[#15803D] font-semibold hover:bg-emerald-100 transition-colors">
                                <span>Laporan Program Kerja</span>
                                <span class="material-symbols-outlined text-[18px]">chevron_right</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ $postsIndexUrl . '?tipe=berita' }}"
                               class="flex items-center justify-between px-3.5 py-2.5 rounded-xl bg-[#EFF6FF] text-[#1D4ED8] font-semibold hover:bg-blue-100 transition-colors">
                                <span>Berita Kesehatan</span>
                                <span class="material-symbols-outlined text-[18px]">chevron_right</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ $postsIndexUrl . '?tipe=agenda' }}"
                               class="flex items-center justify-between px-3.5 py-2.5 rounded-xl bg-[#FFF7ED] text-[#EA580C] font-semibold hover:bg-orange-100 transition-colors">
                                <span>Agenda Kegiatan</span>
                                <span class="material-symbols-outlined text-[18px]">chevron_right</span>
                            </a>
                        </li>
                    </ul>
                </div>

                {{-- Widget 2: 5 Artikel & Publikasi Terbaru --}}
                <div class="bg-white rounded-2xl p-6 border border-slate-200/90 shadow-xs space-y-4">
                    <h2 class="text-base font-bold text-slate-900 flex items-center gap-2">
                        <span class="material-symbols-outlined text-[20px] text-[#2E7D32]">newspaper</span>
                        <span>Artikel &amp; Publikasi Terbaru</span>
                    </h2>

                    <div class="space-y-3">
                        @forelse($artikelTerbaru as $item)
                            @php
                                $itemThumbExists = ! empty($item->foto_thumbnail) && file_exists(public_path('storage/' . $item->foto_thumbnail));
                                $itemUrl = $hasPostShow ? route('public.posts.show', $item->slug) : url('/informasi/' . $item->slug);
                            @endphp
                            <a href="{{ $itemUrl }}"
                               class="group flex items-start gap-3 p-2 rounded-xl hover:bg-slate-50 transition-colors">
                                <div class="w-16 h-12 rounded-lg bg-emerald-700 overflow-hidden flex-shrink-0 flex items-center justify-center text-white">
                                    @if($itemThumbExists)
                                        <img src="{{ asset('storage/' . $item->foto_thumbnail) }}"
                                             alt="{{ $item->judul }}"
                                             class="w-full h-full object-cover">
                                    @else
                                        <span class="material-symbols-outlined text-[20px]">article</span>
                                    @endif
                                </div>
                                <div class="min-w-0 flex-1">
                                    <p class="text-xs font-bold text-slate-900 group-hover:text-[#2E7D32] line-clamp-2 leading-snug">
                                        {{ $item->judul }}
                                    </p>
                                    <p class="text-[11px] text-slate-500 mt-1">
                                        {{ $item->created_at->format('d M Y') }}
                                    </p>
                                </div>
                            </a>
                        @empty
                            <p class="text-xs text-slate-500">Belum ada publikasi lainnya.</p>
                        @endforelse
                    </div>
                </div>

                {{-- Widget 3: Tautan 5 Klaster ILP Puskesmas --}}
                <div class="bg-white rounded-2xl p-6 border border-slate-200/90 shadow-xs space-y-4">
                    <h2 class="text-base font-bold text-slate-900 flex items-center gap-2">
                        <span class="material-symbols-outlined text-[20px] text-[#2E7D32]">hub</span>
                        <span>Klaster ILP Puskesmas</span>
                    </h2>

                    <ul class="space-y-2 text-sm">
                        @foreach($klasters as $k)
                            <li>
                                <a href="{{ $postsIndexUrl . '?klaster=' . $k->slug }}"
                                   class="flex items-center justify-between gap-2 px-3 py-2 rounded-xl border border-slate-200/70 hover:border-[#2E7D32] hover:bg-emerald-50/50 text-slate-700 hover:text-[#003822] transition-all">
                                    <span class="text-xs font-semibold truncate">{{ $k->nama }}</span>
                                    <span class="px-2 py-0.5 rounded-full bg-slate-100 text-slate-600 text-[11px] font-bold">
                                        {{ $k->posts_count ?? 0 }}
                                    </span>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </aside>
        </div>
    </section>
</x-app-layout>
