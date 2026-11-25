<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Portal Pengelola - UPTD Puskesmas Cilimus</title>

    <!-- Google Fonts: Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Material Symbols Outlined -->
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" rel="stylesheet" />

    <!-- Scripts via Vite -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen w-full flex flex-col md:flex-row overflow-x-hidden font-sans antialiased bg-white text-slate-800">

    <!-- Kolom Kiri: Ilustrasi Institusional & Keunggulan Sistem (45% pada Desktop) -->
    <div class="hidden md:flex flex-col justify-between w-full md:w-[45%] min-h-screen bg-[#003822] p-10 lg:p-14 relative overflow-hidden text-white select-none flex-shrink-0">
        <!-- Radial Glow & Medical Pattern Background -->
        <div class="absolute -top-32 -left-32 w-96 h-96 bg-[#2E7D32]/35 rounded-full blur-3xl pointer-events-none"></div>
        <div class="absolute bottom-0 right-0 w-[500px] h-[500px] bg-[#10B981]/15 rounded-full blur-3xl pointer-events-none"></div>

        <svg class="absolute inset-0 w-full h-full opacity-[0.04] pointer-events-none" height="100%" width="100%" xmlns="http://www.w3.org/2000/svg">
            <defs>
                <pattern id="grid-pattern" width="48" height="48" patternUnits="userSpaceOnUse">
                    <path d="M 48 0 L 0 0 0 48" fill="none" stroke="#FFFFFF" stroke-width="1.2"></path>
                    <path d="M 24 20 L 24 28 M 20 24 L 28 24" fill="none" stroke="#FFFFFF" stroke-width="1.2"></path>
                </pattern>
            </defs>
            <rect width="100%" height="100%" fill="url(#grid-pattern)"></rect>
        </svg>

        <!-- Header Kolom Kiri: Logo & Nama Instansi -->
        <div class="relative z-10 flex items-center gap-3.5">
            <div class="w-12 h-12 rounded-xl bg-white/10 backdrop-blur-md border border-white/20 flex items-center justify-center text-emerald-300 shadow-lg shadow-black/10">
                <span class="material-symbols-outlined text-[28px]">local_hospital</span>
            </div>
            <div>
                <h1 class="text-base font-bold tracking-wider uppercase text-white">UPTD PUSKESMAS CILIMUS</h1>
                <p class="text-xs text-emerald-200/80 font-medium">Dinas Kesehatan Kabupaten Kuningan</p>
            </div>
        </div>

        <!-- Center Section: Tagline & Keunggulan Sistem Digital -->
        <div class="relative z-10 my-auto py-8">
            <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-white/10 backdrop-blur-md border border-white/15 text-emerald-300 text-xs font-semibold mb-6">
                <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                <span>Melayani dengan Sepenuh Hati</span>
            </div>

            <h2 class="text-3xl lg:text-4xl font-extrabold leading-tight tracking-tight text-white mb-4">
                Sistem Informasi Manajemen & Pelayanan Kesehatan Terpadu
            </h2>

            <p class="text-emerald-100/75 text-sm lg:text-base leading-relaxed mb-8 max-w-lg">
                Platform sentral pengelolaan data rekam medis, antrean poli, layanan ILP, serta operasional fasilitas kesehatan secara realtime dan aman.
            </p>

            <!-- Kartu Keunggulan Sistem -->
            <div class="space-y-3 max-w-md">
                <div class="flex items-center gap-3.5 p-3.5 rounded-xl bg-white/[0.07] backdrop-blur-sm border border-white/10 transition-all hover:bg-white/[0.12]">
                    <div class="w-9 h-9 rounded-lg bg-emerald-500/20 text-emerald-300 flex items-center justify-center shrink-0">
                        <span class="material-symbols-outlined text-[20px]">sync_saved_locally</span>
                    </div>
                    <div>
                        <div class="text-sm font-semibold text-white">Integrasi SATUSEHAT & BPJS PCare</div>
                        <div class="text-xs text-emerald-200/70">Sinkronisasi data rekam medis terstandar nasional</div>
                    </div>
                </div>

                <div class="flex items-center gap-3.5 p-3.5 rounded-xl bg-white/[0.07] backdrop-blur-sm border border-white/10 transition-all hover:bg-white/[0.12]">
                    <div class="w-9 h-9 rounded-lg bg-emerald-500/20 text-emerald-300 flex items-center justify-center shrink-0">
                        <span class="material-symbols-outlined text-[20px]">hub</span>
                    </div>
                    <div>
                        <div class="text-sm font-semibold text-white">Integrasi Layanan Primer (ILP) Klaster 1 - 5</div>
                        <div class="text-xs text-emerald-200/70">Alur siklus hidup komprehensif dari bumil hingga lansia</div>
                    </div>
                </div>

                <div class="flex items-center gap-3.5 p-3.5 rounded-xl bg-white/[0.07] backdrop-blur-sm border border-white/10 transition-all hover:bg-white/[0.12]">
                    <div class="w-9 h-9 rounded-lg bg-emerald-500/20 text-emerald-300 flex items-center justify-center shrink-0">
                        <span class="material-symbols-outlined text-[20px]">lock</span>
                    </div>
                    <div>
                        <div class="text-sm font-semibold text-white">Rekam Medis Elektronik (RME) Terenkripsi</div>
                        <div class="text-xs text-emerald-200/70">Keamanan data pasien berstandar kriptografi SHA-256</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Footer Kolom Kiri: Kredensial Resmi -->
        <div class="relative z-10 pt-4 border-t border-white/10 flex items-center justify-between text-xs text-emerald-200/60">
            <div class="flex items-center gap-2">
                <span class="material-symbols-outlined text-[16px] text-emerald-400">verified</span>
                <span class="font-medium text-emerald-100">Sistem Terakreditasi Paripurna Kemenkes RI</span>
            </div>
            <div>© {{ date('Y') }} UPTD Puskesmas Cilimus</div>
        </div>
    </div>

    <!-- Kolom Kanan: Formulir Login Pengelola (55% pada Desktop) -->
    <div class="w-full md:w-[55%] min-h-screen flex items-center justify-center p-6 sm:p-10 lg:p-16 bg-white overflow-y-auto">
        <div class="max-w-md w-full mx-auto">
            <!-- Mobile Header Only -->
            <div class="md:hidden flex items-center gap-3 mb-6 pb-4 border-b border-slate-100">
                <div class="w-10 h-10 rounded-xl bg-[#003822] text-emerald-300 flex items-center justify-center shadow-sm">
                    <span class="material-symbols-outlined text-[24px]">local_hospital</span>
                </div>
                <div>
                    <div class="text-xs font-bold text-slate-900 tracking-wider uppercase">UPTD PUSKESMAS CILIMUS</div>
                    <div class="text-[11px] text-slate-500">Dinas Kesehatan Kabupaten Kuningan</div>
                </div>
            </div>

            <!-- Form Header -->
            <div class="mb-6">
                <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">Portal Pengelola</h2>
                <p class="text-sm text-slate-500 font-medium mt-1">UPTD Puskesmas Cilimus — Backoffice</p>
            </div>

            <!-- Red Alert Box jika ada login_error -->
            @if ($errors->has('login_error'))
                <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl text-sm flex items-center gap-2.5 mb-6 shadow-xs">
                    <span class="material-symbols-outlined text-red-600 text-[20px] shrink-0">error</span>
                    <span class="font-medium">{{ $errors->first('login_error') }}</span>
                </div>
            @endif

            <!-- Form Autentikasi -->
            <form action="{{ route('admin.login') }}" method="POST" class="space-y-5">
                @csrf

                <!-- Input Username -->
                <div>
                    <label class="block font-medium text-slate-700 text-sm mb-1.5" for="username">
                        Username atau Email
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                            <span class="material-symbols-outlined text-[20px]">person</span>
                        </div>
                        <input id="username" 
                               name="username" 
                               type="text" 
                               value="{{ old('username') }}" 
                               placeholder="Masukkan username atau email resmi" 
                               required 
                               autofocus
                               class="w-full py-3 px-3.5 pl-10 border border-slate-200 rounded-xl text-sm text-slate-800 placeholder-slate-400 bg-white focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all shadow-xs" />
                    </div>
                    @error('username')
                        <p class="text-xs text-rose-600 mt-1 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Input Password dengan Toggle Show/Hide Mata (Alpine.js) -->
                <div x-data="{ showPassword: false }">
                    <label class="block font-medium text-slate-700 text-sm mb-1.5" for="password">
                        Kata Sandi
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                            <span class="material-symbols-outlined text-[20px]">lock</span>
                        </div>
                        <input id="password" 
                               name="password" 
                               :type="showPassword ? 'text' : 'password'" 
                               placeholder="••••••••••••" 
                               required 
                               class="w-full py-3 px-3.5 pl-10 pr-10 border border-slate-200 rounded-xl text-sm text-slate-800 placeholder-slate-400 bg-white focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all shadow-xs font-mono" />
                        <button @click="showPassword = !showPassword" 
                                type="button" 
                                class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-slate-400 hover:text-slate-600 transition-colors focus:outline-none" 
                                title="Tampilkan / Sembunyikan Password">
                            <span class="material-symbols-outlined text-[20px]" x-text="showPassword ? 'visibility_off' : 'visibility'">visibility</span>
                        </button>
                    </div>
                    @error('password')
                        <p class="text-xs text-rose-600 mt-1 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Tombol Masuk Solid Green #2E7D32 -->
                <div class="pt-2">
                    <button type="submit" 
                            class="w-full bg-[#2E7D32] hover:bg-[#1B5E20] active:scale-[0.99] text-white font-bold py-3.5 px-4 rounded-xl shadow-md hover:shadow-lg transition-all duration-150 flex items-center justify-center gap-2 mt-4 cursor-pointer">
                        <span>Masuk ke Dashboard</span>
                        <span class="text-base leading-none">→</span>
                    </button>
                </div>
            </form>

            <!-- Catatan Keamanan -->
            <div class="mt-8 pt-6 border-t border-slate-100 flex items-center justify-center gap-2 text-xs text-slate-400">
                <span class="material-symbols-outlined text-[16px] text-slate-400 shrink-0">shield</span>
                <span>Sistem dilindungi enkripsi. Akses terbatas khusus staf resmi.</span>
            </div>
        </div>
    </div>

</body>
</html>
