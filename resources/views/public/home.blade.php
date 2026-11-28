@php
    $servicesIndexUrl = \Illuminate\Support\Facades\Route::has('public.services.index')
        ? route('public.services.index')
        : url('/layanan');
    $alurUrl = \Illuminate\Support\Facades\Route::has('public.services.alur')
        ? route('public.services.alur')
        : url('/layanan/alur');
    $postsIndexUrl = \Illuminate\Support\Facades\Route::has('public.posts.index')
        ? route('public.posts.index')
        : url('/informasi');
    $laporanIndexUrl = \Illuminate\Support\Facades\Route::has('public.posts.index')
        ? route('public.posts.index', ['tipe' => 'laporan'])
        : url('/informasi?tipe=laporan');
    $beritaIndexUrl = \Illuminate\Support\Facades\Route::has('public.posts.index')
        ? route('public.posts.index', ['tipe' => 'berita'])
        : url('/informasi?tipe=berita');

    $hasServiceShowRoute = \Illuminate\Support\Facades\Route::has('public.services.show');
    $hasPostShowRoute = \Illuminate\Support\Facades\Route::has('public.posts.show');

    $fotoFasilitasExists = ! empty($profil?->foto_fasilitas) && file_exists(public_path('storage/' . $profil->foto_fasilitas));
    $fotoFasilitasUrl = $fotoFasilitasExists ? asset('storage/' . $profil->foto_fasilitas) : null;

    $mapQuery = ! empty($profil?->koordinat_peta)
        ? urlencode($profil->koordinat_peta)
        : urlencode('UPTD Puskesmas Cilimus, Kuningan');
@endphp

