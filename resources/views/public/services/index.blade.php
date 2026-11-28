@php
    $homeUrl = \Illuminate\Support\Facades\Route::has('public.home') ? route('public.home') : url('/');
    $servicesIndexUrl = \Illuminate\Support\Facades\Route::has('public.services.index') ? route('public.services.index') : url('/layanan');
    $alurUrl = \Illuminate\Support\Facades\Route::has('public.services.alur') ? route('public.services.alur') : url('/layanan/alur');
    $hasServicesIndex = \Illuminate\Support\Facades\Route::has('public.services.index');
    $hasServiceShow = \Illuminate\Support\Facades\Route::has('public.services.show');
    $activeKlaster = request('klaster');
@endphp

<x-app-layout>
    <x-slot name="title">Katalog Layanan Kesehatan</x-slot>

    {{-- Banner Header --}}
    <section class="relative overflow-hidden bg-gradient-to-br from-[#003822] via-[#054d2f] to-[#2E7D32] text-white py-12 lg:py-16">
        <div class="absolute -right-20 -top-20 w-80 h-80 rounded-full bg-white/5 blur-2xl pointer-events-none"></div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 space-y-4">
            <nav aria-label="Breadcrumb" class="flex items-center gap-2 text-xs text-emerald-200/90 font-medium">
                <a href="{{ $homeUrl }}" class="hover:text-white transition-colors inline-flex items-center gap-1">
                    <span class="material-symbols-outlined text-[15px]">home</span>
                    <span>Beranda</span>
                </a>
                <span>/</span>
                <span>Layanan</span>
                <span>/</span>
                <span class="text-white font-semibold">Katalog Layanan Kesehatan</span>
            </nav>

            <div class="flex flex-wrap items-center gap-2">
                <span class="px-3 py-1 rounded-full bg-white/10 border border-white/15 text-emerald-200 text-xs font-semibold uppercase tracking-wider">
                    Integrasi Pelayanan Primer (ILP)
                </span>
                <span class="px-3 py-1 rounded-full bg-emerald-400/20 border border-emerald-300/30 text-emerald-100 text-xs font-semibold">
                    Standar Akreditasi Paripurna
                </span>
            </div>

            <h2 class="text-3xl sm:text-4xl font-extrabold tracking-tight text-white">
                Layanan Kesehatan Puskesmas Cilimus
            </h2>
            <p class="text-sm sm:text-base text-emerald-50/90 max-w-2xl leading-relaxed">
                Daftar unit pelayanan terintegrasi siklus hidup (Klaster 1 s/d 4 dan Lintas Klaster) untuk memberikan pelayanan medis, pencegahan, dan rujukan yang optimal bagi masyarakat Kecamatan Cilimus.
            </p>
        </div>
    </section>

    {{-- Konten Katalog & Filter --}}
    <section class="py-12 lg:py-16 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-10">
        {{-- Bilah Filter Pill Buttons --}}
        <div class="bg-white rounded-2xl p-4 sm:p-5 border border-slate-200/90 shadow-xs space-y-3">
            <div class="flex flex-wrap items-center justify-between gap-2">
                <span class="text-xs font-bold uppercase tracking-wider text-slate-500">Filter Klaster Pelayanan ILP</span>
                <span class="text-xs font-semibold text-[#2E7D32] bg-[#ECFDF5] px-3 py-1 rounded-full">
                    Menampilkan {{ $layananList->count() }} Layanan Aktif
                </span>
            </div>

            <div class="flex flex-wrap items-center gap-2.5">
                <a href="{{ $servicesIndexUrl }}"
                   class="inline-flex items-center gap-1.5 px-4 py-2 rounded-full text-xs sm:text-sm font-semibold transition-all {{ empty($activeKlaster) ? 'bg-[#2E7D32] text-white shadow-xs' : 'bg-slate-100 text-slate-700 hover:bg-emerald-50 hover:text-[#2E7D32]' }}">
                    <span>Semua</span>
                </a>

                @foreach($klasters as $k)
                    @php
                        $isCurrent = $activeKlaster === $k->slug;
                        $klasterUrl = $hasServicesIndex
                            ? route('public.services.index', ['klaster' => $k->slug])
                            : url('/layanan?klaster=' . $k->slug);
                    @endphp
                    <a href="{{ $klasterUrl }}"
                       class="inline-flex items-center gap-1.5 px-4 py-2 rounded-full text-xs sm:text-sm font-semibold transition-all {{ $isCurrent ? 'bg-[#2E7D32] text-white shadow-xs' : 'bg-slate-100 text-slate-700 hover:bg-emerald-50 hover:text-[#2E7D32]' }}">
                        <span>{{ $k->nama }}</span>
                        @if(isset($k->layanan_count))
                            <span class="px-1.5 py-0.5 rounded-full text-[10px] font-bold {{ $isCurrent ? 'bg-white/20 text-white' : 'bg-white text-slate-600' }}">
                                {{ $k->layanan_count }}
                            </span>
                        @endif
                    </a>
                @endforeach
            </div>
        </div>

        {{-- Grid 3 Kolom Kartu Layanan --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($layananList as $poli)
                @php
                    $detailUrl = $hasServiceShow
                        ? route('public.services.show', $poli->slug)
                        : url('/layanan/' . $poli->slug);
                @endphp
                <article class="bg-white rounded-2xl p-6 border border-slate-200/90 shadow-sm hover:shadow-md hover:border-emerald-300 transition-all flex flex-col justify-between">
                    <div>
                        <div class="flex items-start justify-between gap-3 mb-4">
                            <div class="w-12 h-12 rounded-full bg-emerald-50 text-emerald-700 flex items-center justify-center flex-shrink-0">
                                <span class="material-symbols-outlined text-[24px]">medical_services</span>
                            </div>
                            @if($poli->klaster)
                                <span class="px-3 py-1 rounded-full bg-[#ECFDF5] text-[#15803D] text-[11px] font-semibold text-right">
                                    {{ $poli->klaster->nama }}
                                </span>
                            @endif
                        </div>

                        <h3 class="text-xl font-bold text-slate-900 leading-snug mb-3">
                            {{ $poli->nama_poli }}
                        </h3>

                        <div class="bg-slate-50 rounded-xl p-3.5 space-y-2 border border-slate-100 text-xs text-slate-700 mb-4">
                            <div class="flex items-start gap-2">
                                <span class="material-symbols-outlined text-[16px] text-emerald-700 mt-0.5 flex-shrink-0">schedule</span>
                                <span>{{ $poli->jadwal_praktik }}</span>
                            </div>
                            @if($poli->tenaga_medis)
                                <div class="flex items-start gap-2">
                                    <span class="material-symbols-outlined text-[16px] text-emerald-700 mt-0.5 flex-shrink-0">stethoscope</span>
                                    <span><strong>Penanggung Jawab:</strong> {{ $poli->tenaga_medis }}</span>
                                </div>
                            @endif
                        </div>

                        @if($poli->deskripsi)
                            <p class="text-sm text-slate-600 leading-relaxed line-clamp-3">
                                {{ $poli->deskripsi }}
                            </p>
                        @endif
                    </div>

                    <div class="mt-6 pt-4 border-t border-slate-100">
                        <a href="{{ $detailUrl }}"
                           class="w-full inline-flex items-center justify-center gap-1.5 border-2 border-emerald-600 text-emerald-700 hover:bg-emerald-600 hover:text-white rounded-lg px-4 py-2.5 text-sm font-semibold transition-all">
                            <span>Lihat Detail →</span>
                        </a>
                    </div>
                </article>
            @empty
                <div class="col-span-full bg-white rounded-2xl p-10 text-center border border-slate-200 space-y-3">
                    <span class="material-symbols-outlined text-[40px] text-slate-400">search_off</span>
                    <p class="text-base font-semibold text-slate-700">Belum ada layanan aktif pada klaster ini.</p>
                    <a href="{{ $servicesIndexUrl }}" class="inline-flex items-center gap-1 text-sm font-semibold text-[#2E7D32] hover:underline">
                        <span>Tampilkan semua layanan</span>
                    </a>
                </div>
            @endforelse
        </div>

        {{-- Banner Hijau di Bagian Bawah --}}
        <div class="bg-[#2E7D32] rounded-2xl p-8 text-white flex flex-col md:flex-row justify-between items-start md:items-center gap-6 shadow-md">
            <div class="space-y-2 max-w-2xl">
                <span class="inline-block px-3 py-1 rounded-full bg-white/15 text-emerald-100 text-xs font-semibold uppercase tracking-wider">
                    Panduan Pasien
                </span>
                <h3 class="text-2xl sm:text-3xl font-bold leading-snug">
                    Bagaimana Alur Berobat di Puskesmas Cilimus?
                </h3>
                <p class="text-sm sm:text-base text-emerald-50/90">
                    Ikuti langkah mudah mulai dari pendaftaran loket atau antrean online, verifikasi BPJS/KIS maupun Umum, pemeriksaan poliklinik, hingga pengambilan obat.
                </p>
            </div>

            <a href="{{ $alurUrl }}"
               class="inline-flex items-center gap-2 bg-white text-[#003822] hover:bg-emerald-50 font-bold px-6 py-3.5 rounded-xl text-sm shadow-sm flex-shrink-0 transition-colors">
                <span>Lihat Alur Pelayanan →</span>
            </a>
        </div>
    </section>
</x-app-layout>
