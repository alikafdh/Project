@php
    $homeUrl = \Illuminate\Support\Facades\Route::has('public.home') ? route('public.home') : url('/');
    $postsIndexUrl = \Illuminate\Support\Facades\Route::has('public.posts.index') ? route('public.posts.index') : url('/informasi');
    $hasPostShow = \Illuminate\Support\Facades\Route::has('public.posts.show');

    $activeTipe = request('tipe');
    $bulanList = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
    $tahunList = range((int) date('Y') + 1, 2023);
@endphp

<x-app-layout>
    <x-slot name="title">Informasi &amp; Publikasi</x-slot>

    {{-- ======================================================================= --}}
    {{-- HERO BANNER (#003822)                                                   --}}
    {{-- ======================================================================= --}}
    <section class="relative overflow-hidden bg-[#003822] text-white py-12 lg:py-16">
        <div class="absolute -right-20 -top-20 w-80 h-80 rounded-full bg-emerald-400/10 blur-3xl pointer-events-none"></div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 space-y-4">
            <nav aria-label="Breadcrumb" class="flex items-center gap-2 text-xs text-emerald-200/90 font-medium">
                <a href="{{ $homeUrl }}" class="hover:text-white transition-colors inline-flex items-center gap-1">
                    <span class="material-symbols-outlined text-[15px]">home</span>
                    <span>Beranda</span>
                </a>
                <span>/</span>
                <span class="text-white font-semibold">Informasi &amp; Publikasi</span>
            </nav>

            <span class="inline-block px-3 py-1 rounded-full bg-white/10 border border-white/15 text-emerald-200 text-xs font-semibold uppercase tracking-wider">
                Portal Transparansi &amp; Edukasi Kesehatan
            </span>

            <h1 class="text-3xl sm:text-4xl font-extrabold tracking-tight text-white">
                Informasi &amp; Publikasi
            </h1>
            <p class="text-sm sm:text-base text-emerald-50/90 max-w-2xl leading-relaxed">
                Laporan kerja, berita kesehatan, dan agenda kegiatan puskesmas
            </p>
        </div>
    </section>

    {{-- ======================================================================= --}}
    {{-- BILAH PENCARIAN, FILTER & FEED INFORMASI                                --}}
    {{-- ======================================================================= --}}
    <section class="py-12 lg:py-16 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-10">
        {{-- Bilah Pencarian & Filter --}}
        <div class="bg-white rounded-2xl p-5 sm:p-6 border border-slate-200/90 shadow-xs space-y-5">
            {{-- 4 Tab Filter Tipe --}}
            <div class="flex flex-wrap items-center gap-2 border-b border-slate-100 pb-4">
                <a href="{{ $postsIndexUrl }}"
                   class="px-4 py-2 rounded-full text-xs sm:text-sm font-semibold transition-all {{ empty($activeTipe) ? 'bg-[#2E7D32] text-white shadow-xs' : 'bg-slate-100 text-slate-700 hover:bg-emerald-50 hover:text-[#2E7D32]' }}">
                    Semua
                </a>
                <a href="{{ $postsIndexUrl . '?tipe=laporan' }}"
                   class="px-4 py-2 rounded-full text-xs sm:text-sm font-semibold transition-all {{ $activeTipe === 'laporan' ? 'bg-[#15803D] text-white shadow-xs' : 'bg-[#ECFDF5] text-[#15803D] hover:bg-emerald-100' }}">
                    Laporan Program Kerja
                </a>
                <a href="{{ $postsIndexUrl . '?tipe=berita' }}"
                   class="px-4 py-2 rounded-full text-xs sm:text-sm font-semibold transition-all {{ $activeTipe === 'berita' ? 'bg-[#1D4ED8] text-white shadow-xs' : 'bg-[#EFF6FF] text-[#1D4ED8] hover:bg-blue-100' }}">
                    Berita Kesehatan
                </a>
                <a href="{{ $postsIndexUrl . '?tipe=agenda' }}"
                   class="px-4 py-2 rounded-full text-xs sm:text-sm font-semibold transition-all {{ $activeTipe === 'agenda' ? 'bg-[#EA580C] text-white shadow-xs' : 'bg-[#FFF7ED] text-[#EA580C] hover:bg-orange-100' }}">
                    Agenda
                </a>
            </div>

            {{-- Form Search + Dropdown Klaster & Periode --}}
            <form action="{{ $postsIndexUrl }}" method="GET" class="grid grid-cols-1 md:grid-cols-12 gap-3 items-center">
                @if($activeTipe)
                    <input type="hidden" name="tipe" value="{{ $activeTipe }}">
                @endif

                <div class="md:col-span-5 relative">
                    <span class="material-symbols-outlined text-[20px] text-slate-400 absolute left-3.5 top-1/2 -translate-y-1/2 pointer-events-none">search</span>
                    <input type="text"
                           name="q"
                           value="{{ request('q') }}"
                           placeholder="Cari laporan kerja, berita gizi, jadwal posyandu..."
                           class="w-full pl-10 pr-4 py-2.5 rounded-xl border border-slate-300 text-sm text-slate-800 placeholder-slate-400 focus:border-[#2E7D32] focus:ring-[#2E7D32]">
                </div>

                <div class="md:col-span-3">
                    <select name="klaster"
                            aria-label="Filter Klaster ILP"
                            class="w-full py-2.5 px-3.5 rounded-xl border border-slate-300 text-sm text-slate-700 focus:border-[#2E7D32] focus:ring-[#2E7D32]">
                        <option value="">Semua Klaster ILP</option>
                        @foreach($klasters as $k)
                            <option value="{{ $k->slug }}" @selected(request('klaster') === $k->slug)>
                                {{ $k->nama }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="md:col-span-2">
                    <select name="bulan"
                            aria-label="Filter Periode Bulan"
                            class="w-full py-2.5 px-3.5 rounded-xl border border-slate-300 text-sm text-slate-700 focus:border-[#2E7D32] focus:ring-[#2E7D32]">
                        <option value="">Semua Bulan</option>
                        @foreach($bulanList as $bln)
                            <option value="{{ $bln }}" @selected(request('bulan') === $bln)>{{ $bln }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="md:col-span-2 flex items-center gap-2">
                    <select name="tahun"
                            aria-label="Filter Periode Tahun"
                            class="w-full py-2.5 px-3 rounded-xl border border-slate-300 text-sm text-slate-700 focus:border-[#2E7D32] focus:ring-[#2E7D32]">
                        <option value="">Tahun</option>
                        @foreach($tahunList as $thn)
                            <option value="{{ $thn }}" @selected((string) request('tahun') === (string) $thn)>{{ $thn }}</option>
                        @endforeach
                    </select>

                    <button type="submit"
                            class="px-4 py-2.5 rounded-xl bg-[#2E7D32] hover:bg-[#1B5E20] text-white text-sm font-semibold flex-shrink-0 transition-colors">
                        Cari
                    </button>
                </div>
            </form>
        </div>

        {{-- Grid 3 Kolom Card Post --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($posts as $post)
                @php
                    $thumbExists = ! empty($post->foto_thumbnail) && file_exists(public_path('storage/' . $post->foto_thumbnail));
                    $postUrl = $hasPostShow ? route('public.posts.show', $post->slug) : url('/informasi/' . $post->slug);

                    $badgeStyle = match ($post->tipe) {
                        'laporan' => ['bg' => 'bg-[#ECFDF5] text-[#15803D]', 'label' => 'LAPORAN', 'grad' => 'from-[#003822] to-[#2E7D32]', 'icon' => 'analytics'],
                        'agenda' => ['bg' => 'bg-[#FFF7ED] text-[#EA580C]', 'label' => 'AGENDA', 'grad' => 'from-orange-600 to-amber-600', 'icon' => 'event'],
                        default => ['bg' => 'bg-[#EFF6FF] text-[#1D4ED8]', 'label' => 'BERITA', 'grad' => 'from-blue-700 to-indigo-700', 'icon' => 'newspaper'],
                    };
                @endphp

                <article class="bg-white rounded-2xl p-4 border border-slate-200/90 shadow-sm hover:shadow-md hover:border-emerald-300 transition-all flex flex-col justify-between">
                    <div>
                        <a href="{{ $postUrl }}" class="block relative overflow-hidden rounded-xl mb-4 bg-gradient-to-br {{ $badgeStyle['grad'] }}">
                            @if($thumbExists)
                                <img src="{{ asset('storage/' . $post->foto_thumbnail) }}"
                                     alt="{{ $post->judul }}"
                                     class="aspect-video w-full object-cover rounded-xl hover:scale-105 transition-transform duration-300">
                            @else
                                <div class="aspect-video w-full rounded-xl flex flex-col items-center justify-center text-white/85">
                                    <span class="material-symbols-outlined text-[40px]">{{ $badgeStyle['icon'] }}</span>
                                    <span class="text-[11px] font-bold uppercase tracking-wider mt-1">{{ $badgeStyle['label'] }}</span>
                                </div>
                            @endif
                        </a>

                        <div class="flex flex-wrap items-center gap-2 mb-3">
                            <span class="px-2.5 py-0.5 rounded-full text-[11px] font-bold uppercase tracking-wider {{ $badgeStyle['bg'] }}">
                                {{ $badgeStyle['label'] }}
                            </span>
                            @if($post->klaster)
                                <span class="px-2.5 py-0.5 rounded-full bg-slate-100 text-slate-700 text-[11px] font-medium truncate max-w-[190px]">
                                    {{ $post->klaster->nama }}
                                </span>
                            @endif
                        </div>

                        <h2 class="text-lg font-bold text-slate-900 leading-snug mb-2 hover:text-[#2E7D32] transition-colors">
                            <a href="{{ $postUrl }}">{{ $post->judul }}</a>
                        </h2>

                        <p class="text-sm text-slate-600 line-clamp-2 leading-relaxed">
                            {{ \Illuminate\Support\Str::limit(trim(strip_tags($post->isi)), 140) }}
                        </p>
                    </div>

                    <div class="mt-5 pt-3 border-t border-slate-100 flex items-center justify-between gap-2 text-xs text-slate-500">
                        <span class="inline-flex items-center gap-1">
                            <span class="material-symbols-outlined text-[15px]">calendar_today</span>
                            <span>{{ $post->created_at->format('d M Y') }}</span>
                        </span>
                        <span class="truncate max-w-[160px] font-medium text-slate-700">
                            {{ $post->author->nama_lengkap ?? 'Humas Puskesmas' }}
                        </span>
                    </div>
                </article>
            @empty
                <div class="col-span-full bg-white rounded-2xl p-12 text-center border border-slate-200 space-y-3">
                    <span class="material-symbols-outlined text-[44px] text-slate-400">article</span>
                    <p class="text-base font-bold text-slate-800">Tidak ada informasi atau publikasi yang ditemukan.</p>
                    <p class="text-sm text-slate-500">Coba ubah kata kunci pencarian atau reset filter kategori di atas.</p>
                    <a href="{{ $postsIndexUrl }}" class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl bg-[#2E7D32] text-white text-xs font-semibold">
                        Reset Filter
                    </a>
                </div>
            @endforelse
        </div>

        {{-- Paginasi Lengkap --}}
        <div>
            {{ $posts->links('vendor.pagination.public') }}
        </div>
    </section>
</x-app-layout>
