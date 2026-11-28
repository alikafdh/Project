@php
    $sotkPath = $profil->strukt_organisasi ?? null;
    $hasStorageSotk = ! empty($sotkPath) && file_exists(public_path('storage/' . $sotkPath));
    $hasDirectSotk = ! empty($sotkPath) && file_exists(public_path($sotkPath));
    $sotkImgUrl = $hasStorageSotk
        ? asset('storage/' . $sotkPath)
        : ($hasDirectSotk ? asset($sotkPath) : null);

    $pimpinanList = [
        [
            'nama' => 'dr. Hj. Endah Sulistyowati, M.Kes',
            'jabatan' => 'Kepala UPTD Puskesmas Cilimus',
            'nip' => '19780512 200604 2 009',
            'golongan' => 'Pembina Tk. I (IV/b)',
            'klaster' => 'Pimpinan Lembaga',
            'kategori' => 'pimpinan',
            'tugas' => 'Penanggung jawab umum operasional fasilitas, kendali mutu pelayanan medis komprehensif, dan kebijakan program kesehatan daerah.',
            'inisial' => 'ES',
        ],
        [
            'nama' => 'H. Ade Mulyana, S.Kep., Ners',
            'jabatan' => 'Kepala Sub Bagian Tata Usaha',
            'nip' => '19820315 200801 1 012',
            'golongan' => 'Penata Tk. I (III/d)',
            'klaster' => 'Subbag Tata Usaha',
            'kategori' => 'pimpinan',
            'tugas' => 'Pengendali tata kelola kepegawaian ASN/Non-ASN, akuntabilitas keuangan BLUD, administrasi surat, dan sistem informasi puskesmas.',
            'inisial' => 'AM',
        ],
        [
            'nama' => 'Hj. Nining Sartika, S.ST',
            'jabatan' => 'Penanggung Jawab Klaster 1',
            'nip' => '19800721 200501 2 008',
            'golongan' => 'Penata (III/c)',
            'klaster' => 'Klaster 1: Manajemen',
            'kategori' => 'klaster',
            'tugas' => 'Koordinasi perencanaan program puskesmas terpadu (RUK/RPK), lokakarya mini lintas sektor, evaluasi SPM, dan kepatuhan akreditasi.',
            'inisial' => 'NS',
        ],
        [
            'nama' => 'dr. Ratna Wulandari',
            'jabatan' => 'Penanggung Jawab Klaster 2',
            'nip' => '19860410 201101 2 015',
            'golongan' => 'Pembina (IV/a)',
            'klaster' => 'Klaster 2: Ibu & Anak',
            'kategori' => 'klaster',
            'tugas' => 'Mengkoordinasikan Poli KIA/KB, Manajemen Terpadu Balita Sakit (MTBS), imunisasi terpadu, ruang laktasi, dan percepatan penurunan stunting.',
            'inisial' => 'RW',
        ],
        [
            'nama' => 'dr. Hendra Wijaya',
            'jabatan' => 'Penanggung Jawab Klaster 3',
            'nip' => '19841103 201001 1 018',
            'golongan' => 'Penata Tk. I (III/d)',
            'klaster' => 'Klaster 3: Dewasa & Lansia',
            'kategori' => 'klaster',
            'tugas' => 'Pelayanan Poli Penyakit Tidak Menular (PTM), hipertensi, diabetes melitus (Prolanis), skrining usia produktif, dan Posbindu Lansia.',
            'inisial' => 'HW',
        ],
        [
            'nama' => 'Ns. Asep Saefullah, S.Kep',
            'jabatan' => 'Penanggung Jawab Klaster 4',
            'nip' => '19890214 201402 1 003',
            'golongan' => 'Penata Muda Tk. I (III/b)',
            'klaster' => 'Klaster 4: P2P & Kesling',
            'kategori' => 'klaster',
            'tugas' => 'Penanganan TB-DOTS, DBD, pencegahan zoonosis, kewaspadaan dini surveilans epidemiologi 12 desa binaan, dan kesehatan lingkungan.',
            'inisial' => 'AS',
        ],
        [
            'nama' => 'dr. M. Fajar Sidik',
            'jabatan' => 'Penanggung Jawab Lintas Klaster',
            'nip' => '19900824 201601 1 007',
            'golongan' => 'Penata Muda (III/a)',
            'klaster' => 'Lintas Klaster: UGD & PONED',
            'kategori' => 'lintas',
            'tugas' => 'Siaga medis triase kegawatdaruratan 24 jam, kesiapsiagaan ambulans, persalinan normal PONED, dan sistem rujukan cepat RSUD.',
            'inisial' => 'MF',
        ],
        [
            'nama' => 'apt. Siti Rahmawati, S.Farm',
            'jabatan' => 'Koordinator Pelayanan Farmasi',
            'nip' => '19920108 201704 2 006',
            'golongan' => 'Penata Muda (III/a)',
            'klaster' => 'Lintas Klaster: Farmasi',
            'kategori' => 'lintas',
            'tugas' => 'Tata kelola obat rasional, verifikasi dispensing resep, pengelolaan rantai dingin vaksin, dan ketersediaan stok obat emergensi.',
            'inisial' => 'SR',
        ],
        [
            'nama' => 'Dadan Ramdani, A.Md.AK',
            'jabatan' => 'Koordinator Laboratorium Medik',
            'nip' => '19930519 201902 1 004',
            'golongan' => 'Pengatur Tk. I (II/d)',
            'klaster' => 'Lintas Klaster: Laboratorium',
            'kategori' => 'lintas',
            'tugas' => 'Diagnostik klinis hematologi lengkap, kimia darah, tes cepat molekuler (TCM) Tuberkulosis, skrining triple eliminasi ibu hamil, dan urinalisis.',
            'inisial' => 'DR',
        ],
    ];
