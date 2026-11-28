@props([
    'active' => 'visi-misi',
    'title' => 'Profil UPTD Puskesmas Cilimus',
    'subtitle' => 'Mengenal visi, tata kelola organisasi, jangkauan wilayah kerja, serta sarana prasarana pelayanan kesehatan primer.',
    'breadcrumb' => 'Profil',
])

@php
    $homeUrl = \Illuminate\Support\Facades\Route::has('public.home') ? route('public.home') : url('/');
    $visiMisiUrl = \Illuminate\Support\Facades\Route::has('public.profile.visi-misi') ? route('public.profile.visi-misi') : url('/profil/visi-misi');
    $strukturUrl = \Illuminate\Support\Facades\Route::has('public.profile.struktur') ? route('public.profile.struktur') : url('/profil/struktur');
    $wilayahUrl = \Illuminate\Support\Facades\Route::has('public.profile.wilayah') ? route('public.profile.wilayah') : url('/profil/wilayah');
    $fasilitasUrl = \Illuminate\Support\Facades\Route::has('public.profile.fasilitas') ? route('public.profile.fasilitas') : url('/profil/fasilitas');

    $tabs = [
        [
            'key' => 'visi-misi',
            'label' => 'Visi, Misi & Nilai',
            'icon' => 'flag',
            'url' => $visiMisiUrl,
        ],
        [
            'key' => 'struktur',
            'label' => 'Struktur Organisasi',
            'icon' => 'account_tree',
            'url' => $strukturUrl,
        ],
        [
            'key' => 'wilayah',
            'label' => 'Wilayah Kerja',
            'icon' => 'map',
            'url' => $wilayahUrl,
        ],
        [
            'key' => 'fasilitas',
            'label' => 'Fasilitas & Sarana',
            'icon' => 'apartment',
            'url' => $fasilitasUrl,
        ],
    ];
@endphp

{{-- Banner Header Profil --}}
<section class="relative overflow-hidden bg-gradient-to-br from-[#003822] via-[#054d2f] to-[#2E7D32] text-white py-12 lg:py-16">
    <div class="absolute -right-16 -top-16 w-72 h-72 rounded-full bg-white/5 blur-2xl pointer-events-none"></div>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 space-y-4">
        <nav aria-label="Breadcrumb" class="flex items-center gap-2 text-xs text-emerald-200/90 font-medium">
            <a href="{{ $homeUrl }}" class="hover:text-white transition-colors inline-flex items-center gap-1">
                <span class="material-symbols-outlined text-[15px]">home</span>
                <span>Beranda</span>
            </a>
            <span>/</span>
            <span>Profil</span>
            <span>/</span>
            <span class="text-white font-semibold">{{ $breadcrumb }}</span>
        </nav>

        <div class="flex flex-wrap items-center gap-2">
            <span class="px-3 py-1 rounded-full bg-white/10 border border-white/15 text-emerald-200 text-xs font-semibold uppercase tracking-wider">
                Pedoman Strategis Organisasi
            </span>
            <span class="px-3 py-1 rounded-full bg-emerald-400/20 border border-emerald-300/30 text-emerald-100 text-xs font-semibold">
                Akreditasi Paripurna
            </span>
        </div>

        <h2 class="text-3xl sm:text-4xl font-extrabold tracking-tight text-white">
            {{ $title }}
        </h2>
        <p class="text-sm sm:text-base text-emerald-50/90 max-w-2xl leading-relaxed">
            {{ $subtitle }}
        </p>
    </div>
</section>

{{-- Bilah Navigasi Sub-Tabs Horizontal --}}
<div class="bg-white border-b border-slate-200 sticky top-20 z-30 shadow-xs">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <nav aria-label="Navigasi Profil Puskesmas" class="flex items-center gap-2 sm:gap-6 overflow-x-auto no-scrollbar">
            @foreach($tabs as $tab)
                @php
                    $isActive = $active === $tab['key'];
                @endphp
                <a href="{{ $tab['url'] }}"
                   class="inline-flex items-center gap-2 py-4 px-2 text-sm whitespace-nowrap border-b-4 transition-all {{ $isActive ? 'text-[#2E7D32] font-bold border-[#2E7D32]' : 'text-slate-600 font-medium border-transparent hover:text-[#003822] hover:border-emerald-200' }}">
                    <span class="material-symbols-outlined text-[18px]">{{ $tab['icon'] }}</span>
                    <span>{{ $tab['label'] }}</span>
                </a>
            @endforeach
        </nav>
    </div>
</div>
