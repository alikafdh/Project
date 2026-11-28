@php
    $misiList = is_string($profil->misi)
        ? (json_decode($profil->misi, true) ?? [])
        : (is_array($profil->misi) ? $profil->misi : []);

    $tataNilai = [
        [
            'huruf' => 'C',
            'nama' => 'Cepat',
            'sub' => 'Sigap & Tanggap',
            'deskripsi' => 'Bergerak tanggap dan responsif dalam menangani setiap kebutuhan pasien serta kegawatdaruratan medis 24 jam dengan alur pelayanan efisien.',
        ],
        [
            'huruf' => 'I',
            'nama' => 'Inovatif',
            'sub' => 'Kreatif & Adaptif',
            'deskripsi' => 'Terus mengembangkan metode pelayanan kesehatan primer, digitalisasi layanan, dan edukasi pemberdayaan masyarakat kecamatan.',
        ],
        [
            'huruf' => 'L',
            'nama' => 'Loyal',
            'sub' => 'Pengabdian Tulus',
            'deskripsi' => 'Menjunjung tinggi sumpah profesi kesehatan, dedikasi terhadap institusi pemerintah daerah, serta kesetiaan melayani seluruh lapisan warga.',
        ],
        [
            'huruf' => 'I',
            'nama' => 'Integritas',
            'sub' => 'Jujur & Transparan',
            'deskripsi' => 'Bertindak selaras antara ucapan dan perbuatan, menolak segala bentuk gratifikasi, dan menjaga kerahasiaan data rekam medis pasien.',
        ],
        [
            'huruf' => 'M',
            'nama' => 'Mutu',
            'sub' => 'Standar Terbaik',
            'deskripsi' => 'Berpegang teguh pada SOP klinis Kemenkes RI, sterilitas instrumen medis, keselamatan pasien, dan evaluasi mutu layanan berkala.',
        ],
        [
            'huruf' => 'U',
            'nama' => 'Unggul',
            'sub' => 'Humanis & Profesional',
            'deskripsi' => 'Menampilkan kompetensi medis unggulan dan pelayanan penuh empati, khususnya bagi ibu hamil, balita, lansia, dan penyandang disabilitas.',
        ],
        [
            'huruf' => 'S',
            'nama' => 'Santun & Sinergis',
            'sub' => 'Ramah & Kolaboratif',
            'deskripsi' => 'Menerapkan budaya senyum, sapa, salam, sopan, dan santun serta membangun sinergi lintas sektor bersama kader desa dan perangkat kecamatan.',
        ],
    ];
@endphp

