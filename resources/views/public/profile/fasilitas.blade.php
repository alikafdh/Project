@php
    $fotoFasilitasExists = ! empty($profil?->foto_fasilitas) && file_exists(public_path('storage/' . $profil->foto_fasilitas));
    $fotoFasilitasUrl = $fotoFasilitasExists ? asset('storage/' . $profil->foto_fasilitas) : null;

    $fasilitasList = [
        [
            'nama' => 'Ruang Pendaftaran & Rekam Medis Elektronik',
            'kategori' => 'ruang',
            'label' => 'Ruang Pelayanan',
            'ikon' => 'desk',
            'fungsi' => 'Loket registrasi pasien BPJS & Umum dengan antrean terpisah bagi jalur prioritas lansia, ibu hamil, dan disabilitas.',
        ],
        [
            'nama' => 'Unit Gawat Darurat (UGD) & Triase 24 Jam',
            'kategori' => 'ruang',
            'label' => 'Ruang Pelayanan',
            'ikon' => 'emergency',
            'fungsi' => 'Ruang penanganan kegawatdaruratan medis, observasi awal, tindakan bedah minor, dan stabilisasi pasien rujukan.',
        ],
        [
            'nama' => 'Ruang Persalinan (PONED) & Rawat Nifas',
            'kategori' => 'ruang',
            'label' => 'Ruang Pelayanan',
            'ikon' => 'pregnant_woman',
            'fungsi' => 'Fasilitas pertolongan persalinan normal 24 jam serta stabilisasi awal komplikasi obstetri dan neonatal.',
        ],
        [
            'nama' => 'Poli KIA, KB & Pojok Laktasi Ramah Anak',
            'kategori' => 'ruang',
            'label' => 'Ruang Pelayanan',
            'ikon' => 'child_friendly',
            'fungsi' => 'Ruang pemeriksaan kehamilan terpadu, tumbuh kembang balita, serta ruang menyusui yang nyaman dan privat.',
        ],
        [
            'nama' => 'Dental Unit & Peralatan Poli Gigi Modern',
            'kategori' => 'alat',
            'label' => 'Alat Medis',
            'ikon' => 'dentistry',
            'fungsi' => 'Kursi gigi elektrik dengan scaler ultrasonik, sterilisator autoklaf berstandar PPI, dan instrumen bedah mulut dasar.',
        ],
        [
            'nama' => 'USG Obstetri & Inkubator Bayi PONED',
            'kategori' => 'alat',
            'label' => 'Alat Medis',
            'ikon' => 'monitor_heart',
            'fungsi' => 'Peralatan pemantauan kehamilan trimester oleh dokter terlatih serta perawatan kehangatan bayi baru lahir.',
        ],
        [
            'nama' => 'Laboratorium Hematologi & TCM Tuberkulosis',
            'kategori' => 'alat',
            'label' => 'Alat Medis',
            'ikon' => 'biotech',
            'fungsi' => 'Hematology analyzer, fotometer kimia darah, mikroskop klinis, dan pemeriksaan cepat molekuler TB.',
        ],
        [
            'nama' => 'Depo Farmasi & Cold Chain Vaksin',
            'kategori' => 'penunjang',
            'label' => 'Penunjang',
            'ikon' => 'medication',
            'fungsi' => 'Unit peracikan dan konseling obat dengan lemari pendingin vaksin berpemantau suhu otomatis 2–8°C.',
        ],
        [
            'nama' => 'Ambulans Siaga & Sarana Akses Disabilitas',
            'kategori' => 'penunjang',
            'label' => 'Penunjang',
            'ikon' => 'airport_shuttle',
            'fungsi' => 'Armada ambulans rujukan siaga 24 jam, jalur landai kursi roda, pegangan koridor, dan area parkir pasien yang luas.',
        ],
    ];
@endphp