@endphp

<x-app-layout>
    <x-slot name="title">Struktur Organisasi (SOTK)</x-slot>

    <x-public.profile-tabs
        active="struktur"
        title="Struktur Organisasi UPTD Puskesmas Cilimus"
        subtitle="Bagan tata kelola organisasi berbasis Integrasi Layanan Primer (ILP) sesuai pedoman Kementerian Kesehatan RI."
        breadcrumb="Struktur Organisasi"
    />

    {{-- ======================================================================= --}}
    {{-- 1. DIAGRAM BAGAN SOTK (ZOOMABLE CONTAINER + TOOLBAR)                    --}}
    {{-- ======================================================================= --}}
    <section class="py-14 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8"
             x-data="{
                 zoom: 1,
                 zoomIn() { if (this.zoom < 2) this.zoom = Number((this.zoom + 0.2).toFixed(1)); },
                 zoomOut() { if (this.zoom > 0.6) this.zoom = Number((this.zoom - 0.2).toFixed(1)); },
                 resetZoom() { this.zoom = 1; }
             }">
        <div class="flex flex-col lg:flex-row lg:items-end justify-between gap-4 mb-6">
            <div>
                <span class="text-xs font-bold uppercase tracking-wider text-[#2E7D32]">Hierarki Kemenkes RI &amp; Dinkes Kab. Kuningan</span>
                <h3 class="text-2xl sm:text-3xl font-bold text-slate-900 mt-1">Bagan Struktur Organisasi &amp; Tata Kerja (SOTK)</h3>
                <p class="text-sm text-slate-600 mt-1">
                    Pola pembagian tanggung jawab berbasis klaster siklus hidup (Klaster 1 s/d 4 serta Lintas Klaster Gawat Darurat &amp; Penunjang).
                </p>
            </div>

            {{-- Toolbar Zoom & Unduh PDF --}}
            <div class="flex flex-wrap items-center gap-2">
                <div class="inline-flex items-center bg-white border border-slate-200 rounded-xl p-1 shadow-xs">
                    <button type="button"
                            @click="zoomOut()"
                            title="Perkecil Bagan"
                            class="inline-flex items-center gap-1 px-3 py-1.5 rounded-lg text-xs font-semibold text-slate-700 hover:bg-emerald-50 hover:text-[#2E7D32] transition-colors">
                        <span class="material-symbols-outlined text-[18px]">zoom_out</span>
                        <span class="hidden sm:inline">Zoom Out</span>
                    </button>
                    <span class="px-2.5 text-xs font-bold text-[#003822] tabular-nums" x-text="Math.round(zoom * 100) + '%'">100%</span>
                    <button type="button"
                            @click="zoomIn()"
                            title="Perbesar Bagan"
                            class="inline-flex items-center gap-1 px-3 py-1.5 rounded-lg text-xs font-semibold text-slate-700 hover:bg-emerald-50 hover:text-[#2E7D32] transition-colors">
                        <span class="material-symbols-outlined text-[18px]">zoom_in</span>
                        <span class="hidden sm:inline">Zoom In</span>
                    </button>
                    <button type="button"
                            @click="resetZoom()"
                            title="Reset Ukuran"
                            class="inline-flex items-center gap-1 px-3 py-1.5 rounded-lg text-xs font-semibold text-slate-700 hover:bg-slate-100 transition-colors border-l border-slate-200 ml-1">
                        <span class="material-symbols-outlined text-[18px]">restart_alt</span>
                        <span>Reset</span>
                    </button>
                </div>

                <button type="button"
                        onclick="window.print()"
                        class="inline-flex items-center gap-2 bg-[#2E7D32] hover:bg-[#1B5E20] text-white font-semibold px-4 py-2.5 rounded-xl text-xs sm:text-sm shadow-xs transition-colors">
                    <span class="material-symbols-outlined text-[18px]">picture_as_pdf</span>
                    <span>Unduh Bagan Lengkap (PDF)</span>
                </button>
            </div>
        </div>

        {{-- Kontainer Zoomable --}}
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-4 sm:p-6 overflow-auto">
            <div class="origin-top-left transition-transform duration-200"
                 :style="`transform: scale(${zoom}); width: ${100 / zoom}%;`">
                @if($sotkImgUrl)
                    <img src="{{ $sotkImgUrl }}"
                         alt="Bagan Struktur Organisasi dan Tata Kerja UPTD Puskesmas Cilimus"
                         class="w-full object-contain rounded-xl" />
                @else
                    {{-- Fallback Diagram Hierarki Terstruktur bila gambar belum diunggah di CMS --}}
                    <div class="p-6 bg-slate-50 rounded-xl border border-slate-200 space-y-6">
                        <div class="max-w-md mx-auto bg-[#003822] text-white rounded-xl p-4 text-center shadow-sm">
                            <p class="text-[11px] uppercase tracking-wider text-emerald-300 font-semibold">Pimpinan Lembaga</p>
                            <p class="text-base font-bold mt-0.5">Kepala UPTD Puskesmas Cilimus</p>
                            <p class="text-xs text-emerald-100/90 mt-0.5">dr. Hj. Endah Sulistyowati, M.Kes</p>
                        </div>

                        <div class="max-w-sm mx-auto bg-emerald-50 border-2 border-[#2E7D32] rounded-xl p-3.5 text-center">
                            <p class="text-[11px] uppercase tracking-wider text-[#2E7D32] font-bold">Unsur Administrasi</p>
                            <p class="text-sm font-bold text-slate-900">Kepala Sub Bagian Tata Usaha</p>
                            <p class="text-xs text-slate-600">H. Ade Mulyana, S.Kep., Ners</p>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-3">
                            <div class="bg-white border border-slate-200 rounded-xl p-3.5 text-center shadow-xs">
                                <span class="inline-block px-2 py-0.5 rounded-full bg-emerald-50 text-[#2E7D32] text-[10px] font-bold mb-1">Klaster 1</span>
                                <p class="text-xs font-bold text-slate-900">Manajemen</p>
                                <p class="text-[11px] text-slate-600 mt-1">Hj. Nining Sartika, S.ST</p>
                            </div>
                            <div class="bg-white border border-slate-200 rounded-xl p-3.5 text-center shadow-xs">
                                <span class="inline-block px-2 py-0.5 rounded-full bg-emerald-50 text-[#2E7D32] text-[10px] font-bold mb-1">Klaster 2</span>
                                <p class="text-xs font-bold text-slate-900">Ibu &amp; Anak</p>
                                <p class="text-[11px] text-slate-600 mt-1">dr. Ratna Wulandari</p>
                            </div>
                            <div class="bg-white border border-slate-200 rounded-xl p-3.5 text-center shadow-xs">
                                <span class="inline-block px-2 py-0.5 rounded-full bg-emerald-50 text-[#2E7D32] text-[10px] font-bold mb-1">Klaster 3</span>
                                <p class="text-xs font-bold text-slate-900">Dewasa &amp; Lansia</p>
                                <p class="text-[11px] text-slate-600 mt-1">dr. Hendra Wijaya</p>
                            </div>
                            <div class="bg-white border border-slate-200 rounded-xl p-3.5 text-center shadow-xs">
                                <span class="inline-block px-2 py-0.5 rounded-full bg-emerald-50 text-[#2E7D32] text-[10px] font-bold mb-1">Klaster 4</span>
                                <p class="text-xs font-bold text-slate-900">P2P &amp; Kesling</p>
                                <p class="text-[11px] text-slate-600 mt-1">Ns. Asep Saefullah, S.Kep</p>
                            </div>
                            <div class="bg-white border border-rose-200 rounded-xl p-3.5 text-center shadow-xs">
                                <span class="inline-block px-2 py-0.5 rounded-full bg-rose-50 text-rose-700 text-[10px] font-bold mb-1">Lintas Klaster</span>
                                <p class="text-xs font-bold text-slate-900">UGD, Farmasi &amp; Lab</p>
                                <p class="text-[11px] text-slate-600 mt-1">dr. M. Fajar Sidik</p>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </section>

    {{-- ======================================================================= --}}
    {{-- 2. TIM PIMPINAN & PENANGGUNG JAWAB KLASTER                              --}}
    {{-- ======================================================================= --}}
    <section class="bg-slate-50 py-14 border-t border-slate-200/70" x-data="{ filter: 'semua' }">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row md:items-end justify-between gap-4 mb-10">
                <div>
                    <span class="text-xs font-bold uppercase tracking-wider text-[#2E7D32]">Pejabat Struktural &amp; Fungsional</span>
                    <h3 class="text-2xl sm:text-3xl font-bold text-slate-900 mt-1">Tim Pimpinan &amp; Penanggung Jawab Klaster</h3>
                </div>

                {{-- Filter Kategori Jabatan --}}
                <div class="flex flex-wrap items-center gap-2">
                    <button type="button" @click="filter = 'semua'"
                            :class="filter === 'semua' ? 'bg-[#2E7D32] text-white' : 'bg-white text-slate-700 hover:bg-emerald-50 border border-slate-200'"
                            class="px-3.5 py-2 rounded-xl text-xs font-semibold transition-colors">
                        Semua Jabatan
                    </button>
                    <button type="button" @click="filter = 'pimpinan'"
                            :class="filter === 'pimpinan' ? 'bg-[#2E7D32] text-white' : 'bg-white text-slate-700 hover:bg-emerald-50 border border-slate-200'"
                            class="px-3.5 py-2 rounded-xl text-xs font-semibold transition-colors">
                        Pimpinan &amp; TU
                    </button>
                    <button type="button" @click="filter = 'klaster'"
                            :class="filter === 'klaster' ? 'bg-[#2E7D32] text-white' : 'bg-white text-slate-700 hover:bg-emerald-50 border border-slate-200'"
                            class="px-3.5 py-2 rounded-xl text-xs font-semibold transition-colors">
                        Klaster 1 s/d 4
                    </button>
                    <button type="button" @click="filter = 'lintas'"
                            :class="filter === 'lintas' ? 'bg-[#2E7D32] text-white' : 'bg-white text-slate-700 hover:bg-emerald-50 border border-slate-200'"
                            class="px-3.5 py-2 rounded-xl text-xs font-semibold transition-colors">
                        Lintas Klaster
                    </button>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($pimpinanList as $pejabat)
                    <article x-show="filter === 'semua' || filter === '{{ $pejabat['kategori'] }}'"
                             x-transition
                             class="bg-white rounded-2xl p-6 border border-slate-200/90 shadow-sm hover:-translate-y-2 hover:shadow-xl transition-all duration-200 flex flex-col justify-between">
                        <div>
                            <div class="flex items-start justify-between gap-3 mb-4">
                                {{-- Foto / Avatar Lingkaran --}}
                                <div class="w-16 h-16 rounded-full bg-gradient-to-br from-[#003822] to-[#2E7D32] text-white font-bold text-lg flex items-center justify-center ring-4 ring-emerald-50 flex-shrink-0">
                                    {{ $pejabat['inisial'] }}
                                </div>

                                <span class="px-3 py-1 rounded-full text-[11px] font-bold uppercase tracking-wide {{ $pejabat['kategori'] === 'lintas' ? 'bg-rose-50 text-rose-700' : 'bg-[#ECFDF5] text-[#15803D]' }}">
                                    {{ $pejabat['klaster'] }}
                                </span>
                            </div>

                            <h4 class="text-lg font-bold text-slate-900 leading-snug">
                                {{ $pejabat['nama'] }}
                            </h4>
                            <p class="text-sm font-semibold text-[#2E7D32] mt-0.5">
                                {{ $pejabat['jabatan'] }}
                            </p>

                            <div class="mt-3 pt-3 border-t border-slate-100 space-y-1 text-xs text-slate-500">
                                <p><strong class="text-slate-700">NIP:</strong> {{ $pejabat['nip'] }}</p>
                                <p><strong class="text-slate-700">Gol/Pangkat:</strong> {{ $pejabat['golongan'] }}</p>
                            </div>

                            <p class="text-xs sm:text-sm text-slate-600 leading-relaxed mt-3">
                                {{ $pejabat['tugas'] }}
                            </p>
                        </div>
                    </article>
                @endforeach
            </div>
        </div>
    </section>
</x-app-layout>