<x-app-layout>
    <x-slot name="title">Visi, Misi &amp; Tata Nilai</x-slot>

    <x-public.profile-tabs
        active="visi-misi"
        title="Visi, Misi &amp; Tata Nilai"
        subtitle="Landasan filosofis, komitmen pelayanan prima, dan budaya kerja aparatur UPTD Puskesmas Cilimus dalam mewujudkan masyarakat sehat dan mandiri."
        breadcrumb="Visi, Misi &amp; Nilai"
    />

    {{-- ======================================================================= --}}
    {{-- 1. VISI PUSKESMAS                                                       --}}
    {{-- ======================================================================= --}}
    <section class="py-14 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-emerald-50 border border-emerald-200 text-emerald-950 p-8 sm:p-10 rounded-2xl shadow-xs relative overflow-hidden">
            <div class="absolute right-6 top-4 text-emerald-200/60 pointer-events-none">
                <span class="material-symbols-outlined text-[110px]">verified</span>
            </div>

            <div class="relative z-10 max-w-4xl mx-auto text-center space-y-5">
                <span class="inline-flex items-center gap-1.5 px-3.5 py-1 rounded-full bg-white border border-emerald-200 text-[#2E7D32] text-xs font-bold uppercase tracking-wider">
                    <span class="material-symbols-outlined text-[16px]">visibility</span>
                    <span>Visi UPTD Puskesmas Cilimus</span>
                </span>

                <blockquote class="text-xl sm:text-2xl lg:text-3xl font-bold leading-snug text-emerald-950">
                    “{{ $profil->visi }}”
                </blockquote>

                <div class="w-20 h-1 bg-[#2E7D32] mx-auto rounded-full"></div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 pt-2 text-left">
                    <div class="bg-white/80 backdrop-blur-xs rounded-xl p-4 border border-emerald-200/70 flex items-start gap-3">
                        <span class="material-symbols-outlined text-[#2E7D32] text-[22px] mt-0.5">account_balance</span>
                        <div>
                            <p class="text-xs font-bold uppercase tracking-wider text-[#2E7D32]">Selaras RPJMD Daerah</p>
                            <p class="text-xs sm:text-sm text-emerald-900/80 mt-0.5">Mendukung pencapaian pilar kesehatan Pemerintah Kabupaten Kuningan.</p>
                        </div>
                    </div>
                    <div class="bg-white/80 backdrop-blur-xs rounded-xl p-4 border border-emerald-200/70 flex items-start gap-3">
                        <span class="material-symbols-outlined text-[#2E7D32] text-[22px] mt-0.5">hub</span>
                        <div>
                            <p class="text-xs font-bold uppercase tracking-wider text-[#2E7D32]">Transformasi Kemenkes RI</p>
                            <p class="text-xs sm:text-sm text-emerald-900/80 mt-0.5">Mengimplementasikan Integrasi Layanan Primer (ILP) berbasis siklus hidup.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- ======================================================================= --}}
    {{-- 2. MISI PEMBANGUNAN KESEHATAN (NUMBERED LIST HORIZONTAL 01 - 06)        --}}
    {{-- ======================================================================= --}}
    <section class="pb-14 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-4 mb-8">
            <div>
                <span class="text-xs font-bold uppercase tracking-wider text-[#2E7D32]">Arah Kebijakan Pelayanan</span>
                <h3 class="text-2xl sm:text-3xl font-bold text-slate-900 mt-1">Misi Pembangunan Kesehatan</h3>
            </div>
            <p class="text-sm text-slate-600 max-w-md">
                Langkah strategis terpadu dalam mengeksekusi visi pelayanan kesehatan yang humanis, preventif, dan bermutu tinggi.
            </p>
        </div>

        <div class="space-y-4">
            @forelse($misiList as $index => $misi)
                @php
                    $nomor = str_pad((string) ($index + 1), 2, '0', STR_PAD_LEFT);
                @endphp
                <div class="bg-white rounded-2xl p-5 sm:p-6 border border-slate-200/90 shadow-xs hover:border-[#2E7D32]/50 hover:shadow-sm transition-all flex flex-col sm:flex-row items-start sm:items-center gap-4 sm:gap-6">
                    <div class="w-12 h-12 rounded-full bg-[#2E7D32] text-white font-bold flex items-center justify-center flex-shrink-0 text-base shadow-xs">
                        {{ $nomor }}
                    </div>
                    <div class="flex-1">
                        <p class="text-sm sm:text-base font-medium text-slate-800 leading-relaxed">
                            {{ $misi }}
                        </p>
                    </div>
                    <span class="hidden md:inline-flex items-center gap-1 px-3 py-1 rounded-full bg-[#ECFDF5] text-[#15803D] text-xs font-semibold flex-shrink-0">
                        <span class="material-symbols-outlined text-[14px]">check_circle</span>
                        <span>Misi {{ $nomor }}</span>
                    </span>
                </div>
            @empty
                <div class="bg-white rounded-2xl p-8 text-center border border-slate-200 text-slate-500 text-sm">
                    Data misi puskesmas belum tersedia.
                </div>
            @endforelse
        </div>
    </section>

    {{-- ======================================================================= --}}
    {{-- 3. TATA NILAI "C-I-L-I-M-U-S" (7 KARTU AKRONIM HORIZONTAL)              --}}
    {{-- ======================================================================= --}}
    <section class="bg-slate-50 py-14 border-t border-slate-200/70">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-2xl mx-auto mb-10 space-y-2">
                <span class="text-xs font-bold uppercase tracking-wider text-[#2E7D32]">Budaya Kerja &amp; Etos Pelayanan</span>
                <h3 class="text-2xl sm:text-3xl font-bold text-slate-900">Tata Nilai “C-I-L-I-M-U-S”</h3>
                <p class="text-sm text-slate-600">
                    Akronim identitas lokal Kecamatan Cilimus yang menjadi prinsip moral seluruh tenaga medis, paramedis, dan staf administrasi.
                </p>
            </div>

            <div class="space-y-4">
                @foreach($tataNilai as $item)
                    <div class="bg-white rounded-2xl p-5 sm:p-6 border border-slate-200/90 shadow-xs hover:shadow-md hover:border-[#2E7D32]/40 transition-all flex items-center gap-5 sm:gap-7">
                        {{-- Huruf Besar di Kiri --}}
                        <div class="w-16 h-16 sm:w-20 sm:h-20 rounded-2xl bg-[#E8F5E9] border border-[#2E7D32]/20 text-[#2E7D32] font-extrabold text-3xl sm:text-4xl flex items-center justify-center flex-shrink-0">
                            {{ $item['huruf'] }}
                        </div>

                        {{-- Uraian Definisi di Kanan --}}
                        <div class="flex-1 min-w-0">
                            <div class="flex flex-wrap items-center gap-2 mb-1">
                                <h4 class="text-lg sm:text-xl font-bold text-slate-900">{{ $item['nama'] }}</h4>
                                <span class="px-2.5 py-0.5 rounded-full bg-emerald-50 text-[#2E7D32] text-xs font-semibold">
                                    {{ $item['sub'] }}
                                </span>
                            </div>
                            <p class="text-sm text-slate-600 leading-relaxed">
                                {{ $item['deskripsi'] }}
                            </p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
</x-app-layout>
