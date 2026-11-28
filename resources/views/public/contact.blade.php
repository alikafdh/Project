@php
    $homeUrl = \Illuminate\Support\Facades\Route::has('public.home') ? route('public.home') : url('/');
    $feedbackStoreUrl = \Illuminate\Support\Facades\Route::has('public.feedback.store')
        ? route('public.feedback.store')
        : url('/kontak/kirim-saran');

    $waNumber = $profil->wa_number ?? '6281123456789';
    $noTelepon = $profil->no_telepon ?? '(0232) 8611118';
    $email = $profil->email ?? 'puskesmascilimus@kuningankab.go.id';
    $mapsRouteUrl = 'https://www.google.com/maps/search/?api=1&query=' . urlencode($profil->koordinat_peta ?? '-6.9829285,108.4989679');
@endphp

<x-app-layout>
    <x-slot name="title">Hubungi Kami &amp; Sampaikan Saran</x-slot>

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
                <span class="text-white font-semibold">Kontak &amp; Saran</span>
            </nav>

            <div class="flex flex-wrap items-center gap-2">
                <span class="px-3 py-1 rounded-full bg-white/10 border border-white/15 text-emerald-200 text-xs font-semibold uppercase tracking-wider">
                    Layanan Aspirasi &amp; Keluhan Masyarakat
                </span>
                <span class="px-3 py-1 rounded-full bg-emerald-400/20 border border-emerald-300/30 text-emerald-100 text-xs font-semibold">
                    Responsif, Transparan &amp; Akuntabel
                </span>
            </div>

            <h1 class="text-3xl sm:text-4xl font-extrabold tracking-tight text-white">
                Hubungi Kami &amp; Sampaikan Saran
            </h1>
            <p class="text-sm sm:text-base text-emerald-50/90 max-w-2xl leading-relaxed">
                Sampaikan pertanyaan, kritik membangun, permohonan informasi, atau apresiasi pelayanan Anda untuk peningkatan mutu fasilitas kesehatan UPTD Puskesmas Cilimus.
            </p>
        </div>
    </section>

    <section class="py-12 lg:py-16 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-12">
        {{-- ================================================================= --}}
        {{-- SEKSI 1: 3 INFO CARDS TERPISAH                                    --}}
        {{-- ================================================================= --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            {{-- Card 1: Alamat Lengkap --}}
            <div class="bg-white rounded-2xl p-6 border border-slate-200/90 shadow-xs flex flex-col justify-between space-y-4">
                <div class="space-y-3">
                    <div class="w-12 h-12 rounded-xl bg-emerald-50 text-[#2E7D32] flex items-center justify-center">
                        <span class="material-symbols-outlined text-[26px]">location_on</span>
                    </div>
                    <h2 class="text-lg font-bold text-slate-900">📍 Alamat Lengkap</h2>
                    <p class="text-sm text-slate-600 leading-relaxed">
                        {{ $profil->alamat }}
                    </p>
                </div>

                <div class="pt-4 border-t border-slate-100">
                    <a href="{{ $mapsRouteUrl }}"
                       target="_blank"
                       rel="noopener noreferrer"
                       class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl border border-[#2E7D32] text-[#2E7D32] hover:bg-[#2E7D32] hover:text-white text-xs sm:text-sm font-semibold transition-colors">
                        <span class="material-symbols-outlined text-[18px]">directions</span>
                        <span>Buka Rute Google Maps</span>
                    </a>
                </div>
            </div>

            {{-- Card 2: Telepon & WhatsApp --}}
            <div class="bg-white rounded-2xl p-6 border border-slate-200/90 shadow-xs flex flex-col justify-between space-y-4">
                <div class="space-y-3">
                    <div class="w-12 h-12 rounded-xl bg-emerald-50 text-[#2E7D32] flex items-center justify-center">
                        <span class="material-symbols-outlined text-[26px]">call</span>
                    </div>
                    <h2 class="text-lg font-bold text-slate-900">📞 Telepon &amp; WhatsApp</h2>
                    <div class="space-y-2 text-sm text-slate-600">
                        <div class="flex items-center justify-between gap-2">
                            <span>Hotline UGD 24 Jam:</span>
                            <span class="font-bold text-slate-900">{{ $noTelepon }}</span>
                        </div>
                        <div class="flex items-center justify-between gap-2">
                            <span>WA Humas:</span>
                            <span class="font-bold text-[#2E7D32]">{{ $waNumber }}</span>
                        </div>
                    </div>
                </div>

                <div class="pt-4 border-t border-slate-100 flex flex-wrap gap-2">
                    <a href="https://wa.me/{{ $waNumber }}"
                       target="_blank"
                       rel="noopener noreferrer"
                       class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl bg-[#25D366] hover:bg-[#1ebe5d] text-white text-xs sm:text-sm font-semibold transition-colors">
                        <span class="material-symbols-outlined text-[18px]">chat</span>
                        <span>Chat WA Humas</span>
                    </a>
                    <a href="tel:{{ preg_replace('/[^0-9]/', '', $noTelepon) }}"
                       class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl border border-slate-300 text-slate-700 hover:bg-slate-50 text-xs sm:text-sm font-semibold transition-colors">
                        <span>Hubungi UGD</span>
                    </a>
                </div>
            </div>

            {{-- Card 3: Email & Jam Kerja Loket --}}
            <div class="bg-white rounded-2xl p-6 border border-slate-200/90 shadow-xs flex flex-col justify-between space-y-4">
                <div class="space-y-3">
                    <div class="w-12 h-12 rounded-xl bg-emerald-50 text-[#2E7D32] flex items-center justify-center">
                        <span class="material-symbols-outlined text-[26px]">mail</span>
                    </div>
                    <h2 class="text-lg font-bold text-slate-900">📧 Email &amp; Jam Kerja Loket</h2>
                    <div class="space-y-2 text-sm text-slate-600">
                        <p class="font-semibold text-slate-900 break-all">{{ $email }}</p>
                        <div class="text-xs space-y-1 text-slate-600 pt-1">
                            <p><strong>Jadwal Operasional TU &amp; Loket:</strong></p>
                            <p>Senin–Kamis &amp; Sabtu: 07:30–14:00 WIB</p>
                            <p>Jumat: 07:30–11:30 WIB</p>
                        </div>
                    </div>
                </div>

                <div class="pt-4 border-t border-slate-100">
                    <a href="mailto:{{ $email }}"
                       class="inline-flex items-center gap-1.5 text-xs sm:text-sm font-semibold text-[#2E7D32] hover:text-[#1B5E20] transition-colors">
                        <span>Kirim Email Kedinasan</span>
                        <span class="material-symbols-outlined text-[18px]">arrow_forward</span>
                    </a>
                </div>
            </div>
        </div>

        {{-- ================================================================= --}}
        {{-- SEKSI 2: EMBED GOOGLE MAPS ASLI                                   --}}
        {{-- ================================================================= --}}
        <div class="bg-white rounded-2xl p-4 sm:p-6 border border-slate-200/90 shadow-xs">
            <div class="flex flex-wrap items-center justify-between gap-2 mb-2">
                <h2 class="text-base sm:text-lg font-bold text-slate-900 flex items-center gap-2">
                    <span class="material-symbols-outlined text-[20px] text-[#2E7D32]">map</span>
                    <span>Lokasi UPTD Puskesmas Cilimus (Google Maps)</span>
                </h2>
                <a href="{{ $mapsRouteUrl }}"
                   target="_blank"
                   rel="noopener noreferrer"
                   class="text-xs font-semibold text-[#2E7D32] hover:underline">
                    Buka di Tab Baru →
                </a>
            </div>

            <iframe src="https://maps.google.com/maps?q=-6.9829285,108.4989679&hl=id&z=16&output=embed"
                    title="Peta Lokasi UPTD Puskesmas Cilimus"
                    class="w-full h-[400px] rounded-2xl border-0 shadow-sm my-8"
                    loading="lazy"
                    allowfullscreen
                    referrerpolicy="no-referrer-when-downgrade"></iframe>
        </div>

        {{-- ================================================================= --}}
        {{-- SEKSI 3: FORMULIR KRITIK & SARAN SEDERHANA (5 FIELD)              --}}
        {{-- ================================================================= --}}
        <div class="max-w-3xl mx-auto bg-white rounded-2xl p-6 sm:p-10 border border-slate-200/90 shadow-sm space-y-6">
            <div class="text-center space-y-2">
                <span class="inline-block px-3 py-1 rounded-full bg-[#ECFDF5] text-[#15803D] text-xs font-bold uppercase tracking-wider">
                    Partisipasi Publik
                </span>
                <h2 class="text-2xl sm:text-3xl font-bold text-slate-900">
                    Sampaikan Kritik &amp; Saran Anda
                </h2>
                <p class="text-sm text-slate-600 max-w-xl mx-auto">
                    Kerahasiaan identitas pelapor terjamin. Data Anda hanya digunakan untuk verifikasi dan tindak lanjut petugas pengaduan UPTD Puskesmas Cilimus.
                </p>
            </div>

            {{-- Alert Sukses Hijau --}}
            @if(session('success'))
                <div class="p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-800 flex items-start gap-3">
                    <span class="material-symbols-outlined text-[#2E7D32] text-[22px] mt-0.5">check_circle</span>
                    <p class="text-sm font-medium leading-relaxed">{{ session('success') }}</p>
                </div>
            @endif

            {{-- Alert Error Validasi --}}
            @if($errors->any())
                <div class="p-4 rounded-xl bg-rose-50 border border-rose-200 text-rose-800 text-sm space-y-1">
                    <p class="font-bold">Mohon periksa kembali isian formulir Anda:</p>
                    <ul class="list-disc pl-5 space-y-0.5 text-xs">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ $feedbackStoreUrl }}" method="POST" class="space-y-5">
                @csrf

                {{-- Field 1: Nama Lengkap --}}
                <div>
                    <label for="nama_pengirim" class="block text-sm font-semibold text-slate-800 mb-1.5">
                        Nama Lengkap <span class="text-rose-600">*</span>
                    </label>
                    <input type="text"
                           id="nama_pengirim"
                           name="nama_pengirim"
                           value="{{ old('nama_pengirim') }}"
                           required
                           maxlength="100"
                           placeholder="Contoh: Budi Santoso"
                           class="w-full px-4 py-3 rounded-xl border border-slate-300 text-sm text-slate-900 placeholder-slate-400 focus:border-[#2E7D32] focus:ring-[#2E7D32]">
                </div>

                {{-- Field 2: Nomor WhatsApp / Email --}}
                <div>
                    <label for="kontak" class="block text-sm font-semibold text-slate-800 mb-1.5">
                        Nomor WhatsApp / Email <span class="text-rose-600">*</span>
                    </label>
                    <input type="text"
                           id="kontak"
                           name="kontak"
                           value="{{ old('kontak') }}"
                           required
                           maxlength="100"
                           placeholder="Contoh: 081234567890 atau nama@email.com"
                           class="w-full px-4 py-3 rounded-xl border border-slate-300 text-sm text-slate-900 placeholder-slate-400 focus:border-[#2E7D32] focus:ring-[#2E7D32]">
                </div>

                {{-- Field 3: Klaster yang Dituju --}}
                <div>
                    <label for="klaster_id" class="block text-sm font-semibold text-slate-800 mb-1.5">
                        Klaster yang Dituju
                    </label>
                    <select id="klaster_id"
                            name="klaster_id"
                            class="w-full px-4 py-3 rounded-xl border border-slate-300 text-sm text-slate-900 focus:border-[#2E7D32] focus:ring-[#2E7D32]">
                        <option value="">Umum / Layanan Lainnya</option>
                        @foreach($klasters as $k)
                            <option value="{{ $k->id }}" @selected((string) old('klaster_id') === (string) $k->id)>
                                {{ $k->nama }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Field 4: Subjek Masukan --}}
                <div>
                    <label for="subjek" class="block text-sm font-semibold text-slate-800 mb-1.5">
                        Subjek Masukan <span class="text-rose-600">*</span>
                    </label>
                    <input type="text"
                           id="subjek"
                           name="subjek"
                           value="{{ old('subjek') }}"
                           required
                           maxlength="200"
                           placeholder="Contoh: Saran Waktu Tunggu Loket / Apresiasi Pelayanan"
                           class="w-full px-4 py-3 rounded-xl border border-slate-300 text-sm text-slate-900 placeholder-slate-400 focus:border-[#2E7D32] focus:ring-[#2E7D32]">
                </div>

                {{-- Field 5: Isi Pesan --}}
                <div>
                    <label for="isi_pesan" class="block text-sm font-semibold text-slate-800 mb-1.5">
                        Isi Pesan <span class="text-rose-600">*</span>
                    </label>
                    <textarea id="isi_pesan"
                              name="isi_pesan"
                              rows="5"
                              required
                              maxlength="2000"
                              placeholder="Sampaikan kritik, saran, atau apresiasi Anda secara objektif dan santun..."
                              class="w-full px-4 py-3 rounded-xl border border-slate-300 text-sm text-slate-900 placeholder-slate-400 focus:border-[#2E7D32] focus:ring-[#2E7D32]">{{ old('isi_pesan') }}</textarea>
                </div>

                {{-- Tombol Submit Solid Green #2E7D32 --}}
                <button type="submit"
                        class="w-full py-3.5 rounded-xl font-bold text-white bg-[#2E7D32] hover:bg-[#1B5E20] shadow-sm transition-colors text-sm sm:text-base">
                    Kirim Masukan →
                </button>
            </form>
        </div>
    </section>
</x-app-layout>
