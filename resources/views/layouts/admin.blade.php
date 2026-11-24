<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-slate-50">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? 'CMS Backoffice' }} - UPTD Puskesmas Cilimus</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="h-full font-sans antialiased text-slate-800">
    <div x-data="{ sidebarOpen: false }" class="min-h-full flex flex-col lg:flex-row">
        <!-- Mobile Sidebar Backdrop -->
        <div x-show="sidebarOpen" 
             @click="sidebarOpen = false"
             x-transition:enter="transition-opacity ease-linear duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition-opacity ease-linear duration-300"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             class="fixed inset-0 z-40 bg-slate-900/60 lg:hidden" style="display: none;"></div>

        <!-- Sidebar Navigation -->
        <aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'" 
               class="fixed inset-y-0 left-0 z-50 w-72 bg-emerald-950 text-slate-100 flex flex-col transition-transform duration-300 ease-in-out lg:static lg:translate-x-0">
            <!-- Brand Logo / Header -->
            <div class="h-20 px-6 flex items-center justify-between border-b border-emerald-900/50 bg-emerald-900/40">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 rounded-xl bg-emerald-500/20 border border-emerald-400/30 flex items-center justify-center text-emerald-400 font-bold text-xl shadow-inner">
                        ✚
                    </div>
                    <div>
                        <h1 class="text-base font-bold text-white tracking-tight">Puskesmas Cilimus</h1>
                        <p class="text-xs text-emerald-400 font-medium">Panel Admin CMS</p>
                    </div>
                </div>
                <button @click="sidebarOpen = false" class="lg:hidden text-slate-400 hover:text-white">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>

            <!-- Navigation Links -->
            <nav class="flex-1 px-4 py-6 space-y-1.5 overflow-y-auto">
                <a href="{{ route('admin.dashboard') }}" 
                   class="flex items-center px-3.5 py-2.5 rounded-xl text-sm font-medium transition-all {{ request()->routeIs('admin.dashboard') ? 'bg-emerald-600 text-white shadow-md shadow-emerald-900/40' : 'text-slate-300 hover:bg-emerald-900/40 hover:text-white' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                    Dashboard
                </a>

                <div class="pt-4 pb-1 px-3 text-xs font-semibold text-emerald-400 uppercase tracking-wider">
                    Layanan Primer (ILP)
                </div>

                <a href="{{ route('admin.klaster.index') }}" 
                   class="flex items-center px-3.5 py-2.5 rounded-xl text-sm font-medium transition-all {{ request()->routeIs('admin.klaster.*') ? 'bg-emerald-600 text-white shadow-md shadow-emerald-900/40' : 'text-slate-300 hover:bg-emerald-900/40 hover:text-white' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                    Klaster ILP
                </a>

                <a href="{{ route('admin.layanan.index') }}" 
                   class="flex items-center px-3.5 py-2.5 rounded-xl text-sm font-medium transition-all {{ request()->routeIs('admin.layanan.*') ? 'bg-emerald-600 text-white shadow-md shadow-emerald-900/40' : 'text-slate-300 hover:bg-emerald-900/40 hover:text-white' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                    Layanan & Poliklinik
                </a>

                <div class="pt-4 pb-1 px-3 text-xs font-semibold text-emerald-400 uppercase tracking-wider">
                    Konten & Publikasi
                </div>

                <a href="{{ route('admin.posts.index') }}" 
                   class="flex items-center px-3.5 py-2.5 rounded-xl text-sm font-medium transition-all {{ request()->routeIs('admin.posts.*') ? 'bg-emerald-600 text-white shadow-md shadow-emerald-900/40' : 'text-slate-300 hover:bg-emerald-900/40 hover:text-white' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path></svg>
                    Informasi / Posts
                </a>

                <a href="{{ route('admin.profil.edit') }}" 
                   class="flex items-center px-3.5 py-2.5 rounded-xl text-sm font-medium transition-all {{ request()->routeIs('admin.profil.*') ? 'bg-emerald-600 text-white shadow-md shadow-emerald-900/40' : 'text-slate-300 hover:bg-emerald-900/40 hover:text-white' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                    Profil Puskesmas
                </a>

                <a href="{{ route('admin.saran.index') }}" 
                   class="flex items-center px-3.5 py-2.5 rounded-xl text-sm font-medium transition-all {{ request()->routeIs('admin.saran.*') ? 'bg-emerald-600 text-white shadow-md shadow-emerald-900/40' : 'text-slate-300 hover:bg-emerald-900/40 hover:text-white' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path></svg>
                    Kotak Saran Warga
                </a>

                <div class="pt-4 pb-1 px-3 text-xs font-semibold text-emerald-400 uppercase tracking-wider">
                    Otomasi Layanan
                </div>

                <a href="{{ route('admin.reminders.schedules') }}" 
                   class="flex items-center px-3.5 py-2.5 rounded-xl text-sm font-medium transition-all {{ request()->routeIs('admin.reminders.*') ? 'bg-emerald-600 text-white shadow-md shadow-emerald-900/40' : 'text-slate-300 hover:bg-emerald-900/40 hover:text-white' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
                    Reminder WhatsApp
                </a>

                @if(auth()->user()->isSuperadmin())
                    <div class="pt-4 pb-1 px-3 text-xs font-semibold text-emerald-400 uppercase tracking-wider">
                        Superadmin
                    </div>

                    <a href="{{ route('admin.users.index') }}" 
                       class="flex items-center px-3.5 py-2.5 rounded-xl text-sm font-medium transition-all {{ request()->routeIs('admin.users.*') ? 'bg-emerald-600 text-white shadow-md shadow-emerald-900/40' : 'text-slate-300 hover:bg-emerald-900/40 hover:text-white' }}">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                        Kelola Akun Admin
                    </a>
                @endif
            </nav>

            <!-- User Footer Profile Card -->
            <div class="p-4 border-t border-emerald-900/50 bg-emerald-950/80">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-3 overflow-hidden">
                        <div class="w-9 h-9 rounded-full bg-emerald-700 flex items-center justify-center font-bold text-sm text-white shrink-0">
                            {{ substr(auth()->user()->nama_lengkap ?? 'A', 0, 1) }}
                        </div>
                        <div class="truncate">
                            <p class="text-sm font-semibold text-white truncate">{{ auth()->user()->nama_lengkap }}</p>
                            <span class="inline-flex items-center px-1.5 py-0.5 rounded text-[10px] font-semibold {{ auth()->user()->isSuperadmin() ? 'bg-amber-500/20 text-amber-300' : 'bg-emerald-500/20 text-emerald-300' }}">
                                {{ ucfirst(auth()->user()->peran) }}
                            </span>
                        </div>
                    </div>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" title="Keluar dari sesi" class="p-2 text-slate-400 hover:text-rose-400 hover:bg-rose-500/10 rounded-lg transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                        </button>
                    </form>
                </div>
            </div>
        </aside>

        <!-- Main Content Area -->
        <div class="flex-1 flex flex-col min-w-0 overflow-hidden">
            <!-- Top Navbar -->
            <header class="h-20 bg-white border-b border-slate-200 flex items-center justify-between px-6 lg:px-8">
                <div class="flex items-center space-x-4">
                    <button @click="sidebarOpen = true" class="lg:hidden p-2 rounded-lg text-slate-500 hover:text-slate-700 hover:bg-slate-100">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                    </button>
                    <h2 class="text-lg font-bold text-slate-800">{{ $header ?? 'Panel Pengelolaan' }}</h2>
                </div>

                <div class="flex items-center space-x-4">
                    <a href="{{ url('/') }}" target="_blank" class="hidden sm:inline-flex items-center px-3.5 py-1.5 text-xs font-semibold text-emerald-700 bg-emerald-50 hover:bg-emerald-100 rounded-lg border border-emerald-200 transition-colors">
                        <svg class="w-3.5 h-3.5 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                        Kunjungi Portal Publik
                    </a>

                    <div class="h-6 w-px bg-slate-200"></div>

                    <span class="text-xs text-slate-500 hidden md:inline">
                        {{ now()->isoFormat('dddd, D MMMM Y') }}
                    </span>
                </div>
            </header>

            <!-- Page Body -->
            <main class="flex-1 overflow-y-auto p-6 lg:p-8">
                <!-- Flash Alerts -->
                @if (session('success'))
                    <div class="mb-6 p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-800 flex items-start space-x-3 shadow-sm">
                        <svg class="w-5 h-5 text-emerald-600 mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        <div class="text-sm font-medium">{{ session('success') }}</div>
                    </div>
                @endif

                @if (session('error'))
                    <div class="mb-6 p-4 rounded-xl bg-rose-50 border border-rose-200 text-rose-800 flex items-start space-x-3 shadow-sm">
                        <svg class="w-5 h-5 text-rose-600 mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        <div class="text-sm font-medium">{{ session('error') }}</div>
                    </div>
                @endif

                @if ($errors->any())
                    <div class="mb-6 p-4 rounded-xl bg-amber-50 border border-amber-200 text-amber-800 flex items-start space-x-3 shadow-sm">
                        <svg class="w-5 h-5 text-amber-600 mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                        <div class="text-sm font-medium">
                            <p class="font-semibold mb-1">Terdapat beberapa data yang belum sesuai:</p>
                            <ul class="list-disc list-inside space-y-0.5 text-xs text-amber-700">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                @endif

                {{ $slot ?? '' }}
                @yield('content')
            </main>
        </div>
    </div>
</body>
</html>