<x-app-layout>
    {{-- ======================================================================= --}}
    {{-- SEKSI 1: HERO SLIDER                                                    --}}
    {{-- ======================================================================= --}}
    <section x-data="{
                activeSlide: 0,
                slides: [
                    {
                        badge: 'Portal Layanan Publik Resmi Kabupaten Kuningan',
                        tag: '01 Gedung Utama',
                        sub: 'Memberikan pelayanan kesehatan tingkat pertama yang bermutu, ramah, dan terjangkau bagi masyarakat Kecamatan Cilimus.'
                    },
                    {
                        badge: 'Integrasi Layanan Primer (ILP) Kemenkes RI',
                        tag: '02 Klaster Siklus Hidup',
                        sub: 'Pelayanan kesehatan terpadu lintas klaster mulai dari ibu dan anak, usia dewasa dan lansia, hingga pengendalian penyakit.'
                    },
                    {
                        badge: 'Siaga Medis & Kegawatdaruratan 24 Jam',
                        tag: '03 UGD & PONED 24 Jam',
                        sub: 'Tim dokter jaga, perawat, dan bidan siaga PONED siap melayani kegawatdaruratan dan persalinan sepanjang waktu.'
                    }
                ],
                next() {
                    this.activeSlide = (this.activeSlide + 1) % this.slides.length;
                },
                prev() {
                    this.activeSlide = (this.activeSlide - 1 + this.slides.length) % this.slides.length;
                }
            }"
            x-init="setInterval(() => next(), 7000)"
            class="relative overflow-hidden bg-[#003822] text-white min-h-[540px] lg:min-h-[600px] flex items-center">
        {{-- Background Banner Fasilitas & Overlay Gelap --}}
        @if($fotoFasilitasUrl)
            <img src="{{ $fotoFasilitasUrl }}"
                 alt="Gedung Fasilitas UPTD Puskesmas Cilimus"
                 class="absolute inset-0 w-full h-full object-cover object-center opacity-35">
        @endif
        <div class="absolute inset-0 bg-gradient-to-r from-[#002415]/95 via-[#003822]/90 to-[#054d2f]/80"></div>

        {{-- Dekorasi Pola Halus --}}
        <div class="absolute -right-24 -top-24 w-96 h-96 rounded-full bg-emerald-400/10 blur-3xl pointer-events-none"></div>
        <div class="absolute right-12 bottom-12 w-72 h-72 rounded-full bg-[#2E7D32]/20 blur-2xl pointer-events-none"></div>

        {{-- Tombol Panah Kiri / Kanan Slider Interaktif --}}
        <button type="button"
                @click="prev()"
                aria-label="Slide sebelumnya"
                class="hidden sm:flex absolute left-4 lg:left-8 top-1/2 -translate-y-1/2 z-20 w-11 h-11 rounded-full bg-white/10 hover:bg-white/20 border border-white/20 backdrop-blur-sm items-center justify-center text-white transition-all">
            <span class="material-symbols-outlined text-[24px]">chevron_left</span>
        </button>
        <button type="button"
                @click="next()"
                aria-label="Slide berikutnya"
                class="hidden sm:flex absolute right-4 lg:right-8 top-1/2 -translate-y-1/2 z-20 w-11 h-11 rounded-full bg-white/10 hover:bg-white/20 border border-white/20 backdrop-blur-sm items-center justify-center text-white transition-all">
            <span class="material-symbols-outlined text-[24px]">chevron_right</span>
        </button>

        {{-- Konten Hero --}}
        <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-16 w-full py-20 pb-28 lg:py-24 lg:pb-32">
            <div class="max-w-3xl space-y-6">
                <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-white/10 border border-white/15 backdrop-blur-sm text-emerald-200 text-xs font-semibold uppercase tracking-wider">
                    <span class="w-2 h-2 rounded-full bg-emerald-400"></span>
                    <span x-text="slides[activeSlide].badge">Portal Layanan Publik Resmi Kabupaten Kuningan</span>
                </div>

                <h2 class="text-3xl sm:text-4xl lg:text-5xl font-extrabold tracking-tight leading-tight text-white">
                    Selamat Datang di Portal Resmi
                    <span class="text-emerald-300 block mt-1">UPTD Puskesmas Cilimus</span>
                </h2>

                <p class="text-base sm:text-lg text-emerald-50/90 leading-relaxed max-w-2xl" x-text="slides[activeSlide].sub">
                    Memberikan pelayanan kesehatan tingkat pertama yang bermutu, ramah, dan terjangkau bagi masyarakat Kecamatan Cilimus.
                </p>

                {{-- Kutipan Komitmen --}}
                <div class="flex items-start gap-3 p-4 rounded-xl bg-white/10 border border-white/15 backdrop-blur-sm max-w-xl">
                    <span class="material-symbols-outlined text-emerald-300 text-[24px] flex-shrink-0 mt-0.5">format_quote</span>
                    <div>
                        <p class="text-sm sm:text-base font-semibold italic text-white">
                            “Melayani dengan Sepenuh Hati”
                        </p>
                        <p class="text-xs text-emerald-200/80 mt-0.5">
                            Komitmen Mutu &amp; Keselamatan Pasien — UPTD Puskesmas Cilimus
                        </p>
                    </div>
                </div>

                {{-- Tombol CTA --}}
                <div class="flex flex-wrap items-center gap-3 pt-2">
                    <a href="{{ $servicesIndexUrl }}"
                       class="inline-flex items-center gap-2 bg-[#2E7D32] hover:bg-[#1B5E20] text-white font-semibold px-6 py-3.5 rounded-xl text-sm shadow-lg shadow-black/20 transition-all">
                        <span class="material-symbols-outlined text-[20px]">calendar_month</span>
                        <span>Jadwal Poli &amp; Layanan</span>
                    </a>
                    <a href="{{ $laporanIndexUrl }}"
                       class="inline-flex items-center gap-2 bg-transparent hover:bg-white/10 text-white border-2 border-white/75 font-semibold px-6 py-3.5 rounded-xl text-sm transition-all">
                        <span class="material-symbols-outlined text-[20px]">assignment</span>
                        <span>Lihat Laporan Kerja</span>
                    </a>
                </div>

                {{-- Indikator Slide --}}
                <div class="flex flex-wrap items-center justify-between gap-4 pt-4">
                    <div class="flex items-center gap-2">
                        <template x-for="(slide, index) in slides" :key="index">
                            <button type="button"
                                    @click="activeSlide = index"
                                    class="flex items-center gap-2 px-3 py-1 rounded-full text-xs font-medium transition-all"
                                    :class="activeSlide === index ? 'bg-emerald-400 text-[#003822] font-bold' : 'bg-white/10 text-emerald-100/80 hover:bg-white/20'">
                                <span x-text="slide.tag"></span>
                            </button>
                        </template>
                    </div>
                    <div class="flex sm:hidden items-center gap-2">
                        <button type="button" @click="prev()" aria-label="Slide sebelumnya" class="p-2 rounded-full bg-white/10 border border-white/20 text-white">
                            <span class="material-symbols-outlined text-[18px]">chevron_left</span>
                        </button>
                        <button type="button" @click="next()" aria-label="Slide berikutnya" class="p-2 rounded-full bg-white/10 border border-white/20 text-white">
                            <span class="material-symbols-outlined text-[18px]">chevron_right</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- ======================================================================= --}}
    {{-- SEKSI 2: PINTASAN CEPAT (3 KARTU OVERLAPPING)                           --}}
    {{-- ======================================================================= --}}
    <section class="relative z-30 -mt-16 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            {{-- Kartu 1: Jam Operasional --}}
            <div class="bg-white rounded-2xl p-6 shadow-md border border-slate-200/80 flex flex-col justify-between">
                <div class="flex items-start gap-4">
                    <div class="w-12 h-12 rounded-xl bg-[#E8F5E9] text-[#2E7D32] flex items-center justify-center flex-shrink-0">
                        <span class="material-symbols-outlined text-[26px]">schedule</span>
                    </div>
                    <div>
                        <span class="text-[11px] font-bold uppercase tracking-wider text-[#2E7D32]">Akses Terjadwal</span>
                        <h3 class="text-lg font-bold text-slate-900 mt-0.5">Jam Operasional</h3>
                    </div>
                </div>
                <div class="mt-4 pt-4 border-t border-slate-100 space-y-2 text-sm">
                    <div class="flex items-center justify-between gap-2">
                        <span class="text-slate-600">Rawat Jalan:</span>
                        <span class="font-semibold text-slate-900">07:30–14:00 WIB</span>
                    </div>
                    <div class="flex items-center justify-between gap-2">
                        <span class="text-slate-600">UGD &amp; Persalinan:</span>
                        <span class="px-2.5 py-0.5 rounded-full bg-emerald-50 text-[#2E7D32] font-bold text-xs">Buka 24 Jam</span>
                    </div>
                </div>
            </div>

            {{-- Kartu 2: Kontak Gawat Darurat --}}
            <div class="bg-white rounded-2xl p-6 shadow-md border border-rose-200/80 flex flex-col justify-between">
                <div class="flex items-start gap-4">
                    <div class="w-12 h-12 rounded-xl bg-rose-50 text-rose-600 flex items-center justify-center flex-shrink-0">
                        <span class="material-symbols-outlined text-[26px]">emergency</span>
                    </div>
                    <div>
                        <div class="flex items-center gap-2">
                            <span class="text-[11px] font-bold uppercase tracking-wider text-rose-600">Tanggap Darurat</span>
                            <span class="px-2 py-0.5 rounded-full bg-rose-600 text-white text-[10px] font-bold">24 Jam</span>
                        </div>
                        <h3 class="text-lg font-bold text-slate-900 mt-0.5">Kontak Gawat Darurat</h3>
                    </div>
                </div>
                <div class="mt-4 pt-4 border-t border-slate-100 space-y-2 text-sm">
                    <div class="flex items-center justify-between gap-2">
                        <span class="text-slate-600">Hotline UGD:</span>
                        <span class="font-bold text-slate-900">{{ $profil->no_telepon ?? '(0232) 8611118' }}</span>
                    </div>
                    <div class="flex items-center justify-between gap-2">
                        <span class="text-slate-600">Call Center Medis:</span>
                        <span class="font-bold text-rose-600">119 (Bebas Pulsa)</span>
                    </div>
                </div>
            </div>

            {{-- Kartu 3: Alur Pendaftaran --}}
            <div class="bg-white rounded-2xl p-6 shadow-md border border-slate-200/80 flex flex-col justify-between">
                <div class="flex items-start gap-4">
                    <div class="w-12 h-12 rounded-xl bg-[#E8F5E9] text-[#2E7D32] flex items-center justify-center flex-shrink-0">
                        <span class="material-symbols-outlined text-[26px]">fact_check</span>
                    </div>
                    <div>
                        <span class="text-[11px] font-bold uppercase tracking-wider text-[#2E7D32]">Kemudahan Akses</span>
                        <h3 class="text-lg font-bold text-slate-900 mt-0.5">Alur Pendaftaran</h3>
                    </div>
                </div>
                <div class="mt-4 pt-4 border-t border-slate-100 space-y-3">
                    <p class="text-sm text-slate-600">
                        Panduan syarat berkas pasien peserta BPJS Kesehatan/KIS maupun pasien Umum.
                    </p>
                    <a href="{{ $alurUrl }}"
                       class="inline-flex items-center gap-1.5 text-sm font-semibold text-[#2E7D32] hover:text-[#1B5E20] transition-colors">
                        <span>Lihat Panduan Alur</span>
                        <span class="material-symbols-outlined text-[18px]">arrow_forward</span>
                    </a>
                </div>
            </div>
        </div>
    </section>

    {{-- ======================================================================= --}}
    {{-- SEKSI 3: LAYANAN UNGGULAN (GRID 4 KOLOM)                                --}}
    {{-- ======================================================================= --}}
    <section class="py-16 lg:py-20 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-4 mb-10">
            <div>
                <span class="inline-flex items-center gap-1.5 text-xs font-bold uppercase tracking-wider text-[#2E7D32]">
                    <span class="material-symbols-outlined text-[16px]">medical_services</span>
                    <span>Klaster &amp; Unit Pelayanan</span>
                </span>
                <h2 class="text-2xl sm:text-3xl font-bold text-slate-900 mt-1">
                    Layanan Poliklinik Unggulan
                </h2>
                <p class="text-slate-600 text-sm sm:text-base mt-2 max-w-2xl">
                    Pelayanan kesehatan terintegrasi sesuai siklus hidup berdasarkan pedoman Integrasi Layanan Primer (ILP) Kementerian Kesehatan RI.
                </p>
            </div>
            <a href="{{ $servicesIndexUrl }}"
               class="inline-flex items-center gap-2 self-start md:self-auto px-4 py-2.5 rounded-xl border border-slate-200 bg-white hover:border-[#2E7D32] hover:text-[#2E7D32] text-sm font-semibold text-slate-700 shadow-sm transition-all">
                <span>Semua Klaster Layanan</span>
                <span class="material-symbols-outlined text-[18px]">arrow_forward</span>
            </a>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            @forelse($layananUnggulan as $poli)
                <article class="bg-white rounded-2xl p-6 border border-slate-200/80 shadow-sm hover:shadow-md hover:border-[#2E7D32]/40 transition-all flex flex-col justify-between">
                    <div>
                        <div class="flex items-center justify-between gap-2 mb-4">
                            <div class="w-12 h-12 rounded-full bg-emerald-50 text-[#2E7D32] flex items-center justify-center flex-shrink-0">
                                <span class="material-symbols-outlined text-[24px]">stethoscope</span>
                            </div>
                            @if($poli->klaster)
                                <span class="px-2.5 py-1 rounded-full bg-[#ECFDF5] text-[#15803D] text-[11px] font-semibold truncate max-w-[160px]">
                                    {{ $poli->klaster->nama }}
                                </span>
                            @endif
                        </div>

                        <h3 class="text-lg font-bold text-slate-900 mb-2">
                            {{ $poli->nama_poli }}
                        </h3>

                        <div class="space-y-2 text-xs text-slate-600 mt-3">
                            <div class="flex items-start gap-2">
                                <span class="material-symbols-outlined text-[16px] text-[#2E7D32] mt-0.5 flex-shrink-0">schedule</span>
                                <span>{{ $poli->jadwal_praktik }}</span>
                            </div>
                            @if($poli->tenaga_medis)
                                <div class="flex items-start gap-2">
                                    <span class="material-symbols-outlined text-[16px] text-[#2E7D32] mt-0.5 flex-shrink-0">person</span>
                                    <span>{{ $poli->tenaga_medis }}</span>
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="mt-5 pt-4 border-t border-slate-100">
                        <a href="{{ $hasServiceShowRoute ? route('public.services.show', $poli->slug) : url('/layanan/' . $poli->slug) }}"
                           class="inline-flex items-center gap-1 text-sm font-semibold text-[#2E7D32] hover:text-[#1B5E20] transition-colors">
                            <span>Selengkapnya →</span>
                        </a>
                    </div>
                </article>
            @empty
                <div class="col-span-full bg-white rounded-2xl p-8 text-center border border-slate-200 text-slate-500 text-sm">
                    Data layanan poliklinik unggulan belum tersedia.
                </div>
            @endforelse
        </div>
    </section>

    {{-- ======================================================================= --}}
    {{-- SEKSI 4: SOROTAN LAPORAN PROGRAM KERJA (GRID 3 KOLOM)                   --}}
    {{-- ======================================================================= --}}
    <section class="bg-slate-50 py-16 lg:py-20 border-y border-slate-200/70">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row md:items-end justify-between gap-4 mb-10">
                <div>
                    <span class="inline-flex items-center gap-1.5 text-xs font-bold uppercase tracking-wider text-[#15803D]">
                        <span class="material-symbols-outlined text-[16px]">verified</span>
                        <span>Akuntabilitas Publik</span>
                    </span>
                    <h2 class="text-2xl sm:text-3xl font-bold text-slate-900 mt-1">
                        Transparansi Program Kerja Puskesmas
                    </h2>
                    <p class="text-slate-600 text-sm sm:text-base mt-2 max-w-2xl">
                        Publikasi capaian program kesehatan masyarakat, laporan kinerja BLUD, dan realisasi kegiatan lapangan secara berkala.
                    </p>
                </div>
                <a href="{{ $laporanIndexUrl }}"
                   class="inline-flex items-center gap-1.5 text-sm font-semibold text-[#2E7D32] hover:text-[#1B5E20] transition-colors">
                    <span>Arsip Semua Laporan →</span>
                </a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                @forelse($laporanTerbaru as $post)
                    @php
                        $thumbExists = ! empty($post->foto_thumbnail) && file_exists(public_path('storage/' . $post->foto_thumbnail));
                        $postUrl = $hasPostShowRoute ? route('public.posts.show', $post->slug) : url('/informasi/' . $post->slug);
                    @endphp
                    <article class="bg-white rounded-2xl overflow-hidden border border-slate-200/80 shadow-sm hover:shadow-md transition-all flex flex-col justify-between">
                        <div>
                            <div class="relative aspect-video bg-gradient-to-br from-[#003822] to-[#2E7D32] overflow-hidden">
                                @if($thumbExists)
                                    <img src="{{ asset('storage/' . $post->foto_thumbnail) }}"
                                         alt="{{ $post->judul }}"
                                         class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full flex flex-col items-center justify-center text-emerald-100/80 p-4">
                                        <span class="material-symbols-outlined text-[42px] mb-1">analytics</span>
                                        <span class="text-xs font-medium uppercase tracking-wider">Laporan Program Kerja</span>
                                    </div>
                                @endif
                                <span class="absolute top-3 left-3 px-2.5 py-1 rounded-full bg-[#ECFDF5] text-[#15803D] text-[11px] font-bold uppercase tracking-wider shadow-sm">
                                    LAPORAN
                                </span>
                            </div>

                            <div class="p-6 space-y-3">
                                @if($post->klaster)
                                    <span class="inline-block px-2.5 py-0.5 rounded-full bg-slate-100 text-slate-700 text-xs font-medium">
                                        {{ $post->klaster->nama }}
                                    </span>
                                @endif

                                <h3 class="text-lg font-bold text-slate-900 leading-snug line-clamp-2">
                                    {{ $post->judul }}
                                </h3>
                            </div>
                        </div>

                        <div class="px-6 pb-6 pt-3 border-t border-slate-100 flex items-center justify-between text-xs text-slate-500">
                            <span>{{ $post->periode_bulan ? $post->periode_bulan . ' ' . $post->periode_tahun : $post->created_at->translatedFormat('d M Y') }}</span>
                            <a href="{{ $postUrl }}"
                               class="text-sm font-semibold text-[#2E7D32] hover:text-[#1B5E20] transition-colors">
                                Baca Selengkapnya →
                            </a>
                        </div>
                    </article>
                @empty
                    <div class="col-span-full bg-white rounded-2xl p-8 text-center border border-slate-200 text-slate-500 text-sm">
                        Belum ada laporan program kerja yang dipublikasikan.
                    </div>
                @endforelse
            </div>
        </div>
    </section>

    {{-- ======================================================================= --}}
    {{-- SEKSI 5: KABAR & AGENDA (RASIO 60:40)                                   --}}
    {{-- ======================================================================= --}}
    <section class="py-16 lg:py-20 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-10">
            {{-- Kolom Kiri (60% -> 7/12): Berita Terkini --}}
            <div class="lg:col-span-7 space-y-6">
                <div class="flex items-end justify-between gap-4">
                    <div>
                        <span class="text-xs font-bold uppercase tracking-wider text-[#1D4ED8]">Warta Informasi</span>
                        <h2 class="text-2xl font-bold text-slate-900 mt-1">Berita Terkini</h2>
                    </div>
                    <a href="{{ $beritaIndexUrl }}"
                       class="text-sm font-semibold text-[#2E7D32] hover:text-[#1B5E20] transition-colors">
                        Semua Berita →
                    </a>
                </div>

                <div class="space-y-4">
                    @forelse($beritaTerbaru as $post)
                        @php
                            $thumbExists = ! empty($post->foto_thumbnail) && file_exists(public_path('storage/' . $post->foto_thumbnail));
                            $postUrl = $hasPostShowRoute ? route('public.posts.show', $post->slug) : url('/informasi/' . $post->slug);
                        @endphp
                        <a href="{{ $postUrl }}"
                           class="group bg-white rounded-2xl p-4 border border-slate-200/80 shadow-sm hover:shadow-md hover:border-blue-200 transition-all flex flex-col sm:flex-row gap-4 items-start sm:items-center">
                            <div class="w-full sm:w-32 h-24 rounded-xl bg-gradient-to-br from-blue-600 to-blue-800 overflow-hidden flex-shrink-0 flex items-center justify-center text-white">
                                @if($thumbExists)
                                    <img src="{{ asset('storage/' . $post->foto_thumbnail) }}"
                                         alt="{{ $post->judul }}"
                                         class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                                @else
                                    <span class="material-symbols-outlined text-[32px] opacity-85">newspaper</span>
                                @endif
                            </div>

                            <div class="flex-1 min-w-0 space-y-1.5">
                                <div class="flex flex-wrap items-center gap-2 text-xs">
                                    <span class="px-2.5 py-0.5 rounded-full bg-[#EFF6FF] text-[#1D4ED8] font-bold uppercase tracking-wider text-[11px]">
                                        BERITA
                                    </span>
                                    <span class="text-slate-500">
                                        {{ $post->created_at->translatedFormat('d F Y') }}
                                    </span>
                                </div>
                                <h3 class="text-base font-bold text-slate-900 group-hover:text-[#2E7D32] transition-colors line-clamp-2">
                                    {{ $post->judul }}
                                </h3>
                            </div>
                        </a>
                    @empty
                        <div class="bg-white rounded-2xl p-8 text-center border border-slate-200 text-slate-500 text-sm">
                            Belum ada berita kesehatan terbaru.
                        </div>
                    @endforelse
                </div>
            </div>

            {{-- Kolom Kanan (40% -> 5/12): Agenda Terdekat --}}
            <div class="lg:col-span-5 space-y-6">
                <div class="flex items-end justify-between gap-4">
                    <div>
                        <span class="text-xs font-bold uppercase tracking-wider text-[#EA580C]">Jadwal Kegiatan</span>
                        <h2 class="text-2xl font-bold text-slate-900 mt-1">Agenda Terdekat</h2>
                    </div>
                    <a href="{{ \Illuminate\Support\Facades\Route::has('public.posts.index') ? route('public.posts.index', ['tipe' => 'agenda']) : url('/informasi?tipe=agenda') }}"
                       class="text-sm font-semibold text-[#2E7D32] hover:text-[#1B5E20] transition-colors">
                        Semua Agenda →
                    </a>
                </div>

                <div class="space-y-4">
                    @forelse($agendaTerdekat as $post)
                        @php
                            $agendaDate = $post->waktu_kegiatan ?? $post->created_at;
                            $postUrl = $hasPostShowRoute ? route('public.posts.show', $post->slug) : url('/informasi/' . $post->slug);
                        @endphp
                        <a href="{{ $postUrl }}"
                           class="group bg-white rounded-2xl p-4 border border-slate-200/80 shadow-sm hover:shadow-md hover:border-orange-200 transition-all flex items-start gap-4">
                            {{-- Kotak Kalender Tanggal --}}
                            <div class="w-16 h-16 rounded-xl bg-[#FFF7ED] border border-orange-200/70 text-[#EA580C] flex flex-col items-center justify-center flex-shrink-0">
                                <span class="text-xl font-extrabold leading-none">{{ $agendaDate->format('d') }}</span>
                                <span class="text-[11px] font-bold uppercase mt-1">{{ $agendaDate->translatedFormat('M') }}</span>
                            </div>

                            <div class="flex-1 min-w-0 space-y-1.5">
                                <span class="inline-block px-2.5 py-0.5 rounded-full bg-[#FFF7ED] text-[#EA580C] font-bold uppercase tracking-wider text-[11px]">
                                    AGENDA
                                </span>
                                <h3 class="text-sm sm:text-base font-bold text-slate-900 group-hover:text-[#2E7D32] transition-colors line-clamp-2">
                                    {{ $post->judul }}
                                </h3>
                                <div class="flex flex-wrap items-center gap-x-3 gap-y-1 text-xs text-slate-500">
                                    <span class="inline-flex items-center gap-1">
                                        <span class="material-symbols-outlined text-[14px] text-[#EA580C]">schedule</span>
                                        <span>{{ $agendaDate->format('H:i') }} WIB</span>
                                    </span>
                                    @if($post->lokasi_kegiatan)
                                        <span class="inline-flex items-center gap-1">
                                            <span class="material-symbols-outlined text-[14px] text-[#EA580C]">location_on</span>
                                            <span class="truncate max-w-[200px]">{{ $post->lokasi_kegiatan }}</span>
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </a>
                    @empty
                        <div class="bg-white rounded-2xl p-8 text-center border border-slate-200 text-slate-500 text-sm">
                            Belum ada agenda kegiatan terdekat.
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </section>

    {{-- ======================================================================= --}}
    {{-- SEKSI 6: PETA LOKASI & MAKLUMAT PELAYANAN                               --}}
    {{-- ======================================================================= --}}
    <section class="bg-slate-50 py-16 lg:py-20 border-t border-slate-200/70">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 items-stretch">
                {{-- Kolom Kiri: Google Maps Iframe --}}
                <div class="bg-white rounded-2xl p-6 border border-slate-200/80 shadow-sm flex flex-col justify-between gap-4">
                    <div>
                        <span class="text-xs font-bold uppercase tracking-wider text-[#2E7D32]">Akses Fasilitas</span>
                        <h2 class="text-2xl font-bold text-slate-900 mt-1">Lokasi UPTD Puskesmas Cilimus</h2>
                        <p class="text-sm text-slate-600 mt-1">
                            {{ $profil->alamat ?? 'Jl. Raya Cilimus No. 219, Kec. Cilimus, Kab. Kuningan, Jawa Barat 45556' }}
                        </p>
                    </div>

                    <div class="w-full h-80 rounded-2xl overflow-hidden border border-slate-200 bg-slate-100">
                        <iframe src="https://maps.google.com/maps?q={{ $mapQuery }}&t=&z=15&ie=UTF8&iwloc=&output=embed"
                                title="Peta Lokasi UPTD Puskesmas Cilimus Kabupaten Kuningan"
                                class="w-full h-80 rounded-2xl border-0"
                                loading="lazy"
                                allowfullscreen
                                referrerpolicy="no-referrer-when-downgrade"></iframe>
                    </div>
                </div>

                {{-- Kolom Kanan: Maklumat Pelayanan --}}
                <div class="bg-white rounded-2xl p-8 border border-slate-200/80 shadow-sm flex flex-col justify-between relative overflow-hidden">
                    <div class="absolute top-4 right-4 text-[#E8F5E9] pointer-events-none">
                        <span class="material-symbols-outlined text-[120px]">health_and_safety</span>
                    </div>

                    <div class="relative z-10 space-y-6">
                        <div class="flex items-center gap-3">
                            <div class="w-12 h-12 rounded-xl bg-[#003822] text-white flex items-center justify-center flex-shrink-0">
                                <span class="material-symbols-outlined text-[26px]">verified_user</span>
                            </div>
                            <div>
                                <span class="text-xs font-bold uppercase tracking-wider text-[#2E7D32]">Janji Pelayanan Publik</span>
                                <h2 class="text-2xl font-bold text-[#003822]">Maklumat Pelayanan</h2>
                            </div>
                        </div>

                        <blockquote class="p-6 rounded-2xl bg-[#ECFDF5] border border-emerald-200/70 text-slate-800 text-base sm:text-lg italic leading-relaxed">
                            “Dengan ini kami menyatakan sanggup menyelenggarakan pelayanan kesehatan sesuai standar pelayanan yang telah ditetapkan, dan apabila tidak menepati janji ini, kami siap menerima sanksi sesuai dengan peraturan perundang-undangan yang berlaku.”
                        </blockquote>

                        <div>
                            <p class="text-base font-bold text-slate-900">Kepala UPTD Puskesmas Cilimus</p>
                            <p class="text-sm text-slate-600">beserta Seluruh Staf Medis dan Paramedis Puskesmas Cilimus</p>
                        </div>
                    </div>

                    <div class="relative z-10 pt-6 mt-6 border-t border-slate-100 flex flex-wrap items-center gap-3">
                        <span class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-xl bg-[#2E7D32] text-white text-xs font-bold">
                            <span class="material-symbols-outlined text-[16px]">verified</span>
                            <span>Akreditasi Paripurna Kemenkes RI</span>
                        </span>
                        <span class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-xl bg-[#E8F5E9] text-[#0D3813] text-xs font-semibold">
                            <span class="material-symbols-outlined text-[16px]">shield</span>
                            <span>Wilayah Bebas dari Korupsi (WBK)</span>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </section>
</x-app-layout>
