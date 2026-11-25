@props(['title' => null])

@php
    $unreadFeedbackCount = $unreadFeedbackCount ?? \App\Models\Feedback::where('status', 'baru')->count();

    $currentRoute = request()->route() ? request()->route()->getName() : '';
    $breadcrumbTitle = 'Dashboard';

    if (str_starts_with($currentRoute, 'admin.posts')) {
        $breadcrumbTitle = 'Kelola Informasi';
    } elseif (str_starts_with($currentRoute, 'admin.clusters') || str_starts_with($currentRoute, 'admin.klaster')) {
        $breadcrumbTitle = 'Kelola Klaster ILP';
    } elseif (str_starts_with($currentRoute, 'admin.layanan')) {
        $breadcrumbTitle = 'Kelola Layanan / Poli';
    } elseif (str_starts_with($currentRoute, 'admin.profil')) {
        $breadcrumbTitle = 'Kelola Profil Puskesmas';
    } elseif (str_starts_with($currentRoute, 'admin.reminders')) {
        $breadcrumbTitle = 'Reminder WhatsApp';
    } elseif (str_starts_with($currentRoute, 'admin.saran')) {
        $breadcrumbTitle = 'Kotak Saran';
    } elseif (str_starts_with($currentRoute, 'admin.users')) {
        $breadcrumbTitle = 'Kelola Akun';
    }

    $activeTitle = $title ?? $breadcrumbTitle;
@endphp

<header class="bg-white border-b border-slate-200 px-6 py-3 flex items-center justify-between sticky top-0 z-30 shadow-xs">
    <!-- Sisi Kiri: Toggle Buka/Tutup Sidebar & Breadcrumb Navigasi Dinamis -->
    <div class="flex items-center gap-3">
        <!-- Tombol Toggle Buka/Tutup Sidebar (Desktop & Mobile) -->
        <button @click="toggleSidebar()" 
                type="button" 
                class="p-2 rounded-xl text-slate-600 hover:bg-emerald-50 hover:text-[#2E7D32] border border-transparent hover:border-emerald-200 transition-all inline-flex items-center justify-center cursor-pointer"
                :title="(typeof window !== 'undefined' && window.innerWidth >= 768) ? (desktopSidebarOpen ? 'Tutup Sidebar' : 'Buka Sidebar') : (sidebarOpen ? 'Tutup Menu' : 'Buka Menu')"
                aria-label="Toggle Menu Navigasi">
            <span class="hidden md:inline-flex items-center justify-center">
                <span x-show="desktopSidebarOpen" class="material-symbols-outlined text-[22px]">menu_open</span>
                <span x-show="!desktopSidebarOpen" x-cloak class="material-symbols-outlined text-[22px]">menu</span>
            </span>
            <span class="inline-flex md:hidden items-center justify-center">
                <span x-show="!sidebarOpen" class="material-symbols-outlined text-[22px]">menu</span>
                <span x-show="sidebarOpen" x-cloak class="material-symbols-outlined text-[22px]">close</span>
            </span>
        </button>

        <!-- Breadcrumb Navigasi Dinamis -->
        <nav aria-label="Breadcrumb" class="flex items-center gap-1.5 font-medium text-xs sm:text-sm text-slate-500">
            <span class="hidden sm:inline">Admin Portal</span>
            <span class="material-symbols-outlined text-[16px] text-slate-400 hidden sm:inline">chevron_right</span>
            <span class="text-slate-600 hidden md:inline">UPTD Puskesmas Cilimus</span>
            <span class="material-symbols-outlined text-[16px] text-slate-400 hidden md:inline">chevron_right</span>
            <span class="text-[#2E7D32] font-bold">{{ $activeTitle }}</span>
        </nav>
    </div>

    <!-- Sisi Kanan: Status Indikator Sistem, Lonceng Notifikasi, Avatar Admin -->
    <div class="flex items-center gap-3 sm:gap-4">
        <!-- Status Indikator Sistem -->
        <div class="hidden sm:inline-flex items-center gap-2 px-3 py-1 rounded-full bg-emerald-50 text-emerald-700 border border-emerald-200 text-xs font-semibold">
            <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
            <span>Sistem Normal</span>
        </div>

        <!-- Lonceng Notifikasi Saran Masuk -->
        <a href="{{ route('admin.saran.index') }}" 
           aria-label="Notifikasi Saran Baru" 
           class="relative p-2 rounded-full text-slate-500 hover:bg-slate-100 hover:text-slate-800 transition-colors"
           title="Kotak Saran">
            <span class="material-symbols-outlined text-[22px]">notifications</span>
            @if($unreadFeedbackCount > 0)
                <span class="absolute top-1.5 right-1.5 w-2 h-2 rounded-full bg-rose-500 ring-2 ring-white animate-pulse"></span>
            @endif
        </a>

        <div class="h-6 w-px bg-slate-200 hidden sm:block"></div>

        <!-- Avatar Inisial Admin -->
        <div class="flex items-center gap-2.5">
            <div class="w-8 h-8 rounded-full bg-[#2E7D32] text-white flex items-center justify-center font-bold text-xs shadow-sm">
                {{ strtoupper(substr(auth()->user()->nama_lengkap ?? 'A', 0, 2)) }}
            </div>
            <div class="hidden lg:flex flex-col text-left">
                <span class="text-xs font-semibold text-slate-700 truncate max-w-[130px]" title="{{ auth()->user()->nama_lengkap ?? 'Admin' }}">
                    {{ auth()->user()->nama_lengkap ?? 'Admin' }}
                </span>
                <span class="text-[10px] text-slate-400 capitalize">
                    {{ auth()->user()->peran ?? 'Petugas' }}
                </span>
            </div>
        </div>
    </div>
</header>