<x-app-layout>
    <x-slot name="title">Fasilitas &amp; Sarana</x-slot>

    <x-public.profile-tabs
        active="fasilitas"
        title="Fasilitas &amp; Sarana Prasarana"
        subtitle="Dukungan ruang pelayanan klinis, peralatan diagnostik medis, serta fasilitas penunjang ramah pasien di UPTD Puskesmas Cilimus."
        breadcrumb="Fasilitas &amp; Sarana"
    />

    <section class="py-14 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8" x-data="{ tab: 'semua' }">
        {{-- Foto Utama Gedung Fasilitas (jika tersedia) --}}
        @if($fotoFasilitasUrl)
            <div class="mb-10 bg-white rounded-2xl overflow-hidden border border-slate-200 shadow-sm">
                <div class="aspect-[21/9] bg-slate-100 overflow-hidden">
                    <img src="{{ $fotoFasilitasUrl }}"
                         alt="Gedung Utama UPTD Puskesmas Cilimus"
                         class="w-full h-full object-cover">
                </div>
                <div class="p-4 sm:px-6 bg-slate-50 border-t border-slate-200 flex items-center justify-between text-xs sm:text-sm text-slate-600">
                    <span class="font-semibold text-slate-800">Gedung Utama Pelayanan Terpadu UPTD Puskesmas Cilimus</span>
                    <span>{{ $profil->alamat }}</span>
                </div>
            </div>
        @endif

        {{-- Header & Tab Filter Kategori --}}
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
            <div>
                <span class="text-xs font-bold uppercase tracking-wider text-[#2E7D32]">Inventaris Sarana Pelayanan</span>
                <h3 class="text-2xl font-bold text-slate-900 mt-1">Galeri Ruangan &amp; Peralatan</h3>
            </div>

            <div class="flex flex-wrap items-center gap-2">
                <button type="button" @click="tab = 'semua'"
                        :class="tab === 'semua' ? 'bg-[#2E7D32] text-white shadow-xs' : 'bg-white text-slate-700 border border-slate-200 hover:bg-emerald-50'"
                        class="px-4 py-2 rounded-xl text-xs sm:text-sm font-semibold transition-all">
                    Semua Fasilitas
                </button>
                <button type="button" @click="tab = 'ruang'"
                        :class="tab === 'ruang' ? 'bg-[#2E7D32] text-white shadow-xs' : 'bg-white text-slate-700 border border-slate-200 hover:bg-emerald-50'"
                        class="px-4 py-2 rounded-xl text-xs sm:text-sm font-semibold transition-all">
                    Ruang Pelayanan
                </button>
                <button type="button" @click="tab = 'alat'"
                        :class="tab === 'alat' ? 'bg-[#2E7D32] text-white shadow-xs' : 'bg-white text-slate-700 border border-slate-200 hover:bg-emerald-50'"
                        class="px-4 py-2 rounded-xl text-xs sm:text-sm font-semibold transition-all">
                    Alat Medis
                </button>
                <button type="button" @click="tab = 'penunjang'"
                        :class="tab === 'penunjang' ? 'bg-[#2E7D32] text-white shadow-xs' : 'bg-white text-slate-700 border border-slate-200 hover:bg-emerald-50'"
                        class="px-4 py-2 rounded-xl text-xs sm:text-sm font-semibold transition-all">
                    Penunjang
                </button>
            </div>
        </div>

        {{-- Galeri Kartu Fasilitas --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($fasilitasList as $item)
                <article x-show="tab === 'semua' || tab === '{{ $item['kategori'] }}'"
                         x-transition
                         class="bg-white rounded-2xl overflow-hidden border border-slate-200/90 shadow-sm hover:shadow-md transition-all flex flex-col justify-between">
                    <div>
                        <div class="aspect-video bg-gradient-to-br from-[#003822] via-[#065f3c] to-[#2E7D32] relative flex items-center justify-center text-white p-6">
                            <div class="w-16 h-16 rounded-2xl bg-white/15 border border-white/20 backdrop-blur-xs flex items-center justify-center">
                                <span class="material-symbols-outlined text-[36px]">{{ $item['ikon'] }}</span>
                            </div>
                            <span class="absolute top-3 left-3 px-2.5 py-1 rounded-full bg-white/95 text-[#003822] text-[11px] font-bold uppercase tracking-wide">
                                {{ $item['label'] }}
                            </span>
                        </div>

                        <div class="p-6 space-y-2">
                            <h4 class="text-lg font-bold text-slate-900 leading-snug">
                                {{ $item['nama'] }}
                            </h4>
                            <p class="text-sm text-slate-600 leading-relaxed">
                                {{ $item['fungsi'] }}
                            </p>
                        </div>
                    </div>

                    <div class="px-6 pb-5 pt-3 border-t border-slate-100 flex items-center gap-2 text-xs text-[#2E7D32] font-semibold">
                        <span class="material-symbols-outlined text-[16px]">verified</span>
                        <span>Terstandar Keselamatan &amp; Mutu Akreditasi</span>
                    </div>
                </article>
            @endforeach
        </div>
    </section>
</x-app-layout>
