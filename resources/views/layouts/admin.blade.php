<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? 'CMS Backoffice' }} - UPTD Puskesmas Cilimus</title>

    <!-- Google Fonts: Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Material Symbols Outlined -->
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" rel="stylesheet" />

    <!-- Scripts & Styles via Vite -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Pre-init state sidebar desktop agar tidak berkedip saat navigasi -->
    <script>
        try {
            if (localStorage.getItem('admin_sidebar_open') === 'false') {
                document.documentElement.classList.add('admin-sidebar-closed');
            }
        } catch (e) {}
    </script>
</head>
<body class="h-full font-sans antialiased text-slate-800">
    <div x-data="{
            sidebarOpen: false,
            desktopSidebarOpen: (() => {
                try {
                    const saved = localStorage.getItem('admin_sidebar_open');
                    return saved === null ? true : saved === 'true';
                } catch (e) {
                    return true;
                }
            })(),
            toggleSidebar() {
                if (window.innerWidth >= 768) {
                    this.desktopSidebarOpen = !this.desktopSidebarOpen;
                    document.documentElement.classList.toggle('admin-sidebar-closed', !this.desktopSidebarOpen);
                    try {
                        localStorage.setItem('admin_sidebar_open', String(this.desktopSidebarOpen));
                    } catch (e) {}
                } else {
                    this.sidebarOpen = !this.sidebarOpen;
                }
            }
        }"
        @keydown.escape.window="sidebarOpen = false"
        @resize.window="if (window.innerWidth >= 768) sidebarOpen = false"
        class="bg-slate-100 min-h-screen flex">
        <!-- Sidebar Navigation Component -->
        <x-admin.sidebar />

        <!-- Area Konten Utama -->
        <div data-admin-main
             :class="{ 'md:pl-60': desktopSidebarOpen, 'md:pl-0': !desktopSidebarOpen }"
             class="flex-1 md:pl-60 flex flex-col min-h-screen transition-[padding] duration-300 ease-in-out">
            <!-- Topbar Admin Component -->
            <x-admin.topbar :title="$title ?? null" />

            <!-- Session Flash Notifications -->
            @if(session('success') || session('status'))
                <div class="px-6 md:px-8 pt-6">
                    <div class="p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-800 flex items-center justify-between shadow-sm">
                        <div class="flex items-center gap-3">
                            <span class="material-symbols-outlined text-emerald-600 text-[22px]">check_circle</span>
                            <span class="text-sm font-medium">{{ session('success') ?? session('status') }}</span>
                        </div>
                        <button type="button" onclick="this.parentElement.remove()" class="text-emerald-500 hover:text-emerald-800">
                            <span class="material-symbols-outlined text-[18px]">close</span>
                        </button>
                    </div>
                </div>
            @endif

            @if(session('error'))
                <div class="px-6 md:px-8 pt-6">
                    <div class="p-4 rounded-xl bg-rose-50 border border-rose-200 text-rose-800 flex items-center justify-between shadow-sm">
                        <div class="flex items-center gap-3">
                            <span class="material-symbols-outlined text-rose-600 text-[22px]">error</span>
                            <span class="text-sm font-medium">{{ session('error') }}</span>
                        </div>
                        <button type="button" onclick="this.parentElement.remove()" class="text-rose-500 hover:text-rose-800">
                            <span class="material-symbols-outlined text-[18px]">close</span>
                        </button>
                    </div>
                </div>
            @endif

            <!-- Main Content Area -->
            <main class="p-6 md:p-8 flex-1">
                {{ $slot ?? '' }}
                @yield('content')
            </main>
        </div>
    </div>
</body>
</html>
