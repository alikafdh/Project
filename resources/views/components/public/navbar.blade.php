@props(['profil' => null])

@php
    $homeUrl = \Illuminate\Support\Facades\Route::has('public.home') ? route('public.home') : url('/');
    $visiMisiUrl = \Illuminate\Support\Facades\Route::has('public.profile.visi-misi') ? route('public.profile.visi-misi') : url('/profil/visi-misi');
    $strukturUrl = \Illuminate\Support\Facades\Route::has('public.profile.struktur') ? route('public.profile.struktur') : url('/profil/struktur');
    $wilayahUrl = \Illuminate\Support\Facades\Route::has('public.profile.wilayah') ? route('public.profile.wilayah') : url('/profil/wilayah');
    $fasilitasUrl = \Illuminate\Support\Facades\Route::has('public.profile.fasilitas') ? route('public.profile.fasilitas') : url('/profil/fasilitas');
    $servicesUrl = \Illuminate\Support\Facades\Route::has('public.services.index') ? route('public.services.index') : url('/layanan');
    $alurUrl = \Illuminate\Support\Facades\Route::has('public.services.alur') ? route('public.services.alur') : url('/layanan/alur');
    $postsUrl = \Illuminate\Support\Facades\Route::has('public.posts.index') ? route('public.posts.index') : url('/informasi');
    $contactUrl = \Illuminate\Support\Facades\Route::has('public.feedback.index') ? route('public.feedback.index') : url('/kontak');

    $logoExists = ! empty($profil?->logo) && file_exists(public_path('storage/' . $profil->logo));
@endphp

