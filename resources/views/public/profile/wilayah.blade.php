@php
    $desaBinaan = [
        ['nama' => 'Desa Cilimus', 'penduduk' => '6.840', 'posyandu' => 6, 'posbindu' => 2, 'bidan' => 'Bd. Siti Nurhaliza, A.Md.Keb', 'status' => 'Siaga Aktif'],
        ['nama' => 'Desa Bandorasa Wetan', 'penduduk' => '4.920', 'posyandu' => 5, 'posbindu' => 1, 'bidan' => 'Bd. Rina Marlina, A.Md.Keb', 'status' => 'Siaga Aktif'],
        ['nama' => 'Desa Bandorasa Kulon', 'penduduk' => '4.310', 'posyandu' => 4, 'posbindu' => 1, 'bidan' => 'Bd. Dewi Anggraini, A.Md.Keb', 'status' => 'Siaga Aktif'],
        ['nama' => 'Desa Bojong', 'penduduk' => '5.180', 'posyandu' => 5, 'posbindu' => 2, 'bidan' => 'Bd. Yanti Susanti, S.Tr.Keb', 'status' => 'Siaga Aktif'],
        ['nama' => 'Desa Linggarjati', 'penduduk' => '4.460', 'posyandu' => 4, 'posbindu' => 1, 'bidan' => 'Bd. Nani Suryani, A.Md.Keb', 'status' => 'Siaga Aktif'],
        ['nama' => 'Desa Linggamekar', 'penduduk' => '3.750', 'posyandu' => 3, 'posbindu' => 1, 'bidan' => 'Bd. Fitriani, A.Md.Keb', 'status' => 'Siaga Aktif'],
        ['nama' => 'Desa Setianagara', 'penduduk' => '3.620', 'posyandu' => 3, 'posbindu' => 1, 'bidan' => 'Bd. Lilis Kurnia, A.Md.Keb', 'status' => 'Siaga Aktif'],
        ['nama' => 'Desa Caracas', 'penduduk' => '4.890', 'posyandu' => 4, 'posbindu' => 1, 'bidan' => 'Bd. Eka Lestari, S.Tr.Keb', 'status' => 'Siaga Aktif'],
        ['nama' => 'Desa Sampora', 'penduduk' => '4.210', 'posyandu' => 4, 'posbindu' => 1, 'bidan' => 'Bd. Tuti Alawiyah, A.Md.Keb', 'status' => 'Siaga Aktif'],
        ['nama' => 'Desa Kaliaren', 'penduduk' => '3.480', 'posyandu' => 3, 'posbindu' => 1, 'bidan' => 'Bd. Maya Puspita, A.Md.Keb', 'status' => 'Siaga Aktif'],
        ['nama' => 'Desa Cibeureum', 'penduduk' => '3.590', 'posyandu' => 4, 'posbindu' => 1, 'bidan' => 'Bd. Irma Rahmawati, A.Md.Keb', 'status' => 'Siaga Aktif'],
        ['nama' => 'Desa Pakembangan', 'penduduk' => '3.150', 'posyandu' => 3, 'posbindu' => 1, 'bidan' => 'Bd. Wulan Sari, A.Md.Keb', 'status' => 'Siaga Aktif'],
    ];
@endphp

