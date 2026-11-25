@php
    $unreadFeedbackCount = $unreadFeedbackCount ?? \App\Models\Feedback::where('status', 'baru')->count();
    $isReminderActive = request()->routeIs('admin.reminders.*');
@endphp

<!-- Mobile Sidebar Backdrop Overlay -->
<div x-show="sidebarOpen" 
     @click="sidebarOpen = false"
     x-transition:enter="transition-opacity ease-linear duration-200"
     x-transition:enter-start="opacity-0"
     x-transition:enter-end="opacity-100"
     x-transition:leave="transition-opacity ease-linear duration-200"
     x-transition:leave-start="opacity-100"
     x-transition:leave-end="opacity-0"
     class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-40 md:hidden"
     style="display: none;"></div>

<!-- Sidebar Container -->
<aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full md:translate-x-0'"
       class="fixed inset-y-0 left-0 z-50 w-60 bg-[#1A2B4A] text-slate-300 flex flex-col justify-between shadow-2xl transition-transform duration-300 ease-in-out border-r border-slate-700/50">

    <div class="flex flex-col min-h-0 flex-1">
        <!-- 1. Header Sidebar -->
        <div class="h-16 px-4 flex items-center justify-between border-b border-slate-700/60 bg-[#132038] flex-shrink-0">
            <div class="flex items-center gap-3 min-w-0">
                <div class="w-9 h-9 rounded-lg bg-[#2E7D32] flex items-center justify-center text-white shadow-sm flex-shrink-0">
                    <span class="material-symbols-outlined text-[22px]">local_hospital</span>
                </div>
                <div class="flex flex-col min-w-0">
                    <span class="text-sm font-bold text-white tracking-wide truncate">Panel Admin CMS</span>
                    <span class="text-[10px] font-semibold text-emerald-400 uppercase tracking-wider truncate">UPTD Puskesmas Cilimus</span>
                </div>
            </div>
            <!-- Mobile Close Button -->
            <button @click="sidebarOpen = false" type="button" class="md:hidden text-slate-400 hover:text-white p-1">
                <span class="material-symbols-outlined text-[20px]">close</span>
            </button>
        </div>

        <!-- 2. Menu Navigasi -->
        <nav class="flex-1 px-3 py-4 space-y-1.5 overflow-y-auto">
            <!-- 🏠 Dashboard -->
            <a href="{{ route('admin.dashboard') }}" 
               class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all text-sm font-medium {{ request()->routeIs('admin.dashboard') ? 'bg-[#2E7D32] text-white font-semibold shadow-sm' : 'text-slate-300 hover:bg-white/10 hover:text-white' }}">
                <span class="material-symbols-outlined text-[20px]">dashboard</span>
                <span>Dashboard</span>
            </a>

            <!-- 📝 Kelola Informasi -->
            <a href="{{ route('admin.posts.index') }}" 
               class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all text-sm font-medium {{ request()->routeIs('admin.posts.*') ? 'bg-[#2E7D32] text-white font-semibold shadow-sm' : 'text-slate-300 hover:bg-white/10 hover:text-white' }}">
                <span class="material-symbols-outlined text-[20px]">newspaper</span>
                <span>Kelola Informasi</span>
            </a>

            <!-- 🏷️ Kelola Klaster ILP -->
            <a href="{{ route('admin.clusters.index') }}" 
               class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all text-sm font-medium {{ (request()->routeIs('admin.clusters.*') || request()->routeIs('admin.klaster.*')) ? 'bg-[#2E7D32] text-white font-semibold shadow-sm' : 'text-slate-300 hover:bg-white/10 hover:text-white' }}">
                <span class="material-symbols-outlined text-[20px]">category</span>
                <span>Kelola Klaster ILP</span>
            </a>

            <!-- 🏥 Kelola Layanan / Poli -->
            <a href="{{ route('admin.layanan.index') }}" 
               class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all text-sm font-medium {{ request()->routeIs('admin.layanan.*') ? 'bg-[#2E7D32] text-white font-semibold shadow-sm' : 'text-slate-300 hover:bg-white/10 hover:text-white' }}">
                <span class="material-symbols-outlined text-[20px]">medical_services</span>
                <span>Kelola Layanan / Poli</span>
            </a>

            <!-- 👤 Kelola Profil Puskesmas -->
            <a href="{{ route('admin.profil.edit') }}" 
               class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all text-sm font-medium {{ request()->routeIs('admin.profil.*') ? 'bg-[#2E7D32] text-white font-semibold shadow-sm' : 'text-slate-300 hover:bg-white/10 hover:text-white' }}">
                <span class="material-symbols-outlined text-[20px]">account_balance</span>
                <span>Kelola Profil Puskesmas</span>
            </a>

            <!-- 📱 Reminder WhatsApp (Accordion / Sub-Menu) -->
            <div x-data="{ open: {{ $isReminderActive ? 'true' : 'false' }} }" class="space-y-1">
                <button @click="open = !open" 
                        type="button" 
                        class="w-full flex items-center justify-between px-3 py-2.5 rounded-xl transition-all text-sm font-medium {{ $isReminderActive ? 'bg-white/10 text-white font-semibold' : 'text-slate-300 hover:bg-white/10 hover:text-white' }}">
                    <div class="flex items-center gap-3">
                        <span class="material-symbols-outlined text-[20px]">chat</span>
                        <span>Reminder WhatsApp</span>
                    </div>
                    <span class="material-symbols-outlined text-[18px] text-slate-400 transition-transform duration-200" 
                          :class="open ? 'rotate-180 text-white' : ''">expand_more</span>
                </button>

                <!-- Sub-Menu Accordion Items -->
                <div x-show="open" 
                     x-collapse 
                     class="pl-4 pr-1 py-1 space-y-1 border-l-2 border-emerald-500/40 ml-4">
                    <!-- Pasien Terdaftar -->
                    <a href="{{ route('admin.reminders.patients') }}" 
                       class="flex items-center gap-2.5 px-2.5 py-2 rounded-lg text-xs font-medium transition-all {{ request()->routeIs('admin.reminders.patients') ? 'bg-[#2E7D32] text-white font-semibold shadow-xs' : 'text-slate-300 hover:bg-white/10 hover:text-white' }}">
                        <span class="material-symbols-outlined text-[16px]">person_search</span>
                        <span>Pasien Terdaftar</span>
                    </a>

                    <!-- Jadwal & Template -->
                    <a href="{{ route('admin.reminders.schedules') }}" 
                       class="flex items-center gap-2.5 px-2.5 py-2 rounded-lg text-xs font-medium transition-all {{ request()->routeIs('admin.reminders.schedules') ? 'bg-[#2E7D32] text-white font-semibold shadow-xs' : 'text-slate-300 hover:bg-white/10 hover:text-white' }}">
                        <span class="material-symbols-outlined text-[16px]">event_note</span>
                        <span>Jadwal & Template</span>
                    </a>

                    <!-- Log Pengiriman -->
                    <a href="{{ route('admin.reminders.logs') }}" 
                       class="flex items-center gap-2.5 px-2.5 py-2 rounded-lg text-xs font-medium transition-all {{ request()->routeIs('admin.reminders.logs') ? 'bg-[#2E7D32] text-white font-semibold shadow-xs' : 'text-slate-300 hover:bg-white/10 hover:text-white' }}">
                        <span class="material-symbols-outlined text-[16px]">history</span>
                        <span>Log Pengiriman</span>
                    </a>
                </div>
            </div>

            <!-- 💬 Kotak Saran -->
            <a href="{{ route('admin.saran.index') }}" 
               class="flex items-center justify-between px-3 py-2.5 rounded-xl transition-all text-sm font-medium {{ request()->routeIs('admin.saran.*') ? 'bg-[#2E7D32] text-white font-semibold shadow-sm' : 'text-slate-300 hover:bg-white/10 hover:text-white' }}">
                <div class="flex items-center gap-3">
                    <span class="material-symbols-outlined text-[20px]">inbox</span>
                    <span>Kotak Saran</span>
                </div>
                @if($unreadFeedbackCount > 0)
                    <span class="px-2 py-0.5 rounded-full bg-orange-500 text-white font-bold text-xs shadow-sm">
                        {{ $unreadFeedbackCount }}
                    </span>
                @endif
            </a>

            <!-- 👥 Kelola Akun (Khusus Superadmin) -->
            @if(auth()->check() && auth()->user()->peran === 'superadmin')
                <a href="{{ route('admin.users.index') }}" 
                   class="flex items-center justify-between px-3 py-2.5 rounded-xl transition-all text-sm font-medium {{ request()->routeIs('admin.users.*') ? 'bg-[#2E7D32] text-white font-semibold shadow-sm' : 'text-slate-300 hover:bg-white/10 hover:text-white' }}">
                    <div class="flex items-center gap-3">
                        <span class="material-symbols-outlined text-[20px]">manage_accounts</span>
                        <span>Kelola Akun</span>
                    </div>
                    <span class="px-1.5 py-0.5 rounded-md bg-amber-500/20 text-amber-300 border border-amber-500/30 text-[9px] font-semibold tracking-wider uppercase">
                        Superadmin only
                    </span>
                </a>
            @endif
        </nav>
    </div>

    <!-- 3. Footer Sidebar -->
    <div class="p-3 border-t border-slate-700/60 bg-[#132038] flex-shrink-0">
        <!-- Info Profil Petugas -->
        <div class="p-2.5 rounded-xl bg-white/5 border border-white/10 flex items-center justify-between gap-2 mb-2.5">
            <div class="flex items-center gap-2.5 min-w-0">
                <div class="w-8 h-8 rounded-full bg-[#2E7D32] flex items-center justify-center text-white font-bold text-xs flex-shrink-0 shadow-sm">
                    {{ strtoupper(substr(auth()->user()->nama_lengkap ?? 'A', 0, 2)) }}
                </div>
                <div class="flex flex-col min-w-0">
                    <span class="text-xs font-semibold text-white truncate" title="{{ auth()->user()->nama_lengkap ?? 'Petugas' }}">
                        {{ auth()->user()->nama_lengkap ?? 'Petugas' }}
                    </span>
                    <span class="text-[10px] text-emerald-400 font-medium capitalize truncate">
                        {{ auth()->user()->peran ?? 'Admin' }}
                    </span>
                </div>
            </div>
        </div>

        <!-- Tombol Keluar (POST ke route('admin.logout')) -->
        <form method="POST" action="{{ route('admin.logout') }}">
            @csrf
            <button type="submit" 
                    class="w-full flex items-center justify-center gap-2 py-2 px-3 rounded-lg text-xs font-semibold text-rose-300 hover:text-white hover:bg-rose-500/20 transition-all border border-rose-500/30">
                <span class="material-symbols-outlined text-[16px]">logout</span>
                <span>Keluar</span>
            </button>
        </form>
    </div>
</aside>