<header x-data="{ mobileMenu: false, profilOpen: false, layananOpen: false }"
        @keydown.escape.window="mobileMenu = false; profilOpen = false; layananOpen = false"
        class="sticky top-0 z-40 bg-white/95 backdrop-blur-md border-b border-slate-200 shadow-[0_1px_8px_rgba(0,0,0,0.04)]">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-20 flex items-center justify-between gap-4">
        {{-- Kiri: Logo & Identitas Instansi --}}
        <a href="{{ $homeUrl }}" class="flex items-center gap-3 flex-shrink-0 group">
            @if($logoExists)
                <img src="{{ asset('storage/' . $profil->logo) }}"
                     alt="Logo UPTD Puskesmas Cilimus"
                     class="h-10 w-10 object-contain rounded-lg">
            @else
                <div class="w-10 h-10 rounded-xl bg-[#2E7D32] flex items-center justify-center text-white shadow-sm group-hover:bg-[#1B5E20] transition-colors">
                    <span class="material-symbols-outlined text-[24px]">local_hospital</span>
                </div>
            @endif
            <div class="flex flex-col">
                <h1 class="text-base sm:text-lg font-bold text-[#003822] leading-tight tracking-tight">
                    UPTD Puskesmas Cilimus
                </h1>
                <span class="text-xs font-medium text-slate-500">Kabupaten Kuningan</span>
            </div>
        </a>

        {{-- Tengah: Menu Navigasi Desktop --}}
        <nav aria-label="Navigasi Utama" class="hidden lg:flex items-center gap-1">
            <a href="{{ $homeUrl }}"
               class="px-3.5 py-2 rounded-lg text-sm transition-colors {{ request()->is('/') ? 'text-[#2E7D32] font-bold bg-[#E8F5E9]' : 'text-slate-600 font-semibold hover:text-[#003822] hover:bg-[#ECFDF5]' }}">
                Beranda
            </a>

            {{-- Dropdown: Profil --}}
            <div class="relative" @mouseenter="profilOpen = true" @mouseleave="profilOpen = false">
                <button type="button"
                        @click="profilOpen = !profilOpen; layananOpen = false"
                        :aria-expanded="profilOpen.toString()"
                        class="px-3.5 py-2 rounded-lg text-sm flex items-center gap-1 transition-colors {{ request()->is('profil*') ? 'text-[#2E7D32] font-bold bg-[#E8F5E9]' : 'text-slate-600 font-semibold hover:text-[#003822] hover:bg-[#ECFDF5]' }}">
                    <span>Profil</span>
                    <span class="material-symbols-outlined text-[18px] transition-transform duration-150" :class="profilOpen ? 'rotate-180' : ''">expand_more</span>
                </button>
                <div x-show="profilOpen"
                     x-transition:enter="transition ease-out duration-150"
                     x-transition:enter-start="opacity-0 translate-y-1"
                     x-transition:enter-end="opacity-100 translate-y-0"
                     x-transition:leave="transition ease-in duration-100"
                     x-transition:leave-start="opacity-100 translate-y-0"
                     x-transition:leave-end="opacity-0 translate-y-1"
                     x-cloak
                     class="absolute left-0 top-full pt-2 w-56 z-50">
                    <div class="bg-white rounded-xl border border-slate-200 shadow-lg py-2">
                        <a href="{{ $visiMisiUrl }}" class="flex items-center gap-2.5 px-4 py-2.5 text-sm text-slate-700 hover:bg-[#ECFDF5] hover:text-[#2E7D32] font-medium transition-colors">
                            <span class="material-symbols-outlined text-[18px] text-[#2E7D32]">flag</span>
                            <span>Visi Misi</span>
                        </a>
                        <a href="{{ $strukturUrl }}" class="flex items-center gap-2.5 px-4 py-2.5 text-sm text-slate-700 hover:bg-[#ECFDF5] hover:text-[#2E7D32] font-medium transition-colors">
                            <span class="material-symbols-outlined text-[18px] text-[#2E7D32]">account_tree</span>
                            <span>Struktur SOTK</span>
                        </a>
                        <a href="{{ $wilayahUrl }}" class="flex items-center gap-2.5 px-4 py-2.5 text-sm text-slate-700 hover:bg-[#ECFDF5] hover:text-[#2E7D32] font-medium transition-colors">
                            <span class="material-symbols-outlined text-[18px] text-[#2E7D32]">map</span>
                            <span>Wilayah Kerja</span>
                        </a>
                        <a href="{{ $fasilitasUrl }}" class="flex items-center gap-2.5 px-4 py-2.5 text-sm text-slate-700 hover:bg-[#ECFDF5] hover:text-[#2E7D32] font-medium transition-colors">
                            <span class="material-symbols-outlined text-[18px] text-[#2E7D32]">apartment</span>
                            <span>Fasilitas</span>
                        </a>
                    </div>
                </div>
            </div>

            {{-- Dropdown: Layanan --}}
            <div class="relative" @mouseenter="layananOpen = true" @mouseleave="layananOpen = false">
                <button type="button"
                        @click="layananOpen = !layananOpen; profilOpen = false"
                        :aria-expanded="layananOpen.toString()"
                        class="px-3.5 py-2 rounded-lg text-sm flex items-center gap-1 transition-colors {{ request()->is('layanan*') ? 'text-[#2E7D32] font-bold bg-[#E8F5E9]' : 'text-slate-600 font-semibold hover:text-[#003822] hover:bg-[#ECFDF5]' }}">
                    <span>Layanan</span>
                    <span class="material-symbols-outlined text-[18px] transition-transform duration-150" :class="layananOpen ? 'rotate-180' : ''">expand_more</span>
                </button>
                <div x-show="layananOpen"
                     x-transition:enter="transition ease-out duration-150"
                     x-transition:enter-start="opacity-0 translate-y-1"
                     x-transition:enter-end="opacity-100 translate-y-0"
                     x-transition:leave="transition ease-in duration-100"
                     x-transition:leave-start="opacity-100 translate-y-0"
                     x-transition:leave-end="opacity-0 translate-y-1"
                     x-cloak
                     class="absolute left-0 top-full pt-2 w-56 z-50">
                    <div class="bg-white rounded-xl border border-slate-200 shadow-lg py-2">
                        <a href="{{ $servicesUrl }}" class="flex items-center gap-2.5 px-4 py-2.5 text-sm text-slate-700 hover:bg-[#ECFDF5] hover:text-[#2E7D32] font-medium transition-colors">
                            <span class="material-symbols-outlined text-[18px] text-[#2E7D32]">medical_services</span>
                            <span>Daftar Poli</span>
                        </a>
                        <a href="{{ $alurUrl }}" class="flex items-center gap-2.5 px-4 py-2.5 text-sm text-slate-700 hover:bg-[#ECFDF5] hover:text-[#2E7D32] font-medium transition-colors">
                            <span class="material-symbols-outlined text-[18px] text-[#2E7D32]">route</span>
                            <span>Alur Pelayanan</span>
                        </a>
                    </div>
                </div>
            </div>

            <a href="{{ $postsUrl }}"
               class="px-3.5 py-2 rounded-lg text-sm transition-colors {{ request()->is('informasi*') ? 'text-[#2E7D32] font-bold bg-[#E8F5E9]' : 'text-slate-600 font-semibold hover:text-[#003822] hover:bg-[#ECFDF5]' }}">
                Informasi
            </a>

            <a href="{{ $contactUrl }}"
               class="px-3.5 py-2 rounded-lg text-sm transition-colors {{ request()->is('kontak*') ? 'text-[#2E7D32] font-bold bg-[#E8F5E9]' : 'text-slate-600 font-semibold hover:text-[#003822] hover:bg-[#ECFDF5]' }}">
                Kontak &amp; Saran
            </a>
        </nav>

        {{-- Kanan: Tombol Portal Petugas & Hamburger Mobile --}}
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.login') }}"
               class="hidden sm:inline-flex items-center gap-1.5 border-2 border-[#2E7D32] text-[#2E7D32] hover:bg-[#2E7D32] hover:text-white font-semibold px-4 py-2 rounded-xl text-sm transition-all">
                <span>Portal Petugas →</span>
            </a>

            <button type="button"
                    @click="mobileMenu = !mobileMenu"
                    :aria-expanded="mobileMenu.toString()"
                    aria-label="Buka Menu Navigasi"
                    class="lg:hidden inline-flex items-center justify-center p-2 rounded-xl text-slate-700 hover:bg-[#ECFDF5] hover:text-[#2E7D32] border border-slate-200 transition-colors">
                <span class="material-symbols-outlined text-[24px]" x-text="mobileMenu ? 'close' : 'menu'">menu</span>
            </button>
        </div>
    </div>

    {{-- Menu Navigasi Mobile --}}
    <div x-show="mobileMenu"
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 -translate-y-2"
         x-transition:enter-end="opacity-100 translate-y-0"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100 translate-y-0"
         x-transition:leave-end="opacity-0 -translate-y-2"
         x-cloak
         class="lg:hidden bg-white border-t border-slate-200 px-4 py-4 space-y-2 shadow-lg">
        <a href="{{ $homeUrl }}"
           class="block px-3.5 py-2.5 rounded-lg text-sm {{ request()->is('/') ? 'bg-[#E8F5E9] text-[#2E7D32] font-bold' : 'text-slate-700 font-semibold hover:bg-[#ECFDF5]' }}">
            Beranda
        </a>

        <div x-data="{ open: {{ request()->is('profil*') ? 'true' : 'false' }} }" class="space-y-1">
            <button type="button"
                    @click="open = !open"
                    class="w-full flex items-center justify-between px-3.5 py-2.5 rounded-lg text-sm font-semibold {{ request()->is('profil*') ? 'bg-[#E8F5E9] text-[#2E7D32]' : 'text-slate-700 hover:bg-[#ECFDF5]' }}">
                <span>Profil</span>
                <span class="material-symbols-outlined text-[18px] transition-transform" :class="open ? 'rotate-180' : ''">expand_more</span>
            </button>
            <div x-show="open" x-cloak class="pl-4 space-y-1 border-l-2 border-emerald-200 ml-3">
                <a href="{{ $visiMisiUrl }}" class="block px-3 py-2 rounded-lg text-sm text-slate-600 hover:bg-[#ECFDF5] hover:text-[#2E7D32]">Visi Misi</a>
                <a href="{{ $strukturUrl }}" class="block px-3 py-2 rounded-lg text-sm text-slate-600 hover:bg-[#ECFDF5] hover:text-[#2E7D32]">Struktur SOTK</a>
                <a href="{{ $wilayahUrl }}" class="block px-3 py-2 rounded-lg text-sm text-slate-600 hover:bg-[#ECFDF5] hover:text-[#2E7D32]">Wilayah Kerja</a>
                <a href="{{ $fasilitasUrl }}" class="block px-3 py-2 rounded-lg text-sm text-slate-600 hover:bg-[#ECFDF5] hover:text-[#2E7D32]">Fasilitas</a>
            </div>
        </div>

        <div x-data="{ open: {{ request()->is('layanan*') ? 'true' : 'false' }} }" class="space-y-1">
            <button type="button"
                    @click="open = !open"
                    class="w-full flex items-center justify-between px-3.5 py-2.5 rounded-lg text-sm font-semibold {{ request()->is('layanan*') ? 'bg-[#E8F5E9] text-[#2E7D32]' : 'text-slate-700 hover:bg-[#ECFDF5]' }}">
                <span>Layanan</span>
                <span class="material-symbols-outlined text-[18px] transition-transform" :class="open ? 'rotate-180' : ''">expand_more</span>
            </button>
            <div x-show="open" x-cloak class="pl-4 space-y-1 border-l-2 border-emerald-200 ml-3">
                <a href="{{ $servicesUrl }}" class="block px-3 py-2 rounded-lg text-sm text-slate-600 hover:bg-[#ECFDF5] hover:text-[#2E7D32]">Daftar Poli</a>
                <a href="{{ $alurUrl }}" class="block px-3 py-2 rounded-lg text-sm text-slate-600 hover:bg-[#ECFDF5] hover:text-[#2E7D32]">Alur Pelayanan</a>
            </div>
        </div>

        <a href="{{ $postsUrl }}"
           class="block px-3.5 py-2.5 rounded-lg text-sm {{ request()->is('informasi*') ? 'bg-[#E8F5E9] text-[#2E7D32] font-bold' : 'text-slate-700 font-semibold hover:bg-[#ECFDF5]' }}">
            Informasi
        </a>

        <a href="{{ $contactUrl }}"
           class="block px-3.5 py-2.5 rounded-lg text-sm {{ request()->is('kontak*') ? 'bg-[#E8F5E9] text-[#2E7D32] font-bold' : 'text-slate-700 font-semibold hover:bg-[#ECFDF5]' }}">
            Kontak &amp; Saran
        </a>

        <div class="pt-2 border-t border-slate-100 sm:hidden">
            <a href="{{ route('admin.login') }}"
               class="w-full inline-flex items-center justify-center border-2 border-[#2E7D32] text-[#2E7D32] hover:bg-[#2E7D32] hover:text-white font-semibold px-4 py-2 rounded-xl text-sm transition-all">
                Portal Petugas →
            </a>
        </div>
    </div>
</header>
