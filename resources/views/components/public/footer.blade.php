@props(['profil' => null, 'klasters' => collect()])

@php
    $homeUrl = \Illuminate\Support\Facades\Route::has('public.home') ? route('public.home') : url('/');
    $profilUrl = \Illuminate\Support\Facades\Route::has('public.profile.visi-misi') ? route('public.profile.visi-misi') : url('/profil/visi-misi');
    $servicesUrl = \Illuminate\Support\Facades\Route::has('public.services.index') ? route('public.services.index') : url('/layanan');
    $alurUrl = \Illuminate\Support\Facades\Route::has('public.services.alur') ? route('public.services.alur') : url('/layanan/alur');
    $reportsUrl = \Illuminate\Support\Facades\Route::has('public.posts.index') ? route('public.posts.index', ['tipe' => 'laporan']) : url('/informasi?tipe=laporan');
    $contactUrl = \Illuminate\Support\Facades\Route::has('public.feedback.index') ? route('public.feedback.index') : url('/kontak');

    $waNumber = $profil->wa_number ?? '6281123456789';
    $hasServicesRoute = \Illuminate\Support\Facades\Route::has('public.services.index');
@endphp

<footer class="bg-[#003822] text-white pt-12 pb-6">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 pb-10">
            {{-- Kolom 1: Profil Singkat, Badge Akreditasi & Alamat --}}
            <div class="space-y-4">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-white/10 border border-white/15 flex items-center justify-center text-emerald-300 flex-shrink-0">
                        <span class="material-symbols-outlined text-[22px]">local_hospital</span>
                    </div>
                    <div>
                        <h2 class="text-base font-bold text-white leading-tight">PUSKESMAS CILIMUS</h2>
                        <p class="text-xs text-emerald-200/80">Kabupaten Kuningan</p>
                    </div>
                </div>

                <p class="text-sm text-emerald-100/85 leading-relaxed">
                    Puskesmas Ramah, Berkualitas, dan Terjangkau melayani masyarakat Kecamatan Cilimus dan sekitarnya dengan standar Integrasi Layanan Primer (ILP).
                </p>

                <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-emerald-500/20 border border-emerald-400/30 text-emerald-200 text-xs font-semibold tracking-wide uppercase">
                    <span class="material-symbols-outlined text-[15px] text-emerald-300">verified</span>
                    <span>Akreditasi Paripurna</span>
                </div>

                <div class="flex items-start gap-2 text-xs text-emerald-100/80 pt-1">
                    <span class="material-symbols-outlined text-[16px] text-emerald-300 mt-0.5 flex-shrink-0">location_on</span>
                    <span>{{ $profil->alamat ?? 'Jl. Raya Cilimus No. 219, Kec. Cilimus, Kab. Kuningan, Jawa Barat 45556' }}</span>
                </div>
            </div>

            {{-- Kolom 2: Tautan Cepat --}}
            <div class="space-y-4">
                <h3 class="text-sm font-bold uppercase tracking-wider text-white">Tautan Cepat</h3>
                <ul class="space-y-2.5 text-sm text-emerald-100/85">
                    <li>
                        <a href="{{ $homeUrl }}" class="inline-flex items-center gap-1.5 hover:text-emerald-300 transition-colors">
                            <span class="material-symbols-outlined text-[16px] text-emerald-300">chevron_right</span>
                            <span>Beranda</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ $profilUrl }}" class="inline-flex items-center gap-1.5 hover:text-emerald-300 transition-colors">
                            <span class="material-symbols-outlined text-[16px] text-emerald-300">chevron_right</span>
                            <span>Profil</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ $servicesUrl }}" class="inline-flex items-center gap-1.5 hover:text-emerald-300 transition-colors">
                            <span class="material-symbols-outlined text-[16px] text-emerald-300">chevron_right</span>
                            <span>Jadwal Poli</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ $alurUrl }}" class="inline-flex items-center gap-1.5 hover:text-emerald-300 transition-colors">
                            <span class="material-symbols-outlined text-[16px] text-emerald-300">chevron_right</span>
                            <span>Alur Pasien</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ $reportsUrl }}" class="inline-flex items-center gap-1.5 hover:text-emerald-300 transition-colors">
                            <span class="material-symbols-outlined text-[16px] text-emerald-300">chevron_right</span>
                            <span>Laporan Kinerja</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ $contactUrl }}" class="inline-flex items-center gap-1.5 hover:text-emerald-300 transition-colors">
                            <span class="material-symbols-outlined text-[16px] text-emerald-300">chevron_right</span>
                            <span>Kotak Saran</span>
                        </a>
                    </li>
                </ul>
            </div>

            {{-- Kolom 3: 5 Klaster ILP --}}
            <div class="space-y-4">
                <h3 class="text-sm font-bold uppercase tracking-wider text-white">Klaster Layanan ILP</h3>
                <ul class="space-y-2.5 text-sm text-emerald-100/85">
                    @forelse($klasters as $k)
                        <li>
                            <a href="{{ $hasServicesRoute ? route('public.services.index', ['klaster' => $k->slug]) : url('/layanan?klaster=' . $k->slug) }}"
                               class="inline-flex items-start gap-2 hover:text-emerald-300 transition-colors">
                                <span class="material-symbols-outlined text-[16px] text-emerald-300 mt-0.5 flex-shrink-0">medical_information</span>
                                <span>{{ $k->nama }}</span>
                            </a>
                        </li>
                    @empty
                        <li class="text-emerald-200/70 text-xs">Data klaster ILP belum tersedia.</li>
                    @endforelse
                </ul>
            </div>

            {{-- Kolom 4: Jam Operasional & Kontak Resmi --}}
            <div class="space-y-4">
                <h3 class="text-sm font-bold uppercase tracking-wider text-white">Layanan &amp; Kontak</h3>
                <ul class="space-y-3 text-sm text-emerald-100/85">
                    <li class="flex items-start gap-2.5">
                        <span class="material-symbols-outlined text-[18px] text-emerald-300 mt-0.5 flex-shrink-0">schedule</span>
                        <div class="text-xs leading-relaxed">
                            <p class="font-semibold text-white">Jam Operasional Loket:</p>
                            <p>Senin–Kamis &amp; Sabtu: 07:30–11:30 WIB</p>
                            <p>Jumat: 07:30–10:30 WIB</p>
                            <p class="text-emerald-300 font-semibold mt-0.5">UGD &amp; Persalinan: 24 Jam</p>
                        </div>
                    </li>
                    <li class="flex items-center gap-2.5">
                        <span class="material-symbols-outlined text-[18px] text-emerald-300 flex-shrink-0">call</span>
                        <span>{{ $profil->no_telepon ?? '(0232) 8611118' }}</span>
                    </li>
                    <li class="flex items-center gap-2.5">
                        <span class="material-symbols-outlined text-[18px] text-emerald-300 flex-shrink-0">mail</span>
                        <a href="mailto:{{ $profil->email ?? 'puskesmascilimus@kuningankab.go.id' }}" class="hover:text-emerald-300 transition-colors break-all">
                            {{ $profil->email ?? 'puskesmascilimus@kuningankab.go.id' }}
                        </a>
                    </li>
                    <li class="flex items-center gap-2.5">
                        <span class="material-symbols-outlined text-[18px] text-emerald-300 flex-shrink-0">chat</span>
                        <a href="https://wa.me/{{ $waNumber }}" target="_blank" rel="noopener noreferrer" class="hover:text-emerald-300 transition-colors">
                            WhatsApp: {{ $waNumber }}
                        </a>
                    </li>
                </ul>
            </div>
        </div>

        {{-- Bottom Bar Hak Cipta --}}
        <div class="pt-6 border-t border-white/15 flex flex-col sm:flex-row items-center justify-between gap-3 text-xs text-emerald-100/80">
            <p class="text-center sm:text-left">
                © 2026 UPTD Puskesmas Cilimus — Dinas Kesehatan Kabupaten Kuningan
            </p>
            <p class="text-emerald-200/75">
                Portal Pelayanan Kesehatan Masyarakat Terintegrasi
            </p>
        </div>
    </div>
</footer>
