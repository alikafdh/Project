@php
    $homeUrl = \Illuminate\Support\Facades\Route::has('public.home') ? route('public.home') : url('/');
    $servicesIndexUrl = \Illuminate\Support\Facades\Route::has('public.services.index') ? route('public.services.index') : url('/layanan');
    $alurUrl = \Illuminate\Support\Facades\Route::has('public.services.alur') ? route('public.services.alur') : url('/layanan/alur');
    $hasServiceShow = \Illuminate\Support\Facades\Route::has('public.services.show');

    $gambarAlurExists = ! empty($layanan->gambar_alur) && file_exists(public_path('storage/' . $layanan->gambar_alur));
@endphp

<x-app-layout>
    <x-slot name="title">{{ $layanan->nama_poli }}</x-slot>

    {{-- Banner Header Detail Layanan --}}
    <section class="relative overflow-hidden bg-gradient-to-br from-[#003822] via-[#054d2f] to-[#2E7D32] text-white py-12 lg:py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 space-y-4">
            <nav aria-label="Breadcrumb" class="flex flex-wrap items-center gap-2 text-xs text-emerald-200/90 font-medium">
                <a href="{{ $homeUrl }}" class="hover:text-white transition-colors inline-flex items-center gap-1">
                    <span class="material-symbols-outlined text-[15px]">home</span>
                    <span>Beranda</span>
                </a>
                <span>/</span>
                <a href="{{ $servicesIndexUrl }}" class="hover:text-white transition-colors">Layanan</a>
                <span>/</span>
                <span class="text-white font-semibold">{{ $layanan->nama_poli }}</span>
            </nav>

            @if($layanan->klaster)
                <span class="inline-block px-3.5 py-1 rounded-full bg-white/15 border border-white/20 text-emerald-100 text-xs font-semibold uppercase tracking-wider">
                    {{ $layanan->klaster->nama }}
                </span>
            @endif

            <h2 class="text-3xl sm:text-4xl font-extrabold tracking-tight text-white">
                {{ $layanan->nama_poli }}
            </h2>
        </div>
    </section>

    <section class="py-12 lg:py-16 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
            {{-- Kolom Utama --}}
            <div class="lg:col-span-8 space-y-8">
                <div class="bg-white rounded-2xl p-6 sm:p-8 border border-slate-200 shadow-xs space-y-6">
                    <div class="flex items-center justify-between flex-wrap gap-3 pb-4 border-b border-slate-100">
                        <div class="flex items-center gap-3">
                            <div class="w-12 h-12 rounded-full bg-emerald-50 text-[#2E7D32] flex items-center justify-center">
                                <span class="material-symbols-outlined text-[26px]">medical_services</span>
                            </div>
                            <div>
                                <p class="text-xs font-bold uppercase tracking-wider text-slate-500">Unit Pelayanan</p>
                                <h3 class="text-xl font-bold text-slate-900">{{ $layanan->nama_poli }}</h3>
                            </div>
                        </div>

                        <span class="px-3 py-1 rounded-full text-xs font-bold uppercase {{ $layanan->status === 'aktif' ? 'bg-[#ECFDF5] text-[#15803D]' : 'bg-rose-50 text-rose-700' }}">
                            {{ $layanan->status === 'aktif' ? 'Layanan Aktif' : 'Nonaktif' }}
                        </span>
                    </div>

                    <div class="space-y-3">
                        <h4 class="text-base font-bold text-slate-900">Deskripsi Pelayanan &amp; Tindakan Medis</h4>
                        <p class="text-sm sm:text-base text-slate-700 leading-relaxed">
                            {{ $layanan->deskripsi ?? 'Pelayanan kesehatan primer terstandar oleh tenaga medis profesional UPTD Puskesmas Cilimus.' }}
                        </p>
                    </div>

                    @if($gambarAlurExists)
                        <div class="space-y-3 pt-4 border-t border-slate-100">
                            <h4 class="text-base font-bold text-slate-900">Alur Khusus {{ $layanan->nama_poli }}</h4>
                            <figure class="bg-slate-50 p-3 rounded-xl border border-slate-200">
                                <img src="{{ asset('storage/' . $layanan->gambar_alur) }}"
                                     alt="Alur Pelayanan {{ $layanan->nama_poli }}"
                                     class="w-full h-auto rounded-lg object-contain">
                            </figure>
                        </div>
                    @endif
                </div>

                <div class="flex flex-wrap items-center justify-between gap-4">
                    <a href="{{ $servicesIndexUrl }}"
                       class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl border border-slate-300 bg-white hover:bg-slate-50 text-sm font-semibold text-slate-700 transition-colors">
                        <span class="material-symbols-outlined text-[18px]">arrow_back</span>
                        <span>Kembali ke Katalog Layanan</span>
                    </a>
                    <a href="{{ $alurUrl }}"
                       class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-[#2E7D32] hover:bg-[#1B5E20] text-white text-sm font-semibold transition-colors">
                        <span>Lihat Alur Pendaftaran Pasien</span>
                        <span class="material-symbols-outlined text-[18px]">arrow_forward</span>
                    </a>
                </div>
            </div>

            {{-- Sidebar Informasi Jadwal & PJ --}}
            <aside class="lg:col-span-4 space-y-6">
                <div class="bg-white rounded-2xl p-6 border border-slate-200 shadow-xs space-y-4">
                    <h4 class="text-base font-bold text-slate-900">Informasi Praktik</h4>

                    <div class="space-y-3 text-sm">
                        <div class="p-3.5 rounded-xl bg-emerald-50/70 border border-emerald-200/70 flex items-start gap-3">
                            <span class="material-symbols-outlined text-[#2E7D32] text-[20px] mt-0.5">schedule</span>
                            <div>
                                <p class="text-xs font-bold uppercase tracking-wider text-[#2E7D32]">Jadwal Praktik</p>
                                <p class="font-semibold text-slate-900 mt-0.5">{{ $layanan->jadwal_praktik }}</p>
                            </div>
                        </div>

                        <div class="p-3.5 rounded-xl bg-slate-50 border border-slate-200/70 flex items-start gap-3">
                            <span class="material-symbols-outlined text-[#2E7D32] text-[20px] mt-0.5">person</span>
                            <div>
                                <p class="text-xs font-bold uppercase tracking-wider text-slate-500">Penanggung Jawab</p>
                                <p class="font-semibold text-slate-900 mt-0.5">{{ $layanan->tenaga_medis ?? 'Tim Medis UPTD Puskesmas Cilimus' }}</p>
                            </div>
                        </div>

                        @if($layanan->klaster)
                            <div class="p-3.5 rounded-xl bg-slate-50 border border-slate-200/70 flex items-start gap-3">
                                <span class="material-symbols-outlined text-[#2E7D32] text-[20px] mt-0.5">hub</span>
                                <div>
                                    <p class="text-xs font-bold uppercase tracking-wider text-slate-500">Klaster ILP</p>
                                    <p class="font-semibold text-slate-900 mt-0.5">{{ $layanan->klaster->nama }}</p>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                @if($layananLainnya->isNotEmpty())
                    <div class="bg-white rounded-2xl p-6 border border-slate-200 shadow-xs space-y-4">
                        <h4 class="text-base font-bold text-slate-900">Layanan Terkait Lainnya</h4>
                        <div class="space-y-3">
                            @foreach($layananLainnya as $other)
                                <a href="{{ $hasServiceShow ? route('public.services.show', $other->slug) : url('/layanan/' . $other->slug) }}"
                                   class="block p-3 rounded-xl border border-slate-200/80 hover:border-[#2E7D32] hover:bg-emerald-50/40 transition-all">
                                    <p class="text-sm font-bold text-slate-900">{{ $other->nama_poli }}</p>
                                    <p class="text-xs text-slate-500 mt-0.5">{{ $other->jadwal_praktik }}</p>
                                </a>
                            @endforeach
                        </div>
                    </div>
                @endif
            </aside>
        </div>
    </section>
</x-app-layout>