<x-app-layout>
    <x-slot name="title">Wilayah Kerja</x-slot>

    <x-public.profile-tabs
        active="wilayah"
        title="Wilayah Kerja &amp; Demografi Sasaran"
        subtitle="Cakupan geografis, distribusi penduduk sasaran, jaringan posyandu aktif, dan 12 desa binaan UPTD Puskesmas Cilimus."
        breadcrumb="Wilayah Kerja"
    />

    {{-- ======================================================================= --}}
    {{-- 1. STATISTIK DEMOGRAFI & DESKRIPSI WILAYAH KERJA                        --}}
    {{-- ======================================================================= --}}
    <section class="py-14 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            <div class="bg-white rounded-2xl p-6 border border-slate-200/90 shadow-xs">
                <div class="w-11 h-11 rounded-xl bg-emerald-50 text-[#2E7D32] flex items-center justify-center mb-3">
                    <span class="material-symbols-outlined text-[24px]">groups</span>
                </div>
                <p class="text-xs font-bold uppercase tracking-wider text-slate-500">Penduduk Sasaran</p>
                <p class="text-3xl font-extrabold text-slate-900 mt-1">52.400</p>
                <p class="text-xs text-slate-600 mt-1">Jiwa di wilayah kerja Kecamatan Cilimus</p>
            </div>

            <div class="bg-white rounded-2xl p-6 border border-slate-200/90 shadow-xs">
                <div class="w-11 h-11 rounded-xl bg-emerald-50 text-[#2E7D32] flex items-center justify-center mb-3">
                    <span class="material-symbols-outlined text-[24px]">holiday_village</span>
                </div>
                <p class="text-xs font-bold uppercase tracking-wider text-slate-500">Desa Binaan</p>
                <p class="text-3xl font-extrabold text-slate-900 mt-1">12 Desa</p>
                <p class="text-xs text-slate-600 mt-1">Terintegrasi jejaring Pustu &amp; Poskesdes</p>
            </div>

            <div class="bg-white rounded-2xl p-6 border border-slate-200/90 shadow-xs">
                <div class="w-11 h-11 rounded-xl bg-emerald-50 text-[#2E7D32] flex items-center justify-center mb-3">
                    <span class="material-symbols-outlined text-[24px]">child_care</span>
                </div>
                <p class="text-xs font-bold uppercase tracking-wider text-slate-500">Posyandu Aktif</p>
                <p class="text-3xl font-extrabold text-slate-900 mt-1">48 Unit</p>
                <p class="text-xs text-slate-600 mt-1">Posyandu Balita, Remaja &amp; Terintegrasi ILP</p>
            </div>

            <div class="bg-white rounded-2xl p-6 border border-slate-200/90 shadow-xs">
                <div class="w-11 h-11 rounded-xl bg-emerald-50 text-[#2E7D32] flex items-center justify-center mb-3">
                    <span class="material-symbols-outlined text-[24px]">straighten</span>
                </div>
                <p class="text-xs font-bold uppercase tracking-wider text-slate-500">Luas Wilayah</p>
                <p class="text-3xl font-extrabold text-slate-900 mt-1">24,5 km²</p>
                <p class="text-xs text-slate-600 mt-1">Kawasan kaki Gunung Ciremai, Kuningan</p>
            </div>
        </div>

        @if(! empty($profil->wilayah_kerja))
            <div class="bg-emerald-50 border border-emerald-200 rounded-2xl p-6 flex items-start gap-4">
                <div class="w-10 h-10 rounded-xl bg-[#2E7D32] text-white flex items-center justify-center flex-shrink-0">
                    <span class="material-symbols-outlined text-[22px]">public</span>
                </div>
                <div>
                    <h3 class="text-base font-bold text-emerald-950">Keterangan Cakupan Wilayah Kerja</h3>
                    <p class="text-sm text-emerald-900/90 mt-1 leading-relaxed">{{ $profil->wilayah_kerja }}</p>
                </div>
            </div>
        @endif
    </section>

    {{-- ======================================================================= --}}
    {{-- 2. TABEL DESA BINAAN KECAMATAN CILIMUS                                  --}}
    {{-- ======================================================================= --}}
    <section class="bg-slate-50 py-14 border-t border-slate-200/70">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="mb-6">
                <span class="text-xs font-bold uppercase tracking-wider text-[#2E7D32]">Jejaring Pelayanan Primer</span>
                <h3 class="text-2xl font-bold text-slate-900 mt-1">Daftar 12 Desa Binaan Kecamatan Cilimus</h3>
            </div>

            <div class="bg-white rounded-2xl border border-slate-200 shadow-xs overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-slate-200 text-sm">
                        <thead class="bg-slate-50">
                            <tr>
                                <th scope="col" class="px-6 py-3.5 text-left text-xs font-bold uppercase tracking-wider text-slate-600">No</th>
                                <th scope="col" class="px-6 py-3.5 text-left text-xs font-bold uppercase tracking-wider text-slate-600">Nama Desa Binaan</th>
                                <th scope="col" class="px-6 py-3.5 text-left text-xs font-bold uppercase tracking-wider text-slate-600">Est. Penduduk</th>
                                <th scope="col" class="px-6 py-3.5 text-center text-xs font-bold uppercase tracking-wider text-slate-600">Posyandu Aktif</th>
                                <th scope="col" class="px-6 py-3.5 text-center text-xs font-bold uppercase tracking-wider text-slate-600">Posbindu PTM</th>
                                <th scope="col" class="px-6 py-3.5 text-left text-xs font-bold uppercase tracking-wider text-slate-600">Bidan Pembina Desa</th>
                                <th scope="col" class="px-6 py-3.5 text-left text-xs font-bold uppercase tracking-wider text-slate-600">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 bg-white">
                            @foreach($desaBinaan as $index => $desa)
                                <tr class="hover:bg-emerald-50/40 transition-colors">
                                    <td class="px-6 py-4 text-slate-500 font-medium">{{ $index + 1 }}</td>
                                    <td class="px-6 py-4 font-bold text-slate-900">{{ $desa['nama'] }}</td>
                                    <td class="px-6 py-4 text-slate-700">{{ $desa['penduduk'] }} jiwa</td>
                                    <td class="px-6 py-4 text-center font-semibold text-[#2E7D32]">{{ $desa['posyandu'] }}</td>
                                    <td class="px-6 py-4 text-center font-semibold text-slate-700">{{ $desa['posbindu'] }}</td>
                                    <td class="px-6 py-4 text-slate-700">{{ $desa['bidan'] }}</td>
                                    <td class="px-6 py-4">
                                        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full bg-[#ECFDF5] text-[#15803D] text-xs font-semibold">
                                            <span class="w-1.5 h-1.5 rounded-full bg-[#2E7D32]"></span>
                                            <span>{{ $desa['status'] }}</span>
                                        </span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
</x-app-layout>
